<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsAlmacenMovimientoEntrada->UsuId = $_SESSION['SesionId'];	

	$InsAlmacenMovimientoEntrada->AmoId = $_POST['CmpId'];
	$InsAlmacenMovimientoEntrada->SucId = $_SESSION['SesionSucursal'];
	
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


	$InsAlmacenMovimientoEntrada->MonId = $EmpresaMonedaId;
	$InsAlmacenMovimientoEntrada->AmoTipoCambio = NULL;
	$InsAlmacenMovimientoEntrada->AmoIncluyeImpuesto = 2;

	$InsAlmacenMovimientoEntrada->AmoCantidadDia = 0;
	$InsAlmacenMovimientoEntrada->AmoDocumentoOrigen = 0;


	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduana = 0;
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalTransporte = 0;
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba = 0;
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje = 0;
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem= 0;
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional = 0;
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo = 0;
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1 = 0;
	$InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2 = 0;

	$InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo = 0;
	$InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete = 0;
	$InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto= 0;
	
	$InsAlmacenMovimientoEntrada->AmoTotalNacional= 0;
	$InsAlmacenMovimientoEntrada->AmoTotalInternacional= 0;
		 
	$InsAlmacenMovimientoEntrada->AmoTipo = 1;
	$InsAlmacenMovimientoEntrada->AmoSubTipo = 2;
	$InsAlmacenMovimientoEntrada->AmoEstado = $_POST['CmpEstado'];
	
	$InsAlmacenMovimientoEntrada->AmoTiempoCreacion = date("Y-m-d H:i:s");
	$InsAlmacenMovimientoEntrada->AmoTiempoModificacion = date("Y-m-d H:i:s");
	$InsAlmacenMovimientoEntrada->AmoEliminado = 1;
	
	$InsAlmacenMovimientoEntrada->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsAlmacenMovimientoEntrada->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsAlmacenMovimientoEntrada->PrvNombreCompleto = $_POST['CmpProveedorNombre'];
	$InsAlmacenMovimientoEntrada->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsAlmacenMovimientoEntrada->AmoFoto = $_SESSION['SesAmoFoto'.$Identificador];

	
	settype($InsAlmacenMovimientoEntrada->AmoTipoCambio,"float");
		
	$InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle = array();
	
	if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
		if(empty($InsAlmacenMovimientoEntrada->AmoTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_AMO_600';
		}
	}
	
	if(empty($InsAlmacenMovimientoEntrada->AlmId)){
		$Guardar = false;
		$Resultado.='#ERR_AMO_602';
	}
		
	$InsAlmacenMovimientoEntrada->AmoTotalBruto = 0;
	$InsAlmacenMovimientoEntrada->AmoSubTotal = 0;
	$InsAlmacenMovimientoEntrada->AmoImpuesto = 0;
	$InsAlmacenMovimientoEntrada->AmoTotal = 0;
	
	$InsAlmacenMovimientoEntrada->AmoValorTotal = 0;
	
	
//
//
//SesionObjeto-AlmacenMovimientoEntradaSimpleDetalle
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

	$ResAlmacenMovimientoEntradaSimpleDetalle = $_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	
	//if(!empty($ResAlmacenMovimientoEntradaSimpleDetalle['Datos'])){

		$SumaValorTotal = 0;		
		foreach($ResAlmacenMovimientoEntradaSimpleDetalle['Datos'] as $DatSesionObjeto){

			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
				$SumaValorTotal += $DatSesionObjeto->Parametro6 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
			}else{
				$SumaValorTotal += $DatSesionObjeto->Parametro6;
			}

		}
		
		if(empty($SumaValorTotal)){
			$SumaValorTotal = 1;
		}
		

		foreach($ResAlmacenMovimientoEntradaSimpleDetalle['Datos'] as $DatSesionObjeto){

//			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
//				
//				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
//				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
//				$DatSesionObjeto->Parametro13 = $DatSesionObjeto->Parametro13 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
//				
//			}
			
			$InsAlmacenMovimientoEntradaDetalle1 = new ClsAlmacenMovimientoEntradaDetalle();
			$InsAlmacenMovimientoEntradaDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsAlmacenMovimientoEntradaDetalle1->UmeId = $DatSesionObjeto->Parametro10;

			$InsAlmacenMovimientoEntradaDetalle1->AmdIdAnterior = $InsAlmacenMovimientoEntradaDetalle1->MtdObtenerUltimoAlmacenMovimientoEntradaDetalleId($InsAlmacenMovimientoEntradaDetalle1->ProId,$InsAlmacenMovimientoEntrada->AmoFecha);
				
			//$InsAlmacenMovimientoEntradaDetalle1->AmdIdAnterior = $DatSesionObjeto->Parametro20;

			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
				$InsAlmacenMovimientoEntradaDetalle1->AmdCosto = $DatSesionObjeto->Parametro4 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
			}else{
				$InsAlmacenMovimientoEntradaDetalle1->AmdCosto = $DatSesionObjeto->Parametro4;
			}

			$InsAlmacenMovimientoEntradaDetalle1->AmdCostoAnterior = $DatSesionObjeto->Parametro15;
			
			$InsAlmacenMovimientoEntradaDetalle1->AmdCantidad = $DatSesionObjeto->Parametro5;
			$InsAlmacenMovimientoEntradaDetalle1->AmdCantidadReal = $DatSesionObjeto->Parametro12;

			$InsAlmacenMovimientoEntradaDetalle1->AmdUtilidadPorcentaje = $DatSesionObjeto->Parametro14;

			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
				$InsAlmacenMovimientoEntradaDetalle1->AmdUtilidad = $DatSesionObjeto->Parametro13 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
			}else{
				$InsAlmacenMovimientoEntradaDetalle1->AmdUtilidad = $DatSesionObjeto->Parametro13;
			}

			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
			
				$InsAlmacenMovimientoEntradaDetalle1->AmdImporte = $DatSesionObjeto->Parametro6 * $InsAlmacenMovimientoEntrada->AmoTipoCambio;
			}else{
			
				$InsAlmacenMovimientoEntradaDetalle1->AmdImporte = $DatSesionObjeto->Parametro6;
			}
			
						//INTERNACIONALES
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAduana = 0;
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalTransporte =0;
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalDesestiba = 0;
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAlmacenaje =0;
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAdValorem = 0;
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalAduanaNacional = 0;
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalGastoAdministrativo =0;
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalOtroCosto1 = 0;
			$InsAlmacenMovimientoEntradaDetalle1->AmdInternacionalTotalOtroCosto2 = 0;

			//NACIONALES
			$InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalRecargo = 0;
			$InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalFlete = 0;
			$InsAlmacenMovimientoEntradaDetalle1->AmdNacionalTotalOtroCosto = 0;

			
			$InsAlmacenMovimientoEntradaDetalle1->AmdEstado = $DatSesionObjeto->Parametro25;
			$InsAlmacenMovimientoEntradaDetalle1->AmdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsAlmacenMovimientoEntradaDetalle1->AmdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsAlmacenMovimientoEntradaDetalle1->AmdEliminado = $DatSesionObjeto->Eliminado;				
			$InsAlmacenMovimientoEntradaDetalle1->InsMysql = NULL;

			
			$InsAlmacenMovimientoEntradaDetalle1->AmdCostoExtraTotal = 0;

			
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
			
			
			//deb($InsAlmacenMovimientoEntradaDetalle1->AmdEliminado);
			if($InsAlmacenMovimientoEntradaDetalle1->AmdEliminado==1){					
				$InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle[] = $InsAlmacenMovimientoEntradaDetalle1;		
				$InsAlmacenMovimientoEntrada->AmoSubTotal += $InsAlmacenMovimientoEntradaDetalle1->AmdImporte;
			}
		}		
		
//	}else{
//		$Guardar = false;
//		$Resultado.='#ERR_AMO_111';
//	}


//	$ResOrdenCompraPedido = $_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdObtenerSesionObjetos(true);
//	
//	foreach($ResOrdenCompraPedido['Datos'] as $DatSesionObjeto){
//	
//		$InsOrdenCompraPedido1 = new ClsOrdenCompraPedido();
//		$InsOrdenCompraPedido1->PcoId = $DatSesionObjeto->Parametro1;
//		$InsAlmacenMovimientoEntrada->OrdenCompraPedido[] = $InsOrdenCompraPedido1;		
//	
//	}


//	$_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdAgregarSesionObjeto(1,
//					$InsPedidoCompra->PcoId,
//					$InsPedidoCompra->PcoFecha,
//					$InsPedidoCompra->CliNombreCompleto,
//					$InsPedidoCompra->VdiId,
//					$InsPedidoCompra->VdiFecha,
//					$InsPedidoCompra->CprId,
//					$InsPedidoCompra->CprFecha,
//					$InsPedidoCompra->VdiOrdenCompraNumero,
//					$InsPedidoCompra->VdiOrdenCompraFecha,
//					$ArrVentaConcretadas2,
//					2
//					);
				
	$InsAlmacenMovimientoEntrada->AmoImpuesto = round( ($InsAlmacenMovimientoEntrada->AmoSubTotal + $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo) * ($InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta/100),3);
	$InsAlmacenMovimientoEntrada->AmoTotal = $InsAlmacenMovimientoEntrada->AmoSubTotal + $InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo + $InsAlmacenMovimientoEntrada->AmoImpuesto;

/*echo "<br><br><br>";

echo "A: ";
echo $InsAlmacenMovimientoEntrada->AmoSubTotal;
echo " - B: ";
echo $InsAlmacenMovimientoEntrada->AmoValorTotal;
echo " C";*/

	if($Guardar){

		if($InsAlmacenMovimientoEntrada->MtdRegistrarAlmacenMovimientoEntrada()){


				FncNuevo();
		
			$Resultado.='#SAS_AMO_101';
			$Registro = true;
		}else{
			
			$InsAlmacenMovimientoEntrada->AmoFecha = FncCambiaFechaANormal($InsAlmacenMovimientoEntrada->AmoFecha);
			$InsAlmacenMovimientoEntrada->AmoComprobanteFecha = FncCambiaFechaANormal($InsAlmacenMovimientoEntrada->AmoComprobanteFecha,true);
			

			$Resultado.='#ERR_AMO_101';	
		}
			
	}else{
		
			$InsAlmacenMovimientoEntrada->AmoFecha = FncCambiaFechaANormal($InsAlmacenMovimientoEntrada->AmoFecha);
			$InsAlmacenMovimientoEntrada->AmoComprobanteFecha = FncCambiaFechaANormal($InsAlmacenMovimientoEntrada->AmoComprobanteFecha,true);
	
	}
	


}else{

	FncNuevo();

}



function FncNuevo(){

	global $Identificador;
	global $InsAlmacenMovimientoEntrada;
		
	unset($_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]);
	unset($_SESSION['InsOrdenCompraPedido'.$Identificador]);
	
	unset($_SESSION['SesAmoFoto'.$Identificador]);
	
	$_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();

	$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
	
	$InsAlmacenMovimientoEntrada->AmoEstado = 3;
	$InsAlmacenMovimientoEntrada->AmoTipoCambio = $_SESSION['SesionTipoCambioCompra'];
	$InsAlmacenMovimientoEntrada->TopId = "TOP-10004";
	$InsAlmacenMovimientoEntrada->CtiId = "CTI-10000";
	$InsAlmacenMovimientoEntrada->TdoId = "TDO-10003";
	$InsAlmacenMovimientoEntrada->NpaId = "NPA-10000";
	$InsAlmacenMovimientoEntrada->AmoCantidadDia = 0;
	
	$InsAlmacenMovimientoEntrada->TdoIdInternacional1 = "TDO-10003";
	$InsAlmacenMovimientoEntrada->TdoIdInternacional2 = "TDO-10003";
	$InsAlmacenMovimientoEntrada->TdoIdInternacional3 = "TDO-10003";
	$InsAlmacenMovimientoEntrada->TdoIdInternacional4 = "TDO-10003";
	$InsAlmacenMovimientoEntrada->TdoIdInternacional5 = "TDO-10003";
	$InsAlmacenMovimientoEntrada->TdoIdInternacional6 = "TDO-10003";
	$InsAlmacenMovimientoEntrada->TdoIdInternacional7 = "TDO-10003";
	$InsAlmacenMovimientoEntrada->TdoIdInternacional8 = "TDO-10003";
	$InsAlmacenMovimientoEntrada->TdoIdInternacional9 = "TDO-10003";	

	$InsAlmacenMovimientoEntrada->TdoIdNacional1 = "TDO-10003";
	$InsAlmacenMovimientoEntrada->TdoIdNacional2 = "TDO-10003";
	$InsAlmacenMovimientoEntrada->TdoIdNacional3 = "TDO-10003";
	
	$InsAlmacenMovimientoEntrada->AlmId = "";
	$InsAlmacenMovimientoEntrada->SucId = $_SESSION['SesionSucursal'];
	
}
?>