<?php

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

require_once '../validations/validaciones.php';
include_once '../controllers/empleadoController.php';
include_once '../controllers/productoController.php';
include_once '../controllers/pedidoController.php';
include_once '../controllers/mesaController.php';
include_once '../controllers/productoPedidoController.php';
include_once '../controllers/logController.php';

class LoggerMiddlewarePUT{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $retorno = AutentificadorJWT::ObtenerData($token);
        $parametros = $request->getParsedBody();
        $action = $parametros['action'];

        //var_dump($parametros);
        switch ($action) {
            case 'ModificarUsuario':
                if('socio' == $retorno->rol){
                    if ((Validaciones::validarInt($parametros['idEmpleado'])) && (Validaciones::validarStrings($parametros['nombre'])) && (Validaciones::validarStrings($parametros['apellido'])) && (Validaciones::validarStrings($parametros['rol']))) {
                        $empleadoController = new empleadoController();
                        $result = $empleadoController->modificarEmpleado($parametros['idEmpleado'], $parametros['nombre'], $parametros['apellido'], $parametros['rol']);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    }else {
                        $response = new Response();
                        $result = ['message' => 'Algun parametro no fue introducido en un formato correcto.'];
                        $response->getBody()->write(json_encode($result));
                    }
                }else{
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
            break;
            case 'ModificarPedido':
                if('socio' == $retorno->rol || 'mozo' == $retorno->rol){
                    if(Validaciones::validarStrings(($parametros['productos'])) && Validaciones::validarStrings(($parametros['estado'])) && Validaciones::validarInt(($parametros['tiempoFinalizacion']))){
                        $pedidoController = new pedidoController();
                        $result = $pedidoController->modificarPedido($parametros['idPedido'], $parametros['productos'], $parametros['estado'], $parametros['tiempoFinalizacion']);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    }else{
                        $response = new Response();
                        $result = ['message' => 'Algun parametro no fue introducido en un formato correcto.'];
                        $response->getBody()->write(json_encode($result));
                    }
                }else{
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            case 'ModificarProducto':
                if('socio' == $retorno->rol){
                    if(Validaciones::validarInt($parametros['cantidad'])){
                        $productoController = new productoController();
                        $result = $productoController->modificarProducto($parametros['idProducto'], $parametros['cantidad']);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    }else{
                        $response = new Response();
                        $result = ['message' => 'Algun parametro no fue introducido en un formato correcto.'];
                        $response->getBody()->write(json_encode($result));
                    }
                }else{
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            case 'ModificarMesa':
                if ('socio' == $retorno->rol || 'mozo' == $retorno->rol) {
                    if ((Validaciones::validarInt($parametros['idMesa'])) && (Validaciones::validarStrings($parametros['estado']))) {
                        $mesaController = new mesaController();
                        $result = $mesaController->modificarEstadoMesa($parametros['idMesa'], $parametros['estado']);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    } else {
                        $response = new Response();
                        $result = ['message' => 'Algun parametro no fue introducido en un formato correcto.'];
                        $response->getBody()->write(json_encode($result));
                    }
                } else {
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            case 'PrepararProductoPedido':
                if ('cocinero' == $retorno->rol) {
                    if((Validaciones::validarInt($parametros['idProductoPedido'])) && (Validaciones::validarInt($parametros['tiempoFinalizacion']))){
                        $productoPedidoController = new productoPedidoController();
                        $result = $productoPedidoController->prepararProductoPedido($parametros['idProductoPedido'], $parametros['tiempoFinalizacion']);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    }else{
                        $response = new Response();
                        $result = ['message' => 'Algun parametro no fue introducido en un formato correcto.'];
                        $response->getBody()->write(json_encode($result));
                    }
                } else {
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            case 'TerminarProductoPedido':
                if ('cocinero' == $retorno->rol || 'cervecero' == $retorno->rol || 'bartender' == $retorno->rol) {
                    if(Validaciones::validarInt($parametros['idProductoPedido'])){
                        $productoPedidoController = new productoPedidoController();
                        $result = $productoPedidoController->terminarProductoPedido($parametros['idProductoPedido']);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    }else{
                        $response = new Response();
                        $result = ['message' => 'Algun parametro no fue introducido en un formato correcto.'];
                        $response->getBody()->write(json_encode($result));
                    }
                }else {
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            case 'EntregarPedido':
                if ('mozo' == $retorno->rol) {
                    if(Validaciones::validarStrings($parametros['idPedido'])){
                        $pedidoController = new pedidoController();
                        $result = $pedidoController->entregarPedido($parametros['idPedido']);
                        $mesaController = new mesaController();
                        $result = $mesaController->modificarEstadoMesaIDPedido($parametros['idPedido']);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    }else{
                        $response = new Response();
                        $result = ['message' => 'Algun parametro no fue introducido en un formato correcto.'];
                        $response->getBody()->write(json_encode($result));
                    }
                }else {
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            case 'CobrarPedido':
                if ('mozo' == $retorno->rol) {
                    if(Validaciones::validarStrings($parametros['idPedido']) && (Validaciones::validarInt($parametros['cuenta']))){
                        $pedidoController = new pedidoController();
                        $pedidoController->cobrarCuentaPedido($parametros['idPedido'], $parametros['cuenta']);
                        $mesaController = new mesaController();
                        $mesaController->clientePagando($parametros['idPedido']);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    }else{
                        $response = new Response();
                        $result = ['message' => 'Algun parametro no fue introducido en un formato correcto.'];
                        $response->getBody()->write(json_encode($result));
                    }
                }else {
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            case 'CerrarMesa':
                if ('socio' == $retorno->rol){
                    if(Validaciones::validarInt($parametros['codigoMesa'])){
                        $mesaController = new mesaController();
                        $mesaController->cerrarMesa($parametros['codigoMesa']);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    }else{
                        $response = new Response();
                        $result = ['message' => 'Algun parametro no fue introducido en un formato correcto.'];
                        $response->getBody()->write(json_encode($result));
                    }
                }else {
                    $response = new Response();
                    $result = ['message' => 'ERROR, no tiene permiso para ejecutar dicha operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            default:
                $response = new Response();
                $result = ['message' => 'Accion desconocidad: ' . $action];
                $response->getBody()->write(json_encode($result));
                break;
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
}

?>