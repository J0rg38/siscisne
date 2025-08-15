<?php
//Si se hizo click en guardar	
		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsConfiguracionEmpresa->CemId = $_POST['CmpId'];
	$InsConfiguracionEmpresa->CemNombre = $_POST['CmpNombre'];
	$InsConfiguracionEmpresa->CemNombreComercial = $_POST['CmpNombreComercial'];	
	$InsConfiguracionEmpresa->CemCodigo = $_POST['CmpCodigo'];
	$InsConfiguracionEmpresa->CemWeb = $_POST['CmpWeb'];
	
	$InsConfiguracionEmpresa->CemEmail = $_POST['CmpEmail'];
	$InsConfiguracionEmpresa->CemTelefono = $_POST['CmpTelefono'];
	$InsConfiguracionEmpresa->CemFax = $_POST['CmpFax'];
	$InsConfiguracionEmpresa->CemPais = $_POST['CmpPais'];
	$InsConfiguracionEmpresa->CemPaisAbreviacion = $_POST['CmpPaisAbreviacion'];
	$InsConfiguracionEmpresa->CemCodigoUbigeo = $_POST['CmpCodigoUbigeo'];
	
	$InsConfiguracionEmpresa->CemRepresentanteNombre = $_POST['CmpRepresentanteNombre'];
	$InsConfiguracionEmpresa->CemRepresentanteNumeroDocumento = $_POST['CmpRepresentanteNumeroDocumento'];
	
	$InsConfiguracionEmpresa->CemDireccion = $_POST['CmpDireccion'];
	$InsConfiguracionEmpresa->CemDepartamento = $_POST['CmpDepartamento'];
	$InsConfiguracionEmpresa->CemDistrito = $_POST['CmpDistrito'];
	$InsConfiguracionEmpresa->CemProvincia = $_POST['CmpProvincia'];				
	$InsConfiguracionEmpresa->CemLogo = $_POST['CmpLogo'];
	$InsConfiguracionEmpresa->MonId = $_POST['CmpMoneda'];

	$InsConfiguracionEmpresa->CemImpuestoVenta = preg_replace("/,/", "", (empty($_POST['CmpImpuestoVenta'])?0:$_POST['CmpImpuestoVenta']));
	$InsConfiguracionEmpresa->CemImpuestoSelectivo = preg_replace("/,/", "", (empty($_POST['CmpImpuestoSelectivo'])?0:$_POST['CmpImpuestoSelectivo']));
	$InsConfiguracionEmpresa->CemImpuestoRenta = preg_replace("/,/", "", (empty($_POST['CmpImpuestoRenta'])?0:$_POST['CmpImpuestoRenta']));

	$InsConfiguracionEmpresa->CalId = $_POST['CmpCalificacion'];

	$InsConfiguracionEmpresa->CemArticuloTipoCodificacion = 0;
	
	$InsMoneda->MonId = $InsConfiguracionEmpresa->EmpresaMonedaId;
	$InsMoneda->MtdObtenerMoneda();

	$InsConfiguracionEmpresa->EmpresaMoneda = $InsMoneda->MonSimbolo;
	$InsConfiguracionEmpresa->EmpresaMonedaNombre = $InsMoneda->MonNombre;
	
	$InsConfiguracionEmpresa->AlmId = $_POST['CmpAlmacen'];
	$InsConfiguracionEmpresa->CemMantenimientoPorcentajeManoObra = preg_replace("/,/", "", (empty($_POST['CmpMantenimientoPorcentajeManoObra'])?0:$_POST['CmpMantenimientoPorcentajeManoObra']));
	
	$InsConfiguracionEmpresa->CemRepuestoMargenUtilidad = preg_replace("/,/", "", (empty($_POST['CmpRepuestoMargenUtilidad'])?0:$_POST['CmpRepuestoMargenUtilidad']));
	$InsConfiguracionEmpresa->CemRepuestoFlete = preg_replace("/,/", "", (empty($_POST['CemRepuestoFlete'])?0:$_POST['CemRepuestoFlete']));
	
	$InsConfiguracionEmpresa->CemTiempoModificacion = date("Y-m-d H:i:s");
	
	if($InsConfiguracionEmpresa->MtdEditarConfiguracionEmpresa()){			
		
		//$InsConfiguracionEmpresa = new ClsConfiguracionEmpresa();
//		$InsConfiguracionEmpresa->CemId = "CEM-10000";
		$InsConfiguracionEmpresa->CemRuta = $InsProyecto->MtdRutConfiguraciones();
		$InsConfiguracionEmpresa->MtdGenerarConfiguracionEmpresa();


		//$InsConfiguracionEmpresa->MtdGenerarConfiguracionEmpresa();
			
		$Resultado.='#SAS_CON_102';
		FncCargarDatos();
	}else{			
		$Resultado.='#ERR_CON_102';		
	}			

}else{
	FncCargarDatos();
}


function FncCargarDatos(){

	global $InsConfiguracionEmpresa;

	$InsConfiguracionEmpresa->CemId = "CEM-10000";
	$InsConfiguracionEmpresa->MtdObtenerConfiguracionEmpresa();	

}
?>