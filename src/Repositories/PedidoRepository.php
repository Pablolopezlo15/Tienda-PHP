<?php
namespace Repositories;
use Lib\BaseDatos;
use Lib\Pages;
use PDO;
use PDOException;

class PedidoRepository {
    private BaseDatos $db;
    private Pages $pages;

    public function __construct() {
        $this->db = new BaseDatos();
        $this->pages = new Pages();
    }

    public function getAll() {
        $sql = "SELECT * FROM pedidos ORDER BY id DESC";
        $this->db->consulta($sql);
        $this->db->close();
        return $this->db->extraer_todos();
    }

    public function getById($id) {
        $sql = "SELECT * FROM pedidos WHERE id = :id";
        $stmt = $this->db->prepara($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->db->close();
        return $pedido;
    }

    public function getByUsuario($usuarioId) {
        $sql = "SELECT * FROM pedidos WHERE usuario_id = :usuarioId ORDER BY id DESC";
        $stmt = $this->db->prepara($sql);
        $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->db->close();
        return $pedidos;
    }


    public function getLineasPedido($pedidoId) {
        $sql = "SELECT * FROM lineas_pedidos WHERE pedido_id = :pedidoId";
        $stmt = $this->db->prepara($sql);
        
        $stmt->bindParam(':pedidoId', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();
        $lineas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->close();
        return $lineas;
    }

    // public function saveLinea($pedidoId, $productoId, $unidades) {
    //     $sql = "INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) 
    //             VALUES (:pedidoId, :productoId, :unidades)";
    
    //     $stmt = $this->db->prepara($sql);
    //     $stmt->bindParam(':pedidoId', $pedidoId, PDO::PARAM_INT);
    //     $stmt->bindParam(':productoId', $productoId, PDO::PARAM_INT);
    //     $stmt->bindParam(':unidades', $unidades, PDO::PARAM_INT);
    
    //     $save = $stmt->execute();
    //     $this->db->close();
    //     return $save;
    // }

    public function calcularTotal($carrito) {
        $total = 0;
        foreach ($carrito as $elemento) {
            $total += $elemento['precio'] * $elemento['cantidad'];
        }
        return $total;

    }


    private function insertPedido($usuarioId, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora)
    {
        $sqlPedido = "INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES (:usuarioId, :provincia, :localidad, :direccion, :coste, :estado, :fecha, :hora)";
        $stmtPedido = $this->db->prepara($sqlPedido);
        $stmtPedido->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $stmtPedido->bindParam(':provincia', $provincia, PDO::PARAM_STR);
        $stmtPedido->bindParam(':localidad', $localidad, PDO::PARAM_STR);
        $stmtPedido->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmtPedido->bindParam(':coste', $coste, PDO::PARAM_STR);
        $stmtPedido->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmtPedido->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmtPedido->bindParam(':hora', $hora, PDO::PARAM_STR);
        $stmtPedido->execute();
    
        // Obtener el ID del nuevo pedido
        return $this->db->lastInsertId();
    }

    private function insertLineasPedido($pedidoId, $carrito)
    {
        foreach ($carrito as $producto) {
            $productoId = $producto['id'];
            $cantidad = $producto['cantidad'];

            $sqlLineaPedido = "INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES (:pedidoId, :productoId, :unidades)";
            $stmtLineaPedido = $this->db->prepara($sqlLineaPedido);
            $stmtLineaPedido->bindParam(':pedidoId', $pedidoId, PDO::PARAM_INT);
            $stmtLineaPedido->bindParam(':productoId', $productoId, PDO::PARAM_INT);
            $stmtLineaPedido->bindParam(':unidades', $cantidad, PDO::PARAM_INT);
            $stmtLineaPedido->execute();
        }
    }

    public function save($usuarioId, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito)
    {
        // Comienzo de la transacción
        $this->db->empezarTransaccion();

        try {
            // Paso 1: Insertar el pedido en la tabla pedidos
            $pedidoId = $this->insertPedido($usuarioId, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora);

            // Paso 2: Insertar líneas de pedido en la tabla lineas_pedido
            $this->insertLineasPedido($pedidoId, $carrito);

            // Commit si todas las operaciones fueron exitosas
            $this->db->ejecutarTransaccion();

            // Paso 3: Mandar correo de confirmación al cliente
            // $this->enviarCorreoConfirmacion($clienteId);

            // Paso 4: Vaciar el carrito (aquí debes implementar la lógica correspondiente)

            // Puedes devolver el ID del pedido creado o cualquier otro dato que necesites
            return $pedidoId;
        } catch (PDOException $e) {
            // En caso de error, realizar rollback y lanzar la excepción nuevamente
            $this->db->rollBack();
            throw $e;
        }
    }

    public function confirmarPedido($idPedido){
        $estado = 'confirmado';
        try {
            $stmt = $this->db->prepara("UPDATE pedidos SET estado = :estado WHERE id = :id");
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':id', $idPedido);
            $stmt->execute();
            $this->db->close();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}
