<?php

namespace Models;
use Lib\BaseDatos;

class Producto{
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $categoria_id;
    private $stock;
    private $oferta;
    private $imagen;
    private $db;

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