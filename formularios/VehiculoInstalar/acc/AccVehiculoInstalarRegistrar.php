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
	$InsVehiculoInstalar->VisDescripcion = addslashes($_POST['CmpObservacionInterna']);
	$InsVehiculoInstalar->VisTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoInstalar->VisTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculoInstalar->VisEliminado = 1;

	$InsVehiculoInstalar->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsVehiculoInstalar->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
				
	$InsVehiculoInstalar->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsVehiculoInstalar->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsVehiculoInstalar->VveNombre = $_POST['CmpVehiculoIngresoVersion'];

	$InsVehiculoInstalar->VmaId = $_POST['CmpVehiculoMarcaId'];
	$InsVehiculoInstalar->VmoId = $_POST['CmpVehiculoModeloId'];
	$InsVehiculoInstalar->VveId = $_POST['CmpVehiculoVersionId'];

	$InsVehiculoInstalar->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsVehiculoInstalar->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
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

	$ResVehiculoInstalarDetalle = $_SESSION['InsVehiculoInstalarDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	

		foreach($ResVehiculoInstalarDetalle['Datos'] as $DatSesionObjeto){

			$InsVehiculoInstalarDetalle1 = new ClsVehiculoInstalarDetalle();
			$InsVehiculoInstalarDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsVehiculoInstalarDetalle1->UmeId = $DatSesionObjeto->Parametro10;

			$InsVehiculoInstalarDetalle1->VsdCantidad = $DatSesionObjeto->Parametro5;
			
			$InsVehiculoInstalarDetalle1->VsdEstado = $DatSesionObjeto->Parametro25;
			$InsVehiculoInstalarDetalle1->VsdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsVehiculoInstalarDetalle1->VsdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsVehiculoInstalarDetalle1->VsdEliminado = $DatSesionObjeto->Eliminado;				
			$InsVehiculoInstalarDetalle1->InsMysql = NULL;

			//deb($InsVehiculoInstalarDetalle1->VsdEliminado);
			if($InsVehiculoInstalarDetalle1->VsdEliminado==1){					
				$InsVehiculoInstalar->VehiculoInstalarDetalle[] = $InsVehiculoInstalarDetalle1;		
				
			}
		}		
		
		
		
	if($InsVehiculoInstalar->MtdRegistrarVehiculoInstalar()){
		
		unset($InsVehiculoInstalar);
		$Resultado.='#SAS_VIS_101';
		$Registro = true;
		
	} else{
		
		$InsVehiculoInstalar->VisFecha = FncCambiaFechaANormal($InsVehiculoInstalar->VisFecha,true);
	
		$Resultado.='#ERR_VIS_101';
	}


}else{
	
	FncNuevo();
	
}

function FncNuevo(){
	
	global $InsVehiculoInstalar;
	
	unset($_SESSION['InsVehiculoInstalarDetalle'.$Identificador]);
	
	unset($_SESSION['SesVisFoto'.$Identificador]);
	
	$_SESSION['InsVehiculoInstalarDetalle'.$Identificador] = new ClsSesionObjeto();
	
	
	$InsVehiculoInstalar = new ClsVehiculoInstalar();
	$InsVehiculoInstalar->SucId = $_SESSION['SesionSucursal'];
	$InsVehiculoInstalar->VisFecha = date("d/m/Y");
	$InsVehiculoInstalar->VisFechaProgramada = date("d/m/Y");
	$InsVehiculoInstalar->VisHoraProgramada = date("H:i");
	$InsVehiculoInstalar->PerId = $_SESSION['SesionPersonal'];
	$InsVehiculoInstalar->VisEstado = 3;
	$InsVehiculoInstalar->VisDuracion = 2;
	
}
?>