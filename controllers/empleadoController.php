<?php

include_once '../class/empleado.php';

class empleadoController{

    public function agregarEmpleado($nombre, $apellido, $rol, $fechaAlta){
        $empleado = new Empleado();
        $empleado->nombre = $nombre;
        $empleado->apellido = $apellido;
        $empleado->rol = $rol;
        $empleado->fechaAlta = $fechaAlta;
        return $empleado->agregarEmpleado();
    }

    public function listarEmpleados(){
        return Empleado::listarEmpleados();
    }

    public function modificarEmpleado($idEmpleado, $nombre, $apellido, $rol){
        $empleado = new Empleado();
        $empleado->id = $idEmpleado;
        $empleado->nombre = $nombre;
        $empleado->apellido = $apellido;
        $empleado->rol = $rol;
        return $empleado->modificarEmpleado();
    }

    public function borrarEmpleado($idEmpleado){
        $empleado = new Empleado();
        $empleado->id = $idEmpleado;
        return $empleado->borrarEmpleado();
    }

    
}


?>