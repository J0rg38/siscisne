<?php
//Si se hizo click en guardar			

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$error = false;
	
	$InsFichaIngreso->FinId = $_POST['CmpFichaIngresoId'];

	$InsFichaIngreso->VmaId = $_POST['CmpVehiculoIngresoMarcaId'];
	$InsFichaIngreso->VmoId = $_POST['CmpVehiculoIngresoModeloId'];
	$InsFichaIngreso->VveId = $_POST['CmpVehiculoIngresoVersionId'];

	$InsFichaIngreso->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsFichaIngreso->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsFichaIngreso->VveNombre = $_POST['CmpVehiculoIngresoVersion'];

	$InsFichaIngreso->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];
	$InsFichaIngreso->EinAnoFabricacion = $_POST['CmpVehiculoIngresoAnoFabricacion'];
	$InsFichaIngreso->EinColor = $_POST['CmpVehiculoIngresoColor'];

	//CmpMantenimientoKilometraje

	$InsFichaIngreso->FinMantenimientoKilometraje = (empty($_POST['CmpMantenimientoKilometraje'])?0:$_POST['CmpMantenimientoKilometraje']);	
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
					
	$validar = 0;
	if(!empty($ArrModalidadIngresos)){			
		foreach($ArrModalidadIngresos  as $DatModalidadIngreso){

			$InsFichaAccion = new ClsFichaAccion();
			$InsFichaAccion->UsuId = $_SESSION['SesionId'];
			$InsFichaAccion->FccId = $_POST['CmpId_'.$DatModalidadIngreso->MinSigla];
			$InsFichaAccion->FimId = $_POST['CmpFichaIngresoModalidadId_'.$DatModalidadIngreso->MinSigla];

			if(!empty($_POST['CmpModalidadIngresoId_'.$DatModalidadIngreso->MinSigla])){//MARCADO

				if(empty($_POST['CmpFichaIngresoModalidadId_'.$DatModalidadIngreso->MinSigla])){//NO TIENE ID

					$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
					$InsFichaIngresoModalidad->FinId = $InsFichaIngreso->FinId;
					$InsFichaIngresoModalidad->MinId = $DatModalidadIngreso->MinId;
					$InsFichaIngresoModalidad->FimEstado = 1;
					$InsFichaIngresoModalidad->FimObsequio = 0;
						
					$InsFichaIngresoModalidad->FimTiempoCreacion = date("Y-m-d H:i:s");
					$InsFichaIngresoModalidad->FimTiempoModificacion = date("Y-m-d H:i:s");

					if($InsFichaIngresoModalidad->MtdRegistrarFichaIngresoModalidad()){

						$InsFichaAccion->FimId = $InsFichaIngresoModalidad->FimId;
						$InsFichaAccion->FccFecha = date("Y-m-d");
						$InsFichaAccion->FccObservacion = date("d/m/Y H:i:s")." - [Agregado]Sub OT autogenerada de O.T.: ".$InsFichaIngreso->FinId;

						$InsFichaAccion->FccManoObra = 0;	
						$InsFichaAccion->FccDescuento = 0;	
						$InsFichaAccion->FccEstado = 1;	
						$InsFichaAccion->FccTiempoCreacion = date("Y-m-d H:i:s");
						$InsFichaAccion->FccTiempoModificacion = date("Y-m-d H:i:s");
						
						if($DatModalidadIngreso->MinId == "MIN-10001"){

							$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId) ;
							$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
										
							$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
							$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
							
							$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
							unset($ArrPlanMantenimientos);
							$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
										
							$InsFichaIngreso->PmaId = $InsPlanMantenimiento->PmaId;

							$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
							$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
								
							foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
						
								$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtNombre','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
								$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
								
									switch($InsPlanMantenimiento->VmaId){
										//case "VMA-10017"://CHEVROLET
										default://CHEVROLET	
											foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){
				
												foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
				
													$PlanMantenimientoDetalleAccion = '';

													if($InsFichaIngreso->FinMantenimientoKilometraje == $DatKilometro['km']){

														$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
														$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);

													}
			
						
													if(!empty( $PlanMantenimientoDetalleAccion)){

														$InsFichaAccionMantenimiento1 = new ClsFichaIngresoMantenimiento();
														$InsFichaAccionMantenimiento1->FaaId = NULL;
														$InsFichaAccionMantenimiento1->PmtId = $DatPlanMantenimientoTarea->PmtId;
														$InsFichaAccionMantenimiento1->FaaId = NULL;
														$InsFichaAccionMantenimiento1->FaaAccion = $PlanMantenimientoDetalleAccion;
														$InsFichaAccionMantenimiento1->FaaNivel = 2;
														$InsFichaAccionMantenimiento1->FaaVerificar1 = 2;
														$InsFichaAccionMantenimiento1->FaaVerificar2 = 1;
														$InsFichaAccionMantenimiento1->FaaEstado = 2;
														$InsFichaAccionMantenimiento1->FaaTiempoCreacion = date("Y-m-d H:i:s");
														$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");

														$InsFichaAccionMantenimiento1->InsMysql = NULL;

														$InsFichaAccion->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;	

													}

												}

											}

										break;
										
										case "VMA-10018"://ISUZU

											foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){

												foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){

													$PlanMantenimientoDetalleAccion = '';

													if($InsFichaIngreso->FinMantenimientoKilometraje == $DatKilometro['km']){

														$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
														$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	

													}
			
													if(!empty( $PlanMantenimientoDetalleAccion)){

														$InsFichaAccionMantenimiento1 = new ClsFichaIngresoMantenimiento();
														$InsFichaAccionMantenimiento1->PmtId = $DatPlanMantenimientoTarea->PmtId;
														$InsFichaAccionMantenimiento1->FaaId = NULL;
														$InsFichaAccionMantenimiento1->FaaAccion = $PlanMantenimientoDetalleAccion;
														$InsFichaAccionMantenimiento1->FaaNivel = 2;
														$InsFichaAccionMantenimiento1->FaaVerificar1 = 2;
														$InsFichaAccionMantenimiento1->FaaVerificar2 = 1;
														$InsFichaAccionMantenimiento1->FaaEstado = 2;
														$InsFichaAccionMantenimiento1->FaaTiempoCreacion = date("Y-m-d H:i:s");
														$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");
							
														$InsFichaAccionMantenimiento1->InsMysql = NULL;
							
														$InsFichaAccion->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;	
							
													}
																			
												}

											}
																
										break;
										
										case "":
											die("No se encontro la MARCA DEL VEHICULO");
										break;
										
									}
										
								
							
							}
							
						
						}
						
						
						if($InsFichaAccion->MtdRegistrarFichaAccion()){
							$validar++;
							$Resultado.='#SAS_FMI_101';
						}else{
							$Resultado.='#ERR_FMI_101';
						}
						
					}else{
						$Resultado.='#ERR_FMI_102';								
					}

				}else{
					$validar++;
				}

			}else{

				if(!empty($_POST['CmpFichaIngresoModalidadId_'.$DatModalidadIngreso->MinSigla])){//NO TIENE ID
					
					$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
					
					
					if(!$InsFichaAccion->MtdEliminarFichaAccion($InsFichaAccion->FccId)){
						$error = true;
						$Resultado.='#ERR_FMI_103';
					}
						
					if(!$error){
						
						if(!$InsFichaIngresoModalidad->MtdEliminarFichaIngresoModalidad($InsFichaAccion->FimId)){
							$error = true;
							$Resultado.='#ERR_FMI_104';
						}
						
					}
	
						if(!$error){
							$validar++;
							$Resultado.='#SAS_FMI_103';
						}//else{
//							$Resultado.='#ERR_FMI_103';
//						}
						
											
					//if($InsFichaIngresoModalidad->MtdEliminarFichaIngresoModalidad($InsFichaAccion->FimId)){
//
//						if($InsFichaAccion->MtdEliminarFichaAccion($InsFichaAccion->FccId)){
//							$validar++;
//							$Resultado.='#SAS_FMI_103';
//						}else{
//							$Resultado.='#ERR_FMI_103';
//						}
//						
//					}else{
//						$Resultado.='#ERR_FMI_104';
//					}
				
				}else{
					$validar++;	
				}
				
			}
				
			
		}
	}
		
			
			//deb(count($ArrModalidadIngresos)."  -  ".$validar);
			
		if(count($ArrModalidadIngresos) == $validar){
			
			$InsFichaIngreso->MtdEditarFichaIngresoMantenimientoKilometraje();
			
			if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
			}

			FncCargarDatos();
			$Edito = true;
		}

}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsFichaIngreso;
	global $Identificador;

	$InsFichaIngreso->FinId = $GET_id;
	$InsFichaIngreso->MtdObtenerFichaIngreso();			
	
}
?>