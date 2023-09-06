<?php 
//	Controlador de usuarios
class ControladorUsuarios {	
	public function ctrLogin() 
	   {
		// if ((!empty($_POST['loginUsr'])) &&
		// 	(!empty($_POST['passUsr']))	) {

				
			// if ((strcmp(trim($_POST["loginUsr"]), getenv("USER_ADMIN_SITE")) == 0 ) &&
			// 	(strcmp(trim($_POST["passUsr"]), getenv("USER_ADMIN_PASS")) == 0 ) ){
			// 	$_SESSION['id_usuario'] = 1;
			// 	$_SESSION['estado'] = 1;
			// 	$_SESSION['rol'] = 1;
			// 	echo '<script>
			// 	if ( window.history.replaceState ) {
			// 		window.history.replaceState(null, null, window.location.href);
			// 	}
			// 	window.location = "index.php?pagina=inicio";
			// 	</script>';	
						
			//}
			if((preg_match('/^[0-9]+$/', trim($_POST["loginUsr"]))) &&
				(preg_match('/^[0-9a-zA-Z@#$%]+$/', trim($_POST["passUsr"])))) {
				$usr = trim($_POST['loginUsr']);
				$psw = $_POST['passUsr'];
				$respuesta = ModeloUsuarios::mdlLogin($usr,$psw);
				var_dump($respuesta);
				exit();

				if( $respuesta != null ) {
					/*
					$_SESSION['id_usuario'] = $respuesta['id_usuario']; // usuario de plataforma
					$_SESSION['estado'] = $respuesta['id_estado'];
					$_SESSION['rol'] = $respuesta['id_rol'];
					$_SESSION['id_usr_rol'] = $respuesta['id_usr_rol'];	// id segun su rol(alumno precepto etc...)
					*/
					if($respuesta['id_rol'] == 4) {
						$idCarrera = ModeloUsuarios::mdlAlumnoCarrera($respuesta['id_usr_rol']);
						$_SESSION['id_carrera'] = $idCarrera['id_carrera'];
					}
					echo '<script>
					if ( window.history.replaceState ) {
						window.history.replaceState(null, null, window.location.href);
					}
					window.location = "index.php?pagina=inicio";
					</script>';
				} else {
					echo '<script>
					if ( window.history.replaceState ) {
						window.history.replaceState(null, null, window.location.href);
					}
					</script>
					<div class="alert alert-danger mt-2">Usuario o Contraseña incorrecta</div>';
				}
			} else {
				echo '<script>
				if ( window.history.replaceState ) {
					window.history.replaceState(null, null, window.location.href);
				}
				</script>
				<div class="alert alert-danger mt-2">Usuario o Contraseña incorrecta</div>';
			}
		} else {
			echo'<script>
			if ( window.history.replaceState ) {
				window.history.replaceState(null, null, window.location.href);
			}
			alert("Debes completar los campos");
			</script>';
		}
	}

	public function ctrActivacion() {
		if ((!empty($_POST['a_pass'])) &&
			(!empty($_POST['re_pass']))	) {
			if ((strcmp(trim($_POST['a_pass']),trim($_POST['re_pass'])) == 0) &&				
				(strlen(trim($_POST["a_pass"])) >= 8) &&
				(strlen(trim($_POST["re_pass"])) >= 8) &&				
				(preg_match('/^[0-9a-zA-Z@#$%]+$/', trim($_POST["a_pass"]))) &&
				(preg_match('/^[0-9a-zA-Z@#$%]+$/', trim($_POST["re_pass"]))) ) {
				$usr = $_SESSION['id_usuario'];
				$psw = sha1(trim($_POST['a_pass']));
				$ejecutar = ModeloUsuarios::mdlActivacion($usr,$psw);	
				if($ejecutar) {
					$_SESSION['estado'] = 1;
        			echo '<script>
        				if ( window.history.replaceState ) {
            			window.history.replaceState(null, null, window.location.href);
        				}
        				alert("'.$ejecutar["mensaje"].'");
        				window.location = "index.php?pagina=inicio";
        				</script>';
    			}
			} else {
				echo '<script>
					if ( window.history.replaceState ) {
					window.history.replaceState(null, null, window.location.href);
					}
					</script>
					<div class="alert alert-danger">Las claves no coinciden o no cumplen los requerimientos</div>';
			}
		} else {
			echo'<script>
				if ( window.history.replaceState ) {
					window.history.replaceState(null, null, window.location.href);
				}
              	alert("Debes completar los campos");
               	</script>';
		}
	}

//	Datos del usuario 
	static public function ctrDatosUsuario($id){
		$datos = ModeloUsuarios::mdlDatosUsuario($id);
		return $datos;
	}	

	static public function ctrAltaAlumno() {
		if(isset($_POST['nombres_al'])) {
			$datos = array(
				"nombres" => ucwords(strtolower($_POST['nombres_al'])),
				"apellidos" => ucwords(strtolower($_POST['apellidos_al'])),
				"dni" => $_POST['dni_al'],
				"fecha_nac_al" => $_POST['fecha_nac_al'], 
				"id_carrera" => base64_decode($_POST['carrera_id']),
				"legajo" => strtoupper($_POST['legajo']),
				"pass" => sha1($_POST['dni_al'])
			);
			$alumno = ModeloUsuarios::mdlAltaAlumno($datos);
// el SP se ejecuta siempre y va a devolver un mensaje			
			return $alumno;
		}	
	}

	static public function ctrAltaProfesor() {
		if(isset($_POST['nombres_prof'])) {
			$datos = array(
				"nombres" => ucwords(strtolower($_POST['nombres_prof'])),
				"apellidos" => ucwords(strtolower($_POST['apellidos_prof'])),
				"dni" => $_POST['dni_prof'],
				"fecha_nac_prof" => $_POST['fecha_nac_prof'],
				"pass" => sha1($_POST['dni_prof'])
			);
			$profe = ModeloUsuarios::mdlAltaProfesor($datos);
// el SP se ejecuta siempre y va a devolver un mensaje			
			return $profe;
		}	
	}

	static public function ctrAltaPreceptor() {
		if(isset($_POST['nombres_prece'])) {
			$datos = array(
				"nombres" => ucwords(strtolower($_POST['nombres_prece'])),
				"apellidos" => ucwords(strtolower($_POST['apellidos_prece'])),
				"dni" => $_POST['dni_prece'],
				"fecha_nac_prece" => $_POST['fecha_nac_prece'],
				"pass" => sha1($_POST['dni_prece'])
			);
			$prece = ModeloUsuarios::mdlAltaPreceptor($datos);
// el SP se ejecuta siempre y va a devolver un mensaje			
			return $prece;
		}	
	}

	static public function ctrAltaDirectivo() {
		if(isset($_POST['nombres_direc'])) {
			$datos = array(
				"nombres" => ucwords(strtolower($_POST['nombres_direc'])),
				"apellidos" => ucwords(strtolower($_POST['apellidos_direc'])),
				"dni" => $_POST['dni_direc'],
				"fecha_nac_direc" => $_POST['fecha_nac_direc'],
				"pass" => sha1($_POST['dni_direc'])
			);
			$direc = ModeloUsuarios::mdlAltaDirectivo($datos);
// el SP se ejecuta siempre y va a devolver un mensaje			
			return $direc;
		}	
	}

	static public function ctrLibreta() {
		$id = $_SESSION['id_usr_rol'];
		$datos = ModeloUsuarios::mdlLibreta($id);
		return $datos;
	}

	static public function fecha($fecha) {
		$aux = explode("-",$fecha);
		$date = $aux[2]."/".$aux[1]."/".$aux[0];
		return $date;
	}

	static public function ctrPerfil() {
		$id_rol = $_SESSION['id_usr_rol'];
		$id = $_SESSION['id_usuario'];
		$perfil = ModeloUsuarios::mdlPerfil($id,$id_rol);
		return $perfil;
	}

	static public function ctrPerfilData() {
		$id = $_SESSION['id_usuario'];
		$data = ModeloUsuarios::mdlPerfilData($id);
		return $data;
	}

	static public function ctrPerfilDataUpdate() {
	// validar los datos luego	
		$datos = array(
				"id_usuario" => $_SESSION['id_usuario'],
				"usr_mail" => strtolower($_POST['usr_mail']),
				"usr_tel" => $_POST['usr_tel'],
				"usr_loc" => strtoupper($_POST['usr_loc']),
				"usr_dir" => ucwords(strtolower($_POST['usr_dir'])),
				"usr_dir_num" => $_POST['usr_dir_num'],
				"usr_piso" => $_POST['usr_piso'],
				"usr_dpto" => $_POST['usr_dpto']
			);
		$data_up = ModeloUsuarios::mdlPerfilDataUpdate($datos);
		return $data_up;
	}

	static public function ctrDataTablesUsuarios($sql) {
		return ModeloUsuarios::mdlDataTablesUsuarios($sql);
	}

	static public function ctrDataUsuarios($id) {
		$id = base64_decode($id);
		return ModeloUsuarios::mdlDataUsuarios($id);
	}

	static public function ctrUpdateUsuario($id) {
	// validar los datos luego	
		$id = base64_decode($id);
		$datos = array(
				"id_usuario" => $id,
				"up_user_name" => ucwords(strtolower($_POST['up_user_name'])),
				"up_user_surname" => ucwords(strtolower($_POST['up_user_surname'])),
				"up_user_dni" => $_POST['up_user_dni'],
				"up_user_cumple" => $_POST['up_user_cumple']
			);
		return  ModeloUsuarios::mdlUpdateUsuario($datos);		
	}

	static public function ctrCarrerasProfe($id) {
		$id = base64_decode($id);
		return ModeloUsuarios::mdlCarrerasProfe($id);
	}
	
	static public function ctrCarrerasProfeAsignar() {
		$datos = array(				
				"carrera" => base64_decode($_POST['carrera']),
				"prof" => base64_decode($_POST['prof'])
			);
		return ModeloUsuarios::mdlCarrerasProfeAsignar($datos);		
	}

	static public function ctrCarrerasProfeQuitar() {
		$datos = array(				
				"carrera" => base64_decode($_POST['q_carrera'])				
			);
		return ModeloUsuarios::mdlCarrerasProfeQuitar($datos);		
	}

}