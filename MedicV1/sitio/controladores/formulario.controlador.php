<?php
class ControladorFormularios {
    // Registrar médico
    static public function ctrRegistroMedico() {
        $datos = array( 
            "matricul_medic" => $_POST['matricul_medic'],
            "name_medic" => $_POST['name_medic'],
            "surname_medic" => $_POST['surname_medic'],
            "gender_medic" => $_POST['gender_medic'],
            "day_of_birth_medic" => $_POST['day_of_birth_medic'],
            "email_medic" => $_POST['email_medic'],
            "phone_medic" => $_POST['phone_medic'],
            "specialty_medic" => $_POST['specialty_medic'],
            "is_active" => $_POST['is_active']
        );

        return ModeloFormularios::mdlRegistro($datos);
    }

        // Traer registros desde la DB
        static public function ctrSelectRegistros() {
            return ModeloFormularios::mdlSelectRegistros();
        }

        // Traer los datos de un medico en especial
        static public function ctrSelectRegistro($valor) {
            return ModeloFormularios::mdlSelectRegistro($valor);
        }

        // Actualizar registro
        static public function ctrActualizarRegistro() {
            $datos = array( 
                "up_matricul" => $_POST['up_matricul'],
                "up_name" => $_POST['up_name'],
                "up_surname" => $_POST['up_surname'],
                "up_gender" => $_POST['up_gender'],
                "up_day_of_birth" => $_POST['up_day_of_birth'],
                "up_email" => $_POST['up_email'],
                "up_phone" => $_POST['up_phone'],
                "up_specialty" => $_POST['up_specialty'],
                "up_state" => $_POST['up_state'],
                "up_id" => $_POST['up_id']
            );

            return ModeloFormularios::mdlActualizarRegistro($datos);
        }

    // Rellenar <select> con datos de la DB
    public function ctrSelectGender($sp) {
        $respuesta = ModeloFormularios::mdlSelects($sp);

        foreach ($respuesta as $key => $value) {
            echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
        }
    }

    // Rellenar <select> con datos de la DB
    public function ctrSelectSpecialty($sp) {
        $respuesta = ModeloFormularios::mdlSelects($sp);

        foreach ($respuesta as $key => $value) {
            echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
        }
    }

    // Rellenar <select> con datos de la DB
    public function ctrSelectStatus($sp) {
        $respuesta = ModeloFormularios::mdlSelects($sp);

        foreach ($respuesta as $key => $value) {
            echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
        }
    }


    public function ctrEliminarRegistro() {
        return ModeloFormularios::mdlEliminarRegistro($_POST['delete_medic']);
    }

    public function ctrEliminarRegistroPaciente() {
        return ModeloFormularios::mdlEliminarRegistroPaciente($_POST['delete_patient']);
    }

//===============================================================================================

      // Registrar patients
        static public function ctrRegistroPatient() {
        $datos = array( 
            "dni" => $_POST['dni'],
            "name" => $_POST['name'],
            "surname" => $_POST['surname'],
            "gender" => $_POST['gender'],
            "day_of_birth" => $_POST['day_of_birth'],
            "email" => $_POST['email'],
            "phone" => $_POST['phone'],
            "is_active" => $_POST['is_active']
        );

        return ModeloFormularios::mdlRegistroPatient($datos);
    }

        // Traer registros desde la DB
        static public function ctrSelectRegistrosPatients() {
            return ModeloFormularios::mdlSelectRegistrosPatients();
        }

        // Traer los datos de un patiento en especial
        static public function ctrSelectRegistroPatient($valor) {
            return ModeloFormularios::mdlSelectRegistroPatient($valor);
        }

        // Actualizar registro
        static public function ctrActualizarRegistroPatient() {
            $datos = array( 
                "up_dni" => $_POST['up_dni'],
                "up_name" => $_POST['up_name'],
                "up_surname" => $_POST['up_surname'],
                "up_gender" => $_POST['up_gender'],
                "up_day_of_birth" => $_POST['up_day_of_birth'],
                "up_email" => $_POST['up_email'],
                "up_phone" => $_POST['up_phone'],
                "up_state" => $_POST['up_state'],
                "up_id" => $_POST['up_id']
            );

            return ModeloFormularios::mdlActualizarRegistroPatients($datos);
        }

    // Rellenar <select> con datos de la DB
    public function ctrSelectGenderPatient($sp) {
        $respuesta = ModeloFormularios::mdlSelects($sp);

        foreach ($respuesta as $key => $value) {
            echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
        }
    }

    // Rellenar <select> con datos de la DB
    public function ctrSelectStatusPatient($sp) {
        $respuesta = ModeloFormularios::mdlSelects($sp);

        foreach ($respuesta as $key => $value) {
            echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
        }
    }


    public function ctrEliminarRegistroPatient() {
        return ModeloFormularios::mdlEliminarRegistro($_POST['delete_patient']);
    }
}
