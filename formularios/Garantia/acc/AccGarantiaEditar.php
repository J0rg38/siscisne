<?php

//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;	
	
	$InsGarantia->UsuId = $_SESSION['SesionId'];
	
	$InsGarantia->GarId = $_POST['CmpId'];
	$InsGarantia->FccId = $_POST['CmpFichaAccionId'];

	$InsGarantia->GarFechaEmision = FncCambiaFechaAMysql($_POST['CmpFecha']);	
	$InsGarantia->GarFechaVenta = FncCambiaFechaAMysql($_POST['CmpFechaVenta'],true);	
	
	list($InsGarantia->GarAno,$InsGarantia->GarMes,$aux) = explode("-",$InsGarantia->GarFechaEmision);
	
	$InsGarantia->GarCausa = addslashes($_POST['CmpCausa']);
	$InsGarantia->GarSolucion = addslashes($_POST['CmpSolucion']);
	
	$InsGarantia->CliId = $_POST['CmpClienteId'];
	$InsGarantia->CliNombre = $_POST['CmpClienteNombre'];
	$InsGarantia->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsGarantia->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsGarantia->GarDireccion = $_POST['CmpClienteDireccion'];
	$InsGarantia->GarCiudad = $_POST['CmpClienteCiudad'];
	
	$InsGarantia->GarTelefono = $_POST['CmpClienteTelefono'];
	$InsGarantia->GarCelular = $_POST['CmpClienteCelular'];
	
	$InsGarantia->MonId = $_POST['CmpMonedaId'];
	$InsGarantia->GarTipoCambio = $_POST['CmTipoCambio'];
	$InsGarantia->GarPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	
	$InsGarantia->FinId = $_POST['CmpFichaIngresoId'];
	$InsGarantia->FinVehiculoKilometraje = $_POST['CmpFichaIngresoVehiculoKilometraje'];
	$InsGarantia->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	
	$InsGarantia->VmaId = $_POST['CmpVehiculoIngresoMarcaId'];
	$InsGarantia->VmoId = $_POST['CmpVehiculoIngresoModeloId'];	
	
	$InsGarantia->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsGarantia->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsGarantia->GarModelo = $_POST['CmpVehiculoIngresoModelo'];
	$InsGarantia->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];

	$InsGarantia->EinId = $_POST['CmpVehiculoIngresoId'];	

	$InsGarantia->GarObservacion = addslashes($_POST['CmpObservacion']);
	$InsGarantia->GarObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsGarantia->GarTarifaAutorizada = preg_replace("/,/", "", $_POST['CmpTarifaAutorizada']);
	
	$InsGarantia->GarEstado = $_POST['CmpEstado'];
	$InsGarantia->GarTiempoCreacion = date("Y-m-d H:i:s");
	$InsGarantia->GarTiempoModificacion = date("Y-m-d H:i:s");

	$InsGarantia->GarSubTotalRepuestoStock = 0;
	$InsGarantia->GarFactorPorcentaje1 = 0;
	$InsGarantia->GarSubTotalRepuestoOtro = 0;
	$InsGarantia->GarFactorPorcentaje2 = 0;

	$InsGarantia->GarTotalRepuesto = 0;
	$InsGarantia->GarTotalManoObra = 0;

	$InsGarantia->GarSubTotal = 0;
	$InsGarantia->GarImpuesto = 0;
	$InsGarantia->GarTotal = 0;

	$InsGarantia->GarTransaccionFecha = FncCambiaFechaAMysql($_POST['CmpTransaccionFecha'],true);
	$InsGarantia->GarTransaccionNumero = $_POST['CmpTransaccionNumero'];	
	$InsGarantia->GarObservacionFinal = addslashes($_POST['CmpObservacionFinal']);	
	
	$InsGarantia->GarNumeroComprobante = $_POST['CmpNumeroComprobante'];	
	$InsGarantia->GarFechaPago = FncCambiaFechaAMysql($_POST['CmpFechaPago'],true);
	$InsGarantia->CueId = $_POST['CmpCuenta'];	
	
	if($InsGarantia->MonId<>$EmpresaMonedaId){
		if(empty($InsGarantia->GarTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_GAR_600';
		}
	}
	
		
//SesionObjeto-InsGarantiaDetalle
//Parametro1 = GdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = GdeCodigo
//Parametro5 = GdeDescripcion
//Parametro6 = GdeCosto
//Parametro7 = GdeCantidad
//Parametro8 = GdeCostoTotal	
//Parametro9 = GdeEstado	
//Parametro10 = GdeTiempoCreacion		
//Parametro11 = GdeTiempoModificacion	
//Parametro12 = GdeMargen
//Parametro13 = GdeCostoMargen
//Parametro14 = AmdId
	

	$ResGarantiaDetalle = $_SESSION['InsGarantiaDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);


	if(!empty($ResGarantiaDetalle['Datos'])){
		foreach($ResGarantiaDetalle['Datos'] as $DatSesionObjeto){

			$InsGarantiaDetalle1 = new ClsGarantiaDetalle();
			$InsGarantiaDetalle1->GdeId = $DatSesionObjeto->Parametro1;
			$InsGarantiaDetalle1->AmdId = $DatSesionObjeto->Parametro14;
			
			$InsGarantiaDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsGarantiaDetalle1->UmeId = $DatSesionObjeto->Parametro3;
			
			$InsGarantiaDetalle1->GdeCodigo = $DatSesionObjeto->Parametro4;
			$InsGarantiaDetalle1->GdeDescripcion = $DatSesionObjeto->Parametro5;

			if($InsGarantia->MonId<>$EmpresaMonedaId ){
				$InsGarantiaDetalle1->GdeCosto = $DatSesionObjeto->Parametro6 * $InsGarantia->GarTipoCambio;
			}else{
				$InsGarantiaDetalle1->GdeCosto = $DatSesionObjeto->Parametro6;
			}

			$InsGarantiaDetalle1->GdeCantidad = $DatSesionObjeto->Parametro7;

			if($InsGarantia->MonId<>$EmpresaMonedaId ){
				$InsGarantiaDetalle1->GdeCostoTotal = $DatSesionObjeto->Parametro8 * $InsGarantia->GarTipoCambio;
			}else{
				$InsGarantiaDetalle1->GdeCostoTotal = $DatSesionObjeto->Parametro8;
			}

			$InsGarantiaDetalle1->GdeMargen = $DatSesionObjeto->Parametro12;

			if($InsGarantia->MonId<>$EmpresaMonedaId ){
				$InsGarantiaDetalle1->GdeCostoMargen = $DatSesionObjeto->Parametro13 * $InsGarantia->GarTipoCambio;
			}else{
				$InsGarantiaDetalle1->GdeCostoMargen = $DatSesionObjeto->Parametro13;
			}
			
			//deb($InsGarantiaDetalle1->GdeCostoMargen);

			$InsGarantiaDetalle1->GdeEstado = $DatSesionObjeto->Parametro9;
			$InsGarantiaDetalle1->GdeTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro10);
			$InsGarantiaDetalle1->GdeTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro11);
			$InsGarantiaDetalle1->GdeEliminado = $DatSesionObjeto->Eliminado;				
			$InsGarantiaDetalle1->InsMysql = NULL;
			
			$InsGarantia->GarantiaDetalle[] = $InsGarantiaDetalle1;		
			
			if($InsGarantiaDetalle1->GdeEliminado==1){		
				//$InsGarantia->GarSubTotalRepuestoStock += $InsGarantiaDetalle1->GdeCostoMargen;	
				$InsGarantia->GarSubTotalRepuestoStock += $InsGarantiaDetalle1->GdeCostoTotal;	
			}

		}

	}

	
	$ResGarantiaOperacion = $_SESSION['InsGarantiaOperacion'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResGarantiaOperacion['Datos'])){
		foreach($ResGarantiaOperacion['Datos'] as $DatSesionObjeto){

	

	//SesionObjeto-InsGarantiaOperacion
	//Parametro1 = GopId
	//Parametro2 = GopNumero
	//Parametro3 = GopTiempo
	//Parametro4 = GopValor
	//Parametro5 = GopCosto
	//Parametro6 = GopEstado
	//Parametro7 = GopTiempoCreacion
	//Parametro8 = GopTiempoModificacion
	
	//Parametro9 = GopTransaccionNumero
	//Parametro10 = GopTransaccionFecha
	//Parametro11 = GopFechaAprobacion
	//Parametro12 = GopFechaPago	
	//Parametro13 = FaeId
	
			$InsGarantiaOperacion1 = new ClsGarantiaOperacion();
			$InsGarantiaOperacion1->GopId = $DatSesionObjeto->Parametro1;
			$InsGarantiaOperacion1->FaeId = $DatSesionObjeto->Parametro13;
			
			$InsGarantiaOperacion1->GopNumero = $DatSesionObjeto->Parametro2;
			
			//$InsGarantiaOperacion1->GopValor = $DatSesionObjeto->Parametro4;

			if($InsGarantia->MonId<>$EmpresaMonedaId ){
				$InsGarantiaOperacion1->GopCosto = $DatSesionObjeto->Parametro5 * $InsGarantia->GarTipoCambio;
			}else{
				$InsGarantiaOperacion1->GopCosto = $DatSesionObjeto->Parametro5;
			}

			$InsGarantiaOperacion1->GopTiempo = $DatSesionObjeto->Parametro3;

			if($InsGarantia->MonId<>$EmpresaMonedaId ){
				$InsGarantiaOperacion1->GopValor = $DatSesionObjeto->Parametro4 * $InsGarantia->GarTipoCambio;
			}else{
				$InsGarantiaOperacion1->GopValor = $DatSesionObjeto->Parametro4;
			}

			$InsGarantiaOperacion1->GopTransaccionNumero = $DatSesionObjeto->Parametro9;
			$InsGarantiaOperacion1->GopTransaccionFecha = FncCambiaFechaAMysql($DatSesionObjeto->Parametro10,false);
			$InsGarantiaOperacion1->GopFechaAprobacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro11,false);
			$InsGarantiaOperacion1->GopFechaPago = FncCambiaFechaAMysql($DatSesionObjeto->Parametro12,false);
			$InsGarantiaOperacion1->GopComprobanteNumero = $DatSesionObjeto->Parametro13;
			
			$InsGarantiaOperacion1->GopEstado = $DatSesionObjeto->Parametro6;
			$InsGarantiaOperacion1->GopTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsGarantiaOperacion1->GopTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsGarantiaOperacion1->GopEliminado = $DatSesionObjeto->Eliminado;				
			$InsGarantiaOperacion1->InsMysql = NULL;
			
			$InsGarantia->GarantiaOperacion[] = $InsGarantiaOperacion1;		
			
			if($InsGarantiaOperacion1->GopEliminado==1){					
				$InsGarantia->GarTotalManoObra += $InsGarantiaOperacion1->GopCosto;	
			}

		}

	}

	$InsGarantia->GarTotalRepuesto = $InsGarantia->GarSubTotalRepuestoStock;
	$InsGarantia->GarSubTotal = $InsGarantia->GarTotalRepuesto + $InsGarantia->GarTotalManoObra;
	$InsGarantia->GarImpuesto = $InsGarantia->GarSubTotal * ($InsGarantia->GarPorcentajeImpuestoVenta/100);
	$InsGarantia->GarTotal = $InsGarantia->GarSubTotal + $InsGarantia->GarImpuesto;

	if($Guardar){

		if($InsGarantia->MtdEditarGarantia()){
			
			$InsGarantia->MtdEditarGarantiaDato("GarNumeroComprobante",$InsGarantia->GarNumeroComprobante,$InsGarantia->GarId);
			$InsGarantia->MtdEditarGarantiaDato("GarFechaPago",$InsGarantia->GarFechaPago,$InsGarantia->GarId);
			$InsGarantia->MtdEditarGarantiaDato("CueId",$InsGarantia->CueId,$InsGarantia->GarId);
		
			$Edito = true;
			$Resultado.='#SAS_GAR_102';
			
		}else{
			$Resultado.='#ERR_GAR_102';
		}

	}	
	
	$InsGarantia->GarFechaEmision = FncCambiaFechaANormal($InsGarantia->GarFechaEmision);		
	$InsGarantia->GarFechaVenta = FncCambiaFechaANormal($InsGarantia->GarFechaVenta,true);	
	$InsGarantia->GarTransaccionFecha = FncCambiaFechaANormal($InsGarantia->GarTransaccionFecha,true);
	
	$InsGarantia->GarFechaPago = FncCambiaFechaANormal($InsGarantia->GarFechaPago,true);

		
}else{

	FncCargarDatos();
}


function FncCargarDatos(){

	global $InsGarantia;
	global $Identificador;
	
	global $GET_Id;

	unset($_SESSION['InsGarantiaOperacion'.$Identificador]);
	unset($_SESSION['InsGarantiaDetalle'.$Identificador]);
	unset($_SESSION['InsGarantiaFoto'.$Identificador]);
	
	unset($_SESSION['SesGarFotoVIN'.$Identificador]);
	unset($_SESSION['SesGarFotoFrontal'.$Identificador]);
	unset($_SESSION['SesGarFotoCupon'.$Identificador]);
	unset($_SESSION['SesGarFotoMantenimiento'.$Identificador]);
	
	$_SESSION['InsGarantiaOperacion'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsGarantiaDetalle'.$Identificador] = new ClsSesionObjeto();	
	$_SESSION['InsGarantiaFoto'.$Identificador] = new ClsSesionObjeto();
	
	$_SESSION['SesGarFotoVIN'.$Identificador] = $InsFichaIngreso->FinFotoVIN;
	$_SESSION['SesGarFotoFrontal'.$Identificador] = $InsFichaIngreso->FinFotoFrontal;
	$_SESSION['SesGarFotoCupon'.$Identificador] = $InsFichaIngreso->FinFotoCupon;
	$_SESSION['SesGarFotoMantenimiento'.$Identificador] = $InsFichaIngreso->FinFotoMantenimiento;
	
	$InsGarantia->GarId = $GET_Id;
	$InsGarantia->MtdObtenerGarantia();


	$InsFichaIngreso = new ClsFichaIngreso();
	$InsFichaIngreso->FinId = $InsGarantia->FinId ;
	$InsFichaIngreso->MtdObtenerFichaIngreso();
	
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){

			$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;

				if(!empty($InsFichaAccion->FichaAccionFoto)){
					foreach($InsFichaAccion->FichaAccionFoto as $DatFichaAccionFoto){
						
						$_SESSION['InsGarantiaFoto'.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaAccionFoto->FafId,
						NULL,
						$DatFichaAccionFoto->FafArchivo,
						$DatFichaAccionFoto->FafEstado,
						($DatFichaAccionFoto->FafTiempoCreacion),
						($DatFichaAccionFoto->FafTiempoModificacion)
						);
	
					}
				}	
				
				
				
		}
	}
	
	
//	if(empty($InsGarantia->GarCausa)){
//		$InsGarantia->GarCausa = $InsGarantia->FccCausa;
//	}
//	

	
	
	//SesionObjeto-InsGarantiaOperacion
	//Parametro1 = GopId
	//Parametro2 = GopNumero
	//Parametro3 = GopTiempo
	//Parametro4 = GopValor
	//Parametro5 = GopCosto
	//Parametro6 = GopEstado
	//Parametro7 = GopTiempoCreacion
	//Parametro8 = GopTiempoModificacion
	
	//Parametro9 = GopTransaccionNumero
	//Parametro10 = GopTransaccionFecha
	//Parametro11 = GopFechaAprobacion
	//Parametro12 = GopFechaPago	
	//Parametro13 = FaeId
		
	if(!empty($InsGarantia->GarantiaOperacion)){
		
		foreach($InsGarantia->GarantiaOperacion as $DatGarantiaOperacion){					
		
		if($InsGarantia->MonId<>$EmpresaMonedaId ){

			$DatGarantiaOperacion->GopCosto = round($DatGarantiaOperacion->GopCosto / $InsGarantia->GarTipoCambio,2);
			$DatGarantiaOperacion->GopValor = round($DatGarantiaOperacion->GopValor / $InsGarantia->GarTipoCambio,2);

		}
			
			$_SESSION['InsGarantiaOperacion'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatGarantiaOperacion->GopId,
			$DatGarantiaOperacion->GopNumero,
			$DatGarantiaOperacion->GopTiempo,	
			$DatGarantiaOperacion->GopValor,
			$DatGarantiaOperacion->GopCosto,
			$DatGarantiaOperacion->GopEstado,
			($DatGarantiaOperacion->GopTiempoCreacion),
			($DatGarantiaOperacion->GopTiempoModificacion),
			
			$DatGarantiaOperacion->GopTransaccionNumero,
			$DatGarantiaOperacion->GopTransaccionFecha,
			$DatGarantiaOperacion->GopFechaAprobacion,
			$DatGarantiaOperacion->GopFechaPago,
			$DatGarantiaOperacion->FaeId
			);
		}
		
	}			

//SesionObjeto-InsGarantiaDetalle
//Parametro1 = GdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = GdeCodigo
//Parametro5 = GdeDescripcion
//Parametro6 = GdeCosto
//Parametro7 = GdeCantidad
//Parametro8 = GdeCostoTotal	
//Parametro9 = GdeEstado	
//Parametro10 = GdeTiempoCreacion		
//Parametro11 = GdeTiempoModificacion	
//Parametro12 = GdeMargen
//Parametro13 = GdeCostoMargen
//Parametro14 = AmdId

//Parametro15 = ProCodigoOriginal
//Parametro16 = ProNombre
//Parametro17 = UmeNombre


	if(!empty($InsGarantia->GarantiaDetalle)){
		foreach($InsGarantia->GarantiaDetalle as $DatGarantiaDetalle){					

			if($InsGarantia->MonId<>$EmpresaMonedaId  ){
				$DatGarantiaDetalle->GdeCosto = round($DatGarantiaDetalle->GdeCosto / $InsGarantia->GarTipoCambio,2);
				$DatGarantiaDetalle->GdeCostoTotal = round($DatGarantiaDetalle->GdeCostoTotal  / $InsGarantia->GarTipoCambio,2);
				$DatGarantiaDetalle->GdeCostoMargen = round($DatGarantiaDetalle->GdeCostoMargen  / $InsGarantia->GarTipoCambio,2);
			}
			
			$_SESSION['InsGarantiaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatGarantiaDetalle->GdeId,
			$DatGarantiaDetalle->ProId,
			$DatGarantiaDetalle->UmeId,
			
			$DatGarantiaDetalle->GdeCodigo,
			$DatGarantiaDetalle->GdeDescripcion,
			
			$DatGarantiaDetalle->GdeCosto,
			$DatGarantiaDetalle->GdeCantidad,
			($DatGarantiaDetalle->GdeCostoTotal),		
			($DatGarantiaDetalle->GdeEstado),
			($DatGarantiaDetalle->GdeTiempoCreacion),
			($DatGarantiaDetalle->GopTiempoModificacion),
			0,
			0,
			$DatGarantiaDetalle->AmdId,
			
			$DatGarantiaDetalle->ProCodigoOriginal,
			$DatGarantiaDetalle->ProNombre,
			$DatGarantiaDetalle->UmeNombre
			);

		}
	}

}

?>

