<section>
    <h1>Usuarios</h1>
    <nav>
        <ul>
            <li><button class="boton-auxiliares"><a href="<?=BASE_URL?>usuario/registro/">Nuevo Usuario</a></button></li>
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
            <?php if((isset($_GET['id'])) && ($_GET['id'] == $usuario['id'])): ?>
            <tr>
                <form action="<?=BASE_URL?>usuario/actualizar" method="post">
                    <td><input type="text" name="data[id]" value="<?=$usuario['id']?>"></td>
                    <td><input type="text" name="data[nombre]" value="<?=$usuario['nombre']?>"></td>
                    <td><input type="text" name="data[apellidos]" value="<?=$usuario['apellidos']?>"></td>
                    <td><input type="text" name="data[email]" value="<?=$usuario['email']?>"></td>
                    <td>
                        <select name="data[rol]">
                            <option value="admin" <?=($usuario['rol'] == 'admin') ? 'selected' : ''?>>Admin</option>
                            <option value="user" <?=($usuario['rol'] == 'user') ? 'selected' : ''?>>User</option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="id" value="<?=$usuario['id']?>">
                        <input type="submit" value="Guardar">
                    </td>
                </form>
            </tr>
            <?php else: ?>
            <tr>
                <td><?=$usuario['id']?></td>
                <td><?=$usuario['nombre']?></td>
                <td><?=$usuario['apellidos']?></td>
                <td><?=$usuario['email']?></td>
                <td><?=$usuario['rol']?></td>
                <td>
                    <a href="<?=BASE_URL?>usuario/editar/?id=<?=$usuario['id']?>"><i class="ri-edit-line"></i></a>
                    <a href="<?=BASE_URL?>usuario/eliminar/?id=<?=$usuario['id']?>"><i class="ri-delete-bin-2-line"></i></a>
                </td>
            </tr>
            <?php endif;?>

        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <strong class="alert_red">No tienes permisos para ver esta página</strong>
    <?php endif; ?>
</section>