<?php

require_once './class/empleado.php';

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
}


?>