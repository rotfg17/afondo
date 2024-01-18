<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database();
$con = $db->conectar();

$id_categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : 1;
// Obtener las categorías disponibles
$sql = "SELECT id, nombre FROM categoria WHERE activo = 1";
$resultado = $con->query($sql);
$categorias = $resultado->fetchAll(PDO::FETCH_ASSOC);

// Verificar si se ha proporcionado un ID válido
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los detalles de la entrada existente
    $stmt = $con->prepare("SELECT id, titulo, subtitulo, contenido, id_categoria, imagen FROM articulo WHERE id = ? AND activo =1");
    $stmt->execute([$id]);
    $entrada = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si la entrada existe
    if (!$entrada) {
        echo "Entrada no encontrada.";
        exit;
    }
} else {
    echo "ID de entrada no válido.";
    exit;
}

// Procesar la actualización cuando se envíe el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $subtitulo = $_POST["subtitulo"];
    $contenido = $_POST["contenido"];

    // Manejo de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];

        // Mover la imagen a una ubicación permanente
        $carpeta_destino = '../../img/entradas/';
        $ruta_imagen = $carpeta_destino . $imagen_nombre;
        move_uploaded_file($imagen_temp, $ruta_imagen);
    } else {
        // Mantener la imagen actual si no se selecciona una nueva
        $ruta_imagen = $entrada['imagen'];
    }

    // Actualizar la entrada en la base de datos
    $stmt = $con->prepare("UPDATE articulo SET titulo = :titulo, subtitulo = :subtitulo, contenido = :contenido, id_categoria = :categoria, imagen = :imagen WHERE id = :id");
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':subtitulo', $subtitulo);
    $stmt->bindParam(':contenido', $contenido);
    $stmt->bindParam(':categoria', $id_categoria);
    $stmt->bindParam(':imagen', $ruta_imagen);
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    header("Location: index.php");
}
?>

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
<?php include '../header.php'; ?>
<div class="container-fluid px-4">
<h2  class="mt-3">Editar Entrada</h2>
    
    <form action="edita.php?id=<?= $id ?>" method="post" enctype="multipart/form-data" autocomplete="off"><!--Aqui empieza el formulario-->
        <!---->
            <div class="mb-3"><!--Aqui inicia el input de titulo-->
            <label for="titulo" class="form-label">Titulo</label>
              <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo $entrada['titulo']; ?>" required autofocus>
            </div><!--Aqui termina el input de titulo-->

            <div class="mb-3"><!--Aqui inicia el input de subtitulo-->
            <label for="subtitulo" class="form-label">Subtitulo</label>
              <input type="text" class="form-control" name="subtitulo" id="subtitulo" value="<?php echo $entrada['subtitulo']; ?>" required autofocus>
            </div><!--Aqui termina el input de subtitulo-->

            <div class="mb-3"><!--Aqui inicia el input de contenido-->
              <label for="contenido" class="form-label">Contenido</label>
              <textarea  class="form-control" name="contenido" id="editor"  required autofocus><?php echo $entrada['contenido']; ?> </textarea>
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
    
<?php require '../footer.php'; ?>

<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
</script>

<script src="js/scripts.js"></script>

