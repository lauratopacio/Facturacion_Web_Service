<?php
$host= "localhost";
$username="u320249225_topac";
//$username = "u320249225_topac";
$password="amigas16";
//$password = "amigas16";
$dbname="u320249225_fact";


$conexion=mysql_connect($host, $username, $password) or die (mysql_error());
/*$producto=trim($_POST['producto']);
$servicio=trim($_POST['servicio']);*/
$servicio=$_POST['servicio'];
$cantidad=$_POST['cantidad'];
$vendedor=$_POST['usuario'];
$cliente=$_POST['cliente'];

$db=mysql_select_db($dbname, $conexion) or die(mysql_error());


//SELECCION DE LA FACTURA MAXIMA
$maximo2 = mysql_query("SELECT max(id_factura) as maximos FROM facturas",$conexion);
$maxi2 = mysql_fetch_assoc($maximo2);
$max2 = $maxi2['maximos'];
echo  'maximo factura', $max2;


$veen = mysql_query("SELECT id_usuario as vendedorr FROM usuario where nombre='$vendedor'",$conexion);
$ven = mysql_fetch_assoc($veen);
$vend = $ven['vendedorr'];
echo 'vendedor:', $vend;


$cliee = mysql_query("SELECT id_cliente as cliente FROM cliente where nombre='$cliente'",$conexion);
$clien = mysql_fetch_assoc($cliee);
$clie = $clien['cliente'];
echo 'id del cliente', $clie;

															
/*if (empty($producto)) { */
 
//SELECCION DE LA ID POR EL NOMBRE DEL SERVI
$serviciomax = mysql_query("SELECT id_servicio as servii FROM servicio where nombre_servicio='$servicio'",$conexion);
$servi = mysql_fetch_assoc($serviciomax);
$se = $servi['servii'];
  echo  'id del servicio',  $se;



$ser = mysql_query("SELECT costo as serr FROM servicio where id_servicio='$se'",$conexion);
$set = mysql_fetch_assoc($ser);
$s = $set['serr'];

$subtot=$s*$cantidad;

echo 'subtotal', $subtot;
$aa=1;

$insertar2=mysql_query("INSERT INTO venta(id_venta,id_producto,id_servicio, id_factura,costo_unitario, cantidad, sub_total, id_usuario,id_cliente)VALUES(NULL,'".$aa."','".$se."','".$max2."','".$s."','".$cantidad."','".$subtot."','".$vend."','".$clie."')");
/*}
else{
//CONSULTA QUE SELECCIONA EL ID DE PRODUCTO DEL PRODUCTO

$proo = mysql_query("SELECT id_producto as product FROM producto where nombre_producto='$producto'",$conexion);
$doodu = mysql_fetch_assoc($proo);
$pro = $doodu['product'];


echo 'SELECCION DEL LA ID PRODUCTUCTO: ',$pro, '  ';
$producto_costo = mysql_query("SELECT costo as cost FROM producto where id_producto='$pro'",$conexion);
$costoos = mysql_fetch_assoc($producto_costo);
$coosto = $costoos['cost'];


$subtot=$coosto*$cantidad;




$insertar2=mysql_query("INSERT INTO venta(id_venta,id_producto,id_servicio, id_factura,costo_unitario, cantidad, 
sub_total, id_usuario,id_cliente)VALUES(NULL,'".$pro."',NULL,'".$max2."','".$coosto."','".$cantidad."','".$subtot."','".$vend."','".$clie."')");


}*/


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
	alert('Datos no insertados');
	</script
	</body>
	</html>

	";

	
}
?>
 