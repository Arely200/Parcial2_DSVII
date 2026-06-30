<?php
namespace App\Models;
use App\Config\Database;

class Tema {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function obtenerTodos() {
        return $this->db->fetchAll("SELECT id, nombre FROM areas_interes ORDER BY nombre");
    }
}
?>