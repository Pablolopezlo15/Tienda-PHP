<?php
use Controllers\CategoriaController;
use Controllers\ProductoController;
use Models\Producto;

$categoriaId = $_GET['id'];
$categoriaController = new CategoriaController();
$productoId = $_GET['id'];

if (empty($productos)): ?>
    <p>No hay productos en esta categoría</p>
<?php else: ?>
    <div class="productos container">
        <?php foreach ($productos as $producto): ?>
            <div class="producto">
                <div class="producto-img">
                    <a href="<?=BASE_URL?>producto/verDetalles/?id=<?=$producto['id']?>"><img src="<?=BASE_URL?>UPLOADS/<?=$producto['imagen']?>" alt=""></a>
                </div>
                <div class="producto-content">
                    <h3><?= $producto['nombre'] ?></h3>
                    <div class="precio">
                        <p>Precio: <b><?= $producto['precio'] ?>€</b></p>
                        <a class="añadirCarrito button" href="<?=BASE_URL?>carrito/agregarProducto/?id=<?=$producto['id']?>">
                            <div class="text">Añadir</div>
                            <span class="icon">
                                <i class="ri-shopping-cart-line"></i>
                            </span>
                        </a>
                    </div>
                    <?php if (isset($_SESSION['login']) AND $_SESSION['login']->rol=='admin'):?>
                        <a href="<?=BASE_URL?>producto/borrar/?id=<?=$producto['id']?>">Borrar Producto</a>
                        <a href="<?=BASE_URL?>producto/editar/?id=<?=$producto['id']?>">Editar Producto</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>