<?php

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

include_once '../controllers/empleadoController.php';
include_once '../controllers/productoController.php';
include_once '../controllers/pedidoController.php';
include_once '../controllers/mesaController.php';
include_once '../controllers/productoPedidoController.php';
include_once '../controllers/encuestaController.php';
include_once '../controllers/logController.php';

class LoggerMiddlewareGET{
    public function __invoke(Request $request, RequestHandler $handler): Response{
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $retorno = AutentificadorJWT::ObtenerData($token);
        $parametros = $request->getQueryParams();
        $action = $parametros['action'];
        $response = new Response();
        
        switch ($action){
            case 'ListarEmpleados':
                if('socio' == $retorno->rol){
                    $empleadoController = new empleadoController();
                    $result = $empleadoController->listarEmpleados();
                    $logController = new logController();
                    $fechaLog = date('Y-m-d H:i:s');
                    $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                    $response->getBody()->write(json_encode($result));
                }else{
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                } 
            break;
            case 'ListarProductos':
                if('socio' == $retorno->rol || 'mozo' == $retorno->rol){
                    $productosController = new productoController();
                    $result = $productosController->listarProductos();
                    $logController = new logController();
                    $fechaLog = date('Y-m-d H:i:s');
                    $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                    $response->getBody()->write(json_encode($result));
                    //$response = $handler->handle($request);
                }else{
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
            break;
            case 'ListarMesas':
                if('socio' == $retorno->rol || 'mozo' == $retorno->rol){
                    $mesasController = new mesaController();
                    $result = $mesasController->listarMesas();
                    if(!empty($result)){
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response->getBody()->write(json_encode($result));
                    }else{
                        $response = new Response();
                        $result = ['message' => 'ERROR, no existen pedidos disponibles.'];
                        $response->getBody()->write(json_encode($result));
                    }
                    //$response = $handler->handle($request);
                }else{
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
            break;
            case 'ListarPedidos':
                if('socio' == $retorno->rol || 'mozo' == $retorno->rol){
                    $pedidosController = new pedidoController();
                    $result = $pedidosController->listarPedidos();
                    if(!empty($result)){
                        $response->getBody()->write(json_encode($result));
                    }else{
                        $response = new Response();
                        $result = ['message' => 'ERROR, no existen pedidos disponibles.'];
                        $response->getBody()->write(json_encode($result));
                    }
                    //$response = $handler->handle($request);
                }else{
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
            break;
            case 'ListarPendientes':
                if('cocinero' == $retorno->rol || 'mozo' == $retorno->rol || 'cervecero' == $retorno->rol || 'bartender' == $retorno->rol){
                    $productoPedidoController = new productoPedidoController();
                    $result = $productoPedidoController->consultarEstadoProductoPedido($parametros['idEmpleado'], $parametros['estado']);
                    if(!(empty($result))){
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response->getBody()->write(json_encode($result));
                    }else{
                        $response = new Response();
                        $result = ['message' => 'No tiene productos pendientes.'];
                        $response->getBody()->write(json_encode($result));
                    }
                }else{
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            case 'ConsultarPedido':
                $pedidosController = new pedidoController();
                $result = $pedidosController->consultarPedido($parametros['idPedido'], $parametros['codigoMesa']);
                if(!empty($result)){
                    $response->getBody()->write(json_encode($result));
                }else{
                    $response = new Response();
                    $result = ['message' => 'ERROR al buscar su pedido, por favor, re confirme su nro de pedido o el codigo de mesa.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            case 'ListarMejoresComentarios':
                if('socio' == $retorno->rol){
                    $encuestaController = new encuestaController();
                    $result = $encuestaController->listarMejoresComentarios();
                    $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                    $response->getBody()->write(json_encode($result));
                }else{
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            case 'ListarMesaMasUsada':
                if('socio' == $retorno->rol){
                    $mesasController = new mesaController();
                    $result = $mesasController->listarMesaMasUsada();
                    $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                    $response->getBody()->write(json_encode($result));
                }else{
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            case 'DescargarCSV':
                $empleadoController = new empleadoController();
                $result = $empleadoController->listarEmpleados();
                if (($handle = fopen("../files/LeerDesdeArchivo.csv", "w")) !== FALSE) {
                    foreach ($result as $empleado) {
                        $row = array($empleado->nombre, $empleado->apellido, $empleado->rol);
                        fputcsv($handle, $row);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                    }
                    $response = $handler->handle($request);
                    fclose($handle);
                }
                break;
            default:
                $response = new Response();
                $result = ['message' => 'Accion desconocida: ' . $action];
                $response->getBody()->write(json_encode($result));
                break;
                $response = $handler->handle($request);
        }
        
        return $response->withHeader('Content-Type', 'application/json');
    }

}



?>