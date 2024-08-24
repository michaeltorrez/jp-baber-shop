<?php

use Datos\dConexion;
require_once 'dConexion.php';

class dCliente {
  private $conexion;

  public function __construct(
    private $id_cliente,
    private $nombres,
    private $apellidos,
    private $correo,
    private $direccion,
    private $telefono
  ) {
    $this->conexion = new dConexion();
  }


  
  function agregar_cliente() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $con->begin_transaction();
      $consulta = 'CALL AgregarCliente(?,?,?,?,?)';
      $stmt = $con->prepare($consulta);
      $stmt->bind_param('sssss', $this->nombres, $this->apellidos, $this->correo, $this->direccion, $this->telefono);
      $respuesta = $stmt->execute();
      $resultado = $respuesta ? $con->commit() : $con->rollback();
      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
      $exc->getTraceAsString();
    }
    return $resultado;
  }

  function eliminar_cliente() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $con->begin_transaction();
      $consulta = 'CALL EliminarCliente(?)';
      $stmt = $con->prepare($consulta);
      $stmt->bind_param('i', $this->id_cliente);
      $respuesta = $stmt->execute();

      if (!$respuesta) {
        // Error en la ejecución de la consulta
        $con->rollback();
      } else {
        if ($stmt->affected_rows > 0) {
          // Si se eliminó un registro
          $con->commit();
          $resultado = true;
        } else {
          // No se eliminó ningún registro (el cliente no existe o no pudo ser eliminado)
          $con->rollback();
        }
      }
      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
      echo $exc->getMessage();
    }
    return $resultado;
}

  function obtener_cliente_por_id() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $consulta = 'CALL ObtenerClientePorId(?)';
      $stmt = $con->prepare($consulta);
      $stmt->bind_param('i', $this->id_cliente);
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

  //Al no usar ni props, ni funciones de la misma clase, opte por hacerla estatica
  //asi poder usarla sin tener que instanciar para usar el metodo
  static function obtener_clientes() {
    $conexion = new dConexion();
    return $conexion->listar_simple('CALL ObtenerClientes()');
  }

  function listar_clientes() {
    return $this->conexion->listar_simple('CALL ObtenerClientes()');
  }
  


  function editar_cliente(): bool {
    $conexion = new dConexion();
    $parametros = [
      ['tipo' => 's', 'valor' => $this->nombres],
      ['tipo' => 's', 'valor' => $this->apellidos],
      ['tipo' => 's', 'valor' => $this->correo],
      ['tipo' => 's', 'valor' => $this->direccion],
      ['tipo' => 's', 'valor' => $this->telefono]
    ];
    return $conexion->consulta_con_parametros('CALL ActualizarRol(?,?)', $parametros);
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

}