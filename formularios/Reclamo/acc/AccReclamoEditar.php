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

	$ResReclamoDetalle = $_SESSION['InsReclamoDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);


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
			$InsReclamoDetalle1->RdeTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro10);
			$InsReclamoDetalle1->RdeTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro11);
			$InsReclamoDetalle1->RdeEliminado = $DatSesionObjeto->Eliminado;	

			$InsReclamoDetalle1->InsMysql = NULL;
			
			$InsReclamo->ReclamoDetalle[] = $InsReclamoDetalle1;
			
			if($InsReclamoDetalle1->RdeEliminado==1){		
				$InsReclamo->RecTotal += $InsReclamoDetalle1->RdeMonto;	
			}

		}

	}

	
	$ResReclamoFoto = $_SESSION['InsReclamoFoto'.$Identificador]->MtdObtenerSesionObjetos(false);

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
		if($InsReclamo->MtdEditarReclamo()){

			$Edito = true;
			$Resultado.='#SAS_REC_102';
			
		}else{
			$Resultado.='#ERR_REC_102';
		}
	}	
	
	$InsReclamo->RecFechaEmision = FncCambiaFechaANormal($InsReclamo->RecFechaEmision);	
	$InsReclamo->RecRespuestaFecha = FncCambiaFechaANormal($InsReclamo->RecRespuestaFecha,true);						

}else{

	FncCargarDatos();
}


function FncCargarDatos(){

	global $InsReclamo;
	global $Identificador;
	global $EmpresaMonedaId;
	global $GET_Id;

	unset($_SESSION['InsReclamoFoto'.$Identificador]);
	unset($_SESSION['InsReclamoDetalle'.$Identificador]);
			
	$_SESSION['InsReclamoFoto'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsReclamoDetalle'.$Identificador] = new ClsSesionObjeto();	

	$InsReclamo->RecId = $GET_Id;
	$InsReclamo->MtdObtenerReclamo();
	
			//SesionObjeto-InsReclamoFoto
			//Parametro1 = RfoId
			//Parametro2 = RecId
			//Parametro3 = RfoArchivo
			//Parametro4 = RfoComentario
			//Parametro5 = RfoEstado
			//Parametro6 = RfoTiempoCreacion
			//Parametro7 = RfoTiempoModificacion
		
	if(!empty($InsReclamo->ReclamoFoto)){
		foreach($InsReclamo->ReclamoFoto as $DatReclamoFoto){					
		
			$_SESSION['InsReclamoFoto'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatReclamoFoto->RfoId,
			$DatReclamoFoto->RecId,
			$DatReclamoFoto->RfoArchivo,	
			$DatReclamoFoto->RfoComentario,
			$DatReclamoFoto->RfoEstado,
			($DatReclamoFoto->RfoTiempoCreacion),
			($DatReclamoFoto->RfoTiempoModificacion)
			);
			
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

	if(!empty($InsReclamo->ReclamoDetalle)){
		foreach($InsReclamo->ReclamoDetalle as $DatReclamoDetalle){					

			if($InsReclamo->MonId<>$EmpresaMonedaId  ){
				$DatReclamoDetalle->RdePrecioUnitario = round($DatReclamoDetalle->RdePrecioUnitario / $InsReclamo->RecTipoCambio,2);
				$DatReclamoDetalle->RdeMonto = round($DatReclamoDetalle->RdeMonto  / $InsReclamo->RecTipoCambio,2);
				
			}
			
			$_SESSION['InsReclamoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatReclamoDetalle->RdeId,
			$DatReclamoDetalle->ProId,
			$DatReclamoDetalle->UmeId,
			$DatReclamoDetalle->ProCodigoOriginal,	
			$DatReclamoDetalle->ProNombre,
			$DatReclamoDetalle->AmoComprobanteNumero,
			$DatReclamoDetalle->RdeEstado,
			$DatReclamoDetalle->AmdId,
			($DatReclamoDetalle->AmoComprobanteFecha),
			($DatReclamoDetalle->OcoTipo),
			($DatReclamoDetalle->AmdCantidad),
			($DatReclamoDetalle->RdeCantidad),
			($DatReclamoDetalle->RdePrecioUnitario),
			($DatReclamoDetalle->RdeMonto),
			($DatReclamoDetalle->RdeObservacion),
						
			($DatReclamoDetalle->RdeTiempoCreacion),
			($DatReclamoDetalle->RdeTiempoModificacion)
			
			);

		}
	}

}

?>

