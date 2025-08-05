<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsPlanMantenimientoDetalle->PmdId = $_POST['CmpId'];
	$InsPlanMantenimientoDetalle->PmdAccion = $_POST['CmpAccion'];

	if($InsPlanMantenimientoDetalle->MtdEditarPlanMantenimientoDetalleDato($InsPlanMantenimientoDetalle->PmdId,"PmdAccion",$InsPlanMantenimientoDetalle->PmdAccion)){					

		if(!empty($GET_dia)){
?>
<script type="text/javascript">
	self.parent.tb_remove('<?php echo $GET_mod;?>');
	self.parent.FncPlanMantenimientoDetalleListar("<?php echo $InsPlanMantenimientoDetalle->PmdId;?>");
</script>
<?php
		}

		$Resultado.='#SAS_PMD_102';
		FncCargarDatos();
	}else{			
		$Resultado.='#ERR_PMD_102';		
	}			
			
}else{
	FncCargarDatos();
}


function FncCargarDatos(){

	global $GET_id;
	global $InsPlanMantenimientoDetalle;

	$InsPlanMantenimientoDetalle->PmdId = $GET_id;
	$InsPlanMantenimientoDetalle->MtdObtenerPlanMantenimientoDetalle();		

}
?>