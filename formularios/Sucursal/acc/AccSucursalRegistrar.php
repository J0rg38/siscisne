<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsSucursal->SucId = $_POST['CmpId'];
	$InsSucursal->SucNombre = $_POST['CmpNombre'];
	$InsSucursal->SucEtiqueta = $_POST['CmpEtiqueta'];
	$InsSucursal->SucSigla = $_POST['CmpSigla'];
	$InsSucursal->SucDireccion = $_POST['CmpDireccion'];
	
	$InsSucursal->SucDistrito = $_POST['CmpDistrito'];
	$InsSucursal->SucProvincia = $_POST['CmpProvincia'];
	$InsSucursal->SucDepartamento = $_POST['CmpDepartamento'];
	$InsSucursal->SucCodigoUbigeo = $_POST['CmpCodigoUbigeo'];
	
	$InsSucursal->SucEstado = $_POST['CmpEstado'];
	$InsSucursal->SucFoto = $_SESSION['SesSucFoto'.$Identificador];
	$InsSucursal->SucEstado = 1;
	$InsSucursal->SucTiempoCreacion = date("Y-m-d H:i:s");
	$InsSucursal->SucTiempoModificacion = date("Y-m-d H:i:s");
		
	if($InsSucursal->MtdRegistrarSucursal()){	


		if(!empty($GET_dia)){
?>
			<script type="text/javascript">
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.$('#CmpSucursalId').val("<?php echo $InsSucursal->SucId;?>");
			self.parent.FncSucursalesCargar();
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
	global $InsSucursal;
	
	unset($_SESSION['SesSucFoto'.$Identificador]);
	
	$InsSucursal = new ClsSucursal();
}
?>