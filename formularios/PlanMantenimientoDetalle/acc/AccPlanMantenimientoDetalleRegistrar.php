<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
//	$InsTareaProducto->TprId = $_POST['CmpId'];
//	$InsTareaProducto->ProId = $_POST['CmpProductoId'];
//	$InsTareaProducto->ProNombre = $_POST['CmpProductoNombre'];
//	$InsTareaProducto->UmeId = $_POST['CmpProductoUnidadMedidaConvertir'];
//	//$InsTareaProducto->TprCantidad = $_POST['CmpTareaProductoDetalleCantidad'];
//	$InsTareaProducto->TprCantidad = eregi_replace(",","",(empty($_POST['CmpTareaProductoDetalleCantidad'])?0:$_POST['CmpTareaProductoDetalleCantidad']));
//		
//	
//	$InsTareaProducto->PmdId = $_POST['CmpPlanMantenimientoDetalleId'];
//	$InsTareaProducto->PmaId = $_POST['CmpPlanMantenimientoId'];	
//	$InsTareaProducto->TprKilometraje = $_POST['CmpTareaProductoKilometraje'];
//	$InsTareaProducto->PmtId = $_POST['CmpPlanMantenimientoTareaId'];

	$InsPlanMantenimientoDetalle->PmdId = $_POST['CmpId'];
	$InsPlanMantenimientoDetalle->PmaId = $_POST['CmpPlanMantenimientoId'];
	$InsPlanMantenimientoDetalle->PmtId = $_POST['CmpPlanMantenimientoTareaId'];	
	$InsPlanMantenimientoDetalle->PmdAccion = $_POST['CmpPlanMantenimientoDetalleAccion'];
	$InsPlanMantenimientoDetalle->PmdKilometraje = $_POST['CmpPlanMantenimientoDetalleKilometraje'];
	
//	if($InsTareaProducto->MtdRegistrarTareaProducto()){
	if($InsPlanMantenimientoDetalle->MtdRegistrarPlanMantenimientoDetalle()){			
	//	
			if(!empty($GET_dia)){
?>
<script type="text/javascript">


	self.parent.tb_remove('<?php echo $GET_mod;?>');
	self.parent.FncPlanMantenimientoDetalleListar("<?php echo $InsPlanMantenimientoDetalle->PmdId;?>");
</script>

</script>
<?php
			}
			
		unset($InsTareaProducto);
		$Resultado.='#SAS_PMD_101';
		
	} else{
		$Resultado.='#ERR_PMD_101';
	}

}else{

	$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();
	$InsPlanMantenimientoTarea->PmtId = $GET_PlanMantenimientoTareaId;;
	$InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTarea();


	$InsPlanMantenimientoDetalle->PmaId = $GET_PlanMantenimientoId;
	$InsPlanMantenimientoDetalle->PmtId = $GET_PlanMantenimientoTareaId;
	$InsPlanMantenimientoDetalle->PmdKilometraje = $GET_PlanMantenimientoDetalleKilometraje;
	$InsPlanMantenimientoDetalle->PmtNombre = $InsPlanMantenimientoTarea->PmtNombre;	
	
	
}
?>