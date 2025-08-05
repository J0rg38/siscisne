<?php


//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';

	$InsNotaCredito->NcrId = $_POST['CmpId'];
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
	$InsNotaCredito->NcrDireccion = $_POST['CmpClienteDireccion'];
	//$InsNotaCredito->CdiDescripcion = $_POST['CmpClienteDireccion'];
	$InsNotaCredito->CliTelefono = $_POST['CmpClienteTelefono'];
	
	$InsNotaCredito->CliEmail = $_POST['CmpClienteEmail'];
	$InsNotaCredito->CliCelular = $_POST['CmpClienteCelular'];
	$InsNotaCredito->CliFax = $_POST['CmpClienteFax'];

	$InsNotaCredito->NotaCreditoDetalle = array();	
	

/*

SesionObjeto-NotaCreditoDetalleListado
Parametro1 = NcdId
Parametro2 = NcdDescripcion
Parametro5 = Cantidad
Parametro6 = Importe
Parametro7 = TiempoCreacion
Parametro8 = TiempoModificacion
*/


$InsNotaCredito->NcrTotalBruto = 0;
$InsNotaCredito->NcrSubTotal = 0;
$InsNotaCredito->NcrImpuesto = 0;
$InsNotaCredito->NcrTotal = 0;

$ResNotaCreditoDetalle = $_SESSION['InsNotaCreditoDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);


	if(is_array($ResNotaCreditoDetalle['Datos'])){
	
		foreach($ResNotaCreditoDetalle['Datos'] as $DatSesionObjeto){
				
			$InsNotaCreditoDetalle1 = new ClsNotaCreditoDetalle();
			$InsNotaCreditoDetalle1->NcdId = $DatSesionObjeto->Parametro1;
			$InsNotaCreditoDetalle1->NcdDescripcion = $DatSesionObjeto->Parametro2;
			$InsNotaCreditoDetalle1->NcdCantidad = $DatSesionObjeto->Parametro5;
			$InsNotaCreditoDetalle1->NcdImporte = $DatSesionObjeto->Parametro6;
			$InsNotaCreditoDetalle1->NcdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsNotaCreditoDetalle1->NcdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsNotaCreditoDetalle1->NcdEliminado = $DatSesionObjeto->Eliminado;				
			$InsNotaCreditoDetalle1->InsMysql = NULL;
			
			$InsNotaCredito->NotaCreditoDetalle[] = $InsNotaCreditoDetalle1;	
			
			if($InsNotaCreditoDetalle1->NcdEliminado==1){		
				$InsNotaCredito->NcrTotalBruto += $InsNotaCreditoDetalle1->NcdImporte;
				
			}
						
		}	
		

	}
	
	

	$InsNotaCredito->NcrTotal = $InsNotaCredito->NcrTotalBruto;
	$InsNotaCredito->NcrSubTotal = round(($InsNotaCredito->NcrTotal/(($InsNotaCredito->NcrPorcentajeImpuestoVenta/100)+1)),2);
	$InsNotaCredito->NcrImpuesto = $InsNotaCredito->NcrTotal - $InsNotaCredito->NcrSubTotal;

	if($InsNotaCredito->MtdEditarNotaCredito()){
		$Edito = true;		
		$Resultado.='#SAS_NCR_102';
		FncCargarDatos();
	} else{
		$Resultado.='#ERR_NCR_102';
		$InsNotaCredito->NcrFechaEmision = FncCambiaFechaANormal($InsNotaCredito->NcrFechaEmision);
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
			
	$_SESSION['InsNotaCreditoDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsNotaCredito->NcrId = $GET_id;
	$InsNotaCredito->NctId = $GET_ta;
	$InsNotaCredito = $InsNotaCredito->MtdObtenerNotaCredito();		
	
	if(is_array($InsNotaCredito->NotaCreditoDetalle)){
		foreach($InsNotaCredito->NotaCreditoDetalle as $DatNotaCreditoDetalle){
			
/*
SesionObjeto-NotaCreditoDetalleListado
Parametro1 = NcdId
Parametro2 = NcdDescripcion
Parametro5 = Cantidad
Parametro6 = Importe
Parametro7 = TiempoCreacion
Parametro8 = TiempoModificacion
Parametro9 = VdeId
Parametro10 = VenId
Parametro11 = VtaId;
Parametro12 = NcdTipo
*/

			$_SESSION['InsNotaCreditoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,$DatNotaCreditoDetalle->NcdId,$DatNotaCreditoDetalle->NcdDescripcion,NULL,$DatNotaCreditoDetalle->NcdPrecio,$DatNotaCreditoDetalle->NcdCantidad,$DatNotaCreditoDetalle->NcdImporte,($DatNotaCreditoDetalle->NcdTiempoCreacion),($DatNotaCreditoDetalle->NcdTiempoModificacion),$DatNotaCreditoDetalle->OdeId,$DatNotaCreditoDetalle->OriId,$DatNotaCreditoDetalle->OtaNumero,$DatNotaCreditoDetalle->NcdTipo);
		
		}
	}

}

?>