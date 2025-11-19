<title>Registro</title>

<br><h2>Registro de Nuevo Usuario</h2><br>
<form action="" method="post">
    Nombre: <input type="text" id="nombre"><br>
    Apellido: <input type="text" id="apell"><br>
    Dirección: <input type="text" id="direccion"><br>
    Localidad: <input type="text" id="localidad"><br>
    Usuario: <input type="text" id="usu"><br>
    Clave: <input type="password" id="pass"><br>
    Repetir Clave: <input type="password" id="pass2"><br>

    <br>
    Color letra: 
    <select name="colorL" id="comboColorLetra">
        <option value="negro" selected>Negro</option>
        <option value="blanco">Blanco</option>
        <option value="amarillo">Amarillo</option>
        <option value="rojo">Rojo</option>
        <option value="verde">Verde</option>
    </select><br>

    Color fondo: 
    <select name="colorF" id="comboColorFondo">
        <option value="negro" selected>Negro</option>
        <option value="blanco">Blanco</option>
        <option value="amarillo">Amarillo</option>
        <option value="rojo">Rojo</option>
        <option value="verde">Verde</option>
    </select><br>

    Tipo letra: 
    <select name="tipoL" id="comboTipoLetra">
        <option value="arial" selected>Arial</option>
        <option value="serif">Serif</option>
        <option value="TimesNewRoman">Times New Roman</option>
        <option value="Roboto">Roboto</option>
    </select><br>

    Tamaño letra: 
    <select name="tamL" id="comboTamanoLetra">
        <option value="13" selected>13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
    </select><br>

    <input type="submit" id="cancelar" value="Cancelar">
    <input type="submit" id="registro" value="Registrar"> 

</form>