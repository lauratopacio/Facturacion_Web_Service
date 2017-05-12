<?php
$host= "localhost";
$username="root";
//$username = "u320249225_topac";

$password="";
//$password = "amigas16";
$dbname="factura";

$conexion=mysql_connect($host, $username, $password) or die (mysql_error());
$nombre=$_POST['nombre'];
$costo=$_POST['costo'];

$db=mysql_select_db($dbname, $conexion) or die(mysql_error());


$insertar2=mysql_query("INSERT INTO servicio(id_servicio,nombre_servicio, costo)VALUES(NULL,'".$nombre."','".$costo."')");




if($insertar2)
{
	echo"<html>
	<head>
	</head>
	<body>
	<br>
	<br>
	<br>
<script>
	alert('Datos insertados con exito');
	</script
	</body>
	</html>

	";
}
else{
	echo"<html>
	<head>
	</head>
	<body>
	<br>
	<br>
	<br>
	<script>
	alert('Datos no insertados con exito');
	</script
	</body>
	</html>

	";

	
}
?>

