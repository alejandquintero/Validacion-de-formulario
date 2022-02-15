<?php
    
    require_once "conexion/conexion.php";
    require_once "respuestas.class.php";

    class auth extends conexion{

        public function login($json){
            $_respuestas = new respuestas;
            $datos = json_decode($json, true);
            if(!isset($datos['Usuario']) || !isset($datos['Password'])){
                //error con los campos
                return $_respuestas->error_400();
            }else{
                //todo bien
                $usuario = $datos['Usuario'];
                $password = $datos['Password'];
                $password = parent::encriptar($password);
                $datos = $this->obtenerDatosUsuario($usuario);
                if($datos){
                    //Si existe el usuario, preguntamos si la contraseña es correcta
                    if($password == $datos[0]['Password']){
                        // Contraseña correcta
                        if($datos[0]['Estado'] == "Activo"){
                            //Usuario activo
                            $verificar = $this->insertarToken($datos[0]['UsuarioId']);
                            if($verificar){
                                //Se guardo
                                $result = $_respuestas->response;
                                $result['result'] = array(
                                    "token" => $verificar
                                );
                                return $result;
                            }else{
                                //No se guardo
                                return $_respuestas->error_500("Error interno, no hemos podido guardar");
                            }
                        }else{
                            //Usuario inactivo
                            return $_respuestas->error_200("El usuario esta inactivo");
                        }
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
            $query = "SELECT * FROM usuarios WHERE Usuario = '$correo'";
            $datos = parent::obtenerDatos($query);
            if(isset($datos[0]['UsuarioId'])){
                return $datos;
            }else{
                return 0;
            }
        }

        private function insertarToken($usuarioid){
            $val = true;
            $token = bin2hex(openssl_random_pseudo_bytes(16, $val));
            $date = date("Y-m-d H:i");
            $estado = "Activo";
            $query = "INSERT INTO usuarios_token (UsuarioId, Token, Estado, Fecha) VALUES('$usuarioid', '$token', '$estado', '$date')";
            $verificar = parent::nonQuery($query);
            if($verificar){
                return $token;
            }else{
                return 0;
            }
        }

    }

?>