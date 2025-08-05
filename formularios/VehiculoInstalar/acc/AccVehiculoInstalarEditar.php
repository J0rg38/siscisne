<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsVehiculoInstalar->VisId = $_POST['CmpId'];
	$InsVehiculoInstalar->SucId = $_POST['CmpSucursal'];
	
	$InsVehiculoInstalar->VisFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsVehiculoInstalar->VisFechaProgramada = FncCambiaFechaAMysql($_POST['CmpFechaProgramada']);
	$InsVehiculoInstalar->VisHoraProgramada = $_POST['CmpHoraProgramada'];
	
	$InsVehiculoInstalar->PerId = $_POST['CmpPersonal'];
	$InsVehiculoInstalar->PerIdMecanico = $_POST['CmpPersonalMecanico'];
	$InsVehiculoInstalar->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsVehiculoInstalar->CliId = $_POST['CmpClienteId'];
	
	$InsVehiculoInstalar->VisDescripcion = addslashes($_POST['CmpObservacionInterna']);
	
	$InsVehiculoInstalar->VisDuracion = $_POST['CmpDuracion'];
	$InsVehiculoInstalar->VisKilometrajeMantenimiento = $_POST['CmpVehiculoInstalarPresupuestoMantenimientoKilometraje'];
	
	$InsVehiculoInstalar->VmaNombre = $_POST['CmpVehiculoMarca'];
	$InsVehiculoInstalar->VmoNombre = $_POST['CmpVehiculoModelo'];
	$InsVehiculoInstalar->VveNombre = $_POST['CmpVehiculoVersion'];
	$InsVehiculoInstalar->VisVehiculoPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	
	$InsVehiculoInstalar->VisReferencia = addslashes($_POST['CmpReferencia']);
	$InsVehiculoInstalar->VisObservacionInterna = addslashes($_POST['CmpObservacionInterna']);
	
	$InsVehiculoInstalar->MonId = $_POST['CmpMonedaId'];
	$InsVehiculoInstalar->VisTipoCambio = $_POST['CmpTipoCambio'];
	$InsVehiculoInstalar->VisTotal = eregi_replace(",","",(empty($_POST['CmpTotal'])?0:$_POST['CmpTotal']));
	
	$InsVehiculoInstalar->VisEstado = $_POST['CmpEstado'];
	$InsVehiculoInstalar->VisTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsVehiculoInstalar->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsVehiculoInstalar->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
				
	$InsVehiculoInstalar->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsVehiculoInstalar->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsVehiculoInstalar->VveNombre = $_POST['CmpVehiculoIngresoVersion'];

	$InsVehiculoInstalar->VmaId = $_POST['CmpVehiculoMarcaId'];
	$InsVehiculoInstalar->VmoId = $_POST['CmpVehiculoModeloId'];
	$InsVehiculoInstalar->VveId = $_POST['CmpVehiculoVersionId'];

	$InsVehiculoInstalar->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsVehiculoInstalar->CliNombreCompleto = $_POST['CmpClienteNombreCompleto'];
	$InsVehiculoInstalar->CliNombre = $_POST['CmpClienteNombre'];
	$InsVehiculoInstalar->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsVehiculoInstalar->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	settype($InsVehiculoInstalar->VisTipoCambio,"float");
		
//	if($InsVehiculoInstalar->MonId<>$EmpresaMonedaId){
//		if(empty($InsVehiculoInstalar->VisTipoCambio)){
//			$Guardar = false;
//			$Resultado.='#ERR_VIS_600';
//		}
//	}
//
//	if( $InsVehiculoInstalar->MonId<>$EmpresaMonedaId ){
//		$InsVehiculoInstalar->VisTotal = $InsVehiculoInstalar->VisTotal * $InsVehiculoInstalar->VisTipoCambio;
//	}else{
//		$InsVehiculoInstalar->VisTotal = $InsVehiculoInstalar->VisTotal;
//	}
//	
//	
	
	$ResVehiculoInstalarDetalle = $_SESSION['InsVehiculoInstalarDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

//SesionObjeto-VehiculoInstalarDetalle
//Parametro1 = VsdId
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
//Parametro20 = VsdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
	

	//if(!empty($ResVehiculoInstalarDetalle['Datos'])){

		
		
		foreach($ResVehiculoInstalarDetalle['Datos'] as $DatSesionObjeto){
				
			$InsVehiculoInstalarDetalle1 = new ClsVehiculoInstalarDetalle();
			$InsVehiculoInstalarDetalle1->VsdId = $DatSesionObjeto->Parametro1;
			$InsVehiculoInstalarDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsVehiculoInstalarDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			
			$InsVehiculoInstalarDetalle1->VsdCantidad = $DatSesionObjeto->Parametro5;
		
			$InsVehiculoInstalarDetalle1->VsdEstado = $DatSesionObjeto->Parametro25;
			$InsVehiculoInstalarDetalle1->VsdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsVehiculoInstalarDetalle1->VsdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsVehiculoInstalarDetalle1->VsdEliminado = $DatSesionObjeto->Eliminado;				
			$InsVehiculoInstalarDetalle1->InsMysql = NULL;

			$InsVehiculoInstalar->VehiculoInstalarDetalle[] = $InsVehiculoInstalarDetalle1;

			if($InsVehiculoInstalarDetalle1->VsdEliminado==1){
				
			}			

		}		
	
	
	
	
	if($InsVehiculoInstalar->MtdEditarVehiculoInstalar()){	
			$Registro = true;				
			$Resultado.='#SAS_VIS_102';
			FncCargarDatos();
	}else{			
	
		$Resultado.='#ERR_VIS_102';		
	}			
		
	$InsVehiculoInstalar->VisFecha = FncCambiaFechaANormal($InsVehiculoInstalar->VisFecha,true);
	
	//if($InsVehiculoInstalar->MonId<>$EmpresaMonedaId ){
//		$InsVehiculoInstalar->VisTotal = round($InsVehiculoInstalar->VisTotal / $InsVehiculoInstalar->VisTipoCambio,3);
//	}

}else{
	
	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsVehiculoInstalar;
	global $Identificador;
	
	unset($_SESSION['InsVehiculoInstalarDetalle'.$Identificador]);
	

	$_SESSION['InsVehiculoInstalarDetalle'.$Identificador] = new ClsSesionObjeto();
	
	
	$InsVehiculoInstalar->VisId = $GET_id;
	$InsVehiculoInstalar->MtdObtenerVehiculoInstalar();	
	
	//if($InsVehiculoInstalar->MonId<>$EmpresaMonedaId ){
//		$InsVehiculoInstalar->VisTotal = round($InsVehiculoInstalar->VisTotal / $InsVehiculoInstalar->VisTipoCambio,3);
//	}

	
		$_SESSION['SesVisFoto'.$Identificador] =	$InsVehiculoInstalar->VisFoto;

//
//	deb("");
//		deb("");
//			deb("");
//	deb($InsVehiculoInstalar->VehiculoInstalarDetalle);
//	
//	
	
	
	
	if(!empty($InsVehiculoInstalar->VehiculoInstalarDetalle)){
		foreach($InsVehiculoInstalar->VehiculoInstalarDetalle as $DatVehiculoInstalarDetalle){

			if($InsVehiculoInstalar->MonId<>$EmpresaMonedaId and (!empty($InsVehiculoInstalar->VisTipoCambio) )){
				$DatVehiculoInstalarDetalle->VsdImporte = round($DatVehiculoInstalarDetalle->VsdImporte / $InsVehiculoInstalar->VisTipoCambio,3);
				$DatVehiculoInstalarDetalle->VsdCosto = round($DatVehiculoInstalarDetalle->VsdCosto  / $InsVehiculoInstalar->VisTipoCambio,3);
				$DatVehiculoInstalarDetalle->VsdCostoAnterior = round($DatVehiculoInstalarDetalle->VsdCostoAnterior  / $InsVehiculoInstalar->VisTipoCambio,3);
				$DatVehiculoInstalarDetalle->VsdCostoTotal = round($DatVehiculoInstalarDetalle->VsdCostoTotal  / $InsVehiculoInstalar->VisTipoCambio,3);
				$DatVehiculoInstalarDetalle->VsdUtilidad = round($DatVehiculoInstalarDetalle->VsdUtilidad  / $InsVehiculoInstalar->VisTipoCambio,3);
			}

//SesionObjeto-VehiculoInstalarDetalle
//Parametro1 = VsdId
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
//Parametro20 = VsdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
//Parametro25 = VsdEstado
				
			
			$_SESSION['InsVehiculoInstalarDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatVehiculoInstalarDetalle->VsdId,
			$DatVehiculoInstalarDetalle->ProId,
			$DatVehiculoInstalarDetalle->ProNombre,
			$DatVehiculoInstalarDetalle->VsdCosto,
			$DatVehiculoInstalarDetalle->VsdCantidad,
			$DatVehiculoInstalarDetalle->VsdImporte,
			($DatVehiculoInstalarDetalle->VsdTiempoCreacion),
			($DatVehiculoInstalarDetalle->VsdTiempoModificacion),
			$DatVehiculoInstalarDetalle->UmeNombre,
			$DatVehiculoInstalarDetalle->UmeId,
			$DatVehiculoInstalarDetalle->RtiId,
			$DatVehiculoInstalarDetalle->VsdCantidadReal,			
			$DatVehiculoInstalarDetalle->VsdUtilidad,
			$DatVehiculoInstalarDetalle->VsdUtilidadPorcentaje,
			$DatVehiculoInstalarDetalle->VsdCostoAnterior,
			$DatVehiculoInstalarDetalle->VsdCostoTotal,
			$DatVehiculoInstalarDetalle->ProCodigoOriginal,
			$DatVehiculoInstalarDetalle->ProCodigoAlternativo,
			$DatVehiculoInstalarDetalle->UmeIdOrigen,
			NULL,
			$DatVehiculoInstalarDetalle->PcdId,
			$DatVehiculoInstalarDetalle->PcoId,
			$DatVehiculoInstalarDetalle->PcoFecha,
			$DatVehiculoInstalarDetalle->CliNombreCompleto,
			$DatVehiculoInstalarDetalle->VsdEstado);

		}
	}
	
}
?>