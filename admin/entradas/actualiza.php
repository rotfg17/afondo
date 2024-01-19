<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database();
$con = $db->conectar();

$id = $_POST["id"];
$titulo = $_POST["titulo"];
$subtitulo = $_POST["subtitulo"];
$contenido = $_POST["contenido"];
$categoria = $_POST["categoria"];


$sql = "UPDATE articulo SET titulo = ?, subtitulo = ?, contenido = ?, id_categoria = ? WHERE id = ? ";
$stm = $con->prepare($sql);
if($stm->execute([$titulo, $subtitulo, $contenido, $categoria, $id])){
    $id = $_POST['id'];

       // Establecer la ubicación de las imágenes
   $dir = '../../img/productos/' . $id . '/';
   if (!file_exists($dir)) {
       mkdir($dir, 0777, true); // Crea la carpeta si no existe
   }
   
   $permitidos = ['jpeg', 'jpg', 'png', 'webp'];
   
   // Subir imagen principal si se proporciona
   if ($_FILES['imagen_principal']['error'] == UPLOAD_ERR_OK) {
       $archivo_principal = $_FILES['imagen_principal'];
   
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