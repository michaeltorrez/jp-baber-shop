<?php
  require_once 'assets/utiles/config.php';
  require_once '../Negocio/acceso.php';  
  require_once '../Negocio/funciones.php';
  require_once '../Negocio/clientes/nCliente.php';

  // incluimos el doctype y html
  include_once LAYOUT_PATH.'/main.php';
?>

<head>
  <?php
    include_archivo_con_variables(LAYOUT_PATH.'/meta.php', array('title' => 'Nueva venta'));
    require_once LAYOUT_PATH.'/css.php';
  ?>
  <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/select2.min.css">
  <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/flatpickr.min.css">
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
            'pagetitle' => isset($id) ? 'Editar venta': 'Nueva venta',
            'title' => isset($id) ? 'Editar venta': 'Nuevventa'
          ]);
        ?>
        <div class="row mb-3">
          <div class="col-xl-8 col-lg-4 col-md-12 col-12">
            <div class="card">
              <div class="card-header">
                <h5>Detalle de la venta</h5>
              </div>

              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-sm-6 col-sm-9">
                    <label for="cliente" class="form-label fw-bold d-block">
                      Cliente
                      <span class="text-danger">*</span>
                      <a href="/clientes/agregar" class="float-end fw-normal text-decoration-underline">AGREGAR CLIENTE</a>
                    </label>
                    <select type="text" class="form-select" name="cliente" id="cliente">
                    </select>
                  </div>

                  <div class="col-lg-3 col-sm-6">
                    <label for="fecha" class="form-label fw-bold">
                      Fecha
                    </label>
                    <div class="input-group">
                      <input type="date" class="form-control" disabled readonly id="fecha">
                      <span class="input-group-text msr">calendar_month</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-nowrap mb-0 table-centered">
                    <thead>
                      <tr class="table-active">
                        <th scope="col" class="text-center col-1">#</th>
                        <th scope="col" class="text-center">Producto</th>
                        <th scope="col" class="text-center col-2">Precio</th>
                        <th scope="col" class="text-center col-2">Cantidad</th>
                        <th scope="col" class="text-center col-2">Monto total</th>
                        <th scope="col" class="col-2"></th>
                      </tr>
                    </thead>
                    <tbody id="table-body-items">
                    </tbody>
                    
                  </table>
                </div>
                
                <div class="mt-4">
                  <select class="form-select" style="width: 100%;" name="item" id="agregar_item">
                  </select>
                </div>
              </div>
            </div>

            
          </div>

          <div class="col-xl-4 col-lg-8 col-md-12 col-12">
            <div class="card">
              <div class="card-header">
                <h5>Resumen de la venta</h5>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-borderless mb-0">
                    <tbody>
                      <tr>
                        <td>Sub Total :</td>
                        <td class="text-end" id="detalle-subtotal">0.00</td>
                      </tr>
                      <tr>
                          <td>Descuento : </td>
                          <td class="text-end" id="detalle-discount">- 0.00</td>
                      </tr>
                      <tr class="table-active">
                        <th>Total (BOB) :</th>
                        <td class="text-end">
                          <span class="fw-semibold" id="detalle-total">
                            0.00
                          </span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                
              </div>
            </div>

            <a href="javascript:AgregarVenta()" class="btn btn-primary w-100 mt-3">
              Agregar venta
            </a>
          </div>

          
        </div>

        <div class="row mb-3">
          <div class="col-xl-4 col-lg-8 col-md-12 col-12">
            <button type="button" class="btn btn-secondary me-2 d-flex align-items-center" name="cancelar" onclick="location.href='/ventas'">
              <span class="msr me-1">arrow_back</span>  
              Volver
            </button>
          </div>
        </div>

        <!-- <div class="modal fade" id="AddItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                  Seleccione un producto y/o servicio
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="input-group mb-3">
                    <span class="input-group-text msr" id="basic-addon1">search</span>
                    <input type="text" class="form-control" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                  </div>
                  <div class="col">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">First</th>
                          <th scope="col">Last</th>
                          <th scope="col">Handle</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>Mark</td>
                          <td>Otto</td>
                          <td>@mdo</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>Jacob</td>
                          <td>Thornton</td>
                          <td>@fat</td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td colspan="2">Larry the Bird</td>
                          <td>@twitter</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div> -->

        <!-- Modal para confirmar venta -->
        <div class="modal fade zoomIn" id="ConfirmarVentaModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-body">
                <div class="mt-2 text-center">
                  <button type="button" class="btn-close" style="position: absolute; right: 0; top: 0; width: 2rem; height: 2rem;" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                  <div class="mt-2 pt-2 fs-15 mx-4 mx-sm-5">
                    <h4>Confirmar venta</h4>
                    <p class="text-muted mx-4 mb-0">¿Estás seguro(a) de continuar con la venta?</p>
                  </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                  <button type="button" class="btn w-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn w-sm btn-success" id="btnRealizarVenta">Si, vender!</button>
                </div>
              </div>
            </div>
          </div>
        </div>


        <!-- Modal de informacion -->
        <div class="modal fade zoomIn" id="MensajeModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-body">
                <div class="mt-2 text-center">
                  <button type="button" class="btn-close" style="position: absolute; right: 0; top: 0; width: 2rem; height: 2rem;" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                  <div class="mt-2 pt-2 fs-15 mx-4 mx-sm-5">
                    <h4 id="title">Venta confirmada</h4>
                    <p id="content" class="text-muted mx-4 mb-0">La venta se realizo correctamente</p>
                  </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                  <button type="button" class="btn w-sm btn-secondary" id="btnOK" data-bs-dismiss="modal">Ok</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
<?php include LAYOUT_PATH.'/footer.php' ?>
<script src="<?= ASSETS_URL ?>/js/plugins/select2.min.js"></script>
<script src="<?= ASSETS_URL ?>/js/plugins/flatpickr.js"></script>
<script src="<?= ASSETS_URL ?>/js/plugins/es.min.js"></script>
<script src="<?= ASSETS_URL ?>/js/ajax/ventas.js"></script>

</body>
</html>