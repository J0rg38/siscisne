<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$ModalidadMantenimiento = false;
	$Guardar = true;
		
	$Resultado = '';
	$InsFichaIngreso->UsuId = $_SESSION['SesionId'];
	$InsFichaIngreso->CitId = $_POST['CmpCitaId'];
	
	$InsFichaIngreso->FinId = $_POST['CmpId'];
	$InsFichaIngreso->SucId = $_POST['CmpSucursal'];
	
	$InsFichaIngreso->CliId = $_POST['CmpClienteId'];
	$InsFichaIngreso->CamId = $_POST['CmpCampanaId'];
	$InsFichaIngreso->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	$InsFichaIngreso->ObsId = $_POST['CmpObsequioId'];

	$InsFichaIngreso->OvmId = $_POST['CmpOrdenVentaVehiculoMantenimientoId'];
	$InsFichaIngreso->ObsNombre = $_POST['CmpObsequioNombre'];
	$InsFichaIngreso->OvmKilometraje = $_POST['CmpOrdenVentaVehiculoMantenimientoKilometraje'];
	
	
	$InsFichaIngreso->FinFechaVenta = $_POST['CmpVehiculoPromocionFechaVenta'];
	$InsFichaIngreso->FinCantidadMantenimientos = $_POST['CmpVehiculoPromocionCantidadMantenimientos'];
	
	//$InsFichaIngreso->MonId = $_POST['CmpMonedaId'];
	$InsFichaIngreso->MonId = $EmpresaMonedaId;
	
//	deb($InsFichaIngreso->MonId);
	$InsFichaIngreso->FinTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsFichaIngreso->CamNombre = $_POST['CmpCampanaNombre'];
	$InsFichaIngreso->CamCodigo = $_POST['CmpCampanaCodigo'];
	
	$InsFichaIngreso->PerId = $_POST['CmpPersonal'];
	$InsFichaIngreso->PerIdAsesor = $_POST['CmpAsesor'];
	
	$InsFichaIngreso->PmaId = $_POST['CmpPlanMantenimientoId'];
	
	$InsFichaIngreso->EinId = $_POST['CmpVehiculoIngresoId'];	
	$InsFichaIngreso->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	
	$InsFichaIngreso->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsFichaIngreso->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsFichaIngreso->VveNombre = $_POST['CmpVehiculoIngresoVersion'];

	$InsFichaIngreso->VmaId = $_POST['CmpVehiculoIngresoMarcaId'];
	$InsFichaIngreso->VmoId = $_POST['CmpVehiculoIngresoModeloId'];
	$InsFichaIngreso->VveId = $_POST['CmpVehiculoIngresoVersionId'];


	$InsFichaIngreso->EinColor = $_POST['CmpVehiculoIngresoColor'];
	$InsFichaIngreso->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsFichaIngreso->EinAnoFabricacion = $_POST['CmpVehiculoIngresoAnoFabricacion'];
	
	$InsFichaIngreso->FinClienteEmail =($_POST['CmpClienteEmail']);
	$InsFichaIngreso->FinConductor = $_POST['CmpConductor'];
	$InsFichaIngreso->FinTelefono = $_POST['CmpClienteCelular'];
	$InsFichaIngreso->FinDireccion = $_POST['CmpClienteDireccion'];
	$InsFichaIngreso->FinContacto = $_POST['CmpClienteContacto'];
	
	$InsFichaIngreso->FinFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsFichaIngreso->FinFechaActividad = $InsFichaIngreso->FinFecha;
	
	list($InsFichaIngreso->FinAno,$Mes,$Dia) = explode("-",$InsFichaIngreso->FinFecha);

	$InsFichaIngreso->FinFechaEntrega = FncCambiaFechaAMysql($_POST['CmpFechaEntrega'],true);
	$InsFichaIngreso->FinHoraEntrega = ($_POST['CmpHoraEntrega']);
	
	$InsFichaIngreso->FinFechaCita = FncCambiaFechaAMysql($_POST['CmpFechaCita'],true);
	$InsFichaIngreso->FinHora = ($_POST['CmpHora']);
	$InsFichaIngreso->FinObservacion = addslashes($_POST['CmpObservacion']);
	$InsFichaIngreso->MinId = $_POST['CmpModalidad'];
	
	$InsFichaIngreso->TreId = $_POST['CmpTipoReparacion'];
	
	$InsFichaIngreso->FinExteriorDelantero1 = $_POST['CmpExteriorDelantero1'];
	$InsFichaIngreso->FinExteriorDelantero2 = $_POST['CmpExteriorDelantero2'];
	$InsFichaIngreso->FinExteriorDelantero3 = $_POST['CmpExteriorDelantero3'];
	$InsFichaIngreso->FinExteriorDelantero4 = $_POST['CmpExteriorDelantero4'];
	$InsFichaIngreso->FinExteriorDelantero5 = $_POST['CmpExteriorDelantero5'];
	$InsFichaIngreso->FinExteriorDelantero6 = $_POST['CmpExteriorDelantero6'];
	$InsFichaIngreso->FinExteriorDelantero7 = $_POST['CmpExteriorDelantero7'];
	
	$InsFichaIngreso->FinExteriorPosterior1 = $_POST['CmpExteriorPosterior1'];
	$InsFichaIngreso->FinExteriorPosterior2 = $_POST['CmpExteriorPosterior2'];
	$InsFichaIngreso->FinExteriorPosterior3 = $_POST['CmpExteriorPosterior3'];
	$InsFichaIngreso->FinExteriorPosterior4 = $_POST['CmpExteriorPosterior4'];
	$InsFichaIngreso->FinExteriorPosterior5 = $_POST['CmpExteriorPosterior5'];
	$InsFichaIngreso->FinExteriorPosterior6 = $_POST['CmpExteriorPosterior6'];
	
	$InsFichaIngreso->FinExteriorDerecho1 = $_POST['CmpExteriorDerecho1'];
	$InsFichaIngreso->FinExteriorDerecho2 = $_POST['CmpExteriorDerecho2'];
	$InsFichaIngreso->FinExteriorDerecho3 = $_POST['CmpExteriorDerecho3'];
	$InsFichaIngreso->FinExteriorDerecho4 = $_POST['CmpExteriorDerecho4'];
	$InsFichaIngreso->FinExteriorDerecho5 = $_POST['CmpExteriorDerecho5'];
	$InsFichaIngreso->FinExteriorDerecho6 = $_POST['CmpExteriorDerecho6'];
	$InsFichaIngreso->FinExteriorDerecho7 = $_POST['CmpExteriorDerecho7'];
	$InsFichaIngreso->FinExteriorDerecho8 = $_POST['CmpExteriorDerecho8'];
	
	$InsFichaIngreso->FinExteriorIzquierdo1 = $_POST['CmpExteriorIzquierdo1'];
	$InsFichaIngreso->FinExteriorIzquierdo2 = $_POST['CmpExteriorIzquierdo2'];
	$InsFichaIngreso->FinExteriorIzquierdo3 = $_POST['CmpExteriorIzquierdo3'];
	$InsFichaIngreso->FinExteriorIzquierdo4 = $_POST['CmpExteriorIzquierdo4'];
	$InsFichaIngreso->FinExteriorIzquierdo5 = $_POST['CmpExteriorIzquierdo5'];
	$InsFichaIngreso->FinExteriorIzquierdo6 = $_POST['CmpExteriorIzquierdo6'];
	$InsFichaIngreso->FinExteriorIzquierdo7 = $_POST['CmpExteriorIzquierdo7'];
	
	$InsFichaIngreso->FinInterior1 = $_POST['CmpInterior1'];
	$InsFichaIngreso->FinInterior2 = $_POST['CmpInterior2'];
	$InsFichaIngreso->FinInterior3 = $_POST['CmpInterior3'];
	$InsFichaIngreso->FinInterior4 = $_POST['CmpInterior4'];
	$InsFichaIngreso->FinInterior5 = $_POST['CmpInterior5'];
	$InsFichaIngreso->FinInterior6 = $_POST['CmpInterior6'];
	$InsFichaIngreso->FinInterior7 = $_POST['CmpInterior7'];
	$InsFichaIngreso->FinInterior8 = $_POST['CmpInterior8'];
	$InsFichaIngreso->FinInterior9 = $_POST['CmpInterior9'];
	$InsFichaIngreso->FinInterior10 = $_POST['CmpInterior10'];
	$InsFichaIngreso->FinInterior11 = $_POST['CmpInterior11'];
	$InsFichaIngreso->FinInterior12 = $_POST['CmpInterior12'];
	$InsFichaIngreso->FinInterior13 = $_POST['CmpInterior13'];
	$InsFichaIngreso->FinInterior14 = $_POST['CmpInterior14'];
	$InsFichaIngreso->FinInterior15 = $_POST['CmpInterior15'];
	$InsFichaIngreso->FinInterior16 = $_POST['CmpInterior16'];
	$InsFichaIngreso->FinInterior17 = $_POST['CmpInterior17'];
	$InsFichaIngreso->FinInterior18 = $_POST['CmpInterior18'];
	$InsFichaIngreso->FinInterior19 = $_POST['CmpInterior19'];
	$InsFichaIngreso->FinInterior20 = $_POST['CmpInterior20'];
	$InsFichaIngreso->FinInterior21 = $_POST['CmpInterior21'];
	$InsFichaIngreso->FinInterior22 = $_POST['CmpInterior22'];
	$InsFichaIngreso->FinInterior23 = $_POST['CmpInterior23'];
	$InsFichaIngreso->FinInterior24 = $_POST['CmpInterior24'];
	$InsFichaIngreso->FinInterior25 = $_POST['CmpInterior25'];
	$InsFichaIngreso->FinInterior26 = $_POST['CmpInterior26'];
	$InsFichaIngreso->FinInterior27 = $_POST['CmpInterior27'];	
	
	$InsFichaIngreso->FinReferencia = $_POST['CmpReferencia'];
	
	
	$InsFichaIngreso->FinNota = addslashes($_POST['CmpNota']);	
	$InsFichaIngreso->FinIndicacionTecnico = addslashes($_POST['CmpIndicacionTecnico']);	
	
	$InsFichaIngreso->FinInformeTecnicoMantenimiento = $_POST['CmpMantenimiento'];	
	$InsFichaIngreso->FinInformeTecnicoRevision = $_POST['CmpRevision'];	
	$InsFichaIngreso->FinInformeTecnicoDiagnostico = $_POST['CmpDiagnostico'];	
	
	$InsFichaIngreso->FinSalidaFecha = FncCambiaFechaAMysql($_POST['CmpSalidaFecha'],true);
	$InsFichaIngreso->FinSalidaHora = $_POST['CmpSalidaHora'];
	$InsFichaIngreso->FinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsFichaIngreso->FinSalidaObservacion = $_POST['CmpSalidaObservacion'];	

	$InsFichaIngreso->FinVehiculoKilometraje = $_POST['CmpVehiculoKilometraje'];	
	$InsFichaIngreso->FinMantenimientoKilometraje = (empty($_POST['CmpMantenimientoKilometraje'])?0:$_POST['CmpMantenimientoKilometraje']);	
	
	$InsFichaIngreso->FinPrecioEstimado = 0;

	$InsFichaIngreso->FinPrioridad = $_POST['CmpPrioridad'];	
	
	$InsFichaIngreso->FinMontoPresupuesto = eregi_replace(",","",(empty($_POST['CmpMontoPresupuesto'])?0:$_POST['CmpMontoPresupuesto']));
	$InsFichaIngreso->FinTipo = 1;	
	$InsFichaIngreso->FinCita = $_POST['CmpCita'];
	$InsFichaIngreso->FinEstado = $_POST['CmpEstado'];	
	$InsFichaIngreso->FinTiempoCreacion = date("Y-m-d H:i:s");
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
	$InsFichaIngreso->FinEliminado = 1;
	
	$InsFichaIngreso->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsFichaIngreso->CliNombreCompleto = addslashes($_POST['CmpClienteNombre']);
	$InsFichaIngreso->CliNombre = addslashes($_POST['CmpClienteNombre']);
	$InsFichaIngreso->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsFichaIngreso->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsFichaIngreso->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	
	list($InsFichaIngreso->FinAno,$Mes,$Dia) = explode("-",$InsFichaIngreso->FinFecha);
	
	$InsFichaIngreso->FichaIngresoModalidad = array();

//	$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId) ;
//	$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
//						
//	$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
//	$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
//			
//	$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
//	unset($ArrPlanMantenimientos);
//	$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
//						
//	$InsFichaIngreso->PmaId = $InsPlanMantenimiento->PmaId;
//	

	$ModalidadMantenimiento = false;

	foreach($ArrModalidadIngresos as $DatModalidadIngreso){
		if(!empty($DatModalidadIngreso->MinId)){
			if($_POST['CmpModalidadId_'.$DatModalidadIngreso->MinSigla] == "MIN-10001"){
				$ModalidadMantenimiento = true;;
			}
		}
	}
	


	if(empty($InsFichaIngreso->VmoId)){
		
		$Resultado.='#ERR_FIN_608';
		$Guardar = false;
			
	}

	if($ModalidadMantenimiento){

			//$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId) ;
//			$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
//			
//			$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
//			unset($ArrPlanMantenimientos);
//			$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
//						
//			$InsFichaIngreso->PmaId = $InsPlanMantenimiento->PmaId;

		
		if(empty($InsFichaIngreso->PmaId)){
			$Resultado.='#ERR_FIN_606';
			$Guardar = false;
		}
		
	}


deb($InsFichaIngreso->PmaId );

	foreach($ArrModalidadIngresos as $DatModalidadIngreso){

		$InsFichaIngresoModalidad1 = new ClsFichaIngresoModalidad();
		$InsFichaIngresoModalidad1->MinId = $_POST['CmpModalidadId_'.$DatModalidadIngreso->MinSigla];
		$InsFichaIngresoModalidad1->FimObsequio = empty($_POST['CmpFichaIngresoModalidadObsequio_'.$DatModalidadIngreso->MinSigla])?2:1;
	
		$InsFichaIngresoModalidad1->FimEstado = 1;
		$InsFichaIngresoModalidad1->FimTiempoCreacion = date("Y-m-d H:i:s");
		$InsFichaIngresoModalidad1->FimTiempoModificacion = date("Y-m-d H:i:s");
		$InsFichaIngresoModalidad1->InsMysql = NULL;

		if(!empty($InsFichaIngresoModalidad1->MinId)){
		
				//SesionObjeto-FichaIngresoProducto
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

			$ResFichaIngresoProducto = $_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);

			if(!empty($ResFichaIngresoProducto['Datos'])){
				$item = 1;
				foreach($ResFichaIngresoProducto['Datos'] as $DatSesionObjeto){

					$InsFichaIngresoProducto1 = new ClsFichaIngresoProducto();
					$InsFichaIngresoProducto1->ProId = $DatSesionObjeto->Parametro2;
					
					$InsFichaIngresoProducto1->UmeId = $DatSesionObjeto->Parametro6;
					$InsFichaIngresoProducto1->FipCantidad = $DatSesionObjeto->Parametro9;	
					$InsFichaIngresoProducto1->FipCantidadReal = $DatSesionObjeto->Parametro10;
					$InsFichaIngresoProducto1->FipPrecio = $DatSesionObjeto->Parmaetro19;	
					$InsFichaIngresoProducto1->FipImporte = $DatSesionObjeto->Parmaetro20;	
				
					$InsFichaIngresoProducto1->FipVerificar1 = 1;
				
					$InsFichaIngresoProducto1->FipEstado = 1;
					$InsFichaIngresoProducto1->FipTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
					$InsFichaIngresoProducto1->FipTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
					
					$InsFichaIngresoProducto1->FipEliminado = $DatSesionObjeto->Eliminado;				
					$InsFichaIngresoProducto1->InsMysql = NULL;
		
					$InsFichaIngresoModalidad1->FichaIngresoProducto[] = $InsFichaIngresoProducto1;	
					
					$item++;	
				}	
	
			}
	
			/*
			SesionObjeto-FichaIngresoTarea
			Parametro1 = FitId
			Parametro2 =
			Parametro3 = FitDescripcion
			Parametro4 = FitCantidad
			Parametro5 = 
			Parametro6 = FitAccion
			Parametro7 = FitTiempoCreacion
			Parametro8 = FitTiempoModificacion
			Parametro9 = FitPrecio
			Parametro10= FitImporte
			*/
	
			$ResFichaIngresoTarea = $_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
		
			if(!empty($ResFichaIngresoTarea['Datos'])){
				$item = 1;
				foreach($ResFichaIngresoTarea['Datos'] as $DatSesionObjeto){
						
					$InsFichaIngresoTarea1 = new ClsFichaIngresoTarea();
					$InsFichaIngresoTarea1->FitDescripcion = $DatSesionObjeto->Parametro3;
					
					$InsFichaIngresoTarea1->FitCantidad = $DatSesionObjeto->Parametro4;
					$InsFichaIngresoTarea1->FitPrecio = $DatSesionObjeto->Parametro9;
					$InsFichaIngresoTarea1->FitImporte = $DatSesionObjeto->Parametro10;
					
					$InsFichaIngresoTarea1->FitAccion = $DatSesionObjeto->Parametro6;
					$InsFichaIngresoTarea1->FitEstado = 1;
					$InsFichaIngresoTarea1->FitTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
					$InsFichaIngresoTarea1->FitTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
					
					$InsFichaIngresoTarea1->FitEliminado = $DatSesionObjeto->Eliminado;				
					$InsFichaIngresoTarea1->InsMysql = NULL;
		
					$InsFichaIngresoModalidad1->FichaIngresoTarea[] = $InsFichaIngresoTarea1;	
					
					$item++;	
				}
	
			}
			
			
			
			/*
			SesionObjeto-FichaIngresoManoObra
			Parametro1 = FmoId
			Parametro2 =
			Parametro3 = FmoDescripcion
			Parametro4 = FmoImporte
			Parametro5 =
			Parametro6 = FmoEstado
			Parametro7 = FmoTiempoCreacion
			Parametro8 = FmoTiempoModificacion
			*/
			
			$ResFichaIngresoManoObra = $_SESSION['InsFichaIngresoManoObra'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
		
			if(!empty($ResFichaIngresoManoObra['Datos'])){
				$item = 1;
				foreach($ResFichaIngresoManoObra['Datos'] as $DatSesionObjeto){
						
					$InsFichaIngresoManoObra1 = new ClsFichaIngresoTarea();
					$InsFichaIngresoManoObra1->FmoDescripcion = $DatSesionObjeto->Parametro3;
					$InsFichaIngresoManoObra1->FmoImporte = $DatSesionObjeto->Parametro4;
					$InsFichaIngresoManoObra1->FmoEstado = $DatSesionObjeto->Parametro6;
					$InsFichaIngresoManoObra1->FmoTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
					$InsFichaIngresoManoObra1->FmoTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
					
					$InsFichaIngresoManoObra1->FmoEliminado = $DatSesionObjeto->Eliminado;				
					$InsFichaIngresoManoObra1->InsMysql = NULL;
		
					$InsFichaIngresoModalidad1->FichaIngresoManoObra[] = $InsFichaIngresoManoObra1;	
					
					$item++;	
				}
	
			}
			
			//SesionObjeto-FichaIngresoSuministro
			//Parametro1 = FisId
			//Parametro2 = ProId
			//Parametro3 = ProNombre
			//Parametro4 = 
			//Parametro5 = 
			//Parametro6 = UmeId
			//Parametro7 = FisTiempoCreacion
			//Parametro8 = FisTiempoModificacion
			//Parametro9 = FisCantidad
			//Parametro10 = FisCantidadReal	
			//Parametro11 = RtiId
			//Parametro12 = UmeNombre
			//Parametro13 = UmeIdOrigen

			$ResFichaIngresoSuministro = $_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
		
			if(!empty($ResFichaIngresoSuministro['Datos'])){
				$item = 1;
				foreach($ResFichaIngresoSuministro['Datos'] as $DatSesionObjeto){
						
					$InsFichaIngresoSuministro1 = new ClsFichaIngresoSuministro();
					$InsFichaIngresoSuministro1->ProId = $DatSesionObjeto->Parametro2;
					$InsFichaIngresoSuministro1->UmeId = $DatSesionObjeto->Parametro6;
					$InsFichaIngresoSuministro1->FisCantidad = $DatSesionObjeto->Parametro9;
					
					$InsFichaIngresoSuministro1->FisEstado = 1;
					$InsFichaIngresoSuministro1->FisTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
					$InsFichaIngresoSuministro1->FisTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
					
					$InsFichaIngresoSuministro1->FisEliminado = $DatSesionObjeto->Eliminado;				
					$InsFichaIngresoSuministro1->InsMysql = NULL;
		
					$InsFichaIngresoModalidad1->FichaIngresoSuministro[] = $InsFichaIngresoSuministro1;	
					
					$item++;	
				}	
	
			}
			
	
			if($DatModalidadIngreso->MinId == "MIN-10001"){
			
				//$ModalidadMantenimiento = true;
//
//			$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId) ;
//			$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
//						
//			$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
//			$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
//			
//			$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
//			unset($ArrPlanMantenimientos);
//			$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
//						
//			$InsFichaIngreso->PmaId = $InsPlanMantenimiento->PmaId;

				$RepSesionObjetos = $_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
				$ArrSesionObjetos = $RepSesionObjetos['Datos'];


				if(!empty($ArrSesionObjetos)){
					foreach($ArrSesionObjetos as $DatSesionObjeto){

						if(!empty($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatSesionObjeto->Parametro3])){
			
			
							//deb( $_POST['CmpFichaIngresoMantenimientoProductoId_'.$DatSesionObjeto->Parametro3]);
							
							$InsFichaIngresoMantenimiento1 = new ClsFichaIngresoMantenimiento();
							$InsFichaIngresoMantenimiento1->PmtId = $DatSesionObjeto->Parametro3;
							$InsFichaIngresoMantenimiento1->FiaId = $_POST['CmpPlanMantenimientoDetalleId_'.$DatSesionObjeto->Parametro3];
							$InsFichaIngresoMantenimiento1->FiaAccion = $_POST['CmpPlanMantenimientoDetalleAccion_'.$DatSesionObjeto->Parametro3];
							
							$InsFichaIngresoMantenimiento1->ProId = $_POST['CmpFichaIngresoMantenimientoProductoId_'.$DatSesionObjeto->Parametro3];
							
							
							$InsFichaIngresoMantenimiento1->FiaNivel = 2;
							$InsFichaIngresoMantenimiento1->FiaVerificar1 = 2;
							$InsFichaIngresoMantenimiento1->FiaVerificar2 = 2;
							$InsFichaIngresoMantenimiento1->FiaEstado = 2;
							$InsFichaIngresoMantenimiento1->FiaTiempoCreacion = date("Y-m-d H:i:s");
							$InsFichaIngresoMantenimiento1->FiaTiempoModificacion = date("Y-m-d H:i:s");

							$InsFichaIngresoMantenimiento1->InsMysql = NULL;

							$InsFichaIngresoModalidad1->FichaIngresoMantenimiento[] = $InsFichaIngresoMantenimiento1;	

							$_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
							$InsFichaIngresoMantenimiento1->FiaId,
							NULL,
							$InsFichaIngresoMantenimiento1->PmtId,
							$InsFichaIngresoMantenimiento1->FiaAccion,
							$InsFichaIngresoMantenimiento1->FiaTiempoCreacion,
							$InsFichaIngresoMantenimiento1->FiaTiempoModificacion,
							($InsFichaIngresoMantenimiento1->FiaNivel),
							($InsFichaIngresoMantenimiento1->FiaVerificar1),
							$InsFichaIngresoMantenimiento1->FiaVerificar2,
							$InsFichaIngresoMantenimiento1->FiaEstado,
							$InsFichaIngresoMantenimiento1->ProId
							);
							
						}else{
								
						}
						
					}		
									
				}else{
					
					unset($_SESSION['InsFichaIngresoMantenimento'.$DatModalidadIngreso->MinSigla.$Identificador]);
					$_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	

					//$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId) ;
//					$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
					
					$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
					$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
			
					//$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
//					unset($ArrPlanMantenimientos);
					$InsPlanMantenimiento->PmaId = $InsFichaIngreso->PmaId;
					$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
					//$InsFichaIngreso->PmaId = $InsPlanMantenimiento->PmaId;
						
						foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
						
							$PlanMantenimientoDetalleAccion = '';
							
							$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtNombre','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
							$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];

							foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){

								switch($InsPlanMantenimiento->VmaId){

									//case "VMA-10017"://CHEVROLET
									default://CHEVROLET
									
										foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
		
											$PlanMantenimientoDetalleAccion = '';
		
											if($InsFichaIngreso->FinMantenimientoKilometraje == $DatKilometro['km']){

												$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
												$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
												
												
												//deb($PlanMantenimientoDetalleAccion);
												//deb($_POST['CmpFichaIngresoMantenimientoProductoId_'.$DatPlanMantenimientoTarea->PmtId]);
												
												if(!empty( $PlanMantenimientoDetalleAccion)){
						
													$InsFichaIngresoMantenimiento1 = new ClsFichaIngresoMantenimiento();
													$InsFichaIngresoMantenimiento1->PmtId = $DatPlanMantenimientoTarea->PmtId;
													$InsFichaIngresoMantenimiento1->FiaId = $_POST['CmpPlanMantenimientoDetalleId_'.$DatPlanMantenimientoTarea->PmtId];
													$InsFichaIngresoMantenimiento1->FiaAccion = (empty($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId])?$PlanMantenimientoDetalleAccion:$_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]);
													$InsFichaIngresoMantenimiento1->ProId = $_POST['CmpFichaIngresoMantenimientoProductoId_'.$DatPlanMantenimientoTarea->PmtId];
													
													$InsFichaIngresoMantenimiento1->FiaNivel = 2;
													$InsFichaIngresoMantenimiento1->FiaVerificar1 = 2;
													$InsFichaIngresoMantenimiento1->FiaVerificar2 = 2;
													$InsFichaIngresoMantenimiento1->FiaEstado = 2;
													$InsFichaIngresoMantenimiento1->FiaTiempoCreacion = date("Y-m-d H:i:s");
													$InsFichaIngresoMantenimiento1->FiaTiempoModificacion = date("Y-m-d H:i:s");
						
													$InsFichaIngresoMantenimiento1->InsMysql = NULL;
						
													$InsFichaIngresoModalidad1->FichaIngresoMantenimiento[] = $InsFichaIngresoMantenimiento1;	
						
													$_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
													$InsFichaIngresoMantenimiento1->FiaId,
													NULL,
													$InsFichaIngresoMantenimiento1->PmtId,
													$InsFichaIngresoMantenimiento1->FiaAccion,
													$InsFichaIngresoMantenimiento1->FiaTiempoCreacion,
													$InsFichaIngresoMantenimiento1->FiaTiempoModificacion,
													($InsFichaIngresoMantenimiento1->FiaNivel),
													($InsFichaIngresoMantenimiento1->FiaVerificar1),
													$InsFichaIngresoMantenimiento1->FiaVerificar2,
													$InsFichaIngresoMantenimiento1->FiaEstado,
													$InsFichaIngresoMantenimiento1->ProId
													);
			
												}
											
												break;
											}
															
										}

									break;

									case "VMA-10018"://ISUZU

										foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
		
											$PlanMantenimientoDetalleAccion = '';
		
											if($InsFichaIngreso->FinMantenimientoKilometraje==$DatKilometro['km']){
		
												$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
												$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
												
												if(!empty( $PlanMantenimientoDetalleAccion)){
					
													$InsFichaIngresoMantenimiento1 = new ClsFichaIngresoMantenimiento();
													$InsFichaIngresoMantenimiento1->PmtId = $DatPlanMantenimientoTarea->PmtId;
													$InsFichaIngresoMantenimiento1->FiaId = $_POST['CmpPlanMantenimientoDetalleId_'.$DatPlanMantenimientoTarea->PmtId];
													//$InsFichaIngresoMantenimiento1->FiaAccion = $_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId];
													$InsFichaIngresoMantenimiento1->FiaAccion = (empty($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId])?$PlanMantenimientoDetalleAccion:$_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId]);
													
													$InsFichaIngresoMantenimiento1->ProId = $_POST['CmpFichaIngresoMantenimientoProductoId_'.$DatPlanMantenimientoTarea->PmtId];
													
													$InsFichaIngresoMantenimiento1->FiaNivel = 2;
													$InsFichaIngresoMantenimiento1->FiaVerificar1 = 2;
													$InsFichaIngresoMantenimiento1->FiaVerificar2 = 2;
													$InsFichaIngresoMantenimiento1->FiaEstado = 2;
													$InsFichaIngresoMantenimiento1->FiaTiempoCreacion = date("Y-m-d H:i:s");
													$InsFichaIngresoMantenimiento1->FiaTiempoModificacion = date("Y-m-d H:i:s");
						
													$InsFichaIngresoMantenimiento1->InsMysql = NULL;
						
													$InsFichaIngresoModalidad1->FichaIngresoMantenimiento[] = $InsFichaIngresoMantenimiento1;	
						
													$_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
													$InsFichaIngresoMantenimiento1->FiaId,
													NULL,
													$InsFichaIngresoMantenimiento1->PmtId,
													$InsFichaIngresoMantenimiento1->FiaAccion,
													$InsFichaIngresoMantenimiento1->FiaTiempoCreacion,
													$InsFichaIngresoMantenimiento1->FiaTiempoModificacion,
													($InsFichaIngresoMantenimiento1->FiaNivel),
													($InsFichaIngresoMantenimiento1->FiaVerificar1),
													$InsFichaIngresoMantenimiento1->FiaVerificar2,
													$InsFichaIngresoMantenimiento1->FiaEstado,
													$InsFichaIngresoMantenimiento1->ProId
													);
		
												}
											
												
												break;
		
											}
											
											
																	
										}

									break;
									
									case "":
										//die("No se encontro la MARCA DEL VEHICULO");
									break;

								}
								
							}
							
						}
			
			
			
					
				
				}
				
				
				if(empty($_POST['CmpPlanMantenimientoIdAux'])){
					
					$Resultado.='#ERR_FIN_609';				
					$Guardar = false;
					
				}

			}

			if($DatModalidadIngreso->MinSigla == "GA"){
				$InsFichaIngreso->FinFechaGarantia = date("Y-m-d");
			}

			$InsFichaIngreso->FichaIngresoModalidad[] = $InsFichaIngresoModalidad1;	

		}	

	}

	if($ModalidadMantenimiento){
		if(empty($InsFichaIngreso->FinMantenimientoKilometraje)){
			$Resultado.='#ERR_FIN_603';
			$Guardar = false;
		}
		
	//	if(empty($InsPlanMantenimiento->PmaId)){
//			$Resultado.='#ERR_FIN_606';
//			$Guardar = false;
//		}
		
		
	}


	
	if(empty($InsFichaIngreso->FichaIngresoModalidad)){
		$Resultado.='#ERR_FIN_607';
		$Guardar = false;
	}
	
	if($Guardar){
		if($InsFichaIngreso->MtdRegistrarFichaIngreso()){
			
			$InsVehiculoIngreso = new ClsVehiculoIngreso();
			$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinKilometraje",$InsFichaIngreso->FinVehiculoKilometraje,$InsFichaIngreso->EinId);
			
			$Resultado.='#ORDEN DE TRABAJO NUMERO: '.$InsFichaIngreso->FinId;
	
			unset($InsFichaIngreso);
			$InsFichaIngreso = new ClsFichaIngreso();
			
				foreach($ArrModalidadIngresos as $DatModalidadIngreso){
					
					unset($_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador]);
					unset($_SESSION['InsFichaIngresoManoObra'.$DatModalidadIngreso->MinSigla.$Identificador]);
					unset($_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador]);
					unset($_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]);
					unset($_SESSION['InsFichaIngresoMantenimento'.$DatModalidadIngreso->MinSigla.$Identificador]);
			
					$_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
					$_SESSION['InsFichaIngresoManoObra'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
					$_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
					$_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
					$_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
			
				}
		
			$Registro = true;
			$InsFichaIngreso->FinEstado = 1;
			$InsFichaIngreso->FinPrioridad = 2;
			$InsFichaIngreso->FinFecha = date("d/m/Y");	
			$Resultado.='#SAS_FIN_101';	
			
			
			$InsFichaIngreso->CprId = $_POST['CmpCotizacionProductoId'];	
			
			if(!empty($InsFichaIngreso->CprId)){
				
				$InsCotizacionProducto->MtdEditarCotizacionProductoDato("FinId",$InsFichaIngreso->FinId,$InsFichaIngreso->CprId);
				
				if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,11,true)){
					
					$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,4,true);
					
				}
			}
	
		} else{
			
			$InsFichaIngreso->FinId = "";
			$InsFichaIngreso->FinFecha = FncCambiaFechaANormal($InsFichaIngreso->FinFecha);
			$InsFichaIngreso->FinFechaEntrega = FncCambiaFechaANormal($InsFichaIngreso->FinFechaEntrega,true);
			$InsFichaIngreso->FinFechaCita = FncCambiaFechaANormal($InsFichaIngreso->FinFechaCita,true);
			$InsFichaIngreso->FinSalidaFecha = FncCambiaFechaANormal($InsFichaIngreso->FinSalidaFecha,true);
			$Resultado.='#ERR_FIN_101';
		}	
	}else{
		
		$InsFichaIngreso->FinId = "";
			$InsFichaIngreso->FinFecha = FncCambiaFechaANormal($InsFichaIngreso->FinFecha);
			$InsFichaIngreso->FinFechaEntrega = FncCambiaFechaANormal($InsFichaIngreso->FinFechaEntrega,true);
			$InsFichaIngreso->FinFechaCita = FncCambiaFechaANormal($InsFichaIngreso->FinFechaCita,true);
			$InsFichaIngreso->FinSalidaFecha = FncCambiaFechaANormal($InsFichaIngreso->FinSalidaFecha,true);
			$Resultado.='#ERR_FIN_101';
			
	}




}else{
	
	foreach($ArrModalidadIngresos as $DatModalidadIngreso){
		
		unset($_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador]);
		unset($_SESSION['InsFichaIngresoManoObra'.$DatModalidadIngreso->MinSigla.$Identificador]);
		unset($_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador]);
		unset($_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]);
		unset($_SESSION['InsFichaIngresoMantenimento'.$DatModalidadIngreso->MinSigla.$Identificador]);

		$_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
		$_SESSION['InsFichaIngresoManoObra'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
		$_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
		$_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
		$_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	

	}
	
//	unset($_SESSION['InsFichaIngresoTarea'.$Identificador]);
//	unset($_SESSION['InsFichaIngresoProducto'.$Identificador]);
//	
//	$_SESSION['InsFichaIngresoTarea'.$Identificador] = new ClsSesionObjeto();
//	$_SESSION['InsFichaIngresoProducto'.$Identificador] = new ClsSesionObjeto();
	
	$InsFichaIngreso->FinEstado = 1;
	$InsFichaIngreso->FinPrioridad = 2;
	$InsFichaIngreso->PerIdAsesor = $_SESSION['SesionPersonal'];
	$InsFichaIngreso->SucId = $_SESSION['SesionSucursal'];
	
	$InsFichaIngreso->FinExteriorDelantero1 = 1;
	$InsFichaIngreso->FinExteriorDelantero2 =  1;
	$InsFichaIngreso->FinExteriorDelantero3 =  1;
	$InsFichaIngreso->FinExteriorDelantero4 =  1;
	$InsFichaIngreso->FinExteriorDelantero5 = 1;
	$InsFichaIngreso->FinExteriorDelantero6 = 1;
	$InsFichaIngreso->FinExteriorDelantero7 = 1;
	
	$InsFichaIngreso->FinExteriorPosterior1 = 1;
	$InsFichaIngreso->FinExteriorPosterior2 = 1;
	$InsFichaIngreso->FinExteriorPosterior3 = 1;
	$InsFichaIngreso->FinExteriorPosterior4 = 1;
	$InsFichaIngreso->FinExteriorPosterior5 = 1;
	$InsFichaIngreso->FinExteriorPosterior6 = 1;
	
	$InsFichaIngreso->FinExteriorDerecho1 = 1;
	$InsFichaIngreso->FinExteriorDerecho2 =1;
	$InsFichaIngreso->FinExteriorDerecho3 = 1;
	$InsFichaIngreso->FinExteriorDerecho4 = 1;
	$InsFichaIngreso->FinExteriorDerecho5 =1;
	$InsFichaIngreso->FinExteriorDerecho6 =1;
	$InsFichaIngreso->FinExteriorDerecho7 = 1;
	$InsFichaIngreso->FinExteriorDerecho8 = 1;
	
	$InsFichaIngreso->FinExteriorIzquierdo1 = 1;
	$InsFichaIngreso->FinExteriorIzquierdo2 = 1;
	$InsFichaIngreso->FinExteriorIzquierdo3 = 1;
	$InsFichaIngreso->FinExteriorIzquierdo4 =1;
	$InsFichaIngreso->FinExteriorIzquierdo5 = 1;
	$InsFichaIngreso->FinExteriorIzquierdo6 =1;
	$InsFichaIngreso->FinExteriorIzquierdo7 = 1;
	
	
	$InsFichaIngreso->FinInterior1 = 1;
	$InsFichaIngreso->FinInterior2 = 1;
	$InsFichaIngreso->FinInterior3 = 1;
	$InsFichaIngreso->FinInterior4 =1;
	$InsFichaIngreso->FinInterior5 =1;
	$InsFichaIngreso->FinInterior6 =1;
	$InsFichaIngreso->FinInterior7 =1;
	$InsFichaIngreso->FinInterior8 =1;
	$InsFichaIngreso->FinInterior9 = 1;
	$InsFichaIngreso->FinInterior10 = 1;
	$InsFichaIngreso->FinInterior11 =1;
	$InsFichaIngreso->FinInterior12 =1;
	$InsFichaIngreso->FinInterior13 =1;
	$InsFichaIngreso->FinInterior14 = 1;
	$InsFichaIngreso->FinInterior15 =1;
	$InsFichaIngreso->FinInterior16 =1;
	$InsFichaIngreso->FinInterior17 =1;
	$InsFichaIngreso->FinInterior18 =1;
	$InsFichaIngreso->FinInterior19 = 1;
	$InsFichaIngreso->FinInterior20 = 1;
	$InsFichaIngreso->FinInterior21 = 1;
	$InsFichaIngreso->FinInterior22 =1;
	$InsFichaIngreso->FinInterior23 = 1;
	$InsFichaIngreso->FinInterior24 = 1;
	$InsFichaIngreso->FinInterior25 = 1;
	$InsFichaIngreso->FinInterior26 = 1;
	$InsFichaIngreso->FinInterior27 = 1;
	
	
	switch($GET_Origen){
		
		case "Cita":
			
			if(!empty($GET_CitId)){
				
				$InsCita = new ClsCita();
				$InsCita->CitId = $GET_CitId;
				$InsCita->MtdObtenerCita();
				
				$InsFichaIngreso->CitId = $InsCita->CitId;
				
				$InsFichaIngreso->CliId = $InsCita->CliId;
				$InsFichaIngreso->TdoId = $InsCita->TdoId;
				
				$InsFichaIngreso->CliNombreCompleto = $InsCita->CliNombreCompleto;
				$InsFichaIngreso->CliNombre = $InsCita->CliNombre;
				$InsFichaIngreso->CliApellidoPaterno = $InsCita->CliApellidoPaterno;
				$InsFichaIngreso->CliApellidoMaterno = $InsCita->CliApellidoMaterno;
				$InsFichaIngreso->CliNumeroDocumento = $InsCita->CliNumeroDocumento;
				$InsFichaIngreso->CliTelefono = $InsCita->CliTelefono;
				$InsFichaIngreso->CliCelular = $InsCita->CliCelular;
				$InsFichaIngreso->CliEmail = $InsCita->CliEmail;
				
				$InsFichaIngreso->CliDistrito = $InsCita->CliDistrito;
				$InsFichaIngreso->CliProvincia = $InsCita->CliProvincia;
				$InsFichaIngreso->CliDepartamento = $InsCita->CliDepartamento;
								
				$InsFichaIngreso->EinVIN = $InsCita->EinVIN;
				$InsFichaIngreso->VmaId = $InsCita->VmaId;
				$InsFichaIngreso->VmoId = $InsCita->VmoId;
				$InsFichaIngreso->VveId = $InsCita->VveId;
				
				$InsFichaIngreso->VmaNombre = $InsCita->VmaNombre;
				$InsFichaIngreso->VmoNombre = $InsCita->VmoNombre;
				$InsFichaIngreso->VveNombre = $InsCita->VveNombre;
				
				$InsFichaIngreso->EinId = $InsCita->EinId;
				$InsFichaIngreso->EinPlaca = $InsCita->EinPlaca;
				$InsFichaIngreso->EinColor = $InsCita->EinColor;
				$InsFichaIngreso->EinAnoFabricacion = $InsCita->EinAnoFabricacion;
				$InsFichaIngreso->EinAnoModelo = $InsCita->EinAnoModelo;
				$InsFichaIngreso->EinPlaca = $InsCita->EinPlaca;
				
				$InsFichaIngreso->FinTelefono = $InsCita->CliTelefono;
				$InsFichaIngreso->FinDireccion = $InsCita->CliDireccion;
				$InsFichaIngreso->FinContacto = $InsCita->CliCelular;
				$InsFichaIngreso->FinConductor = $InsCita->CliNombre." ".$InsCita->CliApellidoPaterno." ".$InsCita->CliApellidoMaterno;
				$InsFichaIngreso->PerIdAsesor = $InsCita->PerId;
				
				$InsFichaIngreso->FinMantenimientoKilometraje = $InsCita->CitKilometrajeMantenimiento;
				
				if(!empty($InsFichaIngreso->FinMantenimientoKilometraje)){
					
					$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
					$InsFichaIngresoModalidad->MinId = "MIN-10001";
					$InsFichaIngreso->FichaIngresoModalidad[] = $InsFichaIngresoModalidad;
					
					
					$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId) ;
					$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
					
					$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
					unset($ArrPlanMantenimientos);
					$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
					
					$InsFichaIngreso->PmaId = $InsPlanMantenimiento->PmaId;

					
				}
				
				
				
				
				
			}
			
		break;
		
		case "ConsultaVIN":
			
			if($GET_EinId){
				
				$InsVehiculoIngreso = new ClsVehiculoIngreso();
				$InsVehiculoIngreso->EinId = $GET_EinId;
				$InsVehiculoIngreso->MtdObtenerVehiculoIngreso();

				$InsFichaIngreso->EinId = $InsVehiculoIngreso->EinId;
//				$InsFichaIngreso->EinVIN = $InsVehiculoIngreso->EinVIN;
//				$InsFichaIngreso->VmaNombre = $InsVehiculoIngreso->VmaNombre;
//				$InsFichaIngreso->VmoNombre = $InsVehiculoIngreso->VmoNombre;
//				$InsFichaIngreso->VveNombre = $InsVehiculoIngreso->VveNombre;
//				
//				$InsFichaIngreso->VmaId = $InsVehiculoIngreso->VmaId;
//				$InsFichaIngreso->VmoId = $InsVehiculoIngreso->VmoId;
//				$InsFichaIngreso->VveId = $InsVehiculoIngreso->VveId;
//				
//				$InsFichaIngreso->EinColor = $InsVehiculoIngreso->EinColor;
//				$InsFichaIngreso->EinPlaca = $InsVehiculoIngreso->EinPlaca;
//				$InsFichaIngreso->EinAnoFabricacion = $InsVehiculoIngreso->EinAnoFabricacion;
//				
//				if(!empty($InsVehiculoIngreso->VehiculoIngresoCliente)){
//					foreach($InsVehiculoIngreso->VehiculoIngresoCliente as $DatVehiculoIngresoCliente){
//						
//						$InsFichaIngreso->FinConductor = $DatVehiculoIngresoCliente->CliNombre." ".$DatVehiculoIngresoCliente->CliApellidoPaterno." ".$DatVehiculoIngresoCliente->CliApellidoMaterno;
//						$InsFichaIngreso->FinTelefono = $DatVehiculoIngresoCliente->CliCelular;
//						$InsFichaIngreso->FinDireccion = $DatVehiculoIngresoCliente->CliDireccion;
//						$InsFichaIngreso->FinContacto = $DatVehiculoIngresoCliente->CliTelefono;
//	
//					}
//				}


				if(!empty($GET_Origen) and $_POST['Guardar']<>1){
	?>
				<script type="text/javascript">
                $().ready(function() {
                    FncVehiculoIngresoSimpleBuscar('Id');	
                });	
                </script>
	<?php
				}
				
			}
			
		break;
		
		case "CotizacionProducto":
		
	
			$InsCotizacionProducto = new ClsCotizacionProducto();
			$InsCotizacionProducto->CprId = $GET_CprId;
			$InsCotizacionProducto->MtdObtenerCotizacionProducto();

			$InsFichaIngreso->CliId = $InsCotizacionProducto->CliId;
		
			$InsFichaIngreso->MonId = $EmpresaMonedaId;
		
			$InsFichaIngreso->PerId = "PER-10037";
			$InsFichaIngreso->PerIdAsesor = $_SESSION['SesionId'];
		
			$InsFichaIngreso->EinId = $InsCotizacionProducto->EinId;	
			$InsFichaIngreso->EinVIN =  $InsCotizacionProducto->EinVIN;	
			
			$InsFichaIngreso->VmaNombre = $InsCotizacionProducto->VmaNombre;	
			$InsFichaIngreso->VmoNombre = $InsCotizacionProducto->VmoNombre;
			$InsFichaIngreso->VveNombre = $InsCotizacionProducto->VveNombre;
		
			$InsFichaIngreso->VmaId = $InsCotizacionProducto->VmaId;	
			$InsFichaIngreso->VmoId = $InsCotizacionProducto->VmoId;	
			$InsFichaIngreso->VveId = $InsCotizacionProducto->VveId;	
		
			$InsFichaIngreso->EinColor = $InsCotizacionProducto->EinColor;	
			$InsFichaIngreso->EinPlaca = $InsCotizacionProducto->EinPlaca;	
			$InsFichaIngreso->EinAnoFabricacion = $InsCotizacionProducto->EinAnoFabricacion;	
			
			$InsFichaIngreso->FinConductor = $InsCotizacionProducto->CliNombre." ".$InsCotizacionProducto->CliApellidoPaterno." ".$InsCotizacionProducto->CliApellidoMaterno;	
			$InsFichaIngreso->FinTelefono = $InsCotizacionProducto->CliCelular;
			$InsFichaIngreso->FinDireccion = $InsCotizacionProducto->CliDireccion;
			$InsFichaIngreso->FinContacto = $InsCotizacionProducto->CliNombre." ".$InsCotizacionProducto->CliApellidoPaterno." ".$InsCotizacionProducto->CliApellidoMaterno;	
			
			$InsFichaIngreso->FinFecha = date("d/m/Y");
			$InsFichaIngreso->FinFechaActividad = $InsFichaIngreso->FinFecha;
			
			$InsFichaIngreso->FinObservacion = date("d/m/Y H:i:s")." - Orden de Trabajo generado de Cot.:".$InsCotizacionProducto->CprId;;
			
			$InsFichaIngreso->FinExteriorDelantero1 = 1;
			$InsFichaIngreso->FinExteriorDelantero2 = 1;
			$InsFichaIngreso->FinExteriorDelantero3 = 1;
			$InsFichaIngreso->FinExteriorDelantero4 = 1;
			$InsFichaIngreso->FinExteriorDelantero5 = 1;
			$InsFichaIngreso->FinExteriorDelantero6 = 1;
			$InsFichaIngreso->FinExteriorDelantero7 = 1;
			
			$InsFichaIngreso->FinExteriorPosterior1 =1;
			$InsFichaIngreso->FinExteriorPosterior2 =1;
			$InsFichaIngreso->FinExteriorPosterior3 = 1;
			$InsFichaIngreso->FinExteriorPosterior4 = 1;
			$InsFichaIngreso->FinExteriorPosterior5 = 1;
			$InsFichaIngreso->FinExteriorPosterior6 = 1;
			
			$InsFichaIngreso->FinExteriorDerecho1 = 1;
			$InsFichaIngreso->FinExteriorDerecho2 = 1;
			$InsFichaIngreso->FinExteriorDerecho3 = 1;
			$InsFichaIngreso->FinExteriorDerecho4 = 1;
			$InsFichaIngreso->FinExteriorDerecho5 = 1;
			$InsFichaIngreso->FinExteriorDerecho6 = 1;
			$InsFichaIngreso->FinExteriorDerecho7 = 1;
			$InsFichaIngreso->FinExteriorDerecho8 = 1;
			
			$InsFichaIngreso->FinExteriorIzquierdo1 = 1;
			$InsFichaIngreso->FinExteriorIzquierdo2 = 1;
			$InsFichaIngreso->FinExteriorIzquierdo3 =1;
			$InsFichaIngreso->FinExteriorIzquierdo4 = 1;
			$InsFichaIngreso->FinExteriorIzquierdo5 = 1;
			$InsFichaIngreso->FinExteriorIzquierdo6 = 1;
			$InsFichaIngreso->FinExteriorIzquierdo7 = 1;
			
			$InsFichaIngreso->FinInterior1 = 1;
			$InsFichaIngreso->FinInterior2 = 1;
			$InsFichaIngreso->FinInterior3 = 1;
			$InsFichaIngreso->FinInterior4 = 1;
			$InsFichaIngreso->FinInterior5 =  1;
			$InsFichaIngreso->FinInterior6 =  1;
			$InsFichaIngreso->FinInterior7 = 1; 
			$InsFichaIngreso->FinInterior8 = 1;
			$InsFichaIngreso->FinInterior9 = 1;
			$InsFichaIngreso->FinInterior10 = 1;
			$InsFichaIngreso->FinInterior11 = 1;
			$InsFichaIngreso->FinInterior12 = 1;
			$InsFichaIngreso->FinInterior13 = 1;
			$InsFichaIngreso->FinInterior14 = 1;
			$InsFichaIngreso->FinInterior15 = 1;
			$InsFichaIngreso->FinInterior16 = 1;
			$InsFichaIngreso->FinInterior17 = 1;
			$InsFichaIngreso->FinInterior18 = 1;
			$InsFichaIngreso->FinInterior19 = 1;
			$InsFichaIngreso->FinInterior20 = 1;
			$InsFichaIngreso->FinInterior21 = 1;
			$InsFichaIngreso->FinInterior22 = 1;
			$InsFichaIngreso->FinInterior23 = 1;
			$InsFichaIngreso->FinInterior24 = 1;
			$InsFichaIngreso->FinInterior25 = 1;
			$InsFichaIngreso->FinInterior26 = 1;
			$InsFichaIngreso->FinInterior27 = 1;
			
			$InsFichaIngreso->FinPlaca = $InsCotizacionProducto->EinPlaca;
			$InsFichaIngreso->FinSalidaObservacion = date("d/m/Y H:i:s")." - Siniestro/Cot.:".$InsCotizacionProducto->CprId;;
		
			$InsFichaIngreso->FinVehiculoKilometraje = 0;	
			$InsFichaIngreso->FinMantenimientoKilometraje = 0;
			
			$InsFichaIngreso->FinPrecioEstimado = 0;
			
			$InsFichaIngreso->FinPrioridad = 1;		
			$InsFichaIngreso->FinTipo = 1;	
			$InsFichaIngreso->FinEstado = 11;	
			$InsFichaIngreso->FinTiempoCreacion = date("Y-m-d H:i:s");
			$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
			$InsFichaIngreso->FinEliminado = 1;
			
			$InsFichaIngreso->TdoId = $InsCotizacionProducto->TdoId;
			$InsFichaIngreso->CliNombreCompleto = $InsCotizacionProducto->CliNombre." ".$InsCotizacionProducto->CliApellidoPaterno." ".$InsCotizacionProducto->CliApellidoMaterno;
			$InsFichaIngreso->CliNombre = $InsCotizacionProducto->CliNombre;
			$InsFichaIngreso->CliApellidoPaterno = $InsCotizacionProducto->CliApellidoPaterno;
			$InsFichaIngreso->CliApellidoMaterno = $InsCotizacionProducto->CliApellidoMaterno;
			
			$InsFichaIngreso->CliNumeroDocumento = $InsCotizacionProducto->CliNumeroDocumento;
			
	
			$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
			$InsFichaIngresoModalidad->FimId = NULL;
			$InsFichaIngresoModalidad->FinId= NULL;
			$InsFichaIngresoModalidad->MinId = "MIN-10002";
			$InsFichaIngresoModalidad->MinSigla = "SI";
			$InsFichaIngresoModalidad->FimObsequio = 2;
			$InsFichaIngresoModalidad->FimEstado= 1;
			$InsFichaIngresoModalidad->FimTiempoCreacion = date("d/m/Y H:i:s");
			$InsFichaIngresoModalidad->FimTiempoModificacion = date("d/m/Y H:i:s");
			  
			$InsFichaIngreso->FichaIngresoModalidad[] = $InsFichaIngresoModalidad;

	
					/*
					SesionObjeto-FichaIngresoTarea
					Parametro1 = FitId
					Parametro2 =
					Parametro3 = FitDescripcion
					Parametro4 =
					Parametro5 =
					Parametro6 = FitAccion
					Parametro7 = FitTiempoCreacion
					Parametro8 = FitTiempoModificacion
					*/
		
					if(!empty($InsCotizacionProducto->CotizacionProductoDetalle)){
						foreach($InsCotizacionProducto->CotizacionProductoDetalle as $DatCotizacionProductoDetalle){
				
							$_SESSION['InsFichaIngresoProducto'.$InsFichaIngresoModalidad->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatCotizacionProductoDetalle->ProId,
							$DatCotizacionProductoDetalle->ProNombre,
							$DatCotizacionProductoDetalle->ProCodigoOriginal,
							$DatCotizacionProductoDetalle->ProCodigoAlternativo,
							NULL,
							(date("d/m/Y H:i:s")),
							(date("d/m/Y H:i:s"))
							);
												
						}
					}
				
	
		
					if(!empty($InsCotizacionProducto->CotizacionProductoPlanchado)){
						foreach($InsCotizacionProducto->CotizacionProductoPlanchado as $DatCotizacionProductoPlanchado){

							if($InsCotizacionProducto->MonId<>$EmpresaMonedaId ){
								$DatCotizacionProductoPlanchado->CppImporte = round($DatCotizacionProductoPlanchado->CppImporte / $InsCotizacionProducto->CprTipoCambio,2);
							}

							$_SESSION['InsFichaIngresoTarea'.$InsFichaIngresoModalidad->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							NULL,
							"PLANCHADO/".$DatCotizacionProductoPlanchado->CppDescripcion,
							NULL,
							NULL,
							"L",
							(date("d/m/Y H:i:s")),
							(date("d/m/Y H:i:s")),
							NULL);
							
						}
					}
	
	
	//deb($InsCotizacionProducto->CotizacionProductoPintado);
	
					if(!empty($InsCotizacionProducto->CotizacionProductoPintado)){
						foreach($InsCotizacionProducto->CotizacionProductoPintado as $DatCotizacionProductoPintado){
				
							if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
								$DatCotizacionProductoPintado->CppImporte = round($DatCotizacionProductoPintado->CppImporte / $InsCotizacionProducto->CprTipoCambio,2);
							}
							
							$_SESSION['InsFichaIngresoTarea'.$InsFichaIngresoModalidad->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							NULL,
							"PINTADO/".$DatCotizacionProductoPintado->CppDescripcion,
							NULL,
							NULL,
							"N",
							(date("d/m/Y H:i:s")),
							(date("d/m/Y H:i:s")),
							NULL);
				
						}
					}
	
	
	
		
					if(!empty($InsCotizacionProducto->CotizacionProductoCentrado)){
						foreach($InsCotizacionProducto->CotizacionProductoCentrado as $DatCotizacionProductoCentrado){
				
							if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
								$DatCotizacionProductoCentrado->CppImporte = round($DatCotizacionProductoCentrado->CppImporte / $InsCotizacionProducto->CprTipoCambio,2);
							}
				
							$_SESSION['InsFichaIngresoTarea'.$InsFichaIngresoModalidad->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							NULL,
							"CENTRADO/".$DatCotizacionProductoCentrado->CppDescripcion,
							NULL,
							NULL,
							"E",
							(date("d/m/Y H:i:s")),
							(date("d/m/Y H:i:s")),
							NULL);
						
						}
					}
	
	
					if(!empty($InsCotizacionProducto->CotizacionProductoTarea)){
						foreach($InsCotizacionProducto->CotizacionProductoTarea as $DatCotizacionProductoTarea){
					
							if($InsCotizacionProducto->MonId<>$EmpresaMonedaId){
								$DatCotizacionProductoTarea->CppImporte = round($DatCotizacionProductoTarea->CppImporte / $InsCotizacionProducto->CprTipoCambio,2);
							}
					
							$_SESSION['InsFichaIngresoTarea'.$InsFichaIngresoModalidad->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							NULL,
							"ADICIONALES/".$DatCotizacionProductoTarea->CppDescripcion,
							NULL,
							NULL,
							"Z",
							(date("d/m/Y H:i:s")),
							(date("d/m/Y H:i:s")),
							NULL);
						
						}
					}
	
	
	
	
		break;
		
		default:
			
			
		/*	$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
			$InsFichaIngresoModalidad->FimId = NULL;
			$InsFichaIngresoModalidad->FinId= NULL;
			$InsFichaIngresoModalidad->MinId = "MIN-10006";
			$InsFichaIngresoModalidad->MinSigla = "OB";
			$InsFichaIngresoModalidad->FimObsequio = 2;
			$InsFichaIngresoModalidad->FimEstado= 1;
			$InsFichaIngresoModalidad->FimTiempoCreacion = date("d/m/Y H:i:s");
			$InsFichaIngresoModalidad->FimTiempoModificacion = date("d/m/Y H:i:s");
			
			$InsFichaIngreso->FichaIngresoModalidad[] = $InsFichaIngresoModalidad;*/
			
		/*	$InsFichaIngresoModalidad2 = new ClsFichaIngresoModalidad();
			$InsFichaIngresoModalidad2->FimId = NULL;
			$InsFichaIngresoModalidad2->FinId= NULL;
			$InsFichaIngresoModalidad2->MinId = "MIN-10026";
			$InsFichaIngresoModalidad2->MinSigla = "SI";
			$InsFichaIngresoModalidad2->FimObsequio = 2;
			$InsFichaIngresoModalidad2->FimEstado= 1;
			$InsFichaIngresoModalidad2->FimTiempoCreacion = date("d/m/Y H:i:s");
			$InsFichaIngresoModalidad2->FimTiempoModificacion = date("d/m/Y H:i:s");
			  
			$InsFichaIngreso->FichaIngresoModalidad[] = $InsFichaIngresoModalidad2;*/


		break;
		
	}
	//deb($InsFichaIngreso->PerIdAsesor );
}
?>