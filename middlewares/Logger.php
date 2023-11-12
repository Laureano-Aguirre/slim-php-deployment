<?php

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

require_once '../validations/validaciones.php';

class LoggerMiddleware{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $parametros = $request->getParsedBody();

        if (isset($parametros['rolUsuario'])) {
            $rol = $parametros['rolUsuario'];
            $action = $parametros['action'];
            if ($rol == 'socio') {
                switch ($action) {
                    case 'AltaEmpleado':
                        if ((Validaciones::validarStrings($parametros['nombre'])) && (Validaciones::validarStrings($parametros['apellido'])) && (Validaciones::validarStrings($parametros['rol']))) {
                            $response = $handler->handle($request);
                        } else {
                            $response = new Response();
                            $result = ['message' => 'Algun parametro no fue introducido en un formato correcto.'];
                            $response->getBody()->write(json_encode($result));
                        }
                        break;
                } 
            } else {
                $response = new Response();
                $result = ['message' => 'No es socio para poder realizar esta operacion.'];
                $response->getBody()->write(json_encode($result));
            }
        } else {
            $response = new Response();
            $result = ['message' => 'Parametors incorrectos, le falta el parametro rol.'];
            $response->getBody()->write(json_encode($result));
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
}
