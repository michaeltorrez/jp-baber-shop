<?php
  require_once '../../assets/utiles/config.php';
  require_once '../../layout/main.php';
  require_once '../../../Negocio/nAsignar.php';
  include_once '../../../Negocio/funciones.php';

  $usuarios = cargar_usuarios();
  $roles = cargar_roles();

  if (isset($_POST['agregar'])) {
    $id_usuario = (int)trim($_POST['id_usuario']);
    $id_rol = (int)trim($_POST['id_rol']);

    //$errores = validar_form_asignar($nombre, $correo, $usuario, $contrasena);

    // verificamos que no hayan errores para recien crear el usuario
    //if (empty($errores)) {
     $r = new nAsignar(0, $id_usuario, $id_rol, null);
      $resultado = $r->crear_asignacion();

      if ($resultado === true) {
        header('Location: asignar');
      } else {
        $errors = $resultado;
      }
    //}

  }
?>
<head>
  <?php
    include_archivo_con_variables('../../layout/meta.php', array('title' => 'Nueva asignacion'));
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
          include_archivo_con_variables('../../layout/page-title.php', array('pagetitle' => 'Nueva asignacion', 'title' => 'Nueva asignacion'));
        ?>

        <div class="row mt-4">
          <div class="col-xl-9">
            <div class="card">
              <div class="card-body">
                <form action="/asignar/nueva" method="post">
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
                        <label for="usuario" class="form-label">Usuario</label>
                          <select autofocus class="form-control" name="id_usuario" id="usuario" required>
                            <option value="0">Seleccione un usuario...</option>
                            <?php
                              foreach ($usuarios as $usuario) : ?>
                                <option value="<?= $usuario['id'] ?>"><?= $usuario['nombre_usuario'] ?></option>
                            <?php endforeach; ?>
                          </select>
                      </div>

                      <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                          <select class="form-control" name="id_rol" id="rol" required>
                            <option value="0">Seleccione un rol...</option>
                            <?php
                              foreach ($roles as $rol) : ?>
                                <option value="<?= $rol['id'] ?>"><?= $rol['descripcion'] ?></option>
                            <?php endforeach; ?>
                          </select>
                      </div>
                    </div>


                    <div class="col-xl-12">
                      <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary" name="agregar">Agregar</button>
                        <button type="button" class="btn btn-secondary"  name="cancelar" onclick="location.href='/asignar'">Cancelar</button>
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