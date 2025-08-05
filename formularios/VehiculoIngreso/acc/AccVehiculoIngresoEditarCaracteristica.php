<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsVehiculoIngreso->UsuId = $_SESSION['SesionId'];	
	
	$InsVehiculoIngreso->EinId = $_POST['CmpId'];
	$InsVehiculoIngreso->EinVIN = $_POST['CmpVIN'];
	
	$InsVehiculoIngreso->VmaId = $_POST['CmpVehiculoMarca'];
	$InsVehiculoIngreso->VmoId = $_POST['CmpVehiculoModelo'];
	$InsVehiculoIngreso->VveId = $_POST['CmpVehiculoVersion'];
	$InsVehiculoIngreso->VehId = $_POST['CmpVehiculoId'];
	
	
	$InsVehiculoIngreso->EinAnoFabricacion = $_POST['CmpAnoFabricacion'];
	$InsVehiculoIngreso->EinAnoModelo = $_POST['CmpAnoModelo'];
	$InsVehiculoIngreso->EinNumeroMotor = $_POST['CmpVehiculoVersionCaracteristicaNumeroMotor'];

	$InsVehiculoIngreso->EinColor = $_POST['CmpColor'];
	$InsVehiculoIngreso->EinColorInterno = $_POST['CmpColorInterior'];
	
	$InsVehiculoIngreso->EinDUA = $_POST['CmpDUA'];
	$InsVehiculoIngreso->EinPoliza = $_POST['CmpPoliza'];	
	$InsVehiculoIngreso->EinNombre = $_POST['CmpVehiculoIngresoNombre'];	
	
	
	$InsVehiculoIngreso->VveCaracteristica1 = addslashes($_POST['CmpVehiculoVersionCaracteristica1']);
	$InsVehiculoIngreso->VveCaracteristica2 = addslashes($_POST['CmpVehiculoVersionCaracteristica2']);
	$InsVehiculoIngreso->VveCaracteristica3 = addslashes($_POST['CmpVehiculoVersionCaracteristica3']);
	$InsVehiculoIngreso->VveCaracteristica4 = addslashes($_POST['CmpVehiculoVersionCaracteristica4']);
	$InsVehiculoIngreso->VveCaracteristica5 = addslashes($_POST['CmpVehiculoVersionCaracteristica5']);
	$InsVehiculoIngreso->VveCaracteristica6 = addslashes($_POST['CmpVehiculoVersionCaracteristica6']);
	$InsVehiculoIngreso->VveCaracteristica7 = addslashes($_POST['CmpVehiculoVersionCaracteristica7']);
	$InsVehiculoIngreso->VveCaracteristica8 = addslashes($_POST['CmpVehiculoVersionCaracteristica8']);
	$InsVehiculoIngreso->VveCaracteristica9 = addslashes($_POST['CmpVehiculoVersionCaracteristica9']);
	$InsVehiculoIngreso->VveCaracteristica10 = addslashes($_POST['CmpVehiculoVersionCaracteristica10']);
	
	$InsVehiculoIngreso->VveCaracteristica11 = addslashes($_POST['CmpVehiculoVersionCaracteristica11']);
	$InsVehiculoIngreso->VveCaracteristica12 = addslashes($_POST['CmpVehiculoVersionCaracteristica12']);
	$InsVehiculoIngreso->VveCaracteristica13 = addslashes($_POST['CmpVehiculoVersionCaracteristica13']);
	$InsVehiculoIngreso->VveCaracteristica14 = addslashes($_POST['CmpVehiculoVersionCaracteristica14']);
	$InsVehiculoIngreso->VveCaracteristica15 = addslashes($_POST['CmpVehiculoVersionCaracteristica15']);
	$InsVehiculoIngreso->VveCaracteristica16 = addslashes($_POST['CmpVehiculoVersionCaracteristica16']);
	$InsVehiculoIngreso->VveCaracteristica17 = addslashes($_POST['CmpVehiculoVersionCaracteristica17']);	
	$InsVehiculoIngreso->VveCaracteristica18 = addslashes($_POST['CmpVehiculoVersionCaracteristica18']);
	$InsVehiculoIngreso->VveCaracteristica19 = addslashes($_POST['CmpVehiculoVersionCaracteristica19']);
	$InsVehiculoIngreso->VveCaracteristica20 = addslashes($_POST['CmpVehiculoVersionCaracteristica20']);
	
	
		$InsVehiculoIngreso->EinCaracteristica1 = addslashes($_POST['CmpVehiculoVersionCaracteristica1']);
		$InsVehiculoIngreso->EinCaracteristica2 = addslashes($_POST['CmpVehiculoVersionCaracteristica2']);
		$InsVehiculoIngreso->EinCaracteristica3 = addslashes($_POST['CmpVehiculoVersionCaracteristica3']);
		$InsVehiculoIngreso->EinCaracteristica4 = addslashes($_POST['CmpVehiculoVersionCaracteristica4']);
		$InsVehiculoIngreso->EinCaracteristica5 = addslashes($_POST['CmpVehiculoVersionCaracteristica5']);
		$InsVehiculoIngreso->EinCaracteristica6 = addslashes($_POST['CmpVehiculoVersionCaracteristica6']);
		$InsVehiculoIngreso->EinCaracteristica7 = addslashes($_POST['CmpVehiculoVersionCaracteristica7']);
		$InsVehiculoIngreso->EinCaracteristica8 = addslashes($_POST['CmpVehiculoVersionCaracteristica8']);
		$InsVehiculoIngreso->EinCaracteristica9 = addslashes($_POST['CmpVehiculoVersionCaracteristica9']);
		$InsVehiculoIngreso->EinCaracteristica10 = addslashes($_POST['CmpVehiculoVersionCaracteristica10']);
		
		$InsVehiculoIngreso->EinCaracteristica11 = addslashes($_POST['CmpVehiculoVersionCaracteristica11']);
		$InsVehiculoIngreso->EinCaracteristica12 = addslashes($_POST['CmpVehiculoVersionCaracteristica12']);
		$InsVehiculoIngreso->EinCaracteristica13 = addslashes($_POST['CmpVehiculoVersionCaracteristica13']);
		$InsVehiculoIngreso->EinCaracteristica14 = addslashes($_POST['CmpVehiculoVersionCaracteristica14']);
		$InsVehiculoIngreso->EinCaracteristica15 = addslashes($_POST['CmpVehiculoVersionCaracteristica15']);
		$InsVehiculoIngreso->EinCaracteristica16 = addslashes($_POST['CmpVehiculoVersionCaracteristica16']);
		$InsVehiculoIngreso->EinCaracteristica17 = addslashes($_POST['CmpVehiculoVersionCaracteristica17']);	
		$InsVehiculoIngreso->EinCaracteristica18 = addslashes($_POST['CmpVehiculoVersionCaracteristica18']);	
		$InsVehiculoIngreso->EinCaracteristica19 = addslashes($_POST['CmpVehiculoVersionCaracteristica19']);	
		$InsVehiculoIngreso->EinCaracteristica20 = addslashes($_POST['CmpVehiculoVersionCaracteristica20']);	
	
	$InsVehiculoIngreso->EinTiempoModificacion = date("Y-m-d H:i:s");

		
	if($InsVehiculoIngreso->MtdEditarVehiculoIngresoCaracteristica()){	
		
//		deb($GET_dia);
		if(!empty($GET_dia)){
?>
			<script type="text/javascript">
           
		    self.parent.tb_remove('<?php echo $GET_mod;?>','','');
			//self.parent.FncVehiculoIngresoCerrarFormulario();
			
            </script>
<?php
		}
			
		$Edito = true;
		$Resultado.='#SAS_EIN_102';	
		FncCargarDatos();	
			
	}else{			
	
		$Resultado.='#ERR_EIN_102';		
	}			

}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsVehiculoIngreso;
	global $Identificador;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsVehiculoIngresoCliente'.$Identificador]);
	unset($_SESSION['InsVehiculoIngresoFoto'.$Identificador]);
	
	$_SESSION['InsVehiculoIngresoCliente'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsVehiculoIngresoFoto'.$Identificador] = new ClsSesionObjeto();
	
	$InsVehiculoIngreso->EinId = $GET_id;
	$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(true);		

	$_SESSION['SesEinArchivoDAM'.$Identificador] = $InsVehiculoIngreso->EinArchivoDAM;
	$_SESSION['SesEinArchivoDAM2'.$Identificador] = $InsVehiculoIngreso->EinArchivoDAM2;
	$_SESSION['SesEinArchivoDAM3'.$Identificador] = $InsVehiculoIngreso->EinArchivoDAM3;
	
	$_SESSION['SesEinFotoVIN'.$Identificador] = $InsVehiculoIngreso->EinFotoVIN;
	$_SESSION['SesEinFotoFrontal'.$Identificador] = $InsVehiculoIngreso->EinFotoFrontal;
	$_SESSION['SesEinFotoCupon'.$Identificador] = $InsVehiculoIngreso->EinFotoCupon;
	$_SESSION['SesEinFotoMantenimiento'.$Identificador] = $InsVehiculoIngreso->EinFotoMantenimiento;
	
	
}

?>