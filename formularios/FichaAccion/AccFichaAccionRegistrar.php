<?php
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

	$InsFichaIngreso->MtdEditarFichaIngresoMantenimientoKilometraje();
	
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
	
	$RepSesionObjetos = $_SESSION['InsFichaAccionHerramienta'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrSesionObjetos = $RepSesionObjetos['Datos'];
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
				$InsFichaAccion->FccDescuento = 0;
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

				$RepSesionObjetos = $_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
				$ArrSesionObjetos = $RepSesionObjetos['Datos'];
	
					if(!empty($ArrSesionObjetos)){
						foreach($ArrSesionObjetos as $DatSesionObjeto){
	
							$InsFichaAccionTarea1 = new ClsFichaAccionTarea();
							$InsFichaAccionTarea1->FatId = $DatSesionObjeto->Parametro1;
							$InsFichaAccionTarea1->FitId = $DatSesionObjeto->Parametro10;
							$InsFichaAccionTarea1->FatDescripcion = $DatSesionObjeto->Parametro3;
							$InsFichaAccionTarea1->FatAccion = $DatSesionObjeto->Parametro6;
							$InsFichaAccionTarea1->FatVerificar1 = $_POST['CmpFichaAccionTarea_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];
							$InsFichaAccionTarea1->FatVerificar1 = (empty($InsFichaAccionTarea1->FatVerificar1))?2:$InsFichaAccionTarea1->FatVerificar1;
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
			
				$RepSesionObjetos = $_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
				$ArrSesionObjetos = $RepSesionObjetos['Datos'];
				
				if(!empty($ArrSesionObjetos)){
					foreach($ArrSesionObjetos as $DatSesionObjeto){
  
						$InsFichaAccionProducto1 = new ClsFichaAccionProducto();
						$InsFichaAccionProducto1->FapId = $DatSesionObjeto->Parametro1;
						$InsFichaAccionProducto1->ProId = $DatSesionObjeto->Parametro2;
						
						$InsFichaAccionProducto1->FapAccion = $_POST['CmpFichaAccionProductoAccion_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];
						
						$InsFichaAccionProducto1->FapVerificar1 = $_POST['CmpFichaAccionProducto_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];
						$InsFichaAccionProducto1->FapVerificar1 = (empty($InsFichaAccionProducto1->FapVerificar1))?2:$InsFichaAccionProducto1->FapVerificar1;
						$InsFichaAccionProducto1->FapVerificar2 = 1;
  
							if($DatSesionObjeto->Parametro14 == 2){
  
								$InsFichaAccionProducto1->FapCantidad = $_POST['CmpFichaAccionProductoCantidad_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];								
								$InsFichaAccionProducto1->UmeId = $_POST['CmpFichaAccionProductoUnidadMedida_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];								
  
								$InsProducto->ProId = $InsFichaAccionProducto1->ProId;
								$InsProducto->MtdObtenerProducto(false);
								
								if($InsFichaAccionProducto1->FapAccion=="C"){
  
  
									if(!empty($InsFichaAccionProducto1->UmeId)){
  
										//if(!empty($InsFichaAccionProducto1->FapCantidad)){
  
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
																							
										//}else{
											
										//}
  
									}else{
										$InsFichaAccionProducto1->FapCantidadReal = '';
									}
									
									
										
								}else{
									$InsFichaAccionProducto1->FapCantidadReal = 0;
								}
								
								
								
								
							}else{
  
								$InsFichaAccionProducto1->UmeId = $DatSesionObjeto->Parametro6;
								$InsFichaAccionProducto1->FapCantidad = $DatSesionObjeto->Parametro9;	
								$InsFichaAccionProducto1->FapCantidadReal = $DatSesionObjeto->Parametro10;
								$InsFichaAccionProducto1->FapVerificar1 = $DatSesionObjeto->Parametro4;
  
							}
  
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
			
				$RepSesionObjetos = $_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
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
									
									if(!empty($InsFichaAccionSuministro1->FasCantidad)){
										
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
										
									}
  
								}else{
									$InsFichaAccionSuministro1->FasCantidadReal = '';
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

											$InsFichaAccionMantenimiento1->PmtId = $DatSesionObjeto->Parametro3;
											
											$InsFichaAccionMantenimiento1->FiaId = $_POST['CmpFichaIngresoMantenimientoId_'.$DatSesionObjeto->Parametro3];
											$InsFichaAccionMantenimiento1->FaaAccion = $_POST['CmpPlanMantenimientoDetalleAccion_'.$DatSesionObjeto->Parametro3];
											$InsFichaAccionMantenimiento1->FaaNivel = $_POST['CmpPlanMantenimientoDetalleNivel_'.$DatSesionObjeto->Parametro3];
											$InsFichaAccionMantenimiento1->FaaVerificar1 = (empty($_POST['CmpPlanMantenimientoDetalleVerificar1_'.$DatSesionObjeto->Parametro3])?2:1);
											$InsFichaAccionMantenimiento1->FaaVerificar2 = 1;
											
											$InsFichaAccionMantenimiento1->FaaTiempoCreacion = date("Y-m-d H:i:s");
											$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");

											$InsFichaAccionMantenimiento1->InsMysql = NULL;

											$InsFichaAccion->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;	
											
												$InsFichaAccionProducto1 = new ClsFichaAccionProducto();
												$InsFichaAccionProducto1->FapId = $_POST['CmpFichaAccion'.$DatSesionObjeto->Parametro3.'ProductoId'];
												$InsFichaAccionProducto1->ProId = $_POST['Cmp'.$DatSesionObjeto->Parametro3.'ProductoId'];
	
									
											if(!empty($InsFichaAccionProducto1->FapId)){

												if($InsFichaAccionMantenimiento1->FaaAccion == "C" || $InsFichaAccionMantenimiento1->FaaAccion == "R"){

													if(!empty($InsFichaAccionProducto1->ProId)){

														$InsProducto->ProId = $InsFichaAccionProducto1->ProId;
														$InsProducto->MtdObtenerProducto(false);
														
														$InsFichaAccionProducto1->FapVerificar1 = $InsFichaAccionMantenimiento1->FaaVerificar1;
														$InsFichaAccionProducto1->FapVerificar2 = $InsFichaAccionMantenimiento1->FaaVerificar2;
							
														$InsFichaAccionProducto1->FapCantidad = eregi_replace(",","",$_POST['Cmp'.$DatSesionObjeto->Parametro3.'ProductoCantidad']);
														$InsFichaAccionProducto1->UmeId = $_POST['Cmp'.$DatSesionObjeto->Parametro3.'ProductoUnidadMedidaConvertir'];	
														
														$InsFichaAccionProducto1->FaaId = $InsFichaAccionMantenimiento1->FaaId;
														
														$InsFichaAccionProducto1->FapEstado = 3;
														$InsFichaAccionProducto1->FapTiempoCreacion = date("Y-m-d H:i:s");
														$InsFichaAccionProducto1->FapTiempoModificacion = date("Y-m-d H:i:s");
														$InsFichaAccionProducto1->FapEliminado = 1;				
														
														$InsFichaAccionProducto1->ProNombre = $InsProducto->ProNombre;
														$InsFichaAccionProducto1->RtiId= $InsProducto->RtiId;
														$InsFichaAccionProducto1->UmeNombre= $InsUnidadMedida->UmeNombre;
														$InsFichaAccionProducto1->UmeIdOrigen= $InsProducto->UmeId;
																									
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
			
														$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;	
														
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
														
														$InsFichaAccionProducto1->FapId,
														$InsFichaAccionProducto1->ProId,
														$InsFichaAccionProducto1->ProNombre,
														$InsFichaAccionProducto1->FapVerificar1,
														$InsFichaAccionProducto1->FapVerificar2,
														$InsFichaAccionProducto1->UmeId,
														$InsFichaAccionProducto1->FapTiempoCreacion,
														$InsFichaAccionProducto1->FapTiempoModificacion,
														$InsFichaAccionProducto1->FapCantidad,
														$InsFichaAccionProducto1->FapCantidadReal,
														$InsFichaAccionProducto1->RtiId,
														$InsFichaAccionProducto1->UmeNombre,
														$InsFichaAccionProducto1->UmeIdOrigen,
														$InsFichaAccionProducto1->FapEstado);
													}else{

														$InsFichaAccionProducto1->FapEliminado = 2;
														$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;													
														
														unset($InsFichaAccionProducto1);
														
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

												}else{

													$InsFichaAccionProducto1->FapEliminado = 2;
													$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;													

													unset($InsFichaAccionProducto1);
													
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
												
											}else{

												if($InsFichaAccionMantenimiento1->FaaAccion == "C" || $InsFichaAccionMantenimiento1->FaaAccion == "R"){

													if(!empty($InsFichaAccionProducto1->ProId)){

														$InsProducto->ProId = $InsFichaAccionProducto1->ProId;
														$InsProducto->MtdObtenerProducto(false);
														
														$InsFichaAccionProducto1->FapVerificar1 = $InsFichaAccionMantenimiento1->FaaVerificar1;
														$InsFichaAccionProducto1->FapVerificar2 = $InsFichaAccionMantenimiento1->FaaVerificar2;
							
														$InsFichaAccionProducto1->FapCantidad = eregi_replace(",","",$_POST['Cmp'.$DatSesionObjeto->Parametro3.'ProductoCantidad']);
														$InsFichaAccionProducto1->UmeId = $_POST['Cmp'.$DatSesionObjeto->Parametro3.'ProductoUnidadMedidaConvertir'];	
														
														$InsFichaAccionProducto1->FaaId = $InsFichaAccionMantenimiento1->FaaId;
														
														$InsFichaAccionProducto1->FapEstado = 3;
														$InsFichaAccionProducto1->FapTiempoCreacion = date("Y-m-d H:i:s");
														$InsFichaAccionProducto1->FapTiempoModificacion = date("Y-m-d H:i:s");
														$InsFichaAccionProducto1->FapEliminado = 1;				
														
														$InsFichaAccionProducto1->ProNombre = $InsProducto->ProNombre;
														$InsFichaAccionProducto1->RtiId= $InsProducto->RtiId;
														$InsFichaAccionProducto1->UmeNombre= $InsUnidadMedida->UmeNombre;
														$InsFichaAccionProducto1->UmeIdOrigen= $InsProducto->UmeId;
																									
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
			
														$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;	
			
			
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
															
															$InsFichaAccionProducto1->FapId,
															$InsFichaAccionProducto1->ProId,
															$InsFichaAccionProducto1->ProNombre,
															//"AAAAAAAAAAAAAAA",
															$InsFichaAccionProducto1->FapVerificar1,
															$InsFichaAccionProducto1->FapVerificar2,
															$InsFichaAccionProducto1->UmeId,
															$InsFichaAccionProducto1->FapTiempoCreacion,
															$InsFichaAccionProducto1->FapTiempoModificacion,
															$InsFichaAccionProducto1->FapCantidad,
															$InsFichaAccionProducto1->FapCantidadReal,
															$InsFichaAccionProducto1->RtiId,
															$InsFichaAccionProducto1->UmeNombre,
															$InsFichaAccionProducto1->UmeIdOrigen,
															$InsFichaAccionProducto1->FapEstado);
															
													}else{
													
													}
													
												}else{
													
												}
												
											}
											

				
										}
										
									}						
								}
		
						}
						
						
					}
					
					if(!empty($InsFichaAccion->FccId)){

						$InsFichaAccion->Transaccion = true;
						if($InsFichaAccion->MtdEditarFichaAccion()){
							FncFichaAccionCargarDatos();
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
		
		if(!empty($ArrModalidadIngresos)){			
			foreach($ArrModalidadIngresos  as $DatModalidadIngreso){

		
		
//				$InsFichaAccion = new ClsFichaAccion();
//				$InsFichaAccion->UsuId = $_SESSION['SesionId'];
//				$InsFichaAccion->FccId = $_POST['CmpId_'.$DatModalidadIngreso->MinSigla];
//				$InsFichaAccion->FimId = $_POST['CmpFichaIngresoModalidadId_'.$DatModalidadIngreso->MinSigla];
//
//				$InsFichaAccion->FccFecha = FncCambiaFechaAMysql($_POST['CmpFecha_'.$DatModalidadIngreso->MinSigla]);
//				$InsFichaAccion->FccManoObra = 0;
//				$InsFichaAccion->FccDescuento = 0;
//				$InsFichaAccion->FccObservacion = addslashes($_POST['CmpObservacion_'.$DatModalidadIngreso->MinSigla]);
//
//				$InsFichaAccion->FccEstado = 1;
//				$InsFichaAccion->FccTiempoCreacion = date("Y-m-d H:i:s");
//				$InsFichaAccion->FccTiempoModificacion = date("Y-m-d H:i:s");
//
//				$InsFichaAccion->MinSigla = ($_POST['CmpModalidadIngresoSigla_'.$DatModalidadIngreso->MinSigla]);
//				$InsFichaAccion->MinNombre = ($_POST['CmpModalidadIngresoNombre_'.$DatModalidadIngreso->MinSigla]);
//				$InsFichaAccion->MinSigla = ($_POST['CmpModalidadIngresoSigla_'.$DatModalidadIngreso->MinSigla]);
//				$InsFichaAccion->MinId = ($_POST['CmpModalidadIngresoId_'.$DatModalidadIngreso->MinSigla]);
//
//				$InsFichaAccion->FichaAccionTarea = array();
//				$InsFichaAccion->FichaAccionProducto = array();
//
//				if(!empty($DatModalidadIngreso->MinSigla)){//AUX
//					
////		SesionObjeto-FichaAccionTarea
////		Parametro1 = FatId
////		Parametro2 =
////		Parametro3 = FatDescripcion
////		Parametro4 = FatVerificar1
////		Parametro5 = FatVerificar2
////		Parametro6 = FatAccion
////		Parametro7 = FatTiempoCreacion
////		Parametro8 = FatTiempoModificacion
////		Parametro9 = FatEstado
////		Parametro10 = FitId
//
//				$RepSesionObjetos = $_SESSION['InsFichaAccionTarea'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
//				$ArrSesionObjetos = $RepSesionObjetos['Datos'];
//	
//					if(!empty($ArrSesionObjetos)){
//						foreach($ArrSesionObjetos as $DatSesionObjeto){
//	
//							$InsFichaAccionTarea1 = new ClsFichaAccionTarea();
//							$InsFichaAccionTarea1->FatId = $DatSesionObjeto->Parametro1;
//							$InsFichaAccionTarea1->FitId = $DatSesionObjeto->Parametro10;
//							$InsFichaAccionTarea1->FatDescripcion = $DatSesionObjeto->Parametro3;
//							$InsFichaAccionTarea1->FatAccion = $DatSesionObjeto->Parametro6;
//							$InsFichaAccionTarea1->FatVerificar1 = $_POST['CmpFichaAccionTarea_'.$DatModalidadIngreso->MinSigla.$DatSesionObjeto->Item];
//							$InsFichaAccionTarea1->FatVerificar1 = (empty($InsFichaAccionTarea1->FatVerificar1))?2:$InsFichaAccionTarea1->FatVerificar1;
//							$InsFichaAccionTarea1->FatVerificar2 = 2;
//							$InsFichaAccionTarea1->FatEstado = $DatSesionObjeto->Parametro9;
//							$InsFichaAccionTarea1->FatTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
//							$InsFichaAccionTarea1->FatTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
//							$InsFichaAccionTarea1->FatEliminado = 1;				
//							$InsFichaAccionTarea1->InsMysql = NULL;
//							
//							$InsFichaAccion->FichaAccionTarea[] = $InsFichaAccionTarea1;	
//							
//							$_SESSION['InsFichaAccionTarea'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
//							$InsFichaAccionTarea1->FatId,
//							NULL,
//							$InsFichaAccionTarea1->FatDescripcion,
//							$InsFichaAccionTarea1->FatVerificar1,
//							$InsFichaAccionTarea1->FatVerificar2,
//							$InsFichaAccionTarea1->FatAccion,
//							FncCambiaFechaANormal($InsFichaAccionTarea1->FatTiempoCreacion),
//							FncCambiaFechaANormal($InsFichaAccionTarea1->FatTiempoModificacion),
//							$InsFichaAccionTarea1->FatEstado);
//					
//						}
//					}
//
//				//SesionObjeto-FichaAccionProducto
//				//Parametro1 = FapId
//				//Parametro2 = ProId
//				//Parametro3 = ProNombre
//				//Parametro4 = FapVerificar1
//				//Parametro5 = FapVerificar2
//				//Parametro6 = UmeId
//				//Parametro7 = FapTiempoCreacion
//				//Parametro8 = FapTiempoModificacion
//				//Parametro9 = FapCantidad
//				//Parametro10 = FapCantidadReal	
//				//Parametro11 = RtiId
//				//Parametro12 = UmeNombre
//				//Parametro13 = UmeIdOrigen
//				//Parametro14 = FapEstado
//				//Parametro15 = Tipo
//				//Parametro16 = FapAccion
//			
//				$RepSesionObjetos = $_SESSION['InsFichaAccionProducto'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
//				$ArrSesionObjetos = $RepSesionObjetos['Datos'];
//				
//				if(!empty($ArrSesionObjetos)){
//					foreach($ArrSesionObjetos as $DatSesionObjeto){
//  
//						$InsFichaAccionProducto1 = new ClsFichaAccionProducto();
//						$InsFichaAccionProducto1->FapId = $DatSesionObjeto->Parametro1;
//						$InsFichaAccionProducto1->ProId = $DatSesionObjeto->Parametro2;
//						
//						$InsFichaAccionProducto1->FapAccion = $_POST['CmpFichaAccionProductoAccion_'.$DatModalidadIngreso->MinSigla.$DatSesionObjeto->Item];
//						
//						$InsFichaAccionProducto1->FapVerificar1 = $_POST['CmpFichaAccionProducto_'.$DatModalidadIngreso->MinSigla.$DatSesionObjeto->Item];
//						$InsFichaAccionProducto1->FapVerificar1 = (empty($InsFichaAccionProducto1->FapVerificar1))?2:$InsFichaAccionProducto1->FapVerificar1;
//						$InsFichaAccionProducto1->FapVerificar2 = 1;
//  
//							if($DatSesionObjeto->Parametro14 == 2){
//  
//								$InsFichaAccionProducto1->FapCantidad = $_POST['CmpFichaAccionProductoCantidad_'.$DatModalidadIngreso->MinSigla.$DatSesionObjeto->Item];								
//								$InsFichaAccionProducto1->UmeId = $_POST['CmpFichaAccionProductoUnidadMedida_'.$DatModalidadIngreso->MinSigla.$DatSesionObjeto->Item];								
//  
//								$InsProducto->ProId = $InsFichaAccionProducto1->ProId;
//								$InsProducto->MtdObtenerProducto(false);
//								
//								if($InsFichaAccionProducto1->FapAccion=="C"){
//  
//  
//									if(!empty($InsFichaAccionProducto1->UmeId)){
//  
//										//if(!empty($InsFichaAccionProducto1->FapCantidad)){
//  
//											$InsUnidadMedida->UmeId = $InsFichaAccionProducto1->UmeId;
//											$InsUnidadMedida->MtdObtenerUnidadMedida();
//  
//											if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
//												$InsUnidadMedidaConversion->UmcEquivalente = 1;
//											}else{
//												$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
//												$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
//												
//												foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
//													$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
//												}
//											}
//			
//											if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
//												$InsFichaAccionProducto1->FapCantidadReal = round($InsFichaAccionProducto1->FapCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
//											}else{
//												$InsFichaAccionProducto1->FapCantidadReal = '';
//												
//											}
//																							
//										//}else{
//											
//										//}
//  
//									}else{
//										$InsFichaAccionProducto1->FapCantidadReal = '';
//									}
//									
//									
//										
//								}else{
//									$InsFichaAccionProducto1->FapCantidadReal = 0;
//								}
//								
//								
//								
//								
//							}else{
//  
//								$InsFichaAccionProducto1->UmeId = $DatSesionObjeto->Parametro6;
//								$InsFichaAccionProducto1->FapCantidad = $DatSesionObjeto->Parametro9;	
//								$InsFichaAccionProducto1->FapCantidadReal = $DatSesionObjeto->Parametro10;
//								$InsFichaAccionProducto1->FapVerificar1 = $DatSesionObjeto->Parametro4;
//  
//							}
//  
//							$InsFichaAccionProducto1->FapEstado = $DatSesionObjeto->Parametro14;
//							$InsFichaAccionProducto1->FapTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
//							$InsFichaAccionProducto1->FapTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
//							$InsFichaAccionProducto1->FapEliminado = 1;				
//							
//							$InsFichaAccionProducto1->ProNombre = $DatSesionObjeto->Parametro3;
//							$InsFichaAccionProducto1->RtiId= $DatSesionObjeto->Parametro11;
//							$InsFichaAccionProducto1->UmeNombre= $DatSesionObjeto->Parametro12;
//							$InsFichaAccionProducto1->UmeIdOrigen= $DatSesionObjeto->Parametro13;
//							
//							$InsFichaAccionProducto1->InsMysql = NULL;
//							
//							$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;	
//							
//		//SesionObjeto-FichaAccionProducto
//		//Parametro1 = FapId
//		//Parametro2 = ProId
//		//Parametro3 = ProNombre
//		//Parametro4 = FapVerificar1
//		//Parametro5 = FapVerificar2
//		//Parametro6 = UmeId
//		//Parametro7 = FapTiempoCreacion
//		//Parametro8 = FapTiempoModificacion
//		//Parametro9 = FapCantidad
//		//Parametro10 = FapCantidadReal	
//		//Parametro11 = RtiId
//		//Parametro12 = UmeNombre
//		//Parametro13 = UmeIdOrigen
//		//Parametro14 = FapEstado
//		//Parametro15 = Tipo
//		//Parametro16 = FapAccion
//  
//							$_SESSION['InsFichaAccionProducto'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
//							$InsFichaAccionProducto1->FapId,
//							$InsFichaAccionProducto1->ProId,
//							$InsFichaAccionProducto1->ProNombre,
//							$InsFichaAccionProducto1->FapVerificar1,
//							$InsFichaAccionProducto1->FapVerificar2,
//							$InsFichaAccionProducto1->UmeId,
//							FncCambiaFechaANormal($InsFichaAccionProducto1->FapTiempoCreacion),
//							FncCambiaFechaANormal($InsFichaAccionProducto1->FapTiempoModificacion),
//							$InsFichaAccionProducto1->FapCantidad,
//							$InsFichaAccionProducto1->FapCantidadReal,
//							$InsFichaAccionProducto1->RtiId,
//							$InsFichaAccionProducto1->UmeNombre,
//							$InsFichaAccionProducto1->UmeIdOrigen,
//							$InsFichaAccionProducto1->FapEstado,
//							NULL,
//							$InsFichaAccionProducto1->FapAccion);
//							
//					}
//				}
//						
//		//deb($InsFichaAccion->FichaAccionProducto);
//				
//				//SesionObjeto-FichaAccionSuministro
//				//Parametro1 = FasId
//				//Parametro2 = ProId
//				//Parametro3 = ProNombre
//				//Parametro4 = FasVerificar1
//				//Parametro5 = FasVeriticar2
//				//Parametro6 = UmeId
//				//Parametro7 = FasTiempoCreacion
//				//Parametro8 = FasTiempoModificacion
//				//Parametro9 = FasCantidad
//				//Parametro10 = FasCantidadReal	
//				//Parametro11 = RtiId
//				//Parametro12 = UmeNombre
//				//Parametro13 = UmeIdOrigen
//				//Parametro14 = FasEstado
//			
//				$RepSesionObjetos = $_SESSION['InsFichaAccionSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
//				$ArrSesionObjetos = $RepSesionObjetos['Datos'];
//					
//				if(!empty($ArrSesionObjetos)){
//					foreach($ArrSesionObjetos as $DatSesionObjeto){
//  
//							$InsFichaAccionSuministro1 = new ClsFichaAccionSuministro();
//							$InsFichaAccionSuministro1->FasId = $DatSesionObjeto->Parametro1;
//							$InsFichaAccionSuministro1->ProId = $DatSesionObjeto->Parametro2;
//  
//							$InsFichaAccionSuministro1->FasVerificar1 = $_POST['CmpFichaAccionSuministro_'.$DatModalidadIngreso->MinSigla.$DatSesionObjeto->Item];
//							$InsFichaAccionSuministro1->FasVerificar1 = (empty($InsFichaAccionSuministro1->FasVerificar1))?2:$InsFichaAccionSuministro1->FasVerificar1;
//							$InsFichaAccionSuministro1->FasVerificar2 = 2;
//  
//							if($DatSesionObjeto->Parametro14==2){
//								
//								$InsFichaAccionSuministro1->FasCantidad = $_POST['CmpFichaAccionSuministroCantidad_'.$DatModalidadIngreso->MinSigla.$DatSesionObjeto->Item];								
//								$InsFichaAccionSuministro1->UmeId = $_POST['CmpFichaAccionSuministroUnidadMedida_'.$DatModalidadIngreso->MinSigla.$DatSesionObjeto->Item];								
//  
//								$InsProducto->ProId = $InsFichaAccionSuministro1->ProId;
//								$InsProducto->MtdObtenerProducto(false);
//								
//								if(!empty($InsFichaAccionSuministro1->UmeId)){
//									
//									if(!empty($InsFichaAccionSuministro1->FasCantidad)){
//										
//										$InsUnidadMedida->UmeId = $InsFichaAccionSuministro1->UmeId;
//										$InsUnidadMedida->MtdObtenerUnidadMedida();
//										
//										if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
//											$InsUnidadMedidaConversion->UmcEquivalente = 1;
//										}else{
//											$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
//											$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
//  
//											foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
//												$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
//											}
//										}
//		
//										if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
//											$InsFichaAccionSuministro1->FasCantidadReal = round($InsFichaAccionSuministro1->FasCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
//										}else{
//											$InsFichaAccionSuministro1->FasCantidadReal = '';
//										}
//  
//									}else{
//										
//									}
//  
//								}else{
//									$InsFichaAccionSuministro1->FasCantidadReal = '';
//								}
//								
//							}else{
//								$InsFichaAccionSuministro1->UmeId = $DatSesionObjeto->Parametro6;
//								$InsFichaAccionSuministro1->FasCantidad = $DatSesionObjeto->Parametro9;	
//								$InsFichaAccionSuministro1->FasCantidadReal = $DatSesionObjeto->Parametro10;
//							}
//  
//							$InsFichaAccionSuministro1->FasEstado = $DatSesionObjeto->Parametro14;
//							$InsFichaAccionSuministro1->FasTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
//							$InsFichaAccionSuministro1->FasTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
//							$InsFichaAccionSuministro1->FasEliminado = 1;				
//							
//							$InsFichaAccionSuministro1->ProNombre = $DatSesionObjeto->Parametro3;
//							$InsFichaAccionSuministro1->RtiId= $DatSesionObjeto->Parametro11;
//							$InsFichaAccionSuministro1->UmeNombre= $DatSesionObjeto->Parametro12;
//							$InsFichaAccionSuministro1->UmeIdOrigen= $DatSesionObjeto->Parametro13;
//							
//							$InsFichaAccionSuministro1->InsMysql = NULL;
//							
//							$InsFichaAccion->FichaAccionSuministro[] = $InsFichaAccionSuministro1;	
//							
//  //SesionObjeto-FichaAccionSuministro
//  //Parametro1 = FasId
//  //Parametro2 = ProId
//  //Parametro3 = ProNombre
//  //Parametro4 = FasVerificar1
//  //Parametro5 = FasVeriticar2
//  //Parametro6 = UmeId
//  //Parametro7 = FasTiempoCreacion
//  //Parametro8 = FasTiempoModificacion
//  //Parametro9 = FasCantidad
//  //Parametro10 = FasCantidadReal	
//  //Parametro11 = RtiId
//  //Parametro12 = UmeNombre
//  //Parametro13 = UmeIdOrigen
//  //Parametro14 = FasEstado
//  
//							$_SESSION['InsFichaAccionSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
//							$InsFichaAccionSuministro1->FasId,
//							$InsFichaAccionSuministro1->ProId,
//							$InsFichaAccionSuministro1->ProNombre,
//							$InsFichaAccionSuministro1->FasVerificar1,
//							$InsFichaAccionSuministro1->FasVerificar2,
//							$InsFichaAccionSuministro1->UmeId,
//							FncCambiaFechaANormal($InsFichaAccionSuministro1->FasTiempoCreacion),
//							FncCambiaFechaANormal($InsFichaAccionSuministro1->FasTiempoModificacion),
//							$InsFichaAccionSuministro1->FasCantidad,
//							$InsFichaAccionSuministro1->FasCantidadReal,
//							$InsFichaAccionSuministro1->RtiId,
//							$InsFichaAccionSuministro1->UmeNombre,
//							$InsFichaAccionSuministro1->UmeIdOrigen,
//							$InsFichaAccionSuministro1->FasEstado);
//					
//					}
//				}
//						
//			/*
//			SesionObjeto-FichaAccionMantenimiento
//			Parametro1 = FaaId
//			Parametro2 = 
//			Parametro3 = PmtId
//			Parametro4 = FaaAccion
//			Parametro5 = FaaTiempoCreacion
//			Parametro6 = FaaTiempoModificacion
//			Parametro7 = FaaNivel
//			Parametro8 = FaaVerificar1
//			Parametro9 = FaaVerificar2
//			Parametro10 = FaaEstado
//			
//			Parametro11 = FapId
//			Parametro12 = ProId
//			Parametro13 = ProNombre
//			Parametro14 = FapVerificar1
//			Parametro15 = FapVerificar2
//			Parametro16 = UmeId
//			Parametro17 = FapTiempoCreacion
//			Parametro18 = FapTiempoModificacion
//			Parametro19 = FapCantidad
//			Parametro20 = FapCantidadReal	
//			Parametro21 = RtiId
//			Parametro22 = UmeNombre
//			Parametro23 = UmeIdOrigen
//			Parametro24 = FapEstado
//			*/
//			
//						if($DatModalidadIngreso->MinId == "MIN-10001"){
//
//							$RepSesionObjetos = $_SESSION['InsFichaAccionMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
//							$ArrSesionObjetos = $RepSesionObjetos['Datos'];
//			
//								if(!empty($ArrSesionObjetos)){
//									foreach($ArrSesionObjetos as $DatSesionObjeto){
//										
//										if(!empty($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatSesionObjeto->Parametro3])){
//				
//											$InsFichaAccionMantenimiento1 = new ClsFichaAccionMantenimiento();
//											$InsFichaAccionMantenimiento1->FaaId = $_POST['CmpPlanMantenimientoDetalleId_'.$DatSesionObjeto->Parametro3];
//
//											$InsFichaAccionMantenimiento1->PmtId = $DatSesionObjeto->Parametro3;
//											
//											$InsFichaAccionMantenimiento1->FiaId = $_POST['CmpFichaIngresoMantenimientoId_'.$DatSesionObjeto->Parametro3];
//											$InsFichaAccionMantenimiento1->FaaAccion = $_POST['CmpPlanMantenimientoDetalleAccion_'.$DatSesionObjeto->Parametro3];
//											$InsFichaAccionMantenimiento1->FaaNivel = $_POST['CmpPlanMantenimientoDetalleNivel_'.$DatSesionObjeto->Parametro3];
//											$InsFichaAccionMantenimiento1->FaaVerificar1 = (empty($_POST['CmpPlanMantenimientoDetalleVerificar1_'.$DatSesionObjeto->Parametro3])?2:1);
//											$InsFichaAccionMantenimiento1->FaaVerificar2 = 1;
//											
//											$InsFichaAccionMantenimiento1->FaaTiempoCreacion = date("Y-m-d H:i:s");
//											$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");
//
//											$InsFichaAccionMantenimiento1->InsMysql = NULL;
//
//											$InsFichaAccion->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;	
//											
//												$InsFichaAccionProducto1 = new ClsFichaAccionProducto();
//												$InsFichaAccionProducto1->FapId = $_POST['CmpFichaAccion'.$DatSesionObjeto->Parametro3.'ProductoId'];
//												$InsFichaAccionProducto1->ProId = $_POST['Cmp'.$DatSesionObjeto->Parametro3.'ProductoId'];
//	
//									
//											if(!empty($InsFichaAccionProducto1->FapId)){
//
//												if($InsFichaAccionMantenimiento1->FaaAccion == "C" || $InsFichaAccionMantenimiento1->FaaAccion == "R"){
//
//													if(!empty($InsFichaAccionProducto1->ProId)){
//
//														$InsProducto->ProId = $InsFichaAccionProducto1->ProId;
//														$InsProducto->MtdObtenerProducto(false);
//														
//														$InsFichaAccionProducto1->FapVerificar1 = $InsFichaAccionMantenimiento1->FaaVerificar1;
//														$InsFichaAccionProducto1->FapVerificar2 = $InsFichaAccionMantenimiento1->FaaVerificar2;
//							
//														$InsFichaAccionProducto1->FapCantidad = eregi_replace(",","",$_POST['Cmp'.$DatSesionObjeto->Parametro3.'ProductoCantidad']);
//														$InsFichaAccionProducto1->UmeId = $_POST['Cmp'.$DatSesionObjeto->Parametro3.'ProductoUnidadMedidaConvertir'];	
//														
//														$InsFichaAccionProducto1->FaaId = $InsFichaAccionMantenimiento1->FaaId;
//														
//														$InsFichaAccionProducto1->FapEstado = 3;
//														$InsFichaAccionProducto1->FapTiempoCreacion = date("Y-m-d H:i:s");
//														$InsFichaAccionProducto1->FapTiempoModificacion = date("Y-m-d H:i:s");
//														$InsFichaAccionProducto1->FapEliminado = 1;				
//														
//														$InsFichaAccionProducto1->ProNombre = $InsProducto->ProNombre;
//														$InsFichaAccionProducto1->RtiId= $InsProducto->RtiId;
//														$InsFichaAccionProducto1->UmeNombre= $InsUnidadMedida->UmeNombre;
//														$InsFichaAccionProducto1->UmeIdOrigen= $InsProducto->UmeId;
//																									
//														$InsUnidadMedida->UmeId = $InsFichaAccionProducto1->UmeId;
//														$InsUnidadMedida->MtdObtenerUnidadMedida();
//														
//														if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
//															$InsUnidadMedidaConversion->UmcEquivalente = 1;
//														}else{
//															$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
//															$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
//															
//															foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
//																$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
//															}
//														}
//						
//														if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
//															$InsFichaAccionProducto1->FapCantidadReal = round($InsFichaAccionProducto1->FapCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
//														}else{
//															$InsFichaAccionProducto1->FapCantidadReal = '';
//														}
//			
//														$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;	
//														
//														$_SESSION['InsFichaAccionMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
//														$InsFichaAccionMantenimiento1->FaaId,
//														NULL,
//														$InsFichaAccionMantenimiento1->PmtId,
//														$InsFichaAccionMantenimiento1->FaaAccion,
//														$InsFichaAccionMantenimiento1->FaaTiempoCreacion,
//														$InsFichaAccionMantenimiento1->FapTiempoModificacion,
//														($InsFichaAccionMantenimiento1->FaaNivel),
//														($InsFichaAccionMantenimiento1->FaaVerificar1),
//														$InsFichaAccionMantenimiento1->FaaVerificar2,
//														$InsFichaAccionMantenimiento1->FaaEstado,
//														
//														$InsFichaAccionProducto1->FapId,
//														$InsFichaAccionProducto1->ProId,
//														$InsFichaAccionProducto1->ProNombre,
//														$InsFichaAccionProducto1->FapVerificar1,
//														$InsFichaAccionProducto1->FapVerificar2,
//														$InsFichaAccionProducto1->UmeId,
//														$InsFichaAccionProducto1->FapTiempoCreacion,
//														$InsFichaAccionProducto1->FapTiempoModificacion,
//														$InsFichaAccionProducto1->FapCantidad,
//														$InsFichaAccionProducto1->FapCantidadReal,
//														$InsFichaAccionProducto1->RtiId,
//														$InsFichaAccionProducto1->UmeNombre,
//														$InsFichaAccionProducto1->UmeIdOrigen,
//														$InsFichaAccionProducto1->FapEstado);
//													}else{
//
//														$InsFichaAccionProducto1->FapEliminado = 2;
//														$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;													
//														
//														unset($InsFichaAccionProducto1);
//														
//														$_SESSION['InsFichaAccionMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
//														$InsFichaAccionMantenimiento1->FaaId,
//														NULL,
//														$InsFichaAccionMantenimiento1->PmtId,
//														$InsFichaAccionMantenimiento1->FaaAccion,
//														$InsFichaAccionMantenimiento1->FaaTiempoCreacion,
//														$InsFichaAccionMantenimiento1->FapTiempoModificacion,
//														($InsFichaAccionMantenimiento1->FaaNivel),
//														($InsFichaAccionMantenimiento1->FaaVerificar1),
//														$InsFichaAccionMantenimiento1->FaaVerificar2,
//														$InsFichaAccionMantenimiento1->FaaEstado,
//														
//														NULL,
//														NULL,
//														NULL,
//														NULL,
//														NULL,
//														NULL,
//														NULL,
//														NULL,
//														NULL,
//														NULL,
//														NULL,
//														NULL,
//														NULL,
//														NULL);
//
//													}
//
//												}else{
//
//													$InsFichaAccionProducto1->FapEliminado = 2;
//													$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;													
//
//													unset($InsFichaAccionProducto1);
//													
//													$_SESSION['InsFichaAccionMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
//													$InsFichaAccionMantenimiento1->FaaId,
//													NULL,
//													$InsFichaAccionMantenimiento1->PmtId,
//													$InsFichaAccionMantenimiento1->FaaAccion,
//													$InsFichaAccionMantenimiento1->FaaTiempoCreacion,
//													$InsFichaAccionMantenimiento1->FapTiempoModificacion,
//													($InsFichaAccionMantenimiento1->FaaNivel),
//													($InsFichaAccionMantenimiento1->FaaVerificar1),
//													$InsFichaAccionMantenimiento1->FaaVerificar2,
//													$InsFichaAccionMantenimiento1->FaaEstado,
//													
//													NULL,
//													NULL,
//													NULL,
//													NULL,
//													NULL,
//													NULL,
//													NULL,
//													NULL,
//													NULL,
//													NULL,
//													NULL,
//													NULL,
//													NULL,
//													NULL);
//													
//												}
//												
//											}else{
//
//												if($InsFichaAccionMantenimiento1->FaaAccion == "C" || $InsFichaAccionMantenimiento1->FaaAccion == "R"){
//
//													if(!empty($InsFichaAccionProducto1->ProId)){
//
//														$InsProducto->ProId = $InsFichaAccionProducto1->ProId;
//														$InsProducto->MtdObtenerProducto(false);
//														
//														$InsFichaAccionProducto1->FapVerificar1 = $InsFichaAccionMantenimiento1->FaaVerificar1;
//														$InsFichaAccionProducto1->FapVerificar2 = $InsFichaAccionMantenimiento1->FaaVerificar2;
//							
//														$InsFichaAccionProducto1->FapCantidad = eregi_replace(",","",$_POST['Cmp'.$DatSesionObjeto->Parametro3.'ProductoCantidad']);
//														$InsFichaAccionProducto1->UmeId = $_POST['Cmp'.$DatSesionObjeto->Parametro3.'ProductoUnidadMedidaConvertir'];	
//														
//														$InsFichaAccionProducto1->FaaId = $InsFichaAccionMantenimiento1->FaaId;
//														
//														$InsFichaAccionProducto1->FapEstado = 3;
//														$InsFichaAccionProducto1->FapTiempoCreacion = date("Y-m-d H:i:s");
//														$InsFichaAccionProducto1->FapTiempoModificacion = date("Y-m-d H:i:s");
//														$InsFichaAccionProducto1->FapEliminado = 1;				
//														
//														$InsFichaAccionProducto1->ProNombre = $InsProducto->ProNombre;
//														$InsFichaAccionProducto1->RtiId= $InsProducto->RtiId;
//														$InsFichaAccionProducto1->UmeNombre= $InsUnidadMedida->UmeNombre;
//														$InsFichaAccionProducto1->UmeIdOrigen= $InsProducto->UmeId;
//																									
//														$InsUnidadMedida->UmeId = $InsFichaAccionProducto1->UmeId;
//														$InsUnidadMedida->MtdObtenerUnidadMedida();
//														
//														if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
//															$InsUnidadMedidaConversion->UmcEquivalente = 1;
//														}else{
//															$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
//															$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
//															
//															foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
//																$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
//															}
//														}
//						
//														if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
//															$InsFichaAccionProducto1->FapCantidadReal = round($InsFichaAccionProducto1->FapCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
//														}else{
//															$InsFichaAccionProducto1->FapCantidadReal = '';
//														}
//			
//														$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;	
//			
//			
//			/*
//			
//			SesionObjeto-FichaAccionMantenimiento
//Parametro1 = FaaId
//Parametro2 = 
//Parametro3 = PmtId
//Parametro4 = FaaAccion
//Parametro5 = FaaTiempoCreacion
//Parametro6 = FaaTiempoModificacion
//Parametro7 = FaaNivel
//Parametro8 = FaaVerificar1
//Parametro9 = FaaVerificar2
//Parametro10 = FaaEstado
//
//Parametro11 = FapId
//Parametro12 = ProId
//Parametro13 = ProNombre
//Parametro14 = FapVerificar1
//Parametro15 = FapVerificar2
//Parametro16 = UmeId
//Parametro17 = FapTiempoCreacion
//Parametro18 = FapTiempoModificacion
//Parametro19 = FapCantidad
//Parametro20 = FapCantidadReal	
//Parametro21 = RtiId
//Parametro22 = UmeNombre
//Parametro23 = UmeIdOrigen
//Parametro24 = FapEstado
//			*/
//															$_SESSION['InsFichaAccionMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
//															$InsFichaAccionMantenimiento1->FaaId,
//															NULL,
//															$InsFichaAccionMantenimiento1->PmtId,
//															$InsFichaAccionMantenimiento1->FaaAccion,
//															$InsFichaAccionMantenimiento1->FaaTiempoCreacion,
//															$InsFichaAccionMantenimiento1->FapTiempoModificacion,
//															($InsFichaAccionMantenimiento1->FaaNivel),
//															($InsFichaAccionMantenimiento1->FaaVerificar1),
//															$InsFichaAccionMantenimiento1->FaaVerificar2,
//															$InsFichaAccionMantenimiento1->FaaEstado,
//															
//															$InsFichaAccionProducto1->FapId,
//															$InsFichaAccionProducto1->ProId,
//															$InsFichaAccionProducto1->ProNombre,
//															//"AAAAAAAAAAAAAAA",
//															$InsFichaAccionProducto1->FapVerificar1,
//															$InsFichaAccionProducto1->FapVerificar2,
//															$InsFichaAccionProducto1->UmeId,
//															$InsFichaAccionProducto1->FapTiempoCreacion,
//															$InsFichaAccionProducto1->FapTiempoModificacion,
//															$InsFichaAccionProducto1->FapCantidad,
//															$InsFichaAccionProducto1->FapCantidadReal,
//															$InsFichaAccionProducto1->RtiId,
//															$InsFichaAccionProducto1->UmeNombre,
//															$InsFichaAccionProducto1->UmeIdOrigen,
//															$InsFichaAccionProducto1->FapEstado);
//															
//													}else{
//													
//													}
//													
//												}else{
//													
//												}
//												
//											}
//											
//
//				
//										}
//										
//									}						
//								}
//		
//						}
//						
//						
//					}
//					
//					if(!empty($InsFichaAccion->FccId)){
//
//						$InsFichaAccion->Transaccion = true;
//						if($InsFichaAccion->MtdEditarFichaAccion()){
//							FncFichaAccionCargarDatos();
//							$validar++;
//							$Resultado.='#SAS_FCC_102';
//						}else{
//							$InsFichaAccion->FccFecha = FncCambiaFechaANormal($InsFichaAccion->FccFecha);		
//							$Resultado.='#ERR_FCC_102';
//						}
//
//					}else{
//						$validar++;
//					}
//
//					$ArrFichaAccion[] = $InsFichaAccion;			






			}
		}
			
			//deb(count($ArrModalidadIngresos)."  -  ".$validar );
		
			//if(count($ArrModalidadIngresos) == $validar){
			if(count($InsFichaIngreso->FichaIngresoModalidad) == $validar){	
				
				if($InsFichaIngreso->FinEstado == "2"){
					//ACTUALIZANDO A TALLER [Preparando Pedido]
					$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,3,false); //OJOOO

					//if($InsFichaIngreso->FinEstado == "3"){
						
						if($POST_FichaIngresoEnviar == "1"){
							//ACTUALIZANDO A TALLER [Pedido Enviado]
							$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,4);
						}
						
					//}

				}

				$Registro = true;

			}
		
}else{

	if(!empty($ArrModalidadIngresos)){
		foreach($ArrModalidadIngresos as $DatModalidadIngreso){

			unset($_SESSION['InsFichaAccionTarea'.$DatModalidadIngreso->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionProducto'.$DatModalidadIngreso->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]);

			$_SESSION['InsFichaAccionTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsFichaAccionProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
			$_SESSION['InsFichaAccionMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsFichaAccionSuministro'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();

		}
	}

	unset($_SESSION['InsFichaAccionHerramienta'.$Identificador]);

	$_SESSION['InsFichaAccionHerramienta'.$Identificador] = new ClsSesionObjeto();

	if($InsFichaIngreso->FinEstado == 11){

		$validar = 0;

		if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
			foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
	
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
	
				if(!empty($DatFichaIngresoModalidad->FichaIngresoTarea)){
					foreach($DatFichaIngresoModalidad->FichaIngresoTarea as $DatFichaIngresoTarea){
	
						if(!empty($DatFichaIngresoTarea->MinSigla)){ //AUX
	
							$InsFichaAccionTarea1 = new ClsFichaAccionTarea();
							$InsFichaAccionTarea1->FitId = $DatFichaIngresoTarea->FitId;
							$InsFichaAccionTarea1->FatDescripcion = $DatFichaIngresoTarea->FitDescripcion;
							$InsFichaAccionTarea1->FatAccion = $DatFichaIngresoTarea->FitAccion;
							$InsFichaAccionTarea1->FatVerificar1 = 2;
							$InsFichaAccionTarea1->FatVerificar2 = 2;
							$InsFichaAccionTarea1->FatEstado = 2;
							$InsFichaAccionTarea1->FatTiempoCreacion = date("Y-m-d H:i:s");
							$InsFichaAccionTarea1->FatTiempoModificacion = date("Y-m-d H:i:s");
							$InsFichaAccionTarea1->FatEliminado = 1;				
							$InsFichaAccionTarea1->InsMysql = NULL;
	
							$InsFichaAccion->FichaAccionTarea[] = $InsFichaAccionTarea1;		
	
						}
	
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

				if(!empty($DatFichaIngresoModalidad->FichaIngresoProducto)){
					foreach($DatFichaIngresoModalidad->FichaIngresoProducto as $DatFichaIngresoProducto){
					
						if(!empty($DatFichaIngresoProducto->MinSigla)){ //AUX
						
							if(!empty($DatFichaIngresoProducto->ProId) ){
								
								$InsFichaAccionProducto1 = new ClsFichaAccionProducto();
								$InsFichaAccionProducto1->ProId = $DatFichaIngresoProducto->ProId;
								$InsFichaAccionProducto1->UmeId = NULL;
								$InsFichaAccionProducto1->FapAccion = "C";	
								
								
								//switch($InsFichaIngreso->VmaId){
//									
//									case "VMA-10017"://CHEVROLET
//										$InsFichaAccionProducto1->FapAccion = "C";	
//									break;
//									
//									case "VMA-10018"://ISUZU
//										$InsFichaAccionProducto1->FapAccion = "R";
//									break;
//									
//									default:
//										$InsFichaAccionProducto1->FapAccion = "-";
//									break;
//													
//								}
								
								$InsFichaAccionProducto1->FapVerificar1 = 2;//SECAMBIO PRO DEFECTO 
								$InsFichaAccionProducto1->FapVerificar2 = 1;
								$InsFichaAccionProducto1->FapCantidad = 0;
								$InsFichaAccionProducto1->FapCantidadReal = 0;
								$InsFichaAccionProducto1->FapEstado = 2;						
								$InsFichaAccionProducto1->FapTiempoCreacion = date("Y-m-d H:i:s");
								$InsFichaAccionProducto1->FapTiempoModificacion = date("Y-m-d H:i:s");
								$InsFichaAccionProducto1->FapEliminado = 1;				
								$InsFichaAccionProducto1->InsMysql = NULL;
								
								$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;	

							}
							
						
						}
	
					}
				}


	//		SesionObjeto-FichaAccionSuministro
	//		Parametro1 = FasId
	//		Parametro2 = ProId
	//		Parametro3 = ProNombre
	//		Parametro4 = FasVerificar1
	//		Parametro5 = FasVeriticar2
	//		Parametro6 = UmeId
	//		Parametro7 = FasTiempoCreacion
	//		Parametro8 = FasTiempoModificacion
	//		Parametro9 = FasCantidad
	//		Parametro10 = FasCantidadReal		
	//		Parametro11 = FasEstado
	//		
				if(!empty($DatFichaIngresoModalidad->FichaIngresoSuministro)){
					foreach($DatFichaIngresoModalidad->FichaIngresoSuministro as $DatFichaIngresoSuministro){

						if(!empty($DatFichaIngresoSuministro->MinSigla)){ //AUX

							if(!empty($DatFichaIngresoSuministro->ProId)){

								$InsFichaAccionSuministro1 = new ClsFichaAccionSuministro();
								$InsFichaAccionSuministro1->ProId = $DatFichaIngresoSuministro->ProId;
								$InsFichaAccionSuministro1->UmeId = $DatFichaIngresoSuministro->UmeId;
								
								$InsFichaAccionSuministro1->FasAccion = "C";
								$InsFichaAccionSuministro1->FasVerificar1 = 1;//SE CAMBI POR DEFECTO
								$InsFichaAccionSuministro1->FasVerificar2 = 2;
								$InsFichaAccionSuministro1->FasCantidad = $DatFichaIngresoSuministro->FisCantidad;
								$InsFichaAccionSuministro1->FasCantidadReal = 0;
								$InsFichaAccionSuministro1->FasEstado = 2;						
								$InsFichaAccionSuministro1->FasTiempoCreacion = date("Y-m-d H:i:s");
								$InsFichaAccionSuministro1->FasTiempoModificacion = date("Y-m-d H:i:s");
								$InsFichaAccionSuministro1->FasEliminado = 1;				
								$InsFichaAccionSuministro1->InsMysql = NULL;

								$InsFichaAccion->FichaAccionSuministro[] = $InsFichaAccionSuministro1;	

							}

						}
	
					}
				}
				
//	SesionObjeto-FichaAccionMantenimiento
//	Parametro1 = FaaId
//	Parametro2 = 
//	Parametro3 = PmtId
//	Parametro4 = FaaAccion
//	Parametro5 = FaaTiempoCreacion
//	Parametro6 = FaaTiempoModificacion
//	Parametro7 = FaaNivel
//	Parametro8 = FaaVerificar1
//	Parametro9 = FaaVerificar2
//	Parametro10 = FaaEstado
//	
//	Parametro11 = FapId
//	Parametro12 = ProId
//	Parametro13 = ProNombre
//	Parametro14 = FapVerificar1
//	Parametro15 = FapVerificar2
//	Parametro16 = UmeId
//	Parametro17 = FapTiempoCreacion
//	Parametro18 = FapTiempoModificacion
//	Parametro19 = FapCantidad
//	Parametro20 = FapCantidadReal	
//	Parametro21 = RtiId
//	Parametro22 = UmeNombre
//	Parametro23 = UmeIdOrigen
//	Parametro24 = FapEstado
//	
//	Parametro25 = FiaId

				if($DatFichaIngresoModalidad->MinId == "MIN-10001"){

					if(!empty($DatFichaIngresoModalidad->FichaIngresoMantenimiento)){
						foreach($DatFichaIngresoModalidad->FichaIngresoMantenimiento as $DatFichaIngresoMantenimiento){

							if(!empty($DatFichaIngresoMantenimiento->MinSigla)){ //AUX

								$InsFichaAccionMantenimiento1 = new ClsFichaAccionMantenimiento();

								$InsFichaAccionMantenimiento1->PmtId = $DatFichaIngresoMantenimiento->PmtId;
								$InsFichaAccionMantenimiento1->FaaAccion = $DatFichaIngresoMantenimiento->FiaAccion;
								$InsFichaAccionMantenimiento1->FaaNivel = (($DatFichaIngresoMantenimiento->FidAccion == "X"))?'2':'1';
								$InsFichaAccionMantenimiento1->FaaVerificar1 = 1;
								$InsFichaAccionMantenimiento1->FaaVerificar2 = 1;
								$InsFichaAccionMantenimiento1->FaaEstado = 2;
								$InsFichaAccionMantenimiento1->FaaTiempoCreacion = date("Y-m-d H:i:s");
								$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");

								$InsFichaAccionMantenimiento1->FiaId = $DatFichaIngresoMantenimiento->FiaId;

								$InsFichaAccionMantenimiento1->InsMysql = NULL;
	
								$InsFichaAccion->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;
	
							}
		
						}
					}
						 
				}
	
				
				if($InsFichaAccion->MtdRegistrarFichaAccion()){
					$validar++;
					FncFichaAccionCargarDatos();
				}
				
				$ArrFichaAccion[] = $InsFichaAccion;			

			}
			
			
			if(count($InsFichaIngreso->FichaIngresoModalidad) == $validar){
				//ACTUALIZANDO A TALLER [Revisando]
				$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,2,false);//OJOO

			}
			
		}
				
				
		$InsFichaIngreso->FinTiempoTallerRevisando = date("Y-m-d H:i:s");
		$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
		$InsFichaIngreso->MtdEditarFichaIngresoTallerRevisando();
	
	
	}	
	
	
}

function FncFichaAccionCargarDatos(){

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
				$DatFichaAccionTarea->FitId
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
	
	Parametro25 = FiaId
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
//Parametro16 = FasAccion

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
						$DatFichaAccionSuministro->FasEstado,
						$DatFichaAccionSuministro->FasAccion);

					}
				}
				
				
			//deb($InsFichaAccion->FichaAccionMantenimiento);				
}

?>