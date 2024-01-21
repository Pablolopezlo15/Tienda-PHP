<?php

namespace models;

use Lib\BaseDatos;
use mysql_xdevapi\Result;
use PDO;
use PDOException;

/**
 * Clase Usuario
 *
 * Esta clase representa un usuario en el sistema.
 */
class Usuario
{
    /**
     * @var string|null $id El ID del usuario.
     */
    private string|null $id;

    /**
     * @var string $nombre El nombre del usuario.
     */
    private string $nombre;

    /**
     * @var string $apellidos Los apellidos del usuario.
     */
    private string $apellidos;

    /**
     * @var string $email El email del usuario.
     */
    private string $email;

    /**
     * @var string $password La contraseña del usuario.
     */
    private string $password;

    /**
     * @var string $rol El rol del usuario.
     */
    private string $rol;

    /**
     * @var BaseDatos $db La conexión a la base de datos.
     */
    private BaseDatos $db;

    /**
     * Constructor de Usuario.
     *
     * Inicializa una nueva instancia de la clase Usuario.
     */
    public function __construct(string|null $id, string $nombre, string $apellidos, string $email, string $password, string $rol)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
        $this->db = new BaseDatos();
    }

    // Aquí van los métodos getter y setter con su respectiva documentación...


    public function getId(): ? string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRol(): string
    {
        return $this->rol;
    }

    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }


    /**
     * Crea una nueva instancia de la clase Usuario a partir de un array de datos.
     *
     * @param array $data Los datos del usuario.
     * @return Usuario La nueva instancia de Usuario.
     */
    public static function fromArray(array $data):usuario{
        return new Usuario(
            $data['id'] ?? null,
            $data['nombre'] ?? '',
            $data['apellidos'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? '',
            $data['rol'] ?? '',
        );
    }

    /**
     * Desconecta la conexión a la base de datos.
     */
    public function desconecta(){
        $this->db->close();
    }

}