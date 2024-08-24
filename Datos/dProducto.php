<?php
namespace Datos;

use Datos\dConexion;
require_once 'dConexion.php';

class dProducto {

  public function __construct(
    private $id_producto,
    private $id_categoria,
    private $nombre,
    private $descripcion,
    private $marca,
    private $precio,
    private $stock,
    private $imagen
  ) {}


  function listar_productos() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $respuesta = $con->query('CALL ListarProductos()');

      if ($respuesta) {
        $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
      }
      $con->close();
    } catch (\Exception $exc) {
      $exc->getTraceAsString();
    }

    return $resultado;
  }


  function agregar_producto() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $con->begin_transaction();
      $stmt = $con->prepare('CALL AgregarProducto(?,?,?,?,?,?,?, @id)');
      $stmt->bind_param('isssdis', $this->id_categoria, $this->nombre, $this->descripcion, $this->marca, $this->precio, $this->stock, $this->imagen);
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
      ['tipo' => 'i', 'valor' => $this->id_producto],
      ['tipo' => 's', 'valor' => $this->imagen]
    ];
    $resp = $this->ejecutarConsulta('CALL ActualizarImagen(?,?)', $parametros);
    return $resp;
  }


  function obtener_producto_por_id() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $consulta = 'CALL ObtenerProductoPorId(?)';
      $stmt = $con->prepare($consulta);
      $stmt->bind_param('i', $this->id_producto);
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


  function actualizar_producto(): bool {
    $parametros = [
      ['tipo' => 'i', 'valor' => $this->id_producto],
      ['tipo' => 's', 'valor' => $this->nombre],
      ['tipo' => 's', 'valor' => $this->descripcion],
      ['tipo' => 's', 'valor' => $this->marca],
      ['tipo' => 'i', 'valor' => $this->precio],
      ['tipo' => 'i', 'valor' => $this->stock]
    ];
    $resp = $this->ejecutarConsulta('CALL ActualizarProducto(?,?,?,?,?,?)', $parametros);
    return $resp;
  }


  function eliminar_producto() {
    $parametros = [['tipo' => 'i', 'valor' => $this->id_producto]];
    return $this->ejecutarConsulta('CALL EliminarProducto(?)', $parametros);
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