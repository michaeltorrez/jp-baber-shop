<?php
include '../Datos/dUsuario.php';

class nUsuario {
  private $usuario;

  public function __construct($id = 0, $nom = '', $ape = '', $cor = '', $usu = '', $con = '')
  {
    $this->usuario = new dUsuario($id, $nom, $ape, $cor, $usu, $con);
  }


  function crear_usuario() {
    /*$correo_disponible = $this->usuario->consultar_uno('CALL ExisteEmail(?)', $this->usuario->getCorreo(), 's');
    $usuario_disponible = $this->usuario->consultar_uno('CALL ExisteUsuario(?)', $this->usuario->getNombre_usuario(), 's');
    
    if ($correo_disponible !== null) {
      $errores[] = 'El correo: ' . $correo_disponible['correo'] . ' ya esta en uso';
    }
    
    if ($usuario_disponible !== null) {
      $errores[] = 'El usuario: ' . $usuario_disponible['nombre_usuario'] . ' ya esta en uso';
    }

    return $errores ?? $this->usuario->crear_usuario();*/
    return $this->usuario->crear_usuario();
  }


  function eliminar_usuario() {
    $respuesta = $this->usuario->eliminar_usuario();
    return $respuesta;
  }

  function obtener_usuario_por_id() {
    $respuesta = $this->usuario->obtener_usuario_por_id();
    return $respuesta;
  }


  function listar_usuarios() {
    return $this->usuario->listar_usuarios();
  }

  function listar_usuarios_2() {
    return $this->usuario->listar_usuarios_2();
  }

  function actualizar_usuario() {
    $respuesta = $this->usuario->actualizar_usuario();
    return $respuesta;
  }


  function existe_email($email) {
    $respuesta = $this->usuario->consultar_uno('CALL ExisteEmail()', $email, 's');
    return $respuesta;
  }

  function obtener_usuario() {
    $respuesta = $this->usuario->obtener_usuario();
    return $respuesta;
  }

}