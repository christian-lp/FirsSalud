<?php 
if(isset($_GET['id'])){
    $patient = ControladorFormularios::ctrSelectRegistroPatient($_GET['id']);	
?>
<div class="justify-content-center text-center">
    <form class="p-5 bg-light" method="post">
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_dni">DNI: </label>
            <input type="text" name="up_dni" class="form-control" value="<?php echo $patient['dni']; ?>">		
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_name">NOMBRE: </label>
            <input type="text" name="up_name" class="form-control" value="<?php echo $patient['name']; ?>">
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_surname">APELLIDO: </label>
            <input type="text" name="up_surname" class="form-control" value="<?php echo $patient['surname']; ?>">	
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_gender">GÉNERO </label>
            <select class="form-control" name="up_gender">
                <option value="<?php echo $patient['id_gender']; ?>"><?php echo $patient['gender_name']; ?></option>
                <?php
                (new ControladorFormularios())->ctrSelectGender("CALL select_gender()");
                ?>
            </select>
        </div>
        
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_day_of_birth">FECHA DE NACIMIENTO</label>
            <input type="date" name="up_day_of_birth" class="form-control" value="<?php echo $patient['day_of_birth']; ?>">	            
        </div>
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_email">EMAIL</label>
            <input type="text" name="up_email" class="form-control" value="<?php echo $patient['email']; ?>">	            
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_phone">TELEFONO</label>
            <input type="text" name="up_phone" class="form-control" value="<?php echo $patient['phone']; ?>">	           
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_state">ESTADO</label>
            <select class="form-control" name="up_state">
                <option value="<?php echo $patient['id_state']; ?>"><?php echo $patient['state_name']; ?></option>
                <?php
                (new ControladorFormularios())->ctrSelectStatus("CALL select_status()");
                ?>
            </select>
            <input type="hidden" name="up_id" value="<?php echo $patient['patient_id']; ?>">
        </div>
        <button type="submit" name="edit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
<?php 
    if (isset($_POST['edit'])) {
        $ejecutar = ControladorFormularios::ctrActualizarRegistroPatient();
        if($ejecutar) {
            //  este script borra las variables post por si se actualiza la pagina
            echo '<script>
            if ( window.history.replaceState ) {
                window.history.replaceState(null, null, window.location.href);
            }
            alert("'.$ejecutar["mensaje"].'");
            window.location="index.php?pagina=inicio";
            </script>';
        } 
    }
}
?>
