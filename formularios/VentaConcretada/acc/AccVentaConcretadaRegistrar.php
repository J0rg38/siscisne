<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){		
	
	$Resultado = '';
	$Guardar = true;
	
	$InsVentaConcretada->UsuId = $_SESSION['SesionId'];	
	$InsVentaConcretada->SucId = $_SESSION['SesionSucursal'];

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
	$InsVentaConcretada->VcoOrigen =  $_POST['CmpOrigen'];

	$InsVentaConcretada->VcoDescuento = preg_replace("/,/", "", (empty($_POST['CmpDescuento'])?0:$_POST['CmpDescuento']));
	$InsVentaConcretada->VcoManoObra = preg_replace("/,/", "", (empty($_POST['CmpManoObra'])?0:$_POST['CmpManoObra']));
	
	if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
		$InsVentaConcretada->VcoDescuento = $InsVentaConcretada->VcoDescuento * $InsVentaConcretada->VcoTipoCambio;
	}
	
	
	if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
		$InsVentaConcretada->VcoManoObra = $InsVentaConcretada->VcoManoObra * $InsVentaConcretada->VcoTipoCambio;
	}
	
	
	$InsVentaConcretada->VcoIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	
	$InsVentaConcretada->VcoEstado = $_POST['CmpEstado'];
	$InsVentaConcretada->VcoTiempoCreacion = date("Y-m-d H:i:s");
	$InsVentaConcretada->VcoTiempoModificacion = date("Y-m-d H:i:s");

	$InsVentaConcretada->VcoPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	//$InsVentaConcretada->VcoMargenUtilidad = $_POST['CmpClienteTipoUtilidad'];
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

	if(empty($InsVentaConcretada->AlmId)){
		$Guardar = false;
		$Resultado.='#ERR_VCO_112';
	}
	
	
//				SesionObjeto-VentaConcretadaDetalle
//				Parametro1 = VcdId
//				Parametro2 = ProId
//				Parametro3 = ProNombre
//				Parametro4 = VcdPrecioVenta
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
//deb($InsVentaConcretada->VcoTipoCambio);

	$ResVentaConcretadaDetalle = $_SESSION['InsVentaConcretadaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResVentaConcretadaDetalle['Datos'])){
		$item = 1;
		foreach($ResVentaConcretadaDetalle['Datos'] as $DatSesionObjeto){
				
			//deb($DatSesionObjeto);
			//echo "<hr>";
			
			$InsVentaConcretadaDetalle1 = new ClsVentaConcretadaDetalle();
			
			$InsVentaConcretadaDetalle1->VerificarStock	= 2;			
			
			$InsVentaConcretadaDetalle1->VcdId = $DatSesionObjeto->Parametro1;
			$InsVentaConcretadaDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsVentaConcretadaDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			$InsVentaConcretadaDetalle1->VddId = $DatSesionObjeto->Parametro18;
			
			$InsVentaConcretadaDetalle1->VcdReingreso = $DatSesionObjeto->Parametro21;
			//$InsVentaConcretadaDetalle1->VcdPrecioVenta = $DatSesionObjeto->Parametro4;
			//$InsVentaConcretadaDetalle1->VcdCosto = $DatSesionObjeto->Parametro17;
			$InsVentaConcretadaDetalle1->VcdCostoExtraTotal = 0;

			if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
				$InsVentaConcretadaDetalle1->VcdCosto = $DatSesionObjeto->Parametro17 * $InsVentaConcretada->VcoTipoCambio;
			}else{
				$InsVentaConcretadaDetalle1->VcdCosto = $DatSesionObjeto->Parametro17;
			}

			if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
				$InsVentaConcretadaDetalle1->VcdPrecioVenta = $DatSesionObjeto->Parametro4 * $InsVentaConcretada->VcoTipoCambio;
			}else{
				$InsVentaConcretadaDetalle1->VcdPrecioVenta = $DatSesionObjeto->Parametro4;
			}

			$InsVentaConcretadaDetalle1->VcdCantidad = $DatSesionObjeto->Parametro5;

				$InsProducto->ProId = $InsVentaConcretadaDetalle1->ProId;
				$InsProducto->MtdObtenerProducto(false);
				
				if(!empty($InsVentaConcretadaDetalle1->UmeId)){
				
					$InsUnidadMedida->UmeId = $InsVentaConcretadaDetalle1->UmeId;
					$InsUnidadMedida->MtdObtenerUnidadMedida();
									  
					if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
						$InsUnidadMedidaConversion->UmcEquivalente = 1;
					}else{
						$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
						$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
						  
						foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
							$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
						}
					}
				
					if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
						$InsVentaConcretadaDetalle1->VcdCantidadReal = round($InsVentaConcretadaDetalle1->VcdCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
					}else{
						$InsVentaConcretadaDetalle1->VcdCantidadReal = '';
					}
				
				}else{
					$InsVentaConcretadaDetalle1->VcdCantidadReal = '';
				}

			if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
				$InsVentaConcretadaDetalle1->VcdImporte = $DatSesionObjeto->Parametro6 * $InsVentaConcretada->VcoTipoCambio;
			}else{
				$InsVentaConcretadaDetalle1->VcdImporte = $DatSesionObjeto->Parametro6;
			}

			$InsVentaConcretadaDetalle1->VcdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsVentaConcretadaDetalle1->VcdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsVentaConcretadaDetalle1->VcdCompraOrigen = NULL;
			$InsVentaConcretadaDetalle1->VcdEstado = $_POST['CmpVentaConcretadaDetalleEstado_'.$DatSesionObjeto->Item];
			
			$InsVentaConcretadaDetalle1->VcdValorTotal = 0;
			$InsVentaConcretadaDetalle1->VcdUtilidad = 0;
			$InsVentaConcretadaDetalle1->VcdEliminado = $DatSesionObjeto->Eliminado;				
			$InsVentaConcretadaDetalle1->InsMysql = NULL;
			
			if($InsVentaConcretadaDetalle1->VcdEliminado==1){		
				
//				$StockReal = 0;
//				
//				$InsAlmacenProducto = new ClsAlmacenProducto();
//				//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
//				$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($DatSesionObjeto->Parametro2,$POST_AlmacenId,date("Y"));
//
//			
//				if($InsProducto->ProStockReal < $InsVentaConcretadaDetalle1->VcdCantidadReal){
//					$InsVentaConcretadaDetalle1->VerificarStock = 1;
//				}
//				
//				if($InsVentaConcretadaDetalle1->VerificarStock == 1 and $InsVentaConcretada->VcoEstado <> 1 and $InsVentaConcretadaDetalle1->VcdEliminado==1){
//					
//					$Guardar = false;
//					$Resultado.='#ERR_VCO_501';
//					$Resultado.='#Item Numero: '.($item);
//					
//				}
		
				$InsVentaConcretada->VentaConcretadaDetalle[] = $InsVentaConcretadaDetalle1;	
				
				
				if($InsVentaConcretadaDetalle1->VcdEstado=="3"){
					$InsVentaConcretada->VcoTotalBruto += $InsVentaConcretadaDetalle1->VcdImporte;	
				}
				
			}

			$item++;	
		}

	}else{
		$Guardar = false;
		$Resultado.='#ERR_VCO_111';
	}
	
	if($InsVentaConcretada->VcoIncluyeImpuesto == 2){
		
		$InsVentaConcretada->VcoSubTotal = $InsVentaConcretada->VcoTotalBruto + $InsVentaConcretada->VcoManoObra - $InsVentaConcretada->VcoDescuento;
		$InsVentaConcretada->VcoImpuesto = ($InsVentaConcretada->VcoSubTotal  * ($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100) );

		$InsVentaConcretada->VcoTotal = $InsVentaConcretada->VcoSubTotal + $InsVentaConcretada->VcoImpuesto;
	
		
	}else{
		
		$InsVentaConcretada->VcoTotal = $InsVentaConcretada->VcoTotalBruto + $InsVentaConcretada->VcoManoObra - $InsVentaConcretada->VcoDescuento;
		$InsVentaConcretada->VcoSubTotal = $InsVentaConcretada->VcoTotal / (($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100)+1);
		$InsVentaConcretada->VcoImpuesto = $InsVentaConcretada->VcoTotal - $InsVentaConcretada->VcoSubTotal;
	
	}


	if($Guardar){
		
		if($InsVentaConcretada->MtdRegistrarVentaConcretada()){
			
			$Registro = true;
			$Resultado.='#SAS_VCO_101';
			
			$InsVentaConcretada->MtdNotificarFacturarVentaConcretada($InsVentaConcretada->VcoId,$_SESSION['SesionId'],$_SESSION['SesionUsuario'],"Cliente: ".$InsVentaConcretada->CliNombre." ".$InsVentaConcretada->CliApellidoPaterno." ".$InsVentaConcretada->CliApellidoMaterno);
			
			
		}else{
			
			
			if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
				$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento / $InsVentaConcretada->VcoTipoCambio,6);
			}
			
			if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
				$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra / $InsVentaConcretada->VcoTipoCambio,6);
			}
		
			$InsVentaConcretada->VcoFecha = FncCambiaFechaANormal($InsVentaConcretada->VcoFecha);
			$InsVentaConcretada->VcoEmpresaTransporteFecha = FncCambiaFechaANormal($InsVentaConcretada->VcoEmpresaTransporteFecha,true);
			
			$Resultado.='#ERR_VCO_101';
		}	

	}else{
		
		$InsVentaConcretada->VcoFecha = FncCambiaFechaANormal($InsVentaConcretada->VcoFecha);
			
	}
	
}else{

	unset($_SESSION['InsVentaConcretadaDetalle'.$Identificador]);

	$_SESSION['InsVentaConcretadaDetalle'.$Identificador] = new ClsSesionObjeto();

	$InsVentaConcretada->VcoEstado = 3;
	$InsVentaConcretada->VcoOrigen = "VCO";
	$InsVentaConcretada->TopId = "TOP-10000";
	$InsVentaConcretada->VcoPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsVentaConcretada->AlmId = "";
	$InsVentaConcretada->SucId = $_SESSION['SesionSucursal'];

	switch($GET_Origen){

		case "VentaDirecta":

			$InsVentaDirecta = new ClsVentaDirecta();
			$InsVentaDirecta->VdiId = $GET_VdiId;
			$InsVentaDirecta->MtdObtenerVentaDirecta();

			$InsVentaConcretada->VdiId = $InsVentaDirecta->VdiId;
			$InsVentaConcretada->CprId = $InsVentaDirecta->CprId;

			$InsVentaConcretada->CliId = $InsVentaDirecta->CliId;
			$InsVentaConcretada->CliNombre = $InsVentaDirecta->CliNombre;
			$InsVentaConcretada->CliApellidoPaterno = $InsVentaDirecta->CliApellidoPaterno;
			$InsVentaConcretada->CliApellidoMaterno = $InsVentaDirecta->CliApellidoMaterno;

			$InsVentaConcretada->CliNumeroDocumento = $InsVentaDirecta->CliNumeroDocumento;
			$InsVentaConcretada->TdoId = $InsVentaDirecta->TdoId;
			$InsVentaConcretada->LtiId = $InsVentaDirecta->LtiId;
			$InsVentaConcretada->VcoMargenUtilidad = $InsVentaDirecta->VdiMargenUtilidad;
			$InsVentaConcretada->VcoOrigen = "VDI";
			//$InsVentaConcretada->VcoDescuento = (($InsVentaDirecta->VdiDescuento/100)*($InsVentaDirecta->VdiValorVenta));
			//$InsVentaConcretada->VcoDescuento = $InsVentaDirecta->VdiDescuento;
			$InsVentaConcretada->VcoDescuento = 0;
			$InsVentaConcretada->VcoIncluyeImpuesto = $InsVentaDirecta->VdiIncluyeImpuesto;

			$InsVentaConcretada->VcoDireccion = $InsVentaDirecta->VdiDireccion;

			$InsVentaConcretada->VcoObservacion = $InsVentaDirecta->VdiObservacion.chr(13).date("d/m/Y H:i:s")." - Venta Concretada Generada de Ord. Ven.:".$InsVentaDirecta->VdiId;
			
			$InsVentaConcretada->MonId = $InsVentaDirecta->MonId;
			$InsVentaConcretada->VcoTipoCambio = $InsVentaDirecta->VdiTipoCambio;

			$InsVentaConcretada->CprId = $InsVentaDirecta->CprId;
			
			$InsVentaConcretada->VcoManoObra = $InsVentaDirecta->VdiManoObra;


			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento / $InsVentaConcretada->VcoTipoCambio,6);
			}
			
			
			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra / $InsVentaConcretada->VcoTipoCambio,6);
			}

			if(!empty($InsVentaDirecta->VentaDirectaDetalle)){
				foreach($InsVentaDirecta->VentaDirectaDetalle as $DatVentaDirectaDetalle){

					if($DatVentaDirectaDetalle->VddEstado == 1){
						
								
						//$DatVentaDirectaDetalle->VerificarStock	= 2;
						$GuardarDetalle = true;
	
						//deb($DatVentaDirectaDetalle->ProIdPedido);
						//deb($DatVentaDirectaDetalle->ProId);
						
						if($DatVentaDirectaDetalle->VddReemplazo == "Si"){
							$InsProducto->ProId = $DatVentaDirectaDetalle->ProIdPedido;
							$InsProducto->MtdObtenerProducto(false);
						}else{
							$InsProducto->ProId = $DatVentaDirectaDetalle->ProId;
							$InsProducto->MtdObtenerProducto(false);
						}
						
						
						
						if(!empty($DatVentaDirectaDetalle->UmeId)){
	
							$InsUnidadMedida->UmeId = $DatVentaDirectaDetalle->UmeId;
							$InsUnidadMedida->MtdObtenerUnidadMedida();
											  
							if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
								$InsUnidadMedidaConversion->UmcEquivalente = 1;
							}else{
								$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
								$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
								  
								foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
									$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
								}
							}
	
							if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
								$DatVentaDirectaDetalle->VddCantidadReal = round($DatVentaDirectaDetalle->VddCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
							}else{
								$DatVentaDirectaDetalle->VddCantidadReal = '';
							}
						
						}else{
							$DatVentaDirectaDetalle->VddCantidadReal = '';
						}
							
						$DatVentaDirectaDetalle->ProCosto = $InsProducto->ProCosto;
						
						if($DatVentaDirectaDetalle->VddCantidadPendiente2<=0){
							$GuardarDetalle = false;	
						}

						
						if($GuardarDetalle){

	//						deb($InsProducto->ProCodigoOriginal." - ".$InsProducto->ProStockReal." - ".$DatVentaDirectaDetalle->VddCantidadReal);
							//$DatVentaDirectaDetalle->VddCantidadReal = $DatVentaDirectaDetalle->VddCantidadPendiente2 * $InsUnidadMedidaConversion->UmcEquivalente;
							$CantidadPendienteReal  = $DatVentaDirectaDetalle->VddCantidadPendiente2 * $InsUnidadMedidaConversion->UmcEquivalente;
							//deb($InsProducto->ProStockReal." - ". $DatVentaDirectaDetalle->VddCantidadReal);
							//if($InsProducto->ProStockReal < $DatVentaDirectaDetalle->VddCantidadReal){
							//if($InsProducto->ProStockReal < $CantidadPendienteReal){
//								$DatVentaDirectaDetalle->VerificarStock = 1;
//							}	REVISAR QUE NO SE UTILIZA REALMENTE
							
							$CantidadPendiente = $DatVentaDirectaDetalle->VddCantidadPendiente2;
							//$DatVentaDirectaDetalle->VddImporte = $DatVentaDirectaDetalle->VddPrecioVenta * $CantidadPendiente;
							
/*							if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
								
								$DatVentaDirectaDetalle->ProCosto = round($DatVentaDirectaDetalle->ProCosto / $InsVentaConcretada->VcoTipoCambio,6);
								$DatVentaDirectaDetalle->VddPrecioVenta = round($DatVentaDirectaDetalle->VddPrecioVenta / $InsVentaConcretada->VcoTipoCambio,6);
								$DatVentaDirectaDetalle->VddImporte = round($DatVentaDirectaDetalle->VddImporte / $InsVentaConcretada->VcoTipoCambio,6);
							}*/
						
				//if(!empty($InsVentaDirecta->VdiPorcentajeDescuento)){
//					
//					$DetallePrecio = ($DatVentaDirectaDetalle->VddPrecioBruto);
//					$DetalleImporte = ($DetallePrecio *  $CantidadPendiente);
//				
//				}else{
				
							$DetallePrecio = ($DatVentaDirectaDetalle->VddPrecioVenta);
							$DetalleImporte = ($DetallePrecio *  $CantidadPendiente);
				
				//}
				
				
				
				
								
//				150 - 20%(30)     120
				
				
				if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				
					$DatVentaDirectaDetalle->ProCosto = round($DatVentaDirectaDetalle->ProCosto / $InsVentaConcretada->VcoTipoCambio,6);
					
					$DetallePrecio = round($DetallePrecio / $InsVentaConcretada->VcoTipoCambio,6);
					$DetalleImporte = round($DetalleImporte / $InsVentaConcretada->VcoTipoCambio,6);
					
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
//				Parametro23 = VcdCompraOrigen
	
							$_SESSION['InsVentaConcretadaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$InsProducto->ProId,
							$InsProducto->ProNombre,
							
							$DetallePrecio,
							$CantidadPendiente,
							$DetalleImporte,
							
							(date("d/m/Y H:i:s")),
							(date("d/m/Y H:i:s")),
							$DatVentaDirectaDetalle->UmeNombre,
							$DatVentaDirectaDetalle->UmeId,
							$DatVentaDirectaDetalle->RtiId,
							
							$CantidadPendienteReal,							
							$InsProducto->ProCodigoOriginal,
							$InsProducto->ProCodigoAlternativo,
							$DatVentaDirectaDetalle->UmeIdOrigen,
							0,
							$DatVentaDirectaDetalle->ProCosto,
							
							$DatVentaDirectaDetalle->VddId,
							NULL,
							
							NULL,							
							2,
							$CantidadPendienteReal,
							"G",
							3
							);
	
						
						}
						
						
					}
					

				}
			}
			
			
		
			
			

		break;
		
	}
	
}


?>