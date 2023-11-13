<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';
include_once '../middlewares/LoggerPOST.php';
include_once '../middlewares/LoggerGET.php';
include_once '../middlewares/Authentication.php';
include_once '../middlewares/LoggerPUT.php';
include_once '../middlewares/LoggerDELETE.php';

// Instantiate App
$app = AppFactory::create();

// Set base path
$app->setBasePath('/app');

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

include_once '../controllers/empleadoController.php';
include_once '../controllers/productoController.php';
include_once '../controllers/pedidoController.php';
include_once '../controllers/mesaController.php';



// Routes
$app->get('[/]', function (Request $request, Response $response) {
    $result = ['message' => 'Listando, aguarde...'];
    $response->getBody()->write(json_encode($result)); 
    return $response->withHeader('Content-Type', 'application/json');
})->add(new LoggerMiddlewareGET());

$app->post('[/]', function (Request $request, Response $response) {
    $action = $_POST['action'];
    switch ($action){
        case 'AltaEmpleado':
            $result = ['message' => 'Exito al dar de alta al empleado!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'AltaProductos':
            $result = ['message' => 'Exito al dar de alta al producto!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'AltaMesas':
            $result = ['message' => 'Exito al dar de alta la mesa!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'AltaPedidos':
            $result = ['message' => 'Exito al dar de alta el pedido!'];
            $response->getBody()->write(json_encode($result));
            break;
        default:
            $result = ['message' => 'Error, no se reconoce la accion ingresada...'];
            $response->getBody()->write(json_encode($result));
            break;
    }
    return $response->withHeader('Content-Type', 'application/json');
})->add(new AuthenticationMiddleware())->add(new LoggerMiddlewarePOST());

$app->put('[/]', function (Request $request, Response $response) {
    $result = ['message' => 'Exito al modificar el empleado!'];
    $response->getBody()->write(json_encode($result));
    return $response->withHeader('Content-Type', 'application/json');
})->add(new AuthenticationMiddleware())->add(new LoggerMiddlewarePUT());

$app->delete('[/]', function (Request $request, Response $response) {
    $result = ['message' => 'Exito al borrar el empleado!'];
    $response->getBody()->write(json_encode($result));
    return $response->withHeader('Content-Type', 'application/json');
})->add(new AuthenticationMiddleware())->add(new LoggerMiddlewareDelete());

$app->run();
