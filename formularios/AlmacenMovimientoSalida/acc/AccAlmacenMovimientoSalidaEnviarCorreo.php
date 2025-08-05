<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnEnviarCorreo_x']) or $_POST['Guardar']=="1"){	

$Resultado = '';
	$Guardar = true;

	$InsAlmacenMovimientoSalida->UsuId = $_SESSION['SesionId'];	
	
	$InsAlmacenMovimientoSalida->AmoId = $_POST['CmpId'];
	$InsAlmacenMovimientoSalida->LtiId = $_POST['CmpClienteTipo'];
	
	$InsAlmacenMovimientoSalida->TopId = $_POST['CmpTipoOperacion'];
	$InsAlmacenMovimientoSalida->AlmId = $_POST['CmpAlmacen'];
	
	$InsAlmacenMovimientoSalida->MonId = $_POST['CmpMonedaId'];
	$InsAlmacenMovimientoSalida->AmoTipoCambio = eregi_replace(",","",$_POST['CmpTipoCambio']);
	
	$InsAlmacenMovimientoSalida->AmoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsAlmacenMovimientoSalida->AmoObservacion = addslashes($_POST['CmpObservacion']);
	$InsAlmacenMovimientoSalida->AmoDescuento = eregi_replace(",","",$_POST['CmpDescuento']);
	
	$InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsAlmacenMovimientoSalida->AmoIncluyeImpuesto = $_POST['CmpPorcentajeImpuestoVenta'];

	$InsAlmacenMovimientoSalida->AmoSubTipo = 1;
	$InsAlmacenMovimientoSalida->AmoEstado = $_POST['CmpEstado'];
	$InsAlmacenMovimientoSalida->AmoTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle = array();
	
	$InsAlmacenMovimientoSalida->AmoTotal = 0;


	
	if($Guardar){
		
		if(!empty($GET_dia)){
		?>
			<script type="text/javascript">
            self.parent.tb_remove('<?php echo $GET_mod;?>');
            </script>
		<?php
		}
		
		$Registro = true;
		FncCargarDatos();
		$Resultado.='#SAS_VCO_106';
			
	}else{
		
		$InsVentaConcretada->VcoFecha = FncCambiaFechaANormal($InsVentaConcretada->VcoFecha);
		$InsVentaConcretada->VcoEmpresaTransporteFecha = FncCambiaFechaANormal($InsVentaConcretada->VcoEmpresaTransporteFecha,true);
		
		if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
			$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento / $InsVentaConcretada->VcoTipoCambio,6);
		}
		
		if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
			$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra / $InsVentaConcretada->VcoTipoCambio,6);
		}
		$Resultado.='#ERR_VCO_106';
	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $Identificador;
	global $InsVentaConcretada;
	global $EmpresaMonedaId;

	unset($_SESSION['InsVentaConcretadaDetalle'.$Identificador]);
	unset($_SESSION['SesVcoFoto'.$Identificador]);

	$_SESSION['InsVentaConcretadaDetalle'.$Identificador] = new ClsSesionObjeto();

	$InsVentaConcretada->VcoId = $GET_id;
	$InsVentaConcretada->MtdObtenerVentaConcretada();		

	$_SESSION['SesVcoFoto'.$Identificador] = $InsVentaConcretada->VcoFoto;

	if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
		$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento / $InsVentaConcretada->VcoTipoCambio,6);
	}
	
	if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
		$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra / $InsVentaConcretada->VcoTipoCambio,6);
	}
			
			
	if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
		foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){

			if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){

				$DatVentaConcretadaDetalle->VcdCosto = round($DatVentaConcretadaDetalle->VcdCosto / $InsVentaConcretada->VcoTipoCambio,2);
				$DatVentaConcretadaDetalle->VcdPrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta / $InsVentaConcretada->VcoTipoCambio,2);
				$DatVentaConcretadaDetalle->VcdImporte = round($DatVentaConcretadaDetalle->VcdImporte / $InsVentaConcretada->VcoTipoCambio,2);

			}

//				SesionObjeto-VentaConcretadaDetalle
//				Parametro1 = VcdId
//				Parametro2 = ProId
//				Parametro3 = ProNombre
//				Parametro4 = VcdPrecio
//				Parametro5 = VcdCantidad
//				Parametro6 = VcdImporte
//				Parametro7 = VcdTiempoCreacion
//				Parametro8 = VcdTiempoModificacion
//				Parametro9 = UmeNombre
//				Parametro10 = UmeId
//				Parametro11 = RtiId
//				Parametro12 = VcdCantidadReal
//				Parametro13 = ProCodigoOriginal,
//				Parametro14 = ProCodigoAlternativo
//				Parametro15 = UmeIdOrigen
//				Parametro16 = VerificarStock
//				Parametro17 = VcdCosto
//				Parametro18 = VddId
//				Parametro19 = AmdReemplazo
//				Parametro20 = ProCodigoOriginalReemplazo
//				Parametro21 = VcdReingreso
//				Parametro22 = VcdCantidadRealAnterior

				$_SESSION['InsVentaConcretadaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
				$DatVentaConcretadaDetalle->VcdId,
				$DatVentaConcretadaDetalle->ProId,
				$DatVentaConcretadaDetalle->ProNombre,
				$DatVentaConcretadaDetalle->VcdPrecioVenta,
				$DatVentaConcretadaDetalle->VcdCantidad,
				$DatVentaConcretadaDetalle->VcdImporte,
				($DatVentaConcretadaDetalle->VcdTiempoCreacion),
				($DatVentaConcretadaDetalle->VcdTiempoModificacion),
				$DatVentaConcretadaDetalle->UmeNombre,
				$DatVentaConcretadaDetalle->UmeId,
				$DatVentaConcretadaDetalle->RtiId,
				$DatVentaConcretadaDetalle->VcdCantidadReal,
				$DatVentaConcretadaDetalle->ProCodigoOriginal,
				$DatVentaConcretadaDetalle->ProCodigoAlternativo,
				$DatVentaConcretadaDetalle->UmeIdOrigen,
				2,
				$DatVentaConcretadaDetalle->VcdCosto,
				$DatVentaConcretadaDetalle->VddId,
				
				$DatVentaConcretadaDetalle->AmdReemplazo,
				$DatVentaConcretadaDetalle->ProCodigoOriginalReemplazo,
				$DatVentaConcretadaDetalle->VcdReingreso,
				$DatVentaConcretadaDetalle->VcdCantidadReal
			);
		
		}
	}
	
}


?>