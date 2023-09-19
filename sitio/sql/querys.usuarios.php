<?php
define('SQL_LOGIN_PATIENT', '
	SELECT
		patients.id_patient AS "id",
		patients.rol AS "rol",
		patients.email AS "email",
		patients.name AS "name"
	FROM patients
	WHERE patients.email = ? 
		AND patients.password = ?


	');

define('SQL_LOGIN_MEDIC', '
	SELECT
		medics.id_medic AS "id",
		medics.rol AS "rol",
		medics.email_medic AS "email_medic",
		medics.name_medic AS "name_medic"
	FROM medics
	WHERE medics.email_medic = ? 
		AND medics.password_medic = ?
		');

		define('SQL_LOGIN_ADMIN', '
	SELECT
		admins.id_admin AS "id",
		admins.rol AS "rol",
		admins.email AS "email",
		admins.name AS "name"
	FROM admins
	WHERE admins.email = ? 
		AND admins.password = ?
	');

define('SQL_REGISTER_PATIENT', '
INSERT INTO 
	patients (email, password)
	VALUES (?, ?)
	ON DUPLICATE KEY UPDATE email = email;
	');
	
?>