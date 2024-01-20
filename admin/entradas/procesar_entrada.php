
<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database();
$con = $db->conectar();

// Obtener las categorías disponibles
$sql = "SELECT id, nombre FROM categoria WHERE activo = 1";
$resultado = $con->query($sql);
$categorias = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>

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
<h2  class="mt-3">Nueva Entrada</h2>
    
    <form action="guarda.php" method="post" enctype="multipart/form-data" autocomplete="off"><!--Aqui empieza el formulario-->
        <!---->
            <div class="mb-3"><!--Aqui inicia el input de titulo-->
            <label for="titulo" class="form-label">Titulo</label>
              <input type="text" class="form-control" name="titulo" id="titulo" required>
            </div><!--Aqui termina el input de titulo-->

            <div class="mb-3"><!--Aqui inicia el input de subtitulo-->
            <label for="subtitulo" class="form-label">Subtitulo</label>
              <input type="text" class="form-control" name="subtitulo" id="subtitulo" required>
            </div><!--Aqui termina el input de subtitulo-->

            <div class="mb-3"><!--Aqui inicia el input de contenido-->
              <label for="contenido" class="form-label">Contenido</label>
              <textarea  class="form-control" name="contenido" id="editor"  required> </textarea>
            </div><!--Aqui termina el input de contenido-->

            <div class="row mb-2">
                <div class="col">
                      <label for="imagen_principal" class="form-label">Imagen principal</label>
                      <input type="file" class="form-control" name="imagen_principal" id="imagen_principal" accept="img/jpeg" required>
                </div>
                <div class="col">
                <label for="otras_imagenes" class="form-label">Otras imagenes</label>
                <input type="file" class="form-control" name="otras_imagenes[]" id="otras_imagenes" accept="img/jpeg" multiple>
                </div>
            </div>

                    <div class="">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select class="form-select " name="categoria" id="categoria" required>
                            <option value="">Seleccionar categoría</option>
                            <?php foreach($categorias as $categoria)  { ?>
                            <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
    

        <input type="submit" value="Publicar Entrada"><!---->
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