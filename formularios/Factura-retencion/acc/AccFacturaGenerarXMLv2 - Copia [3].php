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

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsFactura->FacId = $GET_id;
$InsFactura->FtaId = $GET_ta;
$InsFactura->MtdObtenerFactura();


//deb($InsFactura->FacTipoCambio);
if($InsFactura->MonId<>$EmpresaMonedaId){
	
	$InsFactura->FacTotalGravado = round($InsFactura->FacTotalGravado/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalExonerado = round($InsFactura->FacTotalExonerado/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalGratuito = round($InsFactura->FacTotalGratuito/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotalDescuento = round($InsFactura->FacTotalDescuento/$InsFactura->FacTipoCambio,2);

	
	$InsFactura->FacTotalPagar = round($InsFactura->FacTotalPagar/$InsFactura->FacTipoCambio,2);
	//$InsFactura->FacTotalDescuento = round($InsFactura->FacTotalDescuento/$InsFactura->FacTipoCambio,2);
	
	$InsFactura->FacSubTotal = round($InsFactura->FacSubTotal/$InsFactura->FacTipoCambio,2);	
	$InsFactura->FacImpuesto = round($InsFactura->FacImpuesto/$InsFactura->FacTipoCambio,2);
	$InsFactura->FacTotal = round($InsFactura->FacTotal/$InsFactura->FacTipoCambio,2);	
	$InsFactura->FacTotalImpuestoSelectivo = round($InsFactura->FacTotalImpuestoSelectivo/$InsFactura->FacTipoCambio,2);	
	
}
	
	
	$InsFactura->CliNombre = trim($InsFactura->CliNombre);
$InsFactura->CliApellidoPaterno = trim($InsFactura->CliApellidoPaterno);
$InsFactura->CliApellidoMaterno = trim($InsFactura->CliApellidoMaterno);



$InsFactura->FacTotal = round($InsFactura->FacTotal,2);
list($parte_entero,$parte_decimal) = explode(".",$InsFactura->FacTotal);

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

$FacturaTotalLetras = "SON ".$numalet->letra()." CON ".$parte_decimal."/100 ".$InsFactura->MonNombre;

$NOMBRE = $EmpresaCodigo.'-01-'.$InsFactura->FtaNumero.'-'.$InsFactura->FacId;
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
////$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacSubTotal,2, '.', ''));
//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalGravado,2, '.', ''));
//$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
//
/////'cbc:ID','1003'	//TOTAL EXONERADAS
////sac:AdditionalMonetaryTotal
//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1003'));
//
////sac:PayableAmount
//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalExonerado,2, '.', ''));
//$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
//
////'cbc:ID','1004'	//TOTAL GRATUITAS
////sac:AdditionalMonetaryTotal
//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1004'));
//
////sac:PayableAmount
//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalGratuito,2, '.', ''));
//$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
//
////'cbc:ID','2005' //TOTAL DESCUENTOS
////sac:AdditionalMonetaryTotal
//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','2005'));
//
////sac:PayableAmount
//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalDescuento,2, '.', ''));
//$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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
//$Value = $domtree->createElement("cbc:Value",$FacturaTotalLetras);
//$Value = $AdditionalProperty->appendChild($Value);
//
//
//if(!empty($InsFactura->FacLeyenda)){
//
//
/////'cbc:ID','1002' //LEYENDA
////sac:AdditionalProperty
//$AdditionalProperty = $domtree->createElement("sac:AdditionalProperty");
//$AdditionalProperty = $AdditionalInformation->appendChild($AdditionalProperty);
//$AdditionalProperty->appendChild($domtree->createElement('cbc:ID','1002'));
//
////cbc:Value
//$Value = $domtree->createElement("cbc:Value",$InsFactura->FacLeyenda);
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
$ID = $domtree->createElement("cbc:ID",$InsFactura->FtaNumero."-".$InsFactura->FacId);
$ID = $xmlRoot->appendChild($ID);

//cbc:IssueDate
$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($InsFactura->FacFechaEmision));
$IssueDate = $xmlRoot->appendChild($IssueDate);
//cbc:IssueTime
$IssueTime = $domtree->createElement("cbc:IssueTime",($InsFactura->FacHoraEmision));
$IssueTime = $xmlRoot->appendChild($IssueTime);

//cbc:InvoiceTypeCode
//$InvoiceTypeCode = $domtree->createElement("cbc:InvoiceTypeCode","01");
//$InvoiceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
//$InvoiceTypeCode->setAttribute('listName', "SUNAT:Identificador de Tipo de Documento");
//$InvoiceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
//$InvoiceTypeCode = $xmlRoot->appendChild($InvoiceTypeCode);
$InvoiceTypeCode = $domtree->createElement("cbc:InvoiceTypeCode","01");
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
//$Note = $domtree->createElement("cbc:Note",$domtree->createCDATASection($FacturaTotalLetras));
$Note = $domtree->createElement("cbc:Note",($FacturaTotalLetras));
$Note->setAttribute('languageLocaleID', "1000");
$Note = $xmlRoot->appendChild($Note);
	
////cbc:DocumentCurrencyCode
//$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsFactura->MonSigla);
//$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);

//cbc:DocumentCurrencyCode
$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsFactura->MonSigla);
$DocumentCurrencyCode->setAttribute('listID', "ISO 4217 Alpha");
$DocumentCurrencyCode->setAttribute('listName', "Currency");
$DocumentCurrencyCode->setAttribute('listAgencyName', "United Nations Economic Commission for Europe");
$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);



/*<cac:DespatchDocumentReference>
	<cbc:ID>0001-0000008</cbc:ID>
	<cbc:DocumentTypeCode listAgencyName="PE:SUNAT" listName="SUNAT:Identificador de guíarelacionada" listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01">09</cbc:DocumentTypeCode>
</cac:DespatchDocumentReference>
*/


if(!empty($InsFactura->FacGuiaRemisionNumero)){
	
	//cac:DespatchDocumentReference
	$DespatchDocumentReference = $domtree->createElement("cac:DespatchDocumentReference");
	$DespatchDocumentReference = $xmlRoot->appendChild($DespatchDocumentReference);
				
		//cbc:ID
		$ID = $domtree->createElement("cbc:ID",$InsFactura->FacGuiaRemisionNumero);
		$ID = $DespatchDocumentReference->appendChild($ID);
		
		//cbc:DocumentTypeCode
		$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode",("09"));
		$DocumentTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
		$DocumentTypeCode->setAttribute('listName', "SUNAT:Identificador de guía relacionada");
		$DocumentTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
		$DocumentTypeCode = $DespatchDocumentReference->appendChild($DocumentTypeCode);	
		
		
}

if(!empty($InsFactura->FacGuiaRemisionTransportistaNumero)){
	
	//cac:DespatchDocumentReference
	$DespatchDocumentReference = $domtree->createElement("cac:DespatchDocumentReference");
	$DespatchDocumentReference = $xmlRoot->appendChild($DespatchDocumentReference);
				
		//cbc:ID
		$ID = $domtree->createElement("cbc:ID",$InsFactura->FacGuiaRemisionTransportistaNumero);
		$ID = $DespatchDocumentReference->appendChild($ID);
		
		//cbc:DocumentTypeCode
		$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode",("09"));
		$DocumentTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
		$DocumentTypeCode->setAttribute('listName', "SUNAT:Identificador de guía relacionada");
		$DocumentTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
		$DocumentTypeCode = $DespatchDocumentReference->appendChild($DocumentTypeCode);	
		
		
}
//if(!empty($InsFactura->FacGuiaRemisionTransportistaNumero)){
//	
//	//cac:DespatchDocumentReference
//	$AdditionalDocumentReference = $domtree->createElement("cac:AdditionalDocumentReference");
//	$AdditionalDocumentReference = $xmlRoot->appendChild($AdditionalDocumentReference);
//				
//		//cbc:ID
//		$ID = $domtree->createElement("cbc:ID",$InsFactura->FacGuiaRemisionTransportistaNumero);
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

/*<?php echo $InsFactura->GrtNumero;?> - <?php echo $InsFactura->GreId;?>
*/
//if(!empty($InsFactura->GreId)){
//	
//	//cac:DespatchDocumentReference
//	$DespatchDocumentReference = $domtree->createElement("cac:DespatchDocumentReference");
//	$DespatchDocumentReference = $xmlRoot->appendChild($DespatchDocumentReference);
//		
//		//cbc:ID
//		$ID = $domtree->createElement("cbc:ID",$InsFactura->GrtNumero."-".$InsFactura->GreId);
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
		

	//cac:AccountingCustomerParty
	$AccountingCustomerParty = $domtree->createElement("cac:AccountingCustomerParty");
	$AccountingCustomerParty = $xmlRoot->appendChild($AccountingCustomerParty);
	
	//	//cbc:CustomerAssignedAccountID
	//	$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$InsFactura->CliNumeroDocumento);
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
				$CompanyID = $domtree->createElement("cbc:ID",($InsFactura->CliNumeroDocumento));
				$CompanyID->setAttribute('schemeID', round($InsFactura->TdoCodigo));
				$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
				$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
				$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
				$CompanyID = $PartyIdentification->appendChild($CompanyID);	
	
							
			//cac:PartyLegalEntity
			$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
			$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);
				
				 //cbc:RegistrationName		
				$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
				$RegistrationName->appendChild($domtree->createCDATASection( $InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno)); 
			
				
			/*
			//cac:PartyTaxScheme
			$PartyTaxScheme = $Party->appendChild($domtree->createElement( 'cac:PartyTaxScheme' ));
			
				//cbc:RegistrationName		
				$RegistrationName = $PartyTaxScheme->appendChild($domtree->createElement('cbc:RegistrationName')); 
				$RegistrationName->appendChild($domtree->createCDATASection( $InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno)); 
				
				//cbc:Note
				//$CompanyID = $domtree->createElement("cbc:CompanyID",$domtree->createCDATASection($InsFactura->CliNumeroDocumento));
				$CompanyID = $domtree->createElement("cbc:CompanyID",($InsFactura->CliNumeroDocumento));
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
if($InsFactura->FacPorcentajeDescuentoGlobal>0){
	
	$InsFactura->FacPorcentajeDescuentoGlobal = round($InsFactura->FacPorcentajeDescuentoGlobal/100,2);
	
	//cac:LegalMonetaryTotal
	$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
	$AllowanceCharge = $xmlRoot->appendChild($AllowanceCharge);
	
		//cbc:ChargeIndicator
		$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","False");
		$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);
		
		//cbc:AllowanceChargeReasonCode
		$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode","00");
		$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);
		
		//cbc:MultiplierFactorNumeric
		$MultiplierFactorNumeric = $domtree->createElement("cbc:MultiplierFactorNumeric",$InsFactura->FacPorcentajeDescuentoGlobal);
		$MultiplierFactorNumeric = $AllowanceCharge->appendChild($MultiplierFactorNumeric);
	
		//cbc:Amount
		//TOTAL DESCUENTO GLOBAL (NO ITEMS)
		$Amount = $domtree->createElement("cbc:Amount",number_format($InsFactura->FacTotalDescuentoGlobal,2, '.', ''));
		$Amount->setAttribute('currencyID', $InsFactura->MonSigla);
		$Amount = $AllowanceCharge->appendChild($Amount);
	
		//cbc:Amount
		//TOTAL SUMA VALORES DE VENTA
		$BaseAmount = $domtree->createElement("cbc:BaseAmount",number_format($InsFactura->FacTotalGravado,2, '.', ''));
		$BaseAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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
//				$StreetName->appendChild($domtree->createCDATASection( $InsFactura->CliDireccion )); 
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
//		$Description->appendChild($domtree->createCDATASection( $InsFactura->CliDireccion )); 
//			
//		//cac:PartyLegalEntity
//		$PartyLegalEntity = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
//		
//		//cac:Name		
//		$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
//		$RegistrationName->appendChild($domtree->createCDATASection( $InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno )); 
		
//cac:TaxTotal
$TaxTotal = $domtree->createElement("cac:TaxTotal");
$TaxTotal = $xmlRoot->appendChild($TaxTotal);

	//cbc:TaxAmount
	//SUMA TOTAL IGV
	$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsFactura->FacImpuesto,2, '.', ''));
	$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$TaxAmount = $TaxTotal->appendChild($TaxAmount);
			
	//cac:TaxSubtotal
	$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
	$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
		
		//cbc:TaxableAmount 
		//SUMA TOTAL GRAVADOS
		$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsFactura->FacTotalGravado,2, '.', ''));
		$TaxableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
		$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
		
		//cbc:TaxAmount 
		$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsFactura->FacImpuesto,2, '.', ''));
		$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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
				
				
				
	if($InsFactura->FacTotalExonerado>0){
	
		//SUMA TOTAL EXONERADOS
		//cac:TaxSubtotal
		$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
		$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
			
			//cbc:TaxableAmount 
			$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsFactura->FacTotalExonerado,2, '.', ''));
			$TaxableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
			
			//cbc:TaxAmount 
			$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
			$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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
	
		
					
	if($InsFactura->FacTotalGratuito>0){
	
		//SUMA TOTAL INAFECTO (GRATUITO)
		//cac:TaxSubtotal
		$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
		$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
			
			//cbc:TaxableAmount 
			$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsFactura->FacTotalGratuito,2, '.', ''));
			$TaxableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
			
			//cbc:TaxAmount 
			$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
			$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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
					$ID = $domtree->createElement("cbc:ID","9998");
					$ID->setAttribute('schemeID', "UN/ECE 5153");
					$ID->setAttribute('schemeAgencyID', "6");
					$ID = $TaxScheme->appendChild($ID);
	
					//cbc:Name
					$Name = $domtree->createElement("cbc:Name","INAFECTO");
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
////	$TaxInclusiveAmount = $domtree->createElement("cbc:TaxInclusiveAmount",number_format($InsFactura->FacSubTotal,2, '.', ''));
////	$TaxInclusiveAmount->setAttribute('currencyID', $InsFactura->MonSigla);
////	$TaxInclusiveAmount = $LegalMonetaryTotal->appendChild($TaxInclusiveAmount);
//
//	//cbc:AllowanceTotalAmount currencyID="PEN"
//	$AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount",number_format($InsFactura->FacTotalDescuento,2, '.', ''));
//	$AllowanceTotalAmount->setAttribute('currencyID', $InsFactura->MonSigla);
//	$AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
//	
//	//cbc:PayableAmount currencyID="PEN"
//	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalPagar,2, '.', ''));
//	$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
//	$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);
//	
	
 
//cac:LegalMonetaryTotal
$LegalMonetaryTotal = $domtree->createElement("cac:LegalMonetaryTotal");
$LegalMonetaryTotal = $xmlRoot->appendChild($LegalMonetaryTotal);

	//cbc:LineExtensionAmount
	$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount",number_format($InsFactura->FacSubTotal,2, '.', ''));
	$LineExtensionAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$LineExtensionAmount = $LegalMonetaryTotal->appendChild($LineExtensionAmount);
	
	//cbc:TaxInclusiveAmount
	////SUMA TOTAL DE LA VENTA - OTROS CARGOS
	$TaxInclusiveAmount = $domtree->createElement("cbc:TaxInclusiveAmount",number_format($InsFactura->FacTotal,2, '.', ''));
	$TaxInclusiveAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$TaxInclusiveAmount = $LegalMonetaryTotal->appendChild($TaxInclusiveAmount);

	//cbc:AllowanceTotalAmount 
	//SUMA TOTAL DESCUENTOS GENERAL + ITEMS
	$AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount",number_format($InsFactura->FacTotalDescuento,2, '.', ''));
	$AllowanceTotalAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
	
	if($InsFactura->FacTotalOtrosCargos>0){
		
		//cbc:ChargeTotalAmount 
		//SUMA TOTAL OTROS CARGOS
		$ChargeTotalAmount = $domtree->createElement("cbc:ChargeTotalAmount",number_format($InsFactura->FacTotalOtrosCargos,2, '.', ''));
		$ChargeTotalAmount->setAttribute('currencyID', $InsFactura->MonSigla);
		$ChargeTotalAmount = $LegalMonetaryTotal->appendChild($ChargeTotalAmount);
		
	}
	
	//cbc:PayableAmount currencyID="PEN"
	//SUMA TOTAL DE LA VENTA
	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotal,2, '.', ''));
	$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);
	
$fila = 1;
if(!empty($InsFactura->FacturaDetalle)){
	foreach($InsFactura->FacturaDetalle as $DatFacturaDetalle){
			
		if($InsFactura->MonId<>$EmpresaMonedaId ){
			
			$DatFacturaDetalle->FdeImporte = ($DatFacturaDetalle->FdeImporte / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdePrecio = ($DatFacturaDetalle->FdePrecio  / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdeValorVenta = ($DatFacturaDetalle->FdeValorVenta  / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdeValorVentaUnitario = ($DatFacturaDetalle->FdeValorVentaUnitario  / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdeImpuesto = ($DatFacturaDetalle->FdeImpuesto  / $InsFactura->FacTipoCambio);
			$DatFacturaDetalle->FdeValorVentaBruto = ($DatFacturaDetalle->FdeValorVentaBruto  / $InsFactura->FacTipoCambio);
			
		}

		//cac:InvoiceLine
		$InvoiceLine = $domtree->createElement("cac:InvoiceLine");
		$InvoiceLine = $xmlRoot->appendChild($InvoiceLine);	
			
			//cbc:ID
			$ID = $domtree->createElement("cbc:ID",$fila);
			$ID = $InvoiceLine->appendChild($ID);	
			
			//cbc:InvoicedQuantity unitCode="NIU"
			$InvoicedQuantity = $domtree->createElement("cbc:InvoicedQuantity",number_format($DatFacturaDetalle->FdeCantidad,2, '.', ''));
			
			//if($DatFacturaDetalle->FdeValidarStock==2){
//				$InvoicedQuantity->setAttribute('unitCode', 'ZZ');
//			}else{
//				$InvoicedQuantity->setAttribute('unitCode', 'NIU');	
//			}
			
			switch($DatFacturaDetalle->FdeTipo){
				
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
			$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount",number_format($DatFacturaDetalle->FdeValorVenta,2, '.', ''));
			$LineExtensionAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			$LineExtensionAmount = $InvoiceLine->appendChild($LineExtensionAmount);	
				
			//cac:PricingReference
			$PricingReference = $domtree->createElement("cac:PricingReference");
			$PricingReference = $InvoiceLine->appendChild($PricingReference);	
				
				
			//VALOR REFERENCIAL UNITARIO POR ITEM EN OPERACIONES NO ONEROSAS
			
			if($DatFacturaDetalle->FdeGratuito==1){
				
				//cac:AlternativeConditionPrice
				$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
				$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
				
					//cbc:PriceAmount currencyID="PEN"
					$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatFacturaDetalle->FdeValorVentaUnitario,2, '.', ''));
					$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	
					//cbc:PriceTypeCode
					$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","02");
					$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
					$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
					$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
					$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
				
			}else if($DatFacturaDetalle->FdeGratuito==2){
			
				//cac:AlternativeConditionPrice
				$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
				$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
						
					//cbc:PriceAmount currencyID="PEN"
					$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatFacturaDetalle->FdePrecio,2, '.', ''));
					$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	
					//cbc:PriceTypeCode
					$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
					$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
					$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
					$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
					$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
				
			}
			
			//DESCUENTOS POR ITEM	
		
			if($DatFacturaDetalle->FdeDescuento>0){
				
				$DatFacturaDetalle->FdePorcentajeDescuento = round($DatFacturaDetalle->FdePorcentajeDescuento/100,2);
				
				//cac:AllowanceCharge
				$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
				$AllowanceCharge = $InvoiceLine->appendChild($AllowanceCharge);					
								
					//cbc:ChargeIndicator
					$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","false");
					$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);
					
					//cbc:AllowanceChargeReasonCode
					$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode","00");//X
					$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);
								
					////cbc:MultiplierFactorNumeric
//					$MultiplierFactorNumeric = $domtree->createElement("cbc:MultiplierFactorNumeric",$DatFacturaDetalle->FdePorcentajeDescuento);//X
//					$MultiplierFactorNumeric = $AllowanceCharge->appendChild($MultiplierFactorNumeric);
									
					//cbc:Amount
					$Amount = $domtree->createElement("cbc:Amount",$DatFacturaDetalle->FdeDescuento);
					$Amount->setAttribute('currencyID', $InsFactura->MonSigla);
					$Amount = $AllowanceCharge->appendChild($Amount);		
					
					//cbc:BaseAmount
					$BaseAmount = $domtree->createElement("cbc:BaseAmount",number_format($DatFacturaDetalle->FdeValorVentaBruto,2, '.', ''));					
					$BaseAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);		
					
					
			}
					
		//OTROS CARGOS POR ITEM	
		// NO SE USA
			if($DatFacturaDetalle->FdeOtroCargo>0){
				
				$DatFacturaDetalle->FdePorcentajeOtroCargo = round($DatFacturaDetalle->FdePorcentajeOtroCargo/100,2);
				
				//cac:AllowanceCharge
				$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
				$AllowanceCharge = $InvoiceLine->appendChild($AllowanceCharge);					
								
					//cbc:ChargeIndicator
					$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","true");
					$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);
					
					//cbc:AllowanceChargeReasonCode
					$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode","5");//X
					$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);
								
					////cbc:MultiplierFactorNumeric
//					$MultiplierFactorNumeric = $domtree->createElement("cbc:MultiplierFactorNumeric",$DatFacturaDetalle->FdePorcentajeDescuento);//X
//					$MultiplierFactorNumeric = $AllowanceCharge->appendChild($MultiplierFactorNumeric);
									
					//cbc:Amount
					$Amount = $domtree->createElement("cbc:Amount",$DatFacturaDetalle->FdeOtroCargo);
					$Amount->setAttribute('currencyID', $InsFactura->MonSigla);
					$Amount = $AllowanceCharge->appendChild($Amount);		
					
					//cbc:BaseAmount
					$BaseAmount = $domtree->createElement("cbc:BaseAmount",$InsFacturaDetalle1->FdeValorVentaBruto);//REVISAR ESTE MONTO
					$BaseAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);		
					
					
			}
			
			
			
			
			
			
			
			
			
				
		//cac:TaxTotal
		$TaxTotal = $domtree->createElement("cac:TaxTotal");
		$TaxTotal = $InvoiceLine->appendChild($TaxTotal);
		
		
			if($DatFacturaDetalle->FdeExonerado == "1"){
				
				//cbc:TaxAmount
				$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
				$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);
						
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
					
					//cbc:TaxableAmount 
					$TaxableAmount = $domtree->createElement("cbc:TaxableAmount","0.00");
					$TaxableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
					
					//cbc:TaxAmount 


					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatFacturaDetalle->FdeValorVenta,2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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
						$Percent = $domtree->createElement("cbc:Percent",$InsFactura->FacPorcentajeImpuestoVenta);
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
							
							
			}else if($DatFacturaDetalle->FdeExonerado == "2"){
				
				
				//cbc:TaxAmount
				$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatFacturaDetalle->FdeImpuesto,2, '.', ''));
				$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);
						
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
					
					//cbc:TaxableAmount 
					$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($DatFacturaDetalle->FdeValorVenta,2, '.', ''));
					$TaxableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
					
					//cbc:TaxAmount 
					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatFacturaDetalle->FdeImpuesto,2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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
						
						//cbc:Percent
						$Percent = $domtree->createElement("cbc:Percent",$InsFactura->FacPorcentajeImpuestoVenta);
						$Percent = $TaxCategory->appendChild($Percent);
						
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
							
							
							
			}else{
				
			}
			
						

			//cac:Item
			$Item = $domtree->createElement("cac:Item");
			$Item = $InvoiceLine->appendChild($Item);	


					if(!empty($InsFactura->OvvId)){
				
						 if(!empty($InsFactura->FacDatoAdicional13) or !empty($InsFactura->FacDatoAdicional7) or !empty($InsFactura->FacDatoAdicional1)){
							
							$DatFacturaDetalle->FdeDescripcion .= "( ";
						
						  }
						
						  if(!empty($InsFactura->FacDatoAdicional13)){
							
							$DatFacturaDetalle->FdeDescripcion .= "Nro. VIN o CHASIS: ".$InsFactura->FacDatoAdicional13.", ";
							
						  }
						
						  if(!empty($InsFactura->FacDatoAdicional7)){
						 
								$DatFacturaDetalle->FdeDescripcion .= "Nro. Motor: ".$InsFactura->FacDatoAdicional7.", ";
							
						  }
						  
						  if(!empty($InsFactura->FacDatoAdicional1)){
						 
								$DatFacturaDetalle->FdeDescripcion .= "Marca: ".$InsFactura->FacDatoAdicional1." ";
						 
						  }
						
						  if(!empty($InsFactura->FacDatoAdicional13) or !empty($InsFactura->FacDatoAdicional7) or !empty($InsFactura->FacDatoAdicional1)){
							
								$DatFacturaDetalle->FdeDescripcion .= " )";
						   
						  }
				  
					}


					//cac:PartyName
					$Description = $domtree->createElement("cbc:Description");
					$Description = $Item->appendChild($Description);

					$Description->appendChild($domtree->createCDATASection($DatFacturaDetalle->FdeDescripcion )); 

				//cac:SellersItemIdentification		
				$SellersItemIdentification = $domtree->createElement("cac:SellersItemIdentification");
				$SellersItemIdentification = $Item->appendChild($SellersItemIdentification);

					$ID = $domtree->createElement("cbc:ID");
					$ID = $SellersItemIdentification->appendChild($ID);
					$ID->appendChild($domtree->createCDATASection($DatFacturaDetalle->FdeCodigo )); 
					
				if(!empty($DatFacturaDetalle->FdeCodigoGeneral)){
					
					//cac:CommodityClassification		
					$CommodityClassification = $domtree->createElement("cac:CommodityClassification");
					$CommodityClassification = $Item->appendChild($CommodityClassification);
					
						//cbc:PriceAmount currencyID="PEN"
						$ItemClassificationCode = $domtree->createElement("cbc:ItemClassificationCode",$DatFacturaDetalle->FdeCodigoGeneral);
						$ItemClassificationCode->setAttribute('listID', "UNSPSC");
						$ItemClassificationCode->setAttribute('listAgencyName', "GS1 US");
						$ItemClassificationCode->setAttribute('listName', "Item Classification");
						$ItemClassificationCode = $CommodityClassification->appendChild($ItemClassificationCode);	
					
				}
				
				
			//cac:Price
			$Price = $domtree->createElement("cac:Price");
			$Price = $InvoiceLine->appendChild($Price);	
				
				if($DatFacturaDetalle->FdeGratuito==1){
					
					//cbc:PriceAmount 
					$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
					$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
				
				}elseif($DatFacturaDetalle->FdeGratuito==2){
					
					//cbc:PriceAmount
					$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatFacturaDetalle->FdeValorVentaUnitario,2, '.', ''));
					$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
					
				}else{
					
					//cbc:PriceAmount
					$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
					$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
						
				}
			
			
			
			if($fila==1){
				
				
				//cac:InvoiceLine
				//$InvoiceLineEspecial = $domtree->createElement("cac:InvoiceLine");
				//$InvoiceLineEspecial = $xmlRoot->appendChild($InvoiceLineEspecial);	
				
				//cac:ItemEspecial
				//$ItemEspecial = $domtree->createElement("cac:Item");
				//$ItemEspecial = $InvoiceLineEspecial->appendChild($Item);	
				
				
				
						if(!empty($InsFactura->EinPlaca)){	
							
							//cac:AdditionalProperty
							$AdditionalProperty = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalProperty->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Numero de Placa')); 
							
							//cac:Name		
							$Value = $AdditionalProperty->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->EinPlaca)); 
							
							
						}
						
						if(!empty($InsFactura->FinLicenciaCategoria)){
							
							//cac:AdditionalItemProperty2
							$AdditionalItemProperty2 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty2->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Categoria')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty2->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->FinLicenciaCategoria)); 
							
						}
						
						if(!empty($InsFactura->FacDatoAdicional1)){
				
							//cac:AdditionalItemProperty5
							$AdditionalItemProperty5 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty5->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Marca')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty5->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional1)); 
							
					
						}else if(!empty($InsFactura->VmaNombre)){
				
							//cac:AdditionalItemProperty3
							$AdditionalItemProperty3 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty3->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Marca')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty3->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->VmaNombre)); 
							
						}
						
						if(!empty($InsFactura->FacDatoAdicional3)){	
				
							//cac:AdditionalItemProperty6
							$AdditionalItemProperty6 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty6->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Modelo')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty6->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional3)); 
							
							
						}else if(!empty($InsFactura->VmoNombre)){
							
				
							//cac:AdditionalItemProperty4
							$AdditionalItemProperty4 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty4->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Modelo')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty4->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->VmoNombre)); 
							
							
						}
						
						
						if(!empty($InsFactura->FacDatoAdicional15)){	
				
							
							//cac:AdditionalItemProperty7
							$AdditionalItemProperty7 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty7->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Color')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty7->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional15)); 
							
						}
						
						
						
						if(!empty($InsFactura->FacDatoAdicional7)){	
							
				
								//cac:AdditionalItemProperty71
								$AdditionalItemProperty71 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
								
								//cac:Name		
								$Name = $AdditionalItemProperty71->appendChild($domtree->createElement('cbc:Name')); 
								$Name->appendChild($domtree->createCDATASection( 'Motor')); 
								
								//cac:Name		
								$Value = $AdditionalItemProperty71->appendChild($domtree->createElement('cbc:Value')); 
								$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional7)); 
								
				
							
						}
						
						//InsFacturaDatoAdicional8
						if(!empty($InsFactura->FacDatoAdicional8)){	
						
				
							//cac:AdditionalItemProperty8
							$AdditionalItemProperty8 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty8->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Combustible')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty8->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional8)); 
							
						}
						
						if(!empty($InsFactura->FacDatoAdicional888888)){	//REVISAR
				
							//cac:AdditionalItemProperty9
							$AdditionalItemProperty9 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty9->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Form. Rodante')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty9->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional888888)); 
							
							
						}
						
							
						if(!empty($InsFactura->FacDatoAdicional13)){	
				
							//cac:AdditionalItemProperty10
							$AdditionalItemProperty10 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty10->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'VIN')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty10->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional13)); 
							
							
							
						}
						
						if(!empty($InsFactura->FacDatoAdicional13)){	
				
							//cac:AdditionalItemProperty101
							$AdditionalItemProperty101 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty101->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Serie/Chasis')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty101->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional13)); 
							
						}
						
						
						//if(!empty($InsFactura->FacDatoAdicional5)){	
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
//							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional5)); 
//							
//						}
						
						if(!empty($InsFactura->FacDatoAdicional27)){	//REVISAR
				
							//cac:AdditionalItemProperty103
							$AdditionalItemProperty103 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty103->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Año Modelo')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty103->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional27)); 
							
						}
				
				
						if(!empty($InsFactura->FacDatoAdicional5555555555)){	//REVISAR
				
							//cac:AdditionalItemProperty104
							$AdditionalItemProperty104 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty104->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Version')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty104->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional5555555555)); 
							
						}
						
						if(!empty($InsFactura->FacDatoAdicional11)){	
						
				
							//cac:AdditionalItemProperty11
							$AdditionalItemProperty11 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty11->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Ejes')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty11->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( str_pad($InsFactura->FacDatoAdicional11,2,"0",STR_PAD_LEFT))); 
							
						}
				
						if(!empty($InsFactura->FacDatoAdicional19)){	
				
							//cac:AdditionalItemProperty12
							$AdditionalItemProperty12 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty12->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Asientos')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty12->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( str_pad($InsFactura->FacDatoAdicional19,4,"0",STR_PAD_LEFT))); 
							
							
						}
						
						
						if(!empty($InsFactura->FacDatoAdicional21)){	
						
				
							//cac:AdditionalItemProperty13
							$AdditionalItemProperty13 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty13->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Pasajeros')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty13->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( str_pad($InsFactura->FacDatoAdicional21,4,"0",STR_PAD_LEFT))); 
							
							
						}
						
						if(!empty($InsFactura->FacDatoAdicional24)){	
				
							//cac:AdditionalItemProperty14
							$AdditionalItemProperty14 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty14->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Ruedas')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty14->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( str_pad($InsFactura->FacDatoAdicional24,2,"0",STR_PAD_LEFT))); 
							
						}
						
												
						if(!empty($InsFactura->FacDatoAdicional4)){	
				
							
							//cac:AdditionalItemProperty15
							$AdditionalItemProperty15 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty15->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Carroceria')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty15->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional4)); 
							
						}
						
						
						if(!empty($InsFactura->FacetaDatoAdicional25)){	
						
				
							
							//cac:AdditionalItemProperty16
							$AdditionalItemProperty16 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty16->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Potencia')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty16->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacetaDatoAdicional25)); 
							
						}
						
							
						if(!empty($InsFactura->FacDatoAdicional9)){	
				
							
							//cac:AdditionalItemProperty17
							$AdditionalItemProperty17 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty17->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Cilindros')); 
							
							//cac:Name		
							$Value = $AdditionalItemProperty17->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( str_pad($InsFactura->FacDatoAdicional9,2,"0",STR_PAD_LEFT))); 
							
						}
						
						
						if(!empty($InsFactura->FacDatoAdicional17)){	
							
				
							
							//cac:AdditionalItemProperty18
							$AdditionalItemProperty18 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty18->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Cilindrada')); 
							
							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional17);
							$NuevoValor = round($NuevoValor/1000,3);
							//cac:Name		
							$Value = $AdditionalItemProperty18->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor)); 
							
							
						}
					
						if(!empty($InsFactura->FacDatoAdicional10)){	
				
							
							//cac:AdditionalItemProperty19
							$AdditionalItemProperty19 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty19->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Peso Bruto')); 
							
							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional10);
							$NuevoValor = round($NuevoValor/1000,3);
							
							//cac:Name		
							$Value = $AdditionalItemProperty19->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor)); 
							
						}
						
						
						if(!empty($InsFactura->FacDatoAdicional14)){	
				
							//cac:AdditionalItemProperty20
							$AdditionalItemProperty20 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty20->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Peso Neto')); 
							
							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional14);
							$NuevoValor = round($NuevoValor/1000,3);
							
							//cac:Name		
							$Value = $AdditionalItemProperty20->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor));
							
						}
						
						
						
						if(!empty($InsFactura->FacDatoAdicional12)){	
				
							
							//cac:AdditionalItemProperty21
							$AdditionalItemProperty21 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty21->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Carga Util')); 
							
							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional12);
							$NuevoValor = round($NuevoValor/1000,3);
							
							//cac:Name		
							$Value = $AdditionalItemProperty21->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor));
							
						}
						
						if(!empty($InsFactura->FacDatoAdicional18)){	
				
							//cac:AdditionalItemProperty22
							$AdditionalItemProperty22 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty22->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Longitud')); 
							
							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional18);
							$NuevoValor = round($NuevoValor/1000,3);
							
							//cac:Name		
							$Value = $AdditionalItemProperty22->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor));
							
						}
						
												
						if(!empty($InsFactura->FacDatoAdicional16)){	
							
				
							//cac:AdditionalItemProperty23
							$AdditionalItemProperty23 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty23->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Altura')); 
							
							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional16);
							$NuevoValor = round($NuevoValor/1000,3);
							
							//cac:Name		
							$Value = $AdditionalItemProperty23->appendChild($domtree->createElement('cbc:Value')); 
							$Value->appendChild($domtree->createCDATASection( $NuevoValor));
							
						}
						
												
						if(!empty($InsFactura->FacDatoAdicional20)){	
							
							//cac:AdditionalItemProperty24
							$AdditionalItemProperty24 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
							
							//cac:Name		
							$Name = $AdditionalItemProperty24->appendChild($domtree->createElement('cbc:Name')); 
							$Name->appendChild($domtree->createCDATASection( 'Ancho')); 
							
							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional20);
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