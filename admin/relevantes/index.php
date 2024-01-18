<?php

require '../config/config.php';
require '../../php/database.php';

$db = new Database(); 
$con = $db->conectar();

$stmt = "SELECT id, subtitulo, titulo, fecha FROM articulo WHERE activo = 1"; // Consulta SQL para seleccionar categorías activas
$resultado = $con->query($stmt); // Ejecuta la consulta SQL
$relevantes = $resultado->fetchAll(PDO::FETCH_ASSOC); // Obtiene un array asociativo con los resultados

?>


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
                            <th>Subtitulo</th>
                            <th>Titulo</th>
                            <th>Publicado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($relevantes as $relevante) : ?>
                        <tr>
                            <td><?php echo $relevante['subtitulo'] ?></td>
                            <td><?php echo $relevante['titulo'] ?></td>
                            <td><?php echo $relevante['fecha'] ?></td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="edita.php?id=<?php echo $relevante['id']; ?>"><i
                                        class='bx bx-edit'></i></a>
                            </td>
                            <td>
                                <a class="btn btn-danger hero__cta deleteBtn" id="elimina"
                                    data-entry-id="<?php echo $relevante['id']; ?>"><i class='bx bx-trash'></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="modalElimina" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Confirmar</h5>
                    <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Deseas eliminar esta noticia?
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
    <?php include '../footer.php'?>
    <script src="../js/scripts.js"></script>
