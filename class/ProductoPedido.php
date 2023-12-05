<?php


include_once '../db/AccesoDatos.php';

class ProductoPedido{
    public $idProductoPedido;
    public $idProducto;
    public $descripcionProducto;
    public $codigoMesa;
    public $idPedido;
    public $idEmpleado;
    public $tiempoFinalizacion;
    public $estado;

    public function agregarProductoPedido(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("INSERT INTO productopedido (id_producto,descripcion_producto,codigo_mesa,id_pedido,id_empleado,tiempo_finalizacion,estado) values (:idProducto, :descripcionProducto, :codigoMesa, :idPedido, :idEmpleado, :tiempoFinalizacion, :estado)");
        
        $consulta->bindValue(':idProducto', $this->idProducto, PDO::PARAM_INT);
        $consulta->bindValue(':descripcionProducto', $this->descripcionProducto, PDO::PARAM_STR);
        $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_INT);
        $consulta->bindValue(':idPedido', $this->idPedido, PDO::PARAM_STR);
        $consulta->bindValue(':idEmpleado', $this->idEmpleado, PDO::PARAM_INT);
        $consulta->bindValue(':tiempoFinalizacion', $this->tiempoFinalizacion, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoId();
    }

    public function consultarEstadoProductoPedido(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT id_producto_pedido as idProductoPedido, id_producto as idProducto, descripcion_producto as descripcionProducto, codigo_mesa as codigoMesa, id_pedido as idPedido, id_empleado as idEmpleado,tiempo_finalizacion as tiempoFinalizacion, estado FROM productopedido WHERE estado=:estado AND id_empleado=:idEmpleado");
        $consulta->bindValue(':idEmpleado', $this->idEmpleado, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "ProductoPedido");
    }

    public function consultarProductoPedido(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT id_producto_pedido as idProductoPedido, id_producto as idProducto, descripcion_producto as descripcion, codigo_mesa as codigoMesa, id_pedido as idPedido, id_empleado as idEmpleado,tiempo_finalizacion as tiempoFinalizacion, id_pedido as idPedido, estado FROM productopedido WHERE id_producto_pedido=:idProductoPedido");
        $consulta->bindValue(':idProductoPedido', $this->idProductoPedido, PDO::PARAM_INT);
        $consulta->execute();
        $productoPedidoBuscado = $consulta->fetchObject('ProductoPedido');
        return $productoPedidoBuscado;
    }

    public function prepararProductoPedido(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("UPDATE productopedido set estado='en preparacion', tiempo_finalizacion=:tiempoFinalizacion WHERE id_producto_pedido=:idProductoPedido");
        $consulta->bindValue(':tiempoFinalizacion', $this->tiempoFinalizacion, PDO::PARAM_INT);
        $consulta->bindValue(':idProductoPedido', $this->idProductoPedido, PDO::PARAM_INT);
        return $consulta->execute();
    }

    public function terminarProductoPedido(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("UPDATE productopedido set estado='listo para servir', tiempo_finalizacion=0 WHERE id_producto_pedido=:idProductoPedido");
        $consulta->bindValue(':idProductoPedido', $this->idProductoPedido, PDO::PARAM_INT);
        return $consulta->execute();
    }
}