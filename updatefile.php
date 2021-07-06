<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, OPTIONS");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8; multipart/form-data;');
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['url']))
    {
        $path = $_GET['url'];
        if (file_exists($path)) {
            If (unlink($path)) {
                echo json_encode(array(
                    "archivoUpload"=> array([
                        'status' => true,
                        'msj'=>'correcto'  
                    ]),
                    "resultML"=> array(
                        'resultCode' => 1,
                        'resultDescription' => 'El archivo fue eliminado correctamente',
                        'resultMsgCode'=>'Exito'
                    ))
                    );
              } else {
                echo json_encode(array(
                "archivoUpload"=>[],
                "resultML"=> array(
                    'resultCode' => 1,
                    'resultDescription' => 'No fue posible eliminar el archivo',
                    'resultMsgCode'=>'Error'
                ))
                );
              }
           
        } else {
            echo json_encode(array(
                "archivoUpload"=> [],
                "resultML"=> array(
                    'resultCode' => 0,
                    'resultDescription' => 'No se encontro el archivo en la ruta',
                    'resultMsgCode'=>'Error'
                ))
                );
        }
     
      exit();
	  }
    else {
        echo json_encode(array(
            "archivoUpload"=> array([
                'status' => false,
                'msj'=>'Incorrecto'  
            ]),
            "resultML"=> array(
                'resultCode' => 0,
                'resultDescription' => 'No se pudo reaizar la petion',
                'resultMsgCode'=>'Error'
            ))
            );
      exit();
	}
}

?>