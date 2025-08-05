<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsDesembolso->UsuId = $_SESSION['SesionId'];	
	
	$InsDesembolso->DesId = $_POST['CmpId'];
	
	$InsDesembolso->PrvId = $_POST['CmpProveedorId'];
	$InsDesembolso->CliId = $_POST['CmpClienteId'];
	$InsDesembolso->PerId = $_POST['CmpPersonalId'];
	
	$InsDesembolso->MonId = $_POST['CmpMonedaId'];
	$InsDesembolso->CueId = $_POST['CmpCuenta'];
	
	$InsDesembolso->AreId = "ARE-10001";
	
	$InsDesembolso->DesFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsDesembolso->DesNumeroCheque = ($_POST['CmpNumeroCheque']);

	$InsDesembolso->DesTipoCambio = ($_POST['CmpTipoCambio']);
	$InsDesembolso->DesMonto = eregi_replace(",","",(empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
	
	$InsDesembolso->DesTipoDestino = ($_POST['CmpTipoDestino']);	
	$InsDesembolso->DesEstado = $_POST['CmpEstado'];
	$InsDesembolso->DesConcepto = addslashes($_POST['CmpConcepto']);
	$InsDesembolso->DesObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsDesembolso->DesTiempoCreacion = date("Y-m-d H:i:s");
	$InsDesembolso->DesTiempoModificacion = date("Y-m-d H:i:s");
	$InsDesembolso->DesEliminado = 1;
	
	$InsDesembolso->PerNombre = ($_POST['CmpPersonalNombre']);
	$InsDesembolso->PerApellidoPaterno = ($_POST['CmpPersonalApellidoPaterno']);
	$InsDesembolso->PerApellidoMaterno = ($_POST['CmpPersonalApellidoMaterno']);
	$InsDesembolso->PerNumeroDocumento = ($_POST['CmpPersonalNumeroDocumento']);
	$InsDesembolso->TdoIdPersonal = ($_POST['CmpPersonalTipoDocumento']);
	
	$InsDesembolso->CliNombre = ($_POST['CmpClienteNombre']);
	$InsDesembolso->CliApellidoPaterno = ($_POST['CmpClienteApellidoPaterno']);
	$InsDesembolso->CliApellidoMaterno = ($_POST['CmpClienteApellidoMaterno']);
	$InsDesembolso->CliNumeroDocumento = ($_POST['CmpClienteNumeroDocumento']);
	$InsDesembolso->TdoIdCliente = ($_POST['CmpClienteTipoDocumento']);
	
	$InsDesembolso->PrvNombre = ($_POST['CmpProveedorNombre']);
	$InsDesembolso->PrvApellidoPaterno = ($_POST['CmpProveedorApellidoPaterno']);
	$InsDesembolso->PrvApellidoMaterno = ($_POST['CmpProbeedorApellidoMaterno']);
	$InsDesembolso->PrvNumeroDocumento = ($_POST['CmpProveedorNumeroDocumento']);
	$InsDesembolso->TdoIdPersonal = ($_POST['CmpProveedorTipoDocumento']);
	
	$InsDesembolso->DesNotificar = $_POST['CmpNotificar'];
	
	if($InsDesembolso->MonId<>$EmpresaMonedaId){
		if(empty($InsDesembolso->DesTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_DES_600';
		}
	}
	
	if(empty($InsDesembolso->PerId) and empty($InsDesembolso->PrvId) and empty($InsDesembolso->CliId)){
		
	}
	
	if($InsDesembolso->MonId<>$EmpresaMonedaId ){
		$InsDesembolso->DesMonto = $InsDesembolso->DesMonto * $InsDesembolso->DesTipoCambio;
	}
/*
SesionObjeto-DesembolsoComprobanteListado
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
	$ResDesembolsoComprobante = $_SESSION['InsDesembolsoComprobante'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrDesembolsoComprobantes = $ResDesembolsoComprobante['Datos'];
	
	$item = 1;
	foreach($ArrDesembolsoComprobantes as $DatSesionObjeto){
			
		$InsDesembolsoComprobante1 = new ClsDesembolsoComprobante();
		
		$InsDesembolsoComprobante1->DcoId = $DatSesionObjeto->Parametro1;
		$InsDesembolsoComprobante1->AmoId = $DatSesionObjeto->Parametro3;
		
		$InsDesembolsoComprobante1->DcoEstado = $DatSesionObjeto->Parametro14;
		$InsDesembolsoComprobante1->DcoTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro15);
		$InsDesembolsoComprobante1->DcoTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro16);
		$InsDesembolsoComprobante1->DcoEliminado = $DatSesionObjeto->Eliminado;
		$InsDesembolsoComprobante1->InsMysql = NULL;
	
		if($InsDesembolsoComprobante1->DcoEliminado==1){					
			$InsDesembolso->DesembolsoComprobante[] = $InsDesembolsoComprobante1;	
			$InsDesembolso->VdiTotalBruto += $InsDesembolsoComprobante1->AmoTotal;
		}
	
		
		$item++;	
	}


	if($InsDesembolso->MtdRegistrarDesembolso()){
		
		if($InsDesembolso->DesNotificar==1){
			
			$InsDesembolso->MtdNotificarDesembolsoRegistro($InsDesembolso->DesId,$CorreosNotificacionDesembolso);
			
		}
		
		FncNuevo();
		$Registro = true;
		$Resultado.='#SAS_DES_101';		
		
	} else{
		$InsDesembolso->DesFecha = FncCambiaFechaANormal($InsDesembolso->DesFecha);
		$Resultado.='#ERR_DES_101';
		
	}

	

}else{
	
	FncNuevo();
	
}

function FncNuevo(){

	global $InsDesembolso;	
	
	$InsDesembolso = new ClsDesembolso();
	
	$InsDesembolso->DesFecha = date("d/m/Y");
	$InsDesembolso->MonId = "MON-10000";
	$InsDesembolso->DesEstado = 3;
	$InsDesembolso->DesTipoDestino = 1;
	
}
?>