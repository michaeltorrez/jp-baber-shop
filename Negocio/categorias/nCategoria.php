<?php
include '../Datos/dCategoria.php';

class nCategoria {
  private $categoria;

  public function __construct($id_categoria=0, $nombre='', $descripcion='')
  {
    $this->categoria = new dCategoria($id_categoria, $nombre, $descripcion);
  }


  function listar_categorias() {
    return $this->categoria->listar_categorias();
  }



}