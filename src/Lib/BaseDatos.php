<?php
namespace Lib;
use PDO;
use PDOException;
use Exception;

class BaseDatos{
    private $conexion;
    private mixed $resultado; //mixed novedad en PHP cualquier valor
    private string $servidor;
    private string $usuario;
    private string $pass;
    private string $base_datos;


    function __construct(){
      $this->servidor = $_ENV['SERVIDOR'];
      $this->usuario = $_ENV['USUARIO'];
      $this->pass = $_ENV['PASSWORD'];
      $this->base_datos = $_ENV['BASE_DATOS'];

      $this->conexion = $this->conectar();
    }

    private function conectar(): PDO {
        try {
            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES Utf8",
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            );

            $conexion = new PDO("mysql:host={$this->servidor};dbname={$this->base_datos}", $this->usuario, $this->pass, $opciones);
            return $conexion;
        } catch(PDOException $e){
            echo "Ha surgido un error y no se puede conectar a la base de datos. Detalle: " . $e->getMessage();
            exit;
        }
    }

    public function consulta(string $consultasQL): void
    {
        $this->resultado = $this->conexion->query($consultasQL);
    }
    public function extraer_registro(): mixed
    {
        return ( $fila = $this->resultado->fetch(PDO::FETCH_ASSOC))? $fila:false;
    }

    public function extraer_todos(): array
    {
        return $this->resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filasAfectadas(): int
    {
        return $this->resultado->rowCount();
    }

    public function close(){
        if ($this->conexion !== null) {
            $this->conexion = null;
        }
    }

    public function prepara($pre){
        return $this->conexion->prepare($pre);
    }

    public function empezarTransaccion(){
        $this->conexion->beginTransaction();
    }

    public function ejecutarTransaccion(){
        $this->conexion->commit();
    }

    public function rollback(){
        $this->conexion->rollBack();
    }

    public function lastInsertId(){
        return $this->conexion->lastInsertId();
    }


}