<?php
declare(strict_types = 1);
include '../Datos/dRol.php';

class nRol {
  private dRol $rol;

  public function __construct(int $id = 0, string $descripcion = '')
  {
    $this->rol = new dRol($id, $descripcion);
  }


  public function crear_rol() {
    if ($this->rol->existe_rol()) {
      $errores[] = 'El rol ya existe';
      return $errores;
    }

    return $this->rol->crear_rol();
  }

  public function listar_roles() : array {
    return $this->rol->listar_roles();
  }

  public function obtener_rol() : array {
    return $this->rol->obtener_rol();
  }

  public function actualizar_rol(): bool {
    return $this->rol->actualizar_rol();
  }

  public function eliminar_rol(): bool {
    return $this->rol->eliminar_rol();
  }

}