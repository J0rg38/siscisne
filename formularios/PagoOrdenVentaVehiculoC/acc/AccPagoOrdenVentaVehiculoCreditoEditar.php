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
	$InsPago->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	$InsPago->NpaId = $_POST['CmpCondicionPago'];
	$InsPago->MonId = $_POST['CmpMonedaId'];
	$InsPago->FpaId = $_POST['CmpFormaPago'];
	
		$InsPago->BanId = $_POST['CmpBanco'];
	$InsPago->PerId = $_POST['CmpPersonal'];
	
	$InsPago->PagTipoCambio = $_POST['CmpTipoCambio'];
	$InsPago->PagMonto = eregi_replace(",","",(empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
	$InsPago->PagObservacion = addslashes($_POST['CmpObservacion']);
	$InsPago->PagObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsPago->PagConcepto = addslashes($_POST['CmpConcepto']);
	$InsPago->PagTipo = "OVV";
	$InsPago->PagEstado = 3;	
	$InsPago->PagTiempoModificacion = date("Y-m-d H:i:s");
	$InsPago->PagEliminado = 1;

	$InsPago->PagFoto2 = $_SESSION['SesPagFoto2'.$Identificador];
	
	$InsPago->CliNombre = $_POST['CmpClienteNombre'];
	$InsPago->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsPago->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsPago->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsPago->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	
	$InsPago->OvvTotal = eregi_replace(",","",(empty($_POST['CmpOrdenVentaVehiculoTotal'])?0:$_POST['CmpOrdenVentaVehiculoTotal']));
	
	$InsPago->PagMonto = $InsPago->OvvTotal;
	
	
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
	global $OrdenVentaVehiculoId;
	global $EmpresaMonedaId;
	global $InsOrdenVentaVehiculo;
	
	$InsPago->PagId = $GET_id;
	$InsPago->MtdObtenerPago();		
	
	$OrdenVentaVehiculoId = "";
	
	if($InsPago->MonId<>$EmpresaMonedaId ){
		$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
	}
	
	if($InsPago->MonId<>$EmpresaMonedaId){
		
		$InsPago->OvvTotal = round($InsPago->OvvTotal  / $InsPago->OvvTipoCambio,2);
		
	}	
	
	
	$_SESSION['SesPagFoto2'.$Identificador] = $InsPago->PagFoto2;
	
	//$InsPago->OvvTotal = $InsOrdenVentaVehiculo->OvvTotal;
	
	if(!empty($InsPago->PagoComprobante)){
		
		foreach($InsPago->PagoComprobante as $DatPagoComprobante){
			
			$OrdenVentaVehiculoId = $DatPagoComprobante->OvvId;
			
		}
		
	}
}
?>