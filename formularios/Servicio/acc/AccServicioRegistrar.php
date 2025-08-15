<?php
//Si se hizo click en guardar		
//deb($_POST[);	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	
	$Resultado = '';
	
	$InsServicio->UsuId = $_SESSION['SesionId'];	
	$InsServicio->SerId = $_POST['CmpId'];
	$InsServicio->SerNombre = $_POST['CmpNombre'];
	$InsServicio->SerDescripcion = $_POST['CmpDescripcion'];
	$InsServicio->MonId = $_POST['CmpMonedaId'];
	$InsServicio->SerImporte = preg_replace("/,/", "", (empty($_POST['CmpImporte'])?0:$_POST['CmpImporte']));

	$InsServicio->SerEstado = $_POST['CmpEstado'];	
	$InsServicio->SerTiempoCreacion = date("Y-m-d H:i:s");
	$InsServicio->SerTiempoModificacion = date("Y-m-d H:i:s");
	$InsServicio->SerEliminado = 1;
	
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

	$ResServicioDetalle = $_SESSION['InsServicioDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrServicioDetalles = $ResServicioDetalle['Datos'];

	if(!empty($ArrServicioDetalles)){
		$item = 1;
		foreach($ArrServicioDetalles as $DatSesionObjeto){
				
			$InsServicioDetalle1 = new ClsServicioDetalle();

			$InsServicioDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsServicioDetalle1->UmeId = $DatSesionObjeto->Parametro3;
			$InsServicioDetalle1->SdeCantidad = $DatSesionObjeto->Parametro4;
			$InsServicioDetalle1->SdeImporte = $DatSesionObjeto->Parametro5;

			$InsServicioDetalle1->SdeEstado = $DatSesionObjeto->Parametro6;							
			$InsServicioDetalle1->SdeTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsServicioDetalle1->SdeTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsServicioDetalle1->SdeEliminado = $DatSesionObjeto->Eliminado;
			$InsServicioDetalle1->InsMysql = NULL;

			if($InsServicioDetalle1->SdeEliminado==1){					
				$InsServicio->ServicioDetalle[] = $InsServicioDetalle1;	
			}

			$item++;	
		}

	}
	
	//
//	
//			//		SesionObjeto-ServicioFoto
//			//		Parametro1 = VifId
//			//		Parametro2 =
//			//		Parametro3 = VifArchivo
//			//		Parametro4 = VifEstado
//			//		Parametro5 = VifTiempoCreacion
//			//		Parametro6 = VifTiempoModificacion
//
//	
//				$RepSesionObjetos = $_SESSION['InsServicioFoto'.$Identificador]->MtdObtenerSesionObjetos(true);
//				$ArrSesionObjetos = $RepSesionObjetos['Datos'];
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
				
	if($Guardar){

		if($InsServicio->MtdRegistrarServicio()){

			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
                    self.parent.tb_remove('<?php echo $GET_mod;?>');
                    self.parent.$('#CmpServicioId').val("<?php echo $InsServicio->SerId;?>");
					self.parent.FncServicioFormularioFuncion();
                </script>
<?php
			}
			$Registro = true;
			FncNuevo();
			
			$Resultado.='#SAS_SER_101';
		} else{
			$Resultado.='#ERR_SER_101';
		}


	}

}else{

	FncNuevo();

}

function FncNuevo(){
	
	global $Identificador;
	global $InsServicio;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsServicioFoto'.$Identificador]);
	unset($_SESSION['InsServicioDetalle'.$Identificador]);
	
	$_SESSION['InsServicioFoto'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsServicioDetalle'.$Identificador] = new ClsSesionObjeto();

	$InsServicio = new ClsServicio();
	$InsServicio->MonId = $EmpresaMonedaId;
}
?>