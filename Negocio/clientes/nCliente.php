<?php
include '../Datos/dCliente.php';

class nCliente {
  private $cliente;

  public function __construct($id_cliente=0, $nombres='', $apellidos='', $correo='', $direccion='', $telefono='')
  {
    $this->cliente = new dCliente($id_cliente, $nombres, $apellidos, $correo, $direccion, $telefono);
  }


  function agregar_cliente() {
    return $this->cliente->agregar_cliente();
  }


  function eliminar_cliente() {
    return $this->cliente->eliminar_cliente();
  }

  function editar_cliente() {
    return $this->cliente->editar_cliente();
  } 
  
  function obtener_cliente_por_id() {
    return $this->cliente->obtener_cliente_por_id();
  }

  function listar_clientes() {
    return $this->cliente->listar_clientes();
  }


  static function listar_clientes_select() {
    $clientes = dCliente::obtener_clientes();
    if ($clientes) { ?>
      <option></option>
      <?php foreach($clientes as $cliente) : ?>
        <option value="<?= $cliente['id_cliente'] ?>">
          <?= strtoupper($cliente['nombres'] . ' ' . $cliente['apellidos']) ?>
        </option>
      <?php endforeach;?>
      <?php
    }
  }



  static function listar_clientes_tabla() {
    $clientes = dCliente::obtener_clientes();

    if ($clientes) {
      $nro = 1;
      foreach($clientes as $cliente) : ?>
        <tr class="cliente">
          <td class="text-center col-1"><?= $nro ?></td>
          <td class="text-left col-2"><?= $cliente['nombres'] ?></td>
          <td class="text-left col-3"><?= $cliente['apellidos'] ?></td>
          <td class="text-left col-2"><?= $cliente['correo'] ?></td>
          <td class="text-center col-2"><?= $cliente['direccion'] ?></td>
          <td class="text-center col-2"><?= $cliente['telefono'] ?></td>
          <td class="text-center col-2">
            <div class="d-flex justify-content-center">
              <a href="/clientes/editar/<?= $cliente['id_cliente'] ?>" class="d-block text-secondary p-1 px-2">
                <span class="msr" data-bs-toggle="tooltip" data-bs-title="Editar">edit</span>
              </a>
              <a href="/clientes/eliminar/<?= $cliente['id_cliente'] ?>" class="d-block text-secondary p-1 px-2" data-bs-toggle="modal" data-bs-target="#EliminarClienteModal">
                <span class="msr" data-bs-toggle="tooltip" data-bs-title="Eliminar">delete</span>
              </a>
            </div>
          </td>
        </tr>
    <?php
        $nro = $nro + 1;
      endforeach;
    }
  }

}