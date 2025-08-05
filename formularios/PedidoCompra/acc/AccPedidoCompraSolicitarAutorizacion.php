<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnEnviarCorreo_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsPedidoCompra->UsuId = $_SESSION['SesionId'];	
	
	$InsPedidoCompra->PcoId = $_POST['CmpId'];
	$InsPedidoCompra->CliId = $_POST['CmpClienteId'];
	$InsPedidoCompra->PerId = $_POST['CmpPersonal'];
	$InsPedidoCompra->PcoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	
	$InsPedidoCompra->MonId = $_POST['CmpMonedaId'];
	$InsPedidoCompra->PcoTipoCambio = $_POST['CmpTipoCambio'];

	$InsPedidoCompra->PcoObservacion = addslashes($_POST['CmpObservacion']);
	$InsPedidoCompra->PcoObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsPedidoCompra->PcoObservacionCorreo = addslashes($_POST['CmpObservacionCorreo']);
	
	$InsPedidoCompra->PcoOrigen =  $_POST['CmpOrigen'];
	$InsPedidoCompra->PcoEstado = $_POST['CmpEstado'];
	$InsPedidoCompra->PcoTiempoModificacion = date("Y-m-d H:i:s");

	$InsPedidoCompra->PcoIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsPedidoCompra->PcoPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsPedidoCompra->PcoMargenUtilidad = 0;
//	$InsPedidoCompra->PcoIncluyeImpuesto = 0;

	$InsPedidoCompra->CliNombre = $_POST['CmpClienteNombre'];
	$InsPedidoCompra->CliNombreCompleto = $InsPedidoCompra->CliNombre;
	$InsPedidoCompra->TdoId = $_POST['CmpClienteTipoDocumento'];	
	$InsPedidoCompra->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];

	$InsPedidoCompra->VdiId = $_POST['CmpVentaDirectaId'];
	$InsPedidoCompra->VdiOrdenCompraNumero = $_POST['CmpVentaDirectaOrdenCompraNumero'];	
	$InsPedidoCompra->OcoId = $_POST['CmpOrdenCompraId'];

	$InsPedidoCompra->FinId = $_POST['CmpFichaIngresoId'];
	$InsPedidoCompra->FccId = $_POST['CmpFichaAccionId'];
	$InsPedidoCompra->MinNombre = $_POST['CmpFichaIngresoModalidad'];
	
	$InsPedidoCompra->PcoSubTotal = 0;
	$InsPedidoCompra->PcoImpuesto = 0;
	$InsPedidoCompra->PcoTotal = 0;

	$InsPedidoCompra->PedidoCompraDetalle = array();

	$InsPedidoCompra->PcoDestinatarios = $_POST['CmpDestinatario'];
	
	if($InsPedidoCompra->MonId<>$EmpresaMonedaId){
		if(empty($InsPedidoCompra->PcoTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_PCO_600';
		}
	}
	

	if(empty($InsPedidoCompra->CliId)){
		$Guardar = false;
		$Resultado.='#ERR_PCO_123';
	}
	
		
	/*
	SesionObjeto-PedidoCompraDetalle
	Parametro1 = PcdId
	Parametro2 = ProId
	Parametro3 = ProNombre
	Parametro4 = PcdPrecio
	Parametro5 = PcdCantidad
	Parametro6 = PcdImporte
	Parametro7 = PcdTiempoCreacion
	Parametro8 = PcdTiempoModificacion
	Parametro9 = UmeNombre
	Parametro10 = UmeId
	Parametro11 = RtiId
	Parametro12 = PcdCodigo
	Parametro13 = ProCodigoOriginal,
	Parametro14 = ProCodigoAlternativo
	Parametro15 = UmeIdOrigen
	Parametro16 = VerificarStock
	Parametro17 = 
	Parametro18 = VddId
	Parametro19 = PcdAno
	Parametro20 = PcdModelo
	
	Parametro21 - PcdDisponibilidad
	Parametro22 - PcdReemplazo
	Parametro23 = AmdCantidad
	
	Parametro24 = PcdBOFecha
	Parametro25 = PcdBOEstado
	
	Parametro26 = PcdEstado
	*/

	$ResPedidoCompraDetalle = $_SESSION['InsPedidoCompraDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
	if(!empty($ResPedidoCompraDetalle['Datos'])){
		$item = 1;
		foreach($ResPedidoCompraDetalle['Datos'] as $DatSesionObjeto){
				
			$InsPedidoCompraDetalle1 = new ClsPedidoCompraDetalle();
			$InsPedidoCompraDetalle1->PcdId = $DatSesionObjeto->Parametro1;
			$InsPedidoCompraDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsPedidoCompraDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			$InsPedidoCompraDetalle1->VddId = $DatSesionObjeto->Parametro18;
			
			$InsPedidoCompraDetalle1->PcdCantidad = $DatSesionObjeto->Parametro5;				
		
			$InsPedidoCompraDetalle1->PcdAno =  $DatSesionObjeto->Parametro19;
			$InsPedidoCompraDetalle1->PcdModelo =  $DatSesionObjeto->Parametro20;
			$InsPedidoCompraDetalle1->PcdCodigo =  $DatSesionObjeto->Parametro13;

			if($InsPedidoCompra->MonId<>$EmpresaMonedaId){
				$InsPedidoCompraDetalle1->PcdPrecio = $DatSesionObjeto->Parametro4 * $InsPedidoCompra->PcoTipoCambio;
			}else{
				$InsPedidoCompraDetalle1->PcdPrecio = $DatSesionObjeto->Parametro4;
			}

			if($InsPedidoCompra->MonId<>$EmpresaMonedaId ){
				$InsPedidoCompraDetalle1->PcdImporte = $DatSesionObjeto->Parametro6 * $InsPedidoCompra->PcoTipoCambio;
			}else{
				$InsPedidoCompraDetalle1->PcdImporte = $DatSesionObjeto->Parametro6;
			}
			
			$InsPedidoCompraDetalle1->PcdObservacion = $DatSesionObjeto->Parametro34;
			
			$InsPedidoCompraDetalle1->PcdEstado = $DatSesionObjeto->Parametro26;
			$InsPedidoCompraDetalle1->PcdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsPedidoCompraDetalle1->PcdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsPedidoCompraDetalle1->PcdEliminado = $DatSesionObjeto->Eliminado;				
			$InsPedidoCompraDetalle1->InsMysql = NULL;

			$InsPedidoCompra->PedidoCompraDetalle[] = $InsPedidoCompraDetalle1;

			if($InsPedidoCompraDetalle1->PcdEliminado==1){					
				$InsPedidoCompra->PcoTotalBruto += $InsPedidoCompraDetalle1->PcdImporte;	
			}
			
			$item++;				
		}		
	}else{
		$Guardar = false;
		$Resultado.='#ERR_PCO_111';
	}	

	if($InsPedidoCompra->PcoIncluyeImpuesto==2){
		$InsPedidoCompra->PcoSubTotal = round($InsPedidoCompra->PcoTotalBruto,6);
		$InsPedidoCompra->PcoImpuesto = round(($InsPedidoCompra->PcoSubTotal * ($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100)),6);
		$InsPedidoCompra->PcoTotal = round($InsPedidoCompra->PcoSubTotal + $InsPedidoCompra->PcoImpuesto,6);
	}else{
		$InsPedidoCompra->PcoTotal = round($InsPedidoCompra->PcoTotalBruto,6);	
		$InsPedidoCompra->PcoSubTotal = round($InsPedidoCompra->PcoTotal / (($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100)+1),6);
		$InsPedidoCompra->PcoImpuesto = round(($InsPedidoCompra->PcoTotal - $InsPedidoCompra->PcoSubTotal),6);
	}
//deb($InsPedidoCompra->PcoDestinatarios);

	if($Guardar){
		
		$InsPedidoCompra->MtdEditarPedidoCompraDato("PcoObservacionCorreo",$InsSolicitudDesembolso->SdsObservacionCorreo,$InsSolicitudDesembolso->SdsId);
	
		$InsPedidoCompra->MtdEditarPedidoCompraDato("PcoObservacionImpresa",$InsSolicitudDesembolso->SdsObservacionImpresa,$InsSolicitudDesembolso->SdsId);
	

		if(!empty($InsPedidoCompra->PcoDestinatarios)){
			
				//if($InsPedidoCompra->MtdGenerarExcelPedidoCompraAutorizacion($InsPedidoCompra->PcoId,'')){
				//if($InsPedidoCompra->MtdGenerarExcelPedidoCompraFormatoGM($InsPedidoCompra->PcoId,'')){
				if($InsPedidoCompra->MtdGenerarExcelPedidoCompraFormatoGM($InsPedidoCompra->PcoId,'')){					
					
					// MtdEnviarCorreoSolicitarAutorizacionPedidoCompra($oOrdenCompra,$oDestinatario,$oRemitente,$oAdjunto=array()){
					if($InsPedidoCompra->MtdEnviarCorreoSolicitarAutorizacionPedidoCompraFormatoGM($InsPedidoCompra->PcoId,$InsPedidoCompra->PcoDestinatarios,$_SESSION['SesionNombre'],array("generados/pedido_compra/".$InsPedidoCompra->PcoId.".xls"))){
	
						if(!empty($GET_dia)){
	?>
							<script type="text/javascript">
							self.parent.tb_remove('<?php echo $GET_mod;?>');
							self.parent.$('#CmpPedidoCompraId').val("<?php echo $InsPedidoCompra->PcoId;?>");
							self.parent.FncPedidoCompraBuscar("Id");
							</script>
	<?php				
						}
						
						if($InsPedidoCompra->PcoEstado == 1){
			
							if($InsPedidoCompra->MtdActualizarEstadoPedidoCompra($InsPedidoCompra->PcoId,3)){
				
								if($InsPedidoCompra->MtdActualizarEstadoPedidoCompra($InsPedidoCompra->PcoId,31)){
				
								}
				
							}
				
						}else if($InsPedidoCompra->PcoEstado == 3){
							
							if($InsPedidoCompra->MtdActualizarEstadoPedidoCompra($InsPedidoCompra->PcoId,31)){
								
							}
								
						}
						
						
						$Edito = true;
						FncCargarDatos();
						$Resultado.='#SAS_PCO_114';
	
					}else{
						$InsPedidoCompra->PcoFecha = FncCambiaFechaANormal($InsPedidoCompra->PcoFecha);
						$Resultado.='#ERR_PCO_114';
					}


				}else{
					$InsPedidoCompra->PcoFecha = FncCambiaFechaANormal($InsPedidoCompra->PcoFecha);
					$Resultado.='#ERR_PCO_114';
				}
				

			
		}else{			
			$InsPedidoCompra->PcoFecha = FncCambiaFechaANormal($InsPedidoCompra->PcoFecha);
			$Resultado.='#ERR_PCO_114';				
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
	global $InsPedidoCompra;
	global $EmpresaMonedaId;
	global $InsProductoDisponibilidad;
	global $InsProductoReemplazo;
	global $CorreosNotificacionSolicitudPedidoCompra;
	
	unset($_SESSION['InsPedidoCompraDetalle'.$Identificador]);

	$_SESSION['InsPedidoCompraDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsPedidoCompra->PcoId = $GET_id;
	$InsPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompra();		
	
	
	$InsPedidoCompra->PcoDestinatarios = $CorreosNotificacionSolicitudPedidoCompra;


	//deb($InsPedidoCompra->PerEmail);
	if(!empty($InsPedidoCompra->PerEmail)){
	
		$ArrCorreos = explode(",",$InsPedidoCompra->PcoDestinatarios);
	
		if(!in_array($InsPedidoCompra->PerEmail,$ArrCorreos)){
			$InsPedidoCompra->PcoDestinatarios .= ",".$InsPedidoCompra->PerEmail;
		}
	
	}
	  
	
	
//deb($InsPedidoCompra->PcoDestinatarios);
	if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
		foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){

			$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatPedidoCompraDetalle->ProCodigoOriginal ,"PdiTiempoCreacion","DESC","1",1);
			$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];

			$Disponibilidad = "";
			
			if(!empty($ArrProductoDisponibilidades)){
				foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
					
					$Disponibilidad =  ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';
				
				}
			}
			
			$Reemplazo = "NO";
			$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",$DatPedidoCompraDetalle->ProCodigoOriginal ,"PreId","ASC",NULL,1);
			$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
			
			if(!empty($ArrProductoReemplazos)){
				  $Reemplazo= "SI";
			}
				
			if($InsPedidoCompra->MonId<>$EmpresaMonedaId){
				$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio / $InsPedidoCompra->PcoTipoCambio;
			}else{
				$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio;
			}

			if($InsPedidoCompra->MonId<>$EmpresaMonedaId ){
				$DatPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdImporte / $InsPedidoCompra->PcoTipoCambio;
			}else{
				$DatPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdImporte;
			}
			
			/*
			SesionObjeto-PedidoCompraDetalle
			Parametro1 = PcdId
			Parametro2 = ProId
			Parametro3 = ProNombre
			Parametro4 = PcdPrecio
			Parametro5 = PcdCantidad
			Parametro6 = PcdImporte
			Parametro7 = PcdTiempoCreacion
			Parametro8 = PcdTiempoModificacion
			Parametro9 = UmeNombre
			Parametro10 = UmeId
			Parametro11 = RtiId
			Parametro12 = PcdCodigo
			Parametro13 = ProCodigoOriginal,
			Parametro14 = ProCodigoAlternativo
			Parametro15 = UmeIdOrigen
			Parametro16 = VerificarStock
			Parametro17 = 
			Parametro18 = VddId
			Parametro19 = PcdAno
			Parametro20 = PcdModelo
			
			Parametro21 - PcdDisponibilidad
			Parametro22 - PcdReemplazo
			Parametro23 = AmdCantidad
			
			Parametro24 = PcdBOFecha
			Parametro25 = PcdBOEstado
			Parametro26 = PcdEstado
			
			Parametro27 = PleFecha
			Parametro28 = PldCantidad
			Parametro29 = ProPromedioMensual
			
			Parametro30 = ProPromedioTrimestral
			Parametro31 = ProPromedioAnual
			Parametro32 = ProFechaUltimaSalida
			Parametro33 = ProDiasInmovilizado
			*/					

			$_SESSION['InsPedidoCompraDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatPedidoCompraDetalle->PcdId,
			$DatPedidoCompraDetalle->ProId,
			$DatPedidoCompraDetalle->ProNombre,
			$DatPedidoCompraDetalle->PcdPrecio,
			$DatPedidoCompraDetalle->PcdCantidad,
			$DatPedidoCompraDetalle->PcdImporte,
			($DatPedidoCompraDetalle->PcdTiempoCreacion),
			($DatPedidoCompraDetalle->PcdTiempoModificacion),
			$DatPedidoCompraDetalle->UmeNombre,
			$DatPedidoCompraDetalle->UmeId,
			$DatPedidoCompraDetalle->RtiId,
			$DatPedidoCompraDetalle->PcdCodigo,
			$DatPedidoCompraDetalle->ProCodigoOriginal,
			$DatPedidoCompraDetalle->ProCodigoAlternativo,
			$DatPedidoCompraDetalle->UmeIdOrigen,
			NULL,
			NULL,
			$DatPedidoCompraDetalle->VddId,
			$DatPedidoCompraDetalle->PcdAno,
			$DatPedidoCompraDetalle->PcdModelo,
			$Disponibilidad,
			$Reemplazo,
			$DatPedidoCompraDetalle->AmdCantidad,
			
			$DatPedidoCompraDetalle->PcdBOFecha,
			$DatPedidoCompraDetalle->PcdBOEstado,			
			$DatPedidoCompraDetalle->PcdEstado,
			
			$DatPedidoCompraDetalle->PleFecha,
			$DatPedidoCompraDetalle->PldCantidad,			
			$DatPedidoCompraDetalle->ProRotacion,
			
			$DatPedidoCompraDetalle->ProSalidaTotalTrimestral,
			$DatPedidoCompraDetalle->ProSalidaTotalSemestral,
			$DatPedidoCompraDetalle->ProFechaUltimaSalida,
			$DatPedidoCompraDetalle->ProDiasInmovilizado,
			
			$DatPedidoCompraDetalle->PcdObservacion
	
			);
		
		}
	}
	
	

	
}



//
//
//
//function FncCargarTallerPedidoDatos(){
//	
//	global $GET_TpeId;
//	global $Identificador;
//	global $InsTallerPedido;
//	global $InsFichaIngreso;
//	
//	unset($_SESSION['InsTallerPedidoDetalle'.$Identificador]);
//
//	$_SESSION['InsTallerPedidoDetalle'.$Identificador] = new ClsSesionObjeto();
//	
//	
//	$InsTallerPedido = new ClsTallerPedido();		
//	$InsTallerPedido->TpeId = $GET_TpeId;
//	$InsTallerPedido->MtdObtenerTallerPedido();
//	
//	if(!empty($InsTallerPedido->TallerPedidoDetalle)){
//		foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
//	
//			$_SESSION['InsTallerPedidoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//			$DatTallerPedidoDetalle->TpdId,
//			$DatTallerPedidoDetalle->ProId,
//			$DatTallerPedidoDetalle->ProNombre,
//			NULL,
//			$DatTallerPedidoDetalle->TpdCantidad,
//			NULL,
//			($DatTallerPedidoDetalle->TpdTiempoCreacion),
//			($DatTallerPedidoDetalle->TpdTiempoModificacion),
//			$DatTallerPedidoDetalle->UmeNombre,
//			$DatTallerPedidoDetalle->UmeId,
//			$DatTallerPedidoDetalle->RtiId,
//			$DatTallerPedidoDetalle->TpdCantidadReal,
//			$DatTallerPedidoDetalle->ProCodigoOriginal,
//			$DatTallerPedidoDetalle->ProCodigoAlternativo,
//			$DatTallerPedidoDetalle->UmeIdOrigen
//			);
//		
//		}
//	}
//	
//			
//	$InsFichaIngreso = new ClsFichaIngreso();
//	$InsFichaIngreso->FinId = $InsTallerPedido->FinId;
//	$InsFichaIngreso->MtdObtenerFichaIngreso();
//}
?>