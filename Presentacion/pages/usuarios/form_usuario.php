<?php
  require_once 'assets/utiles/config.php';
  require_once '../Negocio/acceso.php';  
  require_once '../Negocio/funciones.php';

  if (isset($id)) {   
    require_once '../Negocio/usuarios/nUsuario.php';
    $usu = new nUsuario($id);
    $usuario = $usu->obtener_usuario_por_id();

    $nombres = $usuario['nombres'];
    $apellidos = $usuario['apellidos'];
    $correo = $usuario['correo'];
    $usuario = $usuario['usuario'];
  }

  // incluimos el doctype y html
  include_once LAYOUT_PATH.'/main.php';
?>

<head>
  <?php
    include_archivo_con_variables(LAYOUT_PATH.'/meta.php', array('title' => 'Nuevo usuario'));
    require_once LAYOUT_PATH.'/css.php';
  ?>
</head>



<?php
  require_once 'assets/utiles/config.php';
  //require_once '../Negocio/nUsuario.php';
?>


<div class="layout-wrapper">
  <?php
    include 'componentes/topbar.php';
    include 'componentes/sidebar.php';
  ?>
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <?php
          include_archivo_con_variables(LAYOUT_PATH.'/page-title.php', [
            'pagetitle' => isset($id) ? 'Editar usuario': 'Nuevo usuario',
            'title' => isset($id) ? 'Editar usuario': 'Nuevo usuario'
          ]);
        ?>

        <div class="row mt-4">
          <div class="col">
            <div class="card">
              <div class="card-body p-4">

                <form id="form_usuario">
                  <div class="row">
                    <div class="col-lg-3 text-center mt-2">
                      <div class="d-inline-block mx-auto position-relative mb-4">
                        <img
                          src="../../assets/images/avatar.png"
                          class="img-thumbnail rounded-circle shadow"
                          alt="" width="120" height="120"
                        />
                        <div class="position-absolute bottom-0 end-0 p-0 rounded-circle avatar-xs">
                          <input type="file" id="input-file-avatar" class="d-none">
                          <label for="input-file-avatar" class="position-absolute bottom-0 end-0 avatar-xs">
                            <span class="rounded-circle bg-light text-body-secondary d-flex justify-content-center align-items-center w-100 h-100">
                              <span class="msr fs-6">photo_camera</span>
                            </span>
                          </label>
                        </div>
                      </div>
                      <!-- <h5><?= $_SESSION['nombre_completo'] ?></h5>
                      <p class="text-muted">administrador</p> -->
                    </div>

                    <input type="hidden" name="id_usuario" value="<?= $id ?? '' ?>">

                    <div class="col-lg-5">
                      <div class="mb-3">
                        <label for="nombre" class="form-label">Nombres</label>
                        <input type="text" autofocus class="form-control" id="nombres" name="nombres"
                          value="<?= $nombres ?? '' ?>" required minlength="2">
                        <div class="text-danger" id="error-nombres"></div>
                      </div>

                      <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" autofocus
                          value="<?= $apellidos ?? '' ?>" required minlength="2">
                          <div class="text-danger" id="error-apellidos"></div>
                      </div>

                      <div class="mb-3">
                        <label for="correo" class="form-label">Correo electronico</label>
                        <input type="email" class="form-control" id="correo" name="correo"
                          value="<?= $correo ?? '' ?>" required minlength="2">
                        <div class="text-danger" id="error-correo"></div>
                      </div>
                    </div>
                    
                    <div class="col-xl-4">
                      <div class="mb-3">
                        <label for="usuario" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario"
                          value="<?= $usuario ?? '' ?>" required minlength="2">
                        <div class="text-danger" id="error-usuario"></div>
                      </div>

                      <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena"
                          minlength="8" <?= $id ?? 'required' ?>>
                        <div class="text-danger" id="error-contrasena"></div>
                      </div>
                    </div>

                    <div class="col-xl-12 mt-3">
                      <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn" name="cancelar" onclick="location.href='/usuarios'">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btn_submit">
                          <?= isset($id) ? 'Editar': 'Agregar' ?>
                        </button>
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
<script src="<?= ASSETS_URL ?>/js/pages/usuarios.js"></script>
<?php include LAYOUT_PATH.'/footer.php' ?>