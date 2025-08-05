<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnEnviarCorreo_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

		$InsOrdenVentaVehiculo->OvvId = $_POST['CmpId'];
	$InsOrdenVentaVehiculo->SucId = $_SESSION['SesionSucursal'];
	
	$InsOrdenVentaVehiculo->PerId = $_POST['CmpPersonal'];
	$InsOrdenVentaVehiculo->CliId = $_POST['CmpClienteId'];
	$InsOrdenVentaVehiculo->TdoId = $_POST['CmpTipoDocumentoId'];

	$InsOrdenVentaVehiculo->MonId = $_POST['CmpMonedaId'];
	$InsOrdenVentaVehiculo->OvvTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsOrdenVentaVehiculo->MpaId = $_POST['CmpModalidadPago'];
	
	$InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	$InsOrdenVentaVehiculo->OvvFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsOrdenVentaVehiculo->OvvFechaEntrega = FncCambiaFechaAMysql($_POST['CmpFechaEntrega'],true);
	
list($InsOrdenVentaVehiculo->OvvAno,$InsOrdenVentaVehiculo->OvvMes,$aux) = explode("-",$InsOrdenVentaVehiculo->OvvFecha);
	$InsOrdenVentaVehiculo->OvvObservacion = addslashes($_POST['CmpObservacion']);

	$InsOrdenVentaVehiculo->OvvTelefono = $_POST['CmpClienteTelefono'];
	$InsOrdenVentaVehiculo->OvvCelular = $_POST['CmpClienteCelular'];
	$InsOrdenVentaVehiculo->OvvDireccion = $_POST['CmpClienteDireccion'];
	$InsOrdenVentaVehiculo->OvvEmail = $_POST['CmpClienteEmail'];

	$InsOrdenVentaVehiculo->OvvIncluyeImpuesto = 1;
	
	$InsOrdenVentaVehiculo->OvvCondicionVenta = $_POST['CmpCondicionVenta'];
	$InsOrdenVentaVehiculo->OvvCondicionVentaOtro = $_POST['CmpCondicionVentaOtro'];
	$InsOrdenVentaVehiculo->OvvObsequio = $_POST['CmpObsequio'];
	$InsOrdenVentaVehiculo->OvvObsequioOtro = $_POST['CmpObsequioOtro'];
	
	$InsOrdenVentaVehiculo->OvvComprobanteVenta = $_POST['CmpComprobanteVenta'];
	
	$InsOrdenVentaVehiculo->OvvNota = addslashes($_POST['CmpNota']);	
	$InsOrdenVentaVehiculo->OvvPlaca = $_POST['CmpPlaca'];	
	$InsOrdenVentaVehiculo->OvvEstado = $_POST['CmpEstado'];
	$InsOrdenVentaVehiculo->OvvTiempoModificacion = date("Y-m-d H:i:s");

	$InsOrdenVentaVehiculo->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsOrdenVentaVehiculo->CliNombre = $_POST['CmpClienteNombre'];
	$InsOrdenVentaVehiculo->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
		

	$InsOrdenVentaVehiculo->VmaId = $_POST['CmpVehiculoMarca'];
	$InsOrdenVentaVehiculo->VmoId = $_POST['CmpVehiculoModelo'];
	$InsOrdenVentaVehiculo->VveId = $_POST['CmpVehiculoVersion'];	

	$InsOrdenVentaVehiculo->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsOrdenVentaVehiculo->OvvAnoModelo = $_POST['CmpVehiculoAnoModelo'];
	$InsOrdenVentaVehiculo->OvvAnoFabricacion = $_POST['CmpVehiculoAnoFabricacion'];
	$InsOrdenVentaVehiculo->OvvColor = $_POST['CmpVehiculoColor'];
	$InsOrdenVentaVehiculo->OvvGLP = $_POST['CmpGLP'];
	$InsOrdenVentaVehiculo->CveId = $_POST['CmpCotizacionVehiculoId'];


	$InsOrdenVentaVehiculo->OvvActaEntregaFecha = FncCambiaFechaAMysql($_POST['CmpActaEntregaFecha'],true);
	$InsOrdenVentaVehiculo->OvvActaEntregaDescripcion = addslashes($_POST['CmpActaEntregaDescripcion']);
	
	
	$InsOrdenVentaVehiculo->OvvTotalBruto = 0;

	$InsOrdenVentaVehiculo->OvvPrecio = eregi_replace(",","",$_POST['CmpPrecio']);
	$InsOrdenVentaVehiculo->OvvDescuento = eregi_replace(",","",$_POST['CmpDescuento']);
	$InsOrdenVentaVehiculo->OvvDescuento = (empty($InsOrdenVentaVehiculo->OvvDescuento)?0:$InsOrdenVentaVehiculo->OvvDescuento);
	
	$InsOrdenVentaVehiculo->OvvBonoGM = eregi_replace(",","",$_POST['CmpBonoGM']);
	$InsOrdenVentaVehiculo->OvvBonoDealer = eregi_replace(",","",$_POST['CmpBonoDealer']);
	$InsOrdenVentaVehiculo->OvvDescuentoGerencia = eregi_replace(",","",$_POST['CmpDescuentoGerencia']);
	$InsOrdenVentaVehiculo->OvvDescuentoGerencia = (empty($InsOrdenVentaVehiculo->OvvDescuentoGerencia)?0:$InsOrdenVentaVehiculo->OvvDescuentoGerencia);
	
	$InsOrdenVentaVehiculo->OvvTotal = eregi_replace(",","",$_POST['CmpTotal']);
	$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal,6);
	

	$InsOrdenVentaVehiculo->OvvSubTotal = round( ($InsOrdenVentaVehiculo->OvvTotal /( ($InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta/100)+1 ) ) ,6);
	$InsOrdenVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvTotal - $InsOrdenVentaVehiculo->OvvSubTotal;



	$InsOrdenVentaVehiculo->CveTotal = eregi_replace(",","",$_POST['CmpCotizacionVehiculoTotal']);

	$InsOrdenVentaVehiculo->EinVIN = $_POST['CmpVehiculoIngresoVIN'];

	$InsOrdenVentaVehiculo->OvvNotificar = (empty($_POST['CmpNotificar'])?2:$_POST['CmpNotificar']);
	$InsOrdenVentaVehiculo->OvvEntregaNotificar = (empty($_POST['CmpEntregaNotificar'])?2:$_POST['CmpEntregaNotificar']);



	if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId and !empty($InsOrdenVentaVehiculo->OvvTipoCambio)){

		$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
	
		$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia * $InsOrdenVentaVehiculo->OvvTipoCambio,3);

		$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal * $InsOrdenVentaVehiculo->OvvTipoCambio,6);
		$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto * $InsOrdenVentaVehiculo->OvvTipoCambio,6);
		$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal * $InsOrdenVentaVehiculo->OvvTipoCambio,6);
		
		$InsOrdenVentaVehiculo->CveTotal = round($InsOrdenVentaVehiculo->CveTotal * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
	}	

	if($Guardar){
		
		$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvObservacionCorreo",$InsOrdenVentaVehiculo->OvvObservacionCorreo,$InsOrdenVentaVehiculo->OvvId);
	
		if(!empty($InsOrdenVentaVehiculo->OvvDestinatarios)){
			
					
					// MtdEnviarCorreoSolicitarAutorizacionOrdenVentaVehiculo($oOrdenCompra,$oDestinatario,$oRemitente,$oAdjunto=array()){
					//if($InsOrdenVentaVehiculo->MtdEnviarCorreoSolicitarAutorizacionOrdenVentaVehiculo($InsOrdenVentaVehiculo->OvvId,$InsOrdenVentaVehiculo->OvvDestinatarios,$_SESSION['SesionNombre'],array("generados/pedido_compra/".$InsOrdenVentaVehiculo->OvvId.".xls"))){
						if($InsOrdenVentaVehiculo->MtdEnviarCorreoConfirmarEntregaOrdenVentaVehiculo($InsOrdenVentaVehiculo->OvvId,$InsOrdenVentaVehiculo->OvvDestinatarios,$_SESSION['SesionNombre'],NULL)){
						
						
						if(!empty($GET_dia)){
	?>
							<script type="text/javascript">
							self.parent.tb_remove('<?php echo $GET_mod;?>');
							self.parent.$('#CmpOrdenVentaVehiculoId').val("<?php echo $InsOrdenVentaVehiculo->OvvId;?>");
							self.parent.FncOrdenVentaVehiculoBuscar("Id");
							</script>
	<?php				
						}
						
						$Edito = true;
						FncCargarDatos();
						$Resultado.='#SAS_OVV_114';
	
					}else{
						$InsOrdenVentaVehiculo->OvvFecha = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvFecha);
						$Resultado.='#ERR_OVV_114';
					}


		}else{			
			$InsOrdenVentaVehiculo->OvvFecha = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvFecha);
			$Resultado.='#ERR_OVV_114';				
		}
		
	}else{
		
	}
	
//	deb($Edito);
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	 
	
	global $GET_id;
	global $Identificador;
	global $InsOrdenVentaVehiculo;
	global $EmpresaMonedaId;
	global $CorreosNotificacionOrdenVentaVehiculoSolicitarVIN;
	

	unset($_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador]);
	
	$_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();

	$InsOrdenVentaVehiculo->OvvId = $GET_id;
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();		
	$InsOrdenVentaVehiculo->OvvDestinatarios = $CorreosNotificacionOrdenVentaVehiculoSolicitarVIN;		
	
///	deb($CorreosNotificacionOrdenVentaVehiculoSolicitarVIN);

	if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){

		$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		
		$InsOrdenVentaVehiculo->CveTotal = round($InsOrdenVentaVehiculo->CveTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			
	}	
	
	
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){

//SesionObjeto-OrdenVentaVehiculoPropietario
//Parametro1 = CviId
//Parametro2 = 
//Parametro3 = CliNombre
//Parametro4 = CliNumeroDocumento
//Parametro5 = TdoId
//Parametro6 = CliId
//Parametro7 = CviTiempoCreacion
//Parametro8 = CviTiempoModificacion
//Parametro9 = TdoNombre

//Parametro10 = CliTelefono
//Parametro11 = CliCelular
//Parametro12 = CliEmail

//Parametro13 = CliNombre
//Parametro14 = CliApellidoPaterno
//Parametro15 = CliApellidoMaterno
//Parametro16 = OvpFirmaDJ

			$_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatOrdenVentaVehiculoPropietario->OvpId,
			NULL,
			$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno,
			$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento,
			$DatOrdenVentaVehiculoPropietario->TdoId,
			$DatOrdenVentaVehiculoPropietario->CliId,
			($DatOrdenVentaVehiculoPropietario->OvpTiempoCreacion),
			($DatOrdenVentaVehiculoPropietario->OvpTiempoModificacion),
			$DatOrdenVentaVehiculoPropietario->TdoNombre,
			
			$DatOrdenVentaVehiculoPropietario->CliTelefono,
			$DatOrdenVentaVehiculoPropietario->CliCelular,
			$DatOrdenVentaVehiculoPropietario->CliEmail,
			
			$DatOrdenVentaVehiculoPropietario->CliNombre,
			$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno,
			$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno,
			$DatOrdenVentaVehiculoPropietario->OvpFirmaDJ
			);
		
		}
	}
		
	

	
}


?>