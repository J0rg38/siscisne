<?php
//ini_set ('error_reporting',  ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set("display_errors", 1);
////error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);


$GET_Url = $_GET['Url'];
$GET_Nombre = $_GET['Nombre'];

$ruta_archivo = '../../generados/comprobantes_pdf/'.$GET_Nombre;
$nombre_archivo = basename($ruta_archivo);
header("Content-disposition: attachment; filename=".$GET_Nombre);
header("Content-type: application/octet-stream");
readfile($ruta_archivo);
?>