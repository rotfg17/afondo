<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database(); 
$con = $db->conectar();

$stmt = "SELECT id, nombre FROM categoria WHERE activo = 1"; // Consulta SQL para seleccionar categorías activas
$resultado = $con->query($stmt); // Ejecuta la consulta SQL
$categorias = $resultado->fetchAll(PDO::FETCH_ASSOC); // Obtiene un array asociativo con los resultados

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
        <h2 class="mt-3">Categorías</h2>
        <!-- Categorías-->
        <a href="nuevo.php" class="btn btn-primary">Agregar</a>
            <br><br>
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($categorias as $categoria) { ?>
                        <tr>
                            <td><?php echo $categoria['id'] ?></td>
                            <td><?php echo $categoria['nombre'] ?></td>
                            <td><a class="btn btn-warning btn-sm" href="edita.php?id=<?php echo $categoria['id']; ?>"><i class='bx bx-edit'></i></a></td>
                            <td>
                                <a class="btn btn-danger hero__cta deleteBtn" id="elimina" data-entry-id="<?php echo $categoria['id']; ?>" href="#"><i class='bx bx-trash'></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
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

    <script src="../js/scripts.js"></script>
</body>
</html>