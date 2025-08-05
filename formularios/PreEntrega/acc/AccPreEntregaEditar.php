<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$ModalidadMantenimiento = false;
	$ModalidadMantenimientoMarcado = true;
	$Guardar = true;
	$Resultado = '';
	
	
	$ClienteId = '';
	$ClienteNombreCompleto =  '';
	
	$ClienteNombre = '';
	$ClienteApellidoPaterno = '';
	$ClienteApellidoMaterno = '';
	
	$ClienteNumeroDocumento = '';
	$TipoDocumentoId = '';
			
	$InsCliente = new ClsCliente();
	
	$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"CYC");
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
		
			$ClienteId = $DatCliente->CliId;
			$ClienteNombreCompleto = $DatCliente->CliNombreCompleto;
			
			$ClienteNombre = $DatCliente->CliNombre;
			$ClienteApellidoPaterno = $DatCliente->CliApellidoPaterno;
			$ClienteApellidoMaterno = $DatCliente->CliApellidoMaterno;
			
			$ClienteNumeroDocumento = $DatCliente->CliNumeroDocumento;
			$TipoDocumentoId = $DatCliente->TdoId;

		}
	}
	
	

	$InsFichaIngreso->UsuId = $_SESSION['SesionId'];

	$InsFichaIngreso->FinId = $_POST['CmpId'];
	$InsFichaIngreso->CliId =$ClienteId;

	$InsFichaIngreso->CamId = $_POST['CmpCampanaId'];
	$InsFichaIngreso->CamNombre = $_POST['CmpCampanaNombre'];
	$InsFichaIngreso->CamCodigo = $_POST['CmpCampanaCodigo'];
		
	$InsFichaIngreso->PerId = $_POST['CmpPersonal'];
	$InsFichaIngreso->PerIdAsesor = $_POST['CmpAsesor'];

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
	
	$InsFichaIngreso->PmaId = $_POST['CmpPlanMantenimiento'];

	$InsFichaIngreso->FinConductor =($_POST['CmpConductor']);
	$InsFichaIngreso->FinTelefono = $_POST['CmpClienteCelular'];
	$InsFichaIngreso->FinDireccion = $_POST['CmpClienteDireccion'];
	$InsFichaIngreso->FinContacto = $_POST['CmpClienteContacto'];
	
	$InsFichaIngreso->FinFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	$InsFichaIngreso->FinFechaEntrega = FncCambiaFechaAMysql($_POST['CmpFechaEntrega'],true);
	$InsFichaIngreso->FinHoraEntrega = ($_POST['CmpHoraEntrega']);
	
	$InsFichaIngreso->FinFechaCita = FncCambiaFechaAMysql($_POST['CmpFechaCita'],true);
	
	$InsFichaIngreso->FinHora = ($_POST['CmpHora']);
	$InsFichaIngreso->FinObservacion = addslashes($_POST['CmpObservacion']);
	$InsFichaIngreso->MinId = $_POST['CmpModalidad'];

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
	
	$InsFichaIngreso->FinInformeTecnicoMantenimiento = $_POST['CmpMantenimiento'];	
	$InsFichaIngreso->FinInformeTecnicoRevision = $_POST['CmpRevision'];	
	$InsFichaIngreso->FinInformeTecnicoDiagnostico = $_POST['CmpDiagnostico'];	
	
	$InsFichaIngreso->FinSalidaFecha = NULL;
	$InsFichaIngreso->FinSalidaHora = NULL;
	$InsFichaIngreso->FinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsFichaIngreso->FinSalidaObservacion = $_POST['CmpSalidaObservacion'];	
	
	$InsFichaIngreso->FinVehiculoKilometraje = $_POST['CmpVehiculoKilometraje'];
	$InsFichaIngreso->FinMantenimientoKilometraje = (empty($_POST['CmpMantenimientoKilometraje'])?0:$_POST['CmpMantenimientoKilometraje']);
	

	$InsFichaIngreso->FinPrecioEstimado = 0;

	$InsFichaIngreso->FinPrioridad = $_POST['CmpPrioridad'];
	$InsFichaIngreso->FinOrigenEntrega = $_POST['CmpOrigenEntrega'];
	
	$InsFichaIngreso->FinMontoPresupuesto = 0;	
	
	$InsFichaIngreso->FinEstado = $_POST['CmpEstado'];
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
	$InsFichaIngreso->FinEliminado = 1;

	$InsFichaIngreso->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsFichaIngreso->CliNombre = $_POST['CmpClienteNombre'];
	$InsFichaIngreso->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];

	$InsFichaIngreso->FichaIngresoModalidad = array();
	
	
	


	
	
	foreach($ArrModalidadIngresos as $DatModalidadIngreso){

		$InsFichaIngresoModalidad1 = new ClsFichaIngresoModalidad();
		$InsFichaIngresoModalidad1->FimId = $_POST['CmpPreEntregaModalidadId_'.$DatModalidadIngreso->MinSigla];
		$InsFichaIngresoModalidad1->MinId = $_POST['CmpModalidadId_'.$DatModalidadIngreso->MinSigla];
		$InsFichaIngresoModalidad1->FimObsequio = empty($_POST['CmpPreEntregaModalidadObsequio_'.$DatModalidadIngreso->MinSigla])?2:1;
		$InsFichaIngresoModalidad1->FimEstado = 1;
		$InsFichaIngresoModalidad1->FimTiempoCreacion = date("Y-m-d H:i:s");
		$InsFichaIngresoModalidad1->FimTiempoModificacion = date("Y-m-d H:i:s");
		$InsFichaIngresoModalidad1->InsMysql = NULL;

	//	deb($InsFichaIngresoModalidad1->MinId);
		//if(!empty($InsFichaIngresoModalidad1->MinId)){
			
		/*
		SesionObjeto-FichaIngresoProducto
		Parametro1 = FipId
		Parametro2 = ProId
		Parametro3 = ProNombre
		Parametro4 = 
		Parametro5 = 
		Parametro6 = 
		Parametro7 = FipTiempoCreacion
		Parametro8 = FipTiempoModificacion
		*/
		$ResFichaIngresoProducto = $_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
		
		if(!empty($ResFichaIngresoProducto['Datos'])){
			$item = 1;
			foreach($ResFichaIngresoProducto['Datos'] as $DatSesionObjeto){
					
				$InsFichaIngresoProducto1 = new ClsFichaIngresoProducto();
				$InsFichaIngresoProducto1->FipId = $DatSesionObjeto->Parametro1;
				$InsFichaIngresoProducto1->ProId = $DatSesionObjeto->Parametro2;
									$InsFichaIngresoProducto1->FipCantidad = 1;
					$InsFichaIngresoProducto1->UmeId = "UME-10007";
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
		Parametro4 =
		Parametro5 =
		Parametro6 = FitAccion
		Parametro7 = FitTiempoCreacion
		Parametro8 = FitTiempoModificacion
		*/
	
			$ResFichaIngresoTarea = $_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
		
			if(!empty($ResFichaIngresoTarea['Datos'])){
				$item = 1;
				foreach($ResFichaIngresoTarea['Datos'] as $DatSesionObjeto){
						
					$InsFichaIngresoTarea1 = new ClsFichaIngresoTarea();
					$InsFichaIngresoTarea1->FitId = $DatSesionObjeto->Parametro1;
					$InsFichaIngresoTarea1->FitDescripcion = $DatSesionObjeto->Parametro3;
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

			
					
			
			//deb($InsFichaIngresoModalidad1->MinId);
			if(!empty($InsFichaIngresoModalidad1->FimId)){
				
				if(empty($InsFichaIngresoModalidad1->MinId)){
					
					//echo $DatModalidadIngreso->MinId;
					if($DatModalidadIngreso->MinId == "MIN-10001"){
						$ModalidadMantenimientoMarcado = false;
					}
					
					$InsFichaIngresoModalidad1->FimEliminado = 2;
				}else{
					$InsFichaIngresoModalidad1->FimEliminado = 1;
				}
			}else{
				if(empty($InsFichaIngresoModalidad1->MinId)){
					
					$InsFichaIngresoModalidad1->FimEliminado = 2;
				}else{
					$InsFichaIngresoModalidad1->FimEliminado = 1;
				}
	
			}
	
			$InsFichaIngresoModalidad1->InsMysql = NULL;
		
			$InsFichaIngreso->FichaIngresoModalidad[] = $InsFichaIngresoModalidad1;	

	}
	

	if($Guardar){
		if($InsFichaIngreso->MtdEditarFichaIngreso()){		
			$Resultado.='#SAS_FIN_102';
			$Edito = true;
	
			FncCargarDatos();
		} else{
			$Resultado.='#ERR_FIN_102';
			$InsFichaIngreso->FinFecha = FncCambiaFechaANormal($InsFichaIngreso->FinFecha);
		}
	}else{

		$Resultado.='#ERR_FIN_102';
		$InsFichaIngreso->FinFecha = FncCambiaFechaANormal($InsFichaIngreso->FinFecha);
			
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

	unset($_SESSION['InsPreEntregaDetalle'.$Identificador]);
	unset($_SESSION['InsPreEntregaCliente'.$Identificador]);

	$_SESSION['InsPreEntregaDetalle'.$Identificador] = new ClsSesionObjeto();	
	$_SESSION['InsPreEntregaCliente'.$Identificador] = new ClsSesionObjeto();	

	$InsFichaIngreso = new ClsFichaIngreso();
		
	foreach($ArrModalidadIngresos as $DatModalidadIngreso){
		
		unset($_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador]);
		unset($_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador]);
		unset($_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]);
		
		$_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
		$_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
		$_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
		
	}
		
	$InsFichaIngreso->FinId = $GET_id;
	$InsFichaIngreso->MtdObtenerFichaIngreso();	
	
	$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
	$ResVehiculoIngresoCliente =  $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,"VicId","ASC",NULL,$InsFichaIngreso->EinId);
	$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];


	if(!empty($ArrVehiculoIngresoClientes)){
    	foreach($ArrVehiculoIngresoClientes as $DatVehiculoIngresoCliente){

			/*
			SesionObjeto-PreEntregaCliente
			Parametro1 = 
			Parametro2 = CliId
			Parametro3 = CliNombre
			Parametro4 = CliNumeroDocumento
			Parametro5 = CliApellidoPaterno
			Parametro6 = CliApellidoMaterno
			Parametro7 = 
			Parametro8 = 
			*/

			$_SESSION['InsPreEntregaCliente'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			$DatVehiculoIngresoCliente->CliId,
			$DatVehiculoIngresoCliente->CliNombre,
			$DatVehiculoIngresoCliente->CliNumeroDocumento,
			$DatVehiculoIngresoCliente->CliApellidoPaterno,
			$DatVehiculoIngresoCliente->CliApellidoMaterno
			);
           
		}
	}
 

	//deb($InsFichaIngreso->PreEntregaDetalle);
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
							$DatFichaIngresoProducto->ProCodigoOriginal,
							$DatFichaIngresoProducto->ProCodigoAlternativo,
							NULL,
							($DatFichaIngresoProducto->FipTiempoCreacion),
							($DatFichaIngresoProducto->FipTiempoModificacion)
							);
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
				
				if(!empty($DatFichaIngresoModalidad->FichaIngresoSuministro)){
					foreach($DatFichaIngresoModalidad->FichaIngresoSuministro as $DatFichaIngresoSuministro){					

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
				
				
					
				
				
				
			}
			

	}
		
}
?>