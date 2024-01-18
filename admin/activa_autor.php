<?php
// Incluye el archivo de configuración y las funciones relacionadas con el cliente.
require '../php/config.php';
require '../php/funciones.php';


// Obtiene el ID y el token desde los parámetros GET o establece valores vacíos por defecto.
$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

// Si el ID o el token están en blanco, redirige a la página de inicio y sale del script.
if ($id == '' || $token == '') {
    header("Location: index.php");
    exit;
}

// Crea una instancia de la clase Database y establece una conexión a la base de datos.
$db = new Database();
$con = $db->conectar();

// Llama a la función validaToken para verificar el token y realizar alguna acción relacionada con la validación.
echo validaToken($id, $token, $con);

//En pocas palabras este script se utiliza para que el usuario o cliente active su cuenta.
?>

