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

$rutas->get('usuarios/agregar', function() {
  include 'paginas/usuarios/form_usuario.php';
});

$rutas->post('usuarios/agregar', function() {
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

$rutas->get('servicios/agregar', function() {
  include 'paginas/servicios/form_servicio.php';
});

$rutas->post('servicios/agregar', function() {
  include '../Negocio/servicios/agregar_actualizar_servicio.php';
});

$rutas->post('servicios/upload', function() {
  include '../Negocio/servicios/upload.php';
});

$rutas->get('servicios/editar/:id', function($id) {
  include 'paginas/servicios/form_servicio.php';
});

$rutas->post('servicios/editar/:id', function($id) {
  include '../Negocio/servicios/agregar_actualizar_servicio.php';
});

$rutas->post('servicios/eliminar', function() {
  include '../Negocio/servicios/eliminar_servicio.php';
});


// -----------------------------------------------------


// ---------------------- CATALOGO ----------------------
$rutas->get('catalogo', function() {
  include 'paginas/catalogo/administrar_catalogo.php';
});


// -----------------------------------------------------


// --------------------- PRODUCTOS ---------------------
$rutas->get('productos', function() {
  include 'paginas/productos_administrar.php';
});

$rutas->get('productos/agregar', function() {
  include 'paginas/productos_agregar_editar.php';
});

$rutas->post('productos/agregar', function() {
  include '../Negocio/productos/producto_agregar_editar.php';
});

$rutas->get('productos/editar/:id', function($id) {
  include 'paginas/productos_agregar_editar.php';
});

$rutas->post('productos/editar/:id', function($id) {
  include '../Negocio/productos/producto_agregar_editar.php';
});

$rutas->post('productos/eliminar', function() {
  include '../Negocio/productos/eliminar_producto.php';
});
// -----------------------------------------------------



// ---------------------- CLIENTES ----------------------
$rutas->get('clientes', function() {
  include 'paginas/clientes_administrar.php';
});

$rutas->get('clientes/agregar', function() {
  include 'paginas/clientes_agregar_editar.php';
});

$rutas->post('clientes/agregar', function() {
  include '../Negocio/clientes_agregar_editar.php';
});

$rutas->get('clientes/editar/:idCliente', function($id_cliente) {
  include 'paginas/clientes_agregar_editar.php';
});

$rutas->get('clientes/listar', function() {
  include '../Negocio/clientes/clientes_agregar_editar.php';
});

$rutas->get('clientes/:accion', function() {
  include '../Negocio/clientes/clientes.php';
});

$rutas->post('clientes/editar/:id', function($id_cliente) {
  include '../Negocio/clientes_agregar_editar.php';
});

$rutas->post('clientes/eliminar/:id', function($id_cliente) {
  include '../Negocio/clientes_eliminar.php';
});

// -----------------------------------------------------

// ---------------------- VENTAS ----------------------
$rutas->get('ventas', function() {
  include 'paginas/ventas/ventas.php';
});

$rutas->get('ventas/nueva', function() {
  include 'paginas/ventas/venta_nueva.php';
});

$rutas->get('ventas/:accion', function($accion) {
  include '../Negocio/ventas/ventas.php';
});

$rutas->post('ventas/:accion', function($accion) {
  include '../Negocio/ventas/ventas.php';
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