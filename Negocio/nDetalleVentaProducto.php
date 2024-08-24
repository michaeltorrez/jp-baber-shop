<?php
include '../Datos/dDetalleVentaProducto.php';


class nDetalleVentaProducto {
  private $detalle;

  public function __construct($id_detalle_venta_producto=0, $id_venta=0, $id_producto=0, $cantidad=0, $subtotal=0)
  {
    $this->detalle = new dDetalleVentaProducto($id_detalle_venta_producto, $id_venta, $id_producto, $cantidad, $subtotal);
  }

  public function getDetalle() {
    return $this->detalle;
  }

  public function setSubtotal($detalle) {
    $this->detalle = $detalle;
  }


  function agregar_detalle_producto($detalle) {
    extract($detalle);
    $this->detalle->setIdVenta($id_venta);
    $this->detalle->setIdProducto($id_producto);
    $this->detalle->setCantidad($cantidad);
    $this->detalle->setSubtotal($subtotal);
    return $this->detalle->agregar_detalle_producto();
  }


}