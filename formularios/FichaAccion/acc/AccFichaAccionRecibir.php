<?php


function FncCargarFichaAccionDatos(){


	global $InsFichaAccion;
	global $Identificador;
	
	$InsFichaAccion->MtdObtenerFichaAccion();

	unset($_SESSION['InsFichaAccionTarea'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsFichaAccionProducto'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsFichaAccionMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsFichaAccionSuministro'.$InsFichaAccion->MinSigla.$Identificador]);

	$_SESSION['InsFichaAccionTarea'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFichaAccionProducto'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFichaAccionMantenimiento'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFichaAccionSuministro'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	


//deb($InsFichaAccion->FichaAccionProducto);			

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
						$DatFichaAccionProducto->FapAccion);
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
	//$InsFichaIngreso->FinEstado = $_POST['CmpFichaIngresoEstado'];
	
	$InsFichaIngreso->VmaNomvre =($_POST['CmpFichaIngresoMarca']);
	$InsFichaIngreso->VmoNombre =($_POST['CmpFichaIngresoModelo']);
	$InsFichaIngreso->VveNombre =($_POST['CmpFichaIngresoVersion']);
	
	$InsFichaIngreso->FinSalidaObservacion = addslashes($_POST['CmpObservacionSalida']);
	$InsFichaIngreso->FinMantenimientoKilometraje = ($_POST['CmpFichaIngresoMantenimientoKilometraje']);
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
	//$InsFichaIngreso->MtdEditarFichaIngresoMantenimientoKilometraje();
	$InsFichaIngreso->MtdObtenerFichaIngresoEstado();
	
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
				

	$InsFichaIngreso->MtdEditarFichaIngresoHerramienta();


	$InsFichaIngreso->MtdEditarFichaIngresoObservacionSalida();
	
	
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
			
			
			

	
				$InsFichaAccion = new ClsFichaAccion();
				$InsFichaAccion->UsuId = $_SESSION['SesionId'];
				$InsFichaAccion->FccId = $_POST['CmpId_'.$DatFichaIngresoModalidad->MinSigla];
				$InsFichaAccion->FimId = $_POST['CmpFichaIngresoModalidadId_'.$DatFichaIngresoModalidad->MinSigla];
				
				$InsFichaAccion->FccFecha = FncCambiaFechaAMysql($_POST['CmpFecha_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->FccManoObra = 0;
				$InsFichaAccion->FccObservacion = addslashes($_POST['CmpObservacion_'.$DatFichaIngresoModalidad->MinSigla]);
				
				$InsFichaAccion->FccEstado = 1;
				$InsFichaAccion->FccTiempoCreacion = date("Y-m-d H:i:s");
				$InsFichaAccion->FccTiempoModificacion = date("Y-m-d H:i:s");
	
				$InsFichaAccion->MinSigla = ($_POST['CmpModalidadIngresoSigla_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->MinNombre = ($_POST['CmpModalidadIngresoNombre_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->MinSigla = ($_POST['CmpModalidadIngresoSigla_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->MinId = ($_POST['CmpModalidadIngresoId_'.$DatFichaIngresoModalidad->MinSigla]);
				
				$InsFichaAccion->FichaAccionTarea = array();
				$InsFichaAccion->FichaAccionProducto = array();
	
				//if(!empty($InsFichaAccion->FccId)){
				if(!empty($DatFichaIngresoModalidad->MinSigla)){//AUX
							
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
								
					$RepSesionObjetos = $_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
					$ArrSesionObjetos = $RepSesionObjetos['Datos'];
					
					if(!empty($ArrSesionObjetos)){
						foreach($ArrSesionObjetos as $DatSesionObjeto){
					
							$InsFichaAccionTarea1 = new ClsFichaAccionTarea();
							$InsFichaAccionTarea1->FatId = $DatSesionObjeto->Parametro1;
							$InsFichaAccionTarea1->FitId = $DatSesionObjeto->Parametro10;
							$InsFichaAccionTarea1->FatDescripcion = $DatSesionObjeto->Parametro3;
							$InsFichaAccionTarea1->FatAccion = $DatSesionObjeto->Parametro6;
							$InsFichaAccionTarea1->FatVerificar1 = $_POST['CmpFichaAccionTarea_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];
							//$InsFichaAccionTarea1->FatVerificar1 = (empty($InsFichaAccionTarea1->FatVerificar1))?2:$InsFichaAccionTarea1->FatVerificar1;
							$InsFichaAccionTarea1->FatVerificar2 = 2;
							$InsFichaAccionTarea1->FatEstado = $DatSesionObjeto->Parametro9;
							$InsFichaAccionTarea1->FatTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
							$InsFichaAccionTarea1->FatTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
							$InsFichaAccionTarea1->FatEliminado = 1;				
							
							$InsFichaAccionTarea1->InsMysql = NULL;
							
							$InsFichaAccion->FichaAccionTarea[] = $InsFichaAccionTarea1;	
							
							$_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
							$InsFichaAccionTarea1->FatId,
							NULL,
							$InsFichaAccionTarea1->FatDescripcion,
							$InsFichaAccionTarea1->FatVerificar1,
							$InsFichaAccionTarea1->FatVerificar2,
							$InsFichaAccionTarea1->FatAccion,
							FncCambiaFechaANormal($InsFichaAccionTarea1->FatTiempoCreacion),
							FncCambiaFechaANormal($InsFichaAccionTarea1->FatTiempoModificacion),
							$InsFichaAccionTarea1->FatEstado);
					
						}						
					}

//deb($InsFichaIngreso->FinEstado);

				//if($InsFichaIngreso->FinEstado == 2 or $InsFichaIngreso->FinEstado == 3){
//		
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
					
					//deb($ArrSesionObjetos);
					
					if(!empty($ArrSesionObjetos)){
						foreach($ArrSesionObjetos as $DatSesionObjeto){
					
							  $InsFichaAccionProducto1 = new ClsFichaAccionProducto();
							  $InsFichaAccionProducto1->FapId = $DatSesionObjeto->Parametro1;
							  $InsFichaAccionProducto1->ProId = $DatSesionObjeto->Parametro2;
							  
							  $InsFichaAccionProducto1->FapVerificar2 = 1;
					
					///	deb($DatSesionObjeto->Parametro14);
							if($DatSesionObjeto->Parametro14==2){
					
								$InsFichaAccionProducto1->FapVerificar1 = $_POST['CmpFichaAccionProducto_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];
								$InsFichaAccionProducto1->FapVerificar1 = (empty($InsFichaAccionProducto1->FapVerificar1))?2:$InsFichaAccionProducto1->FapVerificar1;
							  
								$InsFichaAccionProducto1->FapAccion = $_POST['CmpFichaAccionProductoAccion_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];
					
								$InsFichaAccionProducto1->FapCantidad = $_POST['CmpFichaAccionProductoCantidad_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];	
								  //$InsFichaAccionProducto1->FapCantidadReal = $DatSesionObjeto->Parametro10;
								$InsFichaAccionProducto1->UmeId = $_POST['CmpFichaAccionProductoUnidadMedida_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];	

								$InsProducto->ProId = $InsFichaAccionProducto1->ProId;
								$InsProducto->MtdObtenerProducto(false);
									  
								//deb($InsFichaAccionProducto1->UmeId);
								
								  if(!empty($InsFichaAccionProducto1->UmeId)){	
					
									  $InsUnidadMedida->UmeId = $InsFichaAccionProducto1->UmeId;
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
										  $InsFichaAccionProducto1->FapCantidadReal = round($InsFichaAccionProducto1->FapCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
									  }else{
										  $InsFichaAccionProducto1->FapCantidadReal = '';
									  }
										//echo "AAA";
								  }else{
									  //echo "BBBB";
									  $InsFichaAccionProducto1->FapCantidadReal = 0;
								  }
								 // echo "AAA";
							  }else{
								//  echo "BBB";
								  
								  $InsFichaAccionProducto1->UmeId = $DatSesionObjeto->Parametro6;
								  $InsFichaAccionProducto1->FapCantidad = $DatSesionObjeto->Parametro9;	
								  $InsFichaAccionProducto1->FapCantidadReal = $DatSesionObjeto->Parametro10;
								  $InsFichaAccionProducto1->FapVerificar1 = $DatSesionObjeto->Parametro4;
							  }
								
								//deb($InsFichaAccionProducto1->FapAccion);
							//deb($InsFichaAccionProducto1->FapCantidadReal);
								
							  $InsFichaAccionProducto1->FapEstado = $DatSesionObjeto->Parametro14;
							  $InsFichaAccionProducto1->FapTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
							  $InsFichaAccionProducto1->FapTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
							  $InsFichaAccionProducto1->FapEliminado = 1;				
							  
							  $InsFichaAccionProducto1->ProNombre = $DatSesionObjeto->Parametro3;
							  $InsFichaAccionProducto1->RtiId= $DatSesionObjeto->Parametro11;
							  $InsFichaAccionProducto1->UmeNombre= $DatSesionObjeto->Parametro12;
							  $InsFichaAccionProducto1->UmeIdOrigen= $DatSesionObjeto->Parametro13;
							  
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
							  $InsFichaAccionProducto1->FapAccion);
							  
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

					if($DatFichaIngresoModalidad->MinId == "MIN-10001"){
	
						$RepSesionObjetos = $_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
						$ArrSesionObjetos = $RepSesionObjetos['Datos'];

						if(!empty($ArrSesionObjetos)){
							foreach($ArrSesionObjetos as $DatSesionObjeto){
								
								if(!empty($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatSesionObjeto->Parametro3])){
		
									$InsFichaAccionMantenimiento1 = new ClsFichaAccionMantenimiento();
									$InsFichaAccionMantenimiento1->FaaId = $_POST['CmpPlanMantenimientoDetalleId_'.$DatSesionObjeto->Parametro3];
									$InsFichaAccionMantenimiento1->FaaVerificar1 = (empty($_POST['CmpPlanMantenimientoDetalleVerificar1_'.$DatSesionObjeto->Parametro3])?2:1);									
									$InsFichaAccionMantenimiento1->FaaAccion = ($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatSesionObjeto->Parametro3]);							
									
									
									$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");

									$InsFichaAccionMantenimiento1->InsMysql = NULL;

									$InsFichaAccion->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;	

										$InsFichaAccionProducto1 = new ClsFichaAccionProducto();
										$InsFichaAccionProducto1->FapId = $_POST['CmpFichaAccion'.$DatSesionObjeto->Parametro3.'ProductoId'];

										if(!empty($InsFichaAccionProducto1->FapId)){
	
											$InsFichaAccionProducto1->FapVerificar1 = $InsFichaAccionMantenimiento1->FaaVerificar1;
											$InsFichaAccionProducto1->FapTiempoModificacion = date("Y-m-d H:i:s");
											$InsFichaAccionProducto1->FapEliminado = 1;				
											$InsFichaAccionProducto1->InsMysql = NULL;
														
											$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;													
											
												$_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
												$DatSesionObjeto->Parametro1,
												NULL,
												$DatSesionObjeto->Parametro3,
												($InsFichaAccionMantenimiento1->FaaAccion),
												$DatSesionObjeto->Parametro5,
												$DatSesionObjeto->Parametro6,
												$DatSesionObjeto->Parametro7,
												($InsFichaAccionMantenimiento1->FaaVerificar1),
												$DatSesionObjeto->Parametro9,
												$DatSesionObjeto->Parametro10,

												$InsFichaAccionProducto1->FapId,
												$DatSesionObjeto->Parametro12,
												$DatSesionObjeto->Parametro13,
												$InsFichaAccionProducto1->FapVerificar1,
												$DatSesionObjeto->Parametro15,
												$DatSesionObjeto->Parametro16,
												$DatSesionObjeto->Parametro17,
												$InsFichaAccionProducto1->FapTiempoModificacion,
												$DatSesionObjeto->Parametro19,
												$DatSesionObjeto->Parametro20,
												$DatSesionObjeto->Parametro21,
												$DatSesionObjeto->Parametro22,
												$DatSesionObjeto->Parametro23,
												$DatSesionObjeto->Parametro24);
												
											}else{
												
												$_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
												$DatSesionObjeto->Parametro1,
												NULL,
												$DatSesionObjeto->Parametro3,
												($InsFichaAccionMantenimiento1->FaaAccion),
												$DatSesionObjeto->Parametro5,
												$DatSesionObjeto->Parametro6,
												$DatSesionObjeto->Parametro7,
												($InsFichaAccionMantenimiento1->FaaVerificar1),
												$DatSesionObjeto->Parametro9,
												$DatSesionObjeto->Parametro10,

												$DatSesionObjeto->Parametro11,
												$DatSesionObjeto->Parametro12,
												$DatSesionObjeto->Parametro13,
												$DatSesionObjeto->Parametro14,
												$DatSesionObjeto->Parametro15,
												$DatSesionObjeto->Parametro16,
												$DatSesionObjeto->Parametro17,
												$DatSesionObjeto->Parametro18,
												$DatSesionObjeto->Parametro19,
												$DatSesionObjeto->Parametro20,
												$DatSesionObjeto->Parametro21,
												$DatSesionObjeto->Parametro22,
												$DatSesionObjeto->Parametro23,
												$DatSesionObjeto->Parametro24);
												
											}

												
								}
								
							}						
						}
						
					}
					
			
					
					
					if(!empty($InsFichaAccion->FccId)){

						if($InsFichaAccion->MtdAdicionarFichaAccion()){
							FncCargarFichaAccionDatos();
							$validar++;
							$Resultado.='#SAS_FCC_102';
						}else{
							$InsFichaAccion->FccFecha = FncCambiaFechaANormal($InsFichaAccion->FccFecha);
							$Resultado.='#ERR_FCC_102';
						}

					}else{
						$validar++;
					}

					$ArrFichaAccion[] = $InsFichaAccion;	
					
				}
	
				




		}
		
	}

		


			if(count($InsFichaIngreso->FichaIngresoModalidad) == $validar){
					
				
				
				
//				if($InsFichaIngreso->FinEstado == "2"){
//					$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,3);					
//				}

				//FncCargarDatos();
				//$_SESSION['FichaAccionAux'] = 2;
				$Edito = true;

			}
		
}else{

	FncCargarDatos();

	//ALMACEN [Pedido Enviado]
	if($InsFichaIngreso->FinEstado == 7){
		//ACTUALIZANDO A TALLER [Pedido Recibido]
		$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,71,false); //OJOOO		
	}
	
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
//	if(!empty($ArrModalidadIngresos)){
//		foreach($ArrModalidadIngresos as $DatFichaIngresoModalidad){

			unset($_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);

			$_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();	
			$_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();

		}
	}
	
	unset($_SESSION['InsFichaAccionHerramienta'.$Identificador]);
			
	$_SESSION['InsFichaAccionHerramienta'.$Identificador] = new ClsSesionObjeto();

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
						$DatFichaAccionProducto->FapAccion);
						
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
						
						//deb($DatFichaAccionMantenimiento->FapVerificar2);
						
					}
				}				
				
	

			
			$ArrFichaAccion[] = $InsFichaAccion;			
				
				
		}
	}


}

?>

