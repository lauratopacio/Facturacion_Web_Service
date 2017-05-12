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
    
    if (empty($_POST['nombre_servicio']) || empty($_POST['costo_servicio']) ) {
        
        // creamos el JSON
        $response["success"] = 0;
        $response["message"] = "Por favor inserte los datos requeridos";
        
        die(json_encode($response));
    }
    
    //si no hemos muerto (die), nos fijamos si exist en la base de datos
    $query        = " SELECT 1 FROM servicio WHERE nombre_servicio = :nombre_servicio";
    $resultado = $query->fetchColumn();

    //acutalizamos el :user
    $query_params = array(
        ':nombre_servicio' => $_POST['nombre_servicio']
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
        $response["message"] = "Lo siento este servicio ya existe, intente con otro correo porfavor";
        die(json_encode($response));
    }
    
   //////////////////////////////////////////////////////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////////////////////////////////////////////////////
 ///*****************************************REGISTRO UBICACION********************************************
 
    $query2  ="INSERT INTO servicio(nombre_servicio, costo_servicio) VALUES(:nombre_servicio, :costo_servicio)";
 $query_params2 = array(
       
        ':nombre_servicio' => $_POST['nombre_servicio'],
        ':costo_servicio' => $_POST['costo_servicio']
        


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
 <form action="registro_servicio.php" method="post"> 
     Nombre servicio:<br /> 
     <input type="text" name="nombre_servicio" value="" /> 
     <br /><br /> 
          Costo servicio:<br /> 
     <input type="text" name="costo_servicio" value="" /> 
     <br /><br /> 
     <input type="submit" value="Register New User" /> 
 </form>
 <?php
}

?>
