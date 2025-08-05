<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsTrasladoProducto->UsuId = $_SESSION['SesionId'];	
	
	//$InsTrasladoProducto->MonId = $EmpresaMonedaId;
	
	$InsTrasladoProducto->TptId = $_POST['CmpId'];
	$InsTrasladoProducto->SucId =  $_POST['CmpSucursal'];
	$InsTrasladoProducto->SucIdDestino = $_POST['CmpSucursalDestino'];
	
	
	$InsTrasladoProducto->CliId =  $_POST['CmpClienteId'];	
	$InsTrasladoProducto->PrvId =  $_POST['CmpProveedorId'];	

	$InsTrasladoProducto->AlmId = $_POST['CmpAlmacen'];
	$InsTrasladoProducto->AlmIdDestino = $_POST['CmpAlmacenDestino'];
	
	$InsTrasladoProducto->PerId = $_POST['CmpPersonal'];
	$InsTrasladoProducto->CliId = $_POST['CmpClienteId'];
	$InsTrasladoProducto->PrvId = $_POST['CmpProveedorId'];
	$InsTrasladoProducto->MonId = $_POST['CmpMonedaId'];
	$InsTrasladoProducto->CtiId = $_POST['CmpComprobanteTipo'];
	$InsTrasladoProducto->TopId = $_POST['CmpTipoOperacion'];
	$InsTrasladoProducto->TptIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsTrasladoProducto->TptPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	
	
	$InsTrasladoProducto->TptReferenciaSerie = $_POST['CmpReferenciaSerie'];
	$InsTrasladoProducto->TptReferenciaNumero = $_POST['CmpTransferenciaNumero'];
	$InsTrasladoProducto->TptReferencia = $InsTrasladoProducto->TptReferenciaSerie."-".$InsTrasladoProducto->TptReferenciaNumero;
	$InsTrasladoProducto->TptResponsable = $_POST['CmpResponsable'];
	
	$InsTrasladoProducto->TptFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsTrasladoProducto->TptFechaLlegada = FncCambiaFechaAMysql($_POST['CmpFechaLlegada']);
	
	$InsTrasladoProducto->TptObservacion = addslashes($_POST['CmpObservacion']);
	$InsTrasladoProducto->TptObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);	
	
	$InsTrasladoProducto->TptPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsTrasladoProducto->TptIncluyeImpuesto = $_POST['CmpPorcentajeImpuestoVenta'];

$InsTrasladoProducto->TptFoto = $_SESSION['SesTptFoto'.$Identificador];

	$InsTrasladoProducto->TptEstado = $_POST['CmpEstado'];
	$InsTrasladoProducto->TptTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsTrasladoProducto->TptSubTotal = 0;
	$InsTrasladoProducto->TptImpuesto = 0;
	$InsTrasladoProducto->TptTotal = 0;
	
	$InsTrasladoProducto->TrasladoProductoDetalle = array();
	
	if(empty($InsTrasladoProducto->SucId)){
		$Guardar = false;
		$Resultado.='#ERR_TPT_112';
	}
	
	if(empty($InsTrasladoProducto->SucIdDestino)){
		$Guardar = false;
		$Resultado.='#ERR_TPT_113';
	}
	
	$ResTrasladoProductoDetalle = $_SESSION['InsTrasladoProductoDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

//	SesionObjeto-TrasladoProductoDetalle
//	Parametro1 = TpdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = TpdPrecio
//	Parametro5 = TpdCantidad
//	Parametro6 = TpdImporte
//	Parametro7 = TpdTiempoCreacion
//	Parametro8 = TpdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = TpdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro18 = TpdCantidadRealAnterior
//	Parametro19 = TpdEstado

	//deb($ResTrasladoProductoDetalle['Datos']);

	if(!empty($ResTrasladoProductoDetalle['Datos'])){
		$item = 1;
		foreach($ResTrasladoProductoDetalle['Datos'] as $DatSesionObjeto){
				
			$InsTrasladoProductoDetalle1 = new ClsTrasladoProductoDetalle();
			$InsTrasladoProductoDetalle1->TpdId = $DatSesionObjeto->Parametro1;
			$InsTrasladoProductoDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsTrasladoProductoDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			
			$InsTrasladoProductoDetalle1->TpdCosto = $DatSesionObjeto->Parametro17;
			$InsTrasladoProductoDetalle1->TpdCantidad = $DatSesionObjeto->Parametro5;
			$InsTrasladoProductoDetalle1->TpdCantidadReal = $DatSesionObjeto->Parametro12;
			$InsTrasladoProductoDetalle1->TpdImporte = $DatSesionObjeto->Parametro6;
		
			$InsTrasladoProductoDetalle1->TpdEstado = $DatSesionObjeto->Parametro19;
			$InsTrasladoProductoDetalle1->TpdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsTrasladoProductoDetalle1->TpdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsTrasladoProductoDetalle1->TpdEliminado = $DatSesionObjeto->Eliminado;				
			$InsTrasladoProductoDetalle1->InsMysql = NULL;

			$InsProducto->ProId = $InsTrasladoProductoDetalle1->ProId;
			$InsProducto->MtdObtenerProducto(false);

			$InsTrasladoProducto->TrasladoProductoDetalle[] = $InsTrasladoProductoDetalle1;

			if($InsTrasladoProductoDetalle1->TpdEliminado==1){
				
			}	
			
		}		
	}else{
		$Guardar = false;
		$Resultado.='#ERR_TPT_111';
	}	

	//$InsTrasladoProducto->TptTotal = $InsTrasladoProducto->TptTotal - $InsTrasladoProducto->TptDescuento;
	
	if($InsTrasladoProducto->TptIncluyeImpuesto == 2){

		$InsTrasladoProducto->TptSubTotal = $InsTrasladoProducto->TptTotalBruto - $InsTrasladoProducto->TptDescuento;
		$InsTrasladoProducto->TptImpuesto = ($InsTrasladoProducto->TptSubTotal  * ($InsTrasladoProducto->TptPorcentajeImpuestoVenta/100) );
		$InsTrasladoProducto->TptTotal = $InsTrasladoProducto->TptSubTotal + $InsTrasladoProducto->TptImpuesto;

	}else{

		$InsTrasladoProducto->TptTotal = $InsTrasladoProducto->TptTotalBruto - $InsTrasladoProducto->TptDescuento;
		$InsTrasladoProducto->TptSubTotal = $InsTrasladoProducto->TptTotal / (($InsTrasladoProducto->TptPorcentajeImpuestoVenta/100)+1);
		$InsTrasladoProducto->TptImpuesto = $InsTrasladoProducto->TptTotal - $InsTrasladoProducto->TptSubTotal;

	}
	
	
	if($Guardar){
		if($InsTrasladoProducto->MtdEditarTrasladoProducto()){		
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_TPT_102';
		} else{
			$InsTrasladoProducto->TptFecha = FncCambiaFechaANormal($InsTrasladoProducto->TptFecha);
			$InsTrasladoProducto->TptFechaLlegada = FncCambiaFechaANormal($InsTrasladoProducto->TptFechaLlegada);
			$Resultado.='#ERR_TPT_102';
		}	
	}else{
		$InsTrasladoProducto->TptFecha = FncCambiaFechaANormal($InsTrasladoProducto->TptFecha);
		$InsTrasladoProducto->TptFechaLlegada = FncCambiaFechaANormal($InsTrasladoProducto->TptFechaLlegada);
	}
	
	//if(!empty($InsTrasladoProducto->TpeId)){
//		FncCargarTallerPedidoDatos();		
//	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsTrasladoProducto;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsTrasladoProductoDetalle'.$Identificador]);
	unset($_SESSION['SesTptFoto'.$Identificador]);

	$_SESSION['InsTrasladoProductoDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsTrasladoProducto->TptId = $GET_id;
	$InsTrasladoProducto = $InsTrasladoProducto->MtdObtenerTrasladoProducto();		
	
//	deb($InsTrasladoProducto);

	$_SESSION['SesTptFoto'.$Identificador] = $InsTrasladoProducto->TptFoto;

	if(!empty($InsTrasladoProducto->TrasladoProductoDetalle)){
		foreach($InsTrasladoProducto->TrasladoProductoDetalle as $DatTrasladoProductoDetalle){

		$VerificarStock = 2;
	
//	SesionObjeto-TrasladoProductoDetalle
//	Parametro1 = TpdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = TpdPrecio
//	Parametro5 = TpdCantidad
//	Parametro6 = TpdImporte
//	Parametro7 = TpdTiempoCreacion
//	Parametro8 = TpdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = TpdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro18 = TpdCantidadRealAnterior
//  Parametro19 = TpdEstado
//	
			$InsProducto = new ClsProducto();
			$InsProducto->ProId = $DatTrasladoProductoDetalle->ProId;
			$InsProducto->MtdObtenerProducto(false);
			
//			deb($InsProducto->ProStock."":);
			
			
			//if($InsProducto->ProStockReal < $DatTrasladoProductoDetalle->TpdCantidadReal){
			//	$VerificarStock = 1;
			//}
				
			$_SESSION['InsTrasladoProductoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatTrasladoProductoDetalle->TpdId,
			$DatTrasladoProductoDetalle->ProId,
			$DatTrasladoProductoDetalle->ProNombre,
			$DatTrasladoProductoDetalle->TpdPrecioVenta,
			$DatTrasladoProductoDetalle->TpdCantidad,
			$DatTrasladoProductoDetalle->TpdImporte,
			($DatTrasladoProductoDetalle->TpdTiempoCreacion),
			($DatTrasladoProductoDetalle->TpdTiempoModificacion),
			$DatTrasladoProductoDetalle->UmeNombre,
			$DatTrasladoProductoDetalle->UmeId,
			$DatTrasladoProductoDetalle->RtiId,
			$DatTrasladoProductoDetalle->TpdCantidadReal,
			$DatTrasladoProductoDetalle->ProCodigoOriginal,
			$DatTrasladoProductoDetalle->ProCodigoAlternativo,
			$DatTrasladoProductoDetalle->UmeIdOrigen,
			$VerificarStock,
			$DatTrasladoProductoDetalle->TpdCosto,
			$DatTrasladoProductoDetalle->TpdCantidadReal,
			$DatTrasladoProductoDetalle->TpdEstado
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