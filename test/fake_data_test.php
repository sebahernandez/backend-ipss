<?php
/**
 * Prueba de conexión a datos falsos (fake data)
 * Este test verifica que podamos recuperar los datos falsos desde FakeData
 */

// Incluir archivos necesarios
require_once '../config/database.php';
require_once '../models/Servicio.php';
require_once '../config/fake_data.php'; // Necesario para acceder directamente a los datos falsos

echo "=================================================\n";
echo "      PRUEBA DE CONEXIÓN A DATOS FALSOS          \n";
echo "=================================================\n\n";

try {
    // Crear una conexión de base de datos (no se usará, pero es necesaria para el constructor)
    echo "Creando instancia de Database (no se utilizará)...\n";
    $database = new Database();
    $db = $database->getConnection();
    
    // Crear instancia del modelo con useFakeData = true
    echo "Intentando recuperar datos falsos...\n";
    $servicio = new Servicio($db, true); // true = usar datos falsos
    $servicios = $servicio->obtenerServicios();
    
    // Verificar si se obtuvieron servicios falsos
    if (is_array($servicios)) {
        $count = count($servicios);
        echo "✅ Recuperación exitosa. Se encontraron $count servicios falsos.\n\n";
        
        // Comparar con los datos originales para verificar integridad
        $datosOriginales = FakeData::getServicios();
        echo "Verificando integridad de los datos falsos...\n";
        
        if (count($servicios) === count($datosOriginales)) {
            echo "✅ Número correcto de servicios falsos.\n";
            
            // Verificar que los IDs coincidan
            $idsCoincidenTodos = true;
            for ($i = 0; $i < count($servicios); $i++) {
                if ($servicios[$i]['id'] !== $datosOriginales[$i]['id']) {
                    $idsCoincidenTodos = false;
                    break;
                }
            }
            
            if ($idsCoincidenTodos) {
                echo "✅ Los IDs de los servicios coinciden correctamente.\n";
            } else {
                echo "❌ Hay discrepancias en los IDs de los servicios.\n";
            }
        } else {
            echo "❌ El número de servicios falsos no coincide con el esperado.\n";
            echo "   Esperados: " . count($datosOriginales) . ", Obtenidos: " . count($servicios) . "\n";
        }
        
        // Mostrar muestra de los datos falsos
        if ($count > 0) {
            echo "\nMuestra del primer servicio falso recuperado:\n";
            echo "ID: " . $servicios[0]['id'] . "\n";
            echo "Nombre (ES): " . $servicios[0]['nombre']['es'] . "\n";
            echo "Nombre (EN): " . $servicios[0]['nombre']['en'] . "\n";
            echo "Descripción (ES): " . $servicios[0]['descripcion']['es'] . "\n";
            echo "Descripción (EN): " . $servicios[0]['descripcion']['en'] . "\n";
        }
    } else {
        echo "❌ Error al recuperar servicios falsos: el resultado no es un array.\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=================================================\n";
echo "                 FIN DE LA PRUEBA                 \n";
echo "=================================================\n";