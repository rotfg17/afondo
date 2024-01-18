<?php

require '../config/config.php';
require '../../php/database.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="<?php echo ADMIN_URL;?>css/styles.css" rel="stylesheet">
    <title>Dashboard - A Fondo</title>
</head>

<body>

    <?php require '../header.php';?>

    <main>
        <div class="container-fluid px-4">
            <h2 class="mt-3">Nueva categoría</h2>

            <form action="guarda.php" method="post" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required autofocus>
                </div>
                <button class="sumbit">
                    <span class="btnText">Guardar</span>
                    <i class="uil uil-navigator"></i>
                </button>
        </div>
        </div>

        </div>
        </div>
        </div>
        </form>
        </div>

        <script src="../js/scripts.js"></script>
</body>

</html>