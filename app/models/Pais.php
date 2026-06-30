<?php
namespace App\Models;
use App\Config\Database;

class Pais {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function obtenerTodos() {
        return $this->db->fetchAll("SELECT id, nombre FROM paises ORDER BY nombre");
    }
}
?>