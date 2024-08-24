<?php
  require_once 'assets/utiles/config.php';
  require_once '../Negocio/funciones.php';
  require_once LAYOUT_PATH.'/main.php';
?>

<head>
  <?php
    include_archivo_con_variables(LAYOUT_PATH.'/meta.php', array('title' => 'Login'));
    include LAYOUT_PATH.'/css.php';
  ?>
  <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/toastr.css">
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-7 login-bg"></div>
      <div class="col-xl-5">
        <div class="login-page-content">
          <div>
            <div class="d-d-block text-center">
              <h4 class="ms-2 mt-1 fw-bold">JP Barber Shop</h4>
            </div>
            
            <div class="login-main">              
              <form id="form_login" class="mt-4 pt-2 needs-validation" novalidate>
                <h5 class="mb-0">Bienvenido!</h5>
                <p class="text-muted mt-2">Ingrese su usuario y contraseña para iniciar sesión</p>
  
                <div class="input-group mb-3">
                  <span class="input-group-text msr">person</span>
                  <input type="text" class="form-control" name="usuario" placeholder="Usuario" autofocus required>
                  <!-- <div class="text-danger" id="error-usuario"></div> -->
                  <div class="invalid-feedback"></div>
                </div>

                <div class="input-group mb-5">
                  <span class="input-group-text msr">key</span>
                  <input type="password" class="form-control" name="contrasena" placeholder="Contraseña">
                  <div class="invalid-feedback"></div>
                </div>
  
                <div class="mb-3">
                  <button class="btn btn-primary w-100" type="submit">
                    Iniciar sesión
                  </button>
                </div>
                
              </form>
              </div>
            </div>

          </div>

          <div class="position-fixed bottom-0 start-50 translate-middle-x p-3">
            <div id="liveToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="d-flex">
                <div id="message" class="toast-body">
                  Usuario y/o contraseña inválida!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

  <!-- <script src="<?= ASSETS_URL ?>/js/plugins/bootstrap.bundle.min.js"></script> -->
  <script src="<?= ASSETS_URL ?>/js/plugins/toastr.min.js"></script>
  <script src="<?= ASSETS_URL ?>/js/ajax/login.js"></script>
</body>