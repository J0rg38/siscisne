<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){		
	
	$Resultado = '';
	$Guardar = true;
	
	$InsVentaDirecta->UsuId = $_SESSION['SesionId'];	
	
	$InsVentaDirecta->VdiId = $_POST['CmpId'];
	$InsVentaDirecta->SucId = $_SESSION['SesionSucursal'];
	$InsVentaDirecta->CliId = $_POST['CmpClienteId'];
	$InsVentaDirecta->PerId = $_POST['CmpPersonal'];
	
	$InsVentaDirecta->FinId = $_POST['CmpFichaIngresoId'];
	
	$InsVentaDirecta->EinId = $_POST['CmpVehiculoIngresoId'];
//	$InsVentaDirecta->EinId = $_POST['CmpClienteVehiculoIngresoId'];
	$InsVentaDirecta->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsVentaDirecta->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	
	$InsVentaDirecta->NpaId = $_POST['CmpCondicionPago'];
	
	$InsVentaDirecta->VdiOrdenCompraNumero = $_POST['CmpOrdenCompraNumero'];
	$InsVentaDirecta->VdiOrdenCompraFecha = FncCambiaFechaAMysql($_POST['CmpOrdenCompraFecha'],true);
	
	$InsVentaDirecta->VdiMarca = $_POST['CmpVehiculoIngresoMarca'];
	$InsVentaDirecta->VdiModelo = $_POST['CmpVehiculoIngresoModelo'];
	$InsVentaDirecta->VdiPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsVentaDirecta->VdiAnoModelo = $_POST['CmpVehiculoIngresoAnoModelo'];
	$InsVentaDirecta->VdiAnoFabricacion = $_POST['CmpVehiculoIngresoAnoFabricacion'];
	
	//$InsVentaDirecta->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	//$InsVentaDirecta->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	//$InsVentaDirecta->VveNombre = $_POST['CmpVehiculoIngresoVersion'];
	
	$InsVentaDirecta->TopId = "TOP-10000";	
	//$InsVentaDirecta->TopId = $_POST['CmpTipoOperacion'];
	
	$InsVentaDirecta->VdiFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	list($InsVentaDirecta->VdiAno,$Mes,$Dia) = explode("-",$InsVentaDirecta->VdiFecha);

	$InsVentaDirecta->MonId = $_POST['CmpMonedaId'];
	$InsVentaDirecta->VdiTipoCambio = $_POST['CmpTipoCambio'];
	$InsVentaDirecta->VdiTipo = $_POST['CmpTipo'];
	$InsVentaDirecta->VdiTipoFinal = $_POST['CmpTipoFinal'];
	
	$InsVentaDirecta->VdiObservacion = addslashes($_POST['CmpObservacion']);
	$InsVentaDirecta->VdiObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsVentaDirecta->VdiResultado = addslashes($_POST['CmpResultado']);
	$InsVentaDirecta->VdiOrigen =  $_POST['CmpOrigen'];
	
	$InsVentaDirecta->VdiAbono = eregi_replace(",","",(empty($_POST['CmpAbono'])?0:$_POST['CmpAbono']));
	$InsVentaDirecta->VdiManoObra = eregi_replace(",","",(empty($_POST['CmpManoObra'])?0:$_POST['CmpManoObra']));
	$InsVentaDirecta->VdiPorcentajeDescuento = eregi_replace(",","",(empty($_POST['CmpPorcentajeDescuento'])?0:$_POST['CmpPorcentajeDescuento']));
//	$InsVentaDirecta->VdiDescuento = eregi_replace(",","",(empty($_POST['CmpDescuento'])?0:$_POST['CmpDescuento']));
	//deb($InsVentaDirecta->VdiAbono);
	
	$InsVentaDirecta->VdiIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsVentaDirecta->VdiNotificar = (empty($_POST['CmpNotificar'])?2:$_POST['CmpNotificar']);
	
	$InsVentaDirecta->VdiArchivo = $_SESSION['SesVdiArchivo'.$Identificador];
	$InsVentaDirecta->VdiArchivoEntrega = $_SESSION['SesVdiArchivoEntrega'.$Identificador];
	$InsVentaDirecta->VdiArchivoEntrega2 = $_SESSION['SesVdiArchivoEntrega2'.$Identificador];
	$InsVentaDirecta->VdiCantidadDias = eregi_replace(",","",(empty($_POST['CmpCreditoDias'])?0:$_POST['CmpCreditoDias']));
	
	$InsVentaDirecta->VdiEstado = $_POST['CmpEstado'];
	$InsVentaDirecta->VdiTiempoCreacion = date("Y-m-d H:i:s");
	$InsVentaDirecta->VdiTiempoModificacion = date("Y-m-d H:i:s");

	$InsVentaDirecta->VdiPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	$InsVentaDirecta->VdiPorcentajeMargenUtilidad = eregi_replace(",","",(empty($_POST['CmpClienteMargenUtilidad'])?0:$_POST['CmpClienteMargenUtilidad']));	//$InsVentaDirecta->VdiPorcentajeMargenUtilidad = $_POST['CmpClienteTipoUtilidad'];
	$InsVentaDirecta->VdiPorcentajeOtroCosto = eregi_replace(",","",(empty($_POST['CmpPorcentajeOtroCosto'])?0:$_POST['CmpPorcentajeOtroCosto']));
	$InsVentaDirecta->VdiPorcentajeManoObra = eregi_replace(",","",(empty($_POST['CmpPorcentajeManoObra'])?0:$_POST['CmpPorcentajeManoObra']));
	
	//$InsVentaDirecta->VdiPorcentajeMargenUtilidad = $_POST['CmpClienteTipoUtilidad'];
	//$InsVentaDirecta->VdiPorcentajeMargenUtilidad = 0;
	$InsVentaDirecta->LtiId = $_POST['CmpClienteTipo'];	

	$InsVentaDirecta->CliNombre = $_POST['CmpClienteNombre'];
	$InsVentaDirecta->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsVentaDirecta->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsVentaDirecta->TdoId = $_POST['CmpClienteTipoDocumento'];	
	$InsVentaDirecta->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsVentaDirecta->CliTelefono = $_POST['CmpClienteTelefono'];
	
	$InsVentaDirecta->CliNombreSeguro = $_POST['CmpClienteNombreSeguro'];
	$InsVentaDirecta->CliApellidoPaternoSeguro = $_POST['CmpClienteApellidoPaternoSeguro'];
	$InsVentaDirecta->CliApellidoMaternoSeguro = $_POST['CmpClienteApellidoMaternoSeguro'];

//	$InsVentaDirecta->CliEmail = $_POST['CmpClienteEmail'];
//	$InsVentaDirecta->CliCelular = $_POST['CmpClienteCelular'];
//	$InsVentaDirecta->CliFax = $_POST['CmpClienteFax'];

	$InsVentaDirecta->VdiDireccion = $_POST['CmpClienteDireccion'];	
	$InsVentaDirecta->CliCelular = $_POST['CmpClienteCelular'];	
	
	$InsVentaDirecta->CprId = $_POST['CmpCotizacionProductoId'];	
	$InsVentaDirecta->VdiGenerarVentaConcretada = $_POST['CmpGenerarVentaConcretada'];	

	$InsVentaDirecta->VentaDirectaDetalle = array();
	$InsVentaDirecta->VentaDirectaPlanchado = array();
	$InsVentaDirecta->VentaDirectaPintado = array();
	$InsVentaDirecta->VentaDirectaCentrado = array();
	$InsVentaDirecta->VentaDirectaTarea = array();

	$InsVentaDirecta->VdiPlanchadoTotal = 0;
	$InsVentaDirecta->VdiPintadoTotal = 0;
	$InsVentaDirecta->VdiCentradoTotal = 0;
	$InsVentaDirecta->VdiTareaTotal = 0;
	
	$InsVentaDirecta->VdiDescuento = 0;
	$InsVentaDirecta->VdiSubTotal = 0;
	$InsVentaDirecta->VdiImpuesto = 0;
	$InsVentaDirecta->VdiTotal = 0;
	$InsVentaDirecta->VdiObservado = 2;
	
	if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
		if(empty($InsVentaDirecta->VdiTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_VDI_120';
		}
	}

	if(empty($InsVentaDirecta->CliId)){
		$Guardar = false;
		$Resultado.='#ERR_VDI_123';
	}

	
	//if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
//		$InsVentaDirecta->VdiDescuento = $InsVentaDirecta->VdiDescuento * $InsVentaDirecta->VdiTipoCambio;
//	}

	if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
		$InsVentaDirecta->VdiManoObra = round($InsVentaDirecta->VdiManoObra * $InsVentaDirecta->VdiTipoCambio,6);
	}	
	
	if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
		$InsVentaDirecta->VdiAbono = round($InsVentaDirecta->VdiAbono * $InsVentaDirecta->VdiTipoCambio,6);
	}
	
	//deb($InsVentaDirecta->VdiOrdenCompraNumero);
	if(!empty($InsVentaDirecta->VdiOrdenCompraNumero)){
		
		if($InsVentaDirecta->MtdVerificarExisteVentaDirectaDato("VdiOrdenCompraNumero",$InsVentaDirecta->VdiOrdenCompraNumero,$InsVentaDirecta->CliId)){
			$Guardar = false;
			$Resultado.='#ERR_VDI_122';
		};

	}
	

/*
SesionObjeto-VentaDirectaDetalle
Parametro1 = VddId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = VddPrecioVenta
Parametro5 = VddCantidad
Parametro6 = VddImporte
Parametro7 = VddTiempoCreacion
Parametro8 = VddTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = VddCantidadReal
Parametro13 = ProCodigoOriginal
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = VerificarStock
Parametro17 = VddCosto
Parametro18 = ProStock
Parametro19 = ProStockReal
Parametro20 = VddCantidadPedir
Parametro21 = VddCantidadPedirFecha
Parametro22 = CrdId
Parametro23 = VddNuevo
Parametro24 = VddCantidadPorLlegar
Parametro25 = AmdCantidad
Parametro26 = VddEstado
Parametro27 = VdiId

Parametro28 = VddRemplazo
Parametro29 = ProIdPedido
Parametro30 = ProCodigoOriginalPedido

Parametro31 = PcdBOFecha
Parametro32 = PcdBOEstado
Parametro33 = VddFechaPorLlegar
Parametro34 = AmdEstado
Parametro35 = VddTipoPedido

Parametro36 = VddPrecioBruto

Parametro37 = VddValorTotal
Parametro38 = VddDescuento
Parametro39 = VddPorcentajeUtilidad
Parametro40 = VddPorcentajeOtroCosto
Parametro41 = VddPorcentajeManoObra
Parametro42 = VddPorcentajePedido

Parametro43 = VddPorcentajeAdicional
Parametro44 = VddPorcentajeDescuento
Parametro45 = VddAdicional
Parametro46 = VddDescuentoUnitario
Parametro47 = VddImporteBruto
Parametro48 = VddAdicionalUnitario

*/

	$ResVentaDirectaDetalle = $_SESSION['InsVentaDirectaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];

//deb($ArrVentaDirectaDetalles);
	if(!empty($ArrVentaDirectaDetalles) or 1 == 1){
		$item = 1;
		foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){


			if($InsVentaDirecta->MonId <> $EmpresaMonedaId){
				
				$DatVentaDirectaDetalle->Parametro36 = round($DatVentaDirectaDetalle->Parametro36 * $InsVentaDirecta->VdiTipoCambio,6);
				$DatVentaDirectaDetalle->Parametro37 = round($DatVentaDirectaDetalle->Parametro37 * $InsVentaDirecta->VdiTipoCambio,6);
				$DatVentaDirectaDetalle->Parametro17 = round($DatVentaDirectaDetalle->Parametro17 * $InsVentaDirecta->VdiTipoCambio,6);
				$DatVentaDirectaDetalle->Parametro4 = round($DatVentaDirectaDetalle->Parametro4 * $InsVentaDirecta->VdiTipoCambio,6);
				$DatVentaDirectaDetalle->Parametro6 = round($DatVentaDirectaDetalle->Parametro6 * $InsVentaDirecta->VdiTipoCambio,6);
				
				$DatVentaDirectaDetalle->Parametro45 = round($DatVentaDirectaDetalle->Parametro45 * $InsVentaDirecta->VdiTipoCambio,6);
				$DatVentaDirectaDetalle->Parametro48 = round($DatVentaDirectaDetalle->Parametro48 * $InsVentaDirecta->VdiTipoCambio,6);
				$DatVentaDirectaDetalle->Parametro38 = round($DatVentaDirectaDetalle->Parametro38 * $InsVentaDirecta->VdiTipoCambio,6);
				$DatVentaDirectaDetalle->Parametro46 = round($DatVentaDirectaDetalle->Parametro46 * $InsVentaDirecta->VdiTipoCambio,6);
				
				$DatVentaDirectaDetalle->Parametro46 = round($DatVentaDirectaDetalle->Parametro46 * $InsVentaDirecta->VdiTipoCambio,6);
			  
			}	
		
			$InsVentaDirectaDetalle1 = new ClsVentaDirectaDetalle();

//			$DetallePrecioBruto = 0;
//			$DetalleDescuento = 0;
//			$DetallePrecio = 0;
//			$DetalleImporte = 0;
		
			//if(!empty($InsVentaDirecta->VdiPorcentajeDescuento)){
//				
//				$DetallePrecioBruto = ($DatVentaDirectaDetalle->Parametro36);
//				$DetallePrecio = $DetallePrecioBruto;
//				$DetalleImporte = ($DetallePrecio * $DatVentaDirectaDetalle->Parametro5);
//					
//				$DetallePrecioDescuento =  $DetallePrecio - ($DetallePrecio * ($InsVentaDirecta->VdiPorcentajeDescuento/100));
//				
//				$DetalleDescuento = ($DetalleImporte * ($InsVentaDirecta->VdiPorcentajeDescuento/100));
//				$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
//			
//			}else{
//			
//				$DetallePrecioBruto = ($DatVentaDirectaDetalle->Parametro36);
//				$DetallePrecio = $DetallePrecioBruto;
//				$DetalleImporte = ($DetallePrecio * $DatVentaDirectaDetalle->Parametro5);
//				
//				$DetallePrecioDescuento =  $DetallePrecio;
//				
//				$DetalleDescuento = 0;
//				$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
//			
//			}
		
			$InsVentaDirectaDetalle1->ProId = $DatVentaDirectaDetalle->Parametro2;
			$InsVentaDirectaDetalle1->UmeId = $DatVentaDirectaDetalle->Parametro10;

			//$InsVentaDirectaDetalle1->ProNombre = $DatVentaDirectaDetalle->Parametro3;
//			$InsVentaDirectaDetalle1->ProCodigoOriginal = $DatVentaDirectaDetalle->Parametro13;
//			$InsVentaDirectaDetalle1->ProCodigoAlternativo = $DatVentaDirectaDetalle->Parametro14;
//			
//			$InsVentaDirectaDetalle1->UmeIdOrigen = $DatVentaDirectaDetalle->Parametro15;
//			$InsVentaDirectaDetalle1->UmeNombre =  $DatVentaDirectaDetalle->Parametro9;
//			$InsVentaDirectaDetalle1->RtiId = $DatVentaDirectaDetalle->Parametro11;

			$InsVentaDirectaDetalle1->VddCantidadPedir = 0;
			$InsVentaDirectaDetalle1->VddCantidadPedirFecha = NULL;
			
			$InsVentaDirectaDetalle1->VddUtilidad = 0;			
			$InsVentaDirectaDetalle1->VddCostoExtraTotal = 0;	
			
			//$InsVentaDirectaDetalle1->VerificarStock = $DatVentaDirectaDetalle->Parametro16;
			$InsVentaDirectaDetalle1->VddCosto = $DatVentaDirectaDetalle->Parametro17;
			$InsVentaDirectaDetalle1->VddValorTotal = $DatVentaDirectaDetalle->Parametro37;
			
			$InsVentaDirectaDetalle1->VddPorcentajeUtilidad = $DatVentaDirectaDetalle->Parametro39;
			$InsVentaDirectaDetalle1->VddPorcentajeOtroCosto =  $DatVentaDirectaDetalle->Parametro40;
			$InsVentaDirectaDetalle1->VddPorcentajeManoObra = $DatVentaDirectaDetalle->Parametro41;
			$InsVentaDirectaDetalle1->VddPorcentajePedido = $DatVentaDirectaDetalle->Parametro42;
			
			$InsVentaDirectaDetalle1->VddPorcentajeAdicional = $DatVentaDirectaDetalle->Parametro43;
			$InsVentaDirectaDetalle1->VddPorcentajeDescuento = $DatVentaDirectaDetalle->Parametro44;
			
			$InsVentaDirectaDetalle1->VddPrecioBruto =  $DatVentaDirectaDetalle->Parametro36;
			$InsVentaDirectaDetalle1->VddImporteBruto =  $DatVentaDirectaDetalle->Parametro33;
			
			$InsVentaDirectaDetalle1->VddPrecioVenta =  $DatVentaDirectaDetalle->Parametro4;
			$InsVentaDirectaDetalle1->VddImporte = $DatVentaDirectaDetalle->Parametro6;
			
			$InsVentaDirectaDetalle1->VddAdicional = $DatVentaDirectaDetalle->Parametro45;//*
			$InsVentaDirectaDetalle1->VddAdicionalUnitario = $DatVentaDirectaDetalle->Parametro48;
			$InsVentaDirectaDetalle1->VddDescuento = $DatVentaDirectaDetalle->Parametro38;//*
			$InsVentaDirectaDetalle1->VddDescuentoUnitario = $DatVentaDirectaDetalle->Parametro46;
			
			$InsVentaDirectaDetalle1->VddCantidadReal = $DatVentaDirectaDetalle->Parametro12;
			$InsVentaDirectaDetalle1->VddCantidad = $DatVentaDirectaDetalle->Parametro5;
			
			$InsVentaDirectaDetalle1->VddTipoPedido = $DatVentaDirectaDetalle->Parametro35;
			//$InsVentaDirectaDetalle1->VddEstado = $DatVentaDirectaDetalle->Parametro26;
			$InsVentaDirectaDetalle1->VddEstado = (empty($_POST['CmpVentaDirectaDetalleEstado_'.$DatVentaDirectaDetalle->Item])?2:$_POST['CmpVentaDirectaDetalleEstado_'.$DatVentaDirectaDetalle->Item]);
			$InsVentaDirectaDetalle1->VddTiempoCreacion = FncCambiaFechaAMysql($DatVentaDirectaDetalle->Parametro7);
			$InsVentaDirectaDetalle1->VddTiempoModificacion = FncCambiaFechaAMysql($DatVentaDirectaDetalle->Parametro8);

			$InsVentaDirectaDetalle1->CrdId = $DatVentaDirectaDetalle->Parametro22;

			$InsVentaDirectaDetalle1->VddEliminado = $DatVentaDirectaDetalle->Eliminado;
			$InsVentaDirectaDetalle1->InsMysql = NULL;

			if($InsVentaDirectaDetalle1->VddEliminado==1){					
				$InsVentaDirecta->VentaDirectaDetalle[] = $InsVentaDirectaDetalle1;		
			
			}

			if($InsVentaDirectaDetalle1->VddEliminado==1 and ($DatVentaDirectaDetalle->Parametro26 == 1 or $DatVentaDirectaDetalle->Parametro26 == 7)){
				
				$InsVentaDirecta->VdiProductoTotal += $InsVentaDirectaDetalle1->VddImporte;	
				$InsVentaDirecta->VdiDescuento += $InsCotizacionProductoDetalle1->VddDescuento;	

			}
			
//			if(!empty($InsVentaDirecta->VdiPorcentajeDescuento)){
//				$InsVentaDirecta->VdiDescuento = $InsVentaDirecta->VdiProductoTotal * ($InsVentaDirecta->VdiPorcentajeDescuento/100);
//				$InsVentaDirecta->VdiProductoTotal = $InsVentaDirecta->VdiProductoTotal - $InsVentaDirecta->VdiDescuento;
//			}			
			
//						SesionObjeto-VentaDirectaDetalle
//						Parametro1 = VddId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = VddPrecioVenta
//						Parametro5 = VddCantidad
//						Parametro6 = VddImporte
//						Parametro7 = VddTiempoCreacion
//						Parametro8 = VddTiempoModificacion
//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = VddCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo
//						Parametro15 = UmeIdOrigen
//						Parametro16 = VerificarStock
//						Parametro17 = VddCosto
//						Parametro18 = ProStock
//						Parametro19 = ProStockReal
//						Parametro20 = VddCantidadPedir
//						Parametro21 = VddCantidadPedirFecha
//						Parametro22 = CrdId
//						Parametro23 = VddNuevo

//				$InsProducto->ProId = $InsVentaDirectaDetalle1->ProId;
//				$InsProducto->MtdObtenerProducto(false);
//				
//				$_SESSION['InsVentaDirectaDetalle'.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
//				$InsVentaDirectaDetalle1->VddId,
//				$InsVentaDirectaDetalle1->ProId,
//				$InsVentaDirectaDetalle1->ProNombre,
//				$InsVentaDirectaDetalle1->VddPrecioVenta,
//				$InsVentaDirectaDetalle1->VddCantidad,
//				$InsVentaDirectaDetalle1->VddImporte,
//				$InsVentaDirectaDetalle1->VddTiempoCreacion,
//				$InsVentaDirectaDetalle1->VddTiempoModificacion,
//				$InsVentaDirectaDetalle1->UmeNombre,
//				$InsVentaDirectaDetalle1->UmeId,
//				$InsVentaDirectaDetalle1->RtiId,
//				$InsVentaDirectaDetalle1->VddCantidadReal,
//				$InsVentaDirectaDetalle1->ProCodigoOriginal,
//				$InsVentaDirectaDetalle1->ProCodigoAlternativo,
//				$InsVentaDirectaDetalle1->UmeIdOrigen,
//				$InsVentaDirectaDetalle1->VerificarStock,
//				$InsVentaDirectaDetalle1->VddCosto,
//				$InsProducto->ProStock,
//				$InsProducto->ProStockReal,
//				$InsVentaDirectaDetalle1->VddCantidadPedir,	
//				$InsVentaDirectaDetalle1->VddCantidadPedirFecha,
//				$InsVentaDirectaDetalle1->CrdId
//				);
			$item++;	
		}

		if(!empty($InsVentaDirecta->VdiPorcentajeDescuento)){
			//$InsVentaDirecta->VdiDescuento = $InsVentaDirecta->VdiProductoTotal * ($InsVentaDirecta->VdiPorcentajeDescuento/100);
			//$InsVentaDirecta->VdiProductoTotal = $InsVentaDirecta->VdiProductoTotal - $InsVentaDirecta->VdiDescuento;
		}	

	}else{
		$Guardar = false;
		$Resultado.='#ERR_VDI_111';
	}




	$ResVentaDirectaPlanchado = $_SESSION['InsVentaDirectaPlanchado'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResVentaDirectaPlanchado['Datos'])){
		foreach($ResVentaDirectaPlanchado['Datos'] as $DatSesionObjeto){

			if($InsVentaDirecta->MonId <> $EmpresaMonedaId){
				$DatSesionObjeto->Parametro5 = round($DatSesionObjeto->Parametro5 * $InsVentaDirecta->VdiTipoCambio,6);
			}	
			
/*
SesionObjeto-VentaDirectaPlanchado
Parametro1 = VdtId
Parametro2 = 
Parametro3 = VdtDescripcion
Parametro4 = 
Parametro5 = VdtImporte
Parametro6 = VdtTiempoCreacion
Parametro7 = VdtTiempoModificacion
*/
			$InsVentaDirectaPlanchado1 = new ClsVentaDirectaTarea();
			$InsVentaDirectaPlanchado1->VdtId = $DatSesionObjeto->Parametro1;
			$InsVentaDirectaPlanchado1->VdtDescripcion = $DatSesionObjeto->Parametro3;
			//if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
//				$InsVentaDirectaPlanchado1->VdtImporte = $DatSesionObjeto->Parametro5 * $InsVentaDirecta->VdiTipoCambio;
//			}else{
//				$InsVentaDirectaPlanchado1->VdtImporte = $DatSesionObjeto->Parametro5;
//			}
			$InsVentaDirectaPlanchado1->VdtImporte = $DatSesionObjeto->Parametro5;
			$InsVentaDirectaPlanchado1->VdtEstado = 1;
			$InsVentaDirectaPlanchado1->VdtTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			$InsVentaDirectaPlanchado1->VdtTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			
			$InsVentaDirectaPlanchado1->VdtEliminado = $DatSesionObjeto->Eliminado;				
			//$InsVentaDirectaPlanchado1->InsMysql = NULL;
				
			if($InsVentaDirectaPlanchado1->VdtEliminado==1){
				
				$InsVentaDirecta->VentaDirectaPlanchado[] = $InsVentaDirectaPlanchado1;
				$InsVentaDirecta->VdiPlanchadoTotal += $InsVentaDirectaPlanchado1->VdtImporte;
			
			}				
		}		
	}
	
	
	$ResVentaDirectaPintado = $_SESSION['InsVentaDirectaPintado'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResVentaDirectaPintado['Datos'])){
		foreach($ResVentaDirectaPintado['Datos'] as $DatSesionObjeto){

			if($InsVentaDirecta->MonId <> $EmpresaMonedaId){
				$DatSesionObjeto->Parametro5 = round($DatSesionObjeto->Parametro5 * $InsVentaDirecta->VdiTipoCambio,6);
			}
/*
SesionObjeto-VentaDirectaPlanchado
Parametro1 = VdtId
Parametro2 = 
Parametro3 = VdtDescripcion
Parametro4 = 
Parametro5 = VdtImporte
Parametro6 = VdtTiempoCreacion
Parametro7 = VdtTiempoModificacion
*/
			$InsVentaDirectaPintado1 = new ClsVentaDirectaTarea();
			$InsVentaDirectaPintado1->VdtId = $DatSesionObjeto->Parametro1;
			$InsVentaDirectaPintado1->VdtDescripcion = $DatSesionObjeto->Parametro3;
			$InsVentaDirectaPintado1->VdtImporte = $DatSesionObjeto->Parametro5;
			
			//if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
//				$InsVentaDirectaPintado1->VdtImporte = $DatSesionObjeto->Parametro5 * $InsVentaDirecta->VdiTipoCambio;
//			}else{
//				$InsVentaDirectaPintado1->VdtImporte = $DatSesionObjeto->Parametro5;
//			}

			$InsVentaDirectaPintado1->VdtEstado = 1;
			$InsVentaDirectaPintado1->VdtTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			$InsVentaDirectaPintado1->VdtTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			
			$InsVentaDirectaPintado1->VdtEliminado = $DatSesionObjeto->Eliminado;				
			//$InsVentaDirectaPintado1->InsMysql = NULL;
			
			if($InsVentaDirectaPintado1->VdtEliminado==1){
				$InsVentaDirecta->VentaDirectaPintado[] = $InsVentaDirectaPintado1;
				$InsVentaDirecta->VdiPintadoTotal += $InsVentaDirectaPintado1->VdtImporte;			
			}				
		}		
	}
	
	
	$ResVentaDirectaCentrado = $_SESSION['InsVentaDirectaCentrado'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResVentaDirectaCentrado['Datos'])){
		foreach($ResVentaDirectaCentrado['Datos'] as $DatSesionObjeto){

			if($InsVentaDirecta->MonId <> $EmpresaMonedaId){
				$DatSesionObjeto->Parametro5 = round($DatSesionObjeto->Parametro5 * $InsVentaDirecta->VdiTipoCambio,6);
			}
/*
SesionObjeto-VentaDirectaPlanchado
Parametro1 = VdtId
Parametro2 = 
Parametro3 = VdtDescripcion
Parametro4 = 
Parametro5 = CrdImporte
Parametro6 = CrdTiempoCreacion
Parametro7 = CrdTiempoModificacion
*/

			$InsVentaDirectaCentrado1 = new ClsVentaDirectaTarea();
			$InsVentaDirectaCentrado1->VdtId = $DatSesionObjeto->Parametro1;
			$InsVentaDirectaCentrado1->VdtDescripcion = $DatSesionObjeto->Parametro3;
			$InsVentaDirectaCentrado1->VdtImporte = $DatSesionObjeto->Parametro5;
			
			//if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
//				$InsVentaDirectaCentrado1->VdtImporte = $DatSesionObjeto->Parametro5 * $InsVentaDirecta->VdiTipoCambio;
//			}else{
//				$InsVentaDirectaCentrado1->VdtImporte = $DatSesionObjeto->Parametro5;
//			}
			
			$InsVentaDirectaCentrado1->VdtEstado = 1;
			$InsVentaDirectaCentrado1->VdtTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			$InsVentaDirectaCentrado1->VdtTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			
			$InsVentaDirectaCentrado1->VdtEliminado = $DatSesionObjeto->Eliminado;				
		//	$InsVentaDirectaCentrado1->InsMysql = NULL;

			if($InsVentaDirectaCentrado1->VdtEliminado==1){
				$InsVentaDirecta->VentaDirectaCentrado[] = $InsVentaDirectaCentrado1;
				$InsVentaDirecta->VdiCentradoTotal += $InsVentaDirectaCentrado1->VdtImporte;			
			}				
		}		
	}
	


	$ResVentaDirectaTarea = $_SESSION['InsVentaDirectaTarea'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResVentaDirectaTarea['Datos'])){
		foreach($ResVentaDirectaTarea['Datos'] as $DatSesionObjeto){

			if($InsVentaDirecta->MonId <> $EmpresaMonedaId){
				$DatSesionObjeto->Parametro5 = round($DatSesionObjeto->Parametro5 * $InsVentaDirecta->VdiTipoCambio,6);
			}

			/*
			SesionObjeto-VentaDirectaPlanchado
			Parametro1 = VdtId
			Parametro2 = 
			Parametro3 = VdtDescripcion
			Parametro4 = 
			Parametro5 = CrdImporte
			Parametro6 = CrdTiempoCreacion
			Parametro7 = CrdTiempoModificacion
			*/

			$InsVentaDirectaTarea1 = new ClsVentaDirectaTarea();
			$InsVentaDirectaTarea1->VdtId = $DatSesionObjeto->Parametro1;
			$InsVentaDirectaTarea1->VdtDescripcion = $DatSesionObjeto->Parametro3;
			$InsVentaDirectaTarea1->VdtImporte = $DatSesionObjeto->Parametro5;

//			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
//				$InsVentaDirectaTarea1->VdtImporte = $DatSesionObjeto->Parametro5 * $InsVentaDirecta->VdiTipoCambio;
//			}else{
//				$InsVentaDirectaTarea1->VdtImporte = $DatSesionObjeto->Parametro5;
//			}
			
			$InsVentaDirectaTarea1->VdtEstado = 1;
			$InsVentaDirectaTarea1->VdtTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			$InsVentaDirectaTarea1->VdtTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			
			$InsVentaDirectaTarea1->VdtEliminado = $DatSesionObjeto->Eliminado;				
			//$InsVentaDirectaTarea1->InsMysql = NULL;
			
			if($InsVentaDirectaTarea1->VdtEliminado==1){
				$InsVentaDirecta->VentaDirectaTarea[] = $InsVentaDirectaTarea1;
				$InsVentaDirecta->VdiTareaTotal += $InsVentaDirectaTarea1->VdtImporte;
			}				
		}		
	}
		
//	if($InsVentaDirecta->VdiIncluyeImpuesto==1){
//		
//		$InsVentaDirecta->VdiSubTotal = round($InsVentaDirecta->VdiProductoTotal + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal,6);
//		$InsVentaDirecta->VdiImpuesto = round(($InsVentaDirecta->VdiSubTotal * ($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)),6);
//		$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiSubTotal + $InsVentaDirecta->VdiImpuesto,6);
//		
//	}else{
//		
//		$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiProductoTotal + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal,6);	
//		$InsVentaDirecta->VdiSubTotal = round($InsVentaDirecta->VdiTotal * (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1),6);
//		$InsVentaDirecta->VdiImpuesto = round(($InsVentaDirecta->VdiTotal - $InsVentaDirecta->VdiSubTotal),6);
//		
//	}	

	//		SesionObjeto-VentaDirectaFoto
	//		Parametro1 = VdfId
	//		Parametro2 =
	//		Parametro3 = VdfArchivo
	//		Parametro4 = VdfEstado
	//		Parametro5 = VdfTiempoCreacion
	//		Parametro6 = VdfTiempoModificacion
	//		Parametro7 = VdfTipo

			$RepSesionObjetos = $_SESSION['InsVentaDirectaFoto'.$Identificador]->MtdObtenerSesionObjetos(true);
			$ArrSesionObjetos = $RepSesionObjetos['Datos'];

			if(!empty($ArrSesionObjetos)){
				foreach($ArrSesionObjetos as $DatSesionObjeto){
			
					$InsVentaDirectaFoto1 = new ClsVentaDirectaFoto();
					$InsVentaDirectaFoto1->VdfId = $DatSesionObjeto->Parametro1;
					$InsVentaDirectaFoto1->VdfArchivo = $DatSesionObjeto->Parametro3;
					$InsVentaDirectaFoto1->VdfTipo = $DatSesionObjeto->Parametro7;
					$InsVentaDirectaFoto1->VdfEstado = $DatSesionObjeto->Parametro4;
					$InsVentaDirectaFoto1->VdfTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro5);
					$InsVentaDirectaFoto1->VdfTiempoModificacion = date("Y-m-d H:i:s");
					$InsVentaDirectaFoto1->VdfEliminado = $DatSesionObjeto->Eliminado;
					$InsVentaDirectaFoto1->InsMysql = NULL;

					$InsVentaDirecta->VentaDirectaFoto[] = $InsVentaDirectaFoto1;	

				}
			}
			
				
	if($InsVentaDirecta->VdiIncluyeImpuesto==2){

		//$InsVentaDirecta->VdiSubTotal = round($InsVentaDirecta->VdiProductoTotal - $InsVentaDirecta->VdiDescuento  + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal,6);
		$InsVentaDirecta->VdiSubTotal = round($InsVentaDirecta->VdiProductoTotal + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal,6);
		$InsVentaDirecta->VdiImpuesto = round(($InsVentaDirecta->VdiSubTotal * ($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)),6);
		$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiSubTotal + $InsVentaDirecta->VdiImpuesto,6);
		
	}else{
		
		//$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiProductoTotal,6);
		//$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiProductoTotal - $InsVentaDirecta->VdiDescuento + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal,6);	
		$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiProductoTotal + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal,6);	
		$InsVentaDirecta->VdiSubTotal = round($InsVentaDirecta->VdiTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1),6);
		$InsVentaDirecta->VdiImpuesto = round(($InsVentaDirecta->VdiTotal - $InsVentaDirecta->VdiSubTotal),6);
		
	}
	
	
		//deb( $InsVentaDirecta->VdiTotal . " - ". $InsVentaDirecta->VdiManoObra);
	//$InsVentaDirecta->VdiTotal = $InsVentaDirecta->VdiTotal + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal;
	

//	if($InsVentaDirecta->VdiIncluyeImpuesto == 1){
//
//		$InsVentaDirecta->VdiSubTotal = $InsVentaDirecta->VdiProductoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$InsVentaDirecta->VdiSubTotal = $InsVentaDirecta->VdiSubTotal - $InsVentaDirecta->VdiDescuento;
//		
//		$InsVentaDirecta->VdiManoObra = $InsVentaDirecta->VdiManoObra / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$InsVentaDirecta->VdiPlanchadoTotal = $InsVentaDirecta->VdiPlanchadoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$InsVentaDirecta->VdiPintadoTotal = $InsVentaDirecta->VdiPintadoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$InsVentaDirecta->VdiCentradoTotal = $InsVentaDirecta->VdiCentradoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$InsVentaDirecta->VdiTareaTotal = $InsVentaDirecta->VdiTareaTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		
//		
//	}else{
//
//		$InsVentaDirecta->VdiSubTotal = $InsVentaDirecta->VdiProductoTotal - $InsVentaDirecta->VdiDescuento;
//
//	}
//
//	$InsVentaDirecta->VdiSubTotal = $InsVentaDirecta->VdiSubTotal + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal;
//	$InsVentaDirecta->VdiImpuesto = $InsVentaDirecta->VdiSubTotal * ($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100);
//	$InsVentaDirecta->VdiTotal = $InsVentaDirecta->VdiSubTotal + $InsVentaDirecta->VdiImpuesto;	
//	
	
	if($Guardar){
			
		if($InsVentaDirecta->MtdRegistrarVentaDirecta()){
				
			$Registro = true;
			$Resultado.='#SAS_VDI_101';
			
			
				
				if($InsVentaDirecta->VdiGenerarVentaConcretada=="1"){
							
					//principal.php?Mod=VentaConcretada&Form=Registrar&Origen=VentaDirecta&VdiId
					//$InsMensaje->MtdRedireccionar("principal.php?Mod=VentaConcretada&Form=Registrar&Origen=VentaDirecta&VdiId=".$InsVentaDirecta->VdiId,true,1000);	
					
					$AlmacenId = "";
					
					if(!empty($ArrAlmacenes)){
						foreach($ArrAlmacenes as $DatAlmacen){
							$AlmacenId = $DatAlmacen->AlmId;		
						}
					}
						
					$RegistrarVentaConcretada = false;
					
					$InsVentaConcretada = new ClsVentaConcretada();
					$InsVentaConcretada->UsuId = $_SESSION['SesionId'];	
					$InsVentaConcretada->SucId = $_SESSION['SesionSucursal'];
	
					$InsVentaConcretada->VdiId = $InsVentaDirecta->VdiId;
					$InsVentaConcretada->CprId = $InsVentaDirecta->CprId;
					
					$InsVentaConcretada->TopId = "TOP-10000";	
	
					$InsVentaConcretada->AlmId = $AlmacenId;
					$InsVentaConcretada->VcoFecha = date("Y-m-d");
				
					$InsVentaConcretada->MonId = $InsVentaDirecta->MonId;
					$InsVentaConcretada->VcoTipoCambio = $InsVentaDirecta->VdiTipoCambio;
						
					$InsVentaConcretada->CliId = $InsVentaDirecta->CliId;
					$InsVentaConcretada->CliNombre = $InsVentaDirecta->CliNombre;
					$InsVentaConcretada->CliApellidoPaterno = $InsVentaDirecta->CliApellidoPaterno;
					$InsVentaConcretada->CliApellidoMaterno = $InsVentaDirecta->CliApellidoMaterno;
		
					$InsVentaConcretada->CliNumeroDocumento = $InsVentaDirecta->CliNumeroDocumento;
					$InsVentaConcretada->TdoId = $InsVentaDirecta->TdoId;
					$InsVentaConcretada->LtiId = $InsVentaDirecta->LtiId;
					$InsVentaConcretada->VcoMargenUtilidad = $InsVentaDirecta->VdiMargenUtilidad;
					$InsVentaConcretada->VcoOrigen = "VDI";
					
					$InsVentaConcretada->VcoDescuento = 0;
					$InsVentaConcretada->VcoIncluyeImpuesto = $InsVentaDirecta->VdiIncluyeImpuesto;
		
					$InsVentaConcretada->VcoDireccion = $InsVentaDirecta->VdiDireccion;
		
					$InsVentaConcretada->VcoObservacion = $InsVentaDirecta->VdiObservacion.chr(13).date("d/m/Y H:i:s")." - Venta Concretada Generada de Ord. Ven.:".$InsVentaDirecta->VdiId;

					
					$InsVentaConcretada->CprId = $InsVentaDirecta->CprId;
					$InsVentaConcretada->VcoManoObra = $InsVentaDirecta->VdiManoObra;
		
					if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
						$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento / $InsVentaConcretada->VcoTipoCambio,6);
					}
					
					
					if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
						$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra / $InsVentaConcretada->VcoTipoCambio,6);
					}
		
					if(!empty($InsVentaDirecta->VentaDirectaDetalle)){
						foreach($InsVentaDirecta->VentaDirectaDetalle as $DatVentaDirectaDetalle){
		
							if($DatVentaDirectaDetalle->VddEstado == 1){
								
								$GuardarDetalle = true;
			
								if($DatVentaDirectaDetalle->VddReemplazo == "Si"){
									$InsProducto->ProId = $DatVentaDirectaDetalle->ProIdPedido;
									$InsProducto->MtdObtenerProducto(false);
								}else{
									$InsProducto->ProId = $DatVentaDirectaDetalle->ProId;
									$InsProducto->MtdObtenerProducto(false);
								}
								
								if(!empty($DatVentaDirectaDetalle->UmeId)){
			
									$InsUnidadMedida->UmeId = $DatVentaDirectaDetalle->UmeId;
									$InsUnidadMedida->MtdObtenerUnidadMedida();
													  
									if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
										$InsUnidadMedidaConversion->UmcEquivalente = 1;
									}else{
										$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
										$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
										  
										foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
											$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
										}
									}
			
									if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
										$DatVentaDirectaDetalle->VddCantidadReal = round($DatVentaDirectaDetalle->VddCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
									}else{
										$DatVentaDirectaDetalle->VddCantidadReal = '';
									}
								
								}else{
									$DatVentaDirectaDetalle->VddCantidadReal = '';
								}
									
								$DatVentaDirectaDetalle->ProCosto = $InsProducto->ProCosto;
								
								if($DatVentaDirectaDetalle->VddCantidadPendiente2<=0){
									$GuardarDetalle = false;	
								}
		
								
								if($GuardarDetalle){
									
									$CantidadPendienteReal  = $DatVentaDirectaDetalle->VddCantidadPendiente2 * $InsUnidadMedidaConversion->UmcEquivalente;	
									$CantidadPendiente = $DatVentaDirectaDetalle->VddCantidadPendiente2;
									
									$DetallePrecio = ($DatVentaDirectaDetalle->VddPrecioVenta);
									$DetalleImporte = ($DetallePrecio *  $CantidadPendiente);
						
						
									if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
									
										$DatVentaDirectaDetalle->ProCosto = round($DatVentaDirectaDetalle->ProCosto / $InsVentaConcretada->VcoTipoCambio,6);
										
										$DetallePrecio = round($DetallePrecio / $InsVentaConcretada->VcoTipoCambio,6);
										$DetalleImporte = round($DetalleImporte / $InsVentaConcretada->VcoTipoCambio,6);
										
									}
		
									
								
									$InsVentaConcretadaDetalle1 = new ClsVentaConcretadaDetalle();
			
									$InsVentaConcretadaDetalle1->VerificarStock	= 2;			
									
									$InsVentaConcretadaDetalle1->VcdId = NULL;
									$InsVentaConcretadaDetalle1->ProId = $DatVentaDirectaDetalle->ProId;
									$InsVentaConcretadaDetalle1->UmeId = $DatVentaDirectaDetalle->UmeId;
									$InsVentaConcretadaDetalle1->VddId = $DatVentaDirectaDetalle->VddId;
									
									$InsVentaConcretadaDetalle1->VcdReingreso = 2;
									$InsVentaConcretadaDetalle1->VcdCostoExtraTotal = 0;
						
									if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
										$InsVentaConcretadaDetalle1->VcdCosto = $DatVentaDirectaDetalle->ProCosto * $InsVentaConcretada->VcoTipoCambio;
									}else{
										$InsVentaConcretadaDetalle1->VcdCosto = $DatVentaDirectaDetalle->ProCosto;
									}
						
									if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
										$InsVentaConcretadaDetalle1->VcdPrecioVenta = $DetallePrecio * $InsVentaConcretada->VcoTipoCambio;
									}else{
										$InsVentaConcretadaDetalle1->VcdPrecioVenta = $DetallePrecio;
									}
						
									$InsVentaConcretadaDetalle1->VcdCantidad = $CantidadPendiente;
						
										$InsProducto->ProId = $InsVentaConcretadaDetalle1->ProId;
										$InsProducto->MtdObtenerProducto(false);
										
										if(!empty($InsVentaConcretadaDetalle1->UmeId)){
										
											$InsUnidadMedida->UmeId = $InsVentaConcretadaDetalle1->UmeId;
											$InsUnidadMedida->MtdObtenerUnidadMedida();
															  
											if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
												$InsUnidadMedidaConversion->UmcEquivalente = 1;
											}else{
												$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
												$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
												  
												foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
													$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
												}
											}
										
											if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
												$InsVentaConcretadaDetalle1->VcdCantidadReal = round($InsVentaConcretadaDetalle1->VcdCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
											}else{
												$InsVentaConcretadaDetalle1->VcdCantidadReal = '';
											}
										
										}else{
											$InsVentaConcretadaDetalle1->VcdCantidadReal = '';
										}
						
									if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
										$InsVentaConcretadaDetalle1->VcdImporte = $DetalleImporte * $InsVentaConcretada->VcoTipoCambio;
									}else{
										$InsVentaConcretadaDetalle1->VcdImporte = $DetalleImporte;
									}
						
									$InsVentaConcretadaDetalle1->VcdTiempoCreacion = date("Y-m-d H:i:s");
									$InsVentaConcretadaDetalle1->VcdTiempoModificacion = date("Y-m-d H:i:s");
									
									$InsVentaConcretadaDetalle1->VcdCompraOrigen = NULL;
									$InsVentaConcretadaDetalle1->VcdEstado = 3;
									
									$InsVentaConcretadaDetalle1->VcdValorTotal = 0;
									$InsVentaConcretadaDetalle1->VcdUtilidad = 0;
									$InsVentaConcretadaDetalle1->VcdEliminado = 1;				
									$InsVentaConcretadaDetalle1->InsMysql = NULL;
									
									$InsVentaConcretada->VentaConcretadaDetalle[] = $InsVentaConcretadaDetalle1;	
									$InsVentaConcretada->VcoTotalBruto += $InsVentaConcretadaDetalle1->VcdImporte;	
									
			
								
								}
								
								
							}
							
		
						}
					}
					
					
					if($RegistrarVentaConcretada){
						
						if($InsVentaConcretada->MtdRegistrarVentaConcretada()){
							
							
						}else{
							
							$Resultado.='#ERR_VDI_902';
							$RegistrarVentaConcretada = false;
							
						}
						
					}
					
					
					
				}
				
				
				if(!empty($InsVentaDirecta->VdiAbono) and $InsVentaDirecta->VdiAbono <> "0.00"){
					
					$GuardarAbono = true;
					
					$InsPago = new ClsPago();
				
					$InsPago->PagId = NULL;
					$InsPago->SucId = $_SESSION['SesionSucursal'];
					$InsPago->PagFecha = date("Y-m-d");
					$InsPago->CliId = $InsVentaDirecta->CliId;
					$InsPago->AreId = "ARE-10000";
					$InsPago->VdiId = $InsVentaDirecta->Vdiid;
					$InsPago->NpaId = "NPA-10000";
					$InsPago->FpaId = "FPA-10000";
					
					$InsPago->MonId = $InsVentaDirecta->MonId;
					$InsPago->PagTipoCambio = $InsVentaDirecta->PagTipoCambio;
					$InsPago->PagMonto = eregi_replace(",","",(empty($_POST['CmpAbono'])?0:$_POST['CmpAbono']));

					$InsPago->PagObservacion = date("d/m/Y H:i:s")." - Orden de Cobro Generada de Ord. Ven.:".$InsVentaDirecta->VdiId;;
					$InsPago->PagObservacion .= $InsVentaDirecta->VdiObservacion;;

					$InsPago->PagConcepto = "Adelanto de orden ".$InsVentaDirecta->VdiId;

					$InsPago->PagUtilizado = 2;	
					$InsPago->PagTipo = "VDI";		
					$InsPago->PagEstado = 1;		
					$InsPago->PagTiempoCreacion = date("Y-m-d H:i:s");
					$InsPago->PagTiempoModificacion = date("Y-m-d H:i:s");
					$InsPago->PagEliminado = 1;
					
					$InsPago->PagoComprobante = array();
				
					if($InsPago->MonId<>$EmpresaMonedaId){
						if(empty($InsPago->PagTipoCambio)){
							$GuardarAbono = false;
							$Resultado.='#ERR_VDI_901';
						}
					}
				
					if($InsPago->MonId<>$EmpresaMonedaId ){
						$InsPago->PagMonto = round($InsPago->PagMonto * $InsPago->PagTipoCambio,6);
					}
					
					$InsPagoComprobante1 = new ClsPagoComprobante();
					$InsPagoComprobante1->PacId = NULL;
					$InsPagoComprobante1->VdiId = $InsVentaDirecta->VdiId;
					$InsPagoComprobante1->PacEstado = 1;
					$InsPagoComprobante1->PacTiempoCreacion = date("Y-m-d H:i:s");
					$InsPagoComprobante1->PacTiempoModificacion = date("Y-m-d H:i:s");
					$InsPagoComprobante1->PacEliminado = 1;
					
					$InsPago->PagoComprobante[] = $InsPagoComprobante1;
			
			
					if($GuardarAbono){
						
						if($InsPago->MtdRegistrarPago()){
							
							$MensajeAdicional = "";
							$MensajeAdicional .= "Cliente: ".$InsVentaDirecta->CliNombre." ".$InsVentaDirecta->CliApellidoPaterno." ".$InsCliente->CliApellidoMaterno;
							//FncNotificarOrdenCobroVentaDirecta($oVentaDirectaId,$oPago,$oUsuarioId,$oUsuario,$oDescripcionAdicional=NULL)
							$InsPago->FncNotificarOrdenCobroVentaDirecta($InsPago->VdiId,$InsPago->PagId,$_SESSION['SesionId'], $_SESSION['SesionUsuario'],$MensajeAdicional);

						}else{
							
							$Resultado.='#ERR_VDI_900';
							
						}
						
					}
					
					
				}
				
				
			//$InsVentaDirecta->MtdVentaDirectaActualizarProductoUso($InsVentaDirecta->VdiId);

			if($InsVentaDirecta->VdiNotificar==1){
				
				$InsCliente = new ClsCliente();
				$InsCliente->CliId = $InsVentaDirecta->CliId;
				$InsCliente->MtdObtenerCliente();
				
				$Destinatarios = (!empty($InsCliente->CliEmail)?','.$InsCliente->CliEmail:'').(!empty($InsCliente->CliContactoEmail1)?','.$InsCliente->CliContactoEmail1:'').(!empty($InsCliente->CliContactoEmail2)?','.$InsCliente->CliContactoEmail2:'').(!empty($InsCliente->CliContactoEmail3)?','.$InsCliente->CliContactoEmail3:'');

				//$InsVentaDirecta->MtdNotificarVentaDirectaRegistro($InsVentaDirecta->VdiId,$Destinatarios.",jblanco@cyc.com.pe",true);
				$InsVentaDirecta->MtdNotificarVentaDirectaRegistro($InsVentaDirecta->VdiId,$Destinatarios,true);

			}
			
			

			FncNuevo();

		}else{
			$InsVentaDirecta->VdiFecha = FncCambiaFechaANormal($InsVentaDirecta->VdiFecha);
			$InsVentaDirecta->VdiOrdenCompraFecha = FncCambiaFechaANormal($InsVentaDirecta->VdiOrdenCompraFecha);
			$Resultado.='#ERR_VDI_101';
		}		

		

	}else{
		$InsVentaDirecta->VdiFecha = FncCambiaFechaANormal($InsVentaDirecta->VdiFecha);
		$InsVentaDirecta->VdiOrdenCompraFecha = FncCambiaFechaANormal($InsVentaDirecta->VdiOrdenCompraFecha);
	}

	

}else{

	FncNuevo();
	
	switch($GET_Origen){

		case "CotizacionProducto":
			
			//$InsVentaDirecta->VdiIncluyeImpuesto = 1;			
			$InsCotizacionProducto = new ClsCotizacionProducto();
			$InsCotizacionProducto->CprId = $GET_CprId;
			$InsCotizacionProducto->MtdObtenerCotizacionProducto();

			$InsVentaDirecta->PerId = $InsCotizacionProducto->PerId;
	
			$InsVentaDirecta->CprId = $InsCotizacionProducto->CprId;
			
			$InsVentaDirecta->MonId = $InsCotizacionProducto->MonId;
			$InsVentaDirecta->VdiTipoCambio = $InsCotizacionProducto->CprTipoCambio;
			
			$InsVentaDirecta->CliId = $InsCotizacionProducto->CliId;
			$InsVentaDirecta->CliNombre = $InsCotizacionProducto->CliNombre;
			$InsVentaDirecta->CliApellidoPaterno = $InsCotizacionProducto->CliApellidoPaterno;
			$InsVentaDirecta->CliApellidoMaterno = $InsCotizacionProducto->CliApellidoMaterno;
			
			$InsVentaDirecta->CliNumeroDocumento = $InsCotizacionProducto->CliNumeroDocumento;
			$InsVentaDirecta->VdiDireccion = $InsCotizacionProducto->CprDireccion;
			
			$InsVentaDirecta->EinId = $InsCotizacionProducto->EinId;
			$InsVentaDirecta->EinVIN = $InsCotizacionProducto->EinVIN;
			//$InsVentaDirecta->VmaNombre = $InsCotizacionProducto->VmaNombre;
			//$InsVentaDirecta->VmoNombre = $InsCotizacionProducto->VmoNombre;
			$InsVentaDirecta->VmaId = $InsCotizacionProducto->VmaId;
			$InsVentaDirecta->VmoId = $InsCotizacionProducto->VmoId;
			
			$InsVentaDirecta->FinId = $InsCotizacionProducto->FinId;
			
			$InsVentaDirecta->VdiMarca = $InsCotizacionProducto->CprMarca;
			$InsVentaDirecta->VdiModelo = $InsCotizacionProducto->CprModelo;
			$InsVentaDirecta->VdiPlaca = $InsCotizacionProducto->CprPlaca;
			$InsVentaDirecta->VdiAnoModelo = $InsCotizacionProducto->CprAnoModelo;
			$InsVentaDirecta->VdiAnoFabricacion = $InsCotizacionProducto->CprAnoFabricacion;
			
			$InsVentaDirecta->VdiManoObra = $InsCotizacionProducto->CprManoObra;
			$InsVentaDirecta->VdiPorcentajeDescuento = $InsCotizacionProducto->CprPorcentajeDescuento;
			
			$InsVentaDirecta->VdiIncluyeImpuesto = $InsCotizacionProducto->CprIncluyeImpuesto;
			
			$InsVentaDirecta->TdoId = $InsCotizacionProducto->TdoId;
			$InsVentaDirecta->LtiId = $InsCotizacionProducto->LtiId;
			$InsVentaDirecta->VdiPorcentajeMargenUtilidad = $InsCotizacionProducto->CprMargenUtilidad;
			$InsVentaDirecta->VdiPorcentajeOtroCosto = $InsCotizacionProducto->CprFlete;
			
			$InsVentaDirecta->VdiOrigen = "CPR";
			$InsVentaDirecta->VdiObservacion = $InsCotizacionProducto->CprObservacion.chr(13).date("d/m/Y H:i:s")." - Ord. Venta Generada de Cot.:".$InsCotizacionProducto->CprId;

			$InsVentaDirecta->CliNombreSeguro = $InsCotizacionProducto->CliNombreSeguro;
			$InsVentaDirecta->CliApellidoPaternoSeguro = $InsCotizacionProducto->CliApellidoPaternoSeguro;
			$InsVentaDirecta->CliApellidoMaternoSeguro = $InsCotizacionProducto->CliApellidoMaternoSeguro;
			
			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				$InsVentaDirecta->VdiManoObra = round($InsVentaDirecta->VdiManoObra / $InsVentaDirecta->VdiTipoCambio,6);
			}

			if(!empty($InsCotizacionProducto->CotizacionProductoDetalle)){
				foreach($InsCotizacionProducto->CotizacionProductoDetalle as $DatCotizacionProductoDetalle){
				
					if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoDetalle->CrdEstado == 1)){
						
						$GuardarDetalle = true;
						
						$DatCotizacionProductoDetalle->VerificarStock = 2;
			
							$InsProducto->ProId = $DatCotizacionProductoDetalle->ProId;
							$InsProducto->MtdObtenerProducto(false);
	
							$InsUnidadMedida->UmeId = $DatCotizacionProductoDetalle->UmeId;
							$InsUnidadMedida->MtdObtenerUnidadMedida();
	
							if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
								$InsUnidadMedidaConversion->UmcEquivalente = 1;
							}else{
								$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
								$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
								  
								foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
									$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
								}
							}
							 
							if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
								
								$DatCotizacionProductoDetalle->CrdCantidadReal = round($DatVentaDirectaDetalle->CrdCantidadPendiente * $InsUnidadMedidaConversion->UmcEquivalente,6);
								
								if($InsProducto->ProStockReal  < $DatCotizacionProductoDetalle->CrdCantidadReal){	
									$DatCotizacionProductoDetalle->VerificarStock = 1;				
								}
								
							}else{
								$DatCotizacionProductoDetalle->VerificarStock = 0;			
							}
							
							//$DatCotizacionProductoDetalle->cRCantidadPedir = 0;
							//$DatCotizacionProductoDetalle->VddCantidadPedirFecha = NULL;
							
							
							if($DatCotizacionProductoDetalle->CrdCantidadPendiente<=0){
								$GuardarDetalle = false;	
							}
													
						if($GuardarDetalle){
	
		
							$DatCotizacionProductoDetalle->CrdCantidad = $DatCotizacionProductoDetalle->CrdCantidadPendiente;
							//$DatVentaDirectaDetalle->CrdImporte = $DatVentaDirectaDetalle->CrdPrecio * $DatVentaDirectaDetalle->CrdCantidad;
							
							///deb($InsVentaDirecta->MonId." - ".$EmpresaMonedaId);
							if($InsVentaDirecta->MonId <> $EmpresaMonedaId ){
								
							//	deb($DatVentaDirectaDetalle->CrdPrecio );
								
								$DatCotizacionProductoDetalle->CrdPrecioBruto = round($DatCotizacionProductoDetalle->CrdPrecioBruto / $InsVentaDirecta->VdiTipoCambio,6);
								$DatCotizacionProductoDetalle->CrdImporteBruto = round($DatCotizacionProductoDetalle->CrdImporteBruto / $InsVentaDirecta->VdiTipoCambio,6);
								
								$DatCotizacionProductoDetalle->CrdPrecio = round($DatCotizacionProductoDetalle->CrdPrecio / $InsVentaDirecta->VdiTipoCambio,6);
								
								$DatCotizacionProductoDetalle->CrdImporte = round($DatCotizacionProductoDetalle->CrdImporte / $InsVentaDirecta->VdiTipoCambio,6);
								$DatCotizacionProductoDetalle->CrdCosto = round($DatCotizacionProductoDetalle->CrdCosto / $InsVentaDirecta->VdiTipoCambio,6);
								
								$DatCotizacionProductoDetalle->CrdValorVenta = round($DatCotizacionProductoDetalle->CrdValorVenta / $InsVentaDirecta->VdiTipoCambio,6);
								
								$DatCotizacionProductoDetalle->CrdDescuento = round($DatCotizacionProductoDetalle->CrdDescuento / $InsVentaDirecta->VdiTipoCambio,6);
								$DatCotizacionProductoDetalle->CrdDescuentoUnitario = round($DatCotizacionProductoDetalle->CrdDescuentoUnitario / $InsVentaDirecta->VdiTipoCambio,6);
								
								$DatCotizacionProductoDetalle->CrdAdicional = round($DatCotizacionProductoDetalle->CrdAdicional / $InsVentaDirecta->VdiTipoCambio,6);
								$DatCotizacionProductoDetalle->CrdAdicionalUnitario = round($DatCotizacionProductoDetalle->CrdAdicionalUnitario / $InsVentaDirecta->VdiTipoCambio,6);
								
								//deb($DatVentaDirectaDetalle->CrdPrecio );
							}



/*
SesionObjeto-VentaDirectaDetalle
Parametro1 = VddId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = VddPrecioVenta
Parametro5 = VddCantidad
Parametro6 = VddImporte
Parametro7 = VddTiempoCreacion
Parametro8 = VddTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = VddCantidadReal
Parametro13 = ProCodigoOriginal
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = VerificarStock
Parametro17 = VddCosto
Parametro18 = ProStock
Parametro19 = ProStockReal
Parametro20 = VddCantidadPedir
Parametro21 = VddCantidadPedirFecha
Parametro22 = CrdId
Parametro23 = VddNuevo
Parametro24 = VddCantidadPorLlegar
Parametro25 = AmdCantidad
Parametro26 = VddEstado
Parametro27 = VdiId

Parametro28 = VddRemplazo
Parametro29 = ProIdPedido
Parametro30 = ProCodigoOriginalPedido

Parametro31 = PcdBOFecha
Parametro32 = PcdBOEstado
Parametro33 = VddFechaPorLlegar
Parametro34 = AmdEstado
Parametro35 = VddTipoPedido

Parametro36 = VddPrecioBruto

Parametro37 = VddValorTotal
Parametro38 = VddDescuento
Parametro39 = VddPorcentajeUtilidad
Parametro40 = VddPorcentajeOtroCosto
Parametro41 = VddPorcentajeManoObra
Parametro42 = VddPorcentajePedido

Parametro43 = VddPorcentajeAdicional
Parametro44 = VddPorcentajeDescuento
Parametro45 = VddAdicional
Parametro46 = VddDescuentoUnitario
Parametro47 = VddImporteBruto
Parametro48 = VddAdicionalUnitario

*/
							$_SESSION['InsVentaDirectaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatCotizacionProductoDetalle->ProId,
							$DatCotizacionProductoDetalle->ProNombre,
							$DatCotizacionProductoDetalle->CrdPrecio,
							$DatCotizacionProductoDetalle->CrdCantidad,
							$DatCotizacionProductoDetalle->CrdImporte,
							(date("d/m/Y H:i:s")),
							(date("d/m/Y H:i:s")),
							$DatCotizacionProductoDetalle->UmeNombre,
							$DatCotizacionProductoDetalle->UmeId,
							$DatCotizacionProductoDetalle->RtiId,
							$DatCotizacionProductoDetalle->CrdCantidadReal,
							$DatCotizacionProductoDetalle->ProCodigoOriginal,
							$DatCotizacionProductoDetalle->ProCodigoAlternativo,
							$DatCotizacionProductoDetalle->UmeIdOrigen,
							$DatCotizacionProductoDetalle->VerificarStock,
							$DatCotizacionProductoDetalle->CrdCosto,
							$InsProducto->ProStock,
							$InsProducto->ProStockReal,
							0,
							NULL,
							$DatCotizacionProductoDetalle->CrdId,
							NULL,
							NULL,
							NULL,
							1,

							NULL,

							NULL,
							NULL,
							NULL,

							NULL,
							NULL,
							NULL,
							NULL,
							$DatCotizacionProductoDetalle->CrdTipoPedido,

							$DatCotizacionProductoDetalle->CrdPrecioBruto,
							
							$DatCotizacionProductoDetalle->CrdValorVenta,
							$DatCotizacionProductoDetalle->CrdDescuento,
							$DatCotizacionProductoDetalle->CrdPorcentajeUtilidad,
							$DatCotizacionProductoDetalle->CrdPorcentajeOtroCosto,
							$DatCotizacionProductoDetalle->CrdPorcentajeManoObra,
							$DatCotizacionProductoDetalle->CrdPorcentajePedido,
							
							$DatCotizacionProductoDetalle->CrdPorcentajeAdicional,
							$DatCotizacionProductoDetalle->CrdPorcentajeDescuento,
							$DatCotizacionProductoDetalle->CrdAdicional,
							$DatCotizacionProductoDetalle->CrdDescuentoUnitario,
							$DatCotizacionProductoDetalle->CrdImporteBruto,
							$DatCotizacionProductoDetalle->CrdAdicionalUnitario
							);
							
						}
						
					}

				}
			}/*else{
				$Resultado.='#ERR_VDI_701';
			}*/
			
			if(!empty($InsCotizacionProducto->CotizacionProductoPlanchado)){
				foreach($InsCotizacionProducto->CotizacionProductoPlanchado as $DatCotizacionProductoPlanchado){
				
					if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoPlanchado->CppEstado == 1)){
	
	
						if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
							$DatCotizacionProductoPlanchado->CppImporte = round($DatCotizacionProductoPlanchado->CppImporte / $InsVentaDirecta->VdiTipoCambio,6);
						}
							
						$_SESSION['InsVentaDirectaPlanchado'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						NULL,
						$DatCotizacionProductoPlanchado->CppDescripcion,
						NULL,
						$DatCotizacionProductoPlanchado->CppImporte,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s")
						);
						
					}

				}
			}
			
			if(!empty($InsCotizacionProducto->CotizacionProductoPintado)){
				foreach($InsCotizacionProducto->CotizacionProductoPintado as $DatCotizacionProductoPintado){

					if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoPintado->CppEstado == 1)){
	
						if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
							$DatCotizacionProductoPintado->CppImporte = round($DatCotizacionProductoPintado->CppImporte / $InsVentaDirecta->VdiTipoCambio,6);
						}
						
						$_SESSION['InsVentaDirectaPintado'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						NULL,
						$DatCotizacionProductoPintado->CppDescripcion,
						NULL,
						$DatCotizacionProductoPintado->CppImporte,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s")
						);
					
					}

				}
			}
			
			
			if(!empty($InsCotizacionProducto->CotizacionProductoCentrado)){
				foreach($InsCotizacionProducto->CotizacionProductoCentrado as $DatCotizacionProductoCentrado){

					if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoCentrado->CppEstado == 1)){
	
						if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
							$DatCotizacionProductoCentrado->CppImporte = round($DatCotizacionProductoCentrado->CppImporte / $InsVentaDirecta->VdiTipoCambio,6);
						}
						
						$_SESSION['InsVentaDirectaCentrado'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						NULL,
						$DatCotizacionProductoCentrado->CppDescripcion,
						NULL,
						$DatCotizacionProductoCentrado->CppImporte,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s")

					);
					
					}
				}
			}
			
			if(!empty($InsCotizacionProducto->CotizacionProductoTarea)){
				foreach($InsCotizacionProducto->CotizacionProductoTarea as $DatCotizacionProductoTarea){

					if( $InsCotizacionProducto->CprVerificar == 2 or ( $InsCotizacionProducto->CprVerificar == 1 and $DatCotizacionProductoTarea->CppEstado == 1)){
		
						if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
							$DatCotizacionProductoTarea->CppImporte = round($DatCotizacionProductoTarea->CppImporte / $InsVentaDirecta->VdiTipoCambio,6);
						}
						
						$_SESSION['InsVentaDirectaTarea'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						NULL,
						$DatCotizacionProductoTarea->CppDescripcion,
						NULL,
						$DatCotizacionProductoTarea->CppImporte,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s")
						);
					}
				}
			}

		break;
		
	}
	
}



function FncNuevo(){
	
	global $Identificador;
	global $InsVentaDirecta;
	global $EmpresaImpuestoVenta;
	global $EmpresaMonedaId;
	
	global $EmpresaRepuestoMargenUtilidad;
	global $EmpresaRepuestoFlete;
	global $EmpresaMantenimientoPorcentajeManoObra;
	
	
	unset($_SESSION['InsVentaDirectaDetalle'.$Identificador]);
	unset($_SESSION['InsVentaDirectaPlanchado'.$Identificador]);
	unset($_SESSION['InsVentaDirectaPintado'.$Identificador]);
	unset($_SESSION['InsVentaDirectaCentrado'.$Identificador]);
	unset($_SESSION['InsVentaDirectaTarea'.$Identificador]);
	unset($_SESSION['InsVentaDirectaFoto'.$Identificador]);
	
	unset($_SESSION['SesVdiArchivo'.$Identificador]);
		
	$_SESSION['InsVentaDirectaDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsVentaDirectaPlanchado'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsVentaDirectaPintado'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsVentaDirectaCentrado'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsVentaDirectaTarea'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsVentaDirectaFoto'.$Identificador] = new ClsSesionObjeto();

	//unset($InsVentaDirecta);
			
	$InsVentaDirecta = new ClsVentaDirecta();
			
	$InsVentaDirecta->VdiFecha = date("d/m/Y");
	$InsVentaDirecta->VdiIncluyeImpuesto = 1;
	$InsVentaDirecta->VdiEstado = 3;
	$InsVentaDirecta->VdiOrigen = "VDI";
	$InsVentaDirecta->TopId = "TOP-10000";
	$InsVentaDirecta->NpaId = "NPA-10000";
	$InsVentaDirecta->VdiPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
	$InsVentaDirecta->MonId = $EmpresaMonedaId;	
	$InsVentaDirecta->VdiNotificar = 2;
	$InsVentaDirecta->PerId = $_SESSION['SesionPersonal'];
	
	$InsVentaDirecta->VdiPorcentajeMargenUtilidad = $EmpresaRepuestoMargenUtilidad;
	$InsVentaDirecta->VdiPorcentajeOtroCosto = $EmpresaRepuestoFlete;
	$InsVentaDirecta->VdiMantenimiento = $EmpresaMantenimientoPorcentajeManoObra ;
	//$InsVentaDirecta->VdiMantenimiento = 0;
	$InsVentaDirecta->SucId = $_SESSION['SesionSucursal'];

}
?>