<?php
declare(strict_types = 1);

namespace Datos;

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
    $con = new \mysqli($this->servidor, $this->usuario, $this->clave, $this->baseDeDatos, $this->puerto);
    if ($con->connect_error) {
      die('Error al conectar con la base de datos' . $con->connect_error); 
    }
    return $con;
  }


  function consulta_con_parametros(string $consulta, array $parametros = []) {
    try {
      $con = $this->Conectar();
      $con->begin_transaction();
      $stmt = $con->prepare($consulta);
      
      if (!empty($parametros)) {
        $tipos = '';
        $valores = [];
        foreach ($parametros as $parametro) {
          $tipos .= $parametro['tipo'];
          $valores[] = $parametro['valor'];
        }
        $stmt->bind_param($tipos, ...$valores);
      }

      $respuesta = $stmt->execute();
      $resultado = $respuesta ? $con->commit() : $con->rollback();
      $stmt->close();
      $con->close();
    } catch (\Exception $exc) {
      $exc->getTraceAsString();
    }
    
    return $resultado;
  }


  function listar_simple($consulta) {
    $resultado = false;
    try {
      $con = $this->Conectar();
      $respuesta = $con->query($consulta);

      if ($respuesta) {
        $resultado = $respuesta->fetch_all(MYSQLI_ASSOC);
      }
      $con->close();
    } catch (\Exception $exc) {
      $exc->getTraceAsString();
    }

    return $resultado;
  }
}