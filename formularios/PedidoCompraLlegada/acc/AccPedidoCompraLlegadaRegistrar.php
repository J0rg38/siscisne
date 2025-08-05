<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsPedidoCompraLlegada->UsuId = $_SESSION['SesionId'];	

	$InsPedidoCompraLlegada->PleId = $_POST['CmpId'];
	$InsPedidoCompraLlegada->OcoId = $_POST['CmpOrdenCompra'];
	$InsPedidoCompraLlegada->PleFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsPedidoCompraLlegada->PleObservacion = addslashes($_POST['CmpObservacion']);

	$InsPedidoCompraLlegada->PleComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsPedidoCompraLlegada->PleComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsPedidoCompraLlegada->PleComprobanteNumero = $InsPedidoCompraLlegada->PleComprobanteNumeroSerie."-".$InsPedidoCompraLlegada->PleComprobanteNumeroNumero;
	
	$InsPedidoCompraLlegada->PleComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);	
	
	$InsPedidoCompraLlegada->PleGuiaRemisionNumeroSerie = $_POST['CmpGuiaRemisionNumeroSerie'];	
	$InsPedidoCompraLlegada->PleGuiaRemisionNumeroNumero = $_POST['CmpGuiaRemisionNumeroNumero'];	
	$InsPedidoCompraLlegada->PleGuiaRemisionNumero = $InsPedidoCompraLlegada->PleGuiaRemisionNumeroSerie."-".$InsPedidoCompraLlegada->PleGuiaRemisionNumeroNumero;	
	
	$InsPedidoCompraLlegada->PleGuiaRemisionFecha = FncCambiaFechaAMysql($_POST['CmpGuiaRemisionFecha'],true);	

	$InsPedidoCompraLlegada->PleFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);

	$InsPedidoCompraLlegada->PleObservacion = addslashes($_POST['CmpObservacion']);
	$InsPedidoCompraLlegada->PleEstado = $_POST['CmpEstado'];
	
	$InsPedidoCompraLlegada->PleTiempoCreacion = date("Y-m-d H:i:s");
	$InsPedidoCompraLlegada->PleTiempoModificacion = date("Y-m-d H:i:s");
	$InsPedidoCompraLlegada->PleEliminado = 1;
	
	$InsPedidoCompraLlegada->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsPedidoCompraLlegada->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsPedidoCompraLlegada->PrvNombreCompleto = $_POST['CmpProveedorNombre'];
	$InsPedidoCompraLlegada->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsPedidoCompraLlegada->PleFoto = $_SESSION['SesPleFoto'.$Identificador];
		
	$InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle = array();
	
//SesionObjeto-PedidoCompraLlegadaDetalle
//Parametro1 = 
//Parametro2 = PcdId
//Parametro3 = PldCantidad
//Parametro4 = PldEstado
//Parametro5 = PldTiempoCreacion
//Parametro6 = PldTiempoModificacion
//Parametro7 = ProId
//Parametro8 = UmeId
//Parametro9 = PcdCantidad
//Parametro10 = ProNombre
//Parametro11 = ProCodigoOriginal
//Parametro12 = ProCodigoAlternativo
//Parametro13 = UmeIdOrigen
//Parametro14 = UmeNombre
//Parametro15 = VdiId

//Parametro16 = VdiOrdenCompraNumero
//Parametro17 = CliNumeroDocumento
//Parametro18 = CliNombre
//Parametro19 = CliApellidoPaterno
//Parametro20 = CliApellidoMaterno
//Parametro21 = RtiId

	$ResPedidoCompraLlegadaDetalle = $_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	
	if(!empty($ResPedidoCompraLlegadaDetalle['Datos'])){

		foreach($ResPedidoCompraLlegadaDetalle['Datos'] as $DatSesionObjeto){

			$InsPedidoCompraLlegadaDetalle1 = new ClsPedidoCompraLlegadaDetalle();

			$InsPedidoCompraLlegadaDetalle1->PcdId = $DatSesionObjeto->Parametro2;
			$InsPedidoCompraLlegadaDetalle1->PldCantidad = $DatSesionObjeto->Parametro3;
			$InsPedidoCompraLlegadaDetalle1->PldEstado = $InsPedidoCompraLlegada->PleEstado;			
			$InsPedidoCompraLlegadaDetalle1->PldTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro5);
			$InsPedidoCompraLlegadaDetalle1->PldTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			
			$InsPedidoCompraLlegadaDetalle1->PldEliminado = $DatSesionObjeto->Eliminado;				
			$InsPedidoCompraLlegadaDetalle1->InsMysql = NULL;

			if($InsPedidoCompraLlegadaDetalle1->PldEliminado==1){					
				$InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle[] = $InsPedidoCompraLlegadaDetalle1;		
			}
		}		
		
	}else{
		$Guardar = false;
		$Resultado.='#ERR_PLE_111';
	}





	if($Guardar){

		if($InsPedidoCompraLlegada->MtdRegistrarPedidoCompraLlegada()){

			FncNuevo();
	
			$Resultado.='#SAS_PLE_101';
			$Registro = true;
		}else{
			
			$InsPedidoCompraLlegada->PleFecha = FncCambiaFechaANormal($InsPedidoCompraLlegada->PleFecha);
			$InsPedidoCompraLlegada->PleGuiaRemisionFecha = FncCambiaFechaANormal($InsPedidoCompraLlegada->PleGuiaRemisionFecha,true);
			$InsPedidoCompraLlegada->PleComprobanteFecha = FncCambiaFechaANormal($InsPedidoCompraLlegada->PleComprobanteFecha,true);
			
			$Resultado.='#ERR_PLE_101';	
		}
			
	}else{
		
			$InsPedidoCompraLlegada->PleFecha = FncCambiaFechaANormal($InsPedidoCompraLlegada->PleFecha);
			$InsPedidoCompraLlegada->PleGuiaRemisionFecha = FncCambiaFechaANormal($InsPedidoCompraLlegada->PleGuiaRemisionFecha,true);
			$InsPedidoCompraLlegada->PleComprobanteFecha = FncCambiaFechaANormal($InsPedidoCompraLlegada->PleComprobanteFecha,true);
			
	}
	


}else{

	FncNuevo();
	
	switch($GET_Ori){
		
		case "OrdenCompra":
			
			$InsOrdenCompra = new ClsOrdenCompra();
	
			$InsOrdenCompra->OcoId = $GET_OcoId;
			$InsOrdenCompra->MtdObtenerOrdenCompra();	
			
						
			$InsPedidoCompraLlegada->OcoId = $InsOrdenCompra->OcoId;
			$InsPedidoCompraLlegada->MonId = $InsOrdenCompra->MonId;
			$InsPedidoCompraLlegada->PleTipoCambio = $InsOrdenCompra->OcoTipoCambio;

			$InsPedidoCompraLlegada->PrvId = $InsOrdenCompra->PrvId;
			$InsPedidoCompraLlegada->PrvNombreCompleto = $InsOrdenCompra->PrvNombreCompleto;
			$InsPedidoCompraLlegada->PrvNombre = $InsOrdenCompra->PrvNombre;
			$InsPedidoCompraLlegada->PrvApellidoPaterno = $InsOrdenCompra->PrvApellidoPaterno;
			$InsPedidoCompraLlegada->PrvApellidoMaterno = $InsOrdenCompra->PrvApellidoMaterno;
			$InsPedidoCompraLlegada->TdoId = $InsOrdenCompra->TdoId;
			$InsPedidoCompraLlegada->PrvNumeroDocumento = $InsOrdenCompra->PrvNumeroDocumento;

			unset($_SESSION['InsOrdenCompraPedido'.$Identificador]);

			$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();

			if(!empty($InsOrdenCompra->OrdenCompraPedido)){
				foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
		
					$InsPedidoCompra = new ClsPedidoCompra();
					$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
					$InsPedidoCompra->MtdObtenerPedidoCompra();


					$_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdAgregarSesionObjeto(1,
					$InsPedidoCompra->PcoId,
					$InsPedidoCompra->PcoFecha,
					$InsPedidoCompra->CliNombreCompleto
					);
					
							
					if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
						foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
							
							

//SesionObjeto-PedidoCompraLlegadaDetalle
//Parametro1 = PldId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = 
//Parametro5 = Cantidad
//Parametro6 = 
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = 
//Parametro14 = 
//Parametro15 = 
//Parametro16 = 
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = PldIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = 
//Parametro24 = 
					
					$PedidoCompraDetalleCantidad = $DatPedidoCompraDetalle->PcdCantidadPendienteLlegada;
					
					//deb($PedidoCompraDetalleCantidad );
					$InsProducto->ProId = $DatPedidoCompraDetalle->ProId;
					$InsProducto->MtdObtenerProducto(false);

					if(!empty($DatPedidoCompraDetalle->UmeId)){

						$InsUnidadMedida->UmeId = $DatPedidoCompraDetalle->UmeId;
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
							$DatPedidoCompraDetalle->PcdCantidadReal = round($PedidoCompraDetalleCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
						}else{
							$DatPedidoCompraDetalle->PcdCantidadReal = '';
						}
					
					}else{
						$DatPedidoCompraDetalle->PcdCantidadReal = '';
					}
					
					
					
//SesionObjeto-PedidoCompraLlegadaDetalle
//Parametro1 = PldId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = 
//Parametro5 = Cantidad
//Parametro6 = 
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = 
//Parametro14 = 
//Parametro15 = 
//Parametro16 = 
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = 
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = 
//Parametro24 = 			
							if($PedidoCompraDetalleCantidad>0){
								
								$_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
								NULL,
								$DatPedidoCompraDetalle->ProId,
								($DatPedidoCompraDetalle->ProNombre),
								NULL,
								$PedidoCompraDetalleCantidad,
								NULL,
								date("d/m/Y H:i:s"),
								date("d/m/Y H:i:s"),
								$DatPedidoCompraDetalle->UmeNombre,
								$DatPedidoCompraDetalle->UmeId,
								$DatPedidoCompraDetalle->RtiId,
								$DatPedidoCompraDetalle->PcdCantidadReal,
								0,
								0,
								0,
								NULL,
								$DatPedidoCompraDetalle->ProCodigoOriginal,
								$DatPedidoCompraDetalle->ProCodigoAlternativo,
								$DatPedidoCompraDetalle->UmeIdOrigen,
								NULL,
								$DatPedidoCompraDetalle->PcdId,
								$DatPedidoCompraDetalle->PcoId,
								NULL,
								NULL
								);	
								
							}

			
							
						}
					}
					
				
				}
			}



		break;
	}
}



function FncNuevo(){

	global $Identificador;
	global $InsPedidoCompraLlegada;
		
	unset($_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador]);
	unset($_SESSION['InsOrdenCompraPedido'.$Identificador]);
	
	unset($_SESSION['SesPleFoto'.$Identificador]);
	
	$_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();

	$InsPedidoCompraLlegada = new ClsPedidoCompraLlegada();
	
	$InsPedidoCompraLlegada->PleEstado = 3;
	
}
?>