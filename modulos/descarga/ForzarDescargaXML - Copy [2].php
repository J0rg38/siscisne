<?php
//ini_set ('error_reporting',  ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set("display_errors", 1);
////error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
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
//$GET_Nombre = str_replace("xml","zip",$GET_Nombre);
//$ruta_archivo = '../../generados/comprobantes_fir/'.$GET_Nombre;

$ruta_archivo = 'http://192.168.0.3:81/CISNE/SUNAT/Factura/envio/'.$GET_Nombre;

//$zip = new ZipArchive;
//$res = $zip->open($ruta_archivo);
//if ($res === TRUE) {
//  $zip->extractTo('/zip/');
//  $zip->close();
////  echo 'woot!';
//} else {
////  echo 'doh!';
//}
if(file_exists($ruta_archivo)){
	
	//$GET_Nombre = str_replace("zip","xml",$GET_Nombre);
	$nombre_archivo = basename($ruta_archivo);
	header("Content-disposition: attachment; filename=".$GET_Nombre);
	header("Content-type: application/octet-stream");
	readfile($ruta_archivo);

}else{
	
	$URL_LOCAL = $SistemaServidor2;
	$URL_REMOTO = $SistemaServidor3;
	//http://localhost:8080/SISTEMAS/SISCA/empresa/principal.php?Mod=Factura&Form=Listado
	//$URL_REMOTO = "192.168.12.186:8080/SISCA/empresa/";
	
	$CARPETA = "SUNAT";
	$NOMBRE = $EmpresaCodigo."-01-".$InsFactura->FtaNumero."-".$InsFactura->FacId."";
	$ARCHIVO_XML = $NOMBRE.".xml";
	$ARCHIVO_CDR = "R-".$NOMBRE.".zip";
	/*
	* FACTURA ELECTRONICA
	*/
	//echo "Conectando con SUNAT...";
	//echo "<br>";
	//
	//echo "WSDL: http://192.168.0.252:8080/SUNAT/WsSUNAT.php?wsdl";
	//echo "<br>";
	
	$l_oClient = new nusoap_client('http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl','wsdl');
	
	$l_oProxy = $l_oClient->getProxy();
	
	$err = $l_oClient->getError();
		
	if ($err) {
		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
	}
	
	$ComprobanteXML['XMLUrl'] = "http://".$URL_LOCAL."/".$SistemaNombreCarpeta."/generados/comprobantes_xml/".$ARCHIVO_XML;
	$ComprobanteXML['XMLNombre'] = $NOMBRE;
	
	$l_stResult = $l_oProxy->MtdFirmarComprobante(json_encode($ComprobanteXML));
	$l_stResult = eregi_replace("'","\"",$l_stResult);
	
	$Trama = json_decode($l_stResult,true);
	

}

?>