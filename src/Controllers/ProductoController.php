<?php

namespace Controllers;
use Lib\Pages;
use Services\ProductoService;
use Repositories\ProductoRepository;
use Services\PedidoService;
use Repositories\PedidoRepository;


/**
 * Clase ProductoController
 *
 * Esta clase maneja la lógica para las acciones relacionadas con los productos.
 */
class ProductoController{
    private Pages $pages;
    private ProductoService $productoService;
    private PedidoService $pedidoService;

    /**
     * Constructor de ProductoController.
     *
     * Inicializa una nueva instancia de la clase ProductoController.
     */
    public function __construct() {
        $this->pages = new Pages();
        $this->productoService = new ProductoService(new ProductoRepository());
        $this->pedidoService = new PedidoService(new PedidoRepository());
    }

    /**
     * Obtiene productos de manera aleatoria.
     *
     * @return array Los productos obtenidos aleatoriamente.
     */
    public function getRandom() {
        $productos = $this->productoService->getRandom();
        return $productos;
    }

    /**
     * Obtiene todos los productos.
     *
     * @return array Los productos obtenidos.
     */
    public function gestionarProductos() {
        $productos = $this->productoService->getAll();
        $this->pages->render('producto/gestionarProductos', ['productos' => $productos]);
    }
    
    /**
     * Obtiene los productos de una categoría.
     *
     * @param int $id El ID de la categoría.
     * @return array Los productos obtenidos.
     */
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $oferta = $_POST['oferta'];
            $categoriaId = $_POST['categoria_id'];

            $imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                $imagen = $_FILES['imagen'];
            }

            $this->productoService->save($categoriaId, $nombre, $descripcion, $precio, $stock, $imagen);

            header('Location: ' . BASE_URL);
        } else {
            $this->pages->render('producto/crear');
        }
    }


    /**
     * Obtiene los productos de una categoría.
     *
     * @param int $id El ID de la categoría.
     * @return array Los productos obtenidos.
     */
    public function borrar($id) {
        $this->productoService->delete($id);

        header('Location: ' . BASE_URL . 'producto/gestionarProductos');
    }


    /**
     * Obtiene los productos de una categoría.
     *
     * @param int $id El ID de la categoría.
     * @return array Los productos obtenidos.
     */
    public function editar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $categoriaId = $_POST['categoria_id'];
            $imagen = $_POST['imagen'];

            $this->productoService->update($id, $nombre, $descripcion, $precio, $categoriaId, $imagen);

            header('Location: ' . BASE_URL);
        } else {
            $id = $_GET['id'];
            $producto = $this->productoService->getById($id);
            $this->pages->render('producto/editar', ['producto' => $producto]);
        }
    }

    /**
     * Obtiene los productos de una categoría.
     *
     * @param int $id El ID de la categoría.
     * @return array Los productos obtenidos.
     */
    public function verDetalles($id) {
        $producto = $this->productoService->getById($id);
        $this->pages->render('producto/verDetalles', ['producto' => $producto]);
    }
}
