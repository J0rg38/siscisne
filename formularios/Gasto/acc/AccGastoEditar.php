<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsGasto->UsuId = $_SESSION['SesionId'];		
	$InsGasto->GasId = $_POST['CmpId'];
	$InsGasto->PrvId = $_POST['CmpProveedorId'];
	$InsGasto->CtiId = $_POST['CmpComprobanteTipo'];	
	$InsGasto->TopId = $_POST['CmpTipoOperacion'];	

	$InsGasto->GasPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	$InsGasto->GasFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	$InsGasto->GasConcepto = addslashes($_POST['CmpConcepto']);
	$InsGasto->GasObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsGasto->GasComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsGasto->GasComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsGasto->GasComprobanteNumero = $InsGasto->GasComprobanteNumeroSerie."-".$InsGasto->GasComprobanteNumeroNumero;
	
	$InsGasto->GasComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);	
	

	$InsGasto->MonId = $_POST['CmpMonedaId'];
	$InsGasto->GasTipoCambio = $_POST['CmpTipoCambio'];
	
//	$InsGasto->GasIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsGasto->GasIncluyeImpuesto = 1;
	
	
	$InsGasto->NpaId = $_POST['CmpCondicionPago'];
	$InsGasto->GasCantidadDia = isset($_POST['CmpCantidadDia'])?$_POST['CmpCantidadDia']:0;
	
	$InsGasto->GasTotal = preg_replace("/,/", "", (empty($_POST['CmpTotal'])?0:$_POST['CmpTotal']));
	
	$InsGasto->GasEstado = $_POST['CmpEstado'];
	$InsGasto->GasTiempoModificacion = date("Y-m-d H:i:s");
	$InsGasto->GasEliminado = 1;

	$InsGasto->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsGasto->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsGasto->PrvNombreCompleto = $_POST['CmpProveedorNombre'];
	$InsGasto->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsGasto->GasFoto = $_SESSION['SesGasFoto'.$Identificador];

	settype($InsGasto->GasTipoCambio,"float");
			
	if($InsGasto->MonId<>$EmpresaMonedaId){
		if(empty($InsGasto->GasTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_GAS_600';
		}
	}

	if( $InsGasto->MonId<>$EmpresaMonedaId ){
		$InsGasto->GasTotal = $InsGasto->GasTotal * $InsGasto->GasTipoCambio;
	}else{
		$InsGasto->GasTotal = $InsGasto->GasTotal;
	}

	$InsGasto->GasTotal = round($InsGasto->GasTotal,6);	
	$InsGasto->GasSubTotal = round($InsGasto->GasTotal / (($InsGasto->GasPorcentajeImpuestoVenta/100)+1),6);
	$InsGasto->GasImpuesto = round(($InsGasto->GasTotal - $InsGasto->GasSubTotal),6);

	if($Guardar){
		
		if($InsGasto->MtdEditarGasto()){		
			
			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
                    
                        self.parent.tb_remove('<?php echo $GET_mod;?>');
                        self.parent.$('#CmpGastoId').val("<?php echo $InsGasto->GasId;?>");
                        self.parent.FncGastoBuscar("Id");
                
                </script>
<?php
			}
			
			FncCargarDatos();
			$Resultado.='#SAS_GAS_102';
			$Registro = true;
		} else{
	
			$InsGasto->GasFecha = FncCambiaFechaANormal($InsGasto->GasFecha);
			$InsGasto->GasComprobanteFecha = FncCambiaFechaANormal($InsGasto->GasComprobanteFecha,true);
			
			if($InsGasto->MonId<>$EmpresaMonedaId ){
				$InsGasto->GasTotal = round($InsGasto->GasTotal / $InsGasto->GasTipoCambio,3);
			}
	
			$Resultado.='#ERR_GAS_102';
		}
		
	}else{
		$InsGasto->GasFecha = FncCambiaFechaANormal($InsGasto->GasFecha);
		$InsGasto->GasComprobanteFecha = FncCambiaFechaANormal($InsGasto->GasComprobanteFecha,true);
		
		if($InsGasto->MonId<>$EmpresaMonedaId ){
				$InsGasto->GasTotal = round($InsGasto->GasTotal / $InsGasto->GasTipoCambio,3);
		}

	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsGasto;
	global $EmpresaMonedaId;
	

	unset($_SESSION['SesGasFoto'.$Identificador]);
	;
	
	$InsGasto->GasId = $GET_id;
	$InsGasto->MtdObtenerGasto();		

	if($InsGasto->MonId<>$EmpresaMonedaId ){
		$InsGasto->GasTotal = round($InsGasto->GasTotal / $InsGasto->GasTipoCambio,3);
	}
	
	$_SESSION['SesGasFoto'.$Identificador] =	$InsGasto->GasFoto;

			
}
?>