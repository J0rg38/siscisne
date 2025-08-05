<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';

	$InsTipoCambio->TcaId = $_POST['CmpId'];
	$InsTipoCambio->MonId = $_POST['CmpMoneda'];
	$InsTipoCambio->TcaFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsTipoCambio->TcaMontoCompra = $_POST['CmpMontoCompra'];
	$InsTipoCambio->TcaMontoVenta = $_POST['CmpMontoVenta'];
	$InsTipoCambio->TcaMontoComercial = $_POST['CmpMontoComercial'];
	
	$InsTipoCambio->TcaTiempoModificacion = date("Y-m-d H:i:s");
				
		if($InsTipoCambio->MtdEditarTipoCambio()){					
			$Resultado.='#SAS_TCA_102';			
			FncCargarDatos();
		}else{			
			$Resultado.='#ERR_TCA_102';		
			$InsTipoCambio->TcaFecha = FncCambiaFechaANormal($InsTipoCambio->TcaFecha);
		}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	global $GET_id;
	global $InsTipoCambio;
	$InsTipoCambio->TcaId = $GET_id;
	$InsTipoCambio = $InsTipoCambio->MtdObtenerTipoCambio();		
}
?>