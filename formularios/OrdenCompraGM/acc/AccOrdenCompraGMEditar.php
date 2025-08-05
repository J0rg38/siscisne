<?php
//Si se hizo click en guardar	
	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

//deb($_POST);
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
		
	$InsOrdenCompra->OcoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsOrdenCompra->OcoHora = ($_POST['CmpHora']);
	$InsOrdenCompra->OcoObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsOrdenCompra->OcoEstado = $_POST['CmpEstado'];
	$InsOrdenCompra->OcoTiempoModificacion = date("Y-m-d H:i:s");
	$InsOrdenCompra->OcoEliminado = 1;

	$InsOrdenCompra->TdoId = $_POST['CmpTipoDocumento'];
	$InsOrdenCompra->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsOrdenCompra->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
		
	$InsOrdenCompra->OrdenCompraDetalle = array();
	
	if($InsOrdenCompra->MonId<>$EmpresaMonedaId){
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
//	Parametro18 = OcdAno
//	Parametro19 = OcdModelo

$InsOrdenCompra->OcoTotal = 0;

	$RepSesionObjetos = $_SESSION['InsOrdenCompraDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrSesionObjetos = $RepSesionObjetos['Datos'];
	
	if(!empty($ArrSesionObjetos)){
		foreach($ArrSesionObjetos as $DatSesionObjeto){
		
			$InsOrdenCompraDetalle1 = new ClsOrdenCompraDetalle();
			$InsOrdenCompraDetalle1->OcdId = $DatSesionObjeto->Parametro1;
			$InsOrdenCompraDetalle1->PcdId = $DatSesionObjeto->Parametro16;
			
			$InsOrdenCompraDetalle1->OcdAno = $DatSesionObjeto->Parametro18;
			$InsOrdenCompraDetalle1->OcdModelo = $DatSesionObjeto->Parametro19;
			
			$InsOrdenCompraDetalle1->OcdCodigoOtro = $DatSesionObjeto->Parametro13;
			$InsOrdenCompraDetalle1->OcdPrecio = $DatSesionObjeto->Parametro4;
			$InsOrdenCompraDetalle1->OcdImporte = $DatSesionObjeto->Parametro6;

			//if($InsOrdenCompra->MonId<>$EmpresaMonedaId){
//				$InsOrdenCompraDetalle1->OcdPrecio = $InsOrdenCompraDetalle1->OcdPrecio * $InsOrdenCompra->OcoTipoCambio;
//			}else{
				//$InsOrdenCompraDetalle1->OcdPrecio = $InsOrdenCompraDetalle1->OcdPrecio;
			//}
			
			$InsOrdenCompraDetalle1->OcdCantidad = $DatSesionObjeto->Parametro5;					
//
//			if($InsOrdenCompra->MonId<>$EmpresaMonedaId){
//				$InsOrdenCompraDetalle1->OcdImporte = $InsOrdenCompraDetalle1->OcdImporte * $InsOrdenCompra->OcoTipoCambio;
//			}else{
				//$InsOrdenCompraDetalle1->OcdImporte = $InsOrdenCompraDetalle1->OcdImporte;
			//}

			$InsOrdenCompraDetalle1->ProNombre = $DatSesionObjeto->Parametro3;
			$InsOrdenCompraDetalle1->UmeNombre = $DatSesionObjeto->Parametro9;
			$InsOrdenCompraDetalle1->ProCodigoOriginal = $DatSesionObjeto->Parametro14;
			$InsOrdenCompraDetalle1->ProCodigoAlternativo = $DatSesionObjeto->Parametro15;
			$InsOrdenCompraDetalle1->PcdId = $DatSesionObjeto->Parametro16;
			$InsOrdenCompraDetalle1->OcdSaldo = $DatSesionObjeto->Parametro17;

			$InsOrdenCompraDetalle1->OcdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsOrdenCompraDetalle1->OcdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsOrdenCompraDetalle1->OcdEliminado = $DatSesionObjeto->Eliminado;				
			$InsOrdenCompraDetalle1->InsMysql = NULL;

			$InsOrdenCompra->OrdenCompraDetalle[] = $InsOrdenCompraDetalle1;

			if($InsOrdenCompraDetalle1->OcdEliminado==1){
				$InsOrdenCompra->OcoTotal += $InsOrdenCompraDetalle1->OcdImporte;
			}				

			$_SESSION['InsOrdenCompraDetalle'.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
			$InsOrdenCompraDetalle1->OcdId,
			NULL,
			$InsOrdenCompraDetalle1->ProNombre,
			$InsOrdenCompraDetalle1->OcdPrecio,
			$InsOrdenCompraDetalle1->OcdCantidad,
			$InsOrdenCompraDetalle1->OcdImporte,
			$InsOrdenCompraDetalle1->OcdTiempoCreacion,
			date("d/m/Y H:i:s"),
			$InsOrdenCompraDetalle1->UmeNombre,
			NULL,
			NULL,
			NULL,
			$InsOrdenCompraDetalle1->OcdCodigoOtro,
			$InsOrdenCompraDetalle1->ProCodigoOriginal,
			$InsOrdenCompraDetalle1->ProCodigoAlternativo,
			$InsOrdenCompraDetalle1->PcdId,
			NULL,
			$InsOrdenCompraDetalle1->OcdAno,
			$InsOrdenCompraDetalle1->OcdModelo
			);

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
//	Parametro18 = OcdAno
//	Parametro19 = OcdModelo
	
	
	if($Guardar){
	
		if($InsOrdenCompra->MtdEditarOrdenCompra()){	

			if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
			}
				
			$Edito = true;
			FncCargarDatos();		
			$Resultado.='#SAS_OCO_102';	
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
	$InsOrdenCompra = $InsOrdenCompra->MtdObtenerOrdenCompra();		

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
					$OrdenCompraDetalleSaldo = $DatPedidoCompraDetalle->PcdCantidad;

					$OrdenCompraDetalleTiempoCreacion = date("d/m/Y H:i:s");
					$OrdenCompraDetalleTiempoModificacion = date("d/m/Y H:i:s");

					if(!empty($InsOrdenCompra->OrdenCompraDetalle)){
						foreach($InsOrdenCompra->OrdenCompraDetalle as $DatOrdenCompraDetalle){

							if($DatOrdenCompraDetalle->PcdId == $DatPedidoCompraDetalle->PcdId){

								$OrdenCompraDetalleId = $DatOrdenCompraDetalle->OcdId;								
								$OrdenCompraDetalleSaldo = $DatOrdenCompraDetalle->OcdSaldo;
								$OrdenCompraDetalleTiempoCreacion = $DatOrdenCompraDetalle->OcdTiempoCreacion;
								$OrdenCompraDetalleTiempoModificacion = $DatOrdenCompraDetalle->OcdTiempoModificacion;
								break;
							}
							
						}
					}
					
					//if($InsOrdenCompra->MonId<>$EmpresaMonedaId ){
//						//$DatPedidoCompraDetalle->PcdPrecio = round($DatPedidoCompraDetalle->PcdPrecio / $InsOrdenCompra->OcoTipoCambio,2);
//						$OrdenCompraDetalleImporte = $DatPedidoCompraDetalle->PcdPrecio * $OrdenCompraDetalleSaldo;
//					}
					
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
//	Parametro18 = OcdAno
//	Parametro19 = OcdModelo

					//deb($DatPedidoCompraDetalle->PcdPrecio);
					$_SESSION['InsOrdenCompraDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					$OrdenCompraDetalleId ,
					$DatPedidoCompraDetalle->ProId,
					$DatPedidoCompraDetalle->ProNombre,
					$DatPedidoCompraDetalle->PcdPrecio,
					$DatPedidoCompraDetalle->PcdCantidad,
					$DatPedidoCompraDetalle->PcdImporte,
					//$OrdenCompraDetalleImporte,
					($OrdenCompraDetalleTiempoCreacion),
					($OrdenCompraDetalleTiempoModificacion),
					$DatPedidoCompraDetalle->UmeNombre,
					NULL,
					NULL,
					NULL,
					$DatPedidoCompraDetalle->PcdCodigo,
					$DatPedidoCompraDetalle->ProCodigoOriginal,
					$DatPedidoCompraDetalle->ProCodigoAlternativo,
					$DatPedidoCompraDetalle->PcdId,
					$OrdenCompraDetalleSaldo,
					$DatPedidoCompraDetalle->PcdAno,
					$DatPedidoCompraDetalle->PcdModelo);
					
				}
			}
			
		
		}
	}
	

	
}
?>