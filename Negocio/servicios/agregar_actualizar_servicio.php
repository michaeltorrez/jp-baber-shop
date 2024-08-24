<?php
require_once '../Negocio/funciones.php';
require_once '../Negocio/servicios/nServicio.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_servicio = isset($id) ? $id: null;
  $nombre = trim($_POST['nombre']);
  $descripcion = trim($_POST['descripcion']);
  $precio = trim($_POST['precio']);
  $image = 'sin_imagen.png';

  $campos = [
    'nombre' => [
      'valor' => $nombre,
      'validaciones' => [
        ['tipo' => 'empty', 'mensaje' => 'El campo nombre es obligatorio'],
        ['tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El nombre del producto debe tener al menos 2 caracteres'],
      ]
    ],
    'descripcion' => [
      'valor' => $descripcion,
      'validaciones' => [
        ['tipo' => 'empty', 'mensaje' => 'El campo descripción es obligatorio'],
        ['tipo' => 'longitud', 'min' => 10, 'mensaje' => 'La descripción del producto debe tener al menos 10 caracteres'],
      ]
    ],
    'precio' => [
      'valor' => $precio,
      'validaciones' => validaciones_predefinidas('precio', 'precio')
    ]
  ];

  $errores = validar_campos($campos);

  // verificamos que no hayan errores para recien crear el usuario
  if (empty($errores)) {
    if ($id_servicio) {
      // Si hay un id_servicio, actualizamos el servicio existente
      $pro = new nServicio($id_servicio, $nombre, $descripcion, $precio);
      $resultado = $pro->actualizar_servicio() ? ['status' => 'success'] : ['status' => 'error', 'message' => 'No se pudo actualizar el servicio'];
    } else {
      // Si no hay id_servicio, creamos un nuevo servicio
      $pro = new nServicio(0, $nombre, $descripcion, $precio, $image);
      $resultado_id = $pro->agregar_servicio();
      $resultado = $resultado_id ? ['status' => 'success', 'id' => $resultado_id] : ['status' => 'error', 'message' => 'No se pudo agregar el servicio'];
    }
   
  } else {
    $resultado = ['status' => 'errores', 'message' => $errores];
  }
  echo json_encode($resultado);
  exit;
  
}