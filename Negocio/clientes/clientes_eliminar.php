<?php
  require_once '../Negocio/nCliente.php';

  $cliente = new nCliente($id_cliente);
  
  if ($cliente->eliminar_cliente()) {
    $response = ['status' => 'success', 'message' => 'Cliente eliminado correctametne'];
  } else {
    $response = ['status' => 'error', 'message' => 'Algo salio mal'];
  }
  
  echo json_encode($response);
  exit;