<?php
  include_once '../Negocio/usuario-rol/nUsuarioRol.php';
  include_once '../Negocio/usuarios/nUsuario.php';

  function listar_usuario_rol() : array {
    $usuario_rol = new nUsuarioRol();
    return $usuario_rol->listar_usuario_rol();
  }

  // funcion para obtener solo los id y los usuarios
  function listar_usuarios() : array {
    $usuarios = new nUsuario();// instanciamos un objeto de la clase nUsuario
    return $usuarios->listar_usuarios_2();//obtenemos solo id_usuario y usuarios
  }
