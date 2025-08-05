<?php

//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;	
	
	$InsGarantiaRepuestoIsuzu->UsuId = $_SESSION['SesionId'];
	
	$InsGarantiaRepuestoIsuzu->GriId = $_POST['CmpId'];
	$InsGarantiaRepuestoIsuzu->FccId = $_POST['CmpFichaAccionId'];

	$InsGarantiaRepuestoIsuzu->GriFechaEmision = FncCambiaFechaAMysql($_POST['CmpFecha']);	
	$InsGarantiaRepuestoIsuzu->GriFechaVenta = FncCambiaFechaAMysql($_POST['CmpFechaVenta'],true);	
	
	list($InsGarantiaRepuestoIsuzu->GriAno,$InsGarantiaRepuestoIsuzu->GriMes,$aux) = explode("-",$InsGarantiaRepuestoIsuzu->GriFechaEmision);
	
	$InsGarantiaRepuestoIsuzu->GriCausa = addslashes($_POST['CmpCausa']);
	$InsGarantiaRepuestoIsuzu->GriSolucion = addslashes($_POST['CmpSolucion']);
	
	$InsGarantiaRepuestoIsuzu->CliId = $_POST['CmpClienteId'];
	$InsGarantiaRepuestoIsuzu->CliNombre = $_POST['CmpClienteNombre'];
	$InsGarantiaRepuestoIsuzu->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsGarantiaRepuestoIsuzu->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsGarantiaRepuestoIsuzu->GriDireccion = $_POST['CmpClienteDireccion'];
	$InsGarantiaRepuestoIsuzu->GriCiudad = $_POST['CmpClienteCiudad'];
	
	$InsGarantiaRepuestoIsuzu->GriTelefono = $_POST['CmpClienteTelefono'];
	$InsGarantiaRepuestoIsuzu->GriCelular = $_POST['CmpClienteCelular'];
	
	$InsGarantiaRepuestoIsuzu->MonId = $_POST['CmpMonedaId'];
	$InsGarantiaRepuestoIsuzu->GriTipoCambio = $_POST['CmTipoCambio'];
	$InsGarantiaRepuestoIsuzu->GriPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	
	$InsGarantiaRepuestoIsuzu->FinId = $_POST['CmpFichaIngresoId'];
	$InsGarantiaRepuestoIsuzu->FinVehiculoKilometraje = $_POST['CmpFichaIngresoVehiculoKilometraje'];
	$InsGarantiaRepuestoIsuzu->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	
	$InsGarantiaRepuestoIsuzu->VmaId = $_POST['CmpVehiculoIngresoMarcaId'];
	$InsGarantiaRepuestoIsuzu->VmoId = $_POST['CmpVehiculoIngresoModeloId'];	
	
	$InsGarantiaRepuestoIsuzu->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsGarantiaRepuestoIsuzu->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsGarantiaRepuestoIsuzu->GriModelo = $_POST['CmpVehiculoIngresoModelo'];
	$InsGarantiaRepuestoIsuzu->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];

	$InsGarantiaRepuestoIsuzu->EinId = $_POST['CmpVehiculoIngresoId'];	

	$InsGarantiaRepuestoIsuzu->GriObservacion = addslashes($_POST['CmpObservacion']);
	$InsGarantiaRepuestoIsuzu->GriObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsGarantiaRepuestoIsuzu->GriTarifaAutorizada = eregi_replace(",","",$_POST['CmpTarifaAutorizada']);
	
	$InsGarantiaRepuestoIsuzu->GriEstado = $_POST['CmpEstado'];
	$InsGarantiaRepuestoIsuzu->GriTiempoCreacion = date("Y-m-d H:i:s");
	$InsGarantiaRepuestoIsuzu->GriTiempoModificacion = date("Y-m-d H:i:s");

	$InsGarantiaRepuestoIsuzu->GriSubTotalRepuestoStock = 0;
	$InsGarantiaRepuestoIsuzu->GriFactorPorcentaje1 = 0;
	$InsGarantiaRepuestoIsuzu->GriSubTotalRepuestoOtro = 0;
	$InsGarantiaRepuestoIsuzu->GriFactorPorcentaje2 = 0;

	$InsGarantiaRepuestoIsuzu->GriTotalRepuesto = 0;
	$InsGarantiaRepuestoIsuzu->GriTotalManoObra = 0;

	$InsGarantiaRepuestoIsuzu->GriSubTotal = 0;
	$InsGarantiaRepuestoIsuzu->GriImpuesto = 0;
	$InsGarantiaRepuestoIsuzu->GriTotal = 0;

	$InsGarantiaRepuestoIsuzu->GriTransaccionFecha = FncCambiaFechaAMysql($_POST['CmpTransaccionFecha'],true);
	$InsGarantiaRepuestoIsuzu->GriTransaccionNumero = $_POST['CmpTransaccionNumero'];	
	$InsGarantiaRepuestoIsuzu->GriObservacionFinal = addslashes($_POST['CmpObservacionFinal']);	
	
	$InsGarantiaRepuestoIsuzu->GriNumeroComprobante = $_POST['CmpNumeroComprobante'];	
	$InsGarantiaRepuestoIsuzu->GriFechaPago = FncCambiaFechaAMysql($_POST['CmpFechaPago'],true);
	$InsGarantiaRepuestoIsuzu->CueId = $_POST['CmpCuenta'];	
	
	if($InsGarantiaRepuestoIsuzu->MonId<>$EmpresaMonedaId){
		if(empty($InsGarantiaRepuestoIsuzu->GriTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_GRI_600';
		}
	}
	
		
//SesionObjeto-InsGarantiaRepuestoIsuzuDetalle
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
	

	$ResGarantiaRepuestoIsuzuDetalle = $_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);


	if(!empty($ResGarantiaRepuestoIsuzuDetalle['Datos'])){
		foreach($ResGarantiaRepuestoIsuzuDetalle['Datos'] as $DatSesionObjeto){

			$InsGarantiaRepuestoIsuzuDetalle1 = new ClsGarantiaRepuestoIsuzuDetalle();
			$InsGarantiaRepuestoIsuzuDetalle1->GdeId = $DatSesionObjeto->Parametro1;
			$InsGarantiaRepuestoIsuzuDetalle1->AmdId = $DatSesionObjeto->Parametro14;
			
			$InsGarantiaRepuestoIsuzuDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsGarantiaRepuestoIsuzuDetalle1->UmeId = $DatSesionObjeto->Parametro3;
			
			$InsGarantiaRepuestoIsuzuDetalle1->GdeCodigo = $DatSesionObjeto->Parametro4;
			$InsGarantiaRepuestoIsuzuDetalle1->GdeDescripcion = $DatSesionObjeto->Parametro5;

			if($InsGarantiaRepuestoIsuzu->MonId<>$EmpresaMonedaId ){
				$InsGarantiaRepuestoIsuzuDetalle1->GdeCosto = $DatSesionObjeto->Parametro6 * $InsGarantiaRepuestoIsuzu->GriTipoCambio;
			}else{
				$InsGarantiaRepuestoIsuzuDetalle1->GdeCosto = $DatSesionObjeto->Parametro6;
			}

			$InsGarantiaRepuestoIsuzuDetalle1->GdeCantidad = $DatSesionObjeto->Parametro7;

			if($InsGarantiaRepuestoIsuzu->MonId<>$EmpresaMonedaId ){
				$InsGarantiaRepuestoIsuzuDetalle1->GdeCostoTotal = $DatSesionObjeto->Parametro8 * $InsGarantiaRepuestoIsuzu->GriTipoCambio;
			}else{
				$InsGarantiaRepuestoIsuzuDetalle1->GdeCostoTotal = $DatSesionObjeto->Parametro8;
			}

			$InsGarantiaRepuestoIsuzuDetalle1->GdeMargen = $DatSesionObjeto->Parametro12;

			if($InsGarantiaRepuestoIsuzu->MonId<>$EmpresaMonedaId ){
				$InsGarantiaRepuestoIsuzuDetalle1->GdeCostoMargen = $DatSesionObjeto->Parametro13 * $InsGarantiaRepuestoIsuzu->GriTipoCambio;
			}else{
				$InsGarantiaRepuestoIsuzuDetalle1->GdeCostoMargen = $DatSesionObjeto->Parametro13;
			}
			
			//deb($InsGarantiaRepuestoIsuzuDetalle1->GdeCostoMargen);

			$InsGarantiaRepuestoIsuzuDetalle1->GdeEstado = $DatSesionObjeto->Parametro9;
			$InsGarantiaRepuestoIsuzuDetalle1->GdeTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro10);
			$InsGarantiaRepuestoIsuzuDetalle1->GdeTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro11);
			$InsGarantiaRepuestoIsuzuDetalle1->GdeEliminado = $DatSesionObjeto->Eliminado;				
			$InsGarantiaRepuestoIsuzuDetalle1->InsMysql = NULL;
			
			$InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuDetalle[] = $InsGarantiaRepuestoIsuzuDetalle1;		
			
			if($InsGarantiaRepuestoIsuzuDetalle1->GdeEliminado==1){		
				//$InsGarantiaRepuestoIsuzu->GriSubTotalRepuestoStock += $InsGarantiaRepuestoIsuzuDetalle1->GdeCostoMargen;	
				$InsGarantiaRepuestoIsuzu->GriSubTotalRepuestoStock += $InsGarantiaRepuestoIsuzuDetalle1->GdeCostoTotal;	
			}

		}

	}

	
	$ResGarantiaRepuestoIsuzuManoObra = $_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResGarantiaRepuestoIsuzuManoObra['Datos'])){
		foreach($ResGarantiaRepuestoIsuzuManoObra['Datos'] as $DatSesionObjeto){

	

	//SesionObjeto-InsGarantiaRepuestoIsuzuManoObra
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
	
			$InsGarantiaRepuestoIsuzuManoObra1 = new ClsGarantiaRepuestoIsuzuManoObra();
			$InsGarantiaRepuestoIsuzuManoObra1->GopId = $DatSesionObjeto->Parametro1;
			$InsGarantiaRepuestoIsuzuManoObra1->FaeId = $DatSesionObjeto->Parametro13;
			
			$InsGarantiaRepuestoIsuzuManoObra1->GopNumero = $DatSesionObjeto->Parametro2;
			
			//$InsGarantiaRepuestoIsuzuManoObra1->GopValor = $DatSesionObjeto->Parametro4;

			if($InsGarantiaRepuestoIsuzu->MonId<>$EmpresaMonedaId ){
				$InsGarantiaRepuestoIsuzuManoObra1->GopCosto = $DatSesionObjeto->Parametro5 * $InsGarantiaRepuestoIsuzu->GriTipoCambio;
			}else{
				$InsGarantiaRepuestoIsuzuManoObra1->GopCosto = $DatSesionObjeto->Parametro5;
			}

			$InsGarantiaRepuestoIsuzuManoObra1->GopTiempo = $DatSesionObjeto->Parametro3;

			if($InsGarantiaRepuestoIsuzu->MonId<>$EmpresaMonedaId ){
				$InsGarantiaRepuestoIsuzuManoObra1->GopValor = $DatSesionObjeto->Parametro4 * $InsGarantiaRepuestoIsuzu->GriTipoCambio;
			}else{
				$InsGarantiaRepuestoIsuzuManoObra1->GopValor = $DatSesionObjeto->Parametro4;
			}

			$InsGarantiaRepuestoIsuzuManoObra1->GopTransaccionNumero = $DatSesionObjeto->Parametro9;
			$InsGarantiaRepuestoIsuzuManoObra1->GopTransaccionFecha = FncCambiaFechaAMysql($DatSesionObjeto->Parametro10,false);
			$InsGarantiaRepuestoIsuzuManoObra1->GopFechaAprobacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro11,false);
			$InsGarantiaRepuestoIsuzuManoObra1->GopFechaPago = FncCambiaFechaAMysql($DatSesionObjeto->Parametro12,false);
			$InsGarantiaRepuestoIsuzuManoObra1->GopComprobanteNumero = $DatSesionObjeto->Parametro13;
			
			$InsGarantiaRepuestoIsuzuManoObra1->GopEstado = $DatSesionObjeto->Parametro6;
			$InsGarantiaRepuestoIsuzuManoObra1->GopTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsGarantiaRepuestoIsuzuManoObra1->GopTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsGarantiaRepuestoIsuzuManoObra1->GopEliminado = $DatSesionObjeto->Eliminado;				
			$InsGarantiaRepuestoIsuzuManoObra1->InsMysql = NULL;
			
			$InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra[] = $InsGarantiaRepuestoIsuzuManoObra1;		
			
			if($InsGarantiaRepuestoIsuzuManoObra1->GopEliminado==1){					
				$InsGarantiaRepuestoIsuzu->GriTotalManoObra += $InsGarantiaRepuestoIsuzuManoObra1->GopCosto;	
			}

		}

	}

	$InsGarantiaRepuestoIsuzu->GriTotalRepuesto = $InsGarantiaRepuestoIsuzu->GriSubTotalRepuestoStock;
	$InsGarantiaRepuestoIsuzu->GriSubTotal = $InsGarantiaRepuestoIsuzu->GriTotalRepuesto + $InsGarantiaRepuestoIsuzu->GriTotalManoObra;
	$InsGarantiaRepuestoIsuzu->GriImpuesto = $InsGarantiaRepuestoIsuzu->GriSubTotal * ($InsGarantiaRepuestoIsuzu->GriPorcentajeImpuestoVenta/100);
	$InsGarantiaRepuestoIsuzu->GriTotal = $InsGarantiaRepuestoIsuzu->GriSubTotal + $InsGarantiaRepuestoIsuzu->GriImpuesto;

	if($Guardar){

		if($InsGarantiaRepuestoIsuzu->MtdEditarGarantiaRepuestoIsuzu()){
			
			$InsGarantiaRepuestoIsuzu->MtdEditarGarantiaRepuestoIsuzuDato("GriNumeroComprobante",$InsGarantiaRepuestoIsuzu->GriNumeroComprobante,$InsGarantiaRepuestoIsuzu->GriId);
			$InsGarantiaRepuestoIsuzu->MtdEditarGarantiaRepuestoIsuzuDato("GriFechaPago",$InsGarantiaRepuestoIsuzu->GriFechaPago,$InsGarantiaRepuestoIsuzu->GriId);
			$InsGarantiaRepuestoIsuzu->MtdEditarGarantiaRepuestoIsuzuDato("CueId",$InsGarantiaRepuestoIsuzu->CueId,$InsGarantiaRepuestoIsuzu->GriId);
		
			$Edito = true;
			$Resultado.='#SAS_GRI_102';
			
		}else{
			$Resultado.='#ERR_GRI_102';
		}

	}	
	
	$InsGarantiaRepuestoIsuzu->GriFechaEmision = FncCambiaFechaANormal($InsGarantiaRepuestoIsuzu->GriFechaEmision);		
	$InsGarantiaRepuestoIsuzu->GriFechaVenta = FncCambiaFechaANormal($InsGarantiaRepuestoIsuzu->GriFechaVenta,true);	
	$InsGarantiaRepuestoIsuzu->GriTransaccionFecha = FncCambiaFechaANormal($InsGarantiaRepuestoIsuzu->GriTransaccionFecha,true);
	
	$InsGarantiaRepuestoIsuzu->GriFechaPago = FncCambiaFechaANormal($InsGarantiaRepuestoIsuzu->GriFechaPago,true);

		
}else{

	FncCargarDatos();
}


function FncCargarDatos(){

	global $InsGarantiaRepuestoIsuzu;
	global $Identificador;
	
	global $GET_Id;

	unset($_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador]);
	unset($_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador]);
	unset($_SESSION['InsGarantiaRepuestoIsuzuFoto'.$Identificador]);
	
	unset($_SESSION['SesGriFotoVIN'.$Identificador]);
	unset($_SESSION['SesGriFotoFrontal'.$Identificador]);
	unset($_SESSION['SesGriFotoCupon'.$Identificador]);
	unset($_SESSION['SesGriFotoMantenimiento'.$Identificador]);
	
	$_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador] = new ClsSesionObjeto();	
	$_SESSION['InsGarantiaRepuestoIsuzuFoto'.$Identificador] = new ClsSesionObjeto();
	
	$_SESSION['SesGriFotoVIN'.$Identificador] = $InsFichaIngreso->FinFotoVIN;
	$_SESSION['SesGriFotoFrontal'.$Identificador] = $InsFichaIngreso->FinFotoFrontal;
	$_SESSION['SesGriFotoCupon'.$Identificador] = $InsFichaIngreso->FinFotoCupon;
	$_SESSION['SesGriFotoMantenimiento'.$Identificador] = $InsFichaIngreso->FinFotoMantenimiento;
	
	$InsGarantiaRepuestoIsuzu->GriId = $GET_Id;
	$InsGarantiaRepuestoIsuzu->MtdObtenerGarantiaRepuestoIsuzu();


	$InsFichaIngreso = new ClsFichaIngreso();
	$InsFichaIngreso->FinId = $InsGarantiaRepuestoIsuzu->FinId ;
	$InsFichaIngreso->MtdObtenerFichaIngreso();
	
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){

			$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;

				if(!empty($InsFichaAccion->FichaAccionFoto)){
					foreach($InsFichaAccion->FichaAccionFoto as $DatFichaAccionFoto){
						
						$_SESSION['InsGarantiaRepuestoIsuzuFoto'.$Identificador]->MtdAgregarSesionObjeto(1,
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
	
	
//	if(empty($InsGarantiaRepuestoIsuzu->GriCausa)){
//		$InsGarantiaRepuestoIsuzu->GriCausa = $InsGarantiaRepuestoIsuzu->FccCausa;
//	}
//	

	
	
	//SesionObjeto-InsGarantiaRepuestoIsuzuManoObra
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
		
	if(!empty($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra)){
		
		foreach($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuManoObra as $DatGarantiaRepuestoIsuzuManoObra){					
		
		if($InsGarantiaRepuestoIsuzu->MonId<>$EmpresaMonedaId ){

			$DatGarantiaRepuestoIsuzuManoObra->GopCosto = round($DatGarantiaRepuestoIsuzuManoObra->GopCosto / $InsGarantiaRepuestoIsuzu->GriTipoCambio,2);
			$DatGarantiaRepuestoIsuzuManoObra->GopValor = round($DatGarantiaRepuestoIsuzuManoObra->GopValor / $InsGarantiaRepuestoIsuzu->GriTipoCambio,2);

		}
			
			$_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatGarantiaRepuestoIsuzuManoObra->GopId,
			$DatGarantiaRepuestoIsuzuManoObra->GopNumero,
			$DatGarantiaRepuestoIsuzuManoObra->GopTiempo,	
			$DatGarantiaRepuestoIsuzuManoObra->GopValor,
			$DatGarantiaRepuestoIsuzuManoObra->GopCosto,
			$DatGarantiaRepuestoIsuzuManoObra->GopEstado,
			($DatGarantiaRepuestoIsuzuManoObra->GopTiempoCreacion),
			($DatGarantiaRepuestoIsuzuManoObra->GopTiempoModificacion),
			
			$DatGarantiaRepuestoIsuzuManoObra->GopTransaccionNumero,
			$DatGarantiaRepuestoIsuzuManoObra->GopTransaccionFecha,
			$DatGarantiaRepuestoIsuzuManoObra->GopFechaAprobacion,
			$DatGarantiaRepuestoIsuzuManoObra->GopFechaPago,
			$DatGarantiaRepuestoIsuzuManoObra->FaeId
			);
		}
		
	}			

//SesionObjeto-InsGarantiaRepuestoIsuzuDetalle
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


	if(!empty($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuDetalle)){
		foreach($InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuDetalle as $DatGarantiaRepuestoIsuzuDetalle){					

			if($InsGarantiaRepuestoIsuzu->MonId<>$EmpresaMonedaId  ){
				$DatGarantiaRepuestoIsuzuDetalle->GdeCosto = round($DatGarantiaRepuestoIsuzuDetalle->GdeCosto / $InsGarantiaRepuestoIsuzu->GriTipoCambio,2);
				$DatGarantiaRepuestoIsuzuDetalle->GdeCostoTotal = round($DatGarantiaRepuestoIsuzuDetalle->GdeCostoTotal  / $InsGarantiaRepuestoIsuzu->GriTipoCambio,2);
				$DatGarantiaRepuestoIsuzuDetalle->GdeCostoMargen = round($DatGarantiaRepuestoIsuzuDetalle->GdeCostoMargen  / $InsGarantiaRepuestoIsuzu->GriTipoCambio,2);
			}
			
			$_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatGarantiaRepuestoIsuzuDetalle->GdeId,
			$DatGarantiaRepuestoIsuzuDetalle->ProId,
			$DatGarantiaRepuestoIsuzuDetalle->UmeId,
			
			$DatGarantiaRepuestoIsuzuDetalle->GdeCodigo,
			$DatGarantiaRepuestoIsuzuDetalle->GdeDescripcion,
			
			$DatGarantiaRepuestoIsuzuDetalle->GdeCosto,
			$DatGarantiaRepuestoIsuzuDetalle->GdeCantidad,
			($DatGarantiaRepuestoIsuzuDetalle->GdeCostoTotal),		
			($DatGarantiaRepuestoIsuzuDetalle->GdeEstado),
			($DatGarantiaRepuestoIsuzuDetalle->GdeTiempoCreacion),
			($DatGarantiaRepuestoIsuzuDetalle->GopTiempoModificacion),
			0,
			0,
			$DatGarantiaRepuestoIsuzuDetalle->AmdId,
			
			$DatGarantiaRepuestoIsuzuDetalle->ProCodigoOriginal,
			$DatGarantiaRepuestoIsuzuDetalle->ProNombre,
			$DatGarantiaRepuestoIsuzuDetalle->UmeNombre
			);

		}
	}

}

?>

