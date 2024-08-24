<?php
declare(strict_types = 1);
require_once 'dConexion.php';

class dCategoria {

  //Constructor property promotion
  public function __construct(
    private int $id_categoria,
    private int $nombre,
    private string $descripcion
  ) {}


  function crear_categoria(): bool {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $con->begin_transaction();
      $consulta = 'CALL CrearCategoria(?)';
      $stmt = $con->prepare($consulta);
      $stmt->bind_param('s', $this->descripcion);
      $respuesta = $stmt->execute();
      $resultado = $respuesta ? $con->commit() : $con->rollback();
      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
      $exc->getTraceAsString();
    }
    return $resultado;
  }


  public function listar_categorias(): array {
    $lista = $this->consulta_listar('CALL ListarCategorias()');
    return $lista;
  }




  function ejecutarConsulta(string $consulta, array $parametros = []) {
    $conexion = new dConexion();
    $resultado = false;

    try {
        $con = $conexion->Conectar();
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
    } catch (Exception $exc) {
        $exc->getTraceAsString();
    }
    
    return $resultado;
  }


  private function consultar_uno(string $consulta, $valor_buscado, $type): array|false|null {
    $conect = new dConexion();
    $resultado = null;

    try {
      $con = $conect->Conectar();
      $stmt = $con->prepare($consulta);
      $stmt->bind_param($type, $valor_buscado);
      $respuesta = $stmt->execute();

      if ($respuesta) {
        $resultado = $stmt->get_result()->fetch_assoc();
      }
      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
      $exc->getTraceAsString();
    }

    return $resultado;
  }


  private function consulta_listar($consulta): array|false {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $respuesta = $con->query($consulta);

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