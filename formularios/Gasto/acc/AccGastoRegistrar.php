<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsGasto->UsuId = $_SESSION['SesionId'];	

	$InsGasto->GasId = $_POST['CmpId'];
	$InsGasto->SucId = $_SESSION['SesionSucursal'];	
	
	$InsGasto->PrvId = $_POST['CmpProveedorId'];
	$InsGasto->CtiId = $_POST['CmpComprobanteTipo'];	
	$InsGasto->TopId = $_POST['CmpTipoOperacion'];	

	
	$InsGasto->GasPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsGasto->GasFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	$InsGasto->GasConcepto = addslashes($_POST['CmpConcepto']);
	$InsGasto->GasObservacion = addslashes($_POST['CmpObservacion']);
	$InsGasto->GasDocumentoOrigen = $_POST['CmpDocumentoOrigen'];
	
	$InsGasto->GasComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsGasto->GasComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsGasto->GasComprobanteNumero = $InsGasto->GasComprobanteNumeroSerie."-".$InsGasto->GasComprobanteNumeroNumero;
	
	$InsGasto->GasComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);	

	$InsGasto->MonId = $_POST['CmpMonedaId'];
	$InsGasto->GasTipoCambio = $_POST['CmpTipoCambio'];

	$InsGasto->GasIncluyeImpuesto = 1;

	$InsGasto->NpaId = $_POST['CmpCondicionPago'];
	$InsGasto->GasCantidadDia = isset($_POST['CmpCantidadDia'])?$_POST['CmpCantidadDia']:0;
	
	$InsGasto->GasTotal = preg_replace("/,/", "", (empty($_POST['CmpTotal'])?0:$_POST['CmpTotal']));

	$InsGasto->GasEstado = $_POST['CmpEstado'];
	
	$InsGasto->GasTiempoCreacion = date("Y-m-d H:i:s");
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

	$GastoId = $InsGasto->MtdVerificarExisteGasto("GasComprobanteNumero",$InsGasto->GasComprobanteNumero);
	
	if(!empty($GastoId)){
		$error = true;
		$Resultado.='#ERR_GAS_601';
	}
			
			
/*
echo "<br><br><br>";
echo "A: ";
echo $InsGasto->GasSubTotal;
echo " - B: ";
echo $InsGasto->GasValorTotal;
echo " C";
*/

	if($Guardar){

		if($InsGasto->MtdRegistrarGasto()){
			
			
			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
                    
                        self.parent.tb_remove('<?php echo $GET_mod;?>');
                        self.parent.$('#CmpGastoId').val("<?php echo $InsGasto->GasId;?>");
                        self.parent.FncGastoBuscar("Id");
                
                </script>
<?php
			}
				
			FncNuevo();
		
			$Resultado.='#SAS_GAS_101';
			$Registro = true;

		}else{

			$InsGasto->GasFecha = FncCambiaFechaANormal($InsGasto->GasFecha);
			$InsGasto->GasComprobanteFecha = FncCambiaFechaANormal($InsGasto->GasComprobanteFecha,true);
			
			if($InsGasto->MonId<>$EmpresaMonedaId ){
				$InsGasto->GasTotal = round($InsGasto->GasTotal / $InsGasto->GasTipoCambio,3);
			}

			$Resultado.='#ERR_GAS_101';	

		}
			
	}else{
		
		$InsGasto->GasFecha = FncCambiaFechaANormal($InsGasto->GasFecha);
		$InsGasto->GasComprobanteFecha = FncCambiaFechaANormal($InsGasto->GasComprobanteFecha,true);
		
		if($InsGasto->MonId<>$EmpresaMonedaId ){
			$InsGasto->GasTotal = round($InsGasto->GasTotal / $InsGasto->GasTipoCambio,3);
		}
	}
	


}else{

	FncNuevo();
	
}

function FncNuevo(){

	global $Identificador;
	global $InsGasto;
	global  $EmpresaImpuestoVenta;
	unset($_SESSION['SesGasFoto'.$Identificador]);
	
	$InsGasto = new ClsGasto();
	
	$InsGasto->GasEstado = 3;
	$InsGasto->GasTipoCambio = $_SESSION['SesionTipoCambioCompra'];
	$InsGasto->TopId = "TOP-10001";
	$InsGasto->CtiId = "CTI-10000";
	$InsGasto->TdoId = "TDO-10003";
	$InsGasto->NpaId = "NPA-10000";
	$InsGasto->GasCantidadDia = 0;
	$InsGasto->SucId = $_SESSION['SesionSucursal'];	
	
	$InsGasto->GasPorcentajeImpuestoVenta =  $EmpresaImpuestoVenta;
	
}
?>