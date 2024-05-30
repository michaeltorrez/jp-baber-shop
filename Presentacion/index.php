<?php
require_once '../Negocio/Router.php';

$rutas = new Router();

$rutas->get('/', function() {
  include 'pages/inicio.php';
});

$rutas->get('usuarios', function() {
  include './pages/usuarios/administrar_usuarios.php';
});

$rutas->get('usuarios/nuevo', function() {
  include 'pages/usuarios/form_usuario.php';
});

$rutas->post('usuarios/nuevo', function() {
  include '../Negocio/usuarios/agregar_usuario.php';
});

$rutas->get('usuarios/editar/:id', function($id) {
  include 'pages/usuarios/form_usuario.php';
});

$rutas->post('usuarios/editar/:id', function($id) {
  include '../Negocio/usuarios/editar_usuario.php';
});

$rutas->get('login', function() {
  include 'pages/login.php';
});

$rutas->post('login', function() {
  include '../Negocio/usuarios/autenticacion.php';
});

$rutas->get('logout', function() {
  require_once '../Negocio/usuarios/cerrar_sesion.php';
});

$rutas->dispatch();