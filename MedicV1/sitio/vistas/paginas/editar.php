<?php 
if(isset($_GET['id'])){
    $medic = ControladorFormularios::ctrSelectRegistro($_GET['id']);	
?>
<div class="justify-content-center text-center">
    <form class="p-5 bg-light" method="post">
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_matricul">MATRICULA: </label>
            <input type="text" name="up_matricul" class="form-control" value="<?php echo $medic['matricul'] ?>">		
        </div>
        
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_name">NOMBRE: </label>
            <input type="text" name="up_name" class="form-control" value="<?php echo $medic['name']; ?>">
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_surname">APELLIDO: </label>
            <input type="text" name="up_surname" class="form-control" value="<?php echo $medic['surname']; ?>">	
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_gender">GÉNERO </label>
            <select class="form-control" name="up_gender">
                <option value="<?php echo $medic['id_gender']; ?>"><?php echo $medic['gender_name']; ?></option>
                <?php
                (new ControladorFormularios())->ctrSelectGender("CALL select_gender()");
                ?>
            </select>
        </div>
        
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_day_of_birth">FECHA DE NACIMIENTO</label>
            <input type="date" name="up_day_of_birth" class="form-control" value="<?php echo $medic['day_of_birth']; ?>">	            
        </div>
        
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_email">EMAIL</label>
            <input type="text" name="up_email" class="form-control" value="<?php echo $medic['email']; ?>">	            
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_phone">TELEFONO</label>
            <input type="text" name="up_phone" class="form-control" value="<?php echo $medic['phone']; ?>">	           
        </div>

        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_specialty">ESPECIALIDAD </label>
            <select class="form-control" name="up_specialty">
                <option value="<?php echo $medic['id_specialty']; ?>"><?php echo $medic['specialty_name']; ?></option>
                <?php
                (new ControladorFormularios())->ctrSelectSpecialty("CALL select_specialty()");
                ?>
            </select>
        </div>

        
        <div class="form-group d-flex">
            <label class="py-1 p-2" for="up_state">ESTADO</label>
            <select class="form-control" name="up_state">
                <option value="<?php echo $medic['id_state']; ?>"><?php echo $medic['state_name']; ?></option>
                <?php
                (new ControladorFormularios())->ctrSelectStatus("CALL select_status()");
                ?>
            </select>
            <input type="hidden" name="up_id" value="<?php echo $medic['medic_id']; ?>">
        </div>
        <button type="submit" name="editar" class="btn btn-primary">Actualizar</button>
    </form>
</div>
<?php 
    if (isset($_POST['editar'])) {
        $ejecutar = ControladorFormularios::ctrActualizarRegistro();
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
