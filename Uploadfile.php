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


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array('status' => false));
    exit;
}
$cadenatexto = $_POST['carpeta'];
$path='TuCarpeteDeAlmacenamiento';
$aliIdAliado = $_POST['aliIdAliado'];
$conIdConvenio=$_POST['conIdConvenio'];
$reIdReunion=$_POST['reIdReunion'];
if (isset($_FILES['file'])) {
    $originalName = $_FILES['file']['name'];
    $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
    $generatedName = md5($_FILES['file']['tmp_name']).$ext;
    $filePath = $path.$originalName;
    

    if (!is_writable($path)) {
        echo json_encode(array(
            'status' => false,
            'msg'    => 'En el directorio de destino no se puede escribir.'
        ));
        exit;
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
           
            echo json_encode(array(
                "archivoUpload"=> array([ 
                    "docNombre"=> preg_replace("/\.[^.]+$/", "", $originalName),
                    "aliIdAliado"=>$aliIdAliado,
                    "docExtension"=>$ext,
                    "docFechaCreacion"=> date("Y-m-d H:i:s"),
                    "docFechaModificacion"=>date("Y-m-d H:i:s"),
                    "conPeso"=> number_format($_FILES['file']['size'] / 1000000 , 2),
                    "conIdConvenio"=>$conIdConvenio,
                    "reIdReunion"=>$reIdReunion,
                    "docUrlDocumento"=>$filePath
                ]),
                "resultML"=> array(
                    'resultCode' => 1,
                    'resultDescription' => 'Se guardo el archivo correctamente',
                    'resultMsgCode'=>'Exito'
                ))
                );
            
    }else{
        echo json_encode(array(
            "archivoUpload"=> array([]),
            "resultML"=> array(
                'resultCode' => 0,
                'resultDescription' => 'No fue posible guardar el archivo.',
                'resultMsgCode'=>'Error'
            ))
            );
        }
        
}else{


    echo json_encode(
        array('status' => false, 'msg' => 'No se subió ningún archivo.')
    );
    exit;
}

?>