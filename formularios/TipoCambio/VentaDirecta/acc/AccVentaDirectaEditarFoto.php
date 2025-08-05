<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsVentaDirecta->UsuId = $_SESSION['SesionId'];	
	
	$InsVentaDirecta->VdiId = $_POST['CmpId'];
	$InsVentaDirecta->CliId = $_POST['CmpClienteId'];
	
	$InsVentaDirecta->EinId = $_POST['CmpVehiculoIngresoId'];
//	$InsVentaDirecta->EinId = $_POST['CmpClienteVehiculoIngresoId'];
	$InsVentaDirecta->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsVentaDirecta->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	
	$InsVentaDirecta->VdiOrdenCompraNumero = $_POST['CmpOrdenCompraNumero'];
	
	$InsVentaDirecta->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsVentaDirecta->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsVentaDirecta->VveNombre = $_POST['CmpVehiculoIngresoVersion'];




	$InsVentaDirecta->TopId = $_POST['CmpTipoOperacion'];
	$InsVentaDirecta->VdiFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	$InsVentaDirecta->MonId = $_POST['CmpMonedaId'];
	$InsVentaDirecta->VdiTipoCambio = $_POST['CmpTipoCambio'];

	$InsVentaDirecta->VdiObservacion = addslashes($_POST['CmpObservacion']);
	$InsVentaDirecta->VdiObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	
	$InsVentaDirecta->VdiManoObra = eregi_replace(",","",(empty($_POST['CmpManoObra'])?0:$_POST['CmpManoObra']));
	$InsVentaDirecta->VdiDescuento = eregi_replace(",","",(empty($_POST['CmpDescuento'])?0:$_POST['CmpDescuento']));

	
	$InsVentaDirecta->VdiIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsVentaDirecta->VdiNotificar = (empty($_POST['CmpNotificar'])?2:$_POST['CmpNotificar']);
	
	$InsVentaDirecta->VdiArchivo = $_SESSION['SesVdiArchivo'.$Identificador];
	$InsVentaDirecta->VdiEstado = $_POST['CmpEstado'];
	$InsVentaDirecta->VdiTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsVentaDirecta->VdiPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	//$InsVentaDirecta->VdiMargenUtilidad = $_POST['CmpClienteTipoUtilidad'];
	$InsVentaDirecta->VdiMargenUtilidad = 0;
	$InsVentaDirecta->LtiId = $_POST['CmpClienteTipo'];	
		
	$InsVentaDirecta->CliNombre = $_POST['CmpClienteNombre'];
	$InsVentaDirecta->TdoId = $_POST['CmpClienteTipoDocumento'];	
	$InsVentaDirecta->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsVentaDirecta->CliTelefono = $_POST['CmpClienteTelefono'];

//	$InsVentaDirecta->CliEmail = $_POST['CmpClienteEmail'];
//	$InsVentaDirecta->CliCelular = $_POST['CmpClienteCelular'];
//	$InsVentaDirecta->CliFax = $_POST['CmpClienteFax'];

	$InsVentaDirecta->VdiDireccion = $_POST['CmpClienteDireccion'];	

	$InsVentaDirecta->CprId = $_POST['CmpCotizacionProductoId'];	
	
	$InsVentaDirecta->VdiPedidoCompra = $_POST['CmpPedidoCompra'];	
	$InsVentaDirecta->VdiVentaConcretada = $_POST['CmpVentaConcretada'];	
	
	$InsVentaDirecta->VentaDirectaDetalle = array();
	$InsVentaDirecta->VentaDirectaPlanchado = array();
	$InsVentaDirecta->VentaDirectaPintado = array();
	$InsVentaDirecta->VentaDirectaCentrado = array();
	$InsVentaDirecta->VentaDirectaTarea = array();

	$InsVentaDirecta->VdiPlanchadoTotal = 0;
	$InsVentaDirecta->VdiPintadoTotal = 0;
	$InsVentaDirecta->VdiCentradoTotal  = 0;
	$InsVentaDirecta->VdiTareaTotal = 0;
	
	$InsVentaDirecta->VdiSubTotal = 0;
	$InsVentaDirecta->VdiImpuesto = 0;
	$InsVentaDirecta->VdiTotal = 0;


	if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
		if(empty($InsVentaDirecta->VdiTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_VDI_600';
		}
	}

	if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
		$InsVentaDirecta->VdiDescuento = $InsVentaDirecta->VdiDescuento * $InsVentaDirecta->VdiTipoCambio;
	}

	if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
		$InsVentaDirecta->VdiManoObra = $InsVentaDirecta->VdiManoObra * $InsVentaDirecta->VdiTipoCambio;
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
						*/

	$ResVentaDirectaDetalle = $_SESSION['InsVentaDirectaDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
	
	if(!empty($ResVentaDirectaDetalle['Datos'])){
		$item = 1;
		foreach($ResVentaDirectaDetalle['Datos'] as $DatSesionObjeto){
				
			$InsVentaDirectaDetalle1 = new ClsVentaDirectaDetalle();
			$InsVentaDirectaDetalle1->VddId = $DatSesionObjeto->Parametro1;
			$InsVentaDirectaDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsVentaDirectaDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			
			$InsVentaDirectaDetalle1->ProNombre = $DatSesionObjeto->Parametro3;
			$InsVentaDirectaDetalle1->ProCodigoOriginal = $DatSesionObjeto->Parametro13;
			$InsVentaDirectaDetalle1->ProCodigoAlternativo = $DatSesionObjeto->Parametro14;
			
			$InsVentaDirectaDetalle1->UmeIdOrigen = $DatSesionObjeto->Parametro15;
			$InsVentaDirectaDetalle1->UmeNombre =  $DatSesionObjeto->Parametro9;
			$InsVentaDirectaDetalle1->RtiId = $DatSesionObjeto->Parametro11;
			
			//$InsVentaDirectaDetalle1->VddCantidadPedir = $DatSesionObjeto->Parametro20;
			//$InsVentaDirectaDetalle1->VddCantidadPedirFecha = FncCambiaFechaAMysql($DatSesionObjeto->Parametro21,true);
			$InsVentaDirectaDetalle1->VddCantidadPedir = 0;
			$InsVentaDirectaDetalle1->VddCantidadPedirFecha = NULL;
			
			$InsVentaDirectaDetalle1->VerificarStock = $DatSesionObjeto->Parametro16;		
			
			$InsVentaDirectaDetalle1->VddCosto = $DatSesionObjeto->Parametro17;
			//$InsVentaDirectaDetalle1->VddPrecioVenta = $DatSesionObjeto->Parametro4;		
			
			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				$InsVentaDirectaDetalle1->VddPrecioVenta = $DatSesionObjeto->Parametro4 * $InsVentaDirecta->VdiTipoCambio;
			}else{
				$InsVentaDirectaDetalle1->VddPrecioVenta = $DatSesionObjeto->Parametro4;
			}
				
			$InsVentaDirectaDetalle1->VddValorTotal = 0;
			$InsVentaDirectaDetalle1->VddUtilidad = 0;

			$InsVentaDirectaDetalle1->VddCostoExtraTotal = 0;		
			$InsVentaDirectaDetalle1->VddCantidadReal = $DatSesionObjeto->Parametro12;
			$InsVentaDirectaDetalle1->VddCantidad = $DatSesionObjeto->Parametro5;
			//$InsVentaDirectaDetalle1->VddImporte = $DatSesionObjeto->Parametro6;

			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				$InsVentaDirectaDetalle1->VddImporte = $DatSesionObjeto->Parametro6 * $InsVentaDirecta->VdiTipoCambio;
			}else{
				$InsVentaDirectaDetalle1->VddImporte = $DatSesionObjeto->Parametro6;
			}
			
			
			$InsVentaDirectaDetalle1->VddEstado = 1;
			$InsVentaDirectaDetalle1->VddTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsVentaDirectaDetalle1->VddTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsVentaDirectaDetalle1->CrdId = $DatSesionObjeto->Parametro22;
			
			$InsVentaDirectaDetalle1->VddEliminado = $DatSesionObjeto->Eliminado;				
			$InsVentaDirectaDetalle1->InsMysql = NULL;

			$InsVentaDirecta->VentaDirectaDetalle[] = $InsVentaDirectaDetalle1;
				
			if($InsVentaDirectaDetalle1->VddEliminado==1){
				$InsVentaDirecta->VdiTotalBruto += $InsVentaDirectaDetalle1->VddImporte;	
			}	
			
				//$InsProducto->ProId = $InsVentaDirectaDetalle1->ProId;
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
	}else{
		$Guardar = false;
		$Resultado.='#ERR_VDI_111';
	}	


	$ResVentaDirectaPlanchado = $_SESSION['InsVentaDirectaPlanchado'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResVentaDirectaPlanchado['Datos'])){
		foreach($ResVentaDirectaPlanchado['Datos'] as $DatSesionObjeto){

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
			$InsVentaDirectaPlanchado1 = new ClsVentaDirectaTarea();
			$InsVentaDirectaPlanchado1->VdtId = $DatSesionObjeto->Parametro1;
			$InsVentaDirectaPlanchado1->VdtDescripcion = $DatSesionObjeto->Parametro3;
			
			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				$InsVentaDirectaPlanchado1->VdtImporte = $DatSesionObjeto->Parametro5 * $InsVentaDirecta->VdiTipoCambio;
			}else{
				$InsVentaDirectaPlanchado1->VdtImporte = $DatSesionObjeto->Parametro5;
			}
			
			$InsVentaDirectaPlanchado1->VdtEstado = 1;
			$InsVentaDirectaPlanchado1->VdtTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			$InsVentaDirectaPlanchado1->VdtTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			
			$InsVentaDirectaPlanchado1->VdtEliminado = $DatSesionObjeto->Eliminado;				
			//$InsVentaDirectaPlanchado1->InsMysql = NULL;
			
			$InsVentaDirecta->VentaDirectaPlanchado[] = $InsVentaDirectaPlanchado1;
				
			if($InsVentaDirectaPlanchado1->VdtEliminado==1){
			
				$InsVentaDirecta->VdiPlanchadoTotal += $InsVentaDirectaPlanchado1->VdtImporte;
			
			}				
		}		
	}
	
	
	$ResVentaDirectaPintado = $_SESSION['InsVentaDirectaPintado'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResVentaDirectaPintado['Datos'])){
		foreach($ResVentaDirectaPintado['Datos'] as $DatSesionObjeto){

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

			$InsVentaDirectaPintado1 = new ClsVentaDirectaTarea();
			$InsVentaDirectaPintado1->VdtId = $DatSesionObjeto->Parametro1;
			$InsVentaDirectaPintado1->VdtDescripcion = $DatSesionObjeto->Parametro3;

			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				$InsVentaDirectaPintado1->VdtImporte = $DatSesionObjeto->Parametro5 * $InsVentaDirecta->VdiTipoCambio;
			}else{
				$InsVentaDirectaPintado1->VdtImporte = $DatSesionObjeto->Parametro5;
			}
			
			$InsVentaDirectaPintado1->VdtEstado = 1;
			$InsVentaDirectaPintado1->VdtTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			$InsVentaDirectaPintado1->VdtTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			
			$InsVentaDirectaPintado1->VdtEliminado = $DatSesionObjeto->Eliminado;				
			//$InsVentaDirectaPintado1->InsMysql = NULL;
			
			$InsVentaDirecta->VentaDirectaPintado[] = $InsVentaDirectaPintado1;
				
			if($InsVentaDirectaPintado1->VdtEliminado==1){
			
				$InsVentaDirecta->VdiPintadoTotal += $InsVentaDirectaPintado1->VdtImporte;
			
			}				
		}		
	}
	
	
	
	$ResVentaDirectaCentrado = $_SESSION['InsVentaDirectaCentrado'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResVentaDirectaCentrado['Datos'])){
		foreach($ResVentaDirectaCentrado['Datos'] as $DatSesionObjeto){

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

			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				$InsVentaDirectaCentrado1->VdtImporte = $DatSesionObjeto->Parametro5 * $InsVentaDirecta->VdiTipoCambio;
			}else{
				$InsVentaDirectaCentrado1->VdtImporte = $DatSesionObjeto->Parametro5;
			}
			
			$InsVentaDirectaCentrado1->VdtEstado = 1;
			$InsVentaDirectaCentrado1->VdtTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			$InsVentaDirectaCentrado1->VdtTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			
			$InsVentaDirectaCentrado1->VdtEliminado = $DatSesionObjeto->Eliminado;				
			//$InsVentaDirectaCentrado1->InsMysql = NULL;
			
			$InsVentaDirecta->VentaDirectaCentrado[] = $InsVentaDirectaCentrado1;
				
			if($InsVentaDirectaCentrado1->VdtEliminado==1){
			
				$InsVentaDirecta->VdiCentradoTotal += $InsVentaDirectaCentrado1->VdtImporte;
			
			}				
		}		
	}
	


	$ResVentaDirectaTarea = $_SESSION['InsVentaDirectaTarea'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResVentaDirectaTarea['Datos'])){
		foreach($ResVentaDirectaTarea['Datos'] as $DatSesionObjeto){

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

			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				$InsVentaDirectaTarea1->VdtImporte = $DatSesionObjeto->Parametro5 * $InsVentaDirecta->VdiTipoCambio;
			}else{
				$InsVentaDirectaTarea1->VdtImporte = $DatSesionObjeto->Parametro5;
			}
			
			$InsVentaDirectaTarea1->VdtEstado = 1;
			$InsVentaDirectaTarea1->VdtTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			$InsVentaDirectaTarea1->VdtTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			
			$InsVentaDirectaTarea1->VdtEliminado = $DatSesionObjeto->Eliminado;				
			//$InsVentaDirectaTarea1->InsMysql = NULL;
			
			$InsVentaDirecta->VentaDirectaTarea[] = $InsVentaDirectaTarea1;
				
			if($InsVentaDirectaTarea1->VdtEliminado==1){
			
				$InsVentaDirecta->VdiTareaTotal += $InsVentaDirectaTarea1->VdtImporte;
			
			}				
		}		
	}
	
	
	if($InsVentaDirecta->VdiIncluyeImpuesto == 1){

		$InsVentaDirecta->VdiSubTotal = $InsVentaDirecta->VdiTotalBruto / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
		$InsVentaDirecta->VdiSubTotal = $InsVentaDirecta->VdiSubTotal - $InsVentaDirecta->VdiDescuento;
		
		$InsVentaDirecta->VdiManoObra = $InsVentaDirecta->VdiManoObra / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
		$InsVentaDirecta->VdiPlanchadoTotal = $InsVentaDirecta->VdiPlanchadoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
		$InsVentaDirecta->VdiPintadoTotal = $InsVentaDirecta->VdiPintadoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
		$InsVentaDirecta->VdiCentradoTotal = $InsVentaDirecta->VdiCentradoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
		$InsVentaDirecta->VdiTareaTotal = $InsVentaDirecta->VdiTareaTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
		
		
	}else{

		$InsVentaDirecta->VdiSubTotal = $InsVentaDirecta->VdiTotalBruto - $InsVentaDirecta->VdiDescuento;

	}

	$InsVentaDirecta->VdiSubTotal = $InsVentaDirecta->VdiSubTotal + $InsVentaDirecta->VdiManoObra + $InsVentaDirecta->VdiPlanchadoTotal + $InsVentaDirecta->VdiPintadoTotal + $InsVentaDirecta->VdiCentradoTotal + $InsVentaDirecta->VdiTareaTotal;
	$InsVentaDirecta->VdiImpuesto = $InsVentaDirecta->VdiSubTotal * ($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100);
	$InsVentaDirecta->VdiTotal = $InsVentaDirecta->VdiSubTotal + $InsVentaDirecta->VdiImpuesto;	
	
	
	
	
	if($Guardar){
		if($InsVentaDirecta->MtdEditarVentaDirectaDato("VdiFoto",$InsVentaDirecta)){		
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_VDI_102';
		} else{
			$InsVentaDirecta->VdiFecha = FncCambiaFechaANormal($InsVentaDirecta->VdiFecha);
			$Resultado.='#ERR_VDI_102';
		}	
	}else{
		$InsVentaDirecta->VdiFecha = FncCambiaFechaANormal($InsVentaDirecta->VdiFecha);
	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){

	global $GET_id;
	global $Identificador;
	global $InsVentaDirecta;
	global $EmpresaMonedaId;

	global $InsProducto;
	global $InsUnidadMedida;
	global $InsUnidadMedidaConversion;
	
	unset($_SESSION['InsVentaDirectaDetalle'.$Identificador]);
	unset($_SESSION['SesVdiArchivo'.$Identificador]);
	
	
	$_SESSION['InsVentaDirectaDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsVentaDirectaPlanchado'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsVentaDirectaPintado'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsVentaDirectaCentrado'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsVentaDirectaTarea'.$Identificador] = new ClsSesionObjeto();

	$InsVentaDirecta->VdiId = $GET_id;
	$InsVentaDirecta->MtdObtenerVentaDirecta();		

	$_SESSION['SesVdiArchivo'.$Identificador] =	$InsVentaDirecta->VdiArchivo;

	if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
		$InsVentaDirecta->VdiDescuento = round($InsVentaDirecta->VdiDescuento / $InsVentaDirecta->VdiTipoCambio,2);
	}
			
	if(!empty($InsVentaDirecta->VentaDirectaDetalle)){
		foreach($InsVentaDirecta->VentaDirectaDetalle as $DatVentaDirectaDetalle){


			$InsProducto->ProId = $DatVentaDirectaDetalle->ProId;
			$InsProducto->MtdObtenerProducto(false);
			
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
				$DatVentaDirectaDetalle->VddCantidadReal = 0;			
			}
							
							

			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				$DatVentaDirectaDetalle->VddPrecioVenta = round($DatVentaDirectaDetalle->VddPrecioVenta / $InsVentaDirecta->VdiTipoCambio,2);
				$DatVentaDirectaDetalle->VddImporte = round($DatVentaDirectaDetalle->VddImporte / $InsVentaDirecta->VdiTipoCambio,2);
			}

			$DatVentaDirectaDetalle->VerificarStock = 2;
			
			$InsProducto->ProId = $DatVentaDirectaDetalle->ProId;
			$InsProducto->MtdObtenerProducto(false);

			
			if($InsProducto->ProStockReal < $DatVentaDirectaDetalle->VddCantidadReal){
				$DatVentaDirectaDetalle->VerificarStock = 1;
			}
			//deb($DatVentaDirectaDetalle->VddCantidadReal);
			
			$DatVentaDirectaDetalle->VddCantidadPedir = 0;
			$DatVentaDirectaDetalle->VddCantidadPedirFecha = NULL;
			
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


			$_SESSION['InsVentaDirectaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatVentaDirectaDetalle->VddId,
			$DatVentaDirectaDetalle->ProId,
			$DatVentaDirectaDetalle->ProNombre,
			$DatVentaDirectaDetalle->VddPrecioVenta,
			$DatVentaDirectaDetalle->VddCantidad,
			$DatVentaDirectaDetalle->VddImporte,
			($DatVentaDirectaDetalle->VddTiempoCreacion),
			($DatVentaDirectaDetalle->VddTiempoModificacion),
			$DatVentaDirectaDetalle->UmeNombre,
			$DatVentaDirectaDetalle->UmeId,
			$DatVentaDirectaDetalle->RtiId,
			$DatVentaDirectaDetalle->VddCantidadReal,
			$DatVentaDirectaDetalle->ProCodigoOriginal,
			$DatVentaDirectaDetalle->ProCodigoAlternativo,
			$DatVentaDirectaDetalle->UmeIdOrigen,
			$DatVentaDirectaDetalle->VerificarStock,
			$DatVentaDirectaDetalle->VddCosto,
			$InsProducto->ProStock,
			$InsProducto->ProStockReal,
			$DatVentaDirectaDetalle->VddCantidadPedir,
			$DatVentaDirectaDetalle->VddCantidadPedirFecha,
			$DatVentaDirectaDetalle->CrdId
			);
		
		}
	}
	
	




	if(!empty($InsVentaDirecta->VentaDirectaPlanchado)){
		foreach($InsVentaDirecta->VentaDirectaPlanchado as $DatVentaDirectaPlanchado){

			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				$DatVentaDirectaPlanchado->VdtImporte = round($DatVentaDirectaPlanchado->VdtImporte / $InsVentaDirecta->VdiTipoCambio,2);
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
			$_SESSION['InsVentaDirectaPlanchado'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatVentaDirectaPlanchado->VdtId,
			NULL,
			$DatVentaDirectaPlanchado->VdtDescripcion,
			NULL,
			$DatVentaDirectaPlanchado->VdtImporte,
			($DatVentaDirectaPlanchado->VdtTiempoCreacion),
			($DatVentaDirectaPlanchado->VdtTiempoModificacion)
			);
		
		}
	}
	
	
	//deb($InsVentaDirecta->VentaDirectaPintado);
	
	if(!empty($InsVentaDirecta->VentaDirectaPintado)){
		foreach($InsVentaDirecta->VentaDirectaPintado as $DatVentaDirectaPintado){

			if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
				$DatVentaDirectaPintado->VdtImporte = round($DatVentaDirectaPintado->VdtImporte / $InsVentaDirecta->VdiTipoCambio,2);
			}
			
	/*
	SesionObjeto-VentaDirectaPintado
	Parametro1 = VdtId
	Parametro2 = 
	Parametro3 = VdtDescripcion
	Parametro4 = 
	Parametro5 = VdtImporte
	Parametro6 = VdtTiempoCreacion
	Parametro7 = VdtTiempoModificacion
	*/
			$_SESSION['InsVentaDirectaPintado'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatVentaDirectaPintado->VdtId,
			NULL,
			$DatVentaDirectaPintado->VdtDescripcion,
			NULL,
			$DatVentaDirectaPintado->VdtImporte,
			($DatVentaDirectaPintado->VdtTiempoCreacion),
			($DatVentaDirectaPintado->VdtTiempoModificacion)
			);

		}
	}
	
	
	
	
	if(!empty($InsVentaDirecta->VentaDirectaCentrado)){
		foreach($InsVentaDirecta->VentaDirectaCentrado as $DatVentaDirectaCentrado){

			if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
				$DatVentaDirectaCentrado->VdtImporte = round($DatVentaDirectaCentrado->VdtImporte / $InsVentaDirecta->VdiTipoCambio,2);
			}
			
		/*
		SesionObjeto-VentaDirectaCentrado
		Parametro1 = VdtId
		Parametro2 = 
		Parametro3 = VdtDescripcion
		Parametro4 = 
		Parametro5 = VdtImporte
		Parametro6 = VdtTiempoCreacion
		Parametro7 = VdtTiempoModificacion
		*/

		$_SESSION['InsVentaDirectaCentrado'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatVentaDirectaCentrado->VdtId,
			NULL,
			$DatVentaDirectaCentrado->VdtDescripcion,
			NULL,
			$DatVentaDirectaCentrado->VdtImporte,
			($DatVentaDirectaCentrado->VdtTiempoCreacion),
			($DatVentaDirectaCentrado->VdtTiempoModificacion)
			);
		
		}
	}
	
	
	if(!empty($InsVentaDirecta->VentaDirectaTarea)){
		foreach($InsVentaDirecta->VentaDirectaTarea as $DatVentaDirectaTarea){

			if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
				$DatVentaDirectaTarea->VdtImporte = round($DatVentaDirectaTarea->VdtImporte / $InsVentaDirecta->VdiTipoCambio,2);
			}
	
//		SesionObjeto-VentaDirectaTarea
//		Parametro1 = VdtId
//		Parametro2 = 
//		Parametro3 = VdtDescripcion
//		Parametro4 = 
//		Parametro5 = VdtImporte
//		Parametro6 = VdtTiempoCreacion
//		Parametro7 = VdtTiempoModificacion

			$_SESSION['InsVentaDirectaTarea'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatVentaDirectaTarea->VdtId,
			NULL,
			$DatVentaDirectaTarea->VdtDescripcion,
			NULL,
			$DatVentaDirectaTarea->VdtImporte,
			($DatVentaDirectaTarea->VdtTiempoCreacion),
			($DatVentaDirectaTarea->VdtTiempoModificacion)
			);
		
		}
	}


	
}

?>
