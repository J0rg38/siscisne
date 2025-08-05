<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsAlmacen->AlmId = $_POST['CmpId'];
	$InsAlmacen->SucId = $_POST['CmpSucursal'];
	$InsAlmacen->AlmNombre = $_POST['CmpNombre'];
	$InsAlmacen->AlmSigla = $_POST['CmpSigla'];
	$InsAlmacen->AlmDireccion = $_POST['CmpDireccion'];
	
	$InsAlmacen->AlmDistrito = $_POST['CmpDistrito'];
	$InsAlmacen->AlmProvincia = $_POST['CmpProvincia'];
	$InsAlmacen->AlmDepartamento = $_POST['CmpDepartamento'];
	$InsAlmacen->AlmCodigoUbigeo = $_POST['CmpCodigoUbigeo'];
	
	$InsAlmacen->AlmEstado = $_POST['CmpEstado'];
	$InsAlmacen->AlmFoto = $_SESSION['SesAlmFoto'.$Identificador];
	$InsAlmacen->AlmEstado = 1;
	$InsAlmacen->AlmTiempoModificacion = date("Y-m-d H:i:s");
		
	if($InsAlmacen->MtdEditarAlmacen()){				


		if(!empty($GET_dia)){
?>
			<script type="text/javascript">
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.$('#CmpAlmacenId').val("<?php echo $InsAlmacen->AlmId;?>");
			self.parent.FncAlmacenesCargar();
			</script>
<?php
		}

		$Edito = true;	
		FncCargarDatos();			
		$Resultado.='#SAS_ALM_102';
		
	}else{			
		$Resultado.='#ERR_ALM_102';		
	}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsAlmacen;
	global $Identificador;
	
	unset($_SESSION['SesAlmFoto'.$Identificador]);
		
	$InsAlmacen->AlmId = $GET_id;
	$InsAlmacen->MtdObtenerAlmacen();		
	$_SESSION['SesAlmFoto'.$Identificador] =	$InsAlmacen->AlmFoto;
}

?>