<?php
  require_once '../Negocio/usuario-rol/nUsuarioRol.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rol = new nUsuarioRol(0, $id, 0);
    $roles_disponibles = $rol->listar_roles_disponibles();

    echo json_encode(['success' => $roles_disponibles]);
  }