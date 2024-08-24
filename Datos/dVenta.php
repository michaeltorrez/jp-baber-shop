<?php
namespace Datos;

use Datos\dConexion;
require_once 'dConexion.php';


class dVenta {
  private $conexion;

  public function __construct(
    private $id_venta,
    private $id_usuario,
    private $id_cliente,
    private $total_venta,
  ) {
    $this->conexion = new dConexion();
  }
    
    
  function obtener_cantidad_ventas() {
    return $this->conexion->listar_simple('CALL ObtenerCantidadVentas()');
  }
    
    
  function agregar_venta($detalles) {
    $resultado = false;

    try {
      $con = $this->conexion->Conectar();
      /* Importantisimo colocar en false el autocommit para poder hacer la transacción
      y porder hacer rolback a todo si fallara */
      $con->autocommit(false);
      $con->begin_transaction();

      if ($this->registrar_venta($con)) {
        foreach ($detalles as $detalle) {
          if (!$this->agregar_detalle_venta($con, $detalle)) {
            throw new \Exception("Error al agregar detalles de la venta");
          }
        }
        $con->commit();
        $resultado = true;
      } else {
        $con->rollback();
      }
    } catch (\Exception $exc) {
      $con->rollback();
      $exc->getTraceAsString();
    } finally {
      $con->autocommit(true);
      $con->close();
    }

    return $resultado;
  }


  private function registrar_venta($con) {
    $stmt = $con->prepare('CALL RegistrarVenta(?,?,?,@id)');
    $stmt->bind_param('iid', $this->id_usuario, $this->id_cliente, $this->total_venta);
    $respuesta = $stmt->execute();

    if ($respuesta) {
      $result = $con->query('SELECT @id AS id_venta');
      $row = $result->fetch_assoc();
      $this->id_venta = $row['id_venta'];
    }
    $stmt->close();
    return $respuesta;
  }


  private function agregar_detalle_venta($con, $detalle) {
    /* Estraemos los valores del array asociativo $detalles en forma de variables
    Este array si o si trae los siguientes valores
    id_producto, cantidad, precio */
    extract($detalle);
    $subtotal = $cantidad * $precio;
    
    if (isset($id_producto)) {
      $stmt = $con->prepare('CALL AgregarDetalleVentaProducto(?,?,?,?)');
      $stmt->bind_param('iiid', $this->id_venta, $id_producto, $cantidad, $subtotal);
    } else {
      $stmt = $con->prepare('CALL AgregarDetalleVentaServicio(?,?,?,?)');
      $stmt->bind_param('iiid', $this->id_venta, $id_servicio, $cantidad, $subtotal);
    }
    $respuesta = $stmt->execute();
    $stmt->close();

    return $respuesta;
  }


  function listar_ventas() {
    return $this->conexion->listar_simple('CALL ListarVentas()');
  }

}