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
	$InsNotaCreditoCompra->TopId = "TOP-10005";
	$InsNotaCreditoCompra->CtiId = "CTI-10008";
	
	$InsNotaCreditoCompra->NccComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsNotaCreditoCompra->NccComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsNotaCreditoCompra->NccComprobanteNumero = $InsNotaCreditoCompra->NccComprobanteNumeroSerie."-".$InsNotaCreditoCompra->NccComprobanteNumeroNumero;
	$InsNotaCreditoCompra->NccComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],false);
	
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

	$InsNotaCreditoCompra->AmoComprobanteNumero = $_POST['CmpAlmacenMovimientoEntradaComprobanteNumero'];
	$InsNotaCreditoCompra->AmoComprobanteFecha = $_POST['CmpAlmacenMovimientoEntradaComprobanteFecha'];
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
//Parametro17 = NodCantidadReal

	$InsNotaCreditoCompra->NccTotalBruto = 0;
	$InsNotaCreditoCompra->NccSubTotal = 0;
	$InsNotaCreditoCompra->NccImpuesto = 0;
	$InsNotaCreditoCompra->NccTotal = 0;

	$ResNotaCreditoCompraDetalle = $_SESSION['InsNotaCreditoCompraDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);//OJO

	if(!empty($ResNotaCreditoCompraDetalle['Datos'])){	
		foreach($ResNotaCreditoCompraDetalle['Datos'] as $DatSesionObjeto){
						
		$InsNotaCreditoCompraDetalle1 = new ClsNotaCreditoCompraDetalle();
			$InsNotaCreditoCompraDetalle1->NodId = $DatSesionObjeto->Parametro1;	
			$InsNotaCreditoCompraDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsNotaCreditoCompraDetalle1->UmeId = $DatSesionObjeto->Parametro3;

			$InsNotaCreditoCompraDetalle1->NodPrecio = $DatSesionObjeto->Parametro4;

			if($InsNotaCreditoCompra->MonId<>$EmpresaMonedaId and !empty($InsNotaCreditoCompra->NccTipoCambio)){
				$InsNotaCreditoCompraDetalle1->NodPrecio = $DatSesionObjeto->Parametro4 * $InsNotaCreditoCompra->NccTipoCambio;
			}else{
				$InsNotaCreditoCompraDetalle1->NodPrecio = $DatSesionObjeto->Parametro4;
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

	}else if($InsNotaCreditoCompra->NccEstado <> 6){
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

	if(!empty($InsNotaCreditoCompra->AmoId)){
		
		$ArrAlmacenMovimientoEntrada = $InsNotaCreditoCompra->MtdVerificarExisteNotaCreditoCompra("AmoIdOrigen",$InsNotaCreditoCompra->AmoIdOrigen);		
	
		if(!empty($ArrAlmacenMovimientoEntrada)){
			$Guardar = false;
			$Resultado .= "#ERR_NCC_604";	
		}
			
	}
	
	if($Guardar){
		
		if($InsNotaCreditoCompra->MtdRegistrarNotaCreditoCompra()){	

			switch($GET_ori){

				case "AlmacenMovimientoEntrada":

//					if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsNotaCreditoCompra->FinId,9)){
//						//$Resultado .= "#SAS_FCC_106";
//					}else{
//						//$Resultado .= "#ERR_FCC_106";
//					}

				break;
				
			}
	
			$Registro = true;		
			$Resultado.='#SAS_NCC_101';
		} else{
			$Resultado.='#ERR_NCC_101';
		}
	}
	
	$InsNotaCreditoCompra->NccFechaEmision = FncCambiaFechaANormal($InsNotaCreditoCompra->NccFechaEmision);
	list($InsNotaCreditoCompra->NccObservacion,$InsNotaCreditoCompra->NccObservacionImpresa) = explode("###",$InsNotaCreditoCompra->NccObservacion);
	
}else{

	unset($_SESSION['InsNotaCreditoCompraDetalle'.$Identificador]);	
	unset($_SESSION['SesNccFoto'.$Identificador]);
	
	$_SESSION['InsNotaCreditoCompraDetalle'.$Identificador] = new ClsSesionObjeto();

	$InsNotaCreditoCompra->NccFechaEmision = date("d/m/Y");	

	switch($GET_ori){

		case "AlmacenMovimientoEntrada":		

			if(!empty($GET_AmoId)){
				FncCargarAlmacenMovimientoEntradaDatos();				
			}

		break;

	}

}





function FncCargarAlmacenMovimientoEntradaDatos(){
	
	global $GET_AmoId;
	global $Identificador;
	global $InsAlmacenMovimientoEntrada;
	global $InsNotaCreditoCompra;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;

	$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();

	$InsAlmacenMovimientoEntrada->AmoId = $GET_AmoId;
	$InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntrada();	
	
	$InsNotaCreditoCompra->AmoIdOrigen = $InsAlmacenMovimientoEntrada->AmoId;
	
	$InsNotaCreditoCompra->AlmId = $InsAlmacenMovimientoEntrada->AlmId;

	$InsNotaCreditoCompra->PrvId = $InsAlmacenMovimientoEntrada->PrvId;		
	$InsNotaCreditoCompra->PrvNombre = $InsAlmacenMovimientoEntrada->PrvNombre;
	$InsNotaCreditoCompra->PrvApellidoPaterno = $InsAlmacenMovimientoEntrada->PrvApellidoPaterno;
	$InsNotaCreditoCompra->PrvApellidoMaterno = $InsAlmacenMovimientoEntrada->PrvApellidoMaterno;
	$InsNotaCreditoCompra->PrvDireccion = $InsAlmacenMovimientoEntrada->PrvDireccion;
	
	$InsNotaCreditoCompra->NccTipoCambio = (!empty($InsAlmacenMovimientoEntrada->AmoTipoCambio)?$InsAlmacenMovimientoEntrada->AmoTipoCambio:NULL);
	$InsNotaCreditoCompra->TdoId = $InsAlmacenMovimientoEntrada->TdoId;
	$InsNotaCreditoCompra->PrvNumeroDocumento = $InsAlmacenMovimientoEntrada->PrvNumeroDocumento;
	
	$InsNotaCreditoCompra->NccDireccion = $InsAlmacenMovimientoEntrada->PrvDireccion." - ".$InsAlmacenMovimientoEntrada->PrvDistrito." - ".$InsAlmacenMovimientoEntrada->PrvProvincia." - ".$InsAlmacenMovimientoEntrada->PrvDepartamento;
	
	$InsNotaCreditoCompra->NccTelefono = $InsAlmacenMovimientoEntrada->PrvTelefono;	
	$InsNotaCreditoCompra->NccIncluyeImpuesto = $InsAlmacenMovimientoEntrada->AmoIncluyeImpuesto;	
	$InsNotaCreditoCompra->NccEstado = 3;

	$InsNotaCreditoCompra->NccObservacion = $InsAlmacenMovimientoEntrada->AmoObservacion.chr(13).date("d/m/Y H:i:s")." - Nota de Credito autogenerada de Mov. Alm.:".$InsNotaCreditoCompra->AmoId." / Num. Comprob.:".$InsNotaCreditoCompra->AmoNumeroComprobante;
	
	$InsNotaCreditoCompra->MonId = $InsAlmacenMovimientoEntrada->MonId;		
	$InsNotaCreditoCompra->NccPorcentajeImpuestoVenta = $InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta;
	
	$InsNotaCreditoCompra->AmoComprobanteNumeroOrigen = $InsAlmacenMovimientoEntrada->AmoComprobanteNumero;
	$InsNotaCreditoCompra->AmoComprobanteFechaOrigen = $InsAlmacenMovimientoEntrada->AmoComprobanteFecha;
	
	//deb($InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle);
	
	if(!empty($InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle)){
		foreach($InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle as $DatAlmacenMovimientoEntradaDetalle){

		if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
			
			$DatAlmacenMovimientoEntradaDetalle->AmdCosto = round($DatAlmacenMovimientoEntradaDetalle->AmdCosto  / $InsAlmacenMovimientoEntrada->AmoTipoCambio,2);
			$DatAlmacenMovimientoEntradaDetalle->AmdImporte = round($DatAlmacenMovimientoEntradaDetalle->AmdImporte  / $InsAlmacenMovimientoEntrada->AmoTipoCambio,2);
			
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
//Parametro17 = NodCantidadReal


					$_SESSION['InsNotaCreditoCompraDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatAlmacenMovimientoEntradaDetalle->ProId,
					$DatAlmacenMovimientoEntradaDetalle->UmeId,
					$DatAlmacenMovimientoEntradaDetalle->AmdCosto,
					$DatAlmacenMovimientoEntradaDetalle->AmdCantidad,
					$DatAlmacenMovimientoEntradaDetalle->AmdImporte,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					$DatAlmacenMovimientoEntradaDetalle->AmdId,
					$DatAlmacenMovimientoEntradaDetalle->AmoId,
					$DatAlmacenMovimientoEntradaDetalle->ProNombre,
					$DatAlmacenMovimientoEntradaDetalle->ProCodigoOriginal,
					$DatAlmacenMovimientoEntradaDetalle->UmeAbreviacion,
					$DatAlmacenMovimientoEntradaDetalle->RtiId,
					$DatAlmacenMovimientoEntradaDetalle->UmeIdOrigen,
					3,
					$DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal
					);


		}
	}
	


	
}

?>