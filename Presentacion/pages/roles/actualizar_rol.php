<?php
  require_once '../../../config.php';
  require_once '../../layout/main.php';
  require_once '../../../Negocio/nRol.php';
  require_once 'validaciones.php';


  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $rol = new nRol($id);
    $roles = $rol->obtener_rol();

    $descripcion = $roles['descripcion'];
  }
?>
<head>
  <?php
    include_archivo_con_variables('../../layout/meta.php', array('title' => 'Actualizar rol'));
    require_once '../../layout/css.php';
  ?>
</head>



<div class="layout-wrapper">
  <?php
    include '../../componentes/topbar.php';
    include '../../componentes/sidebar.php';
  ?>
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <?php
          include_archivo_con_variables('../../layout/page-title.php', array('pagetitle' => 'Actualizar rol', 'title' => 'Actualizar rol'));

          if (isset($_POST['actualizar'])) {
            $id = $_POST['id'];
            $descripcion = trim($_POST['descripcion']);
            
            $errores = validar_form_roles($descripcion);
            if (empty($errores)) {
              $rol = new nRol($id, $descripcion);
              if ($rol->actualizar_rol()) {
                echo '<script>';
                echo 'Swal.fire({
                  title: "¡Éxito!",
                  text: "El rol se actualizó correctamente.",
                  icon: "success",
                  confirmButtonText: "Ok"
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = "administrarRoles.php"
                  }
                })';
                echo '</script>';
              }
            }
          }
        ?>
        <div class="row mt-4">
          <div class="col-xl-9">
            <div class="card">
              <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                  <?php if (!empty($errores)) : ?>
                    <div class="alert alert-danger" role="alert">
                      <ul>
                        <?php foreach ($errores as $tipoError => $mensajeError) : ?>
                          <li><?= $mensajeError ?></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  <?php endif; ?>

                  <input type="hidden" name="id" value="<?= $id ?? '' ?>">

                  <div class="row">
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion"
                          autofocus required minlength="5" placeholder="Introduzca descripción para el rol"
                          value="<?= $descripcion ?? '' ?>">
                      </div>
                    </div>
                    
                    <div class="col-xl-12">
                      <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary" name="actualizar">Actualizar</button>
                        <button type="button" class="btn btn-secondary"  name="cancelar" onclick="location.href='administrar_roles.php'">Cancelar</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include '../../layout/footer.php' ?>