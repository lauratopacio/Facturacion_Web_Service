<?php
////////////////////////////////REGISTRO INGRESOS POR PRODUCTOS(SOLO PRODUCTOS)////////////////////////////////////
/*
siempre tener en cuenta "config.inc.php" 
*/
require("config.inc.php");

//if posted data is not empty
if (!empty($_POST)) {
    //preguntamos si el ussuario y la contraseña esta vacia
    //sino muere
  

// obtener la id maxima de ubicacion  se almacena en $resultado
$maximo_factura= $db->query('SELECT MAX(id_factura) FROM facturas'); 
$resultado = $maximo_factura->fetchColumn();

//costo
$nombre_servicio=$_REQUEST['nombre_servicio'];
$consulta = "SELECT  costo_servicio  FROM servicio where nombre_servicio=:nombre_servicio"; 
$result = $db->prepare($consulta);
$result->execute(array(":nombre_servicio" => $nombre_servicio));
$costo= $result->fetchColumn();
echo "costo:",$costo;


// obtener la id del producto por el nombre del producto
$consulta2 = "SELECT  id_servicio  FROM servicio where nombre_servicio=:nombre_servicio"; 
$result2 = $db->prepare($consulta2);
$result2->execute(array(":nombre_servicio" => $nombre_servicio));
$id_servicio= $result2->fetchColumn();
echo "id_servicio:", $id_servicio;


$cantidad=$_REQUEST['cantidad'];

$subtotal=$cantidad*$costo;
$iva=$subtotal*0.16;
$con_iva=$subtotal+$iva;
//obtener 


///////////////////////////////////INSERTAR PROVEEDOR//////////////////////////////////////////

 $query3= "INSERT INTO venta(id_factura, id_producto, id_servicio, costo_unitario, cantidad, sub_total, con_iva) VALUES('".$resultado."',NULL,'".$id_servicio."','".$costo."', :cantidad, '".$subtotal."', '".$con_iva."')";
 $query_params3 = array(
       
        ':cantidad' => $_POST['cantidad'],   

    );
                            
     try {
        $stmt   = $db->prepare($query3);
        $result = $stmt->execute($query_params3);
    }
    catch (PDOException $ex) {
        // solo para testing
        //die("Failed to run query: " . $ex->getMessage());
        
        $response["success"] = 0;
        $response["message"] = "NO SE INSERTO EL INGRESO";
        die(json_encode($response));
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////

    //si hemos llegado a este punto
    //es que el usuario se agregado satisfactoriamente
    $response["success"] = 1;
    $response["message"] = "El ingreso se ha agregado correctamente";
    echo json_encode($response);
    
    //para cas php tu puedes simpelmente redireccionar o morir
    //header("Location: login.php"); 
    //die("Redirecting to login.php");
    
    
} 
?>