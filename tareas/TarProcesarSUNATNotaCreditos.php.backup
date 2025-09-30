<?php
session_start();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}



require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON.php'); 
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');




//$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/01/".date("Y");
$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:date("d/m/Y");
$POST_FechaInicio = "01/01/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");
$POST_Limite = isset($_GET['Limite'])?$_GET['Limite']:25;
//$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"NcrFechaEmision";
//$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"DESC";
//
//$POST_Moneda = ($_GET['Moneda']);
//
//$POST_ClienteNombre = ($_GET['ClienteNombre']);
//$POST_ClienteNumeroDocumento = ($_GET['ClienteNumeroDocumento']);
//$POST_ClienteId = ($_GET['ClienteId']);
//
//$POST_CondicionPago = ($_GET['CondicionPago']);
//$POST_Personal = ($_GET['Personal']);



require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteVenta.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');


require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoTalonario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

$InsNotaCredito1 = new ClsNotaCredito();
$InsNotaCreditoTalonario = new ClsNotaCreditoTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();


$ResNotaCredito = $InsNotaCredito1->MtdObtenerNotaCreditos(NULL,NULL,NULL,"NcrTiempoCreacion","DESC",1,$POST_Limite,$POST_Sucursal,"5",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,$POST_Moneda,NULL,NULL,$POST_Sucursal,NULL,true);
$ArrNotaCreditos = $ResNotaCredito['Datos'];






$EnlazarPendiente = 0;
$EnlazarRealizados = 0;

echo "NOTAS DE CREDITO ENCONTRADAS: ";
echo count($ArrNotaCreditos);
echo "<br>";
echo "<br>";

$Ruta = "../";

$EnlazarPendiente = count($ArrNotaCreditos);;

if(!empty($ArrNotaCreditos)){	
	foreach($ArrNotaCreditos as $DatNotaCredito){
		
		echo "<br>";
		echo "<h1>";
		echo "NOTA DE CREDITO ";
		echo "</h1>";
		echo "<br>";
		
		echo "NctNumero: ";
		echo $DatNotaCredito->NctNumero;
		echo "<br>";
		
		echo "NcrId: ";
		echo $DatNotaCredito->NcrId;
		echo "<br>";
		
		echo "NcrFechaEmision: ";
		echo $DatNotaCredito->NcrFechaEmision;;
		echo "<br>";
		
		echo "AmoId: ";
		echo $DatNotaCredito->AmoId;
		echo "<br>";
	
		echo "NcrSunatRespuestaEnvioContenido: ";
		echo $DatNotaCredito->NcrSunatRespuestaEnvioContenido;
		echo "<br>";
			
		echo "NcrTiempoCreacion: ";
		echo $DatNotaCredito->NcrTiempoCreacion;
		echo "<br>";
		echo "<br>";
	
			
		$InsNotaCredito = new ClsNotaCredito();	
		
		$InsNotaCredito->MtdNotaCreditoGenerarArchivoXML($DatNotaCredito->NctId,$DatNotaCredito->NcrId,$Ruta.'generados/comprobantes_xml/');
		
		sleep(5);
				
		//Obteniendo datos de factura
		$InsNotaCredito->NcrId = $DatNotaCredito->NcrId;
		$InsNotaCredito->NctId = $DatNotaCredito->NctId;
		$InsNotaCredito->MtdObtenerNotaCredito();
		
		//$InsNotaCredito->NcrId=$InsNotaCredito->NcrId;
		//$InsNotaCredito->NcrId=(string)(int)$InsNotaCredito->NcrId;
		//190.117.111.8
		$URL_LOCAL = $SistemaServidor2;
		$URL_REMOTO = $SistemaServidor3;
		$CARPETA = "SUNAT";
		$NOMBRE = $EmpresaCodigo."-07-".$InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId."";
		$ARCHIVO_XML = $NOMBRE.".xml";
		$ARCHIVO_CDR = "R-".$NOMBRE.".zip";
		
		
		echo "NOMBRE: ";
		echo $NOMBRE;
		echo "<br>";
		
		echo "ARCHIVO_XML: ";
		echo $ARCHIVO_XML;
		echo "<br>";
		
		echo "ARCHIVO_CDR: ";
		echo $ARCHIVO_CDR;
		echo "<br>";
		
		 
			
			
			/*
		* FACTURA ELECTRONICA
		*/
		//echo "Conectando con SUNAT...";
		//echo "<br>";
		//
		//echo "WSDL: http://192.168.0.252:8080/SUNAT/WsSUNAT.php?wsdl";
		//echo "<br>";
		echo $wsdl = 'http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl' ;
		echo "<br>";
		
		$l_oClient = new nusoap_client($wsdl,'wsdl');
		
		$l_oProxy = $l_oClient->getProxy();
		
		$err = $l_oClient->getError();
			
		if ($err) {
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		}
		
		//$ComprobanteXML['XMLUrl'] = "http://".$URL_LOCAL."/".$SistemaNombreCarpeta."/generados/comprobantes_xml/".$ARCHIVO_XML;
		$ComprobanteXML['XMLUrl'] = "http://".$URL_LOCAL."/".$SistemaNombreCarpeta."/generados/comprobantes_xml/".$ARCHIVO_XML;
		$ComprobanteXML['XMLNombre'] = $NOMBRE;
		
		$l_stResult = $l_oProxy->MtdProcesarNotaCredito(json_encode($ComprobanteXML));
		$l_stResult = eregi_replace("'","\"",$l_stResult);
		$l_stResult = utf8_encode($l_stResult);
		
		$Trama = json_decode($l_stResult,true);
		
		$UltimaRespuesta = "";
		
		if($Trama['CodigoRespuesta']=="P101"){
			
			$UltimaRespuesta = "APROBADO";
		
		}else if($Trama['CodigoRespuesta']=="P102"){
			
			$UltimaRespuesta = "ERROR";
			
		}else if($Trama['CodigoRespuesta']=="P103"){
			
			$UltimaRespuesta = "ERROR";
						
		}else{
		
			$CodigoRespuesta = $Trama['CodigoRespuesta'] + 1 - 1;
		
			if($CodigoRespuesta>= 100 and $CodigoRespuesta <=1999){
				$UltimaRespuesta = "EXCEPCION";
			}else if($CodigoRespuesta>= 2000 and $CodigoRespuesta <=3999){
				$UltimaRespuesta = "RECHAZO";	
			}else if($CodigoRespuesta>= 4000){
				$UltimaRespuesta = "OBSERVADO";	
			}else{
				$UltimaRespuesta = "ERROR";
			}
		
		}
		
		//TICKET ENVIO
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioFecha",$Trama['FechaRespuesta'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioHora",$Trama['HoraRespuesta'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioCodigo",$Trama['CodigoRespuesta'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioContenido",$Trama['MensajeRespuesta'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		//$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		
		//HISTORIAL OBSERVACIONES
		$Observaciones = $InsNotaCredito->NcrSunatRespuestaObservacion;
		$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaObservacion",$Observaciones,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		//ULTIMO TICKET
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsNotaCredito->NcrSunatRespuestaTicket),$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaTicketEstado","",$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		//FIRMA
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		//ACCIONES
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatUltimaAccion","ALTA",$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatUltimaRespuesta",$UltimaRespuesta,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
		
		if(!empty($Trama['XmlFirmado'])){
		
			$OUTPUT = $Ruta."generados/comprobantes_fir/".$ARCHIVO_XML;
		
			$bin = base64_decode($Trama['XmlFirmado']);
			file_put_contents($OUTPUT, $bin);	
			
		}
		
		if(!empty($Trama['ZIPRespuesta'])){
		
			$OUTPUT = $Ruta."generados/comprobantes_cdr/".$ARCHIVO_CDR;
		
			$bin = base64_decode($Trama['ZIPRespuesta']);
			file_put_contents($OUTPUT, $bin);	
			
		}

		echo "<br>";
		
		echo "Resultado: ".($l_stResult);




		 

		echo "<br>";
		echo "<br>";


		
	}	
}

//echo "<br>";
//echo "ENLAZADOS CORRECTAMENTE: ";
//echo $EnlazarRealizados;
//echo "<br>";
echo "-----------------------------------------------";
echo "<br>";
echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");

?>