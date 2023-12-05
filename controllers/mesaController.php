<?php

include_once '../class/mesa.php';

class mesaController{

    public function agregarMesa($idPedido, $codigoMesa, $idMozo, $nombreCliente, $estado){
        $mesa = new Mesa();
        $mesa->idPedido = $idPedido;
        $mesa->codigoMesa = $codigoMesa;
        $mesa->idMozo = $idMozo;
        $mesa->nombreCliente= $nombreCliente;
        $mesa->estado = $estado;
        return $mesa->agregarMesa();
    }

    public function listarMesas(){
        return Mesa::listarMesa();
    }

    public function modificarEstadoMesa($idMesa, $estado){
        $mesa = new Mesa();
        $mesa->idMesa = $idMesa;
        $mesa->estado = $estado;
        return $mesa->modificarEstadoMesa();
    }

    public function modificarEstadoMesaIDPedido($idPedido){
        $mesa = new Mesa();
        $mesa->idPedido = $idPedido;
        $mesa->estado = 'con cliente comiendo';
        return $mesa->modificarEstadoMesaIDPedido();
    }

    public function clientePagando($idPedido){
        $mesa = new Mesa();
        $mesa->idPedido = $idPedido;
        $mesa->estado = 'con cliente pagando';
        return $mesa->clientePagando();
    }

    public function cerrarMesa($codigoMesa){
        $mesa = new Mesa();
        $mesa->codigoMesa = $codigoMesa;
        $mesa->estado = 'cerrada';
        return $mesa->cerrarMesa();
    }

    public function borrarMesa($idMesa){
        $mesa = new Mesa();
        $mesa->idMesa = $idMesa;
        return $mesa->borrarMesa();
    }

    public function listarMesaMasUsada(){
        $mesa = new Mesa();
        return $mesa->listarMesaMasUsada();
    }

    function generarCodigoMesa() {
        return rand(10000, 10009);
    }

    public function generarNombreFotoMesa($codigoMesa, $nombreCliente){
        $nombreArchivo = $codigoMesa . $nombreCliente . ".png"; 
        return $nombreArchivo;
    }

}




?>