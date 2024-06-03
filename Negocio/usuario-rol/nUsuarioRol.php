<?php
declare(strict_types = 1);
require_once '../Datos/dUsuarioRol.php';

class nUsuarioRol {
  private $usuario_rol;

  public function __construct(int $id_usuario = 0, int $id_rol = 0, $fecha_asignacion = null)
  {
    $this->usuario_rol = new dUsuarioRol($id_usuario, $id_rol, $fecha_asignacion);
  }


  function crear_asignacion() {
    return $this->usuario_rol->crear_asignacion();
  }

  function listar_usuario_rol() {
    return $this->usuario_rol->listar_asignaciones();
  }

  function listar_roles_disponibles() : array {
    return $this->usuario_rol->listar_roles_disponibles();
  }


  function eliminar_asignacion() {
    return $this->usuario_rol->eliminar_asignacion();
  }

}