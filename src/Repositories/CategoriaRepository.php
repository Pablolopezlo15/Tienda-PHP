<?php
namespace Repositories;
use Lib\BaseDatos;
use PDO;

class CategoriaRepository {
    private BaseDatos $db;
    

    public function __construct() {
        $this->db = new BaseDatos();
    }

    public function getAll() {
        $this->db->consulta("SELECT * FROM categorias");
        $this->db->close();
        return $this->db->extraer_todos();
    }

    public function getById($id) {
        $sql = "SELECT * FROM categorias WHERE id = :id";

        try {
            $stmt = $this->db->prepara($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            $categoria = null;
        }

        $this->db->close();
        return $categoria;
    }

    public function save($categoria): bool{
        $nombre = $categoria->getNombre();

        try {
            $ins = $this->db->prepara("INSERT INTO categorias (id, nombre) values (null, :nombre)");
            $ins->bindValue(':nombre', $nombre);

            $ins->execute();

            $result = true;
        } catch (PDOException $error){
            $result = false;
        }

        $ins->closeCursor();
        $ins=null;

        return $result;
    }

    

}