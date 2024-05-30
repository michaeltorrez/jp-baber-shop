<?php
  require_once '../../assets/utiles/config.php';
  require_once '../../layout/main.php';
  require_once '../../../Negocio/nRol.php';
  include_once 'validaciones.php';


  if (isset($_POST['agregar'])) {
    $descripcion = trim($_POST['descripcion']);

    //$errores = validar_form_usuario($nombre, $correo, $usuario, $contrasena);

    // verificamos que no hayan errores para recien crear el usuario
    //if (empty($errores)) {
      $r = new nRol(0, $descripcion);
      $resultado = $r->crear_rol();

      if ($resultado === true) {
        header('Location: administrarRoles.php');
      } else {
        $errors = $resultado;
      }
    //}

  }
?>
<head>
  <?php
    include_archivo_con_variables('../../layout/meta.php', array('title' => 'Nuevo rol'));
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
          include_archivo_con_variables('../../layout/page-title.php', array('pagetitle' => 'Nuevo rol', 'title' => 'Nuevo rol'));
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
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" autofocus class="form-control" id="descripcion" name="descripcion"
                          value="<?= $descripcion ?? '' ?>" placeholder="Introduzca nombre para el rol" required minlength="5">
                      </div>
                    </div>


                    <div class="col-xl-12">
                      <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-link"  name="cancelar" onclick="location.href='/roles'">Cancelar</button>
                        <button type="submit" class="btn btn-primary" name="agregar">Agregar</button>
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