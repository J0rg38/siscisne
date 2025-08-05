<?php

//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;	
	
	$InsFichaIngreso->UsuId = $_SESSION['SesionId'];
	
	$InsFichaIngreso->FinId = $_POST['CmpId'];
	
	$InsFichaIngreso->CliId = $_POST['CmpClienteId'];
	$InsFichaIngreso->FinFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);

	$InsFichaIngreso->FinEstado = $_POST['CmpEstado'];	
	$InsFichaIngreso->FinTiempoCreacion = date("Y-m-d H:i:s");
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
	$InsFichaIngreso->FinEliminado = 1;
	
	$InsFichaIngreso->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsFichaIngreso->CliNombreCompleto = $_POST['CmpClienteNombre'];
	$InsFichaIngreso->CliNombre = $_POST['CmpClienteNombre'];
	$InsFichaIngreso->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsFichaIngreso->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsFichaIngreso->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	

	$ResFichaIngresoLlamada = $_SESSION['InsFichaIngresoLlamada'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResFichaIngresoLlamada['Datos'])){
		foreach($ResFichaIngresoLlamada['Datos'] as $DatSesionObjeto){

			//SesionObjeto-InsFichaIngresoLlamada
			//Parametro1 = FllId
			//Parametro2 = 
			//Parametro3 = FllFecha
			//Parametro4 = 
			//Parametro5 = FllObservacion
			//Parametro6 = FllEstado
			//Parametro7 = FllTiempoCreacion
			//Parametro8 = FllTiempoModificacion
	
			$InsFichaIngresoLlamada1 = new ClsFichaIngresoLlamada();
			$InsFichaIngresoLlamada1->FllId = $DatSesionObjeto->Parametro1;
			$InsFichaIngresoLlamada1->FllFecha = FncCambiaFechaAMysql($DatSesionObjeto->Parametro3);
			$InsFichaIngresoLlamada1->FllObservacion = $DatSesionObjeto->Parametro5;
			$InsFichaIngresoLlamada1->FllEstado = $DatSesionObjeto->Parametro6;
			$InsFichaIngresoLlamada1->FllTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsFichaIngresoLlamada1->FllTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsFichaIngresoLlamada1->FllEliminado = $DatSesionObjeto->Eliminado;				
			$InsFichaIngresoLlamada1->InsMysql = NULL;
			
			$InsFichaIngreso->FichaIngresoLlamada[] = $InsFichaIngresoLlamada1;		
			
			if($InsFichaIngresoLlamada1->FllEliminado==1){					
				
			}

		}

	}
	
	if($Guardar){

		if($InsFichaIngreso->MtdSeguimientoClienteFichaIngreso()){
			
			if(!empty($GET_dia)){
			?>
				<script type="text/javascript">
               // self.parent.tb_remove('<?php echo $GET_mod;?>');
				
				self.parent.tb_remove('<?php echo $GET_mod;?>');
				//self.parent.$('#CmpEncuestaId').val("<?php echo $InsEncuesta->EncId;?>");
				self.parent.FncFichaIngresoSeguimientoCargar();
			
			
                </script>
			<?php
			}
				
			$Edito = true;
			$Resultado.='#SAS_FIN_112';
		}else{
			$Resultado.='#ERR_FIN_112';
		}

	}	
	
}else{

	FncCargarDatos();
	
}


function FncCargarDatos(){

	global $InsFichaIngreso;
	global $Identificador;
	
	global $GET_Id;

	unset($_SESSION['InsFichaIngresoLlamada'.$Identificador]);
			
	$_SESSION['InsFichaIngresoLlamada'.$Identificador] = new ClsSesionObjeto();	

	$InsFichaIngreso->FinId = $GET_Id;
	$InsFichaIngreso->MtdObtenerFichaIngreso();
	
	//SesionObjeto-InsFichaIngresoLlamada
	//Parametro1 = FllId
	//Parametro2 = 
	//Parametro3 = FllFecha
	//Parametro4 = 
	//Parametro5 = FllObseracion
	//Parametro6 = FllEstado
	//Parametro7 = FllTiempoCreacion
	//Parametro8 = FllTiempoModificacion
		
	//deb($InsFichaIngreso->FichaIngresoLlamada);
	
	if(!empty($InsFichaIngreso->FichaIngresoLlamada)){
		foreach($InsFichaIngreso->FichaIngresoLlamada as $DatFichaIngresoLlamada){					
	
			$_SESSION['InsFichaIngresoLlamada'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatFichaIngresoLlamada->FllId,
			NULL,
			($DatFichaIngresoLlamada->FllFecha),	
			NULL,
			$DatFichaIngresoLlamada->FllObservacion,
			$DatFichaIngresoLlamada->FllEstado,
			($DatFichaIngresoLlamada->FllTiempoCreacion),
			($DatFichaIngresoLlamada->FllTiempoModificacion)
			);

		}
	}
	
	
	

}

?>

