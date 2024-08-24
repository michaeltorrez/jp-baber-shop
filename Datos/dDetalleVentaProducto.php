<?php
require_once 'dConexion.php';

class dDetalleVentaProducto {
  private $conexion;

  public function __construct(
    private $id_detalle_venta_producto,
    private $id_venta,
    private $id_producto,
    private $cantidad,
    private $subtotal
  ) {
    $this->conexion = new dConexion();
  }


  // Getters y Setters
  public function getIdDetalleVentaProducto() {
    return $this->id_detalle_venta_producto;
  }

  public function setIdDetalleVentaProducto($id_detalle_venta_producto) {
    $this->id_detalle_venta_producto = $id_detalle_venta_producto;
  }

  public function getIdVenta() {
    return $this->id_venta;
  }

  public function setIdVenta($id_venta) {
    $this->id_venta = $id_venta;
  }

  public function getIdProducto() {
    return $this->id_producto;
  }

  public function setIdProducto($id_producto) {
    $this->id_producto = $id_producto;
  }

  public function getCantidad() {
    return $this->cantidad;
  }

  public function setCantidad($cantidad) {
    $this->cantidad = $cantidad;
  }

  public function getSubtotal() {
    return $this->subtotal;
  }

  public function setSubtotal($subtotal) {
    $this->subtotal = $subtotal;
  }




  function agregar_detalle_producto() {
    $resultado = false;

    try {
      $con = $this->conexion->Conectar();
      $con->begin_transaction();
      $consulta = 'CALL AgregarDetalleProducto(?,?,?,?)';
      $stmt = $con->prepare($consulta);
      $stmt->bind_param('iiid', $this->id_venta, $this->id_producto, $this->cantidad, $this->subtotal);
      $respuesta = $stmt->execute();
      $resultado = $respuesta ? $con->commit() : $con->rollback();
      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
      $exc->getTraceAsString();
    }
    return $resultado;
  }


}