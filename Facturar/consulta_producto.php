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
 $result = mysql_query("SELECT x.id_producto, x.nombre_producto, y.nombre_proveedor, x.marca, x.tamanio, x.costo FROM producto x, proveedor y where x.id_proveedor=y.id_proveedor") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["producto"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
        $product["id_producto"] = $row["id_producto"];
        $product["nombre_producto"] = $row["nombre_producto"];
        $product["marca"] = $row["marca"];
        $product["tamanio"] = $row["tamanio"];
        $product["nombre_proveedor"] = $row["nombre_proveedor"];
        $product["costo"] = $row["costo"];

        // push single product into final response array
        array_push($response["producto"], $product);
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