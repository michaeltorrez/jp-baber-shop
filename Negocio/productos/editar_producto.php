<?php
  require_once '../Negocio/funciones.php';
  require_once '../Negocio/productos/nProducto.php';


  if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($id)) {
    $id_producto = $id;
    $id_categoria = $_POST['id_categoria'];
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $marca = trim($_POST['marca']);
    $precio = trim($_POST['precio']);
    $stock = trim($_POST['stock']);

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
      'marca' => [
        'valor' => $marca,
        'validaciones' => [
          ['tipo' => 'empty', 'mensaje' => 'El campo marca es obligatorio'],
          ['tipo' => 'longitud', 'min' => 3, 'mensaje' => 'La marca del producto debe tener al menos 3 caracteres'],
        ]
      ],
      'stock' => [
        'valor' => $stock,
        'validaciones' => validaciones_predefinidas(ValidacionTipo::CANTIDAD, 'stock')
      ],
      'precio' => [
        'valor' => $precio,
        'validaciones' => validaciones_predefinidas(ValidacionTipo::PRECIO, 'precio')
      ],
      'id_categoria' => [
        'valor' => $id_categoria,
        'validaciones' => [
          ['tipo' => 'empty', 'mensaje' => 'La categoría es un campo obligatorio']
        ]
      ]
    ];
  
    $errores = validar_campos($campos);

    // verificamos que no hayan errores para recien crear el usuario
    if (empty($errores)) {
      $pro = new nProducto($id_producto, $id_categoria, $nombre, $descripcion, $marca, $precio, $stock);
      $resultado = $pro->actualizar_producto();
      
      if ($resultado === true) {
        echo json_encode(['status' => 'success']);
      } else {
        echo json_encode($resultado);
      }
    } else {
      echo json_encode(['errores' => $errores]);
    }
    exit;
  }