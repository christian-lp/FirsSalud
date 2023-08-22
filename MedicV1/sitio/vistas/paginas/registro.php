<div class="justify-content-center text-center">
    <form class="p-5 bg-light" method="post">
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="matricul_medic">MATRICULA:</label>
            <input type="text" name="matricul_medic" class="form-control" placeholder="123-456" required>				
        </div>
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="name_medic">NOMBRE</label>
            <input type="text" name="name_medic" class="form-control" placeholder="juan" required>				
        </div>
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="surname_medic">APELLIDO</label>
            <input type="text" name="surname_medic" class="form-control" placeholder="perez" required>				
        </div>	
                
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="gender_medic">GÉNERO</label>
            <select class="form-control" name="gender_medic" id="gender_medic_select" required>
                <option value="" disabled selected>Selecciona una opción</option> 
                <?php
                (new ControladorFormularios()) -> ctrSelectGender("CALL select_gender()");
                ?>
            </select>
        </div>
        

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="day_of_birth_medic">FECHA DE NACIMIENTO</label>
            <input type="date" name="day_of_birth_medic" class="form-control" placeholder="24/09/1994" required>              
        </div>
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="email_medic">EMAIL</label>
            <input type="text" name="email_medic" class="form-control" placeholder="asd@mail" required>              
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="phone_medic">TELEFONO</label>
            <input type="text" name="phone_medic" class="form-control" placeholder="1144246350" required>              
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="specialty_medic">ESPECIALIDAD</label>
            <select class="form-control" name="specialty_medic" required>
                <option value="" disabled selected>Selecciona una opción</option>
                <?php
                (new ControladorFormularios())->ctrSelectSpecialty("CALL select_specialty()");
                ?>
            </select>
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="is_active">ESTADO</label>
            <select class="form-control" name="is_active" required>
                <option value="" disabled selected>Selecciona una opción</option>
                <?php
                (new ControladorFormularios())->ctrSelectStatus("CALL select_status()");
                ?>
            </select>
        </div>

        <button type="submit" name="registro" class="btn btn-primary">Enviar</button>
    </form>
</div>

<?php
if (isset($_POST['registro'])) {
    $ejecutar = ControladorFormularios::ctrRegistroMedico();
    if($ejecutar) {
        // Este script borra las variables POST por si se actualiza la página
        echo '<script>
        if ( window.history.replaceState ) {
            window.history.replaceState(null, null, window.location.href);
        }
        alert("'.$ejecutar["mensaje"].'");
        window.location="index.php?pagina=inicio";
        </script>';
    } 
}
?>
