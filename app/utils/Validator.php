<?php
namespace App\Utils;

class Validator {
    public static function validateRequired($value) {
        return !empty(trim($value));
    }
    
    public static function validateIdentidad($value) {
        return preg_match('/^[0-9]{4}-?[0-9]{4}$/', $value);
    }
    
    public static function validateEmail($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    public static function validateCelular($value) {
        return preg_match('/^[0-9]{8}$/', $value);
    }
    
    public static function validateEdad($value) {
        $edad = (int)$value;
        return $edad >= 18 && $edad <= 120;
    }
    
    public static function validateSexo($value) {
        return in_array($value, ['Masculino', 'Femenino', 'Otro']);
    }
    
    public static function validatePais($value) {
        return is_numeric($value) && $value > 0;
    }
    
    public static function validateTemas($value) {
        return is_array($value) && !empty($value);
    }
}
?>