<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database();
$con = $db->conectar();

$titulo = $_POST["titulo"];
$subtitulo = $_POST["subtitulo"];
$contenido = $_POST["contenido"];
$categoria = $_POST["categoria"];


$sql = "INSERT INTO articulo (titulo, subtitulo, contenido, id_categoria, activo) 
VALUES(?, ?, ?, ?, 1)";
$stm = $con->prepare($sql);
if($stm->execute([$titulo, $subtitulo, $contenido, $categoria])){
    $id = $con->lastInsertId();

    if ($_FILES['imagen']['error'] == UPLOAD_ERR_OK){
        $dir = '../../img/entradas/' .$id. '/';
        $permitidos = ['jpeg', 'jpg', 'webp', 'png'];

        $arregloImagen = explode('.', $_FILES['imagen']['name']);
        $extension = strtolower(end($arregloImagen));

        if(in_array($extension, $permitidos)){
            if(!file_exists($dir)){
                mkdir($dir, 0755, true);
            }

            $ruta_img = $dir . 'principal.' . $extension;
            if(move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_img)){
                Echo "El archivo se cargo correctamente";
            } else {
                echo "Error al subir la imagen";
            }
        } else {
            echo "Archivo no permitido";
        }
    } else {
        echo "No enviaste archivo";
    }
 }

header("Location: index.php");




?>