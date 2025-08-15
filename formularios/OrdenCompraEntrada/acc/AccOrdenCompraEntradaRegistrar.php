<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

	$InsOrdenCompraEntrada->UsuId = $_SESSION['SesionId'];	

	$InsOrdenCompraEntrada->OcoId = $_POST['CmpOrdenCompraId'];

	$InsOrdenCompraEntrada->MonId = $_POST['CmpOrdenCompraMonedaId'];
	$InsOrdenCompraEntrada->OceTipoCambio = $_POST['CmpOrdenCompraTipoCambio'];

	$InsOrdenCompraEntrada->OceFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);

	$InsOrdenCompraEntrada->OceComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsOrdenCompraEntrada->OceComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsOrdenCompraEntrada->OceComprobanteNumero = $InsOrdenCompraEntrada->OceComprobanteNumeroSerie."-".$InsOrdenCompraEntrada->OceComprobanteNumeroNumero;
	$InsOrdenCompraEntrada->OceComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);	

	$InsOrdenCompraEntrada->OceGuiaRemisionNumeroSerie = $_POST['CmpGuiaRemisionNumeroSerie'];	
	$InsOrdenCompraEntrada->OceGuiaRemisionNumeroNumero = $_POST['CmpGuiaRemisionNumeroNumero'];	
	$InsOrdenCompraEntrada->OceGuiaRemisionNumero = $InsOrdenCompraEntrada->OceComprobanteNumeroSerie."-".$InsOrdenCompraEntrada->OceGuiaRemisionNumeroNumero;	
	$InsOrdenCompraEntrada->OceGuiaRemisionFecha = FncCambiaFechaAMysql($_POST['CmpGuiaRemisionFecha'],true);	

	$InsOrdenCompraEntrada->OceTiempoCreacion = date("Y-m-d H:i:s");
	$InsOrdenCompraEntrada->OceTiempoModificacion = date("Y-m-d H:i:s");
	$InsOrdenCompraEntrada->OceEliminado = 1;

	$InsOrdenCompraEntrada->CtiId = $_POST['CmpComprobanteTipo'];	
	$InsOrdenCompraEntrada->TopId = $_POST['CmpTipoOperacion'];	
	$InsOrdenCompraEntrada->OceObservacion = $_POST['CmpObservacion'];
	$InsOrdenCompraEntrada->OceEstado = 1;

	$InsOrdenCompraEntrada->OcePorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
	$InsOrdenCompraEntrada->OceDocumentoOrigen = 1;	
	$InsOrdenCompraEntrada->OceIncluyeImpuesto = 1;	

	$InsOrdenCompraEntrada->PrvId = $_POST['CmpProveedorId'];	
	$InsOrdenCompraEntrada->TdoId = $_POST['CmpProveedorTipoDocumento'];	
	$InsOrdenCompraEntrada->PrvNombre = $_POST['CmpProveedorNombre'];	
	$InsOrdenCompraEntrada->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];	
	
	
	$InsOrdenCompraEntrada->OrdenCompraEntradaDetalle = array();

	$InsOrdenCompraEntrada->OceSubTotal = 0;
	$InsOrdenCompraEntrada->OceImpuesto = 0;
	$InsOrdenCompraEntrada->OceTotal = 0;

			//	SesionObjeto-OrdenCompraEntradaDetalle
			//	Parametro1 = OedId
			//	Parametro2 = ProId
			//	Parametro3 = ProNombre
			//	Parametro4 = OedPrecio
			//	Parametro5 = OedCantidad
			//	Parametro6 = OedImporte
			//	Parametro7 = OedTiempoCreacion
			//	Parametro8 = OedTiempoModificacion
			//	Parametro9 = UmeNombre/UnidadMedidaNombreConvertir
			//	Parametro10 = UmeId/UnidadMedidaConvertir
			//	Parametro11 = OedCantidadReal
			//	Parametro12 = OedCostoAnterior
			//	Parametro13 = OedCodigoOtro
			//	Parametro14 = ProCodigoOriginal
			//	Parametro15 = ProCodigoAlternativo
			//	Parametro16 = PcdId
			//	Parametro17 = OcdId
			//	Parametro18 = OcdSaldo
			
	$RepSesionObjetos = $_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrSesionObjetos = $RepSesionObjetos['Datos'];

	$Items = 1;
	foreach($ArrSesionObjetos as $DatSesionObjeto){
	
		$InsOrdenCompraEntradaDetalle1 = new ClsOrdenCompraEntradaDetalle();
		$InsOrdenCompraEntradaDetalle1->OedId = $DatSesionObjeto->Parametro1;
		$InsOrdenCompraEntradaDetalle1->ProId = $DatSesionObjeto->Parametro2;
		$InsOrdenCompraEntradaDetalle1->UmeId = $DatSesionObjeto->Parametro10;
		
		$InsOrdenCompraEntradaDetalle1->PcdId = $DatSesionObjeto->Parametro16;
		
		$InsOrdenCompraEntradaDetalle1->OedCodigoOtro = $DatSesionObjeto->Parametro13;
		$InsOrdenCompraEntradaDetalle1->OedPrecio = $DatSesionObjeto->Parametro4;
	
		if($InsOrdenCompra->MonId<>$EmpresaMonedaId and !empty($InsOrdenCompra->OcoTipoCambio)){
			$InsOrdenCompraEntradaDetalle1->OedPrecio = $InsOrdenCompraEntradaDetalle1->OedPrecio * $InsOrdenCompra->OcoTipoCambio;
		}else{
			$InsOrdenCompraEntradaDetalle1->OedPrecio = $InsOrdenCompraEntradaDetalle1->OedPrecio;
		}

		$InsOrdenCompraEntradaDetalle1->OedCantidad = preg_replace("/,/", "", $_POST['CmpProductoEntrada_'.$DatSesionObjeto->Parametro16]);					

		$InsOrdenCompraEntradaDetalle1->OedImporte = $InsOrdenCompraEntradaDetalle1->OedCantidad * $InsOrdenCompraEntradaDetalle1->OedPrecio;

//		if($InsOrdenCompra->MonId<>$EmpresaMonedaId and !empty($InsOrdenCompra->OcoTipoCambio)){
//			$InsOrdenCompraEntradaDetalle1->OedImporte = $InsOrdenCompraEntradaDetalle1->OedImporte * $InsOrdenCompra->OcoTipoCambio;
//		}else{
//			$InsOrdenCompraEntradaDetalle1->OedImporte = $InsOrdenCompraEntradaDetalle1->OedImporte;
//		}

		$InsOrdenCompraEntradaDetalle1->ProNombre = $DatSesionObjeto->Parametro3;
		$InsOrdenCompraEntradaDetalle1->UmeNombre = $DatSesionObjeto->Parametro9;
		$InsOrdenCompraEntradaDetalle1->ProCodigoOriginal = $DatSesionObjeto->Parametro14;
		$InsOrdenCompraEntradaDetalle1->ProCodigoAlternativo = $DatSesionObjeto->Parametro15;
		$InsOrdenCompraEntradaDetalle1->PcdId = $DatSesionObjeto->Parametro16;
		$InsOrdenCompraEntradaDetalle1->OcdId = $DatSesionObjeto->Parametro17;
		$InsOrdenCompraEntradaDetalle1->OcdSaldo = $DatSesionObjeto->Parametro18;

		$InsOrdenCompraEntradaDetalle1->OedTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
		$InsOrdenCompraEntradaDetalle1->OedTiempoModificacion = date("Y-m-d H:i:s");

		$InsOrdenCompraEntradaDetalle1->OedEliminado = $DatSesionObjeto->Eliminado;				
		$InsOrdenCompraEntradaDetalle1->InsMysql = NULL;

		$InsOrdenCompraEntradaDetalle1->OedCosto = $InsOrdenCompraEntradaDetalle1->OedPrecio;
//		$InsOrdenCompraEntradaDetalle1->OedCosto= $DatSesionObjeto->Parametro4;
		$InsOrdenCompraEntradaDetalle1->OedCostoAnterior = $DatSesionObjeto->Parametro12;
		$InsOrdenCompraEntradaDetalle1->OedCostoExtraTotal = 0;
		$InsOrdenCompraEntradaDetalle1->OedCostoExtraUnitario = 0;
	
		$InsOrdenCompraEntradaDetalle1->OedValorTotal = $InsOrdenCompraEntradaDetalle1->OedCosto + $InsOrdenCompraEntradaDetalle1->OedCostoExtraUnitario;
	
		$InsOrdenCompraEntradaDetalle1->OedCostoPromedio = round(($InsOrdenCompraEntradaDetalle1->OedValorTotal + $InsOrdenCompraEntradaDetalle1->OedCostoAnterior)/2,3);	
	
		if(!empty($InsOrdenCompraEntradaDetalle1->OedCantidad) and $InsOrdenCompraEntradaDetalle1->OcdSaldo>0){
			$InsOrdenCompraEntrada->OrdenCompraEntradaDetalle[] = $InsOrdenCompraEntradaDetalle1;			
			$InsOrdenCompraEntrada->OceSubTotal += $InsOrdenCompraEntradaDetalle1->OedImporte;
		}

		if($InsOrdenCompraEntradaDetalle1->OedCantidad>$DatSesionObjeto->Parametro5){
			$Guardar = false;
			$Resultado.='#ERR_OCE_601';
			$Resultado.='#Item Numero: '.($Items);
			$InsOrdenCompraEntradaDetalle1->OedCantidad = $DatSesionObjeto->Parametro5;
		}


			$InsProducto->ProId = $InsOrdenCompraEntradaDetalle1->ProId;
			$InsProducto->MtdObtenerProducto(false);
			
			if(!empty($InsOrdenCompraEntradaDetalle1->UmeId)){
			
				$InsUnidadMedida->UmeId = $InsOrdenCompraEntradaDetalle1->UmeId;
				$InsUnidadMedida->MtdObtenerUnidadMedida();
								  
				if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
					$InsUnidadMedidaConversion->UmcEquivalente = 1;
				}else{
					$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
					$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
					  
					foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
						$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
					}
				}

				if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
					$InsOrdenCompraEntradaDetalle1->OedCantidadReal = round($InsOrdenCompraEntradaDetalle1->OedCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
				}else{
					$Guardar = false;
					$Resultado.='#ERR_OCE_703';
					$InsOrdenCompraEntradaDetalle1->OedCantidadReal = '';
				}
			
			}else{
				$Guardar = false;
				$Resultado.='#ERR_OCE_702';
				$InsOrdenCompraEntradaDetalle1->OedCantidadReal = '';
			}
			
			$_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
			$InsOrdenCompraEntradaDetalle1->OedId,
			$InsOrdenCompraEntradaDetalle1->ProId,
			$InsOrdenCompraEntradaDetalle1->ProNombre,
			$InsOrdenCompraEntradaDetalle1->OedPrecio,
			$InsOrdenCompraEntradaDetalle1->OedCantidad,
			$InsOrdenCompraEntradaDetalle1->OedImporte,
			FncCambiaFechaANormal($InsOrdenCompraEntradaDetalle1->OedTiempoCreacion),
			date("d/m/Y H:i:s"),
			$InsOrdenCompraEntradaDetalle1->UmeNombre,
			$InsOrdenCompraEntradaDetalle1->UmeId,
			$InsOrdenCompraEntradaDetalle1->OedCantidadReal,
			NULL,
			$InsOrdenCompraEntradaDetalle1->OedCodigoOtro,
			$InsOrdenCompraEntradaDetalle1->ProCodigoOriginal,
			$InsOrdenCompraEntradaDetalle1->ProCodigoAlternativo,
			$InsOrdenCompraEntradaDetalle1->PcdId,
			$InsOrdenCompraEntradaDetalle1->OcdId,
			$InsOrdenCompraEntradaDetalle1->OcdSaldo
			);
		
		$Items++;
	
	}
	
	if($Guardar){	

		$InsOrdenCompraEntrada->OceImpuesto = round($InsOrdenCompraEntrada->OceSubTotal * ($InsOrdenCompraEntrada->OcePorcentajeImpuestoVenta/100),3);
		$InsOrdenCompraEntrada->OceTotal = $InsOrdenCompraEntrada->OceSubTotal + $InsOrdenCompraEntrada->OceImpuesto;

		if($InsOrdenCompraEntrada->MtdRegistrarOrdenCompraEntrada()){
			
			$InsOrdenCompra->MtdActualizarEstadoOrdenCompra($InsOrdenCompraEntrada->OcoId,4);

			unset($_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador]);
			unset($_SESSION['InsOrdenCompraEntradaPedido'.$Identificador]);
					
			$_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsOrdenCompraEntradaPedido'.$Identificador] = new ClsSesionObjeto();
			
			$InsOrdenCompraEntrada->TopId = "TOP-10001";
			$InsOrdenCompraEntrada->CtiId = "CTI-10000";
	
			$Registro =  true;
			$Resultado.='#SAS_OCE_101';
		} else{
			$InsOrdenCompraEntrada->OceFecha = FncCambiaFechaANormal($InsOrdenCompraEntrada->OceFecha);
			$InsOrdenCompraEntrada->OceComprobanteFecha = FncCambiaFechaANormal($InsOrdenCompraEntrada->OceComprobanteFecha,true);
			$InsOrdenCompraEntrada->OceGuiaRemisionFecha = FncCambiaFechaANormal($InsOrdenCompraEntrada->OceGuiaRemisionFecha,true);
			$Resultado.='#ERR_OCE_101';		
		}

	}

	

}else{
	
	unset($_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador]);
	unset($_SESSION['InsOrdenCompraEntradaPedido'.$Identificador]);
			
	$_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsOrdenCompraEntradaPedido'.$Identificador] = new ClsSesionObjeto();
	
	$InsOrdenCompraEntrada->TopId = "TOP-10001";
	$InsOrdenCompraEntrada->CtiId = "CTI-10000";
	$InsOrdenCompraEntrada->PrvId = $InsOrdenCompra->PrvId;
	$InsOrdenCompraEntrada->PrvNombre = $InsOrdenCompra->PrvNombre;
	$InsOrdenCompraEntrada->TdoId = $InsOrdenCompra->TdoId;
	$InsOrdenCompraEntrada->PrvNumeroDocumento = $InsOrdenCompra->PrvNumeroDocumento;
	
	if(!empty($InsOrdenCompra->OrdenCompraPedido)){
		foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){

			//SesionObjeto-OrdenCompraPedido
			//Parametro1 = PcoId
			//Parametro2 = PcoFecha
			$_SESSION['InsOrdenCompraEntradaPedido'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatOrdenCompraPedido->PcoId,
			$DatOrdenCompraPedido->PcoFecha);
			
		}
	}

	if(!empty($InsOrdenCompra->OrdenCompraDetalle)){
		foreach($InsOrdenCompra->OrdenCompraDetalle as $DatOrdenCompraDetalle){
	
			//	SesionObjeto-OrdenCompraEntradaDetalle
			//	Parametro1 = OedId
			//	Parametro2 = ProId
			//	Parametro3 = ProNombre
			//	Parametro4 = OedPrecio
			//	Parametro5 = OedCantidad
			//	Parametro6 = OedImporte
			//	Parametro7 = OedTiempoCreacion
			//	Parametro8 = OedTiempoModificacion
			//	Parametro9 = UmeNombre/UnidadMedidaNombreConvertir
			//	Parametro10 = UmeId/UnidadMedidaConvertir
			//	Parametro11 = OedCantidadReal
			//	Parametro12 = OedCostoAnterior
			//	Parametro13 = OedCodigoOtro
			//	Parametro14 = ProCodigoOriginal
			//	Parametro15 = ProCodigoAlternativo
			//	Parametro16 = PcdId
			//	Parametro17 = OcdId
			//	Parametro18 = OcdSaldo
		
		
			if($InsOrdenCompra->MonId<>$EmpresaMonedaId and (!empty($InsOrdenCompra->OcoTipoCambio) )){
				$DatOrdenCompraDetalle->OcdPrecio = round($DatOrdenCompraDetalle->OcdPrecio / $InsOrdenCompra->OcoTipoCambio,2);
				$DatOrdenCompraDetalle->OcdImporte = $DatOrdenCompraDetalle->OcdPrecio * $DatOrdenCompraDetalle->OcdSaldo;
			}
			
			
			$_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			$DatOrdenCompraDetalle->ProId,
			$DatOrdenCompraDetalle->ProNombre,
			$DatOrdenCompraDetalle->OcdPrecio,
			$DatOrdenCompraDetalle->OcdCantidad,
			$DatOrdenCompraDetalle->OcdImporte,
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s"),
			$DatOrdenCompraDetalle->UmeNombre,
			$DatOrdenCompraDetalle->UmeId,
			NULL,
			$DatOrdenCompraDetalle->ProCosto,
			$DatOrdenCompraDetalle->OcdCodigoOtro,
			$DatOrdenCompraDetalle->ProCodigoOriginal,
			$DatOrdenCompraDetalle->ProCodigoAlternativo,	
			$DatOrdenCompraDetalle->PcdId,
			$DatOrdenCompraDetalle->OcdId,
			$DatOrdenCompraDetalle->OcdSaldo
			);
		  
		}
	}
	
		
	
	
}
?>