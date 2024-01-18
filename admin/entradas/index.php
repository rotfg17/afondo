<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database(); 
$con = $db->conectar();


$stmt = "SELECT * FROM articulo WHERE activo = 1 ORDER BY fecha DESC ";
$resultado = $con->query($stmt);
$entradas = $resultado->fetchAll(PDO::FETCH_ASSOC);


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
<body > 


<?php require '../header.php';?>
<main>
<div class="container-fluid px-4">
    <h2 class="mt-3">Entradas de noticias</h2>
    <br>
    <a href="procesar_entrada.php" class="btn btn-primary">Agregar</a>
    <br><br>

    <div class="d-flex justify-content-center align-items-center">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Contenido</th>
                    <th>Publicado</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entradas as $entrada) : ?>
                    <tr>
                        <td><?= $entrada['titulo']; ?></td>
                        <td><?= substr($entrada['contenido'], 0, 100); ?>...</td>
                        <td><?= $entrada['fecha']; ?></td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="edita.php?id=<?php echo $entrada['id']; ?>"><i class='bx bx-edit'></i></a>
                        </td>
                        <td>
                        <a class="btn btn-danger hero__cta deleteBtn" id="elimina" data-entry-id="<?php echo $entrada['id']; ?>"><i class='bx bx-trash'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</main>



<div id="darkOverlay"></div>
<div id="modalElimina" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Confirmar</h5>
                <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Deseas eliminar esta Categoría?
            </div>
            <div class="modal-footer">
                <form id="eliminarForm" action="elimina.php" method="post">
                    <input type="hidden" name="id" id="entryIdToDelete">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cerrar</button>
                    <button type="button" class="btn btn-danger" onclick="eliminarElemento()">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php';?>

<script src="../js/scripts.js"></script>
</body>
</html>