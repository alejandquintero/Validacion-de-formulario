<?php

    require_once "conexion/conexion.php";
    require_once "respuestas.class.php";

    
    class usuario extends conexion {
        
        private $tabla = "usuario";
        private $idusuario = "";
        private $nombre = "";
        private $apellido = "";
        private $genero = "";
        private $email = "";
        private $password = "";

        // Insertar usuario

        public function post($json){
            $_respuestas = new respuestas;
            $datos = json_decode($json, true);

            //Campos requeridos (obligatorios)
            if(!isset($datos['nombre']) || !isset($datos['apellido']) || !isset($datos['genero']) || !isset($datos['email']) || !isset($datos['password'])){
                return $_respuestas->error_400();
            }else{

                //Campos obligatorios
                $this->nombre = $datos['nombre'];
                $this->apellido = $datos['apellido'];
                $this->genero = $datos['genero'];
                $this->email = $datos['email'];
                $this->password = $datos['password'];

            }
            
            //Verificamos que el email no esté registrado
            
            $queryEmail = "SELECT * FROM " . $this->tabla . " WHERE email = '" . $this->email ."'";
            $verificacion = parent::nonQuery($queryEmail);
  
              if($verificacion >=1){
                  return $_respuestas->error_200("El correo electronico proporcionado ya se encuentra registrado");             
              }else{
                $resp = $this->insertarUsuario();
                if($resp){
                    $respuesta = $_respuestas->response;
                    $respuesta['result'] = array(
                        "idusuario" => $resp
                    );
                    return $respuesta;
                }else{
                    return $_respuestas->error_500();
                }
              }

        }
        

        // Funcion que realiza el query de INSERT INTO

        private function insertarUsuario(){

            $query = "INSERT INTO " . $this->tabla . " (nombre, apellido, genero, email, password) VALUES ('" . $this->nombre ."','". $this->apellido . "','". $this->genero . "','". $this->email . "','". $this->password . "');";

            $resp = parent::nonQueryId($query);
            if($resp){
                return $resp;
            }else{
                return 0;
            }
        }

        // Actualizar datos

        public function put($json){

            $_respuestas = new respuestas;
            $datos = json_decode($json, true);

            //Campo requerido (obligatorio)
            if(!isset($datos['pacienteId'])){

                return $_respuestas->error_400();

            }else{

                //Campo obligatorio
                $this->pacienteid = $datos['pacienteId'];

                //Campos no obligatorios
                if(isset($datos['nombre'])){ $this->nombre = $datos['nombre'];}
                if(isset($datos['dni'])){ $this->dni = $datos['dni'];}
                if(isset($datos['correo'])){ $this->correo = $datos['correo'];}
                if(isset($datos['direccion'])){ $this->direccion = $datos['direccion'];}
                if(isset($datos['codigoPostal'])){ $this->codigoPostal = $datos['codigoPostal'];}
                if(isset($datos['telefono'])){ $this->telefono = $datos['telefono'];}
                if(isset($datos['genero'])){ $this->genero = $datos['genero'];}
                if(isset($datos['fechaNacimiento'])){ $this->fechaNacimiento = $datos['fechaNacimiento'];}
            }

            $resp = $this->modificarPaciente();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta['result'] = array(
                    "pacienteId" => $this->pacienteid
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }


        }

        // Function que realiza el query de UPDATE

        private function modificarPaciente(){

            $query = "UPDATE " . $this->tabla . " SET Nombre = '" . $this->nombre . "', Direccion = '" .$this->direccion .
            "', DNI = '" . $this->dni . "', Correo = '" .$this->correo . "', CodigoPostal = '". $this->codigoPostal .
            "', Telefono = '" . $this->telefono . "', Genero = '" . $this->genero . "', FechaNacimiento = '" . $this->fechaNacimiento . "' WHERE PacienteId = '" . $this->pacienteid . "';";

            $resp = parent::nonQuery($query);
            //Responde con las filas afectadas
            if($resp >= 1){
                return $resp;
            }else{
                return 0;
            }
        }

        public function delete($json){

            $_respuestas = new respuestas;
            $datos = json_decode($json, true);

            //Campo requerido (obligatorio)
            if(!isset($datos['pacienteId'])){

                return $_respuestas->error_400();

            }else{
                //Campo obligatorio
                $this->pacienteid = $datos['pacienteId'];
            }

            $resp = $this->eliminarPaciente();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta['result'] = array(
                    "pacienteId" => $this->pacienteid
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }


        }

        private function eliminarPaciente(){
            $query = "DELETE FROM ".$this->tabla. " WHERE PacienteId = '". $this->pacienteid. "';";
            $resp = parent::nonQuery($query);

            if($resp >= 1){
                return $resp;
            }else{
                return 0;
            }
        }





    }


?>