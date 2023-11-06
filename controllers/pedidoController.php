<?php

require_once './class/pedido.php';

class pedidoController{

    public function agregarPedido($nombreCliente, $idEmpleado, $productos, $estado, $tiempoFinalizacion){
        $pedido = new Pedido();
        $pedido->nombreCliente = $nombreCliente;
        $pedido->idEmpleado = $idEmpleado;
        $pedido->productos = $productos;
        $pedido->estado = $estado;
        $pedido->tiempoFinalizacion = $tiempoFinalizacion;
    }

    public function listarPedidos(){
        return ProductoRestaurante::listarProductos();
    }
}

?>