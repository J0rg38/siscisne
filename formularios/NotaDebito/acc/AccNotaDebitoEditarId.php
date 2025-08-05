<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	

	$InsNotaDebito->NdbId = $_POST['CmpId'];
	$InsNotaDebito->NNdbId = $_POST['CmpNId'];	
	
	$InsNotaDebito->NdtId = $_POST['CmpTalonario'];	
	$InsNotaDebito->CliId = $_POST['CmpClienteId'];

	$InsNotaDebito->UsuId = $_SESSION['SesionId'];
	$InsNotaDebito->SucId = $_SESSION['SesionSucursal'];
			
	$InsNotaDebito->DocId = $_POST['CmpDocumentoId'];
	$InsNotaDebito->DtaId = $_POST['CmpDocumentoTalonario'];
	$InsNotaDebito->DtaNumero = $_POST['CmpDocumentoTalonarioNumero'];
	$InsNotaDebito->NdbPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	
	$InsNotaDebito->NdbTipo = $_POST['CmpTipo'];	
	$InsNotaDebito->NdbEstado = $_POST['CmpEstado'];
				
	$InsNotaDebito->NdbFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	$InsNotaDebito->NdbObservacion = addslashes($_POST['CmpObservacion'])."###".addslashes($_POST['CmpObservacionImpresa']);
	$InsNotaDebito->NdbMotivo = $_POST['CmpMotivo'];
	
	$InsNotaDebito->NdbCierre = $_POST['CmpCierre'];
	$InsNotaDebito->NdbTiempoModificacion = date("Y-m-d H:i:s");
	$InsNotaDebito->NdbEliminado = 1;
	
	$InsNotaDebito->CliNombre = $_POST['CmpClienteNombre'];
	$InsNotaDebito->TdoId = $_POST['CmpTipoDocumento'];
	$InsNotaDebito->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	//$InsNotaDebito->CliDireccion = $_POST['CmpClienteDireccion'];
	$InsNotaDebito->NdbDireccion = $_POST['CmpClienteDireccion'];
	$InsNotaDebito->CliTelefono = $_POST['CmpClienteTelefono'];	
	$InsNotaDebito->CliEmail = $_POST['CmpClienteEmail'];
	$InsNotaDebito->CliCelular = $_POST['CmpClienteCelular'];
	$InsNotaDebito->CliFax = $_POST['CmpClienteFax'];
	
	if($InsNotaDebito->MtdEditarIdNotaDebito()){
		$Edito = true;		
		$Resultado.='#SAS_NDB_601';
		$GET_id = $InsNotaDebito->NNdbId;
		FncCargarDatos();
		
	}else{
		$Resultado.='#ERR_NDB_601';
		$InsNotaDebito->NdbFechaEmision = FncCambiaFechaANormal($InsNotaDebito->NdbFechaEmision);
		$InsNotaDebito->NdbOrdenFecha = FncCambiaFechaANormal($InsNotaDebito->NdbOrdenFecha,true);
		list($InsNotaDebito->NdbObservacion,$InsNotaDebito->NdbObservacionImpresa) = explode("###",$InsNotaDebito->NdbObservacion);
	}
	

}else{
	FncCargarDatos();
}


function FncCargarDatos(){
	
	global $GET_id;
	global $GET_ta;
	global $Identificador;	
	global $InsNotaDebito;
		
	unset($_SESSION['InsNotaDebitoDetalle'.$Identificador]);	
	unset($_SESSION['InsNotaDebitoVenta'.$Identificador]);
		
	$_SESSION['InsNotaDebitoDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsNotaDebitoVenta'.$Identificador] = new ClsSesionObjeto();
	
	$InsNotaDebito->NdbId = $GET_id;
	$InsNotaDebito->NdtId = $GET_ta;
	$InsNotaDebito = $InsNotaDebito->MtdObtenerNotaDebito();		
	
	if(is_array($InsNotaDebito->NotaDebitoDetalle)){
		foreach($InsNotaDebito->NotaDebitoDetalle as $DatNotaDebitoDetalle){
			
/*
SesionObjeto-NotaDebitoDetalleListado
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
			$_SESSION['InsNotaDebitoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,$DatNotaDebitoDetalle->FdeId,$DatNotaDebitoDetalle->FdeDescripcion,NULL,$DatNotaDebitoDetalle->FdePrecio,$DatNotaDebitoDetalle->FdeCantidad,$DatNotaDebitoDetalle->FdeImporte,($DatNotaDebitoDetalle->FdeTiempoCreacion),($DatNotaDebitoDetalle->FdeTiempoModificacion),$DatNotaDebitoDetalle->VdeId,$DatNotaDebitoDetalle->VenId,$DatNotaDebitoDetalle->VtaNumero);
		
		}
	}
	
	
	if(is_array($InsNotaDebito->NotaDebitoVenta)){
		foreach($InsNotaDebito->NotaDebitoVenta as $DatNotaDebitoVenta){
			
/*
SesionObjeto-NotaDebitoVentaListado
Parametro1 = FveId
Parametro2 = VtaIdVenId
Parametro3 = VenId
Parametro4 = VtaId
Parametro5 = VtaNumero

*/
			
$_SESSION['InsNotaDebitoVenta'.$Identificador]->MtdAgregarSesionObjeto(1,$DatNotaDebitoVenta->FveId,$DatNotaDebitoVenta->VtaId."%".$DatNotaDebitoVenta->VenId,$DatNotaDebitoVenta->VenId,$DatNotaDebitoVenta->VtaId,$DatNotaDebitoVenta->VtaNumero);
		
		}
	}
	

}

?>