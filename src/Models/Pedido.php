<?php

namespace Models;
use Lib\BaseDatos;
use PDO;

/**
 * Clase Pedido
 *
 * Esta clase representa un pedido en el sistema.
 */
class Pedido{
    /**
     * @var int $id El ID del pedido.
     */
    private $id;

    /**
     * @var int $usuario_id El ID del usuario que hizo el pedido.
     */
    private $usuario_id;

    /**
     * @var string $provincia La provincia donde se hará la entrega del pedido.
     */
    private $provincia;

    /**
     * @var string $localidad La localidad donde se hará la entrega del pedido.
     */
    private $localidad;

    /**
     * @var string $direccion La dirección donde se hará la entrega del pedido.
     */
    private $direccion;

    /**
     * @var float $coste El coste total del pedido.
     */
    private $coste;

    /**
     * @var string $estado El estado actual del pedido.
     */
    private $estado;

    /**
     * @var string $fecha La fecha cuando se hizo el pedido.
     */
    private $fecha;

    /**
     * @var string $hora La hora cuando se hizo el pedido.
     */
    private $hora;
    
    /**
     * @var BaseDatos $db La conexión a la base de datos.
     */
    private $db;
    
    /**
     * Constructor de Pedido.
     *
     * Inicializa una nueva instancia de la clase Pedido.
     */
    public function __construct() {
        $this->db = new BaseDatos;
    }
    
    // Aquí van los métodos getter y setter con su respectiva documentación...
    
    //Métodos Getter and Setter
    function getId() {
        return $this->id;
    }

    function getUsuario_id() {
        return $this->usuario_id;
    }

    function getProvincia() {
        return $this->provincia;
    }

    function getLocalidad() {
        return $this->localidad;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getCoste() {
        return $this->coste;
    }

    function getEstado() {
        return $this->estado;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getHora() {
        return $this->hora;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    function setLocalidad($localidad) {
        $this->localidad = $localidad;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setCoste($coste) {
        $this->coste = $coste;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

}