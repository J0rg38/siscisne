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
//deb($GET_ta);

require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemision.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsGuiaRemision = new ClsGuiaRemision();
$InsGuiaRemision->GreId = $GET_id;
$InsGuiaRemision->GrtId = $GET_ta;
//deb($InsGuiaRemision->GrtId."aaaaa");
$InsGuiaRemision->MtdObtenerGuiaRemision();

//deb($InsGuiaRemision);
//deb($InsGuiaRemision->GrtId);

$NOMBRE = $EmpresaCodigo.'-09-'.$InsGuiaRemision->GrtNumero.'-'.$InsGuiaRemision->GreId;
$ARCHIVO = $NOMBRE.'.xml';

//$domtree = new DOMDocument('1.0', 'ISO-8859-1');
$domtree = new DOMDocument('1.0', 'UTF-8');

//$domtree->preserveWhiteSpace = false;
$domtree->formatOutput = true;
//$domtree->xmlStandalone = false;

/* create the root element of the xml tree */
$xmlRoot = $domtree->createElement("DespatchAdvice");
/* append it to the document created */
$xmlRoot = $domtree->appendChild($xmlRoot);


/*
Yo lo tenía así:
xmlns="urn:sunat:names:specification:ubl:schema:xsd:Retention-1"
Y debe ser así:
xmlns="urn:sunat:names:specification:ubl:peru:schema:xsd:Retention-1"

*/

/*
<?xml version="1.0" encoding="UTF-8"?>
<DespatchAdvice xmlns="urn:oasis:names:specification:ubl:schema:xsd:DespatchAdvice-2" 
xmlns:ds="http://www.w3.org/2000/09/xmldsig#" 
xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" 
xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" 
xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">


<ext:UBLExtensions>
<ext:UBLExtension>
<ext:ExtensionContent/>
</ext:UBLExtension>
<ext:UBLExtension xmlns="" xmlns:ar="urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2">
<ext:ExtensionContent>
<Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
*/


$xmlRoot->setAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:DespatchAdvice-2');
$xmlRoot->setAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
$xmlRoot->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
$xmlRoot->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
$xmlRoot->setAttribute('xmlns:ext', 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2');


//ext:UBLExtensions
$UBLExtensions = $domtree->createElement("ext:UBLExtensions");
$UBLExtensions = $xmlRoot->appendChild($UBLExtensions);

//ext:UBLExtension1
$UBLExtension1 = $domtree->createElement("ext:UBLExtension");
$UBLExtension1 = $UBLExtensions->appendChild($UBLExtension1);

//sac:ExtensionContent1
$ExtensionContent1 = $domtree->createElement("ext:ExtensionContent");
$ExtensionContent1 = $UBLExtension1->appendChild($ExtensionContent1);


//ext:UBLExtension2
$UBLExtension2 = $domtree->createElement("ext:UBLExtension");
$UBLExtension2->setAttribute('xmlns', '');
$UBLExtension2->setAttribute('xmlns:ar', 'urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2');
$UBLExtension2 = $UBLExtensions->appendChild($UBLExtension2);

//sac:ExtensionContent2
$ExtensionContent2 = $domtree->createElement("ext:ExtensionContent");
$ExtensionContent2 = $UBLExtension2->appendChild($ExtensionContent2);



	//
////ext:UBLVersionID
////$UBLVersionID = $domtree->createElement("cbc:UBLVersionID","12.0");
//$UBLVersionID = $domtree->createElement("cbc:UBLVersionID","2.0");
//$UBLVersionID = $xmlRoot->appendChild($UBLVersionID);
//
////ext:CustomizationID
//$CustomizationID = $domtree->createElement("cbc:CustomizationID","1.0");
//$CustomizationID = $xmlRoot->appendChild($CustomizationID);
//
//// ////////////////////////////////////////////////////////////////////////////////////////////////
////cbc:ID
//$ID = $domtree->createElement("cbc:ID",$InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId);
//$ID = $xmlRoot->appendChild($ID);
//
////cbc:IssueDate
//$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($InsGuiaRemision->GreFechaEmision,false));
//$IssueDate = $xmlRoot->appendChild($IssueDate);
//
////cbc:DespatchAdviceTypeCode
//$DespatchAdviceTypeCode = $domtree->createElement("cbc:DespatchAdviceTypeCode","09");
//$DespatchAdviceTypeCode = $xmlRoot->appendChild($DespatchAdviceTypeCode);
//
////cbc:Note
//$Note = $domtree->createElement("cbc:Note");
//$Note = $xmlRoot->appendChild($Note);
//$Note->appendChild($domtree->createCDATASection($InsGuiaRemision->GreObservacionImpresa)); 	
//
//

	
	
//$Note->appendChild($domtree->createCDATASection("")); 	
	
//	//cac:OrderReference
//	$OrderReference = $domtree->createElement("cac:OrderReference");
//	$OrderReference = $xmlRoot->appendChild($OrderReference);
//			
//		//cbc:ID
//		$ID = $domtree->createElement("cbc:ID","T001-0001");
//		$ID = $OrderReference->appendChild($ID);
//	
//		//cbc:CustomerAssignedAccountID
//		$OrderTypeCode = $domtree->createElement("cbc:OrderTypeCode","09");
//		$OrderTypeCode->setAttribute('name', "Guía de Remisión");
//		$OrderTypeCode = $OrderReference->appendChild($OrderTypeCode);
//		
		
		
//if(!empty($InsGuiaRemision->GreReferencia)){//AUN NO EXISTE
//	
//	//cac:OrderReference
//	$OrderReference = $domtree->createElement("cac:OrderReference");
//	$OrderReference = $xmlRoot->appendChild($OrderReference);
//			
//		//cbc:ID
//		$ID = $domtree->createElement("cbc:ID",$InsGuiaRemision->GreReferencia);
//		$ID = $OrderReference->appendChild($ID);
//	
//		//cbc:CustomerAssignedAccountID
//		$OrderTypeCode = $domtree->createElement("cbc:OrderTypeCode","09");
//		$OrderTypeCode->setAttribute('name', "Guía de Remisión");
//		$OrderTypeCode = $OrderReference->appendChild($OrderTypeCode);
//	
//}
	////cac:AdditionalDocumentReference
//	$AdditionalDocumentReference = $domtree->createElement("cac:AdditionalDocumentReference");
//	$AdditionalDocumentReference = $xmlRoot->appendChild($AdditionalDocumentReference);
//	
//		//cbc:ID
//		$ID = $domtree->createElement("cbc:ID","T001-0001");
//		$ID = $AdditionalDocumentReference->appendChild($ID);
//	
//		//cbc:DocumentTypeCode
//		$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode","09");
//		$DocumentTypeCode = $AdditionalDocumentReference->appendChild($DocumentTypeCode);	
		

//if(!empty($InsGuiaRemision->GreReferenciaAdicional)){//AUN NO EXISTE
//
//	//cac:AdditionalDocumentReference
//	$AdditionalDocumentReference = $domtree->createElement("cac:AdditionalDocumentReference");
//	$AdditionalDocumentReference = $xmlRoot->appendChild($AdditionalDocumentReference);
//	
//		//cbc:ID
//		$ID = $domtree->createElement("cbc:ID",$InsGuiaRemision->GreReferenciaAdicional);
//		$ID = $AdditionalDocumentReference->appendChild($ID);
//	
//		//cbc:DocumentTypeCode
//		$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode","09");
//		$DocumentTypeCode = $AdditionalDocumentReference->appendChild($DocumentTypeCode);	
//
//}



////ext:UBLExtension3
//$UBLExtension3 = $domtree->createElement("ext:UBLExtension");
//$UBLExtension3 = $UBLExtensions->appendChild($UBLExtension3);
////$UBLExtension2->setAttribute('xmlns', '');
////$UBLExtension2->setAttribute('xmlns:ar', 'urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2');
//
////sac:ExtensionContent2
//$ExtensionContent3 = $domtree->createElement("ext:ExtensionContent");
//$ExtensionContent3 = $UBLExtension3->appendChild($ExtensionContent3);

//ext:UBLVersionID
$UBLVersionID = $domtree->createElement("cbc:UBLVersionID","2.1");
$UBLVersionID = $xmlRoot->appendChild($UBLVersionID);

//ext:CustomizationID
$CustomizationID = $domtree->createElement("cbc:CustomizationID","1.0");
$CustomizationID = $xmlRoot->appendChild($CustomizationID);

//cbc:ID
$ID = $domtree->createElement("cbc:ID",$InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId);
$ID = $xmlRoot->appendChild($ID);

//cbc:IssueDate
$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($InsGuiaRemision->GreFechaEmision));
$IssueDate = $xmlRoot->appendChild($IssueDate);

//cbc:IssueTime
$IssueTime = $domtree->createElement("cbc:IssueTime",($InsGuiaRemision->GreHoraInicioTraslado));
$IssueTime = $xmlRoot->appendChild($IssueTime);

//cbc:InvoiceTypeCode
$DespatchAdviceTypeCode = $domtree->createElement("cbc:DespatchAdviceTypeCode","09");
$DespatchAdviceTypeCode = $xmlRoot->appendChild($DespatchAdviceTypeCode);


//cbc:IssueTime
$Note = $domtree->createElement("cbc:Note",("CONDUCTOR: ".$InsGuiaRemision->GreChofer." DOCUMENTO: ".$InsGuiaRemision->GreChoferNumeroDocumento." / ". $InsGuiaRemision->GreObservacionImpresa));
$Note = $xmlRoot->appendChild($Note);

////cbc:DocumentCurrencyCode
//$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsGuiaRemision->MonSigla);
//$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);

//
////cac:Signature
//$Signature = $domtree->createElement("cac:Signature");
//$Signature = $xmlRoot->appendChild($Signature);
//	
////	//cbc:ID
//	$ID = $domtree->createElement("cbc:ID","IDSignSP");//IDSignSP
//	$ID = $Signature->appendChild($ID);
//	
//	//cac:SignatoryParty
//	$SignatoryParty = $domtree->createElement("cac:SignatoryParty");
//	$SignatoryParty = $Signature->appendChild($SignatoryParty);
//	
//		//cac:PartyIdentification
//		$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
//		$PartyIdentification = $SignatoryParty->appendChild($PartyIdentification);
//	
//			//cbc:ID
//			$ID = $domtree->createElement("cbc:ID",$EmpresaCodigo);
//			$ID = $PartyIdentification->appendChild($ID);
//		
//			//cac:PartyName
//			$base = $SignatoryParty->appendChild($domtree->createElement( 'cac:PartyName' ));
//			
//			//cac:Name		
//			$name = $base->appendChild($domtree->createElement('cbc:Name')); 
//			$name->appendChild($domtree->createCDATASection( $EmpresaNombre )); 
//			
//	//cbc:DigitalSignatureAttachment
//	$DigitalSignatureAttachment = $domtree->createElement("cac:DigitalSignatureAttachment");
//	$DigitalSignatureAttachment = $Signature->appendChild($DigitalSignatureAttachment);
//
//		//cac:ExternalReference
//		$ExternalReference = $domtree->createElement("cac:ExternalReference");
//		$ExternalReference = $DigitalSignatureAttachment->appendChild($ExternalReference);
//			
//			//cbc:URI
//			$URI = $domtree->createElement("cbc:URI","#SignatureSP");
//			$URI = $ExternalReference->appendChild($URI);
//		
//		
		
		
//DATOS REMITENTE

//cac:AccountingSupplierParty
$DespatchSupplierParty = $domtree->createElement("cac:DespatchSupplierParty");
$DespatchSupplierParty = $xmlRoot->appendChild($DespatchSupplierParty);

	//cbc:CustomerAssignedAccountID
	$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$EmpresaCodigo);
	$CustomerAssignedAccountID->setAttribute('schemeID', "6");
	$CustomerAssignedAccountID = $DespatchSupplierParty->appendChild($CustomerAssignedAccountID);
	
	//cac:Party
	$Party = $domtree->createElement("cac:Party");
	$Party = $DespatchSupplierParty->appendChild($Party);
	
		//cac:PartyLegalEntity
		$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
		$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);

			//cbc:RegistrationName
			$RegistrationName = $domtree->createElement("cbc:RegistrationName");
			$RegistrationName = $PartyLegalEntity->appendChild($RegistrationName);
			$RegistrationName->appendChild($domtree->createCDATASection($EmpresaNombre)); 		
		
//			//cbc:RegistrationName
//			$RegistrationName = $domtree->createElement("cbc:RegistrationName",$EmpresaNombre);
//			$RegistrationName = $PartyLegalEntity->appendChild($RegistrationName);
		
			
//cac:DeliveryCustomerParty/
$DeliveryCustomerParty = $domtree->createElement("cac:DeliveryCustomerParty");
$DeliveryCustomerParty = $xmlRoot->appendChild($DeliveryCustomerParty);		
		
	//cbc:CustomerAssignedAccountID
	$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$InsGuiaRemision->CliNumeroDocumento);
	//$CustomerAssignedAccountID->setAttribute('schemeID', str_pad($InsGuiaRemision->TdoCodigoCliente, 2, "0", STR_PAD_LEFT));
	$CustomerAssignedAccountID->setAttribute('schemeID', ($InsGuiaRemision->TdoCodigo+1-1));
	$CustomerAssignedAccountID = $DeliveryCustomerParty->appendChild($CustomerAssignedAccountID);
	
	//cac:Party
	$Party = $domtree->createElement("cac:Party");
	$Party = $DeliveryCustomerParty->appendChild($Party);
	
		//cac:PartyLegalEntity
		$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
		$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);

			//cbc:RegistrationName
			$RegistrationName = $domtree->createElement("cbc:RegistrationName");
			$RegistrationName = $PartyLegalEntity->appendChild($RegistrationName);
			$RegistrationName->appendChild($domtree->createCDATASection($InsGuiaRemision->CliNombre." ".$InsGuiaRemision->CliApellidoPaterno." ".$InsGuiaRemision->CliApellidoMaterno )); 
	
//			//cbc:RegistrationName
//			$RegistrationName = $domtree->createElement("cbc:RegistrationName",$InsGuiaRemision->CliNombre." ".$InsGuiaRemision->CliApellidoPaterno." ".$InsGuiaRemision->CliApellidoMaterno);
//			$RegistrationName = $PartyLegalEntity->appendChild($RegistrationName);
				
//cac:Shipment/
$Shipment = $domtree->createElement("cac:Shipment");
$Shipment = $xmlRoot->appendChild($Shipment);				
			
	// ////////////////////////////////////////////////////////////////////////////////////////////////
	//cbc:ID
	$ID = $domtree->createElement("cbc:ID","1");
	$ID = $Shipment->appendChild($ID);

	//cbc:HandlingCode
	//$HandlingCode = $domtree->createElement("cbc:HandlingCode",$InsGuiaRemision->GreMotivoTrasladoCodigo);
	//$HandlingCode = $Shipment->appendChild($HandlingCode);
	
	$HandlingCode = $domtree->createElement("cbc:HandlingCode",str_pad($InsGuiaRemision->GreMotivoTrasladoCodigo,2,"0",STR_PAD_LEFT));
	$HandlingCode = $Shipment->appendChild($HandlingCode);

	//cbc:Information
	$Information = $domtree->createElement("cbc:Information");
	$Information = $Shipment->appendChild($Information);
	//$Information->appendChild($domtree->createCDATASection($InsGuiaRemision->GreMotivoTrasladoDescripcion)); 
	$Information->appendChild($domtree->createCDATASection($InsGuiaRemision->ScaNombre)); 

//	$Information = $domtree->createElement("cbc:Information",$InsGuiaRemision->GreMotivoTrasladoDescripcion);
//	$Information = $Shipment->appendChild($Information);

/*	//cbc:SplitConsignmentIndicator
	//$SplitConsignmentIndicator = $domtree->createElement("cbc:SplitConsignmentIndicator","false");
	$SplitConsignmentIndicator = $domtree->createElement("cbc:SplitConsignmentIndicator","false");
	$SplitConsignmentIndicator = $Shipment->appendChild($SplitConsignmentIndicator);
			
	//cbc:GrossWeightMeasure
	$GrossWeightMeasure = $domtree->createElement("cbc:GrossWeightMeasure",round($InsGuiaRemision->GrePesoTotal,0));//Peso Total
	$GrossWeightMeasure->setAttribute('unitCode', "KG");
	$GrossWeightMeasure = $Shipment->appendChild($GrossWeightMeasure);
	
	if(!empty($InsGuiaRemision->GreTotalPaquetes)){
		//cbc:TotalTransportHandlingUnitQuantity
		$TotalTransportHandlingUnitQuantity = $domtree->createElement("cbc:TotalTransportHandlingUnitQuantity",round($InsGuiaRemision->GreTotalPaquetes,0));//NUM BULTOS
		$TotalTransportHandlingUnitQuantity = $Shipment->appendChild($TotalTransportHandlingUnitQuantity);	
		
	}else{
				//cbc:TotalTransportHandlingUnitQuantity
		$TotalTransportHandlingUnitQuantity = $domtree->createElement("cbc:TotalTransportHandlingUnitQuantity",0);//NUM BULTOS
		$TotalTransportHandlingUnitQuantity = $Shipment->appendChild($TotalTransportHandlingUnitQuantity);	

	}
	*/
	
//	$ID = $domtree->createElement("cbc:ID","1");
//	$ID = $Shipment->appendChild($ID);

	//cac:ShipmentStage
	$ShipmentStage = $domtree->createElement("cac:ShipmentStage");
	$ShipmentStage = $Shipment->appendChild($ShipmentStage);
//	$ShipmentStage = $Shipment;		
		
		if(!empty($InsGuiaRemision->PrvId)){
			//cbc:TransportModeCode
			$TransportModeCode = $domtree->createElement("cbc:TransportModeCode","1");//CATALOGO 18  //01 - Trans. Pub. 02 - Trans. Priv.
			$TransportModeCode = $ShipmentStage->appendChild($TransportModeCode);		
		}else{
			//cbc:TransportModeCode
			$TransportModeCode = $domtree->createElement("cbc:TransportModeCode","2");//CATALOGO 18  //01 - Trans. Pub. 02 - Trans. Priv.
			$TransportModeCode = $ShipmentStage->appendChild($TransportModeCode);	
		}

		//cac:TransitPeriod
		$TransitPeriod = $domtree->createElement("cac:TransitPeriod");
		$TransitPeriod = $ShipmentStage->appendChild($TransitPeriod);		
		
			//cbc:StartDate
			$StartDate = $domtree->createElement("cbc:StartDate",FncCambiaFechaAMysql($InsGuiaRemision->GreFechaInicioTraslado,false));
			$StartDate = $TransitPeriod->appendChild($StartDate);	
			
			
		if(!empty($InsGuiaRemision->PrvId)){
			
			//cac:CarrierParty
			$CarrierParty = $domtree->createElement("cac:CarrierParty");
			$CarrierParty = $ShipmentStage->appendChild($CarrierParty);	
				
				//cac:PartyIdentification
				$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
				$PartyIdentification = $CarrierParty->appendChild($PartyIdentification);		
			
					//cbc:ID
					$ID = $domtree->createElement("cbc:ID",$InsGuiaRemision->PrvNumeroDocumento);//DNI Conductor
					$ID->setAttribute('schemeID', "6");
					$ID = $PartyIdentification->appendChild($ID);
			
					
				//cac:PartyName
				$PartyName = $domtree->createElement("cac:PartyName");
				$PartyName = $CarrierParty->appendChild($PartyName);		
			
					//cbc:ID
					$Name = $domtree->createElement("cbc:Name",$InsGuiaRemision->PrvNombre);
					$Name = $PartyName->appendChild($Name);
		}
		
		if(!empty($InsGuiaRemision->GrePlaca)){

			//cac:TransportMeans
			$TransportMeans = $domtree->createElement("cac:TransportMeans");
			$TransportMeans = $ShipmentStage->appendChild($TransportMeans);		
						
				//cac:TransportMeans
				$RoadTransport = $domtree->createElement("cac:RoadTransport");
				$RoadTransport = $TransportMeans->appendChild($RoadTransport);	
		
					//cbc:LicensePlateID
					$LicensePlateID = $domtree->createElement("cbc:LicensePlateID",$InsGuiaRemision->GrePlaca);
					$LicensePlateID = $RoadTransport->appendChild($LicensePlateID);	

		}

/*		if(!empty($InsGuiaRemision->GreChoferNumeroDocumento)){
	
			//cac:DriverPerson
			$DriverPerson = $domtree->createElement("cac:DriverPerson");
			$DriverPerson = $ShipmentStage->appendChild($DriverPerson);	
				
				//cbc:ID
				$ID = $domtree->createElement("cbc:ID",$InsGuiaRemision->GreChoferNumeroDocumento);//DNI Conductor
				$ID->setAttribute('schemeID', "1");
				$ID = $DriverPerson->appendChild($ID);

		}*/
	
	//cac:Delivery
	$Delivery = $domtree->createElement("cac:Delivery");
	$Delivery = $Shipment->appendChild($Delivery);	

	//$Delivery = $Shipment;
		//cac:DeliveryAddress
		$DeliveryAddress = $domtree->createElement("cac:DeliveryAddress");
		$DeliveryAddress = $Delivery->appendChild($DeliveryAddress);	
		
			//cbc:ID
			$ID = $domtree->createElement("cbc:ID",$InsGuiaRemision->GrePuntoLlegadaCodigoUbigeo);//BUSCAR UBIGEEO
			$ID = $DeliveryAddress->appendChild($ID);		
	
			//cbc:StreetName
			$StreetName = $domtree->createElement("cbc:StreetName",$InsGuiaRemision->GrePuntoLlegada);
			$StreetName = $DeliveryAddress->appendChild($StreetName);	



	//if(!empty($InsGuiaRemision->GrePlaca)){
//		
//		//cac:TransportHandlingUnit
//		$TransportHandlingUnit = $domtree->createElement("cac:TransportHandlingUnit");
//		$TransportHandlingUnit = $Shipment->appendChild($TransportHandlingUnit);	
//			
//			$TransportEquipment = $domtree->createElement("cac:TransportEquipment");
//			$TransportEquipment = $TransportHandlingUnit->appendChild($TransportEquipment);	
//			
//				$ID = $domtree->createElement("cbc:ID",$InsGuiaRemision->GrePlaca);
//				$ID  = $TransportEquipment->appendChild($ID);	
//					
//	}


//	if(!empty($InsGuiaRemision->GrePlaca)){
//		
//		//cac:TransportHandlingUnit
//		$TransportHandlingUnit = $domtree->createElement("cac:TransportHandlingUnit");
//		$TransportHandlingUnit = $Shipment->appendChild($TransportHandlingUnit);	
//		
//			//cac:TransportHandlingUnit
//			$TransportEquipment = $domtree->createElement("cac:TransportEquipment");
//			$TransportEquipment = $TransportHandlingUnit->appendChild($TransportEquipment);	
//		
//				$ID = $domtree->createElement("cbc:ID",$InsGuiaRemision->GrePlaca);
//				$ID  = $TransportEquipment->appendChild($ID);	
//					
//	}
//	
	
	//cac:OriginAddress
	$OriginAddress = $domtree->createElement("cac:OriginAddress");
	$OriginAddress = $Shipment->appendChild($OriginAddress);		
	
		//cbc:ID
		$ID = $domtree->createElement("cbc:ID",$InsGuiaRemision->GrePuntoPartidaCodigoUbigeo);//BUSCAR CODIGO UBIGEO
		$ID = $OriginAddress->appendChild($ID);		
	
		//cbc:StreetName
		$StreetName = $domtree->createElement("cbc:StreetName",$InsGuiaRemision->GrePuntoPartida);
		$StreetName = $OriginAddress->appendChild($StreetName);	
		

		
		
		$fila = 1;
		if(!empty($InsGuiaRemision->GuiaRemisionDetalle)){
			foreach($InsGuiaRemision->GuiaRemisionDetalle as $DatGuiaRemisionDetalle){
				
				//cac:DespatchLine
				$DespatchLine = $domtree->createElement("cac:DespatchLine");
				$DespatchLine = $xmlRoot->appendChild($DespatchLine);	
					
					//cbc:ID
					$ID = $domtree->createElement("cbc:ID",$fila);
					$ID = $DespatchLine->appendChild($ID);	
					
					//cbc:DespatchAdvicedQuantity unitCode="NIU"
					$DeliveredQuantity = $domtree->createElement("cbc:DeliveredQuantity",number_format($DatGuiaRemisionDetalle->GrdCantidad,2, '.', ''));
					$DeliveredQuantity->setAttribute('unitCode', 'NIU');
					$DeliveredQuantity = $DespatchLine->appendChild($DeliveredQuantity);	
					
					
					//cac:OrderLineReference
					$OrderLineReference = $domtree->createElement("cac:OrderLineReference");
					$OrderLineReference = $DespatchLine->appendChild($OrderLineReference);		
					
						//cbc:ID
						$LineID = $domtree->createElement("cbc:LineID","1");
						$LineID = $OrderLineReference->appendChild($LineID);		
					
					
					
					//cac:Item
					$Item = $domtree->createElement("cac:Item");
					$Item = $DespatchLine->appendChild($Item);	
		
						//	//cbc:Description
//							$Description = $domtree->createElement("cbc:Description");
//							$Description = $Item->appendChild($Description);
//							$Description->appendChild($domtree->createCDATASection($DatGuiaRemisionDetalle->GrdDescripcion )); 
		
								$Name = $domtree->createElement("cbc:Name",$DatGuiaRemisionDetalle->GrdDescripcion);
								$Name = $Item->appendChild($Name);
//		
							//cac:SellersItemIdentification		
							$SellersItemIdentification = $domtree->createElement("cac:SellersItemIdentification");
							$SellersItemIdentification = $Item->appendChild($SellersItemIdentification);
		
								//$ID = $domtree->createElement("cbc:ID");
//								$ID = $SellersItemIdentification->appendChild($ID);
//								$ID->appendChild($domtree->createCDATASection($DatGuiaRemisionDetalle->GrdCodigo )); 

								$ID = $domtree->createElement("cbc:ID",$DatGuiaRemisionDetalle->GrdCodigo);
								$ID = $SellersItemIdentification->appendChild($ID);
						
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