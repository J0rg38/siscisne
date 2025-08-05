<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsAlmacenMovimientoSalida->UsuId = $_SESSION['SesionId'];	
	
	$InsAlmacenMovimientoSalida->MonId = $EmpresaMonedaId;
	
	$InsAlmacenMovimientoSalida->AmoId = $_POST['CmpId'];
	$InsAlmacenMovimientoSalida->SucId = $_SESSION['SesionSucursal'];
	$InsAlmacenMovimientoSalida->SucIdDestino = $_POST['CmpSucursalDestino'];
	$InsAlmacenMovimientoSalida->LtiId = $_POST['CmpClienteTipo'];	
	$InsAlmacenMovimientoSalida->CliId = "CLI-1000";
	
	$InsAlmacenMovimientoSalida->TopId = $_POST['CmpTipoOperacion'];
	$InsAlmacenMovimientoSalida->AlmId = $_POST['CmpAlmacen'];
	
	$InsAlmacenMovimientoSalida->AmoComprobanteNumero = $_POST['CmpComprobanteNumero'];
	$InsAlmacenMovimientoSalida->AmoResponsable = $_POST['CmpResponsable'];
	
	$InsAlmacenMovimientoSalida->AmoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsAlmacenMovimientoSalida->AmoObservacion = addslashes($_POST['CmpObservacion']);
	$InsAlmacenMovimientoSalida->AmoDescuento = 0;
	$InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsAlmacenMovimientoSalida->AmoIncluyeImpuesto = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsAlmacenMovimientoSalida->AmoTipoMovimiento = $_POST['CmpTipoMovimiento'];




	$InsAlmacenMovimientoSalida->AmoSubTipo = 4;
	$InsAlmacenMovimientoSalida->AmoEstado = $_POST['CmpEstado'];
	$InsAlmacenMovimientoSalida->AmoTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle = array();
	
	$InsAlmacenMovimientoSalida->AmoTotal = 0;


	if(empty($InsAlmacenMovimientoSalida->AlmId)){
		$Guardar = false;
		$Resultado.='#ERR_AMO_112';
	}
	
	$ResAlmacenMovimientoSalidaDetalle = $_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

//	SesionObjeto-AlmacenMovimientoSalidaDetalle
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecio
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro18 = AmdCantidadRealAnterior
//	Parametro19 = AmdEstado

	//deb($ResAlmacenMovimientoSalidaDetalle['Datos']);

	if(!empty($ResAlmacenMovimientoSalidaDetalle['Datos'])){
		$item = 1;
		foreach($ResAlmacenMovimientoSalidaDetalle['Datos'] as $DatSesionObjeto){
				
			$InsAlmacenMovimientoSalidaDetalle1 = new ClsAlmacenMovimientoSalidaDetalle();
			
			$InsAlmacenMovimientoSalidaDetalle1->VerificarStock	= 2;
			
			
			$InsAlmacenMovimientoSalidaDetalle1->AmdId = $DatSesionObjeto->Parametro1;
			$InsAlmacenMovimientoSalidaDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsAlmacenMovimientoSalidaDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			$InsAlmacenMovimientoSalidaDetalle1->AmdPrecioVenta = $DatSesionObjeto->Parametro4;
			$InsAlmacenMovimientoSalidaDetalle1->AmdCosto = $DatSesionObjeto->Parametro17;
			$InsAlmacenMovimientoSalidaDetalle1->AmdCostoExtraTotal = 0;
			$InsAlmacenMovimientoSalidaDetalle1->AmdCantidad = $DatSesionObjeto->Parametro5;
			$InsAlmacenMovimientoSalidaDetalle1->AmdCantidadReal = $DatSesionObjeto->Parametro12;
			$InsAlmacenMovimientoSalidaDetalle1->AmdCantidadRealAnterior = $DatSesionObjeto->Parametro18;
			$InsAlmacenMovimientoSalidaDetalle1->AmdEstado = $DatSesionObjeto->Parametro19;
			$InsAlmacenMovimientoSalidaDetalle1->AmdImporte = $DatSesionObjeto->Parametro6;
			$InsAlmacenMovimientoSalidaDetalle1->AmdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsAlmacenMovimientoSalidaDetalle1->AmdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsAlmacenMovimientoSalidaDetalle1->AmdValorTotal = 0;
			$InsAlmacenMovimientoSalidaDetalle1->AmdUtilidad = 0;
			
			$InsAlmacenMovimientoSalidaDetalle1->AlmId = $InsAlmacenMovimientoSalida->AlmId;
			$InsAlmacenMovimientoSalidaDetalle1->AmdFecha = $InsAlmacenMovimientoSalida->AmoFecha;

			$InsAlmacenMovimientoSalidaDetalle1->AmdEliminado = $DatSesionObjeto->Eliminado;				
			$InsAlmacenMovimientoSalidaDetalle1->InsMysql = NULL;

			$InsProducto->ProId = $InsAlmacenMovimientoSalidaDetalle1->ProId;
			$InsProducto->MtdObtenerProducto(false);

			$InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle[] = $InsAlmacenMovimientoSalidaDetalle1;

			if($InsAlmacenMovimientoSalidaDetalle1->AmdEliminado==1){
				
//				$InsProducto = new ClsProducto();
//				$InsProducto->ProId = $InsAlmacenMovimientoSalidaDetalle1->ProId;
//				$InsProducto->MtdObtenerProducto(false);
				
//				if($InsProducto->ProStockReal < $InsAlmacenMovimientoSalidaDetalle1->AmdCantidadReal){
//					$InsAlmacenMovimientoSalidaDetalle1->VerificarStock = 1;
//				}
//				
//				if($InsAlmacenMovimientoSalidaDetalle1->VerificarStock == 1 and $InsAlmacenMovimientoSalida->AmoEstado <> 1 and $InsAlmacenMovimientoSalidaDetalle1->AmdEliminado == 1){
//					$Guardar = false;
//					$Resultado.='#ERR_AMO_501';
//					$Resultado.='#Item Numero: '.($item);
//				}
				
				$InsAlmacenMovimientoSalida->AmoTotalBruto += $InsAlmacenMovimientoSalidaDetalle1->AmdImporte;
			}	
			
					
		}		
	}else{
		$Guardar = false;
		$Resultado.='#ERR_AMO_111';
	}	

	//$InsAlmacenMovimientoSalida->AmoTotal = $InsAlmacenMovimientoSalida->AmoTotal - $InsAlmacenMovimientoSalida->AmoDescuento;
	
	if($InsAlmacenMovimientoSalida->AmoIncluyeImpuesto == 2){

		$InsAlmacenMovimientoSalida->AmoSubTotal = $InsAlmacenMovimientoSalida->AmoTotalBruto - $InsAlmacenMovimientoSalida->AmoDescuento;
		$InsAlmacenMovimientoSalida->AmoImpuesto = ($InsAlmacenMovimientoSalida->AmoSubTotal  * ($InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta/100) );
		$InsAlmacenMovimientoSalida->AmoTotal = $InsAlmacenMovimientoSalida->AmoSubTotal + $InsAlmacenMovimientoSalida->AmoImpuesto;

	}else{

		$InsAlmacenMovimientoSalida->AmoTotal = $InsAlmacenMovimientoSalida->AmoTotalBruto - $InsAlmacenMovimientoSalida->AmoDescuento;
		$InsAlmacenMovimientoSalida->AmoSubTotal = $InsAlmacenMovimientoSalida->AmoTotal / (($InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta/100)+1);
		$InsAlmacenMovimientoSalida->AmoImpuesto = $InsAlmacenMovimientoSalida->AmoTotal - $InsAlmacenMovimientoSalida->AmoSubTotal;

	}
	
	
	if($Guardar){
		if($InsAlmacenMovimientoSalida->MtdEditarAlmacenMovimientoSalida()){		
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_AMO_102';
		} else{
			$InsAlmacenMovimientoSalida->AmoFecha = FncCambiaFechaANormal($InsAlmacenMovimientoSalida->AmoFecha);
			$Resultado.='#ERR_AMO_102';
		}	
	}else{
		$InsAlmacenMovimientoSalida->AmoFecha = FncCambiaFechaANormal($InsAlmacenMovimientoSalida->AmoFecha);
	}
	
	//if(!empty($InsAlmacenMovimientoSalida->TpeId)){
//		FncCargarTallerPedidoDatos();		
//	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsAlmacenMovimientoSalida;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador]);
	unset($_SESSION['SesAmoFoto'.$Identificador]);

	$_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsAlmacenMovimientoSalida->AmoId = $GET_id;
	$InsAlmacenMovimientoSalida = $InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalida();		
	
//	deb($InsAlmacenMovimientoSalida);

	$_SESSION['SesAmoFoto'.$Identificador] = $InsAlmacenMovimientoSalida->AmoFoto;

	if(!empty($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle)){
		foreach($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle as $DatAlmacenMovimientoSalidaDetalle){

		$VerificarStock = 2;
	
//	SesionObjeto-AlmacenMovimientoSalidaDetalle
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecio
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro18 = AmdCantidadRealAnterior
//  Parametro19 = AmdEstado
//	
			$InsProducto = new ClsProducto();
			$InsProducto->ProId = $DatAlmacenMovimientoSalidaDetalle->ProId;
			$InsProducto->MtdObtenerProducto(false);
			
//			deb($InsProducto->ProStock."":);
			
			
			//if($InsProducto->ProStockReal < $DatAlmacenMovimientoSalidaDetalle->AmdCantidadReal){
			//	$VerificarStock = 1;
			//}
				
			$_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatAlmacenMovimientoSalidaDetalle->AmdId,
			$DatAlmacenMovimientoSalidaDetalle->ProId,
			$DatAlmacenMovimientoSalidaDetalle->ProNombre,
			$DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta,
			$DatAlmacenMovimientoSalidaDetalle->AmdCantidad,
			$DatAlmacenMovimientoSalidaDetalle->AmdImporte,
			($DatAlmacenMovimientoSalidaDetalle->AmdTiempoCreacion),
			($DatAlmacenMovimientoSalidaDetalle->AmdTiempoModificacion),
			$DatAlmacenMovimientoSalidaDetalle->UmeNombre,
			$DatAlmacenMovimientoSalidaDetalle->UmeId,
			$DatAlmacenMovimientoSalidaDetalle->RtiId,
			$DatAlmacenMovimientoSalidaDetalle->AmdCantidadReal,
			$DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal,
			$DatAlmacenMovimientoSalidaDetalle->ProCodigoAlternativo,
			$DatAlmacenMovimientoSalidaDetalle->UmeIdOrigen,
			$VerificarStock,
			$DatAlmacenMovimientoSalidaDetalle->AmdCosto,
			$DatAlmacenMovimientoSalidaDetalle->AmdCantidadReal,
			$DatAlmacenMovimientoSalidaDetalle->AmdEstado
			);
		
		}
	}
	
	

	
}



//
//
//
//function FncCargarTallerPedidoDatos(){
//	
//	global $GET_TpeId;
//	global $Identificador;
//	global $InsTallerPedido;
//	global $InsFichaIngreso;
//	
//	unset($_SESSION['InsTallerPedidoDetalle'.$Identificador]);
//
//	$_SESSION['InsTallerPedidoDetalle'.$Identificador] = new ClsSesionObjeto();
//	
//	
//	$InsTallerPedido = new ClsTallerPedido();		
//	$InsTallerPedido->TpeId = $GET_TpeId;
//	$InsTallerPedido->MtdObtenerTallerPedido();
//	
//	if(!empty($InsTallerPedido->TallerPedidoDetalle)){
//		foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
//	
//			$_SESSION['InsTallerPedidoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//			$DatTallerPedidoDetalle->TpdId,
//			$DatTallerPedidoDetalle->ProId,
//			$DatTallerPedidoDetalle->ProNombre,
//			NULL,
//			$DatTallerPedidoDetalle->TpdCantidad,
//			NULL,
//			($DatTallerPedidoDetalle->TpdTiempoCreacion),
//			($DatTallerPedidoDetalle->TpdTiempoModificacion),
//			$DatTallerPedidoDetalle->UmeNombre,
//			$DatTallerPedidoDetalle->UmeId,
//			$DatTallerPedidoDetalle->RtiId,
//			$DatTallerPedidoDetalle->TpdCantidadReal,
//			$DatTallerPedidoDetalle->ProCodigoOriginal,
//			$DatTallerPedidoDetalle->ProCodigoAlternativo,
//			$DatTallerPedidoDetalle->UmeIdOrigen
//			);
//		
//		}
//	}
//	
//			
//	$InsFichaIngreso = new ClsFichaIngreso();
//	$InsFichaIngreso->FinId = $InsTallerPedido->FinId;
//	$InsFichaIngreso->MtdObtenerFichaIngreso();
//}
?>