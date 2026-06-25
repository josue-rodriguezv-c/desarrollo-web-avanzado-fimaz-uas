<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "controllers/ProductoController.php";

$controller = new ProductoController();

$mensaje = "";
$productoEditar = null;

if (isset($_GET["eliminar"])) {
    $idEliminar = $_GET["eliminar"];

    if ($controller->eliminar($idEliminar)) {
        $mensaje = "Producto eliminado correctamente.";
    } else {
        $mensaje = "Error al eliminar el producto.";
    }
}

if (isset($_GET["editar"])) {
    $idEditar = $_GET["editar"];
    $productoEditar = $controller->obtenerPorId($idEditar);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = !empty($_POST["id"]) ? $_POST["id"] : null;
    $nombre = trim($_POST["nombre"]);
    $descripcion = trim($_POST["descripcion"]);
    $existencia = (int) $_POST["existencia"];
    $precio = (float) $_POST["precio"];

    $producto = new Producto();
    $producto->setId($id);
    $producto->setNombre($nombre);
    $producto->setDescripcion($descripcion);
    $producto->setExistencia($existencia);
    $producto->setPrecio($precio);

    if ($id) {
        if ($controller->actualizar($producto)) {
            $mensaje = "Producto actualizado correctamente.";
        } else {
            $mensaje = "Error al actualizar el producto.";
        }
    } else {
        if ($controller->crear($producto)) {
            $mensaje = "Producto agregado correctamente.";
        } else {
            $mensaje = "Error al agregar el producto.";
        }
    }
}

$productos = $controller->listar();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Productos con PHP PDO y POO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">

    <h1 class="text-center mb-4">CRUD de Productos con PHP, PDO y POO</h1>

    <?php if (!empty($mensaje)) { ?>
        <div class="alert alert-info">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php } ?>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?php echo $productoEditar ? "Editar producto" : "Agregar producto"; ?>
        </div>

        <div class="card-body">
            <form method="POST" action="index.php">
                <input type="hidden" name="id" value="<?php echo $productoEditar["id"] ?? ""; ?>">

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required
                           value="<?php echo $productoEditar["nombre"] ?? ""; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <input type="text" name="descripcion" class="form-control" required
                           value="<?php echo $productoEditar["descripcion"] ?? ""; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Existencia</label>
                    <input type="number" name="existencia" class="form-control" required
                           value="<?php echo $productoEditar["existencia"] ?? ""; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control" required
                           value="<?php echo $productoEditar["precio"] ?? ""; ?>">
                </div>

                <button type="submit" class="btn btn-success">
                    <?php echo $productoEditar ? "Actualizar" : "Guardar"; ?>
                </button>

                <?php if ($productoEditar) { ?>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                <?php } ?>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white">
            Lista de productos
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Existencia</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($productos as $producto) { ?>
                        <tr>
                            <td><?php echo $producto["id"]; ?></td>
                            <td><?php echo htmlspecialchars($producto["nombre"]); ?></td>
                            <td><?php echo htmlspecialchars($producto["descripcion"]); ?></td>
                            <td><?php echo $producto["existencia"]; ?></td>
                            <td>$<?php echo number_format($producto["precio"], 2); ?></td>
                            <td>
                                <a href="index.php?editar=<?php echo $producto["id"]; ?>" class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <a href="index.php?eliminar=<?php echo $producto["id"]; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Seguro que deseas eliminar este producto?');">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php if (empty($productos)) { ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay productos registrados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>
