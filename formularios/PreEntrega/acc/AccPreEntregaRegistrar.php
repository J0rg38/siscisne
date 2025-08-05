<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

//deb($_POST);	
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
	$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"PRINCIPAL");
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
	//$InsFichaIngreso->FinAno = date("Y");
	$InsFichaIngreso->SucId = $_SESSION['SesionSucursal'];
	
	
	$InsFichaIngreso->CliId = $ClienteId;
	$InsFichaIngreso->CamId = $_POST['CmpCampanaId'];
	$InsFichaIngreso->CamNombre = $_POST['CmpCampanaNombre'];
	$InsFichaIngreso->CamCodigo = $_POST['CmpCampanaCodigo'];
	
	$InsFichaIngreso->PerId = $_POST['CmpPersonal'];
	$InsFichaIngreso->PerIdAsesor = $_POST['CmpAsesor'];
	
	//$InsFichaIngreso->PmaId = $_POST['CmpPlanMantenimiento'];
	
	$InsFichaIngreso->MonId = $EmpresaMonedaId;
	
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
	
	$InsFichaIngreso->FinConductor = $_POST['CmpConductor'];
	$InsFichaIngreso->FinTelefono = $_POST['CmpClienteCelular'];
	$InsFichaIngreso->FinDireccion = $_POST['CmpClienteDireccion'];
	$InsFichaIngreso->FinContacto = $_POST['CmpClienteContacto'];
	
	$InsFichaIngreso->FinFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	list($InsFichaIngreso->FinAno,$Mes,$Dia) = explode("-",$InsFichaIngreso->FinFecha);

	$InsFichaIngreso->FinFechaEntrega = NULL;
	$InsFichaIngreso->FinHoraEntrega = NULL;
	
	$InsFichaIngreso->FinFechaCita = NULL;
	$InsFichaIngreso->FinHora = NULL;
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
	
	$InsFichaIngreso->FinSalidaFecha = FncCambiaFechaAMysql($_POST['CmpSalidaFecha'],true);
	$InsFichaIngreso->FinSalidaHora = $_POST['CmpSalidaHora'];
	$InsFichaIngreso->FinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsFichaIngreso->FinSalidaObservacion = $_POST['CmpSalidaObservacion'];	

	$InsFichaIngreso->FinVehiculoKilometraje = $_POST['CmpVehiculoKilometraje'];	
	$InsFichaIngreso->FinMantenimientoKilometraje = 0;	
	
	$InsFichaIngreso->FinPrecioEstimado = 0;
	
	$InsFichaIngreso->FinPrioridad = $_POST['CmpPrioridad'];		
	$InsFichaIngreso->FinTipo = 2;	
	
	$InsFichaIngreso->FinOrigenEntrega = $_POST['CmpOrigenEntrega'];
	
	$InsFichaIngreso->FinMontoPresupuesto = 0;	
	
	$InsFichaIngreso->FinEstado = $_POST['CmpEstado'];	
	$InsFichaIngreso->FinTiempoCreacion = date("Y-m-d H:i:s");
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
	$InsFichaIngreso->FinEliminado = 1;
	
	$InsFichaIngreso->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsFichaIngreso->CliNombre = $_POST['CmpClienteNombre'];
	$InsFichaIngreso->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	
	list($InsFichaIngreso->FinAno,$Mes,$Dia) = explode("-",$InsFichaIngreso->FinFecha);
	
	$InsFichaIngreso->FichaIngresoModalidad = array();


				
	foreach($ArrModalidadIngresos as $DatModalidadIngreso){

		$InsFichaIngresoModalidad1 = new ClsFichaIngresoModalidad();
		$InsFichaIngresoModalidad1->MinId = $_POST['CmpModalidadId_'.$DatModalidadIngreso->MinSigla];
		$InsFichaIngresoModalidad1->FimObsequio = 2;
		$InsFichaIngresoModalidad1->FimEstado = 1;
		$InsFichaIngresoModalidad1->FimTiempoCreacion = date("Y-m-d H:i:s");
		$InsFichaIngresoModalidad1->FimTiempoModificacion = date("Y-m-d H:i:s");
		$InsFichaIngresoModalidad1->InsMysql = NULL;

		
		if(!empty($InsFichaIngresoModalidad1->MinId)){

	/*
	SesionObjeto-FichaIngresoProducto
	Parametro1 = FidId
	Parametro2 = ProId
	Parametro3 = ProNombre
	Parametro4 = 
	Parametro5 = 
	Parametro6 = 
	Parametro7 = FipTiempoCreacion
	Parametro8 = FipTiempoModificacion
	*/

			$ResFichaIngresoProducto = $_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);

			if(!empty($ResFichaIngresoProducto['Datos'])){
				$item = 1;
				foreach($ResFichaIngresoProducto['Datos'] as $DatSesionObjeto){

					$InsFichaIngresoProducto1 = new ClsFichaIngresoProducto();
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
	
				$ResFichaIngresoTarea = $_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador]->MtdObtenerSesionObjetos(true);
		
				if(!empty($ResFichaIngresoTarea['Datos'])){
					$item = 1;
					foreach($ResFichaIngresoTarea['Datos'] as $DatSesionObjeto){
							
						$InsFichaIngresoTarea1 = new ClsFichaIngresoTarea();
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
			
			
				$InsFichaIngreso->FichaIngresoModalidad[] = $InsFichaIngresoModalidad1;	

			}

			

		

	}

	
	if(empty($InsFichaIngreso->FichaIngresoModalidad)){
		$Resultado.='#ERR_FIN_607';
		$Guardar = false;
	}
	
	if($Guardar){
		if($InsFichaIngreso->MtdRegistrarFichaIngreso()){
	
			$Resultado.='#PRE-ENTREGA (PDS) NUMERO: '.$InsFichaIngreso->FinId;
	
			unset($InsFichaIngreso);
			$InsFichaIngreso = new ClsFichaIngreso();
			
			unset($_SESSION['InsPreEntregaDetalle'.$Identificador]);
			unset($_SESSION['InsPreEntregaCliente'.$Identificador]);
			
			$_SESSION['InsPreEntregaDetalle'.$Identificador] = new ClsSesionObjeto();	
			$_SESSION['InsPreEntregaCliente'.$Identificador] = new ClsSesionObjeto();	
			
				foreach($ArrModalidadIngresos as $DatModalidadIngreso){
					
					unset($_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador]);
					unset($_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador]);
					unset($_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]);
					
			
					$_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
					$_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
					$_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
					
			
				}
		
			$Registro = true;
			$InsFichaIngreso->FinEstado = 1;
			$InsFichaIngreso->FinPrioridad = 2;
			$InsFichaIngreso->FinFecha = date("d/m/Y");	
			$Resultado.='#SAS_FIN_101';		
	
		} else{
			
			$InsFichaIngreso->FinId = "";
			$InsFichaIngreso->FinFecha = FncCambiaFechaANormal($InsFichaIngreso->FinFecha);
			$Resultado.='#ERR_FIN_101';
		}	
	}else{

			$InsFichaIngreso->FinId = "";
			$InsFichaIngreso->FinFecha = FncCambiaFechaANormal($InsFichaIngreso->FinFecha);
			$Resultado.='#ERR_FIN_101';

	}




}else{

	unset($_SESSION['InsPreEntregaDetalle'.$Identificador]);
	unset($_SESSION['InsPreEntregaCliente'.$Identificador]);
	
	$_SESSION['InsPreEntregaDetalle'.$Identificador] = new ClsSesionObjeto();	
	$_SESSION['InsPreEntregaCliente'.$Identificador] = new ClsSesionObjeto();	

	
	foreach($ArrModalidadIngresos as $DatModalidadIngreso){
		
		unset($_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador]);
		unset($_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador]);
		unset($_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]);

		$_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
		$_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	
		$_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();	

	}
	
	
//	unset($_SESSION['InsFichaIngresoTarea'.$Identificador]);
//	unset($_SESSION['InsFichaIngresoProducto'.$Identificador]);
//	
//	$_SESSION['InsFichaIngresoTarea'.$Identificador] = new ClsSesionObjeto();
//	$_SESSION['InsFichaIngresoProducto'.$Identificador] = new ClsSesionObjeto();
	
	$InsFichaIngreso->FinEstado = 1;
	$InsFichaIngreso->FinPrioridad = 2;
	//$InsFichaIngreso->PerIdAsesor = $_SESSION['SesionPersonal'];
//	$InsFichaIngreso->FinOrigenEntrega = "TACNA PRINCIPAL";
	$InsFichaIngreso->PerIdAsesor = $_SESSION['SesionPersonal'];
	$InsFichaIngreso->SucId = $_SESSION['SesionSucursal'];
	
	
	$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
	$InsFichaIngresoModalidad->MinId = "MIN-10013";
	$InsFichaIngreso->FichaIngresoModalidad[] = $InsFichaIngresoModalidad;
					
					
	
	$RepPreEntregaSeccion = $InsPreEntregaSeccion->MtdObtenerPreEntregaSecciones(NULL,NULL,"PesId","ASC",NULL);
	$ArrPreEntregaSecciones = $RepPreEntregaSeccion['Datos'];
	
	foreach($ArrPreEntregaSecciones as $DatPreEntregaSeccion){
	
		
		$ResPreEntregaTarea = $InsPreEntregaTarea->MtdObtenerPreEntregaTareas(NULL,NULL,'PetNombre','ASC',NULL,$DatPreEntregaSeccion->PesId);
		$ArrPreEntregaTareas = $ResPreEntregaTarea['Datos'];
	
		foreach($ArrPreEntregaTareas as $DatPreEntregaTarea){
	
			$_SESSION['InsPreEntregaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			NULL,
			$DatPreEntregaTarea->PetId,
			1,
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s")
			);

		}
		
	}
	
	
	
	
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
	//deb($InsFichaIngreso->PerIdAsesor );
}
?>