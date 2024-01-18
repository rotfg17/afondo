<?php

require '../php/database.php';
require '../php/config.php';
require '../php/funciones.php';

$db = new Database();
$con = $db->conectar();

$errors = [];

if(!empty($_POST)){
   $nombres = trim($_POST['nombres']);
   $email = trim($_POST['email']);
   $usuario = trim($_POST['usuario']);
   $password = trim($_POST['password']);
   $repassword = trim($_POST['repassword']);

     // Se valida si alguno de los campos del formulario está vacío y se agrega un mensaje de error si es así.
     if (esNulo([$nombres, $email, $usuario, $password, $repassword])) {
      $errors[] = "Todos los campos son obligatorios";
  }

  // Se valida si el formato del correo electrónico es válido y se agrega un mensaje de error si no lo es.
  if (!esEmail($email)) {
      $errors[] = "El correo no es válido.";
  }

  // Se valida si las contraseñas coinciden y se agrega un mensaje de error si no coinciden.
  if (validaPassword($password, $repassword)) {
      $errors[] = "Las contraseñas no coinciden.";
  }

  // Se verifica si el nombre de usuario ya existe en la base de datos y se agrega un mensaje de error si es el caso.
  if (usuarioExiste($usuario, $con)) {
      $errors[] = "Este usuario $usuario ya existe.";
  }

  // Se verifica si el correo electrónico ya existe en la base de datos y se agrega un mensaje de error si es el caso.
  if (emailExiste($email, $con)) {
      $errors[] = "Este correo electrónico $email ya existe.";
  }

   if(count($errors) == 0){

  $id = Registrar([$nombres, $email], $con);

// Si no hay mensajes de error en el array, se procede a registrar el cliente y usuario en la base de datos.
if (count($errors) == 0) {
   // Se registra al cliente y se obtiene su ID.

   // Si se ha registrado el cliente con éxito, se procede a enviar un correo de activación.
   if ($id > 0) {
       // Se crea una instancia de la clase 'Mailer' para enviar correos electrónicos.
       require_once '../php/Mailer.php';
       $mailer = new Mailer();

       // Se genera un token para la activación de la cuenta.
       $token = generarToken();
       $pass_hash = password_hash($password, PASSWORD_DEFAULT);

       // Se registra al usuario y se obtiene su ID.
       $id = registraUsuario([$usuario, $pass_hash, $token, $id], $con);

       // Si se ha registrado el usuario con éxito, se procede a enviar un correo de activación.
       if ($id > 0) {
           $url = SITE_URL . 'activa_autor.php?id=' . $id . '&token=' . $token;
           $asunto = "Activar cuenta - A fondo con Andreina";

           // URL de la imagen del logo de la empresa
           $logoURL = 'https://www.dropbox.com/scl/fi/8g3vg9p3zmj3r9k3vs2b9/Logo.png?rlkey=buj2lpltcobxpsijxcz6ujewy&dl=0';

           // Construir el cuerpo del correo electrónico en formato HTML.
           $cuerpo = "<html>
           <head>
               <style>
                   /* Estilos CSS para el correo */
                   .container {
                       max-width: 600px;
                       margin: 0 auto;
                       padding: 20px;
                       font-family: Arial, sans-serif;
                   }

                   .header {
                       text-align: center;
                   }

                   .logo {
                       max-width: 100px;
                       height: auto;
                   }

                   .btn {
                       display: inline-block;
                       padding: 10px 20px;
                       background-color: #007BFF;
                       color: #FFFFFF;
                       text-decoration: none;
                       border-radius: 5px;
                   }

                   .btn-primary {
                       background-color: #007BFF;
                       color: #FFFFFF;
                   }
               </style>
           </head>
           <body>
               <div class='container'>
                   <div class='header'>
                       <img class='logo' src='$logoURL'>
                       <h1>¡Bienvenido(a) a A fondo con Andreina!</h1>
                   </div>
                   <p>&iexcl;Hola $nombres!</p>
                   <p>&iexcl;Felicidades por dar el primer paso hacia una experiencia increíble en A fondo con Andreina!</p>
                   <p>Tu cuenta ha sido creada y ahora solo falta un paso para desbloquear todas las funcionalidades emocionantes que tenemos para ti. Haz clic en el enlace a continuación para activar tu cuenta y sumergirte en un mundo lleno de posibilidades:</p>

                   <p><a href='$url' class='btn btn-primary'>Activar cuenta</a></p>
                   <p>Recuerda que la seguridad de tu cuenta es vital. Si recibes este correo por error o no reconoces la actividad, por favor, contáctanos de inmediato.</p>
                   <p>Gracias por elegir A fondo con Andreina. Estamos ansiosos por tenerte como parte de nuestra comunidad.</p>
                   <p>&iexcl;Bienvenido/a a bordo!</p>
                   <p>Saludos, <br>El equipo de A fondo con Andreina. </p>
               </div>
           </body>
       </html>";

           // Cabecera para enviar correo HTML
           $cabecera = "MIME-Version: 1.0\r\n";
           $cabecera .= "Content-type: text/html; charset=UTF-8\r\n";

           // Si se envía con éxito el correo electrónico, se redirige a una página de confirmación.
           if ($mailer->enviarCorreo($email, $asunto, $cuerpo)) {
               // Redirige a la plantilla y pasa el mensaje como parámetro.
               header("Location: index.php");
               exit;
           }
       } else {
           $errors[] = "Error al registrar usuario"; 
       }
   } else {
       $errors[] = "Error al registrar cliente";
   }
}
}
}

// Fin de la sección de código PHP.

?>

<!DOCTYPE html>
<!-- Created By RobinsonChalas -->
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>A Fondo Login</title>
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   </head>
   <body>
      <div class="login-form">
         <div class="text">
            Registrar usuario
         </div>

        <?php  mostrarMensajes($errors); ?>

         <form action="registrar.php" method="post" autocomplete="off">
            <div class="field">
               <div class="fas fa-name"></div>
               <input type="text" name="nombres" id="nombres" placeholder="Nombre completo">
            </div>
            <div class="field">
               <div class="fas fa-envelope"></div>
               <input type="email" name="email" id="email" placeholder="Correo electrónico" >
            </div>
            <div class="field">
               <div class="fas fa-user"></div>
               <input type="text" name="usuario" id="usuario" placeholder="Usuario" >
            </div>
            <div class="field">
               <div class="fas fa-lock"></div>
               <input type="password" name="password" id="password" placeholder="Contraseña">
            </div>
            <div class="field">
               <div class="fas fa-lock"></div>
               <input type="password"name="repassword" id="repassword" placeholder="Confirmar contraseña">
            </div>
            <button type="submit">Registrar</button>
         </form>
      </div>
   </body>
</html>