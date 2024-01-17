<?php

namespace Controllers;
use Models\Usuario;
use Lib\Pages;
use Utils\Utils;
use Services\UsuarioService;
use Repositories\UsuarioRepository;

class UsuarioController {
    private Pages $pages;
    private UsuarioService $usuarioService;

    /**
     * @param Pages $pages
     */
    public function __construct()
    {
        $this->pages = new Pages();
        $this->usuarioService = new UsuarioService(new UsuarioRepository());
    }

    public function registro(){
        if (($_SERVER['REQUEST_METHOD']) === 'POST'){
            if ($_POST['data']){
                $registrado = $_POST['data'];

                $registrado['password'] = password_hash($registrado['password'], PASSWORD_BCRYPT, ['cost'=>4]);

                $usuario = Usuario::fromArray($registrado);

                $save = $this->usuarioService->create($usuario);
                if ($save){
                    $_SESSION['register'] = "complete";
                } else {
                    $_SESSION['register'] = "failed";
                }

            } else {
                $_SESSION['register'] = "failed";
            }
            $usuario->desconecta();
        }

        $this->pages->render('/usuario/registro');
    }

    public function login(){
        if (($_SERVER['REQUEST_METHOD']) === 'POST'){
            if ($_POST['data']){
                $login = $_POST['data'];

                $usuario = Usuario::fromArray($login);

                $verify = $this->usuarioService->login($usuario);

                if ($verify!=false){
                    $_SESSION['login'] = $verify;
                } else {
                    $_SESSION['login'] = "failed";
                }

            } else {
                $_SESSION['login'] = "failed";
            }
        }

        $this->pages->render('/usuario/login');
    }

    public function logout(){
        Utils::deleteSession('login');
        // Utils::deleteSession('carrito');
        
        header("Location:".BASE_URL);
    }

}