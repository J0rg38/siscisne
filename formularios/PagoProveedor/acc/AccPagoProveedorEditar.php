<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsPagoProveedor->UsuId = $_SESSION['SesionId'];	
	
	$InsPagoProveedor->PovId = $_POST['CmpId'];
	$InsPagoProveedor->PrvId = $_POST['CmpProveedorId'];
	$InsPagoProveedor->MonId = $_POST['CmpMonedaId'];
	$InsPagoProveedor->CueId = $_POST['CmpCuenta'];	
	
	$InsPagoProveedor->PovFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsPagoProveedor->PovNumeroOperacion = ($_POST['CmpNumeroOperacion']);

	$InsPagoProveedor->PovTipoCambio = ($_POST['CmpTipoCambio']);
	$InsPagoProveedor->PovMonto = eregi_replace(",","",(empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));

	$InsPagoProveedor->PovFoto = $_SESSION['SesPagoProveedorArchivo'.$Identificador];
	$InsPagoProveedor->PovEstado = $_POST['CmpEstado'];
	
	$InsPagoProveedor->PovObservacion = addslashes($_POST['CmpObservacion']);
	$InsPagoProveedor->PovTiempoModificacion = date("Y-m-d H:i:s");

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
	
	
		if($InsPagoProveedor->MtdEditarPagoProveedor()){		
		
			if($InsPagoProveedor->PovNotificar==1){
					
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
		
			$Edito = true;			
			$Resultado.='#SAS_POV_102';		
			FncCargarDatos();	
		}else{			
			$InsPagoProveedor->PovFecha = FncCambiaFechaANormal($InsPagoProveedor->PovFecha);
			$Resultado.='#ERR_POV_102';		
		}			
			
			

			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsPagoProveedor;
	global $Identificador;
	global $EmpresaMonedaId;
		
	unset($_SESSION['SesPagoProveedorArchivo'.$Identificador]);

	$InsPagoProveedor->PovId = $GET_id;
	$InsPagoProveedor->MtdObtenerPagoProveedor();			

	$_SESSION['SesPagoProveedorArchivo'.$Identificador] = $InsPagoProveedor->PovFoto;
	
	if($InsPagoProveedor->MonId<>$EmpresaMonedaId ){
		$InsPagoProveedor->PovMonto = round($InsPagoProveedor->PovMonto / $InsPagoProveedor->PovTipoCambio,2);
	}
	
}
?>