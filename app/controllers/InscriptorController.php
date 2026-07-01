<?php
namespace App\Controllers;

use App\Models\Inscriptor;
use App\Utils\Validator;
use App\Utils\Sanitizer;
use App\Config\Database;

class InscriptorController {

    private function cargarPaises() {
        try {
            return Database::getInstance()->fetchAll(
                "SELECT id, nombre FROM paises ORDER BY nombre"
            ) ?: [];
        } catch (\Exception $e) {
            error_log("Error cargando países: " . $e->getMessage());
            return [];
        }
    }

    private function cargarTemas() {
        try {
            return Database::getInstance()->fetchAll(
                "SELECT id, nombre FROM areas_interes ORDER BY nombre"
            ) ?: [];
        } catch (\Exception $e) {
            error_log("Error cargando temas: " . $e->getMessage());
            return [];
        }
    }

    public function index() {
        $paises = $this->cargarPaises();
        $temas = $this->cargarTemas();
        include __DIR__ . '/../views/formulario.php';
    }

    public function guardar() {
        $errors = [];
        $data = [];

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

        if (!empty($errors)) {
            $paises = $this->cargarPaises();
            $temas = $this->cargarTemas();

            include __DIR__ . '/../views/formulario.php';
            return;
        }

        $result = (new Inscriptor())->guardar($data, $temasSeleccionados);
        if ($result['success']) {
            header('Location: /Parcial2_DSVII/reporte');
        } else {
            echo "Error al guardar: " . htmlspecialchars($result['error']);
        }
        exit();
    }

    public function reporte() {
        try {
            $inscriptores = (new Inscriptor())->obtenerTodos();
            if (!is_array($inscriptores)) $inscriptores = [];
        } catch (\Exception $e) {
            $inscriptores = [];
            error_log("Error en reporte: " . $e->getMessage());
        }
        include __DIR__ . '/../views/reporte.php';
    }

    public function exportarExcel() {
        try {
            $inscriptores = (new Inscriptor())->obtenerTodos();
            if (!is_array($inscriptores)) $inscriptores = [];
        } catch (\Exception $e) {
            $inscriptores = [];
            error_log("Error en exportarExcel: " . $e->getMessage());
        }

        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="reporte_inscriptores.xls"');
        echo "\xEF\xBB\xBF";
        echo '<table border="1"><tr><th>ID</th><th>Identidad</th><th>Nombre</th><th>Apellido</th><th>Edad</th><th>Sexo</th><th>País</th><th>Nacionalidad</th><th>Correo</th><th>Celular</th><th>Temas</th><th>Observaciones</th><th>Fecha</th></tr>';
        foreach ($inscriptores as $row) {
            echo "<tr>"
                . "<td>" . htmlspecialchars((string)$row['id']) . "</td>"
                . "<td>" . htmlspecialchars($row['identidad']) . "</td>"
                . "<td>" . htmlspecialchars($row['nombre']) . "</td>"
                . "<td>" . htmlspecialchars($row['apellido']) . "</td>"
                . "<td>" . htmlspecialchars((string)$row['edad']) . "</td>"
                . "<td>" . htmlspecialchars($row['sexo']) . "</td>"
                . "<td>" . htmlspecialchars($row['pais_nombre'] ?? '') . "</td>"
                . "<td>" . htmlspecialchars($row['nacionalidad']) . "</td>"
                . "<td>" . htmlspecialchars($row['correo']) . "</td>"
                . "<td>" . htmlspecialchars($row['celular']) . "</td>"
                . "<td>" . htmlspecialchars($row['temas'] ?? '') . "</td>"
                . "<td>" . htmlspecialchars($row['observaciones'] ?? '') . "</td>"
                . "<td>" . htmlspecialchars($row['fecha_registro']) . "</td>"
                . "</tr>";
        }
        echo '</table>';
        exit();
    }
}
?>