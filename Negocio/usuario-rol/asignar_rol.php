<?php
  require_once '../Negocio/usuario-rol/nUsuarioRol.php';

  // preguntamos y se llamo al archivos desde  un metodo post
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // recuperamos los valores que trae post
    $id_usuario = $_POST['id_usuario']; // en este caso el id de usuario
    $id_rol = $_POST['id_rol']; // aqui el id de rol

    // instanciamos una variable de tipo nUsuarioRol para poder usar sus metodos
    $usurio_rol = new nUsuarioRol($id_usuario, $id_rol);
    // ejecutamos el metodo para asignar rol al usuario, el cual nos devuelve si tuvo o no exito

    if (!$usurio_rol->existe_asignacion()) {
      if ($usurio_rol->asignar_usuario_rol()) {
        // en caso de que todo haya salido bien devolvemos un json con el mensaje de exito
        echo json_encode(['success' => 'Rol asignado correctamente']);
      } else {
        echo json_encode(['success' => $usurio_rol ]);
      }
    } else {
      echo json_encode(['error' => 'asdasd' ]);
    }


  }