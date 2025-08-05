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

$GET_Seleccionados = $_GET['Seleccionados'];

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaTalonario.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsRegimen.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsResumenDiario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsResumenBaja.php');


$InsBoletaTalonario = new ClsBoletaTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsRegimen = new ClsRegimen();

$ArrBoletas = explode("@",$GET_Seleccionados);
$Boletas = eregi_replace("@",",",$GET_Seleccionados);

$Fecha = "";
$MonedaSigla = "";

if(!empty($ArrBoletas)){
	foreach($ArrBoletas as $DatBoleta){		
		if(!empty($DatBoleta)){
			
			list($Id,$Ta) = explode("%",$DatBoleta);
			
			$InsBoleta = new ClsBoleta();
			$InsBoleta->BolId = $Id;
			$InsBoleta->BtaId = $Ta;
			$InsBoleta->MtdObtenerBoleta(false);
			
			$Fecha = $InsBoleta->BolFechaEmision;	
			$MonedaSigla = $InsBoleta->MonSigla;
			break;	
			
		}
	}
}

list($Ano,$Mes,$Dia) = explode("-",date("Y-m-d"));

$InsResumenDiario = new ClsResumenDiario();
$InsResumenDiario->RdiAno = $Ano;
$InsResumenDiario->RdiMes = $Mes;
$InsResumenDiario->RdiDia = $Dia;
$InsResumenDiario->RdiFecha = date("Y-m-d");
$InsResumenDiario->RdiFechaReferencia = FncCambiaFechaAMysql($Fecha);
$InsResumenDiario->RdiLineas = count($ArrBoletas);
$InsResumenDiario->RdiEstado = 1;
$InsResumenDiario->RdiTiempoCreacion = date("Y-m-d H:i:s");
$InsResumenDiario->RdiTiempoModificacion = date("Y-m-d H:i:s");

$ResumenNumeracion = $InsResumenDiario->MtdGenerarResumenDiarioNumeracion();

$InsResumenDiario->RdiNumeracion = $ResumenNumeracion;

//deb($InsResumenDiario->RdiNumeracion);

if($InsResumenDiario->MtdRegistrarResumenDiario()){
	
	$ResumenDiarioId = $InsResumenDiario->RdiId;
	
}else{
		
}

//echo "aaaaaaaaa".$ResumenDiarioId;
//$InsResumenDiario = new ClsResumenDiario();
//RC-20120624-001
//$NOMBRE = $EmpresaCodigo."-".$InsResumenDiario->RdiId;
//$ARCHIVO = $NOMBRE.".xml";
//$NOMBRE_INTERNO = $InsResumenDiario->RdiId;
$NOMBRE = $EmpresaCodigo."-RC-".date("Ymd")."-".$ResumenNumeracion;
$ARCHIVO = $NOMBRE.".xml";
$NOMBRE_INTERNO = "RC-".date("Ymd")."-".$ResumenNumeracion;

if(!empty($ArrBoletas)){
	foreach($ArrBoletas as $DatBoleta){		
		if(!empty($DatBoleta)){
			
			list($Id,$Ta) = explode("%",$DatBoleta);
			
			$InsBoleta->MtdEditarBoletaDato("RdiId",$ResumenDiarioId,$Id,$Ta);

		}
	}
}

//exit();

$domtree = new DOMDocument('1.0', 'ISO-8859-1');
//$domtree->preserveWhiteSpace = false;
$domtree->formatOutput = true;
$domtree->xmlStandalone = false;

/* create the root element of the xml tree */
$xmlRoot = $domtree->createElement("SummaryDocuments");
/* append it to the document created */
$xmlRoot = $domtree->appendChild($xmlRoot);

$xmlRoot->setAttribute('xmlns', 'urn:sunat:names:specification:ubl:peru:schema:xsd:SummaryDocuments-1');
$xmlRoot->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
$xmlRoot->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
$xmlRoot->setAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
$xmlRoot->setAttribute('xmlns:ext', 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2');
$xmlRoot->setAttribute('xmlns:sac', 'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1');
$xmlRoot->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

//ext:UBLExtensions
$UBLExtensions = $domtree->createElement("ext:UBLExtensions");
$UBLExtensions = $xmlRoot->appendChild($UBLExtensions);

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
$ID = $domtree->createElement("cbc:ID",$NOMBRE_INTERNO);
$ID = $xmlRoot->appendChild($ID);

//cbc:ReferenceDate
$ReferenceDate = $domtree->createElement("cbc:ReferenceDate",FncCambiaFechaAMysql($Fecha));//REVISAR
$ReferenceDate = $xmlRoot->appendChild($ReferenceDate);

//cbc:IssueDate
$IssueDate = $domtree->createElement("cbc:IssueDate",date("Y-m-d"));
$IssueDate = $xmlRoot->appendChild($IssueDate);

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
			$base = $SignatoryParty->appendChild($domtree->createElement('cac:PartyName'));
			
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
		$base = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));

		//cac:Name		
		$name = $base->appendChild($domtree->createElement('cbc:RegistrationName')); 
		$name->appendChild($domtree->createCDATASection( $EmpresaNombre)); 


		$ResBoletaTalonario = $InsBoletaTalonario->MtdObtenerBoletaTalonarios(NULL,NULL,"BtaNumero","DESC",NULL,$_SESSION['SesionSucursal']);
		$ArrBoletaTalonarios = $ResBoletaTalonario['Datos'];
		
	
		$i = 1;
		if(!empty($ArrBoletaTalonarios)){
			foreach($ArrBoletaTalonarios as $DatBoletaTalonario){
				
				$TotalImpuesto = 0;
				$TotalGravado = 0;
				$TotalExonerado = 0;
				$Total = 0;
				$TotalDescuento = 0;
				$TotalRegistros = 0;
				
				//deb($DatBoletaTalonario->BtaId);
				//echo "aaaaaaaaaaa";
				//echo "<br>";
				//echo $ResumenDiarioId;
				//MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL,$oVendedor=NULL){
				$TotalRegistros = $InsBoleta->MtdObtenerBoletasValor("COUNT","BolId",NULL,NULL,"RdiId","esigual",$ResumenDiarioId,'BolId','ASC','1',$_SESSION['SesionSucursal'],NULL,NULL,NULL,$DatBoletaTalonario->BtaId,NULL,NULL,NULL,NULL);
				//echo "<br>";
				//echo "bbbbbbbbb";
				//deb($TotalRegistros);
				
				//exit();
				if($TotalRegistros>0){

					//MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL,$oVendedor=NULL) {
					$Maximo = $InsBoleta->MtdObtenerBoletasValor("MAX","BolId",NULL,NULL,"RdiId","esigual",$ResumenDiarioId,'BolId','DESC','1',$_SESSION['SesionSucursal'],NULL,NULL,NULL,$DatBoletaTalonario->BtaId,NULL,NULL,NULL,NULL);
					$Minimo = $InsBoleta->MtdObtenerBoletasValor("MIN","BolId",NULL,NULL,"RdiId","esigual",$ResumenDiarioId,'BolId','ASC','1',$_SESSION['SesionSucursal'],NULL,NULL,NULL,$DatBoletaTalonario->BtaId,NULL,NULL,NULL,NULL);
					
					$TotalImpuesto = $InsBoleta->MtdObtenerBoletasValor("SUM","BolImpuesto",NULL,NULL,"RdiId","esigual",$ResumenDiarioId,'BolId','ASC','1',$_SESSION['SesionSucursal'],NULL,NULL,NULL,$DatBoletaTalonario->BtaId,NULL,NULL,NULL,NULL);
					$TotalGravado = $InsBoleta->MtdObtenerBoletasValor("SUM","BolTotalGravado",NULL,NULL,"RdiId","esigual",$ResumenDiarioId,'BolId','ASC','1',$_SESSION['SesionSucursal'],NULL,NULL,NULL,$DatBoletaTalonario->BtaId,NULL,NULL,NULL,NULL);
					$TotalExonerado = $InsBoleta->MtdObtenerBoletasValor("SUM","BolTotalExonerado",NULL,NULL,"RdiId","esigual",$ResumenDiarioId,'BolId','ASC','1',$_SESSION['SesionSucursal'],NULL,NULL,NULL,$DatBoletaTalonario->BtaId,NULL,NULL,NULL,NULL);
					$Total = $InsBoleta->MtdObtenerBoletasValor("SUM","BolTotal",NULL,NULL,"RdiId","esigual",$ResumenDiarioId,'BolId','ASC','1',$_SESSION['SesionSucursal'],NULL,NULL,NULL,$DatBoletaTalonario->BtaId,NULL,NULL,NULL,NULL);
					$TotalDescuento = $InsBoleta->MtdObtenerBoletasValor("SUM","BolTotalDescuento",NULL,NULL,"RdiId","esigual",$ResumenDiarioId,'BolId','ASC','1',$_SESSION['SesionSucursal'],NULL,NULL,NULL,$DatBoletaTalonario->BtaId,NULL,NULL,NULL,NULL);
					$TotalImpuestoSelectivo = $InsBoleta->MtdObtenerBoletasValor("SUM","BolTotalImpuestoSelectivo",NULL,NULL,"RdiId","esigual",$ResumenDiarioId,'BolId','ASC','1',$_SESSION['SesionSucursal'],NULL,NULL,NULL,$DatBoletaTalonario->BtaId,NULL,NULL,NULL,NULL);
					
					//cac:SummaryDocumentsLine
					$SummaryDocumentsLine = $domtree->createElement("sac:SummaryDocumentsLine");
					$SummaryDocumentsLine = $xmlRoot->appendChild($SummaryDocumentsLine);	

					//cbc:ID
					$LineID = $domtree->createElement("cbc:LineID",$i);
					$LineID = $SummaryDocumentsLine->appendChild($LineID);	

					//cbc:DocumentTypeCode
					$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode","03");
					$DocumentTypeCode = $SummaryDocumentsLine->appendChild($DocumentTypeCode);	

					//sac:DocumentSerialID
					$DocumentSerialID = $domtree->createElement("sac:DocumentSerialID",$DatBoletaTalonario->BtaNumero);
					$DocumentSerialID = $SummaryDocumentsLine->appendChild($DocumentSerialID);	

					//sac:StartDocumentNumberID
					$StartDocumentNumberID = $domtree->createElement("sac:StartDocumentNumberID",$Minimo);
					$StartDocumentNumberID = $SummaryDocumentsLine->appendChild($StartDocumentNumberID);	

					//sac:EndDocumentNumberID
					$EndDocumentNumberID = $domtree->createElement("sac:EndDocumentNumberID",$Maximo);
					$EndDocumentNumberID = $SummaryDocumentsLine->appendChild($EndDocumentNumberID);	

					//sac:TotalAmount currencyID="PEN"
					$TotalAmount = $domtree->createElement("sac:TotalAmount",number_format($Total,2, '.', ''));
					$TotalAmount->setAttribute('currencyID', $MonedaSigla);
					$TotalAmount = $SummaryDocumentsLine->appendChild($TotalAmount);

					//sac:BillingPayment
					$BillingPayment = $domtree->createElement("sac:BillingPayment");
					$BillingPayment = $SummaryDocumentsLine->appendChild($BillingPayment);	
						
						//sac:TotalAmount currencyID="PEN"
						$PaidAmount = $domtree->createElement("cbc:PaidAmount",number_format($TotalGravado,2, '.', ''));
						$PaidAmount->setAttribute('currencyID', $MonedaSigla);
						$PaidAmount = $BillingPayment->appendChild($PaidAmount);
						
						//cbc:InstructionID
						$InstructionID = $domtree->createElement("cbc:InstructionID","01");//VALOR VENTA - GRAVADAS
						$InstructionID = $BillingPayment->appendChild($InstructionID);	
						
						
						
					//sac:BillingPayment
					$BillingPayment = $domtree->createElement("sac:BillingPayment");
					$BillingPayment = $SummaryDocumentsLine->appendChild($BillingPayment);	
						
						//sac:TotalAmount currencyID="PEN"
						$PaidAmount = $domtree->createElement("cbc:PaidAmount",number_format($TotalExonerado,2, '.', ''));
						$PaidAmount->setAttribute('currencyID', $MonedaSigla);
						$PaidAmount = $BillingPayment->appendChild($PaidAmount);
						
						//cbc:InstructionID
						$InstructionID = $domtree->createElement("cbc:InstructionID","02");//VALOR VENTA - EXONERADAS
						$InstructionID = $BillingPayment->appendChild($InstructionID);	
						
				
				
					//sac:BillingPayment
					$BillingPayment = $domtree->createElement("sac:BillingPayment");
					$BillingPayment = $SummaryDocumentsLine->appendChild($BillingPayment);	
						
						//sac:TotalAmount currencyID="PEN"
						$PaidAmount = $domtree->createElement("cbc:PaidAmount",number_format(0,2, '.', ''));
						$PaidAmount->setAttribute('currencyID', $MonedaSigla);
						$PaidAmount = $BillingPayment->appendChild($PaidAmount);
						
						//cbc:InstructionID
						$InstructionID = $domtree->createElement("cbc:InstructionID","03");//VALOR VENTA - INAFECTAS
						$InstructionID = $BillingPayment->appendChild($InstructionID);		

					//if($TotalDescuento>0){
//						
//						//cac:AllowanceCharge
//						$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
//						$AllowanceCharge = $SummaryDocumentsLine->appendChild($AllowanceCharge);	
//							
//							//cbc:InstructionID
//							$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","false");
//							$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);	
//							
//							//sac:TotalAmount currencyID="PEN"
//							$Amount = $domtree->createElement("cbc:Amount",number_format($TotalDescuento,2, '.', ''));
//							$Amount->setAttribute('currencyID', $MonedaSigla);
//							$Amount = $AllowanceCharge->appendChild($Amount);	
//							
//					}else{
						
						//cac:AllowanceCharge
						$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
						$AllowanceCharge = $SummaryDocumentsLine->appendChild($AllowanceCharge);	
							
							//cbc:InstructionID
							$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","true");
							$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);	
							
							//sac:TotalAmount currencyID="PEN"
							$Amount = $domtree->createElement("cbc:Amount",number_format(0,2, '.', ''));
							$Amount->setAttribute('currencyID', $MonedaSigla);
							$Amount = $AllowanceCharge->appendChild($Amount);	
							
					//}
					
					
						//cac:TaxTotal
					$TaxTotal = $domtree->createElement("cac:TaxTotal");
					$TaxTotal = $SummaryDocumentsLine->appendChild($TaxTotal);	
					
						//sac:TotalAmount currencyID="PEN"
						$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($TotalImpuestoSelectivo,2, '.', ''));
						$TaxAmount->setAttribute('currencyID', $MonedaSigla);
						$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
							
							//cac:TaxSubtotal
							$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
							$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
							
								//sac:TotalAmount currencyID="PEN"
								$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($TotalImpuestoSelectivo,2, '.', ''));
								$TaxAmount->setAttribute('currencyID', $MonedaSigla);
								$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);		
								
								//cac:TaxCategory
								$TaxCategory = $domtree->createElement("cac:TaxCategory");
								$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
									
									//cac:TaxCategory
									$TaxScheme = $domtree->createElement("cac:TaxScheme");
									$TaxScheme = $TaxCategory->appendChild($TaxScheme);
									
										//cbc:TaxCategory
										$ID = $domtree->createElement("cbc:ID","2000");
										$ID = $TaxScheme->appendChild($ID);
										
										//cbc:Name
										$Name = $domtree->createElement("cbc:Name","ISC");
										$Name = $TaxScheme->appendChild($Name);
										
										//cbc:TaxTypeCode
										$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","EXC");
										$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
										
										
					//cac:TaxTotal
					$TaxTotal = $domtree->createElement("cac:TaxTotal");
					$TaxTotal = $SummaryDocumentsLine->appendChild($TaxTotal);	
					
						//sac:TotalAmount currencyID="PEN"
						$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($TotalImpuesto,2, '.', ''));
						$TaxAmount->setAttribute('currencyID', $MonedaSigla);
						$TaxAmount = $TaxTotal->appendChild($TaxAmount);	
							
							//cac:TaxSubtotal
							$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
							$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
							
								//sac:TotalAmount currencyID="PEN"
								$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($TotalImpuesto,2, '.', ''));
								$TaxAmount->setAttribute('currencyID', $MonedaSigla);
								$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);		
								
								//cac:TaxCategory
								$TaxCategory = $domtree->createElement("cac:TaxCategory");
								$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
									
									//cac:TaxCategory
									$TaxScheme = $domtree->createElement("cac:TaxScheme");
									$TaxScheme = $TaxCategory->appendChild($TaxScheme);
									
										//cbc:TaxCategory
										$ID = $domtree->createElement("cbc:ID","1000");
										$ID = $TaxScheme->appendChild($ID);
										
										//cbc:Name
										$Name = $domtree->createElement("cbc:Name","IGV");
										$Name = $TaxScheme->appendChild($Name);
										
										//cbc:TaxTypeCode
										$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","VAT");
										$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
										
										
				
					$i++;
				}
					
			}
		}


if(file_exists('../../../generados/comprobantes_xml/'.$ARCHIVO)){
	unlink('../../../generados/comprobantes_xml/'.$ARCHIVO);
}

$domtree->save('../../../generados/comprobantes_xml/'.$ARCHIVO,LIBXML_NOEMPTYTAG );

//if(!empty($ArrBoletas)){
//	foreach($ArrBoletas as $DatBoleta){		
//		if(!empty($DatBoleta)){
//			
//			list($Id,$Ta) = explode("%",$DatBoleta);
//			$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaBajaId",$InsBoleta->BolSunatRespuestaBajaId,$Id,$Ta);
//	
//		}
//	}
//}

$respuesta['CodigoRespuesta'] = "1";
$respuesta['Nombre'] = $NOMBRE;
$respuesta['Id'] = $ResumenDiarioId;

echo json_encode($respuesta);

?>