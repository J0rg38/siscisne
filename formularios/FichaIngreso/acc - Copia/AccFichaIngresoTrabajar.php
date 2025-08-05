<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

	$InsFichaIngreso->UsuId = $_SESSION['SesionId'];
	$InsFichaIngreso->CitId = $_POST['CmpCitaId'];
	
	$InsFichaIngreso->FinId = $_POST['CmpId'];
	$InsFichaIngreso->CliId = $_POST['CmpClienteId'];
	$InsFichaIngreso->PerId = $_POST['CmpPersonal'];
	$InsFichaIngreso->SucId = $_POST['CmpSucursal'];

	$InsFichaIngreso->CamId = $_POST['CmpCampanaId'];
	$InsFichaIngreso->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	$InsFichaIngreso->ObsId = $_POST['CmpObsequioId'];
	$InsFichaIngreso->OvmId = $_POST['CmpOrdenVentaVehiculoMantenimientoId'];
	$InsFichaIngreso->ObsNombre = $_POST['CmpObsequioNombre'];
	$InsFichaIngreso->OvmKilometraje = $_POST['CmpOrdenVentaVehiculoMantenimientoKilometraje'];

	$InsFichaIngreso->FinFechaVenta = $_POST['CmpVehiculoPromocionFechaVenta'];
	$InsFichaIngreso->FinCantidadMantenimientos = $_POST['CmpVehiculoPromocionCantidadMantenimientos'];
	
	$InsFichaIngreso->MonId = $_POST['CmpMonedaId'];
	$InsFichaIngreso->FinTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsFichaIngreso->CamNombre = $_POST['CmpCampanaNombre'];
	$InsFichaIngreso->CamCodigo = $_POST['CmpCampanaCodigo'];
	
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
	
	//$InsFichaIngreso->PmaId = $_POST['CmpPlanMantenimiento'];
	$InsFichaIngreso->PmaId = $_POST['CmpPlanMantenimientoId'];
	
	$InsFichaIngreso->FinClienteEmail =($_POST['CmpClienteEmail']);
	$InsFichaIngreso->FinConductor =($_POST['CmpConductor']);
	$InsFichaIngreso->FinTelefono = $_POST['CmpClienteCelular'];
	$InsFichaIngreso->FinDireccion = $_POST['CmpClienteDireccion'];
	$InsFichaIngreso->FinContacto = $_POST['CmpClienteContacto'];
	
	$InsFichaIngreso->FinFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsFichaIngreso->FinFechaEntrega = FncCambiaFechaAMysql($_POST['CmpFechaEntrega'],true);
	$InsFichaIngreso->FinHoraEntrega = ($_POST['CmpHoraEntrega']);
	$InsFichaIngreso->FinFechaCita = FncCambiaFechaAMysql($_POST['CmpFechaCita'],true);
	$InsFichaIngreso->FinFechaGarantia = FncCambiaFechaAMysql($_POST['CmpFechaGarantia'],true);
	
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
	$InsFichaIngreso->FinMontoPresupuesto = eregi_replace(",","",(empty($_POST['CmpMontoPresupuesto'])?0:$_POST['CmpMontoPresupuesto']));
	
	$InsFichaIngreso->FinPrioridad = $_POST['CmpPrioridad'];
	$InsFichaIngreso->FinCita = $_POST['CmpCita'];
	$InsFichaIngreso->FinEstado = $_POST['CmpEstado'];
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
	$InsFichaIngreso->FinEliminado = 1;

	$InsFichaIngreso->TdoId = $_POST['CmpClienteTipoDocumento'];
	//$InsFichaIngreso->CliNombre = $_POST['CmpClienteNombre'];

	$InsFichaIngreso->CliNombreCompleto = $_POST['CmpClienteNombre'];
	$InsFichaIngreso->CliNombre = $_POST['CmpClienteNombre'];
	$InsFichaIngreso->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsFichaIngreso->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];


	$InsFichaIngreso->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];


	$InsFichaIngreso->FichaIngresoModalidad = array();
	
	
	foreach($ArrModalidadIngresos as $DatModalidadIngreso){

		$InsFichaIngresoModalidad1 = new ClsFichaIngresoModalidad();
		$InsFichaIngresoModalidad1->FimId = $_POST['CmpFichaIngresoModalidadId_'.$DatModalidadIngreso->MinSigla];
		$InsFichaIngresoModalidad1->MinId = $_POST['CmpModalidadId_'.$DatModalidadIngreso->MinSigla];
		$InsFichaIngresoModalidad1->FimObsequio = empty($_POST['CmpFichaIngresoModalidadObsequio_'.$DatModalidadIngreso->MinSigla])?2:1;
		$InsFichaIngresoModalidad1->FimEstado = 1;
		$InsFichaIngresoModalidad1->FimTiempoCreacion = date("Y-m-d H:i:s");
		$InsFichaIngresoModalidad1->FimTiempoModificacion = date("Y-m-d H:i:s");
		$InsFichaIngresoModalidad1->InsMysql = NULL;

	//	deb($InsFichaIngresoModalidad1->MinId);
		//if(!empty($InsFichaIngresoModalidad1->MinId)){
			
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
		$ResFichaIngresoProducto = $_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
		
		if(!empty($ResFichaIngresoProducto['Datos'])){
			$item = 1;
			foreach($ResFichaIngresoProducto['Datos'] as $DatSesionObjeto){
					
				$InsFichaIngresoProducto1 = new ClsFichaIngresoProducto();
				$InsFichaIngresoProducto1->FipId = $DatSesionObjeto->Parametro1;
				$InsFichaIngresoProducto1->ProId = $DatSesionObjeto->Parametro2;
				
				$InsFichaIngresoProducto1->UmeId = $DatSesionObjeto->Parametro6;
				$InsFichaIngresoProducto1->FipCantidad = $DatSesionObjeto->Parametro9;	
				$InsFichaIngresoProducto1->FipCantidadReal = $DatSesionObjeto->Parametro10;
				
				$InsFichaIngresoProducto1->FipCantidad = $DatSesionObjeto->Parametro9;	
				$InsFichaIngresoProducto1->FipCantidadReal = $DatSesionObjeto->Parametro10;
				
				
				$InsFichaIngresoProducto1->FipVerificar1 = $DatSesionObjeto->Parametro4;
				
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
	
			$ResFichaIngresoTarea = $_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
		
			if(!empty($ResFichaIngresoTarea['Datos'])){
				$item = 1;
				foreach($ResFichaIngresoTarea['Datos'] as $DatSesionObjeto){
						
					$InsFichaIngresoTarea1 = new ClsFichaIngresoTarea();
					$InsFichaIngresoTarea1->FitId = $DatSesionObjeto->Parametro1;
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
			
			$ResFichaIngresoManoObra = $_SESSION['InsFichaIngresoManoObra'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
		
			if(!empty($ResFichaIngresoManoObra['Datos'])){
				$item = 1;
				foreach($ResFichaIngresoManoObra['Datos'] as $DatSesionObjeto){
						
					$InsFichaIngresoManoObra1 = new ClsFichaIngresoTarea();
					$InsFichaIngresoManoObra1->FmoId = $DatSesionObjeto->Parametro1;
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
			
		//}	
			
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
	//Parametro14 = FisEstado
		
					$RepSesionObjetos = $_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
					$ArrSesionObjetos = $RepSesionObjetos['Datos'];

					if(!empty($ArrSesionObjetos)){
						foreach($ArrSesionObjetos as $DatSesionObjeto){
	
								$InsFichaIngresoSuministro1 = new ClsFichaIngresoSuministro();
								$InsFichaIngresoSuministro1->FisId = $DatSesionObjeto->Parametro1;
								$InsFichaIngresoSuministro1->ProId = $DatSesionObjeto->Parametro2;

								$InsFichaIngresoSuministro1->UmeId = $DatSesionObjeto->Parametro6;
								$InsFichaIngresoSuministro1->FisCantidad = $DatSesionObjeto->Parametro9;	
								$InsFichaIngresoSuministro1->FisCantidadReal = $DatSesionObjeto->Parametro10;
								
								$InsFichaIngresoSuministro1->FisEstado = $DatSesionObjeto->Parametro14;
								$InsFichaIngresoSuministro1->FisTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
								$InsFichaIngresoSuministro1->FisTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
								$InsFichaIngresoSuministro1->FisEliminado = 1;				
								
								$InsFichaIngresoSuministro1->ProNombre = $DatSesionObjeto->Parametro3;
								$InsFichaIngresoSuministro1->RtiId= $DatSesionObjeto->Parametro11;
								$InsFichaIngresoSuministro1->UmeNombre= $DatSesionObjeto->Parametro12;
								$InsFichaIngresoSuministro1->UmeIdOrigen= $DatSesionObjeto->Parametro13;
								
								$InsFichaIngresoSuministro1->InsMysql = NULL;
								
								$InsFichaIngresoModalidad1->FichaIngresoSuministro[] = $InsFichaIngresoSuministro1;
								
	
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
	//Parametro14 = FisEstado
	
								$_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
								$InsFichaIngresoSuministro1->FisId,
								$InsFichaIngresoSuministro1->ProId,
								$InsFichaIngresoSuministro1->ProNombre,
								NULL,
								NULL,
								$InsFichaIngresoSuministro1->UmeId,
								FncCambiaFechaANormal($InsFichaIngresoSuministro1->FisTiempoCreacion),
								FncCambiaFechaANormal($InsFichaIngresoSuministro1->FisTiempoModificacion),
								$InsFichaIngresoSuministro1->FisCantidad,
								$InsFichaIngresoSuministro1->FisCantidadReal,
								$InsFichaIngresoSuministro1->RtiId,
								$InsFichaIngresoSuministro1->UmeNombre,
								$InsFichaIngresoSuministro1->UmeIdOrigen,
								$InsFichaIngresoSuministro1->FisEstado);
								
						}
					}

		//deb($DatModalidadIngreso->MinId);

		if($DatModalidadIngreso->MinId == "MIN-10001"){
			
			
						
			$RepSesionObjetos = $_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
			$ArrSesionObjetos = $RepSesionObjetos['Datos'];

						$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId) ;
						$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
						
						
						$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
						$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
			
						$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
						unset($ArrPlanMantenimientos);
						$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
						
						$InsFichaIngreso->PmaId = $InsPlanMantenimiento->PmaId;
						
//						
		if(!empty($ArrSesionObjetos)){
				foreach($ArrSesionObjetos as $DatSesionObjeto){
//
						if(!empty($_POST['CmpPlanMantenimientoDetalleAccion_'.$DatSesionObjeto->Parametro3])){
			
							$InsFichaIngresoMantenimiento1 = new ClsFichaIngresoMantenimiento();
							$InsFichaIngresoMantenimiento1->PmtId = $DatSesionObjeto->Parametro3;
							$InsFichaIngresoMantenimiento1->FiaId = $_POST['CmpPlanMantenimientoDetalleId_'.$DatSesionObjeto->Parametro3];
							$InsFichaIngresoMantenimiento1->FiaAccion = $_POST['CmpPlanMantenimientoDetalleAccion_'.$DatSesionObjeto->Parametro3];
							$InsFichaIngresoMantenimiento1->FiaNivel = 2;
							$InsFichaIngresoMantenimiento1->FiaVerificar1 = 2;
							$InsFichaIngresoMantenimiento1->FiaVerificar2 = 2;
							$InsFichaIngresoMantenimiento1->FiaEstado = 2;
							$InsFichaIngresoMantenimiento1->FiaTiempoCreacion = date("Y-m-d H:i:s");
							$InsFichaIngresoMantenimiento1->FiaTiempoModificacion = date("Y-m-d H:i:s");

//deb($InsFichaIngresoMantenimiento1->FiaAccion);
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
							$InsFichaIngresoMantenimiento1->FiaEstado
							);
							
						}
//						
					}		
//					
			}else{
				
				
					unset($_SESSION['InsFichaIngresoMantenimento'.$DatModalidadIngreso->MinSigla.$Identificador]);

					$_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	

						$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId) ;
						$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
						
						
						$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
						$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
			
						$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
						unset($ArrPlanMantenimientos);
						$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
						
						$InsFichaIngreso->PmaId = $InsPlanMantenimiento->PmaId;
						
						foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
						
							$PlanMantenimientoDetalleId = '';
							$PlanMantenimientoDetalleAccion = '';
							$PlanMantenimientoDetalleNivel = '';
							$PlanMantenimientoDetalleVerificar1 = '';
					//
//							$OpcAccion1 = '';
//							$OpcAccion2 = '';
//							$OpcAccion3 = '';
//							$OpcAccion4 = '';

							$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtNombre','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
							$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];

							foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){

								foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){

									$PlanMantenimientoDetalleAccion = '';

									if($InsFichaIngreso->FinMantenimientoKilometraje==$DatKilometro['km']){

										$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
										$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	

									}
									
									if(!empty( $PlanMantenimientoDetalleAccion)){
			
										$InsFichaIngresoMantenimiento1 = new ClsFichaIngresoMantenimiento();
										$InsFichaIngresoMantenimiento1->PmtId = $DatPlanMantenimientoTarea->PmtId;
										$InsFichaIngresoMantenimiento1->FiaId = $_POST['CmpPlanMantenimientoDetalleId_'.$DatPlanMantenimientoTarea->PmtId];
										$InsFichaIngresoMantenimiento1->FiaAccion = $_POST['CmpPlanMantenimientoDetalleAccion_'.$DatPlanMantenimientoTarea->PmtId];
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
										$InsFichaIngresoMantenimiento1->FiaEstado
										);

									}
									
															
								}
								
							}
						}
			
			
			
			
				
				
			}
			
			
			if(!empty($InsFichaIngresoModalidad1->MinId)){
				$ModalidadMantenimiento = true;		
			}
	
	
	
			if(empty($_POST['CmpPlanMantenimientoIdAux']) and $ModalidadMantenimiento){
				
				$Resultado.='#ERR_FIN_609';				
				$Guardar = false;
				
			}
			
			
		}					
					
			
			//deb($InsFichaIngresoModalidad1->MinId);
			if(!empty($InsFichaIngresoModalidad1->FimId)){
				
				if(empty($InsFichaIngresoModalidad1->MinId)){
					
					//echo $DatModalidadIngreso->MinId;
					if($DatModalidadIngreso->MinId == "MIN-10001"){
						$ModalidadMantenimientoMarcado = false;
					}
					
					if($DatModalidadIngreso->MinSigla == "GA"){
						$InsFichaIngreso->MtdEditarFichaIngresoDato("FinFechaGarantia",NULL,$InsFichaIngreso->FinId);
					}
					
					$InsFichaIngresoModalidad1->FimEliminado = 2;
				}else{
					
					if($DatModalidadIngreso->MinSigla == "GA" and empty($InsFichaIngreso->FinFechaGarantia)){							
						$InsFichaIngreso->MtdEditarFichaIngresoDato("FinFechaGarantia",date("Y-m-d"),$InsFichaIngreso->FinId);							
					}
					
					$InsFichaIngresoModalidad1->FimEliminado = 1;
				}
			}else{
				if(empty($InsFichaIngresoModalidad1->MinId)){

					if($DatModalidadIngreso->MinSigla == "GA"){
						$InsFichaIngreso->MtdEditarFichaIngresoDato("FinFechaGarantia",NULL,$InsFichaIngreso->FinId);
					}

					$InsFichaIngresoModalidad1->FimEliminado = 2;
				}else{
					
					if($DatModalidadIngreso->MinSigla == "GA" and empty($InsFichaIngreso->FinFechaGarantia)){							
						$InsFichaIngreso->MtdEditarFichaIngresoDato("FinFechaGarantia",date("Y-m-d"),$InsFichaIngreso->FinId);							
					}
					
					$InsFichaIngresoModalidad1->FimEliminado = 1;
				}
	
			}
	
			$InsFichaIngresoModalidad1->InsMysql = NULL;
		
			$InsFichaIngreso->FichaIngresoModalidad[] = $InsFichaIngresoModalidad1;	

	}
	


	if($Guardar){
		if($InsFichaIngreso->MtdTrabajarFichaIngreso()){		
			$Resultado.='#SAS_FIN_106';
			$Edito = true;
	
			FncCargarDatos();
		} else{
			$Resultado.='#ERR_FIN_106';
			$InsFichaIngreso->FinFecha = FncCambiaFechaANormal($InsFichaIngreso->FinFecha);
			$InsFichaIngreso->FinFechaEntrega = FncCambiaFechaANormal($InsFichaIngreso->FinFechaEntrega,true);
			$InsFichaIngreso->FinFechaCita = FncCambiaFechaANormal($InsFichaIngreso->FinFechaCita,true);

			$InsFichaIngreso->FinSalidaFecha = FncCambiaFechaANormal($InsFichaIngreso->FinSalidaFecha,true);
		}
	}else{

		$Resultado.='#ERR_FIN_106';
		$InsFichaIngreso->FinFecha = FncCambiaFechaANormal($InsFichaIngreso->FinFecha);
		$InsFichaIngreso->FinFechaEntrega = FncCambiaFechaANormal($InsFichaIngreso->FinFechaEntrega,true);
		$InsFichaIngreso->FinFechaCita = FncCambiaFechaANormal($InsFichaIngreso->FinFechaCita,true);	
		$InsFichaIngreso->FinSalidaFecha = FncCambiaFechaANormal($InsFichaIngreso->FinSalidaFecha,true);
			
	}

}else{

	FncCargarDatos();

}

function FncCargarDatos(){
	
	global $GET_id;
	global $Identificador;
	global $InsFichaIngreso;
	global $EmpresaMonedaId;
	global $ArrModalidadIngresos;
	global $InsPlanMantenimiento;
	
	$InsFichaIngreso = new ClsFichaIngreso();


	foreach($ArrModalidadIngresos as $DatModalidadIngreso){

		unset($_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador]);
		unset($_SESSION['InsFichaIngresoManoObra'.$DatModalidadIngreso->MinSigla.$Identificador]);
		unset($_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador]);
		unset($_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]);
		unset($_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]);

		$_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
		$_SESSION['InsFichaIngresoManoObra'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
		$_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
		$_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
		$_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	

	}
		
		
		
	$InsFichaIngreso->FinId = $GET_id;
	$InsFichaIngreso->MtdObtenerFichaIngreso();	
	


	$ModalidadMantenimiento = false;

	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
		if(!empty($DatFichaIngresoModalidad->MinId)){
		
			if($DatFichaIngresoModalidad->MinId == "MIN-10001"){
	
				$ModalidadMantenimiento = true;;
	
			}

		}
	}
	
	
		if($ModalidadMantenimiento){
		
			if(empty($InsFichaIngreso->PmaId)){
				
				$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId) ;
				$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
							
				$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
				unset($ArrPlanMantenimientos);
				$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
							
				$InsFichaIngreso->PmaId = $InsPlanMantenimiento->PmaId;
				
			}
			
	
		}


		if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
		
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



			if(!empty($DatFichaIngresoModalidad->FichaIngresoTarea)){
				foreach($DatFichaIngresoModalidad->FichaIngresoTarea as $DatFichaIngresoTarea){
					
					//echo 'InsFichaIngresoTarea'.$DatFichaIngresoTarea->MinSigla.$Identificador;
					
					if(!empty($DatFichaIngresoTarea->MinSigla)){ //AUX
						$_SESSION['InsFichaIngresoTarea'.$DatFichaIngresoTarea->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaIngresoTarea->FitId,
						NULL,
						$DatFichaIngresoTarea->FitDescripcion,
						NULL,
						NULL,
						$DatFichaIngresoTarea->FitAccion,
						($DatFichaIngresoTarea->FitTiempoCreacion),
						($DatFichaIngresoTarea->FitTiempoModificacion),
						NULL);
						
					}
					
					
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

			if(!empty($DatFichaIngresoModalidad->FichaIngresoManoObra)){
				foreach($DatFichaIngresoModalidad->FichaIngresoManoObra as $DatFichaIngresoManoObra){
					
					if(!empty($DatFichaIngresoManoObra->MinSigla)){ //AUX
					
						$_SESSION['InsFichaIngresoManoObra'.$DatFichaIngresoManoObra->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaIngresoManoObra->FitId,
						NULL,
						$DatFichaIngresoManoObra->FmoDescripcion,
						$DatFichaIngresoManoObra->FmoImporte,
						NULL,
						($DatFichaIngresoManoObra->FmoEstado),
						($DatFichaIngresoManoObra->FmoTiempoCreacion),
						($DatFichaIngresoManoObra->FmoTiempoModificacion),
						NULL);
						
					}
					
				}
			}


		/*
		SesionObjeto-FichaIngresoProducto
		Parametro1 = FipId
		Parametro2 = ProId
		Parametro3 = ProNombre
		Parametro4 = ProCodigoOriginal
		Parametro5 = ProCodigoAlternativo
		Parametro6 = 
		Parametro7 = FipTiempoCreacion
		Parametro8 = FipTiempoModificacion
		*/
				if(!empty($DatFichaIngresoModalidad->FichaIngresoProducto)){
					foreach($DatFichaIngresoModalidad->FichaIngresoProducto as $DatFichaIngresoProducto){
					
						if(!empty($DatFichaIngresoProducto->MinSigla)){ //AUX
						$_SESSION['InsFichaIngresoProducto'.$DatFichaIngresoProducto->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaIngresoProducto->FipId,
						$DatFichaIngresoProducto->ProId,
						$DatFichaIngresoProducto->ProNombre,
						$DatFichaIngresoProducto->FipVerificar1,
						$DatFichaIngresoProducto->FipVerificar2,
						$DatFichaIngresoProducto->UmeId,
						($DatFichaIngresoProducto->FipTiempoCreacion),
						($DatFichaIngresoProducto->FipTiempoModificacion),
						$DatFichaIngresoProducto->FipCantidad,
						$DatFichaIngresoProducto->FipCantidadReal,
						$DatFichaIngresoProducto->RtiId,
						$DatFichaIngresoProducto->UmeNombre,
						$DatFichaIngresoProducto->UmeIdOrigen,
						$DatFichaIngresoProducto->FipEstado,
						NULL,
						$DatFichaIngresoProducto->FipAccion,
						$DatFichaIngresoProducto->ProCodigoOriginal,
						$DatFichaIngresoProducto->ProCodigoAlternativo);
						}
					
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
//Parametro14 = FisEstado
				
//				deb($DatFichaIngresoModalidad->FichaIngresoSuministro);
				if(!empty($DatFichaIngresoModalidad->FichaIngresoSuministro)){
					foreach($DatFichaIngresoModalidad->FichaIngresoSuministro as $DatFichaIngresoSuministro){					
					
					//echo 'InsFichaIngresoSuministro'.$DatFichaIngresoSuministro->MinSigla.$Identificador;
						if(!empty($DatFichaIngresoSuministro->MinSigla)){ //AUX
							$_SESSION['InsFichaIngresoSuministro'.$DatFichaIngresoSuministro->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
							$DatFichaIngresoSuministro->FisId,
							$DatFichaIngresoSuministro->ProId,
							$DatFichaIngresoSuministro->ProNombre,
							NULL,
							NULL,
							$DatFichaIngresoSuministro->UmeId,
							($DatFichaIngresoSuministro->FisTiempoCreacion),
							($DatFichaIngresoSuministro->FisTiempoModificacion),
							$DatFichaIngresoSuministro->FisCantidad,
							$DatFichaIngresoSuministro->FisCantidadReal,
							$DatFichaIngresoSuministro->RtiId,
							$DatFichaIngresoSuministro->UmeNombre,
							$DatFichaIngresoSuministro->UmeIdOrigen,
							$DatFichaIngresoSuministro->FisEstado);
						}
					}
				}
				
				
				if(!empty($DatFichaIngresoModalidad->FichaIngresoMantenimiento)){
					foreach($DatFichaIngresoModalidad->FichaIngresoMantenimiento as $DatFichaIngresoMantenimiento){		
				
						if(!empty($DatFichaIngresoMantenimiento->MinSigla)){ //AUX
							$_SESSION['InsFichaIngresoMantenimiento'.$DatFichaIngresoMantenimiento->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
							$DatFichaIngresoMantenimiento->FiaId,
							NULL,
							$DatFichaIngresoMantenimiento->PmtId,
							$DatFichaIngresoMantenimiento->FiaAccion,
							$DatFichaIngresoMantenimiento->FiaTiempoCreacion,
							$DatFichaIngresoMantenimiento->FipTiempoModificacion,
							($DatFichaIngresoMantenimiento->FiaNivel),
							($DatFichaIngresoMantenimiento->FiaVerificar1),
							$DatFichaIngresoMantenimiento->FiaVerificar2,
							$DatFichaIngresoMantenimiento->FiaEstado
							);
						}

					}
				}			
				
				
				
			}
			

	}
	
}
?>