<?php
  include_once 'assets/utiles/config.php';
  include_once '../Negocio/acceso.php';
  include_once '../Negocio/funciones.php';
  include_once '../Negocio/servicios/nServicio.php';

  function listar_servicios() {
    $pro = new nServicio();
    return $pro->listar_servicios();
  }
  
  $servicios = listar_servicios();

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
          include_archivo_con_variables('componentes/breadcrumb.php', array('pagetitle' => 'Servicios'));
        ?>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-between">
                  <div class="col-md-6 mb-3">
                    <a class="btn btn-primary" href="servicios/agregar" role="button">
                      + Agregar servicio
                    </a>
                  </div>
                </div>
              </div>

              <div class="card-body">
                <div>
                  <div class="table-responsive table-card mb-1">
                    <table id="datatable" class="table table-hover align-middle">
                      <thead class="table-light text-muted">
                        <tr>
                          <th class="text-center">Servicio</th>
                          <!-- <th class="text-center">Nombre</th> -->
                          <th class="text-center">Descripcion</th>
                          <th class="text-center">Precio</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
    
                      <tbody>
                        <?php
                          if ($servicios) {
                            foreach($servicios as $servicio) : ?>
                              <tr>
                                <td class="text-left col-3">
                                  <div class="d-flex align-items-center">
                                    <?php if ($servicio['imagen'] === 'sin_imagen.png') : ?>
                                      <img class="rounded-3" src="/assets/images/<?= $servicio['imagen'] ?>" alt height="64" width="64">
                                    <?php else : ?>
                                      <img class="rounded-3" src="/uploads/<?= $servicio['imagen'] ?>" alt height="64" width="64">
                                    <?php endif; ?>
                                    <p class="ms-3 fw-semibold"><?= $servicio['nombre'] ?></p>
                                  </div>
                                </td>
                                <!-- <td class="text-left col-2"><?= $servicio['nombre'] ?></td> -->
                                <td class="text-left"><?= $servicio['descripcion'] ?></td>
                                <td class="text-left col-1"><?= $servicio['precio'] ?></td>
                                <td class="text-center col-1">
                                  <div class="d-flex justify-content-center">
                                    <a class="btn btn-sm" href="/servicios/editar/<?= $servicio['id_servicio'] ?>" role="button">
                                      <span class="msr fs-5">edit</span>
                                    </a>

                                    <button class="btn btn-sm" onclick="eliminar_servicio(<?= $servicio['id_servicio'] ?>)">
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

<script src="<?= ASSETS_URL ?>/js/ajax/servicios.js"></script>
<?php include LAYOUT_PATH.'/footer.php' ?>