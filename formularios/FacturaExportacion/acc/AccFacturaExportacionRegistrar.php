<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Resultado = '';
	$Guardar = true;
	
	$InsFacturaExportacion->FexId = $_POST['CmpId'];
	
	$InsFacturaExportacion->UsuId = $_SESSION['SesionId'];
	
	
	$InsFacturaExportacion->FetId = $_POST['CmpTalonario'];
	$InsFacturaExportacion->CliId = $_POST['CmpClienteId'];

	$InsFacturaExportacion->UsuId = $_SESSION['SesionId'];
	$InsFacturaExportacion->NpaId = $_POST['CmpCondicionPago'];	
	$InsFacturaExportacion->FexCantidadDia = isset($_POST['CmpCantidadDia'])?$_POST['CmpCantidadDia']:0;

	$InsFacturaExportacion->MonId = $_POST['CmpMonedaId'];
	$InsFacturaExportacion->FexTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsFacturaExportacion->FexObsequio = $_POST['CmpObsequio'];
	
	$InsFacturaExportacion->FexIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsFacturaExportacion->FexEstado = $_POST['CmpEstado'];
	$InsFacturaExportacion->FexFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	$InsFacturaExportacion->FexPorcentajeImpuestoVenta = ($_POST['CmpPorcentajeImpuestoVenta']);
	$InsFacturaExportacion->FexObservacion = $_POST['CmpObservacion']."###".$_POST['CmpObservacionImpresa'];
	$InsFacturaExportacion->FexCierre = 1;
	$InsFacturaExportacion->FexTiempoCreacion = date("Y-m-d H:i:s");
	$InsFacturaExportacion->FexTiempoModificacion = date("Y-m-d H:i:s");
	$InsFacturaExportacion->FexEliminado = 1;
	
	$InsFacturaExportacion->CliNombre = $_POST['CmpClienteNombre'];
	$InsFacturaExportacion->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsFacturaExportacion->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsFacturaExportacion->CliTelefono = $_POST['CmpClienteTelefono'];
	$InsFacturaExportacion->CliEmail = $_POST['CmpClienteEmail'];
	$InsFacturaExportacion->CliCelular = $_POST['CmpClienteCelular'];
	$InsFacturaExportacion->CliFax = $_POST['CmpClienteFax'];

	$InsFacturaExportacion->FexDireccion = $_POST['CmpClienteDireccion'];	

	$InsFacturaExportacion->FinId = $_POST['CmpFichaIngresoId'];
	$InsFacturaExportacion->AmoId = $_POST['CmpAlmacenMovimientoSalidaId'];
	$InsFacturaExportacion->FccId = $_POST['CmpFichaAccionId'];
	$InsFacturaExportacion->VdiId = $_POST['CmpVentaDirectaId'];
	$InsFacturaExportacion->CprId = $_POST['CmpCotizacionProductoId'];


	$InsFacturaExportacion->FacturaExportacionDetalle = array();	

	if($InsFacturaExportacion->MonId<>$EmpresaMonedaId){
		if(empty($InsFacturaExportacion->FexTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_FEX_600';
		}
	}
	
/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FedId
Parametro2 = FedDescripcion
Parametro3
Parametro4 = FedPrecio
Parametro5 = FedCantidad
Parametro6 = FedImporte
Parametro7 = FedTiempoCreacion
Parametro8 = FedTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FedTipo
Parametro13 = FedUnidadMedida
*/

	$InsFacturaExportacion->FexTotalBruto = 0;
	$InsFacturaExportacion->FexSubTotal = 0;
	$InsFacturaExportacion->FexImpuesto = 0;
	$InsFacturaExportacion->FexTotal = 0;
	
	$ResFacturaExportacionDetalle = $_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResFacturaExportacionDetalle['Datos'])){
		foreach($ResFacturaExportacionDetalle['Datos'] as $DatSesionObjeto){
					
			$InsFacturaExportacionDetalle1 = new ClsFacturaExportacionDetalle();
			$InsFacturaExportacionDetalle1->FedId = $DatSesionObjeto->Parametro1;
			$InsFacturaExportacionDetalle1->AmdId = $DatSesionObjeto->Parametro9;		
			
			//$InsFacturaExportacionDetalle1->FedDescripcion = $DatSesionObjeto->Parametro2;
			$InsFacturaExportacionDetalle1->FedDescripcion = utf8_encode(htmlentities($DatSesionObjeto->Parametro2));
			
			$InsFacturaExportacionDetalle1->FedPrecio = $DatSesionObjeto->Parametro4;
			
			$InsFacturaExportacionDetalle1->FedTipo = $DatSesionObjeto->Parametro12;

			if($InsFacturaExportacion->MonId<>$EmpresaMonedaId and !empty($InsFacturaExportacion->FexTipoCambio)){
				$InsFacturaExportacionDetalle1->FedPrecio = $DatSesionObjeto->Parametro4 * $InsFacturaExportacion->FexTipoCambio;
			}else{
				$InsFacturaExportacionDetalle1->FedPrecio = $DatSesionObjeto->Parametro4;
			}

			$InsFacturaExportacionDetalle1->FedCantidad = $DatSesionObjeto->Parametro5;

			if($InsFacturaExportacion->MonId<>$EmpresaMonedaId and !empty($InsFacturaExportacion->FexTipoCambio)){
				$InsFacturaExportacionDetalle1->FedImporte = $DatSesionObjeto->Parametro6 * $InsFacturaExportacion->FexTipoCambio;
			}else{
				$InsFacturaExportacionDetalle1->FedImporte = $DatSesionObjeto->Parametro6;
			}

			$InsFacturaExportacionDetalle1->FedUnidadMedida = $DatSesionObjeto->Parametro13;
			$InsFacturaExportacionDetalle1->FedTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsFacturaExportacionDetalle1->FedTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsFacturaExportacionDetalle1->FedEliminado = $DatSesionObjeto->Eliminado;
			$InsFacturaExportacionDetalle1->InsMysql = NULL;
			
			$InsFacturaExportacion->FacturaExportacionDetalle[] = $InsFacturaExportacionDetalle1;	
			
			if($InsFacturaExportacionDetalle1->FedEliminado==1){		
				$InsFacturaExportacion->FexTotalBruto += $InsFacturaExportacionDetalle1->FedImporte;
			}
						
		}	
		
	}else{
		$Guardar = false;
		$Resultado.='#ERR_FEX_603';
	}




//SesionObjeto-FacturaExportacionAlmacenMovimiento
//Parametro1 = FeaId
//Parametro2 = AmoId
//Parametro3 = 
//Parametro4 = 
//Parametro5 = FeaEstado
//Parametro6 = FeaTiempoCreacion
//Parametro7 = FeaTiempoModificacion


	$ResFacturaExportacionAlmacenMovimiento = $_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]->MtdObtenerSesionObjetos(true);//OJO

	if(!empty($ResFacturaExportacionAlmacenMovimiento['Datos'])){	
		foreach($ResFacturaExportacionAlmacenMovimiento['Datos'] as $DatSesionObjeto){
						
			$InsFacturaExportacionAlmacenMovimiento1 = new ClsFacturaExportacionAlmacenMovimiento();
			$InsFacturaExportacionAlmacenMovimiento1->FeaId = $DatSesionObjeto->Parametro1;	
				
			$InsFacturaExportacionAlmacenMovimiento1->AmoId = $DatSesionObjeto->Parametro2;		

			$InsFacturaExportacionAlmacenMovimiento1->FeaEstado = $DatSesionObjeto->Parametro5;
			$InsFacturaExportacionAlmacenMovimiento1->FeaTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			$InsFacturaExportacionAlmacenMovimiento1->FeaTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			
			$InsFacturaExportacionAlmacenMovimiento1->FeaEliminado = $DatSesionObjeto->Eliminado;				
			//$InsFacturaAlmacenMovimiento1->InsMysql = NULL;
			
			$InsFacturaExportacion->FacturaExportacionAlmacenMovimiento[] = $InsFacturaExportacionAlmacenMovimiento1;	
			
			
		}
	}
	
		
		
		
		
	$InsFacturaExportacion->FexTotal = round($InsFacturaExportacion->FexTotalBruto,6);
	$InsFacturaExportacion->FexSubTotal = round(($InsFacturaExportacion->FexTotal/(($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100)+1)),6);
	$InsFacturaExportacion->FexImpuesto = round($InsFacturaExportacion->FexTotal - $InsFacturaExportacion->FexSubTotal,6);

	$InsFacturaExportacion->FexTotalReal = $InsFacturaExportacion->FexTotal;
	
	
	if($Guardar){
		if($InsFacturaExportacion->MtdRegistrarFacturaExportacion()){
	
			switch($GET_ori){
				
				case "FichaAccion":
				
					$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFacturaExportacion->FinId,9);
					
					$InsFichaAccion->MtdActualizarEstadoFichaAccion($InsFacturaExportacion->FccId,3);
				
				break;
				
				//ALMACEN
				case "AlmacenMovimientoSalida":
		
					$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFacturaExportacion->FinId,9);
					
		
				break;	
				
				case "VentaConcretada":
					
					$InsCotizacionProducto->MtdActualizarEstadoCotizacionProducto($InsFacturaExportacion->CprId,5);
		
				break;	
				
				
				case "OrdenVentaVehiculo":	

					$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();

					if($InsFacturaExportacion->FexEstado <> 6){
						$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($InsFacturaExportacion->OvvId,5);
					}
					
				break;
				
				
			}
			
			$Registro = true;				
			$Resultado.='#SAS_FEX_101';
		} else{
			$Resultado.='#ERR_FEX_101';
		}
	}
	
	
	$InsFacturaExportacion->FexFechaEmision = FncCambiaFechaANormal($InsFacturaExportacion->FexFechaEmision);
	
	list($InsFacturaExportacion->FexObservacion,$InsFacturaExportacion->FexObservacionImpresa) = explode("###",$InsFacturaExportacion->FexObservacion);
	
	
	
}else{

	unset($_SESSION['InsFacturaExportacionDetalle'.$Identificador]);
	unset($_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]);

	$_SESSION['InsFacturaExportacionDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();

	$InsFacturaExportacion->FexFechaEmision = date("d/m/Y");	
	$InsFacturaExportacion->NpaId = "NPA-10000";	
	$InsFacturaExportacion->TdoId = "TDO-10000";
	$InsFacturaExportacion->MonId = $EmpresaMonedaId;
	$InsFacturaExportacion->FexCancelado = 2;
	$InsFacturaExportacion->FexObsequio = 2;
	$InsFacturaExportacion->FexSpot = 2;
	$InsFacturaExportacion->FexPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsFacturaExportacion->FexIncluyeImpuesto = 1;

	switch($GET_ori){
		
		case "FichaAccion":

			if(!empty($GET_FccId) or !empty($POST_Seleccionados) ){
				FncCargarFichaAccionDatos();	
			}
			
		break;
		//ALMACEN
		case "AlmacenMovimientoSalida":
		
			if(!empty($GET_AmoId)){
				FncCargarAlmacenMovimientoSalidaDatos();
			}

		break;	
		
		case "VentaConcretada":

			if(!empty($GET_VcoId) or !empty($POST_Seleccionados)){
				FncCargarVentaConcretadaDatos();				
			}

		break;	
		
		case "OrdenVentaVehiculo":

			if(!empty($GET_OvvId)){
				FncCargarOrdenVentaVehiculoDatos();
			}

		break;
	}
	
}


function FncCargarFichaAccionDatos(){

	global $GET_FccId;
	global $Identificador;
	global $InsFichaAccion;
	global $InsAlmacenMovimientoSalida;
	global $InsFacturaExportacion;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;
	global $POST_Seleccionados;

	$InsFichaAccion = new ClsFichaAccion();

	if(!empty($GET_FccId)){
		
		$InsFichaAccion->FccId = $GET_FccId;
		$InsFichaAccion->MtdObtenerFichaAccion();
		
		$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();
		$ResAlmacenMovimientoSalida = $InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalidas(NULL,NULL,NULL,'AmoTiempoCreacion','DESC','1',NULL,NULL,NULL,$InsFichaAccion->FccId,NULL,0,0,NULL,NULL,false,NULL);
		$ArrAlmacenMovimientoSalidas = $ResAlmacenMovimientoSalida['Datos'];
		
		foreach($ArrAlmacenMovimientoSalidas as $DatAlmacenMovimientoSalida){
		
			$InsAlmacenMovimientoSalida->AmoId = $DatAlmacenMovimientoSalida->AmoId; 
			$InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalida();	
		
		}
			
		$InsFichaIngreso = new ClsFichaIngreso();
		$InsFichaIngreso->FinId = $InsFichaAccion->FinId;
		$InsFichaIngreso->MtdObtenerFichaIngreso();
		
		$InsFacturaExportacion->AmoId = $InsAlmacenMovimientoSalida->AmoId;
		$InsFacturaExportacion->FinId = $InsFichaIngreso->FinId;
		
		$InsFacturaExportacion->CliId = $InsFichaIngreso->CliId;		
		$InsFacturaExportacion->CliNombre = $InsFichaIngreso->CliNombre;
		$InsFacturaExportacion->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
		$InsFacturaExportacion->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
		
		$InsFacturaExportacion->TdoId = $InsFichaIngreso->TdoId;
		$InsFacturaExportacion->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
		//$InsFacturaExportacion->FexDireccion = $InsFichaIngreso->FinDireccion;
		//$InsFacturaExportacion->FexDireccion = $InsFichaIngreso->FinDireccion." - ".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliDepartamento;
		
		$InsFacturaExportacion->FexDireccion = $InsFichaIngreso->FinDireccion." - ".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliDepartamento;
		
		$InsFacturaExportacion->FexTelefono = $InsFichaIngreso->FinTelefono;		
		$InsFacturaExportacion->FexObsequio = $InsFichaAccion->FimObsequio;
		
		$InsFacturaExportacion->FexIncluyeImpuesto = $InsAlmacenMovimientoSalida->AmoIncluyeImpuesto;
		$InsFacturaExportacion->FexIncluyeImpuesto = $InsAlmacenMovimientoSalida->AmoIncluyeImpuesto;
		
		$InsFacturaExportacion->FexEstado = 5;
		$InsFacturaExportacion->FexObservacion = $InsAlmacenMovimientoSalida->AmoObservacion.chr(13).date("d/m/Y H:i:s")." - FacturaExportacion autogenerada de Mov. Alm.: ".$InsFacturaExportacion->AmoId." / O.T.: ".$InsFacturaExportacion->FinId;
		
		if($InsAlmacenMovimientoSalida->FimObsequio == 1){
		  $InsFacturaExportacion->FexObservacionImpresa = chr(13)."ESTE SERVICIO ES GRATUITO";
		}
		
		$InsFacturaExportacion->MonId = $EmpresaMonedaId;		
		$InsFacturaExportacion->FccId = $InsFichaAccion->FccId;		
		
		$ArrSuministros = array();
		/*
		SesionObjeto-FacturaDetalleListado
		Parametro1 = FedId
		Parametro2 = FedDescripcion
		Parametro3
		Parametro4 = FedPrecio
		Parametro5 = FedCantidad
		Parametro6 = FedImporte
		Parametro7 = FedTiempoCreacion
		Parametro8 = FedTiempoModificacion
		Parametro9 = AmdId
		Parametro10 = AmoId
		Parametro11 =
		Parametro12 = FedTipo
		Parametro13 = FedUnidadMedida
		*/
		
			if(!empty($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle)){
				foreach($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle as $DatAlmacenMovimientoSalidaDetalle){
					
					$GuardarDetalle = false;
					
					
					if($InsFacturaExportacion->FexIncluyeImpuesto == 2){
		
						$DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta + ($DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta * ($DatAlmacenMovimientoSalidaDetalle->AmoPorcentajeImpuestoVenta/100));
		
						$DatAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdImporte + ($DatAlmacenMovimientoSalidaDetalle->AmdImporte * ($DatAlmacenMovimientoSalidaDetalle->AmoPorcentajeImpuestoVenta/100));
		
					}
					
					$ValorVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta;
					$Importe = $ValorVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
					$Cantidad = $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
				
					if($DatAlmacenMovimientoSalidaDetalle->AmdCantidadPendienteFacturar>0){
						$Cantidad = $DatAlmacenMovimientoSalidaDetalle->AmdCantidadPendienteFacturar;
						$GuardarDetalle = true;
					}
								
								
					if($GuardarDetalle){

						$Importe = $Cantidad * $ValorVenta;

						if($DatAlmacenMovimientoSalidaDetalle->RtiId == "RTI-10003"){

							//$DatAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
											
							$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatAlmacenMovimientoSalidaDetalle->ProNombre." ".$DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal." ".($DatAlmacenMovimientoSalidaDetalle->AmdReingreso=="1"?'[R]':''),
							NULL,
							$ValorVenta,
							$Cantidad,
							$Importe,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							$DatAlmacenMovimientoSalidaDetalle->AmdId,
							$DatAlmacenMovimientoSalidaDetalle->AmoId,
							NULL,
							"M",
							$DatAlmacenMovimientoSalidaDetalle->UmeNombre
							);
			
						}else{
			
							//$DatAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
											
							$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatAlmacenMovimientoSalidaDetalle->ProNombre." ".$DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal." ".($DatAlmacenMovimientoSalidaDetalle->AmdReingreso=="1"?'[R]':''),
							NULL,
							$ValorVenta,
							$Cantidad,
							$Importe,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							$DatAlmacenMovimientoSalidaDetalle->AmdId,
							$DatAlmacenMovimientoSalidaDetalle->AmoId,
							NULL,
							"R",
							$DatAlmacenMovimientoSalidaDetalle->UmeAbreviacion
							);
			
						}	
									
					}
					
					
					
					
					
					
				}		
			}else{
				
				if(!empty($InsFichaAccion->FichaAccionTarea)){
					foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
			
							$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatFichaAccionTarea->FatDescripcion,
							NULL,
							0,
							1,
							0,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							NULL,
							NULL,
							NULL,
							"S",
							"UND"
							);
						
						
					}
				}
			
			}
		
			
			if(!empty($InsFichaAccion->FccManoObra)){
		
				$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				"MANO DE OBRA",
				NULL,
		//		($InsAlmacenMovimientoSalida->FccManoObra/(($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100)+1)),
				$InsFichaAccion->FccManoObra,
				1,
		//		($InsAlmacenMovimientoSalida->FccManoObra/(($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100)+1)),
				$InsFichaAccion->FccManoObra,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s"),
				NULL,
				NULL,
				NULL,
				"S",
				NULL
				);
		
			}
			
			
			if(!empty($InsAlmacenMovimientoSalida->AmoDescuento)){
		
				$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				"DESCUENTO",
				NULL,
				($InsAlmacenMovimientoSalida->AmoDescuento*-1),
				1,
				($InsAlmacenMovimientoSalida->AmoDescuento*-1),
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s"),
				NULL,
				NULL,
				NULL,
				"R",
				NULL
				);
		
			}
			
			
			if(!empty($InsAlmacenMovimientoSalida->AmoId)){
		
				$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				$InsAlmacenMovimientoSalida->AmoId,
				NULL,
				NULL,
				1,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s")
				);
				
			}

	}else{

		$ArrSeleccionados = explode("#",$POST_Seleccionados);
		
		if(!empty($ArrSeleccionados)){
			foreach($ArrSeleccionados as $DatSeleccionado){
				
				if(!empty($DatSeleccionado)){
					
					$InsFichaAccion->FccId = $DatSeleccionado;
					$InsFichaAccion->MtdObtenerFichaAccion();
					
					$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();
					$ResAlmacenMovimientoSalida = $InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalidas(NULL,NULL,NULL,'AmoTiempoCreacion','DESC','1',NULL,NULL,NULL,$InsFichaAccion->FccId,NULL,0,0,NULL,NULL,false,NULL);
					$ArrAlmacenMovimientoSalidas = $ResAlmacenMovimientoSalida['Datos'];
					
					foreach($ArrAlmacenMovimientoSalidas as $DatAlmacenMovimientoSalida){
					
						$InsAlmacenMovimientoSalida->AmoId = $DatAlmacenMovimientoSalida->AmoId; 
						$InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalida();	
					
					}
						
					$InsFichaIngreso = new ClsFichaIngreso();
					$InsFichaIngreso->FinId = $InsFichaAccion->FinId;
					$InsFichaIngreso->MtdObtenerFichaIngreso();
					
					$InsFacturaExportacion->AmoId = $InsAlmacenMovimientoSalida->AmoId;
					$InsFacturaExportacion->FinId = $InsFichaIngreso->FinId;
					
					$InsFacturaExportacion->CliId = $InsFichaIngreso->CliId;		
					$InsFacturaExportacion->CliNombre = $InsFichaIngreso->CliNombre;
					$InsFacturaExportacion->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
					$InsFacturaExportacion->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
					
					$InsFacturaExportacion->TdoId = $InsFichaIngreso->TdoId;
					$InsFacturaExportacion->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
					//$InsFacturaExportacion->FexDireccion = $InsFichaIngreso->FinDireccion;
					//$InsFacturaExportacion->FexDireccion = $InsFichaIngreso->FinDireccion." - ".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliDepartamento;
					
					$InsFacturaExportacion->FexDireccion = $InsFichaIngreso->FinDireccion." - ".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliDepartamento;
					
					$InsFacturaExportacion->FexTelefono = $InsFichaIngreso->FinTelefono;		
					$InsFacturaExportacion->FexObsequio = $InsFichaAccion->FimObsequio;
					
					$InsFacturaExportacion->FexIncluyeImpuesto = $InsAlmacenMovimientoSalida->AmoIncluyeImpuesto;
					$InsFacturaExportacion->FexIncluyeImpuesto = $InsAlmacenMovimientoSalida->AmoIncluyeImpuesto;
					
					$InsFacturaExportacion->FexEstado = 5;
					$InsFacturaExportacion->FexObservacion = $InsAlmacenMovimientoSalida->AmoObservacion.chr(13).date("d/m/Y H:i:s")." - FacturaExportacion autogenerada de Mov. Alm.: ".$InsFacturaExportacion->AmoId." / O.T.: ".$InsFacturaExportacion->FinId;
					
					if($InsAlmacenMovimientoSalida->FimObsequio == 1){
					  $InsFacturaExportacion->FexObservacionImpresa = chr(13)."ESTE SERVICIO ES GRATUITO";
					}
					
					$InsFacturaExportacion->MonId = $EmpresaMonedaId;		
					$InsFacturaExportacion->FccId = $InsFichaAccion->FccId;		
					
					$ArrSuministros = array();
					/*
					SesionObjeto-FacturaDetalleListado
					Parametro1 = FedId
					Parametro2 = FedDescripcion
					Parametro3
					Parametro4 = FedPrecio
					Parametro5 = FedCantidad
					Parametro6 = FedImporte
					Parametro7 = FedTiempoCreacion
					Parametro8 = FedTiempoModificacion
					Parametro9 = AmdId
					Parametro10 = AmoId
					Parametro11 =
					Parametro12 = FedTipo
					Parametro13 = FedUnidadMedida
					*/
					
						if(!empty($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle)){
							foreach($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle as $DatAlmacenMovimientoSalidaDetalle){
								
								
								$GuardarDetalle = false;
					
								if($InsFacturaExportacion->FexIncluyeImpuesto == 2){
					
									$DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta + ($DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta * ($DatAlmacenMovimientoSalidaDetalle->AmoPorcentajeImpuestoVenta/100));
					
									$DatAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdImporte + ($DatAlmacenMovimientoSalidaDetalle->AmdImporte * ($DatAlmacenMovimientoSalidaDetalle->AmoPorcentajeImpuestoVenta/100));
					
								}
					
								$ValorVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta;
								$Importe = $ValorVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
								$Cantidad = $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
							
								if($DatAlmacenMovimientoSalidaDetalle->AmdCantidadPendienteFacturar>0){
									$Cantidad = $DatAlmacenMovimientoSalidaDetalle->AmdCantidadPendienteFacturar;
									$GuardarDetalle = true;
								}
								
								if($GuardarDetalle){
									
									$Importe = $Cantidad * $ValorVenta;
									
									if($DatAlmacenMovimientoSalidaDetalle->RtiId == "RTI-10003"){
						
										//$DatAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
														
										$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
										NULL,
										$DatAlmacenMovimientoSalidaDetalle->ProNombre." ".$DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal." ".($DatAlmacenMovimientoSalidaDetalle->AmdReingreso=="1"?'[R]':''),
										NULL,
										$ValorVenta,
										$Cantidad,
										$Importe,
										date("d/m/Y H:i:s"),
										date("d/m/Y H:i:s"),
										$DatAlmacenMovimientoSalidaDetalle->AmdId,
										$DatAlmacenMovimientoSalidaDetalle->AmoId,
										NULL,
										"M",
										$DatAlmacenMovimientoSalidaDetalle->UmeNombre
										);
						
									}else{
						
										//$DatAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
														
										$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
										NULL,
										$DatAlmacenMovimientoSalidaDetalle->ProNombre." ".$DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal." ".($DatAlmacenMovimientoSalidaDetalle->AmdReingreso=="1"?'[R]':''),
										NULL,
										$ValorVenta,
										$Cantidad,
										$Importe,
										date("d/m/Y H:i:s"),
										date("d/m/Y H:i:s"),
										$DatAlmacenMovimientoSalidaDetalle->AmdId,
										$DatAlmacenMovimientoSalidaDetalle->AmoId,
										NULL,
										"R",
										$DatAlmacenMovimientoSalidaDetalle->UmeAbreviacion
										);
						
									}
								
								}
								
							}		
						}else{
							
							if(!empty($InsFichaAccion->FichaAccionTarea)){
								foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
						
										$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
										NULL,
										$DatFichaAccionTarea->FatDescripcion,
										NULL,
										0,
										1,
										0,
										date("d/m/Y H:i:s"),
										date("d/m/Y H:i:s"),
										NULL,
										NULL,
										NULL,
										"S",
										"UND"
										);
									
									
								}
							}
						
						}
					
						
						if(!empty($InsFichaAccion->FccManoObra) and $InsFichaAccion->FccManoObra<>0.00){
					
							$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							"MANO DE OBRA",
							NULL,
					//		($InsAlmacenMovimientoSalida->FccManoObra/(($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100)+1)),
							$InsFichaAccion->FccManoObra,
							1,
					//		($InsAlmacenMovimientoSalida->FccManoObra/(($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100)+1)),
							$InsFichaAccion->FccManoObra,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							NULL,
							NULL,
							NULL,
							"S",
							NULL
							);
					
						}
						
						
						if(!empty($InsAlmacenMovimientoSalida->AmoDescuento) and $InsAlmacenMovimientoSalida->AmoDescuento <> 0.00){
					
							$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							"DESCUENTO",
							NULL,
							($InsAlmacenMovimientoSalida->AmoDescuento*-1),
							1,
							($InsAlmacenMovimientoSalida->AmoDescuento*-1),
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							NULL,
							NULL,
							NULL,
							"R",
							NULL
							);
					
						}
						
						
						if(!empty($InsAlmacenMovimientoSalida->AmoId)){
					
							$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$InsAlmacenMovimientoSalida->AmoId,
							NULL,
							NULL,
							1,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s")
							);
							
						}
			
			
			
			
				}
			}
		}
		
	}
		
		

	///deb(($InsAlmacenMovimientoSalida->AmoDescuento*-1));
	
}





function FncCargarAlmacenMovimientoSalidaDatos(){

	global $GET_AmoId;
	global $Identificador;
	global $InsAlmacenMovimientoSalida;
	global $InsFacturaExportacion;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;
	
	$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();
	$InsAlmacenMovimientoSalida->AmoId = $GET_AmoId;	
	$InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalida();	

	$InsFichaIngreso = new ClsFichaIngreso();
	$InsFichaIngreso->FinId = $InsAlmacenMovimientoSalida->FinId;
	$InsFichaIngreso->MtdObtenerFichaIngreso();

	$InsFacturaExportacion->AmoId = $InsAlmacenMovimientoSalida->AmoId;
	$InsFacturaExportacion->FinId = $InsFichaIngreso->FinId;
	
	$InsFacturaExportacion->CliId = $InsFichaIngreso->CliId;		
	$InsFacturaExportacion->CliNombre = $InsFichaIngreso->CliNombre;
	$InsFacturaExportacion->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
	$InsFacturaExportacion->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
	
	$InsFacturaExportacion->TdoId = $InsFichaIngreso->TdoId;
	$InsFacturaExportacion->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
	$InsFacturaExportacion->FexDireccion = $InsFichaIngreso->FinDireccion." - ".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliDepartamento;

	$InsFacturaExportacion->FexTelefono = $InsFichaIngreso->FinTelefono;		
	$InsFacturaExportacion->FexObsequio = 2;
	
	$InsFacturaExportacion->FexIncluyeImpuesto = $InsAlmacenMovimientoSalida->AmoIncluyeImpuesto;
	$InsFacturaExportacion->FexPorcentajeImpuestoVenta = $InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta;
	
	$InsFacturaExportacion->FexEstado = 5;
	$InsFacturaExportacion->FexObservacion = $InsAlmacenMovimientoSalida->AmoObservacion.chr(13).date("d/m/Y H:i:s")." - FacturaExportacion autogenerada de Mov. Alm.: ".$InsFacturaExportacion->AmoId." / O.T.: ".$InsFacturaExportacion->FinId;
	
	if($InsAlmacenMovimientoSalida->FimObsequio == 1){
		$InsFacturaExportacion->FexObservacionImpresa = chr(13)."ESTE SERVICIO ES GRATUITO";
	}
	
	$InsFacturaExportacion->MonId = $EmpresaMonedaId;		



	$ArrSuministros = array();
/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FedId
Parametro2 = FedDescripcion
Parametro3
Parametro4 = FedPrecio
Parametro5 = FedCantidad
Parametro6 = FedImporte
Parametro7 = FedTiempoCreacion
Parametro8 = FedTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FedTipo
Parametro13 = FedUnidadMedida
*/

	if(!empty($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle)){
		foreach($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle as $DatAlmacenMovimientoSalidaDetalle){


			if($InsFacturaExportacion->FexIncluyeImpuesto == 2){
				
				$DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta + ($DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta * ($DatAlmacenMovimientoSalidaDetalle->AmoPorcentajeImpuestoVenta/100));
				
				$DatAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdImporte + ($DatAlmacenMovimientoSalidaDetalle->AmdImporte * ($DatAlmacenMovimientoSalidaDetalle->AmoPorcentajeImpuestoVenta/100));
				
			}
			
			
			if($DatAlmacenMovimientoSalidaDetalle->RtiId == "RTI-10003"){
				
				$DatAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
								
				$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				$DatAlmacenMovimientoSalidaDetalle->ProNombre." ".$DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal,
				NULL,
				$DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta,
//				$DatAlmacenMovimientoSalidaDetalle->AmdCosto,
				$DatAlmacenMovimientoSalidaDetalle->AmdCantidad,
				$DatAlmacenMovimientoSalidaDetalle->AmdImporte,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s"),
				$DatAlmacenMovimientoSalidaDetalle->AmdId,
				$DatAlmacenMovimientoSalidaDetalle->AmoId,
				NULL,
				"M",
				$DatAlmacenMovimientoSalidaDetalle->UmeNombre
				);

			}else{

				$DatAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
								
				$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				$DatAlmacenMovimientoSalidaDetalle->ProNombre." ".$DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal,
				NULL,
				$DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta,
//				$DatAlmacenMovimientoSalidaDetalle->AmdCosto,
				$DatAlmacenMovimientoSalidaDetalle->AmdCantidad,
				$DatAlmacenMovimientoSalidaDetalle->AmdImporte,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s"),
				$DatAlmacenMovimientoSalidaDetalle->AmdId,
				$DatAlmacenMovimientoSalidaDetalle->AmoId,
				NULL,
				"R",
				$DatAlmacenMovimientoSalidaDetalle->UmeAbreviacion
				);

			}
			
			
			
		}		
	}

	
	
	if(!empty($InsAlmacenMovimientoSalida->FccManoObra)){

		if($InsFacturaExportacion->FexIncluyeImpuesto == 2){
		
			$InsAlmacenMovimientoSalida->FccManoObra = $InsAlmacenMovimientoSalida->FccManoObra + ($InsAlmacenMovimientoSalida->FccManoObra * ($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100));
		
		}
			



		$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
		NULL,
		"MANO DE OBRA",
		NULL,
//		($InsAlmacenMovimientoSalida->FccManoObra/(($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100)+1)),
		$InsAlmacenMovimientoSalida->FccManoObra,
		1,
//		($InsAlmacenMovimientoSalida->FccManoObra/(($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100)+1)),
		$InsAlmacenMovimientoSalida->FccManoObra,
		date("d/m/Y H:i:s"),
		date("d/m/Y H:i:s"),
		NULL,
		NULL,
		NULL,
		"S",
		NULL
		);

	}
	
	
	
	if(!empty($InsAlmacenMovimientoSalida->AmoId)){
		
		$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
		NULL,
		$InsAlmacenMovimientoSalida->AmoId,
		NULL,
		NULL,
		1,
		date("d/m/Y H:i:s"),
		date("d/m/Y H:i:s")
		);	
		
	}

	
}





function FncCargarVentaConcretadaDatos(){

	global $GET_VcoId;
	global $POST_Seleccionados;
	
	global $Identificador;
	global $InsVentaConcretada;
	global $InsFacturaExportacion;
	global $EmpresaMonedaId;
	
	$InsVentaConcretada = new ClsVentaConcretada();
	
	if(!empty($GET_VcoId)){
		
		
			
		
			$InsVentaConcretada->VcoId = $GET_VcoId;	
			$InsVentaConcretada->MtdObtenerVentaConcretada();	
		
			$InsFacturaExportacion->AmoId = $InsVentaConcretada->VcoId;
			$InsFacturaExportacion->CprId = $InsVentaConcretada->CprId;
			
			$InsFacturaExportacion->CliId = $InsVentaConcretada->CliId;		
			$InsFacturaExportacion->CliNombre = $InsVentaConcretada->CliNombre;
			$InsFacturaExportacion->CliApellidoPaterno = $InsVentaConcretada->CliApellidoPaterno;
			$InsFacturaExportacion->CliApellidoMaterno = $InsVentaConcretada->CliApellidoMaterno;
		
			$InsFacturaExportacion->TdoId = $InsVentaConcretada->TdoId;
			$InsFacturaExportacion->CliNumeroDocumento = $InsVentaConcretada->CliNumeroDocumento;
			//$InsFacturaExportacion->FexDireccion = $InsVentaConcretada->VcoDireccion;
			$InsFacturaExportacion->FexDireccion = $InsVentaConcretada->VcoDireccion." - ".$InsVentaConcretada->CliDistrito." - ".$InsVentaConcretada->CliProvincia." - ".$InsVentaConcretada->CliDepartamento;
		
			$InsFacturaExportacion->FexTelefono = $InsVentaConcretada->VcoTelefono;		
			$InsFacturaExportacion->FexObsequio = 2;
			
			$InsFacturaExportacion->FexPorcentajeImpuestoVenta = $InsVentaConcretada->VcoPorcentajeImpuestoVenta;
			$InsFacturaExportacion->FexIncluyeImpuesto = $InsVentaConcretada->VcoIncluyeImpuesto;
			$InsFacturaExportacion->FexEstado = 5;
			$InsFacturaExportacion->FexObservacion = $InsVentaConcretada->VcoObservacion.chr(13).date("d/m/Y H:i:s")." - FacturaExportacion autogenerada de Mov. Alm.: ".$InsFacturaExportacion->AmoId." / Cot.: ".$InsFacturaExportacion->CprId;	
			
			
		//	deb($InsVentaConcretada->VcoIncluyeImpuesto);
			
			if(!empty($InsVentaConcretada->VdiOrdenCompraNumero)){
				$InsFacturaExportacion->FexObservacionImpresa .= chr(13)."O.C.: ".$InsVentaConcretada->VdiOrdenCompraNumero;		
			}
			
			
			if(!empty($InsVentaConcretada->CprId)){
				$InsFacturaExportacion->FexObservacionImpresa .= chr(13)."Cot.: ".$InsVentaConcretada->CprId;		
			}
				
			
			
			//$InsFacturaExportacion->MonId = $EmpresaMonedaId;		
			$InsFacturaExportacion->MonId = $InsVentaConcretada->MonId;	
			$InsFacturaExportacion->FexTipoCambio = $InsVentaConcretada->VcoTipoCambio;	
		
			if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
				foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){
					
					
					if($InsFacturaExportacion->FexIncluyeImpuesto == 2){
						
						$DatVentaConcretadaDetalle->VcdPrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta + ($DatVentaConcretadaDetalle->VcdPrecioVenta * ($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100));
						
						$DatVentaConcretadaDetalle->VcdImporte = $DatVentaConcretadaDetalle->VcdImporte + ($DatVentaConcretadaDetalle->VcdImporte * ($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100));
						
					}
					
					if($InsFacturaExportacion->MonId<>$EmpresaMonedaId ){
						
						$DatVentaConcretadaDetalle->VcdPrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta / $InsFacturaExportacion->FexTipoCambio,2);
						$DatVentaConcretadaDetalle->VcdImporte = round($DatVentaConcretadaDetalle->VcdImporte  / $InsFacturaExportacion->FexTipoCambio,2);
		
					}
//	$DatVentaConcretadaDetalle->AmdCosto = $DatVentaConcretadaDetalle->AmdCosto + ($DatVentaConcretadaDetalle->AmdCosto * ($EmpresaImpuestoVenta/100));
//	$DatVentaConcretadaDetalle->AmdImporte = $DatVentaConcretadaDetalle->AmdCosto * $DatVentaConcretadaDetalle->VcdCantidad;
							
		/*
		SesionObjeto-FacturaDetalleListado
		Parametro1 = FedId
		Parametro2 = FedDescripcion
		Parametro3
		Parametro4 = FedPrecio
		Parametro5 = FedCantidad
		Parametro6 = FedImporte
		Parametro7 = FedTiempoCreacion
		Parametro8 = FedTiempoModificacion
		Parametro9 = AmdId
		Parametro10 = AmoId
		Parametro11 =
		Parametro12 = FedTipo
		Parametro13 = FedUnidadMedida
		Parametro14 = VcdReingreso
		*/
					$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatVentaConcretadaDetalle->ProNombre." ".$DatVentaConcretadaDetalle->ProCodigoOriginal." ".($DatVentaConcretadaDetalle->VcdReingreso=="1"?'[R]':''),
					NULL,
					$DatVentaConcretadaDetalle->VcdPrecioVenta,
					$DatVentaConcretadaDetalle->VcdCantidad,
					$DatVentaConcretadaDetalle->VcdImporte,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					$DatVentaConcretadaDetalle->VcdId,
					$DatVentaConcretadaDetalle->VcoId,
					NULL,
					"R",
					$DatVentaConcretadaDetalle->UmeAbreviacion,
					$DatVentaConcretadaDetalle->VcdReingreso
					);	
								
				}		
			}
			
			
			
			if(!empty($InsVentaConcretada->VcoDescuento)  and $InsVentaConcretada->VcoDescuento <> 0.00 ){
		
				if($InsFacturaExportacion->FexIncluyeImpuesto == 2){
				
					$InsVentaConcretada->VcoDescuento = $InsVentaConcretada->VcoDescuento + ($InsOrdenVentaVehiculo->VcoDescuento * ($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100));
				
				}
		
				if($InsFacturaExportacion->MonId<>$EmpresaMonedaId ){
					$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento / $InsFacturaExportacion->FexTipoCambio,2);
				}
		
				$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				"DESCUENTO",
				NULL,
				$InsVentaConcretada->VcoDescuento*-1,
				1,
				$InsVentaConcretada->VcoDescuento*-1,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s"),
				NULL,
				NULL,
				NULL,
				"S",
				NULL
				);
						
			}
			
			if(!empty($InsVentaConcretada->VcoId)){
						
				$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				$InsVentaConcretada->VcoId,
				NULL,
				NULL,
				1,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s")
				);
				
			}
			
	
	
	}else{
		
		
			$ArrSeleccionados = explode("#",$POST_Seleccionados);
		
		if(!empty($ArrSeleccionados)){
			foreach($ArrSeleccionados as $DatSeleccionado){
				
				if(!empty($DatSeleccionado)){


//SesionObjeto-FacturaExportacionAlmacenMovimiento
//Parametro1 = BFamId
//Parametro2 = AmoId
//Parametro3 = 
//Parametro4 = 
//Parametro5 = FeaEstado
//Parametro6 = FeaTiempoCreacion
//Parametro7 = FeaTiempoModificacion

			
					$InsVentaConcretada->VcoId = $DatSeleccionado;	
					$InsVentaConcretada->MtdObtenerVentaConcretada();	
				
					$InsFacturaExportacion->AmoId = $InsVentaConcretada->VcoId;
			$InsFacturaExportacion->CprId = $InsVentaConcretada->CprId;
			
			$InsFacturaExportacion->CliId = $InsVentaConcretada->CliId;		
			$InsFacturaExportacion->CliNombre = $InsVentaConcretada->CliNombre;
			$InsFacturaExportacion->CliApellidoPaterno = $InsVentaConcretada->CliApellidoPaterno;
			$InsFacturaExportacion->CliApellidoMaterno = $InsVentaConcretada->CliApellidoMaterno;
		
			$InsFacturaExportacion->TdoId = $InsVentaConcretada->TdoId;
			$InsFacturaExportacion->CliNumeroDocumento = $InsVentaConcretada->CliNumeroDocumento;
			//$InsFacturaExportacion->FexDireccion = $InsVentaConcretada->VcoDireccion;
			$InsFacturaExportacion->FexDireccion = $InsVentaConcretada->VcoDireccion." - ".$InsVentaConcretada->CliDistrito." - ".$InsVentaConcretada->CliProvincia." - ".$InsVentaConcretada->CliDepartamento;
		
			$InsFacturaExportacion->FexTelefono = $InsVentaConcretada->VcoTelefono;		
			$InsFacturaExportacion->FexObsequio = 2;
			
			$InsFacturaExportacion->FexPorcentajeImpuestoVenta = $InsVentaConcretada->VcoPorcentajeImpuestoVenta;
			$InsFacturaExportacion->FexIncluyeImpuesto = $InsVentaConcretada->VcoIncluyeImpuesto;
			$InsFacturaExportacion->FexEstado = 5;
			$InsFacturaExportacion->FexObservacion = $InsVentaConcretada->VcoObservacion.chr(13).date("d/m/Y H:i:s")." - FacturaExportacion autogenerada de Mov. Alm.: ".$InsFacturaExportacion->AmoId." / Cot.: ".$InsFacturaExportacion->CprId;	
						
			if(!empty($InsVentaConcretada->VdiOrdenCompraNumero)){
				$InsFacturaExportacion->FexObservacionImpresa .= chr(13)."O.C.: ".$InsVentaConcretada->VdiOrdenCompraNumero;		
			}
			
			if(!empty($InsVentaConcretada->CprId)){
				$InsFacturaExportacion->FexObservacionImpresa .= chr(13)."Cot.: ".$InsVentaConcretada->CprId;		
			}
			
			$InsFacturaExportacion->MonId = $InsVentaConcretada->MonId;	
			$InsFacturaExportacion->FexTipoCambio = $InsVentaConcretada->VcoTipoCambio;	
					
					if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
						foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){
				
							if($InsFacturaExportacion->FexIncluyeImpuesto == 2){
						
								$DatVentaConcretadaDetalle->VcdPrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta + ($DatVentaConcretadaDetalle->VcdPrecioVenta * ($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100));
								
								$DatVentaConcretadaDetalle->VcdImporte = $DatVentaConcretadaDetalle->VcdImporte + ($DatVentaConcretadaDetalle->VcdImporte * ($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100));
								
							}
							
							if($InsFacturaExportacion->MonId<>$EmpresaMonedaId ){
								
								$DatVentaConcretadaDetalle->VcdPrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta / $InsFacturaExportacion->FexTipoCambio,2);
								$DatVentaConcretadaDetalle->VcdImporte = round($DatVentaConcretadaDetalle->VcdImporte  / $InsFacturaExportacion->FexTipoCambio,2);
				
							}
								
				/*
				SesionObjeto-FacturaDetalleListado
				Parametro1 = FedId
				Parametro2 = FedDescripcion
				Parametro3
				Parametro4 = FedPrecio
				Parametro5 = FedCantidad
				Parametro6 = FedImporte
				Parametro7 = FedTiempoCreacion
				Parametro8 = FedTiempoModificacion
				Parametro9 = AmdId
				Parametro10 = AmoId
				Parametro11 =
				Parametro12 = FedTipo
				Parametro13 = FedUnidadMedida
				*/
							$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatVentaConcretadaDetalle->ProNombre." ".$DatVentaConcretadaDetalle->ProCodigoOriginal." ".($DatVentaConcretadaDetalle->VcdReingreso=="1"?'[R]':''),
							NULL,
							$DatVentaConcretadaDetalle->VcdPrecioVenta,
							$DatVentaConcretadaDetalle->VcdCantidad,
							$DatVentaConcretadaDetalle->VcdImporte,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							$DatVentaConcretadaDetalle->VcdId,
							$DatVentaConcretadaDetalle->VcoId,
							NULL,
							"R",
							$DatVentaConcretadaDetalle->UmeAbreviacion,
							$DatVentaConcretadaDetalle->VcdReingreso
							);
							
							
						}		
					}
					
					
					
					
						if(!empty($InsVentaConcretada->VcoDescuento)  and $InsVentaConcretada->VcoDescuento <> 0.00 ){
			
							if($InsFacturaExportacion->FexIncluyeImpuesto == 2){
							
								$InsVentaConcretada->VcoDescuento = $InsVentaConcretada->VcoDescuento + ($InsOrdenVentaVehiculo->VcoDescuento * ($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100));
							
							}
					
							if($InsFacturaExportacion->MonId<>$EmpresaMonedaId ){
								$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento / $InsFacturaExportacion->FexTipoCambio,2);
							}
					
							$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							"DESCUENTO",
							NULL,
							$InsVentaConcretada->VcoDescuento*-1,
							1,
							$InsVentaConcretada->VcoDescuento*-1,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							NULL,
							NULL,
							NULL,
							"S",
							NULL
							);
									
						}
						
			if(!empty($InsVentaConcretada->VcoId)){
						
				$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				$InsVentaConcretada->VcoId,
				NULL,
				NULL,
				1,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s")
				);
				
			}
			
					
					
					

					
				
				}
				
			}
		}
		
	}



}
	
function FncCargarOrdenVentaVehiculoDatos(){

	global $GET_OvvId;
	global $Identificador;
	global $InsOrdenVentaVehiculo;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;
	global $InsFacturaExportacion;
	
	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
	
	$InsOrdenVentaVehiculo->OvvId = $GET_OvvId;	
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();	

	$InsFacturaExportacion->OvvId = $InsOrdenVentaVehiculo->OvvId;
	$InsFacturaExportacion->CveId = $InsOrdenVentaVehiculo->CveId;

	$InsFacturaExportacion->CliId = $InsOrdenVentaVehiculo->CliId;		
	$InsFacturaExportacion->CliNombre = $InsOrdenVentaVehiculo->CliNombre;
	$InsFacturaExportacion->CliApellidoPaterno = $InsOrdenVentaVehiculo->CliApellidoPaterno;
	$InsFacturaExportacion->CliApellidoMaterno = $InsOrdenVentaVehiculo->CliApellidoMaterno;

	$InsFacturaExportacion->TdoId = $InsOrdenVentaVehiculo->TdoId;
	$InsFacturaExportacion->CliNumeroDocumento = $InsOrdenVentaVehiculo->CliNumeroDocumento;
	$InsFacturaExportacion->FexDireccion = $InsOrdenVentaVehiculo->CliDireccion." - ".$InsOrdenVentaVehiculo->CliDistrito." - ".$InsOrdenVentaVehiculo->CliProvincia." - ".$InsOrdenVentaVehiculo->CliDepartamento;

	$InsFacturaExportacion->FexTelefono = $InsOrdenVentaVehiculo->CliTelefono;		
	$InsFacturaExportacion->FexEstado = 5;

	$InsFacturaExportacion->FexObservacion = $InsOrdenVentaVehiculo->OvvObservacion.chr(13).date("d/m/Y H:i:s")." - FacturaExportacion autogenerada de Ord. Ven. Veh.: ".$InsFacturaExportacion->OvvId." / Prof. Veh: ".$InsFacturaExportacion->CveId;

	$InsFacturaExportacion->MonId = $InsOrdenVentaVehiculo->MonId;		
	$InsFacturaExportacion->FexTipoCambio = $InsOrdenVentaVehiculo->FexTipoCambio;		

	$InsFacturaExportacion->FexIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;		
	$InsFacturaExportacion->FexPorcentajeImpuestoVenta = $InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta;

	if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId ){

		$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal  / $InsOrdenVentaVehiculo->OvvTipoCambio,2);

	}
/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FedId
Parametro2 = FedDescripcion
Parametro3
Parametro4 = FedPrecio
Parametro5 = FedCantidad
Parametro6 = FedImporte
Parametro7 = FedTiempoCreacion
Parametro8 = FedTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FedTipo
Parametro13 = FedUnidadMedida
Parametro14 = OvvId
*/
	if($InsFacturaExportacion->FexIncluyeImpuesto == 2){
	
		$InsOrdenVentaVehiculo->OvvTotal = $InsOrdenVentaVehiculo->OvvTotal + ($InsOrdenVentaVehiculo->OvvTotal * ($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100));
	
	}
			
	  //deb($DatVentaConcretadaDetalle->VcdPrecioVenta);
	  //$ValorVenta = $InsOrdenVentaVehiculo->OvvTotal/(($InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta/100)+1);
	  $ValorVenta = $InsOrdenVentaVehiculo->OvvTotal;
	  $Importe = $ValorVenta;

	  $_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
	  NULL,
	  $InsOrdenVentaVehiculo->VmaNombre." ". $InsOrdenVentaVehiculo->VmoNombre." ". $InsOrdenVentaVehiculo->VveNombre,
	  NULL,
	  $ValorVenta,
	  1,
	  $Importe,
	  date("d/m/Y H:i:s"),
	  date("d/m/Y H:i:s"),
	  NULL,
	  NULL,
	  NULL,
	  "V",
	  "Unidad",
	  $InsOrdenVentaVehiculo->OvvId
	  );
		
	
}


?>
