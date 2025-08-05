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
//$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"NdbFechaEmision";
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



require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoTalonario.php');


$InsNotaDebito1 = new ClsNotaDebito();
$InsNotaDebitoTalonario = new ClsNotaDebitoTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();

$ResNotaDebito = $InsNotaDebito->MtdObtenerNotaDebitos( NULL,NULL,NULL,"NdbTiempoCreacion","DESC",1,$POST_Limite,NULL,"5",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,$POST_Moneda);
$ArrNotaDebitos = $ResNotaDebito['Datos'];

$EnlazarPendiente = 0;
$EnlazarRealizados = 0;

echo "NOTAS DE DEBITO ENCONTRADAS: ";
echo count($ArrNotaDebitos);
echo "<br>";
echo "<br>";

$Ruta = "../";

$EnlazarPendiente = count($ArrNotaDebitos);;

if(!empty($ArrNotaDebitos)){	
	foreach($ArrNotaDebitos as $DatNotaDebito){
		
		echo "<br>";
		echo "<h1>";
		echo "NOTA DE DEBITO ";
		echo "</h1>";
		echo "<br>";
		
		echo "NdtNumero: ";
		echo $DatNotaDebito->NdtNumero;
		echo "<br>";
		
		echo "NdbId: ";
		echo $DatNotaDebito->NdbId;
		echo "<br>";
		
		echo "NdbFechaEmision: ";
		echo $DatNotaDebito->NdbFechaEmision;;
		echo "<br>";
		
		echo "AmoId: ";
		echo $DatNotaDebito->AmoId;
		echo "<br>";
	
		echo "NdbSunatRespuestaEnvioContenido: ";
		echo $DatNotaDebito->NdbSunatRespuestaEnvioContenido;
		echo "<br>";
			
		echo "NdbTiempoCreacion: ";
		echo $DatNotaDebito->NdbTiempoCreacion;
		echo "<br>";
		echo "<br>";
	
			
		$InsNotaDebito = new ClsNotaDebito();	
		
		$InsNotaDebito->MtdNotaDebitoGenerarArchivoXML($DatNotaDebito->NdtId,$DatNotaDebito->NdbId,$Ruta.'generados/comprobantes_xml/');
		
		sleep(5);
				
		//Obteniendo datos de factura
		$InsNotaDebito->NdbId = $DatNotaDebito->NdbId;
		$InsNotaDebito->NdtId = $DatNotaDebito->NdtId;
		$InsNotaDebito->MtdObtenerNotaDebito();
		
		//$InsNotaDebito->NdbId=$InsNotaDebito->NdbId;
		//$InsNotaDebito->NdbId=(string)(int)$InsNotaDebito->NdbId;
		//190.117.111.8
		$URL_LOCAL = $SistemaServidor2;
		$URL_REMOTO = $SistemaServidor3;
		$CARPETA = "SUNAT";
		$NOMBRE = $EmpresaCodigo."-07-".$InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId."";
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
		
		$l_stResult = $l_oProxy->MtdProcesarNotaDebito(json_encode($ComprobanteXML));
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
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioFecha",$Trama['FechaRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioHora",$Trama['HoraRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioCodigo",$Trama['CodigoRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioContenido",$Trama['MensajeRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		//$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		
		//HISTORIAL OBSERVACIONES
		$Observaciones = $InsNotaDebito->NdbSunatRespuestaObservacion;
		$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaObservacion",$Observaciones,$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		//ULTIMO TICKET
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsNotaDebito->NdbSunatRespuestaTicket),$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaTicketEstado","",$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		//FIRMA
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		//ACCIONES
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatUltimaAccion","ALTA",$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatUltimaRespuesta",$UltimaRespuesta,$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
		
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