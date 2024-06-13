<?php
  require_once '../Negocio/funciones.php';
  require_once '../Negocio/usuarios/nUsuario.php';

  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $correo = trim($_POST['correo']);
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);

    $campos = [
      'nombres' => [
        'valor' => $nombres,
        'validaciones' => [
          ['tipo' => 'empty', 'mensaje' => 'El campo nombres es obligatorio'],
          ['tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El o los nombres debe tener al menos 2 caracteres'],
          ['tipo' => 'patron', 'patron' => '/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s]{2,29}$/', 'mensaje' => 'Nombre(s) inválido(s)']
        ]
      ],
      'apellidos' => [
        'valor' => $apellidos,
        'validaciones' => [
          ['tipo' => 'empty', 'mensaje' => 'El campo apellidos es obligatorio'],
          ['tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El o los apellidos debe tener al menos 2 caracteres'],
          ['tipo' => 'patron', 'patron' => '/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s]{2,29}$/', 'mensaje' => 'Apellidos inválidos']
        ]
      ],
      'correo' => [
        'valor' => $correo,
        'validaciones' => validaciones_predefinidas('correo'),
      ],
      'usuario' => [
        'valor' => $usuario,
        'validaciones' => validaciones_predefinidas('usuario'),
      ],
      'contrasena' => [
        'valor' => $contrasena,
        'validaciones' => validaciones_predefinidas('contrasena'),
      ]
    ];
    
    //$errores = validar_form_usuario($nombres, $apellidos, $correo, $usuario, $contrasena);
    $errores = validar_campos($campos);
    
    // verificamos que no hayan errores para recien crear el usuario
    if (empty($errores)) {
      $hash = password_hash($contrasena, PASSWORD_DEFAULT);
      $usu = new nUsuario(0, $nombres, $apellidos, $correo, $usuario, $hash);
      $resultado = $usu->crear_usuario();
      
      if ($resultado === true) {
        echo json_encode(['success' => 'Usuario creado correctamente']);
      } else {
        echo json_encode($resultado);
      }
    } else {
      echo json_encode(['errores' => $errores]);
    }
    exit;
  }