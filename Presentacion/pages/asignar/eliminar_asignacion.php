<?php
  require_once '../../../Negocio/nAsignar.php';

  if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $asignar = new nAsignar($id);
    
    if ($asignar->eliminar_asignacion()) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false]);
    }
  }