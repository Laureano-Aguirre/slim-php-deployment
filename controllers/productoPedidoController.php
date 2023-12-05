<?php

include_once '../class/ProductoPedido.php';

class productoPedidoController{
    public function agregarProductoPedido($idProducto, $descripcionProducto, $codigoMesa, $idPedido, $idEmpleado, $tiempoFinalizacion){
        $productoPedido = new ProductoPedido();
        $productoPedido->idProducto = $idProducto;
        $productoPedido->descripcionProducto = $descripcionProducto;
        $productoPedido->codigoMesa = $codigoMesa;
        $productoPedido->idPedido = $idPedido;
        $productoPedido->idEmpleado = $idEmpleado;
        $productoPedido->tiempoFinalizacion = $tiempoFinalizacion;
        $productoPedido->estado = 'pendiente';
        return $productoPedido->agregarProductoPedido();
    }

    public function consultarEstadoProductoPedido($idEmpleado, $estado){
        $productoPedido = new ProductoPedido();
        $productoPedido->idEmpleado = $idEmpleado;
        $productoPedido->estado = $estado;
        return $productoPedido->consultarEstadoProductoPedido();
    }

    public function consultarProductoPedido($idProductoPedido){
        $productoPedido = new ProductoPedido();
        $productoPedido->idProductoPedido = $idProductoPedido;
        return $productoPedido->consultarProductoPedido();
    }

    public function prepararProductoPedido($idProductoPedido, $tiempoFinalizacion){
        $productoPedido = new ProductoPedido();
        $productoPedido->idProductoPedido = $idProductoPedido;
        $productoPedido->tiempoFinalizacion = $tiempoFinalizacion;
        return $productoPedido->prepararProductoPedido();
    }

    public function terminarProductoPedido($idProductoPedido){
        $productoPedido = new ProductoPedido();
        $productoPedido->idProductoPedido = $idProductoPedido;
        return $productoPedido->terminarProductoPedido();
    }
}

?>