<?php
// Inicio de la sección de código PHP.

require '../php/database.php';
require '../php/config.php';
require '../php/funciones.php';

// Se intenta obtener el valor de 'user_id' y 'token' desde la solicitud GET o POST.
$user_id = $_GET['id'] ?? $_POST['user_id'] ?? ''; 
$token = $_GET['token'] ?? $_POST['token'] ?? '';

// Si alguno de los valores es vacío, se redirige a la página de inicio.
if ($user_id == '' || $token == '') {
    header("Location: index.php");
    exit;
}

// Se crea una nueva instancia de la clase 'Database' para gestionar la conexión a la base de datos.
$db = new Database();
$con = $db->conectar();

// Se crea un array llamado $errors para almacenar mensajes de error.
$errors = [];

// Se verifica si el token y el 'user_id' proporcionados son válidos.
if (!verificaTokenRequest($user_id, $token, $con)) {
    echo "No se pudo verificar la información";
    exit;
}

// Si se ha enviado el formulario (POST), se procede a validar y procesar la solicitud.
if (!empty($_POST)) {
    // Se obtienen los valores de los campos del formulario y se eliminan espacios en blanco adicionales.
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']); 

    // Se valida si alguno de los campos del formulario está vacío y se agrega un mensaje de error si es así.
    if (esNulo([$user_id, $token, $password, $repassword])) {
        $errors[] = "Todos los campos son obligatorios";
    }

    // Se valida si las contraseñas coinciden y se agrega un mensaje de error si no coinciden.
    if (validaPassword($password, $repassword)) {
        $errors[] = "Las contraseñas no coinciden.";
    }

    // Si no hay mensajes de error en el array, se procede a actualizar la contraseña en la base de datos.
    if (count($errors) == 0) {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        // Se intenta activar la nueva contraseña en la base de datos.
        if (activaPassword($user_id, $pass_hash, $con)) {
            echo "Tu contraseña ha sido actualizada con éxito. Ahora puedes usar tu nueva contraseña para acceder a tu cuenta.";
            exit;
        } else {
            echo "No hemos podido cambiar tu contraseña. Asegúrate de que la información proporcionada sea correcta e inténtalo de nuevo. Si el problema persiste, ponte en contacto con nuestro equipo de soporte.";
        }
    }
}

// Fin de la sección de código PHP.
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" sizes="128x128"  href="img/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/style.css">
    <title>A fondo con Andreina - Cambiar contraseña</title>
</head>
<body>

   
  
    <div class="login-form">    
        <div class="text">
            Recuperar contraseña
            <?php mostrarMensajes($errors); ?>
        </div>

    <form action="reset_password.php" method="post"  autocomplete="off">

    <input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>"/>
    <input type="hidden" name="token" id="token" value="<?= $token; ?>"/>

    <div class="field">
               <div class="fas fa-envelope"></div>
               <input type="password" name="password" id="password" placeholder="Nueva contraseña">
            </div>
            <div class="field">
               <div class="fas fa-lock"></div>
               <input type="password" name="repassword" id="repassword" placeholder="Confirmar contraseña">
            </div>
            <button type="submit">Confirmar contraseña</button>
            <div class="link">
                <a href="index.php">Iniciar sesión</a>
            </div>

    </form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
