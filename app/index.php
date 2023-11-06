<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';

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
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'ListarEmpleados':
                $empleadoController = new empleadoController();
                $result = $empleadoController->listarEmpleados();
                break;
            case 'ListarProductos':
                $productosController = new productoController();
                $result = $productosController->listarProductos();
                break;
            case 'ListarMesas':
                $mesasController = new mesaController();
                $result = $mesasController->listarMesas();
                break;
            case 'ListarPedidos':
                $pedidosController = new pedidoController();
                $result = $pedidosController->listarPedidos();
                break;
            default:
                $result = ['message' => 'ERROR, accion invalida.'];
                break;           
        }
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }
    else{
        $result = ['message' => 'Parametros incorrectos.'];
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    
});

$app->post('[/]', function (Request $request, Response $response) {
    if(isset($_POST['action'])){
        switch($_POST['action']){
            case 'AltaEmpleados':
                if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['rol'])){
                    $fechaAlta = date('Y-m-d');
                    $empleadoController = new empleadoController();
                    $result = $empleadoController->agregarEmpleado($_POST['nombre'], $_POST['apellido'], $_POST['rol'], $fechaAlta);
                }else{
                    $result = ['message' => 'ERROR, accion invalida en alta empleados index.'];
                }
                break;
            case 'AltaProductos':
                if(isset($_POST['tipo']) && isset($_POST['descripcion']) && isset($_POST['cantidad'])){
                    $productosController = new productoController();
                    $result = $productosController->agregarProducto($_POST['tipo'], $_POST['descripcion'], $_POST['cantidad']);
                }else{
                    $result = ['message' => 'ERROR, accion invalida en alta productos index.'];
                }
                break;
            case 'AltaMesas':
                if(isset($_POST['idCliente']) && isset($_POST['idPedido']) && isset($_POST['idMozo']) && isset($_POST['idEncuesta']) && isset($_POST['estado'])){
                    //$idEncuesta = isset($_POST['idEncuesta']) && !empty($_POST['idEncuesta']) ? $_POST['idEncuesta'] : null ;
                    $mesasController = new mesaController();
                    $result = $mesasController->agregarMesa($_POST['idCliente'], $_POST['idPedido'], $_POST['idMozo'], $_POST['idEncuesta'], $_POST['estado']);
                }else{
                    $result = ['message' => 'ERROR, accion invalida en alta mesas index.'];
                }              
                break;
            case 'AltaPedidos':
                if(isset($_POST['nombreCliente']) && isset($_POST['idEmpleado']) && isset($_POST['productos']) && isset($_POST['estado']) && isset($_POST['tiempoFinalizacion'])){
                    $pedidosController = new pedidoController();
                    $result = $pedidosController->agregarPedido($_POST['nombreCliente'], $_POST['idEmpleado'], $_POST['productos'], $_POST['estado'], $_POST['tiempoFinalizacion']);
                }
                else{
                    $result = ['message' => 'ERROR, accion invalida en alta pedidos index.'];
                }
                break;
            default:
                $result = ['message' => 'ERROR, accion invalida.'];
                break;           
        }
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }
    else{
        $result = ['message' => 'Parametros incorrectos en POST.'];
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
});

$app->run();
