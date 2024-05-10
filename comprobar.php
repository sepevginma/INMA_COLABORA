<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

</head>
<body>
<?php

$usuario= $_POST["usu"];

#Sanatización de parámetros para evitar las inyecciones SQL: quitan caracteres especiales como la comilla simple, etc.
#$usuario = stripslashes($usuario);
$usuario=addslashes($usuario);
#echo "Usuario sanatizado despues del primer filtro: $usuario<br><br>\n";
#$usuario = mysql_real_escape_string($usuario);
#echo "Usuario sanatizado despues del segundo filtro: $usuario<br><br>\n";

    
$clave= $_POST["clave"];

#echo "Consulta a ejecutar: SELECT * FROM acceso where login='$usuario' AND clave=md5('$clave')<br><br>\n";
#Sanatización de parámetros para evitar las inyecciones SQL: quitan caracteres especiales como la comilla simple, etc.
#$clave = stripslashes($clave);
#$clave = mysql_real_escape_string($clave);

//Conecta con el servidor
$conexion=mysqli_connect("localhost","root","");
if (!$conexion){
	echo "ERROR: Imposible establecer conexión con la base de datos para ese usuario y esa clave.<br>\n";
}else{
	echo "Conexion con la base de datos establecida correctamente...<br><br>\n";
}

//Conecta con la base de datos
$db = mysqli_select_db($conexion,"ejemplo");
if (!$db){
		echo "ERROR: Imposible seleccionar la base de datos.<br>\n";
	}
	else{
		echo "Base de datos seleccionada satisfactoriamente...<br><br>\n";
     }
if (!$db) {
    die("Database selection failed: " . mysqli_error());
}


$resul=mysqli_query($conexion,"SELECT * FROM acceso where login='$usuario' AND clave=md5('$clave');");
// Si no pudo realizarse la consulta...
if(!$resul){
	echo "ERROR: Imposible realizar consulta.<br>\n";
}else{
    echo "Consulta realizada satisfactoriamente!<br>\n";
}

// Mostraremos todos sus registros en una tabla html...

echo "Se encontraron ".mysqli_num_rows($resul)." registros.<br>";

if (mysqli_num_rows($resul) == 0) {echo "<br><b>Usuario y/o clave incorrectos!.<br></b>\n";}
else
{
echo "<br>REGISTROS ENCONTRADOS:<br>\n";
			// Sacaremos registro a registro los datos de la tabla.
while ($fila = mysqli_fetch_row($resul)){
				echo "<b>USUARIO:</b>$fila[0]<b>CLAVE:</b>$fila[1]<b>NOMBRE:</b>$fila[2]<b>HAS CONSEGUIDO ENTRAR EN LA PAGINA WEB!</b><br>";
			}

}


mysqli_close($conexion);
 

?>

<form action="altas.html" method="post">
	<input type="submit" name=rAltas value="Ir a altas">
</form>

</body>
</html>


