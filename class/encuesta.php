<?php

include_once '../db/AccesoDatos.php';

class Encuesta{
    public $idEncuesta;
    public $codigoMesa;
    public $idPedido;
    public $puntuacionMesa;
    public $puntuacionRestaurante;
    public $puntuacionMozo;
    public $puntuacionCocinero;
    public $comentario;

    public function agregarEncuesta(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("INSERT into encuestas (codigo_mesa,id_pedido,puntuacion_mesa,puntuacion_restaurante,puntuacion_mozo,puntuacion_cocinero,comentario) values(:codigoMesa, :idPedido, :puntuacionMesa, :puntuacionRestaurante, :puntuacionMozo, :puntuacionCocinero, :comentario)");
        $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_INT);
        $consulta->bindValue(':idPedido', $this->puntuacionMesa, PDO::PARAM_STR);
        $consulta->bindValue(':puntuacionMesa', $this->puntuacionMesa, PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionRestaurante', $this->puntuacionRestaurante, PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionMozo', $this->puntuacionMozo, PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionCocinero', $this->puntuacionCocinero, PDO::PARAM_INT);
        $consulta->bindValue(':comentario', $this->comentario, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoId();
    }

    public static function listarEncuestas(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT id_encuesta as idEncuesta, codigo_mesa as codigoMesa, id_pedido as idPedido,puntuacion_mesa as puntuacionMesa, puntuacion_restaurante as puntuacionRestaurante, puntuacion_mozo as puntuacionMozo, puntuacion_cocinero as puntuacionCocinero, comentario FROM  encuestas");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "encuesta");
    }

    public static function listarMejoresComentarios(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT id_encuesta as idEncuesta, codigo_mesa as codigoMesa, id_pedido as idPedido,puntuacion_mesa as puntuacionMesa, puntuacion_restaurante as puntuacionRestaurante, puntuacion_mozo as puntuacionMozo, puntuacion_cocinero as puntuacionCocinero, comentario FROM  encuestas WHERE puntuacion_mesa > 7 AND  puntuacion_restaurante > 7 AND puntuacion_mozo > 7 AND puntuacion_cocinero > 7");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "encuesta");
    }

}




?>