<?php ?>

<h1>Mis Pedidos</h1>

<table>
    <tr>
        <th>Id</th>
        <th>Coste</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Estado</th>
    </tr>
    <?php foreach ($pedidos as $pedido): ?>
    <tr>
        <td><a href="<?=BASE_URL?>pedido/ver/?id=<?=$pedido['id']?>"><?= $pedido['id'] ?></a></td>
        <td><?= $pedido['coste'] ?>€</td>
        <td><?= $pedido['fecha'] ?></td>
        <td><?= $pedido['hora'] ?></td>
        <td><?= $pedido['estado'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>