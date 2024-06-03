<?php
  require_once '../Negocio/usuario-rol/nUsuarioRol.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rol = new nUsuarioRol($id, 0, null);
    $roles_disponibles = $rol->listar_roles_disponibles();

    echo json_encode(['success' => $roles_disponibles]);
  }