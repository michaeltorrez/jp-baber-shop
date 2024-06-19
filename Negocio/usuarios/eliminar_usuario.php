<?php
  require_once '../Negocio/usuarios/nUsuario.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];

    //print_r($id_usuario);

    $usu = new nUsuario($id_usuario);
    
    if ($usu->eliminar_usuario()) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['errores' => false]);
    }
    exit;
  }