<?php
require 'php/database.php';
require 'php/config.php';
require 'php/funciones.php';

$sql = $con->prepare("SELECT id, titulo, subtitulo, contenido, id_categoria FROM articulo WHERE activo = 1  ORDER BY fecha ");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesamiento del formulario solo cuando se envía
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    // Manejo de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];

        // Mover la imagen a una ubicación permanente
        $carpeta_destino = 'img/entradas/';
        $ruta_imagen = $carpeta_destino . $imagen_nombre;
        move_uploaded_file($imagen_temp, $ruta_imagen);
    } else {
        // Manejar el caso en el que no se seleccionó una imagen
        $ruta_imagen = null; // O establece una ruta predeterminada si lo prefieres
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

    <!-- Aquí comienza el inicio del carrusel para poner promociones o anuncios relevantes -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/anuncio.jpeg" class="d-block w-100 p-4 img-thumbnail" style="max-height: 500px;"
                    alt="Anuncio de ayuntamiento">
            </div>
            <div class="carousel-item">
                <img src="img/anuncio.jpeg" class="d-block w-100 p-4 img-thumbnail" style="max-height: 500px;"
                    alt="Anuncio 1">
            </div>
            <div class="carousel-item">
                <img src="img/anuncio.jpeg" class="d-block w-100 p-4 img-thumbnail" style="max-height: 500px;"
                    alt="Anuncio 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div><!-- Aquí termina el inicio del carrusel para poner promociones o anuncios relevantes -->




    <main class="container py-5">
    <div class="row">
    <div class="col-lg-9">
        <div class="row" data-masonry='{"percentPosition": true }'>
            <?php
            $contador = 0; // Inicializamos el contador
            foreach ($resultado as $row) {
                if ($contador < 4) { // Limitamos a 4 entradas
                    // Obtener información de la categoría
                    $id_categoria = $row['id_categoria']; // Ajusta esto según la estructura real de tu base de datos
                    $sql_categoria = $con->prepare("SELECT nombre FROM categoria WHERE id = ?");
                    $sql_categoria->execute([$id_categoria]);
                    $categoria = $sql_categoria->fetchColumn();

                    // Resto del código para obtener la imagen
                    $id = $row['id'];
                    $imagen = "img/entradas/" . $id . "/principal";

                    $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

                    foreach ($extensiones_permitidas as $extension) {
                        $imagen_con_extension = $imagen . '.' . $extension;
                        if (file_exists($imagen_con_extension)) {
                            $imagen = $imagen_con_extension;
                            break;
                        }
                    }

                    if (!file_exists($imagen)) {
                        $imagen = "img/no-photo.jpg";
                    }
                    ?>
                    <div class="col-md-6 mb-4">
                        <div class="">
                            <div class="card-body">
                                <h2 class="card-text">
                                <div class="texto  <?php echo $categoria; ?> ">
                            <a class="text-decoration-none n-link" href=" <?php echo $categoria; ?>.php"> <?php echo $categoria; ?></a>
                        </div>
                                    <a href="detalles.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha256', $row['id'], KEY_TOKEN); ?>" class="link-color">
                                        <?php echo $row['titulo']; ?>
                                    </a>
                                </h2>
                                <img src="<?php echo $imagen; ?>" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                    <?php
                    $contador++; // Incrementamos el contador
                } else {
                    break; // Salimos del bucle si ya hemos mostrado 4 entradas
                }
            }
            ?>
        </div>
    </div>



            <!--AQUI EMPIEZA EL CODIGO DEL ASIDE-->
            <aside class="col-lg-3">
    <?php
    $contador = 0; // Inicializamos el contador

    // Hacemos una copia de $resultado para evitar modificar el array original
    $resultado_shuffle = $resultado;
    shuffle($resultado_shuffle);
    ?>
    <div class="mb-4">
        <div class="card-body">
            <?php
            // Recuperamos hasta 9 noticias adicionales (diferentes de la noticia actual) con su categoría y fecha de publicación.
            $sql_noticias_relacionadas = $con->prepare("SELECT a.id, a.titulo, a.fecha, c.nombre AS nombre_categoria
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
                    <?php foreach ($noticias_relacionadas as $noticia) {
                        if ($contador < 5) { // Limitamos a 7 entradas
                            ?>
                            <li>
                                <div class="mb-2 categoria <?php echo strtolower($noticia['nombre_categoria']); ?>">
                                    <a class="text-decoration-none n-link"
                                       href="<?php echo strtolower($noticia['nombre_categoria']); ?>.php"><?php echo $noticia['nombre_categoria']; ?></a>
                                </div>
                                <span>
                                    <a class="text-decoration-none textoo"
                                       href="detalles.php?id=<?php echo $noticia['id']; ?>&token=<?php echo hash_hmac('sha256', $noticia['id'], KEY_TOKEN); ?>">
                                        <?php echo $noticia['titulo']; ?>
                                    </a>
                                </span>
                                <!-- Muestra la fecha y hora de publicación en el formato especificado -->
                                <p class="fecha-publicacion">
                                    <?php echo strftime('%I:%M %p | %B %e, %Y', strtotime($noticia['fecha'])); ?>
                                </p>
                                <hr>
                            </li>
                            <?php
                            $contador++; // Incrementamos el contador
                        } else {
                            break; // Salimos del bucle si ya hemos mostrado 7 entradas
                        }
                    } ?>
                </ul>
                <?php
            } else {
                // Si no se encuentran noticias relacionadas, se muestra un mensaje.
                echo '<p>No hay noticias relacionadas disponibles.</p>';
            }
            ?>
        </div>
    </div>
</aside>



   <!--AQUI TERMINA EL CODIGO DEL ASIDE-->
        </div>
    </main>

    <!-- ESTE ES EL CODIGO QUE PERTENECE A LAS MINIATURAS-->
    <div class="album py-5">
    <div class="container">
        <div class="row">
            <?php
            $numEntradasMostradas = 0;
            $maxEntradas = 8; // Número máximo de entradas a mostrar

            foreach ($resultado as $miniaturas) {
                // Obtener información de la categoría
                $id_categoria = $miniaturas['id_categoria']; // Ajusta esto según la estructura real de tu base de datos
                $sql_categoria = $con->prepare("SELECT nombre FROM categoria WHERE id = ?");
                $sql_categoria->execute([$id_categoria]);
                $categoria = $sql_categoria->fetchColumn();

                // Utilizamos una variable diferente para la imagen
                $imagen_miniatura = "img/entradas/" . $miniaturas['id'] . "/principal";
                $extensiones_permitidas_miniatura = ['jpg', 'jpeg', 'png', 'webp'];

                foreach ($extensiones_permitidas_miniatura as $extension_miniatura) {
                    $imagen_con_extension_miniatura = $imagen_miniatura . '.' . $extension_miniatura;
                    if (file_exists($imagen_con_extension_miniatura)) {
                        $imagen_miniatura = $imagen_con_extension_miniatura;
                        break;
                    }
                }

                if (!file_exists($imagen_miniatura)) {
                    $imagen_miniatura = "img/no-photo.jpg";
                }

                // Comienza una nueva fila para cada 4 miniaturas (excepto la primera vez)
                if ($numEntradasMostradas > 0 && $numEntradasMostradas % 4 == 0) {
                    echo '</div><div class="row">';
                }

                // Mostrar solo las primeras 8 entradas
                if ($numEntradasMostradas < $maxEntradas) :
            ?>
                    <div class="col-md-2">
                        <div class="efecto">
                            <a href="detalles.php?id=<?php echo $miniaturas['id']; ?>&token=<?php echo hash_hmac('sha256', $miniaturas['id'], KEY_TOKEN); ?>" class=" link-color">
                                <img src="<?php echo $imagen_miniatura; ?>" alt="imagen-entrada" class="card-img-top">
                            </a>
                            <div class="mb-2 textoo  <?php echo $categoria; ?> ">
                            <a class="text-decoration-none n-link" href=" <?php echo $categoria; ?>.php"> <?php echo $categoria; ?></a>
                        </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-text">
                                        <a href="detalles.php?id=<?php echo $miniaturas['id']; ?>&token=<?php echo hash_hmac('sha256', $miniaturas['id'], KEY_TOKEN); ?>" class="link-color">
                                            <?php echo $miniaturas['titulo']; ?>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                endif;
                $numEntradasMostradas++;

                // Salir del bucle después de mostrar las primeras 8 entradas
                if ($numEntradasMostradas >= $maxEntradas) {
                    break;
                }
            }
            ?>
        </div>
    </div>
</div>






    <script src="js/apps.js"></script>
</body>

</html>