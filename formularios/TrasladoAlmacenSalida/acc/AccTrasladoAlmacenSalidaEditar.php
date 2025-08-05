<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsTrasladoAlmacenSalida->UsuId = $_SESSION['SesionId'];	
	
	$InsTrasladoAlmacenSalida->TasId = $_POST['CmpId'];
	$InsTrasladoAlmacenSalida->LtiId = $_POST['CmpClienteTipo'];
	$InsTrasladoAlmacenSalida->CliId = $_POST['CmpClienteId'];
	
	$InsTrasladoAlmacenSalida->TopId = $_POST['CmpTipoOperacion'];
	$InsTrasladoAlmacenSalida->AlmId = $_POST['CmpAlmacen'];
	$InsTrasladoAlmacenSalida->AlmIdDestino = $_POST['CmpAlmacenDestino'];
	
	$InsTrasladoAlmacenSalida->MonId = $EmpresaMonedaId;
	$InsTrasladoAlmacenSalida->PerId = $_POST['CmpPersonal'];
	
	$InsTrasladoAlmacenSalida->TasFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsTrasladoAlmacenSalida->TasObservacion = addslashes($_POST['CmpObservacion']);


	$InsTrasladoAlmacenSalida->TasEmpresaTransporte = $_POST['CmpEmpresaTransporte'];
	$InsTrasladoAlmacenSalida->TasEmpresaTransporteDocumento = $_POST['CmpEmpresaTransporteDocumento'];
	$InsTrasladoAlmacenSalida->TasEmpresaTransporteClave = $_POST['CmpEmpresaTransporteClave'];
	$InsTrasladoAlmacenSalida->TasEmpresaTransporteFecha = FncCambiaFechaAMysql($_POST['CmpEmpresaTransporteFecha'],true);
	$InsTrasladoAlmacenSalida->TasEmpresaTransporteTipoEnvio = $_POST['CmpEmpresaTransporteTipoEnvio'];
	$InsTrasladoAlmacenSalida->TasEmpresaTransporteDestino = $_POST['CmpEmpresaTransporteDestino'];

	$InsTrasladoAlmacenSalida->TasSubTipo = 8;
	$InsTrasladoAlmacenSalida->TasEstado = $_POST['CmpEstado'];
	$InsTrasladoAlmacenSalida->TasTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsTrasladoAlmacenSalida->TrasladoAlmacenSalidaDetalle = array();


	if(empty($InsTrasladoAlmacenSalida->AlmId)){
		$Guardar = false;
		$Resultado.='#ERR_TAS_112';
	}
	
	$ResTrasladoAlmacenSalidaDetalle = $_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

//	SesionObjeto-TrasladoAlmacenSalidaDetalle
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
//	Parametro17 = AmdCosto
//	Parametro18 = AmdCantidadRealAnterior
//	Parametro19 = AmdEstado

	//deb($ResTrasladoAlmacenSalidaDetalle['Datos']);

	if(!empty($ResTrasladoAlmacenSalidaDetalle['Datos'])){
		$item = 1;
		foreach($ResTrasladoAlmacenSalidaDetalle['Datos'] as $DatSesionObjeto){
				
			$InsTrasladoAlmacenSalidaDetalle1 = new ClsTrasladoAlmacenSalidaDetalle();
			
			$InsTrasladoAlmacenSalidaDetalle1->VerificarStock	= 2;
			
			$InsTrasladoAlmacenSalidaDetalle1->TsdId = $DatSesionObjeto->Parametro1;
			$InsTrasladoAlmacenSalidaDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsTrasladoAlmacenSalidaDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			
			$InsTrasladoAlmacenSalidaDetalle1->TsdCantidad = $DatSesionObjeto->Parametro5;
			$InsTrasladoAlmacenSalidaDetalle1->TsdCantidadReal = $DatSesionObjeto->Parametro12;
			$InsTrasladoAlmacenSalidaDetalle1->TsdCantidadRealAnterior = $DatSesionObjeto->Parametro18;
	
			$InsTrasladoAlmacenSalidaDetalle1->TsdEstado = $DatSesionObjeto->Parametro19;
			$InsTrasladoAlmacenSalidaDetalle1->TsdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsTrasladoAlmacenSalidaDetalle1->TsdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
		
			$InsTrasladoAlmacenSalidaDetalle1->TsdEliminado = $DatSesionObjeto->Eliminado;				
			$InsTrasladoAlmacenSalidaDetalle1->InsMysql = NULL;

			$InsProducto->ProId = $InsTrasladoAlmacenSalidaDetalle1->ProId;
			$InsProducto->MtdObtenerProducto(false);

			$InsTrasladoAlmacenSalida->TrasladoAlmacenSalidaDetalle[] = $InsTrasladoAlmacenSalidaDetalle1;

			if($InsTrasladoAlmacenSalidaDetalle1->TsdEliminado==1){
				
			}	
			
					
		}		
	}else{
		$Guardar = false;
		$Resultado.='#ERR_TAS_111';
	}	

	if($Guardar){
		if($InsTrasladoAlmacenSalida->MtdEditarTrasladoAlmacenSalida()){		
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_TAS_102';
		} else{
			$InsTrasladoAlmacenSalida->TasFecha = FncCambiaFechaANormal($InsTrasladoAlmacenSalida->TasFecha);
			$Resultado.='#ERR_TAS_102';
		}	
	}else{
		$InsTrasladoAlmacenSalida->TasFecha = FncCambiaFechaANormal($InsTrasladoAlmacenSalida->TasFecha);
	}
	
	//if(!empty($InsTrasladoAlmacenSalida->TpeId)){
//		FncCargarTallerPedidoDatos();		
//	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsTrasladoAlmacenSalida;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador]);
	unset($_SESSION['SesTasFoto'.$Identificador]);

	$_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsTrasladoAlmacenSalida->TasId = $GET_id;
	$InsTrasladoAlmacenSalida = $InsTrasladoAlmacenSalida->MtdObtenerTrasladoAlmacenSalida();		
	
//	deb($InsTrasladoAlmacenSalida);

	$_SESSION['SesTasFoto'.$Identificador] = $InsTrasladoAlmacenSalida->TasFoto;

	if(!empty($InsTrasladoAlmacenSalida->TrasladoAlmacenSalidaDetalle)){
		foreach($InsTrasladoAlmacenSalida->TrasladoAlmacenSalidaDetalle as $DatTrasladoAlmacenSalidaDetalle){

		$VerificarStock = 2;
	
//	
//	SesionObjeto-TrasladoAlmacenSalidaDetalle
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
//	Parametro17 = AmdCosto
//	Parametro18 = AmdCantidadRealAnterior
//	Parametro19 = AmdEstado
			$InsProducto = new ClsProducto();
			$InsProducto->ProId = $DatTrasladoAlmacenSalidaDetalle->ProId;
			$InsProducto->MtdObtenerProducto(false);
			
//			deb($InsProducto->ProStock."":);
			
			
			//if($InsProducto->ProStockReal < $DatTrasladoAlmacenSalidaDetalle->TsdCantidadReal){
			//	$VerificarStock = 1;
			//}
				
			$_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatTrasladoAlmacenSalidaDetalle->TsdId,
			$DatTrasladoAlmacenSalidaDetalle->ProId,
			$DatTrasladoAlmacenSalidaDetalle->ProNombre,
			$DatTrasladoAlmacenSalidaDetalle->TsdPrecioVenta,
			$DatTrasladoAlmacenSalidaDetalle->TsdCantidad,
			$DatTrasladoAlmacenSalidaDetalle->TsdImporte,
			($DatTrasladoAlmacenSalidaDetalle->TsdTiempoCreacion),
			($DatTrasladoAlmacenSalidaDetalle->TsdTiempoModificacion),
			$DatTrasladoAlmacenSalidaDetalle->UmeNombre,
			$DatTrasladoAlmacenSalidaDetalle->UmeId,
			$DatTrasladoAlmacenSalidaDetalle->RtiId,
			$DatTrasladoAlmacenSalidaDetalle->TsdCantidadReal,
			$DatTrasladoAlmacenSalidaDetalle->ProCodigoOriginal,
			$DatTrasladoAlmacenSalidaDetalle->ProCodigoAlternativo,
			$DatTrasladoAlmacenSalidaDetalle->UmeIdOrigen,
			$VerificarStock,
			$DatTrasladoAlmacenSalidaDetalle->TsdCosto,
			$DatTrasladoAlmacenSalidaDetalle->TsdCantidadReal,
			$DatTrasladoAlmacenSalidaDetalle->TsdEstado
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