<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsCalificacion->CalId = $_POST['CmpId'];
	$InsCalificacion->CalNombre = $_POST['CmpNombre'];
	$InsCalificacion->MonId = $_POST['CmpMonedaId'];
	$InsCalificacion->CalTipoCambio = $_POST['CmpTipoCambio'];
	$InsCalificacion->CalCosto = eregi_replace(",","",(empty($_POST['CmpCosto'])?0:$_POST['CmpCosto']));
	$InsCalificacion->CalMargen = eregi_replace(",","",(empty($_POST['CmpMargen'])?0:$_POST['CmpMargen']));
	$InsCalificacion->CalRango = $_POST['CmpRango'];
	$InsCalificacion->CalTiempoCreacion = date("Y-m-d H:i:s");
	$InsCalificacion->CalTiempoModificacion = date("Y-m-d H:i:s");
	$InsCalificacion->CalEliminado = 1;
		
	if($InsCalificacion->MtdRegistrarCalificacion()){
		unset($InsCalificacion);
		$Resultado.='#SAS_CAL_101';
		
	} else{
		$Resultado.='#ERR_CAL_101';
	}

}else{
	
	$InsCalificacion->MonId = "MON-10001";
	
	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = "MON-10001";
	$InsTipoCambio->TcaFecha = date("Y-m-d");
	
	$InsTipoCambio->MtdObtenerTipoCambioActual();
	
	if(empty($InsTipoCambio->TcaId)){
		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}
		
	$InsCalificacion->CalTipoCambio = $InsTipoCambio->TcaMontoCompra;
	
	
}
?>