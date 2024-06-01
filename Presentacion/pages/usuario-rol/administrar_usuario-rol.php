<?php
  include_once 'assets/utiles/config.php';
  include_once '../Negocio/acceso.php';
  include_once '../Negocio/usuario-rol/nUsuarioRol.php';
  include_once '../Negocio/funciones.php';

  function listrar_asignaciones() {
    $asig = new nAsignar();
    return $asig->listar_asignaciones();
  }

  $asignaciones = listrar_asignaciones();
?>

<head>
<script>
        if ('scrollRestoration' in history) {
    history.scrollRestoration = 'auto';  // o 'manual'
}
    </script>
  <?php
    include_archivo_con_variables(LAYOUT_PATH.'/meta.php', array('title' => 'Asignar rol'));
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
          include_archivo_con_variables('../../layout/page-title.php', array('pagetitle' => 'Asignar usuario-rol', 'title' => 'Asignar usuario-rol'));
        ?>
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header py-3">
                <div class="row g-4 align-items-center">
                  <div class="col-sm">
                    <div>
                      <h5 class="card-title mb-0">Lista de asiganciones-rol</h5>
                    </div>
                  </div>
                  <div class="col-sm-auto">
                    <a class="btn btn-sm btn-primary" href="asignar/nueva" role="button">
                      <div class="d-flex align-items-center gap-1">
                        <span class="msr">add</span>
                        Asignar
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
                          <th class="text-center">Nombres y apellidos</th>
                          <th class="text-center">Rol</th>
                          <th class="text-center">Fecha de asignación</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
    
                      <tbody>
                      <?php
                        if ($asignaciones) {
                          $nro = 1;
                          foreach($asignaciones as $asignacion) : 
                            $fecha = $asignacion['fecha_asignacion'] ? new DateTime($asignacion['fecha_asignacion']): null;
                          ?>
                            <tr>
                              <td class="text-center col-1"><?= $nro ?></td>
                              <td class="text-left col-2"><?= $asignacion['nombre_usuario'] ?></td>
                              <td class="text-left col-3"><?= $asignacion['nombres_apellidos'] ?></td>
                              <td class="text-left col-2"><?= $asignacion['descripcion'] ?></td>
                              <td class="text-center col-2"><?= $fecha ? $fecha->format('d/m/Y H:i:s'): '' ?></td>
                              <td class="text-center col-2">
                                <div class="d-flex justify-content-center">
                                  <button class="btn btn-sm" onclick="eliminar_asignacion(<?= $asignacion['id'] ?>)">
                                    <span class="msr fs-5 text-danger">delete</span>
                                  </button>
                                </div>
                              </td>
                            </tr>
                      <?php
                            $nro = $nro + 1;
                          endforeach;
                        }
                      ?>
                      </tbody>
                    </table>


                    <!-- Modal de confirmación de eliminación -->
                    <div class="modal fade" id="confirmarEliminar" tabindex="-1" role="dialog" aria-labelledby="confirmarEliminarLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="confirmarEliminarLabel">Confirmar Eliminación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            ¿Estás seguro de que deseas eliminar este elemento?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
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
      </div>
    </div>
  </div>
</div>


<script src="<?= ASSETS_URL ?>/js/pages/asignar.js"></script>

<?php include LAYOUT_PATH.'/footer.php' ?>