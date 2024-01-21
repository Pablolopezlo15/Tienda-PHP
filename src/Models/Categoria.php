<?php

namespace Models;
use Lib\BaseDatos;

/**
 * Clase Categoria
 *
 * Esta clase representa una categoría en el sistema.
 */
class Categoria
{
    /**
     * @var int $id El ID de la categoría.
     */
    private $id;

    /**
     * @var string $nombre El nombre de la categoría.
     */
    private $nombre;

    /**
     * @var BaseDatos $db La conexión a la base de datos.
     */
    private BaseDatos $db;

    /**
     * Constructor de Categoria.
     *
     * Inicializa una nueva instancia de la clase Categoria.
     */
    public function __construct()
    {
        $this->db = new BaseDatos();
    }

    /**
     * Obtiene el ID de la categoría.
     *
     * @return int El ID de la categoría.
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Establece el ID de la categoría.
     *
     * @param int $id El nuevo ID de la categoría.
     */
    public function setId($id): void{
        $this->id = $id;
    }

    /**
     * Obtiene el nombre de la categoría.
     *
     * @return string El nombre de la categoría.
     */
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * Establece el nombre de la categoría.
     *
     * @param string $nombre El nuevo nombre de la categoría.
     */
    public function setNombre($nombre): void{
        $this->nombre = $nombre;
    }

}