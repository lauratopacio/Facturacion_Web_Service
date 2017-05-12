<?php

//carga y se conecta a la base de datos
require("config.inc.php");


if (!empty($_POST)) {
    //obteneos los usuarios respecto a la usuario que llega por parametro
    $query = " 
            SELECT 
                id_cliente,
                nombre, 
                email
            FROM cliente
            WHERE 
                nombre=:username and email=:email
        ";
    
    $query_params = array(
        ':username' => $_POST['username'],
        ':email'=>$_POST['email']
    );
    
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        //para testear pueden utilizar lo de abajo
        //die("la consulta murio " . $ex->getMessage());
        
        $response["success"] = 0;
        $response["message"] = "Problema con la base de datos, vuelve a intetarlo";
        die(json_encode($response));
        
    }
 
    $validated_info = false;
    
    //bamos a buscar a todas las filas
    $row = $stmt->fetch();
    if ($row) {
        //si el password viene encryptado debemos desencryptarlo acá
        // ++ DESCRYPTAR ++//

        //encaso que no lo este, solo comparamos como acontinuación
        if ($_POST['email'] === $row['email']) {
            $login_ok = true;
        }
    }
      
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


                        ///LO UNICO QUE CAMBIA ES EL $query2 y el $query_params2
    
    // así como nos logueamos en facebook, twitter etc!
    // Otherwise, we display a login failed message and show the login form again 
    if ($login_ok) {
        $response["success"] = 1;
        $response["message"] = "Inicio correcto!";
        die(json_encode($response));
///*************************************************************************************************///////



    } else {
        $response["success"] = 0;
        $response["message"] = "DATOS INCORRECTO";
        die(json_encode($response));
    }
/////////////////////////////////////////////////////////////////

}else {
?>
  <h1>Login</h1> 
  <form action="login_cliente.php" method="post"> 
      Username:<br /> 
      <input type="text" name="username" placeholder="username" /> 
      <br /><br /> 
      Password:<br /> 
      <input type="password" name="email" placeholder="email" value="" /> 
      <br /><br /> 
      <input type="submit" value="Login" /> 
  </form> 
  <a href="register.php">Register</a>
 <?php
}

?> 