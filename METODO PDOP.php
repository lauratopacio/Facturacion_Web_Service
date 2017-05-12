
/////////////////// obtener la id maxima de ubicacion  se almacena en $resultado///////////////////////////
$maximo_ubicacion = $db->query('SELECT MAX(id_ubicacion) FROM ubicacion'); 
$resultado = $maximo_ubicacion->fetchColumn();
$db = null; 
print("ubicacion maxima = $resultado\n");



////////////////////////////////////////INSERTAR DATOS///////////////////////////////////////

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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
