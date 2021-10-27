<?php
    
    require_once "conexion/conexion.php";
    require_once "respuestas.class.php";

    class auth extends conexion{

        public function login($json){
            $_respuestas = new respuestas;
            $datos = json_decode($json, true);
            if(!isset($datos['correo']) || !isset($datos['password'])){
                //error con los campos
                return $_respuestas->error_400();
            }else{
                //todo bien
                $usuario = $datos['correo'];
                $password = $datos['password'];
                $password = parent::encriptar($password);
                $datos = $this->obtenerDatosUsuario($usuario);
                if($datos){
                    //Si existe el usuario, preguntamos si la contraseña es correcta
                    if($password == $datos[0]['password']){
                        // Contraseña correcta
                    }else{
                        return $_respuestas->error_200("Contraseña incorrecta");
                    }
                }else{
                    //Si no existe el usuario
                    return $_respuestas->error_200("El usuario $usuario no existe");
                }
            }
        }

        private function obtenerDatosUsuario($correo){
            $query = "SELECT * FROM usuario WHERE correo = '$correo'";
            $datos = parent::obtenerDatos($query);
            if(isset($datos[0]['correo'])){
                return $datos;
            }else{
                return 0;
            }
        }

    }

?>