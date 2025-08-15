<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsRegistroOperacionUIF->UsuId = $_SESSION['SesionId'];	
	
	$InsRegistroOperacionUIF->RouId = $_POST['CmpId'];
	$InsRegistroOperacionUIF->CliId = $_POST['CmpClienteId'];
	$InsRegistroOperacionUIF->PerId = $_POST['CmpPersonal'];
	
	$InsRegistroOperacionUIF->RouCodigoEmpresa = $_POST['CmpCodigoEmpresa'];
	$InsRegistroOperacionUIF->RouCodigoOficialCumplimiento = $_POST['CmpCodigoOficialCumplimiento'];
	$InsRegistroOperacionUIF->RouTransaccion = addslashes($_POST['CmpTransaccion']);
	
	$InsRegistroOperacionUIF->RouFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsRegistroOperacionUIF->RouHora = ($_POST['CmpHora']);
	
	$InsRegistroOperacionUIF->MonId = $_POST['CmpMonedaId'];
	$InsRegistroOperacionUIF->RouTipoCambio = $_POST['CmpTipoCambio'];
	$InsRegistroOperacionUIF->RouImporte = preg_replace("/,/", "", (empty($_POST['CmpImporte'])?0:$_POST['CmpImporte']));

	$InsRegistroOperacionUIF->RouOrdenanteNombre = ($_POST['CmpOrdenanteNombre']);
	$InsRegistroOperacionUIF->RouOrdenanteNumeroDocumento = ($_POST['CmpOrdenanteNumeroDocumento']);
	$InsRegistroOperacionUIF->RouOrdenanteDireccion = ($_POST['CmpOrdenanteDireccion']);
	
	$InsRegistroOperacionUIF->RouTramitanteNombre = ($_POST['CmpTramitanteNombre']);
	$InsRegistroOperacionUIF->RouTramitanteNumeroDocumento = ($_POST['CmpTramitanteNumeroDocumento']);
	$InsRegistroOperacionUIF->RouTramitanteDireccion = ($_POST['CmpTramitanteDireccion']);
	
	$InsRegistroOperacionUIF->RouOrigenFondo = addslashes($_POST['CmpOrigenFondo']);
	$InsRegistroOperacionUIF->RouObservacionInterna = addslashes($_POST['CmpObservacionInterna']);
	
	$InsRegistroOperacionUIF->RouEstado = $_POST['CmpEstado'];
	$InsRegistroOperacionUIF->RouTiempoModificacion = date("Y-m-d H:i:s");

	$InsRegistroOperacionUIF->CliNombre = $_POST['CmpClienteNombre'];
	$InsRegistroOperacionUIF->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsRegistroOperacionUIF->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];

	$InsRegistroOperacionUIF->TdoId = $_POST['CmpClienteTipoDocumento'];	
	$InsRegistroOperacionUIF->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	
	$InsRegistroOperacionUIF->RouDireccion = $_POST['CmpDireccion'];
	$InsRegistroOperacionUIF->RouTelefono = $_POST['CmpTelefono'];
	$InsRegistroOperacionUIF->RouCelular = $_POST['CmpCelular'];
	
	if($InsRegistroOperacionUIF->MonId<>$EmpresaMonedaId){
		if(empty($InsRegistroOperacionUIF->RouTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_ROU_600';
		}
	}
	

	if(empty($InsRegistroOperacionUIF->CliId)){
		$Guardar = false;
		$Resultado.='#ERR_ROU_123';
	}
	
	

	if($Guardar){
		if($InsRegistroOperacionUIF->MtdEditarRegistroOperacionUIF()){	


			if(!empty($GET_dia)){
?>
				<script type="text/javascript">

				self.parent.tb_remove('<?php echo $GET_mod;?>');
				self.parent.$('#CmpRegistroOperacionUIFId').val("<?php echo $InsRegistroOperacionUIF->RouId;?>");
				self.parent.FncRegistroOperacionUIFBuscar("Id");

				</script>
<?php
			}
			
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_ROU_102';
		} else{
			$InsRegistroOperacionUIF->RouFecha = FncCambiaFechaANormal($InsRegistroOperacionUIF->RouFecha);
			$Resultado.='#ERR_ROU_102';
		}	
	}else{
		$InsRegistroOperacionUIF->RouFecha = FncCambiaFechaANormal($InsRegistroOperacionUIF->RouFecha);
	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsRegistroOperacionUIF;
	global $EmpresaMonedaId;
	global $InsProductoDisponibilidad;
	global $InsProductoReemplazo;
	
	$InsRegistroOperacionUIF->RouId = $GET_id;
	$InsRegistroOperacionUIF->MtdObtenerRegistroOperacionUIF();		


	
	
}



?>