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

$InsBoleta->CliNombre = trim($InsBoleta->CliNombre);
$InsBoleta->CliApellidoPaterno = trim($InsBoleta->CliApellidoPaterno);
$InsBoleta->CliApellidoMaterno = trim($InsBoleta->CliApellidoMaterno);

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

//<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
   
   
$xmlRoot->setAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
$xmlRoot->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
$xmlRoot->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
$xmlRoot->setAttribute('xmlns:ccts', 'urn:un:unece:uncefact:documentation:2');
$xmlRoot->setAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
$xmlRoot->setAttribute('xmlns:ext', 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2');
$xmlRoot->setAttribute('xmlns:qdt', 'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2');
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
//
////sac:AdditionalInformation
//$AdditionalInformation = $domtree->createElement("sac:AdditionalInformation");
//$AdditionalInformation = $ExtensionContent1->appendChild($AdditionalInformation);
//
//
/////'cbc:ID','1001'	//TOTAL VENTAS GRAVADAS
////sac:AdditionalMonetaryTotal
//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1001'));
//
////sac:PayableAmount
////$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolSubTotal,2, '.', ''));
//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalGravado,2, '.', ''));
//$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
//
/////'cbc:ID','1003'	//TOTAL EXONERADAS
////sac:AdditionalMonetaryTotal
//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1003'));
//
////sac:PayableAmount
//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalExonerado,2, '.', ''));
//$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
//
////'cbc:ID','1004'	//TOTAL GRATUITAS
////sac:AdditionalMonetaryTotal
//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1004'));
//
////sac:PayableAmount
//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalGratuito,2, '.', ''));
//$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
//
////'cbc:ID','2005' //TOTAL DESCUENTOS
////sac:AdditionalMonetaryTotal
//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','2005'));
//
////sac:PayableAmount
//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalDescuento,2, '.', ''));
//$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
//
//
/////'cbc:ID','1000' //TOTAL EN LETRAS
////sac:AdditionalProperty
//$AdditionalProperty = $domtree->createElement("sac:AdditionalProperty");
//$AdditionalProperty = $AdditionalInformation->appendChild($AdditionalProperty);
//$AdditionalProperty->appendChild($domtree->createElement('cbc:ID','1000'));
//
////cbc:Value
//$Value = $domtree->createElement("cbc:Value",$BoletaTotalLetras);
//$Value = $AdditionalProperty->appendChild($Value);
//
//
//if(!empty($InsBoleta->BolLeyenda)){
//
//
/////'cbc:ID','1002' //LEYENDA
////sac:AdditionalProperty
//$AdditionalProperty = $domtree->createElement("sac:AdditionalProperty");
//$AdditionalProperty = $AdditionalInformation->appendChild($AdditionalProperty);
//$AdditionalProperty->appendChild($domtree->createElement('cbc:ID','1002'));
//
////cbc:Value
//$Value = $domtree->createElement("cbc:Value",$InsBoleta->BolLeyenda);
//$Value = $AdditionalProperty->appendChild($Value);
//
//	
//}


//
////ext:UBLExtension2
//$UBLExtension2 = $domtree->createElement("ext:UBLExtension");
//$UBLExtension2 = $UBLExtensions->appendChild($UBLExtension2);
//
////sac:ExtensionContent2
//$ExtensionContent2 = $domtree->createElement("ext:ExtensionContent");
//$ExtensionContent2 = $UBLExtension2->appendChild($ExtensionContent2);
//
//


//ext:UBLVersionID
$UBLVersionID = $domtree->createElement("cbc:UBLVersionID","2.1");
$UBLVersionID = $xmlRoot->appendChild($UBLVersionID);

//ext:CustomizationID
$CustomizationID = $domtree->createElement("cbc:CustomizationID","2.0");
$CustomizationID = $xmlRoot->appendChild($CustomizationID);

//cbc:ID
$ID = $domtree->createElement("cbc:ID",$InsBoleta->BtaNumero."-".$InsBoleta->BolId);
$ID = $xmlRoot->appendChild($ID);

//cbc:IssueDate
$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($InsBoleta->BolFechaEmision));
$IssueDate = $xmlRoot->appendChild($IssueDate);
//cbc:IssueTime
$IssueTime = $domtree->createElement("cbc:IssueTime",($InsBoleta->BolHoraEmision));
$IssueTime = $xmlRoot->appendChild($IssueTime);

//cbc:InvoiceTypeCode
//$InvoiceTypeCode = $domtree->createElement("cbc:InvoiceTypeCode","01");
//$InvoiceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
//$InvoiceTypeCode->setAttribute('listName', "SUNAT:Identificador de Tipo de Documento");
//$InvoiceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
//$InvoiceTypeCode = $xmlRoot->appendChild($InvoiceTypeCode);
$InvoiceTypeCode = $domtree->createElement("cbc:InvoiceTypeCode","03");
$InvoiceTypeCode->setAttribute('listID', "0101");
$InvoiceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
$InvoiceTypeCode->setAttribute('listName', "SUNAT:Identificador de Tipo de Documento");
$InvoiceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
$InvoiceTypeCode = $xmlRoot->appendChild($InvoiceTypeCode);


////cbc:ProfileID
//$ProfileID = $domtree->createElement("cbc:ProfileID","0101");
//$ProfileID->setAttribute('schemeName', "SUNAT:Identificador de Tipo de Operación");
//$ProfileID->setAttribute('schemeAgencyName', "PE:SUNAT");
//$ProfileID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo17");
//$ProfileID = $xmlRoot->appendChild($ProfileID);



////cbc:InvoiceTypeCode
//$InvoiceTypeCode = $domtree->createElement("cbc:InvoiceTypeCode","01");
//$InvoiceTypeCode = $xmlRoot->appendChild($InvoiceTypeCode);

	
//cbc:Note
//$Note = $domtree->createElement("cbc:Note",$domtree->createCDATASection($BoletaTotalLetras));
$Note = $domtree->createElement("cbc:Note",($BoletaTotalLetras));
$Note->setAttribute('languageLocaleID', "1000");
$Note = $xmlRoot->appendChild($Note);
	
////cbc:DocumentCurrencyCode
//$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsBoleta->MonSigla);
//$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);

//cbc:DocumentCurrencyCode
$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsBoleta->MonSigla);
$DocumentCurrencyCode->setAttribute('listID', "ISO 4217 Alpha");
$DocumentCurrencyCode->setAttribute('listName', "Currency");
$DocumentCurrencyCode->setAttribute('listAgencyName', "United Nations Economic Commission for Europe");
$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);



/*<cac:DespatchDocumentReference>
	<cbc:ID>0001-0000008</cbc:ID>
	<cbc:DocumentTypeCode listAgencyName="PE:SUNAT" listName="SUNAT:Identificador de guíarelacionada" listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01">09</cbc:DocumentTypeCode>
</cac:DespatchDocumentReference>
*/


if(!empty($InsBoleta->BolGuiaRemisionNumero)){
	
	//cac:DespatchDocumentReference
	$DespatchDocumentReference = $domtree->createElement("cac:DespatchDocumentReference");
	$DespatchDocumentReference = $xmlRoot->appendChild($DespatchDocumentReference);
				
		//cbc:ID
		$ID = $domtree->createElement("cbc:ID",$InsBoleta->BolGuiaRemisionNumero);
		$ID = $DespatchDocumentReference->appendChild($ID);
		
		//cbc:DocumentTypeCode
		$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode",("09"));
		$DocumentTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
		$DocumentTypeCode->setAttribute('listName', "SUNAT:Identificador de guía relacionada");
		$DocumentTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
		$DocumentTypeCode = $DespatchDocumentReference->appendChild($DocumentTypeCode);	
		
		
}

if(!empty($InsBoleta->BolGuiaRemisionTransportistaNumero)){
	
	//cac:DespatchDocumentReference
	$DespatchDocumentReference = $domtree->createElement("cac:DespatchDocumentReference");
	$DespatchDocumentReference = $xmlRoot->appendChild($DespatchDocumentReference);
				
		//cbc:ID
		$ID = $domtree->createElement("cbc:ID",$InsBoleta->BolGuiaRemisionTransportistaNumero);
		$ID = $DespatchDocumentReference->appendChild($ID);
		
		//cbc:DocumentTypeCode
		$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode",("09"));
		$DocumentTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
		$DocumentTypeCode->setAttribute('listName', "SUNAT:Identificador de guía relacionada");
		$DocumentTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
		$DocumentTypeCode = $DespatchDocumentReference->appendChild($DocumentTypeCode);	
		
		
}
//if(!empty($InsBoleta->BolGuiaRemisionTransportistaNumero)){
//	
//	//cac:DespatchDocumentReference
//	$AdditionalDocumentReference = $domtree->createElement("cac:AdditionalDocumentReference");
//	$AdditionalDocumentReference = $xmlRoot->appendChild($AdditionalDocumentReference);
//				
//		//cbc:ID
//		$ID = $domtree->createElement("cbc:ID",$InsBoleta->BolGuiaRemisionTransportistaNumero);
//		$ID = $DespatchDocumentReference->appendChild($AdditionalDocumentReference);
//		
//		//cbc:DocumentTypeCode
//		$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode",("99"));
//		$DocumentTypeCode->setAttribute('listName', "Documento Relacionado");
//		$DocumentTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
//		$DocumentTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo12");
//		$DocumentTypeCode = $AdditionalDocumentReference->appendChild($DocumentTypeCode);	
//		
//}

			
			

/*
<cac:DespatchDocumentReference> 
<cbc:ID>0001-002020</cbc:ID> 
<cbc:DocumentTypeCode>09</cbc:DocumentTypeCode> 
</cac:DespatchDocumentReference>
*/

/*<?php echo $InsBoleta->GrtNumero;?> - <?php echo $InsBoleta->GreId;?>
*/
//if(!empty($InsBoleta->GreId)){
//	
//	//cac:DespatchDocumentReference
//	$DespatchDocumentReference = $domtree->createElement("cac:DespatchDocumentReference");
//	$DespatchDocumentReference = $xmlRoot->appendChild($DespatchDocumentReference);
//		
//		//cbc:ID
//		$ID = $domtree->createElement("cbc:ID",$InsBoleta->GrtNumero."-".$InsBoleta->GreId);
//		$ID = $DespatchDocumentReference->appendChild($ID);
//		
//		//cbc:ID
//		$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode","09");
//		$DocumentTypeCode = $DespatchDocumentReference->appendChild($ID);
//
//}

	
	
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

	////cbc:CustomerAssignedAccountID
//	$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$EmpresaCodigo);
//	$CustomerAssignedAccountID = $AccountingSupplierParty->appendChild($CustomerAssignedAccountID);
//	
//	//cbc:AdditionalAccountID
//	$AdditionalAccountID = $domtree->createElement("cbc:AdditionalAccountID","6");
//	$AdditionalAccountID = $AccountingSupplierParty->appendChild($AdditionalAccountID);

	//cac:Party
	$Party = $domtree->createElement("cac:Party");
	$Party = $AccountingSupplierParty->appendChild($Party);
				
		//cac:PartyIdentification
		$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
		$PartyIdentification = $Party->appendChild($PartyIdentification);
			
			//cbc:Note
			//$CompanyID = $domtree->createElement("cbc:CompanyID",$domtree->createCDATASection($EmpresaCodigo));
			$CompanyID = $domtree->createElement("cbc:ID",($EmpresaCodigo));
			$CompanyID->setAttribute('schemeID', "6");
			$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
			$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
			$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
			$CompanyID = $PartyIdentification->appendChild($CompanyID);	


		
		//cac:PartyName
		$PartyName = $Party->appendChild($domtree->createElement( 'cac:PartyName' ));
		
			//cac:Name		
			$Name = $PartyName->appendChild($domtree->createElement('cbc:Name')); 
			$Name->appendChild($domtree->createCDATASection( $EmpresaNombre)); 
			
			
			
						
		//cac:PartyLegalEntity
		$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
		$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);
			
			 //cbc:RegistrationName		
			$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
			$RegistrationName->appendChild($domtree->createCDATASection( $EmpresaNombre)); 
		
			
			
			
	
			
		/*//cac:PartyTaxScheme
		$PartyTaxScheme = $Party->appendChild($domtree->createElement( 'cac:PartyTaxScheme' ));
		
			//cbc:RegistrationName		
			$RegistrationName = $PartyTaxScheme->appendChild($domtree->createElement('cbc:RegistrationName')); 
			$RegistrationName->appendChild($domtree->createCDATASection( $EmpresaNombre)); 
			
			//cbc:Note
			//$CompanyID = $domtree->createElement("cbc:CompanyID",$domtree->createCDATASection($EmpresaCodigo));
			$CompanyID = $domtree->createElement("cbc:CompanyID",($EmpresaCodigo));
			$CompanyID->setAttribute('schemeID', "6");
			$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
			$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
			$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
			$CompanyID = $PartyTaxScheme->appendChild($CompanyID);	
				
		
				
			//cac:RegistrationAddress
			$RegistrationAddress = $PartyTaxScheme->appendChild($domtree->createElement( 'cac:RegistrationAddress' ));
			
				//cbc:ID		
				$AddressTypeCode = $RegistrationAddress->appendChild($domtree->createElement('cbc:AddressTypeCode',"0000")); 
				//$AddressTypeCode->appendChild($domtree->createCDATASection( "0000")); 
				
			//cac:TaxScheme
			$TaxScheme = $PartyTaxScheme->appendChild($domtree->createElement( 'cac:TaxScheme' ));
			
				//cbc:ID		
				$ID = $TaxScheme->appendChild($domtree->createElement('cbc:ID',"-")); 
				//$ID->appendChild($domtree->createCDATASection( "-")); 
				
				*/
				
				
				
	//	//cac:PostalAddress
//		$PostalAddress = $domtree->createElement("cac:PostalAddress");
//		$PostalAddress = $Party->appendChild($PostalAddress);
//		
//			//cbc:ID
//			$ID = $domtree->createElement("cbc:ID","230101");
//			$ID = $PostalAddress->appendChild($ID);
//			
//			//cbc:StreetName
//			$StreetName = $domtree->createElement("cbc:StreetName",$EmpresaDireccion);
//			$StreetName = $PostalAddress->appendChild($StreetName);
//	
//			//cbc:District
//			$District = $domtree->createElement("cbc:District",$EmpresaDistrito);
//			$District = $PostalAddress->appendChild($District);
//			
//			//cac:Country
//			$Country = $domtree->createElement("cac:Country");
//			$Country = $PostalAddress->appendChild($Country);
//			
//			//cbc:IdentificationCode
//			$IdentificationCode = $domtree->createElement("cbc:IdentificationCode","PE");
//			$IdentificationCode = $Country->appendChild($IdentificationCode);
//	
//		//cac:PartyLegalEntity
//		$base = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
//		
//		//cac:Name		
//		$name = $base->appendChild($domtree->createElement('cbc:RegistrationName')); 
//		$name->appendChild($domtree->createCDATASection( $EmpresaNombre)); 
		
		
	
	
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

	//cac:AccountingCustomerParty
	$AccountingCustomerParty = $domtree->createElement("cac:AccountingCustomerParty");
	$AccountingCustomerParty = $xmlRoot->appendChild($AccountingCustomerParty);
	
	//	//cbc:CustomerAssignedAccountID
	//	$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$InsBoleta->CliNumeroDocumento);
	//	$CustomerAssignedAccountID = $AccountingCustomerParty->appendChild($CustomerAssignedAccountID);	
	//	
	//	//cbc:AdditionalAccountID
	//	$AdditionalAccountID = $domtree->createElement("cbc:AdditionalAccountID","6");
	//	$AdditionalAccountID = $AccountingCustomerParty->appendChild($AdditionalAccountID);
	
		//cac:Party
		$Party = $domtree->createElement("cac:Party");
		$Party = $AccountingCustomerParty->appendChild($Party);
			
			//cac:PartyIdentification
			$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
			$PartyIdentification = $Party->appendChild($PartyIdentification);
				
				//cbc:Note
				//$CompanyID = $domtree->createElement("cbc:CompanyID",$domtree->createCDATASection($EmpresaCodigo));
				$CompanyID = $domtree->createElement("cbc:ID",($InsBoleta->CliNumeroDocumento));
				$CompanyID->setAttribute('schemeID', round($InsBoleta->TdoCodigo));
				$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
				$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
				$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
				$CompanyID = $PartyIdentification->appendChild($CompanyID);	
	
							
			//cac:PartyLegalEntity
			$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
			$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);
				
				 //cbc:RegistrationName		
				$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
				$RegistrationName->appendChild($domtree->createCDATASection($InsBoleta->CliNombre." ".$InsBoleta->CliApellidoPaterno." ".$InsBoleta->CliApellidoMaterno ."".$Propietarios)); 
			
				
			/*
			//cac:PartyTaxScheme
			$PartyTaxScheme = $Party->appendChild($domtree->createElement( 'cac:PartyTaxScheme' ));
			
				//cbc:RegistrationName		
				$RegistrationName = $PartyTaxScheme->appendChild($domtree->createElement('cbc:RegistrationName')); 
				$RegistrationName->appendChild($domtree->createCDATASection( $InsBoleta->CliNombre." ".$InsBoleta->CliApellidoPaterno." ".$InsBoleta->CliApellidoMaterno)); 
				
				//cbc:Note
				//$CompanyID = $domtree->createElement("cbc:CompanyID",$domtree->createCDATASection($InsBoleta->CliNumeroDocumento));
				$CompanyID = $domtree->createElement("cbc:CompanyID",($InsBoleta->CliNumeroDocumento));
				$CompanyID->setAttribute('schemeID', "6");
				$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
				$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
				$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
				$CompanyID = $PartyTaxScheme->appendChild($CompanyID);	
					
				//cac:TaxScheme
				$TaxScheme = $PartyTaxScheme->appendChild($domtree->createElement( 'cac:TaxScheme' ));
				
					//cbc:ID		
					$ID = $TaxScheme->appendChild($domtree->createElement('cbc:ID',"-")); 
					//$ID->appendChild(( "-")); 
					*/
					
	
//DESCUENTO GENERAL	
if($InsBoleta->BolPorcentajeDescuentoGlobal>0){
	
	$InsBoleta->BolPorcentajeDescuentoGlobal = round($InsBoleta->BolPorcentajeDescuentoGlobal/100,2);
	
	//cac:LegalMonetaryTotal
	$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
	$AllowanceCharge = $xmlRoot->appendChild($AllowanceCharge);
	
		//cbc:ChargeIndicator
		$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","False");
		$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);
		
		//cbc:AllowanceChargeReasonCode
		$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode","00");
		$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);
		
		//cbc:MultiplierBoltorNumeric
		$MultiplierBoltorNumeric = $domtree->createElement("cbc:MultiplierBoltorNumeric",number_format($InsBoleta->BolPorcentajeDescuentoGlobal,2, '.', ''));
		$MultiplierBoltorNumeric = $AllowanceCharge->appendChild($MultiplierBoltorNumeric);
	
		//cbc:Amount
		//TOTAL DESCUENTO GLOBAL (NO ITEMS)
		$Amount = $domtree->createElement("cbc:Amount",number_format($InsBoleta->BolTotalDescuentoGlobal,2, '.', ''));
		$Amount->setAttribute('currencyID', $InsBoleta->MonSigla);
		$Amount = $AllowanceCharge->appendChild($Amount);
	
		//cbc:Amount
		//TOTAL SUMA VALORES DE VENTA
		$BaseAmount = $domtree->createElement("cbc:BaseAmount",number_format($InsBoleta->BolTotalGravado,2, '.', ''));
		$BaseAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
		$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);
			
}



				

//	//cac:DeliveryTerms
//	$DeliveryTerms = $domtree->createElement("cac:DeliveryTerms");
//	$DeliveryTerms = $xmlRoot->appendChild($DeliveryTerms);
//	
//		//cac:DeliveryLocation
//		$DeliveryLocation = $domtree->createElement("cac:DeliveryLocation");
//		$DeliveryLocation = $DeliveryTerms->appendChild($DeliveryLocation);
//		
//			//cac:Address
//			$Address = $domtree->createElement("cac:Address");
//			$Address = $DeliveryLocation->appendChild($Address);
//						
//				//cbc:StreetName		
//				$StreetName = $Address->appendChild($domtree->createElement('cbc:StreetName')); 
//				$StreetName->appendChild($domtree->createCDATASection( $InsBoleta->CliDireccion )); 
////				
//
//				//cbc:IdentificationCode
//				$IdentificationCode = $domtree->createElement("cbc:IdentificationCode","PE");
//				$IdentificationCode->setAttribute('listID', "ISO 3166-1");
//				$IdentificationCode->setAttribute('listAgencyName', "United Nations Economic
//Commission for Europe");
//				$IdentificationCode->setAttribute('listName', "Country");
//				$IdentificationCode = $Address->appendChild($IdentificationCode);
//				
				
				
//		//cac:PhysicalLocation
//		$PhysicalLocation = $Party->appendChild($domtree->createElement( 'cac:PhysicalLocation' ));
//		
//		//cac:Name		
//		$Description = $PhysicalLocation->appendChild($domtree->createElement('cbc:Description')); 
//		$Description->appendChild($domtree->createCDATASection( $InsBoleta->CliDireccion )); 
//			
//		//cac:PartyLegalEntity
//		$PartyLegalEntity = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
//		
//		//cac:Name		
//		$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
//		$RegistrationName->appendChild($domtree->createCDATASection( $InsBoleta->CliNombre." ".$InsBoleta->CliApellidoPaterno." ".$InsBoleta->CliApellidoMaterno )); 
		
//cac:TaxTotal
$TaxTotal = $domtree->createElement("cac:TaxTotal");
$TaxTotal = $xmlRoot->appendChild($TaxTotal);

	//cbc:TaxAmount
	//SUMA TOTAL IGV
	$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsBoleta->BolImpuesto,2, '.', ''));
	$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
	$TaxAmount = $TaxTotal->appendChild($TaxAmount);
			
	//cac:TaxSubtotal
	$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
	$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
		
		//cbc:TaxableAmount 
		//SUMA TOTAL GRAVADOS
		$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsBoleta->BolTotalGravado,2, '.', ''));
		$TaxableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
		$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
		
		//cbc:TaxAmount 
		$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsBoleta->BolImpuesto,2, '.', ''));
		$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
		$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
		
		//cac:TaxCategory
		$TaxCategory = $domtree->createElement("cac:TaxCategory");
		$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
			
			//cbc:TaxAmount 
			$ID = $domtree->createElement("cbc:ID","S");
			$ID->setAttribute('schemeID', "UN/ECE 5305");
			$ID->setAttribute('schemeName', "Tax Category Identifier");
			$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
			$ID = $TaxCategory->appendChild($ID);
			
			//cac:TaxScheme
			$TaxScheme = $domtree->createElement("cac:TaxScheme");
			$TaxScheme = $TaxCategory->appendChild($TaxScheme);


				//cbc:TaxAmount 
				$ID = $domtree->createElement("cbc:ID","1000");
				$ID->setAttribute('schemeID', "UN/ECE 5153");
				$ID->setAttribute('schemeAgencyID', "6");
				$ID = $TaxScheme->appendChild($ID);

					//cbc:Name
				$Name = $domtree->createElement("cbc:Name","IGV");
				$Name = $TaxScheme->appendChild($Name);

				//cbc:TaxTypeCode
				$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","VAT");
				$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
				
				
				
	if($InsBoleta->BolTotalExonerado>0){
	
		//SUMA TOTAL EXONERADOS
		//cac:TaxSubtotal
		$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
		$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
			
			//cbc:TaxableAmount 
			$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsBoleta->BolTotalExonerado,2, '.', ''));
			$TaxableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
			$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
			
			//cbc:TaxAmount 
			$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
			$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
			$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
			
			//cac:TaxCategory
			$TaxCategory = $domtree->createElement("cac:TaxCategory");
			$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
				
				//cbc:TaxAmount 
				$ID = $domtree->createElement("cbc:ID","E");
				$ID->setAttribute('schemeID', "UN/ECE 5305");
				$ID->setAttribute('schemeName', "Tax Category Identifier");
				$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
				$ID = $TaxCategory->appendChild($ID);
				
				//cac:TaxScheme
				$TaxScheme = $domtree->createElement("cac:TaxScheme");
				$TaxScheme = $TaxCategory->appendChild($TaxScheme);
	
					//cbc:TaxAmount 
					$ID = $domtree->createElement("cbc:ID","9997");
					$ID->setAttribute('schemeID', "UN/ECE 5153");
					$ID->setAttribute('schemeAgencyID', "6");
					$ID = $TaxScheme->appendChild($ID);
	
					//cbc:Name
					$Name = $domtree->createElement("cbc:Name","EXONERADO");
					$Name = $TaxScheme->appendChild($Name);
	
					//cbc:TaxTypeCode
					$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","VAT");
					$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);	
					
							
	}
	
		
					
	if($InsBoleta->BolTotalGratuito>0){
	
		//SUMA TOTAL INAFECTO (GRATUITO)
		//cac:TaxSubtotal
		$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
		$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
			
			//cbc:TaxableAmount 
			$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsBoleta->BolTotalGratuito,2, '.', ''));
			$TaxableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
			$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
			
			//cbc:TaxAmount 
			$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
			$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
			$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
			
			//cac:TaxCategory
			$TaxCategory = $domtree->createElement("cac:TaxCategory");
			$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
				
				//cbc:TaxAmount 
				$ID = $domtree->createElement("cbc:ID","O");
				$ID->setAttribute('schemeID', "UN/ECE 5305");
				$ID->setAttribute('schemeName', "Tax Category Identifier");
				$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
				$ID = $TaxCategory->appendChild($ID);
				
				//cac:TaxScheme
				$TaxScheme = $domtree->createElement("cac:TaxScheme");
				$TaxScheme = $TaxCategory->appendChild($TaxScheme);
	
					//cbc:TaxAmount 
					$ID = $domtree->createElement("cbc:ID","9996");
					$ID->setAttribute('schemeID', "UN/ECE 5153");
					$ID->setAttribute('schemeAgencyID', "6");
					$ID = $TaxScheme->appendChild($ID);
	
					//cbc:Name
					$Name = $domtree->createElement("cbc:Name","GRA");
					$Name = $TaxScheme->appendChild($Name);
	
					//cbc:TaxTypeCode
					$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","FRE");
					$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);	
					
							
	}		
				
				
				
				
//
//				//cbc:ID
//				$ID = $domtree->createElement("cbc:ID","1000");
//				$ID = $TaxScheme->appendChild($ID);
//				
	
	
	



//
//
//	
//	
//	////cbc:TaxInclusiveAmount
////	$TaxInclusiveAmount = $domtree->createElement("cbc:TaxInclusiveAmount",number_format($InsBoleta->BolSubTotal,2, '.', ''));
////	$TaxInclusiveAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
////	$TaxInclusiveAmount = $LegalMonetaryTotal->appendChild($TaxInclusiveAmount);
//
//	//cbc:AllowanceTotalAmount currencyID="PEN"
//	$AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount",number_format($InsBoleta->BolTotalDescuento,2, '.', ''));
//	$AllowanceTotalAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
//	$AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
//	
//	//cbc:PayableAmount currencyID="PEN"
//	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalPagar,2, '.', ''));
//	$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
//	$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);
//	
	
 
//cac:LegalMonetaryTotal
$LegalMonetaryTotal = $domtree->createElement("cac:LegalMonetaryTotal");
$LegalMonetaryTotal = $xmlRoot->appendChild($LegalMonetaryTotal);

	//cbc:LineExtensionAmount
	$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount",number_format($InsBoleta->BolSubTotal,2, '.', ''));
	$LineExtensionAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
	$LineExtensionAmount = $LegalMonetaryTotal->appendChild($LineExtensionAmount);
	
	//cbc:TaxInclusiveAmount
	////SUMA TOTAL DE LA VENTA - OTROS CARGOS
	$TaxInclusiveAmount = $domtree->createElement("cbc:TaxInclusiveAmount",number_format($InsBoleta->BolTotal,2, '.', ''));
	$TaxInclusiveAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
	$TaxInclusiveAmount = $LegalMonetaryTotal->appendChild($TaxInclusiveAmount);

	//cbc:AllowanceTotalAmount 
	//SUMA TOTAL DESCUENTOS GENERAL + ITEMS
	$AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount",number_format($InsBoleta->BolTotalDescuento,2, '.', ''));
	$AllowanceTotalAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
	$AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
	
	if($InsBoleta->BolTotalOtrosCargos>0){
		
		//cbc:ChargeTotalAmount 
		//SUMA TOTAL OTROS CARGOS
		$ChargeTotalAmount = $domtree->createElement("cbc:ChargeTotalAmount",number_format($InsBoleta->BolTotalOtrosCargos,2, '.', ''));
		$ChargeTotalAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
		$ChargeTotalAmount = $LegalMonetaryTotal->appendChild($ChargeTotalAmount);
		
	}
	
	//cbc:PayableAmount currencyID="PEN"
	//SUMA TOTAL DE LA VENTA
	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotal,2, '.', ''));
	$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
	$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);
	
$fila = 1;
if(!empty($InsBoleta->BoletaDetalle)){
	foreach($InsBoleta->BoletaDetalle as $DatBoletaDetalle){
			
		$DatBoletaDetalle->BdeDescripcion  = trim($DatBoletaDetalle->BdeDescripcion );
		
		if($InsBoleta->MonId<>$EmpresaMonedaId ){
			
			$DatBoletaDetalle->BdeImporte = ($DatBoletaDetalle->BdeImporte / $InsBoleta->BolTipoCambio);
			$DatBoletaDetalle->BdePrecio = ($DatBoletaDetalle->BdePrecio  / $InsBoleta->BolTipoCambio);
			$DatBoletaDetalle->BdeValorVenta = ($DatBoletaDetalle->BdeValorVenta  / $InsBoleta->BolTipoCambio);
			$DatBoletaDetalle->BdeValorVentaUnitario = ($DatBoletaDetalle->BdeValorVentaUnitario  / $InsBoleta->BolTipoCambio);
			
			$DatBoletaDetalle->BdeImpuesto = ($DatBoletaDetalle->BdeImpuesto  / $InsBoleta->BolTipoCambio);
			$DatBoletaDetalle->BdeValorVentaBruto = ($DatBoletaDetalle->BdeValorVentaBruto  / $InsBoleta->BolTipoCambio);
			
		}

		//cac:InvoiceLine
		$InvoiceLine = $domtree->createElement("cac:InvoiceLine");
		$InvoiceLine = $xmlRoot->appendChild($InvoiceLine);	
			
			//cbc:ID
			$ID = $domtree->createElement("cbc:ID",$fila);
			$ID = $InvoiceLine->appendChild($ID);	
			
			//cbc:InvoicedQuantity unitCode="NIU"
			$InvoicedQuantity = $domtree->createElement("cbc:InvoicedQuantity",number_format($DatBoletaDetalle->BdeCantidad,2, '.', ''));
			
			//if($DatBoletaDetalle->BdeValidarStock==2){
//				$InvoicedQuantity->setAttribute('unitCode', 'ZZ');
//			}else{
//				$InvoicedQuantity->setAttribute('unitCode', 'NIU');	
//			}
			
			switch($DatBoletaDetalle->BdeTipo){
				
				case "R":
					$InvoicedQuantity->setAttribute('unitCode', 'NIU');	
				break;
								
				case "S":
					$InvoicedQuantity->setAttribute('unitCode', 'ZZ');
				break;
				
				case "M":
					$InvoicedQuantity->setAttribute('unitCode', 'NIU');	
				break;
				
				case "T":
					$InvoicedQuantity->setAttribute('unitCode', 'NIU');	
				break;
				
				default:
					$InvoicedQuantity->setAttribute('unitCode', 'NIU');	
				break;
				
			}
			

	
	
			$InvoicedQuantity->setAttribute('unitCodeListID', 'UN/ECE rec 20');
			$InvoicedQuantity->setAttribute('unitCodeListAgencyName', 'Europe');
			$InvoicedQuantity = $InvoiceLine->appendChild($InvoicedQuantity);	
			
			
			//cbc:LineExtensionAmount currencyID="PEN"
			$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount",number_format($DatBoletaDetalle->BdeValorVenta,2, '.', ''));
			$LineExtensionAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
			$LineExtensionAmount = $InvoiceLine->appendChild($LineExtensionAmount);	
				
			//cac:PricingReference
			$PricingReference = $domtree->createElement("cac:PricingReference");
			$PricingReference = $InvoiceLine->appendChild($PricingReference);	
				
				
			//VALOR REFERENCIAL UNITARIO POR ITEM EN OPERACIONES NO ONEROSAS
			
			if($DatBoletaDetalle->BdeGratuito==1){
				
				//cac:AlternativeConditionPrice
				$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
				$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
				
					//cbc:PriceAmount currencyID="PEN"
					$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatBoletaDetalle->BdeValorVentaUnitario,2, '.', ''));
					$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	
					//cbc:PriceTypeCode
					$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","02");
					$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
					$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
					$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
					$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
				
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
					$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
					$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
					$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
					$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
				
			}
			
			//DESCUENTOS POR ITEM	
		
			if($DatBoletaDetalle->BdeDescuento>0){
				
				$DatBoletaDetalle->BdePorcentajeDescuento = round($DatBoletaDetalle->BdePorcentajeDescuento/100,2);
				
				//cac:AllowanceCharge
				$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
				$AllowanceCharge = $InvoiceLine->appendChild($AllowanceCharge);					
								
					//cbc:ChargeIndicator
					$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","false");
					$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);
					
					//cbc:AllowanceChargeReasonCode
					$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode","00");//X
					$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);
								
					////cbc:MultiplierBoltorNumeric
//					$MultiplierBoltorNumeric = $domtree->createElement("cbc:MultiplierBoltorNumeric",$DatBoletaDetalle->BdePorcentajeDescuento);//X
//					$MultiplierBoltorNumeric = $AllowanceCharge->appendChild($MultiplierBoltorNumeric);
									
					//cbc:Amount
					$Amount = $domtree->createElement("cbc:Amount",number_format($DatBoletaDetalle->BdeDescuento,2, '.', ''));
					$Amount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$Amount = $AllowanceCharge->appendChild($Amount);		
					
					//cbc:BaseAmount
					$BaseAmount = $domtree->createElement("cbc:BaseAmount",number_format($DatBoletaDetalle->BdeValorVentaBruto,2, '.', ''));					
					$BaseAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);		
					
					
			}
					
		//OTROS CARGOS POR ITEM	
		// NO SE USA
			if($DatBoletaDetalle->BdeOtroCargo>0){
				
				$DatBoletaDetalle->BdePorcentajeOtroCargo = round($DatBoletaDetalle->BdePorcentajeOtroCargo/100,2);
				
				//cac:AllowanceCharge
				$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
				$AllowanceCharge = $InvoiceLine->appendChild($AllowanceCharge);					
								
					//cbc:ChargeIndicator
					$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","true");
					$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);
					
					//cbc:AllowanceChargeReasonCode
					$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode","5");//X
					$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);
								
					////cbc:MultiplierBoltorNumeric
//					$MultiplierBoltorNumeric = $domtree->createElement("cbc:MultiplierBoltorNumeric",$DatBoletaDetalle->BdePorcentajeDescuento);//X
//					$MultiplierBoltorNumeric = $AllowanceCharge->appendChild($MultiplierBoltorNumeric);
									
					//cbc:Amount
					$Amount = $domtree->createElement("cbc:Amount",$DatBoletaDetalle->BdeOtroCargo);
					$Amount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$Amount = $AllowanceCharge->appendChild($Amount);		
					
					//cbc:BaseAmount
					$BaseAmount = $domtree->createElement("cbc:BaseAmount",$InsBoletaDetalle1->BdeValorVentaBruto);//REVISAR ESTE MONTO
					$BaseAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);		
					
					
			}
			
			
			
			
			
			
			
			
			
				
		//cac:TaxTotal
		$TaxTotal = $domtree->createElement("cac:TaxTotal");
		$TaxTotal = $InvoiceLine->appendChild($TaxTotal);
		
		
			if($DatBoletaDetalle->BdeExonerado == "1"){
				
				//cbc:TaxAmount
				$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
				$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);
						
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
					
					//cbc:TaxableAmount 
					$TaxableAmount = $domtree->createElement("cbc:TaxableAmount","0.00");
					$TaxableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
					
					//cbc:TaxAmount 


					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeValorVenta,2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
					
					//cac:TaxCategory
					$TaxCategory = $domtree->createElement("cac:TaxCategory");
					$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
						
						//cbc:ID 
						$ID = $domtree->createElement("cbc:ID","E");
						$ID->setAttribute('schemeID', "UN/ECE 5305");
						$ID->setAttribute('schemeName', "Tax Category Identifier");
						$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
						$ID = $TaxCategory->appendChild($ID);
						
						//cbc:Percent
						$Percent = $domtree->createElement("cbc:Percent",$InsBoleta->BolPorcentajeImpuestoVenta);
						$Percent = $TaxCategory->appendChild($Percent);
						
						//cbc:TaxExemptionReasonCode 
						$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","20");
						$TaxExemptionReasonCode->setAttribute('listAgencyName', "PE:SUNAT");
						$TaxExemptionReasonCode->setAttribute('listName', "SUNAT:Codigo de Tipo de Afectación del IGV");
						$TaxExemptionReasonCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
						$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
						
						//cac:TaxScheme
						$TaxScheme = $domtree->createElement("cac:TaxScheme");
						$TaxScheme = $TaxCategory->appendChild($TaxScheme);
			
							//cbc:TaxAmount 
							$ID = $domtree->createElement("cbc:ID","1000");
							$ID->setAttribute('schemeID', "UN/ECE 5153");
							$ID->setAttribute('schemeName', "Tax Scheme Identifier");
							$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
							$ID = $TaxScheme->appendChild($ID);
			
								//cbc:Name
							$Name = $domtree->createElement("cbc:Name","EXONERADO");
							$Name = $TaxScheme->appendChild($Name);
			
							//cbc:TaxTypeCode
							$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","VAT");
							$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
							
							
			}else if($DatBoletaDetalle->BdeExonerado == "2"){
				
				if($DatBoletaDetalle->BdeGratuito=="1"){
					
					//cbc:TaxAmount
					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeValorVenta*($InsBoleta->BolPorcentajeImpuestoVenta/100),2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$TaxAmount = $TaxTotal->appendChild($TaxAmount);
					
				}else{
										//cbc:TaxAmount
					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeImpuesto,2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$TaxAmount = $TaxTotal->appendChild($TaxAmount);

					
				}
				
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
					
					//cbc:TaxableAmount 
					$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($DatBoletaDetalle->BdeValorVenta,2, '.', ''));
					$TaxableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
					
					
					if($DatBoletaDetalle->BdeGratuito=="1"){
				
						$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeValorVenta*($InsBoleta->BolPorcentajeImpuestoVenta/100),2, '.', ''));
						$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
						$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
					}else{
						//cbc:TaxAmount 
						$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeImpuesto,2, '.', ''));
						$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
						$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
					}
					
					
					//cac:TaxCategory
					$TaxCategory = $domtree->createElement("cac:TaxCategory");
					$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
						
						//cbc:TaxAmount 
						$ID = $domtree->createElement("cbc:ID","S");
						$ID->setAttribute('schemeID', "UN/ECE 5305");
						$ID->setAttribute('schemeName', "Tax Category Identifier");
						$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
						$ID = $TaxCategory->appendChild($ID);
						
						//cbc:Percent
						$Percent = $domtree->createElement("cbc:Percent",$InsBoleta->BolPorcentajeImpuestoVenta);
						$Percent = $TaxCategory->appendChild($Percent);
						
						
						if($DatBoletaDetalle->BdeGratuito=="1"){
							
							//cbc:TaxExemptionReasonCode 
							$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","15");
							$TaxExemptionReasonCode->setAttribute('listAgencyName', "PE:SUNAT");
							$TaxExemptionReasonCode->setAttribute('listName', "SUNAT:Codigo de Tipo de Afectación del IGV");
							$TaxExemptionReasonCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
							$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
							
							//cac:TaxScheme
							$TaxScheme = $domtree->createElement("cac:TaxScheme");
							$TaxScheme = $TaxCategory->appendChild($TaxScheme);
				
								//cbc:TaxAmount 
								$ID = $domtree->createElement("cbc:ID","9996");
								$ID->setAttribute('schemeID', "UN/ECE 5153");
								$ID->setAttribute('schemeName', "Tax Scheme Identifier");
								$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
								$ID = $TaxScheme->appendChild($ID);
				
									//cbc:Name
								$Name = $domtree->createElement("cbc:Name","GRA");
								$Name = $TaxScheme->appendChild($Name);
				
								//cbc:TaxTypeCode
								$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","FRE");
								$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
							
						}else{
							
							
							//cbc:TaxExemptionReasonCode 
							$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","10");
							$TaxExemptionReasonCode->setAttribute('listAgencyName', "PE:SUNAT");
							$TaxExemptionReasonCode->setAttribute('listName', "SUNAT:Codigo de Tipo de Afectación del IGV");
							$TaxExemptionReasonCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
							$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
							
							//cac:TaxScheme
							$TaxScheme = $domtree->createElement("cac:TaxScheme");
							$TaxScheme = $TaxCategory->appendChild($TaxScheme);
				
								//cbc:TaxAmount 
								$ID = $domtree->createElement("cbc:ID","1000");
								$ID->setAttribute('schemeID', "UN/ECE 5153");
								$ID->setAttribute('schemeName', "Tax Scheme Identifier");
								$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
								$ID = $TaxScheme->appendChild($ID);
				
									//cbc:Name
								$Name = $domtree->createElement("cbc:Name","IGV");
								$Name = $TaxScheme->appendChild($Name);
				
								//cbc:TaxTypeCode
								$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","VAT");
								$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
								
						}
						
						
						
						
							
							
			}else{
				
			}
			
						

			//cac:Item
			$Item = $domtree->createElement("cac:Item");
			$Item = $InvoiceLine->appendChild($Item);	

					

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


					//cac:PartyName
					$Description = $domtree->createElement("cbc:Description");
					$Description = $Item->appendChild($Description);

					$Description->appendChild($domtree->createCDATASection($DatBoletaDetalle->BdeDescripcion )); 



				//cac:SellersItemIdentification		
				$SellersItemIdentification = $domtree->createElement("cac:SellersItemIdentification");
				$SellersItemIdentification = $Item->appendChild($SellersItemIdentification);

					$ID = $domtree->createElement("cbc:ID");
					$ID = $SellersItemIdentification->appendChild($ID);
					$ID->appendChild($domtree->createCDATASection($DatBoletaDetalle->BdeCodigo )); 
					
				if(!empty($DatBoletaDetalle->BdeCodigoGeneral)){
					
					//cac:CommodityClassification		
					$CommodityClassification = $domtree->createElement("cac:CommodityClassification");
					$CommodityClassification = $Item->appendChild($CommodityClassification);
					
						//cbc:PriceAmount currencyID="PEN"
						$ItemClassificationCode = $domtree->createElement("cbc:ItemClassificationCode",$DatBoletaDetalle->BdeCodigoGeneral);
						$ItemClassificationCode->setAttribute('listID', "UNSPSC");
						$ItemClassificationCode->setAttribute('listAgencyName', "GS1 US");
						$ItemClassificationCode->setAttribute('listName', "Item Classification");
						$ItemClassificationCode = $CommodityClassification->appendChild($ItemClassificationCode);	
					
				}
				
				
			//cac:Price
			$Price = $domtree->createElement("cac:Price");
			$Price = $InvoiceLine->appendChild($Price);	
				
				if($DatBoletaDetalle->BdeGratuito=="1"){
					
					//cbc:PriceAmount 
					$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
					$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
				
				}elseif($DatBoletaDetalle->BdeGratuito=="2"){
					
					//cbc:PriceAmount
					$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatBoletaDetalle->BdeValorVentaUnitario,2, '.', ''));
					$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
					
				}else{
					
					//cbc:PriceAmount
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
						
						
						//if(!empty($InsBoleta->BolDatoAdicional5)){	
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