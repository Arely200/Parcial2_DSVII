-- SQL de creación de la base de datos parcial_itech
-- Incluye tablas, datos de ejemplo y llaves foráneas necesarias.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS parcial_itech CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE parcial_itech;


-- Tabla de países

DROP TABLE IF EXISTS paises;
CREATE TABLE IF NOT EXISTS paises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    UNIQUE KEY uk_paises_nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de áreas de interés

DROP TABLE IF EXISTS areas_interes;
CREATE TABLE IF NOT EXISTS areas_interes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    UNIQUE KEY uk_areas_interes_nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Tabla de inscriptores

DROP TABLE IF EXISTS inscriptores;
CREATE TABLE IF NOT EXISTS inscriptores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    identidad VARCHAR(20) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    sexo ENUM('Masculino', 'Femenino', 'Otro') NOT NULL,
    pais_residencia_id INT NOT NULL,
    nacionalidad VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL,
    celular VARCHAR(20) NOT NULL,
    observaciones TEXT,
    fecha_registro TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_inscriptores_identidad (identidad),
    UNIQUE KEY uk_inscriptores_correo (correo),
    KEY idx_inscriptores_pais (pais_residencia_id),
    CONSTRAINT fk_inscriptores_paises FOREIGN KEY (pais_residencia_id) REFERENCES paises(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Tabla intermedia de temas tecnológicos

DROP TABLE IF EXISTS inscriptor_temas;
CREATE TABLE IF NOT EXISTS inscriptor_temas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    inscriptor_id INT NOT NULL,
    area_interes_id INT NOT NULL,
    UNIQUE KEY uk_inscriptor_temas (inscriptor_id, area_interes_id),
    KEY idx_inscriptor_temas_inscriptor (inscriptor_id),
    KEY idx_inscriptor_temas_area (area_interes_id),
    CONSTRAINT fk_inscriptor_temas_inscriptores FOREIGN KEY (inscriptor_id) REFERENCES inscriptores(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_inscriptor_temas_areas FOREIGN KEY (area_interes_id) REFERENCES areas_interes(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Datos de ejemplo

INSERT INTO paises (nombre) VALUES
('Panamá'),
('Colombia'),
('Costa Rica'),
('México'),
('Estados Unidos'),
('España'),
('Argentina'),
('Chile'),
('Perú'),
('Venezuela');

INSERT INTO areas_interes (nombre) VALUES
('Desarrollo Web'),
('Inteligencia Artificial'),
('Ciberseguridad'),
('Desarrollo Móvil'),
('Cloud Computing'),
('Big Data'),
('IoT (Internet de las Cosas)'),
('Blockchain'),
('DevOps'),
('Machine Learning');

INSERT INTO inscriptores (identidad, nombre, apellido, edad, sexo, pais_residencia_id, nacionalidad, correo, celular, observaciones)
VALUES
('1234-5678', 'Juan', 'Pérez', 25, 'Masculino', 1, 'Panameña', 'juan@email.com', '61234567', 'Me interesa Ciberseguridad'),
('8765-4321', 'María', 'Gómez', 30, 'Femenino', 2, 'Colombiana', 'maria@email.com', '61234568', 'Quiero aprender Machine Learning'),
('5678-1234', 'Carlos', 'Rodríguez', 22, 'Masculino', 4, 'Mexicana', 'carlos@email.com', '61234569', NULL);

INSERT INTO inscriptor_temas (inscriptor_id, area_interes_id) VALUES
(1, 3),
(2, 10),
(3, 3);

USE parcial_itech;

-- 1) El enunciado pide que TODAS las llaves foráneas usen
--    ON DELETE RESTRICT ON UPDATE CASCADE. La FK de inscriptor_temas
--    hacia inscriptores estaba en CASCADE; se corrige a RESTRICT.
ALTER TABLE inscriptor_temas
    DROP FOREIGN KEY fk_inscriptor_temas_inscriptores;

ALTER TABLE inscriptor_temas
    ADD CONSTRAINT fk_inscriptor_temas_inscriptores
    FOREIGN KEY (inscriptor_id) REFERENCES inscriptores(id)
    ON DELETE RESTRICT ON UPDATE CASCADE;

-- 2) Restricción a nivel de BD para el celular (formato de 8 dígitos),
--    para reforzar el punto de "Restricciones Necesarias a nivel de BD"
--    en el campo de teléfono.
ALTER TABLE inscriptores
    ADD CONSTRAINT chk_inscriptores_celular CHECK (celular REGEXP '^[0-9]{7,8}$');

USE parcial_itech;

ALTER TABLE inscriptores
    ADD COLUMN hash_integridad VARCHAR(64) NULL AFTER observaciones,
    ADD COLUMN firma_digital   TEXT NULL AFTER hash_integridad;

INSERT IGNORE INTO areas_interes (nombre) VALUES ('Python');
