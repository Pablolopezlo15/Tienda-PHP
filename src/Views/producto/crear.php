<?php use Utils\Utils;?>
    <?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == 'complete'): ?>
        <strong>Producto creado correctamente</strong>
    <?php elseif(isset($_SESSION['producto']) && $_SESSION['producto'] == 'failed'):?>
        <strong>No se ha podido crear el producto</strong>
    <?php endif;?>
    <?php Utils::deleteSession('producto');?>
    <section>
        <h1>Crear nuevo producto</h1>
        <form action="<?=BASE_URL?>producto/crear/" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
        
            <label for="descripcion">Descripcion</label>
            <textarea name="descripcion" id="descripcion" cols="30" rows="10" required></textarea>
        
            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" required>
        
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" required>
        
            <label for="oferta">Oferta</label>
            <select name="oferta" id="oferta">
                <option value="si">Si</option>
                <option value="no">No</option>
            </select>
        
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" id="imagen" required>
        
            <label for="categoria">Categoria</label>
            <select name="categoria_id" id="categoria" required>
                <?php foreach ($categoria as $categorias): ?>
                    <option value="<?=$categorias['id']?>"><?=$categorias['nombre']?></option>
                <?php endforeach;?>
            </select>
                
            <input type="submit" value="Crear" required>
        </form>
    </section>
