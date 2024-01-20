<?php
require 'php/database.php';
require 'php/config.php';
require 'php/funciones.php';

$db = new Database();
$con = $db->conectar();

$stmt = $con->prepare("SELECT id, nombre FROM categoria WHERE activo = 1 ");
$stmt->execute();
$entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql2 = $con->prepare("SELECT id, nombres, region  FROM  autor WHERE activo = 1");
        $sql2->execute();
        $resultado = $sql2->fetchAll(PDO::FETCH_ASSOC);


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


        // Si los tokens coinciden, se continúa con la ejecución.
        $sql = $con->prepare("SELECT a.id, a.titulo, a.subtitulo, a.contenido, a.fecha, a.imagen, c.nombre as nombre_categoria, autor.nombres as nombre_autor, autor.region as region_autor
            FROM articulo a
            INNER JOIN categoria c ON a.id_categoria = c.id
            INNER JOIN autor ON a.id_autor = autor.id
            WHERE a.activo = 1 AND c.activo = 1 AND autor.activo = 1
            LIMIT 1");
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    
        // Se verifica si la consulta devuelve resultados.
        if (count($resultado) > 0) {
            // Si existen productos con el 'id' proporcionado, se procede a obtener información adicional.
    
            // Se obtienen los datos de la miniatura y la categoría.
            $meses_espanol = array(
                'ene.', 'feb.', 'mar.', 'abr.', 'may.', 'jun.', 'jul.', 'ago.', 'sep.', 'oct.', 'nov.', 'dic.'
            );
            $row = $resultado[0];
            $titulo = $row['titulo'];
            $contenido = $row['contenido'];
            $fecha = $row['fecha'];
            $mes_numero = date('n', strtotime($fecha));
            $nombre_mes_espanol = $meses_espanol[$mes_numero - 1];
            $fecha_formateada = $nombre_mes_espanol . date(" d, Y | h:i a", strtotime($fecha));
            $meses_espanol = array(
                'ene.', 'feb.', 'mar.', 'abr.', 'may.', 'jun.', 'jul.', 'ago.', 'sep.', 'oct.', 'nov.', 'dic.'
            );
            $nombre_categoria = $row['nombre_categoria']; // Cambiado para reflejar el alias correcto
            $nombre_autor = $row['nombre_autor']; // Cambiado para reflejar el alias correcto
            $region_autor = $row['region_autor'];
            
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
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo $row['nombre_categoria']; ?></li>
  </ol>
</nav>
  <div class="row g-5">
    <div class="col-md-8">
      <h1 class="pb-4 mb-4 fst-italic ">
      <?php echo $row['titulo']; ?>
      </h1>

      <article class="blog-post">
      <ul>
        <li><h3 class="blog-post-title mb-1"><?php echo $row['subtitulo']; ?></h3></li>
    </ul>
      <br>
        <h6 class="blog-post-title mb-1"><b><?php echo $row['nombre_autor']; ?></b></h6>
        <p class="blog-post-meta texto"><?php echo $row['region_autor']; ?> - <?php echo $fecha_formateada; ?></p>
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
    <h4 class="fst-italic">Archives</h4>
    <ol class="list-unstyled mb-0">
    <li>
    <a href="actualidad.php" class="link-color"><?php echo $row['nombre_categoria']; ?></a><br>
    <h5 class="card-text">
    <a href="detalles.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha256', $row['id'], KEY_TOKEN); ?>"class="link-color">
        <?php echo $row['titulo']; ?>
    </h5>
    </a>
    </li>

        <hr>
        <li><a href="#">February 2021</a></li>
        <li><a href="#">January 2021</a></li>
        <li><a href="#">December 2020</a></li>
        <li><a href="#">November 2020</a></li>
        <li><a href="#">October 2020</a></li>
        <li><a href="#">September 2020</a></li>
        <li><a href="#">August 2020</a></li>
        <li><a href="#">July 2020</a></li>
        <li><a href="#">June 2020</a></li>
        <li><a href="#">May 2020</a></li>
        <li><a href="#">April 2020</a></li>
    </ol>
</div>

<div class="p-3 bg-light">
    <h4 class="fst-italic">Elsewhere</h4>
    <ol class="list-unstyled">
        <li><a href="#">GitHub</a></li>
        <li><a href="#">Twitter</a></li>
        <li><a href="#">Facebook</a></li>
    </ol>
</div>

</div>



</main>
<script src="js/apps.js"></script>