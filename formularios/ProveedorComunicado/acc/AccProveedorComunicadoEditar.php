<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsProveedorComunicado->UsuId = $_SESSION['SesionId'];
		
	$InsProveedorComunicado->PomId = $_POST['CmpId'];
	$InsProveedorComunicado->PrvId = $_POST['CmpProveedorId'];
	$InsProveedorComunicado->PomFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsProveedorComunicado->PomCodigo = addslashes($_POST['CmpCodigo']);
	$InsProveedorComunicado->PomRemitente = addslashes($_POST['CmpRemitente']);
	$InsProveedorComunicado->PomAsunto = addslashes($_POST['CmpAsunto']);
	$InsProveedorComunicado->PomDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsProveedorComunicado->PomArchivo = $_SESSION['SesProveedorComunicadoArchivoSolo'.$Identificador];	
	$InsProveedorComunicado->PomEstado = 3;	
	$InsProveedorComunicado->PomTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsProveedorComunicado->PrvNombre = $_POST['PrvNombre'];
	$InsProveedorComunicado->PrvApellidoPaterno = $_POST['PrvApellidoPaterno'];
	$InsProveedorComunicado->PrvAPellidoMaterno = $_POST['PrvAPellidoMaterno'];
	
	$InsProveedorComunicado->PrvNumeroDocumento = $_POST['PrvNumeroDocumento'];
	$InsProveedorComunicado->TdoId = $_POST['CmpProveedorTipoDocumentoId'];
				
	if($Guardar){	
		if($InsProveedorComunicado->MtdEditarProveedorComunicado()){		
			
			if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
			}
						
			$Resultado.='#SAS_POM_102';	
			FncCargarDatos();	
			$Edito = true;	
		}else{			
		
			$InsProveedorComunicado->PomFecha = PomFecha($InsProveedorComunicado->PomFecha);
			$Resultado.='#ERR_POM_102';		
		}			
	}
	
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsProveedorComunicado;
	global $Identificador;
	
	unset($_SESSION['SesProFoto'.$Identificador]);

	$InsProveedorComunicado->PomId = $GET_id;
	$InsProveedorComunicado->MtdObtenerProveedorComunicado();		
			
	$_SESSION['SesProveedorComunicadoArchivoSolo'.$Identificador] =	$InsProveedorComunicado->PomArchivo;

}

?>