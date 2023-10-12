<?php
// Verificar que la solicitud sea una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados en la solicitud
    $id2 = isset($_POST['id']) ? $_POST['id'] : null;
    $target = isset($_POST['target']) ? $_POST['target'] : null;

    // Realizar la actualización en la base de datos
    if ($id2 !== null && $target !== null) {
        include '../modelos/conexion.php'; // Incluye tu archivo de conexión a la base de datos

        $database = Conexion::conectar(); // Reemplaza 'Conexion' con la clase que estás usando para la conexión

        // Comprobar si el médico debe ser activado o desactivado
        if ($target === 'activo') {
            $sql = $database->prepare("UPDATE medics SET is_active = is_active + 1 WHERE id_medic = :id");
            $sql->execute();
        } elseif ($target === 'inactivo') {
            $sql = $database->prepare("UPDATE medics SET is_active = is_active - 1 WHERE id_medic = :id");
            $sql->execute();
        }

        $sql->bindParam(':id', $id2, PDO::PARAM_INT);
        $sql->execute();

        // Puedes agregar verificación adicional aquí y manejar la respuesta adecuadamente
    }
}
?>

