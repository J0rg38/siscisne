<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsClienteNota->UsuId = $_SESSION['SesionId'];
	
	$InsClienteNota->CnoId = $_POST['CmpId'];
	$InsClienteNota->CliId = $_POST['CmpClienteId'];
	$InsClienteNota->PerId = $_POST['CmpPersonal'];	
	$InsClienteNota->CnoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);		
	$InsClienteNota->CnoDescripcion = addslashes($_POST['CmpDescripcion']);	
	$InsClienteNota->CnoEstado = $_POST['CmpEstado'];	
	$InsClienteNota->CnoTiempoCreacion = date("Y-m-d H:i:s");
	$InsClienteNota->CnoTiempoModificacion = date("Y-m-d H:i:s");
	$InsClienteNota->CnoEliminado = 1;
	
	$InsClienteNota->CliNombre = $_POST['CmpClienteNombre'];
	$InsClienteNota->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsClienteNota->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsClienteNota->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsClienteNota->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	
	if($Guardar){

		if($InsClienteNota->MtdRegistrarClienteNota()){
			
			if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
			}
			
			
			$Registro = true;
			FncNuevo();
			$Resultado.='#SAS_CNO_101';
			
		} else{
			$InsClienteNota->CnoFecha = FncCambiaFechaANormal($InsClienteNota->CnoFecha);	
			$Resultado.='#ERR_CNO_101';
		}
		
	}else{
		$InsClienteNota->CnoFecha = FncCambiaFechaANormal($InsClienteNota->CnoFecha);	
	}
	

}else{
	FncNuevo();
}

function FncNuevo(){
	
	global $InsClienteNota;
	global $InsCliente;
	global $GET_CliId;
	
	$InsClienteNota = new ClsClienteNota();
	$InsClienteNota->CnoEstado = 3;
	
	$InsCliente = new ClsCliente();
	$InsCliente->CliId = $GET_CliId;
	$InsCliente->MtdObtenerCliente();

	$InsClienteNota->CnoFecha = date("d/m/Y");
	$InsClienteNota->CliNombre = $InsCliente->CliNombre;
	$InsClienteNota->CliApellidoPaterno = $InsCliente->CliApellidoPaterno;
	$InsClienteNota->CliApellidoMaterno = $InsCliente->CliApellidoMaterno;
	$InsClienteNota->CliNumeroDocumento = $InsCliente->CliNumeroDocumento;
	$InsClienteNota->TdoId = $InsCliente->TdoId;
	$InsClienteNota->CliId = $InsCliente->CliId;
	$InsClienteNota->PerId = $_SESSION['SesionPersonal'];
	
	
}
?>