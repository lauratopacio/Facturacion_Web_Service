<?php
 
/*                                              MUESTRA LAS FACTURAS DE LOS PRODUCTOS DE ESE MES
 * Following code will list all the products
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';

 
// connecting to db
$db = new DB_CONNECT();
 
$mes=$_POST['meses'];

if($mes=='enero'){
    $mes=01;
    echo "mes ", $mes;
}
else if($mes=='febrero'){
    $mes=02;
    echo "mes ", $mes;
}
else if($mes=='marzo'){
    $mes=03;
    echo "mes ", $mes;
}
else if($mes=='abril'){
    $mes=04;
    echo "mes ", $mes;
}

else if($mes=='mayo'){
    $mes=05;
    echo "mes ", $mes;
}

else if($mes=='junio'){
    $mes=06;
    echo "mes ", $mes;
}
else if($mes=='julio'){
    $mes=07;
    echo "mes ", $mes;
}

else if($mes=='octubre'){
    $mes=10;
    echo "mes ", $mes;
}
else if($mes=='noviembre'){
    $mes=11;
    echo "mes ", $mes;
}
else if($mes=='diciembre'){
    $mes=12;
    echo "mes ", $mes;
}
else if($mes=='agosto'){
    $mes=8;
    echo "mes ", $mes;
}
else if($mes=='septiembre'){
    $mes=9;
    echo "mes ", $mes;
}

$A1 = mysql_query("SELECT sum(x.con_iva) as suma FROM venta x, facturas y WHERE x.id_factura=y.id_factura  and MONTH(y.fecha_factura)='$mes' GROUP BY x.id_venta") or die(mysql_error());
$maxi3 = mysql_fetch_assoc($A1);
$max3 = $maxi3['suma'];
echo "<br>suma ingresos IVA: ", $max3;



$A2 = mysql_query("SELECT sum(x.sub_total) as suma2 FROM venta x, facturas y WHERE x.id_factura=y.id_factura and MONTH(y.fecha_factura)='$mes' GROUP BY x.id_venta") or die(mysql_error());
$maxi4 = mysql_fetch_assoc($A2);
$max4 = $maxi4['suma2'];
echo " <br>  suma subtotales ingreso: ", $max4;


$B1 = mysql_query("SELECT sum(x.con_iva) as suma3 FROM egresos x, facturas y WHERE x.id_factura=y.id_factura and MONTH(y.fecha_factura)='$mes' GROUP BY x.id_egreso") or die(mysql_error());
$maxi5 = mysql_fetch_assoc($B1);
$max5 = $maxi5['suma3'];
echo " <br>  IVA EGRESO: ", $max5;

$B2 = mysql_query("SELECT sum(x.subtotal) as suma4 FROM egresos x, facturas y WHERE x.id_factura=y.id_factura and MONTH(y.fecha_factura)='$mes' GROUP BY x.id_egreso") or die(mysql_error());
$maxi6 = mysql_fetch_assoc($B2);
$max6 = $maxi6['suma4'];
echo "  <br>  SUBTOTAL EGRESO ", $max6;

$ingre=$max3-$max2;

echo "<br> usted debe  pagar por  ingreso=", $ingre;
$egre=$max5-$max6;
 

echo "<br> usted debe  pagar por EGRESO=", $egre;
$IVA=$max3-$max5;
$hacienda=$IVA*0.6;
echo "<br> deducir impuestos",$hacienda;


$hacienda=mysql_query("INSERT INTO hacienda (id_hacienda, iva_ingreso, subtotal_ingreso, iva_egreso,subtotal_egreso, pagar) VALUES (NULL, '".$max3."', '".$max4."', '".$max5."', '".$max6."', '".$hacienda."');")
/////**************************************CONSULTAS PARA INGRESOS************************************************/////////
        ////consulta PARA FACTURAS POR FECHA PARA PRODUCTOS
//$sql = mysql_query("SELECT y.fecha_factura, x.sub_total, t.nombre_producto, x.cantidad, x.con_iva FROM venta x, facturas y, producto t WHERE x.id_producto=t.id_producto  and x.id_factura=y.id_factura and YEAR(y.fecha_factura)= '$anio' and MONTH(y.fecha_factura)='$mes' GROUP BY x.id_venta") or die(mysql_error());


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//CONSUTA DE FACTURAS POR SERVICIO
//$sql2 = mysql_query("SELECT y.fecha_factura, x.sub_total, l.nombre_servicio, x.cantidad, x.con_iva FROM venta x, facturas y,  servicio l WHERE  l.id_servicio=x.id_servicio and x.id_factura=y.id_factura and YEAR(y.fecha_factura)= '$anio' and MONTH(y.fecha_factura)='$mes' GROUP BY x.id_venta") or die(mysql_error());



// check for empty result
/*if (mysql_num_rows($sql) > 0) {
    // looping through all results
    // products node
    $response["productos_mes"] = array();
 
    while ($row = mysql_fetch_array($sql)) {
        // temp user array
        $product = array();
        $product["fecha_factura"] = $row["fecha_factura"];
        $product["sub_total"] = $row["sub_total"];
        $product["nombre_producto"] = $row["nombre_producto"];
        $product["cantidad"] = $row["cantidad"];
        $product["con_iva"] = $row["con_iva"];
        
        // push single product into final response array
        array_push($response["productos_mes"], $product);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No products found";
 
    // echo no users JSON
    echo json_encode($response);
}
*/

?>
