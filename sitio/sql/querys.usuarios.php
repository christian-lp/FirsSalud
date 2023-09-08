<?php
define('SQL_LOGIN', '
	SELECT
		id_patient AS "id",
		patients.rol AS "rol",
		patients.email AS "email",
		patients.name AS "name"
	FROM patients
	WHERE patients.email = ? 
		AND patients.password = ?
		');

define('SQL_LOGIN_MEDIC', '
SELECT
	id_medic AS "id",
	medics.rol_medic AS "rol_medic",
	medics.email_medic AS "email_medic",
	medics.name_medic AS "name_medic"
FROM medics
WHERE medics.email_medic = ? 
	AND medics.password_medic = ?
	');