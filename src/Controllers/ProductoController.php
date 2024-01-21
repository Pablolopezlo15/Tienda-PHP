<?php

namespace Controllers;
use Lib\Pages;
use Services\ProductoService;
use Repositories\ProductoRepository;
use Services\PedidoService;
use Repositories\PedidoRepository;

class ProductoController{
    private Pages $pages;
    private ProductoService $productoService;
    private PedidoService $pedidoService;

    public function __construct() {
        $this->pages = new Pages();
        $this->productoService = new ProductoService(new ProductoRepository());
        $this->pedidoService = new PedidoService(new PedidoRepository());
    }

    public function getRandom() {
        $productos = $this->productoService->getRandom();
        return $productos;
    }

    public function gestionarProductos() {
        // Llamar al servicio para obtener todos los productos
        $productos = $this->productoService->getAll();
        // Mostrar la vista con todos los productos
        $this->pages->render('producto/gestionarProductos', ['productos' => $productos]);
    }
    
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener datos del formulario
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $oferta = $_POST['oferta'];
            $categoriaId = $_POST['categoria_id'];

            // Subir imagen (si se proporciona)
            $imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                $imagen = $_FILES['imagen'];
            }

            // Llamar al servicio para crear el producto
            $this->productoService->save($categoriaId, $nombre, $descripcion, $precio, $stock, $imagen);

            // Redirigir o hacer lo que necesites después de crear el producto
            header('Location: ' . BASE_URL);
        } else {
            $this->pages->render('producto/crear');
        }
    }

    public function borrar($id) {
        // Llamar al servicio para eliminar el producto
        $this->productoService->delete($id);

        // Redirigir o hacer lo que necesites después de eliminar el producto
        header('Location: ' . BASE_URL);
    }



    public function editar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener datos del formulario
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $categoriaId = $_POST['categoria_id'];
            $imagen = $_POST['imagen'];

            // Llamar al servicio para actualizar el producto
            $this->productoService->update($id, $nombre, $descripcion, $precio, $categoriaId, $imagen);

            // Redirigir o hacer lo que necesites después de actualizar el producto
            header('Location: ' . BASE_URL);
        } else {
            // Mostrar el formulario de edición
            $id = $_GET['id'];
            $producto = $this->productoService->getById($id);
            $this->pages->render('producto/editar', ['producto' => $producto]);
        }
    }

    public function verDetalles($id) {
        // Llamar al servicio para obtener los detalles del producto
        $producto = $this->productoService->getById($id);
        // var_dump($producto);
        $this->pages->render('producto/verDetalles', ['producto' => $producto]);
    }
}
