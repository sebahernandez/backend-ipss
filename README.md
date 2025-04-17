# API de Servicios IPSS - Documentación

## Descripción General

Esta API RESTful proporciona acceso a los servicios de consultoría. Está construida con PHP y MySQL, utilizando una arquitectura MVC simple. La API soporta múltiples idiomas (español e inglés) para los nombres y descripciones de los servicios.

## Configuración de Conexión a Base de Datos

La API utiliza MySQL como sistema de gestión de base de datos. Las configuraciones se encuentran en el archivo `config/database.php`.

### Configuración por Defecto (MAMP)

```php
$host = "localhost";
$db_name = "consultoria";
$username = "root";
$password = "root";
$port = "8889"; // Puerto de MAMP
```

### Base de Datos Alternativa

La API soporta el uso de una base de datos alternativa utilizando el parámetro `db=alternative` en las solicitudes:

```
/servicios?db=alternative
```

Esto cambiará la conexión a la base de datos `consultoria_alternativa`.

## Estructura de la Base de Datos

La tabla principal usada por la API es `servicios` con la siguiente estructura:

| Campo          | Tipo         | Descripción                         |
| -------------- | ------------ | ----------------------------------- |
| id             | INT          | Identificador único del servicio    |
| nombre_es      | VARCHAR(255) | Nombre del servicio en español      |
| nombre_en      | VARCHAR(255) | Nombre del servicio en inglés       |
| descripcion_es | TEXT         | Descripción del servicio en español |
| descripcion_en | TEXT         | Descripción del servicio en inglés  |

## Autenticación

La API utiliza autenticación mediante token Bearer. Para acceder a los endpoints protegidos, se debe incluir un token de autorización válido.

### Token de Autorización

El token válido actual es: `ipss2025`

### Métodos para Enviar el Token

Existen varias formas de proporcionar el token de autorización:

1. **Mediante Header de Autorización (Recomendado)**:

   ```
   Authorization: Bearer ipss2025
   ```

2. **Como parámetro en la URL**:

   ```
   /servicios?token=ipss2025
   ```

3. **Como parámetro POST**:
   ```
   token=ipss2025
   ```

## Endpoints Disponibles

### Obtener Todos los Servicios

```
GET /ipss/backend/servicios
```

**Headers Requeridos:**

- `Authorization: Bearer ipss2025`

**Respuesta Exitosa (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "nombre": {
        "es": "Desarrollo Web",
        "en": "Web Development"
      },
      "descripcion": {
        "es": "Creación de sitios web profesionales con tecnologías modernas",
        "en": "Creation of professional websites with modern technologies"
      }
    }
    // Más servicios...
  ]
}
```

## Parámetros de Consulta

### Datos Falsos (Modo de Desarrollo)

Para obtener datos ficticios sin necesidad de conectar a la base de datos, use:

```
GET /ipss/backend/servicios?fake=true
```

Esto devuelve un conjunto de datos predefinidos desde el archivo `config/fake_data.php`.

### Base de Datos Alternativa

Para usar una base de datos alternativa:

```
GET /ipss/backend/servicios?db=alternative
```

## Manejo de Errores

La API devuelve los siguientes códigos de estado HTTP:

| Código | Descripción                | Posible Causa                                     |
| ------ | -------------------------- | ------------------------------------------------- |
| 200    | OK                         | La solicitud se completó exitosamente             |
| 401    | No Autorizado              | Token inválido o ausente                          |
| 404    | No Encontrado              | Ruta no válida                                    |
| 405    | Método No Permitido        | Método HTTP no soportado para el endpoint         |
| 500    | Error Interno del Servidor | Error de conexión a la base de datos u otro error |

### Ejemplos de Respuestas de Error

**Error de Autenticación (401):**

```json
{
  "mensaje": "Acceso no autorizado. No se proporcionó un token de autorización.",
  "error": "missing_token",
  "ayuda": "Intenta agregar ?token=ipss2025 a la URL para pruebas o enviar el token en el encabezado Authorization"
}
```

**Ruta No Encontrada (404):**

```json
{
  "mensaje": "Ruta no encontrada. Utiliza /servicios para acceder a los servicios."
}
```

## Uso Mediante cURL

### Obtener Servicios con Bearer Token

```bash
curl -X GET "http://localhost:8888/ipss/backend/servicios" \
  -H "Authorization: Bearer ipss2025"
```

### Obtener Servicios con Datos Ficticios

```bash
curl -X GET "http://localhost:8888/ipss/backend/servicios?fake=true" \
  -H "Authorization: Bearer ipss2025"
```

### Obtener Servicios con Base de Datos Alternativa

```bash
curl -X GET "http://localhost:8888/ipss/backend/servicios?db=alternative" \
  -H "Authorization: Bearer ipss2025"
```

## Modo de Desarrollo y Depuración

Durante el desarrollo, es posible que encuentre útil:

1. Los mensajes de error detallados están habilitados en la configuración.
2. En el archivo `servicios.php` existe una variable `$bypass_auth` que puede configurarse como `true` para desactivar temporalmente la autenticación durante el desarrollo.

## Notas para Despliegue en Producción

Antes de desplegar en producción, asegúrese de:

1. Cambiar el token de autorización `ipss2025` por uno más seguro.
2. Desactivar los mensajes detallados de error (`display_errors = Off`).
3. Eliminar cualquier bypass de autenticación.
4. Configurar los parámetros de conexión a la base de datos de producción.
5. Considerar implementar HTTPS para proteger los datos en tránsito.
