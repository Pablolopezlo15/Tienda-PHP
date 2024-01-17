<?php

//Incluir el modelo de pedidos
namespace Controllers;

use Repositories\PedidoRepository;
use Utils\Utils;
use Lib\Pages;
use Services\PedidoService;

// definir clase controladora
class PedidoController {
    private Pages $pages;
    private PedidoService $pedidoService;
    
    public function __construct() {
        $this->pages = new Pages();
        $this->pedidoService = new PedidoService(new PedidoRepository(/* ... pasas la instancia de BaseDatos aquí ... */));
    }

    //Método para mostrar todos los pedidos
    public function mostrarPedido(){
        if(isset($_SESSION['login']) && count($_SESSION['carrito']) >= 1){
            $this->pages->render('pedido/crear');
        } else {
            var_dump('No estás logueado o no tienes productos en el carrito');
        }
    }

    //Método para agregar un pedido a la base de datos
    public function crear () {
        //Si el usuario no está logueado, redirigir a la página de login
        if (!isset($_SESSION['login']) || $_SESSION['carrito'] == "") {
            header('Location: ' . BASE_URL . 'usuario/login');
        }
        //Si el usuario está logueado, crear el pedido
        else {
            //Obtener los datos del formulario
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
            $coste = isset($_POST['coste']) ? $_POST['coste'] : false;
            $estado = 'confirmado';
            $fecha = Utils::getFecha();
            $hora = Utils::getHora();

            //Obtener el usuario logueado
            $usuario = $_SESSION['login'];
            //Obtener el carrito del usuario
            $carrito = $_SESSION['carrito'];
            //Obtener el total del carrito
            $total = $this->pedidoService->getTotalCarrito($carrito);
            //Crear el pedido
            $pedido = $this->pedidoService->save($usuario->id, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito);
            //Vaciar el carrito
            unset($_SESSION['carrito']);
            //Redirigir a la página de mis pedidos
            // header('Location: ' . BASE_URL . 'pedido/misPedidos');
        }
    }

}
