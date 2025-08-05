<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsVehiculoRecepcion->VreId = $_POST['CmpId'];
	
	$InsVehiculoRecepcion->PerId = $_POST['CmpPersonal'];
	
	$InsVehiculoRecepcion->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsVehiculoRecepcion->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	$InsVehiculoRecepcion->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsVehiculoRecepcion->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsVehiculoRecepcion->EinColor = $_POST['CmpVehiculoIngresoColor'];
		
	$InsVehiculoRecepcion->VreTieneGuia = $_POST['CmpTieneGuia'];
	$InsVehiculoRecepcion->VreGuiaRemisionNumero = $_POST['CmpGuiaRemisionNumero'];
	$InsVehiculoRecepcion->VreFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsVehiculoRecepcion->VreObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsVehiculoRecepcion->VreEstado = $_POST['CmpEstado'];
	$InsVehiculoRecepcion->VreTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoRecepcion->VreTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsVehiculoRecepcion->VreNotificar = $_POST['CmpNotificar'];

	if(empty($InsVehiculoRecepcion->EinId)){
		$Resultado.='#ERR_VRE_301';
		$Guardar = false;
	}
	
	if(empty($InsVehiculoRecepcion->PerId)){
		$Resultado.='#ERR_VRE_302';
		$Guardar = false;
	}
	
	
	$InsVehiculoRecepcion->VehiculoRecepcionDetalle = array();


//						SesionObjeto-VehiculoRecepcionDetalle
//						Parametro1 = VrdId
//						Parametro2 = VreId
//						Parametro3 = VrdZonaComprometida
//						Parametro4 = VrdRepuestoDetalle
//						Parametro5 = VrdSolucion
//						Parametro6 = VrdObservacion
//						Parametro7 = VrdTiempoCreacion
//						Parametro8 = VrdTiempoModificacion
//						Parametro9 = VrdEstado

	$ResVehiculoRecepcionDetalle = $_SESSION['InsVehiculoRecepcionDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrVehiculoRecepcionDetalles = $ResVehiculoRecepcionDetalle['Datos'];
	
	if(!empty($ArrVehiculoRecepcionDetalles)){
		foreach($ArrVehiculoRecepcionDetalles as $DatVehiculoRecepcionDetalle){
	
	
			$InsVehiculoRecepcionDetalle1 = new ClsVehiculoRecepcionDetalle();
			
			$InsVehiculoRecepcionDetalle1->VrdId = NULL;
			$InsVehiculoRecepcionDetalle1->VreId = NULL;
			$InsVehiculoRecepcionDetalle1->VrdZonaComprometida = $DatVehiculoRecepcionDetalle->Parametro3;
			$InsVehiculoRecepcionDetalle1->VrdRepuestoDetalle = $DatVehiculoRecepcionDetalle->Parametro4;
			$InsVehiculoRecepcionDetalle1->VrdSolucion = $DatVehiculoRecepcionDetalle->Parametro5;
			$InsVehiculoRecepcionDetalle1->VrdObservacion = $DatVehiculoRecepcionDetalle->Parametro6;
			
			$InsVehiculoRecepcionDetalle1->VrdEstado = $DatVehiculoRecepcionDetalle->Parametro9;
			$InsVehiculoRecepcionDetalle1->VrdEliminado = $DatVehiculoRecepcionDetalle->Eliminado;
			$InsVehiculoRecepcionDetalle1->VrdTiempoCreacion = FncCambiaFechaAMysql($DatVehiculoRecepcionDetalle->Parametro7);
			$InsVehiculoRecepcionDetalle1->VrdTiempoModificacion = date("Y-m-d H:i:s");
	
			if (isset($_SESSION['InsVehiculoRecepcionDetalleFoto'.$DatVehiculoRecepcionDetalle->Item.$Identificador])){
				
				if (!isset($_SESSION['InsVehiculoRecepcionDetalleFoto'.$DatVehiculoRecepcionDetalle->Item.$Identificador])){	
					$_SESSION['InsVehiculoRecepcionDetalleFoto'.$DatVehiculoRecepcionDetalle->Item.$Identificador] = new ClsSesionObjeto();
				}else{	
					$_SESSION['InsVehiculoRecepcionDetalleFoto'.$DatVehiculoRecepcionDetalle->Item.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoRecepcionDetalleFoto'.$DatVehiculoRecepcionDetalle->Item.$Identificador]);
				}
			
			}	
	
	
				//		SesionObjeto-VehiculoRecepcionDetalleFoto
				//		Parametro1 = VrfId
				//		Parametro2 = VrdId
				//		Parametro3 = VrfArchivo
				//		Parametro4 = VrfEstado
				//		Parametro5 = VrfTiempoCreacion
				//		Parametro6 = VrfTiempoModificacion
				
				
			$ResVehiculoRecepcionDetalleFoto = $_SESSION['InsVehiculoRecepcionDetalleFoto'.$DatVehiculoRecepcionDetalle->Item.$Identificador]->MtdObtenerSesionObjetos(true);
			$ArrVehiculoRecepcionDetalleFotos = $ResVehiculoRecepcionDetalleFoto['Datos'];
			
			if(!empty($ArrVehiculoRecepcionDetalleFotos)){
				foreach($ArrVehiculoRecepcionDetalleFotos as $DatVehiculoRecepcionDetalleFoto){
					
					$InsVehiculoRecepcionDetalleFoto1 = new ClsVehiculoRecepcionDetalleFoto();
					$InsVehiculoRecepcionDetalleFoto1->VrfId = NULL;
					$InsVehiculoRecepcionDetalleFoto1->VrdId = NULL;
					$InsVehiculoRecepcionDetalleFoto1->VrfArchivo = $DatVehiculoRecepcionDetalleFoto->Parametro3;
					$InsVehiculoRecepcionDetalleFoto1->VrfEstado = $DatVehiculoRecepcionDetalleFoto->Parametro4;
	
					$InsVehiculoRecepcionDetalleFoto1->VrfTiempoCreacion = FncCambiaFechaAMysql($DatVehiculoRecepcionDetalleFoto->Parametro5);
					$InsVehiculoRecepcionDetalleFoto1->VrfTiempoModificacion = date("Y-m-d H:i:s");
					$InsVehiculoRecepcionDetalleFoto1->VrfEliminado = $DatVehiculoRecepcionDetalleFoto->Eliminado;
									
					if( $InsVehiculoRecepcionDetalleFoto1->VrfEliminado==1 ){
						$InsVehiculoRecepcionDetalle1->VehiculoRecepcionDetalleFoto[] = $InsVehiculoRecepcionDetalleFoto1;
					}
			
				}
			}
			
		//	deb($DatVehiculoRecepcionDetalle->VrdEliminado);
			
			if( $InsVehiculoRecepcionDetalle1->VrdEliminado==1 ){
				
				$InsVehiculoRecepcion->VehiculoRecepcionDetalle[] = $InsVehiculoRecepcionDetalle1;
				
			}
		}
		
	}


	if($Guardar){
		
		if($InsVehiculoRecepcion->MtdRegistrarVehiculoRecepcion()){
			
			if($InsVehiculoRecepcion->VreNotificar=="1"){
				
				$InsVehiculoRecepcion->MtdNotificarVehiculoRecepcion($InsVehiculoRecepcion->VreId,$CorreosNotificacionRecepcionVehicular);
				
			}
			
			FncNuevo();
				
			$Registro = true;
			$Resultado.='#SAS_VRE_101';
		}else{
			
			$InsVehiculoRecepcion->VreFecha = FncCambiaFechaANormal($InsVehiculoRecepcion->VreFecha);				
			
			$Resultado.='#ERR_VRE_101';
		}
		
	}else{
		
		$InsVehiculoRecepcion->VreFecha = FncCambiaFechaANormal($InsVehiculoRecepcion->VreFecha);	

	}
	


}else{
	
	FncNuevo();

	
}

function FncNuevo(){
	
	global $Identificador;
	
	global $InsVehiculoRecepcion;

	
	unset($_SESSION['InsVehiculoRecepcionDetalle'.$Identificador]);

	$_SESSION['InsVehiculoRecepcionDetalle'.$Identificador] = new ClsSesionObjeto();	

	for($i=0;$i<=15;$i++){
		
		unset($_SESSION['InsVehiculoRecepcionDetalleFoto'.$i.$Identificador]);
				
		$_SESSION['InsVehiculoRecepcionDetalleFoto'.$i.$Identificador] = new ClsSesionObjeto();
			
	}
	
			
	$InsVehiculoRecepcion = new ClsVehiculoRecepcion();
	
	$InsVehiculoRecepcion->PerId = $_SESSION['SesionPersonal'];
	$InsVehiculoRecepcion->VreFecha = date("d/m/Y");
	$InsVehiculoRecepcion->VreEstado = 3;
	$InsVehiculoRecepcion->VreNotificar = 1;
}
?>
