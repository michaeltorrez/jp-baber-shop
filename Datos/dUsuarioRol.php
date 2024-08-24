<?php
declare(strict_types = 1);//solo funciona con variables de tipo escalares
require_once 'dConexion.php';

class dUsuarioRol {

  //Constructor property promotion
  public function __construct(
    private int $id_usuario,
    private int $id_rol
  ){}


  public function asignar_usuario_rol() {
    $parametros = [
      ['tipo' => 'i', 'valor' => $this->id_usuario],
      ['tipo' => 'i', 'valor' => $this->id_rol]
    ];
    return $this->ejecutarConsulta('CALL AsignarUsuarioRol(?,?)', $parametros);
  }


  public function listar_asignaciones(): array {
    $lista = $this->consulta_listar('CALL ListarUsuarioRol()');
    return $lista;
  }


  public function listar_roles_disponibles() {
    $parametros = [['tipo' => 'i', 'valor' => $this->id_usuario]];
    $lista = $this->consulta_listar('CALL ListarRolesDisponibles(?)', $parametros);
    return $lista;
  }


  function eliminar_asignacion() {
    $parametros = [
      ['tipo' => 'i', 'valor' => $this->id_usuario],
      ['tipo' => 'i', 'valor' => $this->id_rol]
    ];
    return $this->ejecutarConsulta('CALL EliminarAsignacion(?,?)', $parametros);
  }

  function existe_asignacion() {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
      $consulta = 'CALL ExisteUsuarioRol(?,?)';
      $stmt = $con->prepare($consulta);
      $stmt->bind_param('ii', $this->id_usuario, $this->id_rol);
      $respuesta = $stmt->execute();

      if ($respuesta) {
        $resultado = $stmt->get_result();
      }
      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
      $exc->getTraceAsString();
    }

    return $resultado;
  }



  function ejecutarConsulta(string $consulta, array $parametros = []): bool {
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


  private function consulta_listar($consulta, $parametros = []): array|bool {
    $conect = new dConexion();
    $resultado = false;

    try {
      $con = $conect->Conectar();
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

      if ($respuesta) {
        $resultado = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      }

      $stmt->close();
      $con->close();
    } catch (Exception $exc) {
      $exc->getTraceAsString();
    }

    return $resultado;
  }

}