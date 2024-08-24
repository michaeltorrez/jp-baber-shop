<?php
  include_once 'assets/utiles/config.php';
  include_once '../Negocio/acceso.php';
  include_once '../Negocio/funciones.php';
  include_once '../Negocio/ncliente.php';

  // incluimos el doctype y html
  include_once LAYOUT_PATH.'/main.php';
?>

<head>
  <?php
    include_archivo_con_variables(LAYOUT_PATH.'/meta.php', array('title' => 'Servicios'));
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
          include_archivo_con_variables('componentes/breadcrumb.php', array('pagetitle' => 'Clientes'));
        ?>

        <div class="row">
          <div class="col-12">
            <div class="card">
              
              <div class="card-header">
                <div class="row justify-content-between">
                  <div class="col-md-6">
                    <a class="btn btn-primary" href="clientes/agregar" role="button">
                      + Agregar cliente
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
                          <th class="text-center">Nombres</th>
                          <th class="text-center">Apellidos</th>
                          <th class="text-center">Correo</th>
                          <th class="text-center">Dirección</th>
                          <th class="text-center">Telefono</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
    
                      <tbody>
                        <?= nCliente::listar_clientes_tabla() ?>
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

<!-- Modal para Eliminar producto -->
<div class="modal fade zoomIn" id="EliminarClienteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="mt-2 text-center">
          <button type="button" class="btn-close" style="position: absolute; right: 0; top: 0; width: 2rem; height: 2rem;" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          <div class="mt-2 pt-2 fs-15 mx-4 mx-sm-5">
            <h4>Confirmar eliminación</h4>
            <p class="text-muted mx-4 mb-0">¿Estás seguro(a) de eliminar este cliente?</p>
          </div>
        </div>
        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
          <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn w-sm btn-danger" id="eliminar-cliente">Si, Eliminalo!</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= ASSETS_URL ?>/js/ajax/clientes.js"></script>
<?php include LAYOUT_PATH.'/footer.php' ?>