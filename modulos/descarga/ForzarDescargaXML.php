<?php
ini_set ('error_reporting',  ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set("display_errors", 1);
//////error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_DEPRECATED);
//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
//
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');
//
$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';
//
//////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');

////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
////require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
//require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


$GET_Url = $_GET['Url'];
$GET_Nombre = $_GET['Nombre'];
$GET_Nombre = "R-".$_GET['Nombre'];
$GET_Nombre2 = $_GET['Nombre'];

$ruta_archivo2 = 'http://'.$SistemaServidor3.'/SUNAT/Factura/envio/'.$GET_Nombre;
$ruta_archivo = 'http://'.$SistemaServidor3.'/SUNAT/Factura/envio/'.$GET_Nombre2;

//$zip = new ZipArchive;
//$res = $zip->open($ruta_archivo);
//if ($res === TRUE) {
//  $zip->extractTo('/zip/');
//  $zip->close();
////  echo 'woot!';
//} else {
////  echo 'doh!';
//}

//$url = 'http://www.example.com';
$array = get_headers($ruta_archivo);
$string = $array[0];

  
//if(file_exists($ruta_archivo)){
if(strpos($string,"200")){

	//$GET_Nombre = str_replace("zip","xml",$GET_Nombre);
	$nombre_archivo = basename($ruta_archivo);
	header("Content-disposition: attachment; filename=".$GET_Nombre);
	header("Content-type: application/octet-stream");
	readfile($ruta_archivo);
	
}else{

	$nombre_archivo = basename($ruta_archivo2);
	header("Content-disposition: attachment; filename=".$GET_Nombre2);
	header("Content-type: application/octet-stream");
	readfile($ruta_archivo2);
	
}

?>