<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsTrasladoAlmacenEntrada->UsuId = $_SESSION['SesionId'];		
	$InsTrasladoAlmacenEntrada->TaeId = $_POST['CmpId'];
	$InsTrasladoAlmacenEntrada->PrvId = $_POST['CmpProveedorId'];
	$InsTrasladoAlmacenEntrada->CtiId = $_POST['CmpComprobanteTipo'];	
	$InsTrasladoAlmacenEntrada->TopId = $_POST['CmpTipoOperacion'];	
	$InsTrasladoAlmacenEntrada->OcoId = $_POST['CmpOrdenCompra'];	
	$InsTrasladoAlmacenEntrada->AlmId = $_POST['CmpAlmacen'];	

//	$InsTrasladoAlmacenEntrada->TaePorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	$InsTrasladoAlmacenEntrada->TaePorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
	$InsTrasladoAlmacenEntrada->TaeFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsTrasladoAlmacenEntrada->TaeObservacion = addslashes($_POST['CmpObservacion']);
	$InsTrasladoAlmacenEntrada->TaeDocumentoOrigen = $_POST['CmpDocumentoOrigen'];
	
	$InsTrasladoAlmacenEntrada->TaeComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsTrasladoAlmacenEntrada->TaeComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsTrasladoAlmacenEntrada->TaeComprobanteNumero = $InsTrasladoAlmacenEntrada->TaeComprobanteNumeroSerie."-".$InsTrasladoAlmacenEntrada->TaeComprobanteNumeroNumero;
	
	$InsTrasladoAlmacenEntrada->TaeComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);	
	
	$InsTrasladoAlmacenEntrada->MonId = $EmpresaMonedaId;

	$InsTrasladoAlmacenEntrada->TaeTipo = 1;
	$InsTrasladoAlmacenEntrada->TaeSubTipo = 8	;
	$InsTrasladoAlmacenEntrada->TaeEstado = $_POST['CmpEstado'];
	
	$InsTrasladoAlmacenEntrada->TaeTiempoModificacion = date("Y-m-d H:i:s");
	$InsTrasladoAlmacenEntrada->TaeEliminado = 1;

	$InsTrasladoAlmacenEntrada->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsTrasladoAlmacenEntrada->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsTrasladoAlmacenEntrada->PrvNombreCompleto = $_POST['CmpProveedorNombre'];
	$InsTrasladoAlmacenEntrada->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsTrasladoAlmacenEntrada->TaeFoto = $_SESSION['SesAmoFoto'.$Identificador];


	$InsTrasladoAlmacenEntrada->TrasladoAlmacenEntradaDetalle = array();
	

	if(empty($InsTrasladoAlmacenEntrada->AlmId)){
		$Guardar = false;
		$Resultado.='#ERR_TAE_602';
	}		

	

	$ResTrasladoAlmacenEntradaDetalle = $_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

//SesionObjeto-TrasladoAlmacenEntradaDetalle
//Parametro1 = AmdId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = AmdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
//Parametro25 = AmdEstado
//Parametro26 = AmdUbicacion//SesionObjeto-TrasladoAlmacenEntradaDetalle
//Parametro1 = AmdId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = AmdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
//Parametro25 = AmdEstado
//Parametro26 = AmdUbicacion

		foreach($ResTrasladoAlmacenEntradaDetalle['Datos'] as $DatSesionObjeto){
				

			$InsTrasladoAlmacenEntradaDetalle1 = new ClsTrasladoAlmacenEntradaDetalle();
			$InsTrasladoAlmacenEntradaDetalle1->TedId = $DatSesionObjeto->Parametro1;
			$InsTrasladoAlmacenEntradaDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsTrasladoAlmacenEntradaDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			
						$InsTrasladoAlmacenEntradaDetalle1->TedIdOrigen = $DatSesionObjeto->Parametro20;
			
			$InsTrasladoAlmacenEntradaDetalle1->TedCantidad = $DatSesionObjeto->Parametro5;
			$InsTrasladoAlmacenEntradaDetalle1->TedCantidadReal = $DatSesionObjeto->Parametro12;
			$InsTrasladoAlmacenEntradaDetalle1->TedUbicacion = $DatSesionObjeto->Parametro26;
			
			$InsTrasladoAlmacenEntradaDetalle1->TedEstado = $DatSesionObjeto->Parametro25;
			$InsTrasladoAlmacenEntradaDetalle1->TedTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsTrasladoAlmacenEntradaDetalle1->TedTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsTrasladoAlmacenEntradaDetalle1->TedEliminado = $DatSesionObjeto->Eliminado;				
			$InsTrasladoAlmacenEntradaDetalle1->InsMysql = NULL;

			
			$InsTrasladoAlmacenEntrada->TrasladoAlmacenEntradaDetalle[] = $InsTrasladoAlmacenEntradaDetalle1;

			if($InsTrasladoAlmacenEntradaDetalle1->TedEliminado==1){
				$InsTrasladoAlmacenEntrada->TaeSubTotal += $InsTrasladoAlmacenEntradaDetalle1->TedImporte;
			}			

		}		
	
	
	if($Guardar){
		
		if($InsTrasladoAlmacenEntrada->MtdEditarTrasladoAlmacenEntrada()){		
		
			FncCargarDatos();
			$Resultado.='#SAS_TAE_102';
			$Edito = true;

		} else{
	
			$InsTrasladoAlmacenEntrada->TaeFecha = FncCambiaFechaANormal($InsTrasladoAlmacenEntrada->TaeFecha);
			$InsTrasladoAlmacenEntrada->TaeComprobanteFecha = FncCambiaFechaANormal($InsTrasladoAlmacenEntrada->TaeComprobanteFecha,true);

			$Resultado.='#ERR_TAE_102';
		}
		
	}else{
		
		$InsTrasladoAlmacenEntrada->TaeFecha = FncCambiaFechaANormal($InsTrasladoAlmacenEntrada->TaeFecha);
		$InsTrasladoAlmacenEntrada->TaeComprobanteFecha = FncCambiaFechaANormal($InsTrasladoAlmacenEntrada->TaeComprobanteFecha,true);

	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){

	global $GET_id;
	global $Identificador;
	global $InsTrasladoAlmacenEntrada;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador]);
	unset($_SESSION['SesAmoFoto'.$Identificador]);

	$_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsTrasladoAlmacenEntrada->TaeId = $GET_id;
	$InsTrasladoAlmacenEntrada->MtdObtenerTrasladoAlmacenEntrada();		


	$_SESSION['SesAmoFoto'.$Identificador] =	$InsTrasladoAlmacenEntrada->TaeFoto;

	if(!empty($InsTrasladoAlmacenEntrada->TrasladoAlmacenEntradaDetalle)){
		foreach($InsTrasladoAlmacenEntrada->TrasladoAlmacenEntradaDetalle as $DatTrasladoAlmacenEntradaDetalle){

			//SesionObjeto-TrasladoAlmacenEntradaDetalle
//Parametro1 = AmdId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = AmdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
//Parametro25 = AmdEstado
//Parametro26 = AmdUbicacion
				
			
			$_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatTrasladoAlmacenEntradaDetalle->TedId,
			$DatTrasladoAlmacenEntradaDetalle->ProId,
			$DatTrasladoAlmacenEntradaDetalle->ProNombre,
			$DatTrasladoAlmacenEntradaDetalle->TedCosto,
			$DatTrasladoAlmacenEntradaDetalle->TedCantidad,
			$DatTrasladoAlmacenEntradaDetalle->TedImporte,
			($DatTrasladoAlmacenEntradaDetalle->TedTiempoCreacion),
			($DatTrasladoAlmacenEntradaDetalle->TedTiempoModificacion),
			$DatTrasladoAlmacenEntradaDetalle->UmeNombre,
			$DatTrasladoAlmacenEntradaDetalle->UmeId,
			$DatTrasladoAlmacenEntradaDetalle->RtiId,
			$DatTrasladoAlmacenEntradaDetalle->TedCantidadReal,			
			$DatTrasladoAlmacenEntradaDetalle->TedUtilidad,
			$DatTrasladoAlmacenEntradaDetalle->TedUtilidadPorcentaje,
			$DatTrasladoAlmacenEntradaDetalle->TedCostoAnterior,
			$DatTrasladoAlmacenEntradaDetalle->TedCostoTotal,
			$DatTrasladoAlmacenEntradaDetalle->ProCodigoOriginal,
			$DatTrasladoAlmacenEntradaDetalle->ProCodigoAlternativo,
			$DatTrasladoAlmacenEntradaDetalle->UmeIdOrigen,
			$DatTrasladoAlmacenEntradaDetalle->TedIdOrigen,
			$DatTrasladoAlmacenEntradaDetalle->PcdId,
			$DatTrasladoAlmacenEntradaDetalle->PcoId,
			$DatTrasladoAlmacenEntradaDetalle->PcoFecha,
			$DatTrasladoAlmacenEntradaDetalle->CliNombreCompleto,
			$DatTrasladoAlmacenEntradaDetalle->TedEstado,
			$DatTrasladoAlmacenEntradaDetalle->TedUbicacion);

		}
	}
	
	
}
?>