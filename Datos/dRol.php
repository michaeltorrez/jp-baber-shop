<?php
declare(strict_types = 1);
require_once 'dConexion.php';

class dRol {

  //Constructor property promotion
  public function __construct(
    private int $id,
    private string $descripcion
  ) {}


  public function existe_rol(): bool {
    $rol = $this->consultar_uno('CALL ExisteRol(?)', $this->descripcion, 's');
    return $rol ? true : false;
  }


  function crear_rol(): bool {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $con->begin_transaction();
      $consulta = 'CALL CrearRol(?)';
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


  public function listar_roles(): array {
    $lista = $this->consulta_listar('CALL ListarRoles()');
    return $lista;
  }


  function obtener_rol() : array {
    $rol = $this->consultar_uno('CALL ObtenerRol(?)', $this->id, 'i');
    return $rol;
  }


  function actualizar_rol(): bool {
    $parametros = [
      ['tipo' => 'i', 'valor' => $this->id],
      ['tipo' => 's', 'valor' => $this->descripcion]
    ];
    $resp = $this->ejecutarConsulta('CALL ActualizarRol(?,?)', $parametros);
    return $resp;
  }


  function eliminar_rol() {
    $parametros = [['tipo' => 'i', 'valor' => $this->id]];
    return $this->ejecutarConsulta('CALL EliminarRol(?)', $parametros);
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