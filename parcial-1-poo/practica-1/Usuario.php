<?php

require_once 'Usuario.php';

$usuario = new Usuario(
    "Josue Antonio Rodriguez Cebreros",
    "josuerodriguezv86@gmail.com"
);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 1 - Usuario</title>
</head>
<body>

    <h1>Práctica 1: Clase Usuario</h1>

    <p><strong>Nombre:</strong> <?php echo $usuario->getNombre(); ?></p>
    <p><strong>Correo:</strong> <?php echo $usuario->getCorreo(); ?></p>

</body>
</html>
