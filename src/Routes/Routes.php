<?php
namespace Routes;

use Controllers\DashboardController;
use Controllers\CategoriaController;
use Controllers\ProductoController;
use Controllers\UsuarioController;
use Controllers\CarritoController;
use Controllers\ErrorController;
use Controllers\PedidoController;
use Lib\Router;

class Routes {
    public static function index() {
        Router::add('GET', '/', function() {
            return (new DashboardController())->index();
        });

        Router::add('GET', '/categoria/ver/?id=:id', function($id) {
            return (new CategoriaController())->ver($id);
        });

        Router::add('GET', '/categoria/crear', function() {
            return (new CategoriaController())->crear();
        });

        Router::add('POST', '/categoria/crear', function() {
            return (new CategoriaController())->crear();
        });

        Router::add('GET', '/categoria/borrar/?id=:id', function($id) {
            return (new CategoriaController())->borrar($id);
        });

        Router::add('GET', '/categoria/editar/?id=:id', function($id) {
            return (new CategoriaController())->editar($id);
        });

        Router::add('POST', '/categoria/actualizar', function() {
            return (new CategoriaController())->actualizar();
        });

        Router::add('GET', '/categoria/gestionarCategorias', function() {
            return (new CategoriaController())->gestionarCategorias();
        });

        Router::add('GET', '/producto/verDetalles/?id=:id', function($id) {
            return (new ProductoController())->verDetalles($id);
        });

        Router::add('GET', '/producto/crear', function() {
            return (new ProductoController())->crear();
        });

        Router::add('GET', '/producto/borrar/?id=:id', function($id) {
            return (new ProductoController())->borrar($id);
        });

        Router::add('GET', '/producto/editar/?id=:id', function($id) {
            return (new ProductoController())->editar($id);
        });

        Router::add('POST', '/producto/editar', function() {
            return (new ProductoController())->editar();
        });

        Router::add('GET', '/producto/gestionarProductos', function() {
            return (new ProductoController())->gestionarProductos();
        });

        Router::add('GET', '/carrito/agregarProducto/?id=:id', function($id) {
            return (new CarritoController())->agregarProducto($id);
        });

        Router::add('GET', '/carrito/obtenerCarrito', function() {
            return (new CarritoController())->obtenerCarrito();
        });

        Router::add('GET', '/carrito/eliminarProducto/?id=:id', function($id) {
            return (new CarritoController())->eliminarProducto($id);
        });

        Router::add('GET', '/carrito/aumentarCantidad/?id=:id', function($id) {
            return (new CarritoController())->aumentarCantidad($id);
        });

        Router::add('GET', '/carrito/disminuirCantidad/?id=:id', function($id) {
            return (new CarritoController())->disminuirCantidad($id);
        });

        Router::add('GET', '/pedido/crear', function() {
            return (new PedidoController())->crear();
        });

        Router::add('GET', '/pedido/mostrarPedido', function() {
            return (new PedidoController())->mostrarPedido();
        }); 

        Router::add('GET', '/pedido/misPedidos', function() {
            return (new PedidoController())->misPedidos();
        });

        Router::add('GET', '/pedido/todosLosPedidos', function() {
            return (new PedidoController())->todosLosPedidos();
        });

        Router::add('GET', '/pedido/crear', function() {
            return (new PedidoController())->crear();
        });

        Router::add('POST', '/pedido/crear', function() {
            return (new PedidoController())->crear();
        });

        Router::add('GET', '/pedido/confirmarPedido/?id=:id', function($id) {
            return (new PedidoController())->confirmarPedido($id);
        });

        Router::add('GET', '/pedido/eliminar/?id=:id', function($id) {
            return (new PedidoController())->eliminar($id);
        });

        Router::add('GET', '/pedido/editar/?id=:id', function($id) {
            return (new PedidoController())->editar($id);
        });

        Router::add('GET', '/pedido/actualizar', function() {
            return (new PedidoController())->actualizar();
        });

        Router::add('POST', '/pedido/actualizar', function() {
            return (new PedidoController())->actualizar();
        });

        Router::add('GET', '/usuario/login', function() {
            return (new UsuarioController())->login();
        });   

        Router::add('POST', '/usuario/login', function() {
            return (new UsuarioController())->login();
        });

        Router::add('POST', '/usuario/registro', function() {
            return (new UsuarioController())->registro();
        });

        Router::add('GET', '/usuario/registro', function() {
            return (new UsuarioController())->registro();
        });

        Router::add('GET', '/usuario/verTodos', function() {
            return (new UsuarioController())->verTodos();
        });

        Router::add('GET', '/usuario/logout', function() {
            return (new UsuarioController())->logout();
        });

        Router::add('GET', '/usuario/eliminar/?id=:id', function($id) {
            return (new UsuarioController())->eliminar($id);
        });

        Router::add('GET', '/usuario/editar/?id=:id', function($id) {
            return (new UsuarioController())->editar($id);
        });

        Router::add('POST', '/usuario/actualizar', function() {
            return (new UsuarioController())->actualizar();
        });

        Router::add('GET', '/error', function() {
            return (new ErrorController())->error404();
        });

        Router::dispatch();
    }
}