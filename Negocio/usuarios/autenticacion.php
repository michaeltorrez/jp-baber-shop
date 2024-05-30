<?php
  include '../Negocio/usuarios/nUsuario.php';
  
  session_start();
   
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['usuario']);
    $password = trim($_POST['contrasena']);
    $usu = new nUsuario(0, '', '', '', $username, '');
    $usuario = $usu->obtener_usuario();
    if ($usuario) {
      $hash = $usuario['contrasena'];      
      if (password_verify($password, $hash)) {
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['usuario'] = $usuario['usuario'];
        $_SESSION['nombre_completo'] = trim($usuario['nombres'].' '.$usuario['apellidos']);
        exit(header('Location: /'));
      }
    } else {
      exit(header('Location: /login'));
    }
  }


?>
