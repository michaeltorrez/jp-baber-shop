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

<div class="layout-wrapper">
  <?php
    include 'componentes/topbar.php';
    include 'componentes/sidebar.php';
  ?>
  <div class="main-content">
    <div class="page-content">
      <?php
        include_archivo_con_variables('componentes/breadcrumb.php', [
          'pagetitle' => isset($id) ? 'Editar usuario': 'Nuevo usuario',
          'title' => isset($id) ? 'Editar usuario': 'Nuevo usuario'
        ]);
      ?>
      <div class="container-fluid">
        <div class="row">
          <div class="col-xl-3 col-lg-4 col-md-12 col-12">
            <div class="mb-4 mb-lg-0">
              <h4 class="mb-1 fs-6">Configuración general</h4>
              <p class="mb-0 text-muted">Configuracion de perfil</p>
            </div>
          </div>
          <div class="col-xl-9 col-lg-8 col-md-12 col-12">
            <div class="card">
              <div class="card-body">
                <form id="form_usuario">
                  <input type="hidden" name="id_usuario" value="<?= $id ?? '' ?>">

                  <div class="row mb-3">
                    <label for="nombre" class="col-sm-4 col-form-label form-label">Nombre completo</label>
                    <div class="col-sm-4 mb-3 mb-lg-0">
                      <input type="text" autofocus class="form-control" placeholder="Nombres" id="nombres" name="nombres" value="<?= $nombres ?? '' ?>">
                      <div class="text-danger" id="error-nombres"></div>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" placeholder="Apellidos" id="apellidos" name="apellidos" value="<?= $apellidos ?? '' ?>">
                      <div class="text-danger" id="error-apellidos"></div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="correo" class="col-sm-4 col-form-label form-label">Correo electronico</label>
                    <div class="col-md-8 col-12">
                      <input type="email" class="form-control" placeholder="ejemplo@ejemplo.com" id="correo" name="correo" value="<?= $correo ?? '' ?>">
                      <div class="text-danger" id="error-correo"></div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="usuario" class="col-sm-4 col-form-label form-label">Usuario y contraseña</label>
                    <div class="col-sm-4 mb-3 mb-lg-0">
                      <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        <input type="text" class="form-control" placeholder="Usuario" id="usuario" name="usuario" value="<?= $usuario ?? '' ?>">
                      </div>
                      <div class="text-danger" id="error-usuario"></div>
                    </div>
                    <div class="col-sm-4">
                      <input type="password" class="form-control" placeholder="Contraseña" id="contrasena" name="contrasena" value="<?= $apellidos ?? '' ?>">
                      <div class="text-danger" id="error-contrasena"></div>
                    </div>
                  </div>

                  <div class="offset-md-4 col-md-8 col-12 mt-2 text-end">
                    <button type="button" class="btn btn-light me-1" name="cancelar" onclick="location.href='/usuarios'">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                      <?= isset($id) ? 'Editar': 'Agregar' ?>
                    </button>
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
<script src="<?= ASSETS_URL ?>/js/ajax/usuarios.js"></script>
<?php include LAYOUT_PATH.'/footer.php' ?>