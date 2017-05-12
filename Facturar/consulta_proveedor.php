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
 $result = mysql_query("SELECT x.id_proveedor, x.nombre_proveedor,y.calle, y.estado, y.num_ext, y.num_int,y.colonia, y.delegacion, y.cod_postal, x.telefono, x.email FROM proveedor x, ubicacion y where x.id_direccion=y.id_ubicacion") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["proveedor"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
        $product["id_proveedor"] = $row["id_proveedor"];
        $product["nombre_proveedor"] = $row["nombre_proveedor"];
        $product["calle"] = $row["calle"];
        $product["estado"] = $row["estado"];
        $product["num_ext"] = $row["num_ext"];
        $product["num_int"] = $row["num_int"];
        $product["colonia"] = $row["colonia"];
        $product["delegacion"] = $row["delegacion"];
        $product["cod_postal"] = $row["cod_postal"];
        $product["telefono"] = $row["telefono"];
        $product["email"] = $row["email"];

        // push single product into final response array
        array_push($response["proveedor"], $product);
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