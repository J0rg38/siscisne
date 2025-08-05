<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	


	$Resultado = '';

	$InsClientePago->CpaId = $_POST['CmpId'];
	$InsClientePago->UsuId =  $_SESSION['SesionId'];

	$InsClientePago->CpaTipo = $_POST['CmpTipo'];	
	
	$InsClientePago->DocId = $_POST['CmpDocumentoId'];
	$InsClientePago->DtaId = $_POST['CmpDocumentoTalonario'];
	$InsClientePago->DtaNumero = $_POST['CmpDocumentoTalonarioNumero'];
	$InsClientePago->SucId = $_POST['CmpDocumentoSucursalId'];
	
		
	$InsClientePago->CliNombre = $_POST['CmpClienteNombre'];
	
	$InsClientePago->FpaId = $_POST['CmpFormaPago'];
	$InsClientePago->MonId = $_POST['CmpMonedaId'];	
	$InsClientePago->CpaTipoCambio = $_POST['CmpTipoCambio'];		

	$InsClientePago->CpaTarjetaNumero = $_POST['CmpTarjetaNumero'];
	$InsClientePago->CpaTarjetaTipo = $_POST['CmpTarjetaTipo'];
	
	$InsClientePago->TmaNombre = $_POST['CmpTarjetaMarca'];
	$InsClientePago->TmaId = $_POST['CmpTarjetaMarcaId'];
	
	$InsClientePago->TenNombre = $_POST['CmpTarjetaEntidad'];
	$InsClientePago->TenId = $_POST['CmpTarjetaEntidadId'];
	
	$InsClientePago->BanNombre = $_POST['CmpBanco'];
	$InsClientePago->BanId = $_POST['CmpBancoId'];
	
	$InsClientePago->BanNombreDepositar = $_POST['CmpBancoDepositar'];
	$InsClientePago->BanIdDepositar = $_POST['CmpBancoDepositarId'];
	
	$InsClientePago->BanNombreDepositar = $_POST['CmpBancoDepositar'];
	
	$InsClientePago->CpaChequeNumero = $_POST['CmpChequeNumero'];
	$InsClientePago->CpaTransaccionNumero = $_POST['CmpTransaccionNumero'];
	
	$InsClientePago->CpaNumeroReferencia = $_POST['CmpNumeroReferencia'];
	$InsClientePago->CpaRetencionPorcentaje = $_POST['CmpRetencionPorcentaje'];

	$InsClientePago->CpaDescripcion = $_POST['CmpDescripcion'];
	$InsClientePago->CpaTransaccionSituacion = $_POST['CmpTransaccionSituacion'];
	
	$InsClientePago->CpaDocumentoNumero = $_POST['CmpDocumentoNumero'];
	$InsClientePago->CpaDocumentoFecha = FncCambiaFechaAMysql($_POST['CmpDocumentoFecha'],true);
		
	$InsClientePago->CpaEstado = $_POST['CmpEstado'];

	$InsClientePago->CpaDestino = $_POST['CmpDestino'];
	$InsClientePago->CpaFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	$InsClientePago->CpaFoto = $_SESSION['SesCpaFoto'.$Identificador];

	$InsClientePago->CpaMonto = eregi_replace(",","",$_POST['CmpMonto']);

	if($InsClientePago->MonId<>$EmpresaMonedaId and !empty($InsClientePago->CpaTipoCambio)){
		$InsClientePago->CpaMonto = $InsClientePago->CpaMonto * $InsClientePago->CpaTipoCambio;
	}
			
	$InsClientePago->CpaTiempoCreacion = date("Y-m-d H:i:s");
	$InsClientePago->CpaTiempoModificacion = date("Y-m-d H:i:s");
	$InsClientePago->CpaEliminado = 1;
		
	if($InsClientePago->MtdRegistrarClientePago()){
		
		unset($_SESSION['SesCpaFoto'.$Identificador]);
		
		unset($InsClientePago);
		$InsClientePago = new ClsClientePago();
		$InsClientePago->FpaId = "FPA-10000";
		$Resultado.='#SAS_CPA_101';
	} else{
		$Resultado.='#ERR_CPA_101';

		$InsClientePago->CpaFecha = FncCambiaFechaANormal($InsClientePago->CpaFecha);
		$InsClientePago->CpaDocumentoFecha = FncCambiaFechaANormal($InsClientePago->CpaDocumentoFecha,true);

		if($InsClientePago->MonId<>$EmpresaMonedaId and (!empty($InsClientePago->CpaTipoCambio) )){
				
			$InsClientePago->CpaMonto = round($InsClientePago->CpaMonto / $InsClientePago->CpaTipoCambio,2);
				
		}
		
	}

}else{


	unset($_SESSION['SesCpaFoto'.$Identificador]);
	
	$InsClientePago->FpaId = "FPA-10000";
	$InsClientePago->CpaEstado = 3;
	$InsClientePago->CpaTipo = 1;
	
}
?>