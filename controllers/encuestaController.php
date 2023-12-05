<?php

include_once '../class/encuesta.php';

class encuestaController{

    public function agregarEncuesta($codigoMesa, $idPedido, $puntuacionMesa, $puntuacionRestaurante, $puntuacionMozo, $puntuacionCocinero, $comentario){
        $encuesta = new Encuesta();
        $encuesta->codigoMesa = $codigoMesa;
        $encuesta->idPedido = $idPedido;
        $encuesta->puntuacionMesa = $puntuacionMesa;
        $encuesta->puntuacionRestaurante = $puntuacionRestaurante;
        $encuesta->puntuacionMozo = $puntuacionMozo;
        $encuesta->puntuacionCocinero = $puntuacionCocinero;
        $encuesta->comentario = $comentario;
        return $encuesta->agregarEncuesta();
    }

    public function listarMejoresComentarios(){
        return Encuesta::listarMejoresComentarios();
    }
}


?>