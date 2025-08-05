<?php
//Si se hizo click en guardar			

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$error = false;
	$Guardar = true;
	
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

	$InsFichaIngreso->FinMantenimientoKilometraje = (empty($_POST['CmpMantenimientoKilometraje'])?0:$_POST['CmpMantenimientoKilometraje']);	
	$InsFichaIngreso->FinTiempoModificacion = date("Y-m-d H:i:s");
					
	$validar = 0;
	if(!empty($ArrModalidadIngresos)){			
		foreach($ArrModalidadIngresos  as $DatModalidadIngreso){

			if(!empty($_POST['CmpModalidadIngresoId_'.$DatModalidadIngreso->MinSigla])){//MARCADO
				
				if(empty($_POST['CmpFichaIngresoModalidadId_'.$DatModalidadIngreso->MinSigla])){
					
					$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
					$InsFichaIngresoModalidad->FinId = $InsFichaIngreso->FinId;
					$InsFichaIngresoModalidad->MinId = $DatModalidadIngreso->MinId;
					$InsFichaIngresoModalidad->FimEstado = 1;
					$InsFichaIngresoModalidad->FimObsequio = 0;
						
					$InsFichaIngresoModalidad->FimTiempoCreacion = date("Y-m-d H:i:s");
					$InsFichaIngresoModalidad->FimTiempoModificacion = date("Y-m-d H:i:s");
					
					$FichaIngresoModalidadId = $InsFichaIngresoModalidad->MtdVerificarExisteFichaIngresoModalidad("MinId",$DatModalidadIngreso->MinId,$InsFichaIngreso->FinId);
					
					if(empty($FichaIngresoModalidadId)){

						$InsFichaIngresoModalidad->FimIdCopiar = $_POST['CmpFichaIngresoModalidadCopiar_'.$DatModalidadIngreso->MinSigla];
						
						//deb($InsFichaIngresoModalidad->FimIdCopiar);
						if(!empty($InsFichaIngresoModalidad->FimIdCopiar)){
						
							//deb($InsFichaIngresoModalidad->FimIdCopiar);
							$InsFichaIngresoTarea = new ClsFichaIngresoTarea();	
							//MtdObtenerFichaIngresoTareas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oEstado=NULL)				
							$ResFichaIngresoTarea = $InsFichaIngresoTarea->MtdObtenerFichaIngresoTareas(NULL,NULL,'FitId','ASC',NULL,$InsFichaIngresoModalidad->FimIdCopiar,NULL);
							$ArrFichaIngresoTareas  = $ResFichaIngresoTarea['Datos'];
							
							//deb($ArrFichaIngresoTareas);
							
							$InsFichaIngresoProducto = new ClsFichaIngresoProducto();
							$ResFichaIngresoProducto = $InsFichaIngresoProducto->MtdObtenerFichaIngresoProductos(NULL,NULL,'FipId','ASC',NULL,$InsFichaIngresoModalidad->FimIdCopiar,NULL);
							$ArrFichaIngresoProductos = $ResFichaIngresoProducto['Datos'];
							
							$InsFichaIngresoSuministro = new ClsFichaIngresoSuministro();
							$ResFichaIngresoSuministro = $InsFichaIngresoSuministro->MtdObtenerFichaIngresoSuministros(NULL,NULL,'FisId','ASC',NULL,$InsFichaIngresoModalidad->FimIdCopiar,NULL);
							$ArrFichaIngresoSuministros = $InsFichaIngresoModalidad->FichaIngresoSuministro = $ResFichaIngresoSuministro['Datos'];
							
							$InsFichaIngresoMantenimiento = new ClsFichaIngresoMantenimiento();
							$ResFichaIngresoMantenimiento = $InsFichaIngresoMantenimiento->MtdObtenerFichaIngresoMantenimientos(NULL,NULL,'FiaId','ASC',NULL,$InsFichaIngresoModalidad->FimIdCopiar,NULL,NULL,false,NULL);
							$ArrFichaIngresoMantenimientos = $ResFichaIngresoMantenimiento['Datos'];
						
						
						
						
							if(!empty($ArrFichaIngresoTareas)){
								foreach($ArrFichaIngresoTareas as $DatFichaIngresoTarea){
									
									$InsFichaIngresoTarea = new ClsFichaIngresoTarea();
									$InsFichaIngresoTarea->FitDescripcion = $DatFichaIngresoTarea->FitDescripcion;
									$InsFichaIngresoTarea->FitAccion = $DatFichaIngresoTarea->FitAccion;
									$InsFichaIngresoTarea->FitEstado = $DatFichaIngresoTarea->FitEstado;
									$InsFichaIngresoTarea->FitTiempoCreacion = date("Y-m-d H:i:s");
									$InsFichaIngresoTarea->FitTiempoModificacion = date("Y-m-d H:i:s");
									$InsFichaIngresoTarea->FitEliminado = $DatFichaIngresoTarea->FitEliminado;				
									$InsFichaIngresoTarea->InsMysql = NULL;
						
									$InsFichaIngresoModalidad->FichaIngresoTarea[] = $InsFichaIngresoTarea;	
						
								}
							}
					
					
							if(!empty($ArrFichaIngresoProductos)){
								foreach($ArrFichaIngresoProductos as $DatFichaIngresoProducto){
									
									$InsFichaIngresoProducto = new ClsFichaIngresoProducto();
									$InsFichaIngresoProducto->ProId = $DatFichaIngresoProducto->ProId;
									$InsFichaIngresoProducto->FipEstado = $DatFichaIngresoProducto->FipEstado;
									$InsFichaIngresoProducto->FipTiempoCreacion = date("Y-m-d H:i:s");
									$InsFichaIngresoProducto->FipTiempoModificacion = date("Y-m-d H:i:s");
									$InsFichaIngresoProducto->FipEliminado = $DatFichaIngresoProducto->FipEliminado;				
									$InsFichaIngresoProducto->InsMysql = NULL;
						
									$InsFichaIngresoModalidad->FichaIngresoProducto[] = $InsFichaIngresoProducto;	
									
								}							
							}
							
							
							if(!empty($ArrFichaIngresoSuministros)){
								foreach($ArrFichaIngresoSuministros as $DatFichaIngresoSuministro){
	
									$InsFichaIngresoSuministro = new ClsFichaIngresoSuministro();
									$InsFichaIngresoSuministro->ProId = $DatFichaIngresoSuministro->ProId;
									$InsFichaIngresoSuministro->UmeId = $DatFichaIngresoSuministro->UmeId;
									$InsFichaIngresoSuministro->FisCantidad = $DatFichaIngresoSuministro->FisCantidad;
									
									$InsFichaIngresoSuministro->FisEstado = $DatFichaIngresoSuministro->FisEstado;
									$InsFichaIngresoSuministro->FisTiempoCreacion = date("Y-m-d H:i:s");
									$InsFichaIngresoSuministro->FisTiempoModificacion = date("Y-m-d H:i:s");
									
									$InsFichaIngresoSuministro->FisEliminado = $DatFichaIngresoSuministro->FisEliminado;				
									$InsFichaIngresoSuministro->InsMysql = NULL;
						
									$InsFichaIngresoModalidad->FichaIngresoSuministro[] = $InsFichaIngresoSuministro;	
						
								}
							}
							
					
					
				
				
							if(!empty($ArrFichaIngresoMantenimientos)){
								foreach($ArrFichaIngresoMantenimientos as $DatFichaIngresoMantenimiento){
									
									$InsFichaIngresoMantenimiento = new ClsFichaIngresoMantenimiento();
									$InsFichaIngresoMantenimiento->PmtId = $DatFichaIngresoMantenimiento->PmtId;
									$InsFichaIngresoMantenimiento->FiaAccion = $DatFichaIngresoMantenimiento->FiaAccion;
									$InsFichaIngresoMantenimiento->FiaNivel = $DatFichaIngresoMantenimiento->FiaNivel;
									$InsFichaIngresoMantenimiento->FiaVerificar1 = $DatFichaIngresoMantenimiento->FiaVerificar1;
									$InsFichaIngresoMantenimiento->FiaVerificar2 = $DatFichaIngresoMantenimiento->FiaVerificar2;
									$InsFichaIngresoMantenimiento->FiaEstado = $DatFichaIngresoMantenimiento->FiaEstado;
									$InsFichaIngresoMantenimiento->FiaTiempoCreacion = date("Y-m-d H:i:s");
									$InsFichaIngresoMantenimiento->FiaTiempoModificacion = date("Y-m-d H:i:s");
		
									$InsFichaIngresoMantenimiento->InsMysql = NULL;
		
									$InsFichaIngresoModalidad->FichaIngresoMantenimiento[] = $InsFichaIngresoMantenimiento;
								
									
								}
							}else{
								
								if($InsFichaIngresoModalidad->MinId == "MIN-10001"){
	
									$InsPlanMantenimiento = new ClsPlanMantenimiento();
									$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId) ;
									$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
									
									$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
									$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
						
									$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
									unset($ArrPlanMantenimientos);
									$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
									
									$InsFichaIngreso->PmaId = $InsPlanMantenimiento->PmaId;
									
									foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
									
										$PlanMantenimientoDetalleAccion = '';
										
										$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtNombre','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
										$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
			
											foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){
			
												switch($InsPlanMantenimiento->VmaId){
			
												//case "VMA-10017"://CHEVROLET
												default://CHEVROLET
												
													foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
					
														$PlanMantenimientoDetalleAccion = '';
					
														if($InsFichaIngreso->FinMantenimientoKilometraje==$DatKilometro['km']){
					
															$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
															$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
					
														}
														
														if(!empty( $PlanMantenimientoDetalleAccion)){
								
															$InsFichaIngresoMantenimiento1 = new ClsFichaIngresoMantenimiento();
															$InsFichaIngresoMantenimiento1->PmtId = $DatPlanMantenimientoTarea->PmtId;
															$InsFichaIngresoMantenimiento1->FiaId = NULL;
															$InsFichaIngresoMantenimiento1->FiaAccion = $PlanMantenimientoDetalleAccion;
															$InsFichaIngresoMantenimiento1->FiaNivel = 2;
															$InsFichaIngresoMantenimiento1->FiaVerificar1 = 2;
															$InsFichaIngresoMantenimiento1->FiaVerificar2 = 2;
															$InsFichaIngresoMantenimiento1->FiaEstado = 2;
															$InsFichaIngresoMantenimiento1->FiaTiempoCreacion = date("Y-m-d H:i:s");
															$InsFichaIngresoMantenimiento1->FiaTiempoModificacion = date("Y-m-d H:i:s");
								
															$InsFichaIngresoMantenimiento1->InsMysql = NULL;
								
															$InsFichaIngresoModalidad->FichaIngresoMantenimiento[] = $InsFichaIngresoMantenimiento1;	
								
															
					
														}
																				
													}
			
												break;
			
												case "VMA-10018"://ISUZU
			
													foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
					
														$PlanMantenimientoDetalleAccion = '';
					
														if($InsFichaIngreso->FinMantenimientoKilometraje==$DatKilometro['km']){
					
															$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
															$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
					
														}
														
														if(!empty( $PlanMantenimientoDetalleAccion)){
								
															$InsFichaIngresoMantenimiento1 = new ClsFichaIngresoMantenimiento();
															$InsFichaIngresoMantenimiento1->PmtId = $DatPlanMantenimientoTarea->PmtId;
															$InsFichaIngresoMantenimiento1->FiaId = NULL;
															$InsFichaIngresoMantenimiento1->FiaAccion = $PlanMantenimientoDetalleAccion;
															$InsFichaIngresoMantenimiento1->FiaNivel = 2;
															$InsFichaIngresoMantenimiento1->FiaVerificar1 = 2;
															$InsFichaIngresoMantenimiento1->FiaVerificar2 = 2;
															$InsFichaIngresoMantenimiento1->FiaEstado = 2;
															$InsFichaIngresoMantenimiento1->FiaTiempoCreacion = date("Y-m-d H:i:s");
															$InsFichaIngresoMantenimiento1->FiaTiempoModificacion = date("Y-m-d H:i:s");
								
															$InsFichaIngresoMantenimiento1->InsMysql = NULL;
								
															$InsFichaIngresoModalidad->FichaIngresoMantenimiento[] = $InsFichaIngresoMantenimiento1;	
								
															
					
														}
																				
													}
			
												break;
												
												case "":
													//die("No se encontro la MARCA DEL VEHICULO");
												break;
			
											}
											
										}
										
									}
								
								
								}
								
							}
					
						
						}else{
							
							if($InsFichaIngresoModalidad->MinId == "MIN-10001"){
	
								$InsPlanMantenimiento = new ClsPlanMantenimiento();
								$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId) ;
								$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
								
								$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
								$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];
						
									$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
									unset($ArrPlanMantenimientos);
									$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
									
									$InsFichaIngreso->PmaId = $InsPlanMantenimiento->PmaId;
									
									foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
									
										$PlanMantenimientoDetalleAccion = '';
										
										$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL,NULL,'PmtNombre','ASC',NULL,$DatPlanMantenimientoSeccion->PmsId);
										$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];
			
										foreach($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea){
			
											switch($InsPlanMantenimiento->VmaId){
			
												//case "VMA-10017"://CHEVROLET
												default://CHEVROLET
												
													foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
					
														$PlanMantenimientoDetalleAccion = '';
					
														if($InsFichaIngreso->FinMantenimientoKilometraje==$DatKilometro['km']){
					
															$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
															$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
					
														}
														
														if(!empty( $PlanMantenimientoDetalleAccion)){
								
															$InsFichaIngresoMantenimiento1 = new ClsFichaIngresoMantenimiento();
															$InsFichaIngresoMantenimiento1->PmtId = $DatPlanMantenimientoTarea->PmtId;
															$InsFichaIngresoMantenimiento1->FiaId = NULL;
															$InsFichaIngresoMantenimiento1->FiaAccion = $PlanMantenimientoDetalleAccion;
															$InsFichaIngresoMantenimiento1->FiaNivel = 2;
															$InsFichaIngresoMantenimiento1->FiaVerificar1 = 2;
															$InsFichaIngresoMantenimiento1->FiaVerificar2 = 2;
															$InsFichaIngresoMantenimiento1->FiaEstado = 2;
															$InsFichaIngresoMantenimiento1->FiaTiempoCreacion = date("Y-m-d H:i:s");
															$InsFichaIngresoMantenimiento1->FiaTiempoModificacion = date("Y-m-d H:i:s");
								
															$InsFichaIngresoMantenimiento1->InsMysql = NULL;
								
															$InsFichaIngresoModalidad->FichaIngresoMantenimiento[] = $InsFichaIngresoMantenimiento1;	
								
															
					
														}
																				
													}
			
			
			
												break;
			
												case "VMA-10018"://ISUZU
			
													foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
					
														$PlanMantenimientoDetalleAccion = '';
					
														if($InsFichaIngreso->FinMantenimientoKilometraje==$DatKilometro['km']){
					
															$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
															$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['eq'],$DatPlanMantenimientoSeccion->PmsId,$DatPlanMantenimientoTarea->PmtId);	
					
														}
														
														if(!empty( $PlanMantenimientoDetalleAccion)){
								
															$InsFichaIngresoMantenimiento1 = new ClsFichaIngresoMantenimiento();
															$InsFichaIngresoMantenimiento1->PmtId = $DatPlanMantenimientoTarea->PmtId;
															$InsFichaIngresoMantenimiento1->FiaId = NULL;
															$InsFichaIngresoMantenimiento1->FiaAccion = $PlanMantenimientoDetalleAccion;
															$InsFichaIngresoMantenimiento1->FiaNivel = 2;
															$InsFichaIngresoMantenimiento1->FiaVerificar1 = 2;
															$InsFichaIngresoMantenimiento1->FiaVerificar2 = 2;
															$InsFichaIngresoMantenimiento1->FiaEstado = 2;
															$InsFichaIngresoMantenimiento1->FiaTiempoCreacion = date("Y-m-d H:i:s");
															$InsFichaIngresoMantenimiento1->FiaTiempoModificacion = date("Y-m-d H:i:s");
								
															$InsFichaIngresoMantenimiento1->InsMysql = NULL;
								
															$InsFichaIngresoModalidad->FichaIngresoMantenimiento[] = $InsFichaIngresoMantenimiento1;	
								
															
					
														}
																				
													}
			
												break;
												
												case "":
													//die("No se encontro la MARCA DEL VEHICULO");
												break;
			
											}
											
										}
										
									}
								
								
							
							}
						
						}
						
						
	
						if($InsFichaIngresoModalidad->MtdRegistrarFichaIngresoModalidad()){

							if($DatModalidadIngreso->MinSigla == "GA"){							
								$InsFichaIngreso->MtdEditarFichaIngresoDato("FinFechaGarantia",date("Y-m-d"),$InsFichaIngreso->FinId);							
							}

							$validar++;
							$Resultado.='#SAS_FMI_101';						
						}else{
							$Resultado.='#ERR_FMI_101';								
						}
						
					}else{
						$Resultado.='#ERR_FMI_105';					
					}
					

				}else{
					$validar++;
				}

			}else{

				if(!empty($_POST['CmpFichaIngresoModalidadId_'.$DatModalidadIngreso->MinSigla])){//NO TIENE ID
					
					$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
					$InsFichaIngresoModalidad->FimId = $_POST['CmpFichaIngresoModalidadId_'.$DatModalidadIngreso->MinSigla];
					

					if(!$InsFichaIngresoModalidad->MtdEliminarFichaIngresoModalidad($InsFichaIngresoModalidad->FimId)){

						if($DatModalidadIngreso->MinSigla == "GA"){
							$InsFichaIngreso->MtdEditarFichaIngresoDato("FinFechaGarantia",NULL,$InsFichaIngreso->FinId);
						}
					
						$error = true;
						$Resultado.='#ERR_FMI_103';
					}else{
						$validar++;
						$Resultado.='#SAS_FMI_103';
					}

				
				}else{
					$validar++;	
				}
				
			}
				
			
		}
	}
		
		//deb(count($ArrModalidadIngresos)." - ".$validar);
			
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