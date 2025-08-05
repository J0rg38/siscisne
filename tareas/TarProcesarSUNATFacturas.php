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
//$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"FacFechaEmision";
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


require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaTalonario.php');

$InsFactura1 = new ClsFactura();
$InsVentaConcretada = new ClsVentaConcretada();
$InsComprobanteVenta = new ClsComprobanteVenta();
$InsSucursal = new ClsSucursal();
$InsMoneda = new ClsMoneda();


//MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL,$oTieneCodigoExterno=NULL,$oSucursal=NULL)
$ResFactura = $InsFactura1->MtdObtenerFacturas(NULL,NULL,NULL,"FacTiempoCreacion","DESC",$POST_Limite,NULL,"5",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_tal,NULL,NULL,$POST_npago,NULL,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$POST_Sucursal,true);
$ArrFacturas = $ResFactura['Datos'];


$EnlazarPendiente = 0;
$EnlazarRealizados = 0;

echo "FACTURAS ENCONTRADAS: ";
echo count($ArrFacturas);
echo "<br>";
echo "<br>";

$Ruta = "../";

$EnlazarPendiente = count($ArrFacturas);;

if(!empty($ArrFacturas)){	
	foreach($ArrFacturas as $DatFactura){
		
		echo "<br>";
		echo "<h1>";
		echo "FACTURA ";
		echo "</h1>";
		echo "<br>";
		
		echo "FtaNumero: ";
		echo $DatFactura->FtaNumero;
		echo "<br>";
		
		echo "FacId: ";
		echo $DatFactura->FacId;
		echo "<br>";
		
		echo "FacFechaEmision: ";
		echo $DatFactura->FacFechaEmision;;
		echo "<br>";
		
		echo "AmoId: ";
		echo $DatFactura->AmoId;
		echo "<br>";
	
		echo "FacSunatRespuestaEnvioContenido: ";
		echo $DatFactura->FacSunatRespuestaEnvioContenido;
		echo "<br>";
		
		echo "FacTiempoCreacion: ";
		echo $DatFactura->FacTiempoCreacion;
		echo "<br>";
		echo "<br>";
	
			
		$InsFactura = new ClsFactura();	
		
		$InsFactura->MtdFacturaGenerarArchivoXML($DatFactura->FtaId,$DatFactura->FacId,$Ruta.'generados/comprobantes_xml/');
		
		sleep(5);
				
		//Obteniendo datos de factura
		$InsFactura->FacId = $DatFactura->FacId;
		$InsFactura->FtaId = $DatFactura->FtaId;
		$InsFactura->MtdObtenerFactura();
		
		//$InsFactura->FacId=$InsFactura->FacId;
		//$InsFactura->FacId=(string)(int)$InsFactura->FacId;
		//190.117.111.8
		$URL_LOCAL = $SistemaServidor2;
		$URL_REMOTO = $SistemaServidor3;
		$CARPETA = "SUNAT";
		$NOMBRE = $EmpresaCodigo."-01-".$InsFactura->FtaNumero."-".$InsFactura->FacId."";
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
		
		
		if(!empty($DatFactura->FacSunatRespuestaEnvioContenido)){
		
		
	
			echo "SE REVISARA EL COMPROBANTE";
			echo "<br>";
			
			
			
			preg_match('/[0-9]{4}/', $DatFactura->FacSunatRespuestaEnvioContenido,$Auxiliar);
			
			//deb($Auxiliar);
			
			if(!empty($Auxiliar)){
				
				$Codigo = $Auxiliar[0];
				
				if($Codigo == "1033"){
					
					echo "COMPROBANTE ANTES ENVIADO, SE CONSULTARA CDR";
					echo "<br>";
					
					////Obteniendo datos de factura
//					$InsFactura = new ClsFactura();
//					$InsFactura->FacId = $DatFactura->FacId;
//					$InsFactura->FtaId = $DatFactura->FtaId;
//					$InsFactura->MtdObtenerFactura();
					
					
					//$InsFactura->FacId=$InsFactura->FacId;
					//$InsFactura->FacId=(string)(int)$InsFactura->FacId;
					//190.117.111.8
					$URL_LOCAL = $SistemaServidor2;
					$URL_REMOTO = $SistemaServidor3;
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
					
					echo $wsdl = 'http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl';
					echo "<br>";
					
					$l_oClient = new nusoap_client($wsdl,'wsdl');
					
					$l_oProxy = $l_oClient->getProxy();
					
					$l_oProxy->response_timeout = 2000;
					$l_oClient->response_timeout = 2000;
					
					if ($l_oProxy->fault) {
						echo 'Error1: ';
						print_r($result);
						echo "<br>";	
					} else {
						// check result
						$err_msg = $l_oProxy->getError();
						if ($err_msg) {
							// Print error msg
							echo 'Error2: '.$err_msg;
							echo "<br>";
						} else {
						   // Print result
						   // echo 'Result: ';
						  //  print_r($result);
						 //  echo "<br>";
						}
					}
					
					 
					
					$ComprobanteXML['CDRRUC'] = $EmpresaCodigo;
					$ComprobanteXML['CDRTipoComprobante'] = "01";
					$ComprobanteXML['CDRSerie'] = $InsFactura->FtaNumero;
					$ComprobanteXML['CDRNumero'] = $InsFactura->FacId;
					$ComprobanteXML['CDRXMLNombre'] = $NOMBRE;
					
					$l_stResult = $l_oProxy->MtdConsultarCDR(json_encode($ComprobanteXML));
					$l_stResult = utf8_encode($l_stResult);
					
					
					$l_stResult = eregi_replace("'","\"",$l_stResult);
					
					$Trama = json_decode($l_stResult,true);
					
					$UltimaRespuesta = "";
					
					if($Trama['CodigoRespuesta']=="D101"){
						
						$UltimaRespuesta = "APROBADO";
					
					}else if($Trama['CodigoRespuesta']=="D102"){
						
						$UltimaRespuesta = "ERROR";
						
					}else if($Trama['CodigoRespuesta']=="D103"){
						
						$UltimaRespuesta = "ERROR";
						
					}else if($Trama['CodigoRespuesta']=="D104"){
						
						$UltimaRespuesta = "ERROR";
					
					}else if($Trama['CodigoRespuesta']=="D105"){
						
						$UltimaRespuesta = "ERROR";
					
					}else if($Trama['CodigoRespuesta']=="D106"){
						
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
					
					 
					
					$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
					$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioFecha",$Trama['FechaRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
					$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioHora",$Trama['HoraRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
					
					$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioCodigo",$Trama['CodigoRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
					$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioContenido",$Trama['MensajeRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
					$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsFactura->FacId,$InsFactura->FtaId);
					$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsFactura->FacId,$InsFactura->FtaId);
					
					$Observaciones = $InsFactura->FacSunatRespuestaObservacion;
					$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
					
					$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaObservacion",$Observaciones,$InsFactura->FacId,$InsFactura->FtaId);
					$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsFactura->FacSunatRespuestaTicket),$InsFactura->FacId,$InsFactura->FtaId);
					$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaTicketEstado","",$InsFactura->FacId,$InsFactura->FtaId);
					
					$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsFactura->FacId,$InsFactura->FtaId);
					$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsFactura->FacId,$InsFactura->FtaId);
					$InsFactura->MtdEditarFacturaDato("FacSunatUltimaActividad","ALTA",$InsFactura->FacId,$InsFactura->FtaId);
					$InsFactura->MtdEditarFacturaDato("FacSunatUltimaRespuesta",$UltimaRespuesta,$InsFactura->FacId,$InsFactura->FtaId);
					
					 
					
					if(!empty($Trama['XmlFirmado'])){
					
						$OUTPUT = $Ruta."generados/comprobantes_fir/".$ARCHIVO_XML;
					
						$bin = @base64_decode($Trama['XmlFirmado']);
						@file_put_contents($OUTPUT, $bin);	
						
					}
					
					if(!empty($Trama['ZIPRespuesta'])){
					
						$OUTPUT = $Ruta."generados/comprobantes_cdr/".$ARCHIVO_CDR;
					
						$bin = @base64_decode($Trama['ZIPRespuesta']);
						@file_put_contents($OUTPUT, $bin);	
						
					}
					
					
					echo "<br>";
					
					echo "Resultado: ".($l_stResult);
			
					echo "<br>";
					echo "<br>";
			


					
				}else{
				
					echo "CODIGO DE RESPUESTA: ".$Codigo;
					echo "<br>";
					
					
				}
				
			}else{
				
				echo $DatFactura->FacSunatRespuestaEnvioContenido;
				echo "<br>";
				
			}

		}else{
			
				
			echo "SE PROCESARA EL COMPROBANTE";
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
			
			$l_stResult = $l_oProxy->MtdProcesarFactura(json_encode($ComprobanteXML));
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
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioFecha",$Trama['FechaRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioHora",$Trama['HoraRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioCodigo",$Trama['CodigoRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioContenido",$Trama['MensajeRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsFactura->FacId,$InsFactura->FtaId);
			//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsFactura->FacId,$InsFactura->FtaId);
			
			//HISTORIAL OBSERVACIONES
			$Observaciones = $InsFactura->FacSunatRespuestaObservacion;
			$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaObservacion",$Observaciones,$InsFactura->FacId,$InsFactura->FtaId);
			//ULTIMO TICKET
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsFactura->FacSunatRespuestaTicket),$InsFactura->FacId,$InsFactura->FtaId);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaTicketEstado","",$InsFactura->FacId,$InsFactura->FtaId);
			//FIRMA
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsFactura->FacId,$InsFactura->FtaId);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsFactura->FacId,$InsFactura->FtaId);
			//ACCIONES
			$InsFactura->MtdEditarFacturaDato("FacSunatUltimaAccion","ALTA",$InsFactura->FacId,$InsFactura->FtaId);
			$InsFactura->MtdEditarFacturaDato("FacSunatUltimaRespuesta",$UltimaRespuesta,$InsFactura->FacId,$InsFactura->FtaId);
			
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