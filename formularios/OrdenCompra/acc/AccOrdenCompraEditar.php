<?php
//Si se hizo click en guardar	
	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

//deb($_POST);
	$Guardar = true;
	$Resultado = '';

	$InsOrdenCompra->OcoId = $_POST['CmpId'];
	$InsOrdenCompra->OcoTipo = $_POST['CmpTipo'];
	//$InsOrdenCompra->OcoTipo = "CYC";
	
	$InsOrdenCompra->OcoAno = $_POST['CmpAno'];
	$InsOrdenCompra->OcoMes = $_POST['CmpMes'];
	$InsOrdenCompra->OcoCodigoDealer = $_POST['CmpCodigoDealer'];
	$InsOrdenCompra->OcoVIN = $_POST['CmpVIN'];
	$InsOrdenCompra->OcoOrdenTrabajo = $_POST['CmpOrdenTrabajo'];
	$InsOrdenCompra->PrvId = $_POST['CmpProveedorId'];
	
	$InsOrdenCompra->VmaId = $_POST['CmpVehiculoMarca'];
	$InsOrdenCompra->MonId = $_POST['CmpMonedaId'];
	$InsOrdenCompra->OcoTipoCambio = $_POST['CmpTipoCambio'];
//	$InsOrdenCompra->MonId = $_POST['CmpMonedaId'];
//	$InsOrdenCompra->OcoTipoCambio = $_POST['CmpTipoCambio'];
		
	$InsOrdenCompra->OcoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsOrdenCompra->OcoFechaLlegadaEstimada = FncCambiaFechaAMysql($_POST['CmpFechaEstimadaLlegada'],true);
	
//	deb($InsOrdenCompra->OcoFechaLlegadaEstimada );
	if(empty($InsOrdenCompra->OcoFechaLlegadaEstimada)){
		
//		deb($InsOrdenCompra->OcoTipo);
		switch($InsOrdenCompra->OcoTipo){
			
			case "YRUSH":

				$FechaEstimadaLlegada = strtotime ( '+2 days' , strtotime ( $InsOrdenCompra->OcoFecha) ) ;
				$FechaEstimadaLlegada = date ('Y-m-d' , $FechaEstimadaLlegada );
				$InsOrdenCompra->OcoFechaLlegadaEstimada = $FechaEstimadaLlegada;

			break;
			
			case "ZVOR":
			
				$FechaEstimadaLlegada = strtotime ( '+60 days' , strtotime ( $InsOrdenCompra->OcoFecha) ) ;
				$FechaEstimadaLlegada = date ('Y-m-d' , $FechaEstimadaLlegada );
				$InsOrdenCompra->OcoFechaLlegadaEstimada = $FechaEstimadaLlegada;
			
			break;
			
			case "STK":
				
				$FechaEstimadaLlegada = strtotime ( '+4 days' , strtotime ( $InsOrdenCompra->OcoFecha) ) ;
				$FechaEstimadaLlegada = date ('Y-m-d' , $FechaEstimadaLlegada );
				$InsOrdenCompra->OcoFechaLlegadaEstimada = $FechaEstimadaLlegada;

			break;
			
			default:
			
			break;
                            
		}
		
		
		
	}
	
	
	
	$InsOrdenCompra->OcoHora = ($_POST['CmpHora']);
	$InsOrdenCompra->OcoObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsOrdenCompra->OcoRespuestaProveedor = addslashes($_POST['CmpRespuestaProveedor']);
	$InsOrdenCompra->OcoProcesadoProveedor = $_POST['CmpProcesadoProveedor'];
	
	$InsOrdenCompra->OcoPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsOrdenCompra->OcoIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	
	//deb($InsOrdenCompra->OcoIncluyeImpuesto );
	
	$InsOrdenCompra->OcoEstado = $_POST['CmpEstado'];
	$InsOrdenCompra->OcoTiempoModificacion = date("Y-m-d H:i:s");
	$InsOrdenCompra->OcoEliminado = 1;

	$InsOrdenCompra->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsOrdenCompra->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsOrdenCompra->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
		
	$InsOrdenCompra->OrdenCompraDetalle = array();
	
	if($InsOrdenCompra->MonId<>$EmpresaMonedaId){
//		echo $InsOrdenCompra->OcoTipoCambio.":3";
		if(empty($InsOrdenCompra->OcoTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_OCO_600';
		}
	}
		
//	SesionObjeto-OrdenCompraDetalle
//	Parametro1 = OcdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = OcdPrecio
//	Parametro5 = OcdCantidad
//	Parametro6 = OcdImporte
//	Parametro7 = OcdTiempoCreacion
//	Parametro8 = OcdTiempoModificacion
//	Parametro9 = UnidadMedidaNombreConvertir
//	Parametro10 = UnidadMedidaConvertir
//	Parametro11 = Tipo
//	Parametro12 = 
//	Parametro13 = OcdCodigoOtro
//	Parametro14 = ProCodigoOriginal
//	Parametro15 = ProCodigoAlternativo
//	Parametro16 = PcdId
//	Parametro17 = OcdSaldo	


	
//	$RepSesionObjetos = $_SESSION['InsOrdenCompraDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
//	$ArrSesionObjetos = $RepSesionObjetos['Datos'];
//	
//	if(!empty($ArrSesionObjetos)){
//		foreach($ArrSesionObjetos as $DatSesionObjeto){
//		
//					$InsOrdenCompraDetalle1 = new ClsOrdenCompraDetalle();
//					$InsOrdenCompraDetalle1->OcdId = $DatSesionObjeto->Parametro1;
//					$InsOrdenCompraDetalle1->PcdId = $DatSesionObjeto->Parametro16;
//					
//					$InsOrdenCompraDetalle1->OcdCodigoOtro = $_POST['CmpProductoCodigoOtro_'.$DatSesionObjeto->Parametro16];
//					$InsOrdenCompraDetalle1->OcdPrecio = preg_replace("/,/", "", $_POST['CmpProductoPrecio_'.$DatSesionObjeto->Parametro16]);
//	
//					if($InsOrdenCompra->MonId<>$EmpresaMonedaId and !empty($InsOrdenCompra->OcoTipoCambio)){
//						$InsOrdenCompraDetalle1->OcdPrecio = $InsOrdenCompraDetalle1->OcdPrecio * $InsOrdenCompra->OcoTipoCambio;
//					}else{
//						$InsOrdenCompraDetalle1->OcdPrecio = $InsOrdenCompraDetalle1->OcdPrecio;
//					}
//					
//					$InsOrdenCompraDetalle1->OcdCantidad = $DatSesionObjeto->Parametro5;					
//
//					$InsOrdenCompraDetalle1->OcdImporte = $InsOrdenCompraDetalle1->OcdCantidad * $InsOrdenCompraDetalle1->OcdPrecio;
//							 
//					if($InsOrdenCompra->MonId<>$EmpresaMonedaId and !empty($InsOrdenCompra->OcoTipoCambio)){
//						$InsOrdenCompraDetalle1->OcdImporte = $InsOrdenCompraDetalle1->OcdImporte * $InsOrdenCompra->OcoTipoCambio;
//					}else{
//						$InsOrdenCompraDetalle1->OcdImporte = $InsOrdenCompraDetalle1->OcdImporte;
//					}
//
//					$InsOrdenCompraDetalle1->ProNombre = $DatSesionObjeto->Parametro3;
//					$InsOrdenCompraDetalle1->UmeNombre = $DatSesionObjeto->Parametro9;
//					$InsOrdenCompraDetalle1->ProCodigoOriginal = $DatSesionObjeto->Parametro14;
//					$InsOrdenCompraDetalle1->ProCodigoAlternativo = $DatSesionObjeto->Parametro15;
//					$InsOrdenCompraDetalle1->PcdId = $DatSesionObjeto->Parametro16;
//					$InsOrdenCompraDetalle1->OcdSaldo = $DatSesionObjeto->Parametro17;
//
//					$InsOrdenCompraDetalle1->OcdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
//					$InsOrdenCompraDetalle1->OcdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
//		
//					$InsOrdenCompraDetalle1->OcdEliminado = $DatSesionObjeto->Eliminado;				
//					$InsOrdenCompraDetalle1->InsMysql = NULL;
//		
//					$InsOrdenCompra->OrdenCompraDetalle[] = $InsOrdenCompraDetalle1;
//		
//					if($InsOrdenCompraDetalle1->OcdEliminado==1){
//						//$InsOrdenCompra->OcoTotal += $InsOrdenCompraDetalle1->OcdImporte;
//					}				
//		
//					$_SESSION['InsOrdenCompraDetalle'.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
//					$InsOrdenCompraDetalle1->OcdId,
//					NULL,
//					$InsOrdenCompraDetalle1->ProNombre,
//					$InsOrdenCompraDetalle1->OcdPrecio,
//					$InsOrdenCompraDetalle1->OcdCantidad,
//					$InsOrdenCompraDetalle1->OcdImporte,
//					$InsOrdenCompraDetalle1->OcdTiempoCreacion,
//					date("d/m/Y H:i:s"),
//					$InsOrdenCompraDetalle1->UmeNombre,
//					NULL,
//					NULL,
//					NULL,
//					$InsOrdenCompraDetalle1->OcdCodigoOtro,
//					$InsOrdenCompraDetalle1->ProCodigoOriginal,
//					$InsOrdenCompraDetalle1->ProCodigoAlternativo,
//					$InsOrdenCompraDetalle1->PcdId
//					);
//
//
//		}
//	
//	}elseif($InsOrdenCompra->OcoEstado == 3){
//		$Guardar = false;
//		$Resultado.='#ERR_OCO_603';	
//	}		

	$InsOrdenCompra->OcoSubTotal = 0;
	$InsOrdenCompra->OcoImpuesto = 0;
	$InsOrdenCompra->OcoTotal = 0;
	
	$InsOrdenCompra->OcoTotalBruto = 0;
	
	$RepOrdenCompraPedido = $_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrOrdenCompraPedidos = $RepOrdenCompraPedido['Datos'];

	//deb($ArrOrdenCompraPedidos);
	if(!empty($ArrOrdenCompraPedidos)){
		foreach($ArrOrdenCompraPedidos as $DatOrdenCompraPedido){
			
			$InsPedidoCompra1 = new ClsPedidoCompra();
			$InsPedidoCompra1->PcoId = $DatOrdenCompraPedido->Parametro1;
			$InsPedidoCompra1->MtdObtenerPedidoCompra();
				
			$InsPedidoCompra1->PcoSubTotal = 0;
			$InsPedidoCompra1->PcoImpuesto = 0;
			$InsPedidoCompra1->PcoTotal = 0;

			$InsPedidoCompra1->PcoTotalBruto = 0;

			if(!empty($InsPedidoCompra1->PedidoCompraDetalle)){
				foreach($InsPedidoCompra1->PedidoCompraDetalle as $DatPedidoCompraDetalle){

					$InsPedidoCompra1->PcoTotalBruto += $DatPedidoCompraDetalle->PcdImporte;

				}
			}

			if($InsPedidoCompra1->PcoIncluyeImpuesto==2){
				$InsPedidoCompra1->PcoSubTotal = round($InsPedidoCompra1->PcoTotalBruto,6);
				$InsPedidoCompra1->PcoImpuesto = round(($InsPedidoCompra1->PcoSubTotal * ($InsPedidoCompra1->PcoPorcentajeImpuestoVenta/100)),6);
				$InsPedidoCompra1->PcoTotal = round($InsPedidoCompra1->PcoSubTotal + $InsPedidoCompra1->PcoImpuesto,6);
			}else{
				$InsPedidoCompra1->PcoTotal = round($InsPedidoCompra1->PcoTotalBruto,6);	
				$InsPedidoCompra1->PcoSubTotal = round($InsPedidoCompra1->PcoTotal / (($InsPedidoCompra1->PcoPorcentajeImpuestoVenta/100)+1),6);
				$InsPedidoCompra1->PcoImpuesto = round(($InsPedidoCompra1->PcoTotal - $InsPedidoCompra1->PcoSubTotal),6);
			}
			
			$InsOrdenCompra->OcoSubTotal += $InsPedidoCompra1->PcoSubTotal;
			$InsOrdenCompra->OcoImpuesto += $InsPedidoCompra1->PcoImpuesto;
			$InsOrdenCompra->OcoTotal += $InsPedidoCompra1->PcoTotal;

//			$InsOrdenCompra->MonId = $InsPedidoCompra1->MonId;
//			$InsOrdenCompra->OcoTipoCambio = $InsPedidoCompra1->PcoTipoCambio;

		}
	}
//	
//	if($InsOrdenCompra->OcoIncluyeImpuesto==2){
//		$InsOrdenCompra->OcoSubTotal = round($InsOrdenCompra->OcoTotalBruto,6);
//		$InsOrdenCompra->OcoImpuesto = round(($InsOrdenCompra->OcoSubTotal * ($InsOrdenCompra->OcoPorcentajeImpuestoVenta/100)),6);
//		$InsOrdenCompra->OcoTotal = round($InsOrdenCompra->OcoSubTotal + $InsOrdenCompra->OcoImpuesto,6);
//	}else{
//		$InsOrdenCompra->OcoTotal = round($InsOrdenCompra->OcoTotalBruto,6);	
//		$InsOrdenCompra->OcoSubTotal = round($InsOrdenCompra->OcoTotal / (($InsOrdenCompra->ocoPorcentajeImpuestoVenta/100)+1),6);
//		$InsOrdenCompra->OcoImpuesto = round(($InsOrdenCompra->OcoTotal - $InsOrdenCompra->OcoSubTotal),6);
//	}
	
	if($Guardar){
	
		if($InsOrdenCompra->MtdEditarOrdenCompra()){		
			$Edito = true;
			FncCargarDatos();		
			$Resultado.='#SAS_OCO_102';	
			
			if(!empty($GET_dia)){
?>
<script type="text/javascript">
	self.parent.tb_remove('<?php echo $GET_mod;?>');
	self.parent.$('#CmpOrdenCompraId').val("<?php echo $InsOrdenCompra->OcoId;?>");
	self.parent.FncOrdenCompraBuscar("Id");
</script>
<?php
			}
			
		} else{
			$InsOrdenCompra->OcoFecha = FncCambiaFechaANormal($InsOrdenCompra->OcoFecha);
			$Resultado.='#ERR_OCO_102';
		}		
		
	}else{
		$InsOrdenCompra->OcoFecha = FncCambiaFechaANormal($InsOrdenCompra->OcoFecha);	
	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $Identificador;
	global $InsOrdenCompra;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsOrdenCompraDetalle'.$Identificador]);
	unset($_SESSION['InsOrdenCompraPedido'.$Identificador]);

	$_SESSION['InsOrdenCompraDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();
	
	$InsOrdenCompra->OcoId = $GET_id;
	$InsOrdenCompra->MtdObtenerOrdenCompra();		

//deb($InsOrdenCompra);

//	if(!empty($InsOrdenCompra->OrdenCompraDetalle)){
//		foreach($InsOrdenCompra->OrdenCompraDetalle as $DatOrdenCompraDetalle){
//
////			if($InsOrdenCompra->MonId<>$EmpresaMonedaId and (!empty($InsOrdenCompra->OcoTipoCambio) )){
////				$DatOrdenCompraDetalle->OcdImporte = round($DatOrdenCompraDetalle->OcdImporte / $InsOrdenCompra->OcoTipoCambio,2);
////				$DatOrdenCompraDetalle->OcdPrecio = round($DatOrdenCompraDetalle->OcdPrecio  / $InsOrdenCompra->OcoTipoCambio,2);
////			}
////			
////	/*
////	SesionObjeto-OrdenCompraDetalle
////	Parametro1 = OcdId
////	Parametro2 = ProId
////	Parametro3 = ProNombre
////	Parametro4 = OcdPrecio
////	Parametro5 = OcdCantidad
////	Parametro6 = OcdImporte
////	Parametro7 = OcdTiempoCreacion
////	Parametro8 = OcdTiempoModificacion
////	Parametro9 = UnidadMedidaNombreConvertir
////	Parametro10 = UnidadMedidaConvertir
////	Parametro11 = Tipo
////	Parametro12 = 
////	Parametro13 = OcdCodigoOtro
////	Parametro14 = ProCodigoOriginal
////	Parametro15 = ProCodigoAlternativo
////	*/
////		
////			$_SESSION['InsOrdenCompraDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
////			$DatOrdenCompraDetalle->OcdId,
////			$DatOrdenCompraDetalle->ProId,
////			$DatOrdenCompraDetalle->ProNombre,
////			$DatOrdenCompraDetalle->OcdPrecio,
////			$DatOrdenCompraDetalle->OcdCantidad,
////			$DatOrdenCompraDetalle->OcdImporte,
////			($DatOrdenCompraDetalle->OcdTiempoCreacion),
////			($DatOrdenCompraDetalle->OcdTiempoModificacion),
////			$DatOrdenCompraDetalle->UmeNombre,
////			$DatOrdenCompraDetalle->UmeId,
////			$DatOrdenCompraDetalle->RtiId,
////			NULL,
////			$DatOrdenCompraDetalle->OcdCodigoOtro,
////			$DatOrdenCompraDetalle->ProCodigoOriginal,
////			$DatOrdenCompraDetalle->ProCodigoAlternativo);
//		
//		}
//	}
//	
	
	if(!empty($InsOrdenCompra->OrdenCompraPedido)){
		foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
			//SesionObjeto-OrdenCompraPedido
			//Parametro1 = PcoId
			//Parametro2 = PcoFecha
			$_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatOrdenCompraPedido->PcoId,
			$DatOrdenCompraPedido->PcoFecha);

			$InsPedidoCompra = new ClsPedidoCompra();
			$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
			$InsPedidoCompra->MtdObtenerPedidoCompra();

			if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
				foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){

					$OrdenCompraDetalleId = "";
					$OrdenCompraDetalleCodigoOtro = "";
					$OrdenCompraDetallePrecio = 0;
					$OrdenCompraDetalleImporte = 0;
					$OrdenCompraDetalleSaldo = $DatPedidoCompraDetalle->PcdCantidad;
					
					$OrdenCompraDetalleTiempoCreacion = date("d/m/Y H:i:s");
					$OrdenCompraDetalleTiempoModificacion = date("d/m/Y H:i:s");

					//deb($InsOrdenCompra->OrdenCompraDetalle);
					if(!empty($InsOrdenCompra->OrdenCompraDetalle)){
						foreach($InsOrdenCompra->OrdenCompraDetalle as $DatOrdenCompraDetalle){

							if($DatOrdenCompraDetalle->PcdId == $DatPedidoCompraDetalle->PcdId){

								$OrdenCompraDetalleId = $DatOrdenCompraDetalle->OcdId;
								$OrdenCompraDetalleCodigoOtro = $DatOrdenCompraDetalle->OcdCodigoOtro;
								$OrdenCompraDetallePrecio = $DatOrdenCompraDetalle->OcdPrecio;
								$OrdenCompraDetalleSaldo = $DatOrdenCompraDetalle->OcdSaldo;

								$OrdenCompraDetalleTiempoCreacion = $DatOrdenCompraDetalle->OcdTiempoCreacion;
								$OrdenCompraDetalleTiempoModificacion = $DatOrdenCompraDetalle->OcdTiempoModificacion;

								break;
							}
							
						}
					}
					
					if($InsOrdenCompra->MonId<>$EmpresaMonedaId){
						$OrdenCompraDetallePrecio = round($OrdenCompraDetallePrecio / $InsOrdenCompra->OcoTipoCambio,2);
					}

					$OrdenCompraDetalleImporte = $OrdenCompraDetallePrecio * $DatOrdenCompraDetalle->OcdCantidad;

					if(empty($OrdenCompraDetalleId)){
						$OrdenCompraDetalleSaldo = $DatPedidoCompraDetalle->PcdCantidad;
					}
//	SesionObjeto-OrdenCompraDetalle
//	Parametro1 = OcdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = OcdPrecio
//	Parametro5 = OcdCantidad
//	Parametro6 = OcdImporte
//	Parametro7 = OcdTiempoCreacion
//	Parametro8 = OcdTiempoModificacion
//	Parametro9 = UnidadMedidaNombreConvertir
//	Parametro10 = UnidadMedidaConvertir
//	Parametro11 = Tipo
//	Parametro12 = 
//	Parametro13 = OcdCodigoOtro
//	Parametro14 = ProCodigoOriginal
//	Parametro15 = ProCodigoAlternativo
//	Parametro16 = PcdId
//	Parametro17 = OcdSaldo

					$_SESSION['InsOrdenCompraDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					$OrdenCompraDetalleId ,
					NULL,
					$DatPedidoCompraDetalle->ProNombre,
					$OrdenCompraDetallePrecio,
					$DatPedidoCompraDetalle->PcdCantidad,
					$OrdenCompraDetalleImporte,
					($OrdenCompraDetalleTiempoCreacion),
					($OrdenCompraDetalleTiempoModificacion),
					$DatPedidoCompraDetalle->UmeNombre,
					NULL,
					NULL,
					NULL,
					$OrdenCompraDetalleCodigoOtro,
					$DatPedidoCompraDetalle->ProCodigoOriginal,
					$DatPedidoCompraDetalle->ProCodigoAlternativo,
					$DatPedidoCompraDetalle->PcdId,
					$OrdenCompraDetalleSaldo);
					
				}
			}
			
		
		}
	}
	

	
}
?>