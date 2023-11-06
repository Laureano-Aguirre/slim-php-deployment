<?php

include_once '../db/AccesoDatos.php';

class Empleado{
    public $id;
    public $nombre;
    public $apellido;
    public $rol;
    public $fechaAlta;

    public function agregarEmpleado(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("INSERT into empleados (nombre,apellido,rol,fecha_Alta) values(:nombre, :apellido, :rol, '$this->fechaAlta')");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoId();
    }

    public static function listarEmpleados(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT id_empleado as id, nombre, apellido, rol, fecha_Alta as fechaAlta FROM  empleados");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "empleado");
    }
}


?>