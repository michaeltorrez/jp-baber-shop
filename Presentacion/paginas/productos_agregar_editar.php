<?php
  require_once 'assets/utiles/config.php';
  require_once '../Negocio/acceso.php';  
  require_once '../Negocio/funciones.php';
  require_once '../Negocio/categorias/nCategoria.php';
  require_once '../Negocio/productos/nProducto.php';

  function listar_categorias() {
    $cat = new nCategoria();
    return $cat->listar_categorias();
  }

  $categorias = listar_categorias();

  $id = isset($id) ? $id : null;
  $producto = null;

  if ($id) {
    $pro = new nProducto($id);
    $producto = $pro->obtener_producto_por_id();
  }


  $id_categoria = $producto['id_categoria'] ?? '';
  $nombre = $producto['nombre'] ?? '';
  $descripcion = $producto['descripcion'] ?? '';
  $marca = $producto['marca'] ?? '';
  $precio = $producto['precio'] ?? '';
  $stock = $producto['stock'] ?? '';
  $imagen = $producto['imagen'] ?? '';


  // incluimos el doctype y html
  include_once LAYOUT_PATH.'/main.php';
?>

<head>
  <?php
    include_archivo_con_variables(LAYOUT_PATH.'/meta.php', array('title' => isset($id) ? 'Agregar producto': 'Actualizar producto'));
    require_once LAYOUT_PATH.'/css.php';
  ?>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/dropzone.css">
    <!-- <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/base.min.css"> -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/choices.min.css">
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
            'pagetitle' => isset($id) ? 'Actualizar producto': 'Agregar producto'
          ]);
        ?>
        <div class="container-fluid">
          <form id="form_producto" enctype='multipart/form-data' class="needs-validation" novalidate>
            <div class="row">
              <div class="col-xl-9 col-md-12 col-12">
                <div class="card">
                  <div class="card-body p-4">
                    <!-- <h5 class="card-title mb-4 fw-bold">Información básica del producto</h5> -->
                      
                    <div class="row">
                      <input type="hidden" name="id_producto" value="<?= $id ?>">
                      <input type="hidden" name="imagen" value="<?= $imagen ?>">

                      <div class="mb-4 col-12">
                        <label for="nombre" class="form-label fw-bold">
                          Nombre del producto
                          <span class="text-danger">*</span>
                        </label>
                        <input type="text" autofocus class="form-control" name="nombre" id="nombre" placeholder="Ingrese nombre del producto" value="<?= $nombre ?>">
                        <div class="invalid-feedback"></div>
                      </div>

                      <div class="mb-4 col-md-3 col-12">
                        <label for="stock" class="form-label fw-bold">
                          Stock
                          <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" name="stock" id="stock" value="<?= $stock ?>" placeholder="0">
                        <div class="invalid-feedback"></div>
                      </div>


                      <div class="mb-4 col-md-3 col-12">
                        <label for="precio" class="form-label fw-bold">
                          Precio
                          <span class="text-danger">*</span>
                        </label>
                        <div class="input-group mb-3">
                          <span class="input-group-text" id="basic-addon1">Bs</span>
                          <input type="number" class="form-control" name="precio" id="precio" value="<?= $precio ?>" placeholder="0.00">
                        </div>
                        <div class="invalid-feedback"></div>
                      </div>

                      <div class="mb-4 col-md-6 col-12">
                        <label for="marca" class="form-label fw-bold">
                          Marca
                          <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="marca" id="marca" placeholder="Ingres la marca del producto" value="<?= $marca ?>">
                        <div class="invalid-feedback"></div>
                      </div>
                      




                      <div class="mb-4 col-12">
                        <label for="staticEmail" class="form-label fw-bold">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="descripcion"><?= $descripcion ?></textarea>
                      </div>

                      
                      


                      <div class="mb-4 col-12">
                        <label for="file" class="form-label fw-bold">Imagen del producto</label>
                        <div class="dropzone" id="dropzone">
                          <!-- <div class="dz-message needsclick">
                            <span class="msr fs-1">cloud_upload</span>
                            <h6>Suelte la imagen aquí o haga clic para cargarla.</h6>
                          </div> -->
                        </div>
                        <input type="hidden" name="imagen" id="imagen" value="<?= $imagen ?>">
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>

              <div class="col-xl-3">
                <div class="card">
                  <div class="card-body">
                    <div class="mb-3">
                      <label for="id_categoria" class="form-label fw-bold">
                        Categoría
                        <span class="text-danger">*</span>
                      </label>
                      <select class="form-select" name="id_categoria" id="id_categoria">
                        <?php
                          foreach ($categorias as $categoria) : ?>
                            <option value="<?= $categoria['id_categoria'] ?>">
                              <?= $categoria['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-xl-9">
                <div class="d-flex justify-content-end py-4">
                  <button type="button" class="btn btn-secondary me-2" name="cancelar" onclick="location.href='/productos'">
                    Cancelar
                  </button>

                  <button type="submit" class="btn btn-primary">
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

  <script src="<?= ASSETS_URL ?>/js/plugins/dropzone.min.js"></script>
  <script src="<?= ASSETS_URL ?>/js/ajax/productos.js"></script>
  <script src="<?= ASSETS_URL ?>/js/plugins/choices.min.js"></script>
  <script src="<?= ASSETS_URL ?>/js/productos.js"></script>
  <?php include LAYOUT_PATH.'/footer.php' ?>  
</body>
</html>