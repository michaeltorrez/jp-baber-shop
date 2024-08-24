<?php
  include_once 'assets/utiles/config.php';
  include_once '../Negocio/acceso.php';
  include_once '../Negocio/funciones.php';
  include_once '../Negocio/productos/nProducto.php';

  function listar_productos() {
    $pro = new nProducto();
    return $pro->listar_productos();
  }
  
  $productos = listar_productos();

  // incluimos el doctype y html
  include_once LAYOUT_PATH.'/main.php';
?>

<head>
  <?php
    include_archivo_con_variables(LAYOUT_PATH.'/meta.php', array('title' => 'Productos'));
    include LAYOUT_PATH.'/css.php'
  ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/dataTables.bootstrap5.css">
</head>

<div class="layout-wrapper">
  <?php
    include 'componentes/topbar.php';
    include 'componentes/sidebar.php';
  ?>
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <?php
          include_archivo_con_variables('componentes/breadcrumb.php', array('pagetitle' => 'Productos'));
        ?>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-between">
                  <div class="col-md-6 mb-3">
                    <a class="btn btn-primary" href="productos/agregar" role="button">
                      + Agregar producto
                    </a>
                  </div>
                </div>
              </div>

              <div class="card-body">
                <div>
                  <div class="table-responsive table-card mb-1">
                    <table id="datatable" class="table table-hover align-middle">
                      <thead>
                        <tr class="table-active">
                          <th class="text-center">Producto</th>
                          <!-- <th class="text-center">Nombre</th> -->
                          <th class="text-center">Descripcion</th>
                          <th class="text-center">Marca</th>
                          <th class="text-center">Precio</th>
                          <th class="text-center">Stock</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
    
                      <tbody>
                        <?php
                          if ($productos) {
                            foreach($productos as $producto) : ?>
                              <tr>
                                <td class="text-left col-3">
                                  <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-secondary rounded">
                                      <img src="<?= $producto['imagen'] ? "/files/productos/".$producto['imagen']: null ?>" alt height="64" width="64">
                                    </div>
                                    <p class="ms-3 fw-semibold"><?= $producto['nombre'] ?></p>
                                  </div>
                                </td>
                                <!-- <td class="text-left col-2"><?= $producto['nombre'] ?></td> -->
                                <td class="text-left"><?= $producto['descripcion'] ?></td>
                                <td class="text-left col-3"><?= $producto['marca'] ?></td>
                                <td class="text-left col-1"><?= $producto['precio'] ?></td>
                                <td class="text-left col-1"><?= $producto['stock'] ?></td>
                                <td class="text-center col-1">
                                  <div class="d-flex justify-content-center">
                                    <a class="btn btn-sm" href="/productos/editar/<?= $producto['id_producto'] ?>" role="button">
                                      <span class="msr fs-5">edit</span>
                                    </a>

                                    <button class="btn btn-sm" onclick="eliminar_producto(<?= $producto['id_producto'] ?>)">
                                      <span class="msr fs-5">delete</span>
                                    </button>
                                  </div>
                                </td>
                              </tr>
                          <?php endforeach;}
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?= ASSETS_URL ?>/js/ajax/productos.js"></script>
<?php include LAYOUT_PATH.'/footer.php' ?>