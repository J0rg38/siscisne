<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsVehiculoMarca->VmaId = $_POST['CmpId'];
	$InsVehiculoMarca->VmaNombre = $_POST['CmpNombre'];
	$InsVehiculoMarca->VmaVigenciaVenta = $_POST['CmpVigenciaVenta'];
	$InsVehiculoMarca->VmaFoto = $_SESSION['SesVmaFoto'.$Identificador];
	$InsVehiculoMarca->VmaEstado = 1;
	$InsVehiculoMarca->VmaTiempoModificacion = date("Y-m-d H:i:s");
		
	if($InsVehiculoMarca->MtdEditarVehiculoMarca()){				


		if(!empty($GET_dia)){
?>
			<script type="text/javascript">
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.$('#CmpVehiculoMarcaId').val("<?php echo $InsVehiculoMarca->VmaId;?>");
			self.parent.FncVehiculoMarcasCargar();
			</script>
<?php
		}

		$Edito = true;	
		FncCargarDatos();			
		$Resultado.='#SAS_VMA_102';
		
	}else{			
		$Resultado.='#ERR_VMA_102';		
	}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsVehiculoMarca;
	global $Identificador;
	
	unset($_SESSION['SesVmaFoto'.$Identificador]);
		
	$InsVehiculoMarca->VmaId = $GET_id;
	$InsVehiculoMarca->MtdObtenerVehiculoMarca();		
	$_SESSION['SesVmaFoto'.$Identificador] =	$InsVehiculoMarca->VmaFoto;
}

?>