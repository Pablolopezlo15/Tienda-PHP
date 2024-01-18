<?php use Utils\Utils;?>

<section>
    <h1>Registro</h1>
    <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
        <strong class="exito">Registro completado correctamente</strong>
        <?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'):?>
            <strong class="errores">No se ha podido registrar</strong>
        <?php endif;?>
    <?php Utils::deleteSession('register');?>
    <?php if (!empty($errores)): ?>
        <div class="errores">
            <?php foreach ($errores as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="<?=BASE_URL?>usuario/registro/" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" name="data[nombre]" id="nombre" required>
    
        <label for="apellidos">Apellidos</label>
        <input type="text" name="data[apellidos]" id="apellidos" required>
    
        <?php if(isset($_SESSION['login'])) :?>
            <?php if($_SESSION['login']->rol == 'admin'): ?>
                <label for="rol">Rol</label>
                <select name="data[rol]" id="rol">
                    <option value="admin">Administrador</option>
                    <option value="user">Usuario</option>
                </select>
            <?php endif;?>
        <?php endif;?>
        <label for="email">Email</label>
        <input type="text" name="data[email]" id="email" required>
            
        <label for="password">Contraseña</label>
        <input type="password" name="data[password]" id="password" required>

        <p>Ya tengo una cuenta <a href="<?=BASE_URL?>usuario/login">Inicia Sesión aquí</a></p>
            
        <input type="submit" value="Registrarse" required>
    </form>
</section>
