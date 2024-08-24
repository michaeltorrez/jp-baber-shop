<?php

  //use Negocio\ventas\nVenta;
  include_once 'assets/utiles/config.php';
  include_once '../Negocio/acceso.php';
  include_once '../Negocio/funciones.php';
  // include_once '../Negocio/ventas/nVenta.php';

  
  
  // incluimos el doctype y html
  include_once LAYOUT_PATH.'/main.php';
?>

<head>
  <?php
    include_archivo_con_variables(LAYOUT_PATH.'/meta.php', array('title' => 'Usuarios'));
    include LAYOUT_PATH.'/css.php';
    ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/dataTables.bootstrap5.css">
</head>

<body>

  <div class="layout-wrapper">
    <?php
      include 'componentes/topbar.php';
      include 'componentes/sidebar.php';
    ?>
    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">
          <?php
            include_archivo_con_variables('componentes/breadcrumb.php', array('pagetitle' => 'Ventas', 'title' => 'Lista'));
          ?>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row justify-content-between">
                    <div class="col-md-6">
                      <a class="btn btn-primary" href="ventas/nueva" role="button">
                        + Nueva venta
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
                            <th class="text-center">#</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Monto</th>
                            <th class="text-center">Acciones</th>
                          </tr>
                        </thead>
      
                        <tbody>
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

</body>

<script src="<?= ASSETS_URL ?>/js/ajax/ventas1.js"></script>
<script src="<?= ASSETS_URL ?>/js/plugins/popper.js"></script>

<?php include LAYOUT_PATH.'/footer.php' ?>