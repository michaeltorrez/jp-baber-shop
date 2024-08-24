<?php

  use Negocio\ventas\nVenta;
  use Negocio\productos\nProducto;
  use Negocio\servicios\nServicio;

  require_once '../Negocio/productos/nProducto.php';
  require_once '../Negocio/servicios/nServicio.php';
  require_once '../Negocio/ventas/nVenta.php';
  require_once '../Negocio/nDetalleVentaProducto.php';









  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = [];
    switch ($accion) {
      case 'listar':
        $venta = new nVenta();
        $result  = $venta->listar_ventas();

        break;
        
      case 'listarItems':
        $searchTerm = $_GET['q'] ?? '';
        print_r($searchTerm);
        $pro = new nProducto();
        $productos = $pro->listar_productos();
        $ser = new nServicio();
        $servicios = $ser->listar_servicios();

        $items = array_merge($productos, $servicios);

        $filteredProductos = array_filter($items, function($item) use ($searchTerm) {
          return stripos($item['nombre'], $searchTerm) !== false;
        });

        $result = [['nombre' => 'Productos', 'items' => array_values($filteredProductos)]];

        break;
      
      default:
        # code...
        break;
    }
  


    // Filtrar los resultados basados en el término de búsqueda
    // $filteredProductos = array_filter($productos, function($producto) use ($searchTerm) {
    //   return stripos($producto['nombre'], $searchTerm) !== false;
    // });

    // $filteredServicios = array_filter($servicios, function($servicio) use ($searchTerm) {
    //   return stripos($servicio['nombre'], $searchTerm) !== false;
    // });

    // $result = [
    //   ['nombre' => 'Productos', 'items' => array_values($filteredProductos)],
    //   ['nombre' => 'Servicios', 'items' => array_values($filteredServicios)]
    // ];

    // Devolver los resultados como JSON
    echo json_encode($result);
  }



  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resultado = [];

    switch ($accion) {
      case 'nueva':
        session_start();
        $id_usuario = $_SESSION['id_usuario'];
        $id_cliente = $_POST['id_cliente'];
        $total_venta = $_POST['total_venta'];
        $detalles = json_decode($_POST['detalles'], true);
    
        $venta = new nVenta(0, $id_usuario, $id_cliente, $total_venta);
        if ($venta->agregar_venta($detalles)) {
          $resultado = ['status' => 'success', 'message' => 'Venta registrada correctamente!'];
        } else {
          $resultado = ['status' => 'error', 'message' => 'Algo salio mal!'];
        }
        
        break;
      
      default:
        
        break;
    }

    echo json_encode($resultado);
  }