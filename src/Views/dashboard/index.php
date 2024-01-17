<section>
    <h1>Productos Destacados</h1>
    <div class="slider2">
        <div class="slides2">
        <?php foreach ($productos as $producto): ?>
            <div class="slide2" id="slide1">
                <a href="<?=BASE_URL?>producto/verDetalles/?id=<?=$producto['id']?>"><img src="<?=BASE_URL?>UPLOADS/<?=$producto['imagen']?>" class="slide2-img"></a>
                <h3><?=$producto['nombre']?></h3>
                <h2><?=$producto['precio']?>€</h2>
            </div>
            <?php endforeach;?>
        </div>
    <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
    <button class="next" onclick="changeSlide(1)">&#10095;</button>
</div>
</section>