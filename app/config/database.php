<?php
namespace App\Config;

class Database {
    private static $instance = null;
    private $conn;
    private $host = '127.0.0.1';
    private $dbname = 'parcial_itech';
    private $username = 'root';
    private $password = '';
    
    private function __construct() {
        try {
            $this->conn = new \PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
    
    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function fetchOne($sql, $params = []) {
        return $this->query($sql, $params)->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $this->query($sql, $data);
        return $this->conn->lastInsertId();
    }
    
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
}
?>