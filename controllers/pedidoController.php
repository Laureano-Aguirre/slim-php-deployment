<?php

require_once '../class/pedido.php';

class pedidoController{

    public function agregarPedido($nombreCliente, $idEmpleado, $productos, $estado, $tiempoFinalizacion){
        $pedido = new Pedido();
        $pedido->idPedido = Pedido::generarIdAlfanumerico(5);
        $pedido->nombreCliente = $nombreCliente;
        $pedido->idEmpleado = $idEmpleado;
        $pedido->productos = $productos;
        $pedido->estado = $estado;
        $pedido->tiempoFinalizacion = $tiempoFinalizacion;
        return $pedido->agregarPedido();
    }

    public function listarPedidos(){
        return Pedido::listarPedidos();
    }

    
}

?>