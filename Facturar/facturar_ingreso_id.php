<?php
//carga y se conecta a la base de datos
require("config.inc.php");

//seleccionamos la id del cliente

$nombre_cliente=$_REQUEST['username'];
$email=$_REQUEST['email'];

$consulta = "SELECT  id_cliente  FROM cliente where nombre=:nombre_cliente and email=:email"; 
$result = $db->prepare($consulta);
$result->execute(array(":nombre_cliente" => $nombre_cliente,":email" => $email));

$cliente= $result->fetchColumn();
echo "id_cliente:",$cliente;





///*************************************************************************************************///////

 $query3= "INSERT INTO facturas(fecha_factura,id_cliente) VALUES(NOW(), '".$cliente."')";
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