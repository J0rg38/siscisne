 <?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){		
	
	$Resultado = '';
	$Guardar = true;
	
	$InsSolicitudDesembolso->UsuId = $_SESSION['SesionId'];	
	
	$InsSolicitudDesembolso->SdsId = $_POST['CmpId'];
	$InsSolicitudDesembolso->SucId = $_SESSION['SesionSucursal'];
	$InsSolicitudDesembolso->PerId = $_POST['CmpPersonal'];
	$InsSolicitudDesembolso->AreId = $_POST['CmpArea'];
	$InsSolicitudDesembolso->FinId = $_POST['CmpFichaIngreso'];
	$InsSolicitudDesembolso->TgaId = $_POST['CmpTipoGasto'];
	
	$InsSolicitudDesembolso->SdsFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	list($InsSolicitudDesembolso->SdsAno,$Mes,$Dia) = explode("-",$InsSolicitudDesembolso->SdsFecha);

	$InsSolicitudDesembolso->SdsVIN = $_POST['CmpVIN'];
	$InsSolicitudDesembolso->SdsPlaca = $_POST['CmpPlaca'];
	$InsSolicitudDesembolso->SdsCliente = $_POST['CmpCliente'];
	
	$InsSolicitudDesembolso->MonId = $_POST['CmpMonedaId'];
	$InsSolicitudDesembolso->SdsTipoCambio = $_POST['CmpTipoCambio'];
	$InsSolicitudDesembolso->SdsGastoAsumido = $_POST['CmpGastoAsumido'];
	
	$InsSolicitudDesembolso->SdsAsunto = addslashes($_POST['CmpAsunto']);
	$InsSolicitudDesembolso->SdsDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsSolicitudDesembolso->SdsMonto = eregi_replace(",","",(empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
	
	$InsSolicitudDesembolso->SdsObservacion = addslashes($_POST['CmpObservacion']);
	$InsSolicitudDesembolso->SdsObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsSolicitudDesembolso->SdsObservacionCorreo = addslashes($_POST['CmpObservacionCorreo']);
	$InsSolicitudDesembolso->SdsAprobado = 2;
	
	$InsSolicitudDesembolso->SdsEstado = $_POST['CmpEstado'];
	$InsSolicitudDesembolso->SdsTiempoCreacion = date("Y-m-d H:i:s");
	$InsSolicitudDesembolso->SdsTiempoModificacion = date("Y-m-d H:i:s");

	if($InsSolicitudDesembolso->MonId<>$EmpresaMonedaId){
		if(empty($InsSolicitudDesembolso->SdsTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_SDS_600';
		}
	}
	
//	SesionObjeto-SolicitudDesembolsoDetalle
//	Parametro1 = SddId
//	Parametro2 = SdsId
//	Parametro3 = SreId
//	Parametro4 = SddDescripcion
//	Parametro5 = SddCantidad
//	Parametro6 = SddImporte
//	Parametro7 = SddTiempoCreacion
//	Parametro8 = SddTiempoModificacion
//	Parametro9 = SddEstado
//	Parametro10 = SreNombre
//	

	$ResSolicitudDesembolsoDetalle = $_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResSolicitudDesembolsoDetalle['Datos'])){
		$item = 1;
		foreach($ResSolicitudDesembolsoDetalle['Datos'] as $DatSesionObjeto){
				
			if($InsSolicitudDesembolso->MonId<>$EmpresaMonedaId){
				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsSolicitudDesembolso->SdeTipoCambio;
			}
			
			$InsSolicitudDesembolsoDetalle1 = new ClsSolicitudDesembolsoDetalle();
			
			$InsSolicitudDesembolsoDetalle1->SreId = $DatSesionObjeto->Parametro3;
			
			$InsSolicitudDesembolsoDetalle1->SddCantidad = $DatSesionObjeto->Parametro5;
			$InsSolicitudDesembolsoDetalle1->SddImporte = $DatSesionObjeto->Parametro6;
			
			$InsSolicitudDesembolsoDetalle1->SddEstado = $DatSesionObjeto->Parametro9;
			$InsSolicitudDesembolsoDetalle1->SddTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsSolicitudDesembolsoDetalle1->SddTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsSolicitudDesembolsoDetalle1->SddEliminado = $DatSesionObjeto->Eliminado;				
			$InsSolicitudDesembolsoDetalle1->InsMysql = NULL;

			if($InsSolicitudDesembolsoDetalle1->SddEliminado==1){	
				
				$InsSolicitudDesembolso->SdsTotal += $InsSolicitudDesembolsoDetalle1->SddImporte;	
				$InsSolicitudDesembolso->SolicitudDesembolsoDetalle[] = $InsSolicitudDesembolsoDetalle1;				
					
			}

			$item++;	
		}

	}else{
		$Guardar = false;
		$Resultado.='#ERR_SDS_111';
	}
	
	$InsSolicitudDesembolso->SdsMonto = $InsSolicitudDesembolso->SdsTotal;
	
	if( $InsSolicitudDesembolso->MonId<>$EmpresaMonedaId ){
		$InsSolicitudDesembolso->SdsMonto = $InsSolicitudDesembolso->SdsMonto * $InsSolicitudDesembolso->SdsTipoCambio;
	}else{
		$InsSolicitudDesembolso->SdsMonto = $InsSolicitudDesembolso->SdsMonto;
	}
	
	if($Guardar){

		if($InsSolicitudDesembolso->MtdRegistrarSolicitudDesembolso()){
			
			unset($InsSolicitudDesembolso);
			FncNuevo();

			$Registro = true;
			$Resultado.='#SAS_SDS_101';

		}else{
			
			$InsSolicitudDesembolso->SdsFecha = FncCambiaFechaANormal($InsSolicitudDesembolso->SdsFecha);
			$Resultado.='#ERR_SDS_101';
			
			if($InsSolicitudDesembolso->MonId<>$EmpresaMonedaId ){
				$InsSolicitudDesembolso->SdsMonto = round($InsSolicitudDesembolso->SdsMonto / $InsSolicitudDesembolso->SdsTipoCambio,3);
			}

		}		

	}else{

		$InsSolicitudDesembolso->SdsFecha = FncCambiaFechaANormal($InsSolicitudDesembolso->SdsFecha);	
		
		if($InsSolicitudDesembolso->MonId<>$EmpresaMonedaId ){
				$InsSolicitudDesembolso->SdsMonto = round($InsSolicitudDesembolso->SdsMonto / $InsSolicitudDesembolso->SdsTipoCambio,3);
		}

	}

}else{
	
	FncNuevo();
	
}


function FncNuevo(){
	
	global $Identificador;
	global $InsSolicitudDesembolso;
	global $InsTipoCambio;
	global $EmpresaImpuestoVenta;
	global $EmpresaMonedaId;
	
	global $GET_Origen;
	global $GET_FinId;

	unset($_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador]);
		
	$_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsSolicitudDesembolso = new ClsSolicitudDesembolso();
	$InsSolicitudDesembolso->SdsEstado = 3;
	$InsSolicitudDesembolso->MonId = $EmpresaMonedaId;
	$InsSolicitudDesembolso->SdsFecha = date("d/m/Y");
	$InsSolicitudDesembolso->PerId = $_SESSION['SesionId'];
	$InsSolicitudDesembolso->SdsGastoAsumido = "INTERNO";
	$InsSolicitudDesembolso->SucId = $_SESSION['SesionSucursal'];
	
	if($InsSolicitudDesembolso->MonId<>$EmpresaMonedaId ){
		$InsSolicitudDesembolso->SdsMonto = round($InsSolicitudDesembolso->SdsMonto / $InsSolicitudDesembolso->SdsTipoCambio,3);
	}
			
	//$InsTipoCambio = new ClsTipoCambio();
//	$InsTipoCambio->MonId = "MON-10001";
//	$InsTipoCambio->TcaFecha = date("Y-m-d");
//	
//	$InsTipoCambio->MtdObtenerTipoCambioActual();
//	
//	if(empty($InsTipoCambio->TcaId)){
//		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
//	}
//		
//	$InsSolicitudDesembolso->SdsTipoCambio = $InsTipoCambio->TcaMontoCompra;

//deb($GET_Origen);
	switch($GET_Origen){
		
		case "FichaIngreso":
			
			$InsFichaIngreso  = new ClsFichaIngreso();
			$InsFichaIngreso->FinId = $GET_FinId;
			$InsFichaIngreso->MtdObtenerFichaIngreso(false);
			
			$InsSolicitudDesembolso->FinId = $InsFichaIngreso->FinId;
			$InsSolicitudDesembolso->AreId = "ARE-10004";
			$InsSolicitudDesembolso->SdsVIN = $InsFichaIngreso->EinVIN;
			$InsSolicitudDesembolso->SdsPlaca = $InsFichaIngreso->EinPlaca;
			$InsSolicitudDesembolso->SdsCliente = (empty($InsFichaIngreso->CliNombreCompleto)?$InsFichaIngreso->CliNombre." ".$InsFichaIngreso->CliApellidoPaterno." ".$InsFichaIngreso->CliApellidoMaterno:$InsFichaIngreso->CliNombreCompleto);
			
		break;
	}
}
?>