<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database();
$con = $db->conectar();

// Obtener las categorías disponibles
$sql = "SELECT id, nombre FROM categoria WHERE activo = 1";
$resultado = $con->query($sql);
$categorias = $resultado->fetchAll(PDO::FETCH_ASSOC);

// Verificar si se ha proporcionado un ID válido
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los detalles de la entrada existente
    $stmt = $con->prepare("SELECT id, titulo,  contenido, fecha, imagen FROM miniaturas WHERE id = ? AND activo =1");
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];

        $carpeta_destino = '../../img/entradas/';
        $ruta_imagen = $carpeta_destino . $imagen_nombre;
        move_uploaded_file($imagen_temp, $ruta_imagen);
    } else {

        $ruta_imagen = '../../img/entradas/no-photo.jpg'; 

    }

    $id_categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : 1;

        // Actualizar la entrada en la base de datos
        $stmt = $con->prepare("UPDATE miniaturas SET titulo = :titulo,  contenido = :contenido, fecha = :fecha, imagen = :imagen WHERE id = :id");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':contenido', $contenido);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':imagen', $ruta_imagen);
        $stmt->bindParam(':id', $id);
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
    <h2 class="mt-3">Editar Miniatura</h2>

    <form action="nuevo.php" method="post" enctype="multipart/form-data" autocomplete="off">
        <!--Aqui empieza el formulario-->
        <!---->
        <div class="mb-3">
            <!--Aqui inicia el input de titulo-->
            <label for="titulo" class="form-label">Titulo</label>
            <input type="text" class="form-control" name="titulo" id="titulo"value="<?php echo $entrada['titulo']; ?>" required autofocus>
        </div>
        <!--Aqui termina el input de titulo-->

        <div class="mb-3">
            <!--Aqui inicia el input de contenido-->
            <label for="contenido" class="form-label">Contenido</label>
            <textarea class="form-control" name="contenido" id="editor"<?php echo $entrada['contenido']; ?> required autofocus> </textarea>
        </div>
        <!--Aqui termina el input de contenido-->

        <div class="row mb-3">
            <!--Aqui empieza el div para agregar imagen-->
            <div class="col">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" class="form-control" name="imagen" id="imagen" accept="img/jpeg">
            </div>
            <!--Aqui termina el el div del file para agregar imagen-->
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


        <input type="submit" value="Publicar Entrada">
        <!---->
    </form>
    <!--Aqui termina el formulario-->
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