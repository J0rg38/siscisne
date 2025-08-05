<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnEnviarCorreo_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsSolicitudDesembolso->UsuId = $_SESSION['SesionId'];	
	
	$InsSolicitudDesembolso->SdsId = $_POST['CmpId'];
	$InsSolicitudDesembolso->PerId = $_POST['CmpPersonal'];
	$InsSolicitudDesembolso->AreId = $_POST['CmpArea'];
	$InsSolicitudDesembolso->FinId = $_POST['CmpFichaIngreso'];
	$InsSolicitudDesembolso->TgaId = $_POST['CmpTipoGasto'];
	
	$InsSolicitudDesembolso->SdsFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	$InsSolicitudDesembolso->SdsVIN = $_POST['CmpVIN'];
	$InsSolicitudDesembolso->SdsPlaca = $_POST['CmpPlaca'];
	$InsSolicitudDesembolso->SdsCliente = $_POST['CmpCliente'];
	
	$InsSolicitudDesembolso->MonId = $_POST['CmpMonedaId'];
	$InsSolicitudDesembolso->SdsTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsSolicitudDesembolso->SdsAsunto = addslashes($_POST['CmpAsunto']);
	$InsSolicitudDesembolso->SdsDescripcion = addslashes($_POST['CmpDescripcion']);
	$InsSolicitudDesembolso->SdsMonto = eregi_replace(",","",(empty($_POST['CmpMonto'])?0:$_POST['CmpMonto']));

	$InsSolicitudDesembolso->SdsObservacion = addslashes($_POST['CmpObservacion']);
	$InsSolicitudDesembolso->SdsObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsSolicitudDesembolso->SdsObservacionCorreo = addslashes($_POST['CmpObservacionCorreo']);
	$InsSolicitudDesembolso->SdsAprobado = $_POST['CmpAprobado'];
	
	$InsSolicitudDesembolso->SdsEstado = $_POST['CmpEstado'];
	$InsSolicitudDesembolso->SdsTiempoModificacion = date("Y-m-d H:i:s");

	$InsSolicitudDesembolso->SdsDestinatarios = $_POST['CmpDestinatario'];
	

	if( $InsSolicitudDesembolso->MonId<>$EmpresaMonedaId ){
		$InsSolicitudDesembolso->SdsMonto = $InsSolicitudDesembolso->SdsMonto * $InsSolicitudDesembolso->SdsTipoCambio;
	}else{
		$InsSolicitudDesembolso->SdsMonto = $InsSolicitudDesembolso->SdsMonto;
	}

	if($Guardar){
		
		$InsSolicitudDesembolso->MtdEditarSolicitudDesembolsoDato("SdsAsunto",$InsSolicitudDesembolso->SdsAsunto,$InsSolicitudDesembolso->SdsId);
		$InsSolicitudDesembolso->MtdEditarSolicitudDesembolsoDato("SdsObservacionImpresa",$InsSolicitudDesembolso->SdsObservacionImpresa,$InsSolicitudDesembolso->SdsId);
		$InsSolicitudDesembolso->MtdEditarSolicitudDesembolsoDato("SdsObservacionCorreo",$InsSolicitudDesembolso->SdsObservacionCorreo,$InsSolicitudDesembolso->SdsId);
	
		if(!empty($InsSolicitudDesembolso->SdsDestinatarios)){
			
				if($InsSolicitudDesembolso->MtdGenerarExcelSolicitudDesembolsoAutorizacion($InsSolicitudDesembolso->SdsId,'')){
					
//					if($InsSolicitudDesembolso->MtdEnviarCorreoSolicitarAutorizacionSolicitudDesembolso($InsSolicitudDesembolso->SdsId,$InsSolicitudDesembolso->SdsDestinatarios,$_SESSION['SesionNombre'],array("generados/solicitud_desembolso/".$InsSolicitudDesembolso->SdsId.".xls"))){
					if($InsSolicitudDesembolso->MtdEnviarCorreoSolicitarAutorizacionSolicitudDesembolso($InsSolicitudDesembolso->SdsId,$InsSolicitudDesembolso->SdsDestinatarios,$_SESSION['SesionNombre'],NULL)){
					
						if($InsSolicitudDesembolso->MtdActualizarEstadoSolicitudDesembolso($InsSolicitudDesembolso->SdsId,31)){
				
						}
								
						if(!empty($GET_dia)){
	?>
							<script type="text/javascript">
							self.parent.tb_remove('<?php echo $GET_mod;?>');
							self.parent.$('#CmpSolicitudDesembolsoId').val("<?php echo $InsSolicitudDesembolso->SdsId;?>");
							self.parent.FncSolicitudDesembolsoBuscar("Id");
							</script>
	<?php				
						}
						
						$Edito = true;
						FncCargarDatos();
						$Resultado.='#SAS_SDS_114';
	
					}else{
						$InsSolicitudDesembolso->SdsFecha = FncCambiaFechaANormal($InsSolicitudDesembolso->SdsFecha);
						$Resultado.='#ERR_SDS_114';
					}


				}else{
					$InsSolicitudDesembolso->SdsFecha = FncCambiaFechaANormal($InsSolicitudDesembolso->SdsFecha);
					$Resultado.='#ERR_SDS_114';
				}
				
		}else{			
			$InsSolicitudDesembolso->SdsFecha = FncCambiaFechaANormal($InsSolicitudDesembolso->SdsFecha);
			$Resultado.='#ERR_SDS_114';				
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
	global $InsSolicitudDesembolso;
	global $EmpresaMonedaId;
	global $InsProductoDisponibilidad;
	global $InsProductoReemplazo;
	global $CorreosNotificacionSolicitudDesembolso;
	
	unset($_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador]);
	
	$_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador] = new ClsSesionObjeto();
	
	
	$InsSolicitudDesembolso->SdsId = $GET_id;
	$InsSolicitudDesembolso = $InsSolicitudDesembolso->MtdObtenerSolicitudDesembolso();	
	$InsSolicitudDesembolso->SdsGastoAsumido = "CYC";	
	
	$InsSolicitudDesembolso->SdsDestinatarios = $CorreosNotificacionSolicitudDesembolso;

	if(!empty($InsSolicitudDesembolso->PerEmail)){
	
		$ArrCorreos = explode(",",$InsSolicitudDesembolso->SdsDestinatarios);
	
		if(!in_array($InsSolicitudDesembolso->PerEmail,$ArrCorreos)){
			$InsSolicitudDesembolso->SdsDestinatarios .= ",".$InsSolicitudDesembolso->PerEmail;
		}
	
	}
	
	if(!empty($InsSolicitudDesembolso->SolicitudDesembolsoDetalle)){
		foreach($InsSolicitudDesembolso->SolicitudDesembolsoDetalle as $DatSolicitudDesembolsoDetalle){

			//	SesionObjeto-SolicitudDesembolsoDetalle
			//	Parametro1 = SddId
			//	Parametro2 = SdsId
			//	Parametro3 = SreId
			//	Parametro4 = SddDescripcion
			//	Parametro5 = SddCantidad
			//	Parametro6 = SddImporte
			//	Parametro7 = SddTiempoCreacion
			//	Parametro8 = SddTiempoModificacion
			//	Parametro9 = SddEstado
			//	Parametro10 = SreNombre
	
			$_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatSolicitudDesembolsoDetalle->SddId,
			$DatSolicitudDesembolsoDetalle->SdsId,
			$DatSolicitudDesembolsoDetalle->SreId,
			$DatSolicitudDesembolsoDetalle->SddDescripcion,
			$DatSolicitudDesembolsoDetalle->SddCantidad,
			$DatSolicitudDesembolsoDetalle->SddImporte,
			($DatSolicitudDesembolsoDetalle->SddTiempoCreacion),
			($DatSolicitudDesembolsoDetalle->SddTiempoModificacion),
			$DatSolicitudDesembolsoDetalle->SddEstado,
			$DatSolicitudDesembolsoDetalle->SreNombre
			);
		
		}
	}
	  
}


?>