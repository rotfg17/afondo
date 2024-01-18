<?php  

require '../config/config.php';
require '../../php/database.php';

$db = new Database(); // Crea una instancia de la clase Database
$con = $db->conectar(); // Establece una conexión a la base de datos

$id = $_POST['id']; // Obtiene el valor del campo 'id' desde el formulario
$nombre = $_POST['nombre']; // Obtiene el valor del campo 'nombre' desde el formulario

$sql = $con->prepare("UPDATE categoria SET nombre = ? WHERE id = ?"); // Prepara una consulta SQL de actualización
$sql->execute([$nombre, $id]); // Ejecuta la consulta SQL para actualizar el nombre de la categoría

header("Location: index.php"); // Redirige de vuelta a la página principal después de la actualización


?>

