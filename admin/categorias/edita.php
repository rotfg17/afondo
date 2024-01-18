<?php  

require '../config/config.php';
require '../../php/database.php';


$db = new Database(); // Crea una instancia de la clase Database
$con = $db->conectar(); // Establece una conexión a la base de datos

$id = $_GET['id']; // Obtiene el ID de la categoría desde los parámetros GET

$sql = $con->prepare("SELECT id, nombre FROM categoria WHERE id = ? LIMIT 1"); // Prepara una consulta SQL para seleccionar una categoría por su ID
$sql->execute([$id]); // Ejecuta la consulta SQL con el ID obtenido desde los parámetros GET
$categoria = $sql->fetch(PDO::FETCH_ASSOC); // Almacena los resultados en un arreglo asociativo llamado $categoria


?>

<?php include '../header.php';?>

<div class="container">
    <header>Editar categoría</header>

    <form action="actualiza.php" method="post" autocomplete="off">
        <input type="hidden" name="id" value="<?php echo $categoria['id']; ?>">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $categoria['nombre']; ?>" required autofocus>
                </div>
                        <button class=" sumbit">
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