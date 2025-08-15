<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	
		
		if($_POST['CmpCopiar']=="1"){
			
			$InsPlanMantenimiento = new ClsPlanMantenimiento();
			$InsPlanMantenimiento->PmaId = $_POST['CmpPlanMantenimientoId'];
			$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
			
			//MtdObtenerTareaProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oTarea=NULL);
			$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','ASC',NULL,$_POST['CmpPlanMantenimientoId'],NULL,$_POST['CmpPlanMantenimientoTareaId']);
			$ArrTareaProductos = $ResTareaProducto['Datos'];
 				
				
				switch($_POST['CmpPlanMantenimientoId']){
			  
					//case "VMA-10017"://CHEVROLET
					default://CHEVROLET
						
						$contador = 0;
						if(!empty($InsPlanMantenimiento->PmaChevroletKilometrajes)){
							foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){				
								
								$TareaProductoRegistrar = true;
								$PlanMantenimientoDetalleAccion = "";
								
								if(!empty($ArrTareaProductos)){
									foreach($ArrTareaProductos as $DatTareaProducto){
											
										//deb($DatTareaProducto->TprKilometraje." - ".$DatKilometro['km']);	
											
										if($DatTareaProducto->TprKilometraje ==  $DatKilometro['km']){
											
											
											if(!empty($_POST['CmpProductoId'])){
												
												$InsTareaProducto = new ClsTareaProducto();						
												$InsTareaProducto->TprId = $DatTareaProducto->TprId;
												$InsTareaProducto->ProId = $_POST['CmpProductoId'];
												$InsTareaProducto->UmeId = $_POST['CmpProductoUnidadMedidaConvertir'];
												$InsTareaProducto->TprCantidad = preg_replace("/,/", "", (empty($_POST['CmpTareaProductoCantidad'])?0:$_POST['CmpTareaProductoCantidad']));
												$InsTareaProducto->TprKilometraje = $DatTareaProducto->TprKilometraje;
												
												$InsTareaProducto->PmtId =$DatTareaProducto->PmtId;
												$InsTareaProducto->PmaId = $DatTareaProducto->PmaId;
												$InsTareaProducto->MtdEditarTareaProducto();
												
											}else{
												
												$InsTareaProducto->MtdEliminarTareaProducto($DatTareaProducto->TprId);
												
											}
											
											
											
											$TareaProductoRegistrar = false;
											break;
										}
											
									}
								}
								
								//deb($TareaProductoRegistrar);
								
								if($TareaProductoRegistrar){
																	//MtObtenerPlanMantenimientoDetalleAccion($oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL) 
								$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
								$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($_POST['CmpPlanMantenimientoId'],$DatKilometro['km'],NULL,$_POST['CmpPlanMantenimientoTareaId']);	
								
									if($PlanMantenimientoDetalleAccion == "R" or
									$PlanMantenimientoDetalleAccion == "C" or
									$PlanMantenimientoDetalleAccion == "U"){
										
										if(!empty($_POST['CmpProductoId'])){
												
											$InsTareaProducto = new ClsTareaProducto();	
											$InsTareaProducto->TprId = $DatTareaProducto->TprId;
											$InsTareaProducto->ProId = $_POST['CmpProductoId'];
											$InsTareaProducto->UmeId = $_POST['CmpProductoUnidadMedidaConvertir'];
											$InsTareaProducto->TprCantidad = preg_replace("/,/", "", (empty($_POST['CmpTareaProductoCantidad'])?0:$_POST['CmpTareaProductoCantidad']));
											
											$InsTareaProducto->TprKilometraje = $DatKilometro['km'];
											$InsTareaProducto->PmtId = $_POST['CmpPlanMantenimientoTareaId'];
											$InsTareaProducto->PmaId = $_POST['CmpPlanMantenimientoId'];
											$InsTareaProducto->MtdRegistrarTareaProducto();
										
										}
										
									
									}
									
								}
								
								
								
							}				
						}
						
					break;
				  
					case "VMA-10018"://ISUZU
						
						$contador = 0;
						if(!empty($InsPlanMantenimiento->PmaIsuzuKilometrajes)){
							foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){				
								
								$TareaProductoRegistrar = true;
								$PlanMantenimientoDetalleAccion = "";
								
								if(!empty($ArrTareaProductos)){
									foreach($ArrTareaProductos as $DatTareaProducto){
											
										if($DatTareaProducto->TprKilometraje ==  $DatKilometro['km']){
																
																
											if(!empty($_POST['CmpProductoId'])){		
															
												$InsTareaProducto = new ClsTareaProducto();						
												$InsTareaProducto->TprId = $DatTareaProducto->TprId;
												$InsTareaProducto->ProId = $_POST['CmpProductoId'];
												$InsTareaProducto->UmeId = $_POST['CmpProductoUnidadMedidaConvertir'];
												$InsTareaProducto->TprCantidad = preg_replace("/,/", "", (empty($_POST['CmpTareaProductoCantidad'])?0:$_POST['CmpTareaProductoCantidad']));
												$InsTareaProducto->TprKilometraje = $DatTareaProducto->TprKilometraje;
												
												$InsTareaProducto->PmtId =$DatTareaProducto->PmtId;
												$InsTareaProducto->PmaId = $DatTareaProducto->PmaId;
												$InsTareaProducto->MtdEditarTareaProducto();
											
											}else{
												
												$InsTareaProducto->MtdEliminarTareaProducto($DatTareaProducto->TprId);
												
											}
											
											$TareaProductoRegistrar = false;
											
										}
											
									}
								}
								
								if($TareaProductoRegistrar){
																	//MtObtenerPlanMantenimientoDetalleAccion($oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL) 
							
								$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
								$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($_POST['CmpPlanMantenimientoId'],$DatKilometro['km'],NULL,$_POST['CmpPlanMantenimientoTareaId']);	
								
									if($PlanMantenimientoDetalleAccion == "R" or
									$PlanMantenimientoDetalleAccion == "C" or
									$PlanMantenimientoDetalleAccion == "U"){
										
										if(!empty($_POST['CmpProductoId'])){
											
											$InsTareaProducto = new ClsTareaProducto();	
											$InsTareaProducto->TprId = $DatTareaProducto->TprId;
											$InsTareaProducto->ProId = $_POST['CmpProductoId'];
											$InsTareaProducto->UmeId = $_POST['CmpProductoUnidadMedidaConvertir'];
											$InsTareaProducto->TprCantidad = preg_replace("/,/", "", (empty($_POST['CmpTareaProductoCantidad'])?0:$_POST['CmpTareaProductoCantidad']));
											$InsTareaProducto->TprKilometraje = $DatKilometro['km'];
											
											$InsTareaProducto->PmtId = $_POST['CmpPlanMantenimientoTareaId'];
											$InsTareaProducto->PmaId = $_POST['CmpPlanMantenimientoId'];
											$InsTareaProducto->MtdRegistrarTareaProducto();
										
										}
										
									}
									
								}
								
								
								
							}				
						}
						
						
					break;
					
				}
 


				if($Guardar){				
			
					if(!empty($GET_dia)){
			?>
						<script type="text/javascript">
						 self.parent.tb_remove('<?php echo $GET_mod;?>');
						//FncTareaProductoListar(oTareaProductoId,oPlanMantenimientoId,oPlanMantenimientoTareaId,oPlanMantenimientoDetalleId,oPlanMantenimientoDetalleKilometraje,oPlanMantenimientoDetalleAccion){
								//self.parent.FncTareaProductoListar("<?php echo $InsTareaProducto->TprId;?>","<?php echo $InsTareaProducto->PmaId;?>","<?php echo $InsTareaProducto->PmtId;?>","<?php echo $InsTareaProducto->PmdId;?>","<?php echo $InsTareaProducto->TprKilometraje;?>","<?php echo $InsTareaProducto->PmdAccion;?>");
						
						</script>
			<?php
					}
			
					$Resultado.='#SAS_TPR_102';
					
				}else{			
					$Resultado.='#ERR_TPR_102';		
				}	
				
		}else{
			
			$InsTareaProducto->TprId = $_POST['CmpId'];
			
			$InsTareaProducto->ProId = $_POST['CmpProductoId'];
			$InsTareaProducto->ProNombre = $_POST['CmpProductoNombre'];
			$InsTareaProducto->UmeId = $_POST['CmpProductoUnidadMedidaConvertir'];
			
			$InsTareaProducto->TprCantidad = preg_replace("/,/", "", (empty($_POST['CmpTareaProductoCantidad'])?0:$_POST['CmpTareaProductoCantidad']));
			$InsTareaProducto->TprKilometraje = $_POST['CmpTareaProductoKilometraje'];
			
			$InsTareaProducto->PmtId = $_POST['CmpPlanMantenimientoTareaId'];
			$InsTareaProducto->PmaId = $_POST['CmpPlanMantenimientoId'];
			$InsTareaProducto->PmtNombre = $_POST['CmpPlanMantenimientoTareaNombre'];	
			$InsTareaProducto->PmdId = $_POST['CmpPlanMantenimientoDetalleId'];		
			$InsTareaProducto->PmdAccion = $_POST['CmpPlanMantenimientoDetalleAccion'];		
			
			if(empty($InsTareaProducto->ProId)){
				$Guardar = false;
				$Resultado.='#ERR_TPR_201';
			}
			
			if($Guardar){
		
				//if($_POST['CmpCopiar']=="1"){
				if(empty($_POST['CmpProductoId'])){
					unset($InsTareaProducto);
						$Resultado.='#SAS_TPR_101';
				}else{
					
					if($InsTareaProducto->MtdRegistrarTareaProducto()){
					
						if(!empty($GET_dia)){
		?>
							<script type="text/javascript">
							
								//self.parent.tb_remove('<?php echo $GET_mod;?>');
		//FncTareaProductoListar(oTareaProductoId,oPlanMantenimientoId,oPlanMantenimientoTareaId,oPlanMantenimientoDetalleId,oPlanMantenimientoDetalleKilometraje,oPlanMantenimientoDetalleAccion
						
								self.parent.FncTareaProductoListar("<?php echo $InsTareaProducto->TprId;?>","<?php echo $InsTareaProducto->PmaId;?>","<?php echo $InsTareaProducto->PmtId;?>","<?php echo $InsTareaProducto->PmdId;?>","<?php echo $InsTareaProducto->TprKilometraje;?>","<?php echo $InsTareaProducto->PmdAccion;?>","<?php echo $_POST['CmpCopiar'];?>");
							</script>
				
		<?php
							}
							
						unset($InsTareaProducto);
						$Resultado.='#SAS_TPR_101';
						
					} else{
						$Resultado.='#ERR_TPR_101';
					}
					
				
				}
				
			
			
			}
			
		}
		
		
	
	
}else{
	
	$InsPlanMantenimiento = new ClsPlanMantenimiento();
	$InsPlanMantenimiento->PmaId = $GET_PlanMantenimientoId;
	$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
	
	$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();
	$InsPlanMantenimientoTarea->PmtId = $GET_PlanMantenimientoTareaId;
	$InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTarea();
	
	$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
	$InsPlanMantenimientoDetalle->PmdId = $GET_PlanMantenimientoDetalleId;
	$InsPlanMantenimientoDetalle->MtdObtenerPlanMantenimientoDetalle();
	
	$InsTareaProducto->PmdId = $GET_PlanMantenimientoDetalleId;
	$InsTareaProducto->PmtId = $GET_PlanMantenimientoTareaId;
	$InsTareaProducto->PmaId = $GET_PlanMantenimientoId;
	$InsTareaProducto->PmtNombre = $InsPlanMantenimientoTarea->PmtNombre;
	$InsTareaProducto->TprKilometraje = $GET_PlanMantenimientoDetalleKilometraje;
	$InsTareaProducto->PmdAccion = $InsPlanMantenimientoDetalle->PmdAccion;
	
	$InsTareaProducto->VmaId = $InsPlanMantenimiento->VmaId;
	
}
?>