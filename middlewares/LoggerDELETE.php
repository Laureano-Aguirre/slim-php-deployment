<?php


use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

require_once '../validations/validaciones.php';
include_once '../controllers/empleadoController.php';
include_once '../controllers/productoController.php';
include_once '../controllers/pedidoController.php';
include_once '../controllers/mesaController.php';

class LoggerMiddlewareDelete{
    public function __invoke(Request $request, RequestHandler $handler): Response{
        $parametros = $request->getParsedBody();
        $action = $parametros['action'];

        switch ($action){
            case 'BorrarEmpleado':
                if(Validaciones::validarInt($parametros['idEmpleado'])){
                    $empleadoController = new empleadoController();
                    $result = $empleadoController->borrarEmpleado($parametros['idEmpleado']);
                    $response = $handler->handle($request);
                }else{
                    $response = new Response();
                    $result = ['message' => 'Algun parametro no fue introducido en un formato correcto.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            default:
                $response = new Response();
                $result = ['message' => 'Accion desconocida: ' . $action];
                $response->getBody()->write(json_encode($result));
                break;
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
}


?>