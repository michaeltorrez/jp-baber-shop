<?php
  session_start();
  
  if (!isset($_SESSION['id_usuario'])) {
    header('Location: /login');
    exit;
  }

  $inactive = 600; // 10 minutos de inactividad
  if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
      session_unset();
      session_destroy();
      header("Location: /login");
      exit;
    }
  }
  $_SESSION['timeout'] = time();

?>