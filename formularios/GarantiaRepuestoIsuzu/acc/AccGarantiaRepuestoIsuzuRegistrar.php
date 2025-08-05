<?php

//deb($_POST);
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
	$InsGarantiaRepuestoIsuzu->GriTipoCambio = $_POST['CmpTipoCambio'];
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
	
	$InsGarantiaRepuestoIsuzu->GriNumeroComprobante = $_POST['CmpNumeroComprobante'];	
		
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

	$ResGarantiaRepuestoIsuzuDetalle = $_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResGarantiaRepuestoIsuzuDetalle['Datos'])){
		foreach($ResGarantiaRepuestoIsuzuDetalle['Datos'] as $DatSesionObjeto){

			$InsGarantiaRepuestoIsuzuDetalle1 = new ClsGarantiaRepuestoIsuzuDetalle();
			$InsGarantiaRepuestoIsuzuDetalle1->GdeId = $DatSesionObjeto->Parametro1;

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

			$InsGarantiaRepuestoIsuzuDetalle1->GdeEstado = $DatSesionObjeto->Parametro9;
			$InsGarantiaRepuestoIsuzuDetalle1->GdeTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro10);
			$InsGarantiaRepuestoIsuzuDetalle1->GdeTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro11);
			$InsGarantiaRepuestoIsuzuDetalle1->GdeEliminado = $DatSesionObjeto->Eliminado;				
			$InsGarantiaRepuestoIsuzuDetalle1->InsMysql = NULL;
			
			if($InsGarantiaRepuestoIsuzuDetalle1->GdeEliminado == 1){					
				$InsGarantiaRepuestoIsuzu->GarantiaRepuestoIsuzuDetalle[] = $InsGarantiaRepuestoIsuzuDetalle1;		
//				$InsGarantiaRepuestoIsuzu->GriSubTotalRepuestoStock += $InsGarantiaRepuestoIsuzuDetalle1->GdeCostoMargen;	

$InsGarantiaRepuestoIsuzu->GriSubTotalRepuestoStock += $InsGarantiaRepuestoIsuzuDetalle1->GdeCostoTotal;	
			}

		}

	}



	
	
	$ResGarantiaRepuestoIsuzuManoObra = $_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador]->MtdObtenerSesionObjetos(true);

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
	
			$InsGarantiaRepuestoIsuzuManoObra1 = new ClsGarantiaRepuestoIsuzuManoObra();
			$InsGarantiaRepuestoIsuzuManoObra1->GopId = $DatSesionObjeto->Parametro1;
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

		if($InsGarantiaRepuestoIsuzu->MtdRegistrarGarantiaRepuestoIsuzu()){
			
			$InsGarantiaRepuestoIsuzu->MtdEditarGarantiaRepuestoIsuzuDato("GriNumeroComprobante",$InsGarantiaRepuestoIsuzu->GriNumeroComprobante,$InsGarantiaRepuestoIsuzu->GriId);
			$InsGarantiaRepuestoIsuzu->MtdEditarGarantiaRepuestoIsuzuDato("GriFechaPago",$InsGarantiaRepuestoIsuzu->GriFechaPago,$InsGarantiaRepuestoIsuzu->GriId);
			$InsGarantiaRepuestoIsuzu->MtdEditarGarantiaRepuestoIsuzuDato("CueId",$InsGarantiaRepuestoIsuzu->CueId,$InsGarantiaRepuestoIsuzu->GriId);
			
			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFactura->FinId,9);
			
			unset($InsGarantiaRepuestoIsuzu);

			FncNuevo();

			$Registro = true;
			$Resultado.='#SAS_GRI_101';

		}else{
			
			$InsGarantiaRepuestoIsuzu->GriFechaEmision = FncCambiaFechaANormal($InsGarantiaRepuestoIsuzu->GriFechaEmision);		
			$InsGarantiaRepuestoIsuzu->GriFechaVenta = FncCambiaFechaANormal($InsGarantiaRepuestoIsuzu->GriFechaVenta,true);			
			$Resultado.='#ERR_GRI_101';
		}

	}else{
		$InsGarantiaRepuestoIsuzu->GriFechaEmision = FncCambiaFechaANormal($InsGarantiaRepuestoIsuzu->GriFechaEmision);		
		$InsGarantiaRepuestoIsuzu->GriFechaVenta = FncCambiaFechaANormal($InsGarantiaRepuestoIsuzu->GriFechaVenta,true);			
	}
	
	
}else{

	FncNuevo();

	$InsFichaIngreso = new ClsFichaIngreso();
	$InsFichaIngreso->FinId = $InsFichaAccion->FinId;
	$InsFichaIngreso->MtdObtenerFichaIngreso();
		
	$InsGarantiaRepuestoIsuzu->FinId = $InsFichaIngreso->FinId;
	$InsGarantiaRepuestoIsuzu->FinVehiculoKilometraje = $InsFichaIngreso->FinVehiculoKilometraje;
	
	$InsGarantiaRepuestoIsuzu->GriFechaEmision = $InsFichaIngreso->FinFecha;//date("d/m/Y");
	$InsGarantiaRepuestoIsuzu->EinVIN = $InsFichaIngreso->EinVIN;
	$InsGarantiaRepuestoIsuzu->VmaNombre = $InsFichaIngreso->VmaNombre;
	$InsGarantiaRepuestoIsuzu->VmoNombre = $InsFichaIngreso->VmaNombre;
	$InsGarantiaRepuestoIsuzu->GriModelo = $InsFichaIngreso->VmaNombre." ".$InsFichaIngreso->VveNombre;
	$InsGarantiaRepuestoIsuzu->EinPlaca = $InsFichaIngreso->EinPlaca;

	$InsGarantiaRepuestoIsuzu->VmaId = $InsFichaIngreso->VmaId;
	$InsGarantiaRepuestoIsuzu->VmoId = $InsFichaIngreso->VmoId;
	$InsGarantiaRepuestoIsuzu->VmoId = $InsFichaIngreso->VmoId;
	
	$InsGarantiaRepuestoIsuzu->FccId = $InsFichaAccion->FccId;
	
	$InsGarantiaRepuestoIsuzu->CliId = $InsFichaIngreso->CliId;
	$InsGarantiaRepuestoIsuzu->CliNombre = $InsFichaIngreso->CliNombre;
	$InsGarantiaRepuestoIsuzu->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
	$InsGarantiaRepuestoIsuzu->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
	$InsGarantiaRepuestoIsuzu->TdoId = $InsFichaIngreso->TdoId;
	$InsGarantiaRepuestoIsuzu->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
	$InsGarantiaRepuestoIsuzu->GriDireccion = $InsFichaIngreso->FinDireccion;
	$InsGarantiaRepuestoIsuzu->GriCiudad = "Tacna";
	
	$InsGarantiaRepuestoIsuzu->GriCausa = $InsFichaAccion->FccCausa;
	
	
	$InsGarantiaRepuestoIsuzu->MonId = "MON-10001";
	$InsGarantiaRepuestoIsuzu->GriTarifaAutorizada = 50;
	
	
		$InsTipoCambio = new ClsTipoCambio();
		$InsTipoCambio->MonId = "MON-10001";
		$InsTipoCambio->TcaFecha = date("Y-m-d");

		$InsTipoCambio->MtdObtenerTipoCambioActual();

		if(empty($InsTipoCambio->TcaId)){
			$InsTipoCambio->MtdObtenerTipoCambioUltimo();
		}
		
	$InsGarantiaRepuestoIsuzu->GriTipoCambio = $InsTipoCambio->TcaMontoComercial;
	$InsGarantiaRepuestoIsuzu->GriPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	
	$InsGarantiaRepuestoIsuzu->GriObservacion = chr(13).date("d/m/Y H:i:s")." - GarantiaRepuestoIsuzu Generada de Ord. Trab.:".$InsFichaIngreso->FinId;

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

	
	if(!empty($InsFichaAccion->FichaAccionProducto)){
		foreach($InsFichaAccion->FichaAccionProducto as $DatFichaAccionProducto){

			$ProductoListaPrecio = 0;

			if(!empty($DatFichaAccionProducto->ProCodigoOriginal)){
				
				$InsProductoListaPrecio = new ClsProductoListaPrecio();
				
				$RepProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatFichaAccionProducto->ProCodigoOriginal,"PlpId","ASC","1",NULL);
				$ArrProductoListaPrecios = $RepProductoListaPrecio['Datos'];
				
				foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
					
					if($InsGarantiaRepuestoIsuzu->MonId <> $EmpresaMonedaId){						
						if($DatProductoListaPrecio->MonId == $InsGarantiaRepuestoIsuzu->MonId){
							$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecioReal;
						}else{
							$ProductoListaPrecio = ($DatProductoListaPrecio->PlpPrecio/$InsGarantiaRepuestoIsuzu->GriTipoCambio);
						}					
					}else{
						$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecio;
					}
				}
				
			}
			
			$CostoTotal = $ProductoListaPrecio * $DatFichaAccionProducto->FapCantidad;
			$MargenUtilidad = empty($InsConfiguracionEmpresa->CalMargen)?0:$InsConfiguracionEmpresa->CalMargen;
			
			$_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
	
	//SesionObjeto-InsGarantiaRepuestoIsuzuManoObra
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

		if($InsGarantiaRepuestoIsuzu->MonId <> $InsConfiguracionEmpresa->MonId){
			$InsConfiguracionEmpresa->CalCosto = $InsConfiguracionEmpresa->CalCosto / $InsConfiguracionEmpresa->CalTipoCambio;
		}

	}
	
	
		//SesionObjeto-InsGarantiaRepuestoIsuzuManoObra
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
			
			$_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador]->MtdAgregarSesionObjeto(1,
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
	global $InsGarantiaRepuestoIsuzu;

	unset($_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador]);
	unset($_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador]);

	$_SESSION['InsGarantiaRepuestoIsuzuManoObra'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsGarantiaRepuestoIsuzuDetalle'.$Identificador] = new ClsSesionObjeto();	

	$InsGarantiaRepuestoIsuzu = new ClsGarantiaRepuestoIsuzu();
	$InsGarantiaRepuestoIsuzu->GriFechaEmision = date("d/m/Y");

}



?>

