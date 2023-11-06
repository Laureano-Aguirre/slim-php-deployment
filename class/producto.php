<?php

include '../db/AccesoDatos.php';

class ProductoRestaurante{
    public $id;
    public $tipo;
    public $descripcion;
    public $cantidad;

    public function agregarProducto(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("INSERT into productos (tipo,descripcion) values(:tipo, :descripcion, :cantidad)");
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->retornarUltimoId();
    }

    public static function listarProductos(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("SELECT id_producto as id, tipo, descripcion FROM  productos");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "producto");
    }
}



?>