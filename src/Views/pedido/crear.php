<section>
    <h1>Introduce tus datos para realizar el pedido</h1>
    <form action="<?=BASE_URL?>pedido/crear" method="POST">
        <label for="provincia">Provincia</label>
        <input type="text" name="provincia" required>

        <label for="localidad">Localidad</label>
        <input type="text" name="localidad" required>

        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" required>

        <input type="submit" value="Confirmar Pedido">
    </form>
</section>


