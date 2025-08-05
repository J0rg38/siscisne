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


$ResVehiculoRecepcionDetalle = $_SESSION['InsVehiculoRecepcionDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
$ArrVehiculoRecepcionDetalles = $ResVehiculoRecepcionDetalle['Datos'];

if(!empty($ArrVehiculoRecepcionDetalles)){
	foreach($ArrVehiculoRecepcionDetalles as $DatVehiculoRecepcionDetalle){
			
		$InsVehiculoRecepcionDetalle1 = new ClsVehiculoRecepcionDetalle();
		$InsVehiculoRecepcionDetalle1->VrdId = $DatVehiculoRecepcionDetalle->Parametro1;
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
			
			$_SESSION['InsVehiculoRecepcionDetalleFoto'.$DatVehiculoRecepcionDetalle->Item.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoRecepcionDetalleFoto'.$DatVehiculoRecepcionDetalle->Item.$Identificador]);
		
		}	




			//		SesionObjeto-VehiculoRecepcionDetalleFoto
			//		Parametro1 = VrfId
			//		Parametro2 = VrdId
			//		Parametro3 = VrfArchivo
			//		Parametro4 = VrfEstado
			//		Parametro5 = VrfTiempoCreacion
			//		Parametro6 = VrfTiempoModificacion
			
			//deb('InsVehiculoRecepcionDetalleFoto'.$DatVehiculoRecepcionDetalle->Item.$Identificador);
			
		$ResVehiculoRecepcionDetalleFoto = $_SESSION['InsVehiculoRecepcionDetalleFoto'.$DatVehiculoRecepcionDetalle->Item.$Identificador]->MtdObtenerSesionObjetos(false);
		$ArrVehiculoRecepcionDetalleFotos = $ResVehiculoRecepcionDetalleFoto['Datos'];



		if(!empty($ArrVehiculoRecepcionDetalleFotos)){
			foreach($ArrVehiculoRecepcionDetalleFotos as $DatVehiculoRecepcionDetalleFoto){

				$InsVehiculoRecepcionDetalleFoto1 = new ClsVehiculoRecepcionDetalleFoto();
				$InsVehiculoRecepcionDetalleFoto1->VrfId = $DatVehiculoRecepcionDetalleFoto->Parametro1;
				$InsVehiculoRecepcionDetalleFoto1->VrdId = NULL;
				$InsVehiculoRecepcionDetalleFoto1->VrfArchivo = $DatVehiculoRecepcionDetalleFoto->Parametro3;
				$InsVehiculoRecepcionDetalleFoto1->VrfEstado = $DatVehiculoRecepcionDetalleFoto->Parametro4;
				
				$InsVehiculoRecepcionDetalleFoto1->VrfTiempoCreacion = FncCambiaFechaAMysql($DatVehiculoRecepcionDetalleFoto->Parametro5);
				$InsVehiculoRecepcionDetalleFoto1->VrfTiempoModificacion = date("Y-m-d H:i:s");
				$InsVehiculoRecepcionDetalleFoto1->VrfEliminado = $DatVehiculoRecepcionDetalleFoto->Eliminado;
		
				$InsVehiculoRecepcionDetalle1->VehiculoRecepcionDetalleFoto[] = $InsVehiculoRecepcionDetalleFoto1;
				
				if( $InsVehiculoRecepcionDetalleFoto1->VrfEliminado==1 ){
					
				}

			}
		}
		
		
		
		$InsVehiculoRecepcion->VehiculoRecepcionDetalle[] = $InsVehiculoRecepcionDetalle1;
		
		if( $InsVehiculoRecepcionDetalle1->VrdEliminado==1 ){
			
		}
		
	}
			
}

	
	if($Guardar){
		if($InsVehiculoRecepcion->MtdEditarVehiculoRecepcion()){
			
			
			//deb($InsVehiculoRecepcion->VreNotificar);
			if($InsVehiculoRecepcion->VreNotificar=="1"){
				
				$InsVehiculoRecepcion->MtdNotificarVehiculoRecepcion($InsVehiculoRecepcion->VreId,$CorreosNotificacionRecepcionVehicular);
				
			}
			
			$Edito = true;		
			$Resultado.='#SAS_VRE_102';
			FncCargarDatos();
			
		} else{

			$InsVehiculoRecepcion->VreFecha = FncCambiaFechaANormal($InsVehiculoRecepcion->VreFecha);
			
			$Resultado.='#ERR_VRE_102';
		}		
	}else{
	
		
		$InsVehiculoRecepcion->VreFecha = FncCambiaFechaANormal($InsVehiculoRecepcion->VreFecha);	
	}
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){

	global $GET_id;
	global $Identificador;
	global $InsVehiculoRecepcion;

//deb('InsVehiculoRecepcionDetalle'.$Identificador);
	
	//unset($InsVehiculoRecepcion);
	unset($_SESSION['InsVehiculoRecepcionDetalle'.$Identificador]);
	
	$_SESSION['InsVehiculoRecepcionDetalle'.$Identificador] = new ClsSesionObjeto();
	
	//for($i=0;$i<=50;$i++){
//		
//		unset($_SESSION['InsVehiculoRecepcionDetalleFoto'.$i.$Identificador]);
//			
//		$_SESSION['InsVehiculoRecepcionDetalleFoto'.$i.$Identificador] = new ClsSesionObjeto();
//				
//	}
	
	$ResVehiculoRecepcionDetalle = $_SESSION['InsVehiculoRecepcionDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
$ArrVehiculoRecepcionDetalles = $ResVehiculoRecepcionDetalle['Datos'];


	$InsVehiculoRecepcion->VreId = $GET_id;
	$InsVehiculoRecepcion->MtdObtenerVehiculoRecepcion();	
	
	$detalle = 0;
	if(!empty($InsVehiculoRecepcion->VehiculoRecepcionDetalle)){
		foreach($InsVehiculoRecepcion->VehiculoRecepcionDetalle as $DatVehiculoRecepcionDetalle){


			unset($_SESSION['InsVehiculoRecepcionDetalleFoto'.$detalle.$Identificador]);
			
			$_SESSION['InsVehiculoRecepcionDetalleFoto'.$detalle.$Identificador] = new ClsSesionObjeto();


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

			$_SESSION['InsVehiculoRecepcionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatVehiculoRecepcionDetalle->VrdId,
			$DatVehiculoRecepcionDetalle->VreId,
			$DatVehiculoRecepcionDetalle->VrdZonaComprometida,
			$DatVehiculoRecepcionDetalle->VrdRepuestoDetalle,
			$DatVehiculoRecepcionDetalle->VrdSolucion,
			$DatVehiculoRecepcionDetalle->VrdObservacion,
			($DatVehiculoRecepcionDetalle->VrdTiempoCreacion),
			($DatVehiculoRecepcionDetalle->VrdTiempoModificacion),
			$DatVehiculoRecepcionDetalle->VrdEstado
			);
			
			
			
			//		SesionObjeto-VehiculoRecepcionDetalleFoto
			//		Parametro1 = VrfId
			//		Parametro2 = VrdId
			//		Parametro3 = VrfArchivo
			//		Parametro4 = VrfEstado
			//		Parametro5 = VrfTiempoCreacion
			//		Parametro6 = VrfTiempoModificacion
			
			//deb($DatVehiculoRecepcionDetalle);
			//deb($DatVehiculoRecepcionDetalle->VehiculoRecepcionDetalleFoto);
			
			if(!empty($DatVehiculoRecepcionDetalle->VehiculoRecepcionDetalleFoto)){
				foreach($DatVehiculoRecepcionDetalle->VehiculoRecepcionDetalleFoto as $DatVehiculoRecepcionDetalleFoto){
				
					$_SESSION['InsVehiculoRecepcionDetalleFoto'.$detalle.$Identificador]->MtdAgregarSesionObjeto(1,
					$DatVehiculoRecepcionDetalleFoto->VrfId,
					$DatVehiculoRecepcionDetalleFoto->VrdId,
					$DatVehiculoRecepcionDetalleFoto->VrfArchivo,
					$DatVehiculoRecepcionDetalleFoto->VrfEstado,
					$DatVehiculoRecepcionDetalleFoto->VrfTiempoCreacion,
					$DatVehiculoRecepcionDetalleFoto->VrfTiempoModificacion
					);
				
				}			
			}
			
			$detalle++;
		}
	}
	
	
	
	
	
	

	
}
?>