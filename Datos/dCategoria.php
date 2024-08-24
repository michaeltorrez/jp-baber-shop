<?php
require_once 'dConexion.php';

class dCategoria {

  public function __construct(
    private $id_categoria,
    private $nombre,
    private $descripcion
  ) {}


  function listar_categorias() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $respuesta = $con->query('CALL ListarCategorias()');

      if ($respuesta) {
        $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
      }
      $con->close();
    } catch (Exception $exc) {
      $exc->getTraceAsString();
    }

    return $resultado;
  }

}