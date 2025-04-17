<?php
class Servicio {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerServicios() {
        $query = "SELECT id, nombre_es, nombre_en, descripcion_es, descripcion_en FROM servicios";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $servicios = [];

        foreach ($result as $row) {
            $servicios[] = [
                "id" => $row["id"],
                "nombre" => [
                    "es" => $row["nombre_es"],
                    "en" => $row["nombre_en"]
                ],
                "descripcion" => [
                    "es" => $row["descripcion_es"],
                    "en" => $row["descripcion_en"]
                ]
            ];
        }

        return $servicios;
    }
}
?>
