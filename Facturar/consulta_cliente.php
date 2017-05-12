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
 $result = mysql_query("SELECT x.id_cliente, x.nombre,y.calle, y.estado, y.num_ext, y.num_int,y.colonia, y.delegacion, y.cod_postal, z.tipo_regimen, x.email FROM cliente x, ubicacion y, regimen z where x.id_ubicacion=y.id_ubicacion and z.id_regimen=x.id_regimen ORDER BY x.nombre ASC ") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["cliente"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
        $product["id_cliente"] = $row["id_cliente"];
        $product["nombre"] = $row["nombre"];
        $product["calle"] = $row["calle"];
        $product["estado"] = $row["estado"];
        $product["num_int"] = $row["num_int"];
        $product["colonia"] = $row["colonia"];
        $product["delegacion"] = $row["delegacion"];
        $product["tipo_regimen"] = $row["tipo_regimen"];
        $product["email"] = $row["email"];

        // push single product into final response array
        array_push($response["cliente"], $product);
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