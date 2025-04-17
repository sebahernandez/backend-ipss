<?php
class Database {
    private $host = "localhost";
    private $db_name = "consultoria"; // Cambia esto por el nombre real de tu base de datos
    private $username = "root";
    private $password = "root"; // MAMP usa 'root' como contraseña por defecto
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=localhost;port=8889;dbname=consultoria" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
