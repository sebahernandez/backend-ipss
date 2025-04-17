<?php
// CORS y headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json');

// Activar mensajes de error para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir dependencias
require_once './controllers/ServicioController.php';
require_once './config/database.php';
require_once './config/fake_data.php';

// Determinar la ruta solicitada
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/ipss/backend/';

// Verificar si la URI contiene la ruta base
if (strpos($request_uri, $base_path) === false) {
    http_response_code(404);
    echo json_encode(["mensaje" => "Ruta no válida"]);
    exit;
}

// Extraer la parte de la ruta después de /ipss/backend/
$path = substr($request_uri, strpos($request_uri, $base_path) + strlen($base_path));
$path = strtok($path, '?'); // Eliminar cualquier parámetro de consulta
$path = trim($path, '/');

// Detectar método HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Verificar si se solicitaron datos falsos o base de datos alternativa
$useFakeData = isset($_GET['fake']) && $_GET['fake'] === 'true';
$useAlternativeDb = isset($_GET['db']) && $_GET['db'] === 'alternative';

// Conexión a la base de datos
try {
    $database = new Database($useAlternativeDb);
    $db = $database->getConnection();
    $servicioController = new ServicioController($db, $useFakeData);

    // Enrutar según la ruta y el método
    if ($path === 'servicios') {
        switch ($method) {
            case 'GET':
                $servicioController->obtenerServicios();
                break;
            default:
                http_response_code(405); // Método no permitido
                echo json_encode(["mensaje" => "Método $method no permitido."]);
                break;
        }
    } elseif ($path === '') {
        // Ruta principal
        echo json_encode([
            "mensaje" => "API Rest para servicios",
            "endpoints" => [
                "/servicios" => "GET - Obtener todos los servicios desde la base de datos real",
                "/servicios?fake=true" => "GET - Obtener servicios desde datos hardcoded (sin conexión a base de datos)"
            ],
            "instrucciones" => "Usa el parámetro 'fake=true' para alternar entre la base de datos real y los datos hardcoded"
        ]);
    } else {
        // Ruta no encontrada
        http_response_code(404);
        echo json_encode([
            "mensaje" => "Ruta no encontrada. Utiliza /servicios para acceder a los servicios."
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "mensaje" => "Error interno del servidor",
        "error" => $e->getMessage()
    ]);
}
