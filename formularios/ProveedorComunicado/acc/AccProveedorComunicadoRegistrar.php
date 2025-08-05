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
	$InsProveedorComunicado->PomTiempoCreacion = date("Y-m-d H:i:s");
	$InsProveedorComunicado->PomTiempoModificacion = date("Y-m-d H:i:s");
	$InsProveedorComunicado->PomEliminado = 1;
	
		
	$InsProveedorComunicado->PrvNombre = $_POST['PrvNombre'];
	$InsProveedorComunicado->PrvApellidoPaterno = $_POST['PrvApellidoPaterno'];
	$InsProveedorComunicado->PrvAPellidoMaterno = $_POST['PrvAPellidoMaterno'];
	
	$InsProveedorComunicado->PrvNumeroDocumento = $_POST['PrvNumeroDocumento'];
	$InsProveedorComunicado->TdoId = $_POST['CmpProveedorTipoDocumentoId'];

	if($Guardar){
		if($InsProveedorComunicado->MtdRegistrarProveedorComunicado()){
		
			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
                    self.parent.tb_remove('<?php echo $GET_mod;?>');
                    self.parent.$('#CmpProveedorComunicadoId').val("<?php echo $InsProveedorComunicado->PomId;?>");
                    self.parent.FncProveedorComunicadoBuscar("Id");
                </script>
<?php
			}
			
			//unset($_SESSION['SesProFoto'.$Identificador]);
			//unset($_SESSION['SesProEspecificacion'.$Identificador]);
			//unset($InsProveedorComunicado);	
			FncNuevo();	
			//$InsProveedorComunicado= new ClsProveedorComunicado();
			$Resultado.='#SAS_POM_101';
			$Registro = false;

		} else{
			$InsProveedorComunicado->PomFecha = PomFecha($InsProveedorComunicado->PomFecha);
			
			$InsProveedorComunicado->PcaId = $_POST['CmpCategoria'];
			$Resultado.='#ERR_POM_101';
		}
	}else{
		$InsProveedorComunicado->PomFecha = PomFecha($InsProveedorComunicado->PomFecha);	
	}

}else{
	FncNuevo();
}


function FncNuevo(){
	
	global $Identificador;
	global $InsProveedor;
	global $InsProveedorComunicado;
	
	global $GET_ProveedorComunicadoCodigo;
	global $GET_ProveedorComunicadoCodigo;
	global $GET_ProveedorComunicadoCodigoAlternativo;
	global $GET_ProveedorComunicadoAsunto;
	global $GET_ProveedorComunicadoUnidadMedida;
	
	unset($_SESSION['SesProFoto'.$Identificador]);

	$InsProveedorComunicado = new ClsProveedorComunicado();
	$InsProveedorComunicado->PomFecha = date("d/m/Y");	
	
	
	$InsProveedor = new ClsProveedor();
	$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,'PrvNombre','ASC','1',NULL,"CYC");
	$ArrProveedores = $ResProveedor['Datos'];
	
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){

			$InsProveedorComunicado->PrvId = $DatProveedor->PrvId;
			$InsProveedorComunicado->PrvNombreCompleto = $DatProveedor->PrvNombreCompleto;
			$InsProveedorComunicado->PrvNombre = $DatProveedor->PrvNombre;
			$InsProveedorComunicado->PrvApellidoPaterno = $DatProveedor->PrvApellidoPaterno;
			$InsProveedorComunicado->PrvApellidoMaterno = $DatProveedor->PrvApellidoMaterno;
			
			$InsProveedorComunicado->PrvNumeroDocumento = $DatProveedor->PrvNumeroDocumento;
			$InsProveedorComunicado->TdoId = $DatProveedor->TdoId;

		}
	}
	
}

?>