<?php

$host = "localhost";
$db = "escuela";
$user = "root";
$pass = "";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error de conexión.");
}

$mensaje = "";
$detalle = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $simularError = isset($_POST["simular_error"]);

    if ($nombre === "" || $apellido === "" || $correo === "") {
        $mensaje = "⚠️ Todos los campos son obligatorios.";
    } else {
        try {
            $pdo->beginTransaction();

            $sqlAlumno = "INSERT INTO alumnos (nombre, apellido, correo)
                          VALUES (:nombre, :apellido, :correo)";
            $stmtAlumno = $pdo->prepare($sqlAlumno);
            $stmtAlumno->execute([
                "nombre" => $nombre,
                "apellido" => $apellido,
                "correo" => $correo
            ]);

            $idAlumno = (int) $pdo->lastInsertId();

            if ($simularError) {
                throw new Exception("Simulación de error activada: se fuerza rollback.");
            }

            $sqlLog = "INSERT INTO logs_alumnos (idAlumno, accion)
                       VALUES (:idAlumno, :accion)";
            $stmtLog = $pdo->prepare($sqlLog);
            $stmtLog->execute([
                "idAlumno" => $idAlumno,
                "accion" => "ALTA_ALUMNO"
            ]);

            $pdo->commit();

            $mensaje = "✅ Transacción confirmada (COMMIT). Alumno registrado con ID: $idAlumno";
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $mensaje = "❌ Ocurrió un error. Transacción revertida (ROLLBACK).";
            $detalle = $e->getMessage();
        }
    }
}

$alumnos = $pdo->query("SELECT * FROM alumnos ORDER BY idAlumno DESC")->fetchAll();
$logs = $pdo->query("SELECT * FROM logs_alumnos ORDER BY idLog DESC")->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica PDO: Try/Catch y Transacciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.4;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"] {
            width: 280px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            padding: 10px 14px;
            border: 0;
            border-radius: 8px;
            cursor: pointer;
            background: #0b5ed7;
            color: white;
        }

        .msg {
            padding: 10px;
            border-radius: 8px;
            background: #f5f5f5;
        }

        .small {
            font-size: 12px;
            color: #666;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .danger {
            color: #b02a37;
        }
    </style>
</head>
<body>

<h2>Práctica: try/catch y transacciones en PDO + MySQL</h2>

<?php if ($mensaje !== "") { ?>
    <div class="msg">
        <strong><?php echo htmlspecialchars($mensaje); ?></strong>

        <?php if ($detalle !== "") { ?>
            <br>
            <span class="small danger">
                Detalle: <?php echo htmlspecialchars($detalle); ?>
            </span>
        <?php } ?>
    </div>
<?php } ?>

<div class="card">
    <form method="POST">
        <div class="row">
            <div>
                <label>Nombre</label>
                <input type="text" name="nombre" maxlength="15" value="<?php echo htmlspecialchars($_POST["nombre"] ?? "Josue"); ?>">
            </div>

            <div>
                <label>Apellido</label>
                <input type="text" name="apellido" maxlength="10" value="<?php echo htmlspecialchars($_POST["apellido"] ?? "Rodriguez"); ?>">
            </div>

            <div>
                <label>Correo</label>
                <input type="email" name="correo" maxlength="50" value="<?php echo htmlspecialchars($_POST["correo"] ?? "josuerodriguezv86@gmail.com"); ?>">
            </div>
        </div>

        <p>
            <label style="font-weight: normal;">
                <input type="checkbox" name="simular_error" <?php echo isset($_POST["simular_error"]) ? "checked" : ""; ?>>
                Simular error para forzar ROLLBACK
            </label>
            <span class="small">Activa esta opción para comprobar que no se guarda nada si falla un paso.</span>
        </p>

        <button type="submit">Registrar alumno</button>
    </form>
</div>

<div class="card">
    <h3>Alumnos registrados</h3>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
        </tr>

        <?php foreach ($alumnos as $alumno) { ?>
            <tr>
                <td><?php echo $alumno["idAlumno"]; ?></td>
                <td><?php echo htmlspecialchars($alumno["nombre"]); ?></td>
                <td><?php echo htmlspecialchars($alumno["apellido"]); ?></td>
                <td><?php echo htmlspecialchars($alumno["correo"]); ?></td>
            </tr>
        <?php } ?>

        <?php if (empty($alumnos)) { ?>
            <tr>
                <td colspan="4">No hay alumnos registrados.</td>
            </tr>
        <?php } ?>
    </table>
</div>

<div class="card">
    <h3>Logs de alumnos</h3>

    <table>
        <tr>
            <th>ID Log</th>
            <th>ID Alumno</th>
            <th>Acción</th>
            <th>Fecha</th>
        </tr>

        <?php foreach ($logs as $log) { ?>
            <tr>
                <td><?php echo $log["idLog"]; ?></td>
                <td><?php echo $log["idAlumno"]; ?></td>
                <td><?php echo htmlspecialchars($log["accion"]); ?></td>
                <td><?php echo $log["fecha"]; ?></td>
            </tr>
        <?php } ?>

        <?php if (empty($logs)) { ?>
            <tr>
                <td colspan="4">No hay logs registrados.</td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
