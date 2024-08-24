<?php
require_once '../Negocio/funciones.php';
require_once '../Negocio/productos/nProducto.php';

function validar_y_sanitizar_datos($data) {
  return [
    'id_producto' => $data['id_producto'],
    'id_categoria' => $data['id_categoria'] ?? 0,
    'nombre' => trim($data['nombre']),
    'descripcion' => trim($data['descripcion']),
    'marca' => trim($data['marca']),
    'precio' => trim($data['precio']),
    'stock' => trim($data['stock'])
  ];
}

function definir_validaciones($datos) {
  return [
    'nombre' => [
      'valor' => $datos['nombre'],
      'validaciones' => [
        ['tipo' => 'empty', 'mensaje' => 'El campo nombre es obligatorio'],
        ['tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El nombre del producto debe tener al menos 2 caracteres']
      ]
    ],
    'descripcion' => [
      'valor' => $datos['descripcion'],
      'validaciones' => [
        ['tipo' => 'empty', 'mensaje' => 'El campo descripción es obligatorio'],
        ['tipo' => 'longitud', 'min' => 10, 'mensaje' => 'La descripción del producto debe tener al menos 10 caracteres']
      ]
    ],
    'marca' => [
      'valor' => $datos['marca'],
      'validaciones' => [
        ['tipo' => 'empty', 'mensaje' => 'El campo marca es obligatorio'],
        ['tipo' => 'longitud', 'min' => 3, 'mensaje' => 'La marca del producto debe tener al menos 3 caracteres']
      ]
    ],
    'stock' => [
      'valor' => $datos['stock'],
      'validaciones' => validaciones_predefinidas(ValidacionTipo::CANTIDAD, 'stock')
    ],
    'precio' => [
      'valor' => $datos['precio'],
      'validaciones' => validaciones_predefinidas(ValidacionTipo::PRECIO, 'precio')
    ],
    'id_categoria' => [
      'valor' => $datos['id_categoria'],
      'validaciones' => [
        ['tipo' => 'empty', 'mensaje' => 'La categoría es un campo obligatorio']
      ]
    ]
  ];
}


function manejar_subida_archivo($producto_id) {
  $uploadDir = 'files/productos/';
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }
  
  // Procesar la nueva imagen
  $file = $_FILES['file'];
  $extension_imagen = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  $filename = 'img_producto_' . $producto_id . '.' . $extension_imagen;
  $uploadFile = $uploadDir . $filename;
  
  // Obtener el nombre de la imagen anterior desde la base de datos
  $pro = new nProducto($producto_id, 0, '', '', '', 0, 0, $filename);
  $producto = $pro->obtener_producto_por_id();
  $imagen_anterior = $producto['imagen'];

  // Eliminar la imagen anterior si existe y es diferente a la nueva
  if ($imagen_anterior && $imagen_anterior !== $filename) {
    $ruta_imagen_anterior = $uploadDir . $imagen_anterior;
    if (file_exists($ruta_imagen_anterior)) {
      unlink($ruta_imagen_anterior);
    }
  }

  // Subir la nueva imagen
  if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
    $pro->actualizar_imagen(); // Actualizar la imagen en la base de datos
    return true;
  } else {
    return false;
  }
}


function responder_json($response) {
  echo json_encode($response);
  exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $datos = validar_y_sanitizar_datos($_POST);
  $campos = definir_validaciones($datos);
  $errores = validar_campos($campos);

  if (!empty($errores)) {
    responder_json(['status' => 'errores', 'message' => $errores]);
  }

  //$producto_id = $datos['id_producto'] ?? null;
  if (!empty($id)) {
    // Si el ID está presente, actualizar el producto
    $producto = new nProducto($datos['id_producto'], $datos['id_categoria'], $datos['nombre'], $datos['descripcion'], $datos['marca'], $datos['precio'], $datos['stock'], null);
    $resultado = $producto->actualizar_producto();
  } else {
    // Si no hay ID, crear un nuevo producto
    $producto = new nProducto(0, $datos['id_categoria'], $datos['nombre'], $datos['descripcion'], $datos['marca'], $datos['precio'], $datos['stock'], null);
    $resultado = $producto->agregar_producto();
  }

  if ($resultado) {
    $upload_response = !empty($_FILES['file']) ? manejar_subida_archivo($id ?? $resultado['id']) : true;
    $response_message = $upload_response ? 'Producto creado/actualizado correctamente' : 'Producto creado/actualizado, pero no se pudo subir la imagen';
    responder_json(['status' => 'success', 'message' => $response_message]);
  } else {
    responder_json(['status' => 'errores', 'message' => 'Error al crear/actualizar el producto']);
  }
}



if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  //responder_json()
}