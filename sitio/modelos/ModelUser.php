s<?php 
require_once "/var/www/html/FirsSalud/sitio/modelos/conexion.php";
require_once "/var/www/html/FirsSalud/sitio/sql/querys.usuarios.php";

class ModeloUsuarios
{
	static public function mdlLogin($emailUsr, $hashedPassword)
	{
    try 
	{
        $resultado = null;
        // Define las consultas SQL para cada rol
        $sqlPatient = SQL_LOGIN_PATIENT;
        $sqlMedic = SQL_LOGIN_MEDIC;
        $sqlAdmin = SQL_LOGIN_ADMIN;
    
        $conexion = Conexion::conectar();
        $stmt = null;
    
        // Intenta ejecutar la consulta para el rol de paciente
        $stmt = $conexion->prepare($sqlPatient);
        $stmt->bindParam(1, $emailUsr, PDO::PARAM_STR);
        $stmt->bindParam(2, $hashedPassword, PDO::PARAM_STR);
		// $stmt3 = $conexion->prepare($sqlAdmin);
        // $stmt3->bindParam(1, $emailUsr, PDO::PARAM_STR);
        // $stmt3->bindParam(2, $hashedPassword, PDO::PARAM_STR);
		// var_dump($sqlPatient);
		// var_dump($sqlMedic);
		// var_dump($sqlAdmin);
		// var_dump($emailUsr);
		// var_dump($hashedPassword);
		// exit;

        if ($stmt->execute()) 
		{
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        } 
		if($resultado == false)
		{
            // Si la consulta para el rol de paciente no se ejecuta correctamente, intenta la consulta para el rol de médico
            $stmt = $conexion->prepare($sqlMedic);
            $stmt->bindParam(1, $emailUsr, PDO::PARAM_STR);
            $stmt->bindParam(2, $hashedPassword, PDO::PARAM_STR);
			
            if ($stmt->execute()) {
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            }

			if($resultado == false)
			{
                // Si la consulta para el rol de médico no se ejecuta correctamente, intenta la consulta para el rol de administrador
                $stmt = $conexion->prepare($sqlAdmin);
                $stmt->bindParam(1, $emailUsr, PDO::PARAM_STR);
                $stmt->bindParam(2, $hashedPassword, PDO::PARAM_STR);
                
                if ($stmt->execute()) {
                    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
        }
    
        // Si $resultado sigue siendo nulo, muestra un mensaje de error
        if ($resultado === false) {
            // echo '<script>
            // if ( window.history.replaceState ) {
            //     window.history.replaceState(null, null, window.location.href);
            // }
            // </script>
            // <strong style="color: red;><div class="alert alert-danger mt-2">Usuario o Contraseña Incorrectaaaaaa!</div></strong>';
			$error_message = '<strong style="color: red;">¡USUARIO O CONTRASEÑA INCORRECTA!<br>¡Vuelva a Intentar!</strong>';
		echo '
					<div class="alert alert-danger error-message">
						<strong>' . $error_message . '</strong>
					</div>
				';
		
        }
    
        // Devuelve los datos
        return $resultado;
    } catch (PDOException $e) {
        // Captura errores de PDO y muestra un mensaje de error personalizado
        echo "Error de base de datos: " . $e->getMessage();
        exit;
    }
}

	static public function mdlRegister($emailUsr, $hashedPassword) 
{
    $resultado = null;

    // Realizar la inserción
    $sqlInsert = 'INSERT INTO patients (email, password) VALUES (?, ?)';
    $stmtInsert = Conexion::conectar()->prepare($sqlInsert);
    $stmtInsert->bindParam(1, $emailUsr, PDO::PARAM_STR);
    $stmtInsert->bindParam(2, $hashedPassword, PDO::PARAM_STR);

    if ($stmtInsert->execute()) {
        $resultado = [
            'email' => $emailUsr,
            'rol' => '1',
            'pass' => $hashedPassword
        ];
    } 
	else 
	{
		$error_message = '<strong style="color: red;">¡EL USUARIO YA EXISTE!<br>Ingrese otro!</strong>';
		echo '
					<div class="alert alert-danger error-message">
						<strong>' . $error_message . '</strong>
					</div>
				';
		
        // print_r($stmtInsert->errorInfo());
    }
		echo '<script>
				setTimeout(function()
				{
					var errorAlerts = document.querySelectorAll(".error-message");
					errorAlerts.forEach(function(errorAlert) {
						errorAlert.style.display = "none";
					});
				}, 3000);
				</script>';

    return $resultado;
}



	
	
	
	

	
	static public function mdlActivacion($usr,$psw)	{
		$sql = "CALL usuarios_activar(?,?)";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $usr, PDO::PARAM_INT);
		$stmt->bindParam(2, $psw, PDO::PARAM_STR);
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve todo	
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
		$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}

	static public function mdlDatosUsuario($id)	{
		$sql = "CALL datos_usr_sidebar(?)";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve todo	
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
		$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}

	static public function mdlAlumnoCarrera($id)	{
		$sql = "CALL alumno_carrera(?)";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve todo	
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
			$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}

	static public function mdlAltaAlumno($datos) {		
		$sql = "CALL usuarios_alta_alumno(?,?,?,?,?,?,?);";		
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $datos['nombres'], PDO::PARAM_STR);
		$stmt->bindParam(2, $datos['apellidos'], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos['dni'], PDO::PARAM_STR);		
		$stmt->bindParam(4, $datos['id_carrera'], PDO::PARAM_INT);
		$stmt->bindParam(5, $datos['legajo'], PDO::PARAM_STR);
		$stmt->bindParam(6, $datos['pass'], PDO::PARAM_STR);
		$stmt->bindParam(7, $datos['fecha_nac_al'], PDO::PARAM_STR);
    // Si se esta ejecutando la sentencia SQL		
		if($stmt->execute()) {		 
    // devuelve un mensaje definido en el SOTRE PROCEDURE que lo capto con fetch();
			return $stmt->fetch();
		} else { 
    // sino imprimo el error			
			print_r($stmt -> errorInfo());
		}		
        $stmt = null; // por seguridad vaciamos el objeto de la conexion		
    }
    static public function mdlAltaProfesor($datos) {		
		$sql = "CALL usuarios_alta_profesor(?,?,?,?,?);";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $datos['nombres'], PDO::PARAM_STR);
		$stmt->bindParam(2, $datos['apellidos'], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos['dni'], PDO::PARAM_STR);
		$stmt->bindParam(4, $datos['pass'], PDO::PARAM_STR);
		$stmt->bindParam(5, $datos['fecha_nac_prof'], PDO::PARAM_STR);
    // Si se esta ejecutando la sentencia SQL		
		if($stmt->execute()) {		 
    // devuelve un mensaje definido en el SOTRE PROCEDURE que lo capto con fetch();
			return $stmt->fetch();
		} else { 
    // sino imprimo el error			
			print_r($stmt -> errorInfo());
		}		
        $stmt = null; // por seguridad vaciamos el objeto de la conexion		
    }

    static public function mdlAltaPreceptor($datos) {		
		$sql = "CALL usuarios_alta_preceptor(?,?,?,?,?);";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $datos['nombres'], PDO::PARAM_STR);
		$stmt->bindParam(2, $datos['apellidos'], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos['dni'], PDO::PARAM_STR);
		$stmt->bindParam(4, $datos['pass'], PDO::PARAM_STR);
		$stmt->bindParam(5, $datos['fecha_nac_prece'], PDO::PARAM_STR);
    // Si se esta ejecutando la sentencia SQL		
		if($stmt->execute()) {		 
    // devuelve un mensaje definido en el SOTRE PROCEDURE que lo capto con fetch();
			return $stmt->fetch();
		} else { 
    // sino imprimo el error			
			print_r($stmt -> errorInfo());
		}		
        $stmt = null; // por seguridad vaciamos el objeto de la conexion		
    }

    static public function mdlAltaDirectivo($datos) {		
		$sql = "CALL usuarios_alta_directivo(?,?,?,?,?);";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $datos['nombres'], PDO::PARAM_STR);
		$stmt->bindParam(2, $datos['apellidos'], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos['dni'], PDO::PARAM_STR);
		$stmt->bindParam(4, $datos['pass'], PDO::PARAM_STR);
		$stmt->bindParam(5, $datos['fecha_nac_direc'], PDO::PARAM_STR);
    // Si se esta ejecutando la sentencia SQL		
		if($stmt->execute()) {		 
    // devuelve un mensaje definido en el SOTRE PROCEDURE que lo capto con fetch();
			return $stmt->fetch();
		} else { 
    // sino imprimo el error			
			print_r($stmt -> errorInfo());
		}		
        $stmt = null; // por seguridad vaciamos el objeto de la conexion		
    }

	static public function mdlLibreta($id)	{
		$sql = "CALL alumno_libreta(?)";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetchAll(PDO::FETCH_ASSOC); // devuelve todo	
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
			$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}

	static public function mdlPerfil($id,$id_rol)	{
		$sql = "CALL usuarios_perfil(?,?)";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->bindParam(2, $id_rol, PDO::PARAM_INT);
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve todo	
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
			$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}

	static public function mdlPerfilData($id)	{
		$sql = "CALL usuarios_perfil_data(?)";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);	
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve todo	
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
			$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}
	static public function mdlPerfilDataUpdate($datos)	{
		$sql = "CALL usuarios_perfil_data_update(?,?,?,?,?,?,?,?)";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $datos['id_usuario'], PDO::PARAM_INT);
		$stmt->bindParam(2, $datos['usr_mail'], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos['usr_tel'], PDO::PARAM_STR);
		$stmt->bindParam(4, $datos['usr_loc'], PDO::PARAM_STR);
		$stmt->bindParam(5, $datos['usr_dir'], PDO::PARAM_STR);
		$stmt->bindParam(6, $datos['usr_dir_num'], PDO::PARAM_STR);
		$stmt->bindParam(7, $datos['usr_piso'], PDO::PARAM_STR);
		$stmt->bindParam(8, $datos['usr_dpto'], PDO::PARAM_STR);
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve todo	
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
			$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}

	static public function mdlDataTablesUsuarios($sql) {
	//	para todos los datatables	
		$stmt = Conexion::conectar()->prepare($sql);		
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$stmt = null; // por seguridad vaciamos el objeto de la conexion
	}

	static public function mdlDataUsuarios($id) {
		$sql = "CALL usuarios_data(?)";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);	
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve todo	
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
			$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}

	static public function mdlUpdateUsuario($datos)	{
		$sql = "CALL usuarios_data_update(?,?,?,?,?)";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $datos['id_usuario'], PDO::PARAM_INT);
		$stmt->bindParam(2, $datos['up_user_name'], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos['up_user_surname'], PDO::PARAM_STR);
		$stmt->bindParam(4, $datos['up_user_dni'], PDO::PARAM_STR);
		$stmt->bindParam(5, $datos['up_user_cumple'], PDO::PARAM_STR);
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve todo	
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
			$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}

	static public function mdlCarrerasProfe($id) {
		$sql = "CALL carreras_por_profe(?)";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);	
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetchAll(PDO::FETCH_ASSOC); // devuelve todo				
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
			$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}

	static public function mdlCarrerasProfeAsignar($datos)	{
		$sql = "CALL carreras_asignar_profe(?,?)";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $datos['carrera'], PDO::PARAM_INT);
		$stmt->bindParam(2, $datos['prof'], PDO::PARAM_INT);		
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve todo	
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
			$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}

	static public function mdlCarrerasProfeQuitar($datos)	{
		$sql = "CALL carreras_quitar_profe(?)";
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $datos['carrera'], PDO::PARAM_INT);
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve todo	
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
			$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}

}
