<?php
//Definiendo la clase modelo para los pedidos, lo que tiene que ver con acciones de 
// usuario en la base de datos se relaciona aquí en el modelo

namespace Models;
use Lib\BaseDatos;
use PDO;

class Pedido{
    //Definiendo propiedades del usuario = Campos de la base de datos
    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;
    
    private $db;
    
    // Constructor
    public function __construct() {
        $this->db = new BaseDatos;
    }
    
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

        
    //Método para seleccionar los productos de la BD
    public function getAll($id) {
        $sql = $this->db->prepara("SELECT * FROM pedidos ORDER BY id DESC;");
        $sql->execute();
        $pedido = $sql->fetchAll(PDO::FETCH_OBJ);
        return $pedido;
    }

    public function getPedidoById($id) {
        $sql = $this->db->prepara("SELECT * FROM pedidos WHERE id = :id ORDER BY id DESC;");
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();
        $pedido = $sql->fetch(PDO::FETCH_OBJ);
        return $pedido;
    }
    
    //Método para seleccionar el ultimo pedido  de la BD por usuario
    public function getOneByUser() {
        //Consulta a la base de datos
        $sql = "SELECT p.id, p.coste FROM pedidos p "
               // . "INNER JOIN lineas_pedidos lp ON lp.pedido_id = p.id "
                . "WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC LIMIT 1;";
        $pedido = $this->db->query($sql);
        return $pedido->fetch_object();
    }
    
    //Método para seleccionar todos los pedidos de la BD por usuario
    public function getAllByUser() {
        //Consulta a la base de datos
        $sql = "SELECT p.* FROM pedidos p "
               // . "INNER JOIN lineas_pedidos lp ON lp.pedido_id = p.id "
                . "WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC ;";
        $pedido = $this->db->query($sql);
        return $pedido;
    }
    
    //Método para obtener productos por pedido
    public function getProductosByPedido($id) {
//        $sql = "SELECT * FROM productos "
//                . "WHERE id IN (SELECT producto_id FROM lineas_pedidos "
//                . "WHERE pedido_id={$id} )";
        
        $sql = "SELECT pr.*, lp.unidades FROM productos pr "
                . "INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id "
                . "WHERE lp.pedido_id={$id}";
        
        $productos = $this->db->query($sql);
        return $productos;
    }
    
    // método para insertar productos
    public function crear() {
        $sql = $this->db->prepare("INSERT INTO pedidos VALUES(NULL, :usuario_id, :provincia, :localidad, :direccion, :coste, 'confirm', CURDATE(), CURTIME());");
    
        $sql->bindParam(':usuario_id', $this->getUsuario_id(), PDO::PARAM_INT);
        $sql->bindParam(':provincia', $this->getProvincia(), PDO::PARAM_STR);
        $sql->bindParam(':localidad', $this->getLocalidad(), PDO::PARAM_STR);
        $sql->bindParam(':direccion', $this->getDireccion(), PDO::PARAM_STR);
        $sql->bindParam(':coste', $this->getCoste(), PDO::PARAM_STR);
    
        $sql->execute();
    }
    
    //Método para inserta datos en la tabla lineas_pedido de la BD
    public function save_linea() {
        // Seleccionar el id del último insert realizado
        $sql = "SELECT LAST_INSERT_ID() AS 'pedido'";
        
        $query= $this->db->query($sql);
        // código para comprobar sí la consulta está bien, solo para depuración
//                    echo $sql;
//                    echo $this->db->error;
//                    die();
        $pedido_id = $query->fetch_object()->pedido;
        
        // Recorrer el array de elementos del pedido en el carrito
        foreach($_SESSION['carrito'] as $elemento) {
            $producto = $elemento['producto'];
            
            //Inserta el pedido en la tabla linea pedidos
            $insert = "INSERT INTO lineas_pedidos VALUE(NULL, {$pedido_id}, {$producto->id}, {$elemento['unidades']});";
            $save = $this->db->query($insert);
        }
       
         
        $result = false;
        if($save){
           $result = true; 
        }
        return $result;
        
    }
    
    //Método para actualizar el pedido
    public function edit() {
        $sql = "UPDATE pedidos";
        $sql .= " SET estado = '{$this->getEstado()}' ";
  
        $sql .= " WHERE id={$this->getId()};";
        $save = $this->db->query($sql);
        // código para comprobar sí la consulta está bien, solo para depuración
//                    echo $sql;
//                    echo $this->db->error;
//                    die();
        
        $result = false;
        if($save){
           $result = true; 
        }
        return $result;
    }
 
}