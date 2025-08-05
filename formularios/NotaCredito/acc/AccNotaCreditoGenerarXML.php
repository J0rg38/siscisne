<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsNotaCredito = new ClsNotaCredito();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsNotaCredito->NcrId = $GET_id;
$InsNotaCredito->NctId = $GET_ta;
$InsNotaCredito->MtdObtenerNotaCredito();

//deb($InsNotaCredito->NcrTipoCambio);
if($InsNotaCredito->MonId<>$EmpresaMonedaId){
	
	$InsNotaCredito->NcrTotalGravado = round($InsNotaCredito->NcrTotalGravado/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalExonerado = round($InsNotaCredito->NcrTotalExonerado/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalGratuito = round($InsNotaCredito->NcrTotalGratuito/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalDescuento = round($InsNotaCredito->NcrTotalDescuento/$InsNotaCredito->NcrTipoCambio,2);

	
	$InsNotaCredito->NcrTotalPagar = round($InsNotaCredito->NcrTotalPagar/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalDescuento = round($InsNotaCredito->NcrTotalDescuento/$InsNotaCredito->NcrTipoCambio,2);
	
	$InsNotaCredito->NcrSubTotal = round($InsNotaCredito->NcrSubTotal/$InsNotaCredito->NcrTipoCambio,2);	
	$InsNotaCredito->NcrImpuesto = round($InsNotaCredito->NcrImpuesto/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotal = round($InsNotaCredito->NcrTotal/$InsNotaCredito->NcrTipoCambio,2);	
	
}
$InsNotaCredito->CliNombre = trim($InsBoleta->CliNombre);
$InsNotaCredito->CliApellidoPaterno = trim($InsBoleta->CliApellidoPaterno);
$InsNotaCredito->CliApellidoMaterno = trim($InsBoleta->CliApellidoMaterno);



$InsNotaCredito->NcrTotal = round($InsNotaCredito->NcrTotal,2);
list($parte_entero,$parte_decimal) = explode(".",$InsNotaCredito->NcrTotal);

if(empty($parte_decimal)){
	$parte_decimal = 0;
}

$parte_decimal = str_pad($parte_decimal, 2, "0", STR_PAD_RIGHT);

$numalet= new CNumeroaletra;
$numalet->setNumero($parte_entero);
$numalet->setMayusculas(1);
$numalet->setGenero(1);
$numalet->setMoneda("");
$numalet->setPrefijo("");
$numalet->setSufijo("");

$NotaCreditoTotalLetras = "SON ".$numalet->letra()." CON ".$parte_decimal."/100 ".$InsNotaCredito->MonNombre;


$NOMBRE = $EmpresaCodigo.'-07-'.$InsNotaCredito->NctNumero.'-'.$InsNotaCredito->NcrId;
$ARCHIVO = $NOMBRE.'.xml';


$domtree = new DOMDocument('1.0', 'ISO-8859-1');
//$domtree->preserveWhiteSpace = false;
$domtree->formatOutput = true;
$domtree->xmlStandalone = false;

/* create the root element of the xml tree */
$xmlRoot = $domtree->createElement("CreditNote");
/* append it to the document created */
$xmlRoot = $domtree->appendChild($xmlRoot);

$xmlRoot->setAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2');
$xmlRoot->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
$xmlRoot->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
$xmlRoot->setAttribute('xmlns:ccts', 'urn:un:unece:uncefact:documentation:2');
$xmlRoot->setAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
$xmlRoot->setAttribute('xmlns:ext', 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2');
$xmlRoot->setAttribute('xmlns:qdt', 'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2');
$xmlRoot->setAttribute('xmlns:sac', 'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1');
$xmlRoot->setAttribute('xmlns:udt', 'urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2');
$xmlRoot->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

//ext:UBLExtensions
$UBLExtensions = $domtree->createElement("ext:UBLExtensions");
$UBLExtensions = $xmlRoot->appendChild($UBLExtensions);



if(!empty($InsNotaCredito->OvvId)){
		
		
	//ext:UBLExtension3
	$UBLExtension3 = $domtree->createElement("ext:UBLExtension");
	$UBLExtension3 = $UBLExtensions->appendChild($UBLExtension3);
	
	//sac:ExtensionContent3
	$ExtensionContent3 = $domtree->createElement("ext:ExtensionContent");
	$ExtensionContent3 = $UBLExtension3->appendChild($ExtensionContent3);
	
		//DatosAdicionales
		$DatosAdicionales = $domtree->createElement("DatosAdicionales");
		$DatosAdicionales = $ExtensionContent3->appendChild($DatosAdicionales);
	
			//if(!empty($InsNotaCredito->NcrDatoAdicional1)){
//
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","01");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional1);
//					$Valor = $DatoAdicional->appendChild($Valor);
//	
//				
//			}
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional2)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","02");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional2);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//				
//		if(!empty($InsNotaCredito->NcrDatoAdicional3)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","03");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional3);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional4)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","04");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional4);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional5)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","05");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional5);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//				
//			if(!empty($InsNotaCredito->NcrDatoAdicional6)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","06");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional6);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional7)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","07");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional7);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional8)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","08");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional8);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional9)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","09");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional9);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional10)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","10");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional10);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional11)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","11");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional11);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional12)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","12");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional12);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional13)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","13");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional13);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional14)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","14");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional14);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional15)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","15");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional15);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional16)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","16");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional16);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional17)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","17");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional17);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional18)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","18");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional18);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional19)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","19");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional19);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional20)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","20");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional20);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional21)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","21");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional21);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional122)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","22");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional22);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaCredito->NcrDatoAdicional23)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","23");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional23);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
			

			if(count($InsNotaCredito->OrdenVentaVehiculoPropietario)>1){
			
				$Propietarios = "";
			
				foreach($InsNotaCredito->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
					if($InsNotaCredito->CliId<> $DatOrdenVentaVehiculoPropietario->CliId){
			
						$Propietarios .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." ".$DatOrdenVentaVehiculoPropietario->CliNombre."".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno."";		
						
						if(count($InsNotaCredito->OrdenVentaVehiculoPropietario)-1!=$i){
							$Propietarios .= " * ";
						}
						
						$i++;
			
					}			
				}		
				
				//DatoAdicional
				$DatoAdicional = $domtree->createElement("DatoAdicional");
				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
			
					//DatosAdicionales
					$Codigo = $domtree->createElement("Codigo","24");
					$Codigo = $DatoAdicional->appendChild($Codigo);
					
					$Valor = $domtree->createElement("Valor",$Propietarios);
					$Valor = $DatoAdicional->appendChild($Valor);	
			
			}


			if(!empty($InsNotaCredito->NcrDatoAdicional25)){	
			
				//DatoAdicional
				$DatoAdicional = $domtree->createElement("DatoAdicional");
				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);

					//DatosAdicionales
					$Codigo = $domtree->createElement("Codigo","25");
					$Codigo = $DatoAdicional->appendChild($Codigo);
					
					$Valor = $domtree->createElement("Valor",$InsNotaCredito->NcrDatoAdicional25);
					$Valor = $DatoAdicional->appendChild($Valor);
				
			}
				
}


//ext:UBLExtension1
$UBLExtension1 = $domtree->createElement("ext:UBLExtension");
$UBLExtension1 = $UBLExtensions->appendChild($UBLExtension1);

//sac:ExtensionContent1
$ExtensionContent1 = $domtree->createElement("ext:ExtensionContent");
$ExtensionContent1 = $UBLExtension1->appendChild($ExtensionContent1);

//sac:AdditionalInformation
$AdditionalInformation = $domtree->createElement("sac:AdditionalInformation");
$AdditionalInformation = $ExtensionContent1->appendChild($AdditionalInformation);

///'cbc:ID','1001'	//TOTAL VENTAS GRAVADAS
//sac:AdditionalMonetaryTotal
$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1001'));

//sac:PayableAmount
$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsNotaCredito->NcrImpuesto,2, '.', ''));
$PayableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);

//ext:UBLExtension2
$UBLExtension2 = $domtree->createElement("ext:UBLExtension");
$UBLExtension2 = $UBLExtensions->appendChild($UBLExtension2);

//sac:ExtensionContent2
$ExtensionContent2 = $domtree->createElement("ext:ExtensionContent");
$ExtensionContent2 = $UBLExtension2->appendChild($ExtensionContent2);

//ext:UBLVersionID
$UBLVersionID = $domtree->createElement("cbc:UBLVersionID","2.0");
$UBLVersionID = $xmlRoot->appendChild($UBLVersionID);

//ext:CustomizationID
$CustomizationID = $domtree->createElement("cbc:CustomizationID","1.0");
$CustomizationID = $xmlRoot->appendChild($CustomizationID);

//cbc:ID
$ID = $domtree->createElement("cbc:ID",$InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId);
$ID = $xmlRoot->appendChild($ID);

//cbc:IssueDate
$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($InsNotaCredito->NcrFechaEmision));
$IssueDate = $xmlRoot->appendChild($IssueDate);

//cbc:DocumentCurrencyCode
$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsNotaCredito->MonSigla);
$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);

//cbc:DiscrepancyResponse
$DiscrepancyResponse = $domtree->createElement("cac:DiscrepancyResponse");
$DiscrepancyResponse = $xmlRoot->appendChild($DiscrepancyResponse);

	//cbc:ReferenceID
	$ReferenceID = $domtree->createElement("cbc:ReferenceID",$InsNotaCredito->DtaNumero."-".$InsNotaCredito->DocId);
	$ReferenceID = $DiscrepancyResponse->appendChild($ReferenceID);
	
	//cac:ResponseCode
	$ResponseCode = $domtree->createElement("cbc:ResponseCode",$InsNotaCredito->NcrMotivoCodigo);
	$ResponseCode = $DiscrepancyResponse->appendChild($ResponseCode);
	
	//cac:ResponseCode
	//$ResponseCode = $domtree->createElement("cbc:Description",$InsNotaCredito->ScaNombre);
	$ResponseCode = $domtree->createElement("cbc:Description",$InsNotaCredito->NcrMotivo);
	$ResponseCode = $DiscrepancyResponse->appendChild($ResponseCode);

//cbc:BillingReference
$BillingReference = $domtree->createElement("cac:BillingReference");
$BillingReference = $xmlRoot->appendChild($BillingReference);

	//cac:InvoiceDocumentReference
	$InvoiceDocumentReference = $domtree->createElement("cac:InvoiceDocumentReference");
	$InvoiceDocumentReference = $BillingReference->appendChild($InvoiceDocumentReference);
	
		//cac:ResponseCode
		$ID = $domtree->createElement("cbc:ID",$InsNotaCredito->DtaNumero."-".$InsNotaCredito->DocId);
		$ID = $InvoiceDocumentReference->appendChild($ID);
		
		switch($InsNotaCredito->NcrTipo){
			
			case "2": //FACTURA
		
				//cac:DocumentTypeCode
				$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode","01");
				$DocumentTypeCode = $InvoiceDocumentReference->appendChild($DocumentTypeCode);
					
			break;
			
			case "3"://BOLETA
				//cac:DocumentTypeCode
				$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode","03");
				$DocumentTypeCode = $InvoiceDocumentReference->appendChild($DocumentTypeCode);
				
			break;
			
		}
	
	//cac:Signature
	$Signature = $domtree->createElement("cac:Signature");
	$Signature = $xmlRoot->appendChild($Signature);
		
		//cbc:ID
		$ID = $domtree->createElement("cbc:ID","IDSignSP");
		$ID = $Signature->appendChild($ID);
		
		//cac:SignatoryParty
		$SignatoryParty = $domtree->createElement("cac:SignatoryParty");
		$SignatoryParty = $Signature->appendChild($SignatoryParty);
		
			//cac:PartyIdentification
			$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
			$PartyIdentification = $SignatoryParty->appendChild($PartyIdentification);

				//cbc:ID
				$ID = $domtree->createElement("cbc:ID",$EmpresaCodigo);
				$ID = $PartyIdentification->appendChild($ID);
			
				//cac:PartyName
				$base = $SignatoryParty->appendChild($domtree->createElement( 'cac:PartyName' ));
				
				//cac:Name		
				$name = $base->appendChild($domtree->createElement('cbc:Name')); 
				$name->appendChild($domtree->createCDATASection( $EmpresaNombre )); 
	
		//cbc:ID
		$DigitalSignatureAttachment = $domtree->createElement("cac:DigitalSignatureAttachment");
		$DigitalSignatureAttachment = $Signature->appendChild($DigitalSignatureAttachment);
	
			//cac:ExternalReference
			$ExternalReference = $domtree->createElement("cac:ExternalReference");
			$ExternalReference = $DigitalSignatureAttachment->appendChild($ExternalReference);

				//cbc:URI
				$URI = $domtree->createElement("cbc:URI","#SignatureSP");
				$URI = $ExternalReference->appendChild($URI);

	//situacion
	//cac:AccountingSupplierParty
	$AccountingSupplierParty = $domtree->createElement("cac:AccountingSupplierParty");
	$AccountingSupplierParty = $xmlRoot->appendChild($AccountingSupplierParty);
	
		//cbc:CustomerAssignedAccountID
		$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$EmpresaCodigo);
		$CustomerAssignedAccountID = $AccountingSupplierParty->appendChild($CustomerAssignedAccountID);
		
		//cbc:AdditionalAccountID
		$AdditionalAccountID = $domtree->createElement("cbc:AdditionalAccountID","6");
		$AdditionalAccountID = $AccountingSupplierParty->appendChild($AdditionalAccountID);
	
		//cac:Party
		$Party = $domtree->createElement("cac:Party");
		$Party = $AccountingSupplierParty->appendChild($Party);
		
			//cac:PartyLegalEntity
			$PartyName = $Party->appendChild($domtree->createElement( 'cac:PartyName' ));
			
			//cac:Name		
			$Name = $PartyName->appendChild($domtree->createElement('cbc:Name')); 
			$Name->appendChild($domtree->createCDATASection( $EmpresaNombre)); 
	
			//cac:PostalAddress
			$PostalAddress = $domtree->createElement("cac:PostalAddress");
			$PostalAddress = $Party->appendChild($PostalAddress);
	
				//cbc:ID
				$ID = $domtree->createElement("cbc:ID","220101");
				$ID = $PostalAddress->appendChild($ID);
	
				//cbc:StreetName
				$StreetName = $domtree->createElement("cbc:StreetName",$EmpresaDireccion);
				$StreetName = $PostalAddress->appendChild($StreetName);
	
	//			cbc:CitySubdivisionName
	//			$CitySubdivisionName = $domtree->createElement("cbc:CitySubdivisionName","");
	//			$CitySubdivisionName = $PostalAddress->appendChild($CitySubdivisionName);
	//			
	//			//cbc:CityName
	//			$CityName = $domtree->createElement("cbc:CityName",$EmpresaDepartamento);
	//			$CityName = $PostalAddress->appendChild($CityName);
	//
	//
	//			//cbc:CountrySubentity
	//			$CountrySubentity = $domtree->createElement("cbc:CountrySubentity",$EmpresaProvincia);
	//			$CountrySubentity = $PostalAddress->appendChild($CountrySubentity);
	
				//cbc:District
				$District = $domtree->createElement("cbc:District",$EmpresaDistrito);
				$District = $PostalAddress->appendChild($District);
				
				//cac:Country
				$Country = $domtree->createElement("cac:Country");
				$Country = $PostalAddress->appendChild($Country);
				
				//cbc:IdentificationCode
				$IdentificationCode = $domtree->createElement("cbc:IdentificationCode","PE");
				$IdentificationCode = $Country->appendChild($IdentificationCode);
	
			/*//cac:PartyLegalEntity
			$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
			$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);
	*/
				
				
			//cac:PartyLegalEntity
			$base = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
			
			//cac:Name		
			$name = $base->appendChild($domtree->createElement('cbc:RegistrationName')); 
			$name->appendChild($domtree->createCDATASection( $EmpresaNombre)); 
			
				
	
	
	//cac:AccountingCustomerParty
	$AccountingCustomerParty = $domtree->createElement("cac:AccountingCustomerParty");
	$AccountingCustomerParty = $xmlRoot->appendChild($AccountingCustomerParty);
	
		//cbc:CustomerAssignedAccountID
		$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$InsNotaCredito->CliNumeroDocumento);
		$CustomerAssignedAccountID = $AccountingCustomerParty->appendChild($CustomerAssignedAccountID);
		
		
		//cbc:AdditionalAccountID
		$AdditionalAccountID = $domtree->createElement("cbc:AdditionalAccountID",round($InsNotaCredito->TdoCodigo,0));
		$AdditionalAccountID = $AccountingCustomerParty->appendChild($AdditionalAccountID);
	
		//cac:Party
		$Party = $domtree->createElement("cac:Party");
		$Party = $AccountingCustomerParty->appendChild($Party);
		
			//cac:PhysicalLocation
			$PhysicalLocation = $Party->appendChild($domtree->createElement( 'cac:PhysicalLocation' ));
			
			//cac:Name		
			$Description = $PhysicalLocation->appendChild($domtree->createElement('cbc:Description')); 
			$Description->appendChild($domtree->createCDATASection( $InsNotaCredito->NcrDireccion )); 
			
			 //cac:PartyLegalEntity
			$PartyLegalEntity = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
			
			//cac:Name		
			$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
			$RegistrationName->appendChild($domtree->createCDATASection( $InsNotaCredito->CliNombre." ".$InsNotaCredito->CliApellidoPaterno." ".$InsNotaCredito->CliApellidoMaterno )); 
			
				
				
	 
	//cac:TaxTotal
	$TaxTotal = $domtree->createElement("cac:TaxTotal");
	$TaxTotal = $xmlRoot->appendChild($TaxTotal);
	
		//cbc:TaxAmount
		$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsNotaCredito->NcrImpuesto,2, '.', ''));
		$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
		$TaxAmount = $TaxTotal->appendChild($TaxAmount);
				
				
		//cac:TaxSubtotal
		$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
		$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
			
			//cbc:TaxAmount 
			$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsNotaCredito->NcrImpuesto,2, '.', ''));
			$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
			$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
			
			
			//cac:TaxCategory
			$TaxCategory = $domtree->createElement("cac:TaxCategory");
			$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
				
				//cac:TaxScheme
				$TaxScheme = $domtree->createElement("cac:TaxScheme");
				$TaxScheme = $TaxCategory->appendChild($TaxScheme);
	
					//cbc:ID
					$ID = $domtree->createElement("cbc:ID","1000");
					$ID = $TaxScheme->appendChild($ID);
					
					//cbc:Name
					$Name = $domtree->createElement("cbc:Name","IGV");
					$Name = $TaxScheme->appendChild($Name);
					
					//cbc:TaxTypeCode
					$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","VAT");
					$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
	
	
	
	
	 
	//cac:LegalMonetaryTotal
	$LegalMonetaryTotal = $domtree->createElement("cac:LegalMonetaryTotal");
	$LegalMonetaryTotal = $xmlRoot->appendChild($LegalMonetaryTotal);
	
	
		//cbc:PayableAmount currencyID="PEN"
		$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsNotaCredito->NcrTotal,2, '.', ''));
		$PayableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
		$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);
	
	
	$fila = 1;
	if(!empty($InsNotaCredito->NotaCreditoDetalle)){
		foreach($InsNotaCredito->NotaCreditoDetalle as $DatNotaCreditoDetalle){
			
			if($InsNotaCredito->MonId<>$EmpresaMonedaId){
				
				$DatNotaCreditoDetalle->NcdValorVenta = round($DatNotaCreditoDetalle->NcdValorVenta/$InsNotaCredito->NcrTipoCambio,2);
				$DatNotaCreditoDetalle->NcdValorVentaUnitario = round($DatNotaCreditoDetalle->NcdValorVentaUnitario/$InsNotaCredito->NcrTipoCambio,2);
				
				$DatNotaCreditoDetalle->NcdPrecio = round($DatNotaCreditoDetalle->NcdPrecio/$InsNotaCredito->NcrTipoCambio,2);
				$DatNotaCreditoDetalle->NcdImpuesto = round($DatNotaCreditoDetalle->NcdValorVenta/$InsNotaCredito->NcrTipoCambio,2);
				
			}
			
			//cac:InvoiceLine
			$InvoiceLine = $domtree->createElement("cac:CreditNoteLine");
			$InvoiceLine = $xmlRoot->appendChild($InvoiceLine);	
				
				//cbc:ID
				$ID = $domtree->createElement("cbc:ID",$fila);
				$ID = $InvoiceLine->appendChild($ID);	
				
				//cbc:CreditedQuantity unitCode="NIU"
				$CreditedQuantity = $domtree->createElement("cbc:CreditedQuantity",number_format($DatNotaCreditoDetalle->NcdCantidad,2, '.', ''));
				$CreditedQuantity->setAttribute('unitCode', 'NIU');
				$CreditedQuantity = $InvoiceLine->appendChild($CreditedQuantity);	
				
				//cbc:LineExtensionAmount currencyID="PEN"
				$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount",number_format($DatNotaCreditoDetalle->NcdValorVenta,2, '.', ''));
				$LineExtensionAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
				$LineExtensionAmount = $InvoiceLine->appendChild($LineExtensionAmount);	
					
				//cac:PricingReference
				$PricingReference = $domtree->createElement("cac:PricingReference");
				$PricingReference = $InvoiceLine->appendChild($PricingReference);	
					
	//					//cac:AlternativeConditionPrice
	//					$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
	//					$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);	
	//				
	//						//cbc:PriceAmount currencyID="PEN"
	//						$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaCreditoDetalle->NcdPrecio,2, '.', ''));
	//						$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
	//						$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	//						
	//						//cbc:PriceTypeCode
	//						$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
	//						$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);	
	
							if($DatNotaCreditoDetalle->NcdGratuito==1){
								
								//cac:AlternativeConditionPrice
								$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
								$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
								
								//cbc:PriceAmount currencyID="PEN"
								$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
								$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
								$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	
								//cbc:PriceTypeCode
								$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
								$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
	
								//cac:AlternativeConditionPrice
								$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
								$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
	
								//cbc:PriceAmount currencyID="PEN"
								$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaCreditoDetalle->NcdValorVentaUnitario,2, '.', ''));
								$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
								$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	
								//cbc:PriceTypeCode
								$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","02");
								$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
	
	//							cac:AlternativeConditionPrice
	//							$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
	//							$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
	//							
	//							//cbc:PriceAmount currencyID="PEN"
	//							$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaCreditoDetalle->NcdPrecio,2, '.', ''));
	//							$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
	//							$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	//
	//							//cbc:PriceTypeCode
	//							$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
	//							$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
							
								
							}else if($DatNotaCreditoDetalle->NcdGratuito==2){
								
								//cac:AlternativeConditionPrice
								$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
								$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
								
								//cbc:PriceAmount currencyID="PEN"
								$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaCreditoDetalle->NcdPrecio,2, '.', ''));
								$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
								$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	
								//cbc:PriceTypeCode
	
								$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
								$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
							
								
							}else{
								
								//cac:AlternativeConditionPrice
								$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
								$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
								
								//cbc:PriceAmount currencyID="PEN"
								$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
								$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
								$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
								
								//cbc:PriceTypeCode
								$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","00");
								$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
								
							}
				
				//cac:TaxTotal
				$TaxTotal = $domtree->createElement("cac:TaxTotal");
				$TaxTotal = $InvoiceLine->appendChild($TaxTotal);	
				
				//	//cbc:TaxAmount currencyID="PEN"
	//				$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaCreditoDetalle->NcdImpuesto,2, '.', ''));
	//				$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
	//				$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
				
					if($DatNotaCreditoDetalle->NcdGratuito == "2"){
						
					//cbc:TaxAmount currencyID="PEN"
					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaCreditoDetalle->NcdImpuesto,2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
					$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
						
				}else if($DatNotaCreditoDetalle->NcdGratuito == "1"){
						
					//cbc:TaxAmount currencyID="PEN"
					$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
					$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
					$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
	
					//$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaCreditoDetalle->NcdImpuesto,2, '.', ''));
	//				$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
	//				$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
					
						
				}else{
						
					//cbc:TaxAmount currencyID="PEN"
					$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
					$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
					$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
						
				}
				
					//cac:TaxSubtotal
					$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
					$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);	
					
						////cbc:TaxAmount currencyID="PEN"
	//					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaCreditoDetalle->NcdImpuesto,2, '.', ''));
	//					$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
	//					$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);	
	
						if($DatNotaCreditoDetalle->NcdGratuito == "2"){
	
							//cbc:TaxAmount currencyID="PEN"
							$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaCreditoDetalle->NcdImpuesto,2, '.', ''));
							$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
							$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);		
							
						}else if($DatNotaCreditoDetalle->NcdGratuito == "1"){
		
							//cbc:TaxAmount currencyID="PEN"
							$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
							$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
							$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);	
							
							//$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaCreditoDetalle->NcdImpuesto,2, '.', ''));
							//$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
							//$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);		
							
						}else{
							
							//cbc:TaxAmount currencyID="PEN"
							$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
							$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
							$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);	
							
						}
						
						//cbc:TaxAmount currencyID="PEN"
						$Percent = $domtree->createElement("cbc:Percent",($InsNotaCredito->NcrPorcentajeImpuestoVenta));
						$Percent = $TaxSubtotal->appendChild($Percent);	
					
						//cac:TaxCategory
						$TaxCategory = $domtree->createElement("cac:TaxCategory");
						$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);	
							
							//cbc:TaxExemptionReasonCode
							//$ID = $domtree->createElement("cbc:ID",$DatNotaCreditoDetalle->NcdId);
							//$ID = $TaxCategory->appendChild($ID);
							
							//cbc:TaxExemptionReasonCode
							//$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","10");
							//$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
							
									if($DatNotaCreditoDetalle->NcdExonerado == "1"){//20
									  
									  if($DatNotaCreditoDetalle->NcdGratuito == "1"){//20
																	
										  $TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","21");
										  $TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
										  
									  }else{
										  
										  $TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","20");
										  $TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
										  
									  }
									  
								  
								  }else if($DatNotaCreditoDetalle->NcdExonerado == "2"){//10
									  
									  if($DatNotaCreditoDetalle->NcdGratuito == "1"){//20
										
										$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","11");
										$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
										//$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","10");
										//$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
									  
									  }else{
										  
										  $TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","10");
										  $TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
										  
									  }
									  
								  }else{
									  
									  $TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","00");
									  $TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
									  
								  }
							
								//cac:TaxScheme
								$TaxScheme = $domtree->createElement("cac:TaxScheme");
								$TaxScheme = $TaxCategory->appendChild($TaxScheme);
								
									//cbc:ID
									$ID = $domtree->createElement("cbc:ID","1000");
									$ID = $TaxScheme->appendChild($ID);
															
									//cbc:Name
									$Name2 = $domtree->createElement("cbc:Name","IGV");
									$Name2 = $TaxScheme->appendChild($Name2);
									
									//cbc:TaxTypeCode
									$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","VAT");
									$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
	
				//cac:Item
				$Item = $domtree->createElement("cac:Item");
				$Item = $InvoiceLine->appendChild($Item);	
	
					//cac:PartyName
						$Description = $domtree->createElement("cbc:Description");
						$Description = $Item->appendChild($Description);
	
						$Description->appendChild($domtree->createCDATASection($DatNotaCreditoDetalle->NcdDescripcion )); 
						
						
						
						
						if(!empty($InsNotaCredito->NcrDatoAdicional1)){
							
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("MARCA: ".$InsNotaCredito->NcrDatoAdicional1 )); 
					
						}
						
						if(!empty($InsNotaCredito->NcrDatoAdicional2)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("TRACCION: ".$InsNotaCredito->NcrDatoAdicional2 )); 
							
						}
							
						if(!empty($InsNotaCredito->NcrDatoAdicional3)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("MODELO: ".$InsNotaCredito->NcrDatoAdicional3 )); 
							
						}
						
						if(!empty($InsNotaCredito->NcrDatoAdicional4)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("CARROCERIA: ".$InsNotaCredito->NcrDatoAdicional4 ));
							
						}
						
						
						if(!empty($InsNotaCredito->NcrDatoAdicional5)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("AÑO FABRIC.: ".$InsNotaCredito->NcrDatoAdicional5 ));
							
						}
							
						if(!empty($InsNotaCredito->NcrDatoAdicional6)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("NO. PUERTAS: ".$InsNotaCredito->NcrDatoAdicional6 ));
							
						}
						
						if(!empty($InsNotaCredito->NcrDatoAdicional7)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("NO. MOTOR: ".$InsNotaCredito->NcrDatoAdicional7 ));
							
						}
						
						
						if(!empty($InsNotaCredito->NcrDatoAdicional8)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("COMBUSTIBLE: ".$InsNotaCredito->NcrDatoAdicional8 ));
							
						}
						
						if(!empty($InsNotaCredito->NcrDatoAdicional9)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("NO. CILINDROS: ".$InsNotaCredito->NcrDatoAdicional9 ));
							
						}
						
						if(!empty($InsNotaCredito->NcrDatoAdicional10)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("PESO BRUTO: ".$InsNotaCredito->NcrDatoAdicional10 ));
							
						}
						
						if(!empty($InsNotaCredito->NcrDatoAdicional11)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("NO. EJES: ".$InsNotaCredito->NcrDatoAdicional11 ));
							
						}
						
						if(!empty($InsNotaCredito->NcrDatoAdicional12)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("CARGA UTIL: ".$InsNotaCredito->NcrDatoAdicional12 ));
							
						}
						
						
						if(!empty($InsNotaCredito->NcrDatoAdicional13)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("NO. CHASIS: ".$InsNotaCredito->NcrDatoAdicional13 ));
							
						}
						
						if(!empty($InsNotaCredito->NcrDatoAdicional14)){	
						//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("PESO SECO: ".$InsNotaCredito->NcrDatoAdicional14 ));
							
						}
						
						
						if(!empty($InsNotaCredito->NcrDatoAdicional15)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("COLOR: ".$InsNotaCredito->NcrDatoAdicional15 ));
							
						}
						
						
						if(!empty($InsNotaCredito->NcrDatoAdicional16)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("ALTO: ".$InsNotaCredito->NcrDatoAdicional16 ));
							
						}
						
						if(!empty($InsNotaCredito->NcrDatoAdicional17)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("CILINDRADA: ".$InsNotaCredito->NcrDatoAdicional17 ));
							
						}
						
						
						if(!empty($InsNotaCredito->NcrDatoAdicional18)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("LARGO: ".$InsNotaCredito->NcrDatoAdicional18 ));
							
						}
						
						if(!empty($InsNotaCredito->NcrDatoAdicional19)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("NO. ASIENTOS: ".$InsNotaCredito->NcrDatoAdicional19 ));
							
						}
						
						
						if(!empty($InsNotaCredito->NcrDatoAdicional20)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("ANCHO: ".$InsNotaCredito->NcrDatoAdicional20 ));
							
						}
						
						
						if(!empty($InsNotaCredito->NcrDatoAdicional21)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("CAP. PASAJEROS: ".$InsNotaCredito->NcrDatoAdicional21 ));
							
						}
						
						if(!empty($InsNotaCredito->NcrDatoAdicional122)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("DIST. EJES: ".$InsNotaCredito->NcrDatoAdicional122 ));
							
						}
						
						
						if(!empty($InsNotaCredito->NcrDatoAdicional23)){	
						
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);

							$Description->appendChild($domtree->createCDATASection("NO. POLIZA: ".$InsNotaCredito->NcrDatoAdicional23 ));
							
						}
						
						
						
						
					//cac:SellersItemIdentification		
					$SellersItemIdentification = $domtree->createElement("cac:SellersItemIdentification");
					$SellersItemIdentification = $Item->appendChild($SellersItemIdentification);
	
						$ID = $domtree->createElement("cbc:ID");
						$ID = $SellersItemIdentification->appendChild($ID);
						$ID->appendChild($domtree->createCDATASection($DatNotaCreditoDetalle->NcdCodigo )); 
	
				//cac:Price
				$Price = $domtree->createElement("cac:Price");
				$Price = $InvoiceLine->appendChild($Price);	
	
					////cbc:PriceAmount currencyID="PEN"
	//				$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaCreditoDetalle->NcdPrecio,2, '.', ''));
	//				$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
	//				$PriceAmount = $Price->appendChild($PriceAmount);	
	
	
					if($DatNotaCreditoDetalle->NcdGratuito==1){
						
						//cbc:PriceAmount currencyID="PEN"
						$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
						$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$PriceAmount = $Price->appendChild($PriceAmount);	
						//$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaCreditoDetalle->NcdValorVentaUnitario,2, '.', ''));
						//$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						//$PriceAmount = $Price->appendChild($PriceAmount);	
						
					}elseif($DatNotaCreditoDetalle->NcdGratuito==2){
						
						//cbc:PriceAmount currencyID="PEN"
						$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaCreditoDetalle->NcdValorVentaUnitario,2, '.', ''));
						$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$PriceAmount = $Price->appendChild($PriceAmount);	
						
					}else{
						
						//cbc:PriceAmount currencyID="PEN"
						$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
						$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$PriceAmount = $Price->appendChild($PriceAmount);	
							
					}
			
			$fila++;
		}
	}

if(file_exists('../../../generados/comprobantes/'.$ARCHIVO)){
	unlink('../../../generados/comprobantes/'.$ARCHIVO);
}

$domtree->save('../../../generados/comprobantes/'.$ARCHIVO,LIBXML_NOEMPTYTAG );

$respuesta['CodigoRespuesta'] = "1";
$respuesta['Nombre'] = $NOMBRE;

echo json_encode($respuesta);

?>