<?php
    require_once 'clases/respuestas.class.php';
    require_once 'clases/usuario.class.php';

    $_respuestas = new respuestas;
    $_usuario = new usuario;

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    // Recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    
    // Enviamos los datos al manejador
    $datosArray = $_usuario->post($postBody);
    
    // Devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray['result']['error_id'])){
        $responseCode = $datosArray['result']['error_id'];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
    
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>