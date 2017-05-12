<?php
$host="localhost";
$username="root";
//$username = "u320249225_topac";

$password="";
//$password = "amigas16";
$dbname="factura";
//$dbname = "u320249225_fact";

$conexion=mysql_connect($host, $username, $password) or die (mysql_error());
$nombre=$_POST['nombre'];
$calle=$_POST['calle'];
$estado=$_POST['estado'];
$num_ext=$_POST['num_ext'];
$num_int=$_POST['num_int'];
$colonia=$_POST['colonia'];
$localidad=$_POST['localidad'];
$delegacion=$_POST['delegacion'];
$cod_postal=$_POST['cod_postal'];
$telefono=$_POST['telefono'];

$db=mysql_select_db($dbname, $conexion) or die(mysql_error());

$insertar3=mysql_query("INSERT INTO ubicacion(id_ubicacion,calle,estado,num_ext,num_int,colonia,localidad, delegacion,cod_postal)VALUES(NULL,'".$calle."','".$estado."','".$num_ext."','".$num_int."','".$colonia."','".$localidad."','".$delegacion."','".$cod_postal."')");

$maximo = mysql_query("SELECT max(id_ubicacion) as maximo FROM ubicacion",$conexion);
$maxi = mysql_fetch_assoc($maximo);
$max1 = $maxi['maximo'];


$insertar2=mysql_query("INSERT INTO proveedor(id_proveedor, nombre_proveedor, id_ubicacion, telefono)VALUES(NULL,'".$nombre."','".$max1."','".$telefono."')");


if($insertar2 && $insertar3)
{
	echo"<html>
	<head>
	</head>
	<body>
	<br>
	<br>
	<br>

	<meta http-equiv='Refresh' content='0; url=http://basesdedatosfacturacion.besaba.com/topacio/login.php'>
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

	<meta http-equiv='Refresh' content='0; url=http://basesdedatosfacturacion.besaba.com/topacio/insertar_registro.php'>
	<script>
	alert('Datos no insertados con exito');
	</script
	</body>
	</html>

	";

	
}
?>

