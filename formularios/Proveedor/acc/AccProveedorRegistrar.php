<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsProveedor->PrvId = $_POST['CmpId'];
	$InsProveedor->TdoId = $_POST['CmpTipoDocumento'];
	$InsProveedor->PrvTipoDocumentoOtro = $_POST['CmpTipoDocumentoOtro'];
	$InsProveedor->PrvNombre = $_POST['CmpNombre'];
	$InsProveedor->PrvApellidoPaterno = $_POST['CmpApellidoPaterno'];
	$InsProveedor->PrvApellidoMaterno = $_POST['CmpApellidoMaterno'];
	
	$InsProveedor->PrvFechaNacimiento = FncCambiaFechaAMysql($_POST['CmpFechaNacimiento'],true);
	
	$InsProveedor->PrvNumeroDocumento = $_POST['CmpNumeroDocumento'];

	$InsProveedor->PrvDireccion = $_POST['CmpDireccion'];
	$InsProveedor->PrvDistrito = $_POST['CmpDistrito'];
	$InsProveedor->PrvProvincia = $_POST['CmpProvincia'];
	$InsProveedor->PrvDepartamento = $_POST['CmpDepartamento'];
	$InsProveedor->PrvPais = $_POST['CmpPais'];
	
	$InsProveedor->PrvTelefono = $_POST['CmpTelefono'];
	$InsProveedor->PrvCelular = $_POST['CmpCelular'];
	$InsProveedor->PrvEmail = $_POST['CmpEmail'];
	
	$InsProveedor->PrvContactoNombre1 = $_POST['CmpContactoNombre1'];
	$InsProveedor->PrvContactoCelular1 = $_POST['CmpContactoCelular1'];
	$InsProveedor->PrvContactoEmail1 = $_POST['CmpContactoEmail1'];
	
	$InsProveedor->PrvContactoNombre2 = $_POST['CmpContactoNombre2'];
	$InsProveedor->PrvContactoCelular2 = $_POST['CmpContactoCelular2'];
	$InsProveedor->PrvContactoEmail2 = $_POST['CmpContactoEmail2'];
	
	$InsProveedor->PrvContactoNombre3 = $_POST['CmpContactoNombre3'];
	$InsProveedor->PrvContactoCelular3 = $_POST['CmpContactoCelular3'];
	$InsProveedor->PrvContactoEmail3 = $_POST['CmpContactoEmail3'];

	$InsProveedor->MonId = $_POST['CmpMonedaId'];
	$InsProveedor->PrvTipoCambioFecha = FncCambiaFechaAMysql($_POST['CmpTipoCambioFecha'],true);
	$InsProveedor->PrvTipoCambio = $_POST['CmpTipoCambio'];
	$InsProveedor->PrvLineaCredito = eregi_replace(",","",(empty($_POST['CmpLineaCredito'])?0:$_POST['CmpLineaCredito']));
	$InsProveedor->PrvLineaCreditoActual = eregi_replace(",","",(empty($_POST['CmpLineaCreditoActual'])?0:$_POST['CmpLineaCreditoActual']));
	
	$InsProveedor->PrvEstado = $_POST['CmpEstado'];
	$InsProveedor->PrvTiempoCreacion = date("Y-m-d H:i:s");
	$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
	$InsProveedor->PrvEliminado = 1;
	
	if($InsProveedor->MtdRegistrarProveedor()){

		if(!empty($GET_dia)){
?>
<script type="text/javascript">
	
	self.parent.$('#Cmp<?php echo $GET_Tipo;?>ProveedorId<?php echo $GET_Ruta;?>').val("<?php echo $InsProveedor->PrvId;?>",'<?php echo $GET_Tipo;?>','<?php echo $GET_Ruta;?>');
	self.parent.FncProveedorBuscar("Id",'<?php echo $GET_Tipo;?>','<?php echo $GET_Ruta;?>');
	
	self.parent.tb_remove('<?php echo $GET_mod;?>','<?php echo $GET_Tipo;?>','<?php echo $GET_Ruta;?>');
</script>
<?php
		}
			
		$Registro = true;
		unset($InsProveedor);			
		$Resultado.='#SAS_PRV_101';
	} else{
		$InsProveedor->PrvFechaNacimiento = FncCambiaFechaANormal($InsProveedor->PrvFechaNacimiento,true);
		$Resultado.='#ERR_PRV_101';
	}

}else{
	$InsProveedor->PrvNombre = $GET_ProveedorNombre;
	$InsProveedor->TdoId = empty($GET_TipoDocumentoId)?"TDO-10003":$GET_TipoDocumentoId;
	$InsProveedor->PrvNumeroDocumento = $GET_ProveedorNumeroDocumento;
}
?>