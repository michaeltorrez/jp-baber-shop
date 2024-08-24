<?php
  require_once '../Negocio/funciones.php';
  require_once '../Negocio/productos/nProducto.php';


  if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($id)) {
    $id_servicio = trim($id);
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = trim($_POST['precio']);

    // $campos = [
    //   'nombres' => [
    //     'valor' => $nombres,
    //     'validaciones' => [
    //       ['tipo' => 'empty', 'mensaje' => 'El campo nombres es obligatorio'],
    //       ['tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El o los nombres debe tener al menos 2 caracteres'],
    //       ['tipo' => 'patron', 'patron' => '/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s]{2,29}$/', 'mensaje' => 'Nombre(s) inválido(s)']
    //     ]
    //   ],
    //   'apellidos' => [
    //     'valor' => $apellidos,
    //     'validaciones' => [
    //       ['tipo' => 'empty', 'mensaje' => 'El campo apellidos es obligatorio'],
    //       ['tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El o los apellidos debe tener al menos 2 caracteres'],
    //       ['tipo' => 'patron', 'patron' => '/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s]{2,29}$/', 'mensaje' => 'Apellidos inválidos']
    //     ]
    //   ],
    //   'correo' => [
    //     'valor' => $correo,
    //     'validaciones' => validaciones_predefinidas('correo'),
    //   ],
    //   'usuario' => [
    //     'valor' => $usuario,
    //     'validaciones' => validaciones_predefinidas('usuario'),
    //   ]
    // ];

    // if (!empty($contrasena)) {
    //   $campos['contrasena'] = [
    //     'valor' => $contrasena,
    //     'validaciones' => validaciones_predefinidas('contrasena'),
    //   ];
    // }
    
    // $errores = validar_campos($campos);
    $errores = '';

    // verificamos que no hayan errores para recien crear el usuario
    if (empty($errores)) {
      $pro = new nProducto($id_producto, $nombre, $descripcion, $marca, $precio, $stock);
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