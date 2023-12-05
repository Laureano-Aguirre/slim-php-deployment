<?php

include_once '../class/log.php';

class logController{
    public function agregarLog($user, $accion, $fecha){
        $log = new LogBanco();
        $log->user = $user;
        $log->accion = $accion;
        $log->fecha = $fecha;
        return $log->agregarLog();
    }
}



?>