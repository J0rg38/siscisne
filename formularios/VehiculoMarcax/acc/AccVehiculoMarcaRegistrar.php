<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsVehiculoMarca->VmaId = $_POST['CmpId'];
	$InsVehiculoMarca->VmaNombre = $_POST['CmpNombre'];
	$InsVehiculoMarca->VmaVigenciaVenta = $_POST['CmpVigenciaVenta'];
	$InsVehiculoMarca->VmaFoto = $_SESSION['SesVmaFoto'.$Identificador];
	$InsVehiculoMarca->VmaEstado = 1;
	$InsVehiculoMarca->VmaTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoMarca->VmaTiempoModificacion = date("Y-m-d H:i:s");
		
	if($InsVehiculoMarca->MtdRegistrarVehiculoMarca()){	


		if(!empty($GET_dia)){
?>
			<script type="text/javascript">
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.$('#CmpVehiculoMarcaId').val("<?php echo $InsVehiculoMarca->VmaId;?>");
			self.parent.FncVehiculoMarcasCargar();
			</script>
<?php
		}
		
		
		$Registro = true;
		FncNuevo();
		$Resultado.='#SAS_VMA_101';
	} else{
		$Resultado.='#ERR_VMA_101';
	}

}else{
	FncNuevo();
}


function FncNuevo(){
	
	global $Identificador;
	global $InsVehiculoMarca;
	
	unset($_SESSION['SesVmaFoto'.$Identificador]);
	
	$InsVehiculoMarca = new ClsVehiculoMarca();
}
?>