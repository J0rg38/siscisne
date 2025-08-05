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
	//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacSubTotal,2, '.', ''));
	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalGravado,2, '.', ''));
	$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
	
	///'cbc:ID','1003'	//TOTAL EXONERADAS
	//sac:AdditionalMonetaryTotal
	$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
	$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
	$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1003'));
	
	//sac:PayableAmount
	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalExonerado,2, '.', ''));
	$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
	
	//'cbc:ID','1004'	//TOTAL GRATUITAS
	//sac:AdditionalMonetaryTotal
	$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
	$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
	$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1004'));
	
	//sac:PayableAmount
	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalGratuito,2, '.', ''));
	$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
	
	//'cbc:ID','2005' //TOTAL DESCUENTOS
	//sac:AdditionalMonetaryTotal
	$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
	$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
	$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','2005'));
	
	//sac:PayableAmount
	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalDescuento,2, '.', ''));
	$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
	
	
	///'cbc:ID','1000' //TOTAL EN LETRAS
	//sac:AdditionalProperty
	$AdditionalProperty = $domtree->createElement("sac:AdditionalProperty");
	$AdditionalProperty = $AdditionalInformation->appendChild($AdditionalProperty);
	$AdditionalProperty->appendChild($domtree->createElement('cbc:ID','1000'));
	
	//cbc:Value
	$Value = $domtree->createElement("cbc:Value",$FacturaTotalLetras);
	$Value = $AdditionalProperty->appendChild($Value);
	
	
	if(!empty($InsFactura->FacLeyenda)){
	
		
		///'cbc:ID','1002' //LEYENDA
		//sac:AdditionalProperty
		$AdditionalProperty = $domtree->createElement("sac:AdditionalProperty");
		$AdditionalProperty = $AdditionalInformation->appendChild($AdditionalProperty);
		$AdditionalProperty->appendChild($domtree->createElement('cbc:ID','1002'));
		
		//cbc:Value
		$Value = $domtree->createElement("cbc:Value",$InsFactura->FacLeyenda." ".number_format($InsFactura->FacTotalGratuito,2));
		$Value = $AdditionalProperty->appendChild($Value);
	
		
	}
	
	

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
$ID = $domtree->createElement("cbc:ID",$InsFactura->FtaNumero."-".$InsFactura->FacId);
$ID = $xmlRoot->appendChild($ID);

//cbc:IssueDate
$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($InsFactura->FacFechaEmision));
$IssueDate = $xmlRoot->appendChild($IssueDate);



//cbc:InvoiceTypeCode
$InvoiceTypeCode = $domtree->createElement("cbc:InvoiceTypeCode","01");
$InvoiceTypeCode = $xmlRoot->appendChild($InvoiceTypeCode);

//cbc:DocumentCurrencyCode
$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsFactura->MonSigla);
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
			
	//cac:DigitalSignatureAttachment
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
			$ID = $domtree->createElement("cbc:ID",$InsFactura->SucCodigoUbigeo);
			$ID = $PostalAddress->appendChild($ID);
			
			//cbc:StreetName
			$StreetName = $domtree->createElement("cbc:StreetName",$InsFactura->SucDireccion);
			$StreetName = $PostalAddress->appendChild($StreetName);
	
			//cbc:District
			$District = $domtree->createElement("cbc:District",$InsFactura->SucDistrito);
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

//	if(!empty($InsFactura->CliNumeroDocumento)){
		//cbc:CustomerAssignedAccountID
		$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$InsFactura->CliNumeroDocumento);
		$CustomerAssignedAccountID = $AccountingCustomerParty->appendChild($CustomerAssignedAccountID);	
		
		//cbc:AdditionalAccountID
		$AdditionalAccountID = $domtree->createElement("cbc:AdditionalAccountID",round($InsFactura->TdoCodigo,0));
		$AdditionalAccountID = $AccountingCustomerParty->appendChild($AdditionalAccountID);	
	
//	}else{
//		
//		//cbc:CustomerAssignedAccountID
//		$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$InsFactura->CliNumeroDocumento);
//		$CustomerAssignedAccountID = $AccountingCustomerParty->appendChild($CustomerAssignedAccountID);	
//		
//		//cbc:AdditionalAccountID
//		$AdditionalAccountID = $domtree->createElement("cbc:AdditionalAccountID","0");
//		$AdditionalAccountID = $AccountingCustomerParty->appendChild($AdditionalAccountID);	
//		
//	}


 	//cac:Party
	$Party = $domtree->createElement("cac:Party");
	$Party = $AccountingCustomerParty->appendChild($Party);
	
		//cac:PhysicalLocation
		$PhysicalLocation = $Party->appendChild($domtree->createElement( 'cac:PhysicalLocation' ));
		
		//cac:Name		
		$Description = $PhysicalLocation->appendChild($domtree->createElement('cbc:Description')); 
		$Description->appendChild($domtree->createCDATASection( $InsFactura->FacDireccion )); 
			
		//cac:PartyLegalEntity
		$PartyLegalEntity = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
		
		//cac:Name		
		$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
		$RegistrationName->appendChild($domtree->createCDATASection( $InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno )); 
		
			
 
//cac:TaxTotal
$TaxTotal = $domtree->createElement("cac:TaxTotal");
$TaxTotal = $xmlRoot->appendChild($TaxTotal);

	//cbc:TaxAmount
	$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsFactura->FacImpuesto,2, '.', ''));
	$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$TaxAmount = $TaxTotal->appendChild($TaxAmount);
			
			
	//cac:TaxSubtotal
	$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
	$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
		
		//cbc:TaxAmount 
		$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsFactura->FacImpuesto,2, '.', ''));
		$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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
	$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsFactura->FacTotalImpuestoSelectivo,2, '.', ''));
	$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$TaxAmount = $TaxTotal->appendChild($TaxAmount);
			
	//cac:TaxSubtotal
	$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
	$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
		
		//cbc:TaxAmount 
		$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsFactura->FacTotalImpuestoSelectivo,2, '.', ''));
		$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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
				
				

/*<cac:TaxTotal>
<cbc:TaxAmount currencyID="PEN">21273.87</cbc:TaxAmount>
<cac:TaxSubtotal>
<cbc:TaxAmount currencyID="PEN">21273.87</cbc:TaxAmount>
<cac:TaxCategory>
<cac:TaxScheme>
<cbc:ID>2000</cbc:ID>
<cbc:Name>ISC</cbc:Name>
<cbc:TaxTypeCode>EXC</cbc:TaxTypeCode>
</cac:TaxScheme>
</cac:TaxCategory>
</cac:TaxSubtotal>
*/


 
//cac:LegalMonetaryTotal
$LegalMonetaryTotal = $domtree->createElement("cac:LegalMonetaryTotal");
$LegalMonetaryTotal = $xmlRoot->appendChild($LegalMonetaryTotal);

	//cbc:AllowanceTotalAmount currencyID="PEN"
	$AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount",number_format($InsFactura->FacTotalDescuento,2, '.', ''));
	$AllowanceTotalAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
	

	//cbc:PayableAmount currencyID="PEN"
	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalPagar,2, '.', ''));
	$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
	$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);


$fila = 1;
if(!empty($InsFactura->FacturaDetalle)){
	foreach($InsFactura->FacturaDetalle as $DatFacturaDetalle){
		
		if($InsFactura->MonId<>$EmpresaMonedaId){
			
			$DatFacturaDetalle->FdeValorVenta = round($DatFacturaDetalle->FdeValorVenta/$InsFactura->FacTipoCambio,2);
			$DatFacturaDetalle->FdeValorVentaUnitario = round($DatFacturaDetalle->FdeValorVentaUnitario/$InsFactura->FacTipoCambio,2);
			
			$DatFacturaDetalle->FdePrecio = round($DatFacturaDetalle->FdePrecio/$InsFactura->FacTipoCambio,2);
			$DatFacturaDetalle->FdeImpuesto = round($DatFacturaDetalle->FdeImpuesto/$InsFactura->FacTipoCambio,2);
			
		}
			

			//cac:InvoiceLine
		$InvoiceLine = $domtree->createElement("cac:InvoiceLine");
		$InvoiceLine = $xmlRoot->appendChild($InvoiceLine);	
			
			//cbc:ID
			$ID = $domtree->createElement("cbc:ID",$fila);
			$ID = $InvoiceLine->appendChild($ID);	
			
			//cbc:InvoicedQuantity unitCode="NIU"
			$InvoicedQuantity = $domtree->createElement("cbc:InvoicedQuantity",number_format($DatFacturaDetalle->FdeCantidad,2, '.', ''));
			$InvoicedQuantity->setAttribute('unitCode', 'NIU');
			$InvoicedQuantity = $InvoiceLine->appendChild($InvoicedQuantity);	
			
			//cbc:LineExtensionAmount currencyID="PEN"
			$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount",number_format($DatFacturaDetalle->FdeValorVenta,2, '.', ''));
			$LineExtensionAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			$LineExtensionAmount = $InvoiceLine->appendChild($LineExtensionAmount);	
				
			//cac:PricingReference
			$PricingReference = $domtree->createElement("cac:PricingReference");
			$PricingReference = $InvoiceLine->appendChild($PricingReference);	
						
						if($DatFacturaDetalle->FdeGratuito==1){
							
							//cac:AlternativeConditionPrice
							$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
							$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
							
							//cbc:PriceAmount currencyID="PEN"
							$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
							$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
							$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	

							//cbc:PriceTypeCode
							$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
							$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);

							//cac:AlternativeConditionPrice
							$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
							$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);

							//cbc:PriceAmount currencyID="PEN"
							$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatFacturaDetalle->FdeValorVentaUnitario,2, '.', ''));
							$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
							$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	

							//cbc:PriceTypeCode
							$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","02");
							$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);

//							cac:AlternativeConditionPrice
//							$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
//							$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
//							
//							//cbc:PriceAmount currencyID="PEN"
//							$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatFacturaDetalle->FdePrecio,2, '.', ''));
//							$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
//							$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
//
//							//cbc:PriceTypeCode
//							$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
//							$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
						
							
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
							$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
						
							
						}else{
							
							//cac:AlternativeConditionPrice
							$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
							$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
							
							//cbc:PriceAmount currencyID="PEN"
							$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
							$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
							$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
							
							//cbc:PriceTypeCode
							$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","00");
							$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
							
						}
						
							
			///IGV - INICIO
			//cac:TaxTotal
			$TaxTotal = $domtree->createElement("cac:TaxTotal");
			$TaxTotal = $InvoiceLine->appendChild($TaxTotal);	
				
			if($DatFacturaDetalle->FdeGratuito == "2"){
					
				//cbc:TaxAmount currencyID="PEN"
				$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatFacturaDetalle->FdeImpuesto,2, '.', ''));
				$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
					
			}else if($DatFacturaDetalle->FdeGratuito == "1"){
					
				//cbc:TaxAmount currencyID="PEN"
				$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
				$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);	

				//$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatFacturaDetalle->FdeImpuesto,2, '.', ''));
//				$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
//				$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
				
					
			}else{
					
				//cbc:TaxAmount currencyID="PEN"
				$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
				$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
					
			}
				
				
			
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);	
					
				if($DatFacturaDetalle->FdeGratuito == "2"){

					//cbc:TaxAmount currencyID="PEN"
					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatFacturaDetalle->FdeImpuesto,2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);		
					
				}else if($DatFacturaDetalle->FdeGratuito == "1"){

					//cbc:TaxAmount currencyID="PEN"
					$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
					$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);	
					
					//$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatFacturaDetalle->FdeImpuesto,2, '.', ''));
					//$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					//$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);		
					
				}else{
					
					//cbc:TaxAmount currencyID="PEN"
					$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
					$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);	
					
				}
					
					
					//cbc:TaxAmount currencyID="PEN"
					$Percent = $domtree->createElement("cbc:Percent",($InsFactura->FacPorcentajeImpuestoVenta));
					$Percent = $TaxSubtotal->appendChild($Percent);	
				
					//cac:TaxCategory
					$TaxCategory = $domtree->createElement("cac:TaxCategory");
					$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);	
						
						//cbc:TaxExemptionReasonCode
						//$ID = $domtree->createElement("cbc:ID",$DatFacturaDetalle->FdeId);
						//$ID = $TaxCategory->appendChild($ID);
						
						//cbc:TaxExemptionReasonCode
						
					  if($DatFacturaDetalle->FdeExonerado == "1"){//20
						  
						  if($DatFacturaDetalle->FdeGratuito == "1"){//20
						  								
							  $TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","21");
							  $TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
							  
						  }else{
							  
							  $TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","20");
							  $TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
							  
						  }
						  
					  
					  }else if($DatFacturaDetalle->FdeExonerado == "2"){//10
						  
						  if($DatFacturaDetalle->FdeGratuito == "1"){//20
						  	
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
								
			//IGV - FIN
			
			
			
			if($DatFacturaDetalle->FdeImpuestoSelectivo>0){
				
				
					//ISC - INICIO
					
					//cac:TaxTotal
					$TaxTotal = $domtree->createElement("cac:TaxTotal");
					$TaxTotal = $InvoiceLine->appendChild($TaxTotal);	
						
						//cbc:TaxAmount currencyID="PEN"
						$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatFacturaDetalle->FdeImpuestoSelectivo,2, '.', ''));
						$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
						$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
					
						//cac:TaxSubtotal
						$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
						$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);	
						
							//cbc:TaxAmount currencyID="PEN"
							$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatFacturaDetalle->FdeImpuestoSelectivo,2, '.', ''));
							$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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

				
				
				$pos = strrpos($DatFacturaDetalle->FdeDescripcion, "|");
				
				if ($pos === false) { // nota: tres signos de igual
					
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
						
					//cbc:Description
					$Description = $domtree->createElement("cbc:Description");
					$Description = $Item->appendChild($Description);

					$Description->appendChild($domtree->createCDATASection($DatFacturaDetalle->FdeDescripcion )); 
					
				}else{
					
					$ArrRepuestos = explode("|",$DatFacturaDetalle->FdeDescripcion);
					
					$fila = 1;
					if(!empty($ArrRepuestos)){
						foreach($ArrRepuestos as $DatRepuesto){
							
							//cbc:Description
							$Description = $domtree->createElement("cbc:Description");
							$Description = $Item->appendChild($Description);
							
							
								if($fila==1){
									
									if(!empty($InsFactura->OvvId)){
					
										 if(!empty($InsFactura->FacDatoAdicional13) or !empty($InsFactura->FacDatoAdicional7) or !empty($InsFactura->FacDatoAdicional1)){
											
											$DatRepuesto .= "( ";
										
										  }
										
										  if(!empty($InsFactura->FacDatoAdicional13)){
											
											$DatRepuesto .= "Nro. VIN o CHASIS: ".$InsFactura->FacDatoAdicional13.", ";
											
										  }
										
										  if(!empty($InsFactura->FacDatoAdicional7)){
										 
												$DatRepuesto .= "Nro. Motor: ".$InsFactura->FacDatoAdicional7.", ";
											
										  }
										  
										  if(!empty($InsFactura->FacDatoAdicional1)){
										 
												$DatRepuesto .= "Marca: ".$InsFactura->FacDatoAdicional1." ";
										 
										  }
										
										  if(!empty($InsFactura->FacDatoAdicional13) or !empty($InsFactura->FacDatoAdicional7) or !empty($InsFactura->FacDatoAdicional1)){
											
												$DatRepuesto .= " )";
										   
										  }
								  
									}
									
								}
								
								
							$Description->appendChild($domtree->createCDATASection($DatRepuesto)); 
							
							$fila++;
							
						}						
					}
					
				}
				
					
				

//
//						if(!empty($InsFactura->FacDatoAdicional1)){
//							
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("MARCA: ".$InsFactura->FacDatoAdicional1 )); 
//					
//						}
//						
//						if(!empty($InsFactura->FacDatoAdicional2)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("TRACCION: ".$InsFactura->FacDatoAdicional2 )); 
//							
//						}
//							
//						if(!empty($InsFactura->FacDatoAdicional3)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("MODELO: ".$InsFactura->FacDatoAdicional3 )); 
//							
//						}
//						
//						if(!empty($InsFactura->FacDatoAdicional4)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("CARROCERIA: ".$InsFactura->FacDatoAdicional4 ));
//							
//						}
//						
//						
//						if(!empty($InsFactura->FacDatoAdicional5)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("AÑO FABRIC.: ".$InsFactura->FacDatoAdicional5 ));
//							
//						}
//							
//						if(!empty($InsFactura->FacDatoAdicional6)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. PUERTAS: ".$InsFactura->FacDatoAdicional6 ));
//							
//						}
//						
//						if(!empty($InsFactura->FacDatoAdicional7)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. MOTOR: ".$InsFactura->FacDatoAdicional7 ));
//							
//						}
//						
//						
//						if(!empty($InsFactura->FacDatoAdicional8)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("COMBUSTIBLE: ".$InsFactura->FacDatoAdicional8 ));
//							
//						}
//						
//						if(!empty($InsFactura->FacDatoAdicional9)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. CILINDROS: ".$InsFactura->FacDatoAdicional9 ));
//							
//						}
//						
//						if(!empty($InsFactura->FacDatoAdicional10)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("PESO BRUTO: ".$InsFactura->FacDatoAdicional10 ));
//							
//						}
//						
//						if(!empty($InsFactura->FacDatoAdicional11)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. EJES: ".$InsFactura->FacDatoAdicional11 ));
//							
//						}
//						
//						if(!empty($InsFactura->FacDatoAdicional12)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("CARGA UTIL: ".$InsFactura->FacDatoAdicional12 ));
//							
//						}
//						
//						
//						if(!empty($InsFactura->FacDatoAdicional13)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. CHASIS: ".$InsFactura->FacDatoAdicional13 ));
//							
//						}
//						
//						if(!empty($InsFactura->FacDatoAdicional14)){	
//						//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("PESO SECO: ".$InsFactura->FacDatoAdicional14 ));
//							
//						}
//						
//						
//						if(!empty($InsFactura->FacDatoAdicional15)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("COLOR: ".$InsFactura->FacDatoAdicional15 ));
//							
//						}
//						
//						
//						if(!empty($InsFactura->FacDatoAdicional16)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("ALTO: ".$InsFactura->FacDatoAdicional16 ));
//							
//						}
//						
//						if(!empty($InsFactura->FacDatoAdicional17)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("CILINDRADA: ".$InsFactura->FacDatoAdicional17 ));
//							
//						}
//						
//						
//						if(!empty($InsFactura->FacDatoAdicional18)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("LARGO: ".$InsFactura->FacDatoAdicional18 ));
//							
//						}
//						
//						if(!empty($InsFactura->FacDatoAdicional19)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. ASIENTOS: ".$InsFactura->FacDatoAdicional19 ));
//							
//						}
//						
//						
//						if(!empty($InsFactura->FacDatoAdicional20)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("ANCHO: ".$InsFactura->FacDatoAdicional20 ));
//							
//						}
//						
//						
//						if(!empty($InsFactura->FacDatoAdicional21)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("CAP. PASAJEROS: ".$InsFactura->FacDatoAdicional21 ));
//							
//						}
//						
//						if(!empty($InsFactura->FacDatoAdicional122)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("DIST. EJES: ".$InsFactura->FacDatoAdicional122 ));
//							
//						}
//						
//						
//						if(!empty($InsFactura->FacDatoAdicional23)){	
//						
//							//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//
//							$Description->appendChild($domtree->createCDATASection("NO. POLIZA: ".$InsFactura->FacDatoAdicional23 ));
//							
//						}
						
						

				//cac:SellersItemIdentification		
				$SellersItemIdentification = $domtree->createElement("cac:SellersItemIdentification");
				$SellersItemIdentification = $Item->appendChild($SellersItemIdentification);

					$ID = $domtree->createElement("cbc:ID");
					$ID = $SellersItemIdentification->appendChild($ID);
					$ID->appendChild($domtree->createCDATASection($DatFacturaDetalle->FdeCodigo )); 
					
			//cac:Price
			$Price = $domtree->createElement("cac:Price");
			$Price = $InvoiceLine->appendChild($Price);	
				
				
				if($DatFacturaDetalle->FdeGratuito==1){
					
					//cbc:PriceAmount currencyID="PEN"
					$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
					$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
					//$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatFacturaDetalle->FdeValorVentaUnitario,2, '.', ''));
					//$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					//$PriceAmount = $Price->appendChild($PriceAmount);	
					
				}elseif($DatFacturaDetalle->FdeGratuito==2){
					
					//cbc:PriceAmount currencyID="PEN"
					$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatFacturaDetalle->FdeValorVentaUnitario,2, '.', ''));
					$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
					
				}else{
					
					//cbc:PriceAmount currencyID="PEN"
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