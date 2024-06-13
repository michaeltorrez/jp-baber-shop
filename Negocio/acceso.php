<?php
  session_start();
  
  if (!isset($_SESSION['usuario'])) {
    header('Location: /login');
    exit;
  }

  $inactivo = 900; // 15 minutos de inactividad
  if (isset($_SESSION['timeout'])) {
    $vida_de_sesion = time() - $_SESSION['timeout'];
    if ($vida_de_sesion > $inactivo) {
      session_unset();// borramos el contenido de la sesion
      session_destroy();//destruimos la sesion
      header("Location: /login");// redirigimos a login
      exit;
    }
  }
  
  $_SESSION['timeout'] = time();