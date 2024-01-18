<?php  
// Requiere los archivos necesarios
require '../config/config.php';
require '../../php/database.php';


$db = new Database(); // Crea una instancia de la clase Database
$con = $db->conectar(); // Establece una conexión a la base de datos

$nombre = $_POST['nombre']; // Obtiene el nombre de la categoría desde los datos del formulario

$sql = $con->prepare("INSERT INTO categoria (nombre, activo) VALUES (?, 1)"); // Prepara una consulta SQL para insertar una nueva categoría con el nombre proporcionado
$sql->execute([$nombre]); // Ejecuta la consulta SQL con el nombre de la categoría
header("Location: index.php"); // Redirige a la página de inicio de categorías después de agregar la nueva categoría


?>

