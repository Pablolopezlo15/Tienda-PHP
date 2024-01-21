<?php

namespace Controllers;
use Lib\Pages;
use Utils\Utils;
use Models\Categoria;
use Services\ProductoService;
use Repositories\ProductoRepository;
use Services\CategoriaService;
use Repositories\CategoriaRepository;

class CategoriaController{
    private Pages $pages;
    private ProductoService $productoService;
    private CategoriaService $categoriaService;

    public function __construct() {
        $this->pages = new Pages();
        $this->productoService = new ProductoService(new ProductoRepository());
        $this->categoriaService = new CategoriaService(new CategoriaRepository());

    }

    public function obtenerCategorias() {
        return $this->categoriaService->getAll();
    }

    public function ver($id) {
        $categoriaId = $id;
        $productos = $this->productoService->getByCategoria($categoriaId);
        $this->pages->render('categoria/ver', ['productos' => $productos]);
    }

    public function gestionarCategorias() {
        $categorias = $this->categoriaService->getAll();
        $this->pages->render('categoria/gestionarCategorias', ['categorias' => $categorias]);
    }

    public function crear() {
        if (isset($_POST['nombre'])) {
            $categoria = new Categoria();
            $categoria->setNombre($_POST['nombre']);
            $this->categoriaService->save($categoria);

            header('Location: ' . BASE_URL);

        } else {
            $this->pages->render('categoria/crear');
        }
    }

    public function borrar($id) {
        $this->categoriaService->delete($id);
        $this->gestionarCategorias();
    }

    public function editar($id) {
        $categoria = $this->categoriaService->getById($id);
        $this->pages->render('categoria/gestionarCategorias', ['categoria' => $categoria]);

    }

    public function actualizar() {
        if (isset($_POST['data'])) {
            $data = $_POST['data'];
            $id = $data['id'];
            $nombre = $data['nombre'];
            $this->categoriaService->update($id, $nombre);

            $this->gestionarCategorias();
        } 
    }

}