<?php

//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;	
	
	$InsOrdenVentaVehiculo->OvvId = $_POST['CmpId'];
	$InsOrdenVentaVehiculo->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsOrdenVentaVehiculo->CliNombre = $_POST['CmpClienteNombre'];
	$InsOrdenVentaVehiculo->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
		
	$ResOrdenVentaVehiculoLlamada = $_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResOrdenVentaVehiculoLlamada['Datos'])){
		foreach($ResOrdenVentaVehiculoLlamada['Datos'] as $DatSesionObjeto){

			//SesionObjeto-InsOrdenVentaVehiculoLlamada
			//Parametro1 = OvlId
			//Parametro2 = 
			//Parametro3 = OvlFecha
			//Parametro4 = 
			//Parametro5 = OvlObservacion
			//Parametro6 = OvlEstado
			//Parametro7 = OvlTiempoCreacion
			//Parametro8 = OvlTiempoModificacion
	
			$InsOrdenVentaVehiculoLlamada1 = new ClsOrdenVentaVehiculoLlamada();
			$InsOrdenVentaVehiculoLlamada1->OvlId = $DatSesionObjeto->Parametro1;
			$InsOrdenVentaVehiculoLlamada1->OvlFecha = FncCambiaFechaAMysql($DatSesionObjeto->Parametro3);
			$InsOrdenVentaVehiculoLlamada1->OvlObservacion = $DatSesionObjeto->Parametro5;
			$InsOrdenVentaVehiculoLlamada1->OvlEstado = $DatSesionObjeto->Parametro6;
			$InsOrdenVentaVehiculoLlamada1->OvlTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsOrdenVentaVehiculoLlamada1->OvlTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsOrdenVentaVehiculoLlamada1->OvlEliminado = $DatSesionObjeto->Eliminado;				
			$InsOrdenVentaVehiculoLlamada1->InsMysql = NULL;
			
			$InsOrdenVentaVehiculo->OrdenVentaVehiculoLlamada[] = $InsOrdenVentaVehiculoLlamada1;		
			
			if($InsOrdenVentaVehiculoLlamada1->OvlEliminado==1){					
				
			}

		}

	}
	
	



	if($Guardar){

		if($InsOrdenVentaVehiculo->MtdSeguimientoClienteOrdenVentaVehiculo()){
			
			
				if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
				}
				
				
			$Edito = true;
			$Resultado.='#SAS_OVV_110';
		}else{
			$Resultado.='#ERR_OVV_107';
		}

	}	
	
	$InsOrdenVentaVehiculo->OvvFecha = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvFecha);		
	
		
}else{

	FncCargarDatos();
}


function FncCargarDatos(){

	global $InsOrdenVentaVehiculo;
	global $Identificador;
	
	global $GET_Id;

	unset($_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador]);
			
	$_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador] = new ClsSesionObjeto();	

	$InsOrdenVentaVehiculo->OvvId = $GET_Id;
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
	
	//SesionObjeto-InsOrdenVentaVehiculoLlamada
	//Parametro1 = OvlId
	//Parametro2 = 
	//Parametro3 = OvlFecha
	//Parametro4 = 
	//Parametro5 = OvlObseracion
	//Parametro6 = OvlEstado
	//Parametro7 = OvlTiempoCreacion
	//Parametro8 = OvlTiempoModificacion
		
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoLlamada)){
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoLlamada as $DatOrdenVentaVehiculoLlamada){					
	
			$_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatOrdenVentaVehiculoLlamada->OvlId,
			NULL,
			FncCambiaFechaANormal($DatOrdenVentaVehiculoLlamada->OvlFecha),	
			NULL,
			$DatOrdenVentaVehiculoLlamada->OvlObservacion,
			$DatOrdenVentaVehiculoLlamada->OvlEstado,
			($DatOrdenVentaVehiculoLlamada->OvlTiempoCreacion),
			($DatOrdenVentaVehiculoLlamada->OvlTiempoModificacion)
			);

		}
	}
	
	
	

}

?>

