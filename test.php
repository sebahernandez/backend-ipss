<?php
require_once './config/database.php';

$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    echo "<h2 style='color: green;'>✅ Conexión exitosa a la base de datos.</h2>";
} else {
    echo "<h2 style='color: red;'>❌ Error al conectar con la base de datos.</h2>";
}
