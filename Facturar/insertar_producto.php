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
    
    if (empty($_POST['nombre_producto']) || empty($_POST['costo']) || empty($_POST['marca']) || empty($_POST['proveedor'])|| empty($_POST['tamanio'])) {
        
        // creamos el JSON
        $response["success"] = 0;
        $response["message"] = "Por favor inserte los datos requeridos";
        
        die(json_encode($response));
    }
    
  
$proveedor=$_REQUEST['proveedor'];
$consulta = "SELECT  id_proveedor  FROM proveedor where nombre_proveedor=:proveedor"; 
$result = $db->prepare($consulta);
$result->execute(array(":proveedor" => $proveedor));
$resultado8 = $result->fetchColumn();

    $query2  ="INSERT INTO producto(nombre_producto, id_proveedor, marca, tamanio, costo)VALUES(:nombre_producto,'".$resultado8."',:marca, :tamanio, :costo)";
 $query_params2 = array(
       
        ':nombre_producto' => $_POST['nombre_producto'],
        ':marca' => $_POST['marca'],
        ':tamanio' => $_POST['tamanio'],
        ':costo' => $_POST['costo']
        
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
        $response["message"] = "NO SE AGREGO CORRECTAMENTE EL PRODUCTO";
        die(json_encode($response));
    }

    //si hemos llegado a este punto
    //es que el usuario se agregado satisfactoriamente
    $response["success"] = 1;
    $response["message"] = "El producto se ha agregado correctamente";
    echo json_encode($response);
    
    //para cas php tu puedes simpelmente redireccionar o morir
    //header("Location: login.php"); 
    //die("Redirecting to login.php");
    
    
} else {
?>
 <h1>Register</h1> 
 <form action="insertar_producto.php" method="post"> 
     Nombre del Producto:<br /> 
     <input type="text" name="nombre_producto" value="" /> 
     <br /><br /> 
          Proveedor:<br /> 
     <input type="text" name="proveedor" value="" /> 
     <br /><br /> 
      Tamano:<br /> 
     <input type="text" name="tamanio" value="" /> 
     <br /><br /> 
      Costo:<br /> 
     <input type="text" name="costo" value="" /> 
     <br /><br /> 
     Marca:<br /> 
     <input type="text" name="marca" value="" /> 
     <br /><br /> 
     <input type="submit" value="Registrar productos" /> 
 </form>
 <?php
}

?>


