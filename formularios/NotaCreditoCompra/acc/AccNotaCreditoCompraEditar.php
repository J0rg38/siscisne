<?php
//Si se hizo click en guardar
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsNotaCreditoCompra->NccId = $_POST['CmpId'];
	$InsNotaCreditoCompra->PrvId = $_POST['CmpProveedorId'];
	$InsNotaCreditoCompra->UsuId = $_SESSION['SesionId'];
	$InsNotaCreditoCompra->SucId = $_SESSION['SesionSucursal'];	
	$InsNotaCreditoCompra->AlmId = $_POST['CmpAlmacen'];

	$InsNotaCreditoCompra->NccComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsNotaCreditoCompra->NccComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsNotaCreditoCompra->NccComprobanteNumero = $InsNotaCreditoCompra->NccComprobanteNumeroSerie."-".$InsNotaCreditoCompra->NccComprobanteNumeroNumero;
	$InsNotaCreditoCompra->NccComprobanteNumeroFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],FALSE);
	
	$InsNotaCreditoCompra->NccFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	$InsNotaCreditoCompra->NccFoto = $_SESSION['SesNccFoto'.$Identificador];

	$InsNotaCreditoCompra->MonId = $_POST['CmpMonedaId'];
	$InsNotaCreditoCompra->NccTipoCambio = $_POST['CmpTipoCambio'];

	$InsNotaCreditoCompra->NccIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsNotaCreditoCompra->NccEstado = $_POST['CmpEstado'];
	$InsNotaCreditoCompra->NccPorcentajeImpuestoVenta = ($_POST['CmpPorcentajeImpuestoVenta']);
	
	$InsNotaCreditoCompra->NccObservacion = addslashes($_POST['CmpObservacion'])."###".addslashes($_POST['CmpObservacionImpresa']);
	
	$InsNotaCreditoCompra->NccCierre = 1;
	$InsNotaCreditoCompra->NccTiempoCreacion = date("Y-m-d H:i:s");
	$InsNotaCreditoCompra->NccTiempoModificacion = date("Y-m-d H:i:s");
	$InsNotaCreditoCompra->NccEliminado = 1;
	
	$InsNotaCreditoCompra->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsNotaCreditoCompra->PrvNombreCompleto = $_POST['CmpProveedorNombre'];
	$InsNotaCreditoCompra->PrvApellidoPaterno = $_POST['CmpProveedorApellidoPaterno'];
	$InsNotaCreditoCompra->PrvApellidoMaterno = $_POST['CmpProveedorApellidoMaterno'];
	
	$InsNotaCreditoCompra->TdoId = $_POST['CmpProveedorTipoDocumentoId'];	
	$InsNotaCreditoCompra->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	$InsNotaCreditoCompra->PrvDireccion = $_POST['CmpProveedorDireccion'];

	$InsNotaCreditoCompra->AmoComprobanteNumeroOrigen = $InsAlmacenMovimientoEntrada->AmoComprobanteNumero;
	$InsNotaCreditoCompra->AmoComprobanteFechaOrigen = $InsAlmacenMovimientoEntrada->AmoComprobanteFecha;
	$InsNotaCreditoCompra->AmoIdOrigen = $_POST['CmpAlmacenMovimientoEntradaId'];
	
	$InsNotaCreditoCompra->NotaCreditoCompraDetalle = array();		

	if($InsNotaCreditoCompra->MonId<>$EmpresaMonedaId){
		if(empty($InsNotaCreditoCompra->NccTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_NCC_600';
		}
	}


//SesionObjeto-NotaCreditoCompraDetalleListado
//Parametro1 = NodId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = NodPrecio
//Parametro5 = NodCantidad
//Parametro6 = NodImporte
//Parametro7 = NodTiempoCreacion
//Parametro8 = NodTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 = ProNombre
//Parametro12 = ProCodigoOriginal
//Parametro13 = UmeNombre
//Parametro14 = RtiId
//Parametro15 = UmeIdOrigen
//Parametro16 = NodEstado

	$InsNotaCreditoCompra->NccTotalBruto = 0;
	$InsNotaCreditoCompra->NccSubTotal = 0;
	$InsNotaCreditoCompra->NccImpuesto = 0;
	$InsNotaCreditoCompra->NccTotal = 0;

	$ResNotaCreditoCompraDetalle = $_SESSION['InsNotaCreditoCompraDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
	
	if(!empty($ResNotaCreditoCompraDetalle['Datos'])){
		foreach($ResNotaCreditoCompraDetalle['Datos'] as $DatSesionObjeto){
				
			$InsNotaCreditoCompraDetalle1 = new ClsNotaCreditoCompraDetalle();
			$InsNotaCreditoCompraDetalle1->NodId = $DatSesionObjeto->Parametro1;
			$InsNotaCreditoCompraDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsNotaCreditoCompraDetalle1->UmeId = $DatSesionObjeto->Parametro3;
			
			if($InsNotaCreditoCompra->MonId<>$EmpresaMonedaId and !empty($InsNotaCreditoCompra->NccTipoCambio)){
				$InsNotaCreditoCompraDetalle1->NodPrecio = $DatSesionObjeto->Parametro4 * $InsNotaCreditoCompra->NccTipoCambio;
			}else{
				$InsNotaCreditoCompraDetalle1->NodPrecio  = $DatSesionObjeto->Parametro4;
			}

			$InsNotaCreditoCompraDetalle1->NodCantidad = $DatSesionObjeto->Parametro5;
			$InsNotaCreditoCompraDetalle1->NodCantidadReal = $DatSesionObjeto->Parametro17;

			if($InsNotaCreditoCompra->MonId<>$EmpresaMonedaId and !empty($InsNotaCreditoCompra->NccTipoCambio)){
				$InsNotaCreditoCompraDetalle1->NodImporte = $DatSesionObjeto->Parametro6 * $InsNotaCreditoCompra->NccTipoCambio;
			}else{
				$InsNotaCreditoCompraDetalle1->NodImporte = $DatSesionObjeto->Parametro6;
			}
			
			$InsNotaCreditoCompraDetalle1->AmdIdOrigen = $DatSesionObjeto->Parametro9;
			$InsNotaCreditoCompraDetalle1->NodEstado = $DatSesionObjeto->Parametro16;
			$InsNotaCreditoCompraDetalle1->NodTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsNotaCreditoCompraDetalle1->NodTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsNotaCreditoCompraDetalle1->NodEliminado = $DatSesionObjeto->Eliminado;				
			$InsNotaCreditoCompraDetalle1->InsMysql = NULL;
			
			$InsNotaCreditoCompra->NotaCreditoCompraDetalle[] = $InsNotaCreditoCompraDetalle1;	
			
			if($InsNotaCreditoCompraDetalle1->NodEliminado==1){		
				$InsNotaCreditoCompra->NccTotalBruto += $InsNotaCreditoCompraDetalle1->NodImporte;
				
			}
						
		}	

	}else{
		$Guardar = false;
		$Resultado .= "#ERR_NCC_603";			
	}

	if($InsNotaCreditoCompra->NccIncluyeImpuesto==2){
		
		$InsNotaCreditoCompra->NccSubTotal = round($InsNotaCreditoCompra->NccTotalBruto,6);
		$InsNotaCreditoCompra->NccImpuesto = round(($InsNotaCreditoCompra->NccSubTotal * ($InsNotaCreditoCompra->NccPorcentajeImpuestoVenta/100)),6);
		$InsNotaCreditoCompra->NccTotal = round($InsNotaCreditoCompra->NccSubTotal + $InsNotaCreditoCompra->NccImpuesto,6);
		
	}else{
		
		$InsNotaCreditoCompra->NccTotal = round($InsNotaCreditoCompra->NccTotalBruto,6);	
		$InsNotaCreditoCompra->NccSubTotal = round($InsNotaCreditoCompra->NccTotal / (($InsNotaCreditoCompra->NccPorcentajeImpuestoVenta/100)+1),6);
		$InsNotaCreditoCompra->NccImpuesto = round(($InsNotaCreditoCompra->NccTotal - $InsNotaCreditoCompra->NccSubTotal),6);
		
	}


	if($Guardar){
		
		if($InsNotaCreditoCompra->MtdEditarNotaCreditoCompra()){
			$Edito = true;		
			$Resultado.='#SAS_NCC_102';
			FncCargarDatos();
		} else{
			$Resultado.='#ERR_NCC_102';
			$InsNotaCreditoCompra->NccFechaEmision = FncCambiaFechaANormal($InsNotaCreditoCompra->NccFechaEmision);
			
			list($InsNotaCreditoCompra->NccObservacion,$InsNotaCreditoCompra->NccObservacionImpresa) = explode("###",$InsNotaCreditoCompra->NccObservacion);
			
		}

	}else{
		
		$InsNotaCreditoCompra->NccFechaEmision = FncCambiaFechaANormal($InsNotaCreditoCompra->NccFechaEmision);
		list($InsNotaCreditoCompra->NccObservacion,$InsNotaCreditoCompra->NccObservacionImpresa) = explode("###",$InsNotaCreditoCompra->NccObservacion);
		
	}

}else{
	
	FncCargarDatos();
	
}


function FncCargarDatos(){

	global $GET_id;
	global $GET_ta;
	global $Identificador;	
	global $InsNotaCreditoCompra;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsNotaCreditoCompraDetalle'.$Identificador]);	
	unset($_SESSION['SesNccFoto'.$Identificador]);
	
	$_SESSION['InsNotaCreditoCompraDetalle'.$Identificador] = new ClsSesionObjeto();

	$InsNotaCreditoCompra->NccId = $GET_id;
	$InsNotaCreditoCompra->MtdObtenerNotaCreditoCompra();		

	//deb($InsNotaCreditoCompra);
	
	$_SESSION['SesNccFoto'.$Identificador] = $InsNotaCreditoCompra->NccFoto;

	if(!empty($InsNotaCreditoCompra->NotaCreditoCompraDetalle)){
		foreach($InsNotaCreditoCompra->NotaCreditoCompraDetalle as $DatNotaCreditoCompraDetalle){
			
//SesionObjeto-NotaCreditoCompraDetalleListado
//Parametro1 = NodId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = NodPrecio
//Parametro5 = NodCantidad
//Parametro6 = NodImporte
//Parametro7 = NodTiempoCreacion
//Parametro8 = NodTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 = ProNombre
//Parametro12 = ProCodigoOriginal
//Parametro13 = UmeNombre
//Parametro14 = RtiId
//Parametro15 = UmeIdOrigen
//Parametro16 = NodEstado
//Parametro17 = NodCantidadReal


//			deb($InsNotaCreditoCompra->MonId);
			if( $InsNotaCreditoCompra->MonId<>$EmpresaMonedaId ){
				
				$DatNotaCreditoCompraDetalle->NodImporte = ($DatNotaCreditoCompraDetalle->NodImporte / $InsNotaCreditoCompra->NccTipoCambio);
				$DatNotaCreditoCompraDetalle->NodPrecio = ($DatNotaCreditoCompraDetalle->NodPrecio  / $InsNotaCreditoCompra->NccTipoCambio);

			}

			$_SESSION['InsNotaCreditoCompraDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatNotaCreditoCompraDetalle->NodId,
			$DatNotaCreditoCompraDetalle->ProId,
			$DatNotaCreditoCompraDetalle->UmeId,
			($DatNotaCreditoCompraDetalle->NodPrecio),
			($DatNotaCreditoCompraDetalle->NodCantidad),
			($DatNotaCreditoCompraDetalle->NodImporte),
			($DatNotaCreditoCompraDetalle->NodTiempoCreacion),
			($DatNotaCreditoCompraDetalle->NodTiempoModificacion),
			$DatNotaCreditoCompraDetalle->AmdIdOrigen,
			$DatNotaCreditoCompraDetalle->AmoIdOrigen,
			$DatNotaCreditoCompraDetalle->ProNombre,
			$DatNotaCreditoCompraDetalle->ProCodigoOriginal,
			$DatNotaCreditoCompraDetalle->UmeNombre,
			$DatNotaCreditoCompraDetalle->RtiId,
			$DatNotaCreditoCompraDetalle->UmeIdOrigen,
			$DatNotaCreditoCompraDetalle->NodEstado,
			$DatNotaCreditoCompraDetalle->NodCantidadReal);
		
		}
	}
	
}

?>