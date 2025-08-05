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

//$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"BolFechaEmision";
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


require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaTalonario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteVenta.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');


$InsBoleta1 = new ClsBoleta();
$InsVentaConcretada = new ClsVentaConcretada();
$InsComprobanteVenta = new ClsComprobanteVenta();
$InsSucursal = new ClsSucursal();
$InsMoneda = new ClsMoneda();

//MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL, $oSucursal=NULL,$oNoProcesdado=false) 
$ResBoleta = $InsBoleta1->MtdObtenerBoletas(NULL,NULL,NULL,"BolTiempoCreacion","DESC",$POST_Limite,"5",FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),NULL,NULL,NULL,$POST_Moneda,NULL,$POST_ClienteId,NULL,NULL,NULL,NULL,true,0);
$ArrBoletas = $ResBoleta['Datos'];


$EnlazarPendiente = 0;
$EnlazarRealizados = 0;

echo "BOLETAS ENCONTRADAS: ";
echo count($ArrBoletas);
echo "<br>";
echo "<br>";

$Ruta = "../";

$EnlazarPendiente = count($ArrBoletas);;

if(!empty($ArrBoletas)){	
	foreach($ArrBoletas as $DatBoleta){
		
		echo "<br>";
		echo "<h1>";
		echo "BOLETA ";
		echo "</h1>";
		echo "<br>";
		
		echo "BtaNumero: ";
		echo $DatBoleta->BtaNumero;
		echo "<br>";
		
		echo "BolId: ";
		echo $DatBoleta->BolId;
		echo "<br>";
		
		echo "BolFechaEmision: ";
		echo $DatBoleta->BolFechaEmision;;
		echo "<br>";
		
		echo "AmoId: ";
		echo $DatBoleta->AmoId;
		echo "<br>";
		
		echo "BolSunatRespuestaEnvioContenido: ";
		echo $DatBoleta->BolSunatRespuestaEnvioContenido;
		echo "<br>";
	
		echo "BolTiempoCreacion: ";
		echo $DatBoleta->BolTiempoCreacion;
		echo "<br>";
		echo "<br>";
	
		
			
			
		$InsBoleta = new ClsBoleta();	
		
		$InsBoleta->MtdBoletaGenerarArchivoXML($DatBoleta->BtaId,$DatBoleta->BolId,$Ruta.'generados/comprobantes_xml/');
		
		sleep(5);
				
		//Obteniendo datos de factura
		$InsBoleta->BolId = $DatBoleta->BolId;
		$InsBoleta->BtaId = $DatBoleta->BtaId;
		$InsBoleta->MtdObtenerBoleta();
		//
		//$InsBoleta->BolId=$InsBoleta->BolId;
		//$InsBoleta->BolId=(string)(int)$InsBoleta->BolId;
		//190.117.111.8
		$URL_LOCAL = $SistemaServidor2;
		$URL_REMOTO = $SistemaServidor3;
		$CARPETA = "SUNAT";
		$NOMBRE = $EmpresaCodigo."-03-".$InsBoleta->BtaNumero."-".$InsBoleta->BolId."";
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
		
		
			
		if(!empty($DatBoleta->BolSunatRespuestaEnvioContenido)){

	
			echo "SE REVISARA EL COMPROBANTE";
			echo "<br>";
			
						
			preg_match('/[0-9]{4}/', $DatBoleta->BolSunatRespuestaEnvioContenido,$Auxiliar);
			
			//deb($Auxiliar);
			
			if(!empty($Auxiliar)){
				
				$Codigo = $Auxiliar[0];
				
				if($Codigo == "1033"){
					
											
											//
						//$InsBoleta->BolId=$InsBoleta->BolId;
						//$InsBoleta->BolId=(string)(int)$InsBoleta->BolId;
						//190.117.111.8
						//$URL_LOCAL = "190.117.157.125";
						//$URL_LOCAL = $SistemaServidor2;
						$URL_LOCAL = $SistemaServidor2;
						$URL_REMOTO = $SistemaServidor3;
						$CARPETA = "SUNAT";
						$CARPETA_LOCAL = "sistema";
						$NOMBRE = $EmpresaCodigo."-03-".$InsBoleta->BtaNumero."-".$InsBoleta->BolId."";
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
						
						$wsdl = 'http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl' ;
						
						
						$l_oClient = new nusoap_client($wsdl,'wsdl');
						
						$l_oProxy = $l_oClient->getProxy();
						
						$err = $l_oClient->getError();
							
						if ($err) {
							echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
						}
						
						$ComprobanteXML['CDRRUC'] = $EmpresaCodigo;
						$ComprobanteXML['CDRTipoComprobante'] = "03";
						$ComprobanteXML['CDRSerie'] = $InsBoleta->BtaNumero;
						$ComprobanteXML['CDRNumero'] = $InsBoleta->BolId;
						$ComprobanteXML['CDRXMLNombre'] = $NOMBRE;
						
						$l_stResult = $l_oProxy->MtdConsultarCDR(json_encode($ComprobanteXML));
						$l_stResult = eregi_replace("'","\"",$l_stResult);
						$l_stResult = utf8_encode($l_stResult);
						
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
						
						//if($Trama['CodigoRespuesta']=="000"){
						//	$UltimaRespuesta = "APROBADO";
						//}else{
						//
						//	$CodigoRespuesta = $Trama['CodigoRespuesta'] + 1 - 1;
						//
						//	if($CodigoRespuesta>= 100 and $CodigoRespuesta <=1999){
						//		$UltimaRespuesta = "EXCEPCION";
						//	}else if($CodigoRespuesta>= 2000 and $CodigoRespuesta <=3999){
						//		$UltimaRespuesta = "RECHAZO";	
						//	}else if($CodigoRespuesta>= 4000){
						//		$UltimaRespuesta = "OBSERVADO";	
						//	}else{
						//		$UltimaRespuesta = "ERROR";
						//	}
						//
						//}
						
						
						
						
						$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
						$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioFecha",$Trama['FechaRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
						$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioHora",$Trama['HoraRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
						
						$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioCodigo",$Trama['CodigoRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
						$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioContenido",$Trama['MensajeRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
						$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsBoleta->BolId,$InsBoleta->BtaId);
						$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsBoleta->BolId,$InsBoleta->BtaId);
						
						$Observaciones = $InsBoleta->BolSunatRespuestaObservacion;
						$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
						
						$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaObservacion",$Observaciones,$InsBoleta->BolId,$InsBoleta->BtaId);
						$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsBoleta->BolSunatRespuestaTicket),$InsBoleta->BolId,$InsBoleta->BtaId);
						$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaTicketEstado","",$InsBoleta->BolId,$InsBoleta->BtaId);
						
						$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsBoleta->BolId,$InsBoleta->BtaId);
						$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsBoleta->BolId,$InsBoleta->BtaId);
						$InsBoleta->MtdEditarBoletaDato("BolSunatUltimaActividad","ALTA",$InsBoleta->BolId,$InsBoleta->BtaId);
						$InsBoleta->MtdEditarBoletaDato("BolSunatUltimaRespuesta",$UltimaRespuesta,$InsBoleta->BolId,$InsBoleta->BtaId);
				
						
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
				
				echo $DatBoleta->BolSunatRespuestaEnvioContenido;
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
				
				$l_stResult = $l_oProxy->MtdProcesarBoleta(json_encode($ComprobanteXML));
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
				$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
				$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioFecha",$Trama['FechaRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
				$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioHora",$Trama['HoraRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
				$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioCodigo",$Trama['CodigoRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
				$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioContenido",$Trama['MensajeRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
				$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsBoleta->BolId,$InsBoleta->BtaId);
				//$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsBoleta->BolId,$InsBoleta->BtaId);
				
				//HISTORIAL OBSERVACIONES
				$Observaciones = $InsBoleta->BolSunatRespuestaObservacion;
				$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
				$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaObservacion",$Observaciones,$InsBoleta->BolId,$InsBoleta->BtaId);
				//ULTIMO TICKET
				$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsBoleta->BolSunatRespuestaTicket),$InsBoleta->BolId,$InsBoleta->BtaId);
				$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaTicketEstado","",$InsBoleta->BolId,$InsBoleta->BtaId);
				//FIRMA
				$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsBoleta->BolId,$InsBoleta->BtaId);
				$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsBoleta->BolId,$InsBoleta->BtaId);
				//ACCIONES
				$InsBoleta->MtdEditarBoletaDato("BolSunatUltimaAccion","ALTA",$InsBoleta->BolId,$InsBoleta->BtaId);
				$InsBoleta->MtdEditarBoletaDato("BolSunatUltimaRespuesta",$UltimaRespuesta,$InsBoleta->BolId,$InsBoleta->BtaId);
				
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