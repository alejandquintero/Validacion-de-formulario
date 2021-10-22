<?php
      // Preparamos la base de datos puede ser de esta manera o incluyendola en la cadena de conexion
      //$pdo->exec("USE ".$nombre_bd);
    
    $localhost = "localhost";
    $user = "nano";
    $pass = "123456";
    $nombre_bd = "formulario";
    $connection_string = "mysql:host=$localhost;dbname=$nombre_bd;";
    $data = json_decode(file_get_contents("php://input"));

    // Usando axios

    $name = $data->name_user;
    $lastname = $data->lastname;
    $gender = $data->gender;
    $email = $data->email;
    $password = $data->password;


        //Iniciamos la conexión a La BBDD instanciando la clase PDO(cadenaDeConexion, usuario, contraseña)
        
        try{
            $pdo = new PDO($connection_string, $user, $pass);
            
            //Cambiamos el modo de tratamiento de errores
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //Creamos la variables que recibiremos del formulario:

            // $name = isset($_POST['name']) ? ($_POST['name']) : null;
            // $lastname = isset($_POST['lastname']) ? ($_POST['lastname']) : null;
            // $gender = isset($_POST['gender']) ?($_POST['gender']) : null;
            // $email = isset($_POST['email']) ? $_POST['email'] : null;
            // $password = isset($_POST['password']) ? ($_POST['password']) : null;
        

            // Con esto se prepara la consulta y también podría simular a $pdo->exec()

            $textosql_validate_email = "SELECT * FROM `formulario`.`usuario` WHERE correo = '".$email."';";
            
            $textosql_register = "INSERT INTO `formulario`.`usuario` (`nombre`,`apellidos`, `genero`, `correo`, `password`) VALUES ('".$name."','".$lastname."','".$gender."','".$email."','".$password."');";

            $statement_email = $pdo->prepare($textosql_validate_email);
            $statement_email->execute();

            //Para devolver un tipo PDOstatement que para leerlo hay que hacerlo con PDO::FETCH_ASSOC u otro fetch
            // $statement->execute();

            if($statement_email AND $statement_email->rowCount() > 0){
                echo "Ya hay un usuario registrado con el correo facilitado.";
                header('location: ../index.html');
            }else{
                $statement_register = $pdo->prepare($textosql_register);
                $statement_register->execute();
                echo "Registro exitoso.";
            }

    }

    catch(PDOException $e){

        echo "Ha ocurrido un error de base de datos ".$e->getMessage();
    }

    finally{
        
        //Aquí destruimos la conexión
        
        $pdo = null;
        echo "Trabajo finalizado.";

    }


?>