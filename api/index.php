<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once "config/Database.php";
require_once "models/Cliente.php";
require_once "models/Pedido.php";
require_once "controllers/ClienteController.php";
require_once "controllers/PedidoController.php";

$database = new Database();
$db = $database->getConnection();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// Roteamento básico
$resource = $uri[2] ?? null;
$id = $uri[3] ?? null;

switch($resource) {
    case 'clientes':
        $controller = new ClienteController($db);
        $method = $_SERVER['REQUEST_METHOD'];
        
        switch($method) {
            case 'GET':
                if($id) {
                    $response = $controller->getById($id);
                } else {
                    $response = $controller->getAll();
                }
                break;
                
            case 'POST':
                $data = json_decode(file_get_contents("php://input"), true);
                $response = $controller->create($data);
                break;
                
            case 'PUT':
                if($id) {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $response = $controller->update($id, $data);
                }
                break;
                
            case 'DELETE':
                if($id) {
                    $response = $controller->delete($id);
                }
                break;
        }
        break;
    
    case 'pedidos':
        $controller = new PedidoController($db);
        $method = $_SERVER['REQUEST_METHOD'];
        
        switch($method) {
            case 'GET':
                if($id) {
                    $response = $controller->getById($id);
                } else {
                    $response = $controller->getAll();
                }
                break;
                
            case 'POST':
                $data = json_decode(file_get_contents("php://input"), true);
                $response = $controller->create($data);
                break;
                
            case 'PUT':
                if($id) {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $response = $controller->update($id, $data);
                }
                break;
                
            case 'DELETE':
                if($id) {
                    $response = $controller->delete($id);
                }
                break;
        }
        break;
}

// Retorna a resposta em JSON
echo json_encode($response ?? ["error" => "Endpoint não encontrado"], JSON_UNESCAPED_UNICODE); 