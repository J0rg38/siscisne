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

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsNotaDebito = new ClsNotaDebito();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsNotaDebito->NdbId = $GET_id;
$InsNotaDebito->NdtId = $GET_ta;
$InsNotaDebito->MtdObtenerNotaDebito();

//deb($InsNotaDebito->NdbTipoCambio);
if($InsNotaDebito->MonId<>$EmpresaMonedaId){
	
	$InsNotaDebito->NdbTotalGravado = round($InsNotaDebito->NdbTotalGravado/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotalExonerado = round($InsNotaDebito->NdbTotalExonerado/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotalGratuito = round($InsNotaDebito->NdbTotalGratuito/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotalDescuento = round($InsNotaDebito->NdbTotalDescuento/$InsNotaDebito->NdbTipoCambio,2);

	
	$InsNotaDebito->NdbTotalPagar = round($InsNotaDebito->NdbTotalPagar/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotalDescuento = round($InsNotaDebito->NdbTotalDescuento/$InsNotaDebito->NdbTipoCambio,2);
	
	$InsNotaDebito->NdbSubTotal = round($InsNotaDebito->NdbSubTotal/$InsNotaDebito->NdbTipoCambio,2);	
	$InsNotaDebito->NdbImpuesto = round($InsNotaDebito->NdbImpuesto/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotal = round($InsNotaDebito->NdbTotal/$InsNotaDebito->NdbTipoCambio,2);	
	
}



$InsNotaDebito->NdbTotal = round($InsNotaDebito->NdbTotal,2);
list($parte_entero,$parte_decimal) = explode(".",$InsNotaDebito->NdbTotal);

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

$NotaDebitoTotalLetras = "SON ".$numalet->letra()." CON ".$parte_decimal."/100 ".$InsNotaDebito->MonNombre;


$NOMBRE = $EmpresaCodigo.'-08-'.$InsNotaDebito->NdtNumero.'-'.$InsNotaDebito->NdbId;
$ARCHIVO = $NOMBRE.'.xml';


$domtree = new DOMDocument('1.0', 'ISO-8859-1');
//$domtree->preserveWhiteSpace = false;
$domtree->formatOutput = true;
$domtree->xmlStandalone = false;

/* create the root element of the xml tree */
$xmlRoot = $domtree->createElement("DebitNote");
/* append it to the document created */
$xmlRoot = $domtree->appendChild($xmlRoot);

$xmlRoot->setAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:DebitNote-2');
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



if(!empty($InsNotaDebito->OvvId)){
		
		
	//ext:UBLExtension3
	$UBLExtension3 = $domtree->createElement("ext:UBLExtension");
	$UBLExtension3 = $UBLExtensions->appendChild($UBLExtension3);
	
	//sac:ExtensionContent3
	$ExtensionContent3 = $domtree->createElement("ext:ExtensionContent");
	$ExtensionContent3 = $UBLExtension3->appendChild($ExtensionContent3);
	
		//DatosAdicionales
		$DatosAdicionales = $domtree->createElement("DatosAdicionales");
		$DatosAdicionales = $ExtensionContent3->appendChild($DatosAdicionales);
	
			//if(!empty($InsNotaDebito->NdbDatoAdicional1)){
//
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","01");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional1);
//					$Valor = $DatoAdicional->appendChild($Valor);
//	
//				
//			}
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional2)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","02");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional2);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//				
//		if(!empty($InsNotaDebito->NdbDatoAdicional3)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","03");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional3);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional4)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","04");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional4);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional5)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","05");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional5);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//				
//			if(!empty($InsNotaDebito->NdbDatoAdicional6)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","06");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional6);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional7)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","07");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional7);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional8)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","08");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional8);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional9)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","09");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional9);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional10)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","10");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional10);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional11)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","11");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional11);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional12)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","12");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional12);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional13)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","13");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional13);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional14)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","14");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional14);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional15)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","15");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional15);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional16)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","16");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional16);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional17)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","17");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional17);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional18)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","18");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional18);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional19)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","19");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional19);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional20)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","20");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional20);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional21)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","21");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional21);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional122)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","22");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional22);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
//			
//			if(!empty($InsNotaDebito->NdbDatoAdicional23)){	
//			
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","23");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional23);
//					$Valor = $DatoAdicional->appendChild($Valor);
//				
//			}
//			
			

			if(count($InsNotaDebito->OrdenVentaVehiculoPropietario)>1){
			
				$Propietarios = "";
			
				foreach($InsNotaDebito->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
					if($InsNotaDebito->CliId<> $DatOrdenVentaVehiculoPropietario->CliId){
			
						$Propietarios .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." ".$DatOrdenVentaVehiculoPropietario->CliNombre."".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno."";		
						
						if(count($InsNotaDebito->OrdenVentaVehiculoPropietario)-1!=$i){
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


			if(!empty($InsNotaDebito->NdbDatoAdicional25)){	
			
				//DatoAdicional
				$DatoAdicional = $domtree->createElement("DatoAdicional");
				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);

					//DatosAdicionales
					$Codigo = $domtree->createElement("Codigo","25");
					$Codigo = $DatoAdicional->appendChild($Codigo);
					
					$Valor = $domtree->createElement("Valor",$InsNotaDebito->NdbDatoAdicional25);
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
$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsNotaDebito->NdbImpuesto,2, '.', ''));
$PayableAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
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
$ID = $domtree->createElement("cbc:ID",$InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId);
$ID = $xmlRoot->appendChild($ID);

//cbc:IssueDate
$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($InsNotaDebito->NdbFechaEmision));
$IssueDate = $xmlRoot->appendChild($IssueDate);

//cbc:DocumentCurrencyCode
$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsNotaDebito->MonSigla);
$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);

//cbc:DiscrepancyResponse
$DiscrepancyResponse = $domtree->createElement("cac:DiscrepancyResponse");
$DiscrepancyResponse = $xmlRoot->appendChild($DiscrepancyResponse);

	//cbc:ReferenceID
	$ReferenceID = $domtree->createElement("cbc:ReferenceID",$InsNotaDebito->DtaNumero."-".$InsNotaDebito->DocId);
	$ReferenceID = $DiscrepancyResponse->appendChild($ReferenceID);
	
	//cac:ResponseCode
	$ResponseCode = $domtree->createElement("cbc:ResponseCode",$InsNotaDebito->NdbMotivoCodigo);
	$ResponseCode = $DiscrepancyResponse->appendChild($ResponseCode);
	
	//cac:ResponseCode
	//$ResponseCode = $domtree->createElement("cbc:Description",$InsNotaDebito->ScaNombre);
	$ResponseCode = $domtree->createElement("cbc:Description",$InsNotaDebito->NdbMotivo);
	$ResponseCode = $DiscrepancyResponse->appendChild($ResponseCode);

//cbc:BillingReference
$BillingReference = $domtree->createElement("cac:BillingReference");
$BillingReference = $xmlRoot->appendChild($BillingReference);

	//cac:InvoiceDocumentReference
	$InvoiceDocumentReference = $domtree->createElement("cac:InvoiceDocumentReference");
	$InvoiceDocumentReference = $BillingReference->appendChild($InvoiceDocumentReference);
	
		//cac:ResponseCode
		$ID = $domtree->createElement("cbc:ID",$InsNotaDebito->DtaNumero."-".$InsNotaDebito->DocId);
		$ID = $InvoiceDocumentReference->appendChild($ID);
		
		switch($InsNotaDebito->NdbTipo){
			
			case "2": //NOTA DE DEBITO
		
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
				$ID = $domtree->createElement("cbc:ID","230101");
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
		$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$InsNotaDebito->CliNumeroDocumento);
		$CustomerAssignedAccountID = $AccountingCustomerParty->appendChild($CustomerAssignedAccountID);
		
		
		//cbc:AdditionalAccountID
		$AdditionalAccountID = $domtree->createElement("cbc:AdditionalAccountID",round($InsNotaDebito->TdoCodigo,0));
		$AdditionalAccountID = $AccountingCustomerParty->appendChild($AdditionalAccountID);
	
		//cac:Party
		$Party = $domtree->createElement("cac:Party");
		$Party = $AccountingCustomerParty->appendChild($Party);
		
			//cac:PhysicalLocation
			$PhysicalLocation = $Party->appendChild($domtree->createElement( 'cac:PhysicalLocation' ));
			
			//cac:Name		
			$Description = $PhysicalLocation->appendChild($domtree->createElement('cbc:Description')); 
			$Description->appendChild($domtree->createCDATASection( $InsNotaDebito->NdbDireccion )); 
			
			 //cac:PartyLegalEntity
			$PartyLegalEntity = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
			
			//cac:Name		
			$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
			$RegistrationName->appendChild($domtree->createCDATASection( $InsNotaDebito->CliNombre." ".$InsNotaDebito->CliApellidoPaterno." ".$InsNotaDebito->CliApellidoMaterno )); 
			
				
				
	 
	//cac:TaxTotal
	$TaxTotal = $domtree->createElement("cac:TaxTotal");
	$TaxTotal = $xmlRoot->appendChild($TaxTotal);
	
		//cbc:TaxAmount
		$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsNotaDebito->NdbImpuesto,2, '.', ''));
		$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
		$TaxAmount = $TaxTotal->appendChild($TaxAmount);
				
				
		//cac:TaxSubtotal
		$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
		$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
			
			//cbc:TaxAmount 
			$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsNotaDebito->NdbImpuesto,2, '.', ''));
			$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
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
	$RequestedMonetaryTotal = $domtree->createElement("cac:RequestedMonetaryTotal");
	$RequestedMonetaryTotal = $xmlRoot->appendChild($RequestedMonetaryTotal);
	
	//cbc:PayableAmount currencyID="PEN"
		$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsNotaDebito->NdbTotal,2, '.', ''));
		$PayableAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
		$PayableAmount = $RequestedMonetaryTotal->appendChild($PayableAmount);
	
	 
//	//cac:LegalMonetaryTotal
//	$LegalMonetaryTotal = $domtree->createElement("cac:LegalMonetaryTotal");
//	$LegalMonetaryTotal = $xmlRoot->appendChild($LegalMonetaryTotal);
//	
//	
//		//cbc:PayableAmount currencyID="PEN"
//		$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsNotaDebito->NdbTotal,2, '.', ''));
//		$PayableAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
//		$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);
//	
	
	
	
	
	
	$fila = 1;
	if(!empty($InsNotaDebito->NotaDebitoDetalle)){
		foreach($InsNotaDebito->NotaDebitoDetalle as $DatNotaDebitoDetalle){
			
			if($InsNotaDebito->MonId<>$EmpresaMonedaId){
				
				$DatNotaDebitoDetalle->NddValorVenta = round($DatNotaDebitoDetalle->NddValorVenta/$InsNotaDebito->NdbTipoCambio,2);
				$DatNotaDebitoDetalle->NddValorVentaUnitario = round($DatNotaDebitoDetalle->NddValorVentaUnitario/$InsNotaDebito->NdbTipoCambio,2);
				
				$DatNotaDebitoDetalle->NddPrecio = round($DatNotaDebitoDetalle->NddPrecio/$InsNotaDebito->NdbTipoCambio,2);
				$DatNotaDebitoDetalle->NddImpuesto = round($DatNotaDebitoDetalle->NddImpuesto/$InsNotaDebito->NdbTipoCambio,2);
				
			}
			
			//cac:InvoiceLine
			$InvoiceLine = $domtree->createElement("cac:DebitNoteLine");
			$InvoiceLine = $xmlRoot->appendChild($InvoiceLine);	
				
				//cbc:ID
				$ID = $domtree->createElement("cbc:ID",$fila);
				$ID = $InvoiceLine->appendChild($ID);	
				
				//cbc:DebitedQuantity unitCode="NIU"
				$DebitedQuantity = $domtree->createElement("cbc:DebitedQuantity",number_format($DatNotaDebitoDetalle->NddCantidad,2, '.', ''));
				$DebitedQuantity->setAttribute('unitCode', 'NIU');
				$DebitedQuantity = $InvoiceLine->appendChild($DebitedQuantity);	
				
				//cbc:LineExtensionAmount currencyID="PEN"
				$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount",number_format($DatNotaDebitoDetalle->NddValorVenta,2, '.', ''));
				$LineExtensionAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
				$LineExtensionAmount = $InvoiceLine->appendChild($LineExtensionAmount);	
					
				//cac:PricingReference
				$PricingReference = $domtree->createElement("cac:PricingReference");
				$PricingReference = $InvoiceLine->appendChild($PricingReference);	
					
	//					//cac:AlternativeConditionPrice
	//					$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
	//					$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);	
	//				
	//						//cbc:PriceAmount currencyID="PEN"
	//						$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaDebitoDetalle->NddPrecio,2, '.', ''));
	//						$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
	//						$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	//						
	//						//cbc:PriceTypeCode
	//						$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
	//						$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);	
	
							if($DatNotaDebitoDetalle->NddGratuito==1){
								
								//cac:AlternativeConditionPrice
								$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
								$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
								
								//cbc:PriceAmount currencyID="PEN"
								$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
								$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
								$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	
								//cbc:PriceTypeCode
								$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
								$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
	
								//cac:AlternativeConditionPrice
								$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
								$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
	
								//cbc:PriceAmount currencyID="PEN"
								$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaDebitoDetalle->NddValorVentaUnitario,2, '.', ''));
								$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
								$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	
								//cbc:PriceTypeCode
								$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","02");
								$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
	
	//							cac:AlternativeConditionPrice
	//							$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
	//							$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
	//							
	//							//cbc:PriceAmount currencyID="PEN"
	//							$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaDebitoDetalle->NddPrecio,2, '.', ''));
	//							$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
	//							$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	//
	//							//cbc:PriceTypeCode
	//							$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
	//							$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
							
								
							}else if($DatNotaDebitoDetalle->NddGratuito==2){
								
								//cac:AlternativeConditionPrice
								$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
								$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
								
								//cbc:PriceAmount currencyID="PEN"
								$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaDebitoDetalle->NddPrecio,2, '.', ''));
								$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
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
								$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
								$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
								
								//cbc:PriceTypeCode
								$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","00");
								$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
								
							}
				
				//cac:TaxTotal
				$TaxTotal = $domtree->createElement("cac:TaxTotal");
				$TaxTotal = $InvoiceLine->appendChild($TaxTotal);	
				
				//	//cbc:TaxAmount currencyID="PEN"
	//				$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaDebitoDetalle->NddImpuesto,2, '.', ''));
	//				$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
	//				$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
				
					if($DatNotaDebitoDetalle->NddGratuito == "2"){
						
					//cbc:TaxAmount currencyID="PEN"
					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaDebitoDetalle->NddImpuesto,2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
					$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
						
				}else if($DatNotaDebitoDetalle->NddGratuito == "1"){
						
					//cbc:TaxAmount currencyID="PEN"
					$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
					$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
					$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
	
					//$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaDebitoDetalle->NddImpuesto,2, '.', ''));
	//				$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
	//				$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
					
						
				}else{
						
					//cbc:TaxAmount currencyID="PEN"
					$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
					$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
					$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
						
				}
				
					//cac:TaxSubtotal
					$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
					$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);	
					
						////cbc:TaxAmount currencyID="PEN"
	//					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaDebitoDetalle->NddImpuesto,2, '.', ''));
	//					$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
	//					$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);	
	
						if($DatNotaDebitoDetalle->NddGratuito == "2"){
	
							//cbc:TaxAmount currencyID="PEN"
							$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaDebitoDetalle->NddImpuesto,2, '.', ''));
							$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
							$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);		
							
						}else if($DatNotaDebitoDetalle->NddGratuito == "1"){
		
							//cbc:TaxAmount currencyID="PEN"
							$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
							$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
							$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);	
							
							//$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaDebitoDetalle->NddImpuesto,2, '.', ''));
							//$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
							//$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);		
							
						}else{
							
							//cbc:TaxAmount currencyID="PEN"
							$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
							$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
							$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);	
							
						}
						
						//cbc:TaxAmount currencyID="PEN"
						$Percent = $domtree->createElement("cbc:Percent",($InsNotaDebito->NdbPorcentajeImpuestoVenta));
						$Percent = $TaxSubtotal->appendChild($Percent);	
					
						//cac:TaxCategory
						$TaxCategory = $domtree->createElement("cac:TaxCategory");
						$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);	
							
							//cbc:TaxExemptionReasonCode
							//$ID = $domtree->createElement("cbc:ID",$DatNotaDebitoDetalle->NddId);
							//$ID = $TaxCategory->appendChild($ID);
							
							//cbc:TaxExemptionReasonCode
							//$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","10");
							//$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
							
									if($DatNotaDebitoDetalle->NddExonerado == "1"){//20
									  
									  if($DatNotaDebitoDetalle->NddGratuito == "1"){//20
																	
										  $TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","21");
										  $TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
										  
									  }else{
										  
										  $TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","20");
										  $TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
										  
									  }
									  
								  
								  }else if($DatNotaDebitoDetalle->NddExonerado == "2"){//10
									  
									  if($DatNotaDebitoDetalle->NddGratuito == "1"){//20
										
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
	
						$Description->appendChild($domtree->createCDATASection($DatNotaDebitoDetalle->NddDescripcion )); 
						
						
						
						//if(!empty($InsNotaDebito->NdbDatoAdicional1)){
//							
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("MARCA: ".$InsNotaDebito->NdbDatoAdicional1 )); 
//					
//						}
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional2)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("TRACCION: ".$InsNotaDebito->NdbDatoAdicional2 )); 
//							
//						}
//							
//						if(!empty($InsNotaDebito->NdbDatoAdicional3)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("MODELO: ".$InsNotaDebito->NdbDatoAdicional3 )); 
//							
//						}
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional4)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("CARROCERIA: ".$InsNotaDebito->NdbDatoAdicional4 ));
//							
//						}
//						
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional5)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("AÑO FABRIC.: ".$InsNotaDebito->NdbDatoAdicional5 ));
//							
//						}
//							
//						if(!empty($InsNotaDebito->NdbDatoAdicional6)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. PUERTAS: ".$InsNotaDebito->NdbDatoAdicional6 ));
//							
//						}
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional7)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. MOTOR: ".$InsNotaDebito->NdbDatoAdicional7 ));
//							
//						}
//						
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional8)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("COMBUSTIBLE: ".$InsNotaDebito->NdbDatoAdicional8 ));
//							
//						}
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional9)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. CILINDROS: ".$InsNotaDebito->NdbDatoAdicional9 ));
//							
//						}
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional10)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("PESO BRUTO: ".$InsNotaDebito->NdbDatoAdicional10 ));
//							
//						}
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional11)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. EJES: ".$InsNotaDebito->NdbDatoAdicional11 ));
//							
//						}
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional12)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("CARGA UTIL: ".$InsNotaDebito->NdbDatoAdicional12 ));
//							
//						}
//						
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional13)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. CHASIS: ".$InsNotaDebito->NdbDatoAdicional13 ));
//							
//						}
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional14)){	
//						//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("PESO SECO: ".$InsNotaDebito->NdbDatoAdicional14 ));
//							
//						}
//						
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional15)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("COLOR: ".$InsNotaDebito->NdbDatoAdicional15 ));
//							
//						}
//						
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional16)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("ALTO: ".$InsNotaDebito->NdbDatoAdicional16 ));
//							
//						}
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional17)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("CILINDRADA: ".$InsNotaDebito->NdbDatoAdicional17 ));
//							
//						}
//						
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional18)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("LARGO: ".$InsNotaDebito->NdbDatoAdicional18 ));
//							
//						}
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional19)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. ASIENTOS: ".$InsNotaDebito->NdbDatoAdicional19 ));
//							
//						}
//						
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional20)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("ANCHO: ".$InsNotaDebito->NdbDatoAdicional20 ));
//							
//						}
//						
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional21)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("CAP. PASAJEROS: ".$InsNotaDebito->NdbDatoAdicional21 ));
//							
//						}
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional122)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("DIST. EJES: ".$InsNotaDebito->NdbDatoAdicional122 ));
//							
//						}
//						
//						
//						if(!empty($InsNotaDebito->NdbDatoAdicional23)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. POLIZA: ".$InsNotaDebito->NdbDatoAdicional23 ));
//							
//						}
//						
						
						
						
					//cac:SellersItemIdentification		
					$SellersItemIdentification = $domtree->createElement("cac:SellersItemIdentification");
					$SellersItemIdentification = $Item->appendChild($SellersItemIdentification);
	
						$ID = $domtree->createElement("cbc:ID");
						$ID = $SellersItemIdentification->appendChild($ID);
						$ID->appendChild($domtree->createCDATASection($DatNotaDebitoDetalle->NddCodigo )); 
	
				//cac:Price
				$Price = $domtree->createElement("cac:Price");
				$Price = $InvoiceLine->appendChild($Price);	
	
					////cbc:PriceAmount currencyID="PEN"
	//				$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaDebitoDetalle->NddPrecio,2, '.', ''));
	//				$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
	//				$PriceAmount = $Price->appendChild($PriceAmount);	
	
	
					if($DatNotaDebitoDetalle->NddGratuito==1){
						
						//cbc:PriceAmount currencyID="PEN"
						$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
						$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
						$PriceAmount = $Price->appendChild($PriceAmount);	
						//$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaDebitoDetalle->NddValorVentaUnitario,2, '.', ''));
						//$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
						//$PriceAmount = $Price->appendChild($PriceAmount);	
						
					}elseif($DatNotaDebitoDetalle->NddGratuito==2){
						
						//cbc:PriceAmount currencyID="PEN"
						$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaDebitoDetalle->NddValorVentaUnitario,2, '.', ''));
						$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
						$PriceAmount = $Price->appendChild($PriceAmount);	
						
					}else{
						
						//cbc:PriceAmount currencyID="PEN"
						$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
						$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
						$PriceAmount = $Price->appendChild($PriceAmount);	
							
					}
			
			$fila++;
		}
	}

if(file_exists('../../../generados/comprobantes_xml/'.$ARCHIVO)){
	unlink('../../../generados/comprobantes_xml/'.$ARCHIVO);
}

$domtree->save('../../../generados/comprobantes_xml/'.$ARCHIVO,LIBXML_NOEMPTYTAG );

$respuesta['CodigoRespuesta'] = "1";
$respuesta['Nombre'] = $NOMBRE;

echo json_encode($respuesta);
?>