<?php
  require_once '../Negocio/funciones.php';
  require_once '../Negocio/roles/nRol.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = $_POST['descripcion'];

    $campos = [
      'descripcion' => [
        'valor' => $descripcion,
        'validaciones' => [
          ['tipo' => 'empty', 'mensaje' => 'El campo descripción es obligatorio'],
          ['tipo' => 'longitud', 'min' => 5, 'mensaje' => 'La descripción debe tener al menos 2 caracteres'],
          ['tipo' => 'patron', 'patron' => '/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s]{5,29}$/', 'mensaje' => 'Descripción inválida']
        ]
      ]
    ];

    $errores = validar_campos($campos);

    if (!$errores) {
      $r = new nRol(0, $descripcion);
      $rol = $r->crear_rol();

      if ($rol) {
        echo json_encode(['success' => 'Rol creado correctamente.']);
      } else {
        echo json_encode(['errores' => 'error']);
      }
    } else {
      echo json_encode(['errores' => $errores]);
    }
    exit;
  }