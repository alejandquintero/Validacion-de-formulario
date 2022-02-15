<?php

    require_once "conexion/conexion.php";
    require_once "respuestas.class.php";

    
    class pacientes extends conexion {
        
        private $tabla = "pacientes";
        private $pacienteid = "";
        private $dni = "";
        private $nombre = "";
        private $direccion = "";
        private $codigoPostal = "";
        private $telefono = "";
        private $genero = "";
        private $fechaNacimiento = "0000-00-00";
        private $correo = "";
        private $token = "";

        //Obtener lista de pacientes

        public function listaPacientes($pagina){
            $inicio = 0;
            $cantidad = 100;

            if($pagina > 1){
                $inicio = ($cantidad *($pagina -1)) + 1;
                $cantidad = $cantidad * $pagina;
            }

            $query = "SELECT PacienteId, Nombre, DNI, Telefono, Correo FROM ".$this->tabla . " limit $inicio,$cantidad";
            $datos = parent::obtenerDatos($query);
            return ($datos);
        }

        //Obtener todos los datos de un paciente

        public function obtenerPaciente($id){
            $query = "SELECT * FROM ". $this->tabla . " WHERE PacienteId = '$id'";
            return parent::obtenerDatos($query);
        }

        // Insertar paciente

        public function post($json){
            $_respuestas = new respuestas;
            $datos = json_decode($json, true);

            //Campos requeridos (obligatorios)
            if(!isset($datos['nombre']) || !isset($datos['dni']) || !isset($datos['correo'])){
                return $_respuestas->error_400();
            }else{

                //Campos obligatorios
                $this->nombre = $datos['nombre'];
                $this->dni = $datos['dni'];
                $this->correo = $datos['correo'];

                //Campos no obligatorios
                if(isset($datos['direccion'])){ $this->direccion = $datos['direccion'];}
                if(isset($datos['codigoPostal'])){ $this->codigoPostal = $datos['codigoPostal'];}
                if(isset($datos['telefono'])){ $this->telefono = $datos['telefono'];}
                if(isset($datos['genero'])){ $this->genero = $datos['genero'];}
                if(isset($datos['fechaNacimiento'])){ $this->fechaNacimiento = $datos['fechaNacimiento'];}
            }

            $resp = $this->insertarPaciente();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta['result'] = array(
                    "pacienteId" => $resp
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }

        }

        // Funcion que realiza el query de INSERT INTO

        private function insertarPaciente(){
            $query = "INSERT INTO " . $this->tabla . " (DNI, Nombre, Direccion, CodigoPostal, Telefono, Genero, FechaNacimiento, Correo) VALUES ('" . $this->dni ."','". $this->nombre . "','". $this->direccion .
            "','". $this->codigoPostal . "','". $this->telefono . "','". $this->genero . "','".$this->fechaNacimiento . "','". $this->correo . "');";

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