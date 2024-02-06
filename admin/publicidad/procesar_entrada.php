
<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database();
$con = $db->conectar();

// Obtener las categorías disponibles
$sql = "SELECT id, patrocinador FROM publicaciones WHERE activo = 1";
$resultado = $con->query($sql);
$categorias = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
</head>
<body>
<?php include '../header.php'; ?>

<style>
.editor-container {
    max-height: 230px;
    /* Altura máxima del contenedor, ajusta según sea necesario */
    overflow-y: auto;
    /* Agrega un scroll vertical al contenedor */
}

.ck-editor__editable[role="textbox"] {
    min-height: 230px;
    /* Mantiene la altura mínima del área de texto del editor */
}
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<!--Link para que coja el estilo de formulario editor-->
<div class="container-fluid px-4">
<h2  class="mt-3">Nueva Publicidad</h2>
    
    <form action="guarda.php" method="post" enctype="multipart/form-data" autocomplete="off"><!--Aqui empieza el formulario-->
        <!---->
            <div class="mb-3"><!--Aqui inicia el input de patrocinador-->
            <label for="patrocinador" class="form-label">Nombre patrocinador</label>
              <input type="text" class="form-control" name="patrocinador" id="patrocinador" required>
            </div><!--Aqui termina el input de patrocinador-->

            <div class="row mb-3"><!--Aqui empieza el div para agregar imagen-->
                <div class="col">
                      <label for="imagen" class="form-label">Imagen de publicidad</label>
                      <input type="file" class="form-control" name="imagen" id="imagen" accept="img/jpeg" required>
                </div><!--Aqui termina el el div del file para agregar imagen-->
            </div>
        <input type="submit" value="Publicar"><!---->
    </form><!--Aqui termina el formulario-->
    </div>

<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
</script>

<?php include '../footer.php';?>

<script src="../js/scripts.js"></script>
</body>

</html>