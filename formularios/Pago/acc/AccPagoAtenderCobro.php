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
	
	$InsPago->VdiId = $_POST['CmpVentaDirectaId'];
	$InsPago->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	
	$InsPago->CueId = $_POST['CmpCuenta'];
	$InsPago->FpaId = $_POST['CmpFormaPago'];
	$InsPago->TarId = $_POST['CmpTarjeta'];
	
	$InsPago->PagNumeroRecibo = $_POST['CmpNumeroRecibo'];
	$InsPago->PagNumeroTransaccion = $_POST['CmpNumeroTransaccion'];
	$InsPago->PagFechaTransaccion = FncCambiaFechaAMysql($_POST['CmpFechaTransaccion'],true);
	
	$InsPago->PagReferencia = $_POST['CmpReferencia'];
	$InsPago->MonId = $_POST['CmpMonedaId'];
	$InsPago->PagTipoCambio = $_POST['CmpTipoCambio'];
	$InsPago->PagMonto = eregi_replace(",","",(empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
//	$InsPago->PagObservacion = addslashes($_POST['CmpObservacion']);
	$InsPago->PagObservacion = addslashes($_POST['CmpObservacion'])."###".addslashes($_POST['CmpObservacionImpresa']);

	$InsPago->PagConcepto = addslashes($_POST['CmpConcepto']);
	$InsPago->PagTipo = "VDI";
	$InsPago->PagEstado = 3;	
	$InsPago->PagTiempoModificacion = date("Y-m-d H:i:s");
	$InsPago->PagEliminado = 1;
	
	$InsPago->PagFoto1 = $_SESSION['SesPagFoto1'.$Identificador];
		
	$InsPago->CliNombre = $_POST['CmpClienteNombre'];
	$InsPago->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsPago->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
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

	$VentaDirectaId = $InsPago->VdiId ;
	$OrdenVentaVehiculoId = $InsPago->OvvId;
	
		if($Guardar){
			
		
			//PagNumeroRecibo
			
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
				$InsPago->PagFechaTransaccion = FncCambiaFechaANormal($InsPago->PagFechaTransaccion);		
				
				if($InsPago->MonId<>$EmpresaMonedaId ){
					$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
				}
					
				$Resultado.='#ERR_PAG_102';		
			}
			
		}else{

			$InsPago->PagFecha = FncCambiaFechaANormal($InsPago->PagFecha);	
			$InsPago->PagFechaTransaccion = FncCambiaFechaANormal($InsPago->PagFechaTransaccion);		
		
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
	global $VentaDirectaId;
	global $OrdenVentaVehiculoId;
	
	global $EmpresaMonedaId;
	
	$InsPago->PagId = $GET_id;
	$InsPago->MtdObtenerPago();		
	
	$VentaDirectaId = "";
	$OrdenVentaVehiculoId = "";
	
	if($InsPago->MonId<>$EmpresaMonedaId ){
		$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
	}
	
	if(!empty($InsPago->PagoComprobante)){
		
		foreach($InsPago->PagoComprobante as $DatPagoComprobante){
			
			$VentaDirectaId = $DatPagoComprobante->VdiId;
			
		}
		
	}
	
	if(!empty($InsPago->PagoComprobante)){
		
		foreach($InsPago->PagoComprobante as $DatPagoComprobante){
			
			$OrdenVentaVehiculoId = $DatPagoComprobante->OvvId;
			
		}
		
	}
	
	$InsPago->PagEstado = 3;
	$InsPago->PagFechaTransaccion = date("d/m/Y");
	
	$InsPago->MtdGenerarPagoNumeroRecibo();
	
	$InsPago->FpaId = "FPA-10000";	
	$InsPago->CueId = "CUE-10000";
	
}
?>
