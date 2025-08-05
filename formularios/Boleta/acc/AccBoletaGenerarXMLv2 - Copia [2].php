<?php
session_start();
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

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsBoleta = new ClsBoleta();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsBoleta->BolId = $GET_id;
$InsBoleta->BtaId = $GET_ta;
$InsBoleta->MtdObtenerBoleta();


//deb($InsBoleta->BolTipoCambio);
if($InsBoleta->MonId<>$EmpresaMonedaId){
	
	$InsBoleta->BolTotalGravado = round($InsBoleta->BolTotalGravado/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotalExonerado = round($InsBoleta->BolTotalExonerado/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotalGratuito = round($InsBoleta->BolTotalGratuito/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotalDescuento = round($InsBoleta->BolTotalDescuento/$InsBoleta->BolTipoCambio,2);

	
	$InsBoleta->BolTotalPagar = round($InsBoleta->BolTotalPagar/$InsBoleta->BolTipoCambio,2);
	//$InsBoleta->BolTotalDescuento = round($InsBoleta->BolTotalDescuento/$InsBoleta->BolTipoCambio,2);
	
	$InsBoleta->BolSubTotal = round($InsBoleta->BolSubTotal/$InsBoleta->BolTipoCambio,2);	
	$InsBoleta->BolImpuesto = round($InsBoleta->BolImpuesto/$InsBoleta->BolTipoCambio,2);
	$InsBoleta->BolTotal = round($InsBoleta->BolTotal/$InsBoleta->BolTipoCambio,2);	
	$InsBoleta->BolTotalImpuestoSelectivo = round($InsBoleta->BolTotalImpuestoSelectivo/$InsBoleta->BolTipoCambio,2);
	
}
	
$InsSucursal = new ClsSucursal();
$InsSucursal->SucId = $InsBoleta->SucId;
$InsSucursal->MtdObtenerSucursal();

$InsBoleta->BolTotal = round($InsBoleta->BolTotal,2);
list($parte_entero,$parte_decimal) = explode(".",$InsBoleta->BolTotal);

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

$BoletaTotalLetras = "SON ".$numalet->letra()." CON ".$parte_decimal."/100 ".$InsBoleta->MonNombre;

$NOMBRE = $EmpresaCodigo.'-03-'.$InsBoleta->BtaNumero.'-'.$InsBoleta->BolId;
$ARCHIVO = $NOMBRE.'.xml';

$domtree = new DOMDocument('1.0', 'ISO-8859-1');
//$domtree->preserveWhiteSpace = false;
$domtree->formatOutput = true;
$domtree->xmlStandalone = false;

/* create the root element of the xml tree */
$xmlRoot = $domtree->createElement("Invoice");
/* append it to the document created */
$xmlRoot = $domtree->appendChild($xmlRoot);

$xmlRoot->setAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
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
//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolSubTotal,2, '.', ''));
$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalGravado,2, '.', ''));
$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);

///'cbc:ID','1003'	//TOTAL EXONERADAS
//sac:AdditionalMonetaryTotal
$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1003'));

//sac:PayableAmount
$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalExonerado,2, '.', ''));
$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);

//'cbc:ID','1004'	//TOTAL GRATUITAS
//sac:AdditionalMonetaryTotal
$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1004'));

//sac:PayableAmount
$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalGratuito,2, '.', ''));
$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);

//'cbc:ID','2005' //TOTAL DESCUENTOS
//sac:AdditionalMonetaryTotal
$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','2005'));

//sac:PayableAmount
$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalDescuento,2, '.', ''));
$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);


///'cbc:ID','1000' //TOTAL EN LETRAS
//sac:AdditionalProperty
$AdditionalProperty = $domtree->createElement("sac:AdditionalProperty");
$AdditionalProperty = $AdditionalInformation->appendChild($AdditionalProperty);
$AdditionalProperty->appendChild($domtree->createElement('cbc:ID','1000'));

//cbc:Value
$Value = $domtree->createElement("cbc:Value",$BoletaTotalLetras);
$Value = $AdditionalProperty->appendChild($Value);


if(!empty($InsBoleta->BolLeyenda)){

	
	///'cbc:ID','1002' //LEYENDA
	//sac:AdditionalProperty
	$AdditionalProperty = $domtree->createElement("sac:AdditionalProperty");
	$AdditionalProperty = $AdditionalInformation->appendChild($AdditionalProperty);
	$AdditionalProperty->appendChild($domtree->createElement('cbc:ID','1002'));
	
	//cbc:Value
	$Value = $domtree->createElement("cbc:Value",$InsBoleta->BolLeyenda." ".number_format($InsBoleta->BolTotalGratuito,2));
	$Value = $AdditionalProperty->appendChild($Value);

	
}


//if(!empty($InsBoleta->OvvId)){
//
//	//ext:UBLExtension3
//	$UBLExtension3 = $domtree->createElement("ext:UBLExtension");
//	$UBLExtension3 = $UBLExtensions->appendChild($UBLExtension3);
//	
//	//sac:ExtensionContent3
//	$ExtensionContent3 = $domtree->createElement("ext:ExtensionContent");
//	$ExtensionContent3 = $UBLExtension3->appendChild($ExtensionContent3);
//	
//		//DatosAdicionales
//		$DatosAdicionales = $domtree->createElement("DatosAdicionales");
//		$DatosAdicionales = $ExtensionContent3->appendChild($DatosAdicionales);
//	
//
////			if(!empty($InsBoleta->BolDatoAdicional1)){
////
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","01");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional1);
////					$Valor = $DatoAdicional->appendChild($Valor);
////	
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional2)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","02");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional2);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////				
////		if(!empty($InsBoleta->BolDatoAdicional3)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","03");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional3);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional4)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","04");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional4);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			
////			if(!empty($InsBoleta->BolDatoAdicional5)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","05");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional5);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////				
////			if(!empty($InsBoleta->BolDatoAdicional6)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","06");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional6);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional7)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","07");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional7);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			
////			if(!empty($InsBoleta->BolDatoAdicional8)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","08");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional8);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional9)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","09");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional9);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional10)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","10");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional10);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional11)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","11");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional11);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional12)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","12");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional12);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			
////			if(!empty($InsBoleta->BolDatoAdicional13)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","13");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional13);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional14)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","14");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional14);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			
////			if(!empty($InsBoleta->BolDatoAdicional15)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","15");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional15);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			
////			if(!empty($InsBoleta->BolDatoAdicional16)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","16");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional16);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional17)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","17");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional17);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			
////			if(!empty($InsBoleta->BolDatoAdicional18)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","18");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional18);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional19)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","19");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional19);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			
////			if(!empty($InsBoleta->BolDatoAdicional20)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","20");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional20);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			
////			if(!empty($InsBoleta->BolDatoAdicional21)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","21");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional21);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional122)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","22");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional22);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			
////			if(!empty($InsBoleta->BolDatoAdicional23)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","23");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional23);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional24)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","24");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional24);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////			
////			if(!empty($InsBoleta->BolDatoAdicional25)){	
////			
////				//DatoAdicional
////				$DatoAdicional = $domtree->createElement("DatoAdicional");
////				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
////			
////					//DatosAdicionales
////					$Codigo = $domtree->createElement("Codigo","25");
////					$Codigo = $DatoAdicional->appendChild($Codigo);
////					
////					$Valor = $domtree->createElement("Valor",$InsBoleta->BolDatoAdicional25);
////					$Valor = $DatoAdicional->appendChild($Valor);
////				
////			}
////				
////}
//
//
//			if(count($InsBoleta->OrdenVentaVehiculoPropietario)>1){
//
//				$Propietarios = "";
//		
//				foreach($InsBoleta->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
//					
//					if($InsBoleta->CliId<> $DatOrdenVentaVehiculoPropietario->CliId){
//		
//						$Propietarios .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." ".$DatOrdenVentaVehiculoPropietario->CliNombre."".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno."";		
//						
//						if(count($InsBoleta->OrdenVentaVehiculoPropietario)-1!=$i){
//							$Propietarios .= " * ";
//						}
//						
//						$i++;
//		
//					}			
//				}		
//				
//				//DatoAdicional
//				$DatoAdicional = $domtree->createElement("DatoAdicional");
//				$DatoAdicional = $DatosAdicionales->appendChild($DatoAdicional);
//			
//					//DatosAdicionales
//					$Codigo = $domtree->createElement("Codigo","24");
//					$Codigo = $DatoAdicional->appendChild($Codigo);
//					
//					$Valor = $domtree->createElement("Valor",$Propietarios);
//					$Valor = $DatoAdicional->appendChild($Valor);	
//		
//			}
//
//
//}



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
$ID = $domtree->createElement("cbc:ID",$InsBoleta->BtaNumero."-".$InsBoleta->BolId);
$ID = $xmlRoot->appendChild($ID);

//cbc:IssueDate
$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($InsBoleta->BolFechaEmision));
$IssueDate = $xmlRoot->appendChild($IssueDate);

//cbc:InvoiceTypeCode
$InvoiceTypeCode = $domtree->createElement("cbc:InvoiceTypeCode","03");
$InvoiceTypeCode = $xmlRoot->appendChild($InvoiceTypeCode);

//cbc:DocumentCurrencyCode
$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsBoleta->MonSigla);
$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);

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
			$ID = $domtree->createElement("cbc:ID",$InsBoleta->SucCodigoUbigeo);
			$ID = $PostalAddress->appendChild($ID);
			
			//cbc:StreetName
			$StreetName = $domtree->createElement("cbc:StreetName",$InsBoleta->SucDireccion);
			$StreetName = $PostalAddress->appendChild($StreetName);
	
			//cbc:District
			$District = $domtree->createElement("cbc:District",$InsBoleta->SucDistrito);
			$District = $PostalAddress->appendChild($District);
			
			//cac:Country
			$Country = $domtree->createElement("cac:Country");
			$Country = $PostalAddress->appendChild($Country);
			
			//cbc:IdentificationCode
			$IdentificationCode = $domtree->createElement("cbc:IdentificationCode","PE");
			$IdentificationCode = $Country->appendChild($IdentificationCode);
	
		//cac:PartyLegalEntity
		$base = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
		
		//cac:Name		
		$name = $base->appendChild($domtree->createElement('cbc:RegistrationName')); 
		$name->appendChild($domtree->createCDATASection( $EmpresaNombre)); 

//cac:AccountingCustomerParty
	$AccountingCustomerParty = $domtree->createElement("cac:AccountingCustomerParty");
	$AccountingCustomerParty = $xmlRoot->appendChild($AccountingCustomerParty);

//	if(!empty($InsBoleta->CliNumeroDocumento)){
		//cbc:CustomerAssignedAccountID
		$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$InsBoleta->CliNumeroDocumento);
		$CustomerAssignedAccountID = $AccountingCustomerParty->appendChild($CustomerAssignedAccountID);	
		
		//cbc:AdditionalAccountID
		$AdditionalAccountID = $domtree->createElement("cbc:AdditionalAccountID",round($InsBoleta->TdoCodigo,0));
		$AdditionalAccountID = $AccountingCustomerParty->appendChild($AdditionalAccountID);	
	
//	}else{
//		
//		//cbc:CustomerAssignedAccountID
//		$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$InsBoleta->CliNumeroDocumento);
//		$CustomerAssignedAccountID = $AccountingCustomerParty->appendChild($CustomerAssignedAccountID);	
//		
//		//cbc:AdditionalAccountID
//		$AdditionalAccountID = $domtree->createElement("cbc:AdditionalAccountID","0");
//		$AdditionalAccountID = $AccountingCustomerParty->appendChild($AdditionalAccountID);	
//		
//	}


			if(count($InsBoleta->OrdenVentaVehiculoPropietario)>1){

				$Propietarios = " / ";
		
				foreach($InsBoleta->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
					if($InsBoleta->CliId<> $DatOrdenVentaVehiculoPropietario->CliId){
		
						$Propietarios .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." ".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno."";		
						
						//if(count($InsBoleta->OrdenVentaVehiculoPropietario)-1!=$i){
//							$Propietarios .= " * ";
//						}
						
						$i++;
		
					}			
				}		
				
		
			}


 	//cac:Party
	$Party = $domtree->createElement("cac:Party");
	$Party = $AccountingCustomerParty->appendChild($Party);
	
		//cac:PhysicalLocation
		$PhysicalLocation = $Party->appendChild($domtree->createElement( 'cac:PhysicalLocation' ));
		
		//cac:Name		
		$Description = $PhysicalLocation->appendChild($domtree->createElement('cbc:Description')); 
		$Description->appendChild($domtree->createCDATASection( $InsBoleta->BolDireccion )); 
			
		//cac:PartyLegalEntity
		$PartyLegalEntity = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
		
		//cac:Name		
		$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
		$RegistrationName->appendChild($domtree->createCDATASection( $InsBoleta->CliNombre." ".$InsBoleta->CliApellidoPaterno." ".$InsBoleta->CliApellidoMaterno ." ".$Propietarios)); 
		
			
 
//cac:TaxTotal
$TaxTotal = $domtree->createElement("cac:TaxTotal");
$TaxTotal = $xmlRoot->appendChild($TaxTotal);

	//cbc:TaxAmount
	$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsBoleta->BolImpuesto,2, '.', ''));
	$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
	$TaxAmount = $TaxTotal->appendChild($TaxAmount);
			
			
	//cac:TaxSubtotal
	$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
	$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
		
		//cbc:TaxAmount 
		$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsBoleta->BolImpuesto,2, '.', ''));
		$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
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






//cac:TaxTotal
$TaxTotal = $domtree->createElement("cac:TaxTotal");
$TaxTotal = $xmlRoot->appendChild($TaxTotal);

	//cbc:TaxAmount
	$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsBoleta->BolTotalImpuestoSelectivo,2, '.', ''));
	$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
	$TaxAmount = $TaxTotal->appendChild($TaxAmount);
			
	//cac:TaxSubtotal
	$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
	$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
		
		//cbc:TaxAmount 
		$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsBoleta->BolTotalImpuestoSelectivo,2, '.', ''));
		$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
		$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
		
		//cac:TaxCategory
		$TaxCategory = $domtree->createElement("cac:TaxCategory");
		$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
			
			//cac:TaxScheme
			$TaxScheme = $domtree->createElement("cac:TaxScheme");
			$TaxScheme = $TaxCategory->appendChild($TaxScheme);

				//cbc:ID
				$ID = $domtree->createElement("cbc:ID","2000");
				$ID = $TaxScheme->appendChild($ID);
				
				//cbc:Name
				$Name = $domtree->createElement("cbc:Name","ISC");
				$Name = $TaxScheme->appendChild($Name);
				
				//cbc:TaxTypeCode
				$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","EXC");
				$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
				
				

 
//cac:LegalMonetaryTotal
$LegalMonetaryTotal = $domtree->createElement("cac:LegalMonetaryTotal");
$LegalMonetaryTotal = $xmlRoot->appendChild($LegalMonetaryTotal);

	//cbc:AllowanceTotalAmount currencyID="PEN"
	$AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount",number_format($InsBoleta->BolTotalDescuento,2, '.', ''));
	$AllowanceTotalAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
	$AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
	

	//cbc:PayableAmount currencyID="PEN"
	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalPagar,2, '.', ''));
	$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
	$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);


$fila = 1;
if(!empty($InsBoleta->BoletaDetalle)){
	foreach($InsBoleta->BoletaDetalle as $DatBoletaDetalle){
		
		if($InsBoleta->MonId<>$EmpresaMonedaId){
			
			$DatBoletaDetalle->BdeValorVenta = round($DatBoletaDetalle->BdeValorVenta/$InsBoleta->BolTipoCambio,2);
			$DatBoletaDetalle->BdeValorVentaUnitario = round($DatBoletaDetalle->BdeValorVentaUnitario/$InsBoleta->BolTipoCambio,2);
			
			$DatBoletaDetalle->BdePrecio = round($DatBoletaDetalle->BdePrecio/$InsBoleta->BolTipoCambio,2);
			$DatBoletaDetalle->BdeImpuesto = round($DatBoletaDetalle->BdeImpuesto/$InsBoleta->BolTipoCambio,2);
			
		}
			
		//cac:InvoiceLine
		$InvoiceLine = $domtree->createElement("cac:InvoiceLine");
		$InvoiceLine = $xmlRoot->appendChild($InvoiceLine);	
			
			//cbc:ID
			$ID = $domtree->createElement("cbc:ID",$fila);
			$ID = $InvoiceLine->appendChild($ID);	
			
			//cbc:InvoicedQuantity unitCode="NIU"
			$InvoicedQuantity = $domtree->createElement("cbc:InvoicedQuantity",number_format($DatBoletaDetalle->BdeCantidad,2, '.', ''));
			$InvoicedQuantity->setAttribute('unitCode', 'NIU');
			$InvoicedQuantity = $InvoiceLine->appendChild($InvoicedQuantity);	
			
			//cbc:LineExtensionAmount currencyID="PEN"
			$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount",number_format($DatBoletaDetalle->BdeValorVenta,2, '.', ''));
			$LineExtensionAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
			$LineExtensionAmount = $InvoiceLine->appendChild($LineExtensionAmount);	
				
			//cac:PricingReference
			$PricingReference = $domtree->createElement("cac:PricingReference");
			$PricingReference = $InvoiceLine->appendChild($PricingReference);	
						
						if($DatBoletaDetalle->BdeGratuito==1){
							
							//cac:AlternativeConditionPrice
							$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
							$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
							
							//cbc:PriceAmount currencyID="PEN"
							$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
							$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
							$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	

							//cbc:PriceTypeCode
							$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
							$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);

							//cac:AlternativeConditionPrice
							$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
							$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);

							//cbc:PriceAmount currencyID="PEN"
							$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatBoletaDetalle->BdeValorVentaUnitario,2, '.', ''));
							$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
							$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	

							//cbc:PriceTypeCode
							$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","02");
							$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);

//							cac:AlternativeConditionPrice
//							$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
//							$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
//							
//							//cbc:PriceAmount currencyID="PEN"
//							$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatBoletaDetalle->BdePrecio,2, '.', ''));
//							$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
//							$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
//
//							//cbc:PriceTypeCode
//							$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
//							$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
						
							
						}else if($DatBoletaDetalle->BdeGratuito==2){
							
							//cac:AlternativeConditionPrice
							$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
							$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
							
							//cbc:PriceAmount currencyID="PEN"
							$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatBoletaDetalle->BdePrecio,2, '.', ''));
							$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
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
							$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
							$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
							
							//cbc:PriceTypeCode
							$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","00");
							$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
							
						}
						
							
			
			//cac:TaxTotal
			$TaxTotal = $domtree->createElement("cac:TaxTotal");
			$TaxTotal = $InvoiceLine->appendChild($TaxTotal);	
				
			if($DatBoletaDetalle->BdeGratuito == "2"){
					
				//cbc:TaxAmount currencyID="PEN"
				$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeImpuesto,2, '.', ''));
				$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
					
			}else if($DatBoletaDetalle->BdeGratuito == "1"){
					
				//cbc:TaxAmount currencyID="PEN"
				$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
				$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);	

				//$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeImpuesto,2, '.', ''));
//				$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
//				$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
				
					
			}else{
					
				//cbc:TaxAmount currencyID="PEN"
				$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
				$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
					
			}
				
				
			
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);	
					
				if($DatBoletaDetalle->BdeGratuito == "2"){

					//cbc:TaxAmount currencyID="PEN"
					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeImpuesto,2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);		
					
				}else if($DatBoletaDetalle->BdeGratuito == "1"){

					//cbc:TaxAmount currencyID="PEN"
					$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
					$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);	
					
					//$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeImpuesto,2, '.', ''));
					//$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					//$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);		
					
				}else{
					
					//cbc:TaxAmount currencyID="PEN"
					$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
					$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);	
					
				}
					
					
					//cbc:TaxAmount currencyID="PEN"
					$Percent = $domtree->createElement("cbc:Percent",($InsBoleta->BolPorcentajeImpuestoVenta));
					$Percent = $TaxSubtotal->appendChild($Percent);	
				
					//cac:TaxCategory
					$TaxCategory = $domtree->createElement("cac:TaxCategory");
					$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);	
						
						//cbc:TaxExemptionReasonCode
						//$ID = $domtree->createElement("cbc:ID",$DatBoletaDetalle->BdeId);
						//$ID = $TaxCategory->appendChild($ID);
						
						//cbc:TaxExemptionReasonCode
						
					  if($DatBoletaDetalle->BdeExonerado == "1"){//20
						  
						  if($DatBoletaDetalle->BdeGratuito == "1"){//20
						  								
							  $TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","21");
							  $TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
							  
						  }else{
							  
							  $TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","20");
							  $TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
							  
						  }
						  
					  
					  }else if($DatBoletaDetalle->BdeExonerado == "2"){//10
						  
						  if($DatBoletaDetalle->BdeGratuito == "1"){//20
						  	
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




			if($DatBoletaDetalle->BdeImpuestoSelectivo>0){
				
				
					//ISC - INICIO
					
					//cac:TaxTotal
					$TaxTotal = $domtree->createElement("cac:TaxTotal");
					$TaxTotal = $InvoiceLine->appendChild($TaxTotal);	
						
						//cbc:TaxAmount currencyID="PEN"
						$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeImpuestoSelectivo,2, '.', ''));
						$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
						$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
					
						//cac:TaxSubtotal
						$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
						$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);	
						
							//cbc:TaxAmount currencyID="PEN"
							$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeImpuestoSelectivo,2, '.', ''));
							$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
							$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);	
							
							//cac:TaxCategory
							$TaxCategory = $domtree->createElement("cac:TaxCategory");
							$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);	
								
								//cbc:TaxExemptionReasonCode
								$TierRange = $domtree->createElement("cbc:TierRange","03");
								$TierRange = $TaxCategory->appendChild($TierRange);
											  
								//cac:TaxScheme
								$TaxScheme = $domtree->createElement("cac:TaxScheme");
								$TaxScheme = $TaxCategory->appendChild($TaxScheme);
									
										//cbc:ID
										$ID = $domtree->createElement("cbc:ID","2000");
										$ID = $TaxScheme->appendChild($ID);
																
										//cbc:Name
										$Name2 = $domtree->createElement("cbc:Name","ISC");
										$Name2 = $TaxScheme->appendChild($Name2);
										
										//cbc:TaxTypeCode
										$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","EXC");
										$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
					
			
					//ISC - FIN					
								
								
			}
			
			
			
			
			
			
			//cac:Item
			$Item = $domtree->createElement("cac:Item");
			$Item = $InvoiceLine->appendChild($Item);	
		
					//cac:PartyName
	//				$Description = $domtree->createElement("cbc:Description");
//					$Description = $Item->appendChild($Description);
//
//					$Description->appendChild($domtree->createCDATASection($DatBoletaDetalle->BdeDescripcion )); 

					$pos = strrpos($DatBoletaDetalle->BdeDescripcion, "|");
					
					if ($pos === false) { // nota: tres signos de igual
					
						
						if(!empty($InsBoleta->OvvId)){
					
							 if(!empty($InsBoleta->BolDatoAdicional13) or !empty($InsBoleta->BolDatoAdicional7) or !empty($InsBoleta->BolDatoAdicional1)){
								
								$DatBoletaDetalle->BdeDescripcion .= "( ";
							
							  }
							
							  if(!empty($InsBoleta->BolDatoAdicional13)){
								
								$DatBoletaDetalle->BdeDescripcion .= "Nro. VIN o CHASIS: ".$InsBoleta->BolDatoAdicional13.", ";
								
							  }
							
							  if(!empty($InsBoleta->BolDatoAdicional7)){
							 
									$DatBoletaDetalle->BdeDescripcion .= "Nro. Motor: ".$InsBoleta->BolDatoAdicional7.", ";
								
							  }
							  
							  if(!empty($InsBoleta->BolDatoAdicional1)){
							 
									$DatBoletaDetalle->BdeDescripcion .= "Marca: ".$InsBoleta->BolDatoAdicional1." ";
							 
							  }
							
							  if(!empty($InsBoleta->BolDatoAdicional13) or !empty($InsBoleta->BolDatoAdicional7) or !empty($InsBoleta->BolDatoAdicional1)){
								
									$DatBoletaDetalle->BdeDescripcion .= " )";
							   
							  }
					  
						}
						//cbc:Description
						$Description = $domtree->createElement("cbc:Description");
						$Description = $Item->appendChild($Description);
						
						$Description->appendChild($domtree->createCDATASection($DatBoletaDetalle->BdeDescripcion )); 
						
					}else{
						
						$ArrRepuestos = explode("|",$DatBoletaDetalle->BdeDescripcion);
						
						$fila = 1;
						if(!empty($ArrRepuestos)){
							foreach($ArrRepuestos as $DatRepuesto){
								
								//cbc:Description
								$Description = $domtree->createElement("cbc:Description");
								$Description = $Item->appendChild($Description);
								
								if($fila==1){
									
									if(!empty($InsBoleta->OvvId)){
					
										 if(!empty($InsBoleta->BolDatoAdicional13) or !empty($InsBoleta->BolDatoAdicional7) or !empty($InsBoleta->BolDatoAdicional1)){
											
											$DatRepuesto .= "( ";
										
										  }
										
										  if(!empty($InsBoleta->BolDatoAdicional13)){
											
											$DatRepuesto .= "Nro. VIN o CHASIS: ".$InsBoleta->BolDatoAdicional13.", ";
											
										  }
										
										  if(!empty($InsBoleta->BolDatoAdicional7)){
										 
												$DatRepuesto .= "Nro. Motor: ".$InsBoleta->BolDatoAdicional7.", ";
											
										  }
										  
										  if(!empty($InsBoleta->BolDatoAdicional1)){
										 
												$DatRepuesto .= "Marca: ".$InsBoleta->BolDatoAdicional1." ";
										 
										  }
										
										  if(!empty($InsBoleta->BolDatoAdicional13) or !empty($InsBoleta->BolDatoAdicional7) or !empty($InsBoleta->BolDatoAdicional1)){
											
												$DatRepuesto .= " )";
										   
										  }
								  
									}
									
								}
								
								$Description->appendChild($domtree->createCDATASection($DatRepuesto)); 
								
								$fila++;
							}						
						}
						
					}
	
				//cac:SellersItemIdentification		
				$SellersItemIdentification = $domtree->createElement("cac:SellersItemIdentification");
				$SellersItemIdentification = $Item->appendChild($SellersItemIdentification);

					$ID = $domtree->createElement("cbc:ID");
					$ID = $SellersItemIdentification->appendChild($ID);
					$ID->appendChild($domtree->createCDATASection($DatBoletaDetalle->BdeCodigo )); 
					
			//cac:Price
			$Price = $domtree->createElement("cac:Price");
			$Price = $InvoiceLine->appendChild($Price);	
				
				
				if($DatBoletaDetalle->BdeGratuito==1){
					
					//cbc:PriceAmount currencyID="PEN"
					$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
					$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
					//$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatBoletaDetalle->BdeValorVentaUnitario,2, '.', ''));
					//$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					//$PriceAmount = $Price->appendChild($PriceAmount);	
					
				}elseif($DatBoletaDetalle->BdeGratuito==2){
					
					//cbc:PriceAmount currencyID="PEN"
					$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatBoletaDetalle->BdeValorVentaUnitario,2, '.', ''));
					$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
					
				}else{
					
					//cbc:PriceAmount currencyID="PEN"
					$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
					$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
						
				}
				
		
		
		
			if($fila==1){
				
				
				//cac:InvoiceLine
				//$InvoiceLineEspecial = $domtree->createElement("cac:InvoiceLine");
				//$InvoiceLineEspecial = $xmlRoot->appendChild($InvoiceLineEspecial);	
				
				//cac:ItemEspecial
				//$ItemEspecial = $domtree->createElement("cac:Item");
				//$ItemEspecial = $InvoiceLineEspecial->appendChild($Item);	
				
				
				
						if(!empty($InsBoleta->EinPlaca)){	
							
							//cac:AdditionalProperty
							$AdditionalProperty = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalProperty->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Numero de Placa')); 
							
							//cac:Name		
							$Value = $AdditionalProperty->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->EinPlaca)); 
							
							
						}
						
						if(!empty($InsBoleta->FinLicenciaCategoria)){
							
							//cac:AdditionalItemProperty2
							$AdditionalItemProperty2 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty2->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Categoria')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty2->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->FinLicenciaCategoria)); 
							
						}
						
						if(!empty($InsBoleta->BolDatoAdicional1)){
				
							//cac:AdditionalItemProperty5
							$AdditionalItemProperty5 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty5->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Marca')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty5->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional1)); 
							
					
						}else if(!empty($InsBoleta->VmaNombre)){
				
							//cac:AdditionalItemProperty3
							$AdditionalItemProperty3 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty3->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Marca')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty3->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->VmaNombre)); 
							
						}
						
						if(!empty($InsBoleta->BolDatoAdicional3)){	
				
							//cac:AdditionalItemProperty6
							$AdditionalItemProperty6 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty6->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Modelo')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty6->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional3)); 
							
							
						}else if(!empty($InsBoleta->VmoNombre)){
							
				
							//cac:AdditionalItemProperty4
							$AdditionalItemProperty4 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty4->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Modelo')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty4->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->VmoNombre)); 
							
							
						}
						
						
						if(!empty($InsBoleta->BolDatoAdicional15)){	
				
							
							//cac:AdditionalItemProperty7
							$AdditionalItemProperty7 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty7->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Color')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty7->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional15)); 
							
						}
						
						if(!empty($InsBoleta->BolDatoAdicional7)){	
							
				
								//cac:AdditionalItemProperty71
								$AdditionalItemProperty71 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
								
								//cac:Name		
								$Name = $AdditionalItemProperty71->appendChild($domtree->createElement('cbc:Name')); 
								$Name->appendChild($domtree->createCDATASection( 'Motor')); 
								
								//cac:Name		
								$Value = $AdditionalItemProperty71->appendChild($domtree->createElement('cbc:Value')); 
								$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional7)); 
								
				
							
						}
						
						//InsBoletaDatoAdicional8
						if(!empty($InsBoleta->BolDatoAdicional8)){	
						
				
							//cac:AdditionalItemProperty8
							$AdditionalItemProperty8 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty8->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Combustible')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty8->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional8)); 
							
						}
						
						if(!empty($InsBoleta->BolDatoAdicional888888)){	//REVISAR
				
							//cac:AdditionalItemProperty9
							$AdditionalItemProperty9 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty9->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Form. Rodante')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty9->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional888888)); 
							
							
						}
						
							
						if(!empty($InsBoleta->BolDatoAdicional13)){	
				
							//cac:AdditionalItemProperty10
							$AdditionalItemProperty10 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty10->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'VIN')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty10->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional13)); 
							
							
							
						}
						
						if(!empty($InsBoleta->BolDatoAdicional13)){	
				
							//cac:AdditionalItemProperty101
							$AdditionalItemProperty101 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty101->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Serie/Chasis')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty101->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional13)); 
							
						}
						
						
					//	if(!empty($InsBoleta->BolDatoAdicional5)){	
//				
//							
//							//cac:AdditionalItemProperty102
//							$AdditionalItemProperty102 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
//							
//							//cac:Name		
//							$Name = $AdditionalItemProperty102->appendChild($domtree->createElement('cbc:Name')); 
//							$Name->appendChild($domtree->createCDATASection( 'Año de Fabricacion')); 
//							
//							//cac:Name		
//							$Value = $AdditionalItemProperty102->appendChild($domtree->createElement('cbc:Value')); 
//							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional5)); 
//							
//						}
						
						
						
						if(!empty($InsBoleta->BolDatoAdicional27)){	//REVISAR
				
							//cac:AdditionalItemProperty103
							$AdditionalItemProperty103 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty103->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Año Modelo')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty103->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional27)); 
							
						}
				
				
						if(!empty($InsBoleta->BolDatoAdicional5555555555)){	//REVISAR
				
							//cac:AdditionalItemProperty104
							$AdditionalItemProperty104 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty104->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Version')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty104->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional5555555555)); 
							
						}
						
						if(!empty($InsBoleta->BolDatoAdicional11)){	
						
				
							//cac:AdditionalItemProperty11
							$AdditionalItemProperty11 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty11->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Ejes')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty11->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( str_pad($InsBoleta->BolDatoAdicional11,2,"0",STR_PAD_LEFT))); 
							
						}
				
						if(!empty($InsBoleta->BolDatoAdicional19)){	
				
							//cac:AdditionalItemProperty12
							$AdditionalItemProperty12 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty12->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Asientos')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty12->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( str_pad($InsBoleta->BolDatoAdicional19,4,"0",STR_PAD_LEFT))); 
							
							
						}
						
						
						if(!empty($InsBoleta->BolDatoAdicional21)){	
						
				
							//cac:AdditionalItemProperty13
							$AdditionalItemProperty13 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty13->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Pasajeros')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty13->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( str_pad($InsBoleta->BolDatoAdicional21,4,"0",STR_PAD_LEFT))); 
							
							
						}
						
						if(!empty($InsBoleta->BolDatoAdicional24)){	
				
							//cac:AdditionalItemProperty14
							$AdditionalItemProperty14 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty14->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Ruedas')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty14->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( str_pad($InsBoleta->BolDatoAdicional24,2,"0",STR_PAD_LEFT))); 
							
						}
						
												
						if(!empty($InsBoleta->BolDatoAdicional4)){	
				
							
							//cac:AdditionalItemProperty15
							$AdditionalItemProperty15 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty15->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Carroceria')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty15->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional4)); 
							
						}
						
						
						if(!empty($InsBoleta->BoletaDatoAdicional25)){	
						
				
							
							//cac:AdditionalItemProperty16
							$AdditionalItemProperty16 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty16->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Potencia')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty16->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BoletaDatoAdicional25)); 
							
						}
						
							
						if(!empty($InsBoleta->BolDatoAdicional9)){	
				
							
							//cac:AdditionalItemProperty17
							$AdditionalItemProperty17 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty17->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Cilindros')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty17->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( str_pad($InsBoleta->BolDatoAdicional9,2,"0",STR_PAD_LEFT))); 
							
						}
						
						
						if(!empty($InsBoleta->BolDatoAdicional17)){	
							
				
							
							//cac:AdditionalItemProperty18
							$AdditionalItemProperty18 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty18->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Cilindrada')); 
							
							$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional17);
							$NuevoValor = round($NuevoValor/1000,3);
							//cac:Name		
							$Value = $AdditionalItemProperty18->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor)); 
							
							
						}
					
						if(!empty($InsBoleta->BolDatoAdicional10)){	
				
							
							//cac:AdditionalItemProperty19
							$AdditionalItemProperty19 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty19->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Peso Bruto')); 
							
							$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional10);
							$NuevoValor = round($NuevoValor/1000,3);
							
							//cac:Name		
							$Value = $AdditionalItemProperty19->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor)); 
							
						}
						
						
						if(!empty($InsBoleta->BolDatoAdicional14)){	
				
							//cac:AdditionalItemProperty20
							$AdditionalItemProperty20 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty20->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Peso Neto')); 
							
							$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional14);
							$NuevoValor = round($NuevoValor/1000,3);
							
							//cac:Name		
							$Value = $AdditionalItemProperty20->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor));
							
						}
						
						
						
						if(!empty($InsBoleta->BolDatoAdicional12)){	
				
							
							//cac:AdditionalItemProperty21
							$AdditionalItemProperty21 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty21->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Carga Util')); 
							
							$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional12);
							$NuevoValor = round($NuevoValor/1000,3);
							
							//cac:Name		
							$Value = $AdditionalItemProperty21->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor));
							
						}
						
						if(!empty($InsBoleta->BolDatoAdicional18)){	
				
							//cac:AdditionalItemProperty22
							$AdditionalItemProperty22 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty22->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Longitud')); 
							
							$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional18);
							$NuevoValor = round($NuevoValor/1000,3);
							
							//cac:Name		
							$Value = $AdditionalItemProperty22->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor));
							
						}
						
												
						if(!empty($InsBoleta->BolDatoAdicional16)){	
							
				
							//cac:AdditionalItemProperty23
							$AdditionalItemProperty23 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty23->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Altura')); 
							
							$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional16);
							$NuevoValor = round($NuevoValor/1000,3);
							
							//cac:Name		
							$Value = $AdditionalItemProperty23->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor));
							
						}
						
												
						if(!empty($InsBoleta->BolDatoAdicional20)){	
							
							//cac:AdditionalItemProperty24
							$AdditionalItemProperty24 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty24->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Ancho')); 
							
							$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional20);
							$NuevoValor = round($NuevoValor/1000,3);
							
							//cac:Name		
							$Value = $AdditionalItemProperty24->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor));
							
						}
										

				
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