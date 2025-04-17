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

// Si es una solicitud OPTIONS (preflight), permitir sin verificar token
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Obtener todos los encabezados para depuración
$all_headers = [];
foreach ($_SERVER as $key => $value) {
    if (strpos($key, 'HTTP_') === 0) {
        $header_name = str_replace('HTTP_', '', $key);
        $header_name = str_replace('_', ' ', $header_name);
        $header_name = ucwords(strtolower($header_name));
        $header_name = str_replace(' ', '-', $header_name);
        $all_headers[$header_name] = $value;
    }
}

// Intentar obtener el token de diferentes fuentes posibles
$token = null;

// 1. De parámetros GET o POST
if (isset($_GET['token'])) {
    $token = $_GET['token'];
} 
else if (isset($_POST['token'])) {
    $token = $_POST['token'];
}
// 2. Del encabezado de autorización estándar
else if (isset($all_headers['Authorization'])) {
    $auth = $all_headers['Authorization'];
    // Si usa el formato Bearer
    if (stripos($auth, 'Bearer ') === 0) {
        $token = substr($auth, 7);
    } else {
        $token = $auth;
    }
}
// 3. Comprobar si hay un encabezado específico de 'Authorization'
else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $auth = $_SERVER['HTTP_AUTHORIZATION'];
    if (stripos($auth, 'Bearer ') === 0) {
        $token = substr($auth, 7);
    } else {
        $token = $auth;
    }
}

// Token de autorización válido
$validToken = 'ipss2025';

// ===== SOLUCIÓN TEMPORAL: HABILITAR BYPASS PARA PRUEBAS =====
// Descomentar esta línea para desactivar temporalmente la autenticación
$bypass_auth = true;
if (isset($bypass_auth) && $bypass_auth === true) {
    $token = $validToken;
    error_log("⚠️ ADVERTENCIA: Autenticación desactivada temporalmente para pruebas");
}

// Verificar si el token es válido
if (!$token) {
    http_response_code(401);
    echo json_encode([
        "mensaje" => "Acceso no autorizado. No se proporcionó un token de autorización.",
        "error" => "missing_token",
        "ayuda" => "Intenta agregar ?token=ipss2025 a la URL para pruebas o enviar el token en el encabezado Authorization",
        "debug_headers" => $all_headers // Solo para depuración
    ]);
    exit;
} else if ($token !== $validToken) {
    http_response_code(401);
    echo json_encode([
        "mensaje" => "Acceso no autorizado. El token proporcionado no es válido.",
        "error" => "invalid_token",
        "token_recibido" => $token // Solo incluir en desarrollo para depuración
    ]);
    exit;
}

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

    // Procesar la solicitud según el método
    switch ($method) {
        case 'GET':
            $servicioController->obtenerServicios();
            break;
        default:
            http_response_code(405); // Método no permitido
            echo json_encode(["mensaje" => "Método $method no permitido."]);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "mensaje" => "Error interno del servidor",
        "error" => $e->getMessage()
    ]);
}