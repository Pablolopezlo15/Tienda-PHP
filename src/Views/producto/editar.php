<form method="POST" action="<?=BASE_URL?>producto/editar">
    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?= $producto['nombre'] ?>">
    <label for="descripcion">Descripción:</label>
    <input type="text" id="descripcion" name="descripcion" value="<?= $producto['descripcion'] ?>">
    <label for="precio">Precio:</label>
    <input type="text" id="precio" name="precio" value="<?= $producto['precio'] ?>">
    <label for="categoria_id">Categoría ID:</label>
    <input type="text" id="categoria_id" name="categoria_id" value="<?= $producto['categoria_id'] ?>">
    <label for="imagen">Imagen:</label>
    <input type="text" id="imagen" name="imagen" value="<?= $producto['imagen'] ?>">
    <input type="submit" value="Actualizar">
</form>