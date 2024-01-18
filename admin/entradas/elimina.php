<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database(); // Crea una instancia de la clase Database
$con = $db->conectar(); // Establece una conexión a la base de datos

$id = $_POST['id']; // Obtiene el ID de la categoría desde los datos del formulario

$sql = $con->prepare("UPDATE articulo SET activo = 0 WHERE id = ?"); // Prepara una consulta SQL para desactivar una categoría por su ID
$sql->execute([$id]); // Ejecuta la consulta SQL con el ID obtenido desde los datos del formulario
header("Location: index.php"); // Redirige a la página de inicio de categorías después de desactivar la categoría



?>