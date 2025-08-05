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
	$InsClienteNota->CnoTiempoModificacion = date("Y-m-d H:i:s");
	$InsClienteNota->CnoEliminado = 1;

	$InsClienteNota->CliNombre = $_POST['CmpClienteNombre'];
	$InsClienteNota->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsClienteNota->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsClienteNota->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsClienteNota->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	
		if($Guardar){
	
			if($InsClienteNota->MtdEditarClienteNota()){		

				if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
				}
			
				$Edito = true;			
				$Resultado.='#SAS_CNO_102';
				FncCargarDatos();
				
			}else{
				
				$InsClienteNota->CnoFecha = FncCambiaFechaANormal($InsClienteNota->CnoFecha);	
				$Resultado.='#ERR_CNO_102';		
			}
			
		}else{

			$InsClienteNota->CnoFecha = FncCambiaFechaANormal($InsClienteNota->CnoFecha);	

		}
			
			
}else{

	FncCargarDatos();

}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsClienteNota;

	global $TotalOriginal;
	
	$InsClienteNota->CnoId = $GET_id;
	$InsClienteNota->MtdObtenerClienteNota();		
	
}
?>