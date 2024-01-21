<?php

namespace Models;
use Lib\BaseDatos;

/**
 * Clase Producto
 *
 * Esta clase representa un producto en el sistema.
 */
class Producto{
    /**
     * @var int $id El ID del producto.
     */
    private $id;

    /**
     * @var string $nombre El nombre del producto.
     */
    private $nombre;

    /**
     * @var string $descripcion La descripción del producto.
     */
    private $descripcion;

    /**
     * @var float $precio El precio del producto.
     */
    private $precio;

    /**
     * @var int $categoria_id El ID de la categoría a la que pertenece el producto.
     */
    private $categoria_id;

    /**
     * @var int $stock La cantidad de stock disponible del producto.
     */
    private $stock;

    /**
     * @var string $oferta La oferta aplicada al producto.
     */
    private $oferta;

    /**
     * @var string $imagen La imagen del producto.
     */
    private $imagen;

    /**
     * @var BaseDatos $db La conexión a la base de datos.
     */
    private $db;

    /**
     * Constructor de Producto.
     *
     * Inicializa una nueva instancia de la clase Producto.
     */
    public function __construct($id = null, $nombre = null, $descripcion = null, $precio = null, $stock= null, $oferta = null, $categoria_id = null, $imagen = null){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->oferta = $oferta;
        $this->categoria_id = $categoria_id;
        $this->imagen = $imagen;
        $this->db = new BaseDatos();
    }

    // METODOS GETTER Y SETTER

    public function getId(){
        return $this->id;
    }

    public function setId($id): void{
        $this->id = $id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre): void{
        $this->nombre = $nombre;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function setDescripcion($descripcion): void{
        $this->descripcion = $descripcion;
    }

    public function getPrecio(){
        return $this->precio;
    }

    public function setPrecio($precio): void{
        $this->precio = $precio;
    }

    public function getStock(){
        return $this->stock;
    }

    public function setStock($stock): void{
        $this->stock = $stock;
    }

    public function getOferta(){
        return $this->oferta;
    }

    public function setOferta($oferta): void{
        $this->oferta = $oferta;
    }

    public function getCategoriaId(){
        return $this->categoria_id;
    }

    public function setCategoriaId($categoria_id): void{
        $this->categoria_id = $categoria_id;
    }

    public function getImagen(){
        return $this->imagen;
    }

    public function setImagen($imagen): void{
        $this->imagen = $imagen;
    }

}