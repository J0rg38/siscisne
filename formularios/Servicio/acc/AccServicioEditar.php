<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsServicio->UsuId = $_SESSION['SesionId'];	
	
	$InsServicio->SerId = $_POST['CmpId'];
	$InsServicio->SerNombre = $_POST['CmpNombre'];
	$InsServicio->SerDescripcion = $_POST['CmpDescripcion'];
	$InsServicio->MonId = $_POST['CmpMonedaId'];
	$InsServicio->SerImporte = eregi_replace(",","",(empty($_POST['CmpImporte'])?0:$_POST['CmpImporte']));
	$InsServicio->SerEstado = $_POST['CmpEstado'];	
	$InsServicio->SerTiempoModificacion = date("Y-m-d H:i:s");

	$InsServicio->ServicioDetalle = array();
	
//SesionObjeto-ServicioDetalle
//Parametro1 = SdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = SdeCantidad
//Parametro5 = SdeImporte
//Parametro6 = SdeEstado
//Parametro7 = SdeTiempoCreacion
//Parametro8 = SdeTiempoModificacion
//Parametro10 = ProNombre
//Parametro11 = ProCodigoOriginal
//Parametro12 = ProCodigoAlternativo
//Parametro13 = RtiId
//Parametro14 = UmeNombre

	$ResServicioDetalle = $_SESSION['InsServicioDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
	$ArrServicioDetalles = $ResServicioDetalle['Datos'];

	if(!empty($ArrServicioDetalles)){
		$item = 1;
		foreach($ArrServicioDetalles as $DatSesionObjeto){
				
			$InsServicioDetalle1 = new ClsServicioDetalle();
			$InsServicioDetalle1->SdeId = $DatSesionObjeto->Parametro1;
			$InsServicioDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsServicioDetalle1->UmeId = $DatSesionObjeto->Parametro3;
			$InsServicioDetalle1->SdeCantidad = $DatSesionObjeto->Parametro4;
			$InsServicioDetalle1->SdeImporte = $DatSesionObjeto->Parametro5;
			$InsServicioDetalle1->SdeEstado = $DatSesionObjeto->Parametro6;			
			$InsServicioDetalle1->SdeTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsServicioDetalle1->SdeTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsServicioDetalle1->SdeEliminado = $DatSesionObjeto->Eliminado;
			$InsServicioDetalle1->InsMysql = NULL;
		
			$InsServicio->ServicioDetalle[] = $InsServicioDetalle1;	

			$item++;	
		}

	}
//
//		//		SesionObjeto-ServicioFoto
//		//		Parametro1 = VifId
//		//		Parametro2 =
//		//		Parametro3 = VifArchivo
//		//		Parametro4 = VifEstado
//		//		Parametro5 = VifTiempoCreacion
//		//		Parametro6 = VifTiempoModificacion
//
//			$RepSesionObjetos = $_SESSION['InsServicioFoto'.$Identificador]->MtdObtenerSesionObjetos(false);
//			$ArrSesionObjetos = $RepSesionObjetos['Datos'];
//
//				if(!empty($ArrSesionObjetos)){
//					foreach($ArrSesionObjetos as $DatSesionObjeto){
//
//						$InsServicioFoto1 = new ClsServicioFoto();
//						$InsServicioFoto1->VifId = $DatSesionObjeto->Parametro1;
//						$InsServicioFoto1->VifArchivo = $DatSesionObjeto->Parametro3;
//						$InsServicioFoto1->VifEstado = $DatSesionObjeto->Parametro4;
//						$InsServicioFoto1->VifTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro5);
//						$InsServicioFoto1->VifTiempoModificacion = date("Y-m-d H:i:s");
//						$InsServicioFoto1->VifEliminado = $DatSesionObjeto->Eliminado;
//						$InsServicioFoto1->InsMysql = NULL;
//						
//						$InsServicio->ServicioFoto[] = $InsServicioFoto1;	
//						
//					}
//				}
//				


	if($InsServicio->MtdEditarServicio()){	
	
		if(!empty($GET_dia)){
?>
			<script type="text/javascript">
            self.parent.tb_remove('<?php echo $GET_mod;?>');
            </script>
<?php
		}
			
		$Edito = true;
		$Resultado.='#SAS_SER_102';	
		FncCargarDatos();	
			
	}else{			
	
		$Resultado.='#ERR_SER_102';		
	}			

}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsServicio;
	global $Identificador;
	
	unset($_SESSION['InsServicioDetalle'.$Identificador]);
	unset($_SESSION['InsServicioFoto'.$Identificador]);
	
	$_SESSION['InsServicioDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsServicioFoto'.$Identificador] = new ClsSesionObjeto();
	
	$InsServicio->SerId = $GET_id;
	$InsServicio->MtdObtenerServicio(true);		

	
	if(!empty($InsServicio->ServicioDetalle)){
		foreach($InsServicio->ServicioDetalle as $DatServicioDetalle){

//SesionObjeto-ServicioDetalle
//Parametro1 = SdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = SdeCantidad
//Parametro5 = SdeImporte
//Parametro6 = SdeEstado
//Parametro7 = SdeTiempoCreacion
//Parametro8 = SdeTiempoModificacion
//Parametro9 = 
//Parametro10 = ProNombre
//Parametro11 = ProCodigoOriginal
//Parametro12 = ProCodigoAlternativo
//Parametro13 = RtiId
//Parametro14 = UmeNombre

			$_SESSION['InsServicioDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatServicioDetalle->SdeId,
			$DatServicioDetalle->ProId,
			$DatServicioDetalle->UmeId,
			$DatServicioDetalle->SdeCantidad,
			$DatServicioDetalle->SdeImporte,
			$DatServicioDetalle->SdeEstado,
			($DatServicioDetalle->SdeTiempoCreacion),
			($DatServicioDetalle->SdeTiempoModificacion),
			NULL,
			$DatServicioDetalle->ProNombre,
			$DatServicioDetalle->ProCodigoOriginal,
			$DatServicioDetalle->ProCodigoAlternativo,
			$DatServicioDetalle->RtiId,
			$DatServicioDetalle->UmeNombre
			);
		
		}
	}
	
	
	
//
//		//		SesionObjeto-ServicioFoto
//		//		Parametro1 = VifId
//		//		Parametro2 =
//		//		Parametro3 = VifArchivo
//		//		Parametro4 = VifEstado
//		//		Parametro5 = VifTiempoCreacion
//		//		Parametro6 = VifTiempoModificacion
//		
//
//
//				if(!empty($InsServicio->ServicioFoto)){
//					foreach($InsServicio->ServicioFoto as $DatServicioFoto){
//						
//						$_SESSION['InsServicioFoto'.$Identificador]->MtdAgregarSesionObjeto(1,
//						$DatServicioFoto->VifId,
//						NULL,
//						$DatServicioFoto->VifArchivo,
//						$DatServicioFoto->VifEstado,
//						($DatServicioFoto->VifTiempoCreacion),
//						($DatServicioFoto->VifTiempoModificacion)
//						);
//	
//					}
//				}	
	
	
}

?>