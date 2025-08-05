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
	$InsAlmacen->AlmTiempoCreacion = date("Y-m-d H:i:s");
	$InsAlmacen->AlmTiempoModificacion = date("Y-m-d H:i:s");
		
	if($InsAlmacen->MtdRegistrarAlmacen()){	


		if(!empty($GET_dia)){
?>
			<script type="text/javascript">
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.$('#CmpAlmacenId').val("<?php echo $InsAlmacen->AlmId;?>");
			self.parent.FncAlmacenesCargar();
			</script>
<?php
		}
		
		
		$Registro = true;
		FncNuevo();
		$Resultado.='#SAS_ALM_101';
	} else{
		$Resultado.='#ERR_ALM_101';
	}

}else{
	FncNuevo();
}


function FncNuevo(){
	
	global $Identificador;
	global $InsAlmacen;
	
	unset($_SESSION['SesAlmFoto'.$Identificador]);
	
	$InsAlmacen = new ClsAlmacen();
	$InsAlmacen->SucId = $_SESSION['SesionSucursal'];
}
?>