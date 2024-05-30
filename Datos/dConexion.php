<?php
declare(strict_types = 1);

class dConexion {
  //Constructor property promotion
  public function __construct(
    private string $servidor = 'localhost',
    private string $usuario = 'root',
    private string $clave = '',
    private string $baseDeDatos = 'db_jp_barber_shop',
    private int $puerto = 3366
  ){}

  public function Conectar() {
    $con = new mysqli($this->servidor, $this->usuario, $this->clave, $this->baseDeDatos, $this->puerto);
    if ($con->connect_error) {
      die('Error al conectar con la base de datos' . $con->connect_error); 
    }
    return $con;
  }
}