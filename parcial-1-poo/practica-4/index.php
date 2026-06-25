<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "clases/Admin.php";
require_once "clases/Alumno.php";
require_once "clases/Invitado.php";

$usuarios = [];
$mensajeError = "";

try {
    $usuarios[] = new Admin(
        "Josue Antonio Rodriguez Cebreros",
        "josuerodriguezv86@gmail.com"
    );

    $usuarios[] = new Alumno(
        "Juan Pérez",
        "juan.perez@uas.edu.mx",
        "20260001"
    );

    $usuarios[] = new Invitado(
        "Carlos López",
        "carlos.lopez@empresa.com",
        "Empresa Minera"
    );

    $usuarios[] = new Alumno(
        "Usuario Inválido",
        "correo-mal-escrito",
        "20260002"
    );

} catch (Exception $error) {
    $mensajeError = "Error controlado: " . $error->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 4 - POO PHP</title>
</head>
<body>

    <h1>Práctica 4: Integración POO + Herencia + Validaciones + Excepciones</h1>

    <h2>Lista de usuarios</h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Matrícula</th>
                <th>Empresa</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario) { ?>
                <tr>
                    <td><?php echo $usuario->getNombre(); ?></td>
                    <td><?php echo $usuario->getCorreo(); ?></td>
                    <td><?php echo $usuario->getRol(); ?></td>
                    <td>
                        <?php
                        if ($usuario instanceof Alumno) {
                            echo $usuario->getMatricula();
                        } else {
                            echo "—";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($usuario instanceof Invitado) {
                            echo $usuario->getEmpresa();
                        } else {
                            echo "—";
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php if ($mensajeError != "") { ?>
        <p><strong><?php echo $mensajeError; ?></strong></p>
    <?php } ?>

</body>
</html>
