<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsServicioRepuesto->UsuId = $_SESSION['SesionId'];	

	$InsServicioRepuesto->SreId = $_POST['CmpId'];
	$InsServicioRepuesto->TgaId = $_POST['CmpTipoGasto'];
	
	$InsServicioRepuesto->SreNombre = addslashes($_POST['CmpNombre']);
	$InsServicioRepuesto->SreDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsServicioRepuesto->SreEstado = $_POST['CmpEstado'];
	
	$InsServicioRepuesto->SreTiempoCreacion = date("Y-m-d H:i:s");
	$InsServicioRepuesto->SreTiempoModificacion = date("Y-m-d H:i:s");
	$InsServicioRepuesto->SreEliminado = 1;
	
	if($Guardar){

		if($InsServicioRepuesto->MtdRegistrarServicioRepuesto()){
			
			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
					self.parent.tb_remove('<?php echo $GET_mod;?>');
					self.parent.$('#CmpServicioRepuestoId').val("<?php echo $InsServicioRepuesto->SreId;?>");
					self.parent.FncServicioRepuestoBuscar("Id");
                </script>
<?php
			}
				
			FncNuevo();
		
			$Resultado.='#SAS_SRE_101';
			$Registro = true;

		}else{

			$Resultado.='#ERR_SRE_101';	

		}
			
	}else{
		
		
	}
	


}else{

	FncNuevo();
	
}

function FncNuevo(){

	global $Identificador;
	global $InsServicioRepuesto;
	global $GET_ServicioRepuestoNombre;
	global $GET_TipoGastoId;

	$InsServicioRepuesto = new ClsServicioRepuesto();
	
	
	$InsServicioRepuesto->SreNombre = $GET_ServicioRepuestoNombre;
	$InsServicioRepuesto->TgaId = $GET_TipoGastoId;
	
	$InsServicioRepuesto->SreEstado = 1;

	
}
?>