<?php


function FncCargarFichaAccionDatos(){

	global $InsFichaAccion;
	global $InsFichaIngreso;
	global $Identificador;
	global $EmpresaMonedaId;
	
	
	$InsFichaAccion->MtdObtenerFichaAccion();

	unset($_SESSION['InsFichaAccionFoto'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsFichaAccionTarea'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsFichaAccionTempario'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsFichaAccionProducto'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsFichaAccionMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]);
	unset($_SESSION['InsFichaAccionSuministro'.$InsFichaAccion->MinSigla.$Identificador]);

	$_SESSION['InsFichaAccionFoto'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFichaAccionTarea'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFichaAccionTempario'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFichaAccionProducto'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFichaAccionMantenimiento'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFichaAccionSuministro'.$InsFichaAccion->MinSigla.$Identificador] = new ClsSesionObjeto();


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

	//deb($InsFichaIngreso->MonId);
	
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

	$InsFichaIngreso->MonId = $_POST['CmpMonedaId'];
	$InsFichaIngreso->FinTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsFichaIngreso->VveId = $_POST['CmpFichaIngresoVehiculoVersion'];
	$InsFichaIngreso->FinMantenimientoKilometraje = $_POST['CmpFichaIngresoMantenimientoKilometraje'];
	//$InsFichaIngreso->FinEstado = $_POST['CmpFichaIngresoEstado'];
	
	$InsFichaIngreso->VmaNomvre =($_POST['CmpFichaIngresoMarca']);
	$InsFichaIngreso->VmoNombre =($_POST['CmpFichaIngresoModelo']);
	$InsFichaIngreso->VveNombre =($_POST['CmpFichaIngresoVersion']);

	$InsFichaIngreso->FinFotoVIN =($_SESSION['SesFinFotoVIN'.$Identificador]);
	$InsFichaIngreso->FinFotoFrontal =($_SESSION['SesFinFotoFrontal'.$Identificador]);
	$InsFichaIngreso->FinFotoCupon =($_SESSION['SesFinFotoCupon'.$Identificador]);
	$InsFichaIngreso->FinFotoMantenimiento =($_SESSION['SesFinFotoMantenimiento'.$Identificador]);	
	
	$InsFichaIngreso->FinSalidaObservacion = addslashes($_POST['CmpObservacionSalida']);
	$InsFichaIngreso->FinTipo = ($_POST['CmpFichaIngresoTipo']);
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
	$InsFichaIngreso->FinMantenimientoKilometraje = ($_POST['CmpFichaIngresoMantenimientoKilometraje']);

	$InsFichaIngreso->MtdObtenerFichaIngresoEstado();


	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){


//deb($DatFichaIngresoModalidad->MinSigla);
			if($DatFichaIngresoModalidad->MinSigla == "PP"){
				
			
				$InsFichaAccion = new ClsFichaAccion();
				$InsFichaAccion->UsuId = $_SESSION['SesionId'];
				$InsFichaAccion->FccId = $_POST['CmpId_'.$DatFichaIngresoModalidad->MinSigla];
				$InsFichaAccion->FimId = $_POST['CmpFichaIngresoModalidadId_'.$DatFichaIngresoModalidad->MinSigla];

				$InsFichaAccion->FccFecha = FncCambiaFechaAMysql($_POST['CmpFecha_'.$DatFichaIngresoModalidad->MinSigla]);
				$InsFichaAccion->FccManoObra = 0;
				$InsFichaAccion->FccObservacion = addslashes($_POST['CmpObservacion_'.$DatFichaIngresoModalidad->MinSigla]);
				
				$InsFichaAccion->FccPedido = addslashes($_POST['CmpFichaAccionPedido_'.$DatFichaIngresoModalidad->MinSigla]);
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
				
					
					//if($DatFichaIngresoModalidad->MinSigla == "PP"){

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
							
							//deb($InsFichaAccionTarea1->FatCosto);
							
							$InsFichaAccionTarea1->FatAccion = $DatSesionObjeto->Parametro6;
							$InsFichaAccionTarea1->FatVerificar1 = $_POST['CmpFichaAccionTarea_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item];
							$InsFichaAccionTarea1->FatVerificar1 = (empty($InsFichaAccionTarea1->FatVerificar1))?2:$InsFichaAccionTarea1->FatVerificar1;
							$InsFichaAccionTarea1->FatVerificar2 = 2;
							
							
							
							$InsFichaAccionTarea1->FatEstado = $DatSesionObjeto->Parametro9;
							$InsFichaAccionTarea1->FatTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
							$InsFichaAccionTarea1->FatTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
							$InsFichaAccionTarea1->FatEliminado = $DatSesionObjeto->Eliminado;
							//$InsFichaAccionTarea1->FatEliminado = 1;				
							
							$InsFichaAccionTarea1->InsMysql = NULL;
							
							$InsFichaAccion->FichaAccionTarea[] = $InsFichaAccionTarea1;	
						
					
						}						
					}
	


					//}

					if(!empty($InsFichaAccion->FccId)){

						if($InsFichaAccion->MtdTrabajarFichaAccion()){

							FncCargarFichaAccionDatos();
							
							if(!empty($InsFichaAccion->FccPedido)){
								$InsFichaAccion->MtdNotificarFichaAccionPedido($InsFichaAccion->FccId,$CorreosNotificacionFichaAccionPedido);								
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


					
					$ArrFichaAccion[] = $InsFichaAccion;	

				}
			
			}
			
		}
	}
	
	//if(count($InsFichaIngreso->FichaIngresoModalidad) == $validar){
	if(1 == $validar){	
		$Resultado = '#SAS_FCC_102';
		$Edito = true;
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
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsPreEntregaDetalle'.$Identificador]);
	$_SESSION['InsPreEntregaDetalle'.$Identificador] = new ClsSesionObjeto();	
	
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
			
			unset($_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionTempario'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsFichaAccionFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);

			$_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsFichaAccionTempario'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();	
			$_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsFichaAccionFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();

		}
	}

	unset($_SESSION['InsFichaAccionHerramienta'.$Identificador]);

	$_SESSION['SesFinFotoVIN'.$Identificador] = $InsFichaIngreso->FinFotoVIN;
	$_SESSION['SesFinFotoFrontal'.$Identificador] = $InsFichaIngreso->FinFotoFrontal;
	$_SESSION['SesFinFotoCupon'.$Identificador] = $InsFichaIngreso->FinFotoCupon;
	$_SESSION['SesFinFotoMantenimiento'.$Identificador] = $InsFichaIngreso->FinFotoMantenimiento;

	$_SESSION['InsFichaAccionHerramienta'.$Identificador] = new ClsSesionObjeto();



	if(empty($InsFichaIngreso->MonId)){

		if(!empty($EmpresaMonedaId)){
			if($InsFichaIngreso->MtdEditarFichaIngresoDato("MonId",$EmpresaMonedaId,$InsFichaIngreso->FinId)){
				$InsFichaIngreso->MonId = $EmpresaMonedaId;
			}
		}

	}

	
				
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
			
			$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;
			
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

			$ArrFichaAccion[] = $InsFichaAccion;			

		}
	}


}

?>

