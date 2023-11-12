<?php

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;


class LoggerMiddleware{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $parametros = $request->getParsedBody();
        
        if(isset($parametros['rolUsuario'])){
            $rol = $parametros['rolUsuario'];
            if($rol == 'socio'){
                $response = $handler->handle($request);
            }else{
                $response = new Response();
                $result = ['message' => 'No es socio para poder realizar esta operacion.'];
                $response->getBody()->write(json_encode($result)); 
            }
        }else{
            $response = new Response();
            $result = ['message' => 'Parametors incorrectos, le falta el parametro rol.'];
            $response->getBody()->write(json_encode($result));
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
}
