<?php
//Si se hizo click en guardar	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsCotizacionProducto->CprId = $_POST['CmpId'];
//	$InsCotizacionProducto->CprAnoFabricacion = $_POST['CmpAno'];
//	$InsCotizacionProducto->CprMes = $_POST['CmpMes'];
	
	$InsCotizacionProducto->CliId = $_POST['CmpClienteId'];
	$InsCotizacionProducto->LtiId = $_POST['CmpClienteTipo'];

	$InsCotizacionProducto->CliIdSeguro = $_POST['CmpSeguro'];

	$InsCotizacionProducto->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsCotizacionProducto->PerId = $_POST['CmpPersonal'];

	$InsCotizacionProducto->FinId = $_POST['CmpFichaIngresoId'];
	
	

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
	$InsCotizacionProducto->CprObservacion = addslashes($_POST['CmpObservacion']);
	$InsCotizacionProducto->CprObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);

	$InsCotizacionProducto->CprTelefono = $_POST['CmpClienteCelular'];
	$InsCotizacionProducto->CprDireccion = $_POST['CmpClienteDireccion'];
	$InsCotizacionProducto->CprEmail = $_POST['CmpClienteEmail'];
	$InsCotizacionProducto->CprRepresentante = $_POST['CmpRepresentante'];
	$InsCotizacionProducto->CprAsegurado = $_POST['CmpAsegurado'];
	
	//$InsCotizacionProducto->CprIncluyeImpuesto = 2;
	
	$InsCotizacionProducto->CprManoObra = eregi_replace(",","",(empty($_POST['CmpManoObra'])?0:$_POST['CmpManoObra']));
	$InsCotizacionProducto->CprPorcentajeDescuento = eregi_replace(",","",(empty($_POST['CmpPorcentajeDescuento'])?0:$_POST['CmpPorcentajeDescuento']));

	$InsCotizacionProducto->CprVigencia = eregi_replace(",","",(empty($_POST['CmpVigencia'])?0:$_POST['CmpVigencia']));
	$InsCotizacionProducto->CprTiempoEntrega = eregi_replace(",","",(empty($_POST['CmpTiempoEntrega'])?0:$_POST['CmpTiempoEntrega']));
	
	
//	$InsCotizacionProducto->CprManoObra = eregi_replace(",","",$_POST['CmpManoObra']);
//	$InsCotizacionProducto->CprVigencia = (empty($_POST['CmpVigencia'])?0:$_POST['CmpVigencia']);
//	$InsCotizacionProducto->CprTiempoEntrega = (empty($_POST['CmpTiempoEntrega'])?0:$_POST['CmpTiempoEntrega']);
	
	$InsCotizacionProducto->CprFirmaDigital = (empty($_POST['CmpFirmaDigital'])?2:$_POST['CmpFirmaDigital']);
	$InsCotizacionProducto->CprVerificar = (empty($_POST['CmpVerificar'])?2:$_POST['CmpVerificar']);
	$InsCotizacionProducto->CprNotificar = (empty($_POST['CmpNotificar'])?2:$_POST['CmpNotificar']);
	
	$InsCotizacionProducto->CprIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsCotizacionProducto->CprEstado = $_POST['CmpEstado'];
	$InsCotizacionProducto->CprTiempoModificacion = date("Y-m-d H:i:s");

	$InsCotizacionProducto->CprPlanchado = $_POST['CprPlanchado'];
	$InsCotizacionProducto->CprPintado = $_POST['CprPintado'];
	$InsCotizacionProducto->CprCentrado = $_POST['CprCentrado'];
	
	$InsCotizacionProducto->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsCotizacionProducto->CliNombre = $_POST['CmpClienteNombre'];
	$InsCotizacionProducto->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];

	$InsCotizacionProducto->FinId = $_POST['CmpFichaIngresoId'];

	$InsCotizacionProducto->CotizacionProductoDetalle = array();
	$InsCotizacionProducto->CotizacionProductoPlanchado = array();
	$InsCotizacionProducto->CotizacionProductoPintado = array();
	$InsCotizacionProducto->CotizacionProductoCentrado = array();
	$InsCotizacionProducto->CotizacionProductoTarea = array();
	
	
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
//						Parametro16 = CrdAdicional
//						Parametro17 = 
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

$ResCotizacionProductoDetalle = $_SESSION['InsCotizacionProductoDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
$ArrCotizacionProductoDetalles = $ResCotizacionProductoDetalle['Datos'];

if(!empty($ArrCotizacionProductoDetalles)){
	foreach($ArrCotizacionProductoDetalles as $DatCotizacionProductoDetalle){
			

		if($InsCotizacionProducto->MonId <> $EmpresaMonedaId){
			
			$DatCotizacionProductoDetalle->Parametro24 = round($DatCotizacionProductoDetalle->Parametro24 * $InsCotizacionProducto->CprTipoCambio,6);
			
			$DatCotizacionProductoDetalle->Parametro20 = round($DatCotizacionProductoDetalle->Parametro20 * $InsCotizacionProducto->CprTipoCambio,6);
			$DatCotizacionProductoDetalle->Parametro18 = round($DatCotizacionProductoDetalle->Parametro18 * $InsCotizacionProducto->CprTipoCambio,6);
			$DatCotizacionProductoDetalle->Parametro4 = round($DatCotizacionProductoDetalle->Parametro4 * $InsCotizacionProducto->CprTipoCambio,6);
			$DatCotizacionProductoDetalle->Parametro6 = round($DatCotizacionProductoDetalle->Parametro6 * $InsCotizacionProducto->CprTipoCambio,6);
		  
		}			
			

		//$DetallePrecioBruto = 0;
//		$DetalleDescuento = 0;
//		$DetallePrecio = 0;
//		$DetalleImporte = 0;
//	
//		if(!empty($InsCotizacionProducto->CprPorcentajeDescuento)){
//			
//			$DetallePrecioBruto = ($DatCotizacionProductoDetalle->Parametro24);
//			$DetallePrecio = $DetallePrecioBruto;
//			$DetalleImporte = ($DetallePrecio * $DatCotizacionProductoDetalle->Parametro5);
//				
//			$DetallePrecioDescuento =  $DetallePrecio - ($DetallePrecio * ($InsCotizacionProducto->CprPorcentajeDescuento/100));
//			
//			$DetalleDescuento = ($DetalleImporte * ($InsCotizacionProducto->CprPorcentajeDescuento/100));
//			$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
//		
//		}else{
//		
//			$DetallePrecioBruto = ($DatCotizacionProductoDetalle->Parametro24);
//			$DetallePrecio = $DetallePrecioBruto;
//			$DetalleImporte = ($DetallePrecio * $DatCotizacionProductoDetalle->Parametro5);
//			
//			$DetallePrecioDescuento =  $DetallePrecio;
//			
//			$DetalleDescuento = 0;
//			$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
//		
//		}
		
		$InsCotizacionProductoDetalle1 = new ClsCotizacionProductoDetalle();
		$InsCotizacionProductoDetalle1->CrdId = $DatCotizacionProductoDetalle->Parametro1;
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
		
		$InsCotizacionProductoDetalle1->CrdPrecioBruto =  $DetallePrecioBruto;
		$InsCotizacionProductoDetalle1->CrdDescuento = $DetalleDescuento;
		$InsCotizacionProductoDetalle1->CrdPrecio =  $DetallePrecioDescuento;
		$InsCotizacionProductoDetalle1->CrdImporte = $DetalleImporteFinal;

		$InsCotizacionProductoDetalle1->CrdCantidad = $DatCotizacionProductoDetalle->Parametro5;
		$InsCotizacionProductoDetalle1->CrdCantidadReal = $DatCotizacionProductoDetalle->Parametro5;
			
		$InsCotizacionProductoDetalle1->CrdTipoPedido = $DatCotizacionProductoDetalle->Parametro22;
		$InsCotizacionProductoDetalle1->CrdEstado = (empty($_POST['CmpCotizacionProductoDetalleEstado_'.$DatCotizacionProductoDetalle->Item])?2:$_POST['CmpCotizacionProductoDetalleEstado_'.$DatCotizacionProductoDetalle->Item]);
		$InsCotizacionProductoDetalle1->CrdEliminado = $DatCotizacionProductoDetalle->Eliminado;
		$InsCotizacionProductoDetalle1->CrdTiempoCreacion = FncCambiaFechaAMysql($DatCotizacionProductoDetalle->Parametro7);
		$InsCotizacionProductoDetalle1->CrdTiempoModificacion = date("Y-m-d H:i:s");

		$InsCotizacionProducto->CotizacionProductoDetalle[] = $InsCotizacionProductoDetalle1;
		
		//if( ($InsCotizacionProducto->CprVerificar == 2  ) or ( $InsCotizacionProducto->CprVerificar == 1 and  $DatCotizacionProductoDetalle->CrdEstado == 1) and $DatCotizacionProductoDetalle->CrdEliminado==1 ){
		if( $DatCotizacionProductoDetalle->CrdEliminado==1 ){			
			
			$InsCotizacionProducto->CprProductoTotal += $InsCotizacionProductoDetalle1->CrdImporte ;	
			$InsCotizacionProducto->CprDescuento += $InsCotizacionProductoDetalle1->CrdDescuento;
		
		}
		
	}
	
	if(!empty($InsCotizacionProducto->CprPorcentajeDescuento)){
		//$InsCotizacionProducto->CprDescuento = $InsCotizacionProducto->CprProductoTotal * ($InsCotizacionProducto->CprPorcentajeDescuento/100);
		//$InsCotizacionProducto->CprProductoTotal = $InsCotizacionProducto->CprProductoTotal - $InsCotizacionProducto->CprDescuento;
		//$InsCotizacionProducto->CprProductoTotal = $InsCotizacionProducto->CprProductoTotal - $InsCotizacionProducto->CprDescuento;
		
	}
			
}

//deb($InsCotizacionProducto->CprProductoTotal);

$ResCotizacionProductoPlanchado = $_SESSION['InsCotizacionProductoPlanchado'.$Identificador]->MtdObtenerSesionObjetos(false);
$ArrCotizacionProductoPlanchados = $ResCotizacionProductoPlanchado['Datos'];

	if(!empty($ArrCotizacionProductoPlanchados)){
		foreach($ArrCotizacionProductoPlanchados as $DatCotizacionProductoPlanchado){
		
			if($InsCotizacionProducto->MonId <> $EmpresaMonedaId){
				
				$DatCotizacionProductoPlanchado->Parametro3 = round($DatCotizacionProductoPlanchado->Parametro3 * $InsCotizacionProducto->CprTipoCambio,6);
				$DatCotizacionProductoPlanchado->Parametro5 = round($DatCotizacionProductoPlanchado->Parametro5 * $InsCotizacionProducto->CprTipoCambio,6);
			}
					
			$InsCotizacionProductoPlanchado1 = new ClsCotizacionProductoPlanchadoPintado();
			$InsCotizacionProductoPlanchado1->CppId = $DatCotizacionProductoPlanchado->Parametro1;
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

			$InsCotizacionProducto->CotizacionProductoPlanchado[] = $InsCotizacionProductoPlanchado1;
			
			if( ($InsCotizacionProducto->CprVerificar == 2  ) or ( $InsCotizacionProducto->CprVerificar == 1 and  $InsCotizacionProductoPlanchado1->CppEstado == 1) and $InsCotizacionProductoPlanchado1->CppEliminado == 1 ){

				$InsCotizacionProducto->CprPlanchadoTotal += $InsCotizacionProductoPlanchado1->CppImporte;

			}
			
			
						
		}		
	}
	
	
$ResCotizacionProductoPintado = $_SESSION['InsCotizacionProductoPintado'.$Identificador]->MtdObtenerSesionObjetos(false);
$ArrCotizacionProductoPintados = $ResCotizacionProductoPintado['Datos'];

	if(!empty($ArrCotizacionProductoPintados)){
		foreach($ArrCotizacionProductoPintados as $DatCotizacionProductoPintado){

			if($InsCotizacionProducto->MonId <> $EmpresaMonedaId){
				$DatCotizacionProductoPintado->Parametro3 = round($DatCotizacionProductoPintado->Parametro3 * $InsCotizacionProducto->CprTipoCambio,6);
				$DatCotizacionProductoPintado->Parametro5 = round($DatCotizacionProductoPintado->Parametro5 * $InsCotizacionProducto->CprTipoCambio,6);
			}
					
			$InsCotizacionProductoPintado1 = new ClsCotizacionProductoPlanchadoPintado();
			$InsCotizacionProductoPintado1->CppId =$DatCotizacionProductoPintado->Parametro1;
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
			
			$InsCotizacionProducto->CotizacionProductoPintado[] = $InsCotizacionProductoPintado1;
			
			if( ($InsCotizacionProducto->CprVerificar == 2  ) or ( $InsCotizacionProducto->CprVerificar == 1 and  $InsCotizacionProductoPintado1->CppEstado == 1) and $InsCotizacionProductoPintado1->CppEliminado == 1  ){
				
				$InsCotizacionProducto->CprPintadoTotal += $InsCotizacionProductoPintado1->CppImporte;
			
			}
			
		}		
	}
	
	
	
		
$ResCotizacionProductoCentrado = $_SESSION['InsCotizacionProductoCentrado'.$Identificador]->MtdObtenerSesionObjetos(false);
$ArrCotizacionProductoCentrados = $ResCotizacionProductoCentrado['Datos'];


	if(!empty($ArrCotizacionProductoCentrados)){
		foreach($ArrCotizacionProductoCentrados as $DatCotizacionProductoCentrado){
			
			
			if($InsCotizacionProducto->MonId <> $EmpresaMonedaId){
				
				$DatCotizacionProductoCentrado->Parametro3 = round($DatCotizacionProductoCentrado->Parametro3 * $InsCotizacionProducto->CprTipoCambio,6);
				$DatCotizacionProductoCentrado->Parametro5 = round($DatCotizacionProductoCentrado->Parametro5 * $InsCotizacionProducto->CprTipoCambio,6);
				
			}
					
			$InsCotizacionProductoCentrado1 = new ClsCotizacionProductoPlanchadoPintado();
			$InsCotizacionProductoCentrado1->CppId = $DatCotizacionProductoCentrado->Parametro1;
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

			$InsCotizacionProducto->CotizacionProductoCentrado[] = $InsCotizacionProductoCentrado1;
			
			if( ($InsCotizacionProducto->CprVerificar == 2  ) or ( $InsCotizacionProducto->CprVerificar == 1 and  $InsCotizacionProductoCentrado1->CppEstado == 1) and $InsCotizacionProductoCentrado1->CppEliminado == 1 ){
				
				$InsCotizacionProducto->CprCentradoTotal += $InsCotizacionProductoCentrado1->CppImporte;
			}
						
		}		
	}
	
	
	
$ResCotizacionProductoTarea = $_SESSION['InsCotizacionProductoTarea'.$Identificador]->MtdObtenerSesionObjetos(false);
$ArrCotizacionProductoTareas = $ResCotizacionProductoTarea['Datos'];


	if(!empty($ArrCotizacionProductoTareas)){
		foreach($ArrCotizacionProductoTareas as $DatCotizacionProductoTarea){
			
			
			if($InsCotizacionProducto->MonId <> $EmpresaMonedaId){
				
				$DatCotizacionProductoTarea->Parametro3 = round($DatCotizacionProductoTarea->Parametro3 * $InsCotizacionProducto->CprTipoCambio,6);
				$DatCotizacionProductoTarea->Parametro5 = round($DatCotizacionProductoTarea->Parametro5 * $InsCotizacionProducto->CprTipoCambio,6);

			}
			
			$InsCotizacionProductoTarea1 = new ClsCotizacionProductoPlanchadoPintado();
			$InsCotizacionProductoTarea1->CppId = $DatCotizacionProductoTarea->Parametro1;			
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
		
			$InsCotizacionProducto->CotizacionProductoTarea[] = $InsCotizacionProductoTarea1;

			if( ($InsCotizacionProducto->CprVerificar == 2  ) or ( $InsCotizacionProducto->CprVerificar == 1 and  $InsCotizacionProductoTarea1->CppEstado == 1) and $InsCotizacionProductoTarea1->CppEliminado == 1 ){

				$InsCotizacionProducto->CprTareaTotal += $InsCotizacionProductoTarea1->CppImporte;

			}
						
		}		
	}
	


	$ResCotizacionProductoFoto = $_SESSION['InsCotizacionProductoFoto'.$Identificador]->MtdObtenerSesionObjetos(false);
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
		
			$InsCotizacionProducto->CotizacionProductoFoto[] = $InsCotizacionProductoFoto1;
					
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
		if($InsCotizacionProducto->MtdEditarCotizacionProducto()){
			
			$InsCotizacionProducto->MtdCotizacionProductoActualizarProductoUso($InsCotizacionProducto->CprId);
			
			$Edito = true;		
			$Resultado.='#SAS_CPR_102';
			FncCargarDatos();
		} else{

			if($InsCotizacionProducto->MonId<>$EmpresaMonedaId ){
				$InsCotizacionProducto->CprManoObra = round($InsCotizacionProducto->CprManoObra / $InsCotizacionProducto->CprTipoCambio,6);
			}
			$InsCotizacionProducto->CprFecha = FncCambiaFechaANormal($InsCotizacionProducto->CprFecha);
			
			$Resultado.='#ERR_CPR_102';
		}		
	}else{
		
		if($InsCotizacionProducto->MonId<>$EmpresaMonedaId ){
			$InsCotizacionProducto->CprManoObra = round($InsCotizacionProducto->CprManoObra / $InsCotizacionProducto->CprTipoCambio,6);
		}
		
		$InsCotizacionProducto->CprFecha = FncCambiaFechaANormal($InsCotizacionProducto->CprFecha);	
	}
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){

	global $GET_id;
	global $Identificador;
	global $InsCotizacionProducto;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsCotizacionProductoDetalle'.$Identificador]);
	unset($_SESSION['InsCotizacionProductoPlanchado'.$Identificador]);
	unset($_SESSION['InsCotizacionProductoPintado'.$Identificador]);
	unset($_SESSION['InsCotizacionProductoCentrado'.$Identificador]);
	unset($_SESSION['InsCotizacionProductoTarea'.$Identificador]);
	unset($_SESSION['InsCotizacionProductoFoto'.$Identificador]);

	$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsCotizacionProductoPlanchado'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsCotizacionProductoPintado'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsCotizacionProductoCentrado'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsCotizacionProductoTarea'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsCotizacionProductoFoto'.$Identificador] = new ClsSesionObjeto();
	
	$InsCotizacionProducto->CprId = $GET_id;
	$InsCotizacionProducto->MtdObtenerCotizacionProducto();	

	if($InsCotizacionProducto->MonId<>$EmpresaMonedaId ){
		$InsCotizacionProducto->CprManoObra = round($InsCotizacionProducto->CprManoObra  / $InsCotizacionProducto->CprTipoCambio,6);
	}
		
	$InsCotizacionProducto->MonIdAnterior = $InsCotizacionProducto->MonId;	
			
	if(!empty($InsCotizacionProducto->CotizacionProductoDetalle)){
		
		foreach($InsCotizacionProducto->CotizacionProductoDetalle as $DatCotizacionProductoDetalle){

			//if(empty($DatCotizacionProductoDetalle->CrdPrecioBruto)){
//				$DatCotizacionProductoDetalle->CrdPrecioBruto = $DatCotizacionProductoDetalle->CrdPrecio;
//			}

			if($InsCotizacionProducto->MonId<>$EmpresaMonedaId ){
				
				$DatCotizacionProductoDetalle->CrdPrecioBruto = round($DatCotizacionProductoDetalle->CrdPrecioBruto / $InsCotizacionProducto->CprTipoCambio,6);
				$DatCotizacionProductoDetalle->CrdImporte = round($DatCotizacionProductoDetalle->CrdImporte / $InsCotizacionProducto->CprTipoCambio,6);
				$DatCotizacionProductoDetalle->CrdPrecio = round($DatCotizacionProductoDetalle->CrdPrecio  / $InsCotizacionProducto->CprTipoCambio,6);
				$DatCotizacionProductoDetalle->CrdValorVenta = round($DatCotizacionProductoDetalle->CrdValorVenta  / $InsCotizacionProducto->CprTipoCambio,6);
				
			}
			

			if(!empty($InsCotizacionProducto->CprPorcentajeDescuento)){
				
				$DetallePrecioBruto = ($DatCotizacionProductoDetalle->CrdPrecioBruto);
				$DetallePrecio = $DetallePrecioBruto;
				$DetalleImporte = ($DetallePrecio * $DatCotizacionProductoDetalle->CrdCantidad);
					
				$DetallePrecioDescuento =  $DetallePrecio - ($DetallePrecio * ($InsCotizacionProducto->CprPorcentajeDescuento/100));
				
				$DetalleDescuento = ($DetalleImporte * ( $InsCotizacionProducto->CprPorcentajeDescuento/100));
				$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
			
			}else{
			
				$DetallePrecioBruto = ( $DatCotizacionProductoDetalle->CrdPrecioBruto );
				$DetallePrecio = $DetallePrecioBruto;
				$DetalleImporte = ($DetallePrecio * $DatCotizacionProductoDetalle->CrdCantidad);
				
				$DetallePrecioDescuento =  $DetallePrecio;
				
				$DetalleDescuento = 0;
				$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
			
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
//						Parametro16 = 
//						Parametro17 = 
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

			$_SESSION['InsCotizacionProductoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatCotizacionProductoDetalle->CrdId,
			$DatCotizacionProductoDetalle->ProId,
			$DatCotizacionProductoDetalle->ProNombre,
			$DetallePrecio,
			$DatCotizacionProductoDetalle->CrdCantidad,
			$DetalleImporte,
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
			$DatCotizacionProductoDetalle->CrdPorcentajeDescuento);
		
		}
	}
	
	
	
	if(!empty($InsCotizacionProducto->CotizacionProductoPlanchado)){
		foreach($InsCotizacionProducto->CotizacionProductoPlanchado as $DatCotizacionProductoPlanchado){

			if($InsCotizacionProducto->MonId<>$EmpresaMonedaId ){
				$DatCotizacionProductoPlanchado->CppImporte = round($DatCotizacionProductoPlanchado->CppImporte / $InsCotizacionProducto->CprTipoCambio,6);
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

		$_SESSION['InsCotizacionProductoPlanchado'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatCotizacionProductoPlanchado->CppId,
			$DatCotizacionProductoPlanchado->CppDescripcion,
			$DatCotizacionProductoPlanchado->CppPrecio,
			$DatCotizacionProductoPlanchado->CppCantidad,
			$DatCotizacionProductoPlanchado->CppImporte,
			$DatCotizacionProductoPlanchado->CppEstado,
			$DatCotizacionProductoPlanchado->CppTipo,
			($DatCotizacionProductoPlanchado->CppTiempoCreacion),
			($DatCotizacionProductoPlanchado->CppTiempoModificacion)
			);
		
		}
	}
	
	
	//deb($InsCotizacionProducto->CotizacionProductoPintado);
	
	if(!empty($InsCotizacionProducto->CotizacionProductoPintado)){
		foreach($InsCotizacionProducto->CotizacionProductoPintado as $DatCotizacionProductoPintado){

			if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
				$DatCotizacionProductoPintado->CppImporte = round($DatCotizacionProductoPintado->CppImporte / $InsCotizacionProducto->CprTipoCambio,6);
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

		$_SESSION['InsCotizacionProductoPintado'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatCotizacionProductoPintado->CppId,
			$DatCotizacionProductoPintado->CppDescripcion,
			$DatCotizacionProductoPintado->CppPrecio,
			$DatCotizacionProductoPintado->CppCantidad,
			$DatCotizacionProductoPintado->CppImporte,
			$DatCotizacionProductoPintado->CppEstado,
			$DatCotizacionProductoPintado->CppTipo,
			($DatCotizacionProductoPintado->CppTiempoCreacion),
			($DatCotizacionProductoPintado->CppTiempoModificacion)
			);
		
		}
	}
	
	
	
	
	if(!empty($InsCotizacionProducto->CotizacionProductoCentrado)){
		foreach($InsCotizacionProducto->CotizacionProductoCentrado as $DatCotizacionProductoCentrado){

			if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
				$DatCotizacionProductoCentrado->CppImporte = round($DatCotizacionProductoCentrado->CppImporte / $InsCotizacionProducto->CprTipoCambio,6);
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

		$_SESSION['InsCotizacionProductoCentrado'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatCotizacionProductoCentrado->CppId,
			$DatCotizacionProductoCentrado->CppDescripcion,
			$DatCotizacionProductoCentrado->CppPrecio,
			$DatCotizacionProductoCentrado->CppCantidad,
			$DatCotizacionProductoCentrado->CppImporte,
			$DatCotizacionProductoCentrado->CppEstado,
			$DatCotizacionProductoCentrado->CppTipo,
			($DatCotizacionProductoCentrado->CppTiempoCreacion),
			($DatCotizacionProductoCentrado->CppTiempoModificacion)
			);
		
		}
	}
	
	
	if(!empty($InsCotizacionProducto->CotizacionProductoTarea)){
		foreach($InsCotizacionProducto->CotizacionProductoTarea as $DatCotizacionProductoTarea){

			if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
				$DatCotizacionProductoTarea->CppImporte = round($DatCotizacionProductoTarea->CppImporte / $InsCotizacionProducto->CprTipoCambio,6);
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


			$_SESSION['InsCotizacionProductoTarea'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatCotizacionProductoTarea->CppId,
			$DatCotizacionProductoTarea->CppDescripcion,
			$DatCotizacionProductoTarea->CppPrecio,
			$DatCotizacionProductoTarea->CppCantidad,
			$DatCotizacionProductoTarea->CppImporte,
			$DatCotizacionProductoTarea->CppEstado,
			$DatCotizacionProductoTarea->CppTipo,
			($DatCotizacionProductoTarea->CppTiempoCreacion),
			($DatCotizacionProductoTarea->CppTiempoModificacion)
			);
		
		}
	}
	
	if(!empty($InsCotizacionProducto->CotizacionProductoFoto)){
		foreach($InsCotizacionProducto->CotizacionProductoFoto as $DatCotizacionProductoFoto){
			
			$_SESSION['InsCotizacionProductoFoto'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatCotizacionProductoFoto->CpfId,
			NULL,
			$DatCotizacionProductoFoto->CpfArchivo,			
			$DatCotizacionProductoFoto->CpfEstado,
			($DatCotizacionProductoFoto->CpfTiempoCreacion),
			($DatCotizacionProductoFoto->CpfTiempoModificacion),
			$DatCotizacionProductoFoto->CpfTipo
			);
	
		}
	}

	
}
?>