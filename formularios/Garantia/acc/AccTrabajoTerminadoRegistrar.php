<?php

function FncCargarFichaAccionDatos(){

	global $InsFichaAccion;
	global $Identificador;

	$InsFichaAccion->MtdObtenerFichaAccion();

	unset($_SESSION['InsGarantiaTarea'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsGarantiaProducto'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsGarantiaMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsGarantiaSuministro'.$InsFichaAccion->MinSigla.$Identificador]);

	$_SESSION['InsGarantiaTarea'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsGarantiaProducto'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsGarantiaMantenimiento'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsGarantiaSuministro'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	
//		SesionObjeto-FichaAccionTarea
//		Parametro1 = FatId
//		Parametro2 =
//		Parametro3 = FatDescripcion
//		Parametro4 = FatVerificar1
//		Parametro5 = FatVerificar2
//		Parametro6 = FatAccion
//		Parametro7 = FatTiempoCreacion
//		Parametro8 = FatTiempoModificacion
//		Parametro9 = FatEstado
//		Parametro10 = FitId

				if(!empty($InsFichaAccion->FichaAccionTarea)){
					foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
						$_SESSION['InsGarantiaTarea'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaAccionTarea->FatId,
						NULL,
						$DatFichaAccionTarea->FatDescripcion,
						$DatFichaAccionTarea->FatVerificar1,
						$DatFichaAccionTarea->FatVerificar2,
						$DatFichaAccionTarea->FatAccion,
						($DatFichaAccionTarea->FatTiempoCreacion),
						($DatFichaAccionTarea->FatTiempoModificacion),
						$DatFichaAccionTarea->FatEstado,
						$DatFichaAccionTarea->FitId);
	
					}
				}			
	
//SesionObjeto-FichaAccionProducto
//Parametro1 = FapId
//Parametro2 = ProId
//Parametro3 = ProNombre
//Parametro4 = FapVerificar1
//Parametro5 = FapVerificar2
//Parametro6 = UmeId
//Parametro7 = FapTiempoCreacion
//Parametro8 = FapTiempoModificacion
//Parametro9 = FapCantidad
//Parametro10 = FapCantidadReal	
//Parametro11 = RtiId
//Parametro12 = UmeNombre
//Parametro13 = UmeIdOrigen
//Parametro14 = FapEstado

				if(!empty($InsFichaAccion->FichaAccionProducto)){
					foreach($InsFichaAccion->FichaAccionProducto as $DatFichaAccionProducto){					
						$_SESSION['InsGarantiaProducto'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaAccionProducto->FapId,
						$DatFichaAccionProducto->ProId,
						$DatFichaAccionProducto->ProNombre,
						$DatFichaAccionProducto->FapVerificar1,
						$DatFichaAccionProducto->FapVerificar2,
						$DatFichaAccionProducto->UmeId,
						($DatFichaAccionProducto->FapTiempoCreacion),
						($DatFichaAccionProducto->FapTiempoModificacion),
						$DatFichaAccionProducto->FapCantidad,
						$DatFichaAccionProducto->FapCantidadReal,
						$DatFichaAccionProducto->RtiId,
						$DatFichaAccionProducto->UmeNombre,
						$DatFichaAccionProducto->UmeIdOrigen,
						$DatFichaAccionProducto->FapEstado);
					}
				}

	/*
	SesionObjeto-FichaAccionMantenimiento
	Parametro1 = FaaId
	Parametro2 = 
	Parametro3 = PmtId
	Parametro4 = FaaAccion
	Parametro5 = FaaTiempoCreacion
	Parametro6 = FaaTiempoModificacion
	Parametro7 = FaaNivel
	Parametro8 = FaaVerificar1
	Parametro9 = FaaVerificar2
	Parametro10 = FaaEstado
	
	Parametro11 = FapId
	Parametro12 = ProId
	Parametro13 = ProNombre
	Parametro14 = FapVerificar1
	Parametro15 = FapVerificar2
	Parametro16 = UmeId
	Parametro17 = FapTiempoCreacion
	Parametro18 = FapTiempoModificacion
	Parametro19 = FapCantidad
	Parametro20 = FapCantidadReal	
	Parametro21 = RtiId
	Parametro22 = UmeNombre
	Parametro23 = UmeIdOrigen
	Parametro24 = FapEstado
	*/
				if(!empty($InsFichaAccion->FichaAccionMantenimiento)){
					foreach($InsFichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){		
					
						$_SESSION['InsGarantiaMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaAccionMantenimiento->FaaId,
						NULL,
						$DatFichaAccionMantenimiento->PmtId,
						$DatFichaAccionMantenimiento->FaaAccion,
						$DatFichaAccionMantenimiento->FaaTiempoCreacion,
						$DatFichaAccionMantenimiento->FapTiempoModificacion,
						($DatFichaAccionMantenimiento->FaaNivel),
						($DatFichaAccionMantenimiento->FaaVerificar1),
						$DatFichaAccionMantenimiento->FaaVerificar2,
						$DatFichaAccionMantenimiento->FaaEstado,

						$DatFichaAccionMantenimiento->FapId,
						$DatFichaAccionMantenimiento->ProId,
						$DatFichaAccionMantenimiento->ProNombre,
						$DatFichaAccionMantenimiento->FapVerificar1,
						$DatFichaAccionMantenimiento->FapVerificar2,
						$DatFichaAccionMantenimiento->UmeId,
						$DatFichaAccionMantenimiento->FapTiempoCreacion,
						$DatFichaAccionMantenimiento->FapTiempoModificacion,
						$DatFichaAccionMantenimiento->FapCantidad,
						$DatFichaAccionMantenimiento->FapCantidadReal,
						$DatFichaAccionMantenimiento->RtiId,
						$DatFichaAccionMantenimiento->UmeNombre,
						$DatFichaAccionMantenimiento->UmeIdOrigen,
						$DatFichaAccionMantenimiento->FapEstado);

					}
				}
				
				
	
//SesionObjeto-FichaAccionSuministro
//Parametro1 = FasId
//Parametro2 = ProId
//Parametro3 = ProNombre
//Parametro4 = FasVerificar1
//Parametro5 = FasVeriticar2
//Parametro6 = UmeId
//Parametro7 = FasTiempoCreacion
//Parametro8 = FasTiempoModificacion
//Parametro9 = FasCantidad
//Parametro10 = FasCantidadReal	
//Parametro11 = RtiId
//Parametro12 = UmeNombre
//Parametro13 = UmeIdOrigen
//Parametro14 = FasEstado

				if(!empty($InsFichaAccion->FichaAccionSuministro)){
					foreach($InsFichaAccion->FichaAccionSuministro as $DatFichaAccionSuministro){					
						$_SESSION['InsGarantiaSuministro'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaAccionSuministro->FasId,
						$DatFichaAccionSuministro->ProId,
						$DatFichaAccionSuministro->ProNombre,
						$DatFichaAccionSuministro->FasVerificar1,
						$DatFichaAccionSuministro->FasVerificar2,
						$DatFichaAccionSuministro->UmeId,
						($DatFichaAccionSuministro->FasTiempoCreacion),
						($DatFichaAccionSuministro->FasTiempoModificacion),
						$DatFichaAccionSuministro->FasCantidad,
						$DatFichaAccionSuministro->FasCantidadReal,
						$DatFichaAccionSuministro->RtiId,
						$DatFichaAccionSuministro->UmeNombre,
						$DatFichaAccionSuministro->UmeIdOrigen,
						$DatFichaAccionSuministro->FasEstado);
					}
				}
				
					
}




//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;	
	
	$validar = 0;	
	
	$InsFichaIngreso->FinId = $_POST['CmpFichaIngresoId'];
	$InsFichaIngreso->CliNombre = $_POST['CmpFichaIngresoCliente'];
	$InsFichaIngreso->EinVIN = $_POST['CmpFichaIngresoVIN'];
	$InsFichaIngreso->EinPlaca = $_POST['CmpFichaIngresoPlaca'];
	$InsFichaIngreso->FinFecha = $_POST['CmpFecha'];
	$InsFichaIngreso->VveId = $_POST['CmpFichaIngresoVehiculoVersion'];
	$InsFichaIngreso->FinMantenimientoKilometraje = $_POST['CmpFichaIngresoMantenimientoKilometraje'];
	$InsFichaIngreso->FinEstado = $_POST['CmpFichaIngresoEstado'];
	
	$InsFichaIngreso->VmaNomvre =($_POST['CmpFichaIngresoMarca']);
	$InsFichaIngreso->VmoNombre =($_POST['CmpFichaIngresoModelo']);
	$InsFichaIngreso->VveNombre =($_POST['CmpFichaIngresoVersion']);
	
	$InsFichaIngreso->FinSalidaObservacion = addslashes($_POST['CmpObservacionSalida']);
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");


		$validar = 0;
		
		if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
			foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
	
				$InsFichaAccion = new ClsFichaAccion();
				$InsFichaAccion->UsuId = $_SESSION['SesionId'];
				$InsFichaAccion->FccId = $_POST['CmpId_'.$DatFichaIngresoModalidad->MinSigla];
				$InsFichaAccion->FccFecha = FncCambiaFechaAMysql($_POST['CmpFecha_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->FccManoObra = eregi_replace(",","",$_POST['CmpFichaAccionManoObra_'.$DatFichaIngresoModalidad->MinSigla]);
				
				$InsFichaAccion->FccObservacion = addslashes($_POST['CmpObservacion_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->FccTiempoModificacion = date("Y-m-d H:i:s");

				$InsFichaAccion->MinSigla = ($_POST['CmpModalidadIngresoSigla_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->MinNombre = ($_POST['CmpModalidadIngresoNombre_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->MinSigla = ($_POST['CmpModalidadIngresoSigla_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->MinId = ($_POST['CmpModalidadIngresoId_'.$DatFichaIngresoModalidad->MinSigla]);

				$InsFichaAccion->FichaAccionTarea = array();
				$InsFichaAccion->FichaAccionProducto = array();

				if(!empty($InsFichaAccion->FccId)){

					if($InsFichaAccion->MtdEditarFichaAccion()){
						$validar++;
						FncCargarFichaAccionDatos();
						$Resultado.='#SAS_TTE_102';
					}else{
						$InsFichaAccion->FccFecha = FncCambiaFechaANormal($InsFichaAccion->FccFecha);
						$Resultado.='#ERR_TTE_102';
					}

					$ArrFichaAccion[] = $InsFichaAccion;

				}
	
				
			}
		}





				if(count($InsFichaIngreso->FichaIngresoModalidad) == $validar){
						
					$Registro = true;
						
					if($POST_FichaIngresoEnviar=="1"){

						$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,75);

					}
					
				}		
		

	
}else{


	FncCargarDatos();


}


function FncCargarDatos(){

	global $InsFichaIngreso;
	global $InsFichaAccion;
	global $Identificador;
	global $GET_Id;
	global $ArrFichaAccion;
	global $ArrModalidadIngresos;

	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
			
			unset($_SESSION['InsGarantiaTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsGarantiaProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsGarantiaMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsGarantiaSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			
			$_SESSION['InsGarantiaTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsGarantiaProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();	
			$_SESSION['InsGarantiaMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();	
			$_SESSION['InsGarantiaSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();	
						
		}
	}

	unset($_SESSION['InsGarantiaHerramienta'.$Identificador]);
			
	$_SESSION['InsGarantiaHerramienta'.$Identificador] = new ClsSesionObjeto();
			
			
	$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,74);

//	if($InsFichaIngreso->FinEstado == 74 or $InsFichaIngreso->FinEstado == 73){
	if($InsFichaIngreso->FinEstado == 73){		
		
		//SesionObjeto-FichaAccionHerramienta
		//Parametro1 = FihId
		//Parametro2 = ProId
		//Parametro3 = ProNombre
		//Parametro4 = 
		//Parametro5 = 
		//Parametro6 = UmeId
		//Parametro7 = FihTiempoCreacion
		//Parametro8 = FihTiempoModificacion
		//Parametro9 = FihCantidad
		//Parametro10 = FihCantidadReal	
		//Parametro11 = RtiId
		//Parametro12 = UmeNombre
		//Parametro13 = UmeIdOrigen
		//Parametro14 = FihEstado
		
						if(!empty($InsFichaIngreso->FichaIngresoHerramienta)){
							foreach($InsFichaIngreso->FichaIngresoHerramienta as $DatFichaIngresoHerramienta){					
								$_SESSION['InsGarantiaHerramienta'.$Identificador]->MtdAgregarSesionObjeto(1,
								$DatFichaIngresoHerramienta->FihId,
								$DatFichaIngresoHerramienta->ProId,
								$DatFichaIngresoHerramienta->ProNombre,
								NULL,
								NULL,
								$DatFichaIngresoHerramienta->UmeId,
								($DatFichaIngresoHerramienta->FihTiempoCreacion),
								($DatFichaIngresoHerramienta->FihTiempoModificacion),
								$DatFichaIngresoHerramienta->FihCantidad,
								$DatFichaIngresoHerramienta->FihCantidadReal,
								$DatFichaIngresoHerramienta->RtiId,
								$DatFichaIngresoHerramienta->UmeNombre,
								$DatFichaIngresoHerramienta->UmeIdOrigen,
								$DatFichaIngresoHerramienta->FihEstado);
							}
						}
						
		
		
			if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
				foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
					
					$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;
		
						//		SesionObjeto-FichaAccionTarea
						//		Parametro1 = FatId
						//		Parametro2 =
						//		Parametro3 = FatDescripcion
						//		Parametro4 = FatVerificar1
						//		Parametro5 = FatVerificar2
						//		Parametro6 = FatAccion
						//		Parametro7 = FatTiempoCreacion
						//		Parametro8 = FatTiempoModificacion
						//		Parametro9 = FatEstado
						//		Parametro10 = FitId
		
						if(!empty($InsFichaAccion->FichaAccionTarea)){
							foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
								$_SESSION['InsGarantiaTarea'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
								$DatFichaAccionTarea->FatId,
								NULL,
								$DatFichaAccionTarea->FatDescripcion,
								$DatFichaAccionTarea->FatVerificar1,
								$DatFichaAccionTarea->FatVerificar2,
								$DatFichaAccionTarea->FatAccion,
								($DatFichaAccionTarea->FatTiempoCreacion),
								($DatFichaAccionTarea->FatTiempoModificacion),
								$DatFichaAccionTarea->FatEstado,
								$DatFichaAccionTarea->FitId);
			
							}
						}			
			
		//SesionObjeto-FichaAccionProducto
		//Parametro1 = FapId
		//Parametro2 = ProId
		//Parametro3 = ProNombre
		//Parametro4 = FapVerificar1
		//Parametro5 = FapVerificar2
		//Parametro6 = UmeId
		//Parametro7 = FapTiempoCreacion
		//Parametro8 = FapTiempoModificacion
		//Parametro9 = FapCantidad
		//Parametro10 = FapCantidadReal	
		//Parametro11 = RtiId
		//Parametro12 = UmeNombre
		//Parametro13 = UmeIdOrigen
		//Parametro14 = FapEstado
						
						if(!empty($InsFichaAccion->FichaAccionProducto)){
							foreach($InsFichaAccion->FichaAccionProducto as $DatFichaAccionProducto){					
								$_SESSION['InsGarantiaProducto'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
								$DatFichaAccionProducto->FapId,
								$DatFichaAccionProducto->ProId,
								$DatFichaAccionProducto->ProNombre,
								$DatFichaAccionProducto->FapVerificar1,
								$DatFichaAccionProducto->FapVerificar2,
								$DatFichaAccionProducto->UmeId,
								($DatFichaAccionProducto->FapTiempoCreacion),
								($DatFichaAccionProducto->FapTiempoModificacion),
								$DatFichaAccionProducto->FapCantidad,
								$DatFichaAccionProducto->FapCantidadReal,
								$DatFichaAccionProducto->RtiId,
								$DatFichaAccionProducto->UmeNombre,
								$DatFichaAccionProducto->UmeIdOrigen,
								$DatFichaAccionProducto->FapEstado);
							}
						}
						
						
		//SesionObjeto-FichaAccionSuministro
		//Parametro1 = FasId
		//Parametro2 = ProId
		//Parametro3 = ProNombre
		//Parametro4 = FasVerificar1
		//Parametro5 = FasVeriticar2
		//Parametro6 = UmeId
		//Parametro7 = FasTiempoCreacion
		//Parametro8 = FasTiempoModificacion
		//Parametro9 = FasCantidad
		//Parametro10 = FasCantidadReal	
		//Parametro11 = RtiId
		//Parametro12 = UmeNombre
		//Parametro13 = UmeIdOrigen
		//Parametro14 = FasEstado
						
						if(!empty($InsFichaAccion->FichaAccionSuministro)){
							foreach($InsFichaAccion->FichaAccionSuministro as $DatFichaAccionSuministro){					
								$_SESSION['InsGarantiaSuministro'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
								$DatFichaAccionSuministro->FasId,
								$DatFichaAccionSuministro->ProId,
								$DatFichaAccionSuministro->ProNombre,
								$DatFichaAccionSuministro->FasVerificar1,
								$DatFichaAccionSuministro->FasVerificar2,
								$DatFichaAccionSuministro->UmeId,
								($DatFichaAccionSuministro->FasTiempoCreacion),
								($DatFichaAccionSuministro->FasTiempoModificacion),
								$DatFichaAccionSuministro->FasCantidad,
								$DatFichaAccionSuministro->FasCantidadReal,
								$DatFichaAccionSuministro->RtiId,
								$DatFichaAccionSuministro->UmeNombre,
								$DatFichaAccionSuministro->UmeIdOrigen,
								$DatFichaAccionSuministro->FasEstado);
							}
						}
						
			/*
			SesionObjeto-FichaAccionMantenimiento
			Parametro1 = FaaId
			Parametro2 = 
			Parametro3 = PmtId
			Parametro4 = FaaAccion
			Parametro5 = FaaTiempoCreacion
			Parametro6 = FaaTiempoModificacion
			Parametro7 = FaaNivel
			Parametro8 = FaaVerificar1
			Parametro9 = FaaVerificar2
			Parametro10 = FaaEstado
			
			Parametro11 = FapId
			Parametro12 = ProId
			Parametro13 = ProNombre
			Parametro14 = FapVerificar1
			Parametro15 = FapVerificar2
			Parametro16 = UmeId
			Parametro17 = FapTiempoCreacion
			Parametro18 = FapTiempoModificacion
			Parametro19 = FapCantidad
			Parametro20 = FapCantidadReal	
			Parametro21 = RtiId
			Parametro22 = UmeNombre
			Parametro23 = UmeIdOrigen
			Parametro24 = FapEstado
			*/
		
						if(!empty($InsFichaAccion->FichaAccionMantenimiento)){
							foreach($InsFichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){		
						
								$_SESSION['InsGarantiaMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
								$DatFichaAccionMantenimiento->FaaId,
								NULL,
								$DatFichaAccionMantenimiento->PmtId,
								$DatFichaAccionMantenimiento->FaaAccion,
								$DatFichaAccionMantenimiento->FaaTiempoCreacion,
								$DatFichaAccionMantenimiento->FapTiempoModificacion,
								($DatFichaAccionMantenimiento->FaaNivel),
								($DatFichaAccionMantenimiento->FaaVerificar1),
								$DatFichaAccionMantenimiento->FaaVerificar2,
								$DatFichaAccionMantenimiento->FaaEstado,
		
								$DatFichaAccionMantenimiento->FapId,
								$DatFichaAccionMantenimiento->ProId,
								$DatFichaAccionMantenimiento->ProNombre,
								$DatFichaAccionMantenimiento->FapVerificar1,
								$DatFichaAccionMantenimiento->FapVerificar2,
								$DatFichaAccionMantenimiento->UmeId,
								$DatFichaAccionMantenimiento->FapTiempoCreacion,
								$DatFichaAccionMantenimiento->FapTiempoModificacion,
								$DatFichaAccionMantenimiento->FapCantidad,
								$DatFichaAccionMantenimiento->FapCantidadReal,
								$DatFichaAccionMantenimiento->RtiId,
								$DatFichaAccionMantenimiento->UmeNombre,
								$DatFichaAccionMantenimiento->UmeIdOrigen,
								$DatFichaAccionMantenimiento->FapEstado);
		
							}
						}				
						
					$ArrFichaAccion[] = $InsFichaAccion;			
						
						
				}
			}
	
			
	}






}

?>

