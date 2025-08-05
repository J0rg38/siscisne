<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';
	
	$InsCliente->UsuId = $_SESSION['SesionId'];	
	
	$InsCliente->CliId = $_POST['CmpId'];
	$InsCliente->LtiId = $_POST['CmpTipo'];
	$InsCliente->TdoId = $_POST['CmpTipoDocumento'];
	$InsCliente->TrfId = $_POST['CmpTipoReferido'];
	
	$InsCliente->PerId = $_POST['CmpPersonal'];
	$InsCliente->PerIdAnterior = $_POST['CmpPersonalAnterior'];
	
	
	$InsCliente->CliTipoDocumentoOtro = $_POST['CmpTipoDocumentoOtro'];

	$InsCliente->CliAbreviatura = addslashes($_POST['CmpAbreviatura']);
	$InsCliente->CliNombre = addslashes($_POST['CmpNombre']);
	$InsCliente->CliApellidoPaterno = addslashes($_POST['CmpApellidoPaterno']);
	$InsCliente->CliApellidoMaterno = addslashes($_POST['CmpApellidoMaterno']);
	$InsCliente->CliNombreComercial = addslashes($_POST['CmpNombreComercial']);
	
	$InsCliente->CliRepresentanteNombre = addslashes($_POST['CmpRepresentanteNombre']);
	$InsCliente->CliRepresentanteNumeroDocumento = ($_POST['CmpRepresentanteNumeroDocumento']);
	$InsCliente->CliRepresentanteNacionalidad = ($_POST['CmpRepresentanteNacionalidad']);
	$InsCliente->CliRepresentanteActividadEconomica = ($_POST['CmpRepresentanteActividadEconomica']);
	
	$InsCliente->CliEstadoCivil = ($_POST['CmpEstadoCivil']);
	$InsCliente->CliSexo = ($_POST['CmpSexo']);
	$InsCliente->CliFechaNacimiento = FncCambiaFechaAMysql($_POST['CmpFechaNacimiento'],true);
	
	$InsCliente->CliNumeroDocumento = $_POST['CmpNumeroDocumento'];
	$InsCliente->CliActividadEconomica = $_POST['CmpActividadEconomica'];
	$InsCliente->CliDireccion = $_POST['CmpDireccion'];
	
	$InsCliente->CliDistrito = $_POST['CmpDistrito'];
	$InsCliente->CliProvincia = $_POST['CmpProvincia'];
	$InsCliente->CliDepartamento = $_POST['CmpDepartamento'];
	$InsCliente->CliPais = $_POST['CmpPais'];
	
	$InsCliente->CliTelefono = $_POST['CmpTelefono'];
	$InsCliente->CliCelular = $_POST['CmpCelular'];
	$InsCliente->CliEmail = $_POST['CmpEmail'];
	
	$InsCliente->CliContactoNombre1 = $_POST['CmpContactoNombre1'];
	$InsCliente->CliContactoCelular1 = $_POST['CmpContactoCelular1'];
	$InsCliente->CliContactoEmail1 = $_POST['CmpContactoEmail1'];
	
	$InsCliente->CliContactoNombre2 = $_POST['CmpContactoNombre2'];
	$InsCliente->CliContactoCelular2 = $_POST['CmpContactoCelular2'];
	$InsCliente->CliContactoEmail2 = $_POST['CmpContactoEmail2'];
	
	$InsCliente->CliContactoNombre3 = $_POST['CmpContactoNombre3'];
	$InsCliente->CliContactoCelular3 = $_POST['CmpContactoCelular3'];
	$InsCliente->CliContactoEmail3 = $_POST['CmpContactoEmail3'];
		
	$InsCliente->MonId = $_POST['CmpMonedaId'];
	$InsCliente->CliTipoCambioFecha = FncCambiaFechaAMysql($_POST['CmpTipoCambioFecha'],true);
	$InsCliente->CliTipoCambio = $_POST['CmpTipoCambio'];
	$InsCliente->CliLineaCredito = eregi_replace(",","",(empty($_POST['CmpLineaCredito'])?0:$_POST['CmpLineaCredito']));

	$InsCliente->CliCSIIncluir = (empty($_POST['CmpCSIIncluir'])?2:$_POST['CmpCSIIncluir']);
	$InsCliente->CliCSIExcluirMotivo = addslashes($_POST['CmpCSIExcluirMotivo']);
	
	$InsCliente->CliCSIVentaIncluir = (empty($_POST['CmpCSIVentaIncluir'])?2:$_POST['CmpCSIVentaIncluir']);
	$InsCliente->CliCSIVentaExcluirMotivo = addslashes($_POST['CmpCSIVentaExcluirMotivo']);
	
	$InsCliente->CliArchivo = $_SESSION['SesCliArchivo'.$Identificador];
	
	$InsCliente->CliClaveElectronica = $_POST['CmpClaveElectronica'];
	$InsCliente->CliEmailFacturacion = $_POST['CmpEmailFacturacion'];
	
	$InsCliente->CliClasificacion = 1;
	$InsCliente->CliObservacion = addslashes($_POST['CmpObservacion']);
	$InsCliente->CliEstado = $_POST['CmpEstado'];
	$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
	
	if(!empty($InsCliente->CliNumeroDocumento)){
		
		if($InsCliente->TdoId == "TDO-10001"){//DNI
			
			if(strlen($InsCliente->CliNumeroDocumento)<8 or strlen($InsCliente->CliNumeroDocumento)>8){
				$Guardar = false;
				$Resultado.='#ERR_CLI_601';
			}
			
		}else if($InsCliente->TdoId == "TDO-10003"){//ruc
			
			if(strlen($InsCliente->CliNumeroDocumento)<11 or strlen($InsCliente->CliNumeroDocumento)>11){
				$Guardar = false;
				$Resultado.='#ERR_CLI_602';
			}
			
		}
	}
	
	
	
	

	if($InsCliente->MonId<>$EmpresaMonedaId and !empty($InsCliente->MonId)){
		if(empty($InsCliente->CliTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_CLI_600';
		}
	}
	
	
	if($InsCliente->MonId<>$EmpresaMonedaId and !empty($InsCliente->MonId)){
		$InsCliente->CliLineaCredito = round($InsCliente->CliLineaCredito * $InsCliente->CliTipoCambio,3);
	}	

	if($Guardar){

		if($InsCliente->MtdEditarCliente()){
			
				if($InsCliente->PerId <> $InsCliente->PerIdAnterior){
				
				if(!empty($InsCliente->PerId)){
					
					$InsClientePersonal = new ClsClientePersonal();
					$InsClientePersonal->CliId = $InsCliente->CliId;
					$InsClientePersonal->PerId = $InsCliente->PerId;
					$InsClientePersonal->CpeFecha = date("Y-m-d");
					$InsClientePersonal->CpeObservacion = "Se cambio al personal registrado";
					
					$InsClientePersonal->CpeEstado = 3;
					$InsClientePersonal->CpeTiempoCreacion = date("Y-m-d H:i:s");
					$InsClientePersonal->CpeTiempoModificacion = date("Y-m-d H:i:s");
					
					$InsClientePersonal->MtdRegistrarClientePersonal();
				
				}
				
				
			}
			
			

			if(!empty($GET_dia)){
?>
<script type="text/javascript">


		<?php
		if(!empty($GET_Tipo)){
		?>
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.FncClienteCargar("<?php echo $GET_Tipo;?>","<?php echo $InsCliente->CliId;?>");
		<?php			
		}else{
		?>
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.$('#CmpClienteId').val("<?php echo $InsCliente->CliId;?>");
			self.parent.FncClienteBuscar("Id");
		<?php	
		}
		?>
		
		
//self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
			}
			$Edito = true;
			FncCargarDatos();	
			$Resultado.='#SAS_CLI_102';		
		}else{			
		
			if($InsCliente->MonId<>$EmpresaMonedaId and !empty($InsCliente->MonId)){
				$InsCliente->CliLineaCredito = round($InsCliente->CliLineaCredito / $InsCliente->CliTipoCambio,3);
			}
		
			$InsCliente->CliFechaNacimiento = FncCambiaFechaANormal($InsCliente->CliFechaNacimiento,true);
			$InsCliente->CliTipoCambioFecha = FncCambiaFechaANormal($InsCliente->CliTipoCambioFecha,true);
			$Resultado.='#ERR_CLI_102';		
		}			

		
	}else{

		if($InsCliente->MonId<>$EmpresaMonedaId and !empty($InsCliente->MonId)){
			$InsCliente->CliLineaCredito = round($InsCliente->CliLineaCredito / $InsCliente->CliTipoCambio,3);
		}
			
		$InsCliente->CliFechaNacimiento = FncCambiaFechaANormal($InsCliente->CliFechaNacimiento,true);
		$InsCliente->CliTipoCambioFecha = FncCambiaFechaANormal($InsCliente->CliTipoCambioFecha,true);
		$Resultado.='#SAS_CLI_102';
	}
			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsCliente;
	global $Identificador;
	global $EmpresaMonedaId;

	unset($_SESSION['SesCliArchivo'.$Identificador]);
	unset($_SESSION['InsClienteVehiculoIngreso'.$Identificador]);

	$_SESSION['InsClienteVehiculoIngreso'.$Identificador] = new ClsSesionObjeto();
	
	$InsCliente->CliId = $GET_id;
	$InsCliente->MtdObtenerCliente(true);			
	
	$InsCliente->PerIdAnterior = $InsCliente->PerId;
	
	
	$_SESSION['SesCliArchivo'.$Identificador] = $InsCliente->CliArchivo;
	
	if($InsCliente->MonId<>$EmpresaMonedaId and !empty($InsCliente->MonId)){
		
		$InsCliente->CliLineaCredito = round($InsCliente->CliLineaCredito  / $InsCliente->CliTipoCambio,2);
	
	}
	
	if(empty($InsCliente->CliTipoCambioFecha)){
		$InsCliente->CliTipoCambioFecha = date("d/m/Y");
	}
	
	if(!empty($InsCliente->ClienteVehiculoIngreso)){
		foreach($InsCliente->ClienteVehiculoIngreso as $DatClienteVehiculoIngreso){


//SesionObjeto-ClienteVehiculoIngreso
//Parametro1 = 
//Parametro2 = EinVIN
//Parametro3 = VmaNombre
//Parametro4 = VmoNombre
//Parametro5 = VveNombre
//Parametro6 = EinPlaca
//Parametro7 = EinTiempoCreacion
//Parametro8 = EinTiempoModificacion
//Parametro9 = EinColor

			$_SESSION['InsClienteVehiculoIngreso'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			$DatClienteVehiculoIngreso->EinVIN,
			$DatClienteVehiculoIngreso->VmaNombre,
			$DatClienteVehiculoIngreso->VmoNombre,
			$DatClienteVehiculoIngreso->VveNombre,
			$DatClienteVehiculoIngreso->EinPlaca,
			($DatClienteVehiculoIngreso->EinTiempoCreacion),
			($DatClienteVehiculoIngreso->EinTiempoModificacion),
			$DatClienteVehiculoIngreso->EinColor
			);
		
		}
	}
	
}
?>