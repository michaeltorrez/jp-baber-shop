<?php
  require_once '../Negocio/productos/nProducto.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'];

    $producto = new nProducto($id_producto);
    
    if ($producto->eliminar_producto()) {
      echo json_encode(['status' => 'success']);
    } else {
      echo json_encode(['status' => 'errores']);
    }
    exit;
  }