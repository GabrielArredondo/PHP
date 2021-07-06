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
if (isset($_GET['file'])) { 
  $file_example ="Tu URL". $_GET['file']; //Nombre del archivo
  $archivo_descarga = curl_init(); //inicializamos el curl
  curl_setopt($archivo_descarga, CURLOPT_URL, $file_example);
  curl_setopt($archivo_descarga, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($archivo_descarga, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($archivo_descarga, CURLOPT_AUTOREFERER, true);
  $resultado_descarga = curl_exec($archivo_descarga); //realizamos la descarga
  if(!curl_errno($archivo_descarga)) // si no hay error hacemos la descarga
  {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename ="'.$_GET['file'].'"'); //renombramos la descarga
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    echo($resultado_descarga);
    exit();
  }else
  {
    echo(curl_error($archivo_descarga)); // Si hay error lo mostramos
  }
  }
  ?>