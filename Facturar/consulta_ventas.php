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
echo "maxima factura", $max2;
$servi= null;
 $result = mysql_query("SELECT x.id_venta, z.nombre_producto, x.costo_unitario, x.cantidad,
  x.sub_total, x.con_IVA, y.fecha_factura FROM venta x, facturas y, producto z  where
   x.id_factura=y.id_factura and z.id_producto=x.id_producto 
    and x.id_factura='".$max2."' GROUP BY x.id_venta") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["ingresos"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
        $product["id_venta"] = $row["id_venta"];
        $product["nombre_producto"] = $row["nombre_producto"];
        $product["costo"] = $row["costo_unitario"];
        $product["cantidad"] = $row["cantidad"];
        $product["sub_total"] = $row["sub_total"];
        $product["con_IVA"] = $row["con_IVA"];
        $product["fecha_factura"] = $row["fecha_factura"];

        // push single product into final response array
        array_push($response["ingresos"], $product);
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


?>