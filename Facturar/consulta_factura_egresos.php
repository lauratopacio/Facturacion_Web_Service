<?php
 
/*
 * Following code will list all the products
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';

 
// connecting to db
$db = new DB_CONNECT();
 
// get all products from products table
 $result2 = mysql_query("SELECT max(id_factura) as maximo FROM facturas") or die(mysql_error());
$maxi2 = mysql_fetch_assoc($result2);
$max2 = $maxi2['maximo'];

 $result = mysql_query("SELECT x.id_egreso, x.razon_social, x.producto_servicio, x.costo, x.cantidad, x.subtotal, x.con_iva, y.fecha_factura FROM egresos x, facturas y where x.id_factura=y.id_factura and y.id_factura='".$max2."' ") or die(mysql_error());


 $resultado_cuenta = mysql_query("SELECT count(x.con_iva) as total FROM egresos x, facturas y where x.id_factura=y.id_factura and y.id_factura='".$max2."' ") or die(mysql_error());
$maxi3 = mysql_fetch_assoc($resultado_cuenta);
$max2 = $maxi3['maximo'];

$detalle_factura=mysql_query("SELECT  id_detalle_factura, id_factura, total FROM detalle_factura x, facturas y where x.id_factura=y.id_factura and y.id_factura='".$max2."' ") or die(mysql_error());


// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["egresos"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
        $product["id_egreso"] = $row["id_egreso"];
        $product["razon_social"] = $row["razon_social"];
        $product["producto_servicio"] = $row["producto_servicio"];
        $product["cantidad"] = $row["cantidad"];
        $product["subtotal"] = $row["subtotal"];
        $product["con_iva"] = $row["con_iva"];
        $product["fecha_factura"] = $row["fecha_factura"];

        // push single product into final response array
        array_push($response["egresos"], $product);
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

if (mysql_num_rows($detalle_factura) > 0) {
    // looping through all results
    // products node
    $responses["detalle_factura"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
       
        $product["total"] = $row["total"];
       
       

        // push single product into final response array
        array_push($responses["detalle_total"], $product);
    }
    // success
    $responses["success"] = 1;
 
    // echoing JSON response
    echo json_encode($responses);
} else {
    // no products found
    $responses["success"] = 0;
    $response["message"] = "No products found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>