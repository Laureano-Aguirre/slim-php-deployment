<?php

require_once './class/mesa.php';

class mesaController{

    public function agregarMesa($idCliente, $idPedido, $idMozo, $idEncuesta, $estado){
        $mesa = new Mesa();
        $mesa->idCliente= $idCliente;
        $mesa->idPedido = $idPedido;
        $mesa->idMozo = $idMozo;
        $mesa->idEncuesta = $idEncuesta;
        $mesa->estado = $estado;
    }

    public function listarMesas(){
        return Mesa::listarMesa();
    }
}




?>