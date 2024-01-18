<?php

require '../php/database.php';
require '../php/config.php';
require '../php/funciones.php';

$db = new Database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)){

   $usuario = trim($_POST['usuario']);
   $password = trim($_POST['password']);

     if (esNulo([$usuario, $password])) {
      $errors[] = "Todos los campos son obligatorios";
  }

  if (count($errors) == 0){
      $errors[] = login($usuario, $password, $con);
    }
  }

?>

<!DOCTYPE html>
<!-- Created By RobinsonChalas -->
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>A Fondo Login</title>
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
      <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
   </head>
   <body>


      <div class="login-form">
         <div class="text">
            LOGIN

            <?php mostrarMensajes($errors); ?>
         </div>
         <form action="index.php" method="post" autocomplete="off">
            <div class="field">
               <div class="fas fa-envelope"></div>
               <input type="text" name="usuario" id="usuario" placeholder="Usuario">
            </div>
            <div class="field">
               <div class="fas fa-lock"></div>
               <input type="password" name="password" id="password" placeholder="Contraseña">
            </div>
            <button type="submit">ENTRAR</button>
            <div class="link">
           <!--<a href="registrar.php">Registrar</a><br>-->
               <a href="recupera.php">Cambiar contraseña</a>
            </div>
         </form>
      </div>
   </body>
</html>