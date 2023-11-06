<?php

include './db/AccesoDatos.php';

class Mesa{
    public $idMesa;
    public $idCliente;
    public $idPedido;
    public $idMozo;
    public $idEncuesta;
    public $estado;

    public function agregarMesa(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("INSERT into mesas (id_cliente,id_pedido,id_mozo,id_encuesta,estado) values(:idCliente, :idPedido, :idMozo, :idEncuesta, :estado)");
        $consulta->bindValue(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $consulta->bindValue(':idPedido', $this->idPedido, PDO::PARAM_INT);
        $consulta->bindValue(':idMozo', $this->idMozo, PDO::PARAM_INT);
        $consulta->bindValue(':idEncuesta', $this->idEncuesta, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoId();
    }

    public static function listarMesa(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT id_cliente as idCliente, id_pedido as idPedido, id_mozo as idMozo, id_encuesta as idEncuesta, estado FROM  mesas");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "mesa");
    }

}

?>