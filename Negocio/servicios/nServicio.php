<?php
namespace Negocio\servicios;

use Datos\dServicio;
include '../Datos/dServicio.php';

class nServicio {
  private $servicio;

  public function __construct($id=0, $nombre='', $descripcion='', $precio=0, $imagen=null)
  {
    $this->servicio = new dServicio($id, $nombre, $descripcion, $precio, $imagen);
  }


  function listar_servicios() {
    return $this->servicio->listar_servicios();
  }

  function agregar_servicio() {
    return $this->servicio->agregar_servicio();
  }

  function actualizar_imagen() {
    return $this->servicio->actualizar_imagen();
  }

  function obtener_servicio_por_id() {
    return $this->servicio->obtener_servicio_por_id();
  }

  function actualizar_servicio() {
    return $this->servicio->actualizar_servicio();
  }

  function eliminar_servicio() {
    return $this->servicio->eliminar_servicio();
  }

}