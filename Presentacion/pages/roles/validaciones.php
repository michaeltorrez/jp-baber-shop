<?php
require_once '../../assets/utiles/funciones.php';

function validar_form_roles($descripcion) {
  $campos = array(
    array(
      'valor' => $descripcion,
      'validaciones' => array(
        array('tipo' => 'empty', 'mensaje' => 'La descripción es obligatorio'),
        array('tipo' => 'longitud', 'min' => 5, 'mensaje' => 'La descripción debe tener al menos 5 caracteres'),
        array('tipo' => 'patron', 'patron' => '/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s]{5,29}$/', 'mensaje' => 'Descripción inválida')
      )
    )
  );

  return validar_campos2($campos);
}