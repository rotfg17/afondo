<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database();
$con = $db->conectar();

$id = $_POST["id"];
$patrocinador = $_POST["patrocinador"];


$sql = "UPDATE publicaciones SET patrocinador = ? WHERE id = ? ";
$stm = $con->prepare($sql);
if($stm->execute([$patrocinador, $id])){
    $id = $_POST['id'];

       // Establecer la ubicación de las imágenes
   $dir = '../../img/publicidad/' . $id . '/';
   if (!file_exists($dir)) {
       mkdir($dir, 0777, true); // Crea la carpeta si no existe
   }
   
   $permitidos = ['jpeg', 'jpg', 'png', 'webp'];
   
   // Subir imagen principal si se proporciona
   if ($_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
       $archivo_principal = $_FILES['imagen'];
   
       $extension = strtolower(pathinfo($archivo_principal['name'], PATHINFO_EXTENSION));
   
       if (in_array($extension, $permitidos)) {
           $ruta_img_principal = $dir . 'principal.' . $extension;
           
           if (move_uploaded_file($archivo_principal['tmp_name'], $ruta_img_principal)) {
               echo "Imagen principal cargada correctamente.<br>";
           } else {
               echo "Error al cargar la imagen principal.<br>";
           }
       } else {
           echo "Archivo principal no permitido.<br>";
       }
   }
}

header("Location: index.php");




?>