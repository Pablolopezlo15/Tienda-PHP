<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado</title>
</head>
<body>
    <h1>¡Su pedido ha sido confirmado!</h1>
    <p>Estimado(a) <?php echo htmlspecialchars($nombre); ?>,</p>
    <p>Le informamos que su pedido está ya reparto. Llegará en un plazo de 2 días laborales</p>
    <p>Detalles del pedido:</p>
    <ul>
        <li>ID del pedido: <?php echo htmlspecialchars($idPedido); ?></li>
        <li><table>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
            </tr>
            <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?= $producto['nombre'] ?></td>
                <td><?= $producto['precio'] ?>€</td>
            </tr>
            <?php endforeach; ?>
        </table></li>
        <li>Fecha del pedido: <?php echo htmlspecialchars($fecha) ." ". htmlspecialchars($hora);  ?></li>
    </ul>
    <p>Saludos cordiales, <?=$nombre?></p>
    <p>Tienda de Pablo López Lozano</p>
</body>
</html>
