<?php

//carga y se conecta a la base de datos
require("config.inc.php");



///*************************************************************************************************///////

 $query3= "INSERT INTO facturas(fecha_factura,id_cliente) VALUES(NOW(), NULL)";
 $query_params3 = array(
       
        
    );
                                 ///LO UNICO QUE CAMBIA ES EL $query2 y el $query_params2
     try {
        $stmt   = $db->prepare($query3);
        $result = $stmt->execute($query_params3);
    }
    catch (PDOException $ex) {
        // solo para testing
        //die("Failed to run query: " . $ex->getMessage());
        
        $response["success"] = 0;
        $response["message"] = "NO SE INSERTO LA FACTURA ADECUADA";
        die(json_encode($response));
    }


?> 