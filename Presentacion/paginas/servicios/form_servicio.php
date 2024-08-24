<?php
  require_once 'assets/utiles/config.php';
  require_once '../Negocio/acceso.php';  
  require_once '../Negocio/funciones.php';

  $mode = 'new';
  if (isset($id)) {   
    require_once '../Negocio/servicios/nServicio.php';
    $pro = new nServicio($id);
    $servicio = $pro->obtener_servicio_por_id();

    $mode = 'edit';
    $id_servicio = $id;
    $nombre = $servicio['nombre'];
    $descripcion = $servicio['descripcion'];
    $precio = $servicio['precio'];
    $imagen = $servicio['imagen'];
    //print_r($servicio);
  }


  // incluimos el doctype y html
  include_once LAYOUT_PATH.'/main.php';
?>

<head>
  <?php
    include_archivo_con_variables(LAYOUT_PATH.'/meta.php', array('title' => isset($id) ? 'Agregar servicio': 'Actualizar servicio'));
    require_once LAYOUT_PATH.'/css.php';
    ?>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/dropzone.css">
</head>

<body>
  <div class="layout-wrapper">
    <?php
      include 'componentes/topbar.php';
      include 'componentes/sidebar.php';
    ?>
    <div class="main-content">
      <div class="page-content">
        <?php
          include_archivo_con_variables('componentes/breadcrumb.php', [
            'pagetitle' => isset($id) ? 'Actualizar servicio': 'Agregar servicio'
          ]);
        ?>
        <div class="container-fluid">

          <form id="form_servicio" enctype='multipart/form-data'>
            <div class="row">
              <div class="col-xl-9 col-md-12 col-12">
                <div class="card mb-5">
                  <div class="card-body p-4">
                    <!-- <h5 class="card-title mb-4 fw-bold">Información básica del servicio</h5> -->
                    
                    
                    <div class="row">
                      <input type="hidden" name="id_servicio" value="<?= $id_servicio ?? '' ?>">
                      <input type="hidden" name="imagen" value="<?= $imagen ?? '' ?>">

                      <div class="mb-4 col-12">
                        <label for="nombre" class="form-label fw-bold">
                          Nombre del servicio
                          <span class="text-danger">*</span>
                        </label>
                        <input type="text" autofocus class="form-control" name="nombre" id="nombre"
                          placeholder="Ingrese nombre del servicio" value="<?= $nombre ?? "" ?>"
                        >
                        <div class="text-danger" id="error-nombre"></div>
                      </div>

                      <div class="mb-4 col-12">
                        <label for="staticEmail" class="form-label fw-bold">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="descripcion"><?= $descripcion ?? '' ?></textarea>
                        <div class="text-danger" id="error-descripcion"></div>
                      </div>

                      <div class="mb-4 col-md-6 col-12">
                        <label for="precio" class="form-label fw-bold">
                          Precio
                          <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" name="precio" id="precio" value="<?= $precio ?? '' ?>">
                        <div class="text-danger" id="error-precio"></div>
                      </div>


                      <div class="mb-4 col-12">
                        <label for="file" class="form-label fw-bold">Imagen del servicio</label>
                        <div class="dropzone" id="dropzone">
                        </div>
                      </div>

                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                      <button type="button" class="btn me-2" name="cancelar" onclick="location.href='/servicios'">
                        Cancelar
                      </button>

                      <button type="submit" class="btn btn-primary">
                        <?= isset($id) ? 'Actualizar': 'Agregar' ?>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-3">
                <div class="card mb-5">
                  <div class="card-body">
                  <h5 class="card-title mb-4 fw-bold">Categoria</h5>
                    ...
                  </div>
                </div>
              </div>


            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="<?= ASSETS_URL ?>/js/plugins/dropzone.min.js"></script>
  <script src="<?= ASSETS_URL ?>/js/ajax/servicios.js"></script>
  <?php include LAYOUT_PATH.'/footer.php' ?>  
</body>
</html>