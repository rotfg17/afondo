<?php

require 'php/database.php';
require 'php/config.php';
require 'php/funciones.php';

$sql = $con->prepare("SELECT id, titulo, subtitulo, contenido FROM articulo WHERE activo = 1 AND id_categoria = 1 ORDER BY fecha ");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A fondo con Andreina - Revista</title>
</head>
<body>
<?php include 'header.php'; ?> 

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
                    <?php foreach ($noticias_relacionadas as $noticia) {
                        if ($contador < 4) { // Limitamos a 7 entradas
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
                                        <hr>
                                    </a>
                                </span>
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
            foreach ($resultado as $miniaturas) :
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
            ?>
                <div class="col-md-2">
                    <div class="efecto">
                        <a href="detalles.php?id=<?php echo $miniaturas['id']; ?>&token=<?php echo hash_hmac('sha256', $miniaturas['id'], KEY_TOKEN); ?>" class=" link-color">
                            <img src="<?php echo $imagen_miniatura; ?>" alt="imagen-entrada" class="card-img-top">
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
            <?php
                $numEntradasMostradas++;
            endforeach;
            ?>
        </div>
    </div>
</div>


<script src="js/apps.js"></script>
</body>
</html>













