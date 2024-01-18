<?php

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

require_once '../phpmailer/src/PHPMailer.php';
require_once '../phpmailer/src/SMTP.php';
require_once '../phpmailer/src/Exception.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;  //SMTP::DEBUG_SERVER;                    //Enable verbose debug output
    $mail->isSMTP();                                            
    $mail->Host = MAIL_HOST;                                     //Configura el servidor SMTP para enviar
    $mail->SMTPAuth   = true;                                   //Habilita la autenticacion SMTP
    $mail->Username   = MAIL_USER;                             //Usuario SMTP
    $mail->Password   = MAIL_PASS;                            //Contrasena SMTP 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Habilita el cifrado TLS
    $mail->Port = MAIL_PORT;                                //Puerto TCP al que conectarse; si usas 587 configuralo con `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS `

    //Correo emisor y nombre
    $mail->setFrom(MAIL_USER, 'Afondo con Andreina');
    //Correo receptor y nombre
    $mail->addAddress('afondoconandreina@gmail.com', 'Afondo con Andreina');
    //Enviar copia correo
    $mail->addReplyTo('afondoconandreina@gmail.com');

    //Contenido
    $mail->isHTML(true);    //Establecer el formato de correo electronico en HTML                            
    $mail->Subject = 'Detalles de su compra';   //Titulo del correo

    $cuerpo = '<h3>Gracias por su compra</h3> <br> <img src="https://scontent.fhex4-2.fna.fbcdn.net/v/t39.30808-6/271809553_4677616398954273_3880868244671468411_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeGcu-H9-1F0Yevsf-lfSfefkxQrHuKvu9OTFCse4q-70_Aljmpboy_0CQwx4gtn5otpzDPIsz2KG8TI9enfLcvv&_nc_ohc=yNbF8OBDMfYAX-38p4b&_nc_zt=23&_nc_ht=scontent.fhex4-2.fna&oh=00_AfD78th-EZhw8LWopoq5BvM2kAF-lFrdqmkKGBlntED3pA&oe=65553195" width="150" height="150">';
    $cuerpo .= '<p>El ID de su compra es <br>'. $id_transaccion .  '</br></p>';

    $mail->Body    = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra.';

    $mail->setLanguage('es', '../phpmailer/languague/phpmailer.lang-es.php');

    $mail->send();
} catch (Exception $e) {
    echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
    exit;
}