<?php


//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';

	$InsNotaDebito->NdbId = $_POST['CmpId'];
	$InsNotaDebito->NdtId = $_POST['CmpTalonario'];
	$InsNotaDebito->CliId = $_POST['CmpClienteId'];

	$InsNotaDebito->UsuId = $_SESSION['SesionId'];
	$InsNotaDebito->SucId = $_SESSION['SesionSucursal'];

	$InsNotaDebito->DocId = $_POST['CmpDocumentoId'];
	$InsNotaDebito->DtaId = $_POST['CmpDocumentoTalonario'];
	$InsNotaDebito->DtaNumero = $_POST['CmpDocumentoTalonarioNumero'];
	$InsNotaDebito->NdbPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	
	$InsNotaDebito->NdbTipo = $_POST['CmpTipo'];
	$InsNotaDebito->NdbEstado = $_POST['CmpEstado'];
	$InsNotaDebito->NdbFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	
	$InsNotaDebito->NdbObservacion = addslashes($_POST['CmpObservacion'])."###".addslashes($_POST['CmpObservacionImpresa']);
	
	//deb($_POST['CmpMotivo']);
	$InsNotaDebito->NdbMotivo = addslashes($_POST['CmpMotivo']);
	$InsNotaDebito->NdbMotivoCodigo = $_POST['CmpMotivoCodigo'];
	
	$InsNotaDebito->MonId = $_POST['CmpMonedaId'];
	$InsNotaDebito->NdbTipoCambio = $_POST['CmpTipoCambio'];
	$InsNotaDebito->NdbIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	
	$InsNotaDebito->NdbCierre = $_POST['CmpCierre'];
	$InsNotaDebito->NdbTiempoModificacion = date("Y-m-d H:i:s");
	$InsNotaDebito->NdbEliminado = 1;
	
	$InsNotaDebito->CliNombre = $_POST['CmpClienteNombre'];
	$InsNotaDebito->TdoId = $_POST['CmpTipoDocumento'];
	$InsNotaDebito->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsNotaDebito->NdbDireccion = $_POST['CmpClienteDireccion'];
	//$InsNotaDebito->CdiDescripcion = $_POST['CmpClienteDireccion'];
	$InsNotaDebito->CliTelefono = $_POST['CmpClienteTelefono'];
	
	$InsNotaDebito->CliEmail = $_POST['CmpClienteEmail'];
	$InsNotaDebito->CliCelular = $_POST['CmpClienteCelular'];
	$InsNotaDebito->CliFax = $_POST['CmpClienteFax'];
	
	
		
	$InsNotaDebito->NdbUsuario = $_POST['CmpUsuario'];
	$InsNotaDebito->NdbVendedor = $_POST['CmpVendedor'];
	$InsNotaDebito->NdbNumeroPedido = $_POST['CmpNumeroPedido'];
	
	$InsNotaDebito->NotaDebitoDetalle = array();	
	

	$InsNotaDebito->NdbProcesar = $_POST['CmpProcesar'];
	$InsNotaDebito->NdbEnviarSUNAT = $_POST['CmpEnviarSUNAT'];

	$InsNotaDebito->OvvId = $_POST['CmpOrdenVentaVehiculoId'];

	$InsNotaDebito->NdbDatoAdicional1 = $_SESSION['InsNotaDebitoDatoAdicional1'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional2 = $_SESSION['InsNotaDebitoDatoAdicional2'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional3 = $_SESSION['InsNotaDebitoDatoAdicional3'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional4 = $_SESSION['InsNotaDebitoDatoAdicional4'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional5 = $_SESSION['InsNotaDebitoDatoAdicional5'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional6 = $_SESSION['InsNotaDebitoDatoAdicional6'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional7 = $_SESSION['InsNotaDebitoDatoAdicional7'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional8 = $_SESSION['InsNotaDebitoDatoAdicional8'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional9 = $_SESSION['InsNotaDebitoDatoAdicional9'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional10 = $_SESSION['InsNotaDebitoDatoAdicional10'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional11 = $_SESSION['InsNotaDebitoDatoAdicional11'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional12 = $_SESSION['InsNotaDebitoDatoAdicional12'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional13 = $_SESSION['InsNotaDebitoDatoAdicional13'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional14 = $_SESSION['InsNotaDebitoDatoAdicional14'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional15 = $_SESSION['InsNotaDebitoDatoAdicional15'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional16 = $_SESSION['InsNotaDebitoDatoAdicional16'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional17 = $_SESSION['InsNotaDebitoDatoAdicional17'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional18 = $_SESSION['InsNotaDebitoDatoAdicional18'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional19 = $_SESSION['InsNotaDebitoDatoAdicional19'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional20 = $_SESSION['InsNotaDebitoDatoAdicional20'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional21 = $_SESSION['InsNotaDebitoDatoAdicional21'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional22 = $_SESSION['InsNotaDebitoDatoAdicional22'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional23 = $_SESSION['InsNotaDebitoDatoAdicional23'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional24 = $_SESSION['InsNotaDebitoDatoAdicional24'.$Identificador];
	$InsNotaDebito->NdbDatoAdicional25 = $_SESSION['InsNotaDebitoDatoAdicional25'.$Identificador];
/*
SesionObjeto-NotaDebitoDetalleListado
Parametro1 = NddId
Parametro2 = NddDescripcion
Parametro3 = 
Parametro4 = NddPrecio
Parametro5 = Cantidad
Parametro6 = Importe
Parametro7 = TiempoCreacion
Parametro8 = TiempoModificacion
Parametro9 = VdeId
Parametro10 = VenId
Parametro11 = VtaId;
Parametro12 = NddTipo

Parametro13 = NddUnidadMedida
Parametro14 = AmdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = NddCodigo
Parametro19 = NddValorVenta
Parametro20 = NddImpuesto
Parametro21 = NddDescuentom
Parametro22 = NddGratuito
Parametro23 = NddExonerado	
*/


$InsNotaDebito->NdbTotalBruto = 0;
$InsNotaDebito->NdbTotalGravado = 0;
$InsNotaDebito->NdbTotalExonerado = 0;
$InsNotaDebito->NdbTotalDescuento = 0;
$InsNotaDebito->NdbTotalGratuito = 0;
$InsNotaDebito->NdbTotalDescuentoNoExonerado = 0;
$InsNotaDebito->NdbTotalValorBruto = 0;
$InsNotaDebito->NdbTotalPagar= 0;


$InsNotaDebito->NdbSubTotal = 0;
$InsNotaDebito->NdbImpuesto = 0;
$InsNotaDebito->NdbTotal = 0;

$ResNotaDebitoDetalle = $_SESSION['InsNotaDebitoDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);


	if(is_array($ResNotaDebitoDetalle['Datos'])){
	
		foreach($ResNotaDebitoDetalle['Datos'] as $DatSesionObjeto){
				
			if($InsNotaDebito->MonId<>$EmpresaMonedaId){
				
				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsNotaDebito->NdbTipoCambio;
				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsNotaDebito->NdbTipoCambio;
				
				$DatSesionObjeto->Parametro19 = $DatSesionObjeto->Parametro19 * $InsNotaDebito->NdbTipoCambio;
				$DatSesionObjeto->Parametro20 = $DatSesionObjeto->Parametro20 * $InsNotaDebito->NdbTipoCambio;
				$DatSesionObjeto->Parametro21 = $DatSesionObjeto->Parametro21 * $InsNotaDebito->NdbTipoCambio;
				
			}
			
			
			$InsNotaDebitoDetalle1 = new ClsNotaDebitoDetalle();
			$InsNotaDebitoDetalle1->NddId = $DatSesionObjeto->Parametro1;
			
			
			$InsNotaDebitoDetalle1->OdeId = $DatSesionObjeto->Parametro9;			
			$InsNotaDebitoDetalle1->NddTipo = $DatSesionObjeto->Parametro12;			
			
			if($InsNotaDebitoDetalle1->NddTipo<>"T"){
				$InsNotaDebitoDetalle1->NddDescripcion = utf8_encode(htmlentities($DatSesionObjeto->Parametro2));	
			}else{
				$InsNotaDebitoDetalle1->NddDescripcion = addslashes(utf8_encode(($DatSesionObjeto->Parametro2)));
			}
			
			$InsNotaDebitoDetalle1->NddPrecio = $DatSesionObjeto->Parametro4;
			$InsNotaDebitoDetalle1->NddCantidad = $DatSesionObjeto->Parametro5;
			$InsNotaDebitoDetalle1->NddImporte = $DatSesionObjeto->Parametro6;
			
			$InsNotaDebitoDetalle1->NddValorVenta = $DatSesionObjeto->Parametro19;
			$InsNotaDebitoDetalle1->NddImpuesto = $DatSesionObjeto->Parametro20;
			$InsNotaDebitoDetalle1->NddDescuento = $DatSesionObjeto->Parametro21;
			$InsNotaDebitoDetalle1->NddImpuestoSelectivo = $DatSesionObjeto->Parametro25;
			
			$InsNotaDebitoDetalle1->NddGratuito = 2;
			$InsNotaDebitoDetalle1->NddExonerado = (empty($DatSesionObjeto->Parametro23)?2:$DatSesionObjeto->Parametro23);			

			$InsNotaDebitoDetalle1->NddCodigo = $DatSesionObjeto->Parametro18;
			$InsNotaDebitoDetalle1->NddUnidadMedida = $DatSesionObjeto->Parametro13;
			
			
			$InsNotaDebitoDetalle1->NddTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsNotaDebitoDetalle1->NddTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsNotaDebitoDetalle1->NddEliminado = $DatSesionObjeto->Eliminado;				
			$InsNotaDebitoDetalle1->InsMysql = NULL;
			
//			deb($InsNotaDebitoDetalle1->NddValorVenta);
			$InsNotaDebito->NotaDebitoDetalle[] = $InsNotaDebitoDetalle1;	
			
			if($InsNotaDebitoDetalle1->NddEliminado==1){		
				
				$InsNotaDebito->NdbTotalBruto += $InsNotaDebitoDetalle1->NddImporte;	
									
				//EXONERADO
				if($InsNotaDebitoDetalle1->NddExonerado == 1){						
					//$InsFactura->FacTotalExonerado += $InsNotaDebitoDetalle1->NddImporte - $InsNotaDebitoDetalle1->NddDescuento;					
					$InsNotaDebito->NdbTotalExonerado += $InsNotaDebitoDetalle1->NddValorVenta - $InsNotaDebitoDetalle1->NddDescuento;
				}/*else{
					$InsFactura->FacTotalDescuentoNoExonerado += $InsNotaDebitoDetalle1->NddDescuento;						
				}*/
				
				//GRATUITO
				if($InsNotaDebitoDetalle1->NddGratuito == 1){			
					//$InsFactura->FacTotalGratuito += $InsNotaDebitoDetalle1->NddValorVenta * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);			
					$InsNotaDebito->NdbTotalGratuito += $InsNotaDebitoDetalle1->NddValorVenta;			
				}
				
				//GRAVADO
				if($InsNotaDebitoDetalle1->NddExonerado == 2 and $InsNotaDebitoDetalle1->NddGratuito == 2){			
					$InsNotaDebito->NdbTotalGravado += $InsNotaDebitoDetalle1->NddValorVenta - $InsNotaDebitoDetalle1->NddDescuento;
				}
				
				//VALOR BRUTO
				if($InsNotaDebitoDetalle1->NddGratuito == 2){		
					$InsNotaDebito->NdbTotalValorBruto += $InsNotaDebitoDetalle1->NddValorVenta - $InsNotaDebitoDetalle1->NddDescuento;
				}
				
				
				//TOTAL PAGAR								
				if($InsNotaDebitoDetalle1->NddGratuito == 2){	
					if($InsNotaDebitoDetalle1->NddExonerado == 2){
						$InsNotaDebito->NdbTotalPagar += 	( ($InsNotaDebitoDetalle1->NddValorVenta - $InsNotaDebitoDetalle1->NddDescuento ) * ( ($InsNotaDebito->NdbPorcentajeImpuestoVenta/100)+1) ) * ( (100 - $InsNotaDebito->NdbPorcentajeDescuento)/100 ) ;
					}else{
						$InsNotaDebito->NdbTotalPagar += 	($InsNotaDebitoDetalle1->NddValorVenta - $InsNotaDebitoDetalle1->NddDescuento) * ( (100 - $InsNotaDebito->NdbPorcentajeDescuento)/100 );	
					}
				}
				
				$InsNotaDebito->NdbTotalDescuento += $InsNotaDebitoDetalle1->NddDescuento;				
				
			}
						
		}	
		

	}
	
	
		
	if($InsNotaDebito->NdbPorcentajeDescuento>0){
		
		$InsNotaDebito->NdbTotalExonerado = $InsNotaDebito->NdbTotalExonerado - ($InsNotaDebito->NdbTotalExonerado * ($InsNotaDebito->NdbPorcentajeDescuento/100));
		$InsNotaDebito->NdbTotalGravado =  $InsNotaDebito->NdbTotalGravado - ($InsNotaDebito->NdbTotalGravado * ($InsNotaDebito->NdbPorcentajeDescuento/100));
		$InsNotaDebito->NdbTotalDescuento = $InsNotaDebito->NdbTotalDescuento + ($InsNotaDebito->NdbTotalValorBruto * ($InsNotaDebito->NdbPorcentajeDescuento/100));

	}
	
//deb($InsNotaDebito->NdbSubTotal);
	$InsNotaDebito->NdbSubTotal = ($InsNotaDebito->NdbTotalGravado);
	$InsNotaDebito->NdbImpuesto = ($InsNotaDebito->NdbSubTotal * ($InsNotaDebito->NdbPorcentajeImpuestoVenta/100));
	$InsNotaDebito->NdbTotal = ($InsNotaDebito->NdbSubTotal + $InsNotaDebito->NdbImpuesto + $InsNotaDebito->NdbTotalExonerado);
	
	

	if($InsNotaDebito->MtdEditarNotaDebito()){
		$Edito = true;		
		$Resultado.='#SAS_NDB_102';
		FncCargarDatos();
	} else{
		$Resultado.='#ERR_NDB_102';
		$InsNotaDebito->NdbFechaEmision = FncCambiaFechaANormal($InsNotaDebito->NdbFechaEmision);
		list($InsNotaDebito->NdbObservacion,$InsNotaDebito->NdbObservacionImpresa) = explode("###",$InsNotaDebito->NdbObservacion);
	}
	

}else{
	
	FncCargarDatos();
	
}


function FncCargarDatos(){

	global $GET_id;
	global $GET_ta;
	global $Identificador;	
	global $InsNotaDebito;
	global $EmpresaMonedaId;
		
	unset($_SESSION['InsNotaDebitoDetalle'.$Identificador]);	
			
	$_SESSION['InsNotaDebitoDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsNotaDebito->NdbId = $GET_id;
	$InsNotaDebito->NdtId = $GET_ta;
	$InsNotaDebito->MtdObtenerNotaDebito();		
	
	$_SESSION['InsNotaDebitoDatoAdicional1'.$Identificador] = $InsNotaDebito->NdbDatoAdicional1;
	$_SESSION['InsNotaDebitoDatoAdicional2'.$Identificador] = $InsNotaDebito->NdbDatoAdicional2;
	$_SESSION['InsNotaDebitoDatoAdicional3'.$Identificador] = $InsNotaDebito->NdbDatoAdicional3;
	$_SESSION['InsNotaDebitoDatoAdicional4'.$Identificador] = $InsNotaDebito->NdbDatoAdicional4;
	$_SESSION['InsNotaDebitoDatoAdicional5'.$Identificador] = $InsNotaDebito->NdbDatoAdicional5;
	$_SESSION['InsNotaDebitoDatoAdicional6'.$Identificador] = $InsNotaDebito->NdbDatoAdicional6;
	$_SESSION['InsNotaDebitoDatoAdicional7'.$Identificador] = $InsNotaDebito->NdbDatoAdicional7;
	$_SESSION['InsNotaDebitoDatoAdicional8'.$Identificador] = $InsNotaDebito->NdbDatoAdicional8;
	$_SESSION['InsNotaDebitoDatoAdicional9'.$Identificador] = $InsNotaDebito->NdbDatoAdicional9;
	$_SESSION['InsNotaDebitoDatoAdicional10'.$Identificador] = $InsNotaDebito->NdbDatoAdicional10;
	
	$_SESSION['InsNotaDebitoDatoAdicional11'.$Identificador] = $InsNotaDebito->NdbDatoAdicional11;
	$_SESSION['InsNotaDebitoDatoAdicional12'.$Identificador] = $InsNotaDebito->NdbDatoAdicional12;
	$_SESSION['InsNotaDebitoDatoAdicional13'.$Identificador] = $InsNotaDebito->NdbDatoAdicional13;
	$_SESSION['InsNotaDebitoDatoAdicional14'.$Identificador] = $InsNotaDebito->NdbDatoAdicional14;
	$_SESSION['InsNotaDebitoDatoAdicional15'.$Identificador] = $InsNotaDebito->NdbDatoAdicional15;
	$_SESSION['InsNotaDebitoDatoAdicional16'.$Identificador] = $InsNotaDebito->NdbDatoAdicional16;
	$_SESSION['InsNotaDebitoDatoAdicional17'.$Identificador] = $InsNotaDebito->NdbDatoAdicional17;
	$_SESSION['InsNotaDebitoDatoAdicional18'.$Identificador] = $InsNotaDebito->NdbDatoAdicional18;
	$_SESSION['InsNotaDebitoDatoAdicional19'.$Identificador] = $InsNotaDebito->NdbDatoAdicional19;
	$_SESSION['InsNotaDebitoDatoAdicional20'.$Identificador] = $InsNotaDebito->NdbDatoAdicional20;
	
	$_SESSION['InsNotaDebitoDatoAdicional21'.$Identificador] = $InsNotaDebito->NdbDatoAdicional21;
	$_SESSION['InsNotaDebitoDatoAdicional22'.$Identificador] = $InsNotaDebito->NdbDatoAdicional22;
	$_SESSION['InsNotaDebitoDatoAdicional23'.$Identificador] = $InsNotaDebito->NdbDatoAdicional23;
	$_SESSION['InsNotaDebitoDatoAdicional24'.$Identificador] = $InsNotaDebito->NdbDatoAdicional24;
	$_SESSION['InsNotaDebitoDatoAdicional25'.$Identificador] = $InsNotaDebito->NdbDatoAdicional25;
	
			
			
	if(is_array($InsNotaDebito->NotaDebitoDetalle)){
		foreach($InsNotaDebito->NotaDebitoDetalle as $DatNotaDebitoDetalle){
			
			if($InsNotaDebito->MonId<>$EmpresaMonedaId ){
				
				$DatNotaDebitoDetalle->NddImporte = ($DatNotaDebitoDetalle->NddImporte / $InsNotaDebito->NdbTipoCambio);
				$DatNotaDebitoDetalle->NddPrecio = ($DatNotaDebitoDetalle->NddPrecio  / $InsNotaDebito->NdbTipoCambio);
				
				$DatNotaDebitoDetalle->NddValorVenta = ($DatNotaDebitoDetalle->NddValorVenta  / $InsNotaDebito->NdbTipoCambio);
				$DatNotaDebitoDetalle->NddImpuesto = ($DatNotaDebitoDetalle->NddImpuesto  / $InsNotaDebito->NdbTipoCambio);
				$DatNotaDebitoDetalle->NddDescuento = ($DatNotaDebitoDetalle->NddDescuento  / $InsNotaDebito->NdbTipoCambio);
				
			}
			
/*
				SesionObjeto-NotaDebitoDetalleListado
				Parametro1 = NddId
				Parametro2 = NddDescripcion
				Parametro3 = 
				Parametro4 = NddPrecio
				Parametro5 = Cantidad
				Parametro6 = Importe
				Parametro7 = TiempoCreacion
				Parametro8 = TiempoModificacion
				
				Parametro9 = VdeId
				Parametro10 = VenId
				Parametro11 = VtaId;
				Parametro12 = NddTipo
				
				Parametro13 = NddUnidadMedida
				Parametro14 = AmdReingreso
				
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = NddCodigo
				Parametro19 = NddValorVenta
				Parametro20 = NddImpuesto
				Parametro21 = NddDescuentom
				Parametro22 = NddGratuito
				Parametro23 = NddExonerado	
				*/

			$_SESSION['InsNotaDebitoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatNotaDebitoDetalle->NddId,
			$DatNotaDebitoDetalle->NddDescripcion,
			NULL,
			$DatNotaDebitoDetalle->NddPrecio,
			$DatNotaDebitoDetalle->NddCantidad,
			$DatNotaDebitoDetalle->NddImporte,
			($DatNotaDebitoDetalle->NddTiempoCreacion),
			($DatNotaDebitoDetalle->NddTiempoModificacion),
			NULL,
			NULL,
			NULL,
			$DatNotaDebitoDetalle->NddTipo,
			
			$DatNotaDebitoDetalle->NddUnidadMedida,
			2,
			
			NULL,
			NULL,
			NULL,
			
			$DatNotaDebitoDetalle->NddCodigo,
			$DatNotaDebitoDetalle->NddValorVenta,
			$DatNotaDebitoDetalle->NddImpuesto,
			$DatNotaDebitoDetalle->NddDescuento,
			$DatNotaDebitoDetalle->NddGratuito,
			$DatNotaDebitoDetalle->NddExonerado
			
			);
		
		}
	}

}

?>