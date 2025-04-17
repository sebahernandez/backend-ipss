<?php
// CORS y headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json');

// Incluir dependencias
require_once './controllers/ServicioController.php';
require_once './config/database.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$servicioController = new ServicioController($db);

// Detectar método HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $servicioController->obtenerServicios();
        break;

    default:
        http_response_code(405); // Método no permitido
        echo json_encode(["mensaje" => "Método $method no permitido."]);
        break;
}
