<?php

require_once '../Negocio/funciones.php';

// function validar_form_usuario($nombre, $correo, $usuario, $contrasena) {
//   $campos = array(
//     'nombre' => array(
//       'valor' => $nombre,
//       'validaciones' => array(
//         array('tipo' => 'empty', 'mensaje' => 'El nombre es obligatorio'),
//         array('tipo' => 'longitud', 'min' => 2, 'mensaje' => 'El nombre debe tener al menos 2 caracteres'),
//         array('tipo' => 'patron', 'patron' => '/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s]{2,29}$/', 'mensaje' => 'Nombres y apellidos inválidos')
//       )
//     ),
//     'correo' => array(
//       'valor' => $correo,
//       'validaciones' => array(
//         array(
//           'tipo' => 'empty',
//           'mensaje' => 'El correo es obligatorio'
//         ),
//         array(
//           'tipo' => 'filter',
//           'filtro' => FILTER_VALIDATE_EMAIL,
//           'mensaje' => 'El correo no es válido'
//         )
//       )
//     ),
//     'usuario' => array(
//       'valor' => $usuario,
//       'validaciones' => array(
//         array('tipo' => 'empty', 'mensaje' => 'El usuario es obligatorio'),
//         array (
//           'tipo' => 'patron',
//           'patron' => '/^[a-zA-Z0-9_]{2,20}$/',
//           'mensaje' => 'El nombre de usuario debe tener entre 2 y 20 caracteres alfanuméricos o guiones bajos'
//         )
//       )
//     ),
//     'contrasena' => array(
//       'valor' => $contrasena,
//       'validaciones' => array(
//         array('tipo' => 'empty', 'mensaje' => 'La contraseña es obligatoria'),
//         array(
//           'tipo' => 'longitud',
//           'min' => 8,
//           'mensaje' => 'La contraseña debe tener al menos 8 caracteres'
//         )
//       )
//     )
//   );
//   return validar_campos($campos);
// }