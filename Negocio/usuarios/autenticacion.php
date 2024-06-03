<?php
  include '../Negocio/usuarios/nUsuario.php';
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['usuario']);
    $password = trim($_POST['contrasena']);
    $usu = new nUsuario(0, '', '', '', $username, '');
    $usuario = $usu->obtener_usuario();
    
    if ($usuario) {
      $hash = $usuario['contrasena'];      
      if (password_verify($password, $hash)) {
        session_start();
        $_SESSION['usuario'] = $usuario['usuario'];
        $_SESSION['nombre_completo'] = trim($usuario['nombres'].' '.$usuario['apellidos']);
        echo json_encode(['success' => 'Usuario autenticado correctamente']);
        exit;
      } 
    }
    echo json_encode(['errores' => ['usuario' => ['Usuario no encontrado']]]);
    exit;
  }