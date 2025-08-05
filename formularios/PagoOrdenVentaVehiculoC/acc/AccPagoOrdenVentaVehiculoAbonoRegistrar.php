<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsPago->UsuId = $_SESSION['SesionId'];
	
	$InsPago->PagId = $_POST['CmpId'];
	$InsPago->SucId = $_SESSION['SesionSucursal'];
	$InsPago->PagFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsPago->CliId = $_POST['CmpClienteId'];
	
	$InsPago->AreId = $_POST['CmpAreaId'];
	$InsPago->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	$InsPago->NpaId = $_POST['CmpCondicionPago'];
	$InsPago->FpaId = $_POST['CmpFormaPago'];
	$InsPago->CueId = $_POST['CmpCuenta'];
	$InsPago->TarId = $_POST['CmpTarjeta'];
	
	$InsPago->PagNumeroTransaccion = $_POST['CmpNumeroTransaccion'];
	$InsPago->PagFechaTransaccion = FncCambiaFechaAMysql($_POST['CmpFechaTransaccion'],true);
	$InsPago->PagNumeroRecibo = $_POST['CmpNumeroRecibo'];
	$InsPago->PagCantidadLetras = $_POST['CmpCantidadLetras'];
	
	$InsPago->MonId = $_POST['CmpMonedaId'];
	$InsPago->PagTipoCambio = $_POST['CmpTipoCambio'];
	$InsPago->PagMonto = eregi_replace(",","",(empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
	$InsPago->PagObservacion = addslashes($_POST['CmpObservacion']);
	$InsPago->PagObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsPago->PagConcepto = addslashes($_POST['CmpConcepto']);
	
	$InsPago->PagTipo = "OVV";		
	$InsPago->PagUtilizado = 2;
	$InsPago->PagEstado = 3;		
	$InsPago->PagTiempoCreacion = date("Y-m-d H:i:s");
	$InsPago->PagTiempoModificacion = date("Y-m-d H:i:s");
	$InsPago->PagEliminado = 1;
	
	$InsPago->PagFoto1 = $_SESSION['SesPagFoto1'.$Identificador];
	
	$InsPago->CliNombre = $_POST['CmpClienteNombre'];
	$InsPago->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsPago->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsPago->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsPago->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	
	
	$InsPago->PagoComprobante = array();

	if($InsPago->MonId<>$EmpresaMonedaId){
		if(empty($InsPago->PagTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_PAG_600';
		}
	}


	if($InsPago->MonId<>$EmpresaMonedaId ){
		$InsPago->PagMonto = $InsPago->PagMonto * $InsPago->PagTipoCambio;
	}
	
		$InsPagoComprobante1 = new ClsPagoComprobante();
		$InsPagoComprobante1->PacId = $_POST['CmpPagoComprobanteId'];
		$InsPagoComprobante1->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
		$InsPagoComprobante1->PacEstado = 1;
		$InsPagoComprobante1->PacTiempoCreacion = date("Y-m-d H:i:s");
		$InsPagoComprobante1->PacTiempoModificacion = date("Y-m-d H:i:s");
		
		$InsPago->PagoComprobante[] = $InsPagoComprobante1;
	
		$OrdenVentaVehiculoId = $InsPagoComprobante1->OvvId ;

	
	if($Guardar){

		if($InsPago->MtdRegistrarPago()){
			
			if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
			}
			
			
			$Registro = true;
			FncNuevo();
			$Resultado.='#SAS_PAG_101';
			
		} else{
			$InsPago->PagFecha = FncCambiaFechaANormal($InsPago->PagFecha);
			$InsPago->PagFechaTransaccion = FncCambiaFechaANormal($InsPago->PagFechaTransaccion,true);	
			
			if($InsPago->MonId<>$EmpresaMonedaId ){
				$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
			}
			
			$Resultado.='#ERR_PAG_101';
		}
		
	}else{
		
		$InsPago->PagFecha = FncCambiaFechaANormal($InsPago->PagFecha);	
		$InsPago->PagFechaTransaccion = FncCambiaFechaANormal($InsPago->PagFechaTransaccion,true);	
		
		if($InsPago->MonId<>$EmpresaMonedaId ){
			$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
		}
			
		
	}
	

}else{
	FncNuevo();
}

function FncNuevo(){
	
	global $InsPago;
	global $EmpresaMonedaId;
	global $InsOrdenVentaVehiculo;
	global $OrdenVentaVehiculoId;
	
	global $TotalOriginal;
	
	$InsPago = new ClsPago();
	
	$InsPago->PagFecha = date("d/m/Y");	
	$InsPago->MonId = $EmpresaMonedaId;
	$InsPago->OvvId = $InsOrdenVentaVehiculo->OvvId;
	$InsPago->MonId = $InsOrdenVentaVehiculo->MonId;
	$InsPago->PagTipoCambio = $InsOrdenVentaVehiculo->OvvTipoCambio;

	//$InsPago->PagMonto = $InsOrdenVentaVehiculo->OvvSaldo;
	$InsPago->PagMonto = 0;
	$InsPago->NpaId = "NPA-10000";
	$InsPago->FpaId = "FPA-10002";
	$InsPago->AreId = "ARE-10000";
	
	$InsPago->CliId = $InsOrdenVentaVehiculo->CliId;
	$InsPago->CliNombre = $InsOrdenVentaVehiculo->CliNombre;
	$InsPago->CliApellidoPaterno = $InsOrdenVentaVehiculo->CliApellidoPaterno;
	$InsPago->CliApellidoMaterno = $InsOrdenVentaVehiculo->CliApellidoMaterno;

	$InsPago->TdoId = $InsOrdenVentaVehiculo->TdoId;
	$InsPago->CliNumeroDocumento = $InsOrdenVentaVehiculo->CliNumeroDocumento;
	
	$TotalOriginal = $InsPago->OvvTotal;
	
	//if($InsPago->MonId<>$EmpresaMonedaId){
//		
//		$InsPago->PagMonto = round($InsPago->PagMonto  / $InsPago->PagTipoCambio,2);
//		
//	}	
	
	if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){
		
		$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal  / $InsOrdenVentaVehiculo->OvvTipoCambio,2);
		
	}	
	
	
	$OrdenVentaVehiculoId = $InsOrdenVentaVehiculo->OvvId;
	
	$InsPago->PagConcepto = "Abono de repuestos. O.V.: ".$OrdenVentaVehiculoId;
	
	$InsPago->OvvTotal = $InsOrdenVentaVehiculo->OvvTotal;
	
	
//	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
//	$InsOrdenVentaVehiculo->OvvId = $OrdenVentaVehiculoId;
//	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
	
}
?>