<?php
require 'php/config.php';
require_once 'php/Mailer.php';

// Establecer una variable de sesión para indicar que se ha enviado el mensaje
$_SESSION['mensaje_enviado'] = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Crear una instancia de la clase Database (o como hayas llamado tu clase)
    $db = new Database();
    // Conectar a la base de datos usando PDO
    $con = $db->conectar();

    // Verificar la conexión
    if ($con === false) {
        die("Error de conexión: " . $db->error());
    }

    try {
        // Utilizar una sentencia preparada para evitar la inyección SQL
        $stmt = $con->prepare("INSERT INTO contactos (name, apellido, email, phone, message) VALUES (:name, :apellido, :email, :phone, :message)");
        // Vincular parámetros
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        // Ejecutar la sentencia preparada
        if ($stmt->execute()) {
            // Enviar correo al Autor
            
            $asuntoAutor = "Gracias por ponerte en contacto con nosotros";
            $asuntoAdmin = "Recibiste un nuevo mensaje";
            $estilosCliente = "
                body {
                    font-family: 'Arial', sans-serif;
                    background-color: #f4f4f4;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }
                
                h3 {
                    color: #3498db;
                    margin-bottom: 10px;
                }
                
                p {
                    margin-bottom: 8px;
                }
                
                img {
                    max-width: 100%;
                    height: auto;
                    display: block;
                    margin: 0 auto;
                }
                
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                
                .thank-you {
                    text-align: center;
                    margin-bottom: 20px;
                }
                
                .order-details {
                    margin-bottom: 20px;
                }
                
                .support-info {
                    margin-top: 20px;
                }
            ";
            $cuerpoAutor = '<html>';
            $cuerpoAutor .= '<head>';
            $cuerpoAutor .= '<style>' . $estilosCliente . '</style>';
            $cuerpoAutor .= '</head>';
            $cuerpoAutor .= '<body>';
            $cuerpoAutor .= '<div class="container">';
            $cuerpoAutor .= '<div class="thank-you"><h3>&iexcl;Gracias por ponerte en contacto con nosotros!</h3></div>';
            $cuerpoAutor .= '<p>&iexcl;Hola ' . $name . '!</b></p>';
            $cuerpoAutor .= '<p>Gracias por ponerte en contacto con nosotros. Hemos recibido tu mensaje y nos pondremos en contacto contigo lo antes posible.</p>';
            $cuerpoAutor .= '<div class="fw-bolder"><p><b>La informacion de tu mensaje es:</b></p></div>';
            $cuerpoAutor .= '<div class="fw-bolder"><p> ' . $message . '</p></div>';
            $cuerpoAutor .= '<div class="support-info"><p>Saludos,<br>El equipo de A Fondo con Andreina</p></div>';
            $cuerpoAutor .= '</div>';
            $cuerpoAutor .= '</body>';
            $cuerpoAutor .= '</html>';

            
            $cuerpoAdmin = '<html>';
            $cuerpoAdmin .= '<head>';
            $cuerpoAdmin .= '<style>' . $estilosCliente . '</style>';
            $cuerpoAdmin .= '</head>';
            $cuerpoAdmin .= '<body>';
            $cuerpoAdmin .= '<div class="container">';
            $cuerpoAdmin .= '<p>&iexcl;Hola A fondo con Andreina!</p>';
            $cuerpoAdmin .= '<p>Se ha recibido un nuevo mensaje de ' . $email . ' .Aquí está la información:</p>';
            $cuerpoAdmin .= '<div class="fw-bolder"><p><b>Contenido del mensaje:</b></p></div>';
            $cuerpoAdmin .= '<div class="fw-bolder"><p> ' . $message . '</p></div>';
            $cuerpoAdmin .= '</div>';
            $cuerpoAdmin .= '</body>';
            $cuerpoAdmin .= '</html>';


            $mailer = new Mailer();
            $mailer->enviarCorreo($email, $asuntoAutor, $cuerpoAutor);
            $mailer->enviarCorreo("afondoconandreina@gmail.com", $asuntoAdmin, $cuerpoAdmin);

            header("Location: info_contacto.php");
        } else {
            echo "Error al enviar el mensaje: " . $stmt->errorInfo()[2];
        }
        // Cerrar la sentencia
        $stmt->closeCursor();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión
        $con = null;
    }
    
} else {
    header("Location: index.php");
}
?>