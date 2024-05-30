<?php
declare(strict_types = 1);
require_once '../../../Datos/dAsignar.php';

class nAsignar {
  private $asignar;

  public function __construct(int $id = 0, int $id_usuario = 0, int $id_rol = 0, $fecha_asignacion = null)
  {
    $this->asignar = new dAsignar($id, $id_usuario, $id_rol, $fecha_asignacion);
  }


  function crear_asignacion() {
    return $this->asignar->crear_asignacion();
  }

  function listar_asignaciones() {
    return $this->asignar->listar_asignaciones();
  }


  function eliminar_asignacion() {
    return $this->asignar->eliminar_asignacion();
  }

}