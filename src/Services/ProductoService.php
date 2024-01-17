<?php
namespace Services;
use Repositories\ProductoRepository;

class ProductoService {
    private $productoRepository;

    public function __construct(ProductoRepository $productoRepository) {
        $this->productoRepository = $productoRepository;
    }

    public function getAll() {
        return $this->productoRepository->getAll();
    }

    public function getRandom() {
        return $this->productoRepository->getRandom();
    }

    public function getByCategoria($categoriaId) {
        return $this->productoRepository->getByCategoria($categoriaId);
    }

    public function getById($id) {
        return $this->productoRepository->getById($id);
    }

    public function save($categoriaId, $nombre, $descripcion, $precio, $stock, $imagen) {
        return $this->productoRepository->save($categoriaId, $nombre, $descripcion, $precio, $stock, $imagen);
    }

    public function delete($productId) {
        return $this->productoRepository->delete($productId);
    }

    public function update($productId, $nombre, $descripcion, $precio, $categoriaId, $imagen) {
        return $this->productoRepository->update($productId, $nombre, $descripcion, $precio, $categoriaId, $imagen);
    }
}
