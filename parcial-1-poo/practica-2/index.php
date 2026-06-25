<?php

require_once "Admin.php";

$admin = new Admin("Josue Antonio Rodriguez Cebreros", "josuerodriguezv86@gmail.com");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 2 - Herencia en PHP</title>
</head>
<body>
    <h1>Práctica 2: Herencia y Reutilización de Código en PHP</h1>

    <h2>Datos del administrador</h2>

    <p><strong>Nombre:</strong> <?php echo $admin->getNombre(); ?></p>
    <p><strong>Correo:</strong> <?php echo $admin->getCorreo(); ?></p>
    <p><strong>Rol:</strong> <?php echo $admin->getRol(); ?></p>
</body>
</html>
