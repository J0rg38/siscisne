<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;	
	$Resultado = '';
	
	$InsClientePago->CpaId = $_POST['CmpId'];
	$InsClientePago->CpaFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	





	$InsClientePago->CpaTransaccionNumero = $_POST['CmpTransaccionNumero'];

	$InsClientePago->FpaId = $_POST['CmpFormaPago'];
	$InsClientePago->CueId = $_POST['CmpCuentaId'];
	$InsClientePago->MonId = $_POST['CmpMonedaId'];
	$InsClientePago->CpaTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsClientePago->CpaMonto = eregi_replace(",","",(empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
	
	$InsClientePago->CpaObservacion = $_POST['CmpObservacion'];
	$InsClientePago->CpaEstado = 1;	
	$InsClientePago->CpaTiempoModificacion = date("Y-m-d H:i:s");
	$InsClientePago->CpaEliminado = 1;
		
	$InsClientePago->ClientePagoComprobante = array();


	if($InsClientePago->MonId<>$EmpresaMonedaId){
		if(empty($InsClientePago->CpaTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_CPA_600';
		}
	}
	
		if($InsClientePago->MonId<>$EmpresaMonedaId ){
		$InsClientePago->CpaMonto = $InsClientePago->CpaMonto * $InsClientePago->CpaTipoCambio;
	}

//		$InsClientePagoComprobante1 = new ClsClientePagoComprobante();
//		$InsClientePagoComprobante1->CpcId = $_POST['CmpClientePagoComprobanteId'];
//		$InsClientePagoComprobante1->FacId = $_POST['CmpFacturaId'];
//		$InsClientePagoComprobante1->FtaId = $_POST['CmpFacturaTalonarioId'];
//		
//		$InsClientePago->ClientePagoComprobante[] = $InsClientePagoComprobante1;
		
		if($Guardar){
	
			if($InsClientePago->MtdEditarClientePago()){		


				if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
				}
			
				$Edito = true;			
				$Resultado.='#SAS_CPA_102';
				FncCargarDatos();
				
			}else{
				
				$InsClientePago->CpaFecha = FncCambiaFechaANormal($InsClientePago->CpaFecha);		
				
				if($InsClientePago->MonId<>$EmpresaMonedaId ){
					$InsClientePago->CpaMonto = round($InsClientePago->CpaMonto / $InsClientePago->CpaTipoCambio,3);
				}
					
				$Resultado.='#ERR_CPA_102';		
			}
			
		}else{

			$InsClientePago->CpaFecha = FncCambiaFechaANormal($InsClientePago->CpaFecha);	
		
			if($InsClientePago->MonId<>$EmpresaMonedaId ){
				$InsClientePago->CpaMonto = round($InsClientePago->CpaMonto / $InsClientePago->CpaTipoCambio,3);
			}

		}
			
			
}else{

	FncCargarDatos();

}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsClientePago;
	global $FacturaId;
	global $FacturaTalonarioId;
	global $FacturaTalonarioNumero;
	global $EmpresaMonedaId;
	
	$InsClientePago->CpaId = $GET_id;
	$InsClientePago->MtdObtenerClientePago();		
	
	$FacturaId = "";
	$FacturaTalonarioId = "";
	$FacturaTalonarioNumero = "";
	
	if($InsClientePago->MonId<>$EmpresaMonedaId ){
		$InsClientePago->CpaMonto = round($InsClientePago->CpaMonto / $InsClientePago->CpaTipoCambio,3);
	}
	
	if(!empty($InsClientePago->ClientePagoComprobante)){
		
		foreach($InsClientePago->ClientePagoComprobante as $DatClientePagoComprobante){
			
			$FacturaId = $DatClientePagoComprobante->FacId;
			$FacturaTalonarioId = $DatClientePagoComprobante->FtaId;
			$FacturaTalonarioNumero = $DatClientePagoComprobante->FtaNumero;
			
		}
		
	}
}
?>