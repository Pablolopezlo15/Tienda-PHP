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
}