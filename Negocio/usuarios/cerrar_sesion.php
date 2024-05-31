<?php

  session_start();

  if (isset($_SESSION["usuario"])) {
    session_unset();
    session_destroy();
    exit(header("location: /login"));
  }