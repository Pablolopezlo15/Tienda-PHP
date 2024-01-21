<?php
namespace Controllers;
use Models\Producto;
use Models\Categoria;
use Lib\Pages;
use Services\ProductoService;
use Repositories\ProductoRepository;

/**
 * Clase CarritoController
 *
 * Esta clase maneja la lógica para las acciones relacionadas con el carrito.
 */
class CarritoController {
    private Producto $producto;
    private Categoria $categoria;
    private Pages $pages;
    private ProductoService $productoService;

    /**
     * Constructor de CarritoController.
     *
     * Inicializa una nueva instancia de la clase CarritoController.
     */
    public function __construct() {
        $this->productoService = new ProductoService(new ProductoRepository());
        $this->producto = new Producto();
        $this->categoria = new Categoria();
        $this->pages = new Pages();
    }

    /**
     * Agrega un producto al carrito.
     *
     * @param int $id El ID del producto.
     */
    public function agregarProducto() {
        $productoId = $_GET['id'];
        $this->producto->setId($productoId);
        $producto = $this->productoService->getById($productoId);
        if ($producto) {
            $_SESSION['carrito'][$productoId] = $producto;
            $_SESSION['carrito'][$productoId]['cantidad'] = 1;
        }
        header('Location: '.BASE_URL.'carrito/obtenerCarrito/');        
    }

    /**
     * Elimina un producto del carrito.
     *
     * @param int $id El ID del producto.
     */
    public function eliminarProducto($id) {
        $productoId = $id;
        if (isset($_SESSION['carrito'][$productoId])) {
            unset($_SESSION['carrito'][$productoId]);
        }
        header('Location: '.BASE_URL.'carrito/obtenerCarrito/');        
    }

    /**
     * Obtiene los productos del carrito.
     *
     * @return array Los productos obtenidos.
     */
    public function obtenerCarrito() {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        $productos = $_SESSION['carrito'];
        $total = $this->obtenerTotalCarrito();
        $this->pages->render('carrito/ver', ['productos' => $productos, 'total' => $total]);
    }

    /**
     * Vacía el carrito.
     */
    public function vaciarCarrito() {
        unset($_SESSION['carrito']);
    }

    /**
     * Aumenta la cantidad de un producto en el carrito.
     *
     * @param int $id El ID del producto.
     */
    public function aumentarCantidad($id) {
        $productoId = $id;
        if (isset($_SESSION['carrito'][$productoId])) {
            $_SESSION['carrito'][$productoId]['cantidad']++;
        }
        header('Location: '.BASE_URL.'carrito/obtenerCarrito/');        
    }

    /**
     * Disminuye la cantidad de un producto en el carrito.
     *
     * @param int $id El ID del producto.
     */
    public function disminuirCantidad($id) {
        $productoId = $id;
        if (isset($_SESSION['carrito'][$productoId])) {
            $_SESSION['carrito'][$productoId]['cantidad']--;
            if ($_SESSION['carrito'][$productoId]['cantidad'] == 0) {
                unset($_SESSION['carrito'][$productoId]);
            }
        }
        header('Location: '.BASE_URL.'carrito/obtenerCarrito/');        

    }

    /**
     * Obtiene el total del carrito.
     *
     * @return float El total del carrito.
     */
    public function obtenerTotalCarrito() {
        $total = 0;
        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $producto) {
                $total += $producto['precio'] * $producto['cantidad'];
            }
        }
        return $total;
    }

}