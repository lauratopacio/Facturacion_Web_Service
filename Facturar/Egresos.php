<?php
//////////////////////////////////////////////////////////////////////////
/*
siempre tener en cuenta "config.inc.php" 
*/
require("config.inc.php");

//if posted data is not empty
if (!empty($_POST)) {
    //preguntamos si el ussuario y la contraseña esta vacia
    //sino muere
    if (empty($_POST['razon_social']) || empty($_POST['producto']) || empty($_POST['cantidad']) || empty($_POST['costo'])) {
        
        // creamos el JSON
        $response["success"] = 0;
        $response["message"] = "Por favor inserte los datos requeridos";
        
        die(json_encode($response));
    }
  
//GENERAR CALCULOS NECESARIOS
$cantidad=$_REQUEST['cantidad'];
$costo=$_REQUEST['costo'];

$subtotal=$cantidad*$costo;
$iva=$subtotal*0.16;
$con_iva=$subtotal+$iva;


 //SELECCION MAXIMA DE LA FACTURA 
$maximo_factura = $db->query('SELECT MAX(id_factura) FROM facturas'); 
$max_factura = $maximo_factura->fetchColumn();
   
   
//INSERSION A LA TABLA EGRESOS
       $query2  ="INSERT INTO egresos(razon_social, producto_servicio, costo, cantidad, subtotal, con_iva, id_factura) VALUES(:razon_social, :producto, :costo, :cantidad, '".$subtotal."', '".$con_iva."', '".$max_factura."' )";
 $query_params2 = array(
       
        ':razon_social' => $_POST['razon_social'],
        ':producto' => $_POST['producto'],
        ':costo' => $_POST['costo'],
        ':cantidad' => $_POST['cantidad']
    );
                                 ///LO UNICO QUE CAMBIA ES EL $query2 y el $query_params2
     try {
        $stmt   = $db->prepare($query2);
        $result = $stmt->execute($query_params2);
    }
    catch (PDOException $ex) {
        // solo para testing
        //die("Failed to run query: " . $ex->getMessage());
        
        $response["success"] = 0;
        $response["message"] = "NO SE AGREGO CORRECTAMENTE EL SERVICIO";
        die(json_encode($response));
    }


/////////////////////////////////////////////////////////////////////////////////////////////////////////

    //si hemos llegado a este punto
    //es que el usuario se agregado satisfactoriamente
    $response["success"] = 1;
    $response["message"] = "El servicio se ha agregado correctamente";
    echo json_encode($response);
    
    //para cas php tu puedes simpelmente redireccionar o morir
    //header("Location: login.php"); 
    //die("Redirecting to login.php");
    
    
} else {
?>
 <h1>Register</h1> 
 <form action="Egresos.php" method="post"> 
     Razon social:<br /> 
     <input type="text" name="razon_social" value="" required/> 
     <br /><br /> 
    Producto/Servicio:<br /> 
     <input type="text" name="producto" value="" required /> 
     <br /><br /> 
     Costo:<br /> 
     <input type="text" name="costo" value="" required/> 
     <br /><br /> 
     Cantidad:<br /> 
     <input type="text" name="cantidad" value="" required/> 
     <br /><br /> 
     <input type="submit" value="Registrar Egresos" /> 
 </form>
 <?php
}

?>
