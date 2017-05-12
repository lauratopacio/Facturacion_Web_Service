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
    
    if (empty($_POST['nombre']) || empty($_POST['regimen']) || empty($_POST['email']) ) {
        
        // creamos el JSON
        $response["success"] = 0;
        $response["message"] = "Por favor inserte los datos requeridos";
        
        die(json_encode($response));
    }
    
    //si no hemos muerto (die), nos fijamos si exist en la base de datos
    $query        = " SELECT 1 FROM cliente WHERE email = :email";
    
    //acutalizamos el :user
    $query_params = array(
        ':email' => $_POST['email']
    );
    
    //ejecutamos la consulta
    try {
        // estas son las dos consultas que se van a hacer en la bse de datos
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        // solo para testing
        //die("Failed to run query: " . $ex->getMessage());
        
        $response["success"] = 0;
        $response["message"] = "Database Error1. Please Try Again!";
        die(json_encode($response));
    }
    
    //buscamos la información
    //como sabemos que el usuario ya existe lo matamos
    $row = $stmt->fetch();
    if ($row) {
        // Solo para testing
        //die("This username is already in use");
        
        $response["success"] = 0;
        $response["message"] = "Lo siento el correo ya existe, intente con otro correo porfavor";
        die(json_encode($response));
    }
    
  
  ///////////////////////////////////////////////////////////////////////////////////////////////////////
 ///*****************************************REGISTRO UBICACION********************************************
 
    $query2  ="INSERT INTO ubicacion ( calle, estado, num_ext, num_int, colonia, localidad, delegacion, cod_postal) VALUES(:calle, :estado, :num_ext, :num_int, :colonia, :localidad, :delegacion,:cod_postal)";
 $query_params2 = array(
       
        ':calle' => $_POST['calle'],
        ':estado' => $_POST['estado'],
        ':num_ext' => $_POST['num_ext'],
        ':num_int' => $_POST['num_int'],
        ':colonia' => $_POST['colonia'],
        ':localidad' => $_POST['localidad'],
        ':delegacion' => $_POST['delegacion'],
     ':cod_postal' => $_POST['cod_postal']


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
        $response["message"] = "NO SE INSERTO EL DOMICILIO";
        die(json_encode($response));
    }

// obtener la id maxima de ubicacion  se almacena en $resultado
$maximo_ubicacion = $db->query('SELECT MAX(id_ubicacion) FROM ubicacion'); 
$resultado = $maximo_ubicacion->fetchColumn();

$regimen=$_REQUEST['regimen'];

$consulta = "SELECT id_regimen from regimen where tipo_regimen =:regimen"; 

$result = $db->prepare($consulta);
$result->execute(array(":regimen" => $regimen));

$resultado8 = $result->fetchColumn();

if (!$result) {
    print "<p>Error en la consulta.</p>\n";
}
///////////////////////////////////SELECCION REGIMEN//////////////////////////////////////////////////////
 $query3= "INSERT INTO cliente(nombre, id_ubicacion,id_regimen, email) VALUES(:nombre, '".$resultado."', 
'".$resultado8."', :email)";

 $query_params3 = array(
       
        ':nombre' => $_POST['nombre'],
        ':email' => $_POST['email']
      


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
        $response["message"] = "NO SE INSERTO EL CLIENTE";
        die(json_encode($response));
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////

    //si hemos llegado a este punto
    //es que el usuario se agregado satisfactoriamente
    $response["success"] = 1;
    $response["message"] = "El cliente se ha agregado correctamente";
    echo json_encode($response);
    
    //para cas php tu puedes simpelmente redireccionar o morir
    //header("Location: login.php"); 
    //die("Redirecting to login.php");
    
    
} else {
?>
 <h1>Register</h1> 
 <form action="registro_cliente.php" method="post"> 
     Nombre:<br /> 
     <input type="text" name="nombre" value="" /> 
     <br /><br /> 
          Calle:<br /> 
     <input type="text" name="calle" value="" /> 
     <br /><br /> 
       Estado:<br /> 
     <input type="text" name="estado" value="" /> 
     <br /><br /> 
       No. ext<br /> 
     <input type="text" name="num_ext" value="" />     
     <br /><br /> 
       No. int:<br /> 
     <input type="text" name="num_int" value="" /> 
     <br /><br /> 
      Colonia:<br /> 
     <input type="text" name="colonia" value="" /> 
     <br /><br /> 
       Localidad<br /> 
     <input type="text" name="localidad" value="" /> 
     <br /><br /> 
        Delegacion:<br /> 
     <input type="text" name="delegacion" value="" /> 
     <br /><br /> 
       Cod_postal:<br /> 
     <input type="text" name="cod_postal" value="" /> 
     <br /><br /> 
      Regimen:<br />  
     <input type="text" name="regimen" value="" /> 

     Correo Electronico:<br /> 
     <input type="text" name="email" value="" /> 
     <br /><br />
     <input type="submit" value="Register New User" /> 
 </form>
 <?php
}

?>
