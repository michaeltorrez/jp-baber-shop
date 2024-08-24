<?php
require_once '../Negocio/Router.php';

$rutas = new Router();

$rutas->get('/', function() {
  include 'paginas/inicio.php';
});


$rutas->get('ventas', function() {
  echo('pagina');
});

// $rutas->get('ventas/:accion', function($accion = null) {
//   echo('****'.$accion . ' ');
// });

$rutas->get('ventas/:accion/:id?', function($accion = null, $id = null) {
  echo('-----'.$accion . ' ' . $id);
});

// $rutas->post('ventas/:accion/:id?', function($accion = null, $id = null) {
//   echo($accion . ' ' . $id);
// });


$rutas->get('login', function() {
  include 'paginas/login.php';
});

$rutas->post('login', function() {
  include '../Negocio/usuarios/autenticacion.php';
});

$rutas->get('logout', function() {
  require_once '../Negocio/usuarios/cerrar_sesion.php';
});



$rutas->dispatch();