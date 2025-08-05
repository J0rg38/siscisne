<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	

	$InsNotaCredito->NcrId = $_POST['CmpId'];
	$InsNotaCredito->NNcrId = $_POST['CmpNId'];	
	
	$InsNotaCredito->NctId = $_POST['CmpTalonario'];	
	$InsNotaCredito->CliId = $_POST['CmpClienteId'];

	$InsNotaCredito->UsuId = $_SESSION['SesionId'];
	$InsNotaCredito->SucId = $_SESSION['SesionSucursal'];
			
	$InsNotaCredito->DocId = $_POST['CmpDocumentoId'];
	$InsNotaCredito->DtaId = $_POST['CmpDocumentoTalonario'];
	$InsNotaCredito->DtaNumero = $_POST['CmpDocumentoTalonarioNumero'];
	$InsNotaCredito->NcrPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	
	$InsNotaCredito->NcrTipo = $_POST['CmpTipo'];	
	$InsNotaCredito->NcrEstado = $_POST['CmpEstado'];
				
	$InsNotaCredito->NcrFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	$InsNotaCredito->NcrObservacion = addslashes($_POST['CmpObservacion'])."###".addslashes($_POST['CmpObservacionImpresa']);
	$InsNotaCredito->NcrMotivo = $_POST['CmpMotivo'];
	
	$InsNotaCredito->NcrCierre = $_POST['CmpCierre'];
	$InsNotaCredito->NcrTiempoModificacion = date("Y-m-d H:i:s");
	$InsNotaCredito->NcrEliminado = 1;
	
	$InsNotaCredito->CliNombre = $_POST['CmpClienteNombre'];
	$InsNotaCredito->TdoId = $_POST['CmpTipoDocumento'];
	$InsNotaCredito->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	//$InsNotaCredito->CliDireccion = $_POST['CmpClienteDireccion'];
	$InsNotaCredito->NcrDireccion = $_POST['CmpClienteDireccion'];
	$InsNotaCredito->CliTelefono = $_POST['CmpClienteTelefono'];	
	$InsNotaCredito->CliEmail = $_POST['CmpClienteEmail'];
	$InsNotaCredito->CliCelular = $_POST['CmpClienteCelular'];
	$InsNotaCredito->CliFax = $_POST['CmpClienteFax'];
	
	if($InsNotaCredito->MtdEditarIdNotaCredito()){
		$Edito = true;		
		$Resultado.='#SAS_NCR_601';
		$GET_id = $InsNotaCredito->NNcrId;
		FncCargarDatos();
		
	}else{
		$Resultado.='#ERR_NCR_601';
		$InsNotaCredito->NcrFechaEmision = FncCambiaFechaANormal($InsNotaCredito->NcrFechaEmision);
		$InsNotaCredito->NcrOrdenFecha = FncCambiaFechaANormal($InsNotaCredito->NcrOrdenFecha,true);
		list($InsNotaCredito->NcrObservacion,$InsNotaCredito->NcrObservacionImpresa) = explode("###",$InsNotaCredito->NcrObservacion);
	}
	

}else{
	FncCargarDatos();
}


function FncCargarDatos(){
	
	global $GET_id;
	global $GET_ta;
	global $Identificador;	
	global $InsNotaCredito;
		
	unset($_SESSION['InsNotaCreditoDetalle'.$Identificador]);	
	unset($_SESSION['InsNotaCreditoVenta'.$Identificador]);
		
	$_SESSION['InsNotaCreditoDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsNotaCreditoVenta'.$Identificador] = new ClsSesionObjeto();
	
	$InsNotaCredito->NcrId = $GET_id;
	$InsNotaCredito->NctId = $GET_ta;
	$InsNotaCredito = $InsNotaCredito->MtdObtenerNotaCredito();		
	
	if(is_array($InsNotaCredito->NotaCreditoDetalle)){
		foreach($InsNotaCredito->NotaCreditoDetalle as $DatNotaCreditoDetalle){
			
/*
SesionObjeto-NotaCreditoDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro5 = Cantidad
Parametro6 = Importe
Parametro7 = TiempoCreacion
Parametro8 = TiempoModificacion
Parametro9 = VdeId
Parametro10 = VenId
Parametro11 = VtaNumero;
*/
			$_SESSION['InsNotaCreditoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,$DatNotaCreditoDetalle->FdeId,$DatNotaCreditoDetalle->FdeDescripcion,NULL,$DatNotaCreditoDetalle->FdePrecio,$DatNotaCreditoDetalle->FdeCantidad,$DatNotaCreditoDetalle->FdeImporte,($DatNotaCreditoDetalle->FdeTiempoCreacion),($DatNotaCreditoDetalle->FdeTiempoModificacion),$DatNotaCreditoDetalle->VdeId,$DatNotaCreditoDetalle->VenId,$DatNotaCreditoDetalle->VtaNumero);
		
		}
	}
	
	
	if(is_array($InsNotaCredito->NotaCreditoVenta)){
		foreach($InsNotaCredito->NotaCreditoVenta as $DatNotaCreditoVenta){
			
/*
SesionObjeto-NotaCreditoVentaListado
Parametro1 = FveId
Parametro2 = VtaIdVenId
Parametro3 = VenId
Parametro4 = VtaId
Parametro5 = VtaNumero

*/
			
$_SESSION['InsNotaCreditoVenta'.$Identificador]->MtdAgregarSesionObjeto(1,$DatNotaCreditoVenta->FveId,$DatNotaCreditoVenta->VtaId."%".$DatNotaCreditoVenta->VenId,$DatNotaCreditoVenta->VenId,$DatNotaCreditoVenta->VtaId,$DatNotaCreditoVenta->VtaNumero);
		
		}
	}
	

}

?>