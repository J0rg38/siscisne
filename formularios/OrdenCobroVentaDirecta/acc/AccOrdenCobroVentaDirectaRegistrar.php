<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';

	$InsPago->PagId = $_POST['CmpId'];
	$InsPago->PagFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsPago->CliId = $_POST['CmpClienteId'];
	$InsPago->AreId = $_POST['CmpAreaId'];
	$InsPago->VdiId = $_POST['CmpVentaDirectaId'];
	$InsPago->NpaId = $_POST['CmpCondicionPago'];
	$InsPago->MonId = $_POST['CmpMonedaId'];
	$InsPago->PagTipoCambio = $_POST['CmpTipoCambio'];
	$InsPago->PagMonto = eregi_replace(",","",(empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
	$InsPago->PagObservacion = addslashes($_POST['CmpObservacion']);
	$InsPago->PagConcepto = addslashes($_POST['CmpConcepto']);
	
	$InsPago->PagTipo = "VDI";		
	$InsPago->PagEstado = 1;		
	$InsPago->PagTiempoCreacion = date("Y-m-d H:i:s");
	$InsPago->PagTiempoModificacion = date("Y-m-d H:i:s");
	$InsPago->PagEliminado = 1;
	
	$InsPago->CliNombre = $_POST['CmpClienteNombre'];
	$InsPago->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsPago->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsPago->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsPago->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
		
	$InsPago->VdiTotal = eregi_replace(",","",(empty($_POST['CmpVentaDirectaTotal'])?0:$_POST['CmpVentaDirectaTotal']));
	
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
	$InsPagoComprobante1->VdiId = $_POST['CmpVentaDirectaId'];
	$InsPagoComprobante1->PacEstado = 1;
	$InsPagoComprobante1->PacTiempoCreacion = date("Y-m-d H:i:s");
	$InsPagoComprobante1->PacTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsPago->PagoComprobante[] = $InsPagoComprobante1;
	
	$VentaDirectaId = $InsPagoComprobante1->VdiId ;

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
			
			if($InsPago->MonId<>$EmpresaMonedaId ){
				$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
			}
			
			$Resultado.='#ERR_PAG_101';
		}
		
	}else{
		
		$InsPago->PagFecha = FncCambiaFechaANormal($InsPago->PagFecha);	
		
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
	global $InsVentaDirecta;
	global $VentaDirectaId;
	
	$InsPago = new ClsPago();
	
	$InsPago->PagFecha = date("d/m/Y");	
	$InsPago->MonId = $EmpresaMonedaId;
	$InsPago->VdiId = $InsVentaDirecta->VdiId;
	$InsPago->MonId = $InsVentaDirecta->MonId;
	$InsPago->PagTipoCambio = $InsVentaDirecta->VdiTipoCambio;
	$InsPago->PagMonto = $InsVentaDirecta->VdiSaldo;
	$InsPago->NpaId = "NPA-10000";
	$InsPago->AreId = "ARE-10000";
	
	$InsPago->CliId = $InsVentaDirecta->CliId;
	$InsPago->CliNombre = $InsVentaDirecta->CliNombre;
	$InsPago->CliApellidoPaterno = $InsVentaDirecta->CliApellidoPaterno;
	$InsPago->CliApellidoMaterno = $InsVentaDirecta->CliApellidoMaterno;
	
	$InsPago->TdoId = $InsVentaDirecta->TdoId;
	$InsPago->CliNumeroDocumento = $InsVentaDirecta->CliNumeroDocumento;
	
	if($InsPago->MonId<>$EmpresaMonedaId){
		
		$InsPago->PagMonto = round($InsPago->PagMonto  / $InsPago->PagTipoCambio,2);
		
	}	

	if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
		
		$InsVentaDirecta->VdiTotal = round($InsVentaDirecta->VdiTotal  / $InsVentaDirecta->VdiTipoCambio,2);
		
	}	
	
	$VentaDirectaId = $InsVentaDirecta->VdiId;
	
	$InsPago->PagConcepto = "Pago a cuenta de repuestos. O.V.: ".$VentaDirectaId;

	$InsPago->VdiTotal = $InsVentaDirecta->VdiTotal;
		
}
?>