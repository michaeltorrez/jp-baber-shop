<?php
declare(strict_types = 1);
require_once '../Datos/dUsuarioRol.php';

class nAsignar {
  private $usuario_rol;

  public function __construct(int $id = 0, int $id_usuario = 0, int $id_rol = 0, $fecha_asignacion = null)
  {
    $this->usuario_rol = new dUsuarioRol($id, $id_usuario, $id_rol, $fecha_asignacion);
  }


  function crear_asignacion() {
    return $this->usuario_rol->crear_asignacion();
  }

  function listar_asignaciones() {
    return $this->usuario_rol->listar_asignaciones();
  }


  function eliminar_asignacion() {
    return $this->usuario_rol->eliminar_asignacion();
  }

}