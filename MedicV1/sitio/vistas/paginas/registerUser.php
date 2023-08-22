<div class="justify-content-center text-center">
    <form class="p-5 bg-light" method="post">
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="dni">DNI:</label>
            <input type="text" name="dni" class="form-control" placeholder="12345678" required>				
        </div>
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="name">NOMBRE</label>
            <input type="text" name="name" class="form-control" placeholder="juan" required>				
        </div>
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="surname">APELLIDO</label>
            <input type="text" name="surname" class="form-control" placeholder="perez" required>				
        </div>	
                
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="gender">GÉNERO</label>
            <select class="form-control" name="gender" id="gender_medic_select" required>
                <option value="" disabled selected>Selecciona una opción</option> 
                <?php
                (new ControladorFormularios()) -> ctrSelectGender("CALL select_gender()");
                ?>
            </select>
        </div>
        
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="day_of_birth">FECHA DE NACIMIENTO</label>
            <input type="date" name="day_of_birth" class="form-control" placeholder="24/09/1994" required>              
        </div>
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="email">EMAIL</label>
            <input type="text" name="email" class="form-control" placeholder="asd@mail" required>              
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="phone">TELEFONO</label>
            <input type="text" name="phone" class="form-control" placeholder="1144246350" required>              
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

        <button type="submit" name="registroPaciente" class="btn btn-primary">Enviar</button>
    </form>
</div>

<?php
if (isset($_POST['registroPaciente'])) {
    $ejecutar = ControladorFormularios::ctrRegistroPatient();
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
