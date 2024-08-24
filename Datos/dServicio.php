<?php
namespace Datos;

use Datos\dConexion;
require_once 'dConexion.php';

class dServicio {
  private $conexion;

  public function __construct(
    private $id_servicio,
    private $nombre,
    private $descripcion,
    private $precio,
    private $imagen
  ) {
    $this->conexion = new dConexion();
  }


  function listar_servicios() {
    return $this->conexion->listar_simple('CALL ListarServicios()');
  }


  function agregar_servicio() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $con->begin_transaction();
      $stmt = $con->prepare('CALL AgregarServicio(?,?,?,?, @id)');
      $stmt->bind_param('ssds', $this->nombre, $this->descripcion, $this->precio, $this->imagen);
      $respuesta = $stmt->execute();

      if ($respuesta) {
        $con->commit();
        $resultado = $con->query('SELECT @id as id')->fetch_assoc();
      } else {
        $con->rollback();
      }
      $stmt->close();
      $con->close();
    } catch (\Exception $exc) {
      $exc->getTraceAsString();
    }
    return $resultado;
  }


  function actualizar_imagen(): bool {
    $parametros = [
      ['tipo' => 'i', 'valor' => $this->id_servicio],
      ['tipo' => 's', 'valor' => $this->imagen]
    ];
    $resp = $this->ejecutarConsulta('CALL ActualizarImagen(?,?)', $parametros);
    return $resp;
  }


  function obtener_servicio_por_id() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $consulta = 'CALL ObtenerServicioPorId(?)';
      $stmt = $con->prepare($consulta);
      $stmt->bind_param('i', $this->id_servicio);
      $respuesta = $stmt->execute();

      if ($respuesta) {
        $resultado = $stmt->get_result()->fetch_assoc();
      }
      $stmt->close();
      $con->close();
    } catch (\Exception $exc) {
      $exc->getTraceAsString();
    }

    return $resultado;
  }


  function actualizar_servicio(): bool {
    $parametros = [
      ['tipo' => 'i', 'valor' => $this->id_servicio],
      ['tipo' => 's', 'valor' => $this->nombre],
      ['tipo' => 's', 'valor' => $this->descripcion],
      ['tipo' => 'd', 'valor' => $this->precio],
    ];
    $resp = $this->ejecutarConsulta('CALL ActualizarServicio(?,?,?,?)', $parametros);
    return $resp;
  }


  function eliminar_servicio() {
    $parametros = [['tipo' => 'i', 'valor' => $this->id_servicio]];
    return $this->ejecutarConsulta('CALL EliminarServicio(?)', $parametros);
  }


  function ejecutarConsulta(string $consulta, array $parametros = []) {
    $conexion = new dConexion();
    $resultado = false;

    try {
        $con = $conexion->Conectar();
        $con->begin_transaction();
        $stmt = $con->prepare($consulta);
        
        if (!empty($parametros)) {
            $tipos = '';
            $valores = [];
            foreach ($parametros as $parametro) {
                $tipos .= $parametro['tipo'];
                $valores[] = $parametro['valor'];
            }
            $stmt->bind_param($tipos, ...$valores);
        }

        $respuesta = $stmt->execute();
        $resultado = $respuesta ? $con->commit() : $con->rollback();
        $stmt->close();
        $con->close();
    } catch (\Exception $exc) {
        $exc->getTraceAsString();
    }
    
    return $resultado;
  }

}