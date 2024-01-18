<?php

require '../php/database.php';
require '../php/config.php';
require '../php/funciones.php';

$db = new Database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {

    $email = trim($_POST['email']);

    if (esNulo([$email])) {
        $errors[] = "Todos los campos son obligatorios";
    }


    if (count($errors) == 0) {
        if (emailExiste($email, $con)) {
            // Se prepara una consulta SQL para obtener el 'id' del usuario y sus nombres asociados al correo.
            $sql = $con->prepare("SELECT usuarios.id, autor.nombres FROM usuarios INNER JOIN autor ON usuarios.id_autor = autor.id
             WHERE autor.email LIKE ? LIMIT 1");
            $sql->execute([$email]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);

            // Se obtiene el 'id' del usuario y sus nombres.
            $user_id = $row['id'];
            $nombres = $row['nombres'];

            $token = solicitaPassword($user_id, $con);

            if ($token !== null) {
                require_once '../php/Mailer.php';
                $mailer = new Mailer();

                $url = SITE_URL . 'reset_password.php?id=' . $user_id . '&token=' . $token;

                // URL de la imagen del logo de la empresa
                $logoURL = "https://www.dropbox.com/scl/fi/8g3vg9p3zmj3r9k3vs2b9/Logo.png?rlkey=buj2lpltcobxpsijxcz6ujewy&dl=0";
                $asunto = "Recuperar credencial - A fondo con Andreina";

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

                        .btn-warning {
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
                        <p>Hemos recibido tu solicitud para restablecer la contraseña de tu cuenta en A fondo con Andreina. </p>
                        <p>Estamos aquí para ayudarte a recuperar el acceso.</p>

                        <p>Por favor, haz clic en el siguiente enlace para crear una nueva contraseña:</p>
                        <p><a href='$url' class='btn btn-warning'>Recuperar contraseña</a></p>
                        <p>Si no has solicitado esta acción, te recomendamos cambiar tu contraseña actual de inmediato y ponerte en contacto con nuestro equipo de soporte.</p>
                        <p>Gracias por confiar en A fondo con Andreina. Si necesitas ayuda adicional, no dudes en ponerte en contacto con nosotros.</p>
                        <p>Saludos, <br>El equipo de A fondo con Andreina. </p>
                    </div>
                </body>
                </html>";

                // Cabecera para enviar correo HTML
                $cabecera = "MIME-Version: 1.0\r\n";
                $cabecera .= "Content-type: text/html; charset=UTF-8\r\n";

                $cuerpo .= "<br>Si no hiciste esta solicitud, por favor ignora este correo.";

                // Si se envía con éxito el correo electrónico, se redirige a una página de confirmación.
                if ($mailer->enviarCorreo($email, $asunto, $cuerpo)) {
                    // Redirige a la plantilla y pasa el mensaje como parámetro.
                    header("Location: index.php");
                    exit;
                }
            }
        } else {
            $errors[] = "No existe una cuenta asociada a esta dirección de correo";
        }
    }
}
?>

<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>A Fondo Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <div class="login-form">
        <div class="text">
            Recuperar contraseña
            <?php mostrarMensajes($errors); ?>
        </div>
        <form action="recupera.php" method="post" autocomplete="off">
            <div class="field">
                <div class="fas fa-lock"></div>
                <input type="email" name="email" id="email" placeholder="Correo electrónico">
            </div>
            <button type="submit">Recuperar contraseña</button>
            <div class="link">
                <a href="index.php">Iniciar sesión</a>
            </div>
        </form>
    </div>
</body>

</html>
