<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsMensajeTexto->UsuId = $_SESSION['SesionId'];
	
	$InsMensajeTexto->MteId = $_POST['CmpId'];
	$InsMensajeTexto->MteFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);	
	
	$InsMensajeTexto->MteDestino = $_POST['CmpDestino'];			
	$InsMensajeTexto->MteContenido = addslashes($_POST['CmpContenido']);	
	
	$InsMensajeTexto->MteEstado = $_POST['CmpEstado'];	
	$InsMensajeTexto->MteTiempoCreacion = date("Y-m-d H:i:s");
	$InsMensajeTexto->MteTiempoModificacion = date("Y-m-d H:i:s");
	$InsMensajeTexto->MteEliminado = 1;
	
	if($Guardar){

		if($InsMensajeTexto->MtdRegistrarMensajeTexto()){
			
			if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
			}
			
			
			$Registro = true;
			FncNuevo();
			$Resultado.='#SAS_CMT_101';
			
		} else{
			$InsMensajeTexto->MteFecha = FncCambiaFechaANormal($InsMensajeTexto->MteFecha);	
			$Resultado.='#ERR_CMT_101';
		}
		
	}else{
		$InsMensajeTexto->MteFecha = FncCambiaFechaANormal($InsMensajeTexto->MteFecha);	
	}
	

}else{
	FncNuevo();
}

function FncNuevo(){
	
	global $InsMensajeTexto;
	global $InsCliente;
	global $GET_CmtId;
	
	$InsMensajeTexto = new ClsMensajeTexto();
	$InsMensajeTexto->MteEstado = 3;
	$InsMensajeTexto->MteFecha = date("d/m/Y");
	$InsMensajeTexto->MteDestino = $_SESSION['SesionDestinato'];
	
}
?>