<?php


//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';

	$InsNotaCredito->NcrId = $_POST['CmpId'];
	$InsNotaCredito->NctId = $_POST['CmpTalonario'];
	$InsNotaCredito->CliId = $_POST['CmpClienteId'];

	$InsNotaCredito->UsuId = $_SESSION['SesionId'];
	$InsNotaCredito->SucId = $_SESSION['SesionSucursal'];

	$InsNotaCredito->DocId = $_POST['CmpDocumentoId'];
	$InsNotaCredito->DtaId = $_POST['CmpDocumentoTalonario'];
	$InsNotaCredito->DtaNumero = $_POST['CmpDocumentoTalonarioNumero'];
	$InsNotaCredito->NcrPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsNotaCredito->NcrPorcentajeImpuestoSelectivo = $_POST['CmpPorcentajeImpuestoSelectivo'];
	
	$InsNotaCredito->NcrTipo = $_POST['CmpTipo'];
	$InsNotaCredito->NcrEstado = $_POST['CmpEstado'];
	$InsNotaCredito->NcrFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	
	$InsNotaCredito->NcrObservacion = addslashes($_POST['CmpObservacion'])."###".addslashes($_POST['CmpObservacionImpresa']);
	
	//deb($_POST['CmpMotivo']);
	$InsNotaCredito->NcrMotivo = addslashes($_POST['CmpMotivo']);
	$InsNotaCredito->NcrMotivoCodigo = $_POST['CmpMotivoCodigo'];
	
	$InsNotaCredito->MonId = $_POST['CmpMonedaId'];
	$InsNotaCredito->NcrTipoCambio = $_POST['CmpTipoCambio'];
	$InsNotaCredito->NcrIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	
	$InsNotaCredito->NcrCierre = $_POST['CmpCierre'];
	$InsNotaCredito->NcrTiempoModificacion = date("Y-m-d H:i:s");
	$InsNotaCredito->NcrEliminado = 1;
	
	$InsNotaCredito->CliNombre = $_POST['CmpClienteNombre'];
	$InsNotaCredito->TdoId = $_POST['CmpTipoDocumento'];
	$InsNotaCredito->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsNotaCredito->NcrDireccion = $_POST['CmpClienteDireccion'];
	//$InsNotaCredito->CdiDescripcion = $_POST['CmpClienteDireccion'];
	$InsNotaCredito->CliTelefono = $_POST['CmpClienteTelefono'];
	
	$InsNotaCredito->CliEmail = $_POST['CmpClienteEmail'];
	$InsNotaCredito->CliCelular = $_POST['CmpClienteCelular'];
	$InsNotaCredito->CliFax = $_POST['CmpClienteFax'];


		
	$InsNotaCredito->NcrUsuario = $_POST['CmpUsuario'];
	$InsNotaCredito->NcrVendedor = $_POST['CmpVendedor'];
	$InsNotaCredito->NcrNumeroPedido = $_POST['CmpNumeroPedido'];
	
	
	$InsNotaCredito->NotaCreditoDetalle = array();	
	

	$InsNotaCredito->NcrProcesar = $_POST['CmpProcesar'];
	$InsNotaCredito->NcrEnviarSUNAT = $_POST['CmpEnviarSUNAT'];

	$InsNotaCredito->OvvId = $_POST['CmpOrdenVentaVehiculoId'];

	$InsNotaCredito->NcrDatoAdicional1 = $_SESSION['InsNotaCreditoDatoAdicional1'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional2 = $_SESSION['InsNotaCreditoDatoAdicional2'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional3 = $_SESSION['InsNotaCreditoDatoAdicional3'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional4 = $_SESSION['InsNotaCreditoDatoAdicional4'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional5 = $_SESSION['InsNotaCreditoDatoAdicional5'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional6 = $_SESSION['InsNotaCreditoDatoAdicional6'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional7 = $_SESSION['InsNotaCreditoDatoAdicional7'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional8 = $_SESSION['InsNotaCreditoDatoAdicional8'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional9 = $_SESSION['InsNotaCreditoDatoAdicional9'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional10 = $_SESSION['InsNotaCreditoDatoAdicional10'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional11 = $_SESSION['InsNotaCreditoDatoAdicional11'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional12 = $_SESSION['InsNotaCreditoDatoAdicional12'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional13 = $_SESSION['InsNotaCreditoDatoAdicional13'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional14 = $_SESSION['InsNotaCreditoDatoAdicional14'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional15 = $_SESSION['InsNotaCreditoDatoAdicional15'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional16 = $_SESSION['InsNotaCreditoDatoAdicional16'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional17 = $_SESSION['InsNotaCreditoDatoAdicional17'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional18 = $_SESSION['InsNotaCreditoDatoAdicional18'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional19 = $_SESSION['InsNotaCreditoDatoAdicional19'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional20 = $_SESSION['InsNotaCreditoDatoAdicional20'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional21 = $_SESSION['InsNotaCreditoDatoAdicional21'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional22 = $_SESSION['InsNotaCreditoDatoAdicional22'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional23 = $_SESSION['InsNotaCreditoDatoAdicional23'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional24 = $_SESSION['InsNotaCreditoDatoAdicional24'.$Identificador];
	$InsNotaCredito->NcrDatoAdicional25 = $_SESSION['InsNotaCreditoDatoAdicional25'.$Identificador];
/*
SesionObjeto-NotaCreditoDetalleListado
Parametro1 = NcdId
Parametro2 = NcdDescripcion
Parametro3 = 
Parametro4 = NcdPrecio
Parametro5 = Cantidad
Parametro6 = Importe
Parametro7 = TiempoCreacion
Parametro8 = TiempoModificacion
Parametro9 = VdeId
Parametro10 = VenId
Parametro11 = VtaId;
Parametro12 = NcdTipo

Parametro13 = NcdUnidadMedida
Parametro14 = AmdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = NcdCodigo
Parametro19 = NcdValorVenta
Parametro20 = NcdImpuesto
Parametro21 = NcdDescuentom
Parametro22 = NcdGratuito
Parametro23 = NcdExonerado	

Parametro24 = NcdIncluyeSelectivo
Parametro25 = NcdImpuestoSelectivo
*/

$InsNotaCredito->NcrTotalBruto = 0;
$InsNotaCredito->NcrTotalGravado = 0;
$InsNotaCredito->NcrTotalExonerado = 0;
$InsNotaCredito->NcrTotalGratuito = 0;
$InsNotaCredito->NcrTotalDescuentoNoExonerado = 0;
$InsNotaCredito->NcrTotalValorBruto = 0;
$InsNotaCredito->NcrTotalPagar= 0;
$InsNotaCredito->NcrTotalDescuento= 0;
$InsNotaCredito->NcrTotalImpuestoSelectivo= 0;

$InsNotaCredito->NcrSubTotal = 0;
$InsNotaCredito->NcrImpuesto = 0;
$InsNotaCredito->NcrTotal = 0;

$ResNotaCreditoDetalle = $_SESSION['InsNotaCreditoDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);


	if(is_array($ResNotaCreditoDetalle['Datos'])){
	
		foreach($ResNotaCreditoDetalle['Datos'] as $DatSesionObjeto){
				
			if($InsNotaCredito->MonId<>$EmpresaMonedaId){
				
				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsNotaCredito->NcrTipoCambio;
				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsNotaCredito->NcrTipoCambio;
				
				$DatSesionObjeto->Parametro19 = $DatSesionObjeto->Parametro19 * $InsNotaCredito->NcrTipoCambio;
				$DatSesionObjeto->Parametro20 = $DatSesionObjeto->Parametro20 * $InsNotaCredito->NcrTipoCambio;
				$DatSesionObjeto->Parametro21 = $DatSesionObjeto->Parametro21 * $InsNotaCredito->NcrTipoCambio;
				$DatSesionObjeto->Parametro25 = $DatSesionObjeto->Parametro25 * $InsNotaCredito->NcrTipoCambio;
				
			}
			
			
			$InsNotaCreditoDetalle1 = new ClsNotaCreditoDetalle();
			$InsNotaCreditoDetalle1->NcdId = $DatSesionObjeto->Parametro1;
			
			
			$InsNotaCreditoDetalle1->OdeId = $DatSesionObjeto->Parametro9;			
			$InsNotaCreditoDetalle1->NcdTipo = $DatSesionObjeto->Parametro12;			
			
			if($InsNotaCreditoDetalle1->NcdTipo<>"T"){
				$InsNotaCreditoDetalle1->NcdDescripcion = utf8_encode(htmlentities($DatSesionObjeto->Parametro2));	
			}else{
				$InsNotaCreditoDetalle1->NcdDescripcion = addslashes(utf8_encode(($DatSesionObjeto->Parametro2)));
			}
			
			$InsNotaCreditoDetalle1->NcdPrecio = $DatSesionObjeto->Parametro4;
			$InsNotaCreditoDetalle1->NcdCantidad = $DatSesionObjeto->Parametro5;
			$InsNotaCreditoDetalle1->NcdImporte = $DatSesionObjeto->Parametro6;
			
			$InsNotaCreditoDetalle1->NcdValorVenta = $DatSesionObjeto->Parametro19;
			$InsNotaCreditoDetalle1->NcdImpuesto = $DatSesionObjeto->Parametro20;
			$InsNotaCreditoDetalle1->NcdDescuento = $DatSesionObjeto->Parametro21;
			$InsNotaCreditoDetalle1->NcdImpuestoSelectivo = $DatSesionObjeto->Parametro25;
			
			$InsNotaCreditoDetalle1->NcdGratuito = 2;
			$InsNotaCreditoDetalle1->NcdExonerado = (empty($DatSesionObjeto->Parametro23)?2:$DatSesionObjeto->Parametro23);			
			$InsNotaCreditoDetalle1->NcdIncluyeSelectivo = $DatSesionObjeto->Parametro24;

			$InsNotaCreditoDetalle1->NcdCodigo = $DatSesionObjeto->Parametro18;
			$InsNotaCreditoDetalle1->NcdUnidadMedida = $DatSesionObjeto->Parametro13;
			
			$InsNotaCreditoDetalle1->NcdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsNotaCreditoDetalle1->NcdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsNotaCreditoDetalle1->NcdEliminado = $DatSesionObjeto->Eliminado;				
			$InsNotaCreditoDetalle1->InsMysql = NULL;
			
//			deb($InsNotaCreditoDetalle1->NcdValorVenta);
			$InsNotaCredito->NotaCreditoDetalle[] = $InsNotaCreditoDetalle1;	
			
			if($InsNotaCreditoDetalle1->NcdEliminado==1){		
				
				$InsNotaCredito->NcrTotalBruto += $InsNotaCreditoDetalle1->NcdImporte;	
									
					//EXONERADO
				if($InsNotaCreditoDetalle1->NcdExonerado == 1){						
					$InsNotaCredito->NcrTotalExonerado += $InsNotaCreditoDetalle1->NcdValorVenta;
				}
				
				//GRAVADO
				if($InsNotaCreditoDetalle1->NcdExonerado == 2 and $InsNotaCreditoDetalle1->NcdGratuito == 2){			
					$InsNotaCredito->NcrTotalGravado += $InsNotaCreditoDetalle1->NcdValorVenta;
				}
				
				//VALOR BRUTO
				if($InsNotaCreditoDetalle1->NcdGratuito == 2){		
					$InsNotaCredito->NcrTotalValorBruto += $InsNotaCreditoDetalle1->NcdValorVenta;
				}
				
				//GRATUITO
				if($InsNotaCreditoDetalle1->NcdGratuito == 1){			
					$InsNotaCredito->NcrTotalGratuito += $InsNotaCreditoDetalle1->NcdValorVenta;			
				}
				
				
				//INCLUYE SELECTIVO
				if($InsFacturaDetalle1->FdeIncluyeSelectivo == 1){			
					$InsFactura->FacTotalImpuestoSelectivo += ($InsFacturaDetalle1->FdeImpuestoSelectivo);
				}	
				
				//TOTAL PAGAR								
				if($InsNotaCreditoDetalle1->NcdGratuito == 2){	
					if($InsNotaCreditoDetalle1->NcdExonerado == 2){
						$InsNotaCredito->NcrTotalPagar += 	( ($InsNotaCreditoDetalle1->NcdValorVenta ) * ( ($InsNotaCredito->NcrPorcentajeImpuestoVenta/100)+1) ) * ( (100 - $InsNotaCredito->NcrPorcentajeDescuento)/100 ) ;
					}else{
						$InsNotaCredito->NcrTotalPagar += 	($InsNotaCreditoDetalle1->NcdValorVenta ) * ( (100 - $InsNotaCredito->NcrPorcentajeDescuento)/100 );	
					}
				}
				
				$InsNotaCredito->NcrTotalDescuento += $InsNotaCreditoDetalle1->NcdDescuento;				
				
			}
						
		}	
		

	}
	
	$InsNotaCredito->NcrSubTotal = ($InsNotaCredito->NcrTotalGravado);
	$InsNotaCredito->NcrImpuesto = (($InsNotaCredito->NcrSubTotal + $InsNotaCredito->NcrTotalImpuestoSelectivo ) * ($InsNotaCredito->NcrPorcentajeImpuestoVenta/100));
	$InsNotaCredito->NcrTotal = ($InsNotaCredito->NcrSubTotal+ $InsNotaCredito->NcrTotalImpuestoSelectivo +  $InsNotaCredito->NcrTotalExonerado + $InsNotaCredito->NcrImpuesto);

	if($InsNotaCredito->MtdEditarNotaCredito()){
		$Edito = true;		
		$Resultado.='#SAS_NCR_102';
		FncCargarDatos();
	} else{
		$Resultado.='#ERR_NCR_102';
		$InsNotaCredito->NcrFechaEmision = FncCambiaFechaANormal($InsNotaCredito->NcrFechaEmision);
		list($InsNotaCredito->NcrObservacion,$InsNotaCredito->NcrObservacionImpresa) = explode("###",$InsNotaCredito->NcrObservacion);
	}
	

}else{
	
	FncCargarDatos();
	
}


function FncCargarDatos(){

	global $GET_id;
	global $GET_ta;
	global $Identificador;	
	global $InsNotaCredito;
	global $EmpresaMonedaId;
		
	unset($_SESSION['InsNotaCreditoDetalle'.$Identificador]);	
			
	$_SESSION['InsNotaCreditoDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsNotaCredito->NcrId = $GET_id;
	$InsNotaCredito->NctId = $GET_ta;
	$InsNotaCredito->MtdObtenerNotaCredito();		
	
	$_SESSION['InsNotaCreditoDatoAdicional1'.$Identificador] = $InsNotaCredito->NcrDatoAdicional1;
	$_SESSION['InsNotaCreditoDatoAdicional2'.$Identificador] = $InsNotaCredito->NcrDatoAdicional2;
	$_SESSION['InsNotaCreditoDatoAdicional3'.$Identificador] = $InsNotaCredito->NcrDatoAdicional3;
	$_SESSION['InsNotaCreditoDatoAdicional4'.$Identificador] = $InsNotaCredito->NcrDatoAdicional4;
	$_SESSION['InsNotaCreditoDatoAdicional5'.$Identificador] = $InsNotaCredito->NcrDatoAdicional5;
	$_SESSION['InsNotaCreditoDatoAdicional6'.$Identificador] = $InsNotaCredito->NcrDatoAdicional6;
	$_SESSION['InsNotaCreditoDatoAdicional7'.$Identificador] = $InsNotaCredito->NcrDatoAdicional7;
	$_SESSION['InsNotaCreditoDatoAdicional8'.$Identificador] = $InsNotaCredito->NcrDatoAdicional8;
	$_SESSION['InsNotaCreditoDatoAdicional9'.$Identificador] = $InsNotaCredito->NcrDatoAdicional9;
	$_SESSION['InsNotaCreditoDatoAdicional10'.$Identificador] = $InsNotaCredito->NcrDatoAdicional10;
	
	$_SESSION['InsNotaCreditoDatoAdicional11'.$Identificador] = $InsNotaCredito->NcrDatoAdicional11;
	$_SESSION['InsNotaCreditoDatoAdicional12'.$Identificador] = $InsNotaCredito->NcrDatoAdicional12;
	$_SESSION['InsNotaCreditoDatoAdicional13'.$Identificador] = $InsNotaCredito->NcrDatoAdicional13;
	$_SESSION['InsNotaCreditoDatoAdicional14'.$Identificador] = $InsNotaCredito->NcrDatoAdicional14;
	$_SESSION['InsNotaCreditoDatoAdicional15'.$Identificador] = $InsNotaCredito->NcrDatoAdicional15;
	$_SESSION['InsNotaCreditoDatoAdicional16'.$Identificador] = $InsNotaCredito->NcrDatoAdicional16;
	$_SESSION['InsNotaCreditoDatoAdicional17'.$Identificador] = $InsNotaCredito->NcrDatoAdicional17;
	$_SESSION['InsNotaCreditoDatoAdicional18'.$Identificador] = $InsNotaCredito->NcrDatoAdicional18;
	$_SESSION['InsNotaCreditoDatoAdicional19'.$Identificador] = $InsNotaCredito->NcrDatoAdicional19;
	$_SESSION['InsNotaCreditoDatoAdicional20'.$Identificador] = $InsNotaCredito->NcrDatoAdicional20;
	
	$_SESSION['InsNotaCreditoDatoAdicional21'.$Identificador] = $InsNotaCredito->NcrDatoAdicional21;
	$_SESSION['InsNotaCreditoDatoAdicional22'.$Identificador] = $InsNotaCredito->NcrDatoAdicional22;
	$_SESSION['InsNotaCreditoDatoAdicional23'.$Identificador] = $InsNotaCredito->NcrDatoAdicional23;
	$_SESSION['InsNotaCreditoDatoAdicional24'.$Identificador] = $InsNotaCredito->NcrDatoAdicional24;
	$_SESSION['InsNotaCreditoDatoAdicional25'.$Identificador] = $InsNotaCredito->NcrDatoAdicional25;
	
			
			
	if(is_array($InsNotaCredito->NotaCreditoDetalle)){
		foreach($InsNotaCredito->NotaCreditoDetalle as $DatNotaCreditoDetalle){
			
			if($InsNotaCredito->MonId<>$EmpresaMonedaId ){
				
				$DatNotaCreditoDetalle->NcdImporte = ($DatNotaCreditoDetalle->NcdImporte / $InsNotaCredito->NcrTipoCambio);
				$DatNotaCreditoDetalle->NcdPrecio = ($DatNotaCreditoDetalle->NcdPrecio  / $InsNotaCredito->NcrTipoCambio);
				
				$DatNotaCreditoDetalle->NcdValorVenta = ($DatNotaCreditoDetalle->NcdValorVenta  / $InsNotaCredito->NcrTipoCambio);
				$DatNotaCreditoDetalle->NcdImpuesto = ($DatNotaCreditoDetalle->NcdImpuesto  / $InsNotaCredito->NcrTipoCambio);
				$DatNotaCreditoDetalle->NcdImpuestoSelectivo = ($DatNotaCreditoDetalle->NcdImpuestoSelectivo  / $InsNotaCredito->NcrTipoCambio);
				$DatNotaCreditoDetalle->NcdDescuento = ($DatNotaCreditoDetalle->NcdDescuento  / $InsNotaCredito->NcrTipoCambio);
				
			}
			
/*
				SesionObjeto-NotaCreditoDetalleListado
				Parametro1 = NcdId
				Parametro2 = NcdDescripcion
				Parametro3 = 
				Parametro4 = NcdPrecio
				Parametro5 = Cantidad
				Parametro6 = Importe
				Parametro7 = TiempoCreacion
				Parametro8 = TiempoModificacion
				
				Parametro9 = VdeId
				Parametro10 = VenId
				Parametro11 = VtaId;
				Parametro12 = NcdTipo
				
				Parametro13 = NcdUnidadMedida
				Parametro14 = AmdReingreso
				
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = NcdCodigo
				Parametro19 = NcdValorVenta
				Parametro20 = NcdImpuesto
				Parametro21 = NcdDescuentom
				Parametro22 = NcdGratuito
				Parametro23 = NcdExonerado	
				*/

			$_SESSION['InsNotaCreditoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatNotaCreditoDetalle->NcdId,
			$DatNotaCreditoDetalle->NcdDescripcion,
			NULL,
			$DatNotaCreditoDetalle->NcdPrecio,
			$DatNotaCreditoDetalle->NcdCantidad,
			$DatNotaCreditoDetalle->NcdImporte,
			($DatNotaCreditoDetalle->NcdTiempoCreacion),
			($DatNotaCreditoDetalle->NcdTiempoModificacion),
			NULL,
			NULL,
			NULL,
			$DatNotaCreditoDetalle->NcdTipo,
			
			$DatNotaCreditoDetalle->NcdUnidadMedida,
			2,
			
			NULL,
			NULL,
			NULL,
			
			$DatNotaCreditoDetalle->NcdCodigo,
			$DatNotaCreditoDetalle->NcdValorVenta,
			$DatNotaCreditoDetalle->NcdImpuesto,
			$DatNotaCreditoDetalle->NcdDescuento,
			$DatNotaCreditoDetalle->NcdGratuito,
			$DatNotaCreditoDetalle->NcdExonerado,
			
			$DatNotaCreditoDetalle->NcdIncluyeSelectivo,
			$DatNotaCreditoDetalle->NcdImpuestoSelectivo
			
			
			);
		
		}
	}

}

?>