
<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database();
$con = $db->conectar();

// Obtener las categorías disponibles
$sql = "SELECT id, nombre FROM categoria WHERE activo = 1";
$resultado = $con->query($sql);
$categorias = $resultado->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];

        $carpeta_destino = '../../img/miniaturas/';
        $ruta_imagen = $carpeta_destino . $imagen_nombre;
        move_uploaded_file($imagen_temp, $ruta_imagen);
    } else {

        $ruta_imagen = '../../img/miniaturas/no-photo.jpg'; 

    }

    $id_categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : 1;

    // Guardar la entrada en la base de datos
    $stmt = $con->prepare("INSERT INTO miniaturas (titulo, contenido, fecha, imagen) VALUES (:titulo, :contenido, :fecha, :imagen)");
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':contenido', $contenido);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':imagen', $ruta_imagen);
    $stmt->execute();

    header("Location: index.php"); // Redireccionar al dashboard después de la publicación
}
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
<h2  class="mt-3">Nueva miniatura</h2>
    
    <form action="nuevo.php" method="post" enctype="multipart/form-data" autocomplete="off"><!--Aqui empieza el formulario-->
        <!---->
            <div class="mb-3"><!--Aqui inicia el input de titulo-->
            <label for="titulo" class="form-label">Titulo</label>
              <input type="text" class="form-control" name="titulo" id="titulo" required autofocus>
            </div><!--Aqui termina el input de titulo-->

            <div class="mb-3"><!--Aqui inicia el input de contenido-->
              <label for="contenido" class="form-label">Contenido</label>
              <textarea  class="form-control" name="contenido" id="editor"  required autofocus> </textarea>
            </div><!--Aqui termina el input de contenido-->

            <div class="row mb-3"><!--Aqui empieza el div para agregar imagen-->
                <div class="col">
                      <label for="imagen" class="form-label">Imagen</label>
                      <input type="file" class="form-control" name="imagen" id="imagen" accept="img/jpeg">
                </div><!--Aqui termina el el div del file para agregar imagen-->
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