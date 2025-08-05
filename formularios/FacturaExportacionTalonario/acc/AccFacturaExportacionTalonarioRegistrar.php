<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsFacturaExportacionTalonario->FetId = $_POST['CmpId'];
	$InsFacturaExportacionTalonario->FetNumero = $_POST['CmpNumero'];
	$InsFacturaExportacionTalonario->FetInicio = $_POST['CmpInicio'];
	$InsFacturaExportacionTalonario->FetTiempoCreacion = date("Y-m-d H:i:s");
	$InsFacturaExportacionTalonario->FetTiempoModificacion = date("Y-m-d H:i:s");
	$InsFacturaExportacionTalonario->FetEliminado = 1;
		
	if($InsFacturaExportacionTalonario->MtdRegistrarFacturaExportacionTalonario()){
		
		$Registro = true;
		
		if(!empty($GET_dia)){
		?>
<script type="text/javascript">

			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.$('#CmpFacturaExportacionId').val("<?php echo $InsFacturaExportacionTalonario->FetId;?>");
			self.parent.FncFacturaExportacionBuscar("Id");
	
</script>
<?php
		}

		unset($InsFacturaExportacionTalonario);
		$Resultado.='#SAS_FET_101';
	} else{
		$Resultado.='#ERR_FET_101';
	}

}else{

}
?>