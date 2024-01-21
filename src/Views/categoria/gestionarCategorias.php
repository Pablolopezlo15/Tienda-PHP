<section>
    <h1>Gestionar Categorías</h1>
    <nav>
        <ul>
            <li><button class="boton-auxiliares"><a href="<?=BASE_URL?>categoria/crear/">Nueva Categoría</a></button></li>
        </ul>
    </nav>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categoria as $categorias): ?>
                <?php if((isset($_GET['id'])) && ($_GET['id'] == $categorias['id'])): ?>
                <tr>
                    <form action="<?=BASE_URL?>categoria/actualizar" method="post">
                        <td><input type="text" name="data[id]" value="<?=$categorias['id']?>"></td>
                        <td><input type="text" name="data[nombre]" value="<?=$categorias['nombre']?>"></td>
                        <td>
                            <input type="hidden" name="id" value="<?=$categorias['id']?>">
                            <input type="submit" value="Guardar">
                        </td>
                    </form>
                </tr>
                <?php else: ?>
                <tr>
                    <td><?= $categorias['id'] ?></td>
                    <td><?= $categorias['nombre'] ?></td>
                    <td>
                        <a href="<?=BASE_URL?>categoria/borrar/?id=<?=$categorias['id']?>">Borrar</a>
                        <a href="<?=BASE_URL?>categoria/editar/?id=<?=$categorias['id']?>">Editar</a>
                    </td>
                </tr>
                <?php endif;?>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>