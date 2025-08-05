<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsVehiculoVersion->VveId = $_POST['CmpId'];	
	$InsVehiculoVersion->VmaId = $_POST['CmpVehiculoMarca'];
	$InsVehiculoVersion->VmoId = $_POST['CmpVehiculoModelo'];
	$InsVehiculoVersion->VveNombre = $_POST['CmpNombre'];
	$InsVehiculoVersion->VveVigenciaVenta = $_POST['CmpVigenciaVenta'];
	$InsVehiculoVersion->VveFoto = $_SESSION['SesVveFoto'.$Identificador];
	$InsVehiculoVersion->VveArchivo = $_SESSION['SesVveArchivo'.$Identificador];

	$InsVehiculoVersion->VveFotoLateral = $_SESSION['SesVveFotoLateral'.$Identificador];
	$InsVehiculoVersion->VveFotoPosterior = $_SESSION['SesVveFotoPosterior'.$Identificador];
	$InsVehiculoVersion->VveFotoCaracteristica = $_SESSION['SesVveFotoCaracteristica'.$Identificador];
	
	$InsVehiculoVersion->VveEstado = 1;
	$InsVehiculoVersion->VveTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoVersion->VveTiempoModificacion = date("Y-m-d H:i:s");
	
	////$InsVehiculoVersion->VehiculoVersionCaracteristica = array();
//	$ArrVehiculoVersionCaracteristicas = $InsVehiculoVersion->VehiculoVersionCaracteristica;
//	unset($InsVehiculoVersion->VehiculoVersionCaracteristica);
//
//	if(!empty($ArrVehiculoVersionCaracteristicas)){	
//		foreach($ArrVehiculoVersionCaracteristicas as $DatVehiculoVersionCaracteristica ){
//
//
//			for($ano=2013;$ano<=date("Y");$ano++){
//	
//			$InsVehiculoVersionCaracteristica1 = new ClsVehiculoVersionCaracteristica();
//			$InsVehiculoVersionCaracteristica1->VvcId = $DatVehiculoVersionCaracteristica->VvcId;
//			$InsVehiculoVersionCaracteristica1->VcsId = ($_POST['CmpVehiculoVersionCaracteristicaSeccionId_'.$DatVehiculoVersionCaracteristica->VvcId]);
//			$InsVehiculoVersionCaracteristica1->VvcDescripcion = addslashes($_POST['CmpVehiculoVersionCaracteristicaDescripcion_'.$DatVehiculoVersionCaracteristica->VvcId]);
//			$InsVehiculoVersionCaracteristica1->VvcValor = addslashes($_POST['CmpVehiculoVersionCaracteristicaValor_'.$DatVehiculoVersionCaracteristica->VvcId]);
//			$InsVehiculoVersionCaracteristica1->VvcAnoModelo = addslashes($_POST['CmpVehiculoVersionCaracteristicaAnoModelo_'.$DatVehiculoVersionCaracteristica->VvcId]);
//			$InsVehiculoVersionCaracteristica1->VvcTiempoCreacion = date("Y-m-d H:i:s");
//			$InsVehiculoVersionCaracteristica1->VvcTiempoModificacion = date("Y-m-d H:i:s");
//			$InsVehiculoVersionCaracteristica1->VvcEliminado = 1;
//			$InsVehiculoVersionCaracteristica1->InsMysql = NULL;
//			
//	
//			}
//			
//
//			$InsVehiculoVersion->VehiculoVersionCaracteristica[] = $InsVehiculoVersionCaracteristica1;	
//		
//		}
//	}
	

//	SesionObjeto-VehiculoVersionCaracteristica
//	Parametro1 = VvcId
//	Parametro2 = VveId
//	Parametro3 = VcsId

//	Parametro4 = VvcDescripcion
//	Parametro5 = VvcValor
//	Parametro6 = VvcAnoModelo
//	Parametro7 = VvcTiempoCreacion
//	Parametro8 = VvcTiempoModificacion
//	Parametro9 = VcsNombre

	$ResVehiculoVersionCaracteristica = $_SESSION['InsVehiculoVersionCaracteristica'.$Identificador]->MtdObtenerSesionObjetos(true);//OJO

	if(!empty($ResVehiculoVersionCaracteristica['Datos'])){	
		foreach($ResVehiculoVersionCaracteristica['Datos'] as $DatSesionObjeto){
			
			$InsVehiculoVersionCaracteristica1 = new ClsVehiculoVersionCaracteristica();
			$InsVehiculoVersionCaracteristica1->VvcId = $DatSesionObjeto->Parametro1;	
			$InsVehiculoVersionCaracteristica1->VveId = $DatSesionObjeto->Parametro2;
			$InsVehiculoVersionCaracteristica1->VcsId = $DatSesionObjeto->Parametro3;
			
			$InsVehiculoVersionCaracteristica1->VvcDescripcion = addslashes($DatSesionObjeto->Parametro4);
			$InsVehiculoVersionCaracteristica1->VvcValor = addslashes($DatSesionObjeto->Parametro5);
			$InsVehiculoVersionCaracteristica1->VvcAnoModelo = $DatSesionObjeto->Parametro6;
			
			$InsVehiculoVersionCaracteristica1->VvcTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsVehiculoVersionCaracteristica1->VvcTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsVehiculoVersionCaracteristica1->VvcEliminado = $DatSesionObjeto->Eliminado;				
			$InsVehiculoVersionCaracteristica1->InsMysql = NULL;
			
			//$InsVehiculoVersion->VehiculoVersionCaracteristica[] = $InsVehiculoVersionCaracteristica1;	
			
			if($InsVehiculoVersionCaracteristica1->VvcEliminado==1){		
				
				$InsVehiculoVersion->VehiculoVersionCaracteristica[] = $InsVehiculoVersionCaracteristica1;	
				
			}
		}	

	}
	
	
	if($InsVehiculoVersion->MtdRegistrarVehiculoVersion()){	
	
		if(!empty($GET_dia)){
?>
			<script type="text/javascript">
            self.parent.tb_remove('<?php echo $GET_mod;?>');
            self.parent.$('#CmpVehiculoVersionId').val("<?php echo $InsVehiculoVersion->VveId;?>");
            self.parent.FncVehiculoVersionesCargar();
            </script>
<?php
		}	
	
		FncNuevo();
		$Registro = true;
		$Resultado.='#SAS_VVE_101';
		unset($InsVehiculoVersion);
	} else{
		$Resultado.='#ERR_VVE_101';
	}

}else{

	FncNuevo();
}

function FncNuevo(){

	global $GET_VehiculoMarca;
	global $GET_VehiculoVersion;
	
	global $Identificador;
	global $InsVehiculoVersion;

	unset($_SESSION['SesVveFoto'.$Identificador]);
	unset($_SESSION['SesVveArchivo'.$Identificador]);
	unset($_SESSION['SesVveFotoLateral'.$Identificador]);
	unset($_SESSION['SesVveFotoPosterior'.$Identificador]);
	unset($_SESSION['SesVveFotoCaracteristica'.$Identificador]);
	
	unset($_SESSION['InsVehiculoVersionCaracteristica'.$Identificador]);	
	
	$_SESSION['InsVehiculoVersionCaracteristica'.$Identificador] = new ClsSesionObjeto();
	
	$InsVehiculoVersion->VmaId = $GET_VehiculoMarca;
	$InsVehiculoVersion->VmoId = $GET_VehiculoVersion;
	$InsVehiculoVersion->VveVigenciaVenta = 2;

}
?>