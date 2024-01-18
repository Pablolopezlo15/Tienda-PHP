<section>
    <h1>Mis Pedidos</h1>
    <?php if (isset($_SESSION['login']) && $pedidos >= 1): ?>
    <table>
        <tr>
            <th>Id</th>
            <th>Coste</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
            <?php if (isset($_SESSION['login']) && $_SESSION['login']->rol == 'admin'):?>
            <th>Confirmar Pedido</th>
            <?php endif;?>
        </tr>
        <?php foreach ($pedidos as $pedido): ?>
        <tr>
            <td><a href="<?=BASE_URL?>pedido/ver/?id=<?=$pedido['id']?>"><?= $pedido['id'] ?></a></td>
            <td><?= $pedido['coste'] ?>€</td>
            <td><?= $pedido['fecha'] ?></td>
            <td><?= $pedido['hora'] ?></td>
            <td><?= $pedido['estado'] ?></td>
            <?php if (isset($_SESSION['login']) && $_SESSION['login']->rol == 'admin'):?>
            <td><a href="<?=BASE_URL?>pedido/confirmarPedido/?id=<?=$pedido['id']?>"><i class="ri-check-line"></i></a></td>
            <?php endif;?>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <strong class="alert_red">No tienes pedidos</strong>
    <?php endif; ?>
</section>
