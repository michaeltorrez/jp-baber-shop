<?php
  require_once '../../../config.php';
  require_once '../../layout/main.php';
  require_once '../../../Negocio/nUsuario.php';
  require_once 'validaciones.php';


  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $usu = new nUsuario($id);
    $usuario = $usu->obtener_usuario();

    $nombre = $usuario['nombres_apellidos'];
    $correo = $usuario['correo'];
    $nombre_usuario = $usuario['nombre_usuario'];
    $contrasena = $usuario['contrasena'];
  }
?>
<head>
  <?php
    include_archivo_con_variables('../../layout/meta.php', array('title' => 'Actualizar usuario'));
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
          include_archivo_con_variables('../../layout/page-title.php', array('pagetitle' => 'Actualizar usuario', 'title' => 'Actualizar usuario'));

          if (isset($_POST['actualizar'])) {
            $id = $_POST['id'];
            $nombre = trim($_POST['nombre']);
            $correo = trim($_POST['correo']);
            $nombre_usuario = trim($_POST['usuario']);
            $contrasena = trim($_POST['contrasena']);
            
            $errores = validar_form_usuario($nombre, $correo, $nombre_usuario, $contrasena);
            if (empty($errores)) {
              $usu = new nUsuario($id, $nombre, $correo, $nombre_usuario, $contrasena);
              if ($usu->actualizar_usuario()) {
                echo '<script>';
                echo 'Swal.fire({
                  title: "¡Éxito!",
                  text: "El usuario se actualizó correctamente.",
                  icon: "success",
                  confirmButtonText: "Ok"
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = "administrarUsuarios.php"
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
                        <label for="nombre" class="form-label">Nombres y apellidos</label>
                        <input type="text" autofocus class="form-control" id="nombre" name="nombre"
                          required minlength="2" placeholder="Introduzca su nombre completo"
                          value="<?= $nombre ?? '' ?>">
                      </div>

                      <div class="mb-3">
                        <label for="correo" class="form-label">Correo electronico</label>
                        <input type="email" class="form-control" id="correo" name="correo"
                          required minlength="2" placeholder="Introduzca su email"
                          value="<?= $correo?? '' ?>">
                      </div>
                    </div>
                    
                    <div class="col-xl-6">
                      <div class="mb-3">
                        <label for="usuario" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario"
                          required minlength="2" placeholder="Introduzca un nombre para su usuario"
                          value="<?= $nombre_usuario ?? '' ?>">
                      </div>

                      <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena"
                          required minlength="2" placeholder="Introduzca su contraseña"
                          value="<?= $contrasena ?? '' ?>">
                      </div>
                    </div>

                    <div class="col-xl-12">
                      <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary" name="actualizar">Actualizar</button>
                        <button type="button" class="btn btn-secondary"  name="cancelar" onclick="location.href='administrar_usuarios.php'">Cancelar</button>
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