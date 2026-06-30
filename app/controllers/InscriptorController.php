<?php
namespace App\Controllers;

use App\Models\Inscriptor;
use App\Utils\Validator;
use App\Utils\Sanitizer;

class InscriptorController {
    
    // ============================================================
    // FUNCIÓN PARA CARGAR PAÍSES (CONEXIÓN DIRECTA)
    // ============================================================
    private function cargarPaises() {
        try {
            $pdo = new \PDO('mysql:host=127.0.0.1;dbname=parcial_itech;charset=utf8', 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $result = $pdo->query("SELECT id, nombre FROM paises ORDER BY nombre")->fetchAll(\PDO::FETCH_ASSOC);
            return $result ?: [];
        } catch (\Exception $e) {
            error_log("Error cargando países: " . $e->getMessage());
            return [];
        }
    }
    
    // ============================================================
    // FUNCIÓN PARA CARGAR TEMAS (CONEXIÓN DIRECTA)
    // ============================================================
    private function cargarTemas() {
        try {
            $pdo = new \PDO('mysql:host=127.0.0.1;dbname=parcial_itech;charset=utf8', 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $result = $pdo->query("SELECT id, nombre FROM areas_interes ORDER BY nombre")->fetchAll(\PDO::FETCH_ASSOC);
            return $result ?: [];
        } catch (\Exception $e) {
            error_log("Error cargando temas: " . $e->getMessage());
            return [];
        }
    }
    
    // ============================================================
    // MÉTODO INDEX
    // ============================================================
    public function index() {
        $paises = $this->cargarPaises();
        $temas = $this->cargarTemas();
        
        // Debug
        error_log("Países cargados: " . count($paises));
        error_log("Temas cargados: " . count($temas));
        
        include __DIR__ . '/../views/formulario.php';
    }
    
    // ============================================================
    // MÉTODO GUARDAR
    // ============================================================
    public function guardar() {
        $errors = [];
        $data = [];
        
        // Sanitización
        $data['identidad'] = Sanitizer::sanitizeIdentidad($_POST['identidad'] ?? '');
        $data['nombre'] = Sanitizer::sanitizeNombre($_POST['nombre'] ?? '');
        $data['apellido'] = Sanitizer::sanitizeNombre($_POST['apellido'] ?? '');
        $data['edad'] = Sanitizer::sanitizeEdad($_POST['edad'] ?? 0);
        $data['sexo'] = Sanitizer::sanitizeString($_POST['sexo'] ?? '');
        $data['pais_id'] = (int)($_POST['pais_id'] ?? 0);
        $data['nacionalidad'] = Sanitizer::sanitizeString($_POST['nacionalidad'] ?? '');
        $data['correo'] = Sanitizer::sanitizeEmail($_POST['correo'] ?? '');
        $data['celular'] = Sanitizer::sanitizeCelular($_POST['celular'] ?? '');
        $data['observaciones'] = Sanitizer::sanitizeObservaciones($_POST['observaciones'] ?? '');
        $temasSeleccionados = Sanitizer::sanitizeTemas($_POST['temas'] ?? []);
        
        // Validaciones
        if (!Validator::validateRequired($data['nombre'])) {
            $errors['nombre'] = 'El nombre es obligatorio';
        }
        if (!Validator::validateRequired($data['apellido'])) {
            $errors['apellido'] = 'El apellido es obligatorio';
        }
        if (!Validator::validateIdentidad($data['identidad'])) {
            $errors['identidad'] = 'Identidad inválida (formato: 1234-5678)';
        }
        if (!Validator::validateEmail($data['correo'])) {
            $errors['correo'] = 'Correo electrónico inválido';
        }
        if (!Validator::validateCelular($data['celular'])) {
            $errors['celular'] = 'Celular inválido (8 dígitos)';
        }
        if (!Validator::validateEdad($data['edad'])) {
            $errors['edad'] = 'Edad debe ser entre 18 y 120 años';
        }
        if (!Validator::validateSexo($data['sexo'])) {
            $errors['sexo'] = 'Seleccione un sexo válido';
        }
        if (!Validator::validatePais($data['pais_id'])) {
            $errors['pais_id'] = 'Seleccione un país válido';
        }
        if (!Validator::validateTemas($temasSeleccionados)) {
            $errors['temas'] = 'Seleccione al menos un tema';
        }
        
        // Si hay errores, volver al formulario
        if (!empty($errors)) {
            $paises = $this->cargarPaises();
            $temas = $this->cargarTemas();
            
            include __DIR__ . '/../views/formulario.php';
            return;
        }
        
        // Guardar
        $result = (new Inscriptor())->guardar($data, $temasSeleccionados);
        if ($result['success']) {
            header('Location: /Parcial2_DSVII/reporte');
        } else {
            echo "Error al guardar: " . $result['error'];
        }
        exit();
    }
    
    // ============================================================
    // MÉTODO REPORTE
    // ============================================================
    public function reporte() {
        try {
            $inscriptores = (new Inscriptor())->obtenerTodos();
            if (!is_array($inscriptores)) $inscriptores = [];
        } catch (Exception $e) {
            $inscriptores = [];
            error_log("Error en reporte: " . $e->getMessage());
        }
        include __DIR__ . '/../views/reporte.php';
    }
    
    // ============================================================
    // MÉTODO EXPORTAR EXCEL
    // ============================================================
    public function exportarExcel() {
        try {
            $inscriptores = (new Inscriptor())->obtenerTodos();
            if (!is_array($inscriptores)) $inscriptores = [];
        } catch (Exception $e) {
            $inscriptores = [];
            error_log("Error en exportarExcel: " . $e->getMessage());
        }
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="reporte_inscriptores.xls"');
        echo '<table border="1"><tr><th>ID</th><th>Identidad</th><th>Nombre</th><th>Apellido</th><th>Edad</th><th>Sexo</th><th>País</th><th>Nacionalidad</th><th>Correo</th><th>Celular</th><th>Temas</th><th>Observaciones</th><th>Fecha</th></tr>';
        foreach ($inscriptores as $row) {
            echo "<tr><td>{$row['id']}</td><td>{$row['identidad']}</td><td>{$row['nombre']}</td><td>{$row['apellido']}</td><td>{$row['edad']}</td><td>{$row['sexo']}</td><td>{$row['pais_nombre']}</td><td>{$row['nacionalidad']}</td><td>{$row['correo']}</td><td>{$row['celular']}</td><td>{$row['temas']}</td><td>{$row['observaciones']}</td><td>{$row['fecha_registro']}</td></tr>";
        }
        echo '</table>';
        exit();
    }
    
    // ============================================================
    // FIRMA DIGITAL
    // ============================================================
    public function firmarReporte($datos) {
        $privateKeyPath = __DIR__ . '/../../private_key.pem';
        $publicKeyPath = __DIR__ . '/../../public_key.pem';
        
        if (!file_exists($privateKeyPath) || !file_exists($publicKeyPath)) {
            return [
                'success' => false,
                'error' => 'Las claves OpenSSL no existen. Ejecuta: php generar_claves.php'
            ];
        }
        
        $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyPath));
        
        if (!$privateKey) {
            return ['success' => false, 'error' => 'No se pudo cargar la clave privada'];
        }
        
        $dataString = json_encode($datos);
        $hash = hash('sha256', $dataString);
        
        $signature = '';
        openssl_sign($hash, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $signatureBase64 = base64_encode($signature);
        
        $publicKey = openssl_pkey_get_public(file_get_contents($publicKeyPath));
        $verification = openssl_verify($hash, $signature, $publicKey, OPENSSL_ALGO_SHA256);
        
        return [
            'success' => true,
            'hash' => $hash,
            'firma' => $signatureBase64,
            'verificada' => $verification === 1,
            'fecha' => date('Y-m-d H:i:s')
        ];
    }
}
?>