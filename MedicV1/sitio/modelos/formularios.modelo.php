<?php  
require_once "conexion.php";
class ModeloFormularios {

	//funcion para agregar nuevo medico a la base de datos
	static public function mdlRegistro($datos){		
		try {
			$stmt = Conexion::conectar()->prepare("CALL new_medic(?, ?, ?, ?, ?, ?, ?, ?,?)");
			$stmt->bindParam(1, $datos["matricul_medic"], PDO::PARAM_STR);
			$stmt->bindParam(2, $datos["name_medic"], PDO::PARAM_STR);
			$stmt->bindParam(3, $datos["surname_medic"], PDO::PARAM_STR);
			$stmt->bindParam(4, $datos["gender_medic"], PDO::PARAM_INT);
			$stmt->bindParam(5, $datos["day_of_birth_medic"], PDO::PARAM_STR);
			$stmt->bindParam(6, $datos["email_medic"], PDO::PARAM_STR);
			$stmt->bindParam(7, $datos["phone_medic"], PDO::PARAM_STR);
			$stmt->bindParam(8, $datos["specialty_medic"], PDO::PARAM_INT);
			$stmt->bindParam(9, $datos["is_active"], PDO::PARAM_INT);
			
			if($stmt->execute()) 
			{
				// si se ejecuta todo bien devuelvo el mensaje
				return $stmt->fetch(PDO::FETCH_ASSOC);
			} 
			else 
			{ 
				// sino imprimo el error
				print_r($stmt -> errorInfo());
			}		
			//$stmt = null; // por seguridad vaciamos el objeto de la conexion	
		} 
		catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}		
						
	}

	
	// Consultar DB, la vista listado
	static public function mdlSelectRegistros() {		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM list_medics");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC); // devuelve todo	
		$stmt = null; // por seguridad vaciamos el objeto de la conexion							
			
	}

	// Consultar DB, la vista listado datos
	// Trae los datos de un medico en especial
	static public function mdlSelectRegistro($valor) {
		$stmt = Conexion::conectar()->prepare("SELECT * FROM list_medics WHERE medic_id = $valor");
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve todo			
		$stmt = null; // por seguridad vaciamos el objeto de la conexion					
	}

	static public function mdlActualizarRegistro($datos){
		// Statement = Declaracion		
		$stmt = Conexion::conectar()->prepare("CALL update_medic(?,?,?,?,?,?,?,?,?,?)");
		$stmt->bindParam(1, $datos["up_matricul"], PDO::PARAM_STR);
		$stmt->bindParam(2, $datos["up_name"], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos["up_surname"], PDO::PARAM_STR);
		$stmt->bindParam(4, $datos["up_gender"], PDO::PARAM_INT);
		$stmt->bindParam(5, $datos["up_day_of_birth"], PDO::PARAM_STR);
		$stmt->bindParam(6, $datos["up_email"], PDO::PARAM_STR);
		$stmt->bindParam(7, $datos["up_phone"], PDO::PARAM_STR);
		$stmt->bindParam(8, $datos["up_specialty"], PDO::PARAM_INT);
		$stmt->bindParam(9, $datos["up_state"], PDO::PARAM_INT);
		$stmt->bindParam(10, $datos["up_id"], PDO::PARAM_INT);
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} 
		else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
		$stmt = null; // por seguridad vaciamos el objeto de la conexion				
	}

	static public function mdlSelects($sql){
		// con esto podemos armar los selects para los formulario
		// solo sirve para las tablas con 2 datos, id y nombre
		$stmt = Conexion::conectar()->prepare($sql);		
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);			
	}

	static public function mdlEliminarRegistro($valor){
		// Statement = Declaracion		
		$stmt = Conexion::conectar()->prepare("CALL delete_medic(?)");
		$stmt->bindParam(1, $valor, PDO::PARAM_INT);		
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
		$stmt = null; // por seguridad vaciamos el objeto de la conexion				
	}

	static public function mdlEliminarRegistroPaciente($valor){
		// Statement = Declaracion		
		$stmt = Conexion::conectar()->prepare("CALL delete_patient(?)");
		$stmt->bindParam(1, $valor, PDO::PARAM_INT);		
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
		$stmt = null; // por seguridad vaciamos el objeto de la conexion				
	}


	// ============================================================================================



	//funcion para agregar nuevo medico a la base de datos
	static public function mdlRegistroPatient($datos){		
		try {
			$stmt = Conexion::conectar()->prepare("CALL new_patient(?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bindParam(1, $datos["dni"], PDO::PARAM_STR);
			$stmt->bindParam(2, $datos["name"], PDO::PARAM_STR);
			$stmt->bindParam(3, $datos["surname"], PDO::PARAM_STR);
			$stmt->bindParam(4, $datos["gender"], PDO::PARAM_INT);
			$stmt->bindParam(5, $datos["day_of_birth"], PDO::PARAM_STR);
			$stmt->bindParam(6, $datos["email"], PDO::PARAM_STR);
			$stmt->bindParam(7, $datos["phone"], PDO::PARAM_STR);
			$stmt->bindParam(8, $datos["is_active"], PDO::PARAM_INT);
			
			if($stmt->execute()) 
			{
				// si se ejecuta todo bien devuelvo el mensaje
				return $stmt->fetch(PDO::FETCH_ASSOC);
			} 
			else 
			{ 
				// sino imprimo el error
				print_r($stmt -> errorInfo());
			}		
			//$stmt = null; // por seguridad vaciamos el objeto de la conexion	
		} 
		catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}		
						
}
	
	// Consultar DB, la vista listado
	static public function mdlSelectRegistrosPatients() {		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM list_patients");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC); // devuelve todo	
		$stmt = null; // por seguridad vaciamos el objeto de la conexion							
			
	}

	// Consultar DB, la vista listado datos
	// Trae los datos de un medico en especial
	static public function mdlSelectRegistroPatient($valor) {
		$stmt = Conexion::conectar()->prepare("SELECT * FROM list_patients WHERE patient_id = $valor");
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve todo			
		$stmt = null; // por seguridad vaciamos el objeto de la conexion					
	}

	static public function mdlActualizarRegistroPatients($datos){
		// Statement = Declaracion		
		$stmt = Conexion::conectar()->prepare("CALL update_patient(?,?,?,?,?,?,?,?,?)");
		$stmt->bindParam(1, $datos["up_dni"], PDO::PARAM_STR);
		$stmt->bindParam(2, $datos["up_name"], PDO::PARAM_STR);
		$stmt->bindParam(3, $datos["up_surname"], PDO::PARAM_STR);
		$stmt->bindParam(4, $datos["up_gender"], PDO::PARAM_INT);
		$stmt->bindParam(5, $datos["up_day_of_birth"], PDO::PARAM_STR);
		$stmt->bindParam(6, $datos["up_email"], PDO::PARAM_STR);
		$stmt->bindParam(7, $datos["up_phone"], PDO::PARAM_STR);
		$stmt->bindParam(8, $datos["up_state"], PDO::PARAM_INT);
		$stmt->bindParam(9, $datos["up_id"], PDO::PARAM_INT);
		// Si se esta ejecutando la sentencia SQL
		if($stmt->execute()) {
			// si se ejecuta retorno el OK		
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} 
		else { // sino imprimo el error
			print_r($stmt -> errorInfo());
		}		
		$stmt = null; // por seguridad vaciamos el objeto de la conexion				
	}
	
}


