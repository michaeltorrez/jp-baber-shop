<?php
namespace Negocio\ventas;

use Datos\dVenta;
include '../Datos/dVenta.php';


class nVenta {
  private $venta;

  public function __construct($id_venta=0, $id_usuario=0, $id_cliente=0, $total_venta=0)
  {
    $this->venta = new dVenta($id_venta, $id_usuario, $id_cliente, $total_venta);
  }

  public function getVenta() {
    return $this->venta;
  }

  public function setVenta($venta) {
    $this->venta = $venta;
  }


  function agregar_venta($detalle) {
    return $this->venta->agregar_venta($detalle);
  }


  function listar_ventas() {
    return $this->venta->listar_ventas();
  }


}