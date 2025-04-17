<?php
class Database {
    private $host = "localhost";
    private $db_name = "consultoria"; // Cambia esto por el nombre real de tu base de datos
    private $username = "root";
    private $password = "root"; // MAMP usa 'root' como contraseña por defecto
    private $port = "8889"; // Puerto de MAMP
    private $conn;
    
    // Nueva propiedad para indicar qué base de datos usar
    private $useAlternativeDb;
    
    public function __construct($useAlternativeDb = false) {
        $this->useAlternativeDb = $useAlternativeDb;
        
        // Si se usa la base de datos alternativa, cambia la configuración
        if ($this->useAlternativeDb) {
            $this->db_name = "consultoria_alternativa"; // Nombre de la base de datos alternativa
            // También puedes cambiar otros parámetros si es necesario
            // $this->host = "otro_host";
            // $this->username = "otro_usuario";
            // $this->password = "otra_contraseña";
            // $this->port = "otro_puerto";
        }
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
