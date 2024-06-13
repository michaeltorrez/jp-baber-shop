<?php
  declare(strict_types = 1);//solo funciona con variables de tipo escalares
  require_once '../Negocio/usuario-rol/nUsuarioRol.php';
  //include_once '../Negocio/acceso.php'; soluciones esto

  // preguntamos y se llamo al archivos desde  un metodo post
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // recuperamos el id_usuario_rol que trae post
    $id_usuario = (int)$_POST['id_usuario'];
    $id_rol = (int)$_POST['id_rol'];

    // instanciamos una variable de tipo nUsuarioRol para poder usar sus metodos
    $rol = new nUsuarioRol($id_usuario, $id_rol);

    if ($rol->eliminar_asignacion()) {
      echo json_encode(['success' => 'Rol asignado eliminado correctamente']);
    } else {
      echo json_encode(['errores' => false]);
    }
    
    exit;
  }