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
	$InsRegistroOperacionUIF->RouTiempoCreacion = date("Y-m-d H:i:s");
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

		if($InsRegistroOperacionUIF->MtdRegistrarRegistroOperacionUIF()){
			
			unset($InsRegistroOperacionUIF);
			FncNuevo();

			$Registro = true;
			$Resultado.='#SAS_ROU_101';

		}else{
			$InsRegistroOperacionUIF->RouFecha = FncCambiaFechaANormal($InsRegistroOperacionUIF->RouFecha);
			$Resultado.='#ERR_ROU_101';
		}		

	}else{

		$InsRegistroOperacionUIF->RouFecha = FncCambiaFechaANormal($InsRegistroOperacionUIF->RouFecha);	

	}

	

}else{
	
	FncNuevo();
	
	switch($GET_Origen){

		case "VentaDirecta":

			
		break;
		
		case "FichaAccion":
		
			
		break;
		
	}
	
}


function FncNuevo(){
	
	
	global $Identificador;
	global $InsRegistroOperacionUIF;
	global $InsTipoCambio;
	global $EmpresaImpuestoVenta;
	
	$InsRegistroOperacionUIF->RouEstado = 3;
	$InsRegistroOperacionUIF->MonId = "MON-10001";
	$InsRegistroOperacionUIF->RouFecha = date("d/m/Y");
	$InsRegistroOperacionUIF->RouHora = date("H:i:s");
	$InsRegistroOperacionUIF->PerId = $_SESSION['SesionPersonal'];
	
//	deb($_SESSION['SesionPersonal']);
	$InsRegistroOperacionUIF->RouCodigoEmpresa = "16554402";
	$InsRegistroOperacionUIF->RouCodigoOficialCumplimiento = "011124495491";
	
	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = "MON-10001";
	$InsTipoCambio->TcaFecha = date("Y-m-d");
	
	$InsTipoCambio->MtdObtenerTipoCambioActual();
	
	if(empty($InsTipoCambio->TcaId)){
		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}
		
	$InsRegistroOperacionUIF->RouTipoCambio = $InsTipoCambio->TcaMontoCompra;
	
}
?>