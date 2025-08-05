<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsProduccionProducto->UsuId = $_SESSION['SesionId'];	
	
	$InsProduccionProducto->PprId = $_POST['CmpId'];
	$InsProduccionProducto->PerId = $_POST['CmpPersonal'];
	
	$InsProduccionProducto->AlmId = $_POST['CmpAlmacen'];
	$InsProduccionProducto->AlmIdDestino = $_POST['CmpAlmacenDestino'];
	
	$InsProduccionProducto->TopId = "TOP-10021";
	$InsProduccionProducto->CtiId = "CTI-10006";
	
	$InsProduccionProducto->CliId = "CLI-1000";
	$InsProduccionProducto->PrvId = "PRV-1000";
	
	$InsProduccionProducto->PprFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsProduccionProducto->PprFechaLlegada = FncCambiaFechaAMysql($_POST['CmpFechaLlegada'],true);
	
	$InsProduccionProducto->PprPorcentajeImpuestoVenta = $EmpresaPorcentajeImpuestoVenta;
	
	list($InsProduccionProducto->PprAno,$Mes,$Dia) = explode("-",$InsProduccionProducto->PprFecha);	
	$InsProduccionProducto->PprObservacion = addslashes($_POST['CmpObservacion']);

	$InsProduccionProducto->MonId = $_POST['CmpMonedaId'];
	$InsProduccionProducto->PprTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsProduccionProducto->PprPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsProduccionProducto->PprIncluyeImpuesto = 1;
	
	$InsProduccionProducto->PprEstado = $_POST['CmpEstado'];
	$InsProduccionProducto->PprTiempoModificacion = date("Y-m-d H:i:s");

	$InsProduccionProducto->ProduccionProductoDetalleEntrada = array();
	$InsProduccionProducto->ProduccionProductoDetalleSalida = array();


	

	if(empty($InsProduccionProducto->AlmId )){
		$Guardar = false;
		$Resultado.='#ERR_PPR_112';		
	}
	
	
	
	
/*
SesionObjeto-ProduccionProductoDetalle
Parametro1 = PpdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = PpdCosto
Parametro5 = PpdCantidad
Parametro6 = PpdCantidadReal
Parametro7 = PpdTiempoCreacion
Parametro8 = PpdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = 
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = PpdEstado
Parametro17 = PpdCantidadRealAnterior
Parametro18 = PpdImporte
*/


	$ResProduccionProductoDetalleEntrada = $_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador]->MtdObtenerSesionObjetos(false);
	if(!empty($ResProduccionProductoDetalleEntrada['Datos'])){
		$item = 1;
		foreach($ResProduccionProductoDetalleEntrada['Datos'] as $DatSesionObjeto){
				
			$InsProduccionProductoDetalle1 = new ClsProduccionProductoDetalle();
			$InsProduccionProductoDetalle1->PpdId = $DatSesionObjeto->Parametro1;
			$InsProduccionProductoDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsProduccionProductoDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			$InsProduccionProductoDetalle1->PpdCantidad = $DatSesionObjeto->Parametro5;
			$InsProduccionProductoDetalle1->PpdCantidadReal = $DatSesionObjeto->Parametro6;

			$InsProduccionProductoDetalle1->PpdCosto = $DatSesionObjeto->Parametro4;
			$InsProduccionProductoDetalle1->PpdImporte = $DatSesionObjeto->Parametro18;
			$InsProduccionProductoDetalle1->PpdTipo = 1;

			$InsProduccionProductoDetalle1->PpdEstado = $DatSesionObjeto->Parametro16;
			$InsProduccionProductoDetalle1->PpdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsProduccionProductoDetalle1->PpdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsProduccionProductoDetalle1->PpdEliminado = $DatSesionObjeto->Eliminado;				
			$InsProduccionProductoDetalle1->InsMysql = NULL;

			$InsProduccionProducto->ProduccionProductoDetalleEntrada[] = $InsProduccionProductoDetalle1;

			if($InsProduccionProductoDetalle1->PpdEliminado==1){					
				
			}
			
			$item++;				
		}		
	}else{
		$Guardar = false;
		$Resultado.='#ERR_PPR_111';
	}	
	
	

			/*
			SesionObjeto-ProduccionProductoDetalle
			Parametro1 = PpdId
			Parametro2 = ProId
			Parametro3 = ProNombre
			Parametro4 = PpdCosto
			Parametro5 = PpdCantidad
			Parametro6 = PpdCantidadReal
			Parametro7 = PpdTiempoCreacion
			Parametro8 = PpdTiempoModificacion
			Parametro9 = UmeNombre
			Parametro10 = UmeId
			Parametro11 = RtiId
			Parametro12 = PpdTipo
			Parametro13 = ProCodigoOriginal,
			Parametro14 = ProCodigoAlternativo
			Parametro15 = UmeIdOrigen
			Parametro16 = PpdEstado,
			Parametro17 = PpdCantidadRealAnterior
			Parametro18 = PpdImporte
			*/	
			
	$ResProduccionProductoDetalleSalida = $_SESSION['InsProduccionProductoDetalleSalida'.$Identificador]->MtdObtenerSesionObjetos(false);
	if(!empty($ResProduccionProductoDetalleSalida['Datos'])){
		$item = 1;
		foreach($ResProduccionProductoDetalleSalida['Datos'] as $DatSesionObjeto){
				
			$InsProduccionProductoDetalle1 = new ClsProduccionProductoDetalle();
			$InsProduccionProductoDetalle1->PpdId = $DatSesionObjeto->Parametro1;
			$InsProduccionProductoDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsProduccionProductoDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			$InsProduccionProductoDetalle1->PpdCantidad = $DatSesionObjeto->Parametro5;
			$InsProduccionProductoDetalle1->PpdCantidadReal = $DatSesionObjeto->Parametro6;
			$InsProduccionProductoDetalle1->PpdCantidadRealAnterior = $DatSesionObjeto->Parametro17;

			$InsProduccionProductoDetalle1->PpdCosto = $DatSesionObjeto->Parametro4;
			$InsProduccionProductoDetalle1->PpdImporte = $DatSesionObjeto->Parametro18;
			$InsProduccionProductoDetalle1->PpdTipo = 2;

			$InsProduccionProductoDetalle1->PpdEstado = $DatSesionObjeto->Parametro16;
			$InsProduccionProductoDetalle1->PpdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsProduccionProductoDetalle1->PpdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsProduccionProductoDetalle1->PpdEliminado = $DatSesionObjeto->Eliminado;				
			$InsProduccionProductoDetalle1->InsMysql = NULL;

			$InsProduccionProducto->ProduccionProductoDetalleSalida[] = $InsProduccionProductoDetalle1;

			if($InsProduccionProductoDetalle1->PpdEliminado==1){					
	
			}
			
			$item++;

		}		
	}else{
		$Guardar = false;
		$Resultado.='#ERR_PPR_111';
	}	
	
	
	
	
	
	

	if($Guardar){
		if($InsProduccionProducto->MtdEditarProduccionProducto()){	

			if(!empty($GET_dia)){
?>
				<script type="text/javascript">

				self.parent.tb_remove('<?php echo $GET_mod;?>');
				self.parent.$('#CmpProduccionProductoId').val("<?php echo $InsProduccionProducto->PprId;?>");
				self.parent.FncProduccionProductoBuscar("Id");

				</script>
<?php
			}
					
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_PPR_102';
		} else{
			$InsProduccionProducto->PprFecha = FncCambiaFechaANormal($InsProduccionProducto->PprFecha);
			
			$Resultado.='#ERR_PPR_102';
		}	
	}else{
		$InsProduccionProducto->PprFecha = FncCambiaFechaANormal($InsProduccionProducto->PprFecha);
		
	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){

	global $GET_id;
	global $Identificador;
	global $InsProduccionProducto;
	global $EmpresaMonedaId;
	global $InsProductoDisponibilidad;
	global $InsProductoReemplazo;

	unset($_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador]);
	unset($_SESSION['InsProduccionProductoDetalleSalida'.$Identificador]);

	$_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsProduccionProductoDetalleSalida'.$Identificador] = new ClsSesionObjeto();
	
	$InsProduccionProducto->PprId = $GET_id;
	$InsProduccionProducto = $InsProduccionProducto->MtdObtenerProduccionProducto();		

	if(!empty($InsProduccionProducto->ProduccionProductoDetalleEntrada)){
		foreach($InsProduccionProducto->ProduccionProductoDetalleEntrada as $DatProduccionProductoDetalle){

			/*
SesionObjeto-ProduccionProductoDetalle
Parametro1 = PpdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = PpdCosto
Parametro5 = PpdCantidad
Parametro6 = PpdCantidadReal
Parametro7 = PpdTiempoCreacion
Parametro8 = PpdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = 
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = PpdEstado
Parametro17 = PpdCantidadRealAnterior
Parametro18 = PpdImporte
*/

			$_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatProduccionProductoDetalle->PpdId,
			$DatProduccionProductoDetalle->ProId,
			$DatProduccionProductoDetalle->ProNombre,
			0,
			$DatProduccionProductoDetalle->PpdCantidad,
			$DatProduccionProductoDetalle->PpdCantidadReal,
			($DatProduccionProductoDetalle->PpdTiempoCreacion),
			($DatProduccionProductoDetalle->PpdTiempoModificacion),
			$DatProduccionProductoDetalle->UmeNombre,
			$DatProduccionProductoDetalle->UmeId,
			$DatProduccionProductoDetalle->RtiId,
			$DatProduccionProductoDetalle->PpdTipo,
			$DatProduccionProductoDetalle->ProCodigoOriginal,
			$DatProduccionProductoDetalle->ProCodigoAlternativo,
			$DatProduccionProductoDetalle->UmeIdOrigen,
			$DatProduccionProductoDetalle->PpdEstado,
		 	0,
			$DatProduccionProductoDetalle->PpdImporte
			);
		
		}
	}
	
	
	if(!empty($InsProduccionProducto->ProduccionProductoDetalleSalida)){
		foreach($InsProduccionProducto->ProduccionProductoDetalleSalida as $DatProduccionProductoDetalle){

			/*
			SesionObjeto-ProduccionProductoDetalle
			Parametro1 = PpdId
			Parametro2 = ProId
			Parametro3 = ProNombre
			Parametro4 = PpdCosto
			Parametro5 = PpdCantidad
			Parametro6 = PpdCantidadReal
			Parametro7 = PpdTiempoCreacion
			Parametro8 = PpdTiempoModificacion
			Parametro9 = UmeNombre
			Parametro10 = UmeId
			Parametro11 = RtiId
			Parametro12 = PpdTipo
			Parametro13 = ProCodigoOriginal,
			Parametro14 = ProCodigoAlternativo
			Parametro15 = UmeIdOrigen
			Parametro16 = PpdEstado,
			Parametro17 = PpdCantidadRealAnterior
			Parametro18 = PpdImporte
			*/	

			$_SESSION['InsProduccionProductoDetalleSalida'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatProduccionProductoDetalle->PpdId,
			$DatProduccionProductoDetalle->ProId,
			$DatProduccionProductoDetalle->ProNombre,
			0,
			$DatProduccionProductoDetalle->PpdCantidad,
			$DatProduccionProductoDetalle->PpdCantidadReal,
			($DatProduccionProductoDetalle->PpdTiempoCreacion),
			($DatProduccionProductoDetalle->PpdTiempoModificacion),
			$DatProduccionProductoDetalle->UmeNombre,
			$DatProduccionProductoDetalle->UmeId,
			$DatProduccionProductoDetalle->RtiId,
			$DatProduccionProductoDetalle->PpdTipo,
			$DatProduccionProductoDetalle->ProCodigoOriginal,
			$DatProduccionProductoDetalle->ProCodigoAlternativo,
			$DatProduccionProductoDetalle->UmeIdOrigen,
			$DatProduccionProductoDetalle->PpdEstado,
			$DatProduccionProductoDetalle->PpdCantidadReal,
			$DatProduccionProductoDetalle->PpdImporte
			);
		
		}
	}
	

	
}



//
//
//
//function FncCargarPprlerPedidoDatos(){
//	
//	global $GET_TpeId;
//	global $Identificador;
//	global $InsPprlerPedido;
//	global $InsFichaIngreso;
//	
//	unset($_SESSION['InsPprlerPedidoDetalle'.$Identificador]);
//
//	$_SESSION['InsPprlerPedidoDetalle'.$Identificador] = new ClsSesionObjeto();
//	
//	
//	$InsPprlerPedido = new ClsPprlerPedido();		
//	$InsPprlerPedido->TpeId = $GET_TpeId;
//	$InsPprlerPedido->MtdObtenerPprlerPedido();
//	
//	if(!empty($InsPprlerPedido->PprlerPedidoDetalle)){
//		foreach($InsPprlerPedido->PprlerPedidoDetalle as $DatPprlerPedidoDetalle){
//	
//			$_SESSION['InsPprlerPedidoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//			$DatPprlerPedidoDetalle->TpdId,
//			$DatPprlerPedidoDetalle->ProId,
//			$DatPprlerPedidoDetalle->ProNombre,
//			NULL,
//			$DatPprlerPedidoDetalle->TpdCantidad,
//			NULL,
//			($DatPprlerPedidoDetalle->TpdTiempoCreacion),
//			($DatPprlerPedidoDetalle->TpdTiempoModificacion),
//			$DatPprlerPedidoDetalle->UmeNombre,
//			$DatPprlerPedidoDetalle->UmeId,
//			$DatPprlerPedidoDetalle->RtiId,
//			$DatPprlerPedidoDetalle->TpdCantidadReal,
//			$DatPprlerPedidoDetalle->ProCodigoOriginal,
//			$DatPprlerPedidoDetalle->ProCodigoAlternativo,
//			$DatPprlerPedidoDetalle->UmeIdOrigen
//			);
//		
//		}
//	}
//	
//			
//	$InsFichaIngreso = new ClsFichaIngreso();
//	$InsFichaIngreso->FinId = $InsPprlerPedido->FinId;
//	$InsFichaIngreso->MtdObtenerFichaIngreso();
//}
?>