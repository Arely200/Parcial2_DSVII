<?php
namespace App\Models;
use App\Config\Database;
use App\Utils\Firmador;

class Inscriptor {
    private $db;
    public function __construct() { 
        $this->db = Database::getInstance(); 
    }
    
    public function guardar($data, $temas) {
        try {
            $conn = $this->db->getConnection();
            $conn->beginTransaction();

            // Auditoría de integridad: hash SHA-256 + firma digital OpenSSL
            // sobre los campos sensibles (nombre, apellido, identidad, correo,
            // celular, sexo), para poder detectar después si fueron alterados.
            $hash = Firmador::generarHash($data);
            $firma = Firmador::firmar($hash);

            $inscriptorData = [
                'identidad' => $data['identidad'],
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'edad' => $data['edad'],
                'sexo' => $data['sexo'],
                'pais_residencia_id' => $data['pais_id'],
                'nacionalidad' => $data['nacionalidad'],
                'correo' => $data['correo'],
                'celular' => $data['celular'],
                'observaciones' => $data['observaciones'] ?? null,
                'hash_integridad' => $hash,
                'firma_digital' => $firma,
            ];
            
            $inscriptorId = $this->db->insert('inscriptores', $inscriptorData);
            
            foreach ($temas as $temaId) {
                $this->db->insert('inscriptor_temas', [
                    'inscriptor_id' => $inscriptorId, 
                    'area_interes_id' => $temaId
                ]);
            }
            
            $conn->commit();
            return ['success' => true, 'id' => $inscriptorId];
            
        } catch (\Exception $e) {
            if (isset($conn)) $conn->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    public function obtenerTodos() {
        $sql = "SELECT 
                    i.*, 
                    p.nombre as pais_nombre,
                    GROUP_CONCAT(a.nombre ORDER BY a.nombre SEPARATOR ', ') as temas
                FROM inscriptores i
                LEFT JOIN paises p ON i.pais_residencia_id = p.id
                LEFT JOIN inscriptor_temas it ON i.id = it.inscriptor_id
                LEFT JOIN areas_interes a ON it.area_interes_id = a.id
                GROUP BY i.id 
                ORDER BY i.fecha_registro DESC";
        
        return $this->db->fetchAll($sql);
    }
}
?>