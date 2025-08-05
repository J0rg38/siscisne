<?php
//ini_set ('error_reporting',  ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set("display_errors", 1);
////error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

$GET_Url = $_GET['Url'];
$GET_Nombre = $_GET['Nombre'];
$GET_Nombre = str_replace("xml","zip",$GET_Nombre);
//$ruta_archivo = '../../generados/comprobantes_fir/'.$GET_Nombre;

$ruta_archivo = 'http://192.168.0.3:81/CISNE/SUNAT/Factura/envio/'.$GET_Nombre;


$zip = new ZipArchive;
$res = $zip->open($ruta_archivo);
if ($res === TRUE) {
  $zip->extractTo('/zip/');
  $zip->close();
//  echo 'woot!';
} else {
//  echo 'doh!';
}

$GET_Nombre = str_replace("zip","xml",$GET_Nombre);

$nombre_archivo = basename($ruta_archivo);
header("Content-disposition: attachment; filename=".$GET_Nombre);
header("Content-type: application/octet-stream");
readfile($ruta_archivo);
?>