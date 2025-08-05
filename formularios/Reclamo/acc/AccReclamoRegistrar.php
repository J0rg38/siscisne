<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;	

	$InsReclamo->UsuId = $_SESSION['SesionId'];
	
	$InsReclamo->RecId = $_POST['CmpId'];
	$InsReclamo->RecCodigoReclamo = $_POST['CmpCodigoReclamo'];	

	$InsReclamo->PerId = $_POST['CmpPersonal'];
	$InsReclamo->AmoId = $_POST['CmpAlmacenMovimientoEntradaId'];

	$InsReclamo->RecFechaEmision = FncCambiaFechaAMysql($_POST['CmpFecha']);	

	$InsReclamo->PrvId = $_POST['CmpProveedorId'];
	$InsReclamo->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsReclamo->PrvApellidoPaterno = $_POST['CmpProveedorApellidoPaterno'];
	$InsReclamo->PrvApellidoMaterno = $_POST['CmpProveedorApellidoMaterno'];
	
	$InsReclamo->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsReclamo->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsReclamo->RecCliente = $_POST['CmpCliente'];
	$InsReclamo->RecSucursal = $_POST['CmpSucursal'];
	$InsReclamo->RecPais = $_POST['CmpPais'];
	
	$InsReclamo->MonId = $_POST['CmpMonedaId'];
	$InsReclamo->RecTipoCambio = $_POST['CmpTipoCambio'];

	$InsReclamo->RecObservacion = addslashes($_POST['CmpObservacion']);
	$InsReclamo->RecObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);

$InsReclamo->RecRespuestaNumero = ($_POST['CmpRespuestaNumero']);	
	$InsReclamo->RecRespuestaFecha = FncCambiaFechaAMysql($_POST['CmpRespuestaFecha'],true);
	
	$InsReclamo->RecEstado = $_POST['CmpEstado'];
	$InsReclamo->RecTiempoCreacion = date("Y-m-d H:i:s");
	$InsReclamo->RecTiempoModificacion = date("Y-m-d H:i:s");

	$InsReclamo->RecTotal = 0;

	if($InsReclamo->MonId<>$EmpresaMonedaId){
		if(empty($InsReclamo->RecTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_REC_600';
		}
	}			


//SesionObjeto-InsReclamoDetalle
//Parametro1 = RdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = ProCodigoOriginal
//Parametro5 = ProNombre
//Parametro6 = AmoComprobanteNumero
//Parametro7 = RdeEstado
//Parametro8 = AmdId
//Parametro9 = AmoComprobanteFecha
//Parametro10 = OcoTipo	
//Parametro11 = AmdCantidad	
//Parametro12 = RdeCantidad	
//Parametro13 = RdePrecioUnitario
//Parametro14 = RdeMonto
//Parametro15 = RdeObservacion
//Parametro16 = RdeTiempoCreacion
//Parametro17 = RdeTiempoModificacion

	$ResReclamoDetalle = $_SESSION['InsReclamoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResReclamoDetalle['Datos'])){
		foreach($ResReclamoDetalle['Datos'] as $DatSesionObjeto){

			$InsReclamoDetalle1 = new ClsReclamoDetalle();
			$InsReclamoDetalle1->RdeId = $DatSesionObjeto->Parametro1;

			$InsReclamoDetalle1->RdeCantidad = $DatSesionObjeto->Parametro12;
			$InsReclamoDetalle1->RdeObservacion = $DatSesionObjeto->Parametro15;
			$InsReclamoDetalle1->AmdId = $DatSesionObjeto->Parametro8;

			if($InsReclamo->MonId<>$EmpresaMonedaId ){
				$InsReclamoDetalle1->RdePrecioUnitario = $DatSesionObjeto->Parametro13 * $InsReclamo->RecTipoCambio;
			}else{
				$InsReclamoDetalle1->RdePrecioUnitario = $DatSesionObjeto->Parametro13;
			}
			
			if($InsReclamo->MonId<>$EmpresaMonedaId ){
				$InsReclamoDetalle1->RdeMonto = $DatSesionObjeto->Parametro14 * $InsReclamo->RecTipoCambio;
			}else{
				$InsReclamoDetalle1->RdeMonto = $DatSesionObjeto->Parametro14;
			}
			
			$InsReclamoDetalle1->RdeEstado = $DatSesionObjeto->Parametro7;
			$InsReclamoDetalle1->RdeTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro16);
			$InsReclamoDetalle1->RdeTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro17);
			$InsReclamoDetalle1->RdeEliminado = $DatSesionObjeto->Eliminado;				
			$InsReclamoDetalle1->InsMysql = NULL;
			
			if($InsReclamoDetalle1->RdeEliminado == 1){					
				$InsReclamo->ReclamoDetalle[] = $InsReclamoDetalle1;		
				$InsReclamo->RecTotal += $InsReclamoDetalle1->RdeMonto;	
			}


		}

	}



	
	
	$ResReclamoFoto = $_SESSION['InsReclamoFoto'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResReclamoFoto['Datos'])){
		foreach($ResReclamoFoto['Datos'] as $DatSesionObjeto){

			//SesionObjeto-InsReclamoFoto
			//Parametro1 = RfoId
			//Parametro2 = RecId
			//Parametro3 = RfoArchivo
			//Parametro4 = RfoComentario
			//Parametro5 = RfoEstado
			//Parametro6 = RfoTiempoCreacion
			//Parametro7 = RfoTiempoModificacion

			$InsReclamoFoto1 = new ClsReclamoFoto();
			$InsReclamoFoto1->RfoId = $DatSesionObjeto->Parametro1;
			
			$InsReclamoFoto1->RfoArchivo = $DatSesionObjeto->Parametro3;
			$InsReclamoFoto1->RfoComentario = $DatSesionObjeto->Parametro4;

			$InsReclamoFoto1->RfoEstado = $DatSesionObjeto->Parametro5;
			$InsReclamoFoto1->RfoTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			$InsReclamoFoto1->RfoTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsReclamoFoto1->RfoEliminado = $DatSesionObjeto->Eliminado;				
			$InsReclamoFoto1->InsMysql = NULL;
			
			$InsReclamo->ReclamoFoto[] = $InsReclamoFoto1;		
			
		}

	}


	if($Guardar){

		if($InsReclamo->MtdRegistrarReclamo()){
			
			unset($InsReclamo);

			FncNuevo();

			$Registro = true;
			$Resultado.='#SAS_REC_101';

		}else{
			$InsReclamo->RecFechaEmision = FncCambiaFechaANormal($InsReclamo->RecFechaEmision);	
			$InsReclamo->RecRespuestaFecha = FncCambiaFechaANormal($InsReclamo->RecRespuestaFecha,true);					
			$Resultado.='#ERR_REC_101';
		}

	}else{
		
		$InsReclamo->RecFechaEmision = FncCambiaFechaANormal($InsReclamo->RecFechaEmision);	
		$InsReclamo->RecRespuestaFecha = FncCambiaFechaANormal($InsReclamo->RecRespuestaFecha,true);					
		
	}
	
	
}else{

	FncNuevo();

	$InsReclamo->AmoId = $InsAlmacenMovimientoEntrada->AmoId;
	$InsReclamo->RecFechaEmision = date("d/m/Y");
	$InsReclamo->RecCodigoReclamo = "D";	
	$InsReclamo->PrvId = $InsFichaIngreso->PrvId;
	$InsReclamo->PrvNombre = $InsFichaIngreso->PrvNombre;
	$InsReclamo->PrvApellidoPaterno = $InsFichaIngreso->PrvApellidoPaterno;
	$InsReclamo->PrvApellidoMaterno = $InsFichaIngreso->PrvApellidoMaterno;
	$InsReclamo->TdoId = $InsFichaIngreso->TdoId;
	$InsReclamo->PrvNumeroDocumento = $InsFichaIngreso->PrvNumeroDocumento;
	$InsReclamo->RecCliente = $EmpresaNombre;
	$InsReclamo->RecSucursal = $EmpresaDepartamento;
	$InsReclamo->RecPais = $EmpresaPais;
	
	
	
		$InsReclamo->RecObservacion = chr(13).date("d/m/Y H:i:s")." - Reclamo Generada de Mov. Entrada c/ Comprobante.: ".$InsAlmacenMovimientoEntrada->TcoNombre."/".$InsAlmacenMovimientoEntrada->AmoComprobanteNumero;



	$InsProveedor = new ClsProveedor();
	$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,'PrvNombre','ASC','1',NULL,"CYC");
	$ArrProveedores = $ResProveedor['Datos'];
	
	//deb($ArrProveedores);
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){

			$InsReclamo->PrvId = $DatProveedor->PrvId;
			$InsReclamo->PrvNombreCompleto = $DatProveedor->PrvNombreCompleto;
			$InsReclamo->PrvNombre = $DatProveedor->PrvNombre;
			$InsReclamo->PrvApellidoPaterno = $DatProveedor->PrvApellidoPaterno;
			$InsReclamo->PrvApellidoMaterno = $DatProveedor->PrvApellidoMaterno;
			
			$InsReclamo->PrvNumeroDocumento = $DatProveedor->PrvNumeroDocumento;
			$InsReclamo->TdoId = $DatProveedor->TdoId;

		}
	}

//SesionObjeto-InsReclamoDetalle
//Parametro1 = RdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = ProCodigoOriginal
//Parametro5 = ProNombre
//Parametro6 = AmoComprobanteNumero
//Parametro7 = RdeEstado
//Parametro8 = AmdId
//Parametro9 = AmoComprobanteFecha
//Parametro10 = OcoTipo	
//Parametro11 = AmdCantidad	
//Parametro12 = RdeCantidad	
//Parametro13 = RdePrecioUnitario
//Parametro14 = RdeMonto
//Parametro15 = RdeObservacion
//Parametro16 = RdeTiempoCreacion
//Parametro17 = RdeTiempoModificacion
	
	if(!empty($InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle)){
		foreach($InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle as $DatAlmacenMovimientoEntradaDetalle){

			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
				$DatAlmacenMovimientoEntradaDetalle->AmdImporte = round($DatAlmacenMovimientoEntradaDetalle->AmdImporte / $InsAlmacenMovimientoEntrada->AmoTipoCambio,3);
				$DatAlmacenMovimientoEntradaDetalle->AmdCosto = round($DatAlmacenMovimientoEntradaDetalle->AmdCosto  / $InsAlmacenMovimientoEntrada->AmoTipoCambio,3);
			}
			
			$_SESSION['InsReclamoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			$DatAlmacenMovimientoEntradaDetalle->ProId,
			$DatAlmacenMovimientoEntradaDetalle->UmeId,
			$DatAlmacenMovimientoEntradaDetalle->ProCodigoOriginal,	
			$DatAlmacenMovimientoEntradaDetalle->ProNombre,
			$InsAlmacenMovimientoEntrada->AmoComprobanteNumero,
			1,
			$DatAlmacenMovimientoEntradaDetalle->AmdId,
			$InsAlmacenMovimientoEntrada->AmoComprobanteFecha,
			$DatAlmacenMovimientoEntradaDetalle->OcoTipo,
			$DatAlmacenMovimientoEntradaDetalle->AmdCantidad,
			$DatAlmacenMovimientoEntradaDetalle->AmdCantidad,
			$DatAlmacenMovimientoEntradaDetalle->AmdCosto,
			$DatAlmacenMovimientoEntradaDetalle->AmdImporte,
			"Sin observaciones",
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s")
			);
			
		}
	}


}


function FncNuevo(){
	
	global $Identificador;
	global $InsReclamo;
	global $InsTipoCambio;
	
	unset($_SESSION['InsReclamoFoto'.$Identificador]);
	unset($_SESSION['InsReclamoDetalle'.$Identificador]);

	$_SESSION['InsReclamoFoto'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsReclamoDetalle'.$Identificador] = new ClsSesionObjeto();	

	$InsReclamo = new ClsReclamo();
	$InsReclamo->RecFechaEmision = date("d/m/Y");
	
	$InsReclamo->RecEstado = 5;
	$InsReclamo->MonId = "MON-10001";
	$InsReclamo->PerId = $_SESSION['SesionId'];
	
	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = "MON-10001";
	$InsTipoCambio->TcaFecha = date("Y-m-d");

	$InsTipoCambio->MtdObtenerTipoCambioActual();

	if(empty($InsTipoCambio->TcaId)){
		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}
		
	$InsReclamo->RecTipoCambio = $InsTipoCambio->TcaMontoVenta;
	$InsReclamo->RecPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
		
		
}



?>

