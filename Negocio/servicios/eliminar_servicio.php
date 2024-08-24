<?php
  require_once '../Negocio/servicios/nServicio.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_servicio = $_POST['id_servicio'];

    $servicio = new nServicio($id_servicio);
    
    if ($servicio->eliminar_servicio()) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'errores']);
    }
    exit;
  }