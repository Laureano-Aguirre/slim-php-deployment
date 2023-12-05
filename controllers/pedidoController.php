<?php

require_once '../class/pedido.php';

class pedidoController{

    public function agregarPedido($nombreCliente, $idMozo, $estado, $tiempoFinalizacion){
        $pedido = new Pedido();
        $pedido->idPedido = Pedido::generarIdAlfanumerico(5);
        $pedido->nombreCliente = $nombreCliente;
        $pedido->idEmpleado = $idMozo;
        $pedido->estado = $estado;
        $pedido->tiempoFinalizacion = $tiempoFinalizacion;
        return $pedido->agregarPedido();
    }

    public function listarPedidos(){
        return Pedido::listarPedidos();
    }

    public function modificarPedido($idPedido, $estado, $tiempoFinalizacion){
        $pedido = new Pedido();
        $pedido->idPedido = $idPedido;
        $pedido->estado = $estado;
        $pedido->tiempoFinalizacion = $tiempoFinalizacion;
        return $pedido->modificarPedido();
    }

    public function establecerCodigoMesa($idPedido, $codigoMesa){
        $pedido = new Pedido();
        $pedido->idPedido = $idPedido;
        $pedido->codigoMesa = $codigoMesa;
        return $pedido->establecerCodigoMesa();
    }

    public function consultarPedido($idPedido, $codigoMesa){
        $pedido = new Pedido();
        $pedido->idPedido = $idPedido;
        $pedido->codigoMesa = $codigoMesa;
        return $pedido->consultarPedido();
    }

    public function entregarPedido($idPedido){
        $pedido = new Pedido();
        $pedido->idPedido = $idPedido;
        return $pedido->entregarPedido();
    }

    public function cobrarCuentaPedido($idPedido, $cuenta){
        $pedido = new Pedido();
        $pedido->idPedido = $idPedido;
        $pedido->cuenta = $cuenta;
        return $pedido->cobrarCuentaPedido();
    }

    public function borrarPedido($idPedido){
        $pedido = new Pedido();
        $pedido->idPedido = $idPedido;
        return $pedido->borrarPedido();
    }
}

?>