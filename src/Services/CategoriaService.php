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

}