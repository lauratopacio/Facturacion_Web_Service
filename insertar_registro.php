<?php
$host= "localhost";
$username="root";
//$username = "u320249225_topac";

$password="";
//$password = "amigas16";
$dbname="factura";
//$dbname = "u320249225_fact";

$conexion=mysql_connect($host, $username, $password) or die (mysql_error());
$nombre=$_POST['nombre'];
$rfc=$_POST['rfc'];
$calle=$_POST['calle'];
$estado=$_POST['estado'];
$num_ext=$_POST['num_ext'];
$num_int=$_POST['num_int'];
$colonia=$_POST['colonia'];
$localidad=$_POST['localidad'];
$delegacion=$_POST['delegacion'];
$cod_postal=$_POST['cod_postal'];
$user=$_POST['usuario'];
$pass=$_POST['password'];
$db=mysql_select_db($dbname, $conexion) or die(mysql_error());
// YAAAAAAAA
$insertar=mysql_query("INSERT INTO login (id_login,username, password) VALUES (NULL,'".$user."','".$pass."')");
// YAAAAAAAAAAAAAAAAAAAAA
$insertar3=mysql_query("INSERT INTO ubicacion(id_ubicacion,calle,estado,num_ext,num_int,colonia,localidad, delegacion,cod_postal)VALUES(NULL,'".$calle."','".$estado."','".$num_ext."','".$num_int."','".$colonia."','".$localidad."','".$delegacion."','".$cod_postal."')");
//// yaaaaaaaaaaaaaaaaaaaaaaaa
$maximo = mysql_query("SELECT max(id_ubicacion) as maximo FROM ubicacion",$conexion);
$maxi = mysql_fetch_assoc($maximo);
$max1 = $maxi['maximo'];
/// yaaaaaaaaaaaaaaaaaaaaaaaaaaaa
$maximo2 = mysql_query("SELECT max(id_login) as maximos FROM login",$conexion);
$maxi2 = mysql_fetch_assoc($maximo2);
$max2 = $maxi2['maximos'];

$insertar2=mysql_query("INSERT INTO usuario(id_usuario,nombre,rfc, id_ubicacion, id_login)VALUES(NULL,'".$nombre."','".$rfc."','".$max1."','".$max2."')");

?>





