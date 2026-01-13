<h2>Array asociativo</h2>

<?php

    $persona= [
        'nombre' => 'Juan',
        'edad'   => 25,
        'ciudad' => 'Madrid'
    ];
    
    echo "<p>Array Asociativo Inicial<p>";
    echo "Datos iniciales de la persona:<br>";
    echo "Nombre: ".$persona['nombre']."<br>";
    echo "Edad: ".$persona['edad']."<br>";
    echo "Ciudad: ".$persona['ciudad']."<br>";

    
    echo "<p> Mostrar nombre y ciudad<br>";
    echo "El nombre de la persona es ".$persona['nombre']." y vive en ".$persona['ciudad'].".<br>";

    $persona['profesion'] = 'Ingeniero';

    echo "<p> Array después de añadir la profesion<br>";
    echo "Se ha añadido la profesión de ".$persona['profesion'].".<br>";

   
    echo "<p> Todos los datos de la persona <br>";
    foreach ($persona as $clave => $valor) {
        echo $clave." : ".$valor."<br>";
    }
?>

