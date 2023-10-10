SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- crea base de datos
CREATE DATABASE IF NOT EXISTS `medic` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `medic`;

DELIMITER $$

-- procedimiento para ingresar datos de medicos a la tabla medics
CREATE DEFINER=`medic`@`%` PROCEDURE `new_medic` (
    IN `matricul_medic` VARCHAR(255) CHARSET utf8mb4,
    IN `name_medic` VARCHAR(255) CHARSET utf8mb4,
    IN `surname_medic` VARCHAR(255) CHARSET utf8mb4,
    IN `gender_medic` TINYINT,
    IN `day_of_birth_medic` DATE,
    IN `email_medic` VARCHAR(255) CHARSET utf8mb4,
    IN `phone_medic` VARCHAR(255) CHARSET utf8mb4,
    IN `specialty_medic` TINYINT,
    IN `is_active` TINYINT
) COMMENT 'Inserta un nuevo médico'
BEGIN
    DECLARE EXIT HANDLER FOR 1062
    SELECT 'El MÉDICO está repetido, revise el formulario de carga' AS 'mensaje';
    INSERT INTO medics (
        matricul_medic,
        name_medic,
        surname_medic,
        gender_medic,
        day_of_birth_medic,
        email_medic,
        phone_medic,
        specialty_medic,
        is_active
    )
    VALUES (
        matricul_medic,
        name_medic,
        surname_medic,
        gender_medic,
        day_of_birth_medic,
        email_medic,
        phone_medic,
        specialty_medic,
        is_active
    );
    SELECT 'Se insertó un nuevo registro' AS 'mensaje';
END$$

-- procedimiento para ingresar datos de pacientes a la tabla patients
CREATE DEFINER=`medic`@`%` PROCEDURE `new_patient` (
    IN `dni` VARCHAR(50) CHARSET utf8mb4,
    IN `name` VARCHAR(255) CHARSET utf8mb4,
    IN `surname` VARCHAR(255) CHARSET utf8mb4,
    IN `gender` TINYINT,
    IN `day_of_birth` DATE,
    IN `email` VARCHAR(255) CHARSET utf8mb4,
    IN `phone` VARCHAR(255) CHARSET utf8mb4,
    IN `is_active` TINYINT
) COMMENT 'Inserta un nuevo paciente'
BEGIN
    DECLARE EXIT HANDLER FOR 1062
    SELECT 'El PACIENTE está repetido, revise el formulario de carga' AS 'mensaje';
    INSERT INTO patients (
        dni,
        name,
        surname,
        gender,
        day_of_birth,
        email,
        phone,
        is_active
    )
    VALUES (
        dni,
        name,
        surname,
        gender,
        day_of_birth,
        email,
        phone,
        is_active
    );
    SELECT 'Se insertó un nuevo registro' AS 'mensaje';
END$$


-- procedimiento para ingresar datos de pacientes a la tabla patients
CREATE DEFINER=`medic`@`%` PROCEDURE `new_user` (
    IN `dni` VARCHAR(50) CHARSET utf8mb4,
    IN `name` VARCHAR(255) CHARSET utf8mb4,
    IN `surname` VARCHAR(255) CHARSET utf8mb4,
    IN `gender` TINYINT,
    IN `day_of_birth` DATE,
    IN `email` VARCHAR(255) CHARSET utf8mb4,
    IN `phone` VARCHAR(255) CHARSET utf8mb4,
    IN `is_active` TINYINT
) COMMENT 'Inserta un nuevo usuario'
BEGIN
    DECLARE EXIT HANDLER FOR 1062
    SELECT 'El PACIENTE está repetido, revise el formulario de carga' AS 'mensaje';
    INSERT INTO users (
        dni,
        name,
        surname,
        gender,
        day_of_birth,
        email,
        phone,
        is_active
    )
    VALUES (
        dni,
        name,
        surname,
        gender,
        day_of_birth,
        email,
        phone,
        is_active
    );
    SELECT 'Se insertó un nuevo registro' AS 'mensaje';
END$$


-- procedimiento para seleccionar genero
CREATE DEFINER=`medic`@`%` PROCEDURE `select_gender` ()
BEGIN
    SELECT
        genders.gender_id AS "id",
        genders.gender_name AS "name"
    FROM genders;
END$$

-- procedimiento para seleccionar especialidad
CREATE DEFINER=`medic`@`%` PROCEDURE `select_specialty` ()
BEGIN
    SELECT
        specialties.specialty_id AS "id",
        specialties.specialty_name AS "name"
    FROM specialties;
END$$

-- procedimiento para seleccionar estado (activo/inactivo)
CREATE DEFINER=`medic`@`%` PROCEDURE `select_status` ()
BEGIN
    SELECT
        status.state_id AS "id",
        status.state_name AS "name"
    FROM status;
END$$

-- procedimiento para actualizar datos de un medico
CREATE DEFINER=`medic`@`%` PROCEDURE `update_medic` (
    IN `up_matricul` VARCHAR(255) CHARSET utf8mb4,
    IN `up_name` VARCHAR(255) CHARSET utf8mb4, 
    IN `up_surname` VARCHAR(255) CHARSET utf8mb4, 
    IN `up_gender` TINYINT, 
    IN `up_day_of_birth` DATE,
    IN `up_email` VARCHAR(255),
    IN `up_phone` VARCHAR(255),
    IN `up_specialty` TINYINT,
    IN `up_state` TINYINT,
    IN `up_id` INT
) MODIFIES SQL DATA COMMENT 'Actualizar datos de MEDICOS'
BEGIN
    UPDATE medics SET
        matricul_medic = up_matricul,
        name_medic = up_name,
        surname_medic = up_surname,
        gender_medic = up_gender,
        day_of_birth_medic = up_day_of_birth,
        email_medic = up_email,
        phone_medic = up_phone,
        specialty_medic = up_specialty,
        is_active = up_state,
        created_at = CURRENT_TIMESTAMP
    WHERE id_medic = up_id;
    
    SELECT "Se actualizó el registro" AS "mensaje";
END$$

-- procedimiento para actualizar datos de un paciente
CREATE DEFINER=`medic`@`%` PROCEDURE `update_patient` (
    IN `up_dni` VARCHAR(50) CHARSET utf8mb4,
    IN `up_name` VARCHAR(255) CHARSET utf8mb4, 
    IN `up_surname` VARCHAR(255) CHARSET utf8mb4, 
    IN `up_gender` TINYINT, 
    IN `up_day_of_birth` DATE,
    IN `up_email` VARCHAR(255),
    IN `up_phone` VARCHAR(255),
    IN `up_state` TINYINT,
    IN `up_id` INT
) MODIFIES SQL DATA COMMENT 'Actualizar datos de PACIENTES'
BEGIN
    UPDATE patients SET
        dni = up_dni,
        name = up_name,
        surname = up_surname,
        gender = up_gender,
        day_of_birth = up_day_of_birth,
        email = up_email,
        phone = up_phone,
        is_active = up_state,
        created_at = CURRENT_TIMESTAMP
    WHERE id_patient = up_id;
    
    SELECT "Se actualizó el registro" AS "mensaje";
END$$


-- procedimiento para actualizar datos de un paciente
CREATE DEFINER=`medic`@`%` PROCEDURE `update_user` (
    IN `up_dni` VARCHAR(50) CHARSET utf8mb4,
    IN `up_name` VARCHAR(255) CHARSET utf8mb4, 
    IN `up_surname` VARCHAR(255) CHARSET utf8mb4, 
    IN `up_gender` TINYINT, 
    IN `up_day_of_birth` DATE,
    IN `up_email` VARCHAR(255),
    IN `up_phone` VARCHAR(255),
    IN `up_state` TINYINT,
    IN `up_id` INT
) MODIFIES SQL DATA COMMENT 'Actualizar datos de PACIENTES'
BEGIN
    UPDATE users     SET
        dni = up_dni,
        name = up_name,
        surname = up_surname,
        gender = up_gender,
        day_of_birth = up_day_of_birth,
        email = up_email,
        phone = up_phone,
        is_active = up_state,
        created_at = CURRENT_TIMESTAMP
    WHERE id_patient = up_id;
    
    SELECT "Se actualizó el registro" AS "mensaje";
END$$


-- procedimiento para eliminar un usuario
CREATE DEFINER=`medic`@`%` PROCEDURE `delete_user`(IN `id` INT)
BEGIN
    DELETE FROM users WHERE id_user = id;
    
    SELECT "Se eliminó el registro" AS "mensaje";
END$$

-- procedimiento para eliminar un medico
CREATE DEFINER=`medic`@`%` PROCEDURE `delete_medic`(IN `id` INT)
BEGIN
    DELETE FROM medics WHERE id_medic = id;
    
    SELECT "Se eliminó el registro" AS "mensaje";
END$$

-- procedimiento para eliminar un paciente
CREATE DEFINER=`medic`@`%` PROCEDURE `delete_patient`(IN `id` INT)
BEGIN
    DELETE FROM patients WHERE id_patient = id;
    
    SELECT "Se eliminó el registro" AS "mensaje";
END$$

DELIMITER ;

-- =============TABLAS===================

-- Tabla `status`
CREATE TABLE IF NOT EXISTS `status` (
    `state_id` tinyint(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `state_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcado de datos para la tabla `status`
INSERT INTO `status` (`state_id`, `state_name`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- Tabla `genders`
CREATE TABLE IF NOT EXISTS `genders` (
    `gender_id` tinyint(4) NOT NULL PRIMARY KEY,
    `gender_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcado de datos para la tabla `genders`
INSERT INTO `genders` (`gender_id`, `gender_name`) VALUES
(1, 'Masculino'),
(2, 'Femenino'),
(3, 'Otro');

-- Tabla `specialties`
CREATE TABLE IF NOT EXISTS `specialties` (
    `specialty_id` tinyint(4) NOT NULL PRIMARY KEY,
    `specialty_name` varchar(255) NOT NULL

-- Volcado de datos para la tabla `specialties`
INSERT INTO `specialties` (`specialty_id`, `specialty_name`) VALUES
(1, 'Clinico'),
(2, 'Cardiologo'),
(3, 'Traumatologo'),
(4, 'Radiologo'),
(5, 'Ginecologo');) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Tabla `medics`
CREATE TABLE IF NOT EXISTS `medics` (
    `id_medic` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `matricul_medic` VARCHAR(255) NOT NULL UNIQUE,
    `name_medic` VARCHAR(50) NOT NULL,
    `surname_medic` VARCHAR(50) NOT NULL,
    `gender_medic` TINYINT(1) NOT NULL,
    `day_of_birth_medic` DATE NOT NULL,
    `email_medic` VARCHAR(255) NOT NULL,
    `phone_medic` VARCHAR(255) NOT NULL,
    `specialty_medic` TINYINT(1) NOT NULL,
    `is_active` TINYINT(1) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (gender_medic) REFERENCES genders(gender_id),
    FOREIGN KEY (specialty_medic) REFERENCES specialties(specialty_id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_czech_ci;

-- Tabla `patients`
CREATE TABLE IF NOT EXISTS `patients` (
    `id_patient` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `dni` VARCHAR(50) NOT NULL UNIQUE,
    `name` VARCHAR(50) NOT NULL,
    `surname` VARCHAR(50) NOT NULL,
    `gender` TINYINT(1) NOT NULL,
    `day_of_birth` DATE NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(255) NOT NULL,
    `is_active` TINYINT(1) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (gender) REFERENCES genders(gender_id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_czech_ci;

-- Tabla `users`
CREATE TABLE IF NOT EXISTS `users` (
    `id_user` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `dni` VARCHAR(50) NOT NULL UNIQUE,
    `name` VARCHAR(50) NOT NULL,
    `surname` VARCHAR(50) NOT NULL,
    `gender` TINYINT(1) NOT NULL,
    `day_of_birth` DATE NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(255) NOT NULL,
    `is_active` TINYINT(1) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (gender) REFERENCES genders(gender_id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_czech_ci;

CREATE TABLE `listado` (
 `matricul` VARCHAR(255),
 `name` VARCHAR(255),
 `surname` VARCHAR(255),
 `gender` TINYINT,
 `day_of_birth` DATE,
 `email` VARCHAR(255),
 `phone` VARCHAR(255),
 `specialty` TINYINT,
 `status` TINYINT
);

-- Vista `listado`
DROP VIEW IF EXISTS `list_medics`;
CREATE VIEW `list_medics` AS
SELECT
    `medics`.`id_medic` AS `medic_id`,
    `medics`.`matricul_medic` AS `matricul`,
    `medics`.`name_medic` AS `name`,
    `medics`.`surname_medic` AS `surname`,
    `genders`.`gender_id` AS `id_gender`,
    `genders`.`gender_name` AS `gender_name`,
    `medics`.`day_of_birth_medic` AS `day_of_birth`,
    `medics`.`email_medic` AS `email`,
    `medics`.`phone_medic` AS `phone`,
    `specialties`.`specialty_id` AS `id_specialty`,
    `specialties`.`specialty_name` AS `specialty_name`,
    `status`.`state_id` AS `id_state`,
    `status`.`state_name` AS `state_name`
FROM
    `medics`
JOIN
    `genders` ON (`medics`.`gender_medic` = `genders`.`gender_id`)
JOIN
    `specialties` ON (`medics`.`specialty_medic` = `specialties`.`specialty_id`)
JOIN
    `status` ON (`medics`.`is_active` = `status`.`state_id`);

-- Vista `listado_pacientes`
DROP VIEW IF EXISTS `list_patients`;
CREATE VIEW `list_patients` AS
SELECT
    `patients`.`id_patient` AS `patient_id`,
    `patients`.`dni` AS `dni`,
    `patients`.`name` AS `name`,
    `patients`.`surname` AS `surname`,
    `genders`.`gender_id` AS `id_gender`,
    `genders`.`gender_name` AS `gender_name`,
    `patients`.`day_of_birth` AS `day_of_birth`,
    `patients`.`email` AS `email`,
    `patients`.`phone` AS `phone`,
    `status`.`state_id` AS `id_state`,
    `status`.`state_name` AS `state_name`
FROM
    `patients`
JOIN
    `genders` ON (`patients`.`gender` = `genders`.`gender_id`)
JOIN
    `status` ON (`patients`.`is_active` = `status`.`state_id`);

    -- Vista `listado_users`
DROP VIEW IF EXISTS `list_users`;
CREATE VIEW `list_patients` AS
SELECT
    `users`.`id_user` AS `user_id`,
    `users`.`dni` AS `dni`,
    `users`.`name` AS `name`,
    `users`.`surname` AS `surname`,
    `genders`.`gender_id` AS `id_gender`,
    `genders`.`gender_name` AS `gender_name`,
    `users`.`day_of_birth` AS `day_of_birth`,
    `users`.`email` AS `email`,
    `users`.`phone` AS `phone`,
    `status`.`state_id` AS `id_state`,
    `status`.`state_name` AS `state_name`
FROM
    `users`
JOIN
    `genders` ON (`users`.`gender` = `genders`.`gender_id`)
JOIN
    `status` ON (`users`.`is_active` = `status`.`state_id`);


-- ALTER TABLE `medics`
--   ADD PRIMARY KEY (`id_medic`),
--   ADD UNIQUE KEY `matricul_medic` (`matricul_medic`),
--   ADD KEY `gender_medic` (`gender_medic`);

--   ALTER TABLE `patients`
--   ADD PRIMARY KEY (`id_patient`),
--   ADD UNIQUE KEY `dni` (`dni`),
--   ADD KEY `gender` (`gender`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

