<?php
  require_once '../Negocio/usuarios/nUsuario.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usu = new nUsuario($id);
    
    if ($usu->eliminar_usuario()) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false]);
    }
    exit;
  }