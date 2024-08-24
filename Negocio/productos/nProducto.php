<?php
namespace Negocio\productos;

use Datos\dProducto;
include '../Datos/dProducto.php';

class nProducto {
  private $producto;

  public function __construct($id_producto=0, $id_categoria=0, $nombre='', $descripcion='', $marca='', $precio=0, $stock=0, $imagen=null)
  {
    $this->producto = new dProducto($id_producto, $id_categoria, $nombre, $descripcion, $marca, $precio, $stock, $imagen);
  }


  function listar_productos() {
    return $this->producto->listar_productos();
  }

  function agregar_producto() {
    return $this->producto->agregar_producto();
  }

  function actualizar_imagen() {
    return $this->producto->actualizar_imagen();
  }

  function obtener_producto_por_id() {
    return $this->producto->obtener_producto_por_id();
  }

  function actualizar_producto() {
    return $this->producto->actualizar_producto();
  }

  function eliminar_producto() {
    return $this->producto->eliminar_producto();
  }

}