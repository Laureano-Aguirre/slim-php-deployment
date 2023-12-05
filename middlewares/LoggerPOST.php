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
include_once '../controllers/encuestaController.php';
include_once '../controllers/logController.php';

class LoggerMiddlewarePOST{
    
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $retorno = AutentificadorJWT::ObtenerData($token);
        $parametros = $request->getParsedBody();
        $action = $parametros['action'];

        switch ($action) {
            case 'AltaEmpleado':
                if('socio' == $retorno->rol){
                    if ((Validaciones::validarStrings($parametros['nombre'])) && (Validaciones::validarStrings($parametros['apellido'])) && (Validaciones::validarStrings($parametros['rol']))) {
                        $fechaAlta = date('Y-m-d');
                        $empleadoController = new empleadoController();
                        $result = $empleadoController->agregarEmpleado($parametros['nombre'], $parametros['apellido'], $parametros['rol'], $fechaAlta,$parametros['usuario'], $parametros['password']);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    } else {
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
            case 'AltaProductos':
                if('socio' == $retorno->rol){
                    if ((Validaciones::validarStrings($parametros['tipo'])) && (Validaciones::validarStrings($parametros['descripcion'])) && (Validaciones::validarInt($parametros['cantidad']))) {
                        $productosController = new productoController();
                        $productosController->agregarProducto($parametros['tipo'], $parametros['descripcion'], $parametros['cantidad']);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    } else {
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
            case 'AltaMesas':
                if('mozo' == $retorno->rol || 'socio' == $retorno->rol){
                    if ((isset($parametros['idPedido'])) && (Validaciones::validarInt($parametros['idMozo'])) && (Validaciones::validarStrings($parametros['nombreCliente'])) && (Validaciones::validarStrings($parametros['estado'])) && (isset($_FILES['archivo']))) {
                        $mesasController = new mesaController();
                        $codigoMesa = $mesasController->generarCodigoMesa();
                        $mesasController->agregarMesa($parametros['idPedido'], $codigoMesa, $parametros['idMozo'], $parametros['nombreCliente'], $parametros['estado']);
                        $archivo = $_FILES['archivo'];
                        $nombreImagen = $archivo['name'];
                        $tipo = $archivo['type'];
                        $nombreImagen = $mesasController->generarNombreFotoMesa($codigoMesa, $parametros['nombreCliente']);
                        move_uploaded_file($archivo['tmp_name'], '../ImagenesMesas/' . $nombreImagen);
                        $pedidosController = new pedidoController();
                        $pedidosController->establecerCodigoMesa($parametros['idPedido'], $codigoMesa);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    } else {
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
            case 'AltaPedidos':
                if('mozo' == $retorno->rol){
                    if ((Validaciones::validarStrings($parametros['nombreCliente'])) && (Validaciones::validarInt($parametros['idMozo'])) && (Validaciones::validarStrings($parametros['estado'])) && (Validaciones::validarInt($parametros['tiempoFinalizacion']))) {
                        $pedidosController = new pedidoController();
                        $pedidosController->agregarPedido($parametros['nombreCliente'], $parametros['idMozo'], $parametros['estado'], $parametros['tiempoFinalizacion']);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    } else {
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
            case 'AltaProductoPedido':
                if('mozo' == $retorno->rol){
                    if((Validaciones::validarInt($parametros['idProducto'])) && (Validaciones::validarStrings($parametros['descripcionProducto'])) && (Validaciones::validarInt($parametros['codigoMesa'])) && (Validaciones::validarStrings($parametros['idPedido'])) && (Validaciones::validarInt($parametros['idEmpleado'])) && (Validaciones::validarInt($parametros['tiempoFinalizacion']))){
                        $productoPedidoController = new productoPedidoController();
                        $productoPedidoController->agregarProductoPedido($parametros['idProducto'], $parametros['descripcionProducto'], $parametros['codigoMesa'], $parametros['idPedido'], $parametros['idEmpleado'], $parametros['tiempoFinalizacion']);
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
                    $result = ['message' => 'No tiene el permiso correcto para realizar esta operacion.'];
                    $response->getBody()->write(json_encode($result));
                }
                break;
            case 'HacerEncuesta':
                $encuestaController = new encuestaController();
                $result = $encuestaController->agregarEncuesta($parametros['codigoMesa'], $parametros['idPedido'], $parametros['puntuacionMesa'], $parametros['puntuacionRestaurante'], $parametros['puntuacionMozo'], $parametros['puntuacionCocinero'], $parametros['comentario']);
                $logController = new logController();
                $fechaLog = date('Y-m-d H:i:s');
                $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                $response = $handler->handle($request);
                break;
            case 'AltaEmpleadoCSV':
                $empleadoController = new empleadoController();
                $fechaAlta = date('Y-m-d');
                if (($handle = fopen("../files/CargarDesdeArchivo.csv", "r")) !== FALSE) {
                    if (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $result = $empleadoController->agregarEmpleado($data[0], $data[1], $data[2], $data[3], $data[4],$fechaAlta);
                        $logController = new logController();
                        $fechaLog = date('Y-m-d H:i:s');
                        $logController->agregarLog($retorno->usuario, $action, $fechaLog);
                        $response = $handler->handle($request);
                    }
                    fclose($handle);
                }else{
                    $response = new Response();
                    $result = ['message' => 'Error al leer el archivo.'];
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
