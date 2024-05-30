<?php
  require_once '../../../Negocio/nRol.php';

  if (isset($_POST['id'])) {
    $rol = new nRol($_POST['id']);
    
    if ($rol->eliminar_rol()) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false]);
    }
  }