<?php

include_once '../class/producto.php';

class productoController{

    public function agregarProducto($tipo, $descripcion, $cantidad){
        $producto = new ProductoRestaurante();
        $producto->tipo = $tipo;
        $producto->descripcion = $descripcion;
        $producto->cantidad = $cantidad;
        return $producto->agregarProducto();
    }

    public function listarProductos(){
        return ProductoRestaurante::listarProductos();
    }
}

?>