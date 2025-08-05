<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsCotizacionProducto->CprId = $_POST['CmpId'];
	$InsCotizacionProducto->SucId = $_SESSION['SesionSucursal'];
	
	$InsCotizacionProducto->CliId = $_POST['CmpClienteId'];
	$InsCotizacionProducto->LtiId = $_POST['CmpClienteTipo'];
	
	$InsCotizacionProducto->CliIdSeguro = $_POST['CmpSeguro'];

	$InsCotizacionProducto->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsCotizacionProducto->PerId = $_POST['CmpPersonal'];
	
	$InsCotizacionProducto->FinId = $_POST['CmpFichaIngresoId'];
	
		$InsCotizacionProducto->CprNivelInteres = $_POST['CmpNivelInteres'];
	
	$InsCotizacionProducto->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsCotizacionProducto->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	
	$InsCotizacionProducto->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsCotizacionProducto->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsCotizacionProducto->VveNombre = $_POST['CmpVehiculoIngresoVersion'];

	$InsCotizacionProducto->CprVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsCotizacionProducto->CprMarca = $_POST['CmpVehiculoIngresoMarca'];
	$InsCotizacionProducto->CprModelo = $_POST['CmpVehiculoIngresoModelo'];
	$InsCotizacionProducto->CprPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsCotizacionProducto->CprAnoFabricacion = $_POST['CmpVehiculoIngresoAnoFabricacion'];
	$InsCotizacionProducto->CprAnoModelo = $_POST['CmpVehiculoIngresoAnoModelo'];
	
	
	$InsCotizacionProducto->MonId = $_POST['CmpMonedaId'];
	$InsCotizacionProducto->MonIdAnterior = $_POST['CmpMonedaIdAnterior'];
	$InsCotizacionProducto->CprTipoCambio = $_POST['CmpTipoCambio'];

	$InsCotizacionProducto->CprPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsCotizacionProducto->CprPorcentajeMargenUtilidad = eregi_replace(",","",(empty($_POST['CmpClienteMargenUtilidad'])?0:$_POST['CmpClienteMargenUtilidad']));
	$InsCotizacionProducto->CprPorcentajeOtroCosto = eregi_replace(",","",(empty($_POST['CmpPorcentajeOtroCosto'])?0:$_POST['CmpPorcentajeOtroCosto']));
	$InsCotizacionProducto->CprPorcentajeManoObra = eregi_replace(",","",(empty($_POST['CmpPorcentajeManoObra'])?0:$_POST['CmpPorcentajeManoObra']));
		
	$InsCotizacionProducto->CprFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsCotizacionProducto->CprHora = ($_POST['CmpHora']);
	
	list($InsCotizacionProducto->CprAno,$InsCotizacionProducto->CprMes,$aux) = explode("-",$InsCotizacionProducto->CprFecha);

	$InsCotizacionProducto->CprObservacion = addslashes($_POST['CmpObservacion']);
	$InsCotizacionProducto->CprObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);

	$InsCotizacionProducto->CprTelefono = $_POST['CmpClienteCelular'];
	$InsCotizacionProducto->CprDireccion = $_POST['CmpClienteDireccion'];
	$InsCotizacionProducto->CprEmail = $_POST['CmpClienteEmail'];
	$InsCotizacionProducto->CprRepresentante = $_POST['CmpRepresentante'];
	$InsCotizacionProducto->CprAsegurado = $_POST['CmpAsegurado'];
	
	$InsCotizacionProducto->CprVentaPerdida = $_POST['CmpVentaPerdida'];
	$InsCotizacionProducto->CprVentaPerdida = 2;
	$InsCotizacionProducto->CprVentaPerdidaMotivo =addslashes($_POST['CmpVentaPerdidaMotivo']);

	//$InsCotizacionProducto->CprIncluyeImpuesto = 2;

	$InsCotizacionProducto->CprManoObra = eregi_replace(",","",(empty($_POST['CmpManoObra'])?0:$_POST['CmpManoObra']));
	$InsCotizacionProducto->CprPorcentajeDescuento = eregi_replace(",","",(empty($_POST['CmpPorcentajeDescuento'])?0:$_POST['CmpPorcentajeDescuento']));
	
	$InsCotizacionProducto->CprVigencia = eregi_replace(",","",(empty($_POST['CmpVigencia'])?0:$_POST['CmpVigencia']));
	$InsCotizacionProducto->CprTiempoEntrega = eregi_replace(",","",(empty($_POST['CmpTiempoEntrega'])?0:$_POST['CmpTiempoEntrega']));
	
	//$InsCotizacionProducto->CprVigencia = (empty($_POST['CmpVigencia'])?0:$_POST['CmpVigencia']);
	//$InsCotizacionProducto->CprTiempoEntrega = (empty($_POST['CmpTiempoEntrega'])?0:$_POST['CmpTiempoEntrega']);
	
	$InsCotizacionProducto->CprFirmaDigital = (empty($_POST['CmpFirmaDigital'])?2:$_POST['CmpFirmaDigital']);
	$InsCotizacionProducto->CprVerificar = (empty($_POST['CmpVerificar'])?2:$_POST['CmpVerificar']);
	$InsCotizacionProducto->CprNotificar = (empty($_POST['CmpNotificar'])?2:$_POST['CmpNotificar']);
	
	$InsCotizacionProducto->CprIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsCotizacionProducto->CprEstado = $_POST['CmpEstado'];
	$InsCotizacionProducto->CprTiempoCreacion = date("Y-m-d H:i:s");
	$InsCotizacionProducto->CprTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsCotizacionProducto->CprPlanchado = $_POST['CprPlanchado'];
	$InsCotizacionProducto->CprPintado = $_POST['CprPintado'];
	$InsCotizacionProducto->CprCentrado = $_POST['CprCentrado'];
	
	$InsCotizacionProducto->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsCotizacionProducto->CliNombre = $_POST['CmpClienteNombre'];
	$InsCotizacionProducto->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	
	$InsCotizacionProducto->FinId = $_POST['CmpFichaIngresoId'];
	
	$InsCotizacionProducto->CotizacionProductoDetalle = array();

	if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
		if(empty($InsCotizacionProducto->CprTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_CPR_600';
		}
	}
	
	
		if(empty($InsCotizacionProducto->CliId)){
		$Guardar = false;
		$Resultado.='#ERR_CPR_123';
	}
	
	if($InsCotizacionProducto->MonId<>$EmpresaMonedaId ){
		$InsCotizacionProducto->CprManoObra = round($InsCotizacionProducto->CprManoObra * $InsCotizacionProducto->CprTipoCambio,6);
	}		

	
	$InsCotizacionProducto->CprPlanchadoTotal = 0;
	$InsCotizacionProducto->CprPintadoTotal = 0;
	$InsCotizacionProducto->CprCentradoTotal = 0;
	$InsCotizacionProducto->CprTareaTotal = 0;
	$InsCotizacionProducto->CprProductoTotal = 0;
	
	$InsCotizacionProducto->CprTotalBruto = 0;
	$InsCotizacionProducto->CprDescuento= 0;
	$InsCotizacionProducto->CprSubTotal = 0;
	$InsCotizacionProducto->CprImpuesto = 0;
	$InsCotizacionProducto->CprTotal = 0;


//						SesionObjeto-CotizacionProductoDetalle
//						Parametro1 = CpdId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = CrdPrecio
//						Parametro5 = CrdCantidad
//						Parametro6 = CrdImporte
//						Parametro7 = CrdTiempoCreacion
//						Parametro8 = CrdTiempoModificacion

//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = AmdCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo

//						Parametro15 = AmdPrecioVenta
//						Parametro16 = CrdDescripcion
//						Parametro17 = CrdCodigo
//						Parametro18 = CrdValorVenta

//						Parametro19 = UmeIdOrigen
//						Parametro20 = CrdCosto
//						Parametro21 = CrdEstado
//						Parametro22 = CrdTipoPedido
//						Parametro23 = CrdDescuento
//						Parametro24 = CrdPrecioBruto

//						Parametro25 = CrdPorcentajeUtilidad
//						Parametro26 = CrdPorcentajeOtroCosto
//						Parametro27 = CrdPorcentajeManoObra
//						Parametro28 = CrdPorcentajePedido

//						Parametro29 = CrdPorcentajeAdicional
//						Parametro30 = CrdPorcentajeDescuento
//						Parametro31 = CrdAdicional
//						Parametro32 = CrdDescuentoUnitario
//						Parametro33 = CrdImporteBruto
//						Parametro34 = CrdAdicionalUnitario

$ResCotizacionProductoDetalle = $_SESSION['InsCotizacionProductoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCotizacionProductoDetalles = $ResCotizacionProductoDetalle['Datos'];

if(!empty($ArrCotizacionProductoDetalles)){
	foreach($ArrCotizacionProductoDetalles as $DatCotizacionProductoDetalle){

		if($InsCotizacionProducto->MonId <> $EmpresaMonedaId){
			
			$DatCotizacionProductoDetalle->Parametro24 = round($DatCotizacionProductoDetalle->Parametro24 * $InsCotizacionProducto->CprTipoCambio,6);
			
		  $DatCotizacionProductoDetalle->Parametro20 = round($DatCotizacionProductoDetalle->Parametro20 * $InsCotizacionProducto->CprTipoCambio,6);
		  $DatCotizacionProductoDetalle->Parametro18 = round($DatCotizacionProductoDetalle->Parametro18 * $InsCotizacionProducto->CprTipoCambio,6);
		  $DatCotizacionProductoDetalle->Parametro4 = round($DatCotizacionProductoDetalle->Parametro4 * $InsCotizacionProducto->CprTipoCambio,6);
		  $DatCotizacionProductoDetalle->Parametro6 = round($DatCotizacionProductoDetalle->Parametro6 * $InsCotizacionProducto->CprTipoCambio,6);
		  
			$DatCotizacionProductoDetalle->Parametro29 = round($DatCotizacionProductoDetalle->Parametro29 * $InsCotizacionProducto->CprTipoCambio,6);
			$DatCotizacionProductoDetalle->Parametro30 = round($DatCotizacionProductoDetalle->Parametro30 * $InsCotizacionProducto->CprTipoCambio,6);
			$DatCotizacionProductoDetalle->Parametro31 = round($DatCotizacionProductoDetalle->Parametro31 * $InsCotizacionProducto->CprTipoCambio,6);
			$DatCotizacionProductoDetalle->Parametro32 = round($DatCotizacionProductoDetalle->Parametro32 * $InsCotizacionProducto->CprTipoCambio,6);
			$DatCotizacionProductoDetalle->Parametro33 = round($DatCotizacionProductoDetalle->Parametro33 * $InsCotizacionProducto->CprTipoCambio,6);
		  
		}			
			
		$InsCotizacionProductoDetalle1 = new ClsCotizacionProductoDetalle();
		
		$InsCotizacionProductoDetalle1->CrdId = NULL;
		$InsCotizacionProductoDetalle1->CprId = NULL;
		$InsCotizacionProductoDetalle1->ProId = $DatCotizacionProductoDetalle->Parametro2;
		$InsCotizacionProductoDetalle1->UmeId = $DatCotizacionProductoDetalle->Parametro10;
		
		$InsCotizacionProductoDetalle1->CrdCosto = $DatCotizacionProductoDetalle->Parametro20;
		$InsCotizacionProductoDetalle1->CrdValorVenta = $DatCotizacionProductoDetalle->Parametro18;
		
		$InsCotizacionProductoDetalle1->CrdPorcentajeUtilidad = $DatCotizacionProductoDetalle->Parametro25;
		$InsCotizacionProductoDetalle1->CrdPorcentajeOtroCosto =  $DatCotizacionProductoDetalle->Parametro26;
		$InsCotizacionProductoDetalle1->CrdPorcentajeManoObra = $DatCotizacionProductoDetalle->Parametro27;
		$InsCotizacionProductoDetalle1->CrdPorcentajePedido = $DatCotizacionProductoDetalle->Parametro28;
		
		$InsCotizacionProductoDetalle1->CrdPorcentajeAdicional = $DatCotizacionProductoDetalle->Parametro29;
		$InsCotizacionProductoDetalle1->CrdPorcentajeDescuento = $DatCotizacionProductoDetalle->Parametro30;

		$InsCotizacionProductoDetalle1->CrdPrecioBruto =  $DatCotizacionProductoDetalle->Parametro24;
		$InsCotizacionProductoDetalle1->CrdImporteBruto =  $DatCotizacionProductoDetalle->Parametro33;
		
		
		$InsCotizacionProductoDetalle1->CrdPrecio =  $DatCotizacionProductoDetalle->Parametro4;
		$InsCotizacionProductoDetalle1->CrdImporte = $DatCotizacionProductoDetalle->Parametro6;
		
		$InsCotizacionProductoDetalle1->CrdAdicional = $DatCotizacionProductoDetalle->Parametro31;//*
		$InsCotizacionProductoDetalle1->CrdDescuento = $DatCotizacionProductoDetalle->Parametro23;//*
		$InsCotizacionProductoDetalle1->CrdDescuentoUnitario = $DatCotizacionProductoDetalle->Parametro32;
		
		$InsCotizacionProductoDetalle1->CrdCantidad = $DatCotizacionProductoDetalle->Parametro5;
		$InsCotizacionProductoDetalle1->CrdCantidadReal = $DatCotizacionProductoDetalle->Parametro5;
	
		$InsCotizacionProductoDetalle1->CrdTipoPedido = $DatCotizacionProductoDetalle->Parametro22;

		$InsCotizacionProductoDetalle1->CrdObservacion = $DatCotizacionProductoDetalle->Parametro35;
		$InsCotizacionProductoDetalle1->CrdEstado = (empty($_POST['CmpCotizacionProductoDetalleEstado_'.$DatCotizacionProductoDetalle->Item])?2:$_POST['CmpCotizacionProductoDetalleEstado_'.$DatCotizacionProductoDetalle->Item]);
		$InsCotizacionProductoDetalle1->CrdEliminado = $DatCotizacionProductoDetalle->Eliminado;
		$InsCotizacionProductoDetalle1->CrdTiempoCreacion = FncCambiaFechaAMysql($DatCotizacionProductoDetalle->Parametro7);
		$InsCotizacionProductoDetalle1->CrdTiempoModificacion = date("Y-m-d H:i:s");

		//if( ($InsCotizacionProducto->CprVerificar == 2  ) or ( $InsCotizacionProducto->CprVerificar == 1 and  $DatCotizacionProductoDetalle->CrdEstado == 1) and $DatCotizacionProductoDetalle->CrdEliminado==1 ){
	
		
			$InsCotizacionProducto->CotizacionProductoDetalle[] = $InsCotizacionProductoDetalle1;
			
			if( $InsCotizacionProductoDetalle1->CrdEliminado==1 ){
				if( $InsCotizacionProductoDetalle1->CrdEstado == 3 ){
		
					$InsCotizacionProducto->CprProductoTotal += $InsCotizacionProductoDetalle1->CrdImporte;	
					$InsCotizacionProducto->CprDescuento += $InsCotizacionProductoDetalle1->CrdDescuento;	
					
				}
			}
			
			
			
		//}
	}
	
	if(!empty($InsCotizacionProducto->CprPorcentajeDescuento)){
		
		//$InsCotizacionProducto->CprDescuento = $InsCotizacionProducto->CprProductoTotal * ($InsCotizacionProducto->CprPorcentajeDescuento/100);
		//$InsCotizacionProducto->CprProductoTotal = $InsCotizacionProducto->CprProductoTotal - $InsCotizacionProducto->CprDescuento;
		
	}
		
		
}


//						SesionObjeto-CotizacionProductoPlanchado
//						Parametro1 = CppId
//						Parametro2 = CppDescripcion
//						Parametro3 = CppPrecio
//						Parametro4 = CppCantidad
//						Parametro5 = CppImporte
//						Parametro6 = CppEstado
//						Parametro7 = CppTipo
//						Parametro8 = CppTiempoCreacion
//						Parametro9 = CppTiempoModificacion

$ResCotizacionProductoPlanchado = $_SESSION['InsCotizacionProductoPlanchado'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCotizacionProductoPlanchados = $ResCotizacionProductoPlanchado['Datos'];

	if(!empty($ArrCotizacionProductoPlanchados)){
		foreach($ArrCotizacionProductoPlanchados as $DatCotizacionProductoPlanchado){
		
			if($InsCotizacionProducto->MonId <> $EmpresaMonedaId){
				$DatCotizacionProductoPlanchado->Parametro3 = round($DatCotizacionProductoPlanchado->Parametro3 * $InsCotizacionProducto->CprTipoCambio,6);
				$DatCotizacionProductoPlanchado->Parametro5 = round($DatCotizacionProductoPlanchado->Parametro5 * $InsCotizacionProducto->CprTipoCambio,6);
			}
					
			$InsCotizacionProductoPlanchado1 = new ClsCotizacionProductoPlanchadoPintado();
			$InsCotizacionProductoPlanchado1->CppId = NULL;
			$InsCotizacionProductoPlanchado1->CprId = NULL;
			$InsCotizacionProductoPlanchado1->CppDescripcion = $DatCotizacionProductoPlanchado->Parametro2;			
			$InsCotizacionProductoPlanchado1->CppPrecio = $DatCotizacionProductoPlanchado->Parametro3;
			$InsCotizacionProductoPlanchado1->CppCantidad = $DatCotizacionProductoPlanchado->Parametro4;
			$InsCotizacionProductoPlanchado1->CppImporte = $DatCotizacionProductoPlanchado->Parametro5;
			$InsCotizacionProductoPlanchado1->CppTipo = $DatCotizacionProductoPlanchado->Parametro7;
			$InsCotizacionProductoPlanchado1->CppEstado = $DatCotizacionProductoPlanchado->Parametro6;
			$InsCotizacionProductoPlanchado1->CppEliminado = $DatCotizacionProductoPlanchado->Eliminado;
			$InsCotizacionProductoPlanchado1->CppTiempoCreacion = FncCambiaFechaAMysql($DatCotizacionProductoPlanchado->Parametro8);
			$InsCotizacionProductoPlanchado1->CppTiempoModificacion = date("Y-m-d H:i:s");

			if( ($InsCotizacionProducto->CprVerificar == 2  ) or ( $InsCotizacionProducto->CprVerificar == 1 and  $InsCotizacionProductoPlanchado1->CppEstado == 1) and $InsCotizacionProductoPlanchado1->CppEliminado == 1 ){

				$InsCotizacionProducto->CotizacionProductoPlanchado[] = $InsCotizacionProductoPlanchado1;
				$InsCotizacionProducto->CprPlanchadoTotal += $InsCotizacionProductoPlanchado1->CppImporte;

			}
						
		}		
	}

//						SesionObjeto-CotizacionProductoPlanchado
//						Parametro1 = CppId
//						Parametro2 = CppDescripcion
//						Parametro3 = CppPrecio
//						Parametro4 = CppCantidad
//						Parametro5 = CppImporte
//						Parametro6 = CppEstado
//						Parametro7 = CppTipo
//						Parametro8 = CppTiempoCreacion
//						Parametro9 = CppTiempoModificacion

$ResCotizacionProductoPintado = $_SESSION['InsCotizacionProductoPintado'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCotizacionProductoPintados = $ResCotizacionProductoPintado['Datos'];

	if(!empty($ArrCotizacionProductoPintados)){
		foreach($ArrCotizacionProductoPintados as $DatCotizacionProductoPintado){

			if($InsCotizacionProducto->MonId <> $EmpresaMonedaId){
				$DatCotizacionProductoPintado->Parametro3 = round($DatCotizacionProductoPintado->Parametro3 * $InsCotizacionProducto->CprTipoCambio,6);
				$DatCotizacionProductoPintado->Parametro5 = round($DatCotizacionProductoPintado->Parametro5 * $InsCotizacionProducto->CprTipoCambio,6);
			}
					
			$InsCotizacionProductoPintado1 = new ClsCotizacionProductoPlanchadoPintado();
			$InsCotizacionProductoPintado1->CppId = NULL;
			$InsCotizacionProductoPintado1->CprId = NULL;
			$InsCotizacionProductoPintado1->CppDescripcion = $DatCotizacionProductoPintado->Parametro2;			
			$InsCotizacionProductoPintado1->CppPrecio = $DatCotizacionProductoPintado->Parametro3;
			$InsCotizacionProductoPintado1->CppCantidad = $DatCotizacionProductoPintado->Parametro4;
			$InsCotizacionProductoPintado1->CppImporte = $DatCotizacionProductoPintado->Parametro5;
			$InsCotizacionProductoPintado1->CppTipo = $DatCotizacionProductoPintado->Parametro7;
			$InsCotizacionProductoPintado1->CppEstado = $DatCotizacionProductoPintado->Parametro6;
			$InsCotizacionProductoPintado1->CppEliminado = $DatCotizacionProductoPintado->Eliminado;
			$InsCotizacionProductoPintado1->CppTiempoCreacion = FncCambiaFechaAMysql($DatCotizacionProductoPintado->Parametro8);
			$InsCotizacionProductoPintado1->CppTiempoModificacion = date("Y-m-d H:i:s");
			
			if( ($InsCotizacionProducto->CprVerificar == 2  ) or ( $InsCotizacionProducto->CprVerificar == 1 and  $InsCotizacionProductoPintado1->CppEstado == 1) and $InsCotizacionProductoPintado1->CppEliminado == 1  ){
				
				$InsCotizacionProducto->CotizacionProductoPintado[] = $InsCotizacionProductoPintado1;
				$InsCotizacionProducto->CprPintadoTotal += $InsCotizacionProductoPintado1->CppImporte;
			
			}
		}		
	}
	
	
//						SesionObjeto-CotizacionProductoPlanchado
//						Parametro1 = CppId
//						Parametro2 = CppDescripcion
//						Parametro3 = CppPrecio
//						Parametro4 = CppCantidad
//						Parametro5 = CppImporte
//						Parametro6 = CppEstado
//						Parametro7 = CppTipo
//						Parametro8 = CppTiempoCreacion
//						Parametro9 = CppTiempoModificacion

$ResCotizacionProductoCentrado = $_SESSION['InsCotizacionProductoCentrado'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCotizacionProductoCentrados = $ResCotizacionProductoCentrado['Datos'];

	if(!empty($ArrCotizacionProductoCentrados)){
		foreach($ArrCotizacionProductoCentrados as $DatCotizacionProductoCentrado){
			
			if($InsCotizacionProducto->MonId <> $EmpresaMonedaId){
				
				$DatCotizacionProductoCentrado->Parametro3 = round($DatCotizacionProductoCentrado->Parametro3 * $InsCotizacionProducto->CprTipoCambio,6);
				$DatCotizacionProductoCentrado->Parametro5 = round($DatCotizacionProductoCentrado->Parametro5 * $InsCotizacionProducto->CprTipoCambio,6);
				
			}
					
			$InsCotizacionProductoCentrado1 = new ClsCotizacionProductoPlanchadoPintado();
			$InsCotizacionProductoCentrado1->CppId = NULL;
			$InsCotizacionProductoCentrado1->CprId = NULL;
			$InsCotizacionProductoCentrado1->CppDescripcion = $DatCotizacionProductoCentrado->Parametro2;			
			$InsCotizacionProductoCentrado1->CppPrecio = $DatCotizacionProductoCentrado->Parametro3;
			$InsCotizacionProductoCentrado1->CppCantidad = $DatCotizacionProductoCentrado->Parametro4;
			$InsCotizacionProductoCentrado1->CppImporte = $DatCotizacionProductoCentrado->Parametro5;
			$InsCotizacionProductoCentrado1->CppTipo = $DatCotizacionProductoCentrado->Parametro7;
			$InsCotizacionProductoCentrado1->CppEstado = $DatCotizacionProductoCentrado->Parametro6;
			$InsCotizacionProductoCentrado1->CppEliminado = $DatCotizacionProductoCentrado->Eliminado;
			$InsCotizacionProductoCentrado1->CppTiempoCreacion = FncCambiaFechaAMysql($DatCotizacionProductoCentrado->Parametro8);
			$InsCotizacionProductoCentrado1->CppTiempoModificacion = date("Y-m-d H:i:s");

			if( ($InsCotizacionProducto->CprVerificar == 2  ) or ( $InsCotizacionProducto->CprVerificar == 1 and  $InsCotizacionProductoCentrado1->CppEstado == 1) and $InsCotizacionProductoCentrado1->CppEliminado == 1 ){
				
				$InsCotizacionProducto->CotizacionProductoCentrado[] = $InsCotizacionProductoCentrado1;
				$InsCotizacionProducto->CprCentradoTotal += $InsCotizacionProductoCentrado1->CppImporte;
			}
						
		}		
	}
	

//						SesionObjeto-CotizacionProductoTarea
//						Parametro1 = CppId
//						Parametro2 = CppDescripcion
//						Parametro3 = CppPrecio
//						Parametro4 = CppCantidad
//						Parametro5 = CppImporte
//						Parametro6 = CppEstado
//						Parametro7 = CppTipo
//						Parametro8 = CppTiempoCreacion
//						Parametro9 = CppTiempoModificacion

$ResCotizacionProductoTarea = $_SESSION['InsCotizacionProductoTarea'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCotizacionProductoTareas = $ResCotizacionProductoTarea['Datos'];

	if(!empty($ArrCotizacionProductoTareas)){
		foreach($ArrCotizacionProductoTareas as $DatCotizacionProductoTarea){
			

			if($InsCotizacionProducto->MonId <> $EmpresaMonedaId){
				
				$DatCotizacionProductoTarea->Parametro3 = round($DatCotizacionProductoTarea->Parametro3 * $InsCotizacionProducto->CprTipoCambio,6);
				$DatCotizacionProductoTarea->Parametro5 = round($DatCotizacionProductoTarea->Parametro5 * $InsCotizacionProducto->CprTipoCambio,6);

			}
			
			$InsCotizacionProductoTarea1 = new ClsCotizacionProductoPlanchadoPintado();
			$InsCotizacionProductoTarea1->CppId = NULL;
			$InsCotizacionProductoTarea1->CprId = NULL;
			$InsCotizacionProductoTarea1->CppDescripcion = $DatCotizacionProductoTarea->Parametro2;			
			$InsCotizacionProductoTarea1->CppPrecio = $DatCotizacionProductoTarea->Parametro3;
			$InsCotizacionProductoTarea1->CppCantidad = $DatCotizacionProductoTarea->Parametro4;
			$InsCotizacionProductoTarea1->CppImporte = $DatCotizacionProductoTarea->Parametro5;
			$InsCotizacionProductoTarea1->CppTipo = $DatCotizacionProductoTarea->Parametro7;
			$InsCotizacionProductoTarea1->CppEstado = $DatCotizacionProductoTarea->Parametro6;
			$InsCotizacionProductoTarea1->CppEliminado = $DatCotizacionProductoTarea->Eliminado;
			$InsCotizacionProductoTarea1->CppTiempoCreacion = FncCambiaFechaAMysql($DatCotizacionProductoTarea->Parametro8);
			$InsCotizacionProductoTarea1->CppTiempoModificacion = date("Y-m-d H:i:s");
		

			if( ($InsCotizacionProducto->CprVerificar == 2  ) or ( $InsCotizacionProducto->CprVerificar == 1 and  $InsCotizacionProductoTarea1->CppEstado == 1) and $InsCotizacionProductoTarea1->CppEliminado == 1 ){

				$InsCotizacionProducto->CotizacionProductoTarea[] = $InsCotizacionProductoTarea1;
				$InsCotizacionProducto->CprTareaTotal += $InsCotizacionProductoTarea1->CppImporte;

			}
						
		}		
	}
	
			/*	$_SESSION['InsCotizacionProductoFoto'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatCotizacionProductoFoto->CpfId,
			NULL,
			$DatCotizacionProductoFoto->CpfArchivo,			
			$DatCotizacionProductoFoto->CpfEstado,
			($DatCotizacionProductoFoto->CpfTiempoCreacion),
			($DatCotizacionProductoFoto->CpfTiempoModificacion),
			$DatCotizacionProductoFoto->CpfTipo*/

	$ResCotizacionProductoFoto = $_SESSION['InsCotizacionProductoFoto'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrCotizacionProductoFotos = $ResCotizacionProductoFoto['Datos'];

	if(!empty($ArrCotizacionProductoFotos)){
		foreach($ArrCotizacionProductoFotos as $DatCotizacionProductoFoto){
			
			$InsCotizacionProductoFoto1 = new ClsCotizacionProductoFoto();
			$InsCotizacionProductoFoto1->CpfId = $DatCotizacionProductoFoto->Parametro1;	
			$InsCotizacionProductoFoto1->CprId = NULL;
			$InsCotizacionProductoFoto1->CpfArchivo = $DatCotizacionProductoFoto->Parametro3;	
			$InsCotizacionProductoFoto1->CpfTipo = $DatCotizacionProductoFoto->Parametro7;
			$InsCotizacionProductoFoto1->CpfEstado = $DatCotizacionProductoFoto->Parametro4;
			$InsCotizacionProductoFoto1->CpfEliminado = $DatCotizacionProductoFoto->Eliminado;
			$InsCotizacionProductoFoto1->CpfTiempoCreacion = FncCambiaFechaAMysql($DatCotizacionProductoFoto->Parametro5);
			$InsCotizacionProductoFoto1->CpfTiempoModificacion = date("Y-m-d H:i:s");
		
			if(  $InsCotizacionProductoFoto1->CpfEliminado == 1 ){
				$InsCotizacionProducto->CotizacionProductoFoto[] = $InsCotizacionProductoFoto1;
			}
						
		}		
	}
	
	if($InsCotizacionProducto->CprIncluyeImpuesto == 1){
		
		$InsCotizacionProducto->CprTotal = $InsCotizacionProducto->CprProductoTotal + $InsCotizacionProducto->CprManoObra + $InsCotizacionProducto->CprPintadoTotal + $InsCotizacionProducto->CprPlanchadoTotal  + $InsCotizacionProducto->CprCentradoTotal + $InsCotizacionProducto->CprTareaTotal;	
		
		$InsCotizacionProducto->CprSubTotal = $InsCotizacionProducto->CprTotal / (($InsCotizacionProducto->CprPorcentajeImpuestoVenta/100)+1);
		$InsCotizacionProducto->CprImpuesto = $InsCotizacionProducto->CprTotal - $InsCotizacionProducto->CprSubTotal;
			
	}else{
		
		$InsCotizacionProducto->CprSubTotal = $InsCotizacionProducto->CprProductoTotal + $InsCotizacionProducto->CprManoObra + $InsCotizacionProducto->CprPintadoTotal + $InsCotizacionProducto->CprPlanchadoTotal  + $InsCotizacionProducto->CprCentradoTotal + $InsCotizacionProducto->CprTareaTotal;	
		
		$InsCotizacionProducto->CprImpuesto = $InsCotizacionProducto->CprSubTotal * ($InsCotizacionProducto->CprPorcentajeImpuestoVenta/100);
		
		$InsCotizacionProducto->CprTotal = $InsCotizacionProducto->CprSubTotal + $InsCotizacionProducto->CprImpuesto;
		
	}
	

	if($Guardar){
		
		if($InsCotizacionProducto->MtdRegistrarCotizacionProducto()){
			
			$InsCotizacionProducto->MtdCotizacionProductoActualizarProductoUso($InsCotizacionProducto->CprId);
			
			if($InsCotizacionProducto->CprNotificar==1){
				$InsCotizacionProducto->MtdNotificarCotizacionProductoRegistro($InsCotizacionProducto->CprId,"jblanco@cyc.com.pe",true);
			}
			
			if($InsCotizacionProducto->MonId<>$EmpresaMonedaId ){
				$InsCotizacionProducto->CprManoObra = round($InsCotizacionProducto->CprManoObra / $InsCotizacionProducto->CprTipoCambio,6);
			}

			$InsCotizacionProducto->CprFecha = FncCambiaFechaANormal($InsCotizacionProducto->CprFecha);			
			
			FncNuevo();
				
			$Registro = true;
			$Resultado.='#SAS_CPR_101';
		}else{
			
			if($InsCotizacionProducto->MonId<>$EmpresaMonedaId ){
				$InsCotizacionProducto->CprManoObra = round($InsCotizacionProducto->CprManoObra / $InsCotizacionProducto->CprTipoCambio,6);
			}

			$InsCotizacionProducto->CprFecha = FncCambiaFechaANormal($InsCotizacionProducto->CprFecha);				
			
			$Resultado.='#ERR_CPR_101';
		}
		
	}else{
		
		if($InsCotizacionProducto->MonId<>$EmpresaMonedaId ){
				$InsCotizacionProducto->CprManoObra = round($InsCotizacionProducto->CprManoObra / $InsCotizacionProducto->CprTipoCambio,6);
		}

		$InsCotizacionProducto->CprFecha = FncCambiaFechaANormal($InsCotizacionProducto->CprFecha);	

	}
	
	//if(empty($InsCotizacionProducto->MonIdAnterior)){
//		$InsCotizacionProducto->MonIdAnterior = $InsCotizacionProducto->MonId;
//	}

	

}else{
	
	FncNuevo();

	switch($GET_Origen){

		case "TallerPedido":

			$InsFichaIngreso = new ClsFichaIngreso();
			$InsFichaIngreso->FinId = $GET_FinId;
			$InsFichaIngreso->MtdObtenerFichaIngreso();
			
			$InsCotizacionProducto->CprFecha = date("d/m/Y");
			
			$InsCotizacionProducto->LtiId = $InsFichaIngreso->LtiId;
			$InsCotizacionProducto->CliId = $InsFichaIngreso->CliId;
			$InsCotizacionProducto->CliNombre = $InsFichaIngreso->CliNombre;
			$InsCotizacionProducto->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
			$InsCotizacionProducto->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
			$InsCotizacionProducto->TdoId = $InsFichaIngreso->TdoId;
			$InsCotizacionProducto->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
			$InsCotizacionProducto->CprDireccion = $InsFichaIngreso->FinDireccion;
			$InsCotizacionProducto->CprTelefono = $InsFichaIngreso->FinTelefono;
			$InsCotizacionProducto->CprEmail = $InsFichaIngreso->CliEmail;
			
			$InsCotizacionProducto->EinId = $InsFichaIngreso->EinId;
			$InsCotizacionProducto->CprVIN = $InsFichaIngreso->EinVIN;
			
			$InsCotizacionProducto->VmaId = $InsFichaIngreso->VmaId;
			$InsCotizacionProducto->VmoId = $InsFichaIngreso->VmoId;
			
			$InsCotizacionProducto->CprMarca = $InsFichaIngreso->VmaNombre;
			$InsCotizacionProducto->CprModelo = $InsFichaIngreso->VmoNombre;
			$InsCotizacionProducto->CprPlaca = $InsFichaIngreso->EinPlaca;
			$InsCotizacionProducto->CprAnoFabricacion = $InsFichaIngreso->EinAnoFabricacion;
			
			$InsCotizacionProducto->CprObservacion = date("d/m/Y H:i:s")." - Cotizacion autogenerada de O.T.: ".$InsFichaIngreso->FinId;
			$InsCotizacionProducto->FinId = $InsFichaIngreso->FinId;	

			//if($InsCotizacionProducto->MtdRegistrarCotizacionProducto()){
//				$InsCotizacionProducto->CprFecha = date("d/m/Y");
//			}
				
			foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
				
				/*if(!empty($DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle)){
					foreach($DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
					

			
//						SesionObjeto-CotizacionProductoDetalle
//						Parametro1 = CpdId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = CrdPrecio
//						Parametro5 = CrdCantidad
//						Parametro6 = CrdImporte
//						Parametro7 = CrdTiempoCreacion
//						Parametro8 = CrdTiempoModificacion
//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = AmdCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo
//						Parametro15 = AmdPrecioVenta
//						Parametro16 = 
//						Parametro17 = 
//						Parametro18 = CrdValorVenta
//						Parametro19 = UmeIdOrigen
//						Parametro20 = CrdCosto
//						Parametro21 = CrdEstado

							$_SESSION['InsCotizacionProductoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatTallerPedidoDetalle->ProId,
							$DatTallerPedidoDetalle->ProNombre,
							$DatTallerPedidoDetalle->AmdCosto,
							$DatTallerPedidoDetalle->AmdCantidad,
							$DatTallerPedidoDetalle->AmdImporte,
							(date("d/m/Y H:i:s")),
							(date("d/m/Y H:i:s")),
							$DatTallerPedidoDetalle->UmeNombre,
							$DatTallerPedidoDetalle->UmeId,
							$DatTallerPedidoDetalle->RtiId,
							$DatTallerPedidoDetalle->AmdCantidadReal,
							$DatTallerPedidoDetalle->ProCodigoOriginal,
							$DatTallerPedidoDetalle->ProCodigoAlternativo,
							$DatTallerPedidoDetalle->AmdPrecioVenta,
							NULL,
							NULL,
							$DatTallerPedidoDetalle->AmdValorVenta,
							$DatTallerPedidoDetalle->UmeIdOrigen,
							$DatTallerPedidoDetalle->AmdCosto,
							1);

					}
				}*/
				
				
				if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea)){
					foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
					
					//deb($DatFichaAccionTarea);
					
					if($DatFichaAccionTarea->FatAccion == "L" ){

//						SesionObjeto-CotizacionProductoPlanchado
//						Parametro1 = CppId
//						Parametro2 = CppDescripcion
//						Parametro3 = CppPrecio
//						Parametro4 = CppCantidad
//						Parametro5 = CppImporte
//						Parametro6 = CppEstado
//						Parametro7 = CppTipo
//						Parametro8 = CppTiempoCreacion
//						Parametro9 = CppTiempoModificacion

							$_SESSION['InsCotizacionProductoPlanchado'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatFichaAccionTarea->FatDescripcion,
							0,
							0,
							0,
							1,
							"L",
							(date("d/m/Y H:i:s")),
							(date("d/m/Y H:i:s"))
							);

						}
						
						if($DatFichaAccionTarea->FatAccion == "N" ){
						
							$_SESSION['InsCotizacionProductoPintado'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatFichaAccionTarea->FatDescripcion,
							0,
							0,
							0,
							1,
							"I",
							(date("d/m/Y H:i:s")),
							(date("d/m/Y H:i:s"))
							);
							
						}
						
						
						if($DatFichaAccionTarea->FatAccion == "E" ){
						
							$_SESSION['InsCotizacionProductoCentrado'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatFichaAccionTarea->FatDescripcion,
							0,
							0,
							0,
							1,
							"C",
							(date("d/m/Y H:i:s")),
							(date("d/m/Y H:i:s"))
							);
							
						}
						
						if($DatFichaAccionTarea->FatAccion == "Z" ){

							$_SESSION['InsCotizacionProductoCentrado'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatFichaAccionTarea->FatDescripcion,
							0,
							0,
							0,
							1,
							"Z",
							(date("d/m/Y H:i:s")),
							(date("d/m/Y H:i:s"))
							);
							
						}
						

					}
				}
				
				
				
			}


		break;
		
		
		
		case "CotizacionProducto":

			$InsCotizacionProducto1 = new ClsCotizacionProducto();
			$InsCotizacionProducto1->CprId = $GET_CprId;
			$InsCotizacionProducto1->MtdObtenerCotizacionProducto();
			
				$InsCotizacionProducto->CprFecha = date("d/m/Y");
				
				$InsCotizacionProducto->LtiId = $InsCotizacionProducto1->LtiId;
				
				$InsCotizacionProducto->MonId = $InsCotizacionProducto1->MonId;
				$InsCotizacionProducto->CprTipoCambio = $InsCotizacionProducto1->CprTipoCambio;
				
				$InsCotizacionProducto->CliId = $InsCotizacionProducto1->CliId;
				$InsCotizacionProducto->CliNombre = $InsCotizacionProducto1->CliNombre;
				$InsCotizacionProducto->CliApellidoPaterno = $InsCotizacionProducto1->CliApellidoPaterno;
				$InsCotizacionProducto->CliApellidoMaterno = $InsCotizacionProducto1->CliApellidoMaterno;
				$InsCotizacionProducto->TdoId = $InsCotizacionProducto1->TdoId;
				$InsCotizacionProducto->CliNumeroDocumento = $InsCotizacionProducto1->CliNumeroDocumento;
				$InsCotizacionProducto->CprDireccion = $InsCotizacionProducto1->FinDireccion;
				$InsCotizacionProducto->CprTelefono = $InsCotizacionProducto1->FinTelefono;
				$InsCotizacionProducto->CprEmail = $InsCotizacionProducto1->CliEmail;
				
				$InsCotizacionProducto->EinId = $InsCotizacionProducto1->EinId;
				$InsCotizacionProducto->EinVIN = $InsCotizacionProducto1->EinVIN;
				
				$InsCotizacionProducto->VmaId = $InsCotizacionProducto1->VmaId;
				$InsCotizacionProducto->VmoId = $InsCotizacionProducto1->VmoId;
				
				$InsCotizacionProducto->CprMarca = $InsCotizacionProducto1->VmaNombre;
				$InsCotizacionProducto->CprModelo = $InsCotizacionProducto1->VmoNombre;
				$InsCotizacionProducto->CprPlaca = $InsCotizacionProducto1->EinPlaca;
				$InsCotizacionProducto->CprAnoFabricacion = $InsCotizacionProducto1->EinAnoFabricacion;
				
				$InsCotizacionProducto->CprObservacion = date("d/m/Y H:i:s")." - Cotizacion generado de Cot.: ".$InsCotizacionProducto1->CprId;
				$InsCotizacionProducto->FinId = $InsCotizacionProducto1->FinId;	
	
				//if($InsCotizacionProducto->MtdRegistrarCotizacionProducto()){
//					$InsCotizacionProducto->CprFecha = FncCambiaFechaANormal($InsCotizacionProducto->CprFecha);
//				}
			

		if(!empty($InsCotizacionProducto1->CotizacionProductoDetalle)){
			foreach($InsCotizacionProducto1->CotizacionProductoDetalle as $DatCotizacionProductoDetalle){

				if($InsCotizacionProducto1->MonId<>$EmpresaMonedaId ){
				
				$DatCotizacionProductoDetalle->CrdPrecioBruto = round($DatCotizacionProductoDetalle->CrdPrecioBruto / $InsCotizacionProducto1->CprTipoCambio,6);
				$DatCotizacionProductoDetalle->CrdImporteBruto = round($DatCotizacionProductoDetalle->CrdImporteBruto / $InsCotizacionProducto1->CprTipoCambio,6);
				
				$DatCotizacionProductoDetalle->CrdImporte = round($DatCotizacionProductoDetalle->CrdImporte / $InsCotizacionProducto1->CprTipoCambio,6);
				$DatCotizacionProductoDetalle->CrdPrecio = round($DatCotizacionProductoDetalle->CrdPrecio  / $InsCotizacionProducto1->CprTipoCambio,6);
				$DatCotizacionProductoDetalle->CrdValorVenta = round($DatCotizacionProductoDetalle->CrdValorVenta  / $InsCotizacionProducto1->CprTipoCambio,6);
				
				$DatCotizacionProductoDetalle->CrdDescuento = round($DatCotizacionProductoDetalle->CrdDescuento  / $InsCotizacionProducto1->CprTipoCambio,6);
				$DatCotizacionProductoDetalle->CrdDescuentoUnitario = round($DatCotizacionProductoDetalle->CrdDescuentoUnitario  / $InsCotizacionProducto1->CprTipoCambio,6);
				
				$DatCotizacionProductoDetalle->CrdAdicional = round($DatCotizacionProductoDetalle->CrdAdicional  / $InsCotizacionProducto1->CprTipoCambio,6);
				$DatCotizacionProductoDetalle->CrdAdicionalUnitario = round($DatCotizacionProductoDetalle->CrdAdicionalUnitario  / $InsCotizacionProducto1->CprTipoCambio,6);
				
				}
			

		
			

//						SesionObjeto-CotizacionProductoDetalle
//						Parametro1 = CpdId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = CrdPrecio
//						Parametro5 = CrdCantidad
//						Parametro6 = CrdImporte
//						Parametro7 = CrdTiempoCreacion
//						Parametro8 = CrdTiempoModificacion

//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = AmdCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo

//						Parametro15 = AmdPrecioVenta
//						Parametro16 = CrdDescripcion
//						Parametro17 = CrdCodigo
//						Parametro18 = CrdValorVenta

//						Parametro19 = UmeIdOrigen
//						Parametro20 = CrdCosto
//						Parametro21 = CrdEstado
//						Parametro22 = CrdTipoPedido
//						Parametro23 = CrdDescuento
//						Parametro24 = CrdPrecioBruto

//						Parametro25 = CrdPorcentajeUtilidad
//						Parametro26 = CrdPorcentajeOtroCosto
//						Parametro27 = CrdPorcentajeManoObra
//						Parametro28 = CrdPorcentajePedido

//						Parametro29 = CrdPorcentajeAdicional
//						Parametro30 = CrdPorcentajeDescuento
//						Parametro31 = CrdAdicional
//						Parametro32 = CrdDescuentoUnitario
//						Parametro33 = CrdImporteBruto
//						Parametro34 = CrdAdicionalUnitario
 
							$_SESSION['InsCotizacionProductoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatCotizacionProductoDetalle->CrdId,
			$DatCotizacionProductoDetalle->ProId,
			$DatCotizacionProductoDetalle->ProNombre,
			$DatCotizacionProductoDetalle->CrdPrecio,
			$DatCotizacionProductoDetalle->CrdCantidad,
			$DatCotizacionProductoDetalle->CrdImporte,
			($DatCotizacionProductoDetalle->CrdTiempoCreacion),
			($DatCotizacionProductoDetalle->CrdTiempoModificacion),
			$DatCotizacionProductoDetalle->UmeNombre,
			$DatCotizacionProductoDetalle->UmeId,
			$DatCotizacionProductoDetalle->RtiId,
			$DatCotizacionProductoDetalle->CrdCantidadReal,
			$DatCotizacionProductoDetalle->ProCodigoOriginal,
			$DatCotizacionProductoDetalle->ProCodigoAlternativo,
			$DatCotizacionProductoDetalle->CrdPrecio,
			$DatCotizacionProductoDetalle->CrdDescripcion,
			$DatCotizacionProductoDetalle->CrdCodigo,
			$DatCotizacionProductoDetalle->CrdValorVenta,
			$DatCotizacionProductoDetalle->UmeIdOrigen,
			$DatCotizacionProductoDetalle->CrdCosto,
			$DatCotizacionProductoDetalle->CrdEstado,
			$DatCotizacionProductoDetalle->CrdTipoPedido,
			
			$DatCotizacionProductoDetalle->CrdDescuento,
			$DatCotizacionProductoDetalle->CrdPrecioBruto,
			
			$DatCotizacionProductoDetalle->CrdPorcentajeUtilidad,
			$DatCotizacionProductoDetalle->CrdPorcentajeOtroCosto,
			$DatCotizacionProductoDetalle->CrdPorcentajeManoObra,
			$DatCotizacionProductoDetalle->CrdPorcentajePedido,
			
			$DatCotizacionProductoDetalle->CrdPorcentajeAdicional,
			$DatCotizacionProductoDetalle->CrdPorcentajeDescuento,
			
			$DatCotizacionProductoDetalle->CrdAdicional,
			$DatCotizacionProductoDetalle->CrdDescuentoUnitario,
			$DatCotizacionProductoDetalle->CrdImporteBruto,
			$DatCotizacionProductoDetalle->CrdAdicionalUnitario);

		
				}
			}
	
			if(!empty($InsCotizacionProducto1->CotizacionProductoPlanchado)){
				foreach($InsCotizacionProducto1->CotizacionProductoPlanchado as $DatCotizacionProductoPlanchado){
		
					if($InsCotizacionProducto1->MonId<>$EmpresaMonedaId ){
						$DatCotizacionProductoPlanchado->CppImporte = round($DatCotizacionProductoPlanchado->CppImporte / $InsCotizacionProducto1->CprTipoCambio,6);
					}
		
					$_SESSION['InsCotizacionProductoPlanchado'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatCotizacionProductoPlanchado->CppDescripcion,
					$DatCotizacionProductoPlanchado->CppPrecio,
					$DatCotizacionProductoPlanchado->CppCantidad,
					$DatCotizacionProductoPlanchado->CppImporte,
					$DatCotizacionProductoPlanchado->CppEstado,
					"L",
					(date("d/m/Y H:i:s")),
					(date("d/m/Y H:i:s"))
					);
				
				}
			}
	
	
			if(!empty($InsCotizacionProducto1->CotizacionProductoPintado)){
				foreach($InsCotizacionProducto1->CotizacionProductoPintado as $DatCotizacionProductoPintado){
		
					if($InsCotizacionProducto1->MonId<>$EmpresaMonedaId){
						$DatCotizacionProductoPintado->CppImporte = round($DatCotizacionProductoPintado->CppImporte / $InsCotizacionProducto1->CprTipoCambio,6);
					}
					
					$_SESSION['InsCotizacionProductoPintado'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatCotizacionProductoPintado->CppDescripcion,
					$DatCotizacionProductoPintado->CppPrecio,
					$DatCotizacionProductoPintado->CppCantidad,
					$DatCotizacionProductoPintado->CppImporte,
					$DatCotizacionProductoPintado->CppEstado,
					"I",
					(date("d/m/Y H:i:s")),
					(date("d/m/Y H:i:s"))
					);
				
				}
			}
			
	
			if(!empty($InsCotizacionProducto1->CotizacionProductoCentrado)){
				foreach($InsCotizacionProducto1->CotizacionProductoCentrado as $DatCotizacionProductoCentrado){
		
					if($InsCotizacionProducto1->MonId<>$EmpresaMonedaId){
						$DatCotizacionProductoCentrado->CppImporte = round($DatCotizacionProductoCentrado->CppImporte / $InsCotizacionProducto1->CprTipoCambio,6);
					}
					
					$_SESSION['InsCotizacionProductoCentrado'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatCotizacionProductoCentrado->CppDescripcion,
					$DatCotizacionProductoCentrado->CppPrecio,
					$DatCotizacionProductoCentrado->CppCantidad,
					$DatCotizacionProductoCentrado->CppImporte,
					$DatCotizacionProductoCentrado->CppEstado,
					"C",
					(date("d/m/Y H:i:s")),
					(date("d/m/Y H:i:s"))
					);

				}
			}
			
	
			if(!empty($InsCotizacionProducto1->CotizacionProductoTarea)){
				foreach($InsCotizacionProducto1->CotizacionProductoTarea as $DatCotizacionProductoTarea){
		
					if($InsCotizacionProducto1->MonId<>$EmpresaMonedaId){
						$DatCotizacionProductoTarea->CppImporte = round($DatCotizacionProductoTarea->CppImporte / $InsCotizacionProducto1->CprTipoCambio,6);
					}

					$_SESSION['InsCotizacionProductoTarea'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatCotizacionProductoTarea->CppDescripcion,
					$DatCotizacionProductoTarea->CppPrecio,
					$DatCotizacionProductoTarea->CppCantidad,
					$DatCotizacionProductoTarea->CppImporte,
					$DatCotizacionProductoTarea->CppEstado,
					"Z",
					(date("d/m/Y H:i:s")),
					(date("d/m/Y H:i:s"))
					);
				
				}
			}
	
	
	
	
			

		
		break;
		
		case "ConsultaVIN":

			if($GET_EinId){
				
				$InsVehiculoIngreso = new ClsVehiculoIngreso();
				$InsVehiculoIngreso->EinId = $GET_EinId;
				$InsVehiculoIngreso->MtdObtenerVehiculoIngreso();

				$InsCotizacionProducto->EinId = $InsVehiculoIngreso->EinId;

				if(!empty($InsVehiculoIngreso->VehiculoIngresoCliente)){
					foreach($InsVehiculoIngreso->VehiculoIngresoCliente as $DatVehiculoIngresoCliente){
						
						$InsCotizacionProducto->CliId = $DatVehiculoIngresoCliente->CliId;
						
					}
				}

				if(!empty($GET_Origen) and $_POST['Guardar']<>1){
	?>
					<script type="text/javascript">
                    $().ready(function() {
                        FncVehiculoIngresoSimpleBuscar('Id');	
						 FncClienteBuscar('Id');	
                    });	
                    </script>
	<?php
				}
				
					
			}

	
		break;
		
		case "ConsultaProducto":
		
			if($GET_ProId){
				
				$InsProducto = new ClsProducto();
				$InsProducto->ProId = $GET_ProId;
				$InsProducto->MtdObtenerProducto(false);

				

//						SesionObjeto-CotizacionProductoDetalle
//						Parametro1 = CpdId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = CrdPrecio
//						Parametro5 = CrdCantidad
//						Parametro6 = CrdImporte
//						Parametro7 = CrdTiempoCreacion
//						Parametro8 = CrdTiempoModificacion

//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = AmdCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo

//						Parametro15 = AmdPrecioVenta
//						Parametro16 = CrdDescripcion
//						Parametro17 = CrdCodigo
//						Parametro18 = CrdValorVenta

//						Parametro19 = UmeIdOrigen
//						Parametro20 = CrdCosto
//						Parametro21 = CrdEstado
//						Parametro22 = CrdTipoPedido
//						Parametro23 = CrdDescuento
//						Parametro24 = CrdPrecioBruto

//						Parametro25 = CrdPorcentajeUtilidad
//						Parametro26 = CrdPorcentajeOtroCosto
//						Parametro27 = CrdPorcentajeManoObra
//						Parametro28 = CrdPorcentajePedido

//						Parametro29 = CrdPorcentajeAdicional
//						Parametro30 = CrdPorcentajeDescuento
//						Parametro31 = CrdAdicional
//						Parametro32 = CrdDescuentoUnitario
//						Parametro33 = CrdImporteBruto
//						Parametro34 = CrdAdicionalUnitario
						
						$Costo = 0;
						$ValorVenta = 0;
						$Precio = 0;
						$Importe = 0;
						$TipoPedido = "";
						
						$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
						$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$InsProducto->ProCodigoOriginal, 'PdiId','ASC',"1",1);
						$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];

						$InsProductoDisponibilidad->PlpId = $ArrProductoDisponibilidades[0]->PlpId;
						unset($ArrProductoDisponibilidades);
						$InsProductoDisponibilidad->MtdObtenerProductoDisponibilidad();
						$ProductoDisponibilidad = $InsProductoDisponibilidad->PdiDisponible;
						
						$InsProductoListaPrecio = new ClsProductoListaPrecio();
						$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$InsProducto->ProCodigoOriginal, 'PlpId','ASC',"1",1);
						$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
						
						$InsProductoListaPrecio->PlpId = $ArrProductoListaPrecios[0]->PlpId;
						unset($ArrProductoListaPrecios);
						$InsProductoListaPrecio->MtdObtenerProductoListaPrecio();
						
						$InsTipoCambio = new ClsTipoCambio();
						$InsTipoCambio->MonId = $InsProductoListaPrecio->MonId;
						$InsTipoCambio->TcaFecha = date("Y-m-d");
						$InsTipoCambio->MtdObtenerTipoCambioActual();
						
						if(empty($InsTipoCambio->TcaId)){
							$InsTipoCambio->MtdObtenerTipoCambioUltimo();
						}
						
						$InsProductoListaPrecio->PlpTipoCambio = $InsTipoCambio->TcaMontoVenta;
						$ProductoPrecio = round($InsProductoListaPrecio->PlpPrecioReal * $InsTipoCambio->TcaMontoVenta,2);
						$ProductoPrecioReal = round($InsProductoListaPrecio->PlpPrecioReal,2);
						
						
						if($EmpresaMonedaId == $InsCotizacionProducto->MonId){
							$Costo = $ProductoPrecio;
						}else{
							$Costo = $ProductoPrecioReal;
						}
						
						if(!empty($InsCotizacionProducto->CprPorcentajeMargenUtilidad)){
							$Precio = $Costo + $Costo * ($InsCotizacionProducto->CprPorcentajeMargenUtilidad/100);
						}
						
						if(!empty($InsCotizacionProducto->CprPorcentajeOtroCosto)){
							$ValorVenta = $Precio = $Precio + $Precio * ($InsCotizacionProducto->CprPorcentajeOtroCosto/100);
						}
						
						if($ProductoDisponibilidad == "2"){
							$Precio = $Precio + $Precio * (0.15);
							$TipoPedido = "IMPORTACION";
						}else{
							$TipoPedido = "NORMAL";	
						}
						
						$Importe = $Precio;
						
						
//						SesionObjeto-CotizacionProductoDetalle
//						Parametro1 = CpdId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = CrdPrecio
//						Parametro5 = CrdCantidad
//						Parametro6 = CrdImporte
//						Parametro7 = CrdTiempoCreacion
//						Parametro8 = CrdTiempoModificacion

//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = AmdCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo

//						Parametro15 = AmdPrecioVenta
//						Parametro16 = CrdDescripcion
//						Parametro17 = CrdCodigo
//						Parametro18 = CrdValorVenta

//						Parametro19 = UmeIdOrigen
//						Parametro20 = CrdCosto
//						Parametro21 = CrdEstado
//						Parametro22 = CrdTipoPedido
//						Parametro23 = CrdDescuento
//						Parametro24 = CrdPrecioBruto

//						Parametro25 = CrdPorcentajeUtilidad
//						Parametro26 = CrdPorcentajeOtroCosto
//						Parametro27 = CrdPorcentajeManoObra
//						Parametro28 = CrdPorcentajePedido

//						Parametro29 = CrdPorcentajeAdicional
//						Parametro30 = CrdPorcentajeDescuento
//						Parametro31 = CrdAdicional
//						Parametro32 = CrdDescuentoUnitario
//						Parametro33 = CrdImporteBruto
//						Parametro34 = CrdAdicionalUnitario

						$_SESSION['InsCotizacionProductoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						$InsProducto->ProId,
						$InsProducto->ProNombre,
						$Precio,//COSTO
						1,
						$Importe,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s"),
						$InsProducto->UmeNombre,
						$InsProducto->UmeId,
						$InsProducto->RtiId,
						1,
						$InsProducto->ProCodigoOriginal,
						$InsProducto->ProCodigoAlternativo,
						0,//Precio
						NULL,//Descripcion
						NULL,//Codigo
						$ValorVenta,//valorVenta
						$InsProducto->UmeId,//UmeIdOrigen
						$Costo,//Costo
						1,
						"NORMAL",
						0,
						0,
						
						0,
						0,
						0,
						0,
						
						0,
						0,
						0,
						0,
						0,
						0
						
						);//Estado
			

					
			}
				
		
		
		break;
		
		
		default:

				//if($InsCotizacionProducto->MtdRegistrarCotizacionProducto()){
//					$InsCotizacionProducto->CprFecha = date("d/m/Y");
//				}
			
		break;

	}
}

//function FncNuevo(){
//	
//			
//	global $Identificador;
//	global $InsCotizacionProducto;	
//	global $EmpresaMonedaId;
//
////deb($EmpresaMonedaId);
//
//	unset($_SESSION['InsCotizacionProductoDetalle'.$Identificador]);
//	unset($_SESSION['InsCotizacionProductoPlanchado'.$Identificador]);
//	unset($_SESSION['InsCotizacionProductoPintado'.$Identificador]);
//	unset($_SESSION['InsCotizacionProductoCentrado'.$Identificador]);
//
//		
//	$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = new ClsSesionObjeto();	
//	$_SESSION['InsCotizacionProductoPlanchado'.$Identificador] = new ClsSesionObjeto();
//	$_SESSION['InsCotizacionProductoPintado'.$Identificador] = new ClsSesionObjeto();
//	$_SESSION['InsCotizacionProductoCentrado'.$Identificador] = new ClsSesionObjeto();
//	
//	
//	
//	//if (!isset($_SESSION['InsCotizacionProductoDetalle'.$Identificador])){	
////		$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = new ClsSesionObjeto();
////	}else{	
////		$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoDetalle'.$Identificador]);
////	}
////	
////	if (!isset($_SESSION['InsCotizacionProductoPintado'.$Identificador])){	
////		$_SESSION['InsCotizacionProductoPintado'.$Identificador] = new ClsSesionObjeto();
////	}else{	
////		$_SESSION['InsCotizacionProductoPintado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoPintado'.$Identificador]);
////	}
////	
////	if (!isset($_SESSION['InsCotizacionProductoPlanchado'.$Identificador])){	
////		$_SESSION['InsCotizacionProductoPlanchado'.$Identificador] = new ClsSesionObjeto();
////	}else{	
////		$_SESSION['InsCotizacionProductoPlanchado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoPlanchado'.$Identificador]);
////	}
////	
////	
////	if (!isset($_SESSION['InsCotizacionProductoCentrado'.$Identificador])){	
////		$_SESSION['InsCotizacionProductoCentrado'.$Identificador] = new ClsSesionObjeto();
////	}else{	
////		$_SESSION['InsCotizacionProductoCentrado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoCentrado'.$Identificador]);
////	}	
//
//	//unset($InsCotizacionProducto);
//	
//	$InsCotizacionProducto = new ClsCotizacionProducto();
////deb($EmpresaMonedaId);
//	$InsCotizacionProducto->CprEstado = 1;
//	$InsCotizacionProducto->MonId = $EmpresaMonedaId;
//	$InsCotizacionProducto->PerId = $_SESSION['SesionPersonal'];
//	$InsCotizacionProducto->CprFecha = date("d/m/Y");
//	$InsCotizacionProducto->CprVigencia = 15;
//					
//	
//}

function FncNuevo(){
	
	global $Identificador;
	
	global $InsCotizacionProducto;
	global $EmpresaMonedaId;
	global $EmpresaRepuestoMargenUtilidad;
	global $EmpresaRepuestoFlete;
	global $EmpresaMantenimientoPorcentajeManoObra;
	
	unset($_SESSION['InsCotizacionProductoDetalle'.$Identificador]);
	unset($_SESSION['InsCotizacionProductoPlanchado'.$Identificador]);
	unset($_SESSION['InsCotizacionProductoPintado'.$Identificador]);
	unset($_SESSION['InsCotizacionProductoCentrado'.$Identificador]);
	unset($_SESSION['InsCotizacionProductoTarea'.$Identificador]);
		
	$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = new ClsSesionObjeto();	
	$_SESSION['InsCotizacionProductoPlanchado'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsCotizacionProductoPintado'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsCotizacionProductoCentrado'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsCotizacionProductoTarea'.$Identificador] = new ClsSesionObjeto();

	$InsCotizacionProducto = new ClsCotizacionProducto();
	$InsCotizacionProducto->CprEstado = 1;
	$InsCotizacionProducto->MonId = $EmpresaMonedaId;
	$InsCotizacionProducto->CprPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;

	$InsCotizacionProducto->PerId = $_SESSION['SesionPersonal'];
	$InsCotizacionProducto->CprFecha = date("d/m/Y");
	$InsCotizacionProducto->CprHora = date("H:i");
	list($InsCotizacionProducto->CprAno,$InsCotizacionProducto->CprMes,$aux) = explode("-",$InsCotizacionProducto->CprFecha);

	$InsCotizacionProducto->CprVigencia = 15;

	$InsCotizacionProducto->CprVerificar = 0;
	$InsCotizacionProducto->CprFirmaDigital = 2;
	$InsCotizacionProducto->CprIncluyeImpuesto = 1;

	//$InsCotizacionProducto->CprNotificar = 1;
	$InsCotizacionProducto->CprNotificar = 2;

	$InsCotizacionProducto->CprPorcentajeMargenUtilidad = $EmpresaRepuestoMargenUtilidad;
	$InsCotizacionProducto->CprPorcentajeOtroCosto = $EmpresaRepuestoFlete;
	$InsCotizacionProducto->CprPorcentajeManoObra = $EmpresaMantenimientoPorcentajeManoObra ;
//	$InsCotizacionProducto->CprPorcentajeManoObra = 0;
	
	
	
	
	$InsCotizacionProducto->CprManoObra = 0;
	$InsCotizacionProducto->CprTiempoEntrega = 0;
	

	$InsCotizacionProducto->CprTiempoCreacion = date("Y-m-d H:i:s");
	$InsCotizacionProducto->CprTiempoModificacion = date("Y-m-d H:i:s");
		
	$InsCotizacionProducto->CprPlanchadoTotal = 0;
	$InsCotizacionProducto->CprPintadoTotal = 0;
	$InsCotizacionProducto->CprCentradoTotal = 0;
	$InsCotizacionProducto->CprProductoTotal = 0;
	
	$InsCotizacionProducto->CprTotalBruto = 0;
	$InsCotizacionProducto->CprSubTotal = 0;
	$InsCotizacionProducto->CprImpuesto = 0;
	$InsCotizacionProducto->CprTotal = 0;
	$InsCotizacionProducto->CprVentaPerdida = 2;
	
	$InsCotizacionProducto->CprTipoCambio = $_SESSION['SesionTipoCambioComercial'];
	
	
}
?>
