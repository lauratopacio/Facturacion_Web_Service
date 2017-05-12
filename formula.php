
<?php
 $host= "localhost";
$username="u320249225_topac";
//$username = "u320249225_topac";
$password="amigas16";
//$password = "amigas16";
$dbname="u320249225_fact";
?>

<!DOCTYPE html lang="es">
<html>
	<head>
		<title>Mostrar por mes y anio</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="tablas.css">
	</head>
	<body>
	<h1 align="Center">facturas</h1>

	 <form id="form" method="post"> 
               <select id="meses" name="meses">
                   <option value="01">Enero</option>
                   <option value="02">Febrero</option>
                   <option value="03">Marzo</option>
                   <option value="04">Abril</option>
                   <option value="05">Mayo</option>
                   <option value="06">Junio</option>
                   <option value="07">Julio</option>
                   <option value="08">Agosto</option>
                   <option value="09">Setiembre</option>
                   <option value="10">Octubre</option>
                   <option value="11">Noviembre</option>
                   <option value="12">Diciembre</option>

               </select>

                <select id="anio" name="anio">
                   <option value="2015">2015</option>
               </select>
             <input type="submit" value="BUSCAR" /> 
               </form>
		<?php
		//configuracion de la base de datos
		
$conexion=mysql_connect($host, $username, $password) or die (mysql_error());

$db=mysql_select_db($dbname, $conexion) or die(mysql_error());
$mes=$_POST['meses'];
$anio=$_POST['anio'];

/////**************************************CONSULTAS PARA INGRESOS************************************************/////////
		////consulta PARA FACTURAS POR FECHA PARA PRODUCTOS
$sql = mysql_query("SELECT y.fecha_factura, x.sub_total, t.nombre_producto, x.cantidad, x.con_iva FROM venta x, facturas y, producto t WHERE x.id_producto=t.id_producto  and x.id_factura=y.id_factura and YEAR(y.fecha_factura)= '$anio' and MONTH(y.fecha_factura)='$mes' GROUP BY x.id_venta", $conexion);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//CONSUTA DE FACTURAS POR SERVICIO
$sql2 = mysql_query("SELECT y.fecha_factura, x.sub_total, l.nombre_servicio, x.cantidad, x.con_iva FROM venta x, facturas y,  servicio l WHERE  l.id_servicio=x.id_servicio and x.id_factura=y.id_factura and YEAR(y.fecha_factura)= '$anio' and MONTH(y.fecha_factura)='$mes' GROUP BY x.id_venta", $conexion);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//consulta para sacar la suma de las ventas con ivas de un solo
$suma_ingresos = mysql_query("SELECT sum(x.con_iva) as IVA_SUM FROM venta x, facturas y WHERE x.id_factura=y.id_factura and YEAR(y.fecha_factura)= '$anio' and MONTH(y.fecha_factura)='$mes'", $conexion);
$suma = mysql_fetch_assoc($suma_ingresos);
$LA_SUMA = $suma['IVA_SUM'];
echo  'SUMA DE LOS IVA DE PRODUCTO Y SERVICIOS ', $LA_SUMA;



/////**************************************CONSULTAS PARA EGRESOS******************************************************///////
		?>
		<div>
			<table border="1" class="tabla">
				<tr><!-- Esto es una fila-->
				<h1>PRODUCTOS</h1>
					<td>Fecha:</td><!-- Esto es una columna-->
					<td>PRODUCTO</td><!-- Esto es una columna-->
					<td>CANTIDAD</td><!-- Esto es una columna-->
					<td>SUB-TOTAL:</td><!-- Esto es una columna-->
					<td>CON IVA</td><!-- Esto es una columna-->
				</tr>
				<?php
				while($row = mysql_fetch_array($sql)){
					echo "<tr>";
					echo "<td>".$row['fecha_factura']."</td>";
					echo "<td>".$row['nombre_producto']."</td>";
					echo "<td>".$row['cantidad']."</td>";
					echo "<td>".$row['sub_total']."</td>";
					echo "<td>".$row['con_iva']."</td>";
					echo "</tr>";
				}
				?>
			</table>
		</div>

		<div>
			<table border="1" class="tabla2">
				<tr><!-- Esto es una fila--><h1>SERVICIO</h1>
					<td>Fecha:</td><!-- Esto es una columna-->
					<td>SERVICIO</td><!-- Esto es una columna-->
					<td>CANTIDAD</td><!-- Esto es una columna-->
					<td>SUB-TOTAL:</td><!-- Esto es una columna-->
					<td>CON IVA</td><!-- Esto es una columna-->

				</tr>
				<?php
				while($row = mysql_fetch_array($sql2)){
					echo "<tr>";
					echo "<td>".$row['fecha_factura']."</td>";
					echo "<td>".$row['nombre_servicio']."</td>";
					echo "<td>".$row['cantidad']."</td>";
					echo "<td>".$row['sub_total']."</td>";
					echo "<td>".$row['con_iva']."</td>";
					echo "</tr>";
				}


				?>
			</table>
		</div>
	
		<p align="center"><br>
			<?php
			$query = mysql_query("SELECT y.fecha_factura, x.sub_total, t.nombre_producto, x.cantidad FROM venta x, facturas y, producto t WHERE x.id_producto=t.id_producto  and x.id_factura=y.id_factura and YEAR(y.fecha_factura)= 2015 and MONTH(y.fecha_factura)='$mes' GROUP BY x.id_venta", $conexion);

			$query2 = mysql_query("SELECT y.fecha_factura, x.sub_total, l.nombre_servicio, x.cantidad FROM venta x, facturas y,  servicio l WHERE  l.id_servicio=x.id_servicio and x.id_factura=y.id_factura and YEAR(y.fecha_factura)= 2015 and MONTH(y.fecha_factura)='$mes' GROUP BY x.id_venta", $conexion);

			$no_rows = mysql_num_rows($query);
						$no_rows2 = mysql_num_rows($query2);
			$no_rows3 =$no_rows+$no_rows2;

			?>
		</p>
		<p align="center">
			NUMERO DE REGISTROS: <?php echo $no_rows3; ?>
		</p>
		<br>
		
		
	</body>
	</html>