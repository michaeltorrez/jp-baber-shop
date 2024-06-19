<?php
  include_once 'assets/utiles/config.php';
  include_once '../Negocio/acceso.php';
  include_once '../Negocio/funciones.php';

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
          include_archivo_con_variables(LAYOUT_PATH.'/page-title.php', array('pagetitle' => 'Servicios', 'title' => 'Productos'));
        ?>

        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header py-3">
                <div class="row g-4 align-items-center">
                  <div class="col-sm">
                    <div>
                      <h5 class="card-title mb-0">Lista de productos</h5>
                    </div>
                  </div>
                  <div class="col-sm-auto">
                    <a class="btn btn-sm btn-primary" href="usuario-rol/asignar" role="button">
                      <div class="d-flex align-items-center gap-1">
                        <span class="msr">add</span>
                        Agregar
                      </div>
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
                          <th class="text-center">#</th>
                          <th class="text-center">Usuario</th>
                          <th class="text-center">Nombre completo</th>
                          <th class="text-center">Rol</th>
                          <th class="text-center">Fecha de asignación</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
    
                      <tbody>
                      <?php
                        /*$asignaciones = listar_usuario_rol();
                        if ($asignaciones) {
                          $nro = 1;
                          foreach($asignaciones as $asignacion) : 
                            $fecha = $asignacion['fecha_asignacion'] ? new DateTime($asignacion['fecha_asignacion']): null;
                          ?>
                            <tr>
                              <td class="text-center col-1"><?= $nro ?></td>
                              <td class="text-left col-2"><?= $asignacion['usuario'] ?></td>
                              <td class="text-left col-3"><?= $asignacion['nombre_completo'] ?></td>
                              <td class="text-left col-2"><?= $asignacion['descripcion'] ?></td>
                              <td class="text-center col-2"><?= $fecha ? $fecha->format('d/m/Y H:i:s'): '' ?></td>
                              <td class="text-center col-2">
                                <div class="d-flex justify-content-center">
                                  <button class="btn btn-sm" onclick="eliminar_asignacion(<?= $asignacion['id_usuario_rol'] ?>)">
                                    <span class="msr fs-5">delete</span>
                                  </button>
                                </div>
                              </td>
                            </tr>
                      <?php
                            $nro = $nro + 1;
                          endforeach;
                        }
                      */ ?>
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

<?php include LAYOUT_PATH.'/footer.php' ?>