<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$InsVehiculoModelo->VmoId = $_POST['CmpId'];
	$InsVehiculoModelo->VmaId = $_POST['CmpMarca'];
	$InsVehiculoModelo->VtiId = $_POST['CmpTipo'];
	$InsVehiculoModelo->VmoNombre = $_POST['CmpNombre'];
	$InsVehiculoModelo->VmoNombreComercial = $_POST['CmpNombreComercial'];
	$InsVehiculoModelo->VmoVigenciaVenta = $_POST['CmpVigenciaVenta'];
	$InsVehiculoModelo->VmoEstado = 1;
	$InsVehiculoModelo->VmoTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoModelo->VmoTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculoModelo->VmoFotoCaracteristica = $_SESSION['SesVmoFotoCaracteristica'.$Identificador];
			
	if($InsVehiculoModelo->MtdRegistrarVehiculoModelo()){	
	
		if(!empty($GET_dia)){
?>
			<script type="text/javascript">
            self.parent.tb_remove('<?php echo $GET_mod;?>');
            self.parent.$('#CmpVehiculoModeloId').val("<?php echo $InsVehiculoModelo->VmoId;?>");
            self.parent.FncVehiculoModelosCargar();
            </script>
<?php
		}	
	
		$Registro = true;
		$Resultado.='#SAS_VMO_101';
		unset($InsVehiculoModelo);
	} else{
		$Resultado.='#ERR_VMO_101';
	}

}else{

	$InsVehiculoModelo->VmaId = $GET_VehiculoMarca ;
	$InsVehiculoModelo->VmoVigenciaVenta = 2;
	
}


?>