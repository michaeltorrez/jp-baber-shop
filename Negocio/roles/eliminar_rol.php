<?php
  require_once '../Negocio/roles/nRol.php';
  //include_once '../Negocio/acceso.php'; soluciones esto

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rol = new nRol($id);
    
    if ($rol->eliminar_rol()) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['errores' => false]);
    }
    exit;
  }