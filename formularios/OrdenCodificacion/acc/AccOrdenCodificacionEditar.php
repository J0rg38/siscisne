<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsOrdenCodificacion->UsuId = $_SESSION['SesionId'];	
	
	$InsOrdenCodificacion->OciId = $_POST['CmpId'];
	$InsOrdenCodificacion->PrvId = $_POST['CmpProveedorId'];
	$InsOrdenCodificacion->PerId = $_POST['CmpPersonal'];
	
	$InsOrdenCodificacion->OciFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsOrdenCodificacion->OciFechaRespuesta = FncCambiaFechaAMysql($_POST['CmpFechaRespuesta'],true);
	$InsOrdenCodificacion->OciHora = ($_POST['CmpHora']);

	$InsOrdenCodificacion->OciSolicitante = $_POST['CmpSolicitante'];
	$InsOrdenCodificacion->OciSolicitanteCargo = $_POST['CmpSolicitanteCargo'];
	$InsOrdenCodificacion->OciDealerSucursal = $_POST['CmpDealerSucursal'];
	$InsOrdenCodificacion->OciDescripcionPN= $_POST['CmpDescripcionPN'];
	$InsOrdenCodificacion->OciVIN = $_POST['CmpVIN'];
	$InsOrdenCodificacion->OciVehiculoModelo = $_POST['CmpVehiculoModelo'];
	$InsOrdenCodificacion->OciVehiculoAnoFabricacion = $_POST['CmpVehiculoAnoFabricacion'];
	$InsOrdenCodificacion->OciVehiculoMotorCilindrada = $_POST['CmpVehiculoMotorCilindrada'];

	$InsOrdenCodificacion->OciObservacion = addslashes($_POST['CmpObservacion']);
	$InsOrdenCodificacion->OciObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsOrdenCodificacion->OciObservacionCorreo = addslashes($_POST['CmpObservacionCorreo']);
	
	$InsOrdenCodificacion->OciOrigen =  $_POST['CmpOrigen'];
	$InsOrdenCodificacion->OciEstado = $_POST['CmpEstado'];
	$InsOrdenCodificacion->OciTiempoModificacion = date("Y-m-d H:i:s");

	$InsOrdenCodificacion->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsOrdenCodificacion->PrvNombreCompleto = $InsOrdenCodificacion->PrvNombre;
	$InsOrdenCodificacion->TdoId = $_POST['CmpProveedorTipoDocumento'];	
	$InsOrdenCodificacion->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];

	$InsOrdenCodificacion->OciFoto = $_SESSION['SesOciFoto'.$Identificador];

	if($Guardar){
		if($InsOrdenCodificacion->MtdEditarOrdenCodificacion()){	

			if(!empty($GET_dia)){
?>
				<script type="text/javascript">

				self.parent.tb_remove('<?php echo $GET_mod;?>');
				self.parent.$('#CmpOrdenCodificacionId').val("<?php echo $InsOrdenCodificacion->OciId;?>");
				self.parent.FncOrdenCodificacionBuscar("Id");

				</script>
<?php
			}
			
					
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_OCI_102';
		} else{
			$InsOrdenCodificacion->OciFecha = FncCambiaFechaANormal($InsOrdenCodificacion->OciFecha);
			$InsOrdenCodificacion->OciFechaRespuesta = FncCambiaFechaANormal($InsOrdenCodificacion->OciFechaRespuesta,true);
			$Resultado.='#ERR_OCI_102';
		}	
	}else{
		$InsOrdenCodificacion->OciFecha = FncCambiaFechaANormal($InsOrdenCodificacion->OciFecha);
		$InsOrdenCodificacion->OciFechaRespuesta = FncCambiaFechaANormal($InsOrdenCodificacion->OciFechaRespuesta,true);
	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $Identificador;
	global $InsOrdenCodificacion;
	global $EmpresaMonedaId;
	global $InsProductoDisponibilidad;
	global $InsProductoReemplazo;
	
	unset($_SESSION['SesOciFoto'.$Identificador]);
	
	$InsOrdenCodificacion->OciId = $GET_id;
	$InsOrdenCodificacion->MtdObtenerOrdenCodificacion();		
	
	$_SESSION['SesOciFoto'.$Identificador] = $InsOrdenCodificacion->OciFoto;

}

?>