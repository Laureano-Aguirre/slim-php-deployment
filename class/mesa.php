<?php

include_once '../db/AccesoDatos.php';

class Mesa{
    public $idMesa;
    public $codigoMesa;
    public $idPedido;
    public $idMozo;
    public $idEncuesta;
    public $nombreCliente;
    public $estado;

    public function agregarMesa(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("INSERT into mesas (codigo_mesa,id_pedido,id_mozo,nombre_cliente,estado) values(:codigoMesa, :idPedido, :idMozo, :nombreCliente, :estado)");
        $consulta->bindValue(':idPedido', $this->idPedido, PDO::PARAM_STR);
        $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_STR);
        $consulta->bindValue(':idMozo', $this->idMozo, PDO::PARAM_INT);
        $consulta->bindValue(':nombreCliente', $this->nombreCliente, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoId();
    }

    public static function listarMesa(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT id_mesa as idMesa, codigo_mesa as codigoMesa, id_pedido as idPedido, id_mozo as idMozo, nombre_cliente as nombreCliente, estado FROM  mesas");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "mesa");
    }

    public function modificarEstadoMesa(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("UPDATE mesas SET estado=:estado WHERE codigo_mesa=:codigoMesa");
        $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        return $consulta->execute();
    }

    public function modificarEstadoMesaIDPedido(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("UPDATE mesas SET estado=:estado WHERE id_pedido=:idPedido");
        $consulta->bindValue(':idPedido', $this->idPedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        return $consulta->execute();
    }

    public function clientePagando(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("UPDATE mesas SET estado=:estado WHERE id_pedido=:idPedido");
        $consulta->bindValue(':idPedido', $this->idPedido, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        return $consulta->execute();
    }

    public function cerrarMesa(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("UPDATE mesas SET estado=:estado WHERE codigo_mesa=:codigoMesa");
        $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        return $consulta->execute();
    }

    public function listarMesaMasUsada(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT codigo_mesa, COUNT(*) as count FROM mesas GROUP BY codigo_mesa ORDER BY count DESC LIMIT 1");
        $consulta->execute();
        $mesaBuscada = $consulta->fetch(PDO::FETCH_ASSOC);
        return $mesaBuscada;
    }

    public function borrarMesa(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("DELETE from mesas WHERE id_mesa=:idMesa");
        $consulta->bindValue(':idMesa', $this->idMesa, PDO::PARAM_INT);
        return $consulta->execute();
    }


}

?>