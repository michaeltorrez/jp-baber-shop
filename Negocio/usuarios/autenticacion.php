<?php
  include '../Negocio/usuarios/nUsuario.php';
  require_once '../Negocio/funciones.php';
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['usuario']);
    $password = trim($_POST['contrasena']);

    $campos = [
      'usuario' => [
        'valor' => $username,
        'validaciones' => validaciones_predefinidas(ValidacionTipo::USUARIO)
      ],
      'contrasena' => [
        'valor' => $password,
        'validaciones' => validaciones_predefinidas(ValidacionTipo::OBLIGATORIO, 'contraseña')
      ]
    ];

    $errores = validar_campos($campos);

    if (empty($errores)) {
      $usu = new nUsuario(0, '', '', '', $username, '');
      $usuario = $usu->obtener_usuario();
      
      if ($usuario) {
        $hash = $usuario['contrasena'];      
        if (password_verify($password, $hash)) {
          session_start();
          $_SESSION['id_usuario'] = $usuario['id_usuario'];
          $_SESSION['usuario'] = $usuario['usuario'];
          $_SESSION['nombre_completo'] = trim($usuario['nombres'].' '.$usuario['apellidos']);
          $resultado = ['status' => 'success', 'message' => 'Usuario autenticado correctamente'];
        } else {
          $resultado = ['status' => 'notification', 'message' => 'Contraseña incorrecta'];
        }
      } else {
        $resultado = ['status' => 'error', 'message' => ['usuario' => ['Usuario inválido']] ];
      }
    } else {
      $resultado = ['status' => 'error', 'message' => $errores];
    }

    echo json_encode($resultado);
    exit;
  }