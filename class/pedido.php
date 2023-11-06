<?php

include_once '../db/AccesoDatos.php';

class Pedido{
    public $idPedido;
    public $nombreCliente;
    public $idEmpleado;
    public $productos = array();
    public $estado;
    public $tiempoFinalizacion;

    public function agregarPedido(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("INSERT into pedidos (nombre_cliente,id_empleado,estado,tiempo_finalizacion) values(:nombreCliente, :idEmpleado, :estado, :tiempoFinalizacion)");
        $consulta->bindValue(':nombreCliente', $this->nombreCliente, PDO::PARAM_STR);
        $consulta->bindValue(':idEmpleado', $this->idEmpleado, PDO::PARAM_INT);
        $consulta->bindValue(':productos', $this->productos, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':tiempoFinalizacion', $this->tiempoFinalizacion, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoId();   //falta pasar los productos

    }

    public static function listarMesa(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT nombre_cliente as nombreCliente, id_empleado as idEmpleado, estado, tiempo_finalizacion as tiempoFinalizacion FROM  pedidos");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "mesa");
    }

    public static function generarIdAlfanumerico($length = 5) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $id = '';
        
        for ($i = 0; $i < $length; $i++) {
            $id .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $id;
    }
}


?>