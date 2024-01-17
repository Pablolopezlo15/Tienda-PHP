
<?php use Utils\Utils;?>
<?php if(isset($_SESSION['categoria']) && $_SESSION['categoria'] == 'complete'): ?>
    <strong>Categoria creada correctamente</strong>
<?php elseif(isset($_SESSION['categoria']) && $_SESSION['categoria'] == 'failed'):?>
    <strong>No se ha podido crear la categoria</strong>
<?php endif;?>
<?php Utils::deleteSession('categoria');?>
<section>
<h1>Crear nueva categoría</h1>
<form action="<?=BASE_URL?>categoria/crear/" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" required>

    <input type="submit" value="Crear" required>
</form>
</section>
