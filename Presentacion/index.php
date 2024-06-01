<?php
require_once '../Negocio/Router.php';

$rutas = new Router();

$rutas->get('/', function() {
  include 'pages/inicio.php';
});

// -------------------- USUARIOS --------------------
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

$rutas->post('usuarios/eliminar/:id', function($id) {
  include '../Negocio/usuarios/eliminar_usuario.php';
});

// ---------------------- ROLES ----------------------
$rutas->get('roles', function() {
  include 'pages/roles/administrar_roles.php';
});

$rutas->get('roles/nuevo', function() {
  include 'pages/roles/form_rol.php';
});

$rutas->post('roles/nuevo', function() {
  include '../Negocio/roles/agregar_rol.php';
});

$rutas->post('roles/editar/:id', function($id) {
  include '../Negocio/roles/editar_rol.php';
});

$rutas->post('roles/eliminar/:id', function($id) {
  include '../Negocio/roles/eliminar_rol.php';
});
// ----------------------------------------------------


// -------------------- USUARIO-ROL --------------------
$rutas->get('usuario-rol', function() {
  include 'pages/usuario-rol/administrar_usuario-rol.php';
});

$rutas->get('usuario-rol/nuevo', function() {
  include 'pages/usuario-rol/asignar_usuario-rol.php';
});
// -----------------------------------------------------
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