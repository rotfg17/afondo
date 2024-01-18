<?php

class Database {

    private $hostname = "localhost";     // Host de la base de datos
    private $database = "newpaper_db"; // Nombre de la base de datos
    private $username = "root";         // Nombre de usuario de la base de datos
    private $password = "Informatico1996!"; // Contraseña de la base de datos
    private $charset = "utf8";           // Juego de caracteres

    // Método para establecer una conexión a la base de datos
    function conectar()
    {
        try {
            // Configuración de la conexión
            $conexion = "mysql:host=" . $this->hostname . "; dbname=" . $this->database . ";charset=" . $this->charset;

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,      // Modo de error: Lanzar excepciones en caso de error
                PDO::ATTR_EMULATE_PREPARES => false               // Deshabilitar emulación de consultas preparadas
            ];

            // Crear una instancia de la clase PDO para la conexión
            $pdo = new PDO($conexion, $this->username, $this->password, $options);

            return $pdo; // Devuelve la instancia de conexión a la base de datos
        } catch (PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage(); // Muestra un mensaje de error en caso de fallo
            exit; // Finaliza la ejecución del script
        }
    }
}

//PDO (PHP Data Objects) para conectarse a la base de datos MySQL 
//y establece opciones para el manejo de errores y la desactivación de la emulación de consultas preparadas. 
?>
