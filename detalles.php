<?php
require 'php/database.php';
require 'php/config.php';
require 'php/funciones.php';

$db = new Database();
$con = $db->conectar();



// Se verifica si se ha proporcionado un valor para 'id' y 'token' a través del método GET y se asignan a las variables correspondientes.
$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

// Se realiza una comprobación para asegurarse de que 'id' y 'token' no estén vacíos.
if ($id == '' || $token == '')  {
    header("location: index.php");
    exit; // Se muestra un mensaje de error y se finaliza la ejecución del script si faltan parámetros.
} else {
    // Se genera un token temporal basado en 'id' y se compara con el token proporcionado.
    $token_tmp = hash_hmac('sha256', $id, KEY_TOKEN);

    if ($token == $token_tmp) {

        $sql = $con->prepare("SELECT count(id) as count FROM articulo WHERE id=? ");
        $sql->execute([$id]);

        // Si los tokens coinciden, se continúa con la ejecución.
        $sql = $con->prepare("SELECT id, titulo, subtitulo, contenido FROM articulo WHERE id=?  LIMIT 1");
        $sql->execute([$id]);
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    
        // Se verifica si la consulta devuelve resultados.
        if (count($resultado) > 0) {
            // Si existen productos con el 'id' proporcionado, se procede a obtener información adicional.
    
            // Se obtienen los datos de la miniatura y la categoría.
            $meses_espanol = array(
                'ene.', 'feb.', 'mar.', 'abr.', 'may.', 'jun.', 'jul.', 'ago.', 'sep.', 'oct.', 'nov.', 'dic.'
            );
            $row = $resultado[0];
            $subtitulo = $row['subtitulo'];
            $titulo = $row['titulo'];
            $contenido = $row['contenido'];
            // Se define la ubicación de las imágenes del producto.
            $dir_images = 'img/entradas/' . $id . '/';
            // Se crea un array para almacenar las rutas de las imágenes.
            $imagenes = [];
            // Se definen las rutas de las diferentes versiones de imágenes del producto.
            $rutaimgJPG = $dir_images . 'principal.jpg';
            $rutaimgJPEG = $dir_images . 'principal.jpg';
            $rutaimgPNG = $dir_images . 'principal.png';
            $rutaimgWebP = $dir_images . 'principal.webp';
            // Se verifica la existencia de las diferentes versiones de imágenes y se decide cuál utilizar.
            if (!file_exists($rutaimgJPG) && !file_exists($rutaimgJPEG) && !file_exists($rutaimgPNG) && !file_exists($rutaimgWebP)) {
                $rutaimg = 'img/no-photo.jpg'; // Imagen de respaldo si ninguna versión existe
            } else {
                // Se decide cuál de las tres versiones utilizar.
                if (file_exists($rutaimgJPG)) {
                    $rutaimg = $rutaimgJPG; // Utilizar la versión JPG si existe
                } elseif (file_exists($rutaimgJPEG)) {
                    $rutaimg = $rutaimgJPEG; // Utilizar la versión JPEG si existe
                } elseif (file_exists($rutaimgPNG)) {
                    $rutaimg = $rutaimgPNG; // Utilizar la versión PNG si existe
                } elseif (file_exists($rutaimgWebP)) {
                    $rutaimg = $rutaimgWebP; // Utilizar la versión WebP si existe
                }
            }

            // Se crea una instancia del directorio para explorar imágenes adicionales del producto.
            $dir = dir($dir_images);
            

            // Se itera a través del directorio para obtener rutas de imágenes adicionales y almacenarlas en el array $imagenes.
            while(($archivo = $dir->read()) != false){
                if($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg')|| strpos($archivo, 'png') || strpos($archivo, 'webp'))){
                    $imagenes[] = $dir_images . $archivo;
                }
            }

            // Se cierra el directorio.
            $dir->close();
        } else {
            // Si no se encuentran productos con el 'id' proporcionado, se muestra un mensaje de error y se finaliza la ejecución.
            echo 'Error al procesar la petición';
            exit;
        }
    } else {
        // Si los tokens no coinciden, se muestra un mensaje de error y se finaliza la ejecución.
        echo 'Error al procesar la petición';
        exit;
    }
}


?>
<?php require 'header.php' ?>

<main class="container p-4">
  <div class="row g-5">
    <div class="col-md-8">
      <h1 class="pb-4 mb-4 fst-italic ">
      <?php echo $row['titulo']; ?>
      </h1>

      <article class="blog-post">
      <ul>
        <li><h3 class="blog-post-title mb-1"><?php echo $subtitulo; ?></h3></li>
    </ul>
      <br>
        <hr>
            <div class="image-container">
        <?php
        // Itera a través de las imágenes adicionales y las muestra como miniaturas.
        foreach ($imagenes as $img) {
            if ($img !== $rutaimg) { // Excluye la imagen principal
                echo '<img src="' . $img . '" class="thumbnail" width="150" height="150">';
            }
        }
        ?>
        <img src="<?php echo $rutaimg; ?>" width="100%" height="auto">
    </div>

        <blockquote class="blockquote">
        </blockquote>
        <?php echo $row['contenido']; ?>
        
      </article>

    </div>

    <div class="col-md-4 ">
    <div class="position-sticky" style="top: 2rem;">
        <div class="p-4 mb-3 ">
    <div class="px-4 bg-light">
    <h3 class="fst-italic">Relacionadas</h3><hr>
    <aside class="">
                <?php
    $contador = 0; // Inicializamos el contador

    // Mezcla el array de $resultado de forma aleatoria
    shuffle($resultado);

    foreach ($resultado as $row) {
        if ($contador < 7) { // Limitamos a 6 entradas
    ?>
                <div class="mb-4">
                    <div class="card-body">
                        <h5 class="card-text fst-italic">
                            <a href="#" class="link-color">
                                <?php echo $row['titulo']; ?>
                                <hr>
                            </a>
                        </h5>
                    </div>
                </div>
                <?php
            $contador++; // Incrementamos el contador
        } else {
            break; // Salimos del bucle si ya hemos mostrado 6 entradas
        }
    }
    ?>
    </aside>

<div class="p-3 bg-light">
    <h4 class="fst-italic">Redes Sociales</h4>
    <ol class="list-unstyled">
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Instagram</a></li>
    </ol>
</div>

</div>



</main>
<script src="js/apps.js"></script>