<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

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
	$InsVentaConcretada->VcoDescuento = eregi_replace(",","",(empty($_POST['CmpDescuento'])?0:$_POST['CmpDescuento']));
	$InsVentaConcretada->VcoManoObra = eregi_replace(",","",(empty($_POST['CmpManoObra'])?0:$_POST['CmpManoObra']));
	
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

	if(empty($InsVentaConcretada->AlmId)){
		$Guardar = false;
		$Resultado.='#ERR_VCO_112';
	}
	
	
	$ResVentaConcretadaDetalle = $_SESSION['InsVentaConcretadaDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

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


	if(!empty($ResVentaConcretadaDetalle['Datos'])){
		$item = 1;
		foreach($ResVentaConcretadaDetalle['Datos'] as $DatSesionObjeto){
				
				//deb($DatSesionObjeto);
				
				
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
					
			$InsVentaConcretadaDetalle1->VcdCantidadRealAnterior = $DatSesionObjeto->Parametro22;
			
			if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
				$InsVentaConcretadaDetalle1->VcdImporte = $DatSesionObjeto->Parametro6 * $InsVentaConcretada->VcoTipoCambio;
			}else{
				$InsVentaConcretadaDetalle1->VcdImporte = $DatSesionObjeto->Parametro6;
			}	

			$InsVentaConcretadaDetalle1->VcdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsVentaConcretadaDetalle1->VcdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			//$InsVentaConcretadaDetalle1->VcdCompraOrigen = $_POST['CmpVentaConcretadaDetalleCompraOrigen_'.$DatSesionObjeto->Item];
			$InsVentaConcretadaDetalle1->VcdCompraOrigen = NULL;
			$InsVentaConcretadaDetalle1->VcdEstado = $_POST['CmpVentaConcretadaDetalleEstado_'.$DatSesionObjeto->Item];
			
			$InsVentaConcretadaDetalle1->VcdValorTotal = 0;
			$InsVentaConcretadaDetalle1->VcdUtilidad = 0;
		
			$InsVentaConcretadaDetalle1->VcdEliminado = $DatSesionObjeto->Eliminado;				
			$InsVentaConcretadaDetalle1->InsMysql = NULL;

			$InsVentaConcretada->VentaConcretadaDetalle[] = $InsVentaConcretadaDetalle1;
				
			if($InsVentaConcretadaDetalle1->VcdEliminado==1){
				
//				if($InsProducto->ProStockReal < $InsVentaConcretadaDetalle1->VcdCantidadReal){
//					$InsVentaConcretadaDetalle1->VerificarStock = 1;
//				}
//				
//				if($InsVentaConcretadaDetalle1->VerificarStock == 1 and $InsVentaConcretada->VcoEstado <> 1 and $InsVentaConcretadaDetalle1->VcdEliminado==1){
//					$Guardar = false;
//					$Resultado.='#ERR_VCO_501';
//					$Resultado.='#Item Numero: '.($item);
//					
//				}

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

//	$InsVentaConcretada->VcoTotal = $InsVentaConcretada->VcoTotalBruto - $InsVentaConcretada->VcoDescuento;
//	$InsVentaConcretada->VcoSubTotal = $InsVentaConcretada->VcoTotal / (($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100)+1);
//	$InsVentaConcretada->VcoImpuesto = $InsVentaConcretada->VcoTotal - $InsVentaConcretada->VcoSubTotal;	

	if($InsVentaConcretada->VcoIncluyeImpuesto == 2){
		
		$InsVentaConcretada->VcoSubTotal = $InsVentaConcretada->VcoTotalBruto  + $InsVentaConcretada->VcoManoObra  - $InsVentaConcretada->VcoDescuento;
		$InsVentaConcretada->VcoImpuesto = ($InsVentaConcretada->VcoSubTotal  * ($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100) );
		$InsVentaConcretada->VcoTotal = $InsVentaConcretada->VcoSubTotal + $InsVentaConcretada->VcoImpuesto;
		
	}else{
		
		$InsVentaConcretada->VcoTotal = $InsVentaConcretada->VcoTotalBruto  + $InsVentaConcretada->VcoManoObra  - $InsVentaConcretada->VcoDescuento;
		$InsVentaConcretada->VcoSubTotal = $InsVentaConcretada->VcoTotal / (($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100)+1);
		$InsVentaConcretada->VcoImpuesto = $InsVentaConcretada->VcoTotal - $InsVentaConcretada->VcoSubTotal;
	
	}
	
	
	if($Guardar){
		
		if($InsVentaConcretada->MtdEditarVentaConcretada()){		
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_VCO_102';
		} else{
			$InsVentaConcretada->VcoFecha = FncCambiaFechaANormal($InsVentaConcretada->VcoFecha);
			$InsVentaConcretada->VcoEmpresaTransporteFecha = FncCambiaFechaANormal($InsVentaConcretada->VcoEmpresaTransporteFecha,true);
			
			if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
				$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento / $InsVentaConcretada->VcoTipoCambio,6);
			}
			
			if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
				$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra / $InsVentaConcretada->VcoTipoCambio,6);
			}
			
			$Resultado.='#ERR_VCO_102';
		}	
	}else{
		
		$InsVentaConcretada->VcoFecha = FncCambiaFechaANormal($InsVentaConcretada->VcoFecha);
		$InsVentaConcretada->VcoEmpresaTransporteFecha = FncCambiaFechaANormal($InsVentaConcretada->VcoEmpresaTransporteFecha,true);
		
		if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
			$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento / $InsVentaConcretada->VcoTipoCambio,6);
		}
		
		if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
			$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra / $InsVentaConcretada->VcoTipoCambio,6);
		}

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
//				Parametro23 = VcdCompraOrigen
//				Parametro24 = VcdEstado

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
				$DatVentaConcretadaDetalle->VcdCantidadReal,
				$DatVentaConcretadaDetalle->VcdCompraOrigen,
				$DatVentaConcretadaDetalle->VcdEstado
				);
				
				//deb($DatVentaConcretadaDetalle->VcdCompraOrigen);
				//deb($DatVentaConcretadaDetalle->VcdEstado);
		
		}
	}
	
}


?>