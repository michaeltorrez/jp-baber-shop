<?php
require_once '../Negocio/Router.php';

$rutas = new Router();

$rutas->get('/', function() {
  include 'paginas/inicio.php';
});

// -------------------- USUARIOS --------------------
$rutas->get('usuarios/', function() {
  include 'paginas/usuarios/administrar_usuarios.php';
});

$rutas->get('usuarios/nuevo', function() {
  include 'paginas/usuarios/form_usuario.php';
});

$rutas->post('usuarios/nuevo', function() {
  include '../Negocio/usuarios/agregar_usuario.php';
});

$rutas->get('usuarios/editar/:id', function($id) {
  include 'paginas/usuarios/form_usuario.php';
});

$rutas->post('usuarios/editar/:id', function($id) {
  include '../Negocio/usuarios/editar_usuario.php';
});

$rutas->post('usuarios/eliminar', function() {
  include '../Negocio/usuarios/eliminar_usuario.php';
});

// ---------------------- ROLES ----------------------
$rutas->get('roles/', function() {
  include 'paginas/roles/administrar_roles.php';
});

$rutas->get('roles/nuevo', function() {
  include 'paginas/roles/form_rol.php';
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
$rutas->get('usuario-rol/', function() {
  include 'paginas/usuario-rol/administrar_usuario-rol.php';
});

$rutas->get('usuario-rol/asignar', function() {
  include 'paginas/usuario-rol/asignar_usuario-rol.php';
});

$rutas->post('usuario-rol/asignar', function() {
  include '../Negocio/usuario-rol/asignar_rol.php';
});

$rutas->post('usuario-rol/roles-disponibles/:id', function($id) {
  include '../Negocio/usuario-rol/cargar_roles.php';
});

$rutas->post('usuario-rol/eliminar', function() {
  include '../Negocio/usuario-rol/eliminar_asignacion.php';
});
// -----------------------------------------------------


// --------------------- SERVICIOS ---------------------
$rutas->get('servicios', function() {
  include 'paginas/servicios/administrar_servicios.php';
});


// -----------------------------------------------------


// ---------------------- CATALOGO ----------------------
$rutas->get('catalogo', function() {
  include 'paginas/catalogo/administrar_catalogo.php';
});


// -----------------------------------------------------


// --------------------- PRODUCTOS ---------------------
$rutas->get('productos', function() {
  include 'paginas/productos/administrar_productos.php';
});


// -----------------------------------------------------



// ---------------------- CLIENTES ----------------------
$rutas->get('clientes', function() {
  include 'paginas/clientes/administrar_clientes.php';
});


// -----------------------------------------------------

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