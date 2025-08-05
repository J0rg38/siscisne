<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsEncuesta->EncId = $_POST['CmpId'];
	
	$InsEncuesta->SucId = $_POST['CmpSucursal'];
	$InsEncuesta->CliId = $_POST['CmpClienteId'];
	
	$InsEncuesta->EncFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	$InsEncuesta->FinId = ($_POST['CmpFichaIngresoId']);
	$InsEncuesta->OvvId = ($_POST['CmpOrdenVentaVehiculoId']);
	$InsEncuesta->EncTipo = "POSTVENTA";
	$InsEncuesta->EncVerbatin = $_POST['CmpVerbatin'];
	$InsEncuesta->EncObservacion = addslashes($_POST['CmpObservacion']);
	$InsEncuesta->EncEstado = 3;
	$InsEncuesta->EncTiempoCreacion = date("Y-m-d H:i:s");
	$InsEncuesta->EncTiempoModificacion = date("Y-m-d H:i:s");
	$InsEncuesta->EncEliminado = 1;
		
	$InsEncuesta->CliNombre = ($_POST['CmpClienteNombre']);
	$InsEncuesta->EinVIN = ($_POST['CmpVehiculoIngresoVIN']);
	$InsEncuesta->EinPlaca = ($_POST['CmpVehiculoIngresoPlaca']);
	$InsEncuesta->VmaNombre = ($_POST['CmpVehiculoMarca']);
	$InsEncuesta->VmoNombre = ($_POST['CmpVehiculoModelo']);
	
		$InsEncuestaPreguntaSeccion = new ClsEncuestaPreguntaSeccion();
		$ResEncuestaPreguntaSeccion = $InsEncuestaPreguntaSeccion->MtdObtenerEncuestaPreguntaSecciones(NULL,NULL,NULL,'EpsId','ASC',NULL,3);
		$ArrEncuestaPreguntaSecciones = $ResEncuestaPreguntaSeccion['Datos'];
	
	if(!empty($ArrEncuestaPreguntaSecciones)){
		foreach($ArrEncuestaPreguntaSecciones as $DatEncuestaPreguntaSeccion){
	
	
				
		$InsEncuestaPregunta = new ClsEncuestaPregunta();
		//MtdObtenerEncuestaPreguntas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL,$oTipo=NULL,$oSeccion=NULL)
		$ResEncuestaPregunta = $InsEncuestaPregunta->MtdObtenerEncuestaPreguntas(NULL,NULL,NULL,'EprOrden','ASC',NULL,3,0,0,$DatEncuestaPreguntaSeccion->EpsId);
		$ArrEncuestaPreguntas = $ResEncuestaPregunta['Datos'];
		
			if(!empty($ArrEncuestaPreguntas)){
				foreach($ArrEncuestaPreguntas as $DatEncuestaPregunta){
					
					
					//$InsEncuestaPreguntaRespuesta = new ClsEncuestaPreguntaRespuesta();
					////  MtdObtenerEncuestaPreguntaRespuestas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EpeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuestaPregunta=NULL) 
					//$ResEncuestaPreguntaRespuesta = $InsEncuestaPreguntaRespuesta->MtdObtenerEncuestaPreguntaRespuestas(NULL,NULL,NULL,'EpeNombre','ASC',NULL,3,$DatEncuestaPregunta->EprId);
					//$ArrEncuestaPreguntaPreguntas = $ResEncuestaPreguntaRespuesta['Datos'];
					
					//if(!empty($ArrEncuestaPreguntaPreguntas)){
					//	foreach($ArrEncuestaPreguntaPreguntas as $DatEncuestaPreguntaRespuesta){
							
							//deb('CmpEncuestaDetalleRespuesta_'.$DatEncuestaPregunta->EprId);
							
							if(!empty($_POST['CmpEncuestaDetalleRespuesta_'.$DatEncuestaPregunta->EprId]) || $_POST['CmpEncuestaDetalleRespuesta_'.$DatEncuestaPregunta->EprId] == "0" ){
								
								$InsEncuestaDetalle1 = new ClsEncuestaDetalle();
								$InsEncuestaDetalle1->EdeId = $_POST['CmpEncuestaDetalleId_'.$DatEncuestaPregunta->EprId];
								$InsEncuestaDetalle1->EprId = $DatEncuestaPregunta->EprId;
								$InsEncuestaDetalle1->EdeRespuesta = $_POST['CmpEncuestaDetalleRespuesta_'.$DatEncuestaPregunta->EprId];
								//CmpEncuestaDetalleRespuesta_EPR-10000
								$InsEncuestaDetalle1->EdeEstado = 3;
								$InsEncuestaDetalle1->EdeTiempoCreacion = date("Y-m-d H:i:s");
								$InsEncuestaDetalle1->EdeTiempoModificacion = date("Y-m-d H:i:s");
								$InsEncuesta->EncuestaDetalle[] = $InsEncuestaDetalle1;
				
							}
							
							
							
						//}
					//}
	
	
					/*(!empty($_POST['CmpEncuestaDetalleRespuesta_'.$DatEncuestaPregunta->EprId])){
						
						$InsEncuestaDetalle1 = new ClsEncuestaDetalle();
						$InsEncuestaDetalle1->EdeId = "";
						$InsEncuestaDetalle1->EprId = $DatEncuestaPregunta->EprId;
						$InsEncuestaDetalle1->EprRespuesta = $_POST['CmpEncuestaDetalleRespuesta_'.$DatEncuestaPregunta->EprId];
						$InsEncuestaDetalle1->EdeEstado = 3;
						$InsEncuestaDetalle1->EdeTiempoCreacion = date("Y-m-d H:i:s");
						$InsEncuestaDetalle1->EdeTiempoModificacion = date("Y-m-d H:i:s");
		
						$InsEncuesta->EncuestaDetalle[] = $InsEncuestaDetalle1;
		
					}*/
		
				}
			}
	
		}
	}

	

	


	if($InsEncuesta->MtdRegistrarEncuesta()){
		
		if(!empty($GET_dia)){
		?>
			<script type="text/javascript">
			
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.$('#CmpEncuestaId').val("<?php echo $InsEncuesta->EncId;?>");
			self.parent.FncEncuestaBuscar("Id");
			
			</script>
		<?php
		}
				
		$Registro = true;
		//unset($InsEncuesta);
		
		//FncNuevo();
		$Resultado.='#SAS_ENC_101';
		
	} else{
		
		$InsEncuesta->EncFecha = FncCambiaFechaANormal($InsEncuesta->EncFecha);
		
		$Resultado.='#ERR_ENC_101';
	}

}else{
	
	FncNuevo();
	
}

function FncNuevo(){
	
	global $InsEncuesta;
	global $GET_FichaIngresoId;
	global $GET_OrdenVentaVehiculoId;
	global $GET_Tipo;

	$InsEncuesta->FinId = $GET_FichaIngresoId;	
	$InsEncuesta->OvvId = $GET_OrdenVentaVehiculoId;	
	$InsEncuesta->EncFecha = date("d/m/Y");	
	$InsEncuesta->EncTipo = "POSTVENTA";
	$InsEncuesta->SucId = $_SESSION['SesionSucursal'];
	
	$InsFichaIngreso = new ClsFichaIngreso();
	$InsFichaIngreso->FinId =  $GET_FichaIngresoId;	
	$InsFichaIngreso->MtdObtenerFichaIngreso(false);
	
	$InsEncuesta->CliNombre = $InsFichaIngreso->CliNombre;	
	$InsEncuesta->CliApellidoPaterno =  $InsFichaIngreso->CliApellidoPaterno;	
	$InsEncuesta->CliApellidoMaterno =  $InsFichaIngreso->CliApellidoMaterno;	
	
	$InsEncuesta->EinPlaca =  $InsFichaIngreso->EinPlaca;	
	$InsEncuesta->EinVIN =  $InsFichaIngreso->EinVIN;	
	$InsEncuesta->VmaNombre =  $InsFichaIngreso->VmaNombre;	
	$InsEncuesta->VmoNombre =  $InsFichaIngreso->VmoNombre;	
	
	
}
?>