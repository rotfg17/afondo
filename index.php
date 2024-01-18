<?php
require 'php/database.php';
require 'php/config.php';
require 'php/funciones.php';

$sql = $con->prepare("SELECT id, titulo, subtitulo, contenido FROM articulo WHERE activo = 1  ORDER BY fecha DESC LIMIT 4");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

$stmt = $con->prepare("SELECT id, titulo, contenido FROM miniaturas WHERE activo = 1 ORDER BY fecha DESC");
$stmt->execute();
$entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);



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
                <?php foreach ($resultado as $row) { ?>
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
                                // Se extrae el 'id' del producto y se forma la ruta de la imagen principal.
                                $id = $row['id'];
                                $imagen = "img/entradas/" . $id . "/principal.jpg";

                                // Se define una lista de extensiones de archivo permitidas.
                                $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

                                // Se busca una imagen válida en los formatos permitidos.
                                foreach ($extensiones_permitidas as $extension) {
                                    $imagen_con_extension = $imagen . '.' . $extension;
                                    if (file_exists($imagen_con_extension)) {
                                        $imagen = $imagen_con_extension;
                                        break; // Sale del bucle si se encontró una imagen válida.
                                    }
                                }
                                // Si no se encuentra una imagen válida, se establece una imagen de respaldo.
                                if (!file_exists($imagen)) {
                                    $imagen = "img/no-photo.jpg";
                                }
                                ?>
                                <img src="<?php echo $imagen; ?>" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!--AQUI EMPIEZA EL CODIGO DEL ASIDE-->
        <aside class="col-lg-3">
            <div class="mb-4">
                <img src="https://resources.diariolibre.com/images/2024/01/12/oficina-de-wilfrido-vargas-asegura-que-el-artista-no-consume-alcohol_1-focus-0-0-896-504.jpg "
                    class="img-fluid" alt="" >
                <div class="card-body">
                    <h5 class="card-text">
                        <a href="#" class="link-color">
                            La verdad detrás de la entrevista de Wilfrido Vargas en el programa Despierta América
                        </a>
                    </h5>
                </div>
            </div>

            <div class="mb-4">
                <img src="https://resources.diariolibre.com/images/2024/01/10/crop-w670-h447-fito-lider-de-los-choneros-y-su-fuga-de-prision-en-ecuador-focus-min0.08-0.07-896-504.jpg"
                    class="img-fluid" alt="">
                <div class="card-body">
                    <h5 class="card-text">
                        <a href="#" class="link-color">
                            Colombia sospecha que entró a ese país Fito, el capo que desató crisis de Ecuador
                        </a>
                    </h5>
                </div>
            </div>

            <div class="mb-4">
                <img src="https://resources.diariolibre.com/images/2023/12/08/bajaran-precios-de-tres-combustibles_4-focus-0-0-896-504.jpg"
                    class="img-fluid" alt="">
                <div class="card-body">
                    <h5 class="card-text">
                        <a href="#" class="link-color">
                            Estos serán los precios de los combustibles a partir de este sábado
                        </a>
                    </h5>
                </div>



            <!-- Resto del código del ASIDE... -->
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
        foreach (array_slice($entradas, 0, 8) as $miniaturas) :
            if ($numEntradasMostradas % 4 == 0) :
                // Comienza una nueva fila para cada 4 miniaturas
                echo '</div><div class="row">';
            endif;
        ?>
            <div class="col-md-2">
                <div class="efecto">
                <?php
                // Se extrae el 'id' del producto y se forma la ruta de la imagen principal.
                $id = $miniaturas['id'];
                $imagen = "img/miniaturas/" . $id . "/miniatura.jpg";

                // Se define una lista de extensiones de archivo permitidas.
                $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

                // Se busca una imagen válida en los formatos permitidos.
                foreach ($extensiones_permitidas as $extension) {
                    $imagen_con_extension = $imagen . '.' . $extension;
                    if (file_exists($imagen_con_extension)) {
                        $imagen = $imagen_con_extension;
                        break; // Sale del bucle si se encontró una imagen válida.
                    }
                }
                // Si no se encuentra una imagen válida, se establece una imagen de respaldo.
                if (!file_exists($imagen)) {
                    $imagen = "img/no-photo.jpg";
                }
                ?>
                    <a href="detalles_miniaturas.php?id=<?php echo $miniaturas['id']; ?>&token=<?php echo hash_hmac('sha256', $miniaturas['id'], KEY_TOKEN); ?>" class="link-color">
                        <img src="<?php echo $imagen; ?>" alt="imagen-entrada" class="card-img-top">
                    </a>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-text">
                            <a href="detalles_miniaturas.php?id=<?php echo $miniaturas['id']; ?>&token=<?php echo hash_hmac('sha256', $miniaturas['id'], KEY_TOKEN); ?>" class="link-color">
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