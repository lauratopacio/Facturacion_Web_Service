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
 


        ////consulta PARA FACTURAS POR FECHA PARA PRODUCTOS


$result2 = mysql_query("SELECT max(id_hacienda) as maximo FROM hacienda") or die(mysql_error());
$maxi2 = mysql_fetch_assoc($result2);
$max2 = $maxi2['maximo'];

$sql = mysql_query("SELECT  iva_ingreso, subtotal_ingreso, iva_egreso, subtotal_egreso, pagar FROM hacienda where id_hacienda= '".$max2."'   ") or die(mysql_error());




// check for empty result
if (mysql_num_rows($sql) > 0) {
    // looping through all results
    // products node
    $response["hacienda"] = array();
 
    while ($row = mysql_fetch_array($sql)) {
        // temp user array
        $product = array();
        $product["id_hacienda"] = $row["id_factura"];
        $product["iva_ingreso"] = $row["iva_ingreso"];
        $product["subtotal_ingreso"] = $row["subtotal_ingreso"];
        $product["iva_egreso"] = $row["iva_egreso"];
        $product["subtotal_egreso"] = $row["subtotal_egreso"];
         $product["pagar"] = $row["pagar"];

        // push single product into final response array
        array_push($response["hacienda"], $product);
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
