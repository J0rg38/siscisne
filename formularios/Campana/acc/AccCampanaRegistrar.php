<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsCampana->CamId = $_POST['CmpId'];
	$InsCampana->CamCodigo = $_POST['CmpCodigo'];
	$InsCampana->CamNombre = $_POST['CmpNombre'];
	$InsCampana->CamFechaInicio = FncCambiaFechaAMysql($_POST['CmpFechaInicio']);	
	$InsCampana->CamFechaFin = FncCambiaFechaAMysql($_POST['CmpFechaFin'],true);
	$InsCampana->CamObservacion = addslashes($_POST['CmpObservacion']);
	
	list($InsCampana->CamAno,$InsCampana->CamMes,$aux) = explode("-",$InsCampana->CamFechaInicio);
	
	
	$InsCampana->CamArchivo1 = utf8_decode($_SESSION['CampanaArchivo1'.$Identificador]);
	$InsCampana->CamArchivo2 = utf8_encode($_SESSION['CampanaArchivo2'.$Identificador]);
	$InsCampana->CamArchivo3 = utf8_encode($_SESSION['CampanaArchivo3'.$Identificador]);

	$InsCampana->CamOperacionCodigo = $_POST['CmpOperacionCodigo'];
	$InsCampana->CamOperacionTiempo = preg_replace("/,/", "", (empty($_POST['CmpOperacionTiempo'])?0:$_POST['CmpOperacionTiempo']));
	
	$InsCampana->CamBoletinCodigo = $_POST['CmpBoletinCodigo'];
	$InsCampana->CamBoletin =utf8_encode( $_SESSION['CampanaBoletin'.$Identificador]);
	
	$InsCampana->VmaId = $_POST['CmpVehiculoMarca'];
	$InsCampana->VmoId = $_POST['CmpVehiculoModelo'];
	
	$InsCampana->CamEstado = 1;
	$InsCampana->CamTiempoCreacion = date("Y-m-d H:i:s");
	$InsCampana->CamTiempoModificacion = date("Y-m-d H:i:s");
	$InsCampana->CamEliminado = 1;
		
	$ResCampanaVehiculo = $_SESSION['InsCampanaVehiculo'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResCampanaVehiculo['Datos'])){
		foreach($ResCampanaVehiculo['Datos'] as $DatSesionObjeto){

	
			//SesionObjeto-InsCampanaVehiculo
			//Parametro1 = AveId
			//Parametro2 = AveVIN
			//Parametro3 = 
			//Parametro4 = 
			//Parametro5 = 
			//Parametro6 = AveEstado
			//Parametro7 = AveTiempoCreacion
			//Parametro8 = AveTiempoModificacion
	
			$InsCampanaVehiculo1 = new ClsCampanaVehiculo();
			$InsCampanaVehiculo1->AveId = $DatSesionObjeto->Parametro1;
			$InsCampanaVehiculo1->AveVIN = $DatSesionObjeto->Parametro2;
			$InsCampanaVehiculo1->AveEstado = $DatSesionObjeto->Parametro6;
			$InsCampanaVehiculo1->AveTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsCampanaVehiculo1->AveTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsCampanaVehiculo1->AveEliminado = $DatSesionObjeto->Eliminado;				
			$InsCampanaVehiculo1->InsMysql = NULL;
			
			$InsCampana->CampanaVehiculo[] = $InsCampanaVehiculo1;	
			
		}

	}


	if($InsCampana->MtdRegistrarCampana()){

		unset($InsCampana);
		
		unset($_SESSION['InsCampanaVehiculo'.$Identificador]);	
		unset($_SESSION['CampanaArchivo1'.$Identificador]);	
		unset($_SESSION['CampanaArchivo2'.$Identificador]);	
		unset($_SESSION['CampanaArchivo3'.$Identificador]);	
		
		unset($_SESSION['CampanaBoletin'.$Identificador]);	
	
		$Registro = true;
		$Resultado.='#SAS_CAM_101';
	} else{
		$InsCampana->CamFechaInicio = FncCambiaFechaANormal($InsCampana->CamFechaInicio);		
		$InsCampana->CamFechaFin = FncCambiaFechaANormal($InsCampana->CamFechaFin,true);	
		$Resultado.='#ERR_CAM_101';
	}

}else{

	$InsCampana->CamFechaInicio  = date("d/m/Y");

}
?>