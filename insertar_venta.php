<?php
$host= "localhost";
$username="root";
//$username = "u320249225_topac";

$password="";
//$password = "amigas16";
$dbname="factura";

$conexion=mysql_connect($host, $username, $password) or die (mysql_error());
$producto=$_POST['producto'];
$cantidad=$_POST['cantidad'];
$usuario=$_POST['usuario'];
$cliente=$_POST['cliente'];

$db=mysql_select_db($dbname, $conexion) or die(mysql_error());

//FACTURA MAXIMA 
$maximo2 = mysql_query("SELECT  max(id_factura) as id_fact FROM facturas",$conexion);
$maxi2 = mysql_fetch_assoc($maximo2);
$factu = $maxi2['id_fact'];


//CONSULTA PARA SACAR LA ID DEL PRODUCTO
$maximo3 = mysql_query("SELECT id_producto as id_product FROM producto where nombre_producto='$producto'",$conexion);
$maxi3 = mysql_fetch_assoc($maximo2);
$produc = $maxi3['id_product'];


//SELECCIONAR EL COSTO DEL PRODUCTO

//HACER LA MULTIPLICACION DEL COSTO POR LA CANTIDAD para PONERLO EN SUBTOTAL

//SACAR LA ID DEL USUARIO A TRAVEZ DE UNA CONSULTA CON EL NOMBRE QE INGRESO

//SACAR LA ID DEL CLIENTE POR UNA CONSULTA DE SELECCION

//INSERTAR DATOS DE VENTAS DE FACTURAS POR PRODUCTO Y O SERVICIO
$insertar2=mysql_query("INSERT INTO venta(id_venta,id_producto,id_servicio, id_factura,costo_unitario, cantidad, sub_total, id_usuario,id_cliente)VALUES(NULL,'".$produc."','".$servicio."','".$factu."','".$cost."','".$cantidad."','".$subtotal."','".$subtotal."','".$usuar."','".$clien."'");




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

