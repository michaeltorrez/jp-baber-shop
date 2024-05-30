<?php
  require_once '../../../Negocio/nUsuario.php';

  if (isset($_POST['id'])) {
    $usu = new nUsuario($_POST['id']);
    
    if ($usu->eliminar_usuario()) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false]);
    }
  }