<?php

//deb($_POST);
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
	$InsGarantia->GarTipoCambio = $_POST['CmpTipoCambio'];
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
	
	$InsGarantia->GarNumeroComprobante = $_POST['CmpNumeroComprobante'];	
		
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

	$ResGarantiaDetalle = $_SESSION['InsGarantiaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResGarantiaDetalle['Datos'])){
		foreach($ResGarantiaDetalle['Datos'] as $DatSesionObjeto){

			$InsGarantiaDetalle1 = new ClsGarantiaDetalle();
			$InsGarantiaDetalle1->GdeId = $DatSesionObjeto->Parametro1;

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

			$InsGarantiaDetalle1->GdeEstado = $DatSesionObjeto->Parametro9;
			$InsGarantiaDetalle1->GdeTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro10);
			$InsGarantiaDetalle1->GdeTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro11);
			$InsGarantiaDetalle1->GdeEliminado = $DatSesionObjeto->Eliminado;				
			$InsGarantiaDetalle1->InsMysql = NULL;
			
			if($InsGarantiaDetalle1->GdeEliminado == 1){					
				$InsGarantia->GarantiaDetalle[] = $InsGarantiaDetalle1;		
//				$InsGarantia->GarSubTotalRepuestoStock += $InsGarantiaDetalle1->GdeCostoMargen;	

$InsGarantia->GarSubTotalRepuestoStock += $InsGarantiaDetalle1->GdeCostoTotal;	
			}

		}

	}



	
	
	$ResGarantiaOperacion = $_SESSION['InsGarantiaOperacion'.$Identificador]->MtdObtenerSesionObjetos(true);

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
	
			$InsGarantiaOperacion1 = new ClsGarantiaOperacion();
			$InsGarantiaOperacion1->GopId = $DatSesionObjeto->Parametro1;
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

		if($InsGarantia->MtdRegistrarGarantia()){
			
			$InsGarantia->MtdEditarGarantiaDato("GarNumeroComprobante",$InsGarantia->GarNumeroComprobante,$InsGarantia->GarId);
			$InsGarantia->MtdEditarGarantiaDato("GarFechaPago",$InsGarantia->GarFechaPago,$InsGarantia->GarId);
			$InsGarantia->MtdEditarGarantiaDato("CueId",$InsGarantia->CueId,$InsGarantia->GarId);
			
			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFactura->FinId,9);
			
			unset($InsGarantia);

			FncNuevo();

			$Registro = true;
			$Resultado.='#SAS_GAR_101';

		}else{
			
			$InsGarantia->GarFechaEmision = FncCambiaFechaANormal($InsGarantia->GarFechaEmision);		
			$InsGarantia->GarFechaVenta = FncCambiaFechaANormal($InsGarantia->GarFechaVenta,true);			
			$Resultado.='#ERR_GAR_101';
		}

	}else{
		$InsGarantia->GarFechaEmision = FncCambiaFechaANormal($InsGarantia->GarFechaEmision);		
		$InsGarantia->GarFechaVenta = FncCambiaFechaANormal($InsGarantia->GarFechaVenta,true);			
	}
	
	
}else{

	FncNuevo();

	$InsFichaIngreso = new ClsFichaIngreso();
	$InsFichaIngreso->FinId = $InsFichaAccion->FinId;
	$InsFichaIngreso->MtdObtenerFichaIngreso();
		
	$InsGarantia->FinId = $InsFichaIngreso->FinId;
	$InsGarantia->FinVehiculoKilometraje = $InsFichaIngreso->FinVehiculoKilometraje;
	
	$InsGarantia->GarFechaEmision = $InsFichaIngreso->FinFecha;//date("d/m/Y");
	$InsGarantia->EinVIN = $InsFichaIngreso->EinVIN;
	$InsGarantia->VmaNombre = $InsFichaIngreso->VmaNombre;
	$InsGarantia->VmoNombre = $InsFichaIngreso->VmaNombre;
	$InsGarantia->GarModelo = $InsFichaIngreso->VmaNombre." ".$InsFichaIngreso->VveNombre;
	$InsGarantia->EinPlaca = $InsFichaIngreso->EinPlaca;

	$InsGarantia->VmaId = $InsFichaIngreso->VmaId;
	$InsGarantia->VmoId = $InsFichaIngreso->VmoId;
	$InsGarantia->VmoId = $InsFichaIngreso->VmoId;
	
	$InsGarantia->FccId = $InsFichaAccion->FccId;
	
	$InsGarantia->CliId = $InsFichaIngreso->CliId;
	$InsGarantia->CliNombre = $InsFichaIngreso->CliNombre;
	$InsGarantia->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
	$InsGarantia->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
	$InsGarantia->TdoId = $InsFichaIngreso->TdoId;
	$InsGarantia->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
	$InsGarantia->GarDireccion = $InsFichaIngreso->FinDireccion;
	$InsGarantia->GarCiudad = "Tacna";
	
	$InsGarantia->GarCausa = $InsFichaAccion->FccCausa;
	
	
	$InsGarantia->MonId = "MON-10001";
	$InsGarantia->GarTarifaAutorizada = 50;
	
	
		$InsTipoCambio = new ClsTipoCambio();
		$InsTipoCambio->MonId = "MON-10001";
		$InsTipoCambio->TcaFecha = date("Y-m-d");

		$InsTipoCambio->MtdObtenerTipoCambioActual();

		if(empty($InsTipoCambio->TcaId)){
			$InsTipoCambio->MtdObtenerTipoCambioUltimo();
		}
		
	$InsGarantia->GarTipoCambio = $InsTipoCambio->TcaMontoComercial;
	$InsGarantia->GarPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	
	$InsGarantia->GarObservacion = chr(13).date("d/m/Y H:i:s")." - Garantia Generada de Ord. Trab.:".$InsFichaIngreso->FinId;

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

	
	if(!empty($InsFichaAccion->FichaAccionProducto)){
		foreach($InsFichaAccion->FichaAccionProducto as $DatFichaAccionProducto){

			$ProductoListaPrecio = 0;

			if(!empty($DatFichaAccionProducto->ProCodigoOriginal)){
				
				$InsProductoListaPrecio = new ClsProductoListaPrecio();
				
				$RepProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatFichaAccionProducto->ProCodigoOriginal,"PlpId","ASC","1",NULL);
				$ArrProductoListaPrecios = $RepProductoListaPrecio['Datos'];
				
				foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
					
					if($InsGarantia->MonId <> $EmpresaMonedaId){						
						if($DatProductoListaPrecio->MonId == $InsGarantia->MonId){
							$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecioReal;
						}else{
							$ProductoListaPrecio = ($DatProductoListaPrecio->PlpPrecio/$InsGarantia->GarTipoCambio);
						}					
					}else{
						$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecio;
					}
				}
				
			}
			
			$CostoTotal = $ProductoListaPrecio * $DatFichaAccionProducto->FapCantidad;
			$MargenUtilidad = empty($InsConfiguracionEmpresa->CalMargen)?0:$InsConfiguracionEmpresa->CalMargen;
			
			$_SESSION['InsGarantiaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			$DatFichaAccionProducto->ProId,
			$DatFichaAccionProducto->UmeId,
			$DatFichaAccionProducto->ProCodigoOriginal,	
			$DatFichaAccionProducto->ProNombre,
			$ProductoListaPrecio,
			$DatFichaAccionProducto->FapCantidad,
			($CostoTotal),		
			(1),
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s"),
			$MargenUtilidad,
			( ($MargenUtilidad/100) * $CostoTotal)+ $CostoTotal
			);
			
		}
	}
	
	//SesionObjeto-InsGarantiaOperacion
	//Parametro1 = GopId
	//Parametro2 = GopNumero
	//Parametro3 = GopTiempo
	//Parametro4 = GopValor
	//Parametro5 = GopCosto
	//Parametro6 = GopEstado
	//Parametro7 = GopTiempoCreacion
	//Parametro8 = GopTiempoModificacion
	//deb($InsConfiguracionEmpresa);

	//deb($InsConfiguracionEmpresa->CalId);
	
	if(!empty($InsConfiguracionEmpresa->CalId)){

		if($InsGarantia->MonId <> $InsConfiguracionEmpresa->MonId){
			$InsConfiguracionEmpresa->CalCosto = $InsConfiguracionEmpresa->CalCosto / $InsConfiguracionEmpresa->CalTipoCambio;
		}

	}
	
	
		//SesionObjeto-InsGarantiaOperacion
	//Parametro1 = GopId
	//Parametro2 = GopNumero
	//Parametro3 = GopTiempo
	//Parametro4 = GopValor
	//Parametro5 = GopCosto
	//Parametro6 = GopEstado
	//Parametro7 = GopTiempoCreacion
	//Parametro8 = GopTiempoModificacion
	
	
	if(!empty($InsFichaAccion->FichaAccionTempario)){
		foreach($InsFichaAccion->FichaAccionTempario as $DatFichaAccionTempario){					

			$Costo = $InsConfiguracionEmpresa->CalCosto * $DatFichaAccionTempario->FaeTiempo;
			
			$_SESSION['InsGarantiaOperacion'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			$DatFichaAccionTempario->FaeCodigo,
			$DatFichaAccionTempario->FaeTiempo,	
			$InsConfiguracionEmpresa->CalCosto,
			$Costo,
			1,
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s")
			);

		}
	}		
	

}


function FncNuevo(){
	
	global $Identificador;
	global $InsGarantia;

	unset($_SESSION['InsGarantiaOperacion'.$Identificador]);
	unset($_SESSION['InsGarantiaDetalle'.$Identificador]);

	$_SESSION['InsGarantiaOperacion'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsGarantiaDetalle'.$Identificador] = new ClsSesionObjeto();	

	$InsGarantia = new ClsGarantia();
	$InsGarantia->GarFechaEmision = date("d/m/Y");

}



?>

