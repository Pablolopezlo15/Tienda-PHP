<?php
namespace Services;
use Repositories\CategoriaRepository;

class CategoriaService {
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository) {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function getAll() {
        return $this->categoriaRepository->getAll();
    }

    public function getById($id) {
        return $this->categoriaRepository->getById($id);
    }

    public function save($nombre) {
        return $this->categoriaRepository->save($nombre);
    }

    public function delete($id) {
        return $this->categoriaRepository->delete($id);
    }

    public function editar($id, $nombre) {
        return $this->categoriaRepository->update($id, $nombre);
    }

    public function update($id, $nombre) {
        return $this->categoriaRepository->update($id, $nombre);
    }

}