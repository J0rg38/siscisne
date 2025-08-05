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
	$InsPago->BolId = $_POST['CmpBoletaId'];
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
	
	$InsPago->PagTipo = "BOL";		
	$InsPago->PagUtilizado = 2;
	
	$InsPago->PagUsuario = $_SESSION['SesionUsuario'];
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
		
		$InsPagoComprobante1->BolId = $_POST['CmpBoletaId'];
		$InsPagoComprobante1->BtaId = $_POST['CmpBoletaTalonarioId'];
		
		$InsPagoComprobante1->PacEstado = 1;
		$InsPagoComprobante1->PacTiempoCreacion = date("Y-m-d H:i:s");
		$InsPagoComprobante1->PacTiempoModificacion = date("Y-m-d H:i:s");
		
		$InsPago->PagoComprobante[] = $InsPagoComprobante1;
	
		$BoletaId = $InsPagoComprobante1->BolId ;

	
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
	global $InsBoleta;
	
	global $BoletaId;
	global $BoletaTalonarioId;
	global $BoletaTalonarioNumero;
	
	$InsPago = new ClsPago();
	
	$InsPago->PagFecha = date("d/m/Y");	
	$InsPago->MonId = $EmpresaMonedaId;
	$InsPago->BolId = $InsBoleta->BolId;
	$InsPago->MonId = $InsBoleta->MonId;
	$InsPago->PagTipoCambio = $InsBoleta->BolTipoCambio;
	//$InsPago->PagMonto = $InsBoleta->BolTotal;
	$InsPago->PagMonto = $InsBoleta->BolSaldo;
	$InsPago->NpaId = "NPA-10000";
	$InsPago->FpaId = "FPA-10000";
	$InsPago->AreId = "ARE-10010";
	
	$InsPago->CliId = $InsBoleta->CliId;
	$InsPago->CliNombre = $InsBoleta->CliNombre;
	$InsPago->CliApellidoPaterno = $InsBoleta->CliApellidoPaterno;
	$InsPago->CliApellidoMaterno = $InsBoleta->CliApellidoMaterno;

	$InsPago->TdoId = $InsBoleta->TdoId;
	$InsPago->CliNumeroDocumento = $InsBoleta->CliNumeroDocumento;
		
	if($InsPago->MonId<>$EmpresaMonedaId){
		
		$InsPago->PagMonto = round($InsPago->PagMonto  / $InsPago->PagTipoCambio,2);
		
	}	
	
	if($InsBoleta->MonId<>$EmpresaMonedaId){
		
		$InsBoleta->BolTotal = round($InsBoleta->BolTotal  / $InsBoleta->BolTipoCambio,2);
		
	}	
	
	$BoletaId = $InsBoleta->BolId;
	$BoletaTalonarioId = $InsBoleta->BtaId;
	$BoletaTalonarioNumero = $InsBoleta->BtaNumero;
	
	$InsPago->PagConcepto = "Abono de Boleta B/V: ".$BoletaTalonarioNumero." ".$BoletaId;
	
	$InsPago->BolTotal = $InsBoleta->BolTotal;
	
	
//	$InsBoleta = new ClsBoleta();
//	$InsBoleta->BolId = $BoletaId;
//	$InsBoleta->MtdObtenerBoleta();
	
}
?>