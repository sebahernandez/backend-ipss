<?php
class Servicio {
    private $conn;
    private $useFakeData;

    public function __construct($db, $useFakeData = false) {
        $this->conn = $db;
        $this->useFakeData = $useFakeData;
    }

    public function obtenerServicios() {
        // Si se seleccionó usar datos falsos, devolver datos hardcoded
        if ($this->useFakeData) {
            require_once './config/fake_data.php';
            return FakeData::getServicios();
        }

        // De lo contrario, usar la base de datos real
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
