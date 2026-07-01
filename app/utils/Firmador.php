<?php
namespace App\Utils;

/**
 * Clase Firmador
 * Genera un hash de integridad y una firma digital (OpenSSL) para los
 * datos sensibles de cada inscriptor (Nombre, Identificación, Correo,
 * Teléfono, Sexo), y permite verificar si esos datos siguen siendo
 * íntegros o si fueron corrompidos/alterados en la base de datos.
 */
class Firmador
{
    private static string $carpetaLlaves = __DIR__ . '/../config/llaves';
    private static string $rutaPrivada;
    private static string $rutaPublica;
    private static bool $entornoListo = false;

    /**
     * Indica a TODAS las funciones openssl_* dónde está el archivo
     * openssl.cnf que viaja con el proyecto (variable de entorno
     * OPENSSL_CONF). Sin esto, en muchas instalaciones de WAMP/XAMPP
     * en Windows las funciones de OpenSSL fallan en silencio.
     */
    private static function prepararEntorno(): void
    {
        if (!self::$entornoListo) {
            putenv('OPENSSL_CONF=' . __DIR__ . '/../config/openssl.cnf');
            self::$entornoListo = true;
        }
    }

    /** Asegura que exista el par de llaves RSA, generándolo si hace falta */
    private static function asegurarLlaves(): void
    {
        self::prepararEntorno();

        if (!is_dir(self::$carpetaLlaves)) {
            mkdir(self::$carpetaLlaves, 0775, true);
        }

        self::$rutaPrivada = self::$carpetaLlaves . '/privada.pem';
        self::$rutaPublica  = self::$carpetaLlaves . '/publica.pem';

        if (!file_exists(self::$rutaPrivada) || !file_exists(self::$rutaPublica)) {
            $recurso = openssl_pkey_new([
                'private_key_bits' => 2048,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
                'config'           => __DIR__ . '/../config/openssl.cnf',
            ]);

            if ($recurso === false) {
                throw new \RuntimeException('No se pudo generar el par de llaves OpenSSL: ' . openssl_error_string());
            }

            openssl_pkey_export($recurso, $llavePrivada, null, [
                'config' => __DIR__ . '/../config/openssl.cnf',
            ]);
            $detalles = openssl_pkey_get_details($recurso);
            $llavePublica = $detalles['key'];

            file_put_contents(self::$rutaPrivada, $llavePrivada);
            file_put_contents(self::$rutaPublica, $llavePublica);
        }
    }

    /**
     * Construye la cadena canónica con los campos sensibles que se
     * desean proteger contra corrupción/alteración.
     */
    public static function construirCadenaIntegridad(array $datos): string
    {
        return implode('|', [
            trim($datos['nombre'] ?? ''),
            trim($datos['apellido'] ?? ''),
            trim($datos['identidad'] ?? ''),
            trim($datos['correo'] ?? ''),
            trim($datos['celular'] ?? ''),
            trim($datos['sexo'] ?? ''),
        ]);
    }

    /** Genera el hash SHA-256 de los datos sensibles */
    public static function generarHash(array $datos): string
    {
        return hash('sha256', self::construirCadenaIntegridad($datos));
    }

    /** Firma digitalmente el hash con la llave privada (OpenSSL) */
    public static function firmar(string $hash): string
    {
        self::asegurarLlaves();
        $llavePrivada = openssl_pkey_get_private(file_get_contents(self::$rutaPrivada));

        if ($llavePrivada === false) {
            throw new \RuntimeException('No se pudo leer la llave privada: ' . openssl_error_string());
        }

        $firma = '';
        $exito = openssl_sign($hash, $firma, $llavePrivada, OPENSSL_ALGO_SHA256);

        if ($exito === false) {
            throw new \RuntimeException('No se pudo firmar el hash: ' . openssl_error_string());
        }

        return base64_encode($firma);
    }

    /** Verifica que una firma corresponda al hash dado (datos no corrompidos) */
    public static function verificarFirma(string $hash, string $firmaBase64): bool
    {
        self::asegurarLlaves();
        $llavePublica = openssl_pkey_get_public(file_get_contents(self::$rutaPublica));

        if ($llavePublica === false) {
            throw new \RuntimeException('No se pudo leer la llave pública: ' . openssl_error_string());
        }

        $firma = base64_decode($firmaBase64);

        $resultado = openssl_verify($hash, $firma, $llavePublica, OPENSSL_ALGO_SHA256);
        return $resultado === 1;
    }

    /**
     * Verifica la integridad completa de un registro de la tabla inscriptores:
     * 1) Recalcula el hash con los datos ACTUALES de la fila.
     * 2) Compara contra el hash guardado al momento de la inscripción.
     * 3) Verifica que la firma digital sea válida con la llave pública.
     * true = verde (íntegro) | false = rojo (corrompido/alterado)
     */
    public static function esIntegro(array $filaInscriptor): bool
    {
        if (empty($filaInscriptor['hash_integridad']) || empty($filaInscriptor['firma_digital'])) {
            return false;
        }

        $hashActual = self::generarHash($filaInscriptor);
        $hashGuardado = $filaInscriptor['hash_integridad'];

        if (!hash_equals($hashGuardado, $hashActual)) {
            return false;
        }

        return self::verificarFirma($hashGuardado, $filaInscriptor['firma_digital']);
    }
}