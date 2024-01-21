<?php
require 'php/database.php';
require 'php/config.php';
require 'php/funciones.php';

$db = new Database();
$con = $db->conectar();

$sql2 = $con->prepare("SELECT id, nombres, region FROM autor WHERE activo = 1");
$sql2->execute();
$result = $sql2->fetchAll(PDO::FETCH_ASSOC);

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
        $sql = $con->prepare("SELECT id, titulo, subtitulo, contenido, fecha FROM articulo WHERE id=?  LIMIT 1");
        $sql->execute([$id]);
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    
        // Se verifica si la consulta devuelve resultados.
        if (count($resultado) > 0) {
            // Si existen productos con el 'id' proporcionado, se procede a obtener información adicional.
    
            // Se obtienen los datos de la miniatura y la categoría.
            $row = $resultado[0];
            $subtitulo = $row['subtitulo'];
            $titulo = $row['titulo'];
            $contenido = $row['contenido'];
            $fecha = $row['fecha'];
            $mes_numero = date('n', strtotime($fecha));
            $meses_espanol = array(
                'ene.', 'feb.', 'mar.', 'abr.', 'may.', 'jun.', 'jul.', 'ago.', 'sep.', 'oct.', 'nov.', 'dic.'
            );
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>A fondo con Andreina</title>

</head>

<body>
<?php require 'header.php' ?>

<main class="container p-4">
    <?php
    $stmt = $con->prepare("SELECT id, nombre FROM categoria WHERE activo = 1");
    $stmt->execute();
    $entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Asumiendo que deseas mostrar la primera categoría activa (puedes ajustar según tus necesidades)
    if (!empty($entradas)) {
        $rows = $entradas[0];
    ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($rows['nombre']); ?></li>
            </ol>
        </nav>
    <?php
    }
    ?>

    <div class="row g-5">
        <div class="col-md-8">
            <h1 class="pb-4 mb-4 fst-italic ">
                <?php echo $row['titulo']; ?>
            </h1>

            <article class="blog-post">
                <ul>
                    <li><p class="blog-post-title subtitulo"><?php echo $row['subtitulo']; ?></p></li>
                </ul>

                <?php foreach ($result as $autor): ?>
                    <?php
                    $nombre_mes_espanol = $meses_espanol[$mes_numero - 1];
                    $fecha_formateada = $nombre_mes_espanol . date(" d, Y | h:i a", strtotime($fecha));
                    ?>

                    <div class="autor-container">
                        <img src="img/autor.jpeg" alt="Imagen de <?php echo $autor['nombres']; ?>" width="50" height="50">
                        <div class="info-container">
                            <h6 class="blog-post-title mb-1"><b><?php echo $autor['nombres']; ?></b></h6>
                            <p class="blog-post-meta texto"><?php echo $autor['region']; ?> - <?php echo $fecha_formateada; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>

                <hr>

                <div class="image-container">
                    <?php
                    // Itera a través de las imágenes adicionales y las muestra como miniaturas.
                    foreach ($imagenes as $img) {
                        if ($img !== $rutaimg) { // Excluye la imagen principal
                            echo '<img src="' . $img . '" class="thumbnail img-fluid" width="150" height="150">';
                        }
                    }
                    ?>
                    <img src="<?php echo $rutaimg; ?>" class="img-fluid" alt="Imagen principal del artículo">
                </div>

                <blockquote class="blockquote">
                </blockquote>
                <?php echo $row['contenido']; ?>
            </article>
        </div>

        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4 mb-3 ">
                    <div class="px-4 bg-light">
                        <aside class="">
                        <?php
    // Recuperamos hasta 9 noticias adicionales (diferentes de la noticia actual) con su categoría.
    $sql_noticias_relacionadas = $con->prepare("SELECT a.id, a.titulo, c.nombre AS nombre_categoria
                                               FROM articulo a
                                               JOIN categoria c ON a.id_categoria = c.id
                                               WHERE a.id != ?
                                               ORDER BY RAND() LIMIT 9");
    $sql_noticias_relacionadas->execute([$id]);
    $noticias_relacionadas = $sql_noticias_relacionadas->fetchAll(PDO::FETCH_ASSOC);

    // Mostramos las noticias relacionadas.
    if (count($noticias_relacionadas) > 0) {
    ?>
        <h4>EN PORTADA</h4>
        <hr>
        <ul>
            <?php foreach ($noticias_relacionadas as $noticia) { ?>
                <li>
                <div class="mb-2 categoria <?php echo strtolower($noticia['nombre_categoria']); ?> ">
                            <a class="text-decoration-none n-link" href="<?php echo strtolower($noticia['nombre_categoria']); ?>.php"><?php echo $noticia['nombre_categoria']; ?></a>
                        </div>
                    <span>
                        <a class="text-decoration-none textoo" href="detalles.php?id=<?php echo $noticia['id']; ?>&token=<?php echo hash_hmac('sha256', $noticia['id'], KEY_TOKEN); ?>">
                            <?php echo $noticia['titulo']; ?>
                            <hr>
                        </a>
                    </span>
                </li>
            <?php } ?>
        </ul>
    <?php
    } else {
        // Si no se encuentran noticias relacionadas, se muestra un mensaje.
        echo '<p>No hay noticias relacionadas disponibles.</p>';
    }
    ?>

                            <h5>Redes sociales</h5>
                            <div class="socials-container">
                            <a href="#" class="social twitter">
    <svg height="1em" viewBox="0 0 512 512">
      <path
        d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"
      ></path>
    </svg>
  </a>

  <a href="#" class="social facebook"
    ><svg height="1em" viewBox="0 0 320 512">
      <path
        d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
      ></path></svg
  ></a>

  <a href="#" class="social instagram"
    ><svg height="1em" viewBox="0 0 448 512">
      <path
        d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"
      ></path></svg></a>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="js/apps.js"></script>

</body>

</html>