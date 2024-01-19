<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database();
$con = $db->conectar();

    $id = $_GET['id'];

// Realiza una consulta SQL para obtener los detalles del producto con el ID proporcionado y asegura que el producto esté activo.
$sql = $con->prepare("SELECT id, titulo, subtitulo, contenido, id_categoria, imagen FROM articulo
WHERE id = ? AND activo = 1");
$sql->execute([$id]);
$entrada = $sql->fetch(PDO::FETCH_ASSOC);

// Realiza una consulta SQL para obtener todas las categorías activas en la base de datos.
$sql = "SELECT id, nombre FROM categoria WHERE activo = 1";
$resultado = $con->query($sql);
$categorias = $resultado->fetchAll(PDO::FETCH_ASSOC);

// Establece la ruta para las imágenes del producto y recopila los nombres de archivo de las imágenes disponibles en el directorio.
$rutaImagenes = '../../img/entradas/' . $id . '/';
$imagenPrincipal = $rutaImagenes . 'principal.jpg';

$imagenes = [];
$dirInit = dir($rutaImagenes);

// Recorre el directorio de imágenes y recopila los nombres de archivo de las imágenes disponibles.
while (($archivo = $dirInit->read()) !== false) {
  if($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg')|| strpos($archivo, 'png') || strpos($archivo, 'webp'))){
    $image = $rutaImagenes . $archivo;
    $imagenes[] = $image;
  }
}

$dirInit->close();

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
    
    <form action="actualiza.php" method="post" enctype="multipart/form-data" autocomplete="off"><!--Aqui empieza el formulario-->
    <input type="hidden" name="id" value="<?php echo $entrada['id']; ?>">
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

            <div class="row col-md-6 mb-4"><!--Aqui empieza el div para agregar imagen-->
                <div class="col">
                <?php if(file_exists($imagenPrincipal)) {  ?>
                    <img src="<?php echo $imagenPrincipal . '?id=' . time(); ?>" class="img-thumbnail my-3"><br>
                    <button class="btn btn-danger btn-sm" onclick="elimaImagen('<?php echo $imagenPrincipal; ?>')"><i class="fa-regular fa-trash-can"></i></button>
                    <?php } ?>
                </div><!--Aqui termina el el div del file para agregar imagen-->
            </div>

                    <div class="">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select class="form-select " name="categoria" id="categoria" required>
                            <option value="">Seleccionar categoría</option>
                            <?php foreach($categorias as $categoria)  { ?>
                            <option value="<?php echo $categoria['id']; ?>" <?php if($categoria['id'] == $entrada['id_categoria']) 
                            echo 'selected'; ?>><?php echo $categoria['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
    

        <input type="submit" value="Publicar Entrada"><!---->
    </form><!--Aqui termina el formulario-->
    </div>
    
<?php require '../footer.php'; ?>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );

        function elimaImagen(urlImagen) {
          let url = 'eliminar_imagen.php'
          let formData = new FormData()
          formData.append('urlImagen', urlImagen)

          fetch(url, {
            method: 'POST',
            body: formData
          }).then((response) => {
            if (response.ok){
                location.reload()
            }
          })
        }
</script>

<script src="js/scripts.js"></script>

