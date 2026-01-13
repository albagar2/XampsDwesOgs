<!--Realiza un formulario donde el nombre no puede estar vacio, solo puede ser texto y con una longitud maxima de 30 digitos,
en el DNI tiene que haber 8 digitos mas una letra mayuscula, en la fecha de nacimiento tiene que tener el 
formato (dd-mm-yyyy)y ser correcta, en el email tiene que tener texto y algun numero el @ texto o numero . com/es/org
en la edad debe seer mayor de 18 y solo pueden ser numeros.
Si al enviar hay algun error se mostrara al lado y los datos correctos seguiran en el formulario, solo se quedara 
vacio cuando todos los datos sean correctos.-->

<h1>Formulario de Validacion con Expresiones Regulares</h1><br>

<form action="" method="post">
    Nombre: <input type="text" name="nombre"><br>
    DNI: <input type="text" name="dni"><br>
    Fecha nacimiento: <input type="text" name="fecha"><br>
    Email: <input type="text" name="correo"><br>
    Edad: <input type="text" name="edad"><br>
    
    <input type="submit" name="enviar" value="Enviar"><br>
</form>
<?php
    if (isset($_POST['enviar'])){
        if (!preg_match('/^[A-Z]{1,30}$/i', $_POST['nombre'])){
            echo '<br>El nombre no puede estar vacio, y debe ser una cadena de texto entre 1 y 30 caracteres<br>';
        }
        if (!preg_match('/^\d{8}[A-Z]$/', $_POST['dni'])){
            echo '<br>El DNI debe de contener 8 digitos y una letra mayúscula<br>';
        }
        if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $_POST['fecha'])){
            echo '<br>La fecha tiene que tener el siguiente formato dd-mm-yyyy<br>';
        }
        if (!preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.(com|es|org)$/', $_POST['correo'])){
            echo '<br>El email debe contener texto, numeros, puntos o guiones el @ texto, numeros, puntos o '
            . 'guiones .org/es/com <br>';
        }
        if (!preg_match('/^[0-9]+$/', $_POST['edad']) || $_POST['edad'] < 18){
            echo 'La edad debe de ser numeros enteros y mayor de 18';
        }
    }
?>