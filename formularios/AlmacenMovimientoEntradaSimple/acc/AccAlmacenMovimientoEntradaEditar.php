<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsAlmacenMovimientoEntrada->UsuId = $_SESSION['SesionId'];		
	$InsAlmacenMovimientoEntrada->AmoId = $_POST['CmpId'];
	$InsAlmacenMovimientoEntrada->PrvId = $_POST['CmpProveedorId'];
	$InsAlmacenMovimientoEntrada->CtiId = $_POST['CmpComprobanteTipo'];	
	$InsAlmacenMovimientoEntrada->TopId = $_POST['CmpTipoOperacion'];	
	$InsAlmacenMovimientoEntrada->OcoId = $_POST['CmpOrdenCompra'];	
	$InsAlmacenMovimientoEntrada->AlmId = $_POST['CmpAlmacen'];	

//	$InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	$InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
	$InsAlmacenMovimientoEntrada->AmoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsAlmacenMovimientoEntrada->AmoObservacion = addslashes($_POST['CmpObservacion']);
	$InsAlmacenMovimientoEntrada->AmoDocumentoOrigen = $_POST['CmpDocumentoOrigen'];
	
	$InsAlmacenMovimientoEntrada->AmoComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsAlmacenMovimientoEntrada->AmoComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsAlmacenMovimientoEntrada->AmoComprobanteNumero = $InsAlmacenMovimientoEntrada->AmoComprobanteNumeroSerie."-".$InsAlmacenMovimientoEntrada->AmoComprobanteNumeroNumero;
	
	$InsAlmacenMovimientoEntrada->AmoComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);	
	

	$InsAlmacenMovimientoEntrada->AmoGuiaRemisionNumeroSerie = $_POST['CmpGuiaRemisionNumeroSerie'];	
	$InsAlmacenMovimientoEntrada->AmoGuiaRemisionNumeroNumero = $_POST['CmpGuiaRemisionNumeroNumero'];	
	$InsAlmacenMovimientoEntrada->AmoGuiaRemisionNumero = $InsAlmacenMovimientoEntrada->AmoGuiaRemisionNumeroSerie."-".$InsAlmacenMovimientoEntrada->AmoGuiaRemisionNumeroNumero;
	
	$InsAlmacenMovimientoEntrada->AmoGuiaRemisionFecha = FncCambiaFechaAMysql($_POST['CmpGuiaRemisionFecha'],true);	
	$InsAlmacenMovimientoEntrada->AmoGuiaRemisionFoto = $_SESSION['SesAmoGuiaRemisionFoto'.$Identificador];

	$InsAlmacenMovimientoEntrada->MonId = $_POST['CmpMonedaId'];
	$InsAlmacenMovimientoEntrada->AmoTipoCambio = $_POST['CmpTipoCambio'];
	
//	$InsAlmacenMovimientoEntrada->AmoIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsAlmacenMovimientoEntrada->AmoIncluyeImpuesto = 2;
	
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduana = eregi_replace(",","",$_POST['CmpTotalAduana']);
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalTransporte = eregi_replace(",","",$_POST['CmpTotalTransporte']);
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba = eregi_replace(",","",$_POST['CmpTotalDesestiba']);
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje = eregi_replace(",","",$_POST['CmpTotalAlmacenaje']);
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem = eregi_replace(",","",$_POST['CmpTotalAdValorem']);
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional = eregi_replace(",","",$_POST['CmpTotalAduanaNacional']);
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo = eregi_replace(",","",$_POST['CmpTotalGastoAdministrativo']);
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1 = eregi_replace(",","",$_POST['CmpTotalOtroCosto1']);
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2 = eregi_replace(",","",$_POST['CmpTotalOtroCosto2']);

	$InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo = eregi_replace(",","",$_POST['CmpTotalRecargo']);
	$InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete = eregi_replace(",","",$_POST['CmpTotalFlete']);
	$InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto = eregi_replace(",","",$_POST['CmpTotalOtroCosto']);
			
	$InsAlmacenMovimientoEntrada->AmoTotalInternacional = $InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduana +
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalTransporte + $InsAlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba +
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje + $InsAlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem +
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional + $InsAlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo +
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1 + $InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2;
	
	$InsAlmacenMovimientoEntrada->AmoTotalNacional = $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo + 
	$InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete + $InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto;
	
	$InsAlmacenMovimientoEntrada->AmoMargenUtilidad = 0.00;
	$InsAlmacenMovimientoEntrada->AmoTipo = 1;
	$InsAlmacenMovimientoEntrada->AmoSubTipo = 1;

	$InsAlmacenMovimientoEntrada->NpaId = $_POST['CmpCondicionPago'];
	$InsAlmacenMovimientoEntrada->AmoCantidadDia = isset($_POST['CmpCantidadDia'])?$_POST['CmpCantidadDia']:0;
	
	$InsAlmacenMovimientoEntrada->AmoEstado = $_POST['CmpEstado'];
	$InsAlmacenMovimientoEntrada->AmoTiempoModificacion = date("Y-m-d H:i:s");
	$InsAlmacenMovimientoEntrada->AmoEliminado = 1;

	$InsAlmacenMovimientoEntrada->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsAlmacenMovimientoEntrada->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsAlmacenMovimientoEntrada->PrvNombreCompleto = $_POST['CmpProveedorNombre'];
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsAlmacenMovimientoEntrada->AmoFoto = $_SESSION['SesAmoFoto'.$Identificador];
	$InsAlmacenMovimientoEntrada->AmoNacionalFoto1 = $_SESSION['SesAmoNacionalFoto1'.$Identificador];
	$InsAlmacenMovimientoEntrada->AmoNacionalFoto2 = $_SESSION['SesAmoNacionalFoto2'.$Identificador];
	$InsAlmacenMovimientoEntrada->AmoNacionalFoto3 = $_SESSION['SesAmoNacionalFoto3'.$Identificador];
	
		
	$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante1 = $_POST['CmpInternacionalNumeroComprobante1'];
	$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante2 = $_POST['CmpInternacionalNumeroComprobante2'];
	$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante3 = $_POST['CmpInternacionalNumeroComprobante3'];
	$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante4 = $_POST['CmpInternacionalNumeroComprobante4'];
	$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante5 = $_POST['CmpInternacionalNumeroComprobante5'];
	$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante6 = $_POST['CmpInternacionalNumeroComprobante6'];
	$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante7 = $_POST['CmpInternacionalNumeroComprobante7'];
	$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante8 = $_POST['CmpInternacionalNumeroComprobante8'];
	$InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante9 = $_POST['CmpInternacionalNumeroComprobante9'];
	
	$InsAlmacenMovimientoEntrada->AmoNacionalNumeroComprobante1 = $InsAlmacenMovimientoEntrada->AmoComprobanteNumero;
	$InsAlmacenMovimientoEntrada->AmoNacionalNumeroComprobante2 = $_POST['CmpNacionalNumeroComprobante2'];
	$InsAlmacenMovimientoEntrada->AmoNacionalNumeroComprobante3 = $_POST['CmpNacionalNumeroComprobante3'];
	

	$InsAlmacenMovimientoEntrada->MonIdInternacional1 = $_POST['CmpInternacionalMonedaId1'];
	$InsAlmacenMovimientoEntrada->MonIdInternacional2 = $_POST['CmpInternacionalMonedaId2'];
	$InsAlmacenMovimientoEntrada->MonIdInternacional3 = $_POST['CmpInternacionalMonedaId3'];
	$InsAlmacenMovimientoEntrada->MonIdInternacional4 = $_POST['CmpInternacionalMonedaId4'];
	$InsAlmacenMovimientoEntrada->MonIdInternacional5 = $_POST['CmpInternacionalMonedaId5'];
	$InsAlmacenMovimientoEntrada->MonIdInternacional6 = $_POST['CmpInternacionalMonedaId6'];
	$InsAlmacenMovimientoEntrada->MonIdInternacional7 = $_POST['CmpInternacionalMonedaId7'];
	$InsAlmacenMovimientoEntrada->MonIdInternacional8 = $_POST['CmpInternacionalMonedaId8'];
	$InsAlmacenMovimientoEntrada->MonIdInternacional9 = $_POST['CmpInternacionalMonedaId9'];
	
	$InsAlmacenMovimientoEntrada->MonIdNacional1 = $InsAlmacenMovimientoEntrada->MonId;
	$InsAlmacenMovimientoEntrada->MonIdNacional2 = $_POST['CmpNacionalMonedaId2'];
	$InsAlmacenMovimientoEntrada->MonIdNacional3 = $_POST['CmpNacionalMonedaId3'];


	$InsAlmacenMovimientoEntrada->PrvIdInternacional1 = $_POST['CmpInternacionalProveedorId1'];
	$InsAlmacenMovimientoEntrada->PrvIdInternacional2 = $_POST['CmpInternacionalProveedorId2'];
	$InsAlmacenMovimientoEntrada->PrvIdInternacional3 = $_POST['CmpInternacionalProveedorId3'];
	$InsAlmacenMovimientoEntrada->PrvIdInternacional4 = $_POST['CmpInternacionalProveedorId4'];
	$InsAlmacenMovimientoEntrada->PrvIdInternacional5 = $_POST['CmpInternacionalProveedorId5'];
	$InsAlmacenMovimientoEntrada->PrvIdInternacional6 = $_POST['CmpInternacionalProveedorId6'];
	$InsAlmacenMovimientoEntrada->PrvIdInternacional7 = $_POST['CmpInternacionalProveedorId7'];
	$InsAlmacenMovimientoEntrada->PrvIdInternacional8 = $_POST['CmpInternacionalProveedorId8'];
	$InsAlmacenMovimientoEntrada->PrvIdInternacional9 = $_POST['CmpInternacionalProveedorId9'];

	$InsAlmacenMovimientoEntrada->PrvIdNacional1 = $_POST['CmpNacionalProveedorId1'];
	$InsAlmacenMovimientoEntrada->PrvIdNacional2 = $_POST['CmpNacionalProveedorId2'];
	$InsAlmacenMovimientoEntrada->PrvIdNacional3 = $_POST['CmpNacionalProveedorId3'];
	
	
	
	
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional1 = $_POST['CmpInternacionalProveedorNumeroDocumento1'];
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional2 = $_POST['CmpInternacionalProveedorNumeroDocumento2'];
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional3 = $_POST['CmpInternacionalProveedorNumeroDocumento3'];
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional4 = $_POST['CmpInternacionalProveedorNumeroDocumento4'];
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional5 = $_POST['CmpInternacionalProveedorNumeroDocumento5'];
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional6 = $_POST['CmpInternacionalProveedorNumeroDocumento6'];
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional7 = $_POST['CmpInternacionalProveedorNumeroDocumento7'];
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional8 = $_POST['CmpInternacionalProveedorNumeroDocumento8'];
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional9 = $_POST['CmpInternacionalProveedorNumeroDocumento9'];	

	$InsAlmacenMovimientoEntrada->PrvNumeroDocumentoNacional1 = $InsAlmacenMovimientoEntrada->PrvNumeroDocumento;
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumentoNacional2 = $_POST['CmpNacionalProveedorNumeroDocumento2'];
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumentoNacional3 = $_POST['CmpNacionalProveedorNumeroDocumento3'];

			
	$InsAlmacenMovimientoEntrada->PrvNombreInternacional1 = $_POST['CmpInternacionalProveedorNombre1'];
	$InsAlmacenMovimientoEntrada->PrvNombreInternacional2 = $_POST['CmpInternacionalProveedorNombre2'];
	$InsAlmacenMovimientoEntrada->PrvNombreInternacional3 = $_POST['CmpInternacionalProveedorNombre3'];
	$InsAlmacenMovimientoEntrada->PrvNombreInternacional4 = $_POST['CmpInternacionalProveedorNombre4'];
	$InsAlmacenMovimientoEntrada->PrvNombreInternacional5 = $_POST['CmpInternacionalProveedorNombre5'];
	$InsAlmacenMovimientoEntrada->PrvNombreInternacional6 = $_POST['CmpInternacionalProveedorNombre6'];
	$InsAlmacenMovimientoEntrada->PrvNombreInternacional7 = $_POST['CmpInternacionalProveedorNombre7'];
	$InsAlmacenMovimientoEntrada->PrvNombreInternacional8 = $_POST['CmpInternacionalProveedorNombre8'];
	$InsAlmacenMovimientoEntrada->PrvNombreInternacional9 = $_POST['CmpInternacionalProveedorNombre9'];	
	
	$InsAlmacenMovimientoEntrada->PrvNombreNacional1 = $InsAlmacenMovimientoEntrada->PrvNombre;
	$InsAlmacenMovimientoEntrada->PrvNombreNacional2 = $_POST['CmpNacionalProveedorNombre2'];
	$InsAlmacenMovimientoEntrada->PrvNombreNacional3 = $_POST['CmpNacionalProveedorNombre3'];	


			
	$InsAlmacenMovimientoEntrada->TdoIdInternacional1 = $_POST['CmpInternacionalProveedorTipoDocumento1'];
	$InsAlmacenMovimientoEntrada->TdoIdInternacional2 = $_POST['CmpInternacionalProveedorTipoDocumento2'];
	$InsAlmacenMovimientoEntrada->TdoIdInternacional3 = $_POST['CmpInternacionalProveedorTipoDocumento3'];
	$InsAlmacenMovimientoEntrada->TdoIdInternacional4 = $_POST['CmpInternacionalProveedorTipoDocumento4'];
	$InsAlmacenMovimientoEntrada->TdoIdInternacional5 = $_POST['CmpInternacionalProveedorTipoDocumento5'];
	$InsAlmacenMovimientoEntrada->TdoIdInternacional6 = $_POST['CmpInternacionalProveedorTipoDocumento6'];
	$InsAlmacenMovimientoEntrada->TdoIdInternacional7 = $_POST['CmpInternacionalProveedorTipoDocumento7'];
	$InsAlmacenMovimientoEntrada->TdoIdInternacional8 = $_POST['CmpInternacionalProveedorTipoDocumento8'];
	$InsAlmacenMovimientoEntrada->TdoIdInternacional9 = $_POST['CmpInternacionalProveedorTipoDocumento9'];	

	$InsAlmacenMovimientoEntrada->TdoIdNacional1 = $InsAlmacenMovimientoEntrada->TdoId;
	$InsAlmacenMovimientoEntrada->TdoIdNacional2 = $_POST['CmpNacionalProveedorTipoDocumento2'];
	$InsAlmacenMovimientoEntrada->TdoIdNacional3 = $_POST['CmpNacionalProveedorTipoDocumento3'];

	settype($InsAlmacenMovimientoEntrada->AmoTipoCambio,"float");
			
	$InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle = array();



	
	if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
		if(empty($InsAlmacenMovimientoEntrada->AmoTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_AMO_600';
		}
	}

		
				
	$InsAlmacenMovimientoEntrada->AmoTotalBruto = 0;
	$InsAlmacenMovimientoEntrada->AmoSubTotal = 0;
	$InsAlmacenMovimientoEntrada->AmoImpuesto = 0;
	$InsAlmacenMovimientoEntrada->AmoTotal = 0;
	
	$InsAlmacenMovimientoEntrada->AmoValorTotal = 0;
	//$InsAlmacenMovimientoEntrada->AmoValorTotal = eregi_replace(",","",$_POST['CmpValorTotal']);
	
	//if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId and !empty($InsAlmacenMovimientoEntrada->AmoTipoCambio)){
//		$InsAlmacenMovimientoEntrada->AmoValorTotal = round($InsAlmacenMovimientoEntrada->AmoValorTotal * $InsAlmacenMovimientoEntrada->AmoTipoCambio,3);
//	}	

	$ResAlmacenMovimientoEntradaDetalle = $_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

//SesionObjeto-AlmacenMovimientoEntradaDetalle
//Parametro1 = AmdId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = AmdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
	
	if( $InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
		$InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo = $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
	}else{
		$InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo = $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo;
	}
	
	if( $InsAlmacenMovimientoEntrada->MonIdNacional2<>$EmpresaMonedaId ){
		$InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete = $InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
	}else{
		$InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete = $InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete;
	}
	
	if( $InsAlmacenMovimientoEntrada->MonIdNacional3<>$EmpresaMonedaId ){
		$InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto = $InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
	}else{
		$InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto = $InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto;
	}

		
				
//		if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
//			$TotalRecargo = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo * $InsAlmacenMovimientoEntrada->AmoTipoCambio);
//		}else{
//			$TotalRecargo = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo);
//		}
//		
//		if($InsAlmacenMovimientoEntrada->MonIdNacional2<>$EmpresaMonedaId){
//			$TotalFlete = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete * $InsAlmacenMovimientoEntrada->AmoTipoCambio);
//		}else{
//			$TotalFlete = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete);
//		}
//		
//		if($InsAlmacenMovimientoEntrada->MonIdNacional3<>$EmpresaMonedaId){
//			$TotalOtroCosto = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto * $InsAlmacenMovimientoEntrada->AmoTipoCambio);
//		}else{
//			$TotalOtroCosto = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto);	
//		}




	if(!empty($ResAlmacenMovimientoEntradaDetalle['Datos'])){

		$SumaValorTotal = 0;		
		foreach($ResAlmacenMovimientoEntradaDetalle['Datos'] as $DatSesionObjeto){

			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
				$SumaValorTotal += $DatSesionObjeto->Parametro6 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
			}else{
				$SumaValorTotal += $DatSesionObjeto->Parametro6;
			}

		}
		
		if(empty($SumaValorTotal)){
			$SumaValorTotal = 1;
		}
		
		foreach($ResAlmacenMovimientoEntradaDetalle['Datos'] as $DatSesionObjeto){
				
			//$DatSesionObjeto->Parametro6 = round($DatSesionObjeto->Parametro4 * $DatSesionObjeto->Parametro5,6);  
//			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
//				
//				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
//				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
//				$DatSesionObjeto->Parametro13 = $DatSesionObjeto->Parametro13 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
//				
//			}

			$InsAlmacenMovimientoEntradaDetalle1 = new ClsAlmacenMovimientoEntradaDetalle();
			$InsAlmacenMovimientoEntradaDetalle1->AmdId = $DatSesionObjeto->Parametro1;
			$InsAlmacenMovimientoEntradaDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsAlmacenMovimientoEntradaDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			
			if(!empty($DatSesionObjeto->Parametro20)){
				$Existe = $InsAlmacenMovimientoEntradaDetalle1->MtdVerificarExisteUltimoAlmacenMovimientoEntradaDetalleId($DatSesionObjeto->Parametro20);
				if(!$Existe){
					$InsAlmacenMovimientoEntradaDetalle1->AmdIdAnterior = $InsAlmacenMovimientoEntradaDetalle1->MtdObtenerUltimoAlmacenMovimientoEntradaDetalleId($InsAlmacenMovimientoEntradaDetalle1->ProId,$InsAlmacenMovimientoEntrada->AmoFecha);
				}
			}

			//$InsAlmacenMovimientoEntradaDetalle1->AmdCosto = $DatSesionObjeto->Parametro4;			
			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
				$InsAlmacenMovimientoEntradaDetalle1->AmdCosto = $DatSesionObjeto->Parametro4 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
			}else{
				$InsAlmacenMovimientoEntradaDetalle1->AmdCosto = $DatSesionObjeto->Parametro4;
			}
			
			$InsAlmacenMovimientoEntradaDetalle1->AmdCostoAnterior = $DatSesionObjeto->Parametro15;
			
			$InsAlmacenMovimientoEntradaDetalle1->AmdCantidad = $DatSesionObjeto->Parametro5;
			$InsAlmacenMovimientoEntradaDetalle1->AmdCantidadReal = $DatSesionObjeto->Parametro12;
			
			$InsAlmacenMovimientoEntradaDetalle1->AmdUtilidadPorcentaje = $DatSesionObjeto->Parametro14;
			
			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
				$InsAlmacenMovimientoEntradaDetalle1->AmdUtilidad = $DatSesionObjeto->Parametro13 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
			}else{
				$InsAlmacenMovimientoEntradaDetalle1->AmdUtilidad = $DatSesionObjeto->Parametro13;
			}
			//$InsAlmacenMovimientoEntradaDetalle1->AmdUtilidad = $DatSesionObjeto->Parametro13;
			
			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
				$InsAlmacenMovimientoEntradaDetalle1->AmdImporte = $DatSesionObjeto->Parametro6 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
			}else{
				$InsAlmacenMovimientoEntradaDetalle1->AmdImporte = $DatSesionObjeto->Parametro6;
			}
			//$InsAlmacenMovimientoEntradaDetalle1->AmdImporte = $DatSesionObjeto->Parametro6;
			
			//INTERNACIONALES
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAduana = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduana)/$SumaValorTotal,6);
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalTransporte = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalTransporte)/$SumaValorTotal,6);
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalDesestiba = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba)/$SumaValorTotal,6);
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAlmacenaje = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje)/$SumaValorTotal,6);
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAdValorem = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem)/$SumaValorTotal,6);
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAduanaNacional = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional)/$SumaValorTotal,6);
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalGastoAdministrativo = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo)/$SumaValorTotal,6);
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalOtroCosto1 = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1)/$SumaValorTotal,6);
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalOtroCosto2 = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2)/$SumaValorTotal,6);

			//NACIONALES
			$InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalRecargo = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo)/$SumaValorTotal,6);
			$InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalFlete = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete)/$SumaValorTotal,6);
			$InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalOtroCosto = round(($InsAlmacenMovimientoEntradaDetalle1->AmdImporte * $InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto)/$SumaValorTotal,6);

			$InsAlmacenMovimientoEntradaDetalle1->AmdEstado = $DatSesionObjeto->Parametro25;
			$InsAlmacenMovimientoEntradaDetalle1->AmdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsAlmacenMovimientoEntradaDetalle1->AmdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsAlmacenMovimientoEntradaDetalle1->AmdEliminado = $DatSesionObjeto->Eliminado;				
			$InsAlmacenMovimientoEntradaDetalle1->InsMysql = NULL;
			
//			$RecargoUnitario = round(($DatSesionObjeto->Parametro6 * $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo)/$SumaValorTotal,3);
//			$FleteUnitario = round(($DatSesionObjeto->Parametro6 * $InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete)/$SumaValorTotal,3);
//			$OtroCosto = round(($DatSesionObjeto->Parametro6 * $InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto)/$SumaValorTotal,3);
//			$TotalImportacion = round(($DatSesionObjeto->Parametro6 * $InsAlmacenMovimientoEntrada->AmoTotalInternacional)/$SumaValorTotal,3);

			//SE ESTA IGNORADO LA IMPORTACION
			$InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraTotal = round($InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalRecargo + $InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalFlete + $InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalOtroCosto,6);
			$InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraTotal =  round($InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraTotal/(($InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta/100)+1),6);

			$InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraUnitario = round($InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraTotal/$DatSesionObjeto->Parametro5,6);

			$InsAlmacenMovimientoEntradaDetalle1->AmdValorTotal =  round($InsAlmacenMovimientoEntradaDetalle1->AmdCosto + $InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraUnitario,6);
			
			settype($InsAlmacenMovimientoEntradaDetalle1->AmdCostoAnterior,"float");
		
			if(empty($InsAlmacenMovimientoEntradaDetalle1->AmdCostoAnterior)){
				$InsAlmacenMovimientoEntradaDetalle1->AmdCostoPromedio =  round(($InsAlmacenMovimientoEntradaDetalle1->AmdValorTotal),6);				
			}else{
				$InsAlmacenMovimientoEntradaDetalle1->AmdCostoPromedio =  round(($InsAlmacenMovimientoEntradaDetalle1->AmdValorTotal + $InsAlmacenMovimientoEntradaDetalle1->AmdCostoAnterior)/2,6);				
			}			
			
			$InsAlmacenMovimientoEntradaDetalle1->PcdId = $DatSesionObjeto->Parametro21;
			$InsAlmacenMovimientoEntradaDetalle1->PcoId = $DatSesionObjeto->Parametro22;
			$InsAlmacenMovimientoEntradaDetalle1->PcoFecha = $DatSesionObjeto->Parametro23;
			$InsAlmacenMovimientoEntradaDetalle1->CliNombreCompleto = $DatSesionObjeto->Parametro24;
			
			$InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle[] = $InsAlmacenMovimientoEntradaDetalle1;

			if($InsAlmacenMovimientoEntradaDetalle1->AmdEliminado==1){
				$InsAlmacenMovimientoEntrada->AmoSubTotal += $InsAlmacenMovimientoEntradaDetalle1->AmdImporte;
			}			

		}		
	
	}else{
		$Guardar = false;
		$Resultado.='#ERR_AMO_111';
	}
	
//	
//$SubTotal = round($SubTotal,2);
//$Recargo = $POST_TotalRecargo;
//$Impuesto = round(($SubTotal + $Recargo) * ($EmpresaImpuestoVenta/100),2);
//$Total = $SubTotal + $Recargo + $Impuesto;


		$InsAlmacenMovimientoEntrada->AmoImpuesto = round( ($InsAlmacenMovimientoEntrada->AmoSubTotal + $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo) * ($InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta/100),3);
		//$InsAlmacenMovimientoEntrada->AmoImpuesto = round($InsAlmacenMovimientoEntrada->AmoSubTotal * ($InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta/100),3);
		$InsAlmacenMovimientoEntrada->AmoTotal = $InsAlmacenMovimientoEntrada->AmoSubTotal + $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo + $InsAlmacenMovimientoEntrada->AmoImpuesto;
		
//		deb($InsAlmacenMovimientoEntrada->AmoSubTotal);
//		deb($InsAlmacenMovimientoEntrada->AmoImpuesto);
//		deb($InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo);
//		deb($InsAlmacenMovimientoEntrada->AmoTotal);
		
//$SubTotal = round($SubTotal,2);
//$Recargo = $POST_TotalRecargo;
//$Impuesto = round(($SubTotal + $Recargo) * ($EmpresaImpuestoVenta/100),2);
//$Total = $SubTotal + $Recargo + $Impuesto;

	if($Guardar){
		
		if($InsAlmacenMovimientoEntrada->MtdEditarAlmacenMovimientoEntrada()){		

				if(!empty($_POST['CmpGenerarVentaConcretada'])){

					$VentaDirectas = "";
					$ResOrdenCompraPedido = $_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdObtenerSesionObjetos(false);
					$ArrOrdenCompraPedidos = $ResOrdenCompraPedido['Datos'];

					//deb($ArrOrdenCompraPedidos);
					foreach($ArrOrdenCompraPedidos as $DatSesionObjeto){
						$VentaDirectas .= "#".$DatSesionObjeto->Parametro4;
					}

					$InsVentaDirecta = new ClsVentaDirecta();
					$InsVentaDirecta->MtdGenerarVentaConcretada($VentaDirectas,true);

				}
			
			FncCargarDatos();
			$Resultado.='#SAS_AMO_102';
			$Edito = true;

		} else{
	
			$InsAlmacenMovimientoEntrada->AmoFecha = FncCambiaFechaANormal($InsAlmacenMovimientoEntrada->AmoFecha);
			$InsAlmacenMovimientoEntrada->AmoComprobanteFecha = FncCambiaFechaANormal($InsAlmacenMovimientoEntrada->AmoComprobanteFecha,true);
			$InsAlmacenMovimientoEntrada->AmoGuiaRemisionFecha = FncCambiaFechaANormal($InsAlmacenMovimientoEntrada->AmoGuiaRemisionFecha,true);
			
//			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
//				$InsAlmacenMovimientoEntrada->AmoValorTotal = ($InsAlmacenMovimientoEntrada->AmoValorTotal / $InsAlmacenMovimientoEntrada->AmoTipoCambio);
//			}
			
			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
				$TotalRecargo = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo / $InsAlmacenMovimientoEntrada->AmoTipoCambio);
			}
						
			if($InsAlmacenMovimientoEntrada->MonIdNacional2<>$EmpresaMonedaId){
				$TotalFlete = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete / $InsAlmacenMovimientoEntrada->AmoTipoCambio);
			}
			
			if($InsAlmacenMovimientoEntrada->MonIdNacional3<>$EmpresaMonedaId){
				$TotalOtroCosto = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto / $InsAlmacenMovimientoEntrada->AmoTipoCambio);
			}			
	
			$Resultado.='#ERR_AMO_102';
		}
		
	}else{
		
		$InsAlmacenMovimientoEntrada->AmoFecha = FncCambiaFechaANormal($InsAlmacenMovimientoEntrada->AmoFecha);
		$InsAlmacenMovimientoEntrada->AmoComprobanteFecha = FncCambiaFechaANormal($InsAlmacenMovimientoEntrada->AmoComprobanteFecha,true);
		$InsAlmacenMovimientoEntrada->AmoGuiaRemisionFecha = FncCambiaFechaANormal($InsAlmacenMovimientoEntrada->AmoGuiaRemisionFecha,true);

//			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
//				$InsAlmacenMovimientoEntrada->AmoValorTotal = round($InsAlmacenMovimientoEntrada->AmoValorTotal / $InsAlmacenMovimientoEntrada->AmoTipoCambio,3);
//			}

			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
				$InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo / $InsAlmacenMovimientoEntrada->AmoTipoCambio);
			}

			if($InsAlmacenMovimientoEntrada->MonIdNacional2<>$EmpresaMonedaId){
				$InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete / $InsAlmacenMovimientoEntrada->AmoTipoCambio);
			}

			if($InsAlmacenMovimientoEntrada->MonIdNacional3<>$EmpresaMonedaId){
				$InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto / $InsAlmacenMovimientoEntrada->AmoTipoCambio);
			}

	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){

	global $GET_id;
	global $Identificador;
	global $InsAlmacenMovimientoEntrada;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]);
	unset($_SESSION['SesAmoFoto'.$Identificador]);
	unset($_SESSION['SesAmoGuiaRemisionFoto'.$Identificador]);
	
	unset($_SESSION['SesAmoNacionalFoto1'.$Identificador]);
	unset($_SESSION['SesAmoNacionalFoto2'.$Identificador]);
	unset($_SESSION['SesAmoNacionalFoto3'.$Identificador]);

	$_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsAlmacenMovimientoEntrada->AmoId = $GET_id;
	$InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntrada();		

	if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
		$InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo / $InsAlmacenMovimientoEntrada->AmoTipoCambio);
	}
	
	if($InsAlmacenMovimientoEntrada->MonIdNacional2<>$EmpresaMonedaId){
		$InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete / $InsAlmacenMovimientoEntrada->AmoTipoCambio);
	}
	
	if($InsAlmacenMovimientoEntrada->MonIdNacional3<>$EmpresaMonedaId){
		$InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto = ($InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto / $InsAlmacenMovimientoEntrada->AmoTipoCambio);
	}
	
	
	$_SESSION['SesAmoFoto'.$Identificador] =	$InsAlmacenMovimientoEntrada->AmoFoto;
	$_SESSION['SesAmoGuiaRemisionFoto'.$Identificador] = $InsAlmacenMovimientoEntrada->AmoGuiaRemisionFoto;
	
	$_SESSION['SesAmoNacionalFoto1'.$Identificador] = $InsAlmacenMovimientoEntrada->AmoNacionalFoto1;
	$_SESSION['SesAmoNacionalFoto2'.$Identificador] = $InsAlmacenMovimientoEntrada->AmoNacionalFoto2;
	$_SESSION['SesAmoNacionalFoto3'.$Identificador] = $InsAlmacenMovimientoEntrada->AmoNacionalFoto3;

		if(!empty($InsAlmacenMovimientoEntrada->OcoId)){
			
			$InsOrdenCompra = new ClsOrdenCompra();
			$InsOrdenCompra->OcoId = $InsAlmacenMovimientoEntrada->OcoId;
			$InsOrdenCompra->MtdObtenerOrdenCompra();	
	
			unset($_SESSION['InsOrdenCompraPedido'.$Identificador]);
	
			$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();

			if(!empty($InsOrdenCompra->OrdenCompraPedido)){
				foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
		
					$InsPedidoCompra = new ClsPedidoCompra();
					$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
					$InsPedidoCompra->MtdObtenerPedidoCompra();

					$ArrVentaConcretadas2 = array();
					
					if(!empty($InsPedidoCompra->VdiId)){
						
						$InsVentaConcretada = new ClsVentaConcretada();
						
						$ResVentaConcretada = $InsVentaConcretada->MtdObtenerVentaConcretadas(NULL,NULL,NULL,'AmoId','Desc',NULL,NULL,NULL,3,0,0,0,$InsPedidoCompra->VdiId,NULL);
						$ArrVentaConcretadas = $ResVentaConcretada['Datos'];
						
						if(!empty($ArrVentaConcretadas)){
							foreach($ArrVentaConcretadas as $DatVentaConcretada){
								
								$ArrVentaConcretadas2[] = $DatVentaConcretada->VcoId;
								
							}
						}
						
					}


					$_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdAgregarSesionObjeto(1,
					$InsPedidoCompra->PcoId,
					$InsPedidoCompra->PcoFecha,
					$InsPedidoCompra->CliNombreCompleto,
					$InsPedidoCompra->VdiId,
					$InsPedidoCompra->VdiFecha,
					$InsPedidoCompra->CprId,
					$InsPedidoCompra->CprFecha,
					$InsPedidoCompra->VdiOrdenCompraNumero,
					$InsPedidoCompra->VdiOrdenCompraFecha,
					$ArrVentaConcretadas2
					);


				}
			}
			
						
		}





	

	if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId and (!empty($InsAlmacenMovimientoEntrada->AmoTipoCambio) )){
		$InsAlmacenMovimientoEntrada->AmoValorTotal = round($InsAlmacenMovimientoEntrada->AmoValorTotal / $InsAlmacenMovimientoEntrada->AmoTipoCambio,3);
	}
			
	//deb($InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle);
	
	if(!empty($InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle)){
		foreach($InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle as $DatAlmacenMovimientoEntradaDetalle){

			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId and (!empty($InsAlmacenMovimientoEntrada->AmoTipoCambio) )){
				$DatAlmacenMovimientoEntradaDetalle->AmdImporte = round($DatAlmacenMovimientoEntradaDetalle->AmdImporte / $InsAlmacenMovimientoEntrada->AmoTipoCambio,3);
				$DatAlmacenMovimientoEntradaDetalle->AmdCosto = round($DatAlmacenMovimientoEntradaDetalle->AmdCosto  / $InsAlmacenMovimientoEntrada->AmoTipoCambio,3);
				$DatAlmacenMovimientoEntradaDetalle->AmdCostoAnterior = round($DatAlmacenMovimientoEntradaDetalle->AmdCostoAnterior  / $InsAlmacenMovimientoEntrada->AmoTipoCambio,3);
				$DatAlmacenMovimientoEntradaDetalle->AmdCostoTotal = round($DatAlmacenMovimientoEntradaDetalle->AmdCostoTotal  / $InsAlmacenMovimientoEntrada->AmoTipoCambio,3);
				$DatAlmacenMovimientoEntradaDetalle->AmdUtilidad = round($DatAlmacenMovimientoEntradaDetalle->AmdUtilidad  / $InsAlmacenMovimientoEntrada->AmoTipoCambio,3);
			}

//SesionObjeto-AlmacenMovimientoEntradaDetalle
//Parametro1 = AmdId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = AmdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
//Parametro25 = AmdEstado
				
			
			$_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatAlmacenMovimientoEntradaDetalle->AmdId,
			$DatAlmacenMovimientoEntradaDetalle->ProId,
			$DatAlmacenMovimientoEntradaDetalle->ProNombre,
			$DatAlmacenMovimientoEntradaDetalle->AmdCosto,
			$DatAlmacenMovimientoEntradaDetalle->AmdCantidad,
			$DatAlmacenMovimientoEntradaDetalle->AmdImporte,
			($DatAlmacenMovimientoEntradaDetalle->AmdTiempoCreacion),
			($DatAlmacenMovimientoEntradaDetalle->AmdTiempoModificacion),
			$DatAlmacenMovimientoEntradaDetalle->UmeNombre,
			$DatAlmacenMovimientoEntradaDetalle->UmeId,
			$DatAlmacenMovimientoEntradaDetalle->RtiId,
			$DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal,			
			$DatAlmacenMovimientoEntradaDetalle->AmdUtilidad,
			$DatAlmacenMovimientoEntradaDetalle->AmdUtilidadPorcentaje,
			$DatAlmacenMovimientoEntradaDetalle->AmdCostoAnterior,
			$DatAlmacenMovimientoEntradaDetalle->AmdCostoTotal,
			$DatAlmacenMovimientoEntradaDetalle->ProCodigoOriginal,
			$DatAlmacenMovimientoEntradaDetalle->ProCodigoAlternativo,
			$DatAlmacenMovimientoEntradaDetalle->UmeIdOrigen,
			NULL,
			$DatAlmacenMovimientoEntradaDetalle->PcdId,
			$DatAlmacenMovimientoEntradaDetalle->PcoId,
			$DatAlmacenMovimientoEntradaDetalle->PcoFecha,
			$DatAlmacenMovimientoEntradaDetalle->CliNombreCompleto,
			$DatAlmacenMovimientoEntradaDetalle->AmdEstado);

		}
	}
	
	
}
?>