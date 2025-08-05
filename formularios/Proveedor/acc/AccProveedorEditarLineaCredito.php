<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$InsProveedor->PrvId = $_POST['CmpId'];

	$InsProveedor->MonId = $_POST['CmpMonedaId'];
	$InsProveedor->PrvTipoCambioFecha = FncCambiaFechaAMysql($_POST['CmpTipoCambioFecha'],true);
	$InsProveedor->PrvTipoCambio = $_POST['CmpTipoCambio'];
	$InsProveedor->PrvLineaCredito = eregi_replace(",","",(empty($_POST['CmpLineaCredito'])?0:$_POST['CmpLineaCredito']));
	$InsProveedor->PrvLineaCreditoActual = eregi_replace(",","",(empty($_POST['CmpLineaCreditoActual'])?0:$_POST['CmpLineaCreditoActual']));
	$InsProveedor->PrvLineaCreditoActiva = $_POST['CmpLineaCreditoActiva'];
	$InsProveedor->PrvTiempoModificacion = date("Y-m-d H:i:s");
				
	if($InsProveedor->MonId<>$EmpresaMonedaId ){
		$InsProveedor->PrvLineaCredito = $InsProveedor->PrvLineaCredito * $InsProveedor->PrvTipoCambio;
	}	
	
	if($InsProveedor->MonId<>$EmpresaMonedaId ){
		$InsProveedor->PrvLineaCreditoActual = $InsProveedor->PrvLineaCreditoActual * $InsProveedor->PrvTipoCambio;
	}	
	
	if($InsProveedor->MtdActualizarProveedorLineaCreditoActual()){					
	
		$InsProveedor->MtdEditarProveedorDato("PrvLineaCreditoActiva",$InsProveedor->PrvLineaCreditoActiva,$InsProveedor->PrvId);
	
		if(!empty($GET_dia)){
?>
			<script type="text/javascript">
			self.parent.tb_remove('<?php echo $GET_mod;?>','<?php echo $GET_Tipo;?>','<?php echo $GET_Ruta;?>');
		   // self.parent.FncProveedorBuscar("Id",'<?php echo $GET_Tipo;?>','<?php echo $GET_Ruta;?>');
			</script>
<?php
		}
			
		$Edito = true;
		FncCargarDatos();	
		$Resultado.='#SAS_PRV_108';		
	}else{			
				
		if($InsProveedor->MonId<>$EmpresaMonedaId ){
			$InsProveedor->PrvLineaCreditoActual = $InsProveedor->PrvLineaCreditoActual / $InsProveedor->PrvTipoCambio;
		}	
		
		if($InsProveedor->MonId<>$EmpresaMonedaId ){
			$InsProveedor->PrvLineaCredito = $InsProveedor->PrvLineaCredito / $InsProveedor->PrvTipoCambio;
		}	
		
		$Resultado.='#ERR_PRV_108';		
	}			
			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsProveedor;
	global $Identificador;
	global $EmpresaMonedaId;
	
	$InsProveedor->PrvId = $GET_id;
	$InsProveedor = $InsProveedor->MtdObtenerProveedor();			
	
	if($InsProveedor->MonId<>$EmpresaMonedaId ){
		$InsProveedor->PrvLineaCreditoActual = $InsProveedor->PrvLineaCreditoActual / $InsProveedor->PrvTipoCambio;
	}	
	
	if($InsProveedor->MonId<>$EmpresaMonedaId ){
		$InsProveedor->PrvLineaCredito = $InsProveedor->PrvLineaCredito / $InsProveedor->PrvTipoCambio;
	}	
	
}
?>