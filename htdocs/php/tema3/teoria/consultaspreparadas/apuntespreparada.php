<?php
/*
 --------------------------------------------------------------------
  APUNTES DE SENTENCIAS PREPARADAS (mysqli - PHP)
 --------------------------------------------------------------------
  Este ejemplo muestra cómo:
  ✅ Conectarse a MySQL
  ✅ Insertar registros con bind_param()
  ✅ Consultar registros con bind_param()
  ✅ Recuperar resultados con:
       1️⃣ bind_result() + fetch()
       2️⃣ get_result() + fetch_object()
 --------------------------------------------------------------------
*/

try {
    // 1️⃣ CONEXIÓN A LA BASE DE DATOS ------------------------------------
    $conex = new mysqli("localhost", "dwes", "abc123.", "dwes");
    $conex->set_charset("utf8mb4");

    // Si algo falla, saltará al catch automáticamente.
    
    // --------------------------------------------------------------------
    // 2️⃣ INSERCIÓN DE DATOS CON bind_param() ----------------------------
    // (Descomenta para probarlo una vez)
    /*
    $stmt = $conex->prepare("INSERT INTO tienda (cod, nombre, tlf) VALUES (?, ?, ?)");
    // Tipos: i = int, s = string
    $cod = 5;
    $nombre = "Sucursal 5";
    $telf = "12345345437";
    $stmt->bind_param("iss", $cod, $nombre, $telf); // Enlaza las variables

    if ($stmt->execute()) {
        echo "✅ Tienda insertada correctamente<br>";
    } else {
        echo "❌ Error al insertar tienda: " . $stmt->error . "<br>";
    }
    $stmt->close(); // Siempre cerrar el statement después de usarlo
    */

    // --------------------------------------------------------------------
    // 3️⃣ CONSULTA CON CONDICIÓN Y bind_param() ---------------------------
    $stmt = $conex->prepare("SELECT * FROM tienda WHERE cod > ?");
    $cod = 3; // Valor que usará el placeholder (?)
    $stmt->bind_param("i", $cod); // i = entero
    $stmt->execute();

    // --------------------------------------------------------------------
    // 4️⃣ PRIMERA FORMA DE LEER RESULTADOS: bind_result() -----------------
    // Permite vincular las columnas a variables PHP
    $stmt->bind_result($codRes, $nombreRes, $telfRes);
    $stmt->store_result(); // Opcional: carga el resultado en memoria

    if ($stmt->num_rows()) {
        echo "<h3>Resultados con bind_result() + fetch()</h3>";
        while ($stmt->fetch()) {
            echo "Código: $codRes <br>";
            echo "Nombre: $nombreRes <br>";
            echo "Teléfono: $telfRes <br>";
            echo "-----------------------------<br>";
        }
    } else {
        echo "No hay resultados con bind_result()<br>";
    }

    // --------------------------------------------------------------------
    // 5️⃣ SEGUNDA FORMA: get_result() + fetch_object() --------------------
    // ⚠ Solo funciona si PHP tiene el driver mysqlnd (la mayoría de versiones actuales lo incluyen).
    $stmt->execute(); // Hay que ejecutar otra vez
    $result = $stmt->get_result(); // Devuelve un objeto mysqli_result

    echo "<h3>Resultados con get_result() + fetch_object()</h3>";
    while ($fila = $result->fetch_object()) {
        echo "Código: " . $fila->cod . "<br>";
        echo "Nombre: " . $fila->nombre . "<br>";
        echo "Teléfono: " . $fila->tlf . "<br>";
        echo "-----------------------------<br>";
    }

    // --------------------------------------------------------------------
    // 6️⃣ CIERRE FINAL ----------------------------------------------------
    $stmt->close();
    $conex->close();

} catch (mysqli_sql_exception $exc) {
    echo "❌ Error: " . $exc->getMessage();
}
?>