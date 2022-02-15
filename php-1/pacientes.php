<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/pacientes.class.php';

$_respuestas = new respuestas;
$_pacientes = new pacientes;

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["page"])){

        //Obtenemos una lista de pacientes con un limite de 100 registros por pagina

        $pagina = $_GET["page"];
        $listaPacientes = $_pacientes->listaPacientes($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaPacientes);
        http_response_code(200);

    }else if(isset($_GET['id'])){

        //Obtenemos el dato de un paciente

        $pacienteId = $_GET['id'];
        $datosPaciente = $_pacientes->obtenerPaciente($pacienteId);
        header("Content-Type: application/json");
        echo json_encode($datosPaciente);
        http_response_code(200);
    }


} else if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    // Recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    
    // Enviamos los datos al manejador
    $datosArray = $_pacientes->post($postBody);
    
    // Devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray['result']['error_id'])){
        $responseCode = $datosArray['result']['error_id'];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);


}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    // Recibimos los datos enviados
    $postBody = file_get_contents("php://input");

    // Enviamos los datos al manejador

    $datosArray = $_pacientes->put($postBody);
    
    // Devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray['result']['error_id'])){
        $responseCode = $datosArray['result']['error_id'];
        http_response_code($responseCode);
    }else{
         http_response_code(200);
    }
    
    echo json_encode($datosArray);

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    
      // Recibimos los datos enviados
      $postBody = file_get_contents("php://input");

      // Enviamos los datos al manejador
  
      $datosArray = $_pacientes->delete($postBody);
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