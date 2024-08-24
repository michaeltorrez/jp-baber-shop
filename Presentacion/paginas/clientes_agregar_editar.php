<?php
  require_once 'assets/utiles/config.php';
  require_once '../Negocio/acceso.php';  
  require_once '../Negocio/funciones.php';
  require_once '../Negocio/nCliente.php';


  if (isset($id_cliente)) {
    $cli = new nCliente($id_cliente);
    $cliente = $cli->obtener_cliente_por_id();
  }
  //$id_cliente = $cliente['id_cliente'] ?? '';
  $nombres = $cliente['nombres'] ?? '';
  $apellidos = $cliente['apellidos']  ?? '';
  $correo = $cliente['correo'] ?? '';
  $direccion = $cliente['direccion'] ?? '';
  $telefono = $cliente['telefono'] ?? '';

  // incluimos el doctype y html
  include_once LAYOUT_PATH.'/main.php';
?>

<head>
  <?php
    include_archivo_con_variables(LAYOUT_PATH.'/meta.php', array('title' => 'Nuevo cliente'));
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
      <div class="container-xl">
        <?php
          include_archivo_con_variables('componentes/breadcrumb.php', [
            'pagetitle' => isset($id_cliente) ? 'Editar cliente': 'Nuevo cliente',
            'title' => isset($id_cliente) ? 'Editar cliente': 'Nuevo cliente'
          ]);
        ?>
        <form id="form_cliente" enctype='multipart/form-data' class="needs-validation" novalidate>
          <div class="row">
            <div class="col-xl-9 col-md-12 col-12">
              <div class="card">
                <div class="card-body p-4">
                  <div class="row">
                    <input type="hidden" name="id_cliente" value="<?= $id_cliente ?>">

                    <div class="mb-4 col-6">
                      <label for="nombres" class="form-label fw-bold">
                        Nombres
                        <span class="text-danger">*</span>
                      </label>
                      <input type="text" autofocus class="form-control" name="nombres" id="nombres" placeholder="Ingrese nombre(s) del cliente" value="<?= $nombres ?>">
                      <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-4 col-6">
                      <label for="stock" class="form-label fw-bold">
                        Apellidos
                        <span class="text-danger">*</span>
                      </label>
                      <input type="text" class="form-control" name="apellidos" id="apellidos" value="<?= $apellidos ?>" placeholder="Ingrese apellido(s) del cliente">
                      <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-4 col-6">
                      <label for="stock" class="form-label fw-bold">
                        correo
                        <span class="text-danger">*</span>
                      </label>
                      <input type="email" class="form-control" name="correo" id="correo" value="<?= $correo ?>" placeholder="correo_cliente@ejemplo.com">
                      <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-4 col-6">
                      <label for="stock" class="form-label fw-bold">
                        Dirección
                        <span class="text-danger">*</span>
                      </label>
                      <input type="text" class="form-control" name="direccion" id="direccion" value="<?= $direccion ?>" placeholder="Av. Ejemplo calle 1 #123">
                      <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-4 col-6">
                      <label for="stock" class="form-label fw-bold">
                        Telefono/celular
                        <span class="text-danger">*</span>
                      </label>
                      <input type="text" class="form-control" name="telefono" id="telefono" value="<?= $telefono ?>" placeholder="70000000">
                      <div class="invalid-feedback"></div>
                    </div>

                  </div>
                  
                </div>
              </div>
            </div>

            <!-- <div class="col-xl-3">
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
            </div> -->
          </div>

          <div class="row">
            <div class="col-12 col-xl-9">
              <div class="d-flex justify-content-end py-4">
                <button type="button" class="btn btn-secondary me-2" name="cancelar" onclick="location.href='/clientes'">
                  Cancelar
                </button>

                <button type="submit" class="btn btn-primary">
                  <?= isset($id_cliente) ? 'Editar': 'Agregar' ?>
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?= ASSETS_URL ?>/js/ajax/clientes_agregar_editar.js"></script>
<?php include LAYOUT_PATH.'/footer.php' ?>