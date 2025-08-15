<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){		
	
	$Resultado = '';
	$Guardar = true;
	
	$InsAlmacenMovimientoSalida->UsuId = $_SESSION['SesionId'];	
	$InsAlmacenMovimientoSalida->SucId = $_SESSION['SesionSucursal'];
	
	$InsAlmacenMovimientoSalida->AmoId = $_POST['CmpId'];
	$InsAlmacenMovimientoSalida->LtiId = $_POST['CmpClienteTipo'];
	
	$InsAlmacenMovimientoSalida->TopId = $_POST['CmpTipoOperacion'];
	$InsAlmacenMovimientoSalida->AlmId = $_POST['CmpAlmacen'];
	$InsAlmacenMovimientoSalida->AmoTipoCambio = preg_replace("/,/", "", $_POST['CmpTipoCambio']);
	
	$InsAlmacenMovimientoSalida->MonId = $_POST['CmpMonedaId'];
		
	$InsAlmacenMovimientoSalida->AmoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsAlmacenMovimientoSalida->AmoObservacion = addslashes($_POST['CmpObservacion']);	
	$InsAlmacenMovimientoSalida->AmoDescuento = preg_replace("/,/", "", $_POST['CmpDescuento']);
	
	$InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsAlmacenMovimientoSalida->AmoIncluyeImpuesto = $_POST['CmpPorcentajeImpuestoVenta'];
	
	$InsAlmacenMovimientoSalida->AmoSubTipo = 1;
	$InsAlmacenMovimientoSalida->AmoEstado = $_POST['CmpEstado'];
	$InsAlmacenMovimientoSalida->AmoTiempoCreacion = date("Y-m-d H:i:s");
	$InsAlmacenMovimientoSalida->AmoTiempoModificacion = date("Y-m-d H:i:s");	

	$InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle = array();

	$InsAlmacenMovimientoSalida->AmoTotal = 0;

	if(empty($InsAlmacenMovimientoSalida->AlmId)){
		$Guardar = false;
		$Resultado.='#ERR_AMO_112';
	}
	
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
//	Parametro17 = AmdCosto
//	Parametro18 = AmdCantidadRealAnterior
//	Parametro19 = AmdEstado

//	Parametro20 = AlmId
//	Parametro21 = AmdFecha
	
	
	$ResAlmacenMovimientoSalidaDetalle = $_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResAlmacenMovimientoSalidaDetalle['Datos'])){
		$item = 1;
		foreach($ResAlmacenMovimientoSalidaDetalle['Datos'] as $DatSesionObjeto){
				
			$InsAlmacenMovimientoSalidaDetalle1 = new ClsAlmacenMovimientoSalidaDetalle();
			$InsAlmacenMovimientoSalidaDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsAlmacenMovimientoSalidaDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			$InsAlmacenMovimientoSalidaDetalle1->AmdPrecioVenta = $DatSesionObjeto->Parametro4;
			$InsAlmacenMovimientoSalidaDetalle1->AmdCosto = $DatSesionObjeto->Parametro17;
			$InsAlmacenMovimientoSalidaDetalle1->AmdCostoExtraTotal = 0;
			$InsAlmacenMovimientoSalidaDetalle1->AmdCantidad = $DatSesionObjeto->Parametro5;
			$InsAlmacenMovimientoSalidaDetalle1->AmdCantidadReal = $DatSesionObjeto->Parametro12;
			$InsAlmacenMovimientoSalidaDetalle1->AmdImporte = $DatSesionObjeto->Parametro6;
			$InsAlmacenMovimientoSalidaDetalle1->AmdEstado = $_POST['CmpAlmacenMovimientoSalidaDetalleEstado_'.$DatSesionObjeto->Item];
			$InsAlmacenMovimientoSalidaDetalle1->AmdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsAlmacenMovimientoSalidaDetalle1->AmdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsAlmacenMovimientoSalidaDetalle1->AmdValorTotal = 0;
			$InsAlmacenMovimientoSalidaDetalle1->AmdUtilidad = 0;
			
			$InsAlmacenMovimientoSalidaDetalle1->AlmId = $DatSesionObjeto->Parametro20;
			$InsAlmacenMovimientoSalidaDetalle1->AmdFecha = $DatSesionObjeto->Parametro21;
			
			$InsAlmacenMovimientoSalidaDetalle1->AmdEliminado = $DatSesionObjeto->Eliminado;				
			$InsAlmacenMovimientoSalidaDetalle1->InsMysql = NULL;

			if($InsAlmacenMovimientoSalidaDetalle1->AmdEliminado==1){	
				
				$InsProducto = new ClsProducto();
				$InsProducto->ProId = $InsAlmacenMovimientoSalidaDetalle1->ProId;
				$InsProducto->MtdObtenerProducto(false);
				
				if($InsProducto->ProStockReal < $InsAlmacenMovimientoSalidaDetalle1->AmdCantidadReal){
					$InsAlmacenMovimientoSalidaDetalle1->VerificarStock = 1;
				}

				if($InsAlmacenMovimientoSalidaDetalle1->VerificarStock == 1 and $InsAlmacenMovimientoSalida->AmoEstado <> 1 and $InsAlmacenMovimientoSalidaDetalle1->AmdEliminado==1){
					
					$Guardar = false;
					$Resultado.='#ERR_AMO_501';
					$Resultado.='#Item Numero: '.($item);
					
				}

				$InsAlmacenMovimientoSalida->AmoTotalBruto += $InsAlmacenMovimientoSalidaDetalle1->AmdImporte;	
				$InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle[] = $InsAlmacenMovimientoSalidaDetalle1;				
					
			}

			$item++;	
		}

	}else{
		$Guardar = false;
		$Resultado.='#ERR_AMO_111';
	}
	
	//$InsAlmacenMovimientoSalida->AmoTotal = $InsAlmacenMovimientoSalida->AmoTotal - $InsAlmacenMovimientoSalida->AmoDescuento;
	//deb($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle);


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
		if($InsAlmacenMovimientoSalida->MtdRegistrarAlmacenMovimientoSalida()){
			
						if(!empty($GET_dia)){
?>
			<script type="text/javascript">
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			</script>
<?php
			}
			
			FncNuevo();
			$Registro = true;
			$Resultado.='#SAS_AMO_101';
			
		} else{
			
			$InsAlmacenMovimientoSalida->AmoFecha = FncCambiaFechaANormal($InsAlmacenMovimientoSalida->AmoFecha);
			$Resultado.='#ERR_AMO_101';
		}		
	}else{
		
		$InsAlmacenMovimientoSalida->AmoFecha = FncCambiaFechaANormal($InsAlmacenMovimientoSalida->AmoFecha);
			
	}

	
}else{

	FncNuevo();

}

function FncNuevo(){
	
	global $InsAlmacenMovimientoSalida;
	global $Identificador;
	global $EmpresaImpuestoVenta;
	
	unset($_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador]);
		
	$_SESSION['InsAlmacenMovimientoSalidaDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();
	
	$InsAlmacenMovimientoSalida->LtiId = "LTI-10015";
	$InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsAlmacenMovimientoSalida->AmoIncluyeImpuesto = 1;
	
	$InsAlmacenMovimientoSalida->TopId = "TOP-10016";
	$InsAlmacenMovimientoSalida->AmoEstado = 3;
	$InsAlmacenMovimientoSalida->AlmId = "ALM-10000";
	$InsAlmacenMovimientoSalida->SucId = $_SESSION['SesionSucursal'];
	
}

?>