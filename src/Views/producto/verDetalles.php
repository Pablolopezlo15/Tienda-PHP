<section class="detalles">
            <div class="detalle">
                <div class="img-detalle">
                    <img src="<?=BASE_URL?>UPLOADS/<?=$producto['imagen']?>" alt="">
                </div>
                <div class="detalle-contenido">
                    <h2><?= $producto['nombre'] ?></h2>
                    <p><?= $producto['descripcion'] ?></p>
                    <!-- <p><b>Valoración {{ producto.rating.rate }} <i class="ri-star-line"></i></b></p> -->
                    <div class="precio-detalles">
                        <p class="preciodetalle">Precio: <b><?=$producto['precio'] ?>€</b></p>
                        <a class="añadirCarrito button" href="<?=BASE_URL?>carrito/agregarProducto/?id=<?=$producto['id']?>">
                            <div class="text">Añadir</div>
                            <span class="icon">
                              <i class="ri-shopping-cart-line"></i>
                            </span>
                        </a>
                    </div>
    
                </div>
            </div>

        </section>