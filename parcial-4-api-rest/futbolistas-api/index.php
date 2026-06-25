<?php
// Alumno: Josue Antonio Rodriguez Cebreros
// Evaluación parcial: Desarrollo de API REST en PHP

header("Content-Type: application/json; charset=UTF-8");

require_once "controllers/FutbolistaController.php";

$controller = new FutbolistaController();

$method = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$uri = trim($uri, "/");
$partes = explode("/", $uri);

$recurso = end($partes);
$id = null;

if (count($partes) >= 2 && is_numeric(end($partes))) {
    $id = (int) end($partes);
    $recurso = $partes[count($partes) - 2];
}

function responder($codigo, $datos)
{
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

function obtenerDatosJson()
{
    $json = file_get_contents("php://input");
    return json_decode($json, true);
}

function validarDatos($datos)
{
    if (
        !isset($datos["nombre"]) ||
        !isset($datos["posicion"]) ||
        !isset($datos["numero"]) ||
        !isset($datos["edad"]) ||
        !isset($datos["equipo"])
    ) {
        return "Todos los campos son obligatorios.";
    }

    if (trim($datos["nombre"]) === "") {
        return "El nombre no puede estar vacío.";
    }

    if (trim($datos["posicion"]) === "") {
        return "La posición no puede estar vacía.";
    }

    if (!is_numeric($datos["numero"]) || $datos["numero"] <= 0) {
        return "El número debe ser mayor a 0.";
    }

    if (!is_numeric($datos["edad"]) || $datos["edad"] < 0) {
        return "La edad no puede ser negativa.";
    }

    if (trim($datos["equipo"]) === "") {
        return "El equipo no puede estar vacío.";
    }

    return null;
}

if ($recurso !== "futbolistas") {
    responder(404, [
        "error" => true,
        "mensaje" => "Endpoint no encontrado"
    ]);
}

try {
    switch ($method) {
        case "GET":
            if ($id === null) {
                $futbolistas = $controller->obtenerTodos();

                responder(200, [
                    "error" => false,
                    "mensaje" => "Lista de futbolistas",
                    "data" => $futbolistas
                ]);
            } else {
                $futbolista = $controller->obtenerPorId($id);

                if (!$futbolista) {
                    responder(404, [
                        "error" => true,
                        "mensaje" => "Futbolista no encontrado"
                    ]);
                }

                responder(200, [
                    "error" => false,
                    "mensaje" => "Futbolista encontrado",
                    "data" => $futbolista
                ]);
            }
            break;

        case "POST":
            $datos = obtenerDatosJson();

            if (!$datos) {
                responder(400, [
                    "error" => true,
                    "mensaje" => "JSON inválido"
                ]);
            }

            $errorValidacion = validarDatos($datos);

            if ($errorValidacion !== null) {
                responder(400, [
                    "error" => true,
                    "mensaje" => $errorValidacion
                ]);
            }

            $futbolista = new Futbolista(
                null,
                $datos["nombre"],
                $datos["posicion"],
                (int) $datos["numero"],
                (int) $datos["edad"],
                $datos["equipo"]
            );

            $nuevoId = $controller->crear($futbolista);

            responder(201, [
                "error" => false,
                "mensaje" => "Futbolista creado correctamente",
                "id" => $nuevoId
            ]);
            break;

        case "PUT":
            if ($id === null) {
                responder(400, [
                    "error" => true,
                    "mensaje" => "Debes indicar el ID del futbolista"
                ]);
            }

            $existe = $controller->obtenerPorId($id);

            if (!$existe) {
                responder(404, [
                    "error" => true,
                    "mensaje" => "Futbolista no encontrado"
                ]);
            }

            $datos = obtenerDatosJson();

            if (!$datos) {
                responder(400, [
                    "error" => true,
                    "mensaje" => "JSON inválido"
                ]);
            }

            $errorValidacion = validarDatos($datos);

            if ($errorValidacion !== null) {
                responder(400, [
                    "error" => true,
                    "mensaje" => $errorValidacion
                ]);
            }

            $futbolista = new Futbolista(
                $id,
                $datos["nombre"],
                $datos["posicion"],
                (int) $datos["numero"],
                (int) $datos["edad"],
                $datos["equipo"]
            );

            $controller->actualizar($futbolista);

            responder(200, [
                "error" => false,
                "mensaje" => "Futbolista actualizado correctamente"
            ]);
            break;

        case "DELETE":
            if ($id === null) {
                responder(400, [
                    "error" => true,
                    "mensaje" => "Debes indicar el ID del futbolista"
                ]);
            }

            $existe = $controller->obtenerPorId($id);

            if (!$existe) {
                responder(404, [
                    "error" => true,
                    "mensaje" => "Futbolista no encontrado"
                ]);
            }

            $controller->eliminar($id);

            responder(200, [
                "error" => false,
                "mensaje" => "Futbolista eliminado correctamente"
            ]);
            break;

        default:
            responder(405, [
                "error" => true,
                "mensaje" => "Método no permitido"
            ]);
    }
} catch (Exception $e) {
    responder(500, [
        "error" => true,
        "mensaje" => "Error interno del servidor"
    ]);
}
?>
