<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$InsClienteTipo->LtiId = $_POST['CmpId'];
	$InsClienteTipo->LtiNombre = $_POST['CmpNombre'];
	
	$InsClienteTipo->LtiPorcentajeMargenUtilidad = eregi_replace(",","",(empty($_POST['CmpPorcentajeMargenUtilidad'])?0:$_POST['CmpPorcentajeMargenUtilidad']));
	$InsClienteTipo->LtiPorcentajeOtroCosto = eregi_replace(",","",(empty($_POST['CmpPorcentajeOtroCosto'])?0:$_POST['CmpPorcentajeOtroCosto']));
	$InsClienteTipo->LtiPorcentajeDescuento = eregi_replace(",","",(empty($_POST['CmpPorcentajeDescuento'])?0:$_POST['CmpPorcentajeDescuento']));
	$InsClienteTipo->LtiPorcentajeManoObra = eregi_replace(",","",(empty($_POST['CmpPorcentajeManoObra'])?0:$_POST['CmpPorcentajeManoObra']));

	
	$InsClienteTipo->LtiAbreviatura = $_POST['CmpAbreviatura'];
	$InsClienteTipo->LtiObservacion = addslashes($_POST['CmpObservacion']);
	$InsClienteTipo->LtiEstado = 1;
	$InsClienteTipo->LtiTiempoCreacion = date("Y-m-d H:i:s");
	$InsClienteTipo->LtiTiempoModificacion = date("Y-m-d H:i:s");
	$InsClienteTipo->LtiEliminado = 1;
		
	if($InsClienteTipo->MtdRegistrarClienteTipo()){
		$Registro = true;
		unset($InsClienteTipo);
		$Resultado.='#SAS_LTI_101';
	} else{
		$Resultado.='#ERR_LTI_101';
	}

}else{
	//$InsClienteTipo->MtdGenerarClienteTipoId();
}
?>