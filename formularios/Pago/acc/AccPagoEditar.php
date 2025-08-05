<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;	
	$Resultado = '';
	
	$InsPago->UsuId = $_SESSION['SesionId'];
	
	$InsPago->PagId = $_POST['CmpId'];
	$InsPago->PagFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsPago->CliId = $_POST['CmpClienteId'];
	
	$InsPago->AreId = $_POST['CmpAreaId'];
	$InsPago->FacId = $_POST['CmpFacturaId'];
	$InsPago->NpaId = $_POST['CmpCondicionPago'];
	$InsPago->FpaId = $_POST['CmpFormaPago'];
	$InsPago->CueId = $_POST['CmpCuenta'];
	$InsPago->TarId = $_POST['CmpTarjeta'];
	
	$InsPago->PagNumeroTransaccion = $_POST['CmpNumeroTransaccion'];
	$InsPago->PagFechaTransaccion = FncCambiaFechaAMysql($_POST['CmpFechaTransaccion'],true);
	$InsPago->PagNumeroRecibo = $_POST['CmpNumeroRecibo'];
	
	$InsPago->MonId = $_POST['CmpMonedaId'];
	$InsPago->PagTipoCambio = $_POST['CmpTipoCambio'];
	$InsPago->PagMonto = eregi_replace(",","",(empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
	$InsPago->PagObservacion = addslashes($_POST['CmpObservacion']);
	$InsPago->PagConcepto = addslashes($_POST['CmpConcepto']);
	$InsPago->PagTipo = "LIB";
	//$InsPago->PagEstado = 3;	
	$InsPago->PagEstado = $_POST['CmpEstado'];
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


		
		if($Guardar){
	
			if($InsPago->MtdEditarPago()){		


				if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
				}
			
				$Edito = true;			
				$Resultado.='#SAS_PAG_102';
				FncCargarDatos();
				
			}else{
				
				$InsPago->PagFecha = FncCambiaFechaANormal($InsPago->PagFecha);		
				
				if($InsPago->MonId<>$EmpresaMonedaId ){
					$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
				}
					
				$Resultado.='#ERR_PAG_102';		
			}
			
		}else{

			$InsPago->PagFecha = FncCambiaFechaANormal($InsPago->PagFecha);	
		
			if($InsPago->MonId<>$EmpresaMonedaId ){
				$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
			}

		}
			
			
}else{

	FncCargarDatos();

}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsPago;
	global $FacturaId;
	global $FacturaTalonarioId;
	global $FacturaTalonarioNumero;
	global $EmpresaMonedaId;
	global $Identificador;

	$InsPago->PagId = $GET_id;
	$InsPago->MtdObtenerPago();		
	
	//deb($InsPago->PagMonto." - ".$InsPago->PagTipoCambio);
	if($InsPago->MonId<>$EmpresaMonedaId ){
		$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
	}
	
	if($InsPago->MonId<>$EmpresaMonedaId){
		$InsPago->FacTotal = round($InsPago->FacTotal  / $InsPago->FacTipoCambio,2);
	}	
	
	$_SESSION['SesPagFoto1'.$Identificador] = $InsPago->PagFoto1;
	
	//$InsPago->FacTotal = $InsFactura->FacTotal;
	
	if(!empty($InsPago->PagoComprobante)){
		
		foreach($InsPago->PagoComprobante as $DatPagoComprobante){
			
			$FacturaId = $DatPagoComprobante->FacId;
			$FacturaTalonarioId = $DatPagoComprobante->FtaId;
			$FacturaTalonarioNumero = $DatPagoComprobante->FtaNumero;
			
		}
		
	}
}
?>