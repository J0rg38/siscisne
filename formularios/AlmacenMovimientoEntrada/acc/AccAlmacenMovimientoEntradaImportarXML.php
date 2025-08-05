<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta= '../../../';
$InsProyecto->Ruta= '../../../';

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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');
?>

<!--
Libreria leer excel
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/OLERead.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/reader.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'simplexlsx.class.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'JSON.php'); ?>
<?php require_once($InsProyecto->MtdRutLibrerias().'JSON2.php'); ?>

<?php

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenCierre.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');

$InsSucursal = new ClsSucursal();
//MtdObtenerSucursales($oCampo=NULL,$oFiltro=NULL,$oOrden = 'SucId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"INICIAL");
$ArrSucursales = $RepSucursal['Datos'];

$SucursalId = "";

if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
		$SucursalId = $DatSucursal->SucId;
	}
}



?>
	<form method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td align="left" valign="top">

	<input type="file" id="CmpArchivo" name="CmpArchivo" />
	<input name="BtnEnviar" id="BtnEnviar" type="submit" value="Importar Archivo XML" />

  
  </td>
</tr>
<tr>
	<td align="left" valign="top">


</td>
  </tr>
<tr>
  <td align="left" valign="top">
    <?php
if (!empty($_FILES)) {
	
	$tempFile = $_FILES['CmpArchivo']['tmp_name'];
	$file_name = strtolower($_FILES['CmpArchivo']['name']);	
	$targetPath = '../../../subidos/almacen_movimiento_entrada_xmls/';
	$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_XML_'.($file_name);	
	
?>

	Nombre de Archivo: <?php echo $file_name;?><br />

<?php
	if (move_uploaded_file($tempFile,$targetFile)){
		
		$path = $targetFile;
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		
			switch($ext){
				
				case "xml":
						
					echo "Leyendo archivo xml...";
					echo "<br>";
					
					//$archivo = file_get_contents($targetFile);
//					$archivo = utf8_decode($archivo);
					
					
//					$xml = file_get_contents($targetFile);
//
//deb($xml);
//
//					///$DOM = new DOMDocument('1.0', 'utf-8');
//					$DOM = new DOMDocument('1.0');
//					$DOM->loadXML($xml);
//					
//					
//					$usuarios = $DOM->getElementsByTagName('AccountingSupplierParty');
//					
//					
//					 deb($DOM);

					$data = file_get_contents($targetFile);
					
					//$data = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $data);
					
					$data = eregi_replace("[\n|\r|\n\r]", ' ', $data);
					
//					$items = simplexml_load_string($data);
//					
//					
//					deb($items);
//					
					
					//$factura = simplexml_load_string($data);
//$namespaces = $factura -> getNamespaces(true);
//
//deb($factura);
					
					$Fecha = "";
					$Id = "";
					$Moneda = "";
					
					$dom = new DOMDocument();
					$dom->loadXML($data);
					
					
					$IssueDate = $dom->getElementsByTagName('IssueDate');
					
					if ($IssueDate->length > 0) {
						$Fecha = ( $IssueDate->item(0)->nodeValue );
					}
					
					
					$it = 0;					
					while(substr($Id,0,1) != "F" and substr($Id,0,1) != "B"){
						
						$ID = $dom->getElementsByTagName('ID');
					
						if ($ID->length > 0) {
							$Id = ( $ID->item($it)->nodeValue );
						}
						
						$it++;
						
					}
					
					//deb($Id);
					//exit();
					
					$InvoiceTypeCode = $dom->getElementsByTagName('InvoiceTypeCode');
					
					if ($InvoiceTypeCode->length > 0) {
						$TipoDocumento = ( $InvoiceTypeCode->item(0)->nodeValue );
					}
					
					$DocumentCurrencyCode = $dom->getElementsByTagName('DocumentCurrencyCode');
					
					if ($DocumentCurrencyCode->length > 0) {
						$Moneda = ( $DocumentCurrencyCode->item(0)->nodeValue );
					}
					
					
					
					$AccountingSupplierParty = $dom->getElementsByTagName('AccountingSupplierParty');
					
					if ($AccountingSupplierParty->length > 0) {
						
						//$Proveedor = ( $proveedor_items->item(0)->nodeValue );
						
						//$ProveedorNumeroDocumento = $AccountingSupplierParty->item(0)->getElementsByTagName('CustomerAssignedAccountID')->item(0)->nodeValue;
						$ProveedorNumeroDocumento = $AccountingSupplierParty->item(0)->getElementsByTagName('PartyIdentification')->item(0)->nodeValue;
						
						$ProveedorTipoDocumento = $AccountingSupplierParty->item(0)->getElementsByTagName('AdditionalAccountID')->item(0)->nodeValue;
					
						$Party = $AccountingSupplierParty->item(0)->getElementsByTagName('Party')->item(0);
						$PartyName = $Party->getElementsByTagName('PartyName')->item(0);
						$Proveedor = $PartyName->getElementsByTagName('Name')->item(0)->nodeValue;
						
						//$PostalAddress = $Party->getElementsByTagName('PostalAddress')->item(0);
						//$ProveedorDireccion = $PostalAddress->getElementsByTagName('StreetName')->item(0)->nodeValue;
						
					//	deb($ProveedorNumeroDocumento);
					//	deb($ProveedorTipoDocumento);
					//	deb($Proveedor);
					//	deb($ProveedorDireccion);
					
					}
					
					//$cliente_items = $dom->getElementsByTagName('AccountingCustomerParty');
					//
					//if ($cliente_items->length > 0) {
					//	$Cliente = ( $cliente_items->item(0)->nodeValue );
					//	
					//	deb($Cliente);
					//}
					
					
					$TaxTotal = $dom->getElementsByTagName('TaxTotal');
					
					if ($TaxTotal->length > 0) {
						
						$FacturaImpuesto = $TaxTotal->item(0)->getElementsByTagName('TaxAmount')->item(0)->nodeValue;
						
					}
					
					
					$LegalMonetaryTotal = $dom->getElementsByTagName('LegalMonetaryTotal');
					
					if ($LegalMonetaryTotal->length > 0) {
						
						$FacturaTotal = $LegalMonetaryTotal->item(0)->getElementsByTagName('PayableAmount')->item(0)->nodeValue;
						
					}
					
					
					
					//$ArrItems = array();
					
					
					
					
					
					echo "<br>";
					echo "<br>";
					
					echo "Fecha de Comprobante: ".FncCambiaFechaANormal($Fecha);
					echo "<br>";
					
					echo "Numero de Comprobante: ".$Id;
					echo "<br>";
					
						
					echo "Impuesto de Comprobante: ".$FacturaImpuesto;
					echo "<br>";
					
					echo "Total de Comprobante: ".$FacturaTotal;
					echo "<br>";
					
					echo "Tipo de Documento: ".$TipoDocumento;
					echo "<br>";
					
					echo "Moneda: ".$Moneda;
					echo "<br>";
					
					echo "Num. Doc. de Proveedor: ".$ProveedorNumeroDocumento;
					echo "<br>";
					
					echo "Tipo Doc. de Proveedor: ".$ProveedorTipoDocumento;
					echo "<br>";
					
					echo "Direccion de Proveedor: ".$ProveedorDireccion;
					echo "<br>";
					
					echo "Nombre de Proveedor: ".$Proveedor;
					echo "<br>";
					
					
					echo "<br>";					
					echo "Items identificados";
					echo "<br>";
					echo "<br>";
					
					$InvoiceLine = $dom->getElementsByTagName('InvoiceLine');
					
					if ($InvoiceLine->length > 0) {
						
						$Cantidad = 0;
						$ValorTotal = 0;
						$PrecioUnitario = 0;
						$Codigo = "";
						
						foreach( $InvoiceLine as $DatInvoiceLine){
							
								$Cantidad = $DatInvoiceLine->getElementsByTagName('InvoicedQuantity')->item(0)->nodeValue;
								$ValorTotal = $DatInvoiceLine->getElementsByTagName('LineExtensionAmount')->item(0)->nodeValue;
								
								$PricingReference = $DatInvoiceLine->getElementsByTagName('PricingReference')->item(0);
								$PrecioUnitario = $PricingReference->getElementsByTagName('PriceAmount')->item(0)->nodeValue;
								
								$Item = $DatInvoiceLine->getElementsByTagName('Item')->item(0);
								$SellersItemIdentification = $Item->getElementsByTagName('SellersItemIdentification')->item(0);
								$Codigo = $Item->getElementsByTagName('ID')->item(0)->nodeValue;
								$Codigo = $Codigo + 1 - 1;
								
								$Importe = $Cantidad * $PrecioUnitario;
								
								echo "Codigo: ".$Codigo;
								echo "<br>";
								
								echo "Cantidad: ".$Cantidad;
								echo "<br>";
								
								echo "Valor Total: ".$ValorTotal;
								echo "<br>";
								
								echo "Precio Unitario: ".$PrecioUnitario;
								echo "<br>";
								
								echo "Importe Total: ".$Importe;
								echo "<br>";
								
								echo "<br>";
								
						}
						
					}














			
					/*
					*
					*/
						
					$GuardarArchivo = true;
				
					$InsAlmacen = new ClsAlmacen();
					$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$InsTallerPedido->SucId);
					$ArrAlmacenes = $RepAlmacen['Datos'];
					
					$AlmacenId = "";
					
					if(!empty($ArrAlmacenes)){
						foreach($ArrAlmacenes as $DatAlmacen){
							$AlmacenId = $DatAlmacen->AlmId;						
						}
					}
					
					if(empty($AlmacenId)){
						
						$GuardarArchivo = false;
						echo "No se ha encontrado Almacen destino";	
						echo "<br>";
					}
					
					
					$InsProveedor = new ClsProveedor();
							//MtdObtenerProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PrvId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL)
					$ResProveedor = $InsProveedor->MtdObtenerProveedores("PrvNumeroDocumento","esigual",$ProveedorNumeroDocumento,"PrvNumeroDocumento","DESC","1",$POST_est);
					$ArrProveedores = $ResProveedor['Datos'];
					
					$ProveedorId = "";
					
					if(!empty($ArrProveedores)){
						foreach($ArrProveedores as $DatProveedor){
							$ProveedorId = $DatProveedor->PrvId;
						}
					}
					
					if(empty($ProveedorId)){
						
						$GuardarArchivo = false;
						echo "No se ha identificado al Proveedor, verifique que se encuentre registrado ";	
						echo "<br>";
						
					}
					
					$InsComprobanteTipo = new ClsComprobantetipo();
					//MtdObtenerComprobanteTipos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CtiId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oUso=NULL)
					$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos("CtiCodigo",$TipoDocumento,'CtiCodigo','DESC',1,'1',NULL);
					$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];
					
					$ComprobanteTipoId = "";
					
					if(!empty($ArrComprobanteTipos)){
						foreach($ArrComprobanteTipos as $DatComprobanteTipo){
							$ComprobanteTipoId = $DatComprobanteTipo->CtiId;
						}
					}
			
					if(empty($ComprobanteTipoId)){
						
						$GuardarArchivo = false;
						echo "No se ha identificado el tipo de documento, verifique que se encuentre registrado ";	
						echo "<br>";
						
					}
					
					
					$InsMoneda = new ClsMoneda();
					//MtdObtenerMonedas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'MonId',$oSentido = 'Desc',$oPaginacion = '0,10')
					$ResMoneda = $InsMoneda->MtdObtenerMonedas("MonSigla","esigual",$Moneda,'MonId','DESC','1');
					$ArrMonedas = $ResMoneda['Datos'];
					
					$MonedaId = "";
					
					if(!empty($ArrMonedas)){
						foreach($ArrMonedas as $DatMoneda){
							$MonedaId = $DatMoneda->MonId;
						}
					}
			
			
					if(empty($MonedaId)){
						
						$GuardarArchivo = false;
						echo "No se ha identificado la moneda, verifique que se encuentre registrado ";	
						echo "<br>";
						
					}
					
					
					$TipoCambio = NULL;
					
					if($MonedaId <> $EmpresaMonedaId){
						
						$InsTipoCambio = new ClsTipoCambio();
						$InsTipoCambio->MonId = $MonedaId;
						$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($Fecha,true);
						
						$InsTipoCambio->MtdObtenerTipoCambioActual();
						
						if(empty($InsTipoCambio->TcaId)){
							
							$InsTipoCambio->MtdObtenerTipoCambioUltimo();
							//if(empty($InsTipoCambio->TcaId)){
							//}
							//unset($InsTipoCambio);	
						}
						
						$TipoCambio = $InsTipoCambio->TcaMontoVenta;
						
						if(empty($TipoCambio)){
						
							$GuardarArchivo = false;
							echo "No se ha ha podido identificar el tipo de cambio, verifique que se encuentre registrado ";	
							echo "<br>";
							
						}
						
					}
					
			
				$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
				$InsAlmacenMovimientoEntrada->UsuId = $_SESSION['SesionId'];	
			
				$InsAlmacenMovimientoEntrada->AmoId = NULL;
				$InsAlmacenMovimientoEntrada->SucId = $_SESSION['SesionSucursal'];
			
				$InsAlmacenMovimientoEntrada->PrvId = $ProveedorId;
				$InsAlmacenMovimientoEntrada->CtiId = $ComprobanteTipoId;	
				$InsAlmacenMovimientoEntrada->OcoId = NULL;	
				$InsAlmacenMovimientoEntrada->AlmId = $AlmacenId;	
				$InsAlmacenMovimientoEntrada->TopId =  "TOP-10001";	
				
				
			//	$InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
				$InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
				$InsAlmacenMovimientoEntrada->AmoFecha = date("Y-m-d");
				$InsAlmacenMovimientoEntrada->AmoObservacion = "Importado desde XML el ".date("d/m/Y H:i:s");;
				$InsAlmacenMovimientoEntrada->AmoDocumentoOrigen = 1;//Nacinal
				
				$InsAlmacenMovimientoEntrada->AmoComprobanteNumero = $Id;
				$InsAlmacenMovimientoEntrada->AmoComprobanteFecha = ($Fecha);	
				$InsAlmacenMovimientoEntrada->AmoGuiaRemisionNumero = "";
				
				$InsAlmacenMovimientoEntrada->AmoGuiaRemisionFecha = NULL;
				$InsAlmacenMovimientoEntrada->AmoGuiaRemisionFoto = "";
			
				$InsAlmacenMovimientoEntrada->MonId = $MonedaId;
				$InsAlmacenMovimientoEntrada->AmoTipoCambio = $TipoCambio;
				$InsAlmacenMovimientoEntrada->AmoTipoCambioComercial = $TipoCambio;
				
				$InsAlmacenMovimientoEntrada->AmoValidarStock = 1;
				$InsAlmacenMovimientoEntrada->AmoIncluyeImpuesto = 2;
			
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduana = 0;
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalTransporte = 0;
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba = 0;
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje = 0;
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem = 0;
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional = 0;
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo = 0;
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1 = 0;
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2 = 0;
			
				$InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo = 0;
				$InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete = 0;
				$InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto = 0;
			
				
				$InsAlmacenMovimientoEntrada->AmoMargenUtilidad = 0.00;
				$InsAlmacenMovimientoEntrada->AmoTipo = 1;
				$InsAlmacenMovimientoEntrada->AmoSubTipo = 1;
			
				$InsAlmacenMovimientoEntrada->NpaId = "NPA-10001";
				$InsAlmacenMovimientoEntrada->AmoCantidadDia = 0;
				
				$InsAlmacenMovimientoEntrada->AmoEstado = 3;
				
				$InsAlmacenMovimientoEntrada->AmoTiempoCreacion = date("Y-m-d H:i:s");
				$InsAlmacenMovimientoEntrada->AmoTiempoModificacion = date("Y-m-d H:i:s");
				$InsAlmacenMovimientoEntrada->AmoEliminado = 1;
			
				
				$InsAlmacenMovimientoEntrada->AmoFoto = "";
				$InsAlmacenMovimientoEntrada->AmoNacionalFoto1 = "";
				$InsAlmacenMovimientoEntrada->AmoNacionalFoto2 = "";
				$InsAlmacenMovimientoEntrada->AmoNacionalFoto3 = "";
				
					
				$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante1 = "";
				$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante2 = "";
				$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante3 = "";
				$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante4 = "";
				$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante5 = "";
				$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante6 = "";
				$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante7 = "";
				$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante8 = "";
				$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante9 = "";
				
				$InsAlmacenMovimientoEntrada->AmoNacionalNumeroComprobante1 = "";
				$InsAlmacenMovimientoEntrada->AmoNacionalNumeroComprobante2 = "";
				$InsAlmacenMovimientoEntrada->AmoNacionalNumeroComprobante3 = "";
				
			
				$InsAlmacenMovimientoEntrada->MonIdInternacional1 = NULL;
				$InsAlmacenMovimientoEntrada->MonIdInternacional2 = NULL;
				$InsAlmacenMovimientoEntrada->MonIdInternacional3 = NULL;
				$InsAlmacenMovimientoEntrada->MonIdInternacional4 = NULL;
				$InsAlmacenMovimientoEntrada->MonIdInternacional5 = NULL;
				$InsAlmacenMovimientoEntrada->MonIdInternacional6 = NULL;
				$InsAlmacenMovimientoEntrada->MonIdInternacional7 = NULL;
				$InsAlmacenMovimientoEntrada->MonIdInternacional8 = NULL;
				$InsAlmacenMovimientoEntrada->MonIdInternacional9 = NULL;
				
				$InsAlmacenMovimientoEntrada->MonIdNacional1 = NULL;
				$InsAlmacenMovimientoEntrada->MonIdNacional2 = NULL;
				$InsAlmacenMovimientoEntrada->MonIdNacional3 =  NULL;
			
			
				$InsAlmacenMovimientoEntrada->PrvIdInternacional1 = NULL;
				$InsAlmacenMovimientoEntrada->PrvIdInternacional2 = NULL;
				$InsAlmacenMovimientoEntrada->PrvIdInternacional3 = NULL;
				$InsAlmacenMovimientoEntrada->PrvIdInternacional4 = NULL;
			
				$InsAlmacenMovimientoEntrada->PrvIdInternacional5 = NULL;
				$InsAlmacenMovimientoEntrada->PrvIdInternacional6 =NULL;
				$InsAlmacenMovimientoEntrada->PrvIdInternacional7 = NULL;
				$InsAlmacenMovimientoEntrada->PrvIdInternacional8 = NULL;
				$InsAlmacenMovimientoEntrada->PrvIdInternacional9 = NULL;
			
				$InsAlmacenMovimientoEntrada->PrvIdNacional1 = NULL;
				$InsAlmacenMovimientoEntrada->PrvIdNacional2 = NULL;
				$InsAlmacenMovimientoEntrada->PrvIdNacional3 =NULL;
								
				settype($InsAlmacenMovimientoEntrada->AmoTipoCambio,"float");
					
				$InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle = array();
	
			//	if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
			//		if(empty($InsAlmacenMovimientoEntrada->AmoTipoCambio)){
			//			$Guardar = false;
			//			$Resultado.='#ERR_AMO_600';
			//		}
			//	}
				
			//	if(empty($InsAlmacenMovimientoEntrada->AlmId)){
			//		$Guardar = false;
			//		$Resultado.='#ERR_AMO_602';
			//	}
				
				
				//if( $InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
//					$InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo = $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
//				}else{
//					$InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo = $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo;
//				}
//				
//				if( $InsAlmacenMovimientoEntrada->MonIdNacional2<>$EmpresaMonedaId ){
//					$InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete = $InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
//				}else{
//					$InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete = $InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete;
//				}
//				
//				if( $InsAlmacenMovimientoEntrada->MonIdNacional3<>$EmpresaMonedaId ){
//					$InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto = $InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
//				}else{
//					$InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto = $InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto;
//				}
		
				$InsAlmacenMovimientoEntrada->AmoTotalInternacional = $InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduana +
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalTransporte + $InsAlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba +
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje + $InsAlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem +
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional + $InsAlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo +
				$InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1 + $InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2;
				
				$InsAlmacenMovimientoEntrada->AmoTotalNacional = $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo + 
				$InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete + $InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto;
				
				
				$InsAlmacenMovimientoEntrada->AmoTotalBruto = 0;
				$InsAlmacenMovimientoEntrada->AmoSubTotal = 0;
				$InsAlmacenMovimientoEntrada->AmoImpuesto = 0;
				$InsAlmacenMovimientoEntrada->AmoTotal = 0;
				
				$InsAlmacenMovimientoEntrada->AmoValorTotal = 0;
	

	//$ResAlmacenMovimientoEntradaDetalle = $_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	
	
					$InvoiceLine = $dom->getElementsByTagName('InvoiceLine');
					
					if ($InvoiceLine->length > 0) {
						
						$Cantidad = 0;
						$ValorTotal = 0;
						$PrecioUnitario = 0;
						$Importe = 0;
						$Codigo = "";
						
						$SumaValorTotal = 0;	
						
						foreach( $InvoiceLine as $DatInvoiceLine){
							
								$Cantidad = $DatInvoiceLine->getElementsByTagName('InvoicedQuantity')->item(0)->nodeValue;
								$ValorTotal = $DatInvoiceLine->getElementsByTagName('LineExtensionAmount')->item(0)->nodeValue;
								
								$PricingReference = $DatInvoiceLine->getElementsByTagName('PricingReference')->item(0);
								$PrecioUnitario = $PricingReference->getElementsByTagName('PriceAmount')->item(0)->nodeValue;
								
								$Item = $DatInvoiceLine->getElementsByTagName('Item')->item(0);
								$SellersItemIdentification = $Item->getElementsByTagName('SellersItemIdentification')->item(0);
								$Codigo = $Item->getElementsByTagName('ID')->item(0)->nodeValue;
								$Codigo = $Codigo + 1 - 1;
								
								$Importe = $Cantidad * $PrecioUnitario;
								
								if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
									$SumaValorTotal += $ValorTotal * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
								}else{
									$SumaValorTotal += $ValorTotal;
								}
								
						}			
										
						if(empty($SumaValorTotal)){
							$SumaValorTotal = 1;
						}
				
						
						foreach( $InvoiceLine as $DatInvoiceLine){
							
							if(!empty($Codigo)){
								$Cantidad = $DatInvoiceLine->getElementsByTagName('InvoicedQuantity')->item(0)->nodeValue;
								$ValorTotal = $DatInvoiceLine->getElementsByTagName('LineExtensionAmount')->item(0)->nodeValue;
								
								$PricingReference = $DatInvoiceLine->getElementsByTagName('PricingReference')->item(0);
								$PrecioUnitario = $PricingReference->getElementsByTagName('PriceAmount')->item(0)->nodeValue;
								
								$Item = $DatInvoiceLine->getElementsByTagName('Item')->item(0);
								$SellersItemIdentification = $Item->getElementsByTagName('SellersItemIdentification')->item(0);
								$Codigo = $Item->getElementsByTagName('ID')->item(0)->nodeValue;
								$Codigo = $Codigo + 1 - 1;
								
								$Importe = $Cantidad * $PrecioUnitario;
								
								$InsProducto = new ClsProducto();
								$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$Codigo,"ProCodigoOriginal","DESC","1",NULL,NULL,NULL,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL,false,NULL,NULL);
								$ArrProductos = $ResProducto['Datos'];
								
								$ProductoId = "";
								$UnidadMedidaId = "";
								
								if(!empty($ArrProductos)){
									foreach($ArrProductos as $DatProducto){
										$ProductoId = $DatProducto->ProId;
										$UnidadMedidaId = $DatProducto->UmeIdIngreso;
									}
								}
								

								
								$InsAlmacenMovimientoEntradaDetalle1 = new ClsAlmacenMovimientoEntradaDetalle();
								$InsAlmacenMovimientoEntradaDetalle1->ProId = $ProductoId;
								$InsAlmacenMovimientoEntradaDetalle1->UmeId = $UnidadMedidaId;
					
								$InsAlmacenMovimientoEntradaDetalle1->AmdIdAnterior = $InsAlmacenMovimientoEntradaDetalle1->MtdObtenerUltimoAlmacenMovimientoEntradaDetalleId($InsAlmacenMovimientoEntradaDetalle1->ProId,$InsAlmacenMovimientoEntrada->AmoFecha);
									
								if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
									$InsAlmacenMovimientoEntradaDetalle1->AmdCosto = $PrecioUnitario * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
								}else{
									$InsAlmacenMovimientoEntradaDetalle1->AmdCosto = $PrecioUnitario;
								}
					
								$InsAlmacenMovimientoEntradaDetalle1->AmdCostoAnterior = 0;
								
								$InsAlmacenMovimientoEntradaDetalle1->AmdCantidad = $Cantidad;
								$InsAlmacenMovimientoEntradaDetalle1->AmdCantidadReal = $Cantidad;
					
								$InsAlmacenMovimientoEntradaDetalle1->AmdUtilidadPorcentaje = 0;
								$InsAlmacenMovimientoEntradaDetalle1->AmdUtilidad = 0;
								
					
								if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){								
									$InsAlmacenMovimientoEntradaDetalle1->AmdImporte = $ValorTotal * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
								}else{								
									$InsAlmacenMovimientoEntradaDetalle1->AmdImporte = $ValorTotal;
								}
								
								$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAduana = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduana)/$SumaValorTotal,6);
								$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalTransporte = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalTransporte)/$SumaValorTotal,6);
								$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalDesestiba = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba)/$SumaValorTotal,6);
								$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAlmacenaje = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje)/$SumaValorTotal,6);
								$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAdValorem = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem)/$SumaValorTotal,6);
								$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAduanaNacional = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional)/$SumaValorTotal,6);
								$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalGastoAdministrativo = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo)/$SumaValorTotal,6);
								$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalOtroCosto1 = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1)/$SumaValorTotal,6);
								$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalOtroCosto2 = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2)/$SumaValorTotal,6);
								
								$InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalRecargo = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo)/$SumaValorTotal,6);
								$InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalFlete = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete)/$SumaValorTotal,6);
								$InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalOtroCosto = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto)/$SumaValorTotal,6);
					
								$InsAlmacenMovimientoEntradaDetalle1->AmdEstado = 3;
								$InsAlmacenMovimientoEntradaDetalle1->AmdTiempoCreacion = date("Y-m-d H:i:s");
								$InsAlmacenMovimientoEntradaDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");
								$InsAlmacenMovimientoEntradaDetalle1->AmdEliminado = 1;				
								$InsAlmacenMovimientoEntradaDetalle1->InsMysql = NULL;
								
								//SE ESTA IGNORADO LA IMPORTACION
								$InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraTotal = round($InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalRecargo + $InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalFlete + $InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalOtroCosto,6);
								$InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraUnitario = round($InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraTotal/$Cantidad,6);
								$InsAlmacenMovimientoEntradaDetalle1->AmdValorTotal =  round($InsAlmacenMovimientoEntradaDetalle1->AmdCosto + ($InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraUnitario/(($InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta/100)+1)),6);
					
								settype($InsAlmacenMovimientoEntradaDetalle1->AmdCostoAnterior,"float");
					
								if(empty($InsAlmacenMovimientoEntradaDetalle1->AmdCostoAnterior)){
									$InsAlmacenMovimientoEntradaDetalle1->AmdCostoPromedio =  round(($InsAlmacenMovimientoEntradaDetalle1->AmdValorTotal),6);				
								}else{
									$InsAlmacenMovimientoEntradaDetalle1->AmdCostoPromedio =  round(($InsAlmacenMovimientoEntradaDetalle1->AmdValorTotal + $InsAlmacenMovimientoEntradaDetalle1->AmdCostoAnterior)/2,6);				
								}		
								
								$InsAlmacenMovimientoEntradaDetalle1->PcdId = NULL;
								$InsAlmacenMovimientoEntradaDetalle1->PcoId = NULL;
								$InsAlmacenMovimientoEntradaDetalle1->PcoFecha = NULL;
								$InsAlmacenMovimientoEntradaDetalle1->CliNombreCompleto = NULL;
								
								
								//deb($InsAlmacenMovimientoEntradaDetalle1->AmdEliminado);
								if($InsAlmacenMovimientoEntradaDetalle1->AmdEliminado==1){					
									$InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle[] = $InsAlmacenMovimientoEntradaDetalle1;		
									$InsAlmacenMovimientoEntrada->AmoSubTotal += $InsAlmacenMovimientoEntradaDetalle1->AmdImporte;
								}
								
								
								
							}
								
						}

						
					}
					
				

								
					$InsAlmacenMovimientoEntrada->AmoImpuesto = round( ($InsAlmacenMovimientoEntrada->AmoSubTotal + $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo) * ($InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta/100),3);
					$InsAlmacenMovimientoEntrada->AmoTotal = $InsAlmacenMovimientoEntrada->AmoSubTotal + $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo + $InsAlmacenMovimientoEntrada->AmoImpuesto;

					
					if($GuardarArchivo){
						
						if($InsAlmacenMovimientoEntrada->MtdRegistrarAlmacenMovimientoEntrada()){
							echo "Se ha importado correctamente el xml";	
							echo "<br>";
						}else{
							echo "Ha ocurrido un error al importar el archivo, intente nuevamente";	
							echo "<br>";
							
						}
						
					}else{
						
						
					}



					/*
					1215853560 waj388
					*/
					
				break;
				
				default:
				
					echo "Formato no permitido";
					echo "<br>";
					
				break;
				
			}
			
			
				

		} else {
			
			echo "Hubo un error al subir el archivo";
			echo "<br>";
		
		}

	
}
?></td>
</tr>
</table>

	</form>



