<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsFacturaExportacionTalonario->FetId = $_POST['CmpId'];
	$InsFacturaExportacionTalonario->FetNumero = $_POST['CmpNumero'];
	$InsFacturaExportacionTalonario->FetInicio = $_POST['CmpInicio'];	
	$InsFacturaExportacionTalonario->FetTiempoModificacion = date("Y-m-d H:i:s");
				
	if($InsFacturaExportacionTalonario->MtdEditarFacturaExportacionTalonario()){		
		
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
				
		$Resultado.='#SAS_FET_102';
		FncCargarDatos();
	}else{			
		$Resultado.='#ERR_FET_102';		
	}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	global $GET_id;
	global $InsFacturaExportacionTalonario;
	
	$InsFacturaExportacionTalonario->FetId = $GET_id;
	$InsFacturaExportacionTalonario = $InsFacturaExportacionTalonario->MtdObtenerFacturaExportacionTalonario();		
}
?>