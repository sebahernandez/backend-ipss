<?php
/**
 * Prueba de conexión a la base de datos real
 * Este test verifica que podamos conectarnos a la base de datos y recuperar servicios
 */

// Incluir archivos necesarios
require_once '../config/database.php';
require_once '../models/Servicio.php';

echo "=================================================\n";
echo "    PRUEBA DE CONEXIÓN A LA BASE DE DATOS REAL    \n";
echo "=================================================\n\n";

try {
    // Crear instancia de la base de datos
    echo "Intentando conectar a la base de datos...\n";
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db) {
        echo "✅ Conexión exitosa a la base de datos.\n\n";
        
        // Intentar recuperar servicios
        echo "Intentando recuperar servicios desde la base de datos...\n";
        $servicio = new Servicio($db, false); // false = usar base de datos real
        $servicios = $servicio->obtenerServicios();
        
        // Verificar si se obtuvieron servicios
        if (is_array($servicios)) {
            $count = count($servicios);
            echo "✅ Recuperación exitosa. Se encontraron $count servicios.\n\n";
            
            // Mostrar muestra de los datos
            if ($count > 0) {
                echo "Muestra del primer servicio recuperado:\n";
                echo "ID: " . $servicios[0]['id'] . "\n";
                echo "Nombre (ES): " . $servicios[0]['nombre']['es'] . "\n";
                echo "Nombre (EN): " . $servicios[0]['nombre']['en'] . "\n";
                echo "Descripción (ES): " . $servicios[0]['descripcion']['es'] . "\n";
                echo "Descripción (EN): " . $servicios[0]['descripcion']['en'] . "\n";
            } else {
                echo "⚠️ No hay servicios en la base de datos, pero la consulta fue exitosa.\n";
            }
        } else {
            echo "❌ Error al recuperar servicios: el resultado no es un array.\n";
        }
    } else {
        echo "❌ No se pudo establecer conexión con la base de datos.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=================================================\n";
echo "                 FIN DE LA PRUEBA                 \n";
echo "=================================================\n";