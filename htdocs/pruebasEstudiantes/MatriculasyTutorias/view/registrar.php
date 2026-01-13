<?php
session_start();
include_once '../controller/ControladorEstudiante.php';
include_once '../controller/ControladorMatricula.php';
include_once '../controller/ControladorProfesor.php';
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Gestión de Matrícula</h2>
    <form method="POST">
        DNI Estudiante: <input type="text" name="dni_buscar" pattern="[0-9]{8}[A-Z]{1}">
        <button name="btn_buscar">Buscar</button>
    </form>

    <?php
    if (isset($_POST['btn_buscar'])) {
        if (!ControladorEstudiante::buscarPorDni($_POST['dni_buscar'])) echo "Estudiante no existe.";
    }

    if (isset($_SESSION['estudiante_encontrado'])) {
        $est = unserialize($_SESSION['estudiante_encontrado']);
        echo "<h3>Expediente de: {$est->nombre_completo}</h3>";
        $lista = ControladorMatricula::obtenerExpediente($est->dni);
        foreach($lista as $reg) echo "{$reg->nombre_asignatura} - {$reg->estado}<br>";
    ?>
        <hr>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="dni" value="<?php echo $est->dni; ?>">
            Nombre: <input type="text" name="nom" value="<?php echo $est->nombre_completo; ?>"><br>
            Foto (.png): <input type="file" name="foto" accept=".png" required><br>
            Asignaturas: <select name="asigs[]" multiple required>
                <option value="1">Matemáticas</option>
                <option value="2">Historia</option>
            </select><br>
            Tutor: <select name="tutor">
                <?php foreach(ControladorProfesor::obtenerTutores() as $t) echo "<option value='{$t->codigo}'>{$t->nombre_completo}</option>"; ?>
            </select><br>
            <button name="btn_matricular">Nueva Matrícula</button>
        </form>
    <?php
    }
    if (isset($_POST['btn_matricular'])) {
        ControladorEstudiante::actualizarEstudiante($_POST['dni'], $_POST['nom'], "Dir", "123");
        echo ControladorMatricula::registrarMasivo($_POST['dni'], $_POST['tutor'], $_POST['asigs'], $_FILES['foto']);
    }
    ?>
    <br><a href="menu.php">Volver</a>
</body>
</html>