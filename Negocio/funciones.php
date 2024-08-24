<?php

enum ValidacionTipo: string {
  case USUARIO = 'usuario';
  case CONTRASENA = 'contrasena';
  case CORREO = 'correo';
  case TEXTO = 'texto';
  case CANTIDAD = 'cantidad';
  case PRECIO = 'precio';
  case OBLIGATORIO = 'obligatorio';
}

function validaciones_predefinidas(ValidacionTipo $tipo, $nombre_campo = null) {
  $validaciones = [
    ValidacionTipo::OBLIGATORIO->value => [
      ['tipo' => 'empty', 'mensaje' => (isset($nombre_campo) ? 'El campo '. $nombre_campo : 'Este campo') .' es obligatorio']
    ],
    ValidacionTipo::USUARIO->value => [
      ['tipo' => 'empty', 'mensaje' => 'El usuario es obligatorio'],
      ['tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El nombre de usuario debe tener al menos 2 caracteres'],
      ['tipo' => 'patron', 'patron' => '/^[a-zA-Z0-9_]{2,20}$/', 'mensaje' => 'El nombre de usuario debe tener entre 2 y 20 caracteres alfanuméricos o guiones bajos']
    ],
    'contrasena' => [
      ['tipo' => 'empty', 'mensaje' => 'La contraseña es obligatoria'],
      ['tipo' => 'longitud', 'min' => 8, 'mensaje' => 'La contraseña debe tener al menos 8 caracteres']
    ],
    ValidacionTipo::CORREO->value => [
      ['tipo' => 'empty', 'mensaje' => 'El correo es obligatorio'],
      ['tipo' => 'filter', 'filtro' => FILTER_VALIDATE_EMAIL, 'mensaje' => 'El correo no es válido']
    ],
    'texto' => [
      ['tipo' => 'empty', 'mensaje' => (isset($nombre_campo) ? 'El campo '. $nombre_campo : 'Este campo') .' es obligatorio'],
      ['tipo' => 'longitud', 'min' => 1, 'max' => 255, 'mensaje' => 'La longitud del texto debe ser entre 1 y 255 caracteres']
    ],
    'cantidad' => [
      ['tipo' => 'empty', 'mensaje' => 'La cantidad es obligatoria'],
      ['tipo' => 'numero', 'mensaje' => 'La cantidad debe ser un número entero'],
      ['tipo' => 'positivo', 'mensaje' => 'La cantidad debe ser un número positivo']
    ],
    'precio' => [
      ['tipo' => 'empty', 'mensaje' => 'El precio es obligatorio'],
      ['tipo' => 'decimal', 'mensaje' => 'El precio debe ser un número decimal'],
      ['tipo' => 'positivo', 'mensaje' => 'El precio debe ser un número positivo']
    ],
    // Agregar más validaciones predefinidas según sea necesario
  ];

  return $validaciones[$tipo->value] ?? [];
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
          case 'numero':
            if (!filter_var($valor, FILTER_VALIDATE_INT)) {
              $errores[$nombre_campo][] = $validacion['mensaje'];
              break 2;
            }
            break;
          case 'decimal':
            if (!filter_var($valor, FILTER_VALIDATE_FLOAT)) {
              $errores[$nombre_campo][] = $validacion['mensaje'];
              break 2;
            }
            break;
          case 'positivo':
            if ($valor <= 0) {
              $errores[$nombre_campo][] = $validacion['mensaje'];
              break 2;
            }
            break;
          // Agregar más casos de validación según sea necesario
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