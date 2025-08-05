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
	
	
	$InsServicioRepuesto->SreTiempoModificacion = date("Y-m-d H:i:s");
	$InsServicioRepuesto->SreEliminado = 1;

	
	if($Guardar){
		
		if($InsServicioRepuesto->MtdEditarServicioRepuesto()){		
			
			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
                    
                        self.parent.tb_remove('<?php echo $GET_mod;?>');
                        self.parent.$('#CmpServicioRepuestoId').val("<?php echo $InsServicioRepuesto->SreId;?>");
                        self.parent.FncServicioRepuestoBuscar("Id");
                
                </script>
<?php
			}
			
			FncCargarDatos();
			$Resultado.='#SAS_SRE_102';
			$Edito = true;
		} else{
	
			
			$Resultado.='#ERR_SRE_102';
		}
		
	}else{
		

	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsServicioRepuesto;
	global $EmpresaMonedaId;
	
	$InsServicioRepuesto->SreId = $GET_id;
	$InsServicioRepuesto->MtdObtenerServicioRepuesto();		

	
			
}
?>