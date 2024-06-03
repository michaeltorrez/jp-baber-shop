<?php
  session_start();
  
  if (!isset($_SESSION['usuario'])) {
    header('Location: /login');
    exit;
  }

  $inactive = 900; // 15 minutos de inactividad
  if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
      session_unset();// borramos el contenido de la sesion
      session_destroy();//destruimos la sesion
      header("Location: /login");// redirigimos a login
      exit;
    }
  }
  $_SESSION['timeout'] = time();