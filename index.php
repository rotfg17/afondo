<?php
require 'php/database.php';
require 'php/config.php';
require 'php/funciones.php';

$sql = $con->prepare("SELECT id, titulo, subtitulo, contenido FROM articulo WHERE activo = 1  ORDER BY fecha ");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);




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
            ?>
                    <div class="col-md-6 mb-4">
                        <div class="">
                            <div class="card-body">
                                <h2 class="card-text">
                                    <a href="detalles.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha256', $row['id'], KEY_TOKEN); ?>"
                                        class="link-color">
                                        <?php echo $row['titulo']; ?>
                                    </a>
                                </h2>
                                <?php
                                $id = $row['id'];
                                $imagen = "img/entradas/" . $id . "/principal.jpg";

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
   <!--AQUI TERMINA EL CODIGO DEL ASIDE-->
        </div>
    </main>

    <!-- ESTE ES EL CODIGO QUE PERTENECE A LAS MINIATURAS-->
    <div class="album py-5">
    <div class="container">
        <div class="row">
            <?php
            $numEntradasMostradas = 0;
            foreach ($resultado as $miniaturas) :
                if ($numEntradasMostradas > 0 && $numEntradasMostradas % 4 == 0) :
                    // Comienza una nueva fila para cada 4 miniaturas, excepto la primera vez
                    echo '</div><div class="row">';
                endif;
            ?>
                <div class="col-md-2">
                    <div class="efecto">
                        <a href="detalles.php?id=<?php echo $miniaturas['id']; ?>&token=<?php echo hash_hmac('sha256', $miniaturas['id'], KEY_TOKEN); ?>" class=" link-color">
                            <img src="<?php echo $imagen; ?>" alt="imagen-entrada" class="card-img-top">
                        </a>
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
                <?php $numEntradasMostradas++; endforeach; ?>
        </div>
    </div>
</div>
    <script src="js/apps.js"></script>
</body>

</html>