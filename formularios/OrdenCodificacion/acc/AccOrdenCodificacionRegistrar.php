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
	list($InsOrdenCodificacion->OciAno,$Mes,$Dia) = explode("-",$InsOrdenCodificacion->OciFecha);

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
	$InsOrdenCodificacion->OciTiempoCreacion = date("Y-m-d H:i:s");
	$InsOrdenCodificacion->OciTiempoModificacion = date("Y-m-d H:i:s");

	$InsOrdenCodificacion->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsOrdenCodificacion->PrvNombreCompleto = $InsOrdenCodificacion->PrvNombre;
	$InsOrdenCodificacion->TdoId = $_POST['CmpProveedorTipoDocumento'];	
	$InsOrdenCodificacion->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsOrdenCodificacion->OciFoto = $_SESSION['SesOciFoto'.$Identificador];
	
	if($Guardar){

		if($InsOrdenCodificacion->MtdRegistrarOrdenCodificacion()){
			
		
			unset($InsOrdenCodificacion);
			FncNuevo();

			$Registro = true;
			$Resultado.='#SAS_OCI_101';

		}else{
			$InsOrdenCodificacion->OciFecha = FncCambiaFechaANormal($InsOrdenCodificacion->OciFecha);
			$InsOrdenCodificacion->OciFechaRespuesta = FncCambiaFechaANormal($InsOrdenCodificacion->OciFechaRespuesta,true);
			$Resultado.='#ERR_OCI_101';
		}		

	}else{

		$InsOrdenCodificacion->OciFecha = FncCambiaFechaANormal($InsOrdenCodificacion->OciFecha);	
			$InsOrdenCodificacion->OciFechaRespuesta = FncCambiaFechaANormal($InsOrdenCodificacion->OciFechaRespuesta,true);

	}

	

}else{
	
	FncNuevo();
	
}


function FncNuevo(){
	
	global $Identificador;
	global $InsOrdenCodificacion;
	global $InsTipoCambio;
	global $EmpresaImpuestoVenta;
		
		
	$InsOrdenCodificacion->PerId = $_SESSION['SesionId'];
	$InsOrdenCodificacion->OciEstado = 3;
	$InsOrdenCodificacion->OciIncluyeImpuesto = 3;
	$InsOrdenCodificacion->OciOrigen = "OCI";
	$InsOrdenCodificacion->MonId = "MON-10001";
	$InsOrdenCodificacion->OciFecha = date("d/m/Y");
	$InsOrdenCodificacion->OciHora = date("H:i:s");
	$InsOrdenCodificacion->OciPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;

	$InsProveedor = new ClsProveedor();
	//MtdObtenerProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PrvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL) {
	$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,"PrvNombre","ASC","1","1","CYC");
	$ArrProveedores = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){
		
			$InsOrdenCodificacion->PrvId = $DatProveedor->PrvId;
			$InsOrdenCodificacion->PrvNombreCompleto = $DatProveedor->PrvNombreCompleto;
			$InsOrdenCodificacion->PrvNombre = $DatProveedor->PrvNombre;
			$InsOrdenCodificacion->PrvApellidoPaterno = $DatProveedor->PrvApellidoPaterno;
			$InsOrdenCodificacion->PrvApellidoMaterno = $DatProveedor->PrvApellidoMaterno;
			$InsOrdenCodificacion->PrvNumeroDocumento = $DatProveedor->PrvNumeroDocumento;
			$InsOrdenCodificacion->TdoId = $DatProveedor->TdoId;
//			$InsOrdenCodificacion->PrvId = "CLI-1000";
//			$InsOrdenCodificacion->PrvNombre = "C&C S.A.C.";
//			$InsOrdenCodificacion->PrvNumeroDocumento = "20410705878";
//			$InsOrdenCodificacion->TdoId = "TDO-10003";
	
		}
	}
	
	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = "MON-10001";
	$InsTipoCambio->TcaFecha = date("Y-m-d");
	
	$InsTipoCambio->MtdObtenerTipoCambioActual();
	
	if(empty($InsTipoCambio->TcaId)){
		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}
		
	$InsOrdenCodificacion->OciTipoCambio = $InsTipoCambio->TcaMontoCompra;
	
}
?>