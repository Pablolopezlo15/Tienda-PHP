<section>
    <h1>Gestionar Productos</h1>
    <nav>
        <ul>
            <li><button class="boton-auxiliares"><a href="<?=BASE_URL?>producto/crear/">Nuevo Producto</a></button></li>
        </ul>
    </nav>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($productos as $producto): ?>
                <tr>
                    <td><?= $producto['nombre'] ?></td>
                    <td><?= $producto['descripcion'] ?></td>
                    <td><?= $producto['precio'] ?></td>
                    <td><?= $producto['stock'] ?></td>
                    <td>
                        <a href="<?=BASE_URL?>producto/borrar/?id=<?=$producto['id']?>">Borrar</a>
                        <a href="<?=BASE_URL?>producto/editar/?id=<?=$producto['id']?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>