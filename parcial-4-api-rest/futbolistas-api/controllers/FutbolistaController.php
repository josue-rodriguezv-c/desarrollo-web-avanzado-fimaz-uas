<?php
// Alumno: Josue Antonio Rodriguez Cebreros

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/Futbolista.php";

class FutbolistaController
{
    private $connection;

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function obtenerTodos()
    {
        $sql = "SELECT * FROM futbolistas ORDER BY id ASC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM futbolistas WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function crear(Futbolista $futbolista)
    {
        $sql = "INSERT INTO futbolistas (nombre, posicion, numero, edad, equipo)
                VALUES (:nombre, :posicion, :numero, :edad, :equipo)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":nombre", $futbolista->getNombre());
        $stmt->bindValue(":posicion", $futbolista->getPosicion());
        $stmt->bindValue(":numero", $futbolista->getNumero(), PDO::PARAM_INT);
        $stmt->bindValue(":edad", $futbolista->getEdad(), PDO::PARAM_INT);
        $stmt->bindValue(":equipo", $futbolista->getEquipo());

        $stmt->execute();

        return $this->connection->lastInsertId();
    }

    public function actualizar(Futbolista $futbolista)
    {
        $sql = "UPDATE futbolistas
                SET nombre = :nombre,
                    posicion = :posicion,
                    numero = :numero,
                    edad = :edad,
                    equipo = :equipo
                WHERE id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":id", $futbolista->getId(), PDO::PARAM_INT);
        $stmt->bindValue(":nombre", $futbolista->getNombre());
        $stmt->bindValue(":posicion", $futbolista->getPosicion());
        $stmt->bindValue(":numero", $futbolista->getNumero(), PDO::PARAM_INT);
        $stmt->bindValue(":edad", $futbolista->getEdad(), PDO::PARAM_INT);
        $stmt->bindValue(":equipo", $futbolista->getEquipo());

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM futbolistas WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
?>
