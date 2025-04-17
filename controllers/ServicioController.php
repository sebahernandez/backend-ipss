<?php
require_once './models/Servicio.php';

class ServicioController {
    private $servicio;

    public function __construct($db, $useFakeData = false) {
        $this->servicio = new Servicio($db, $useFakeData);
    }

    public function obtenerServicios() {
        $servicios = $this->servicio->obtenerServicios();
        echo json_encode(["data" => $servicios], JSON_UNESCAPED_UNICODE);
    }
}

