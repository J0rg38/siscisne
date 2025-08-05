
<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';
	
	$InsCliente->UsuId = $_SESSION['SesionId'];	
	
	$InsCliente->CliId = $_POST['CmpId'];
	$InsCliente->LtiId = $_POST['CmpTipo'];
	$InsCliente->TdoId = $_POST['CmpTipoDocumento'];
	$InsCliente->CliTipoDocumentoOtro = $_POST['CmpTipoDocumentoOtro'];
	$InsCliente->CliNombre = addslashes($_POST['CmpNombre']);
	$InsCliente->CliApellidoPaterno = addslashes($_POST['CmpApellidoPaterno']);
	$InsCliente->CliApellidoMaterno = addslashes($_POST['CmpApellidoMaterno']);
	$InsCliente->CliNombreComercial = addslashes($_POST['CmpNombreComercial']);
		
	$InsCliente->CliRepresentanteNombre = addslashes($_POST['CmpRepresentanteNombre']);
	$InsCliente->CliRepresentanteNumeroDocumento = ($_POST['CmpRepresentanteNumeroDocumento']);
	$InsCliente->CliRepresentanteNacionalidad = ($_POST['CmpRepresentanteNacionalidad']);
	$InsCliente->CliRepresentanteActividadEconomica = ($_POST['CmpRepresentanteActividadEconomica']);
	
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
	
	$InsCliente->CliClasificacion = 1;
	$InsCliente->CliEstado = $_POST['CmpEstado'];
	$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
	$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
	$InsCliente->CliEliminado = 1;


	if(!empty($InsCliente->CliNumeroDocumento)){
		
		if($InsCliente->TdoId == "TDO-10001"){//DNI
			
			if(strlen($InsCliente->CliNumeroDocumento)<8 or strlen($InsCliente->CliNumeroDocumento)>8){
				$Guardar = false;
				$Resultado.='#ERR_CLI_108';
			}
			
		}else if($InsCliente->TdoId == "TDO-10003"){//ruc
			
			if(strlen($InsCliente->CliNumeroDocumento)<11 or strlen($InsCliente->CliNumeroDocumento)>11){
				$Guardar = false;
				$Resultado.='#ERR_CLI_109';
			}
			
		}
	}
	
	if($InsCliente->MonId<>$EmpresaMonedaId and !empty($InsCliente->MonId)){
		if(empty($InsCliente->CliTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_CLI_600';
		}
	}
	
	
	if($InsCliente->MonId<>$EmpresaMonedaId ){
		$InsCliente->CliLineaCredito = round($InsCliente->CliLineaCredito * $InsCliente->CliTipoCambio,3);
	}	
	
	if(!empty($InsCliente->CliNumeroDocumento)){
		
	}
	
	if($Guardar){
		if($InsCliente->MtdRegistrarCliente()){
	
				if(!empty($GET_dia)){
	?>
	<script type="text/javascript">
		<?php
		if(!empty($GET_Tipo)){
		?>
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.FncClienteSimpleCargar("<?php echo $GET_Tipo;?>","<?php echo $InsCliente->CliId;?>");

		<?php			
		}else{
		?>
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.$('#CmpClienteId').val("<?php echo $InsCliente->CliId;?>");
			self.parent.FncClienteSimpleBuscar("Id");
		<?php	
		}
		?>
	</script>
	<?php
				}
			
			$Registro = true;
			unset($InsCliente);	
			$Resultado.='#SAS_CLI_101';		
		} else{
			
			if($InsCliente->MonId<>$EmpresaMonedaId and !empty($InsCliente->MonId)){
				$InsCliente->CliLineaCredito = round($InsCliente->CliLineaCredito / $InsCliente->CliTipoCambio,3);
			}
		
			$InsCliente->CliFechaNacimiento = FncCambiaFechaANormal($InsCliente->CliFechaNacimiento,true);
			$InsCliente->CliTipoCambioFecha = FncCambiaFechaANormal($InsCliente->CliTipoCambioFecha,true);
			$Resultado.='#ERR_CLI_101';
		}
	}else{
		
		if($InsCliente->MonId<>$EmpresaMonedaId and !empty($InsCliente->MonId)){
			$InsCliente->CliLineaCredito = round($InsCliente->CliLineaCredito / $InsCliente->CliTipoCambio,3);
		}
		
		$InsCliente->CliFechaNacimiento = FncCambiaFechaANormal($InsCliente->CliFechaNacimiento,true);
		$InsCliente->CliTipoCambioFecha = FncCambiaFechaANormal($InsCliente->CliTipoCambioFecha,true);
		$Resultado.='#ERR_CLI_101';
	}

//deb($Registro);
}else{

	FncNuevo();
		
	$InsCliente->CliNombre = $GET_ClienteNombre;
	$InsCliente->TdoId = empty($GET_TipoDocumentoId)?"TDO-10001":$GET_TipoDocumentoId;
	$InsCliente->CliNumeroDocumento = $GET_ClienteNumeroDocumento;
	$InsCliente->CliDireccion = ($GET_ClienteDireccion=="undefined")?"":$GET_ClienteDireccion;
	$InsCliente->CliCelular = ($GET_ClienteCelular=="undefined")?"":$GET_ClienteCelular;
	$InsCliente->CliTelefono = ($GET_ClienteTelefono=="undefined")?"":$GET_ClienteTelefono;
	$InsCliente->CliEmail = ($GET_ClienteEmail=="undefined")?"":$GET_ClienteEmail;
	$InsCliente->LtiId = empty($GET_ClienteTipoId)?"LTI-10011":$GET_ClienteTipoId;
	
	$InsCliente->CliTipoCambioFecha = date("d/m/Y");
	
	
}


function FncNuevo(){
	
	global $InsCliente;
	
	unset($_SESSION['SesCliArchivo'.$Identificador]);
	
	$InsCliente->LtiId = "LTI-10011";
	$InsCliente->TdoId = "TDO-10001";
	$InsCliente->CliCSIIncluir = 1;
}
?>