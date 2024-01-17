<?php
namespace Repositories;
use Lib\BaseDatos;
use PDO;

class ProductoRepository {
    private BaseDatos $db;

    public function __construct() {
        $this->db = new BaseDatos();
    }

    public function getAll() {
        $sql = "SELECT * FROM productos";
        $this->db->consulta($sql);
        $this->db->close();
        return $this->db->extraer_todos();
    }

    public function getRandom() {
        $sql = "SELECT * FROM productos ORDER BY RAND() LIMIT 5";
        $this->db->consulta($sql);
        $this->db->close();
        return $this->db->extraer_todos();
    }

    public function getByCategoria($categoriaId) {
        $sql = "SELECT * FROM productos WHERE categoria_id = :categoriaId";
        $stmt = $this->db->prepara($sql);
        $stmt->bindParam(':categoriaId', $categoriaId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->db->close();
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM productos WHERE id = :id";
        $stmt = $this->db->prepara($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->db->close();
        return $producto;
    }

    public function save($categoriaId, $nombre, $descripcion, $precio, $stock, $imagen) {
        $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, imagen) 
                VALUES (:categoriaId, :nombre, :descripcion, :precio, :stock, :imagen)";
    
        $stmt = $this->db->prepara($sql);
        $stmt->bindParam(':categoriaId', $categoriaId, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':imagen', $imagen, PDO::PARAM_STR);
    
        $save = $stmt->execute();
        $this->db->close();
    
        return $save;
    }


    public function delete($productId) {
        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $this->db->prepara($sql);
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $this->db->close();
    }

    public function update($productId, $nombre, $descripcion, $precio, $categoriaId, $imagen) {
        $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, categoria_id = :categoriaId, imagen = :imagen WHERE id = :id";
        $stmt = $this->db->prepara($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
        $stmt->bindParam(':categoriaId', $categoriaId, PDO::PARAM_INT);
        $stmt->bindParam(':imagen', $imagen, PDO::PARAM_STR);
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $this->db->close();
    }
}
