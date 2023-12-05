<?php

include_once '../db/AccesoDatos.php';

class LogBanco{
    public $id;
    public $user;
    public $accion;
    public $fecha;


    public function agregarLog(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("INSERT into log (user,accion,fecha) values(:user, :accion, :fecha)");
        $consulta->bindValue(':user', $this->user, PDO::PARAM_STR);
        $consulta->bindValue(':accion', $this->accion, PDO::PARAM_STR);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoId();
    }

}

?>