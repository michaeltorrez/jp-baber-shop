<?php

function validaciones_predefinidas($tipo) {
  $validaciones = [
    'usuario' => [
        ['tipo' => 'empty', 'mensaje' => 'El usuario es obligatorio'],
        ['tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El nombre de usuario debe tener al menos 2 caracteres'],
        ['tipo' => 'patron', 'patron' => '/^[a-zA-Z0-9_]{2,20}$/', 'mensaje' => 'El nombre de usuario debe tener entre 2 y 20 caracteres alfanuméricos o guiones bajos']
    ],
    'contrasena' => [
        ['tipo' => 'empty', 'mensaje' => 'La contraseña es obligatoria'],
        ['tipo' => 'longitud', 'min' => 8, 'mensaje' => 'La contraseña debe tener al menos 8 caracteres']
    ],
    'correo' => [
        ['tipo' => 'empty', 'mensaje' => 'El correo es obligatorio'],
        ['tipo' => 'filter', 'filtro' => FILTER_VALIDATE_EMAIL, 'mensaje' => 'El correo no es válido']
    ],
    // Agregar más validaciones predefinidas según sea necesario
  ];

  return $validaciones[$tipo] ?? [];
}


function validar_campos($campos) {
  $errores = [];

  foreach ($campos as $nombre_campo => $campo) {
    $valor = isset($campo['valor']) ? trim($campo['valor']) : '';

    if (isset($campo['validaciones']) && is_array($campo['validaciones'])) {
      foreach ($campo['validaciones'] as $validacion) {
        switch ($validacion['tipo']) {
          case 'empty':
            if (empty($valor)) {
              $errores[$nombre_campo][] = $validacion['mensaje'];
              break 2;
            }
            break;
          case 'longitud':
            if (isset($validacion['min']) && strlen($valor) < $validacion['min']) {
              $errores[$nombre_campo][] = $validacion['mensaje'];
              break 2;
            }
            break;
          case 'patron':
            if (isset($validacion['patron']) && !preg_match($validacion['patron'], $valor)) {
              $errores[$nombre_campo][] = $validacion['mensaje'];
            }
            break;
          case 'filter':
            if (isset($validacion['filtro']) && !filter_var($valor, $validacion['filtro'])) {
              $errores[$nombre_campo][] = $validacion['mensaje'];
            }
            break;
        }
      }
    }
  }

  return $errores;
}


function include_archivo_con_variables($filePath, $variables = array(), $print = true){
  $output = NULL;
  if(file_exists($filePath)){
    extract($variables);
    ob_start();
    include $filePath;
    $output = ob_get_clean();
  }
  if ($print) {
    print $output;
  }
  
  return $output;
}