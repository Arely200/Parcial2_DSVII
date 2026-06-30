<?php
namespace App\Utils;

class Sanitizer {
    public static function sanitizeString($value) {
        return trim(htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8'));
    }
    
    public static function sanitizeIdentidad($value) {
        return preg_replace('/[^0-9-]/', '', trim($value));
    }
    
    public static function sanitizeEmail($value) {
        return filter_var(trim($value), FILTER_SANITIZE_EMAIL);
    }
    
    public static function sanitizeCelular($value) {
        return preg_replace('/[^0-9]/', '', trim($value));
    }
    
    public static function sanitizeEdad($value) {
        return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }
    
    public static function sanitizeNombre($value) {
        $value = self::sanitizeString($value);
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }
    
    public static function sanitizeObservaciones($value) {
        return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
    }
    
    public static function sanitizeTemas($temas) {
        if (!is_array($temas)) return [];
        return array_map('intval', $temas);
    }
}
?>