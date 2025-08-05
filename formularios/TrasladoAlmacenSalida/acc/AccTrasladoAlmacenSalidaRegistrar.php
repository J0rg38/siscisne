<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){		
	
	$Resultado = '';
	$Guardar = true;
	
	$InsTrasladoAlmacenSalida->UsuId = $_SESSION['SesionId'];	
	
	$InsTrasladoAlmacenSalida->TasId = $_POST['CmpId'];
	$InsTrasladoAlmacenSalida->LtiId = $_POST['CmpClienteTipo'];
	$InsTrasladoAlmacenSalida->CliId = $_POST['CmpClienteId'];
	
	$InsTrasladoAlmacenSalida->TopId = $_POST['CmpTipoOperacion'];
	$InsTrasladoAlmacenSalida->AlmId = $_POST['CmpAlmacen'];
	$InsTrasladoAlmacenSalida->AlmIdDestino = $_POST['CmpAlmacenDestino'];
	
	$InsTrasladoAlmacenSalida->MonId = $EmpresaMonedaId;
	$InsTrasladoAlmacenSalida->PerId = $_POST['CmpPersonal'];
		
	$InsTrasladoAlmacenSalida->TasFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsTrasladoAlmacenSalida->TasObservacion = addslashes($_POST['CmpObservacion']);	

	$InsTrasladoAlmacenSalida->TasEmpresaTransporte = $_POST['CmpEmpresaTransporte'];
	$InsTrasladoAlmacenSalida->TasEmpresaTransporteDocumento = $_POST['CmpEmpresaTransporteDocumento'];
	$InsTrasladoAlmacenSalida->TasEmpresaTransporteClave = $_POST['CmpEmpresaTransporteClave'];
	$InsTrasladoAlmacenSalida->TasEmpresaTransporteFecha = FncCambiaFechaAMysql($_POST['CmpEmpresaTransporteFecha'],true);
	$InsTrasladoAlmacenSalida->TasEmpresaTransporteTipoEnvio = $_POST['CmpEmpresaTransporteTipoEnvio'];
	$InsTrasladoAlmacenSalida->TasEmpresaTransporteDestino = $_POST['CmpEmpresaTransporteDestino'];
	
	$InsTrasladoAlmacenSalida->TasSubTipo = 8;
	$InsTrasladoAlmacenSalida->TasEstado = $_POST['CmpEstado'];
	$InsTrasladoAlmacenSalida->TasTiempoCreacion = date("Y-m-d H:i:s");
	$InsTrasladoAlmacenSalida->TasTiempoModificacion = date("Y-m-d H:i:s");	

	$InsTrasladoAlmacenSalida->TrasladoAlmacenSalidaDetalle = array();

	if(empty($InsTrasladoAlmacenSalida->AlmId)){
		$Guardar = false;
		$Resultado.='#ERR_TAS_112';
	}
	
//	SesionObjeto-TrasladoAlmacenSalidaDetalle
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecio
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro17 = AmdCosto
//	Parametro18 = AmdCantidadRealAnterior
//	Parametro19 = AmdEstado
	
	$ResTrasladoAlmacenSalidaDetalle = $_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResTrasladoAlmacenSalidaDetalle['Datos'])){
		$item = 1;
		foreach($ResTrasladoAlmacenSalidaDetalle['Datos'] as $DatSesionObjeto){
				
			$InsTrasladoAlmacenSalidaDetalle1 = new ClsTrasladoAlmacenSalidaDetalle();
			$InsTrasladoAlmacenSalidaDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsTrasladoAlmacenSalidaDetalle1->UmeId = $DatSesionObjeto->Parametro10;
		
			$InsTrasladoAlmacenSalidaDetalle1->TsdCantidad = $DatSesionObjeto->Parametro5;
			$InsTrasladoAlmacenSalidaDetalle1->TsdCantidadReal = $DatSesionObjeto->Parametro12;
			$InsTrasladoAlmacenSalidaDetalle1->TsdCantidadRealAnterior = $DatSesionObjeto->Parametro18;
		
			$InsTrasladoAlmacenSalidaDetalle1->TsdEstado = $DatSesionObjeto->Parametro19;
			$InsTrasladoAlmacenSalidaDetalle1->TsdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsTrasladoAlmacenSalidaDetalle1->TsdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);			

			$InsTrasladoAlmacenSalidaDetalle1->TsdEliminado = $DatSesionObjeto->Eliminado;				
			$InsTrasladoAlmacenSalidaDetalle1->InsMysql = NULL;

			if($InsTrasladoAlmacenSalidaDetalle1->TsdEliminado==1){	
			
				$InsTrasladoAlmacenSalida->TrasladoAlmacenSalidaDetalle[] = $InsTrasladoAlmacenSalidaDetalle1;				
					
			}

			$item++;	
		}

	}else{
		$Guardar = false;
		$Resultado.='#ERR_TAS_111';
	}
	
	if($Guardar){
		if($InsTrasladoAlmacenSalida->MtdRegistrarTrasladoAlmacenSalida()){
			
			FncNuevo();
			$Registro = true;
			$Resultado.='#SAS_TAS_101';
			
		} else{
			
			$InsTrasladoAlmacenSalida->TasFecha = FncCambiaFechaANormal($InsTrasladoAlmacenSalida->TasFecha);
			$Resultado.='#ERR_TAS_101';
		}		
	}else{
		
		$InsTrasladoAlmacenSalida->TasFecha = FncCambiaFechaANormal($InsTrasladoAlmacenSalida->TasFecha);
			
	}

	
}else{

	FncNuevo();

}

function FncNuevo(){
	
	global $InsTrasladoAlmacenSalida;
	global $InsCliente;
	global $Identificador;
	global $EmpresaImpuestoVenta;
	
	
	unset($_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador]);
		
	$_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsTrasladoAlmacenSalida = new ClsTrasladoAlmacenSalida();
	$InsTrasladoAlmacenSalida->LtiId = "LTI-10015";
	$InsTrasladoAlmacenSalida->TasPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsTrasladoAlmacenSalida->TasIncluyeImpuesto = 1;
	
	$InsTrasladoAlmacenSalida->TopId = "TOP-10010";
	$InsTrasladoAlmacenSalida->TasEstado = 3;
	$InsTrasladoAlmacenSalida->AlmId = "ALM-10000";
	
	
	$InsCliente = new ClsCliente();
	//MtdObtenerClientes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CliId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL)
	$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"CYC");
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
		
			$InsTrasladoAlmacenSalida->CliId = $DatCliente->CliId;
			
		}
	}
			
	
}

?>