<?php
namespace Controllers;
use Models\Producto;
use Models\Categoria;
use Lib\Pages;
use Services\ProductoService;
use Repositories\ProductoRepository;

class CarritoController {
    private Producto $producto;
    private Categoria $categoria;
    private Pages $pages;
    private ProductoService $productoService;

    public function __construct() {
        $this->productoService = new ProductoService(new ProductoRepository());
        $this->producto = new Producto();
        $this->categoria = new Categoria();
        $this->pages = new Pages();
    }
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

    public function eliminarProducto($id) {
        $productoId = $id;
        if (isset($_SESSION['carrito'][$productoId])) {
            unset($_SESSION['carrito'][$productoId]);
        }
        header('Location: '.BASE_URL.'carrito/obtenerCarrito/');        
    }

    public function obtenerCarrito() {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        $productos = $_SESSION['carrito'];
        $total = $this->obtenerTotalCarrito();
        $this->pages->render('carrito/ver', ['productos' => $productos, 'total' => $total]);
    }

    public function vaciarCarrito() {
        unset($_SESSION['carrito']);
    }

    public function aumentarCantidad($id) {
        $productoId = $id;
        if (isset($_SESSION['carrito'][$productoId])) {
            $_SESSION['carrito'][$productoId]['cantidad']++;
        }
        header('Location: '.BASE_URL.'carrito/obtenerCarrito/');        
    }

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