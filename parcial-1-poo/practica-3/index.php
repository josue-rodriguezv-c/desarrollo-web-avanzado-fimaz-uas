<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "clases/Admin.php";
require_once "clases/Alumno.php";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 3 - Validaciones y Excepciones</title>
</head>
<body>

    <h1>Práctica 3: Sistema de Usuarios con Validaciones y Excepciones</h1>

    <h2>Usuarios válidos</h2>

    <?php
    try {
        $admin = new Admin(
            "Josue Antonio Rodriguez Cebreros",
            "josuerodriguezv86@gmail.com"
        );

        echo "<p><strong>Nombre:</strong> " . $admin->getNombre() . "</p>";
        echo "<p><strong>Correo:</strong> " . $admin->getCorreo() . "</p>";
        echo "<p><strong>Rol:</strong> " . $admin->getRol() . "</p>";
        echo "<hr>";

        $alumno = new Alumno(
            "Juan Pérez",
            "juan.perez@uas.edu.mx",
            "20260001"
        );

        echo "<p><strong>Nombre:</strong> " . $alumno->getNombre() . "</p>";
        echo "<p><strong>Correo:</strong> " . $alumno->getCorreo() . "</p>";
        echo "<p><strong>Matrícula:</strong> " . $alumno->getMatricula() . "</p>";
        echo "<p><strong>Rol:</strong> " . $alumno->getRol() . "</p>";

    } catch (Exception $error) {
        echo "<p><strong>Error:</strong> " . $error->getMessage() . "</p>";
    }
    ?>

    <h2>Prueba con usuario inválido</h2>

    <?php
    try {
        $alumnoInvalido = new Alumno(
            "Alumno Incorrecto",
            "correo-invalido",
            "20260002"
        );

        echo "<p>Usuario creado correctamente.</p>";

    } catch (Exception $error) {
        echo "<p><strong>Error controlado:</strong> " . $error->getMessage() . "</p>";
    }
    ?>

</body>
</html>
