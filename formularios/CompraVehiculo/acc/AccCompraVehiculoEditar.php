<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsCompraVehiculo->UsuId = $_SESSION['SesionId'];		
	$InsCompraVehiculo->CvhId = $_POST['CmpId'];
	$InsCompraVehiculo->PrvId = $_POST['CmpProveedorId'];
	$InsCompraVehiculo->CtiId = $_POST['CmpComprobanteTipo'];	
	$InsCompraVehiculo->TopId = $_POST['CmpTipoOperacion'];	
	$InsCompraVehiculo->OcoId = $_POST['CmpOrdenCompra'];	
	$InsCompraVehiculo->AlmId = $_POST['CmpAlmacen'];
	
	$InsCompraVehiculo->SucId = $_POST['CmpSucursal'];	
	
	$InsCompraVehiculo->CvhPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
	$InsCompraVehiculo->CvhFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsCompraVehiculo->CvhObservacion = addslashes($_POST['CmpObservacion']);
	$InsCompraVehiculo->CvhDocumentoOrigen = $_POST['CmpDocumentoOrigen'];
	
	$InsCompraVehiculo->CvhComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsCompraVehiculo->CvhComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsCompraVehiculo->CvhComprobanteNumero = $InsCompraVehiculo->CvhComprobanteNumeroSerie."-".$InsCompraVehiculo->CvhComprobanteNumeroNumero;
	
	$InsCompraVehiculo->CvhComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);	
	
	$InsCompraVehiculo->CvhGuiaRemisionNumeroSerie = $_POST['CmpGuiaRemisionNumeroSerie'];	
	$InsCompraVehiculo->CvhGuiaRemisionNumeroNumero = $_POST['CmpGuiaRemisionNumeroNumero'];	
	$InsCompraVehiculo->CvhGuiaRemisionNumero = $InsCompraVehiculo->CvhGuiaRemisionNumeroSerie."-".$InsCompraVehiculo->CvhGuiaRemisionNumeroNumero;
	
	$InsCompraVehiculo->CvhGuiaRemisionFecha = FncCambiaFechaAMysql($_POST['CmpGuiaRemisionFecha'],true);	
	$InsCompraVehiculo->CvhGuiaRemisionFoto = $_SESSION['SesCveGuiaRemisionFoto'.$Identificador];

	$InsCompraVehiculo->MonId = $_POST['CmpMonedaId'];
	$InsCompraVehiculo->CvhTipoCambio = $_POST['CmpTipoCambio'];
	$InsCompraVehiculo->CvhTipoCambioComercial = $_POST['CmpTipoCambioComercial'];

	$InsCompraVehiculo->CvhIncluyeImpuesto = 2;
	
	$InsCompraVehiculo->CvhMargenUtilidad = 0.00;
	$InsCompraVehiculo->CvhTipo = 1;
	$InsCompraVehiculo->CvhSubTipo = 1	;

	$InsCompraVehiculo->NpaId = $_POST['CmpCondicionPago'];
	$InsCompraVehiculo->CvhCantidadDia = isset($_POST['CmpCantidadDia'])?$_POST['CmpCantidadDia']:0;
	
	$InsCompraVehiculo->CvhEstado = $_POST['CmpEstado'];
	$InsCompraVehiculo->CvhTiempoModificacion = date("Y-m-d H:i:s");
	$InsCompraVehiculo->CvhEliminado = 1;

	$InsCompraVehiculo->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsCompraVehiculo->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsCompraVehiculo->PrvNombreCompleto = $_POST['CmpProveedorNombre'];
	$InsCompraVehiculo->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsCompraVehiculo->CvhFoto = $_SESSION['SesCveFoto'.$Identificador];

	settype($InsCompraVehiculo->CvhTipoCambio,"float");
			
	$InsCompraVehiculo->CompraVehiculoDetalle = array();

	
	if($InsCompraVehiculo->MonId<>$EmpresaMonedaId){
		if(empty($InsCompraVehiculo->CvhTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_CVH_600';
		}
	}

	if(empty($InsCompraVehiculo->SucId)){
		$Guardar = false;
		$Resultado.='#ERR_CVH_602';
	}
	
	$InsCompraVehiculo->CvhTotalBruto = 0;
	$InsCompraVehiculo->CvhSubTotal = 0;
	$InsCompraVehiculo->CvhImpuesto = 0;
	$InsCompraVehiculo->CvhTotal = 0;
	
	$InsCompraVehiculo->CvhValorTotal = 0;
	
	$ResCompraVehiculoDetalle = $_SESSION['InsCompraVehiculoDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

//SesionObjeto-CompraVehiculoDetalle
//Parametro1 = CvdId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = CvdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
	
	if(!empty($ResCompraVehiculoDetalle['Datos'])){
		foreach($ResCompraVehiculoDetalle['Datos'] as $DatSesionObjeto){
			
			if($InsCompraVehiculo->MonId<>$EmpresaMonedaId){
				
				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsCompraVehiculo->CvhTipoCambio;
				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsCompraVehiculo->CvhTipoCambio;
				$DatSesionObjeto->Parametro13 = $DatSesionObjeto->Parametro13 * $InsCompraVehiculo->CvhTipoCambio;
				$DatSesionObjeto->Parametro15 = $DatSesionObjeto->Parametro15 * $InsCompraVehiculo->CvhTipoCambio;
				
			}
			
			$InsCompraVehiculoDetalle1 = new ClsCompraVehiculoDetalle();
			$InsCompraVehiculoDetalle1->CvdId = $DatSesionObjeto->Parametro1;
			$InsCompraVehiculoDetalle1->EinId = $DatSesionObjeto->Parametro2;
			$InsCompraVehiculoDetalle1->VehId = $DatSesionObjeto->Parametro12;
			
			$InsCompraVehiculoDetalle1->CvdIdAnterior = $InsCompraVehiculoDetalle1->MtdObtenerUltimoCompraVehiculoDetalleId($InsCompraVehiculoDetalle1->VehId,$InsCompraVehiculo->CvhFecha);
		
			$InsCompraVehiculoDetalle1->CvdCosto = $DatSesionObjeto->Parametro4;
			$InsCompraVehiculoDetalle1->CvdCantidad = $DatSesionObjeto->Parametro5;
			$InsCompraVehiculoDetalle1->CvdImporte = $DatSesionObjeto->Parametro6;
			
			$InsCompraVehiculoDetalle1->CvdCostoAnterior = $DatSesionObjeto->Parametro15;		
			$InsCompraVehiculoDetalle1->CvdUtilidad = $DatSesionObjeto->Parametro13;
			$InsCompraVehiculoDetalle1->CvdUtilidadPorcentaje = $DatSesionObjeto->Parametro14;
			
			$InsCompraVehiculoDetalle1->CvdCostoExtraTotal = 0;
			$InsCompraVehiculoDetalle1->CvdCostoExtraUnitario = 0;
			
			
			$InsCompraVehiculoDetalle1->CvdCaracteristica1 = (empty( $DatSesionObjeto->Parametro31)?0: $DatSesionObjeto->Parametro31);
			$InsCompraVehiculoDetalle1->CvdCaracteristica2 = (empty( $DatSesionObjeto->Parametro32)?0: $DatSesionObjeto->Parametro32);
			$InsCompraVehiculoDetalle1->CvdCaracteristica3 = (empty( $DatSesionObjeto->Parametro33)?0: $DatSesionObjeto->Parametro33);
			$InsCompraVehiculoDetalle1->CvdCaracteristica4 = (empty( $DatSesionObjeto->Parametro34)?0: $DatSesionObjeto->Parametro34);
			$InsCompraVehiculoDetalle1->CvdCaracteristica5 = (empty( $DatSesionObjeto->Parametro35)?0: $DatSesionObjeto->Parametro35);
			$InsCompraVehiculoDetalle1->CvdCaracteristica6 = (empty( $DatSesionObjeto->Parametro36)?0: $DatSesionObjeto->Parametro36);
			$InsCompraVehiculoDetalle1->CvdCaracteristica7 = (empty( $DatSesionObjeto->Parametro37)?0: $DatSesionObjeto->Parametro37);
			$InsCompraVehiculoDetalle1->CvdCaracteristica8 = (empty( $DatSesionObjeto->Parametro38)?0: $DatSesionObjeto->Parametro38);
			$InsCompraVehiculoDetalle1->CvdCaracteristica9 = (empty( $DatSesionObjeto->Parametro39)?0: $DatSesionObjeto->Parametro39);
			$InsCompraVehiculoDetalle1->CvdCaracteristica10 = (empty( $DatSesionObjeto->Parametro40)?0: $DatSesionObjeto->Parametro40);
			$InsCompraVehiculoDetalle1->CvdCaracteristica11 = (empty( $DatSesionObjeto->Parametro41)?0: $DatSesionObjeto->Parametro41);
			$InsCompraVehiculoDetalle1->CvdCaracteristica12 = (empty( $DatSesionObjeto->Parametro42)?0: $DatSesionObjeto->Parametro42);
			$InsCompraVehiculoDetalle1->CvdCaracteristica13 = (empty( $DatSesionObjeto->Parametro43)?0: $DatSesionObjeto->Parametro43);
			$InsCompraVehiculoDetalle1->CvdCaracteristica14 = (empty( $DatSesionObjeto->Parametro44)?0: $DatSesionObjeto->Parametro44);
			$InsCompraVehiculoDetalle1->CvdCaracteristica15 = (empty( $DatSesionObjeto->Parametro44)?0: $DatSesionObjeto->Parametro44);
			$InsCompraVehiculoDetalle1->CvdCaracteristica16 = (empty( $DatSesionObjeto->Parametro45)?0: $DatSesionObjeto->Parametro45);
			$InsCompraVehiculoDetalle1->CvdCaracteristica17 = (empty( $DatSesionObjeto->Parametro46)?0: $DatSesionObjeto->Parametro46);
			$InsCompraVehiculoDetalle1->CvdCaracteristica18 = (empty( $DatSesionObjeto->Parametro47)?0: $DatSesionObjeto->Parametro47);
			$InsCompraVehiculoDetalle1->CvdCaracteristica19 = (empty( $DatSesionObjeto->Parametro48)?0: $DatSesionObjeto->Parametro48);
			$InsCompraVehiculoDetalle1->CvdCaracteristica20 = (empty( $DatSesionObjeto->Parametro49)?0: $DatSesionObjeto->Parametro49);
			
			$InsCompraVehiculoDetalle1->CvdEstado = $DatSesionObjeto->Parametro25;
			$InsCompraVehiculoDetalle1->CvdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsCompraVehiculoDetalle1->CvdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsCompraVehiculoDetalle1->CvdEliminado = $DatSesionObjeto->Eliminado;				
			$InsCompraVehiculoDetalle1->InsMysql = NULL;

			$InsCompraVehiculoDetalle1->CvdValorTotal =  round($InsCompraVehiculoDetalle1->CvdCosto + ($InsCompraVehiculoDetalle1->CvdCostoExtraUnitario/(($InsCompraVehiculo->CvhPorcentajeImpuestoVenta/100)+1)),6);

			settype($InsCompraVehiculoDetalle1->CvdCostoAnterior,"float");

			if(empty($InsCompraVehiculoDetalle1->CvdCostoAnterior)){
				$InsCompraVehiculoDetalle1->CvdCostoPromedio =  round(($InsCompraVehiculoDetalle1->CvdValorTotal),6);				
			}else{
				$InsCompraVehiculoDetalle1->CvdCostoPromedio =  round(($InsCompraVehiculoDetalle1->CvdValorTotal + $InsCompraVehiculoDetalle1->CvdCostoAnterior)/2,6);				
			}		
			
			$InsCompraVehiculo->CompraVehiculoDetalle[] = $InsCompraVehiculoDetalle1;

			if($InsCompraVehiculoDetalle1->CvdEliminado==1){
				$InsCompraVehiculo->CvhTotalBruto += $InsCompraVehiculoDetalle1->CvdImporte;
			}			

		}		
	
	}else{
		$Guardar = false;
		$Resultado.='#ERR_CVH_111';
	}

$InsCompraVehiculo->CvhSubTotal = $InsCompraVehiculo->CvhTotalBruto;
	$InsCompraVehiculo->CvhImpuesto = round( ($InsCompraVehiculo->CvhSubTotal + $InsCompraVehiculo->CvhNacionalTotalRecargo) * ($InsCompraVehiculo->CvhPorcentajeImpuestoVenta/100),3);
	
	$InsCompraVehiculo->CvhTotal = $InsCompraVehiculo->CvhSubTotal + $InsCompraVehiculo->CvhImpuesto;

	if($Guardar){
		
		if($InsCompraVehiculo->MtdEditarCompraVehiculo()){		
		
			if($_POST['CmpNotificar']=="1"){
				
				$InsCompraVehiculo->MtdNotificarCompraVehiculoRegistro($InsCompraVehiculo->CvhId,$CorreosNotificacionCompraVehiculoRegistro,false);
			
			}
			
			FncCargarDatos();
			$Resultado.='#SAS_CVH_102';
			$Edito = true;

		} else{
	
			$InsCompraVehiculo->CvhFecha = FncCambiaFechaANormal($InsCompraVehiculo->CvhFecha);
			$InsCompraVehiculo->CvhComprobanteFecha = FncCambiaFechaANormal($InsCompraVehiculo->CvhComprobanteFecha,true);
			$InsCompraVehiculo->CvhGuiaRemisionFecha = FncCambiaFechaANormal($InsCompraVehiculo->CvhGuiaRemisionFecha,true);
			
			$Resultado.='#ERR_CVH_102';
		}
		
	}else{
		
		$InsCompraVehiculo->CvhFecha = FncCambiaFechaANormal($InsCompraVehiculo->CvhFecha);
		$InsCompraVehiculo->CvhComprobanteFecha = FncCambiaFechaANormal($InsCompraVehiculo->CvhComprobanteFecha,true);
		$InsCompraVehiculo->CvhGuiaRemisionFecha = FncCambiaFechaANormal($InsCompraVehiculo->CvhGuiaRemisionFecha,true);

	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){

	global $GET_id;
	global $Identificador;
	global $InsCompraVehiculo;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsCompraVehiculoDetalle'.$Identificador]);
	unset($_SESSION['SesCveFoto'.$Identificador]);
	unset($_SESSION['SesCveGuiaRemisionFoto'.$Identificador]);
	
	$_SESSION['InsCompraVehiculoDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsCompraVehiculo->CvhId = $GET_id;
	$InsCompraVehiculo->MtdObtenerCompraVehiculo();		

	
	$_SESSION['SesCveFoto'.$Identificador] =	$InsCompraVehiculo->CvhFoto;
	$_SESSION['SesCveGuiaRemisionFoto'.$Identificador] = $InsCompraVehiculo->CvhGuiaRemisionFoto;


	if($InsCompraVehiculo->MonId<>$EmpresaMonedaId and (!empty($InsCompraVehiculo->CvhTipoCambio) )){
		$InsCompraVehiculo->CvhValorTotal = round($InsCompraVehiculo->CvhValorTotal / $InsCompraVehiculo->CvhTipoCambio,3);
	}
			
	//deb($InsCompraVehiculo->CompraVehiculoDetalle);
	if(!empty($InsCompraVehiculo->CompraVehiculoDetalle)){
		foreach($InsCompraVehiculo->CompraVehiculoDetalle as $DatCompraVehiculoDetalle){

			if($InsCompraVehiculo->MonId<>$EmpresaMonedaId and (!empty($InsCompraVehiculo->CvhTipoCambio) )){
				
				$DatCompraVehiculoDetalle->CvdImporte = round($DatCompraVehiculoDetalle->CvdImporte / $InsCompraVehiculo->CvhTipoCambio,3);
				$DatCompraVehiculoDetalle->CvdCosto = round($DatCompraVehiculoDetalle->CvdCosto  / $InsCompraVehiculo->CvhTipoCambio,3);
				$DatCompraVehiculoDetalle->CvdCostoAnterior = round($DatCompraVehiculoDetalle->CvdCostoAnterior  / $InsCompraVehiculo->CvhTipoCambio,3);
				$DatCompraVehiculoDetalle->CvdUtilidad = round($DatCompraVehiculoDetalle->CvdUtilidad  / $InsCompraVehiculo->CvhTipoCambio,3);
				
			}



//SesionObjeto-CompraVehiculoDetalle
//Parametro1 = CvdId
//Parametro2 = EinId
//Parametro3 = EinVIN

//Parametro4 = CvdCosto
//Parametro5 = CvdCantidad
//Parametro6 = CvdImporte
//Parametro7 = CvdTiempoCreacion
//Parametro8 = CvdTiempoModificacion

//Parametro9 = EinNumeroMotor
//Parametro10 = EinAnoFabricacion
//Parametro11 = EinAnoModelo
//Parametro12 = VehId

//Parametro13 = CvdUtilidad
//Parametro14 = CvdUtilidadPorcentaje
//Parametro15 = CvdCostoAnterior
//Parametro16 = 
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = CvdEstado
				
			$_SESSION['InsCompraVehiculoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatCompraVehiculoDetalle->CvdId,
			$DatCompraVehiculoDetalle->EinId,
			$DatCompraVehiculoDetalle->EinVIN,
			$DatCompraVehiculoDetalle->CvdCosto,
			$DatCompraVehiculoDetalle->CvdCantidad,
			$DatCompraVehiculoDetalle->CvdImporte,
			($DatCompraVehiculoDetalle->CvdTiempoCreacion),
			($DatCompraVehiculoDetalle->CvdTiempoModificacion),
			$DatCompraVehiculoDetalle->EinNumeroMotor,
			$DatCompraVehiculoDetalle->EinAnoFabricacion,
			$DatCompraVehiculoDetalle->EinAnoModelo,
			$DatCompraVehiculoDetalle->VehId,			
			
			$DatCompraVehiculoDetalle->CvdUtilidad,
			$DatCompraVehiculoDetalle->CvdUtilidadPorcentaje,
			$DatCompraVehiculoDetalle->CvdCostoAnterior,
			NULL,
			$DatCompraVehiculoDetalle->EinColor,
			$DatCompraVehiculoDetalle->EinColorInterior,
			$DatCompraVehiculoDetalle->VmaNombre,
			$DatCompraVehiculoDetalle->VmoNombre,
			$DatCompraVehiculoDetalle->VveNombre,
			$DatCompraVehiculoDetalle->VmaId,
			$DatCompraVehiculoDetalle->VmoId,
			$DatCompraVehiculoDetalle->VveId,
			$DatCompraVehiculoDetalle->CvdEstado);

		}
	}
	
	
}
?>