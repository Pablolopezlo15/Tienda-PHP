<section class="carrito-container">
            <div id="carrito" class="carrito container">
            <h1>Carrito</h1>
                <?php if (isset($errores)): ?>
                    <p class="errores"><?= $errores ?></p>
                <?php endif; ?>
                <table>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                    <?php if (empty($_SESSION['carrito'])): ?>
                        <tr>
                            <td colspan="3">No hay productos en el carrito</td>
                        </tr>
                    <?php else: ?>
                    <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td>
                            <div class="productos-carrito">
                                <img src="<?=BASE_URL?>UPLOADS/<?=$producto['imagen']?>" alt="">
                                <div class="productos-carritoinfo">
                                    <p><?= $producto['nombre'] ?></p>
                                    <p><?= $producto['precio'] ?>€</p>
                                </div>
                            </div>
                        <td>
                            <div class="cantidad-carrito">
                                <div>
                                    <label><a href="<?=BASE_URL?>carrito/disminuirCantidad/?id=<?=$producto['id']?>"> - </a></label>
                                    <label><?= $producto['cantidad'] ?></label>
                                    <label><a href="<?=BASE_URL?>carrito/aumentarCantidad/?id=<?=$producto['id']?>"> + </a></label>
                                </div>
                                
                                <a href="<?=BASE_URL?>carrito/eliminarProducto/?id=<?=$producto['id']?>" class="eliminar"><i class="ri-delete-bin-2-line"></i></a>
                            </div>
                        </td>
                        <td><p><?= $producto['precio'] * $producto['cantidad'] ?>€</p></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </table>
    
                <div class="carrito-total">
                    <div class="pagar">
                        <a href="<?=BASE_URL?>pedido/mostrarPedido">                        
                            <button class="button" data-text="Awesome">
                                <span class="actual-text">&nbsp;Pedido&nbsp;</span>
                                <span aria-hidden="true" class="hover-text">&nbsp;Pedido&nbsp;</span>
                            </button>
                        </a>

                    </div>
                    <div class="total">
                    <?php if (empty($_SESSION['carrito'])): ?>
                        <p>Total: <b>0€</b></p>
                        <p>Número de artículos: 0</p>
                    <?php else: ?>
                        <p>Total: <b><?=$total?>€</b></p>
                        <p>Número de artículos: <?= count($_SESSION['carrito']) ?></p>
                    <?php endif; ?>
                    </div>
                </div>

            </div>
            
        </section>