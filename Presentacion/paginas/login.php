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
</head>

<body>
  <div class="container-fluid p-0">
    <div class="row g-0">
      <div class="col-xl-7 login-bg"></div>

      <div class="col-xl-5">
        <div class="login-page-content d-flex justify-content-center align-items-center p-sm-5 p-4">
          <div>
            <div class="mb-4 mb-md-5 d-flex justify-content-center align-items-center">
              <!--<svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" width="38px" height="38px" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css">  .st0{fill:#ffffff;}  </style> <g> <path class="st0" d="M476.719,182.854c-32.563-12.953-50.188,5.063-57.219,14.328c-7.344,9.75-4.156,26.391-1.031,19.313 c4.625-14.906,28.688-14.906,36.438,0c7.781,14.922-4.781,31.375-22.5,33.766c-23.25,3.141-32.906-16.172-46.875-31.875 c-13.969-15.688-35.094-33.063-65.719-41.922c-19.875-5.75-46.656-1.141-63.813,14.828c-17.125-15.969-43.938-20.578-63.813-14.828 c-30.625,8.859-51.719,26.234-65.719,41.922c-13.938,15.703-23.594,35.016-46.875,31.875c-17.688-2.391-30.281-18.844-22.5-33.766 c7.75-14.906,31.813-14.906,36.469,0c3.094,7.078,6.281-9.563-1.063-19.313c-7-9.266-24.656-27.281-57.219-14.328 C3.563,195.464-8.625,242.089,6.406,274.558c20.938,45.281,80.406,68.219,142.719,62.484c44.156-4.063,78.844-30.016,106.875-72.5 c28.031,42.484,62.719,68.438,106.875,72.5c62.313,5.734,121.781-17.203,142.719-62.484 C520.625,242.089,508.438,195.464,476.719,182.854z"></path> </g> </g></svg>-->
              <h4 class="ms-2 mt-1 fw-bold">JP Barber Shop</h4>
            </div>
            
            <div class="my-auto">
              <div class="text-center">
                <h5 class="mb-0">Bienvenido!</h5>
                <p class="text-muted mt-2">Ingrese su usuario y contraseña para iniciar sesión</p>
              </div>

              <form id="form_login" class="mt-4 pt-2">

                <div class="mb-3">
                  <label class="form-label" for="username">Usuario</label>
                  <input type="text" class="form-control" name="usuario" autofocus required>
                </div>

                <div class="mb-5">
                  <label class="form-label" for="password">Contraseña</label>
                  <input type="password" class="form-control" name="contrasena" required>
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
              <div class="toast-body">
                Usuario y/o contraseña inválida!
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= ASSETS_URL ?>/js/plugins/bootstrap.bundle.min.js"></script>
  <script src="<?= ASSETS_URL ?>/js/ajax/login.js"></script>
</body>