<?php

require_once './class/producto.php';

class productoController{

    public function agregarProducto($tipo, $descripcion){
        $producto = new ProductoRestaurante();
        $producto->tipo = $tipo;
        $producto->descripcion = $descripcion;
        $producto->agregarProducto();
    }

    public function listarProductos(){
        return ProductoRestaurante::listarProductos();
    }
}

?>