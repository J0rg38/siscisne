<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsOrdenCotizacion->UsuId = $_SESSION['SesionId'];	
	$InsOrdenCotizacion->SucId = $_SESSION['SesionSucursal'];	

	$InsOrdenCotizacion->OotId = $_POST['CmpId'];
	$InsOrdenCotizacion->PrvId = $_POST['CmpProveedorId'];
	$InsOrdenCotizacion->PerId = $_POST['CmpPersonal'];	
	
	$InsOrdenCotizacion->OotFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsOrdenCotizacion->OotFechaRespuesta = FncCambiaFechaAMysql($_POST['CmpFechaRespuesta'],true);
	$InsOrdenCotizacion->OotHora = ($_POST['CmpHora']);

	$InsOrdenCotizacion->MonId = $_POST['CmpMonedaId'];
	$InsOrdenCotizacion->OotTipoCambio = $_POST['CmpTipoCambio'];

	$InsOrdenCotizacion->OotObservacion = addslashes($_POST['CmpObservacion']);
	$InsOrdenCotizacion->OotOrigen =  $_POST['CmpOrigen'];
	$InsOrdenCotizacion->OotEstado = $_POST['CmpEstado'];
	$InsOrdenCotizacion->OotTiempoModificacion = date("Y-m-d H:i:s");

	$InsOrdenCotizacion->OotPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsOrdenCotizacion->OotMargenUtilidad = 0;
	$InsOrdenCotizacion->OotIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];		

	$InsOrdenCotizacion->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsOrdenCotizacion->PrvNombreCompleto = $InsOrdenCotizacion->PrvNombre;
	$InsOrdenCotizacion->TdoId = $_POST['CmpProveedorTipoDocumento'];	
	$InsOrdenCotizacion->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];

	$InsOrdenCotizacion->OotSubTotal = 0;
	$InsOrdenCotizacion->OotImpuesto = 0;
	$InsOrdenCotizacion->OotTotal = 0;

	$InsOrdenCotizacion->OrdenCotizacionDetalle = array();

	if($InsOrdenCotizacion->MonId<>$EmpresaMonedaId){
		if(empty($InsOrdenCotizacion->OotTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_OOT_600';
		}
	}
	

/*
SesionObjeto-OrdenCotizacionDetalle
Parametro1 = OodId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = 
Parametro5 = 
Parametro6 = 
Parametro7 = OodTiempoCreacion
Parametro8 = OodTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = 
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = 
Parametro17 = 
Parametro18 = 
Parametro19 = OodAno
Parametro20 = OodModelo

Parametro21 - 
Parametro22 - 
Parametro23 = 

Parametro24 = 
Parametro25 = 

Parametro26 = PcdEstado
*/

	$ResOrdenCotizacionDetalle = $_SESSION['InsOrdenCotizacionDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
	if(!empty($ResOrdenCotizacionDetalle['Datos'])){
		$item = 1;
		foreach($ResOrdenCotizacionDetalle['Datos'] as $DatSesionObjeto){
				
			$InsOrdenCotizacionDetalle1 = new ClsOrdenCotizacionDetalle();
			$InsOrdenCotizacionDetalle1->OodId = $DatSesionObjeto->Parametro1;
			$InsOrdenCotizacionDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsOrdenCotizacionDetalle1->UmeId = $DatSesionObjeto->Parametro10;
		
			$InsOrdenCotizacionDetalle1->OodAno =  $DatSesionObjeto->Parametro19;
			$InsOrdenCotizacionDetalle1->OodModelo =  $DatSesionObjeto->Parametro20;
//			$InsOrdenCotizacionDetalle1->OodPrecio =  $DatSesionObjeto->Parametro4;

			if($InsOrdenCotizacion->MonId<>$EmpresaMonedaId){
				$InsOrdenCotizacionDetalle1->OodPrecio = $DatSesionObjeto->Parametro4 * $InsOrdenCotizacion->OotTipoCambio;
			}else{
				$InsOrdenCotizacionDetalle1->OodPrecio = $DatSesionObjeto->Parametro4;
			}
			
			$InsOrdenCotizacionDetalle1->OodEstado = $InsOrdenCotizacion->OotEstado;//$DatSesionObjeto->Parametro26;
			$InsOrdenCotizacionDetalle1->OodTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsOrdenCotizacionDetalle1->OodTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsOrdenCotizacionDetalle1->OodEliminado = $DatSesionObjeto->Eliminado;				
			$InsOrdenCotizacionDetalle1->InsMysql = NULL;

			$InsOrdenCotizacion->OrdenCotizacionDetalle[] = $InsOrdenCotizacionDetalle1;

			if($InsOrdenCotizacionDetalle1->OodEliminado==1){					
				
			}
			
			$item++;				
		}		
	}else{
		$Guardar = false;
		$Resultado.='#ERR_OOT_111';
	}	

	if($Guardar){
		if($InsOrdenCotizacion->MtdEditarOrdenCotizacion()){	


			if(!empty($GET_dia)){
?>
				<script type="text/javascript">

				self.parent.tb_remove('<?php echo $GET_mod;?>');
				self.parent.$('#CmpOrdenCotizacionId').val("<?php echo $InsOrdenCotizacion->OotId;?>");
				self.parent.FncOrdenCotizacionBuscar("Id");

				</script>
<?php
			}
			
				//if(!empty($InsOrdenCotizacion->OcoId)){
//
//					$InsOrdenCompra = new ClsOrdenCompra();
//					$InsOrdenCompra->OcoId = $InsOrdenCotizacion->OcoId;
//					$InsOrdenCompra->MtdObtenerOrdenCompra();
//					
//					if($InsOrdenCompra->MtdActualizarEstadoOrdenCompra($InsOrdenCotizacion->OcoId,3)){
//						
//						$InsOrdenCompra->OcoTotal += $InsOrdenCotizacion->OotTotal;
//						
//						$InsOrdenCompra->MtdEditarOrdenCompraDato("OcoTotal",$InsOrdenCompra->OcoTotal,$InsOrdenCompra->OcoId);
//
//					}
//
//					
//				}
				
					
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_OOT_102';
		} else{
			$InsOrdenCotizacion->OotFecha = FncCambiaFechaANormal($InsOrdenCotizacion->OotFecha);
			$InsOrdenCotizacion->OotFechaRespuesta = FncCambiaFechaANormal($InsOrdenCotizacion->OotFechaRespuesta,true);
			$Resultado.='#ERR_OOT_102';
		}	
	}else{
		$InsOrdenCotizacion->OotFecha = FncCambiaFechaANormal($InsOrdenCotizacion->OotFecha);
		$InsOrdenCotizacion->OotFechaRespuesta = FncCambiaFechaANormal($InsOrdenCotizacion->OotFechaRespuesta,true);
	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsOrdenCotizacion;
	global $EmpresaMonedaId;
	global $InsProductoDisponibilidad;
	global $InsProductoReemplazo;
	
	
	unset($_SESSION['InsOrdenCotizacionDetalle'.$Identificador]);

	$_SESSION['InsOrdenCotizacionDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsOrdenCotizacion->OotId = $GET_id;
	$InsOrdenCotizacion->MtdObtenerOrdenCotizacion();		

	if(!empty($InsOrdenCotizacion->OrdenCotizacionDetalle)){
		foreach($InsOrdenCotizacion->OrdenCotizacionDetalle as $DatOrdenCotizacionDetalle){

			if($InsOrdenCotizacion->MonId<>$EmpresaMonedaId){
				$DatOrdenCotizacionDetalle->OodPrecio = $DatOrdenCotizacionDetalle->OodPrecio / $InsOrdenCotizacion->OotTipoCambio;
			}else{
				$DatOrdenCotizacionDetalle->OodPrecio = $DatOrdenCotizacionDetalle->OodPrecio;
			}
			
/*
SesionObjeto-OrdenCotizacionDetalle
Parametro1 = OodId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = OodPrecio
Parametro5 = 
Parametro6 = 
Parametro7 = OodTiempoCreacion
Parametro8 = OodTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = 
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = 
Parametro17 = 
Parametro18 = 
Parametro19 = OodAno
Parametro20 = OodModelo

Parametro21 - 
Parametro22 - 
Parametro23 = 

Parametro24 = 
Parametro25 = 

Parametro26 = OodEstado
*/

		
			$_SESSION['InsOrdenCotizacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatOrdenCotizacionDetalle->OodId,
			$DatOrdenCotizacionDetalle->ProId,
			$DatOrdenCotizacionDetalle->ProNombre,
			$DatOrdenCotizacionDetalle->OodPrecio,
			0,
			0,
			($DatOrdenCotizacionDetalle->OodTiempoCreacion),
			($DatOrdenCotizacionDetalle->OodTiempoModificacion),
			$DatOrdenCotizacionDetalle->UmeNombre,
			$DatOrdenCotizacionDetalle->UmeId,
			$DatOrdenCotizacionDetalle->RtiId,
			NULL,
			$DatOrdenCotizacionDetalle->ProCodigoOriginal,
			$DatOrdenCotizacionDetalle->ProCodigoAlternativo,
			$DatOrdenCotizacionDetalle->UmeIdOrigen,
			NULL,
			NULL,
			NULL,
			$DatOrdenCotizacionDetalle->OodAno,
			$DatOrdenCotizacionDetalle->OodModelo,
			NULL,
			NULL,
			NULL,
			
			NULL,
			NULL,
			
			$DatOrdenCotizacionDetalle->OodEstado,
			NULL,
			NULL
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