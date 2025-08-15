<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsPagoProveedor->UsuId = $_SESSION['SesionId'];	
	
	$InsPagoProveedor->PovId = $_POST['CmpId'];
	$InsPagoProveedor->PrvId = $_POST['CmpProveedorId'];
	
	$InsPagoProveedor->MonId = $_POST['CmpMonedaId'];
	$InsPagoProveedor->CueId = $_POST['CmpCuenta'];
	
	$InsPagoProveedor->PovFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsPagoProveedor->PovNumeroOperacion = ($_POST['CmpNumeroOperacion']);

	$InsPagoProveedor->PovTipoCambio = ($_POST['CmpTipoCambio']);
	$InsPagoProveedor->PovMonto = preg_replace("/,/", "", (empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
	
	$InsPagoProveedor->PovFoto = $_SESSION['SesPagoProveedorArchivo'.$Identificador];
	$InsPagoProveedor->PovEstado = $_POST['CmpEstado'];
	$InsPagoProveedor->PovConcepto = addslashes($_POST['CmpConcepto']);
	$InsPagoProveedor->PovObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsPagoProveedor->PovTiempoCreacion = date("Y-m-d H:i:s");
	$InsPagoProveedor->PovTiempoModificacion = date("Y-m-d H:i:s");
	$InsPagoProveedor->PovEliminado = 1;
	
	$InsPagoProveedor->PrvNombre = ($_POST['CmpProveedorNombre']);
	$InsPagoProveedor->PrvApellidoPaterno = ($_POST['CmpProveedorApellidoPaterno']);
	$InsPagoProveedor->PrvApellidoMaterno = ($_POST['CmpProbeedorApellidoMaterno']);
	$InsPagoProveedor->PrvNumeroDocumento = ($_POST['CmpProveedorNumeroDocumento']);
	$InsPagoProveedor->TdoId = ($_POST['CmpProveedorTipoDocumento']);
	
	$InsPagoProveedor->PovNotificar = $_POST['ChkNotificar'];
	$InsPagoProveedor->PovActualizarLineaCredito = $_POST['ChkActualizarLineaCredito'];
	
	if($InsPagoProveedor->MonId<>$EmpresaMonedaId){
		if(empty($InsPagoProveedor->PovTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_POV_600';
		}
	}
	
	if($InsPagoProveedor->MonId<>$EmpresaMonedaId ){
		$InsPagoProveedor->PovMonto = $InsPagoProveedor->PovMonto * $InsPagoProveedor->PovTipoCambio;
	}


	if($InsPagoProveedor->MtdRegistrarPagoProveedor()){
		
		if($InsPagoProveedor->PovNotificar==1){
				
			//$InsPagoProveedor->MtdNotificarPagoProveedorRegistro($InsPagoProveedor->PovId,"jblanco@cyc.com.pe");
			$InsPagoProveedor->MtdNotificarPagoProveedorRegistro($InsPagoProveedor->PovId,$CorreosNotificacionPagoProveedor);
			
		}
		
		if($InsPagoProveedor->PovActualizarLineaCredito=="1"){

			$InsProveedor = new ClsProveedor();
			$InsProveedor->PrvId = $InsPagoProveedor->PrvId;
			$InsProveedor->MonId = $InsPagoProveedor->MonId;
			$InsProveedor->PrvTipoCambio = $InsPagoProveedor->PovTipoCambio;
				$InsProveedor->PrvLineaCredito = $InsPagoProveedor->PovMonto;
			$InsProveedor->PrvLineaCreditoActual = $InsPagoProveedor->PovMonto;
			$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
			$InsProveedor->MtdActualizarProveedorLineaCreditoActual();
			
		}


		FncNuevo();
		$Registro = true;
		$Resultado.='#SAS_POV_101';		
		
	} else{
		$InsPagoProveedor->PovFecha = FncCambiaFechaANormal($InsPagoProveedor->PovFecha);
		$Resultado.='#ERR_POV_101';
		
	}

	

}else{
	
	FncNuevo();
	
}

function FncNuevo(){

	global $InsPagoProveedor;	
	global $InsProveedor;	
	global $InsProveedor;	
	
	$InsPagoProveedor = new ClsPagoProveedor();
	
	$InsPagoProveedor->PovFecha = date("d/m/Y");
	$InsPagoProveedor->MonId = "MON-10000";
	$InsPagoProveedor->PovEstado = 3;
	$InsPagoProveedor->PovTipoDestino = 1;
	$InsPagoProveedor->MonId = "MON-10001";
	
	$InsProveedor = new ClsProveedor();
	$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,'PrvNombre','ASC','1',NULL,"CYC");
	$ArrProveedores = $ResProveedor['Datos'];
	
	$ProveedorId = "";
	$ProveedorNombre = "";
	$ProveedorNumeroDocumento = "";
	$ProveedorTipoDocumentoId = "";
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){

			$ProveedorId = $DatProveedor->PrvId;
			$ProveedorNombre =  $DatProveedor->PrvNombre;
			$ProveedorNumeroDocumento = $DatProveedor->PrvNumeroDocumento;
			$ProveedorTipoDocumentoId = $DatProveedor->TdoId;
			

		}
	}
	
	$InsPagoProveedor->PrvId = $ProveedorId;
	$InsPagoProveedor->PrvNombre = $ProveedorNombre;
	$InsPagoProveedor->PrvNumeroDocumento = $ProveedorNumeroDocumento;
	$InsPagoProveedor->TdoId = $ProveedorTipoDocumentoId;
	
	//deb($InsOrdenCompra);
	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = $InsPagoProveedor->MonId;
	$InsTipoCambio->TcaFecha = date("Y-m-d");
	
	$InsTipoCambio->MtdObtenerTipoCambioActual();
	
	if(empty($InsTipoCambio->TcaId)){
		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}
		
	
	$InsPagoProveedor->PovTipoCambio = $InsTipoCambio->TcaMontoComercial;
	
	
}
?>