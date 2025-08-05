<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsVentaDirecta->UsuId = $_SESSION['SesionId'];	
	
	$InsVentaDirecta->VdiId = $_POST['CmpId'];
	$InsVentaDirecta->CliId = $_POST['CmpClienteId'];
	
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
	//$InsVentaDirecta->TopId = $_POST['CmpTipoOperacion'];
	$InsVentaDirecta->TopId = "TOP-10000";	
	$InsVentaDirecta->VdiFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	$InsVentaDirecta->MonId = $_POST['CmpMonedaId'];
	$InsVentaDirecta->VdiTipoCambio = $_POST['CmpTipoCambio'];

	$InsVentaDirecta->VdiObservacion = addslashes($_POST['CmpObservacion']);
	$InsVentaDirecta->VdiObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsVentaDirecta->VdiResultado = addslashes($_POST['CmpResultado']);
	
	$InsVentaDirecta->VdiAbono = eregi_replace(",","",(empty($_POST['CmpAbono'])?0:$_POST['CmpAbono']));
	$InsVentaDirecta->VdiManoObra = eregi_replace(",","",(empty($_POST['CmpManoObra'])?0:$_POST['CmpManoObra']));
	$InsVentaDirecta->VdiDescuento = eregi_replace(",","",(empty($_POST['CmpDescuento'])?0:$_POST['CmpDescuento']));
	
	$InsVentaDirecta->VdiIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsVentaDirecta->VdiNotificar = (empty($_POST['CmpNotificar'])?2:$_POST['CmpNotificar']);
	
	$InsVentaDirecta->VdiArchivo = $_SESSION['SesVdiArchivo'.$Identificador];
	$InsVentaDirecta->VdiArchivoEntrega = $_SESSION['SesVdiArchivoEntrega'.$Identificador];
	$InsVentaDirecta->VdiArchivoEntrega2 = $_SESSION['SesVdiArchivoEntrega2'.$Identificador];
	
	$InsVentaDirecta->VdiEstado = $_POST['CmpEstado'];
	$InsVentaDirecta->VdiTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsVentaDirecta->VdiPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	//$InsVentaDirecta->VdiPorcentajeMargenUtilidad = $_POST['CmpClienteTipoUtilidad'];
	$InsVentaDirecta->VdiPorcentajeMargenUtilidad = 0;
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
//						Parametro24 = VddCantidadPorLlegar
//						Parametro25 = AmdCantidad
//						Parametro26 = VddEstado
//						Parametro27 = VdiId

//						Parametro28 = VddRemplazo
//						Parametro29 = ProIdPedido
//						Parametro30 = ProCodigoOriginalPedido

//						Parametro31 = PcdBOFecha
//						Parametro32 = PcdBOEstado
//						Parametro33 = VddFechaPorLlegar
//						Parametro34 = AmdEstado
//						Parametro35 = VddEntregado

	$ResVentaDirectaDetalle = $_SESSION['InsVentaDirectaDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
	
	if(!empty($ResVentaDirectaDetalle['Datos'])){
		$item = 1;
		foreach($ResVentaDirectaDetalle['Datos'] as $DatSesionObjeto){
				
			$InsVentaDirectaDetalle1 = new ClsVentaDirectaDetalle();
			
			$InsVentaDirectaDetalle1->VddEstado = $DatSesionObjeto->Parametro26;
			$InsVentaDirectaDetalle1->VddEntregado = $DatSesionObjeto->Parametro35;
			$InsVentaDirectaDetalle1->VddTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsVentaDirectaDetalle1->VddEliminado = $DatSesionObjeto->Eliminado;				
			$InsVentaDirectaDetalle1->InsMysql = NULL;

			$InsVentaDirecta->VentaDirectaDetalle[] = $InsVentaDirectaDetalle1;
				
			$item++;				
		}		
	}else{
		$Guardar = false;
		$Resultado.='#ERR_VDI_111';
	}	



	//		SesionObjeto-VentaDirectaFoto
	//		Parametro1 = VdfId
	//		Parametro2 =
	//		Parametro3 = VdfArchivo
	//		Parametro4 = VdfEstado
	//		Parametro5 = VdfTiempoCreacion
	//		Parametro6 = VdfTiempoModificacion
	//		Parametro7 = VdfTipo

			$RepSesionObjetos = $_SESSION['InsVentaDirectaFoto'.$Identificador]->MtdObtenerSesionObjetos(false);
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
				
	
	
	if($Guardar){
		if($InsVentaDirecta->MtdEditarVentaDirecta()){		
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_VDI_102';
		} else{
			$InsVentaDirecta->VdiFecha = FncCambiaFechaANormal($InsVentaDirecta->VdiFecha);
			$InsVentaDirecta->VdiOrdenCompraFecha = FncCambiaFechaANormal($InsVentaDirecta->VdiOrdenCompraFecha);
			$Resultado.='#ERR_VDI_102';
		}	
	}else{
		$InsVentaDirecta->VdiFecha = FncCambiaFechaANormal($InsVentaDirecta->VdiFecha);
		$InsVentaDirecta->VdiOrdenCompraFecha = FncCambiaFechaANormal($InsVentaDirecta->VdiOrdenCompraFecha);
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

	$InsVentaDirecta->VdiId = $GET_id;
	$InsVentaDirecta->MtdObtenerVentaDirecta();		

	$_SESSION['SesVdiArchivo'.$Identificador] =	$InsVentaDirecta->VdiArchivo;
	$_SESSION['SesVdiArchivoEntrega'.$Identificador] =	$InsVentaDirecta->VdiArchivoEntrega;
	$_SESSION['SesVdiArchivoEntrega2'.$Identificador] =	$InsVentaDirecta->VdiArchivoEntrega2;

	if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
		$InsVentaDirecta->VdiDescuento = round($InsVentaDirecta->VdiDescuento / $InsVentaDirecta->VdiTipoCambio,2);
	}
	
	
			
	$InsVentaDirecta->VdiNotificar=2;

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
//						Parametro24 = VddCantidadPorLlegar
//						Parametro25 = AmdCantidad
//						Parametro26 = VddEstado
//						Parametro27 = VdiId

//						Parametro28 = VddRemplazo
//						Parametro29 = ProIdPedido
//						Parametro30 = ProCodigoOriginalPedido

//						Parametro31 = PcdBOFecha
//						Parametro32 = PcdBOEstado
//						Parametro33 = VddFechaPorLlegar
//						Parametro34 = AmdEstado
//						Parametro35 = VddEntregado

//deb($DatVentaDirectaDetalle->VddReemplazo);
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
			$DatVentaDirectaDetalle->CrdId,
			NULL,
			$DatVentaDirectaDetalle->VddCantidadPorLlegar,
			$DatVentaDirectaDetalle->AmdCantidad,
			$DatVentaDirectaDetalle->VddEstado,
			$DatVentaDirectaDetalle->VdiId,
			
			$DatVentaDirectaDetalle->VddReemplazo,
			$DatVentaDirectaDetalle->ProIdPedido,
			$DatVentaDirectaDetalle->ProCodigoOriginalPedido,
			
			$DatVentaDirectaDetalle->PcdBOFecha,
			$DatVentaDirectaDetalle->PcdBOEstado,
			
			$DatVentaDirectaDetalle->VddFechaPorLlegar,		
			$DatVentaDirectaDetalle->AmdEstado,
			$DatVentaDirectaDetalle->VddEntregado		
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


	//		SesionObjeto-VentaDirectaFoto
	//		Parametro1 = VdfId
	//		Parametro2 =
	//		Parametro3 = VdfArchivo
	//		Parametro4 = VdfEstado
	//		Parametro5 = VdfTiempoCreacion
	//		Parametro6 = VdfTiempoModificacion
	//		Parametro7 = VdfTipo
		
	if(!empty($InsVentaDirecta->VentaDirectaFoto)){
		foreach($InsVentaDirecta->VentaDirectaFoto as $DatVentaDirectaFoto){
			
			$_SESSION['InsVentaDirectaFoto'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatVentaDirectaFoto->VdfId,
			NULL,
			$DatVentaDirectaFoto->VdfArchivo,			
			$DatVentaDirectaFoto->VdfEstado,
			($DatVentaDirectaFoto->VdfTiempoCreacion),
			($DatVentaDirectaFoto->VdfTiempoModificacion),
			$DatVentaDirectaFoto->VdfTipo
			);
	
		}
	}	
				
				
				
	
}

?>
