<?php
  require_once '../Negocio/funciones.php';
  require_once '../Negocio/clientes/nCliente.php';

  function validar_y_sanitizar_datos($data) {
    return [
      'id_cliente' => $data['id_cliente'],
      'nombres' => trim($data['nombres']),
      'apellidos' => trim($data['apellidos']),
      'correo' => trim($data['correo']),
      'direccion' => trim($data['direccion']),
      'telefono' => trim($data['telefono'])
    ];
  }

  function definir_validaciones($datos) {
    return [
      'nombres' => [
        'valor' => $datos['nombres'],
        'validaciones' => [
          ['tipo' => 'empty', 'mensaje' => 'El campo nombres es obligatorio'],
          ['tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El nombre del cliente debe tener al menos 2 caracteres']
        ]
      ],
      'descripcion' => [
        'valor' => $datos['apellidos'],
        'validaciones' => [
          ['tipo' => 'empty', 'mensaje' => 'El campo apellidos es obligatorio'],
          ['tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El apellido del cliente debe tener al menos 2 caracteres']
        ]
      ],
      'correo' => [
        'valor' => $datos['correo'],
        'validaciones' => validaciones_predefinidas(ValidacionTipo::CORREO)
      ],
      'telefono' => [
        'valor' => $datos['telefono'],
        'validaciones' => [
          ['tipo' => 'empty', 'mensaje' => 'El campo teléfono es obligatorio'],
        ]
      ]
    ];
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
  
    if (!empty($id)) {
      $cliente = new nCliente($datos['id_cliente'], $datos['nombres'], $datos['apellidos'], $datos['correo'], $datos['direccion'], $datos['telefono']);
      $resultado = $cliente->editar_cliente();
      $response_message = 'Datos del cliente editado correctamente';
    } else {
      $cliente = new nCliente(0, $datos['nombres'], $datos['apellidos'], $datos['correo'], $datos['direccion'], $datos['telefono']);
      $resultado = $cliente->agregar_cliente();
      $response_message = 'Cliente agregado correctamente';
    }

    if ($resultado) {
      responder_json(['status' => 'success', 'message' => $response_message]);
    } else {
      responder_json(['status' => 'errores', 'message' => 'Error al crear/actualizar el producto']);
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtén el término de búsqueda desde el query string
   $searchTerm = $_GET['q'] ?? ''; // Si no existe, usar cadena vacía

   // Conectar con tu base de datos o lógica de búsqueda
   $clientes = dCliente::obtener_clientes();

   // Filtrar los resultados basados en el término de búsqueda
   $filteredClientes = array_filter($clientes, function($cliente) use ($searchTerm) {
      return stripos($cliente['nombres'], $searchTerm) !== false;
   });

   // Devolver los resultados como JSON
   echo json_encode(array_values($filteredClientes));
  }