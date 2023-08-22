<?php 
if (isset($_GET['id'])) {
?>
    <div class="container p-5 bg-danger ">
        <div class="row justify-content-center">
            <div class="col-4">
                <h3 class="text-white">Va a eliminar un registro</h3>    
            </div>            
        </div>
        <div class="row justify-content-center">
            <div class="col-4">
                <form method="post">
                    <input type="hidden" name="delete_patient" value="<?php echo $_GET['id'] ?>">
                    <input type="submit" name="delRegistro" value="Confirmar" class="btn btn-secondary">
                </form>    
            </div>
        </div>    
    </div>
<?php 
}
if (isset($_POST['delRegistro'])) {
    $ejecutar = ControladorFormularios::ctrEliminarRegistroPaciente();
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