<?php

namespace Models;
use Lib\BaseDatos;

class Categoria
{
    private $id;
    private $nombre;
    private BaseDatos $db;

    public function __construct()
    {
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

}