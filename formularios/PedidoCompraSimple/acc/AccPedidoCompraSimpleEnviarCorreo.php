<?php
//Si se hizo click en guardar	
	

if(isset($_POST['BtnEnviarCorreo_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

	$InsOrdenCompra->OcoId = $_POST['CmpId'];
	$InsOrdenCompra->OcoTipo = $_POST['CmpTipo'];
	
	$InsOrdenCompra->OcoAno = $_POST['CmpAno'];
	$InsOrdenCompra->OcoMes = $_POST['CmpMes'];
	$InsOrdenCompra->OcoCodigoDealer = $_POST['CmpCodigoDealer'];
	
	$InsOrdenCompra->PrvId = $_POST['CmpProveedorId'];

	$InsOrdenCompra->MonId = $_POST['CmpMonedaId'];
	$InsOrdenCompra->OcoTipoCambio = $_POST['CmpTipoCambio'];
		
	$InsPedidoCompra->PcoObservacion = addslashes($_POST['CmpObservacion']);
	$InsPedidoCompra->PcoObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsPedidoCompra->PcoObservacionCorreo = addslashes($_POST['CmpObservacionCorreo']);
	
	$InsOrdenCompra->OcoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsOrdenCompra->OcoFechaLlegadaEstimada = FncCambiaFechaAMysql($_POST['CmpFechaEstimadaLlegada'],true);
	
	$InsOrdenCompra->OcoHora = ($_POST['CmpHora']);
	$InsOrdenCompra->OcoObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsOrdenCompra->OcoRespuestaProveedor = addslashes($_POST['CmpRespuestaProveedor']);
	$InsOrdenCompra->OcoProcesadoProveedor = $_POST['CmpProcesadoProveedor'];
		
	$InsOrdenCompra->OcoEstado = $_POST['CmpEstado'];
	$InsOrdenCompra->OcoTiempoModificacion = date("Y-m-d H:i:s");
	$InsOrdenCompra->OcoEliminado = 1;

	$InsOrdenCompra->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsOrdenCompra->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsOrdenCompra->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsOrdenCompra->OrdenCompraDetalle = array();
	
	$InsOrdenCompra->OcoTotal = 0;

	$Destinatario = preg_replace("/ /", "", $_POST['CmpDestinatario']);
	
	if(!empty($Destinatario)){
		
		if($InsOrdenCompra->MtdGenerarExcelOrdenCompra($InsOrdenCompra->OcoId,"")){

			if(!empty($_SESSION['SesionPersonal'])){

				$InsPersonal = new ClsPersonal();
				$InsPersonal->PerId = $_SESSION['SesionPersonal'];
				$InsPersonal->MtdObtenerPersonal();
				
				$InsOrdenCompra->PerNombre = $InsPersonal->PerNombre;
				$InsOrdenCompra->PerApellidoPaterno = $InsPersonal->PerApellidoPaterno;
				$InsOrdenCompra->PerApellidoMaterno = $InsPersonal->PerApellidoMaterno;
				
			}
			
			$InsOrdenCompra->MtdEnviarCorreoPedidoOrdenCompra($InsOrdenCompra->OcoId,$Destinatario,"");  
			
		}else{
			$Guardar = false;	
		}
			
	}else{
		$Guardar = false;	
	}
		

		
	if($Guardar){
		
		
		if($InsOrdenCompra->OcoEstado == 1){
	
			if($InsOrdenCompra->MtdActualizarEstadoOrdenCompra($InsOrdenCompra->OcoId,3)){
					
				if($InsOrdenCompra->MtdActualizarEstadoOrdenCompra($InsOrdenCompra->OcoId,31)){
				
				}
			
			}
	
		}else if($InsOrdenCompra->OcoEstado == 3){
			
			if($InsOrdenCompra->MtdActualizarEstadoOrdenCompra($InsOrdenCompra->OcoId,31)){
				
			}
				
		}
		
		if(!empty($GET_dia)){
?>
		<script type="text/javascript">
            self.parent.tb_remove('<?php echo $GET_mod;?>');
            self.parent.$('#CmpOrdenCompraId').val("<?php echo $InsOrdenCompra->OcoId;?>");
            self.parent.FncOrdenCompraBuscar("Id");
        </script>
    <?php
        }
    
		$Resultado.='#SAS_OCO_109';	
		$Edito = true;
        $InsOrdenCompra->OcoFecha = FncCambiaFechaANormal($InsOrdenCompra->OcoFecha);	
        
		
	}else{
		$Edito = false;
		$Resultado.='#ERR_OCO_109';	
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