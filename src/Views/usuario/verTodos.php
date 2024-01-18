<section>
    <h1>Usuarios</h1>
    <nav>
        <ul>
            <li><a href="<?=BASE_URL?>usuario/registro/">Nuevo Usuario</a></li>
        </ul>
    </nav>
    <?php if (isset($_SESSION['login']) && $_SESSION['login']->rol == 'admin') :?>
    <table>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario['id'] ?></td>
            <td><?= $usuario['nombre'] ?></td>
            <td><?= $usuario['apellidos'] ?></td>
            <td><?= $usuario['email'] ?></td>
            <td><?= $usuario['rol'] ?></td>
            <td>
                <a href="<?=BASE_URL?>usuario/editar/?id=<?=$usuario['id']?>"><i class="ri-edit-line"></i></a>
                <a href="<?=BASE_URL?>usuario/eliminar/?id=<?=$usuario['id']?>"><i class="ri-delete-bin-2-line"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <strong class="alert_red">No tienes permisos para ver esta página</strong>
    <?php endif; ?>
</section>