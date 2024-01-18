<?php
namespace Services;
use Repositories\UsuarioRepository;

class UsuarioService {
    private $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository) {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function create($usuario) {
        return $this->usuarioRepository->create($usuario);
    }

    public function verTodos() {
        return $this->usuarioRepository->verTodos();
    }

    public function login($usuario) {
        return $this->usuarioRepository->login($usuario);
    }

    public function buscaMail($email) {
        return $this->usuarioRepository->buscaMail($email);
    }

}
