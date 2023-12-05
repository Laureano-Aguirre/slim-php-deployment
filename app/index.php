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
include_once '../middlewares/LoginMiddleware.php';
include_once '../jwt/AutentificadorJWT.php';

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
include_once '../controllers/AuthenticatorController.php';
include_once '../controllers/productoPedidoController.php';


// Routes
$app->get('[/]', function (Request $request, Response $response) {
    $action = $_GET['action'];
    switch($action){
        case 'ListarPendientes':
            $result = ['message' => 'Listando, aguarde...'];
            break;
    }
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
        case 'AltaProductoPedido':
            $result = ['message' => 'Exito al agregar el producto al pedido!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'AltaEmpleadoCSV':
            $result = ['message' => 'Exito al dar de alta al empleado a traves del archivo.csv!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'HacerEncuesta':
            $result = ['message' => 'Muchas gracias por realizar la encuesta!'];
            $response->getBody()->write(json_encode($result));
            break;
        default:
            $result = ['message' => 'Error, no se reconoce la accion ingresada...'];
            $response->getBody()->write(json_encode($result));
            break;
    }
    return $response->withHeader('Content-Type', 'application/json');
})->add(new AuthenticationMiddleware())->add(new LoggerMiddlewarePOST());

$app->group('/auth', function (RouteCollectorProxy $group) {
    $group->post('[/login]', function (Request $request, Response $response) {
        $parametros = $request->getParsedBody();
        $datos = array('usuario' => $parametros['usuario'], 'rol' => $parametros['rol']);
        $token = AutentificadorJWT::CrearToken($datos);
        $payload = array('jwt' => $token);
        $response->getBody()->write(json_encode($payload));
        return $response->withHeader('Content-Type', 'application/json');
    })->add(new LoginMiddleware());
});

$app->put('[/]', function (Request $request, Response $response) {
    $parametros = $request->getParsedBody();
    $action = $parametros['action'];
    switch ($action){
        case 'ModificarEmpleado':
            $result = ['message' => 'Exito al modificar el empleado!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'ModificarProducto':
            $result = ['message' => 'Exito al modificar el producto!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'ModificarMesa':
            $result = ['message' => 'Exito al modificar la mesa!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'ModificarPedido':
            $result = ['message' => 'Exito al modificar el pedido!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'PrepararProductoPedido':
            $result = ['message' => 'Manos a la obra, a preparar el producto!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'TerminarProductoPedido':
            $result = ['message' => 'Rinnnnnng, producto listo para servir!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'EntregarPedido':
            $result = ['message' => 'Aca esta su pedido, que lo disfruten!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'CobrarPedido':
            $result = ['message' => 'Su pago se efectuo con exito!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'CerrarMesa':
            $result = ['message' => 'Mesa cerrada, esperemos que lo hayan disfrutado, vuelvan pronto!'];
            $response->getBody()->write(json_encode($result));
            break;
        default:
            $result = ['message' => 'Error, no se reconoce la accion ingresada...'];
            $response->getBody()->write(json_encode($result));
            break;
    }
    
    return $response->withHeader('Content-Type', 'application/json');
})->add(new AuthenticationMiddleware())->add(new LoggerMiddlewarePUT());

$app->delete('[/]', function (Request $request, Response $response) {    
    $parametros = $request->getParsedBody();
    $action = $parametros['action'];
    switch ($action){
        case 'BorrarEmpleado':
            $result = ['message' => 'Exito al borrar el empleado!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'BorrarProducto':
            $result = ['message' => 'Exito al borrar el producto!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'BorrarMesa':
            $result = ['message' => 'Exito al borrar la mesa!'];
            $response->getBody()->write(json_encode($result));
            break;
        case 'BorrarPedido':
            $result = ['message' => 'Exito al borrar el pedido!'];
            $response->getBody()->write(json_encode($result));
            break;
        default:
            $result = ['message' => 'Error, no se reconoce la accion ingresada...'];
            $response->getBody()->write(json_encode($result));
            break;
    }
    
    return $response->withHeader('Content-Type', 'application/json');
})->add(new AuthenticationMiddleware())->add(new LoggerMiddlewareDelete());

$app->run();
