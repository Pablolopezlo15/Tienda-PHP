<?php use Utils\Utils;?>
<?php if(isset($_SESSION['login']) && $_SESSION['login'] == 'complete'): ?>
    <h3>Login completado correctamente</h3>
<?php elseif(isset($_SESSION['login']) && $_SESSION['login'] == 'failed'):?>
    <strong>No se ha podido iniciar sesión</strong>
    <?php Utils::deleteSession('login'); ?>
<?php endif;?>

<?php if(!isset($_SESSION['login']) OR $_SESSION['login'] == 'failed'):?>
<form action="<?=BASE_URL?>usuario/login/" method="POST">
    <label for="email">Email</label>
    <input type="email" name="data[email]" id="email" required>

    <label for="password">Contraseña</label>
    <input type="password" name="data[password]" id="password" required>

    <input type="submit" value="Login" required>
</form>
<?php endif;?>