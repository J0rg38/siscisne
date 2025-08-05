<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsVehiculoMovimientoEntrada->UsuId = $_SESSION['SesionId'];	

	$InsVehiculoMovimientoEntrada->VmvId = $_POST['CmpId'];
	$InsVehiculoMovimientoEntrada->PrvId = $_POST['CmpProveedorId'];
	$InsVehiculoMovimientoEntrada->CtiId = $_POST['CmpComprobanteTipo'];	
	$InsVehiculoMovimientoEntrada->TopId = $_POST['CmpTipoOperacion'];	
	$InsVehiculoMovimientoEntrada->OcoId = $_POST['CmpOrdenCompra'];	
	$InsVehiculoMovimientoEntrada->AlmId = $_POST['CmpAlmacen'];	
	
	$InsVehiculoMovimientoEntrada->SucId = $_POST['CmpSucursal'];	
	
//	$InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	$InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
	$InsVehiculoMovimientoEntrada->VmvFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsVehiculoMovimientoEntrada->VmvObservacion = addslashes($_POST['CmpObservacion']);
	$InsVehiculoMovimientoEntrada->VmvDocumentoOrigen = $_POST['CmpDocumentoOrigen'];
	
	$InsVehiculoMovimientoEntrada->VmvComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsVehiculoMovimientoEntrada->VmvComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsVehiculoMovimientoEntrada->VmvComprobanteNumero = $InsVehiculoMovimientoEntrada->VmvComprobanteNumeroSerie."-".$InsVehiculoMovimientoEntrada->VmvComprobanteNumeroNumero;
	
	$InsVehiculoMovimientoEntrada->VmvComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);	

	$InsVehiculoMovimientoEntrada->VmvGuiaRemisionNumeroSerie = $_POST['CmpGuiaRemisionNumeroSerie'];	
	$InsVehiculoMovimientoEntrada->VmvGuiaRemisionNumeroNumero = $_POST['CmpGuiaRemisionNumeroNumero'];	
	$InsVehiculoMovimientoEntrada->VmvGuiaRemisionNumero = $InsVehiculoMovimientoEntrada->VmvGuiaRemisionNumeroSerie."-".$InsVehiculoMovimientoEntrada->VmvGuiaRemisionNumeroNumero;	
	
	$InsVehiculoMovimientoEntrada->VmvGuiaRemisionFecha = FncCambiaFechaAMysql($_POST['CmpGuiaRemisionFecha'],true);	
	$InsVehiculoMovimientoEntrada->VmvGuiaRemisionFoto = $_SESSION['SesVmvGuiaRemisionFoto'.$Identificador];

	$InsVehiculoMovimientoEntrada->MonId = $_POST['CmpMonedaId'];
	$InsVehiculoMovimientoEntrada->VmvTipoCambio = $_POST['CmpTipoCambio'];
	$InsVehiculoMovimientoEntrada->VmvTipoCambioComercial = $_POST['CmpTipoCambioComercial'];
	
	$InsVehiculoMovimientoEntrada->VmvIncluyeImpuesto = 2;

	$InsVehiculoMovimientoEntrada->VmvMargenUtilidad = 0.00;
	$InsVehiculoMovimientoEntrada->VmvTipo = 1;
	$InsVehiculoMovimientoEntrada->VmvSubTipo = 2;

	$InsVehiculoMovimientoEntrada->NpaId = $_POST['CmpCondicionPago'];
	$InsVehiculoMovimientoEntrada->VmvCantidadDia = isset($_POST['CmpCantidadDia'])?$_POST['CmpCantidadDia']:0;
	
	$InsVehiculoMovimientoEntrada->VmvEstado = $_POST['CmpEstado'];
	
	$InsVehiculoMovimientoEntrada->VmvTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoMovimientoEntrada->VmvTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculoMovimientoEntrada->VmvEliminado = 1;
	
	$InsVehiculoMovimientoEntrada->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsVehiculoMovimientoEntrada->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsVehiculoMovimientoEntrada->PrvApellidoPaterno = $_POST['CmpProveedorApellidoPaterno'];
	$InsVehiculoMovimientoEntrada->PrvApellidoMaterno = $_POST['CmpProveedorApellidoMaterno'];
	
	$InsVehiculoMovimientoEntrada->PrvNombreCompleto = $_POST['CmpProveedorNombreCompleto'];
	$InsVehiculoMovimientoEntrada->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsVehiculoMovimientoEntrada->VmvFoto = $_SESSION['SesVmvFoto'.$Identificador];

	settype($InsVehiculoMovimientoEntrada->VmvTipoCambio,"float");
		
	$InsVehiculoMovimientoEntrada->VehiculoMovimientoEntradaDetalle = array();
	
	if($InsVehiculoMovimientoEntrada->MonId<>$EmpresaMonedaId){
		if(empty($InsVehiculoMovimientoEntrada->VmvTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_VME_600';
		}
	}
	
	if(empty($InsVehiculoMovimientoEntrada->SucId)){
		$Guardar = false;
		$Resultado.='#ERR_VME_602';
	}
	
	
	$InsVehiculoMovimientoEntrada->VmvTotalBruto = 0;
	$InsVehiculoMovimientoEntrada->VmvSubTotal = 0;
	$InsVehiculoMovimientoEntrada->VmvImpuesto = 0;
	$InsVehiculoMovimientoEntrada->VmvTotal = 0;
	$InsVehiculoMovimientoEntrada->VmvValorTotal = 0;
	
	
//
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
//Parametro16 = VmdObservacion
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = VmdEstado
//Parametro26 = UmeId

	$ResVehiculoMovimientoEntradaDetalle = $_SESSION['InsVehiculoMovimientoEntradaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	
	if(!empty($ResVehiculoMovimientoEntradaDetalle['Datos'])){
		foreach($ResVehiculoMovimientoEntradaDetalle['Datos'] as $DatSesionObjeto){
			
			if($InsVehiculoMovimientoEntrada->MonId<>$EmpresaMonedaId){
				
				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsVehiculoMovimientoEntrada->VmvTipoCambio;
				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsVehiculoMovimientoEntrada->VmvTipoCambio;
				$DatSesionObjeto->Parametro13 = $DatSesionObjeto->Parametro13 * $InsVehiculoMovimientoEntrada->VmvTipoCambio;
				$DatSesionObjeto->Parametro15 = $DatSesionObjeto->Parametro15 * $InsVehiculoMovimientoEntrada->VmvTipoCambio;
				$DatSesionObjeto->Parametro29 = $DatSesionObjeto->Parametro29 * $InsVehiculoMovimientoEntrada->VmvTipoCambio;
				
			}
		
			$InsVehiculoMovimientoEntradaDetalle1 = new ClsVehiculoMovimientoEntradaDetalle();
			$InsVehiculoMovimientoEntradaDetalle1->VmdId = $DatSesionObjeto->Parametro1;
			
			$InsVehiculoMovimientoEntradaDetalle1->EinId = $DatSesionObjeto->Parametro2;
			$InsVehiculoMovimientoEntradaDetalle1->VehId = $DatSesionObjeto->Parametro12;
			
			$InsVehiculoMovimientoEntradaDetalle1->VmdIdAnterior = $InsVehiculoMovimientoEntradaDetalle1->MtdObtenerUltimoVehiculoMovimientoEntradaDetalleId($InsVehiculoMovimientoEntradaDetalle1->VehId,$InsVehiculoMovimientoEntrada->VmvFecha);
		
			$InsVehiculoMovimientoEntradaDetalle1->VmdCosto = $DatSesionObjeto->Parametro4;
//			$InsVehiculoMovimientoEntradaDetalle1->VmdCostoIngreso = $DatSesionObjeto->Parametro4;
			$InsVehiculoMovimientoEntradaDetalle1->VmdCostoIngreso = 0;
			$InsVehiculoMovimientoEntradaDetalle1->VmdCantidad = $DatSesionObjeto->Parametro5;
			$InsVehiculoMovimientoEntradaDetalle1->VmdImporte = $DatSesionObjeto->Parametro6;
			$InsVehiculoMovimientoEntradaDetalle1->VmdObservacion = $DatSesionObjeto->Parametro16;
			$InsVehiculoMovimientoEntradaDetalle1->UmeId = $DatSesionObjeto->Parametro27;
			$InsVehiculoMovimientoEntradaDetalle1->VmdFecha = 	$InsVehiculoMovimientoEntrada->VmvFecha;
		
			$InsVehiculoMovimientoEntradaDetalle1->VmdCostoAnterior = $DatSesionObjeto->Parametro15;		
			$InsVehiculoMovimientoEntradaDetalle1->VmdUtilidad = $DatSesionObjeto->Parametro13;
			$InsVehiculoMovimientoEntradaDetalle1->VmdUtilidadPorcentaje = $DatSesionObjeto->Parametro14;
			
			$InsVehiculoMovimientoEntradaDetalle1->VmdCostoExtraTotal = 0;
			$InsVehiculoMovimientoEntradaDetalle1->VmdCostoExtraUnitario = 0;
			
			
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica1 = (empty( $DatSesionObjeto->Parametro31)?0: $DatSesionObjeto->Parametro31);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica2 = (empty( $DatSesionObjeto->Parametro32)?0: $DatSesionObjeto->Parametro32);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica3 = (empty( $DatSesionObjeto->Parametro33)?0: $DatSesionObjeto->Parametro33);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica4 = (empty( $DatSesionObjeto->Parametro34)?0: $DatSesionObjeto->Parametro34);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica5 = (empty( $DatSesionObjeto->Parametro35)?0: $DatSesionObjeto->Parametro35);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica6 = (empty( $DatSesionObjeto->Parametro36)?0: $DatSesionObjeto->Parametro36);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica7 = (empty( $DatSesionObjeto->Parametro37)?0: $DatSesionObjeto->Parametro37);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica8 = (empty( $DatSesionObjeto->Parametro38)?0: $DatSesionObjeto->Parametro38);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica9 = (empty( $DatSesionObjeto->Parametro39)?0: $DatSesionObjeto->Parametro39);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica10 = (empty( $DatSesionObjeto->Parametro40)?0: $DatSesionObjeto->Parametro40);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica11 = (empty( $DatSesionObjeto->Parametro41)?0: $DatSesionObjeto->Parametro41);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica12 = (empty( $DatSesionObjeto->Parametro42)?0: $DatSesionObjeto->Parametro42);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica13 = (empty( $DatSesionObjeto->Parametro43)?0: $DatSesionObjeto->Parametro43);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica14 = (empty( $DatSesionObjeto->Parametro44)?0: $DatSesionObjeto->Parametro44);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica15 = (empty( $DatSesionObjeto->Parametro44)?0: $DatSesionObjeto->Parametro44);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica16 = (empty( $DatSesionObjeto->Parametro45)?0: $DatSesionObjeto->Parametro45);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica17 = (empty( $DatSesionObjeto->Parametro46)?0: $DatSesionObjeto->Parametro46);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica18 = (empty( $DatSesionObjeto->Parametro47)?0: $DatSesionObjeto->Parametro47);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica19 = (empty( $DatSesionObjeto->Parametro48)?0: $DatSesionObjeto->Parametro48);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica20 = (empty( $DatSesionObjeto->Parametro49)?0: $DatSesionObjeto->Parametro49);

			
			
			//$InsVehiculoMovimientoEntradaDetalle1->VmdEstado = $DatSesionObjeto->Parametro25;
			$InsVehiculoMovimientoEntradaDetalle1->VmdEstado = $_POST['CmpVehiculoMovimientoEntradaSimpleDetalleEstado_'.$DatSesionObjeto->Item];		
			$InsVehiculoMovimientoEntradaDetalle1->VmdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsVehiculoMovimientoEntradaDetalle1->VmdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsVehiculoMovimientoEntradaDetalle1->VmdEliminado = $DatSesionObjeto->Eliminado;				
			$InsVehiculoMovimientoEntradaDetalle1->InsMysql = NULL;

			$InsVehiculoMovimientoEntradaDetalle1->VmdValorTotal =  round($InsVehiculoMovimientoEntradaDetalle1->VmdCosto + ($InsVehiculoMovimientoEntradaDetalle1->VmdCostoExtraUnitario/(($InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta/100)+1)),6);

			settype($InsVehiculoMovimientoEntradaDetalle1->VmdCostoAnterior,"float");

			if(empty($InsVehiculoMovimientoEntradaDetalle1->VmdCostoAnterior)){
				$InsVehiculoMovimientoEntradaDetalle1->VmdCostoPromedio =  round(($InsVehiculoMovimientoEntradaDetalle1->VmdValorTotal),6);				
			}else{
				$InsVehiculoMovimientoEntradaDetalle1->VmdCostoPromedio =  round(($InsVehiculoMovimientoEntradaDetalle1->VmdValorTotal + $InsVehiculoMovimientoEntradaDetalle1->VmdCostoAnterior)/2,6);				
			}		
						
			if($InsVehiculoMovimientoEntradaDetalle1->VmdEliminado==1){	
							
				$InsVehiculoMovimientoEntrada->VehiculoMovimientoEntradaDetalle[] = $InsVehiculoMovimientoEntradaDetalle1;		
				$InsVehiculoMovimientoEntrada->VmvTotalBruto += $InsVehiculoMovimientoEntradaDetalle1->VmdImporte;
				
			}
		}		
		
	}else{
		//$Guardar = false;
		//$Resultado.='#ERR_VME_111';
	}

	$InsVehiculoMovimientoEntrada->VmvSubTotal = $InsVehiculoMovimientoEntrada->VmvTotalBruto;
	$InsVehiculoMovimientoEntrada->VmvImpuesto = round( ($InsVehiculoMovimientoEntrada->VmvSubTotal + $InsVehiculoMovimientoEntrada->VmvNacionalTotalRecargo) * ($InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta/100),3);
	
	$InsVehiculoMovimientoEntrada->VmvTotal = $InsVehiculoMovimientoEntrada->VmvSubTotal + $InsVehiculoMovimientoEntrada->VmvImpuesto;


	if($Guardar){

		if($InsVehiculoMovimientoEntrada->MtdRegistrarVehiculoMovimientoEntrada()){

			if($_POST['CmpNotificar']=="1"){
				
				$InsVehiculoMovimientoEntrada->MtdNotificarVehiculoMovimientoEntradaRegistro($InsVehiculoMovimientoEntrada->VmvId,$CorreosNotificacionVehiculoMovimientoEntradaRegistro,false);
				
			}
			
			FncNuevo();
		
			$Resultado.='#SAS_VME_101';
			$Registro = true;
		}else{
			
			$InsVehiculoMovimientoEntrada->VmvFecha = FncCambiaFechaANormal($InsVehiculoMovimientoEntrada->VmvFecha);
			$InsVehiculoMovimientoEntrada->VmvComprobanteFecha = FncCambiaFechaANormal($InsVehiculoMovimientoEntrada->VmvComprobanteFecha,true);
			$InsVehiculoMovimientoEntrada->VmvGuiaRemisionFecha = FncCambiaFechaANormal($InsVehiculoMovimientoEntrada->VmvGuiaRemisionFecha,true);


			$Resultado.='#ERR_VME_101';	
		}
			
	}else{
		
			$InsVehiculoMovimientoEntrada->VmvFecha = FncCambiaFechaANormal($InsVehiculoMovimientoEntrada->VmvFecha);
			$InsVehiculoMovimientoEntrada->VmvComprobanteFecha = FncCambiaFechaANormal($InsVehiculoMovimientoEntrada->VmvComprobanteFecha,true);
			$InsVehiculoMovimientoEntrada->VmvGuiaRemisionFecha = FncCambiaFechaANormal($InsVehiculoMovimientoEntrada->VmvGuiaRemisionFecha,true);
			
		
	}
	


}else{

	FncNuevo();
	
	
	switch($GET_Ori){
		
		case "OrdenCompra":
			

		break;
		
		case "VehiculoMovimientoSalida":
		
			$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();
			$InsVehiculoMovimientoSalida->VmvId = $GET_VmvId;
			$InsVehiculoMovimientoSalida->MtdObtenerVehiculoMovimientoSalida();	
			
			$ProveedorId = '';
			$ProveedorNombreCompleto =  '';
			
			$ProveedorNombre = '';
			$ProveedorApellidoPaterno = '';
			$ProveedorApellidoMaterno = '';
			
			$ProveedorNumeroDocumento = '';
			$TipoDocumentoId = '';
					
			$InsProveedor = new ClsProveedor();	
			
			//MtdObtenerProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PrvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL) 
			$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,"PrvNombre","ASC",1,"1","PRINCIPAL");
			$ArrProveedores = $ResProveedor['Datos'];
			
			if(!empty($ArrProveedores)){
				foreach($ArrProveedores as $DatProveedor){
				
					$ProveedorId = $DatProveedor->PrvId;
					$ProveedorNombreCompleto = $DatProveedor->PrvNombreCompleto;
					
					$ProveedorNombre = $DatProveedor->PrvNombre;
					$ProveedorApellidoPaterno = $DatProveedor->PrvApellidoPaterno;
					$ProveedorApellidoMaterno = $DatProveedor->PrvApellidoMaterno;
					
					$ProveedorNumeroDocumento = $DatProveedor->PrvNumeroDocumento;
					$TipoDocumentoId = $DatProveedor->TdoId;
		
				}
			}
			
			$InsVehiculoMovimientoEntrada->VmvComprobanteNumeroSerie = $InsVehiculoMovimientoSalida->VmvGuiaRemisionSerie;
			$InsVehiculoMovimientoEntrada->VmvComprobanteNumeroNumero = $InsVehiculoMovimientoSalida->VmvGuiaRemisionNumero;
			$InsVehiculoMovimientoEntrada->VmvComprobanteFecha = $InsVehiculoMovimientoSalida->VmvGuiaRemisionFecha;
			
			
			$InsVehiculoMovimientoEntrada->PrvId = $ProveedorId;
			$InsVehiculoMovimientoEntrada->PrvNumeroDocumento = $ProveedorNumeroDocumento;
			$InsVehiculoMovimientoEntrada->PrvNombre = $ProveedorNombre;
			$InsVehiculoMovimientoEntrada->PrvApellidoPaterno = $ProveedorApellidoPaterno;
			$InsVehiculoMovimientoEntrada->PrvApellidoMaterno = $ProveedorApellidoMaterno;
			$InsVehiculoMovimientoEntrada->TdoId = $TipoDocumentoId;
			$InsVehiculoMovimientoEntrada->PrvNombreCompleto = $ProveedorNombreCompleto;
			
			
				if(!empty($InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle)){
		foreach($InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle as $DatVehiculoMovimientoSalidaDetalle){

					if($InsVehiculoMovimientoSalida->MonId<>$EmpresaMonedaId and (!empty($InsVehiculoMovimientoSalida->VmvTipoCambio) )){
						
						$DatVehiculoMovimientoSalidaDetalle->VmdImporte = round($DatVehiculoMovimientoSalidaDetalle->VmdImporte / $InsVehiculoMovimientoSalida->VmvTipoCambio,3);
						$DatVehiculoMovimientoSalidaDetalle->VmdCosto = round($DatVehiculoMovimientoSalidaDetalle->VmdCosto  / $InsVehiculoMovimientoSalida->VmvTipoCambio,3);
						$DatVehiculoMovimientoSalidaDetalle->VmdCostoIngreso = round($DatVehiculoMovimientoSalidaDetalle->VmdCostoIngreso  / $InsVehiculoMovimientoSalida->VmvTipoCambio,3);
						$DatVehiculoMovimientoSalidaDetalle->VmdCostoAnterior = round($DatVehiculoMovimientoSalidaDetalle->VmdCostoAnterior  / $InsVehiculoMovimientoSalida->VmvTipoCambio,3);
						$DatVehiculoMovimientoSalidaDetalle->VmdUtilidad = round($DatVehiculoMovimientoSalidaDetalle->VmdUtilidad  / $InsVehiculoMovimientoSalida->VmvTipoCambio,3);
						
					}


					$_SESSION['InsVehiculoMovimientoEntradaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					$DatVehiculoMovimientoSalidaDetalle->VmdId,
					$DatVehiculoMovimientoSalidaDetalle->EinId,
					$DatVehiculoMovimientoSalidaDetalle->EinVIN,
					$DatVehiculoMovimientoSalidaDetalle->VmdCosto,
					$DatVehiculoMovimientoSalidaDetalle->VmdCantidad,
					$DatVehiculoMovimientoSalidaDetalle->VmdImporte,
					($DatVehiculoMovimientoSalidaDetalle->VmdTiempoCreacion),
					($DatVehiculoMovimientoSalidaDetalle->VmdTiempoModificacion),
					$DatVehiculoMovimientoSalidaDetalle->EinNumeroMotor,
					$DatVehiculoMovimientoSalidaDetalle->EinAnoFabricacion,
					$DatVehiculoMovimientoSalidaDetalle->EinAnoModelo,
					$DatVehiculoMovimientoSalidaDetalle->VehId,			
					
					$DatVehiculoMovimientoSalidaDetalle->VmdUtilidad,
					$DatVehiculoMovimientoSalidaDetalle->VmdUtilidadPorcentaje,
					$DatVehiculoMovimientoSalidaDetalle->VmdCostoAnterior,
					$DatVehiculoMovimientoSalidaDetalle->VmdObservacion,
					$DatVehiculoMovimientoSalidaDetalle->EinColor,
					$DatVehiculoMovimientoSalidaDetalle->EinColorInterior,
					$DatVehiculoMovimientoSalidaDetalle->VmaNombre,
					$DatVehiculoMovimientoSalidaDetalle->VmoNombre,
					$DatVehiculoMovimientoSalidaDetalle->VveNombre,
					$DatVehiculoMovimientoSalidaDetalle->VmaId,
					$DatVehiculoMovimientoSalidaDetalle->VmoId,
					$DatVehiculoMovimientoSalidaDetalle->VveId,
					$DatVehiculoMovimientoSalidaDetalle->VmdEstado,
					$DatVehiculoMovimientoSalidaDetalle->VehCodigoIdentificador,
					$DatVehiculoMovimientoSalidaDetalle->UmeId,
					$DatVehiculoMovimientoSalidaDetalle->UmeNombre,
					$DatVehiculoMovimientoSalidaDetalle->VmdCostoIngreso);
					
				}
		}
				
				
			
			
			
	
		break;
	}
}



function FncNuevo(){

	global $Identificador;
	global $InsVehiculoMovimientoEntrada;
		
	unset($_SESSION['InsVehiculoMovimientoEntradaDetalle'.$Identificador]);
	unset($_SESSION['InsOrdenCompraPedido'.$Identificador]);
	
	unset($_SESSION['SesCveFoto'.$Identificador]);
	
	$_SESSION['InsVehiculoMovimientoEntradaDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsVehiculoMovimientoEntrada = new ClsVehiculoMovimientoEntrada();
	
	$InsVehiculoMovimientoEntrada->VmvEstado = 3;

	$InsVehiculoMovimientoEntrada->TopId = "TOP-10010";
	$InsVehiculoMovimientoEntrada->CtiId = "CTI-10006";
	$InsVehiculoMovimientoEntrada->TdoId = "TDO-10003";
	$InsVehiculoMovimientoEntrada->NpaId = "NPA-10000";
	$InsVehiculoMovimientoEntrada->VmvCantidadDia = 0;
	$InsVehiculoMovimientoEntrada->SucId = $_SESSION['SesionSucursal'];
	$InsVehiculoMovimientoEntrada->AlmId = "";
	
	
	$ProveedorId = '';
	$ProveedorNombreCompleto =  '';
	
	$ProveedorNombre = '';
	$ProveedorApellidoPaterno = '';
	$ProveedorApellidoMaterno = '';
	
	$ProveedorNumeroDocumento = '';
	$TipoDocumentoId = '';
			
	$InsProveedor = new ClsProveedor();	
	
	//MtdObtenerProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PrvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL) 
	$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,"PrvNombre","ASC",1,"1","PRINCIPAL");
	$ArrProveedores = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){
		
			$ProveedorId = $DatProveedor->PrvId;
			$ProveedorNombreCompleto = $DatProveedor->PrvNombreCompleto;
			
			$ProveedorNombre = $DatProveedor->PrvNombre;
			$ProveedorApellidoPaterno = $DatProveedor->PrvApellidoPaterno;
			$ProveedorApellidoMaterno = $DatProveedor->PrvApellidoMaterno;
			
			$ProveedorNumeroDocumento = $DatProveedor->PrvNumeroDocumento;
			$TipoDocumentoId = $DatProveedor->TdoId;

		}
	}
	$InsVehiculoMovimientoEntrada->PrvId = $ProveedorId;
	$InsVehiculoMovimientoEntrada->PrvNumeroDocumento = $ProveedorNumeroDocumento;
	$InsVehiculoMovimientoEntrada->PrvNombre = $ProveedorNombre;
	$InsVehiculoMovimientoEntrada->PrvApellidoPaterno = $ProveedorApellidoPaterno;
	$InsVehiculoMovimientoEntrada->PrvApellidoMaterno = $ProveedorApellidoMaterno;
	$InsVehiculoMovimientoEntrada->TdoId = $TipoDocumentoId;
	$InsVehiculoMovimientoEntrada->PrvNombreCompleto = $ProveedorNombreCompleto;
	
	

}
?>