<?php
  require_once '../Negocio/funciones.php';
  require_once '../Negocio/usuarios/nUsuario.php';

  // if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Agregar'])) {
  //   $nombres = trim($_POST['nombres']);
  //   $apellidos = trim($_POST['apellidos']);
  //   $correo = trim($_POST['correo']);
  //   $usuario = trim($_POST['usuario']);
  //   $contrasena = trim($_POST['contrasena']);
    
  //   $errores = validar_form_usuario($nombres, $apellidos, $correo, $usuario, $contrasena);
    
  //   // verificamos que no hayan errores para recien crear el usuario
  //   if (empty($errores)) {
  //     $usu = new nUsuario(0, $nombres, $apellidos, $correo, $usuario, $contrasena);
  //     $resultado = $usu->crear_usuario();
      
  //     if ($resultado === true) {
  //       echo json_encode(['success' => 'Usuario creado correctamente']);
  //     } else {
  //       echo json_encode($resultado);
  //     }
  //   } else {
  //     echo json_encode(['errores' => $errores]);
  //   }
  //   exit;
  // }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Editar'])) {
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $correo = trim($_POST['correo']);
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);
    
    $errores = validar_form_usuario($nombres, $apellidos, $correo, $usuario, $contrasena);

    // verificamos que no hayan errores para recien crear el usuario
    if (empty($errores)) {
      $usu = new nUsuario(0, $nombres, $apellidos, $correo, $usuario, $contrasena);
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
  

  function validar_form_usuario($nombres, $apellidos, $correo, $usuario, $contrasena) {
    $campos = array(
      'nombres' => array(
        'valor' => $nombres,
        'validaciones' => array(
          array('tipo' => 'empty', 'mensaje' => 'El campo nombres es obligatorio'),
          array('tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El o los nombres debe tener al menos 2 caracteres'),
          array('tipo' => 'patron', 'patron' => '/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s]{2,29}$/', 'mensaje' => 'Nombre(s) inválido(s)')
        )
      ),
      'apellidos' => array(
        'valor' => $apellidos,
        'validaciones' => array(
          array('tipo' => 'empty', 'mensaje' => 'El campo apellidos es obligatorio'),
          array('tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El o los apellidos debe tener al menos 2 caracteres'),
          array('tipo' => 'patron', 'patron' => '/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s]{2,29}$/', 'mensaje' => 'Apellidos inválidos')
        )
      ),
      'correo' => array(
        'valor' => $correo,
        'validaciones' => array(
          array(
            'tipo' => 'empty',
            'mensaje' => 'El correo es obligatorio'
          ),
          array('tipo' => 'filter', 'filtro' => FILTER_VALIDATE_EMAIL, 'mensaje' => 'El correo no es válido'
          )
        )
      ),
      'usuario' => array(
        'valor' => $usuario,
        'validaciones' => array(
          array('tipo' => 'empty', 'mensaje' => 'El usuario es obligatorio'),
          array('tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El nombre de usuario debe tener al menos 2 caracteres'),
          array ('tipo' => 'patron', 'patron' => '/^[a-zA-Z0-9_]{2,20}$/', 'mensaje' => 'El nombre de usuario debe tener entre 2 y 20 caracteres alfanuméricos o guiones bajos')
        )
      ),
      'contrasena' => array(
        'valor' => $contrasena,
        'validaciones' => array(
          array('tipo' => 'empty', 'mensaje' => 'La contraseña es obligatoria'),
          array('tipo' => 'longitud', 'min' => 8, 'mensaje' => 'La contraseña debe tener al menos 8 caracteres')
        )
      )
    );
    return validar_campos($campos);
  }