<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;	
	$Resultado = '';
	
	$InsOrdenCobro->OcbId = $_POST['CmpId'];
	$InsOrdenCobro->OcbFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsOrdenCobro->CliId = $_POST['CmpClienteId'];
	
	$InsOrdenCobro->AreId = $_POST['CmpAreaId'];
	
	$InsOrdenCobro->VdiId = $_POST['CmpVentaDirectaId'];
	$InsOrdenCobro->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	
	$InsOrdenCobro->NpaId = $_POST['CmpCondicionPago'];
	$InsOrdenCobro->MonId = $_POST['CmpMonedaId'];
	$InsOrdenCobro->OcbTipoCambio = $_POST['CmpTipoCambio'];
	$InsOrdenCobro->OcbMonto = preg_replace("/,/", "", (empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));
	$InsOrdenCobro->OcbObservacion = addslashes($_POST['CmpObservacion']);
	$InsOrdenCobro->OcbConcepto = addslashes($_POST['CmpConcepto']);
	$InsOrdenCobro->OcbTipo = "VDI";
	$InsOrdenCobro->OcbEstado = $_POST['CmpEstado'];	
	$InsOrdenCobro->OcbTiempoModificacion = date("Y-m-d H:i:s");
	$InsOrdenCobro->OcbEliminado = 1;
	
	$InsOrdenCobro->CliNombre = $_POST['CmpClienteNombre'];
	$InsOrdenCobro->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsOrdenCobro->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsOrdenCobro->OrdenCobroComprobante = array();

	if($InsOrdenCobro->MonId<>$EmpresaMonedaId){
		if(empty($InsOrdenCobro->OcbTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_OCB_600';
		}
	}
	
	if($InsOrdenCobro->MonId<>$EmpresaMonedaId ){
		$InsOrdenCobro->OcbMonto = $InsOrdenCobro->OcbMonto * $InsOrdenCobro->OcbTipoCambio;
	}

	$VentaDirectaId = $InsOrdenCobro->VdiId ;
	$OrdenVentaVehiculoId = $InsOrdenCobro->OvvId;
	
		if($Guardar){
	
			if($InsOrdenCobro->MtdEditarOrdenCobro()){		


				if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
				}
			
				$Edito = true;			
				$Resultado.='#SAS_OCB_102';
				FncCargarDatos();
				
			}else{
				
				$InsOrdenCobro->OcbFecha = FncCambiaFechaANormal($InsOrdenCobro->OcbFecha);		
				
				if($InsOrdenCobro->MonId<>$EmpresaMonedaId ){
					$InsOrdenCobro->OcbMonto = round($InsOrdenCobro->OcbMonto / $InsOrdenCobro->OcbTipoCambio,3);
				}
					
				$Resultado.='#ERR_OCB_102';		
			}
			
		}else{

			$InsOrdenCobro->OcbFecha = FncCambiaFechaANormal($InsOrdenCobro->OcbFecha);	
		
			if($InsOrdenCobro->MonId<>$EmpresaMonedaId ){
				$InsOrdenCobro->OcbMonto = round($InsOrdenCobro->OcbMonto / $InsOrdenCobro->OcbTipoCambio,3);
			}

		}
			
			
}else{

	FncCargarDatos();

}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsOrdenCobro;
	global $VentaDirectaId;
	global $OrdenVentaVehiculoId;
	
	global $EmpresaMonedaId;
	
	$InsOrdenCobro->OcbId = $GET_id;
	$InsOrdenCobro->MtdObtenerOrdenCobro();		
	
	$VentaDirectaId = "";
	$OrdenVentaVehiculoId = "";
	
	if($InsOrdenCobro->MonId<>$EmpresaMonedaId ){
		$InsOrdenCobro->OcbMonto = round($InsOrdenCobro->OcbMonto / $InsOrdenCobro->OcbTipoCambio,3);
	}
	
	if(!empty($InsOrdenCobro->OrdenCobroComprobante)){
		
		foreach($InsOrdenCobro->OrdenCobroComprobante as $DatOrdenCobroComprobante){
			
			$VentaDirectaId = $DatOrdenCobroComprobante->VdiId;
			
		}
		
	}
	
	if(!empty($InsOrdenCobro->OrdenCobroComprobante)){
		
		foreach($InsOrdenCobro->OrdenCobroComprobante as $DatOrdenCobroComprobante){
			
			$OrdenVentaVehiculoId = $DatOrdenCobroComprobante->OvvId;
			
		}
		
	}
	
	$InsOrdenCobro->OcbEstado = 3;	
}
?>
