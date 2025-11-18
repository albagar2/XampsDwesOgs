<h2>Creacion y acceso a elementos</h2>
<?php
       
    $colores = array("rojo", "verde", "azul", "amarillo");

    echo "<br> Array inicial<br>";
    echo "Los colores iniciales son: ".implode(", ", $colores)."<br><p>";


    echo "<br>Acceso a elementos específicos<br>";
    echo "El primer elemento es: ".$colores[0]."<br>";
    echo "El tercer elemento es: ".$colores[2]."<br><p>";


    $colores[] = "naranja";

    echo "<br>Array después de la adición<br>";
    echo "El array después de añadir 'naranja' es: ".implode(", ", $colores)."<p>";


    echo "Elementos recorridos con bucle 'for'<br>";
    $num_elementos = count($colores); 

    for ($i = 0; $i < $num_elementos; $i++) {
        echo "Color en el índice $i: ".$colores[$i]."<br>";
    }


    echo "<p> Elementos recorridos con bucle 'foreach' <br>";
    foreach ($colores as $color) {
        echo "Color: ".$color."<p>";
    }


?>