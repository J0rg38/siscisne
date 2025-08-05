<?php

//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;	
	
	$InsCotizacionVehiculo->CveId = $_POST['CmpId'];
	$InsCotizacionVehiculo->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsCotizacionVehiculo->CliNombre = $_POST['CmpClienteNombre'];
	$InsCotizacionVehiculo->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
		
	$ResCotizacionVehiculoLlamada = $_SESSION['InsCotizacionVehiculoLlamada'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResCotizacionVehiculoLlamada['Datos'])){
		foreach($ResCotizacionVehiculoLlamada['Datos'] as $DatSesionObjeto){

			//SesionObjeto-InsCotizacionVehiculoLlamada
//Parametro1 = CvlId
//Parametro2 = CvlNumero
//Parametro3 = CvlFecha
//Parametro4 = CvlValor
//Parametro5 = CvlObservacion
//Parametro6 = CvlEstado
//Parametro7 = CvlFechaCreacion
//Parametro8 = CvlFechaModificacion	
//Parametro8 = CvlFechaProgramada
	
			$InsCotizacionVehiculoLlamada1 = new ClsCotizacionVehiculoLlamada();
			$InsCotizacionVehiculoLlamada1->CvlId = $DatSesionObjeto->Parametro1;
			$InsCotizacionVehiculoLlamada1->CvlFecha = FncCambiaFechaAMysql($DatSesionObjeto->Parametro3);
			$InsCotizacionVehiculoLlamada1->CvlFechaProgramada = FncCambiaFechaAMysql($DatSesionObjeto->Parametro9,true);
			$InsCotizacionVehiculoLlamada1->CvlObservacion = $DatSesionObjeto->Parametro5;
			$InsCotizacionVehiculoLlamada1->CvlEstado = $DatSesionObjeto->Parametro6;
			$InsCotizacionVehiculoLlamada1->CvlTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsCotizacionVehiculoLlamada1->CvlTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsCotizacionVehiculoLlamada1->CvlEliminado = $DatSesionObjeto->Eliminado;				
			$InsCotizacionVehiculoLlamada1->InsMysql = NULL;
			
			$InsCotizacionVehiculo->CotizacionVehiculoLlamada[] = $InsCotizacionVehiculoLlamada1;		
			
			if($InsCotizacionVehiculoLlamada1->CvlEliminado==1){					
				
			}

		}

	}
	
	



	if($Guardar){

		if($InsCotizacionVehiculo->MtdSeguimientoClienteCotizacionVehiculo()){
			
			
				if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
				}
				
				
			$Edito = true;
			$Resultado.='#SAS_CVE_110';
		}else{
			$Resultado.='#ERR_CVE_110';
		}

	}	
	
	$InsCotizacionVehiculo->CveFecha = FncCambiaFechaANormal($InsCotizacionVehiculo->CveFecha);		
	
		
}else{

	FncCargarDatos();
}


function FncCargarDatos(){

	global $InsCotizacionVehiculo;
	global $Identificador;
	
	global $GET_Id;

	unset($_SESSION['InsCotizacionVehiculoLlamada'.$Identificador]);
			
	$_SESSION['InsCotizacionVehiculoLlamada'.$Identificador] = new ClsSesionObjeto();	

	$InsCotizacionVehiculo->CveId = $GET_Id;
	$InsCotizacionVehiculo->MtdObtenerCotizacionVehiculo();
	
//SesionObjeto-InsCotizacionVehiculoLlamada
//Parametro1 = CvlId
//Parametro2 = CvlNumero
//Parametro3 = CvlFecha
//Parametro4 = CvlValor
//Parametro5 = CvlObservacion
//Parametro6 = CvlEstado
//Parametro7 = CvlFechaCreacion
//Parametro8 = CvlFechaModificacion	
//Parametro8 = CvlFechaProgramada
		
	if(!empty($InsCotizacionVehiculo->CotizacionVehiculoLlamada)){
		foreach($InsCotizacionVehiculo->CotizacionVehiculoLlamada as $DatCotizacionVehiculoLlamada){					
	
			$_SESSION['InsCotizacionVehiculoLlamada'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatCotizacionVehiculoLlamada->CvlId,
			NULL,
			($DatCotizacionVehiculoLlamada->CvlFecha),	
			NULL,
			$DatCotizacionVehiculoLlamada->CvlObservacion,
			$DatCotizacionVehiculoLlamada->CvlEstado,
			($DatCotizacionVehiculoLlamada->CvlTiempoCreacion),
			($DatCotizacionVehiculoLlamada->CvlTiempoModificacion),
			($DatCotizacionVehiculoLlamada->CvlFechaProgramada)
			);

		}
	}
	
	
	

}

?>

