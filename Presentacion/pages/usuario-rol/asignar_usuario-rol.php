<?php
  include_once 'assets/utiles/config.php';
  include_once '../Negocio/acceso.php';
  include_once '../Negocio/usuario-rol/funciones.php';
  include_once '../Negocio/funciones.php';

  $usuarios = listar_usuarios();
  $roles = [];//cargar_roles();

  /*if (isset($_POST['agregar'])) {
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

  }*/
?>
<head>
  <?php
    include_archivo_con_variables(LAYOUT_PATH.'/meta.php', array('title' => 'Nueva asignacion'));
    require_once LAYOUT_PATH.'/css.php';
  ?>
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
          include_archivo_con_variables(LAYOUT_PATH.'/page-title.php', array('pagetitle' => 'Nueva asignacion', 'title' => 'Nueva asignacion'));
        ?>

        <div class="row mt-4">
          <div class="col-xl-9">
            <div class="card">
              <div class="card-body">
                <form id="form-asignar">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                          <select autofocus class="form-control" name="id_usuario" id="select_usuario" required>
                            <option value="" disabled selected hidden></option>
                            <?php
                              foreach ($usuarios as $usuario) : ?>
                                <option value="<?= $usuario['id_usuario'] ?>"><?= $usuario['usuario'] ?></option>
                            <?php endforeach; ?>
                          </select>
                      </div>

                      <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                          <select class="form-control" name="id_rol" id="rol" required></select>
                      </div>
                    </div>


                    <div class="col-xl-12">
                      <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary" name="agregar">Agregar</button>
                        <button type="button" class="btn btn-light"  name="cancelar" onclick="location.href='/usuario-rol'">Cancelar</button>
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

<script src="<?= ASSETS_URL ?>/js/pages/usuario-rol.js"></script>

<?php include LAYOUT_PATH.'/footer.php' ?>