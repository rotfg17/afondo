<?php

$path = dirname(__FILE__) . DIRECTORY_SEPARATOR;

require_once $path . 'database.php';
require_once $path . '../php/cifrado.php';

// Conexión a la base de datos
$db = new Database();
$con = $db->conectar();

// Consulta de configuración desde la base de datos
$sql = "SELECT nombre, valor FROM configuracion";
$resultado = $con->query($sql);
$datosConfig = $resultado->fetchAll(PDO::FETCH_ASSOC);

// Almacena la configuración en un arreglo asociativo
$config = [];

foreach ($datosConfig as $datoConfig) {
    $config[$datoConfig['nombre']] = $datoConfig['valor'];
}

// Configuración del sistema
define("SITE_URL", "http://localhost/afondo/admin/"); // URL del sitio web
define("KEY_TOKEN", "FERRE.2023-mon--2598301*"); // Clave de token
define("MONEDA", "RD$"); // Moneda local
define("DOLAR", "USD$"); // Moneda en dólares

// Configuración PayPal
define("CLIENT_ID", "AdQ05myVMQmkF9wVllz2WY6JekeJz1ZlWq4BYIJRDA0OXEnT_lsq4cV71vLWXgrR5nedXD_-yyrn6HO_"); // ID de cliente de PayPal
define("CURRENCY", "USD"); // Moneda de PayPal

// Datos para el envío de correo electrónico
define("MAIL_HOST", $config['correo_smtp']); // Servidor SMTP para el correo
define("MAIL_USER", $config['correo_email']); // Usuario del correo
define("MAIL_PASS", descifrar($config['correo_password'], ['key' => KEY_CIFRADO, 'method' => METODO_CIFRADO])); // Contraseña de correo (descifrada)
define("MAIL_PORT", $config['correo_puerto']); // Puerto del servidor de correo

// Iniciar la sesión
session_start();

// Contadores para el carrito y la lista de deseos
$num_cart = 0;
$num_whislist = 0;

// Verificar si existen productos en el carrito
if (isset($_SESSION['carrito']['productos'])) {
    $num_cart = count($_SESSION['carrito']['productos']);
}

// Verificar si existen productos en la lista de deseos
if (isset($_SESSION['wishlist']['products'])) {
    $num_whislist = count($_SESSION['wishlist']['products']);
}
