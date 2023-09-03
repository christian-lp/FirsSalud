<?php

$sql_login = '
	SELECT
		patients.id AS "id",
	    CONCAT_WS(" ", patients.name,patients.surname) AS "patient",
   		patients.dni AS "dni"
	FROM patients
	WHERE patients.dni = ? 
		AND patients.pass = ?
		';