<?php
    use Controllers\CategoriaController;
    $categoria = (new CategoriaController())->obtenerCategorias();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tienda Pablo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.7.0/remixicon.css"></link>
    <!-- <link rel="stylesheet" href="<?=BASE_URL?>/src/css/styles.css"> -->
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/normalize.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/styles2.css">
</head>
<body>

    <header>
        <nav>
            <div class="navbar">
                <div class="nav-container">
                    <div>
                    </div>
                    <input class="checkbox" type="checkbox" name="" id="checkbox" />
                    <div class="hamburger-lines">
                        <span class="line line1"></span>
                        <span class="line line2"></span>
                        <span class="line line3"></span>
                    </div>  

                    <div class="nav-container login">
                        <?php if (!isset($_SESSION['login']) OR $_SESSION['login']=='failed'):?>
                            <a href="<?=BASE_URL?>usuario/login/">Identificarse</a>
                            <a href="<?=BASE_URL?>usuario/registro/">Registrarse</a>
                        <?php else:?>
                            <p><?=$_SESSION['login']->nombre?> <?=$_SESSION['login']->apellidos?></p>
                            <a href="<?=BASE_URL?>usuario/logout/">Cerrar Sesión</a>
                            <a href="<?=BASE_URL?>pedido/misPedidos/">Mis Pedidos</a>
                        <?php endif;?>
                        <a href="<?=BASE_URL?>carrito/obtenerCarrito/">
                            <i class="ri-shopping-cart-2-fill"></i>
                            <?= isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0 ?>
                        </a>    
                        <?php if (isset($_SESSION['login']) && is_object($_SESSION['login'])):?>
                            <?php if ($_SESSION['login']->rol == 'admin'):?>
                                <a href="<?=BASE_URL?>usuario/verTodos/">Gestionar Usuarios</a>
                                <a href="<?=BASE_URL?>categoria/verTodos/">Gestionar Categorias</a>
                                <a href="<?=BASE_URL?>categoria/crear/">Crear Categoria</a>
                                <a href="<?=BASE_URL?>producto/crear/">Nuevo Producto</a>
                                <a href="<?=BASE_URL?>pedido/verTodos/">Gestionar Pedidos</a>
                            <?php endif;?>
                        <?php endif;?>
                    </div>
                    <div class="logo">
                        <!-- <a href="#" @click="mostrarLandingPage()"><img src="src/img/logo/pllogo.png" alt=""></a> -->
                    </div>
                    <div class="menu-items" id="categoria">
                        <li><a href="<?= BASE_URL ?>">Home</a></li>
                        <?php foreach ($categoria as $categorias): ?>
                            <li><a href="<?=BASE_URL?>categoria/ver/?id=<?=$categorias['id']?>"><?=$categorias['nombre']?></a></li>
                        <?php endforeach;?>

                    </div>
                </div>
            </div>
        </nav>
    </header>