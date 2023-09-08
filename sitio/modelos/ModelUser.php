<?php 
require_once "/var/www/html/MedicV4/FirsSalud/sitio/modelos/conexion.php";
require_once "/var/www/html/MedicV4/FirsSalud/sitio/sql/querys.usuarios.php";

class ModeloUsuarios {
	

	static public function mdlLogin($user,$pass){
		
		$sql = SQL_LOGIN;
		$stmt = Conexion::conectar()->prepare($sql);
		$stmt->bindParam(1, $user, PDO::PARAM_STR);
		$stmt->bindParam(2, $pass, PDO::PARAM_STR);
		// Si se esta ejecutando la sentencia SQL
		if ($stmt->execute()) {
			$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($resultado !== false) {
				// Autenticación exitosa
				return $resultado;
			} else {
				echo '<script>
				if ( window.history.replaceState ) {
					window.history.replaceState(null, null, window.location.href);
				}
				</script>
				<div class="alert alert-danger mt-2">Usuario o Contraseña incorrecta</div>';
			}
		} else {
			print_r($stmt->errorInfo());
		}
		
		$stmt = null; // por seguridad vaciamos el objeto de la conexion	
	}

	// static public function mdlLogin($user, $pass, $rol) 
	// {
	// 	$resultado = null;
	// 	// Define las consultas SQL para cada rol
	// 	$sql = '';
	// 	switch ($rol) {
	// 		case 'Paciente':
	// 			$sql = SQL_LOGIN;
	// 			break;
	// 		case 'Médico':
	// 			$sql = SQL_LOGIN_MEDIC;
	// 			break;
	// 		default:
	// 			echo '<script>
	// 			if ( window.history.replaceState ) {
	// 				window.history.replaceState(null, null, window.location.href);
	// 			}
	// 			</script>
	// 			<div class="alert alert-danger mt-2">Rol no válido</div>';
	// 			return null;
	// 	}
	
	// 	// Prepara la consulta SQL
	// 	$stmt = Conexion::conectar()->prepare($sql);
	// 	$stmt->bindParam(1, $user, PDO::PARAM_STR);
	// 	$stmt->bindParam(2, $pass, PDO::PARAM_STR);
	
	// 	// Si se está ejecutando la sentencia SQL
	// 	if ($stmt->execute()) {
	// 		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
	// 		if ($resultado == false) {
	// 			echo '<script>
	// 			if ( window.history.replaceState ) {
	// 				window.history.replaceState(null, null, window.location.href);
	// 			}
	// 			</script>
	// 			<div class="alert alert-danger mt-2">Usuario o Contraseña incorrecta</div>';
	// 		}
	// 	} else {
	// 		print_r($stmt->errorInfo());
	// 	}
		
	// 	$stmt = null; // Por seguridad, vaciamos el objeto de la conexión
	
	// 	return $resultado;
	// }

	
	
	
	

	
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

