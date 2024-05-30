<?php
  require_once 'assets/utiles/config.php';
  require_once '../Negocio/acceso.php';  
  require_once '../Negocio/funciones.php';

  header('Content-Type: application/json');

  if (isset($_GET['id'])) {   
      require_once '../Negocio/usuarios/nUsuario.php';  
      $usu = new nUsuario($_GET['id']);
      $usuario = $usu->obtener_usuario_por_id();

      if ($usuario) {
          echo json_encode($usuario);
      } else {
          http_response_code(404);
          echo json_encode(['error' => 'Usuario no encontrado']);
      }
  } else {
      http_response_code(400);
      echo json_encode(['error' => 'ID de usuario no especificado']);
  }
?>
