<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsPagoProveedor->UsuId = $_SESSION['SesionId'];	
	
	$InsPagoProveedor->PovId = $_POST['CmpId'];
	
	$InsPagoProveedor->PrvId = $_POST['CmpProveedorId'];
	$InsPagoProveedor->CliId = $_POST['CmpClienteId'];
	$InsPagoProveedor->PerId = $_POST['CmpPersonalId'];
	
	$InsPagoProveedor->MonId = $_POST['CmpMonedaId'];
	$InsPagoProveedor->CueId = $_POST['CmpCuenta'];
	
	$InsPagoProveedor->AreId = "ARE-10001";
	
	$InsPagoProveedor->PovFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsPagoProveedor->PovNumeroOperacion = ($_POST['CmpNumeroOperacion']);

	$InsPagoProveedor->PovTipoCambio = ($_POST['CmpTipoCambio']);
	$InsPagoProveedor->PovMonto = preg_replace("/,/", "", (empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
	
	$InsPagoProveedor->PovTipoDestino = ($_POST['CmpTipoDestino']);	
	$InsPagoProveedor->PovEstado = $_POST['CmpEstado'];
	$InsPagoProveedor->PovConcepto = addslashes($_POST['CmpConcepto']);
	$InsPagoProveedor->PovObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsPagoProveedor->PovTiempoCreacion = date("Y-m-d H:i:s");
	$InsPagoProveedor->PovTiempoModificacion = date("Y-m-d H:i:s");
	$InsPagoProveedor->PovEliminado = 1;
	
	$InsPagoProveedor->PerNombre = ($_POST['CmpPersonalNombre']);
	$InsPagoProveedor->PerApellidoPaterno = ($_POST['CmpPersonalApellidoPaterno']);
	$InsPagoProveedor->PerApellidoMaterno = ($_POST['CmpPersonalApellidoMaterno']);
	$InsPagoProveedor->PerNumeroDocumento = ($_POST['CmpPersonalNumeroDocumento']);
	$InsPagoProveedor->TdoIdPersonal = ($_POST['CmpPersonalTipoDocumento']);
	
	$InsPagoProveedor->CliNombre = ($_POST['CmpClienteNombre']);
	$InsPagoProveedor->CliApellidoPaterno = ($_POST['CmpClienteApellidoPaterno']);
	$InsPagoProveedor->CliApellidoMaterno = ($_POST['CmpClienteApellidoMaterno']);
	$InsPagoProveedor->CliNumeroDocumento = ($_POST['CmpClienteNumeroDocumento']);
	$InsPagoProveedor->TdoIdCliente = ($_POST['CmpClienteTipoDocumento']);
	
	$InsPagoProveedor->PrvNombre = ($_POST['CmpProveedorNombre']);
	$InsPagoProveedor->PrvApellidoPaterno = ($_POST['CmpProveedorApellidoPaterno']);
	$InsPagoProveedor->PrvApellidoMaterno = ($_POST['CmpProbeedorApellidoMaterno']);
	$InsPagoProveedor->PrvNumeroDocumento = ($_POST['CmpProveedorNumeroDocumento']);
	$InsPagoProveedor->TdoIdPersonal = ($_POST['CmpProveedorTipoDocumento']);
	
	$InsPagoProveedor->PovNotificar = $_POST['CmpNotificar'];
	
	if($InsPagoProveedor->MonId<>$EmpresaMonedaId){
		if(empty($InsPagoProveedor->PovTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_DES_600';
		}
	}
	
	if(empty($InsPagoProveedor->PerId) and empty($InsPagoProveedor->PrvId) and empty($InsPagoProveedor->CliId)){
		
	}
	
	if($InsPagoProveedor->MonId<>$EmpresaMonedaId ){
		$InsPagoProveedor->PovMonto = $InsPagoProveedor->PovMonto * $InsPagoProveedor->PovTipoCambio;
	}
/*
SesionObjeto-PagoProveedorComprobanteListado
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
	$ResPagoProveedorComprobante = $_SESSION['InsPagoProveedorComprobante'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrPagoProveedorComprobantes = $ResPagoProveedorComprobante['Datos'];
	
	$item = 1;
	foreach($ArrPagoProveedorComprobantes as $DatSesionObjeto){
			
		$InsPagoProveedorComprobante1 = new ClsPagoProveedorComprobante();
		
		$InsPagoProveedorComprobante1->DcoId = $DatSesionObjeto->Parametro1;
		$InsPagoProveedorComprobante1->AmoId = $DatSesionObjeto->Parametro3;
		
		$InsPagoProveedorComprobante1->DcoEstado = $DatSesionObjeto->Parametro14;
		$InsPagoProveedorComprobante1->DcoTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro15);
		$InsPagoProveedorComprobante1->DcoTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro16);
		$InsPagoProveedorComprobante1->DcoEliminado = $DatSesionObjeto->Eliminado;
		$InsPagoProveedorComprobante1->InsMysql = NULL;
	
		if($InsPagoProveedorComprobante1->DcoEliminado==1){					
			$InsPagoProveedor->PagoProveedorComprobante[] = $InsPagoProveedorComprobante1;	
			$InsPagoProveedor->VdiTotalBruto += $InsPagoProveedorComprobante1->AmoTotal;
		}
	
		
		$item++;	
	}


	if($InsPagoProveedor->MtdRegistrarPagoProveedor()){
		
		if($InsPagoProveedor->PovNotificar==1){
				
			//$InsPagoProveedor->MtdNotificarPagoProveedorRegistro($InsPagoProveedor->PovId,"jblanco@cyc.com.pe");
			$InsPagoProveedor->MtdNotificarPagoProveedorRegistro($InsPagoProveedor->PovId,"mluisagodinez@cyc.com.pe,gcanepam@cyc.com.pe,fcanepa@cyc.com.pe,scanepam@cyc.com.pe,gchura@cyc.com.pe,pamapaza@cyc.com.pe,epilco@cyc.com.pe,avillanueva@cyc.com.pe,gparedes@cyc.com.pe,mguillermo@cyc.com.pe,jblanco@cyc.com.pe");
			
		}
		
		FncNuevo();
		$Registro = true;
		$Resultado.='#SAS_DES_101';		
		
	} else{
		$InsPagoProveedor->PovFecha = FncCambiaFechaANormal($InsPagoProveedor->PovFecha);
		$Resultado.='#ERR_DES_101';
		
	}

	

}else{
	
	FncNuevo();
	
}

function FncNuevo(){

	global $InsPagoProveedor;	
	
	$InsPagoProveedor = new ClsPagoProveedor();
	
	$InsPagoProveedor->PovFecha = date("d/m/Y");
	$InsPagoProveedor->MonId = "MON-10000";
	$InsPagoProveedor->PovEstado = 3;
	$InsPagoProveedor->PovTipoDestino = 1;
	
}
?>