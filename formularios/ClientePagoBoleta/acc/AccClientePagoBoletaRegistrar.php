<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsClientePago->CpaId = $_POST['CmpId'];
	$InsClientePago->CpaFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	$InsClientePago->BolId = $_POST['CmpBoletaId'];
	$InsClientePago->BtaId = $_POST['CmpBoletaTalonarioId'];
	$InsClientePago->BtaNumero = $_POST['CmpBoletaTalonarioNumero'];
		
	$InsClientePago->CpaTransaccionNumero = $_POST['CmpTransaccionNumero'];
	
	$InsClientePago->FpaId = $_POST['CmpFormaPago'];
	$InsClientePago->CueId = $_POST['CmpCuentaId'];
	$InsClientePago->MonId = $_POST['CmpMonedaId'];

	$InsClientePago->CpaTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsClientePago->CpaMonto = eregi_replace(",","",(empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
	
	$InsClientePago->CpaObservacion = $_POST['CmpObservacion'];
	
	$InsClientePago->CpaEstado = 1;		
	$InsClientePago->CpaTiempoCreacion = date("Y-m-d H:i:s");
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
	
		$InsClientePagoComprobante1 = new ClsClientePagoComprobante();
		$InsClientePagoComprobante1->CpcId = $_POST['CmpClientePagoComprobanteId'];
		$InsClientePagoComprobante1->BolId = $_POST['CmpBoletaId'];
		$InsClientePagoComprobante1->BtaId = $_POST['CmpBoletaTalonarioId'];
		$InsClientePagoComprobante1->BtaNumero = $_POST['CmpBoletaTalonarioNumero'];
		
		$InsClientePago->ClientePagoComprobante[] = $InsClientePagoComprobante1;
	
	

			
		$BoletaId = $InsClientePagoComprobante1->BolId ;
		$BoletaTalonarioId = $DatClietePagoComprobante->BtaId;
		$BoletaTalonarioNumero = $InsClientePagoComprobante1->BtaNumero;
		
	
	
	if($Guardar){

		if($InsClientePago->MtdRegistrarClientePago()){
			
			if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
			}
			
			
			$Registro = true;
			FncNuevo();
			$Resultado.='#SAS_CPA_101';
			
		} else{
			$InsClientePago->CpaFecha = FncCambiaFechaANormal($InsClientePago->CpaFecha);	
			
			if($InsClientePago->MonId<>$EmpresaMonedaId ){
				$InsClientePago->CpaMonto = round($InsClientePago->CpaMonto / $InsClientePago->CpaTipoCambio,3);
			}
			
			$Resultado.='#ERR_CPA_101';
		}
		
	}else{
		
		$InsClientePago->CpaFecha = FncCambiaFechaANormal($InsClientePago->CpaFecha);	
		
		if($InsClientePago->MonId<>$EmpresaMonedaId ){
			$InsClientePago->CpaMonto = round($InsClientePago->CpaMonto / $InsClientePago->CpaTipoCambio,3);
		}
			
		
	}
	

}else{
	FncNuevo();
}

function FncNuevo(){
	
	global $InsClientePago;
	global $EmpresaMonedaId;
	global $InsBoleta;
	
	global $BoletaId;
	global $BoletaTalonarioId;
	global $BoletaTalonarioNumero;
	

	
	$InsClientePago = new ClsClientePago();
	
	$InsClientePago->CpaFecha = date("d/m/Y");	
	$InsClientePago->MonId = $EmpresaMonedaId;
	$InsClientePago->BolId = $InsBoleta->BolId;
	$InsClientePago->BtaId = $InsBoleta->BtaId;
	$InsClientePago->BtaNumero = $InsBoleta->BtaNumero;
	$InsClientePago->MonId = $InsBoleta->MonId;
	$InsClientePago->CpaTipoCambio = $InsBoleta->BolTipoCambio;
	$InsClientePago->CpaMonto = $InsBoleta->BolMontoPendiente;
	$InsClientePago->FpaId = "FPA-10000";
		
	if($InsClientePago->MonId<>$EmpresaMonedaId){
		
		$InsClientePago->CpaMonto = round($InsClientePago->CpaMonto  / $InsClientePago->CpaTipoCambio,2);
		
	}	
	
	$BoletaId = $InsBoleta->BolId;
	$BoletaTalonarioId = $InsBoleta->BtaId;
	$BoletaTalonarioNumero = $InsBoleta->BtaNumero;
	
}
?>