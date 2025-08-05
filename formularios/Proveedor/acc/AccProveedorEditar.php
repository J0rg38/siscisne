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
	$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
				
			
		if($InsProveedor->MtdEditarProveedor()){					
		
			if(!empty($GET_dia)){
?>
	<script type="text/javascript">
	self.parent.tb_remove('<?php echo $GET_mod;?>','<?php echo $GET_Tipo;?>','<?php echo $GET_Ruta;?>');
	self.parent.FncProveedorBuscar("Id",'<?php echo $GET_Tipo;?>','<?php echo $GET_Ruta;?>');
	</script>
<?php
			}
				
			$Edito = true;
			FncCargarDatos();	
			$Resultado.='#SAS_PRV_102';		
		}else{			
			$InsProveedor->PrvFechaNacimiento = FncCambiaFechaANormal($InsProveedor->PrvFechaNacimiento,true);		
			$Resultado.='#ERR_PRV_102';		
		}			
			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	global $GET_id;
	global $InsProveedor;
	global $Identificador;

		
	$InsProveedor->PrvId = $GET_id;
	$InsProveedor = $InsProveedor->MtdObtenerProveedor();			
	
}
?>