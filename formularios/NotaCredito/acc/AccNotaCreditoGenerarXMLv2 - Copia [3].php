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


$InsNotaCredito->CliNombre = trim($InsNotaCredito->CliNombre);
$InsNotaCredito->CliApellidoPaterno = trim($InsNotaCredito->CliApellidoPaterno);
$InsNotaCredito->CliApellidoMaterno = trim($InsNotaCredito->CliApellidoMaterno);


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

//ext:UBLExtension1
$UBLExtension1 = $domtree->createElement("ext:UBLExtension");
$UBLExtension1 = $UBLExtensions->appendChild($UBLExtension1);

//sac:ExtensionContent1
$ExtensionContent1 = $domtree->createElement("ext:ExtensionContent");
$ExtensionContent1 = $UBLExtension1->appendChild($ExtensionContent1);

//ext:UBLVersionID
$UBLVersionID = $domtree->createElement("cbc:UBLVersionID","2.1");
$UBLVersionID = $xmlRoot->appendChild($UBLVersionID);

//ext:CustomizationID
$CustomizationID = $domtree->createElement("cbc:CustomizationID","2.0");
$CustomizationID = $xmlRoot->appendChild($CustomizationID);


//cbc:ID
$ID = $domtree->createElement("cbc:ID",$InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId);
$ID = $xmlRoot->appendChild($ID);

//cbc:IssueDate
$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($InsNotaCredito->NcrFechaEmision));
$IssueDate = $xmlRoot->appendChild($IssueDate);
//cbc:IssueTime
$IssueTime = $domtree->createElement("cbc:IssueTime",($InsNotaCredito->NcrHoraEmision));
$IssueTime = $xmlRoot->appendChild($IssueTime);

//cbc:Note
//$Note = $domtree->createElement("cbc:Note",$domtree->createCDATASection($NotaCreditoTotalLetras));
$Note = $domtree->createElement("cbc:Note",($NotaCreditoTotalLetras));
$Note->setAttribute('languageLocaleID', "1000");
$Note = $xmlRoot->appendChild($Note);

//cbc:DocumentCurrencyCode
$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsNotaCredito->MonSigla);
$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);


//cbc:DiscrepancyResponse
$DiscrepancyResponse = $domtree->createElement("cac:DiscrepancyResponse");
$DiscrepancyResponse = $xmlRoot->appendChild($DiscrepancyResponse);

	//cbc:ReferenceID
	$ReferenceID = $domtree->createElement("cbc:ReferenceID",$InsNotaCredito->DtaNumero."-".$InsNotaCredito->DocId);
	$ReferenceID = $DiscrepancyResponse->appendChild($ReferenceID);
	
	/*
	01 - Anulacion de la operacion
02 - Anulacion por error en el RUC
03 - Correcion por error en la descripcion
04 - Descuento global
05 - Descuento por item
06 - Devolucion totla
07 - Devolucion por item
08 - Bonificacion
09 - Disminucion en el valor
10 - Otros conceptos
	*/
	//cac:ResponseCode
	$ResponseCode = $domtree->createElement("cbc:ResponseCode",$InsNotaCredito->NcrMotivoCodigo);
	$ResponseCode = $DiscrepancyResponse->appendChild($ResponseCode);
	
	//cac:ResponseCode
	$Description = $domtree->createElement("cbc:Description",$InsNotaCredito->NcrMotivo);
	$Description = $DiscrepancyResponse->appendChild($Description);



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
		
		if(!empty($InsNotaCredito->NcrOtroDocumento	)){
				
			//cbc:BillingReference
			$AdditionalDocumentReference = $domtree->createElement("cac:AdditionalDocumentReference");
			$AdditionalDocumentReference = $xmlRoot->appendChild($AdditionalDocumentReference);	
				
				$ID = $domtree->createElement("cbc:ID",$InsNotaCredito->NcrOtroDocumento);
				$ID = $AdditionalDocumentReference->appendChild($ID);
				
				$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode",$InsNotaCredito->NcrOtroDocumentoCodigo);
				$DocumentTypeCode = $AdditionalDocumentReference->appendChild($DocumentTypeCode);
				
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
			
			
//DATOS DEL PROVEEDOR
//cac:AccountingSupplierParty
$AccountingSupplierParty = $domtree->createElement("cac:AccountingSupplierParty");
$AccountingSupplierParty = $xmlRoot->appendChild($AccountingSupplierParty);

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
			
			
//DATOS DEL CLIENTE
//cac:AccountingCustomerParty
$AccountingCustomerParty = $domtree->createElement("cac:AccountingCustomerParty");
$AccountingCustomerParty = $xmlRoot->appendChild($AccountingCustomerParty);

	//cac:Party
	$Party = $domtree->createElement("cac:Party");
	$Party = $AccountingCustomerParty->appendChild($Party);
		
		//cac:PartyIdentification
		$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
		$PartyIdentification = $Party->appendChild($PartyIdentification);
			
			//cbc:Note
			//$CompanyID = $domtree->createElement("cbc:CompanyID",$domtree->createCDATASection($EmpresaCodigo));
			$CompanyID = $domtree->createElement("cbc:ID",($InsNotaCredito->CliNumeroDocumento));
			$CompanyID->setAttribute('schemeID', round($InsNotaCredito->TdoCodigo,0));
			$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
			$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
			$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
			$CompanyID = $PartyIdentification->appendChild($CompanyID);	

						
		//cac:PartyLegalEntity
		$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
		$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);
			
			 //cbc:RegistrationName		
			$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
			$RegistrationName->appendChild($domtree->createCDATASection( $InsNotaCredito->CliNombre." ".$InsNotaCredito->CliApellidoPaterno." ".$InsNotaCredito->CliApellidoMaterno)); 
		
		
		
		
	
	//DATOS DE INMPUESTOS		
//cac:TaxTotal
$TaxTotal = $domtree->createElement("cac:TaxTotal");
$TaxTotal = $xmlRoot->appendChild($TaxTotal);

	//cbc:TaxAmount
	//SUMA TOTAL IGV
	$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsNotaCredito->NcrImpuesto,2, '.', ''));
	$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
	$TaxAmount = $TaxTotal->appendChild($TaxAmount);
			
	//cac:TaxSubtotal
	$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
	$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
		
		//cbc:TaxableAmount 
		//SUMA TOTAL GRAVADOS
		$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsNotaCredito->NcrTotalGravado,2, '.', ''));
		$TaxableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
		$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
		
		//cbc:TaxAmount 
		$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsNotaCredito->NcrImpuesto,2, '.', ''));
		$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
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
				
				
				
	if($InsNotaCredito->NcrTotalExonerado>0){
	
		//SUMA TOTAL EXONERADOS
		//cac:TaxSubtotal
		$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
		$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
			
			//cbc:TaxableAmount 
			$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsNotaCredito->NcrTotalExonerado,2, '.', ''));
			$TaxableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
			$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
			
			//cbc:TaxAmount 
			$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
			$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
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
	
		
					
	if($InsNotaCredito->NcrTotalGratuito>0){
	
		//SUMA TOTAL INAFECTO (GRATUITO)
		//cac:TaxSubtotal
		$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
		$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
			
			//cbc:TaxableAmount 
			$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsNotaCredito->NcrTotalGratuito,2, '.', ''));
			$TaxableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
			$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
			
			//cbc:TaxAmount 
			$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
			$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
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
	
	
 
//cac:LegalMonetaryTotal
$LegalMonetaryTotal = $domtree->createElement("cac:LegalMonetaryTotal");
$LegalMonetaryTotal = $xmlRoot->appendChild($LegalMonetaryTotal);

	//cbc:AllowanceTotalAmount 
	//SUMA TOTAL DESCUENTOS GENERAL + ITEMS
	$AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount",number_format($InsNotaCredito->NcrTotalDescuento,2, '.', ''));
	$AllowanceTotalAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
	$AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
	
	//cbc:PayableAmount currencyID="PEN"
	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsNotaCredito->NcrTotal,2, '.', ''));
	$PayableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
	$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);


$fila = 1;
if(!empty($InsNotaCredito->NotaCreditoDetalle)){
	foreach($InsNotaCredito->NotaCreditoDetalle as $DatNotaCreditoDetalle){
			
		//cac:InvoiceLine
		$InvoiceLine = $domtree->createElement("cac:CreditNoteLine");
		$InvoiceLine = $xmlRoot->appendChild($InvoiceLine);	
			
			//cbc:ID
			$ID = $domtree->createElement("cbc:ID",$fila);
			$ID = $InvoiceLine->appendChild($ID);	
			
			//cbc:CreditedQuantity unitCode="NIU"
			$CreditedQuantity = $domtree->createElement("cbc:CreditedQuantity",number_format($DatNotaCreditoDetalle->NcdCantidad,2, '.', ''));
			
			if($DatNotaCreditoDetalle->NcdValidarStock==2){
				$CreditedQuantity->setAttribute('unitCode', 'ZZ');
			}else{
				$CreditedQuantity->setAttribute('unitCode', 'NIU');	
			}
			$CreditedQuantity->setAttribute('unitCodeListID', 'UN/ECE rec 20');
			$CreditedQuantity->setAttribute('unitCodeListAgencyName', 'Europe');
			$CreditedQuantity = $InvoiceLine->appendChild($CreditedQuantity);	
			
			//cbc:LineExtensionAmount currencyID="PEN"
			$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount",number_format($DatNotaCreditoDetalle->NcdValorVenta,2, '.', ''));
			$LineExtensionAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
			$LineExtensionAmount = $InvoiceLine->appendChild($LineExtensionAmount);	
				
			//cac:PricingReference
			$PricingReference = $domtree->createElement("cac:PricingReference");
			$PricingReference = $InvoiceLine->appendChild($PricingReference);	
				
				
			//VALOR REFERENCIAL UNITARIO POR ITEM EN OPERACIONES NO ONEROSAS
			
			if($DatNotaCreditoDetalle->NcdGratuito==1){
				
				//cac:AlternativeConditionPrice
				$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
				$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
				
					//cbc:PriceAmount currencyID="PEN"
					$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaCreditoDetalle->NcdValorVentaUnitario,2, '.', ''));
					$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
					$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	
					//cbc:PriceTypeCode
					$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","02");
					$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
					$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
					$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
					$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
				
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
					$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
					$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
					$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
					$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
				
			}
			
			//DESCUENTOS POR ITEM	
		
			if($DatNotaCreditoDetalle->NcdDescuento>0){
				
				$DatNotaCreditoDetalle->NcdPorcentajeDescuento = round($DatNotaCreditoDetalle->NcdPorcentajeDescuento/100,2);
				
				//cac:AllowanceCharge
				$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
				$AllowanceCharge = $InvoiceLine->appendChild($AllowanceCharge);					
								
					//cbc:ChargeIndicator
					$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","false");
					$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);
					
					//cbc:AllowanceChargeReasonCode
					$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode","00");//X
					$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);
								
					////cbc:MultiplierNcrtorNumeric
//					$MultiplierNcrtorNumeric = $domtree->createElement("cbc:MultiplierNcrtorNumeric",$DatNotaCreditoDetalle->NcdPorcentajeDescuento);//X
//					$MultiplierNcrtorNumeric = $AllowanceCharge->appendChild($MultiplierNcrtorNumeric);
									
					//cbc:Amount
					$Amount = $domtree->createElement("cbc:Amount",$DatNotaCreditoDetalle->NcdDescuento);
					$Amount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
					$Amount = $AllowanceCharge->appendChild($Amount);		
					
					//cbc:BaseAmount
					$BaseAmount = $domtree->createElement("cbc:BaseAmount",$InsNotaCreditoDetalle1->NcdValorVentaBruto);
					$BaseAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
					$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);		
					
					
			}
					
		
			
			
			
			
			
				
		//cac:TaxTotal
		$TaxTotal = $domtree->createElement("cac:TaxTotal");
		$TaxTotal = $InvoiceLine->appendChild($TaxTotal);
		
		
			if($DatNotaCreditoDetalle->NcdExonerado == "1"){
				
				//cbc:TaxAmount
				$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
				$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);
						
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
					
					//cbc:TaxableAmount 
					$TaxableAmount = $domtree->createElement("cbc:TaxableAmount","0.00");
					$TaxableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
					$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
					
					//cbc:TaxAmount 
					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaCreditoDetalle->NcdValorVenta,2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
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
						$Percent = $domtree->createElement("cbc:Percent",$InsNotaCredito->NcrPorcentajeImpuestoVenta);
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
							
							
			}else if($DatNotaCreditoDetalle->NcdExonerado == "2"){
				
				
				//cbc:TaxAmount
				$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaCreditoDetalle->NcdImpuesto,2, '.', ''));
				$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);
						
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
					
					//cbc:TaxableAmount 
					$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($DatNotaCreditoDetalle->NcdValorVenta,2, '.', ''));
					$TaxableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
					$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
					
					//cbc:TaxAmount 
					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaCreditoDetalle->NcdImpuesto,2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
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
						$Percent = $domtree->createElement("cbc:Percent",$InsNotaCredito->NcrPorcentajeImpuestoVenta);
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

					//cac:PartyName
					$Description = $domtree->createElement("cbc:Description");
					$Description = $Item->appendChild($Description);

					$Description->appendChild($domtree->createCDATASection($DatNotaCreditoDetalle->NcdDescripcion )); 

				//cac:SellersItemIdentification		
				$SellersItemIdentification = $domtree->createElement("cac:SellersItemIdentification");
				$SellersItemIdentification = $Item->appendChild($SellersItemIdentification);

					$ID = $domtree->createElement("cbc:ID");
					$ID = $SellersItemIdentification->appendChild($ID);
					$ID->appendChild($domtree->createCDATASection($DatNotaCreditoDetalle->NcdCodigo )); 
					
				if(!empty($DatNotaCreditoDetalle->NcdCodigoGeneral)){
					
					//cac:CommodityClassification		
					$CommodityClassification = $domtree->createElement("cac:CommodityClassification");
					$CommodityClassification = $Item->appendChild($CommodityClassification);
					
						//cbc:PriceAmount currencyID="PEN"
						$ItemClassificationCode = $domtree->createElement("cbc:ItemClassificationCode",$DatNotaCreditoDetalle->NcdCodigoGeneral);
						$ItemClassificationCode->setAttribute('listID', "UNSPSC");
						$ItemClassificationCode->setAttribute('listAgencyName', "GS1 US");
						$ItemClassificationCode->setAttribute('listName', "Item Classification");
						$ItemClassificationCode = $CommodityClassification->appendChild($ItemClassificationCode);	
					
				}
				
				
			//cac:Price
			$Price = $domtree->createElement("cac:Price");
			$Price = $InvoiceLine->appendChild($Price);	
				
				if($DatNotaCreditoDetalle->NcdGratuito==1){
					
					//cbc:PriceAmount 
					$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
					$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
				
				}elseif($DatNotaCreditoDetalle->NcdGratuito==2){
					
					//cbc:PriceAmount
					$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaCreditoDetalle->NcdValorVentaUnitario,2, '.', ''));
					$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
					
				}else{
					
					//cbc:PriceAmount
					$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
					$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
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