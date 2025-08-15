<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsIngreso->UsuId = $_SESSION['SesionId'];	
	
	$InsIngreso->IngId = $_POST['CmpId'];
	$InsIngreso->SucId = $_SESSION['SesionSucursal'];	
	
	$InsIngreso->PrvId = $_POST['CmpProveedorId'];
	$InsIngreso->CliId = $_POST['CmpClienteId'];
	$InsIngreso->PerId = $_POST['CmpPersonalId'];
	
	$InsIngreso->FpaId = $_POST['CmpFormaPago'];
	$InsIngreso->MonId = $_POST['CmpMonedaId'];
	$InsIngreso->CueId = "CUE-10000";
	
	$InsIngreso->AreId = "ARE-10000";
	
	$InsIngreso->IngFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsIngreso->IngNumeroCheque = ($_POST['CmpNumeroCheque']);
	$InsIngreso->IngReferencia = ($_POST['CmpReferencia']);

	$InsIngreso->IngTipoCambio = ($_POST['CmpTipoCambio']);
	$InsIngreso->IngMonto = preg_replace("/,/", "", (empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
	
	$InsIngreso->IngTipoDestino = ($_POST['CmpTipoDestino']);
	$InsIngreso->IngTipo = $_POST['CmpTipo'];	
	$InsIngreso->IngEstado = $_POST['CmpEstado'];
	$InsIngreso->IngConcepto = addslashes($_POST['CmpConcepto']);
	$InsIngreso->IngObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsIngreso->IngTiempoCreacion = date("Y-m-d H:i:s");
	$InsIngreso->IngTiempoModificacion = date("Y-m-d H:i:s");
	$InsIngreso->IngEliminado = 1;
	
	$InsIngreso->PerNombre = ($_POST['CmpPersonalNombre']);
	$InsIngreso->PerApellidoPaterno = ($_POST['CmpPersonalApellidoPaterno']);
	$InsIngreso->PerApellidoMaterno = ($_POST['CmpPersonalApellidoMaterno']);
	$InsIngreso->PerNumeroDocumento = ($_POST['CmpPersonalNumeroDocumento']);
	$InsIngreso->TdoIdPersonal = ($_POST['CmpPersonalTipoDocumento']);
	
	$InsIngreso->CliNombre = ($_POST['CmpClienteNombre']);
	$InsIngreso->CliApellidoPaterno = ($_POST['CmpClienteApellidoPaterno']);
	$InsIngreso->CliApellidoMaterno = ($_POST['CmpClienteApellidoMaterno']);
	$InsIngreso->CliNumeroDocumento = ($_POST['CmpClienteNumeroDocumento']);
	$InsIngreso->TdoIdCliente = ($_POST['CmpClienteTipoDocumento']);
	
	$InsIngreso->PrvNombre = ($_POST['CmpProveedorNombre']);
	$InsIngreso->PrvApellidoPaterno = ($_POST['CmpProveedorApellidoPaterno']);
	$InsIngreso->PrvApellidoMaterno = ($_POST['CmpProbeedorApellidoMaterno']);
	$InsIngreso->PrvNumeroDocumento = ($_POST['CmpProveedorNumeroDocumento']);
	$InsIngreso->TdoIdPersonal = ($_POST['CmpProveedorTipoDocumento']);
	
	$InsIngreso->IngNotificar = $_POST['CmpNotificar'];
	
	if($InsIngreso->MonId<>$EmpresaMonedaId){
		if(empty($InsIngreso->IngTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_ING_600';
		}
	}
	
	if(empty($InsIngreso->PerId) and empty($InsIngreso->PrvId) and empty($InsIngreso->CliId)){
		
	}
	
	if($InsIngreso->MonId<>$EmpresaMonedaId ){
		$InsIngreso->IngMonto = $InsIngreso->IngMonto * $InsIngreso->IngTipoCambio;
	}
/*
SesionObjeto-IngresoComprobanteListado
Parametro1 = DcoId
Parametro2 = 
Parametro3 = AmoId
Parametro4 = AmoComprobanteNumero
Parametro5 = AmoComprobanteFecha
Parametro6 = AmoTotal
Parametro7 = PrvId
Parametro8 = MonId
Parametro9 = AmoTipoCambio
Parametro10 = MonNombre
Parametro11 = MonSimbolo
Parametro12 = PrvNombre
Parametro13 = PrvNumeroDocumento

Parametro14 = DcoEstado
Parametro15 = DcoTiempoCreacion
Parametro16 = DcoTiempoModificacion

*/
	$ResIngresoComprobante = $_SESSION['InsIngresoComprobante'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrIngresoComprobantes = $ResIngresoComprobante['Datos'];
	
	$item = 1;
	foreach($ArrIngresoComprobantes as $DatSesionObjeto){
			
		$InsIngresoComprobante1 = new ClsIngresoComprobante();
		
		$InsIngresoComprobante1->DcoId = $DatSesionObjeto->Parametro1;
		$InsIngresoComprobante1->AmoId = $DatSesionObjeto->Parametro3;
		
		$InsIngresoComprobante1->DcoEstado = $DatSesionObjeto->Parametro14;
		$InsIngresoComprobante1->DcoTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro15);
		$InsIngresoComprobante1->DcoTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro16);
		$InsIngresoComprobante1->DcoEliminado = $DatSesionObjeto->Eliminado;
		$InsIngresoComprobante1->InsMysql = NULL;
	
		if($InsIngresoComprobante1->DcoEliminado==1){					
			$InsIngreso->IngresoComprobante[] = $InsIngresoComprobante1;	
			$InsIngreso->VdiTotalBruto += $InsIngresoComprobante1->AmoTotal;
		}
	
		
		$item++;	
	}


	if($InsIngreso->MtdRegistrarIngreso()){
		
		/*if($InsIngreso->IngNotificar==1){
				
			//$InsIngreso->MtdNotificarIngresoRegistro($InsIngreso->IngId,"jblanco@cyc.com.pe");
			$InsIngreso->MtdNotificarIngresoRegistro($InsIngreso->IngId,$CorreosNotificacionIngresoCaja);
			
		}*/
		
		FncNuevo();
		$Registro = true;
		$Resultado.='#SAS_ING_101';		
		
	} else{
		$InsIngreso->IngFecha = FncCambiaFechaANormal($InsIngreso->IngFecha);
		$Resultado.='#ERR_ING_101';
		
	}

	

}else{
	
	FncNuevo();
	
}

function FncNuevo(){

	global $InsIngreso;	
	
	$InsIngreso = new ClsIngreso();
	
	$InsIngreso->IngFecha = date("d/m/Y");
	$InsIngreso->MonId = "MON-10000";
	$InsIngreso->IngEstado = 3;
	$InsIngreso->IngTipoDestino = 1;
	$InsIngreso->SucId = $_SESSION['SesionSucursal'];
	$InsIngreso->FpaId = "FPA-10000";	
	
	$InsIngreso->IngTipo = 5;
	
	
	
	
	
}
?>