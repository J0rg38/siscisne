<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsTrasladoAlmacen->UsuId = $_SESSION['SesionId'];	
	
	$InsTrasladoAlmacen->TalId = $_POST['CmpId'];
	$InsTrasladoAlmacen->PerId = $_POST['CmpPersonal'];
	
	$InsTrasladoAlmacen->AlmId = $_POST['CmpAlmacen'];
	$InsTrasladoAlmacen->AlmIdDestino = $_POST['CmpAlmacenDestino'];
	
	$InsTrasladoAlmacen->TopId = "TOP-10010";
	$InsTrasladoAlmacen->CtiId = "CTI-10006";
	
	$InsTrasladoAlmacen->CliId = "CLI-1000";
	$InsTrasladoAlmacen->PrvId = "PRV-1000";
	
	$InsTrasladoAlmacen->TalFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsTrasladoAlmacen->TalFechaLlegada = FncCambiaFechaAMysql($_POST['CmpFechaLlegada'],true);
	
	$InsTrasladoAlmacen->TalPorcentajeImpuestoVenta = $EmpresaPorcentajeImpuestoVenta;
	
	list($InsTrasladoAlmacen->TalAno,$Mes,$Dia) = explode("-",$InsTrasladoAlmacen->TalFecha);	
	$InsTrasladoAlmacen->TalObservacion = addslashes($_POST['CmpObservacion']);

	$InsTrasladoAlmacen->MonId = $_POST['CmpMonedaId'];
	$InsTrasladoAlmacen->TalTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsTrasladoAlmacen->TalPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsTrasladoAlmacen->TalIncluyeImpuesto = 1;
	
	$InsTrasladoAlmacen->TalEstado = $_POST['CmpEstado'];
	$InsTrasladoAlmacen->TalTiempoModificacion = date("Y-m-d H:i:s");

	$InsTrasladoAlmacen->TrasladoAlmacenDetalle = array();


	

			/*
			SesionObjeto-TrasladoAlmacenDetalle
			Parametro1 = TadId
			Parametro2 = ProId
			Parametro3 = ProNombre
			Parametro4 = 
			Parametro5 = TadCantidad
			Parametro6 = TadCantidadReal
			Parametro7 = TadTiempoCreacion
			Parametro8 = TadTiempoModificacion
			Parametro9 = UmeNombre
			Parametro10 = UmeId
			Parametro11 = RtiId
			Parametro12 = 
			Parametro13 = ProCodigoOriginal,
			Parametro14 = ProCodigoAlternativo
			Parametro15 = UmeIdOrigen
			Parametro16 = TadEstado
			Parametro17 = TadCantidadRealAnterior
			*/


	$ResTrasladoAlmacenDetalle = $_SESSION['InsTrasladoAlmacenDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
	if(!empty($ResTrasladoAlmacenDetalle['Datos'])){
		$item = 1;
		foreach($ResTrasladoAlmacenDetalle['Datos'] as $DatSesionObjeto){
				
			$InsTrasladoAlmacenDetalle1 = new ClsTrasladoAlmacenDetalle();
			$InsTrasladoAlmacenDetalle1->TadId = $DatSesionObjeto->Parametro1;
			$InsTrasladoAlmacenDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsTrasladoAlmacenDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			$InsTrasladoAlmacenDetalle1->TadCantidad = $DatSesionObjeto->Parametro5;
			$InsTrasladoAlmacenDetalle1->TadCantidadReal = $DatSesionObjeto->Parametro6;
			$InsTrasladoAlmacenDetalle1->TadCantidadRealAnterior = $DatSesionObjeto->Parametro17;

			$InsTrasladoAlmacenDetalle1->TadCosto = 0;
			$InsTrasladoAlmacenDetalle1->TadImporte = 0;

			$InsTrasladoAlmacenDetalle1->TadEstado = $DatSesionObjeto->Parametro16;
			$InsTrasladoAlmacenDetalle1->TadTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsTrasladoAlmacenDetalle1->TadTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsTrasladoAlmacenDetalle1->TadEliminado = $DatSesionObjeto->Eliminado;				
			$InsTrasladoAlmacenDetalle1->InsMysql = NULL;

			$InsTrasladoAlmacen->TrasladoAlmacenDetalle[] = $InsTrasladoAlmacenDetalle1;

			if($InsTrasladoAlmacenDetalle1->TadEliminado==1){					
				
			}
			
			$item++;				
		}		
	}else{
		$Guardar = false;
		$Resultado.='#ERR_TAL_111';
	}	

	if(empty($InsTrasladoAlmacen->AlmId )){
		$Guardar = false;
		$Resultado.='#ERR_TAL_112';		
	}
	
	if(empty($InsTrasladoAlmacen->AlmIdDestino )){
		$Guardar = false;
		$Resultado.='#ERR_TAL_113';		
	}
	
	if($InsTrasladoAlmacen->AlmId == $InsTrasladoAlmacen->AlmIdDestino ){
		$Guardar = false;
		$Resultado.='#ERR_TAL_114';		
	}
	
	if($Guardar){
		if($InsTrasladoAlmacen->MtdEditarTrasladoAlmacen()){	

			if(!empty($GET_dia)){
?>
				<script type="text/javascript">

				self.parent.tb_remove('<?php echo $GET_mod;?>');
				self.parent.$('#CmpTrasladoAlmacenId').val("<?php echo $InsTrasladoAlmacen->TalId;?>");
				self.parent.FncTrasladoAlmacenBuscar("Id");

				</script>
<?php
			}
					
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_TAL_102';
		} else{
			$InsTrasladoAlmacen->TalFecha = FncCambiaFechaANormal($InsTrasladoAlmacen->TalFecha);
			$InsTrasladoAlmacen->TalFechaLlegada = FncCambiaFechaANormal($InsTrasladoAlmacen->TalFechaLlegada,true);
			$Resultado.='#ERR_TAL_102';
		}	
	}else{
		$InsTrasladoAlmacen->TalFecha = FncCambiaFechaANormal($InsTrasladoAlmacen->TalFecha);
		$InsTrasladoAlmacen->TalFechaLlegada = FncCambiaFechaANormal($InsTrasladoAlmacen->TalFechaLlegada,true);
	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){

	global $GET_id;
	global $Identificador;
	global $InsTrasladoAlmacen;
	global $EmpresaMonedaId;
	global $InsProductoDisponibilidad;
	global $InsProductoReemplazo;

	unset($_SESSION['InsTrasladoAlmacenDetalle'.$Identificador]);

	$_SESSION['InsTrasladoAlmacenDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsTrasladoAlmacen->TalId = $GET_id;
	$InsTrasladoAlmacen = $InsTrasladoAlmacen->MtdObtenerTrasladoAlmacen();		


	if(!empty($InsTrasladoAlmacen->TrasladoAlmacenDetalle)){
		foreach($InsTrasladoAlmacen->TrasladoAlmacenDetalle as $DatTrasladoAlmacenDetalle){

			/*
			SesionObjeto-TrasladoAlmacenDetalle
			Parametro1 = TadId
			Parametro2 = ProId
			Parametro3 = ProNombre
			Parametro4 = 
			Parametro5 = TadCantidad
			Parametro6 = TadCantidadReal
			Parametro7 = TadTiempoCreacion
			Parametro8 = TadTiempoModificacion
			Parametro9 = UmeNombre
			Parametro10 = UmeId
			Parametro11 = RtiId
			Parametro12 = 
			Parametro13 = ProCodigoOriginal,
			Parametro14 = ProCodigoAlternativo
			Parametro15 = UmeIdOrigen
			Parametro16 = TadEstado
			Parametro17 = TadCantidadRealAnterior
			*/

			$_SESSION['InsTrasladoAlmacenDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatTrasladoAlmacenDetalle->TadId,
			$DatTrasladoAlmacenDetalle->ProId,
			$DatTrasladoAlmacenDetalle->ProNombre,
			0,
			$DatTrasladoAlmacenDetalle->TadCantidad,
			$DatTrasladoAlmacenDetalle->TadCantidadReal,
			($DatTrasladoAlmacenDetalle->TadTiempoCreacion),
			($DatTrasladoAlmacenDetalle->TadTiempoModificacion),
			$DatTrasladoAlmacenDetalle->UmeNombre,
			$DatTrasladoAlmacenDetalle->UmeId,
			$DatTrasladoAlmacenDetalle->RtiId,
			NULL,
			$DatTrasladoAlmacenDetalle->ProCodigoOriginal,
			$DatTrasladoAlmacenDetalle->ProCodigoAlternativo,
			$DatTrasladoAlmacenDetalle->UmeIdOrigen,
			$DatTrasladoAlmacenDetalle->TadEstado,
			$DatTrasladoAlmacenDetalle->TadCantidadReal
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