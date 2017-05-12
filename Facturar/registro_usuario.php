<?php
//////////////////////////////////////REGISTRO USUARIO SI FUNCIIONA////////////////////////////////////
/*
siempre tener en cuenta "config.inc.php" 
*/
require("config.inc.php");

//if posted data is not empty
if (!empty($_POST)) {
    //preguntamos si el ussuario y la contraseña esta vacia
    //sino muere
    if (empty($_POST['username']) || empty($_POST['password'])) {
        
        // creamos el JSON
        $response["success"] = 0;
        $response["message"] = "Por favor inserte los datos usuario y el password";
        
        die(json_encode($response));
    }
    
    //si no hemos muerto (die), nos fijamos si exist en la base de datos
    $query        = " SELECT 1 FROM login WHERE username = :user";
    
    //acutalizamos el :user
    $query_params = array(
        ':user' => $_POST['username']
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
        $response["message"] = "Lo siento el usuario ya existe, no";
        die(json_encode($response));
    }
    //Si llegamos a este punto, es porque el usuario no existe
    //y lo insertamos (agregamos)
   //////////////////////////////////////////////////////////////////////////////////////////////////////
    $query = "INSERT INTO login ( username, password ) VALUES ( :user, :pass ) ";
    //actualizamos los token
    $query_params = array(
        ':user' => $_POST['username'],
        ':pass' => $_POST['password']
    );
   
    //ejecutamos la query y creamos el usuario
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        //solo para testing
        //die("Failed to run query: " . $ex->getMessage());
        
        $response["success"] = 0;
        $response["message"] = "Error base de datos2. Porfavor vuelve a intentarlo";
        die(json_encode($response));
    }
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////
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

$maximo_login = $db->query('SELECT MAX(id_login) FROM login'); 
$resultado2 = $maximo_login->fetchColumn();

//************************************************************************


///////////////////////////////////INSERTAR USUARIO//////////////////////////////////////////////////////

 $query3= "INSERT INTO usuario(nombre, id_ubicacion, id_login) VALUES(:nombre, '".$resultado."', '".$resultado2."')";
 $query_params3 = array(
       
        ':nombre' => $_POST['nombre']
       
       
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
        $response["message"] = "NO SE INSERTO EL USUARIO";
        die(json_encode($response));
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////

    //si hemos llegado a este punto
    //es que el usuario se agregado satisfactoriamente
    $response["success"] = 1;
    $response["message"] = "El usuario se ha agregado correctamente";
    echo json_encode($response);
    
    //para cas php tu puedes simpelmente redireccionar o morir
    //header("Location: login.php"); 
    //die("Redirecting to login.php");
    
    
} else {
?>
 <h1>Register</h1> 
 <form action="registro_usuario.php" method="post"> 
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

     Username:<br /> 
     <input type="text" name="username" value="" /> 
     <br /><br /> 
     Password:<br /> 
     <input type="password" name="password" value="" /> 
     <br /><br /> 
     <input type="submit" value="Register New User" /> 
 </form>
 <?php
}

?>