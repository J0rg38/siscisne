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
	$InsMensajeTexto->MteTiempoModificacion = date("Y-m-d H:i:s");
	$InsMensajeTexto->MteEliminado = 1;

		if($Guardar){
	
			if($InsMensajeTexto->MtdEditarMensajeTexto()){		

				if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
				}
			
				$Edito = true;			
				$Resultado.='#SAS_CMT_102';
				FncCargarDatos();
				
			}else{
				
				$InsMensajeTexto->MteFecha = FncCambiaFechaANormal($InsMensajeTexto->MteFecha);	
				$Resultado.='#ERR_CMT_102';		
			}
			
		}else{

			$InsMensajeTexto->MteFecha = FncCambiaFechaANormal($InsMensajeTexto->MteFecha);	

		}
			
			
}else{

	FncCargarDatos();

}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsMensajeTexto;

	global $TotalOriginal;
	
	$InsMensajeTexto->MteId = $GET_id;
	$InsMensajeTexto->MtdObtenerMensajeTexto();		
	
}
?>