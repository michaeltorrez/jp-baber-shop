<?php
  include_once 'assets/utiles/config.php';
  include_once '../Negocio/acceso.php';
  include_once '../Negocio/usuarios/nUsuario.php';
  include_once '../Negocio/funciones.php';
  
  
  function listar_usuarios() {
    $usu = new nUsuario();
    return $usu->listar_usuarios();
  }
  
  $usuarios = listar_usuarios();

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

<div class="layout-wrapper">
  <?php
    if (isset($_SESSION['mensaje'])) {
      echo "<script>
        Swal.fire({
            title: 'Éxito',
            text: '{$_SESSION['exito']}',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
      </script>";

      // Eliminar el mensaje de éxito de la sesión
      unset($_SESSION['mensaje']);
    }
    include 'componentes/topbar.php';
    include 'componentes/sidebar.php';
  ?>
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <?php
          include_archivo_con_variables('componentes/breadcrumb.php', array('pagetitle' => 'Usuarios', 'title' => 'Lista'));
        ?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-between">
                  <div class="col-md-6">
                    <a class="btn btn-primary" href="usuarios/agregar" role="button">
                      + Agregar usuario
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
                          <th class="text-center">Avatar</th>
                          <th class="text-center">Nombres</th>
                          <th class="text-center">Apellidos</th>
                          <th class="text-center">Correo</th>
                          <th class="text-center">Usuario</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
    
                      <tbody>
                      <?php
                        if ($usuarios) {
                          $nro = 1;
                          foreach($usuarios as $usuario) { ?>
                            <tr>
                              <td class="text-center col-1"><?= $nro ?></td>
                              <td class="text-center col-1">
                                <img
                                  src="<?= $usuario['avatar'] ?? ASSETS_URL.'/images/avatar.png' ?>"
                                  class="rounded-circle shadow"
                                  alt="" width="32" height="32"
                                />
                              </td>
                              <td class="text-left col-2"><?= $usuario['nombres'] ?></td>
                              <td class="text-left col-3"><?= $usuario['apellidos'] ?></td>
                              <td class="text-left col-3"><?= $usuario['correo'] ?></td>
                              <td class="text-left col-3"><?= $usuario['usuario'] ?></td>
                              <td class="col-2">
                                <div class="d-flex justify-content-center">
                                  <a class="btn btn-sm" href="/usuarios/editar/<?= $usuario['id_usuario'] ?>" role="button"
                                    data-bs-toggle="tooltip" data-bs-title="Editar">
                                    <span class="msr fs-5">edit</span>
                                  </a>
    
                                  <button class="btn btn-sm" onclick="eliminar_usuario(<?= $usuario['id_usuario'] ?>)"
                                    data-bs-toggle="tooltip" data-bs-title="Eliminar">
                                    <span class="msr fs-5">delete</span>
                                  </button>
                                </div>
                              </td>
                            </tr>
                      <?php
                            $nro = $nro + 1;
                          }
                        }
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


<script src="<?= ASSETS_URL ?>/js/ajax/usuarios.js"></script>
<script src="<?= ASSETS_URL ?>/js/plugins/popper.js"></script>

<?php include LAYOUT_PATH.'/footer.php' ?>