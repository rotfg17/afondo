<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database();
$con = $db->conectar();

$titulo = $_POST["titulo"];
$subtitulo = $_POST["subtitulo"];
$contenido = $_POST["contenido"];
$fecha = $_POST["fecha"];
$categoria = $_POST["categoria"];


$sql = "INSERT INTO articulo (titulo, subtitulo, contenido, fecha, id_categoria, activo) 
VALUES(?, ?, ?, ?, ?, 1)";
$stm = $con->prepare($sql);
if($stm->execute([$titulo, $subtitulo, $contenido, $fecha, $categoria, $con])){
    $id = $con->lastInsertId();
}

    if ($_FILES['imagen']['error'] == UPLOAD_ERR_OK){
        $dir = '';
    }

//header("Location: index.php");




?>