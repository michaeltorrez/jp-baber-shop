<?php

use Datos\dConexion;
require_once 'dConexion.php';

class dUsuario {
  //Constructor Property Promotion
  public function __construct(
    private $id_usuario,
    private $nombres,
    private $apellidos,
    private $correo,
    private $usuario,
    private $contrasena
  ) {}


  function crear_usuario() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $con->begin_transaction();
      $consulta = 'CALL CrearUsuario(?,?,?,?,?)';
      $stmt = $con->prepare($consulta);
      $stmt->bind_param('sssss', $this->nombres, $this->apellidos, $this->correo, $this->usuario, $this->contrasena);
      $respuesta = $stmt->execute();
      $resultado = $respuesta ? $con->commit() : $con->rollback();
      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
      $exc->getTraceAsString();
    }
    return $resultado;
  }

  function eliminar_usuario() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $con->begin_transaction();
      $consulta = 'CALL EliminarUsuario(?)';
      $stmt = $con->prepare($consulta);
      $stmt->bind_param('i', $this->id_usuario);
      $respuesta = $stmt->execute();

      if (!$respuesta) {
        $con->rollback();
      } else {
        $con->commit();
        $resultado = true;
      }
      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
      echo $exc->getMessage();
    }
    return $resultado;
  }

  function obtener_usuario_por_id() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $consulta = 'CALL ObtenerUsuarioPorId(?)';
      $stmt = $con->prepare($consulta);
      $stmt->bind_param('i', $this->id_usuario);
      $respuesta = $stmt->execute();

      if ($respuesta) {
        $resultado = $stmt->get_result()->fetch_assoc();
      }
      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
      $exc->getTraceAsString();
    }

    return $resultado;
  }


  function listar_usuarios() {
    return $this->listar('CALL ListarUsuarios()');
  }

  function listar_usuarios_2() {
    return $this->listar('CALL ListarUsuarios2()');
  }

  private function listar($consulta) {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $respuesta = $con->query($consulta);

      if ($respuesta) {
        $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
      }
      $con->close();
    } catch (Exception $exc) {
      $exc->getTraceAsString();
    }

    return $resultado;
  }


  function actualizar_usuario() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $con->begin_transaction();
      //Verificamos si la contraseña no es null
      if ($this->contrasena !== null) {
        $consulta = 'CALL ActualizarUsuario(?,?,?,?,?,?)';
        $stmt = $con->prepare($consulta);
        $stmt->bind_param('isssss', $this->id_usuario, $this->nombres, $this->apellidos, $this->correo, $this->usuario, $this->contrasena);
      } else { //si es null usamos el procedimiento para actualizar menos la contraseña
        $consulta = 'CALL ActualizarUsuarioSinContrasena(?,?,?,?,?)';
        $stmt = $con->prepare($consulta);
        $stmt->bind_param('issss', $this->id_usuario, $this->nombres, $this->apellidos, $this->correo, $this->usuario);
      }
      $respuesta = $stmt->execute();

      if ($respuesta) {
        $con->commit();
        $resultado = true;
      } else {
        $con->rollback();
      }
      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
      echo $exc->getMessage();
    }
    return $resultado;
  }

  function consulta_listar($consulta) {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      //$consulta = 'CALL ListarUsuarios()';
      $respuesta = $con->query($consulta);

      if ($respuesta) {
        $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
      }
      $con->close();
    } catch (Exception $exc) {
      $exc->getTraceAsString();
    }

    return $resultado;
  }


  function consultar_uno($consulta, $valor_buscado, $type) {
    $conect = new dConexion();
    $resultado = null;

    try {
      $con = $conect->Conectar();
      $stmt = $con->prepare($consulta);
      $stmt->bind_param($type, $valor_buscado);
      $respuesta = $stmt->execute();

      if ($respuesta) {
        $resultado = $stmt->get_result()->fetch_assoc();
      }
      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
      $exc->getTraceAsString();
    }

    return $resultado;
  }


  function obtener_usuario() {
    $conexion = new dConexion();
    $resultado = false;

    try {
      $con = $conexion->Conectar();
      $stmt = $con->prepare('CALL ObtenerUsuario(?)');
      $parametro = $con->real_escape_string($this->usuario);
      $stmt->bind_param('s', $parametro);
      $respuesta = $stmt->execute();
      $respuesta = $stmt->get_result();

      if ($respuesta->num_rows > 0) {
        $resultado = $respuesta->fetch_assoc();
      } /*elseif ($respuesta->num_rows > 1) {
        $resultado = $respuesta->fetch_array();
      }*/
      
      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
        $exc->getTraceAsString();
    }
    
    return $resultado;
  }

}