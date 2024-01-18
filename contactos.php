
<?php

require 'php/database.php';
require 'php/config.php';
require 'php/funciones.php';

?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Form in PHP | CodingNepal</title>
  <link rel="stylesheet" href="css/contact.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>

<?php require 'header.php';?>

  <div class="wrapper">
  
    <form action="procesar_contacto.php" method="post" autocomplete="off">
    <header>Contáctanos</header>
      <div class="dbl-field">
        <div class="field">
          <input type="text"  name="name" placeholder="Ingrese su nombre"required>
          <i class='fas fa-user'></i>
        </div>
        <div class="field">
          <input type="text" name="apellido" placeholder="Ingrese su apellido" required>
          <i class='fas fa-user'></i>
        </div>
      </div>
      <div class="dbl-field">
        <div class="field">
          <input type="email" name="email" placeholder="Ingrese su correo" required>
          <i class='fas fa-envelope'></i>
        </div>
        <div class="field">
          <input type="tel" name="phone" placeholder="Ingrese su teléfono" required>
          <i class='fas fa-phone-alt'></i>
        </div>
      </div>
      <div class="message">
        <textarea placeholder="Escribe tu mensaje" name="message"></textarea>
        <i class="material-icons">message</i>
      </div>
      <div class="button-area">
        <button type="submit">Enviar mensaje</button>
        <span></span>
      </div>
    </form>
  </div>

  <script src="js/apps.js"></script>

</body>
</html>