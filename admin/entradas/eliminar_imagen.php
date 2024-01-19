<?php  

// Requiere los archivos necesarios
require '../config/config.php';
require '../../php/database.php';



$urlImagen = $_POST['urlImagen'] ?? ''; //Declaracion de la variable urlImagen

//Sirve para identificar si la url es vacia y si la ubicacion existe, elimina la imagen.
if ($urlImagen !== '' && file_exists($urlImagen)){
        unlink($urlImagen);
}

?>