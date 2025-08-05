<?php

function FncCargarFichaAccionDatos(){

	global $InsFichaIngreso;
	global $InsFichaAccion;
	global $Identificador;
	global $EmpresaMonedaId;

	$InsFichaAccion->MtdObtenerFichaAccion();

	unset($_SESSION['InsFichaAccionTarea'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsFichaAccionProducto'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsFichaAccionMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsFichaAccionSuministro'.$InsFichaAccion->MinSigla.$Identificador]);

	$_SESSION['InsFichaAccionTarea'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFichaAccionProducto'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFichaAccionMantenimiento'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFichaAccionSuministro'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();

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

//		Parametro11 = FatEspecificacion
//		Parametro12 = FatCosto

				if(!empty($InsFichaAccion->FichaAccionTarea)){
					foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
						//deb($InsFichaIngreso->MonId." - ".$EmpresaMonedaId);						
						if($InsFichaIngreso->MonId<>$EmpresaMonedaId){
							$DatFichaAccionTarea->FatCosto = round($DatFichaAccionTarea->FatCosto / $InsFichaIngreso->FinTipoCambio,2);
						}
						
						$_SESSION['InsFichaAccionTarea'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaAccionTarea->FatId,
						NULL,
						$DatFichaAccionTarea->FatDescripcion,
						$DatFichaAccionTarea->FatVerificar1,
						$DatFichaAccionTarea->FatVerificar2,
						$DatFichaAccionTarea->FatAccion,
						($DatFichaAccionTarea->FatTiempoCreacion),
						($DatFichaAccionTarea->FatTiempoModificacion),
						$DatFichaAccionTarea->FatEstado,
						$DatFichaAccionTarea->FitId,

						$DatFichaAccionTarea->FatEspecificacion,
						$DatFichaAccionTarea->FatCosto);
	
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
				//Parametro15 = Tipo
				//Parametro16 = FapAccion

				if(!empty($InsFichaAccion->FichaAccionProducto)){
					foreach($InsFichaAccion->FichaAccionProducto as $DatFichaAccionProducto){					
					
						$_SESSION['InsFichaAccionProducto'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
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
						$DatFichaAccionProducto->FapEstado,
						NULL,
						$DatFichaAccionProducto->FapAccion,
						$DatFichaAccionProducto->ProCodigoOriginal,
						$DatFichaAccionProducto->ProCodigoAlternativo);
						
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
	
//deb($InsFichaAccion->FichaAccionMantenimiento);
				if(!empty($InsFichaAccion->FichaAccionMantenimiento)){
					foreach($InsFichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){		
					
						$_SESSION['InsFichaAccionMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
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

						NULL,
						$DatFichaAccionMantenimiento->ProId,
						$DatFichaAccionMantenimiento->ProNombre,
						0,
						0,
						$DatFichaAccionMantenimiento->UmeId,
						NULL,
						NULL,
						$DatFichaAccionMantenimiento->FaaCantidad,
						NULL,
						$DatFichaAccionMantenimiento->RtiId,
						$DatFichaAccionMantenimiento->UmeNombre,
						$DatFichaAccionMantenimiento->UmeIdOrigen,
						NULL,
						NULL,
						$DatFichaAccionMantenimiento->ProCodigoOriginal
						);
						
						/*$_SESSION['InsFichaAccionMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
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
						$DatFichaAccionMantenimiento->FapEstado,
						NULL,
						$DatFichaAccionMantenimiento->ProCodigoOriginal);*/

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
									
						$_SESSION['InsFichaAccionSuministro'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
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


// aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
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

	$InsFichaIngreso->MonId = $_POST['CmpMonedaId'];
	$InsFichaIngreso->FinTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsFichaIngreso->VveId = $_POST['CmpFichaIngresoVehiculoVersion'];
	$InsFichaIngreso->FinMantenimientoKilometraje = $_POST['CmpFichaIngresoMantenimientoKilometraje'];
	//$InsFichaIngreso->FinEstado = $_POST['CmpFichaIngresoEstado'];
	
	$InsFichaIngreso->PmaId = $_POST['CmpPlanMantenimientoId'];
	
	
	
	$InsFichaIngreso->VmaId =($_POST['CmpVehiculoIngresoMarcaId']);
	$InsFichaIngreso->VmoId =($_POST['CmpVehiculoIngresoModeloId']);
	//$InsFichaIngreso->VveId =($_POST['CmpVehiculoIngresoVersionId']);
	
	$InsFichaIngreso->VmaNomvre =($_POST['CmpFichaIngresoMarca']);
	$InsFichaIngreso->VmoNombre =($_POST['CmpFichaIngresoModelo']);
	$InsFichaIngreso->VveNombre =($_POST['CmpFichaIngresoVersion']);
	
	$InsFichaIngreso->FinFotoVIN =($_SESSION['SesFinFotoVIN'.$Identificador]);
	$InsFichaIngreso->FinFotoFrontal =($_SESSION['SesFinFotoFrontal'.$Identificador]);
	$InsFichaIngreso->FinFotoCupon =($_SESSION['SesFinFotoCupon'.$Identificador]);
	$InsFichaIngreso->FinFotoMantenimiento =($_SESSION['SesFinFotoMantenimiento'.$Identificador]);	
	
	$InsFichaIngreso->FinSalidaObservacion = addslashes($_POST['CmpObservacionSalida']);	
	$InsFichaIngreso->FinSalidaObservacionInterna = addslashes($_POST['CmpObservacionSalidaInterna']);
	$InsFichaIngreso->FinTipo = ($_POST['CmpFichaIngresoTipo']);
	$InsFichaIngreso->FinMantenimientoKilometraje = ($_POST['CmpFichaIngresoMantenimientoKilometraje']);
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
		
//	$InsFichaIngreso->MtdEditarFichaIngresoMantenimientoKilometraje();
	
	$InsFichaIngreso->MtdObtenerFichaIngresoEstado();
	
	/*if(
	$InsFichaIngreso->FinEstado==4  
	|| $InsFichaIngreso->FinEstado==5 
	|| $InsFichaIngreso->FinEstado==6 
	|| $InsFichaIngreso->FinEstado == 72 
	|| $InsFichaIngreso->FinEstado == 73
	){*/
	
		if(!empty($_POST['CmpFichaIngresoTrabajoConcluido'])){
	
			if(empty($_POST['CmpFichaIngresoTiempoTrabajoConcluido'])){
	
				$InsFichaIngreso->FinTiempoTallerConcluido = date("Y-m-d H:i:s");	
				$InsFichaIngreso->MtdEditarFichaIngresoTallerConcluido();		
	
			}
	
		}else{
	
			$InsFichaIngreso->FinTiempoTallerConcluido = NULL;	
			$InsFichaIngreso->MtdEditarFichaIngresoTallerConcluido();		
	
		}
		
	/*}*/
	
	
	
	
	
	if($InsFichaIngreso->FinTipo == 2){
	
	//$InsFichaIngreso->FichaIngresoModalidad = array();
	
		$RepSesionObjetos = $_SESSION['InsPreEntregaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
		$ArrSesionObjetos = $RepSesionObjetos['Datos'];
	
		if(!empty($ArrSesionObjetos)){
			foreach($ArrSesionObjetos as $DatSesionObjeto){
	
					
//					SesionObjeto-PreEntregaDetalle
//					Parametro1 = RedId
//					Parametro2 = 
//					Parametro3 = PetId
//					Parametro4 = RedAccion
//					Parametro5 = RedTiempoCreacion
//					Parametro6 = RedTiempoModificacion
//					

					$InsPreEntregaDetalle1 = new ClsPreEntregaDetalle();
					$InsPreEntregaDetalle1->RedId = $_POST['CmpPreEntregaDetalleId_'.$DatSesionObjeto->Parametro3];
					$InsPreEntregaDetalle1->PetId = $_POST['CmpPreEntregaTareaId_'.$DatSesionObjeto->Parametro3];	
					$InsPreEntregaDetalle1->RedAccion = $_POST['CmpPreEntregaDetalleAccion_'.$DatSesionObjeto->Parametro3];
					$InsPreEntregaDetalle1->RedTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro5);
					$InsPreEntregaDetalle1->RedTiempoModificacion = date("Y-m-d H:i:s");
	
					$InsPreEntregaDetalle1->InsMysql = NULL;
					
					$InsFichaIngreso->PreEntregaDetalle[] = $InsPreEntregaDetalle1;	
	
					$_SESSION['InsPreEntregaDetalle'.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
					$InsPreEntregaDetalle1->RedId,
					NULL,
					$InsPreEntregaDetalle1->PetId,
					$InsPreEntregaDetalle1->RedAccion,
					FncCambiaFechaANormal($InsPreEntregaDetalle1->RedTiempoCreacion),
					FncCambiaFechaANormal($InsPreEntregaDetalle1->RedTiempoModificacion)
					);
					
				}
							
		}else{
			
			unset($_SESSION['InsPreEntregaDetalle'.$Identificador]);
			$_SESSION['InsPreEntregaDetalle'.$Identificador] = new ClsSesionObjeto();	
	
			$RepPreEntregaSeccion = $InsPreEntregaSeccion->MtdObtenerPreEntregaSecciones(NULL,NULL,"PesId","ASC",NULL);
			$ArrPreEntregaSecciones = $RepPreEntregaSeccion['Datos'];
	
				foreach($ArrPreEntregaSecciones as $DatPreEntregaSeccion){
				
					
					$ResPreEntregaTarea = $InsPreEntregaTarea->MtdObtenerPreEntregaTareas(NULL,NULL,'PetNombre','ASC',NULL,$DatPreEntregaSeccion->PesId);
					$ArrPreEntregaTareas = $ResPreEntregaTarea['Datos'];
	
	
					foreach($ArrPreEntregaTareas as $DatPreEntregaTarea){
	
						
						$InsPreEntregaDetalle1 = new ClsPreEntregaDetalle();
						$InsPreEntregaDetalle1->RedId = $_POST['CmpPreEntregaDetalleId_'.$DatPreEntregaTarea->PetId];								
						$InsPreEntregaDetalle1->PetId = $DatPreEntregaTarea->PetId;
						$InsPreEntregaDetalle1->PetId = $_POST['CmpPreEntregaTareaId_'.$DatPreEntregaTarea->PetId];								
						
						$InsPreEntregaDetalle1->RedAccion = $_POST['CmpPreEntregaDetalleAccion_'.$DatPreEntregaTarea->PetId];	
						$InsPreEntregaDetalle1->RedTiempoCreacion = date("Y-m-d H:i:s");
						$InsPreEntregaDetalle1->RedTiempoModificacion = date("Y-m-d H:i:s");
						
						$InsPreEntregaDetalle1->InsMysql = NULL;
						
						$InsFichaIngreso->PreEntregaDetalle[] = $InsPreEntregaDetalle1;	
						
						
							$_SESSION['InsPreEntregaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							$InsPreEntregaDetalle1->RedId,
							NULL,
							$InsPreEntregaDetalle1->PetId,
							$InsPreEntregaDetalle1->RedAccion,
							FncCambiaFechaANormal($InsPreEntregaDetalle1->RedTiempoCreacion),
							FncCambiaFechaANormal($InsPreEntregaDetalle1->RedTiempoModificacion)
							);
					}
					
				}
	
			
		}
		
		
		$InsFichaIngreso->MtdEditarFichaIngresoPreEntregaDetalle(false);
	
	}

	
	
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
	
				$RepSesionObjetos = $_SESSION['InsFichaAccionHerramienta'.$Identificador]->MtdObtenerSesionObjetos(false);
				$ArrSesionObjetos = $RepSesionObjetos['Datos'];
				
//				deb($ArrSesionObjetos );
//				
				if(!empty($ArrSesionObjetos)){
					foreach($ArrSesionObjetos as $DatSesionObjeto){

							$InsFichaIngresoHerramienta1 = new ClsFichaAccionProducto();
							$InsFichaIngresoHerramienta1->FihId = $DatSesionObjeto->Parametro1;
							$InsFichaIngresoHerramienta1->ProId = $DatSesionObjeto->Parametro2;

							$InsFichaIngresoHerramienta1->UmeId = $DatSesionObjeto->Parametro6;
							$InsFichaIngresoHerramienta1->FihCantidad = $DatSesionObjeto->Parametro9;	
							$InsFichaIngresoHerramienta1->FihCantidadReal = $DatSesionObjeto->Parametro10;

							$InsFichaIngresoHerramienta1->FihEstado = $DatSesionObjeto->Parametro14;
							$InsFichaIngresoHerramienta1->FihTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
							$InsFichaIngresoHerramienta1->FihTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
							$InsFichaIngresoHerramienta1->FihEliminado = 1;				
							
							$InsFichaIngresoHerramienta1->ProNombre = $DatSesionObjeto->Parametro3;
							$InsFichaIngresoHerramienta1->RtiId= $DatSesionObjeto->Parametro11;
							$InsFichaIngresoHerramienta1->UmeNombre= $DatSesionObjeto->Parametro12;
							$InsFichaIngresoHerramienta1->UmeIdOrigen= $DatSesionObjeto->Parametro13;
							
							$InsFichaIngresoHerramienta1->InsMysql = NULL;
							
							$InsFichaIngreso->FichaIngresoHerramienta[] = $InsFichaIngresoHerramienta1;	

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

							$_SESSION['InsFichaAccionHerramienta'.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
							$InsFichaIngresoHerramienta1->FihId,
							$InsFichaIngresoHerramienta1->ProId,
							$InsFichaIngresoHerramienta1->ProNombre,
							NULL,
							NULL,
							$InsFichaIngresoHerramienta1->UmeId,
							FncCambiaFechaANormal($InsFichaIngresoHerramienta1->FihTiempoCreacion),
							FncCambiaFechaANormal($InsFichaIngresoHerramienta1->FihTiempoModificacion),
							$InsFichaIngresoHerramienta1->FihCantidad,
							$InsFichaIngresoHerramienta1->FihCantidadReal,
							$InsFichaIngresoHerramienta1->RtiId,
							$InsFichaIngresoHerramienta1->UmeNombre,
							$InsFichaIngresoHerramienta1->UmeIdOrigen,
							$InsFichaIngresoHerramienta1->FihEstado);
					}
				}
				

		//deb($InsFichaIngreso->FichaIngresoModalidad);
		
	//	exit();
		
		if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
			foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
				

				$InsFichaAccion = new ClsFichaAccion();
				$InsFichaAccion->UsuId = $_SESSION['SesionId'];
				$InsFichaAccion->FccId = $_POST['CmpId_'.$DatFichaIngresoModalidad->MinSigla];
				$InsFichaAccion->FimId = $_POST['CmpFichaIngresoModalidadId_'.$DatFichaIngresoModalidad->MinSigla];
				
				$InsFichaAccion->FccFecha = FncCambiaFechaAMysql($_POST['CmpFecha_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->FccManoObra = 0;
				$InsFichaAccion->FccDescuento = 0;
				$InsFichaAccion->FccObservacion = addslashes($_POST['CmpObservacion_'.$DatFichaIngresoModalidad->MinSigla]);
				
				$InsFichaAccion->FccPedido = addslashes($_POST['CmpFichaAccionPedido_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->FccPedido2 = addslashes($_POST['CmpFichaAccionPedido_'.$DatFichaIngresoModalidad->MinSigla.'2']);
				
				$InsFichaAccion->FccCausa = addslashes($_POST['CmpFichaAccionCausa_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->FccSolucion = addslashes($_POST['CmpFichaAccionSolucion_'.$DatFichaIngresoModalidad->MinSigla]);

				$InsFichaAccion->FccComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);
				$InsFichaAccion->FccComprobanteNumero = addslashes($_POST['CmpComprobanteNumero']);


				$InsFichaAccion->FccEstado = 1;
				$InsFichaAccion->FccTiempoCreacion = date("Y-m-d H:i:s");
				$InsFichaAccion->FccTiempoModificacion = date("Y-m-d H:i:s");
	
				$InsFichaAccion->MinSigla = ($_POST['CmpModalidadIngresoSigla_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->MinNombre = ($_POST['CmpModalidadIngresoNombre_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->MinSigla = ($_POST['CmpModalidadIngresoSigla_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->MinId = ($_POST['CmpModalidadIngresoId_'.$DatFichaIngresoModalidad->MinSigla]);

				$InsFichaAccion->FichaAccionTarea = array();
				$InsFichaAccion->FichaAccionProducto = array();
				$InsFichaAccion->FichaAccionSalidaExterna = array();
				

				if(!empty($DatFichaIngresoModalidad->MinSigla)){//AUX
							
					if($DatFichaIngresoModalidad->MinSigla == "PP"){
					
					//		SesionObjeto-FichaAccionSalidaExterna
					//		Parametro1 = FsxId
					//		Parametro2 =
					//		Parametro3 = PrvId
					//		Parametro4 = FsxFechaSalida
					//		Parametro5 = FsxFechaFinalizacion
					//		Parametro6 = FsxEstado
					//		Parametro7 = FsxTiempoCreacion
					//		Parametro8 = FsxTiempoModificacion
	
						$InsFichaAccionSalidaExterna1 = new ClsFichaAccionSalidaExterna();
						$InsFichaAccionSalidaExterna1->FsxId = $_POST['CmpFichaAccionSalidaExternaId'];
						$InsFichaAccionSalidaExterna1->TdoId = $_POST['CmpTipoDocumentoId'];
		
						$InsFichaAccionSalidaExterna1->PrvId = $_POST['CmpProveedorId'];
						$InsFichaAccionSalidaExterna1->PrvNombreCompleto = $_POST['CmpProveedorNombre'];
						$InsFichaAccionSalidaExterna1->PrvNombre = $_POST['CmpProveedorNombre'];
						$InsFichaAccionSalidaExterna1->PrvApellidoPaterno = $_POST['CmpProveedorApellidoPaterno'];
						$InsFichaAccionSalidaExterna1->PrvApellidoMaterno = $_POST['CmpProveedorApellidoMaterno'];
						$InsFichaAccionSalidaExterna1->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
		
						$InsFichaAccionSalidaExterna1->FsxFechaSalida = FncCambiaFechaAMysql($_POST['CmpSalidaExternaFechaSalida'],true);
						$InsFichaAccionSalidaExterna1->FsxFechaFinalizacion = FncCambiaFechaAMysql($_POST['CmpSalidaExternaFechaFinalizacion'],true);
						$InsFichaAccionSalidaExterna1->FsxEstado = 1;
						$InsFichaAccionSalidaExterna1->FsxTiempoCreacion = date("Y-m-d H:i:s");
						$InsFichaAccionSalidaExterna1->FsxTiempoModificacion = date("Y-m-d H:i:s");
		
						$InsFichaAccionSalidaExterna1->FsxEliminado = 1;
						$InsFichaAccionSalidaExterna1->InsMysql = NULL;
						
						$InsFichaAccion->FichaAccionSalidaExterna[] = $InsFichaAccionSalidaExterna1;
						
				}
							
							
			//		SesionObjeto-FichaAccionFoto
			//		Parametro1 = FafId
			//		Parametro2 =
			//		Parametro3 = FafArchivo
			//		Parametro4 = FafEstado
			//		Parametro5 = FafTiempoCreacion
			//		Parametro6 = FafTiempoModificacion

				$RepSesionObjetos = $_SESSION['InsFichaAccionFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
				$ArrSesionObjetos = $RepSesionObjetos['Datos'];
	
					if(!empty($ArrSesionObjetos)){
						foreach($ArrSesionObjetos as $DatSesionObjeto){
	
							$InsFichaAccionFoto1 = new ClsFichaAccionFoto();
							$InsFichaAccionFoto1->FafId = $DatSesionObjeto->Parametro1;
							$InsFichaAccionFoto1->FafArchivo = $DatSesionObjeto->Parametro3;
							$InsFichaAccionFoto1->FafEstado = $DatSesionObjeto->Parametro4;
							$InsFichaAccionFoto1->FafTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro5);
							$InsFichaAccionFoto1->FafTiempoModificacion = date("Y-m-d H:i:s");
							$InsFichaAccionFoto1->FafEliminado = $DatSesionObjeto->Eliminado;
							$InsFichaAccionFoto1->InsMysql = NULL;

							$InsFichaAccion->FichaAccionFoto[] = $InsFichaAccionFoto1;	

//							$_SESSION['InsFichaAccionFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,$InsFichaAccionFoto1->FafEliminado,
//							$InsFichaAccionFoto1->FafId,
//							NULL,
//							$InsFichaAccionFoto1->FafArchivo,
//							$InsFichaAccionFoto1->FafEstado,
//							FncCambiaFechaANormal($InsFichaAccionFoto1->FafTiempoCreacion),
//							FncCambiaFechaANormal($InsFichaAccionFoto1->FafTiempoModificacion));
					
						}
					}							
							
				
							
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

//		Parametro11 = FatEspecificacion
//		Parametro12 = FatCosto

								
					$RepSesionObjetos = $_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
					$ArrSesionObjetos = $RepSesionObjetos['Datos'];
					
					if(!empty($ArrSesionObjetos)){
						foreach($ArrSesionObjetos as $DatSesionObjeto){
					
							$InsFichaAccionTarea1 = new ClsFichaAccionTarea();
							$InsFichaAccionTarea1->FatId = $DatSesionObjeto->Parametro1;
							$InsFichaAccionTarea1->FitId = $DatSesionObjeto->Parametro10;
							$InsFichaAccionTarea1->FatDescripcion = $DatSesionObjeto->Parametro3;
							
							$InsFichaAccionTarea1->FatEspecificacion = $DatSesionObjeto->Parametro11;
							
							$DatSesionObjeto->Parametro12 = (empty($DatSesionObjeto->Parametro12)?0:$DatSesionObjeto->Parametro12);
							
							if($InsFichaIngreso->MonId<>$EmpresaMonedaId ){
								$InsFichaAccionTarea1->FatCosto = $DatSesionObjeto->Parametro12 * $InsFichaIngreso->FinTipoCambio;
							}else{
								$InsFichaAccionTarea1->FatCosto = $DatSesionObjeto->Parametro12;
							}

							$InsFichaAccionTarea1->FatAccion = $DatSesionObjeto->Parametro6;
							//$InsFichaAccionTarea1->FatVerificar1 = $_POST['CmpFichaAccionTarea_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];
							//$InsFichaAccionTarea1->FatVerificar1 = (empty($InsFichaAccionTarea1->FatVerificar1))?2:$InsFichaAccionTarea1->FatVerificar1;
							$InsFichaAccionTarea1->FatVerificar1 = 2;
							$InsFichaAccionTarea1->FatVerificar2 = 2;
							$InsFichaAccionTarea1->FatEstado = $DatSesionObjeto->Parametro9;
							$InsFichaAccionTarea1->FatTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
							$InsFichaAccionTarea1->FatTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
							//$InsFichaAccionTarea1->FatEliminado = 1;				
							$InsFichaAccionTarea1->FatEliminado = $DatSesionObjeto->Eliminado;
							
							$InsFichaAccionTarea1->InsMysql = NULL;
							
							$InsFichaAccion->FichaAccionTarea[] = $InsFichaAccionTarea1;	
							
							$_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,$InsFichaAccionTarea1->FatEliminado,
							$InsFichaAccionTarea1->FatId,
							NULL,
							$InsFichaAccionTarea1->FatDescripcion,
							$InsFichaAccionTarea1->FatVerificar1,
							$InsFichaAccionTarea1->FatVerificar2,
							$InsFichaAccionTarea1->FatAccion,
							FncCambiaFechaANormal($InsFichaAccionTarea1->FatTiempoCreacion),
							FncCambiaFechaANormal($InsFichaAccionTarea1->FatTiempoModificacion),
							$InsFichaAccionTarea1->FatEstado,
							$InsFichaAccionTarea1->FitId,
							
							$InsFichaAccionTarea1->FatEspecificacion,
							$InsFichaAccionTarea1->FatCosto
							);


						}						
					}



//		SesionObjeto-FichaAccionTempario
//		Parametro1 = FaeId
//		Parametro2 =
//		Parametro3 = FaeCodigo
//		Parametro4 = FaeTiempo
//		Parametro5 = 
//		Parametro6 = FaeEstado
//		Parametro7 = FaeTiempoCreacion
//		Parametro8 = FaeTiempoModificacion	

					$RepSesionObjetos = $_SESSION['InsFichaAccionTempario'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
					$ArrSesionObjetos = $RepSesionObjetos['Datos'];
					
					if(!empty($ArrSesionObjetos)){
						foreach($ArrSesionObjetos as $DatSesionObjeto){
							
						
						$InsFichaAccionTempario1 = new ClsFichaAccionTempario();
						$InsFichaAccionTempario1->FaeId = $DatSesionObjeto->Parametro1;
						$InsFichaAccionTempario1->FaeCodigo = $DatSesionObjeto->Parametro3;
						$InsFichaAccionTempario1->FaeTiempo = $DatSesionObjeto->Parametro4;
						$InsFichaAccionTempario1->FaeEstado = $DatSesionObjeto->Parametro6;
						$InsFichaAccionTempario1->FaeTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
						$InsFichaAccionTempario1->FaeTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
						$InsFichaAccionTempario1->FaeEliminado = $DatSesionObjeto->Eliminado;			
						
						$InsFichaAccionTempario1->InsMysql = NULL;
						
						$InsFichaAccion->FichaAccionTempario[] = $InsFichaAccionTempario1;	
						
						
						//SesionObjeto-FichaAccionTempario
//Parametro1 = FaeId
//Parametro2 =
//Parametro3 = FaeCodigo
//Parametro4 = FaeTiempo
//Parametro5 = 
//Parametro6 = FaeEstado
//Parametro7 = FaeTiempoCreacion
//Parametro8 = FaeTiempoModificacion

							$_SESSION['InsFichaAccionTempario'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,$InsFichaAccionTempario1->FaeEliminado,
							$InsFichaAccionTempario1->FaeId,
							NULL,
							$InsFichaAccionTempario1->FaeCodigo,
							$InsFichaAccionTempario1->FaeTiempo,
							NULL,
							$InsFichaAccionTempario1->FaeEstado,
							FncCambiaFechaANormal($InsFichaAccionTempario1->FaeTiempoCreacion),
							FncCambiaFechaANormal($InsFichaAccionTempario1->FaeTiempoModificacion)
							);
							
					}
				}	
				
				
				//if($InsFichaIngreso->FinEstado == 2 or $InsFichaIngreso->FinEstado == 3){
		
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
					//Parametro15 = Tipo
					//Parametro16 = FapAccion

					$RepSesionObjetos = $_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
					$ArrSesionObjetos = $RepSesionObjetos['Datos'];

					if(!empty($ArrSesionObjetos)){
						foreach($ArrSesionObjetos as $DatSesionObjeto){
					
							$InsFichaAccionProducto1 = new ClsFichaAccionProducto();
							$InsFichaAccionProducto1->FapId = $DatSesionObjeto->Parametro1;
							$InsFichaAccionProducto1->ProId = $DatSesionObjeto->Parametro2;

							//$InsFichaAccionProducto1->FapVerificar1 = $_POST['CmpFichaAccionProducto_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];
							//$InsFichaAccionProducto1->FapVerificar1 = (empty($InsFichaAccionProducto1->FapVerificar1))?2:$InsFichaAccionProducto1->FapVerificar1;
							$InsFichaAccionProducto1->FapVerificar1 = 1;
							$InsFichaAccionProducto1->FapVerificar2 = 1;

						
							$InsProducto->ProId = $InsFichaAccionProducto1->ProId;
							$InsProducto->MtdObtenerProducto(false);


							 $InsFichaAccionProducto1->UmeId = $DatSesionObjeto->Parametro6;
							 $InsFichaAccionProducto1->FapCantidad = $DatSesionObjeto->Parametro9;	
							 $InsFichaAccionProducto1->FapCantidadReal = $DatSesionObjeto->Parametro10;
							 $InsFichaAccionProducto1->FapVerificar1 = $DatSesionObjeto->Parametro4;
							

							  $InsFichaAccionProducto1->FapEstado = $DatSesionObjeto->Parametro14;
							  $InsFichaAccionProducto1->FapTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
							  $InsFichaAccionProducto1->FapTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
							  $InsFichaAccionProducto1->FapEliminado = $DatSesionObjeto->Eliminado;			
								
								
							  $InsFichaAccionProducto1->ProNombre = $DatSesionObjeto->Parametro3;
							  $InsFichaAccionProducto1->RtiId= $DatSesionObjeto->Parametro11;
							  $InsFichaAccionProducto1->UmeNombre= $DatSesionObjeto->Parametro12;
							  $InsFichaAccionProducto1->UmeIdOrigen= $DatSesionObjeto->Parametro13;
							  
							  $InsFichaAccionProducto1->ProCodigoOriginal = $DatSesionObjeto->Parmaetro17;
							  $InsFichaAccionProducto1->ProCodigoAlternativo = $DatSesionObjeto->Parmaetro18;
							  

							  $InsFichaAccionProducto1->InsMysql = NULL;

						$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;									

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
		//Parametro15 = Tipo
		//Parametro16 = FapAccion
		//Parmaetro17 = ProCodigoOriginal,
		//Parmaetro18 = ProCodigoAlternativo
							
							$_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
							$InsFichaAccionProducto1->FapId,
							$InsFichaAccionProducto1->ProId,
							$InsFichaAccionProducto1->ProNombre,
							$InsFichaAccionProducto1->FapVerificar1,
							$InsFichaAccionProducto1->FapVerificar2,
							$InsFichaAccionProducto1->UmeId,
							FncCambiaFechaANormal($InsFichaAccionProducto1->FapTiempoCreacion),
							FncCambiaFechaANormal($InsFichaAccionProducto1->FapTiempoModificacion),
							$InsFichaAccionProducto1->FapCantidad,
							$InsFichaAccionProducto1->FapCantidadReal,
							$InsFichaAccionProducto1->RtiId,
							$InsFichaAccionProducto1->UmeNombre,
							$InsFichaAccionProducto1->UmeIdOrigen,
							$InsFichaAccionProducto1->FapEstado,
							NULL,
							$InsFichaAccionProducto1->FapAccion,
							$InsFichaAccionProducto1->ProCodigoOriginal,
							$InsFichaAccionProducto1->ProCodigoAlternativo);

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
						
					$RepSesionObjetos = $_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
					$ArrSesionObjetos = $RepSesionObjetos['Datos'];

					
						if(!empty($ArrSesionObjetos)){
							foreach($ArrSesionObjetos as $DatSesionObjeto){

								$InsFichaAccionSuministro1 = new ClsFichaAccionSuministro();
								$InsFichaAccionSuministro1->FasId = $DatSesionObjeto->Parametro1;
								$InsFichaAccionSuministro1->ProId = $DatSesionObjeto->Parametro2;
								
								$InsFichaAccionSuministro1->FasVerificar1 = $_POST['CmpFichaAccionSuministro_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];
								$InsFichaAccionSuministro1->FasVerificar1 = (empty($InsFichaAccionSuministro1->FasVerificar1))?2:$InsFichaAccionSuministro1->FasVerificar1;
								$InsFichaAccionSuministro1->FasVerificar2 = 2;
					
								if($DatSesionObjeto->Parametro14==2){

									$InsFichaAccionSuministro1->FasCantidad = $_POST['CmpFichaAccionSuministroCantidad_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];	
									$InsFichaAccionSuministro1->UmeId = $_POST['CmpFichaAccionSuministroUnidadMedida_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];	

									$InsProducto->ProId = $InsFichaAccionSuministro1->ProId;
									$InsProducto->MtdObtenerProducto(false);

									if(!empty($InsFichaAccionSuministro1->UmeId)){	

										$InsUnidadMedida->UmeId = $InsFichaAccionSuministro1->UmeId;
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
											$InsFichaAccionSuministro1->FasCantidadReal = round($InsFichaAccionSuministro1->FasCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
										}else{
											$InsFichaAccionSuministro1->FasCantidadReal = '';
										}

									}else{
										$InsFichaAccionSuministro1->FasCantidadReal = 0;
									}

								}else{
									$InsFichaAccionSuministro1->UmeId = $DatSesionObjeto->Parametro6;
									$InsFichaAccionSuministro1->FasCantidad = $DatSesionObjeto->Parametro9;	
									$InsFichaAccionSuministro1->FasCantidadReal = $DatSesionObjeto->Parametro10;
								}

								$InsFichaAccionSuministro1->FasEstado = $DatSesionObjeto->Parametro14;
								$InsFichaAccionSuministro1->FasTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
								$InsFichaAccionSuministro1->FasTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
								$InsFichaAccionSuministro1->FasEliminado = 1;				
								
								$InsFichaAccionSuministro1->ProNombre = $DatSesionObjeto->Parametro3;
								$InsFichaAccionSuministro1->RtiId= $DatSesionObjeto->Parametro11;
								$InsFichaAccionSuministro1->UmeNombre= $DatSesionObjeto->Parametro12;
								$InsFichaAccionSuministro1->UmeIdOrigen= $DatSesionObjeto->Parametro13;

								$InsFichaAccionSuministro1->InsMysql = NULL;

								$InsFichaAccion->FichaAccionSuministro[] = $InsFichaAccionSuministro1;
												
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
								
								$_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
								$InsFichaAccionSuministro1->FasId,
								$InsFichaAccionSuministro1->ProId,
								$InsFichaAccionSuministro1->ProNombre,
								$InsFichaAccionSuministro1->FasVerificar1,
								$InsFichaAccionSuministro1->FasVerificar2,
								$InsFichaAccionSuministro1->UmeId,
								FncCambiaFechaANormal($InsFichaAccionSuministro1->FasTiempoCreacion),
								FncCambiaFechaANormal($InsFichaAccionSuministro1->FasTiempoModificacion),
								$InsFichaAccionSuministro1->FasCantidad,
								$InsFichaAccionSuministro1->FasCantidadReal,
								$InsFichaAccionSuministro1->RtiId,
								$InsFichaAccionSuministro1->UmeNombre,
								$InsFichaAccionSuministro1->UmeIdOrigen,
								$InsFichaAccionSuministro1->FasEstado);
												
							}
						}
						
				//}

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
		Parametro25 = 
		Parametro26 = ProCodigoOriginal
		*/
		
		

					//if($DatFichaIngresoModalidad->MinId == "MIN-10001"){
		if($DatFichaIngresoModalidad->MinSigla == "MA"){
		
				$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
				$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
				
				//$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId) ;
//				$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
//									
//				$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
//				unset($ArrPlanMantenimientos);
//				$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
				
				$InsPlanMantenimiento = new ClsPlanMantenimiento();
				$InsPlanMantenimiento->PmaId = $InsFichaIngreso->PmaId;
				$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
						
				foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
								
					$PlanMantenimientoDetalleId = '';
					$PlanMantenimientoDetalleAccion = '';
					$PlanMantenimientoDetalleNivel = '';
					$PlanMantenimientoDetalleVerificar1 = '';
					
					$OpcAccion1 = '';
					$OpcAccion2 = '';
					$OpcAccion3 = '';
					$OpcAccion4 = '';
					$OpcAccion5 = '';
		
					$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtNombre','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
					$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
		
					foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){
		
										
																						
						if(!empty($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId])){
												
							$InsFichaAccionMantenimiento1 = new ClsFichaAccionMantenimiento();
							
							$InsFichaAccionMantenimiento1->FaaId = $_POST['CmpPlanMantenimientoDetalleId_'.$DatPlanMantenimientoTarea->PmtId];		
							$InsFichaAccionMantenimiento1->PmtId = $DatPlanMantenimientoTarea->PmtId;
							$InsFichaAccionMantenimiento1->FaaAccion = ($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]);													
							$InsFichaAccionMantenimiento1->FaaNivel = (($DatFichaIngresoMantenimiento->FaaAccion == "X"))?'2':'1';	
						//	$InsFichaAccionMantenimiento1->FaaVerificar1 = 1; ACTUALIZADO 22-02-16
							$InsFichaAccionMantenimiento1->FaaVerificar1 = ($_POST['CmpPlanMantenimientoDetalleVerificar1_'.$DatPlanMantenimientoTarea->PmtId]);				
							$InsFichaAccionMantenimiento1->FaaVerificar1 = (empty($InsFichaAccionMantenimiento1->FaaVerificar1))?2:$InsFichaAccionMantenimiento1->FaaVerificar1;
							
								
							$InsFichaAccionMantenimiento1->ProId = ($_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoId']);					
							$InsFichaAccionMantenimiento1->UmeId = ($_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoUnidadMedidaConvertir']);
							
							$InsFichaAccionMantenimiento1->FaaCantidad = (empty($_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoCantidad'])?0:$_POST['Cmp'.$DatPlanMantenimientoTarea->PmtId.'ProductoCantidad']);
							
							$ProductoNombre = '';
							$ProductoCodigoOriginal = '';
							$ProductoTipoId = '';
							
							$UnidadMedidaNombre = '';
								
							if(!empty($InsFichaAccionMantenimiento1->ProId)){
								
								$InsProducto->ProId = $InsFichaAccionMantenimiento1->ProId;
								$InsProducto->MtdObtenerProducto(false);
								
								$ProductoNombre = $InsProducto->ProNombre;
								$ProductoCodigoOriginal =  $InsProducto->ProCodigoOriginal;														
								$ProductoTipoId =  $InsProducto->RtiId;		
								
							}
							
							if(!empty($InsFichaAccionMantenimiento1->UmeId)){
								
								$InsUnidadMedida->UmeId = $InsFichaAccionMantenimiento1->UmeId;
								$InsUnidadMedida->MtdObtenerUnidadMedida(false);
								
								$UnidadMedidaNombre = $InsUnidadMedida->UmeNombre;
							}
							
	
							$InsFichaAccionMantenimiento1->FaaVerificar2 = 1;
							$InsFichaAccionMantenimiento1->FaaEstado = 2;
							$InsFichaAccionMantenimiento1->FaaTiempoCreacion = date("Y-m-d H:i:s");
							$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");
							$InsFichaAccionMantenimiento1->FiaId = $DatFichaIngresoMantenimiento->FiaId;
							
							$InsFichaAccionMantenimiento1->InsMysql = NULL;
							
							//if(!empty($InsFichaAccionMantenimiento1->FaaAccion)){
							$InsFichaAccion->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;
							//}
						
							$ExistePlanMantenimientoDetalle = false;

							$RepSesionObjetos = $_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
							$ArrSesionObjetos = $RepSesionObjetos['Datos'];
											
							
							
							  if(!empty($ArrSesionObjetos)){
								  foreach($ArrSesionObjetos as $DatSesionObjeto){
									  
									  if($DatSesionObjeto->Parametro3 == $DatPlanMantenimientoTarea->PmtId){
										  
										  $ExistePlanMantenimientoDetalle = true;

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
										Parametro25 = 	
										Parametro26 = ProCodigoOriginal
										Parametro27 = FaaCantidad
										*/

										  $_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
										  $InsFichaAccionMantenimiento1->FaaId,
										  NULL,
										  $InsFichaAccionMantenimiento1->PmtId,
										  $InsFichaAccionMantenimiento1->FaaAccion,
										  $InsFichaAccionMantenimiento1->FaaTiempoCreacion,
										  $InsFichaAccionMantenimiento1->FapTiempoModificacion,
										  ($InsFichaAccionMantenimiento1->FaaNivel),
										  ($InsFichaAccionMantenimiento1->FaaVerificar1),
										  $InsFichaAccionMantenimiento1->FaaVerificar2,
										  $InsFichaAccionMantenimiento1->FaaEstado,

										  $DatSesionObjeto->Parametro11,
										  $InsFichaAccionMantenimiento1->ProId,
										  $ProductoNombre,
										  $DatSesionObjeto->Parametro14,
										  $DatSesionObjeto->Parametro15,
										  $InsFichaAccionMantenimiento1->UmeId,
										  $DatSesionObjeto->Parametro17,
										  $DatSesionObjeto->Parametro18,
										  $InsFichaAccionMantenimiento1->FaaCantidad,
										  $DatSesionObjeto->Parametro20,
										  $ProductoTipoId,
										  $UnidadMedidaNombre,
										  $DatSesionObjeto->Parametro23,
										  $DatSesionObjeto->Parametro24,
										  $DatSesionObjeto->Parametro25,
										  
										  $ProductoCodigoOriginal
										  );
										  
									  }
									  
								  }
							  }
								
								if(!$ExistePlanMantenimientoDetalle){
									
									$_SESSION['InsFichaAccionMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
									$InsFichaAccionMantenimiento1->FaaId,
									NULL,
									$InsFichaAccionMantenimiento1->PmtId,
									$InsFichaAccionMantenimiento1->FaaAccion,
									$InsFichaAccionMantenimiento1->FaaTiempoCreacion,
									$InsFichaAccionMantenimiento1->FapTiempoModificacion,
									($InsFichaAccionMantenimiento1->FaaNivel),
									($InsFichaAccionMantenimiento1->FaaVerificar1),
									$InsFichaAccionMantenimiento1->FaaVerificar2,
									$InsFichaAccionMantenimiento1->FaaEstado,
			
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									
									NULL,
									NULL);
		
		
								}
								
						}
											
											
					}
				}
		
			
			
		}
					
					
					if(!empty($InsFichaAccion->FccId)){
						
						if($InsFichaAccion->MinSigla <> "PP"){
							
							
							if($InsFichaAccion->MtdEditarFichaAccion()){
							
								FncCargarFichaAccionDatos();
								
								if($InsFichaAccion->MinSigla == "MA" and (!empty($_POST['CmpFichaIngresoTrabajoConcluido']))){
									
								
									//$InsFichaAccion->MtdNotificarFichaAccionMantenimiento($InsFichaAccion->FccId,$CorreosNotificacionFichaAccionMantenimiento);								
								
								}
								
								if( !empty($InsFichaAccion->FccPedido) ){
								
									$Comparar1 = strip_tags($InsFichaAccion->FccPedido);
									$Comparar1 = str_replace(" ","",$Comparar1);
									
									$Comparar2 = strip_tags($InsFichaAccion->FccPedido2);
									$Comparar2 = str_replace(" ","",$Comparar2);
									
									if( ($Comparar1) <> $Comparar2){
										
										if(!empty($_SESSION['SesionPersonal'])){
												
											$InsPersonal = new ClsPersonal();
											$InsPersonal->PerId = $_SESSION['SesionPersonal'];
											$InsPersonal->MtdObtenerPersonal();

											if(!empty($InsPersonal->PerEmail)){
												$PersonalEmail = $InsPersonal->PerEmail.",";	
											}

										}
										
							
										$InsFichaAccion->MtdNotificarFichaAccionPedido($InsFichaAccion->FccId,$PersonalEmail.",".$CorreosNotificacionFichaAccionPedido);								
										
									}

								}
								
								$validar++;
								$Resultado.='#SAS_FCC_102';
							}else{
								
								
							
								$InsFichaAccion->FccFecha = FncCambiaFechaANormal($InsFichaAccion->FccFecha);
								$InsFichaAccion->FccComprobanteFecha = FncCambiaFechaANormal($InsFichaAccion->FccComprobanteFecha,true);
								
								if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
									foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
								
										if($DatFichaIngresoModalidad->MinSigla == "PP"){
			
											$InsFichaAccionSalidaExterna1->FsxFechaSalida = FncCambiaFechaANormal($InsFichaAccionSalidaExterna1->FsxFechaSalida,true);
											$InsFichaAccionSalidaExterna1->FsxFechaFinalizacion = FncCambiaFechaANormal($InsFichaAccionSalidaExterna1->FsxFechaFinalizacion,true);
			
										}
											
									}
								}
						
								$Resultado.='#ERR_FCC_102';
							}
							
						}else{
							$validar++;
						}
						

					}else{
						$validar++;
					}
						
					$ArrFichaAccion[] = $InsFichaAccion;	
					
				}
	


			}
		}
		



	$InsFichaIngreso->MtdEditarFichaIngresoHerramienta();

	//$InsFichaIngreso->MtdEditarFichaIngresoObservacionSalida();
	$InsFichaIngreso->MtdEditarFichaIngresoDato("FinSalidaObservacion",$InsFichaIngreso->FinSalidaObservacion,$InsFichaIngreso->FinId);
	$InsFichaIngreso->MtdEditarFichaIngresoDato("FinSalidaObservacionInterna",$InsFichaIngreso->FinSalidaObservacionInterna,$InsFichaIngreso->FinId);
		
				
	if(count($InsFichaIngreso->FichaIngresoModalidad) == $validar){
	
		$InsFichaIngreso->MtdEditarFichaIngresoDato("FinFotoVIN",$InsFichaIngreso->FinFotoVIN,$InsFichaIngreso->FinId);
		$InsFichaIngreso->MtdEditarFichaIngresoDato("FinFotoFrontal",$InsFichaIngreso->FinFotoFrontal,$InsFichaIngreso->FinId);
		$InsFichaIngreso->MtdEditarFichaIngresoDato("FinFotoCupon",$InsFichaIngreso->FinFotoCupon,$InsFichaIngreso->FinId);
		$InsFichaIngreso->MtdEditarFichaIngresoDato("FinFotoMantenimiento",$InsFichaIngreso->FinFotoMantenimiento,$InsFichaIngreso->FinId);
					
		$InsVehiculoIngreso = new ClsVehiculoIngreso();
		$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinFotoVIN",$InsFichaIngreso->FinFotoVIN,$InsFichaIngreso->EinId);
		$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinFotoFrontal",$InsFichaIngreso->FinFotoFrontal,$InsFichaIngreso->EinId);
		$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinFotoCupon",$InsFichaIngreso->FinFotoCupon,$InsFichaIngreso->EinId);

		$Resultado='#SAS_FCC_102';

		switch($InsFichaIngreso->FinEstado){
			
			case "2":
				
				$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,3);					
				
				if($POST_FichaIngresoEnviar == "1"){
					//ACTUALIZANDO A TALLER [Pedido Enviado]
					$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,4);
				}
							
			break;
			
			case "3":
			
				if($POST_FichaIngresoEnviar == "1"){
					//ACTUALIZANDO A TALLER [Pedido Enviado]
					$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,4);
				}
				
			break;
			
		}
		
//		if($InsFichaIngreso->FinEstado == "2"){
//
//			
//
//		}
		

		//_SESSION['FichaAccionAux'] = 2;
		$Edito = true;
	
	}else{
		
//		if(empty($Resultado)){
//			$Resultado.='#ERR_FCC_102';				
//		}

	
	}
			
	$InsFichaIngreso->MtdObtenerFichaIngresoEstado();
		
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
	
	global $EmpresaMonedaId;
	

	unset($_SESSION['InsPreEntregaDetalle'.$Identificador]);
	$_SESSION['InsPreEntregaDetalle'.$Identificador] = new ClsSesionObjeto();	
	
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){

			unset($_SESSION['InsFichaAccionFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionTempario'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);

			$_SESSION['InsFichaAccionFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsFichaAccionTempario'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();	
			$_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();

		}
	}
	
	
	$_SESSION['SesFinFotoVIN'.$Identificador] = $InsFichaIngreso->FinFotoVIN;
	$_SESSION['SesFinFotoFrontal'.$Identificador] = $InsFichaIngreso->FinFotoFrontal;
	$_SESSION['SesFinFotoCupon'.$Identificador] = $InsFichaIngreso->FinFotoCupon;
	$_SESSION['SesFinFotoMantenimiento'.$Identificador] = $InsFichaIngreso->FinFotoMantenimiento;
			
	$_SESSION['InsFichaAccionHerramienta'.$Identificador] = new ClsSesionObjeto();

	if(!empty($InsFichaIngreso->PreEntregaDetalle)){
		foreach($InsFichaIngreso->PreEntregaDetalle as $DatPreEntregaDetalle){		
	
			/*
			SesionObjeto-PreEntregaDetalle
			Parametro1 = RedId
			Parametro2 = 
			Parametro3 = PetId
			Parametro4 = RedAccion
			Parametro5 = RedTiempoCreacion
			Parametro6 = RedTiempoModificacion
			*/

			$_SESSION['InsPreEntregaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatPreEntregaDetalle->RedId,
			NULL,
			$DatPreEntregaDetalle->PetId,
			$DatPreEntregaDetalle->RedAccion,
			($DatPreEntregaDetalle->RedTiempoCreacion),
			$DatPreEntregaDetalle->RedTiempoModificacion
			);
	
		}
	}		
	
	
	
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
					
						$_SESSION['InsFichaAccionHerramienta'.$Identificador]->MtdAgregarSesionObjeto(1,
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
			
			
			if($InsFichaAccion ==NULL){
				
				
				$InsFichaAccion = new ClsFichaAccion();
				$InsFichaAccion->FimId = $DatFichaIngresoModalidad->FimId;
				$InsFichaAccion->FccFecha = date("Y-m-d");
				$InsFichaAccion->FccObservacion = date("d/m/Y H:i:s")." - Sub OT autogenerada de O.T.: ".$InsFichaIngreso->FinId;
				
				$InsFichaAccion->FccManoObra = 0;	
				$InsFichaAccion->FccDescuento = 0;	
				$InsFichaAccion->FccEstado = 1;	
				$InsFichaAccion->FccTiempoCreacion = date("Y-m-d H:i:s");
				$InsFichaAccion->FccTiempoModificacion = date("Y-m-d H:i:s");
				
				$InsFichaAccion->MinSigla = $DatFichaIngresoModalidad->MinSigla;
				
				$InsFichaAccion->FichaAccionTarea = array();
				$InsFichaAccion->FichaAccionProducto = array();
				$InsFichaAccion->FichaAccionMantenimiento = array();
				
				$FichaAccionId = $InsFichaAccion->MtdVerificarExisteFichaAccion("FimId",$InsFichaAccion->FimId);
				
				if(empty($FichaAccionId)){
				
					if($InsFichaAccion->MtdRegistrarFichaAccion()){
						
//						$InsFichaAccion->FccId
					}

				}
				
				
			}
			
			
		
//		SesionObjeto-FichaAccionFoto
//		Parametro1 = FafId
//		Parametro2 =
//		Parametro3 = FafArchivo
//		Parametro4 = FafEstado
//		Parametro5 = FafTiempoCreacion
//		Parametro6 = FafTiempoModificacion

				if(!empty($InsFichaAccion->FichaAccionFoto)){
					foreach($InsFichaAccion->FichaAccionFoto as $DatFichaAccionFoto){
						
						$_SESSION['InsFichaAccionFoto'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaAccionFoto->FafId,
						NULL,
						$DatFichaAccionFoto->FafArchivo,
						$DatFichaAccionFoto->FafEstado,
						($DatFichaAccionFoto->FafTiempoCreacion),
						($DatFichaAccionFoto->FafTiempoModificacion)
						);
	
					}
				}	
				
				
				//deb($InsFichaAccion->FichaAccionSalidaExterna);
			
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

//		Parametro11 = FatEspecificacion
//		Parametro12 = FatCosto

				if(!empty($InsFichaAccion->FichaAccionTarea)){
					foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){

						if($InsFichaIngreso->MonId<>$EmpresaMonedaId){
							$DatFichaAccionTarea->FatCosto = round($DatFichaAccionTarea->FatCosto / $InsFichaIngreso->FinTipoCambio,2);
						}

						$_SESSION['InsFichaAccionTarea'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaAccionTarea->FatId,
						NULL,
						$DatFichaAccionTarea->FatDescripcion,
						$DatFichaAccionTarea->FatVerificar1,
						$DatFichaAccionTarea->FatVerificar2,
						$DatFichaAccionTarea->FatAccion,
						($DatFichaAccionTarea->FatTiempoCreacion),
						($DatFichaAccionTarea->FatTiempoModificacion),
						$DatFichaAccionTarea->FatEstado,
						$DatFichaAccionTarea->FitId,

						$DatFichaAccionTarea->FatEspecificacion,
						$DatFichaAccionTarea->FatCosto);
	
					}
				}			


				
				
				if(!empty($DatFichaIngresoModalidad->FichaIngresoTarea)){
					foreach($DatFichaIngresoModalidad->FichaIngresoTarea as $DatFichaIngresoTarea){
						
						$Agregar = true;
						
						if(!empty($InsFichaAccion->FichaAccionTarea)){
							foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
						
								if($DatFichaIngresoTarea->FitId == $DatFichaAccionTarea->FitId){
									$Agregar = false;
									break;
								}
							
							}
						}
						
						
						if($Agregar){
						//	echo 'InsFichaAccionTarea'.$InsFichaAccion->MinSigla.$Identificador;
							
							//$_SESSION['InsFichaAccionTarea'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
//							NULL,
//							NULL,
//							$DatFichaIngresoTarea->FitDescripcion,
//							2,
//							2,
//							$DatFichaIngresoTarea->FitAccion,
//							(date("d/m/Y H:i:s")),
//							(date("d/m/Y H:i:s")),
//							2,
//							$DatFichaIngresoTarea->FitId,
//	
//							NULL,
//							0);
							
							
						}
						
						
						
						
					}
				}
				
				
//		SesionObjeto-FichaAccionTempario
//		Parametro1 = FaeId
//		Parametro2 =
//		Parametro3 = FaeCodigo
//		Parametro4 = FaeTiempo
//		Parametro5 = 
//		Parametro6 = FaeEstado
//		Parametro7 = FaeTiempoCreacion
//		Parametro8 = FaeTiempoModificacion	

				if(!empty($InsFichaAccion->FichaAccionTempario)){
					foreach($InsFichaAccion->FichaAccionTempario as $DatFichaAccionTempario){
						
						$_SESSION['InsFichaAccionTempario'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaAccionTempario->FaeId,
						NULL,
						$DatFichaAccionTempario->FaeCodigo,
						$DatFichaAccionTempario->FaeTiempo,
						NULL,
						$DatFichaAccionTempario->FaeEstado,
						($DatFichaAccionTempario->FaeTiempoCreacion),
						($DatFichaAccionTempario->FaeTiempoModificacion)
						);

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
//Parametro15 = Tipo
//Parametro16 = FapAccion
//Parmaetro17 = ProCodigoOriginal,
//Parmaetro18 = ProCodigoAlternativo
				
				if(!empty($InsFichaAccion->FichaAccionProducto)){
					foreach($InsFichaAccion->FichaAccionProducto as $DatFichaAccionProducto){	
									
						$_SESSION['InsFichaAccionProducto'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
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
						$DatFichaAccionProducto->FapEstado,
						NULL,
						$DatFichaAccionProducto->FapAccion,
						$DatFichaAccionProducto->ProCodigoOriginal,
						$DatFichaAccionProducto->ProCodigoAlternativo);
						
					}
				}

				
//deb($InsFichaAccion->FichaAccionProducto);
				
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
				
				//if(!empty($InsFichaAccion->FichaAccionSuministro)){
//					foreach($InsFichaAccion->FichaAccionSuministro as $DatFichaAccionSuministro){					
//					
//						$_SESSION['InsFichaAccionSuministro'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
//						$DatFichaAccionSuministro->FasId,
//						$DatFichaAccionSuministro->ProId,
//						$DatFichaAccionSuministro->ProNombre,
//						$DatFichaAccionSuministro->FasVerificar1,
//						$DatFichaAccionSuministro->FasVerificar2,
//						$DatFichaAccionSuministro->UmeId,
//						($DatFichaAccionSuministro->FasTiempoCreacion),
//						($DatFichaAccionSuministro->FasTiempoModificacion),
//						$DatFichaAccionSuministro->FasCantidad,
//						$DatFichaAccionSuministro->FasCantidadReal,
//						$DatFichaAccionSuministro->RtiId,
//						$DatFichaAccionSuministro->UmeNombre,
//						$DatFichaAccionSuministro->UmeIdOrigen,
//						$DatFichaAccionSuministro->FasEstado);
//						
//					}
//				}
				
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

	Parametro26 = ProCodigoOriginal
	*/
		
			

				
				
				
				
			//	
//				if(empty($InsFichaAccion->FichaAccionMantenimiento)){
//						
//					//$InsFichaAccion1 = new ClsFichaAccion();
//					//$InsFichaAccion1->FccId = $Ins
//										
//					if(!empty($DatFichaIngresoModalidad->FichaIngresoMantenimiento)){
//						foreach($DatFichaIngresoModalidad->FichaIngresoMantenimiento as $DatFichaIngresoMantenimiento){
//
//							if(!empty($DatFichaIngresoMantenimiento->MinSigla)){ //AUX
//
//								$InsFichaAccionMantenimiento1 = new ClsFichaAccionMantenimiento();
//
//								$InsFichaAccionMantenimiento1->PmtId = $DatFichaIngresoMantenimiento->PmtId;
//								//$InsFichaAccionMantenimiento1->FaaAccion = $DatFichaIngresoMantenimiento->FiaAccion;
//								if($InsFichaAccionMantenimiento1->FaaAccion<>"C" or $InsFichaAccionMantenimiento1->FaaAccion<>"R"){
//									$InsFichaAccionMantenimiento1->FaaAccion = "X";			
//								}
//
//								$InsFichaAccionMantenimiento1->FaaNivel = (($DatFichaIngresoMantenimiento->FidAccion == "X"))?'2':'1';
//								$InsFichaAccionMantenimiento1->FaaVerificar1 = 1;//ACTUALIZADO 03-10-17
//								$InsFichaAccionMantenimiento1->FaaVerificar2 = 1;//ACTUALIZADO 03-10-17
//								$InsFichaAccionMantenimiento1->FaaEstado = 2;
//								$InsFichaAccionMantenimiento1->FaaTiempoCreacion = date("Y-m-d H:i:s");
//								$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");
//								$InsFichaAccionMantenimiento1->FiaId = $DatFichaIngresoMantenimiento->FiaId;
//
//								
//								$InsFichaAccionMantenimiento1->InsMysql = NULL;
//	
//								$InsFichaAccion->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;
//								
//								
//								
//							}
//		
//						}
//						
//						$InsFichaAccion->MtdRegistrarFichaAccionMantenimiento();
//						
//					}
//					
//					
//				}				
//				
				
				
				
				if(!empty($InsFichaAccion->FichaAccionMantenimiento)){
					foreach($InsFichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){		
				
						$_SESSION['InsFichaAccionMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
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

						NULL,
						$DatFichaAccionMantenimiento->ProId,
						$DatFichaAccionMantenimiento->ProNombre,
						0,
						0,
						$DatFichaAccionMantenimiento->UmeId,
						NULL,
						NULL,
						$DatFichaAccionMantenimiento->FaaCantidad,
						NULL,
						$DatFichaAccionMantenimiento->RtiId,
						$DatFichaAccionMantenimiento->UmeNombre,
						$DatFichaAccionMantenimiento->UmeIdOrigen,
						NULL,
						NULL,
						$DatFichaAccionMantenimiento->ProCodigoOriginal
						);
						
						
						
						/*$_SESSION['InsFichaAccionMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
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
						$DatFichaAccionMantenimiento->FapEstado,
						NULL,
						$DatFichaAccionMantenimiento->ProCodigoOriginal);*/
							
					}
				}		
				
				
				
			if(empty($InsFichaAccion->FichaAccionMantenimiento)){
						
			}
					
						
				
			$ArrFichaAccion[] = $InsFichaAccion;			
				
				
		}
	}


}

?>

