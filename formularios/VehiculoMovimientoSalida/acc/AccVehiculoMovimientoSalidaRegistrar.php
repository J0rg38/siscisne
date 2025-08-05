<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsVehiculoMovimientoSalida->UsuId = $_SESSION['SesionId'];	

	$InsVehiculoMovimientoSalida->VmvId = $_POST['CmpId'];
	$InsVehiculoMovimientoSalida->CliId = $_POST['CmpClienteId'];
	$InsVehiculoMovimientoSalida->CtiId = $_POST['CmpComprobanteTipo'];	
	$InsVehiculoMovimientoSalida->TopId = $_POST['CmpTipoOperacion'];	
	$InsVehiculoMovimientoSalida->OcoId = $_POST['CmpOrdenCompra'];	
	$InsVehiculoMovimientoSalida->AlmId = $_POST['CmpAlmacen'];	
	
	$InsVehiculoMovimientoSalida->SucId = $_POST['CmpSucursal'];	
	$InsVehiculoMovimientoSalida->SucIdDestino = $_POST['CmpSucursalDestino'];	
	
//	$InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	$InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
	$InsVehiculoMovimientoSalida->VmvFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsVehiculoMovimientoSalida->VmvObservacion = addslashes($_POST['CmpObservacion']);
	$InsVehiculoMovimientoSalida->VmvDocumentoOrigen = $_POST['CmpDocumentoOrigen'];
	
	$InsVehiculoMovimientoSalida->VmvComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsVehiculoMovimientoSalida->VmvComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsVehiculoMovimientoSalida->VmvComprobanteNumero = $InsVehiculoMovimientoSalida->VmvComprobanteNumeroSerie."-".$InsVehiculoMovimientoSalida->VmvComprobanteNumeroNumero;
	
	$InsVehiculoMovimientoSalida->VmvComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);	

	$InsVehiculoMovimientoSalida->VmvGuiaRemisionNumeroSerie = $_POST['CmpGuiaRemisionNumeroSerie'];	
	$InsVehiculoMovimientoSalida->VmvGuiaRemisionNumeroNumero = $_POST['CmpGuiaRemisionNumeroNumero'];	
	$InsVehiculoMovimientoSalida->VmvGuiaRemisionNumero = $InsVehiculoMovimientoSalida->VmvGuiaRemisionNumeroSerie."-".$InsVehiculoMovimientoSalida->VmvGuiaRemisionNumeroNumero;	
	
	$InsVehiculoMovimientoSalida->VmvGuiaRemisionFecha = FncCambiaFechaAMysql($_POST['CmpGuiaRemisionFecha'],true);	
	$InsVehiculoMovimientoSalida->VmvGuiaRemisionFoto = $_SESSION['SesVmvGuiaRemisionFoto'.$Identificador];

	$InsVehiculoMovimientoSalida->MonId = $_POST['CmpMonedaId'];
	$InsVehiculoMovimientoSalida->VmvTipoCambio = $_POST['CmpTipoCambio'];
	$InsVehiculoMovimientoSalida->VmvTipoCambioComercial = $_POST['CmpTipoCambioComercial'];
	
	$InsVehiculoMovimientoSalida->VmvIncluyeImpuesto = 2;

	$InsVehiculoMovimientoSalida->VmvMargenUtilidad = 0.00;
	$InsVehiculoMovimientoSalida->VmvTipo = 2;
	$InsVehiculoMovimientoSalida->VmvSubTipo = 1;

	$InsVehiculoMovimientoSalida->NpaId = $_POST['CmpCondicionPago'];
	$InsVehiculoMovimientoSalida->VmvCantidadDia = isset($_POST['CmpCantidadDia'])?$_POST['CmpCantidadDia']:0;
	
	$InsVehiculoMovimientoSalida->VmvEstado = $_POST['CmpEstado'];
	
	$InsVehiculoMovimientoSalida->VmvTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoMovimientoSalida->VmvTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculoMovimientoSalida->VmvEliminado = 1;
	
	$InsVehiculoMovimientoSalida->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsVehiculoMovimientoSalida->CliNombre = $_POST['CmpClienteNombre'];
	$InsVehiculoMovimientoSalida->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsVehiculoMovimientoSalida->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsVehiculoMovimientoSalida->CliNombreCompleto = $_POST['CmpClienteNombreCompleto'];
	$InsVehiculoMovimientoSalida->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	
	$InsVehiculoMovimientoSalida->VmvFoto = $_SESSION['SesVmvFoto'.$Identificador];

	settype($InsVehiculoMovimientoSalida->VmvTipoCambio,"float");
		
	$InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle = array();
	
	if($InsVehiculoMovimientoSalida->MonId<>$EmpresaMonedaId){
		if(empty($InsVehiculoMovimientoSalida->VmvTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_VMS_600';
		}
	}
	
	if(empty($InsVehiculoMovimientoSalida->SucId)){
		$Guardar = false;
		$Resultado.='#ERR_VMS_602';
	}
	
	
	$InsVehiculoMovimientoSalida->VmvTotalBruto = 0;
	$InsVehiculoMovimientoSalida->VmvSubTotal = 0;
	$InsVehiculoMovimientoSalida->VmvImpuesto = 0;
	$InsVehiculoMovimientoSalida->VmvTotal = 0;
	$InsVehiculoMovimientoSalida->VmvValorTotal = 0;
	
	

//SesionObjeto-VehiculoMovimientoEntradaDetalle
//Parametro1 = VmdId
//Parametro2 = EinId
//Parametro3 = EinVIN

//Parametro4 = VmdCosto
//Parametro5 = VmdCantidad
//Parametro6 = VmdImporte
//Parametro7 = VmdTiempoCreacion
//Parametro8 = VmdTiempoModificacion

//Parametro9 = EinNumeroMotor
//Parametro10 = EinAnoFabricacion
//Parametro11 = EinAnoModelo
//Parametro12 = VehId

//Parametro13 = VmdUtilidad
//Parametro14 = VmdUtilidadPorcentaje
//Parametro15 = VmdCostoAnterior
//Parametro16 = 
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = VmdEstado
//Parametro26 = VehCodigoIdentificador
//Parametro27 = UmeId
//Parametro28 = UmeNombre
//Parametro29 = VmdCostoIngreso

	$ResVehiculoMovimientoSalidaDetalle = $_SESSION['InsVehiculoMovimientoSalidaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	
	if(!empty($ResVehiculoMovimientoSalidaDetalle['Datos'])){
		foreach($ResVehiculoMovimientoSalidaDetalle['Datos'] as $DatSesionObjeto){
			
			if($InsVehiculoMovimientoSalida->MonId<>$EmpresaMonedaId){
				
				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsVehiculoMovimientoSalida->VmvTipoCambio;
				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsVehiculoMovimientoSalida->VmvTipoCambio;
				$DatSesionObjeto->Parametro13 = $DatSesionObjeto->Parametro13 * $InsVehiculoMovimientoSalida->VmvTipoCambio;
				$DatSesionObjeto->Parametro15 = $DatSesionObjeto->Parametro15 * $InsVehiculoMovimientoSalida->VmvTipoCambio;
				
			}
		
			$InsVehiculoMovimientoSalidaDetalle1 = new ClsVehiculoMovimientoSalidaDetalle();
			$InsVehiculoMovimientoSalidaDetalle1->VmdId = $DatSesionObjeto->Parametro1;
			$InsVehiculoMovimientoSalidaDetalle1->EinId = $DatSesionObjeto->Parametro2;
			$InsVehiculoMovimientoSalidaDetalle1->VehId = $DatSesionObjeto->Parametro12;
			$InsVehiculoMovimientoSalidaDetalle1->UmeId = $DatSesionObjeto->Parametro27;
			
			$InsVehiculoMovimientoSalidaDetalle1->VmdIdAnterior = $InsVehiculoMovimientoSalidaDetalle1->MtdObtenerUltimoVehiculoMovimientoSalidaDetalleId($InsVehiculoMovimientoSalidaDetalle1->VehId,$InsVehiculoMovimientoSalida->VmvFecha);
		
			$InsVehiculoMovimientoSalidaDetalle1->VmdCosto = $DatSesionObjeto->Parametro4;
			$InsVehiculoMovimientoSalidaDetalle1->VmdCostoIngreso = $DatSesionObjeto->Parametro29;
			$InsVehiculoMovimientoSalidaDetalle1->VmdCantidad = $DatSesionObjeto->Parametro5;
			$InsVehiculoMovimientoSalidaDetalle1->VmdImporte = $DatSesionObjeto->Parametro6;
			$InsVehiculoMovimientoSalidaDetalle1->VmdObservacion = $DatSesionObjeto->Parametro16;

			$InsVehiculoMovimientoSalidaDetalle1->VmdFecha = 	$InsVehiculoMovimientoSalida->VmvFecha;
		
			$InsVehiculoMovimientoSalidaDetalle1->VmdCostoAnterior = $DatSesionObjeto->Parametro15;		
			$InsVehiculoMovimientoSalidaDetalle1->VmdUtilidad = $DatSesionObjeto->Parametro13;
			$InsVehiculoMovimientoSalidaDetalle1->VmdUtilidadPorcentaje = $DatSesionObjeto->Parametro14;
			
			$InsVehiculoMovimientoSalidaDetalle1->VmdCostoExtraTotal = 0;
			$InsVehiculoMovimientoSalidaDetalle1->VmdCostoExtraUnitario = 0;
			
			
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica1 = (empty( $DatSesionObjeto->Parametro31)?0: $DatSesionObjeto->Parametro31);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica2 = (empty( $DatSesionObjeto->Parametro32)?0: $DatSesionObjeto->Parametro32);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica3 = (empty( $DatSesionObjeto->Parametro33)?0: $DatSesionObjeto->Parametro33);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica4 = (empty( $DatSesionObjeto->Parametro34)?0: $DatSesionObjeto->Parametro34);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica5 = (empty( $DatSesionObjeto->Parametro35)?0: $DatSesionObjeto->Parametro35);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica6 = (empty( $DatSesionObjeto->Parametro36)?0: $DatSesionObjeto->Parametro36);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica7 = (empty( $DatSesionObjeto->Parametro37)?0: $DatSesionObjeto->Parametro37);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica8 = (empty( $DatSesionObjeto->Parametro38)?0: $DatSesionObjeto->Parametro38);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica9 = (empty( $DatSesionObjeto->Parametro39)?0: $DatSesionObjeto->Parametro39);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica10 = (empty( $DatSesionObjeto->Parametro40)?0: $DatSesionObjeto->Parametro40);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica11 = (empty( $DatSesionObjeto->Parametro41)?0: $DatSesionObjeto->Parametro41);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica12 = (empty( $DatSesionObjeto->Parametro42)?0: $DatSesionObjeto->Parametro42);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica13 = (empty( $DatSesionObjeto->Parametro43)?0: $DatSesionObjeto->Parametro43);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica14 = (empty( $DatSesionObjeto->Parametro44)?0: $DatSesionObjeto->Parametro44);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica15 = (empty( $DatSesionObjeto->Parametro44)?0: $DatSesionObjeto->Parametro44);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica16 = (empty( $DatSesionObjeto->Parametro45)?0: $DatSesionObjeto->Parametro45);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica17 = (empty( $DatSesionObjeto->Parametro46)?0: $DatSesionObjeto->Parametro46);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica18 = (empty( $DatSesionObjeto->Parametro47)?0: $DatSesionObjeto->Parametro47);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica19 = (empty( $DatSesionObjeto->Parametro48)?0: $DatSesionObjeto->Parametro48);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica20 = (empty( $DatSesionObjeto->Parametro49)?0: $DatSesionObjeto->Parametro49);

			
			
			//$InsVehiculoMovimientoSalidaDetalle1->VmdEstado = $DatSesionObjeto->Parametro25;
			$InsVehiculoMovimientoSalidaDetalle1->VmdEstado = $_POST['CmpVehiculoMovimientoSalidaDetalleEstado_'.$DatSesionObjeto->Item];		
			$InsVehiculoMovimientoSalidaDetalle1->VmdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsVehiculoMovimientoSalidaDetalle1->VmdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsVehiculoMovimientoSalidaDetalle1->VmdEliminado = $DatSesionObjeto->Eliminado;				
			$InsVehiculoMovimientoSalidaDetalle1->InsMysql = NULL;

			$InsVehiculoMovimientoSalidaDetalle1->VmdValorTotal =  round($InsVehiculoMovimientoSalidaDetalle1->VmdCosto + ($InsVehiculoMovimientoSalidaDetalle1->VmdCostoExtraUnitario/(($InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta/100)+1)),6);

			settype($InsVehiculoMovimientoSalidaDetalle1->VmdCostoAnterior,"float");

			if(empty($InsVehiculoMovimientoSalidaDetalle1->VmdCostoAnterior)){
				$InsVehiculoMovimientoSalidaDetalle1->VmdCostoPromedio =  round(($InsVehiculoMovimientoSalidaDetalle1->VmdValorTotal),6);				
			}else{
				$InsVehiculoMovimientoSalidaDetalle1->VmdCostoPromedio =  round(($InsVehiculoMovimientoSalidaDetalle1->VmdValorTotal + $InsVehiculoMovimientoSalidaDetalle1->VmdCostoAnterior)/2,6);				
			}		
						
			if($InsVehiculoMovimientoSalidaDetalle1->VmdEliminado==1){	
							
				$InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle[] = $InsVehiculoMovimientoSalidaDetalle1;		
				$InsVehiculoMovimientoSalida->VmvTotalBruto += $InsVehiculoMovimientoSalidaDetalle1->VmdImporte;
				
			}
		}		
		
	}else{
		//$Guardar = false;
		//$Resultado.='#ERR_VMS_111';
	}

	$InsVehiculoMovimientoSalida->VmvSubTotal = $InsVehiculoMovimientoSalida->VmvTotalBruto;
	$InsVehiculoMovimientoSalida->VmvImpuesto = round( ($InsVehiculoMovimientoSalida->VmvSubTotal + $InsVehiculoMovimientoSalida->VmvNacionalTotalRecargo) * ($InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta/100),3);
	
	$InsVehiculoMovimientoSalida->VmvTotal = $InsVehiculoMovimientoSalida->VmvSubTotal + $InsVehiculoMovimientoSalida->VmvImpuesto;


	if($Guardar){

		if($InsVehiculoMovimientoSalida->MtdRegistrarVehiculoMovimientoSalida()){

			if($_POST['CmpNotificar']=="1"){
				
				$InsVehiculoMovimientoSalida->MtdNotificarVehiculoMovimientoSalidaRegistro($InsVehiculoMovimientoSalida->VmvId,$CorreosNotificacionVehiculoMovimientoSalidaRegistro,false);
				
				
			}
			
			FncNuevo();
		
			$Resultado.='#SAS_VMS_101';
			$Registro = true;
		}else{
			
			$InsVehiculoMovimientoSalida->VmvFecha = FncCambiaFechaANormal($InsVehiculoMovimientoSalida->VmvFecha);
			$InsVehiculoMovimientoSalida->VmvComprobanteFecha = FncCambiaFechaANormal($InsVehiculoMovimientoSalida->VmvComprobanteFecha,true);
			$InsVehiculoMovimientoSalida->VmvGuiaRemisionFecha = FncCambiaFechaANormal($InsVehiculoMovimientoSalida->VmvGuiaRemisionFecha,true);


			$Resultado.='#ERR_VMS_101';	
		}
			
	}else{
		
			$InsVehiculoMovimientoSalida->VmvFecha = FncCambiaFechaANormal($InsVehiculoMovimientoSalida->VmvFecha);
			$InsVehiculoMovimientoSalida->VmvComprobanteFecha = FncCambiaFechaANormal($InsVehiculoMovimientoSalida->VmvComprobanteFecha,true);
			$InsVehiculoMovimientoSalida->VmvGuiaRemisionFecha = FncCambiaFechaANormal($InsVehiculoMovimientoSalida->VmvGuiaRemisionFecha,true);
			
		
	}
	


}else{

	FncNuevo();
	
	switch($GET_Ori){
		
		case "OrdenCompra":
			

		break;
	}
}



function FncNuevo(){

	global $Identificador;
	global $InsVehiculoMovimientoSalida;
		
	unset($_SESSION['InsVehiculoMovimientoSalidaDetalle'.$Identificador]);
	unset($_SESSION['InsOrdenCompraPedido'.$Identificador]);
	
	unset($_SESSION['SesCveFoto'.$Identificador]);
	
	$_SESSION['InsVehiculoMovimientoSalidaDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();
	
	$InsVehiculoMovimientoSalida->VmvEstado = 3;

	$InsVehiculoMovimientoSalida->TopId = "TOP-10010";
	$InsVehiculoMovimientoSalida->CtiId = "CTI-10006";
	$InsVehiculoMovimientoSalida->TdoId = "TDO-10003";
	$InsVehiculoMovimientoSalida->NpaId = "NPA-10000";
	$InsVehiculoMovimientoSalida->VmvCantidadDia = 0;
	$InsVehiculoMovimientoSalida->SucId = $_SESSION['SesionSucursal'];
	$InsVehiculoMovimientoSalida->AlmId = "";

}
?>