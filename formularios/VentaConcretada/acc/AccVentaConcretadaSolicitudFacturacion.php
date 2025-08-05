<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnEnviarCorreo_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsVentaConcretada->UsuId = $_SESSION['SesionId'];	
	
	$InsVentaConcretada->VcoId = $_POST['CmpId'];
	$InsVentaConcretada->CliId = $_POST['CmpClienteId'];
	$InsVentaConcretada->TopId = "TOP-10000";	
	
	$InsVentaConcretada->AlmId = $_POST['CmpAlmacen'];
	$InsVentaConcretada->VcoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	$InsVentaConcretada->MonId = $_POST['CmpMonedaId'];
	$InsVentaConcretada->VcoTipoCambio = $_POST['CmpTipoCambio'];
	//$InsVentaConcretada->MonId = $EmpresaMonedaId;
	//$InsVentaConcretada->VcoTipoCambio = NULL;

	$InsVentaConcretada->VcoObservacion = addslashes($_POST['CmpObservacion']);
	$InsVentaConcretada->VcoDescuento = eregi_replace(",","",$_POST['CmpDescuento']);
	$InsVentaConcretada->VcoManoObra = eregi_replace(",","",$_POST['CmpManoObra']);
	
	if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
		$InsVentaConcretada->VcoDescuento = $InsVentaConcretada->VcoDescuento * $InsVentaConcretada->VcoTipoCambio;
	}
	
	
	if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
		$InsVentaConcretada->VcoManoObra = $InsVentaConcretada->VcoManoObra * $InsVentaConcretada->VcoTipoCambio;
	}
	
	$InsVentaConcretada->VcoIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	
	$InsVentaConcretada->VcoEstado = $_POST['CmpEstado'];
	$InsVentaConcretada->VcoTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsVentaConcretada->VcoPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
//	$InsVentaConcretada->VcoMargenUtilidad = $_POST['CmpClienteTipoUtilidad'];
	$InsVentaConcretada->VcoMargenUtilidad = 0;
	$InsVentaConcretada->LtiId = $_POST['CmpClienteTipo'];	
		
	$InsVentaConcretada->CliNombre = $_POST['CmpClienteNombre'];
	$InsVentaConcretada->TdoId = $_POST['CmpClienteTipoDocumento'];	
	$InsVentaConcretada->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsVentaConcretada->CliTelefono = $_POST['CmpClienteTelefono'];

	$InsVentaConcretada->CliEmail = $_POST['CmpClienteEmail'];
	$InsVentaConcretada->CliCelular = $_POST['CmpClienteCelular'];
	$InsVentaConcretada->CliFax = $_POST['CmpClienteFax'];

	$InsVentaConcretada->VcoDireccion = $_POST['CmpClienteDireccion'];	

	$InsVentaConcretada->CliNombreSeguro = $_POST['CmpClienteNombreSeguro'];
	$InsVentaConcretada->CliApellidoPaternoSeguro = $_POST['CmpClienteApellidoPaternoSeguro'];
	$InsVentaConcretada->CliApellidoMaternoSeguro = $_POST['CmpClienteApellidoMaternoSeguro'];
	
	$InsVentaConcretada->VdiId = $_POST['CmpVentaDirectaId'];	
	$InsVentaConcretada->CprId = $_POST['CmpCotizacionProductoId'];	
	
	$InsVentaConcretada->FinId = $_POST['CmpFichaIngresoId'];
	
	$InsVentaConcretada->VcoEmpresaTransporte = $_POST['CmpEmpresaTransporte'];
	$InsVentaConcretada->VcoEmpresaTransporteDocumento = $_POST['CmpEmpresaTransporteDocumento'];
	$InsVentaConcretada->VcoEmpresaTransporteClave = $_POST['CmpEmpresaTransporteClave'];
	$InsVentaConcretada->VcoEmpresaTransporteFecha = FncCambiaFechaAMysql($_POST['CmpEmpresaTransporteFecha'],true);
	$InsVentaConcretada->VcoEmpresaTransporteTipoEnvio = $_POST['CmpEmpresaTransporteTipoEnvio'];
	$InsVentaConcretada->VcoEmpresaTransporteDestino = $_POST['CmpEmpresaTransporteDestino'];
	
	$InsVentaConcretada->VentaConcretadaDetalle = array();
	
	$InsVentaConcretada->VcoSubTotal = 0;
	$InsVentaConcretada->VcoImpuesto = 0;
	$InsVentaConcretada->VcoTotal = 0;

	$Destinatario = eregi_replace(" ","",$_POST['CmpDestinatario']);
	
	if(!empty($Destinatario)){
		
			$InsNotificacion = new ClsNotificacion();
			$InsNotificacion->UsuId = "USU-10001";
			$InsNotificacion->UsuIdOrigen = $_SESSION['SesionId'];
							
			$InsNotificacion->NfnModulo = "ComprobanteVenta";
			$InsNotificacion->NfnFormulario = "MonitoreoVentaConcretada";
			$InsNotificacion->NfnDescripcion = "<b>".$_SESSION['SesionUsuario']."</b> te ha enviado una venta concretada para facturar a nombre de ".$InsVentaConcretada->CliNombre." ".$InsVentaConcretada->CliApellidoPaterno." ".$InsVentaConcretada->CliApellidoMaterno;
			$InsNotificacion->NfnEnlace = "principal.php?Mod=ComprobanteVenta&Form=MonitoreoVentaConcretada";
			$InsNotificacion->NfnEnlaceNombre = "Mostrar";
																					
			$InsNotificacion->NfnTipo = 1;
			$InsNotificacion->NfnEstado = 1;
			$InsNotificacion->NfnTiempoCreacion =date("Y-m-d H:i:s");
			$InsNotificacion->NfnTiempoModificacion =date("Y-m-d H:i:s");

			$InsNotificacion->MtdRegistrarNotificacion();
					
		
			if(!empty($_SESSION['SesionPersonal'])){

				$InsPersonal = new ClsPersonal();
				$InsPersonal->PerId = $_SESSION['SesionPersonal'];
				$InsPersonal->MtdObtenerPersonal();
				
				//$InsVentaConcretada->PerNombre = $InsPersonal->PerNombre;
//				$InsVentaConcretada->PerApellidoPaterno = $InsPersonal->PerApellidoPaterno;
//				$InsVentaConcretada->PerApellidoMaterno = $InsPersonal->PerApellidoMaterno;
				
				$Solicitante = $InsPersonal->PerNombre." ".$InsPersonal->PerApellidoPaterno." ".$InsPersonal->PerApellidoMaterno;
				
				if(!empty($InsPersonal->PerEmail)){
					$Destinatario.=",".$InsPersonal->PerEmail;	
				}
				
			}
			
			$InsVentaConcretada->MtdEnviarCorreoSolicitudFacturacion($Destinatario,$InsVentaConcretada->VcoId,$Solicitante);  
			
	}else{
		$Guardar = false;	
	}
	
	if($Guardar){
		
		if(!empty($GET_dia)){
		?>
			<script type="text/javascript">
            self.parent.tb_remove('<?php echo $GET_mod;?>');
            </script>
		<?php
		}
		
		$Registro = true;
		FncCargarDatos();
		$Resultado.='#SAS_VCO_106';
			
	}else{
		
		$InsVentaConcretada->VcoFecha = FncCambiaFechaANormal($InsVentaConcretada->VcoFecha);
		$InsVentaConcretada->VcoEmpresaTransporteFecha = FncCambiaFechaANormal($InsVentaConcretada->VcoEmpresaTransporteFecha,true);
		
		if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
			$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento / $InsVentaConcretada->VcoTipoCambio,6);
		}
		
		if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
			$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra / $InsVentaConcretada->VcoTipoCambio,6);
		}
		$Resultado.='#ERR_VCO_106';
	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $Identificador;
	global $InsVentaConcretada;
	global $EmpresaMonedaId;

	unset($_SESSION['InsVentaConcretadaDetalle'.$Identificador]);
	unset($_SESSION['SesVcoFoto'.$Identificador]);

	$_SESSION['InsVentaConcretadaDetalle'.$Identificador] = new ClsSesionObjeto();

	$InsVentaConcretada->VcoId = $GET_id;
	$InsVentaConcretada->MtdObtenerVentaConcretada();		

	$_SESSION['SesVcoFoto'.$Identificador] = $InsVentaConcretada->VcoFoto;

	if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
		$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento / $InsVentaConcretada->VcoTipoCambio,6);
	}
	
	if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
		$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra / $InsVentaConcretada->VcoTipoCambio,6);
	}

	$InsVentaConcretada->VcoDestinatarios = $CorreosNotificacionSolicitudFacturacion;		
			
	if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
		foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){

			if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){

				$DatVentaConcretadaDetalle->VcdCosto = round($DatVentaConcretadaDetalle->VcdCosto / $InsVentaConcretada->VcoTipoCambio,2);
				$DatVentaConcretadaDetalle->VcdPrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta / $InsVentaConcretada->VcoTipoCambio,2);
				$DatVentaConcretadaDetalle->VcdImporte = round($DatVentaConcretadaDetalle->VcdImporte / $InsVentaConcretada->VcoTipoCambio,2);

			}

//				SesionObjeto-VentaConcretadaDetalle
//				Parametro1 = VcdId
//				Parametro2 = ProId
//				Parametro3 = ProNombre
//				Parametro4 = VcdPrecio
//				Parametro5 = VcdCantidad
//				Parametro6 = VcdImporte
//				Parametro7 = VcdTiempoCreacion
//				Parametro8 = VcdTiempoModificacion
//				Parametro9 = UmeNombre
//				Parametro10 = UmeId
//				Parametro11 = RtiId
//				Parametro12 = VcdCantidadReal
//				Parametro13 = ProCodigoOriginal,
//				Parametro14 = ProCodigoAlternativo
//				Parametro15 = UmeIdOrigen
//				Parametro16 = VerificarStock
//				Parametro17 = VcdCosto
//				Parametro18 = VddId
//				Parametro19 = AmdReemplazo
//				Parametro20 = ProCodigoOriginalReemplazo
//				Parametro21 = VcdReingreso
//				Parametro22 = VcdCantidadRealAnterior

				$_SESSION['InsVentaConcretadaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
				$DatVentaConcretadaDetalle->VcdId,
				$DatVentaConcretadaDetalle->ProId,
				$DatVentaConcretadaDetalle->ProNombre,
				$DatVentaConcretadaDetalle->VcdPrecioVenta,
				$DatVentaConcretadaDetalle->VcdCantidad,
				$DatVentaConcretadaDetalle->VcdImporte,
				($DatVentaConcretadaDetalle->VcdTiempoCreacion),
				($DatVentaConcretadaDetalle->VcdTiempoModificacion),
				$DatVentaConcretadaDetalle->UmeNombre,
				$DatVentaConcretadaDetalle->UmeId,
				$DatVentaConcretadaDetalle->RtiId,
				$DatVentaConcretadaDetalle->VcdCantidadReal,
				$DatVentaConcretadaDetalle->ProCodigoOriginal,
				$DatVentaConcretadaDetalle->ProCodigoAlternativo,
				$DatVentaConcretadaDetalle->UmeIdOrigen,
				2,
				$DatVentaConcretadaDetalle->VcdCosto,
				$DatVentaConcretadaDetalle->VddId,
				
				$DatVentaConcretadaDetalle->AmdReemplazo,
				$DatVentaConcretadaDetalle->ProCodigoOriginalReemplazo,
				$DatVentaConcretadaDetalle->VcdReingreso,
				$DatVentaConcretadaDetalle->VcdCantidadReal
			);
		
		}
	}
	
}


?>