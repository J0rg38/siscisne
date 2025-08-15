<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsFactura->FacId = $_POST['CmpId'];
	$InsFactura->FtaId = $_POST['CmpTalonario'];
	$InsFactura->SucId = $_SESSION['SesionSucursal'];
	$InsFactura->CliId = $_POST['CmpClienteId'];

	$InsFactura->UsuId = $_SESSION['SesionId'];
	$InsFactura->UsuUsuario = $_SESSION['SesionUsuario'];

	if(!empty($_POST['CmpGuiaRemision'])){
		$InsFactura->GreId = $_POST['CmpGreId'];
		$InsFactura->GrtId = $_POST['CmpGrtId'];
		$InsFactura->GrtNumero = $_POST['CmpGrtNumero'];
	}

	$InsFactura->FacSIAFNumero = $_POST['CmpSIAFNumero'];
	$InsFactura->FacOrdenNumero = $_POST['CmpOrdenNumero'];
	$InsFactura->FacOrdenFecha = FncCambiaFechaAMysql($_POST['CmpOrdenFecha'],true);	
	$InsFactura->FacOrdenTipo = $_POST['CmpOrdenTipo'];
	$InsFactura->FacOrdenFoto = $_SESSION['SesFacOrdenFoto'.$Identificador];
	$InsFactura->NpaId = $_POST['CmpCondicionPago'];
	$InsFactura->FacCantidadDia = isset($_POST['CmpCantidadDia'])?$_POST['CmpCantidadDia']:0;
	
	$InsFactura->MonId = $_POST['CmpMonedaId'];
	$InsFactura->FacTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsFactura->MonId = $_POST['CmpMonedaId'];
	$InsFactura->FacTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsFactura->FacCancelado = $_POST['CmpCancelado'];
	$InsFactura->FacObsequio = $_POST['CmpObsequio'];
	$InsFactura->FacSpot = $_POST['CmpSpot'];
	
	$InsFactura->FacIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsFactura->FacConcepto = addslashes($_POST['CmpConcepto']);
	
	$InsFactura->FacAbono = preg_replace("/,/", "", (empty($_POST['CmpAbono'])?0:$_POST['CmpAbono']));
	
	
//	$InsFactura->FacTipo = $_POST['CmpTipo'];
	$InsFactura->FacTipo = 1;
	$InsFactura->FacObservado = $_POST['CmpObservado'];
	
	$InsFactura->FacEstado = $_POST['CmpEstado'];
	$InsFactura->FacPorcentajeImpuestoVenta = ($_POST['CmpPorcentajeImpuestoVenta']);
	$InsFactura->FacPorcentajeImpuestoSelectivo = ($_POST['CmpPorcentajeImpuestoSelectivo']);
			
	$InsFactura->FacFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	//$InsFactura->FacFechaVencimiento = FncCambiaFechaAMysql($_POST['CmpFechaVencimiento'],true);
	
	 $FechaVencimiento = NULL;
	 
	if($InsFactura->FacCantidadDia>0){
		// $FechaVencimiento = date("d/m/Y",strtotime($_POST['CmpFechaEmision']." + ".$InsFactura->FacCantidadDia." days"));
		$FechaVencimiento = strtotime('+'.$InsFactura->FacCantidadDia.' day', strtotime($InsFactura->FacFechaEmision));;
		$FechaVencimiento = date('d/m/Y', $FechaVencimiento);
	}
	
	$InsFactura->FacFechaVencimiento = FncCambiaFechaAMysql($FechaVencimiento,true);
	 
	
	$InsFactura->FacObservacion = addslashes($_POST['CmpObservacion'])."###".addslashes($_POST['CmpObservacionImpresa']);
	$InsFactura->FacObservacionCaja = addslashes($_POST['CmpObservacionCaja']);
	$InsFactura->FacLeyenda = addslashes($_POST['CmpLeyenda']);
	
	$InsFactura->FacCierre = 1;
	$InsFactura->FacUsuario =  $_SESSION['SesionUsuario'];
	$InsFactura->FacTiempoCreacion = date("Y-m-d H:i:s");
	$InsFactura->FacTiempoModificacion = date("Y-m-d H:i:s");
	$InsFactura->FacEliminado = 1;
	
	$InsFactura->CliNombre = $_POST['CmpClienteNombre'];
	$InsFactura->CliNombreCompleto = $_POST['CmpClienteNombre'];
	$InsFactura->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsFactura->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsFactura->TdoId = $_POST['CmpClienteTipoDocumento'];	
	$InsFactura->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsFactura->CliTelefono = $_POST['CmpClienteTelefono'];

	$InsFactura->CliEmail = $_POST['CmpClienteEmail'];
	$InsFactura->CliCelular = $_POST['CmpClienteCelular'];
	$InsFactura->CliFax = $_POST['CmpClienteFax'];

	$InsFactura->FacDireccion = $_POST['CmpClienteDireccion'];

	$InsFactura->FacNotificar = $_POST['CmpNotificar'];

	$InsFactura->FacRegimenComprobanteNumero = $_POST['CmpRegimenComprobanteNumero'];
	$InsFactura->FacRegimenComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpRegimenComprobanteFecha'],true);	
	$InsFactura->RegId = $_POST['CmpRegimenId'];	
	$InsFactura->RegAplicacion = $_POST['CmpRegimenAplicacion'];	
	$InsFactura->FacRegimenPorcentaje = $_POST['CmpRegimenPorcentaje'];
	$InsFactura->FacRegimenMonto = preg_replace("/,/", "", $_POST['CmpRegimenMonto']);

	$InsFactura->FacTotalDescuento = preg_replace("/,/", "", $_POST['CmpTotalDescuento']);

	if($InsFactura->MonId<>$EmpresaMonedaId and !empty($InsFactura->FacTipoCambio)){
		$InsFactura->FacRegimenMonto = $InsFactura->FacRegimenMonto * $InsFactura->FacTipoCambio;
		$InsFactura->FacTotalDescuento = $InsFactura->FacTotalDescuento * $InsFactura->FacTipoCambio;
	}	
		
	$InsFactura->FinId = $_POST['CmpFichaIngresoId'];
	$InsFactura->AmoId = $_POST['CmpAlmacenMovimientoSalidaIdAux'];

	$InsFactura->VdiId = $_POST['CmpVentaDirectaId'];
	
	$InsFactura->FccId = $_POST['CmpFichaAccionId'];
	$InsFactura->CprId = $_POST['CmpCotizacionProductoId'];
	
	$InsFactura->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	$InsFactura->CveId = $_POST['CmpCotizacionVehiculoId'];
	
	$InsFactura->PagId = $_POST['CmpPagoId'];
	
	$InsFactura->FacProcesar = $_POST['CmpProcesar'];
	$InsFactura->FacEnviarSUNAT = $_POST['CmpEnviarSUNAT'];

	$InsFactura->FacUsuario = $_POST['CmpUsuario'];
	$InsFactura->FacVendedor = $_POST['CmpVendedor'];
	$InsFactura->FacNumeroPedido = $_POST['CmpNumeroPedido'];
	
	$InsFactura->FacturaDetalle = array();
	
	if($InsFactura->MonId<>$EmpresaMonedaId){
		if(empty($InsFactura->FacTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_FAC_600';
		}
	}

	if(empty($InsFactura->CliId)){
		$Guardar = false;
		$Resultado.='#ERR_FAC_123';
	}	
		
	if(!empty($InsFactura->OvvId)){
		if(empty($InsFactura->CliEmail)){
			$Guardar = false;
			$Resultado.='#ERR_FAC_124';
		}
	}	
	

	
	$InsFactura->FacDatoAdicional1 = $_SESSION['InsFacturaDatoAdicional1'.$Identificador];
	$InsFactura->FacDatoAdicional2 = $_SESSION['InsFacturaDatoAdicional2'.$Identificador];
	$InsFactura->FacDatoAdicional3 = $_SESSION['InsFacturaDatoAdicional3'.$Identificador];
	$InsFactura->FacDatoAdicional4 = $_SESSION['InsFacturaDatoAdicional4'.$Identificador];
	$InsFactura->FacDatoAdicional5 = $_SESSION['InsFacturaDatoAdicional5'.$Identificador];
	$InsFactura->FacDatoAdicional6 = $_SESSION['InsFacturaDatoAdicional6'.$Identificador];
	$InsFactura->FacDatoAdicional7 = $_SESSION['InsFacturaDatoAdicional7'.$Identificador];
	$InsFactura->FacDatoAdicional8 = $_SESSION['InsFacturaDatoAdicional8'.$Identificador];
	$InsFactura->FacDatoAdicional9 = $_SESSION['InsFacturaDatoAdicional9'.$Identificador];
	$InsFactura->FacDatoAdicional10 = $_SESSION['InsFacturaDatoAdicional10'.$Identificador];
	$InsFactura->FacDatoAdicional11 = $_SESSION['InsFacturaDatoAdicional11'.$Identificador];
	$InsFactura->FacDatoAdicional12 = $_SESSION['InsFacturaDatoAdicional12'.$Identificador];
	$InsFactura->FacDatoAdicional13 = $_SESSION['InsFacturaDatoAdicional13'.$Identificador];
	$InsFactura->FacDatoAdicional14 = $_SESSION['InsFacturaDatoAdicional14'.$Identificador];
	$InsFactura->FacDatoAdicional15 = $_SESSION['InsFacturaDatoAdicional15'.$Identificador];
	$InsFactura->FacDatoAdicional16 = $_SESSION['InsFacturaDatoAdicional16'.$Identificador];
	$InsFactura->FacDatoAdicional17 = $_SESSION['InsFacturaDatoAdicional17'.$Identificador];
	$InsFactura->FacDatoAdicional18 = $_SESSION['InsFacturaDatoAdicional18'.$Identificador];
	$InsFactura->FacDatoAdicional19 = $_SESSION['InsFacturaDatoAdicional19'.$Identificador];
	$InsFactura->FacDatoAdicional20 = $_SESSION['InsFacturaDatoAdicional20'.$Identificador];
	$InsFactura->FacDatoAdicional21 = $_SESSION['InsFacturaDatoAdicional21'.$Identificador];
	$InsFactura->FacDatoAdicional22 = $_SESSION['InsFacturaDatoAdicional22'.$Identificador];
	$InsFactura->FacDatoAdicional23 = $_SESSION['InsFacturaDatoAdicional23'.$Identificador];
	$InsFactura->FacDatoAdicional24 = $_SESSION['InsFacturaDatoAdicional24'.$Identificador];
	$InsFactura->FacDatoAdicional25 = $_SESSION['InsFacturaDatoAdicional25'.$Identificador];
	$InsFactura->FacDatoAdicional26 = $_SESSION['InsFacturaDatoAdicional26'.$Identificador];
	$InsFactura->FacDatoAdicional27 = $_SESSION['InsFacturaDatoAdicional27'.$Identificador];
	$InsFactura->FacDatoAdicional28 = $_SESSION['InsFacturaDatoAdicional28'.$Identificador];
		
		
/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro3
Parametro4 = FdePrecio
Parametro5 = FdeCantidad
Parametro6 = FdeImporte
Parametro7 = FdeTiempoCreacion
Parametro8 = FdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FdeTipo
Parametro13 = FdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId
*/

	$InsFactura->FacTotalBruto = 0;
	$InsFactura->FacTotalGravado = 0;
	$InsFactura->FacTotalExonerado = 0;
	//$InsFactura->FacTotalDescuento = 0;
	$InsFactura->FacTotalGratuito = 0;
	$InsFactura->FacTotalDescuentoNoExonerado = 0;
	$InsFactura->FacTotalValorBruto = 0;
	$InsFactura->FacTotalPagar= 0;
	$InsFactura->FacTotalDescuento= 0;
	$InsFactura->FacTotalImpuestoSelectivo= 0;

	$InsFactura->FacSubTotal = 0;
	$InsFactura->FacImpuesto = 0;
	$InsFactura->FacTotal = 0;

	$ResFacturaDetalle = $_SESSION['InsFacturaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);//OJO

	if(!empty($ResFacturaDetalle['Datos'])){	
		foreach($ResFacturaDetalle['Datos'] as $DatSesionObjeto){
			
					
			if($InsFactura->MonId<>$EmpresaMonedaId){
			
				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsFactura->FacTipoCambio;
				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsFactura->FacTipoCambio;

				$DatSesionObjeto->Parametro19 = $DatSesionObjeto->Parametro19 * $InsFactura->FacTipoCambio;
				$DatSesionObjeto->Parametro20 = $DatSesionObjeto->Parametro20 * $InsFactura->FacTipoCambio;
				$DatSesionObjeto->Parametro21 = $DatSesionObjeto->Parametro21 * $InsFactura->FacTipoCambio;
				$DatSesionObjeto->Parametro25 = $DatSesionObjeto->Parametro25 * $InsFactura->FacTipoCambio;
				
			}
			
			$InsFacturaDetalle1 = new ClsFacturaDetalle();
			$InsFacturaDetalle1->FdeId = $DatSesionObjeto->Parametro1;	
			
			$InsFacturaDetalle1->AmdId = $DatSesionObjeto->Parametro15;
			$InsFacturaDetalle1->VmdId = $DatSesionObjeto->Parametro26;
			$InsFacturaDetalle1->FatId = $DatSesionObjeto->Parametro16;
			$InsFacturaDetalle1->FdeTipo = $DatSesionObjeto->Parametro12;
			
			//$InsFacturaDetalle1->FdeDescripcion = addslashes(utf8_encode(($DatSesionObjeto->Parametro2)));
			//if($InsFacturaDetalle1->FdeTipo<>"T"){
//				$InsFacturaDetalle1->FdeDescripcion = utf8_encode(htmlentities($DatSesionObjeto->Parametro2));	
//			}else{
//				$InsFacturaDetalle1->FdeDescripcion = addslashes(utf8_encode(($DatSesionObjeto->Parametro2)));
//			}

			if($InsFacturaDetalle1->FdeTipo<>"T"){
				$InsFacturaDetalle1->FdeDescripcion = (utf8_encode($DatSesionObjeto->Parametro2));	
			}else{
				$InsFacturaDetalle1->FdeDescripcion = (utf8_encode(($DatSesionObjeto->Parametro2)));
			}
			
			$InsFacturaDetalle1->FdePrecio = $DatSesionObjeto->Parametro4;
			$InsFacturaDetalle1->FdeCantidad = $DatSesionObjeto->Parametro5;
			$InsFacturaDetalle1->FdeImporte = $DatSesionObjeto->Parametro6;
			
			$InsFacturaDetalle1->FdeValorVenta = $DatSesionObjeto->Parametro19;
			$InsFacturaDetalle1->FdeImpuesto = $DatSesionObjeto->Parametro20;
			$InsFacturaDetalle1->FdeDescuento = $DatSesionObjeto->Parametro21;
			$InsFacturaDetalle1->FdeImpuestoSelectivo = $DatSesionObjeto->Parametro25;
			
			$InsFacturaDetalle1->FdeGratuito = $DatSesionObjeto->Parametro22;
			//$InsFacturaDetalle1->FdeGratuito = $InsFactura->FacObsequio;
			$InsFacturaDetalle1->FdeExonerado = $DatSesionObjeto->Parametro23;			
			$InsFacturaDetalle1->FdeIncluyeSelectivo = $DatSesionObjeto->Parametro24;

			$InsFacturaDetalle1->FdeCodigo = $DatSesionObjeto->Parametro18;
			$InsFacturaDetalle1->FdeUnidadMedida = $DatSesionObjeto->Parametro13;
			
			$InsFacturaDetalle1->FdeTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsFacturaDetalle1->FdeTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsFacturaDetalle1->FdeEliminado = $DatSesionObjeto->Eliminado;				
			$InsFacturaDetalle1->InsMysql = NULL;
			
			//$InsFactura->FacturaDetalle[] = $InsFacturaDetalle1;	
			
			if($InsFacturaDetalle1->FdeEliminado==1){		
				
			$InsFactura->FacTotalBruto += $InsFacturaDetalle1->FdeImporte;	
									
				//EXONERADO
				if($InsFacturaDetalle1->FdeExonerado == 1){						
					$InsFactura->FacTotalExonerado += $InsFacturaDetalle1->FdeValorVenta;
				}
				
				//GRAVADO
				if($InsFacturaDetalle1->FdeExonerado == 2 and $InsFacturaDetalle1->FdeGratuito == 2){			
					$InsFactura->FacTotalGravado += $InsFacturaDetalle1->FdeValorVenta;
				}
				
				//VALOR BRUTO
				if($InsFacturaDetalle1->FdeGratuito == 2){		
					$InsFactura->FacTotalValorBruto += $InsFacturaDetalle1->FdeValorVenta;
				}
				
				//GRATUITO
				if($InsFacturaDetalle1->FdeGratuito == 1){			
					$InsFactura->FacTotalGratuito += $InsFacturaDetalle1->FdeValorVenta;			
				}

				//INCLUYE SELECTIVO
				if($InsFacturaDetalle1->FdeIncluyeSelectivo == 1){			
					$InsFactura->FacTotalImpuestoSelectivo += ($InsFacturaDetalle1->FdeImpuestoSelectivo);
				}				

				//TOTAL PAGAR								
				if($InsFacturaDetalle1->FdeGratuito == 2){	
					if($InsFacturaDetalle1->FdeExonerado == 2){
						$InsFactura->FacTotalPagar += ( ($InsFacturaDetalle1->FdeValorVenta + $InsFacturaDetalle1->FdeImpuestoSelectivo) * ( ($InsFactura->FacPorcentajeImpuestoVenta/100)+1) ) * ( (100 - $InsFactura->FacPorcentajeDescuento)/100 ) ;
					}else{
						$InsFactura->FacTotalPagar += ($InsFacturaDetalle1->FdeValorVenta + $InsFacturaDetalle1->FdeImpuestoSelectivo) * ( (100 - $InsFactura->FacPorcentajeDescuento)/100 );	
					}
				}
				
				$InsFactura->FacTotalDescuento += $InsFacturaDetalle1->FdeDescuento;	//reemplazado 06-12-16
				
				$InsFactura->FacturaDetalle[] = $InsFacturaDetalle1;	
				
			}
		}	

	}
	
//SesionObjeto-FacturaAlmacenMovimiento
//Parametro1 = FamId
//Parametro2 = AmoId
//Parametro3 = 
//Parametro4 = 
//Parametro5 = FamEstado
//Parametro6 = FamTiempoCreacion
//Parametro7 = FamTiempoModificacion

//Parametro8 = FinId
//Parametro9 = FccId
//Parametro10 = AmoFecha
//Parametro11 = AmoSubTipo
//Parametro12 = VmvId
//Parametro13 = VmvFecha
//Parametro14 = VmvSubTipo

	$ResFacturaAlmacenMovimiento = $_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]->MtdObtenerSesionObjetos(true);//OJO

	if(!empty($ResFacturaAlmacenMovimiento['Datos'])){	
		foreach($ResFacturaAlmacenMovimiento['Datos'] as $DatSesionObjeto){
						
			$InsFacturaAlmacenMovimiento1 = new ClsFacturaAlmacenMovimiento();
			$InsFacturaAlmacenMovimiento1->FamId = $DatSesionObjeto->Parametro1;	
				
			$InsFacturaAlmacenMovimiento1->AmoId = $DatSesionObjeto->Parametro2;		
			$InsFacturaAlmacenMovimiento1->VmvId = $DatSesionObjeto->Parametro12;		

			$InsFacturaAlmacenMovimiento1->FamEstado = $DatSesionObjeto->Parametro5;
			$InsFacturaAlmacenMovimiento1->FamTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			$InsFacturaAlmacenMovimiento1->FamTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			
			$InsFacturaAlmacenMovimiento1->FamEliminado = $DatSesionObjeto->Eliminado;				
			//$InsFacturaAlmacenMovimiento1->InsMysql = NULL;
			
			$InsFactura->FacturaAlmacenMovimiento[] = $InsFacturaAlmacenMovimiento1;	
			
			
		}
	}
	
//	if($InsFactura->FacTipo == "2"){
//		$InsFactura->FacTotalBruto = preg_replace("/,/", "", $_POST['CmpTotal']);
//	}
	
	//if($InsFactura->FacPorcentajeDescuento>0){
//
//		$InsFactura->FacTotalExonerado = $InsFactura->FacTotalExonerado - ($InsFactura->FacTotalExonerado * ($InsFactura->FacPorcentajeDescuento/100));
//		$InsFactura->FacTotalGravado =  $InsFactura->FacTotalGravado - ($InsFactura->FacTotalGravado * ($InsFactura->FacPorcentajeDescuento/100));
//		$InsFactura->FacTotalDescuento = $InsFactura->FacTotalDescuento + ($InsFactura->FacTotalValorBruto * ($InsFactura->FacPorcentajeDescuento/100));
//
//	}
//
//	
//	$InsFactura->FacSubTotal = ($InsFactura->FacTotalGravado);
//	$InsFactura->FacImpuesto = ($InsFactura->FacSubTotal * ($InsFactura->FacPorcentajeImpuestoVenta/100));
//	$InsFactura->FacTotal = ($InsFactura->FacSubTotal + $InsFactura->FacImpuesto + $InsFactura->FacTotalExonerado);

	$InsFactura->FacSubTotal = ($InsFactura->FacTotalGravado);
	$InsFactura->FacImpuesto = (($InsFactura->FacSubTotal + $InsFactura->FacTotalImpuestoSelectivo ) * ($InsFactura->FacPorcentajeImpuestoVenta/100));
	$InsFactura->FacTotal = ($InsFactura->FacSubTotal+ $InsFactura->FacTotalImpuestoSelectivo +  $InsFactura->FacTotalExonerado + $InsFactura->FacImpuesto);

	if(!empty($InsFactura->RegId)){
		if($InsFactura->RegAplicacion==1){
			$InsFactura->FacTotalReal = $InsFactura->FacTotal - $InsFactura->FacRegimenMonto;
		}elseif($InsFactura->RegAplicacion == 2){
			$InsFactura->FacTotalReal = $InsFactura->FacTotal + $InsFactura->FacRegimenMonto;					
		}
	}else{
		$InsFactura->FacTotalReal = $InsFactura->FacTotal;
	}	
	
//	$InsFactura->FacLeyenda = $InsFactura->FacLeyenda.chr(13)." VALOR REFERENCIAL: ".$InsFactura->FacTotalGratuito;
	
//	if(!empty($InsFactura->AmoId)){
//		
//		$ArrFactura = $InsFactura->MtdVerificarExisteAlmacenMovimientoSalidaId($InsFactura->AmoId);		
//		
//		if(!empty($ArrFactura)){
//			$Guardar = false;
//			$Resultado .= "#ERR_FAC_604";	
//		}
//			
//	}
	
	if($Guardar){
		
		if($InsFactura->MtdRegistrarFactura()){	
			
			switch($GET_ori){

				case "FichaAccion":		


				$ResFacturaAlmacenMovimiento = $_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]->MtdObtenerSesionObjetos(true);//OJO
				
				if(!empty($ResFacturaAlmacenMovimiento['Datos'])){	
					foreach($ResFacturaAlmacenMovimiento['Datos'] as $DatSesionObjeto){
									
						if(!empty($DatSesionObjeto->Parametro8)){
							
							$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($DatSesionObjeto->Parametro8,9);
							$InsFichaAccion->MtdActualizarEstadoFichaAccion($DatSesionObjeto->Parametro9,3);
						}
					
					}
				}
				

				break;

			//	case "AlmacenMovimientoSalida":		
//
//					if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFactura->FinId,9)){
//						//$Resultado .= "#SAS_FCC_106";
//					}else{
//						//$Resultado .= "#ERR_FCC_106";
//					}
//
//				break;


			

				case "VentaConcretada":	

					$InsCotizacionProducto->MtdActualizarEstadoCotizacionProducto($InsFactura->CprId,5);

				break;
		
				case "OrdenVentaVehiculo":	

					

					if($InsFactura->FacEstado <> 6){
						
						
						$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
						$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($InsFactura->OvvId,5);
						$InsOrdenVentaVehiculo->OvvId = $InsBoleta->OvvId;
						$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
						
					//										
//												
//							if(!empty($InsOrdenVentaVehiculo->PerId)){
//								
//								$InsPersonal = new ClsPersonal();
//								$InsPersonal->PerId = $InsOrdenVentaVehiculo->PerId;
//								$InsPersonal->MtdObtenerPersonal();
//							
//							}
//							
//							$EmailPersonal = "";
//							$EmailPersonal = $CorreosNotificacionBienvenida.",";
//							
//							if(!empty($InsPersonal->PerEmail)){
//								
//								$EmailPersonal .= trim($InsPersonal->PerEmail).",";
//								
//							}	
//							
//							if(!empty($InsPersonal->PerEmailVendedor)){
//								
//								$EmailPersonal .= trim($InsPersonal->PerEmailVendedor).",";
//								
//							}
//								
//						//echo "EmailPersonal: ";
//						//echo $EmailPersonal;
//						//echo "<br>";
//						
//							//MtdEnviarBienvenidaOrdenVentaVehiculo($oOrdenVentaVehiculo,$oDestinatario,$oRemitente,$oAdjuntoBanner)
//							$InsOrdenVentaVehiculo->MtdEnviarBienvenidaOrdenVentaVehiculo($GET_OvvId,$EmailPersonal,$SistemaCorreoRemitente,$SistemaCorreoImagenBienvenida,false);
//							

						
						
					}
					
					//$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($InsFactura->OvvId,5);
//					
//					$InsOrdenVentaVehiculo->OvvId = $InsFactura->OvvId;
//					$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);
					
					//if(!empty($InsOrdenVentaVehiculo->EinId)){
//
//						$InsVehiculoIngreso = new ClsVehiculoIngreso();
//						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","VENDIDO",$InsOrdenVentaVehiculo->EinId);
//
//					}
					
				break;
					
					case "VehiculoMovimientoSalida":
					
					
	
						if($InsFactura->FacEstado <> 6){
							
							
							$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
							$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($InsFactura->OvvId,5);
							$InsOrdenVentaVehiculo->OvvId = $InsFactura->OvvId;
							$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
									
								if(!empty($InsOrdenVentaVehiculo->PerId)){
									
									$InsPersonal = new ClsPersonal();
									$InsPersonal->PerId = $InsOrdenVentaVehiculo->PerId;
									$InsPersonal->MtdObtenerPersonal();
								
								}
								
								$EmailPersonal = "";
								$EmailPersonal = $CorreosNotificacionBienvenida.",";
								
								if(!empty($InsPersonal->PerEmail)){
									
									$EmailPersonal .= trim($InsPersonal->PerEmail).",";
									
								}	
								
								if(!empty($InsOrdenVentaVehiculo->CliEmail)){
								
									$EmailPersonal .= trim($InsOrdenVentaVehiculo->CliEmail).",";
									
								}
									
							//echo "EmailPersonal: ";
							//echo $EmailPersonal;
							//echo "<br>";
							
								//MtdEnviarBienvenidaOrdenVentaVehiculo($oOrdenVentaVehiculo,$oDestinatario,$oRemitente,$oAdjuntoBanner)
								$InsOrdenVentaVehiculo->MtdEnviarBienvenidaOrdenVentaVehiculo($InsFactura->OvvId,$EmailPersonal,$SistemaCorreoRemitente,$SistemaCorreoImagenBienvenida,false);
								
	
							
							
						}
						
						
					break;	
					
					case "Pago":
					
					if($InsFactura->FacEstado <> 6){
						
						$InsPago = new ClsPago();
						$InsPago->MtdActualizarEstadoPago($InsFactura->PagId,3);
						
					}
					
				break;	
				
				
				
			}
	
	
	


				if(!empty($InsFactura->FacAbono) and $InsFactura->FacAbono <> "0.00" and $InsFactura->NpaId == "NPA-10000"){
					
//					$Guardar = true;
//					$InsPago = new ClsPago();
//				
//					$InsPago->PagId = NULL;
//					$InsPago->PagFecha = date("Y-m-d");
//					$InsPago->CliId = $InsFactura->CliId;
//					$InsPago->AreId = "ARE-10000";
//					$InsPago->FacId = $InsFactura->FacId;
//					$InsPago->FtaId = $InsFactura->FtaId;
//					
//					$InsPago->NpaId = "NPA-10000";
//					$InsPago->FpaId = "FPA-10000";
//					
//					$InsPago->MonId = $InsFactura->MonId;
//					$InsPago->PagTipoCambio = $InsFactura->FacTipoCambio;
//					$InsPago->PagMonto = preg_replace("/,/", "", (empty($InsFactura->FacAbono)?0:$InsFactura->FacAbono));
//
//					$InsPago->PagObservacion = date("d/m/Y H:i:s")." - Abono Generada de Factura: ".$InsFactura->FtaNumero."-".$InsFactura->FacId;
//					$InsPago->PagObservacion .= $InsVentaDirecta->VdiObservacion;;
//
//					$InsPago->PagConcepto = "Abono de Factura ".$InsFactura->FtaNumero."-".$InsFactura->FacId;
//
//					$InsPago->PagUtilizado = 1;	
//					$InsPago->PagTipo = "FAC";		
//					$InsPago->PagEstado = 3;		
//					$InsPago->PagTiempoCreacion = date("Y-m-d H:i:s");
//					$InsPago->PagTiempoModificacion = date("Y-m-d H:i:s");
//					$InsPago->PagEliminado = 1;
//					
//					$InsPago->PagoComprobante = array();
//				
//					if($InsPago->MonId<>$EmpresaMonedaId){
//						if(empty($InsPago->PagTipoCambio)){
//							$Guardar = false;
//							$Resultado.='#ERR_FAC_901';
//						}
//					}
//				
//					if($InsPago->MonId<>$EmpresaMonedaId ){
//						$InsPago->PagMonto = round($InsPago->PagMonto * $InsPago->PagTipoCambio,6);
//					}
//					
//					$InsPagoComprobante1 = new ClsPagoComprobante();
//					$InsPagoComprobante1->PacId = NULL;
//					$InsPagoComprobante1->FacId = $InsFactura->FacId;
//					$InsPagoComprobante1->FtaId = $InsFactura->FtaId;
//					$InsPagoComprobante1->PacEstado = 1;
//					$InsPagoComprobante1->PacTiempoCreacion = date("Y-m-d H:i:s");
//					$InsPagoComprobante1->PacTiempoModificacion = date("Y-m-d H:i:s");
//					$InsPagoComprobante1->PacEliminado = 1;
//					
//					$InsPago->PagoComprobante[] = $InsPagoComprobante1;
//
//					if($Guardar){
//						
//						if(!$InsPago->MtdRegistrarPago()){
//							$Resultado.='#ERR_FAC_900';
//						}
//						
//					}
//					
				}
				
				
			if($InsFactura->FacNotificar=="1"){
				$InsFactura->MtdNotificarFacturaRegistro($InsFactura->FacId,$InsFactura->FtaId,$CorreosNotificacionFacturaRegistro);
			}
			
			$InsFacturaTalonario = new ClsFacturaTalonario();
			$InsFacturaTalonario->FtaId = $InsFactura->FtaId;
			$InsFacturaTalonario->MtdObtenerFacturaTalonario();		
			
			if(substr($InsFacturaTalonario->FtaNumero,0,1)=="F"){
				
				if($InsFactura->FacProcesar=="1"){
		?>
			  <script type="text/javascript">
                    $().ready(function() {
                    /*
                    Configuracion carga de datos y animacion
                    */			
                   		FncFacturaGenerarXMLv2('<?php echo $InsFactura->FacId;?>','<?php echo $InsFactura->FtaId;?>','',1,1);		
                    });
                </script>
        <?php			
			}
			
	
			}
				
			$Registro = true;		
			$Resultado.='#SAS_FAC_101';
		} else{
			$Resultado.='#ERR_FAC_101';
		}		
		
	}
	
	$InsFactura->FacFechaEmision = FncCambiaFechaANormal($InsFactura->FacFechaEmision);
	$InsFactura->FacOrdenFecha = FncCambiaFechaANormal($InsFactura->FacOrdenFecha,true);
	$InsFactura->FacFechaVencimiento = FncCambiaFechaANormal($InsFactura->FacFechaVencimiento,true);
	
	list($InsFactura->FacObservacion,$InsFactura->FacObservacionImpresa) = explode("###",$InsFactura->FacObservacion);
	
	if($InsFactura->MonId<>$EmpresaMonedaId and !empty($InsFactura->FacTipoCambio)){
		$InsFactura->FacRegimenMonto = round($InsFactura->FacRegimenMonto / $InsFactura->FacTipoCambio,2);
	}
	
}else{

	unset($_SESSION['InsFacturaDetalle'.$Identificador]);
	unset($_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]);	
	
	$_SESSION['InsFacturaDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFacturaAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();
	
	for($i=1;$i<=25;$i++){
		
		unset($_SESSION['InsFacturaDatoAdicional'.$i.$Identificador]);	
	}

	$InsFactura->FacFechaEmision = date("d/m/Y");	
	$InsFactura->TdoId = "TDO-10000";
	$InsFactura->MonId = $EmpresaMonedaId;
	$InsFactura->NpaId = "NPA-10000";
	$InsFactura->FacCancelado = 2;
	$InsFactura->FacObservado = 2;
	
	$InsFactura->FacObsequio = 2;
	$InsFactura->FacSpot = 2;
	//deb($InsFactura->FacSpot);
	$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsFactura->FacPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
	$InsFactura->FacIncluyeImpuesto = 1;
	$InsFactura->FacTipo = 1;
	//$InsFactura->FacNotificar = 0;
	$InsFactura->FacAbono = 0;

	$InsFactura->FacNotificar = 0;
	$InsFactura->FacProcesar = 1;
	$InsFactura->FacEnviarSUNAT = 0;
	$InsFactura->SucId = $_SESSION['SesionSucursal'];
	$InsFactura->FacUsuario =  $_SESSION['SesionUsuario'];
	
//deb($GET_ori);
	switch($GET_ori){

		case "FichaAccion":
			
			if(!empty($GET_FccId) or !empty($POST_Seleccionados) ){
				FncCargarFichaAccionDatos();		
			}

		break;

		/*
		scase "AlmacenMovimientoSalida":		

			if(!empty($GET_AmoId)){
				FncCargarTallerPedidoDatos();				
			}

		break;
		*/

		case "VentaConcretada":		
			
			if(!empty($GET_VcoId) or !empty($POST_Seleccionados)){
				FncCargarVentaConcretadaDatos();
			}

		break;
		
		/*case "OrdenVentaVehiculo":

			if(!empty($GET_OvvId)){
				FncCargarOrdenVentaVehiculoDatos();
			}

		break;*/
		
		case "VehiculoMovimientoSalida":
			
//			deb($GET_VmvId);
			
			if(!empty($GET_VmvId)){
				FncCargarVehiculoMovimientoSalidaDatos();
			}

		break;
		
		case "Pago":
			
			if(!empty($GET_PagId)){
				FncCargarPago();
			}
			
			
		break;

	}

}


function FncCargarFichaAccionDatos(){

	global $GET_FccId;
	global $GET_AmoId;
	global $Identificador;
	global $InsFichaAccion;
	global $InsTallerPedido;
	global $InsFactura;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;
	global $EmpresaImpuestoSelectivo;
	global $POST_Seleccionados;

	if(!empty($GET_FccId)){
	
		$InsFichaAccion = new ClsFichaAccion();
		$InsFichaAccion->FccId = $GET_FccId;
		$InsFichaAccion->MtdObtenerFichaAccion();
			
		$InsFichaIngreso = new ClsFichaIngreso();
		$InsFichaIngreso->FinId = $InsFichaAccion->FinId;
		$InsFichaIngreso->MtdObtenerFichaIngreso();
		
		//OBTENIENDO FICHAS
		$InsTallerPedido = new ClsTallerPedido();
		$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoTiempoCreacion','DESC','',NULL,NULL,NULL,$InsFichaAccion->FccId,NULL,0,0,NULL,NULL,false,NULL);
		$ArrTallerPedidos = $ResTallerPedido['Datos'];
		
		//OBTENIENDO TOTAL DESCUENTO
		$MonedaId = "";
		$TipoCambio = NULL;
		$IncluyeImpuesto = NULL;
		$Observacion = NULL;
		$TallerPedidoId = "";
		$TienePromocion = false;
		
		$TotalDescuento = 0;
		$TotalBruto = 0;
		
		if(!empty($ArrTallerPedidos)){	
			foreach($ArrTallerPedidos as $DatTallerPedido){

				$MonedaId = $DatTallerPedido->MonId;
				$TipoCambio = $DatTallerPedido->AmoTipoCambio;
				$IncluyeImpuesto = $DatTallerPedido->AmoIncluyeImpuesto;
				$Observacion .= $DatTallerPedido->AmoObservacion;
				$TallerPedidoId = $DatTallerPedido->AmoId;
				
				if($DatTallerPedido->MonId<>$EmpresaMonedaId ){
					$DatTallerPedido->AmoDescuento  = ($DatTallerPedido->AmoDescuento  / $DatTallerPedido->AmoTipoCambio);
					$DatTallerPedido->AmoTotal  = ($DatTallerPedido->AmoTotal  / $DatTallerPedido->AmoTipoCambio);
				}
				
				if($DatTallerPedido->AmoIncluyeImpuesto == 2){
					$DatTallerPedido->AmoDescuento = ($DatTallerPedido->AmoDescuento * (($EmpresaImpuestoVenta/100)+1));
				}
				
				$TotalDescuento += $DatTallerPedido->AmoDescuento;
				$TotalBruto += $DatTallerPedido->AmoTotal;				
						
				if($DatTallerPedidoDetalle->ProTienePromocion=="1"){
					$TienePromocion = true;
				}
								
			}
		}
		
				$TotalBruto += $InsFichaAccion->FccManoObra;	
		
		
		$PorcentajeDescuento = (((100*$TotalDescuento)/$TotalBruto));
		
		//deb($TotalDescuento);
			//deb($TotalBruto);
				//deb($PorcentajeDescuento);
		
		//DATOS FACTURA
		$InsFactura->MonId = $MonedaId;
		$InsFactura->FacTipoCambio = $TipoCambio;
		
		$InsFactura->AmoId = $TallerPedidoId;
		$InsFactura->FccId = $InsFichaAccion->FccId;
		$InsFactura->FinId = $InsFichaIngreso->FinId;
		
		$InsFactura->CliId = $InsFichaIngreso->CliId;		
		$InsFactura->CliNombre = $InsFichaIngreso->CliNombre;
		$InsFactura->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
		$InsFactura->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
		
		$InsFactura->TdoId = $InsFichaIngreso->TdoId;
		$InsFactura->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
		$InsFactura->FacDireccion = $InsFichaIngreso->CliDireccion." - ".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliDepartamento;
		$InsFactura->FacTelefono = $InsFichaIngreso->FinTelefono;		
		$InsFactura->FacObsequio = $InsFichaAccion->FimObsequio;
		
		$InsFactura->FacIncluyeImpuesto = $IncluyeImpuesto;
		$InsFactura->FacEstado = 5;
		$InsFactura->FacObservacion = $Observacion.chr(13).date("d/m/Y H:i:s")." - Factura autogenerada de Mov. Alm.:".$InsFactura->AmoId." / O.T.:".$InsFactura->FinId;
		
		if($InsFactura->FacObsequio == 1){
			$InsFactura->FacLeyenda .= chr(13)."ENTREGA A TITULO GRATUITO. VALOR REFERENCIAL";			
		}
		
		if($TienePromocion){
			$InsFactura->FacObservacionImpresa .= chr(13)."(*) Productos en oferta con precio especial disponibles hasta agotar stock";
		}
			
		$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
		$InsFactura->FacPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
		
		$InsFactura->FacPorcentajeDescuento = $PorcentajeDescuento;
		
		$InsFactura->FacVendedor = $InsFichaIngreso->UsuUsuario;	
		$InsFactura->FacNumeroPedido = $InsFichaIngreso->FinId;	
				
				
				
		//if($InsFactura->MonId<>$EmpresaMonedaId ){
		//	$TotalDescuento = round($TotalDescuento / $InsFactura->FacTipoCambio,2);
		//}
		
		//$InsFactura->FacTotalDescuento = $TotalDescuento;
		
		//ITEMS	
		if(!empty($ArrTallerPedidos)){	
			foreach($ArrTallerPedidos as $DatTallerPedido){

				$InsTallerPedido->AmoId = $DatTallerPedido->AmoId; 
				$InsTallerPedido->MtdObtenerTallerPedido();	
				
				$MonedaId = $InsTallerPedido->MonId;
				$TipoCambio = $InsTallerPedido->AmoTipoCambio;
				$IncluyeImpuesto = $InsTallerPedido->AmoIncluyeImpuesto;
				$Observacion .= $InsTallerPedido->AmoObservacion;
				$TallerPedidoId = $InsTallerPedido->AmoId;
			
					//if($InsFichaAccion->MinSigla == "MA"){
				
							//$TotalValorVenta = 0;
//							$TotalPrecioVenta = 0;
//							$TotalImporte = 0;
//							$TotalImpuesto = 0;
//							$TotalDescuento = 0;
//	
//							$Repuestos = "";
//									
//							if(!empty($InsTallerPedido->TallerPedidoDetalle)){
//								foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
//									
//									$GuardarDetalle = false;
//									
//									if($DatTallerPedidoDetalle->AmdCantidadPendienteFacturar>0){
//										$GuardarDetalle = true;
//									}
//						
//									if($DatTallerPedidoDetalle->AmdEstado == 1){
//										$GuardarDetalle = false;
//									}
//																		
//									if($GuardarDetalle){
//										
//										$reingreso = strpos($DatTallerPedidoDetalle->ProCodigoOriginal, "-R");
//										$Cantidad = $DatTallerPedidoDetalle->AmdCantidadPendienteFacturar;
//										
//										$PrecioVenta = $DatTallerPedidoDetalle->AmdPrecioVenta;
//										$Importe = $DatTallerPedidoDetalle->AmdImporte;
//										$ValorVenta = 0;
//										$Impuesto = 0;
//									
//										if($InsFactura->MonId<>$EmpresaMonedaId ){
//											$PrecioVenta = ($PrecioVenta / $InsFactura->FacTipoCambio);
//											$Importe = ($Importe / $InsFactura->FacTipoCambio);
//										}
//		
//										if($InsTallerPedido->AmoIncluyeImpuesto == 2){
//											$PrecioVenta = $PrecioVenta * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
//											$Importe = $Importe * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
//										}
//										
//										$Impuesto = ($Importe / (($InsFactura->FacPorcentajeImpuestoVenta/100)+1));
//										$Impuesto = $Importe - $Impuesto;
//										
//										$ValorVenta = $Importe/((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
//	
//										$Descuento = 0;
//									
//										if($InsTallerPedido->AmoDescuento>0){
//											$Descuento = ($InsFactura->FacPorcentajeDescuento/100) * $ValorVenta;
//										}
//	
//										$ValorVenta = $ValorVenta - $Descuento;
//											
//										$TotalValorVenta += $ValorVenta;
//										$TotalPrecioVenta += $PrecioVenta;
//										$TotalImporte += $Importe;
//										$TotalImpuesto += $Impuesto;
//										$TotalDescuento += $Descuento;
//										
//										if($DatTallerPedidoDetalle->RtiId == "RTI-10003"){
//		
//											$Repuestos .= " | ".number_format($DatTallerPedidoDetalle->AmdCantidad,2)." ".$DatTallerPedidoDetalle->UmeNombre." ".$DatTallerPedidoDetalle->ProNombre." [S]";			
//										
//										}elseif($DatTallerPedidoDetalle->RtiId == "RTI-10010" or $reingreso !== false){
//											
//											$Repuestos .= " | ".number_format($DatTallerPedidoDetalle->AmdCantidad,2)." ".$DatTallerPedidoDetalle->UmeNombre." ".$DatTallerPedidoDetalle->ProNombre." [S]";			
//										
//										}else{
//											
//											$Repuestos .= " | ".number_format($DatTallerPedidoDetalle->AmdCantidad,2)." ".$DatTallerPedidoDetalle->UmeNombre." ".$DatTallerPedidoDetalle->ProNombre." ".($DatTallerPedidoDetalle->AmdReingreso=="1"?'[R]':'')." ".($DatTallerPedidoDetalle->ProTienePromocion=="1"?'[*]':'');
//											
//										}
//										
//									
//									}
//			
//			
//								}		
//							}
//							
//						
//
///*
//SesionObjeto-FacturaDetalleListado
//Parametro1 = FdeId
//Parametro2 = FdeDescripcion
//Parametro3
//Parametro4 = FdePrecio
//Parametro5 = FdeCantidad
//Parametro6 = FdeImporte
//Parametro7 = FdeTiempoCreacion
//Parametro8 = FdeTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 =
//Parametro12 = FdeTipo
//Parametro13 = FdeUnidadMedida
//Parametro14 = VcdReingreso
//
//Parametro15 = AmdId
//Parametro16 = FatId
//Parametro17 = OvvId
//
//Parametro18 = FdeCodigo
//Parametro19 = FdeValorVenta
//Parametro20 = FdeImpuesto
//Parametro21 = FdeDescuento
//Parametro22 = FdeGratuito
//Parametro23 = FdeExonerado
//
//Parametro24 = FdeIncluyeSelectivo
//Parametro25 = FdeImpuestoSelectivo
//*/							
//							$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//							NULL,
//							"KIT DE MANTENIMIENTO ".$InsFichaAccion->VmaNombre." ".$InsFichaAccion->VmoNombre." ".$InsFichaAccion->FinMantenimientoKilometraje." KM".$Repuestos,
//							NULL,
//							$TotalImporte,
//							1,
//							$TotalImporte,				
//							
//							date("d/m/Y H:i:s"),
//							date("d/m/Y H:i:s"),
//							NULL,//EX AMDID
//							$DatTallerPedidoDetalle->AmoId,
//							NULL,
//							"T",
//							NULL,//UmeNombre
//							NULL,//AmdReingreso
//							NULL,//AmdId
//							NULL,
//							NULL,
//							"",//ProCodigoOriginal
//							$TotalValorVenta,
//							$TotalImpuesto,
//							$TotalDescuento,
//							(($InsFactura->FacObsequio=="1")?1:2),
//							2,
//							
//							2,
//							0,
//							
//							""
//							);	
								
					//}else{

						if(!empty($InsTallerPedido->TallerPedidoDetalle)){
							foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
								
							
								$GuardarDetalle = false;
								
							
								
								if($DatTallerPedidoDetalle->AmdCantidadPendienteFacturar>0){	
									$GuardarDetalle = true;
								}
								
								if($DatTallerPedidoDetalle->ProTienePromocion=="1"){
									$TienePromocion = true;
								}
								
								if($DatTallerPedidoDetalle->AmdEstado == 1){	
												$GuardarDetalle = false;
											}
									
							//	$GuardarDetalle = true;
							//	$DatTallerPedidoDetalle->AmdCantidadPendienteFacturar = $DatTallerPedidoDetalle->AmdCantidad;
								
								if($GuardarDetalle){
																	
									$reingreso = strpos($DatTallerPedidoDetalle->ProCodigoOriginal, "-R");
									
									$Cantidad = $DatTallerPedidoDetalle->AmdCantidadPendienteFacturar;
									$PrecioVenta = $DatTallerPedidoDetalle->AmdPrecioVenta;

									// AGREGADO POR JORGITO



									$Importe = $DatTallerPedidoDetalle->AmdImporte;
									$ValorVenta = 0;
									$Impuesto = 0;
									
									if($InsFactura->MonId<>$EmpresaMonedaId ){
										$PrecioVenta = ($PrecioVenta / $InsFactura->FacTipoCambio);
										$Importe = ($Importe / $InsFactura->FacTipoCambio);
									}
	
									if($InsTallerPedido->AmoIncluyeImpuesto == 2){
										$PrecioVenta = $PrecioVenta * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
										$Importe = $Importe * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
									}
									
									$Impuesto = ($Importe / (($InsFactura->FacPorcentajeImpuestoVenta/100)+1));
									$Impuesto = $Importe - $Impuesto;
									
									$ValorVenta = $Importe/((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);

									$Descuento = 0;
								
									if($InsTallerPedido->AmoDescuento>0){
										$Descuento = ($InsFactura->FacPorcentajeDescuento/100) * $Importe;
									}

									// $ValorVenta = $ValorVenta - $Descuento;
								
									
									/*
										SesionObjeto-FacturaDetalleListado
										Parametro1 = FdeId
										Parametro2 = FdeDescripcion
										Parametro3
										Parametro4 = FdePrecio
										Parametro5 = FdeCantidad
										Parametro6 = FdeImporte
										Parametro7 = FdeTiempoCreacion
										Parametro8 = FdeTiempoModificacion
										Parametro9 = AmdId
										Parametro10 = AmoId
										Parametro11 =
										Parametro12 = FdeTipo
										Parametro13 = FdeUnidadMedida
										Parametro14 = VcdReingreso
										
										Parametro15 = AmdId
										Parametro16 = FatId
										Parametro17 = OvvId
										
										Parametro18 = FdeCodigo
										Parametro19 = FdeValorVenta
										Parametro20 = FdeImpuesto
										Parametro21 = FdeDescuento
										Parametro22 = FdeGratuito
										Parametro23 = FdeExonerado	
										*/
										
									if($DatTallerPedidoDetalle->RtiId == "RTI-10003"){
							
										$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
										NULL,
										$DatTallerPedidoDetalle->ProNombre." [S]",
										NULL,
										
										$PrecioVenta,
										$Cantidad,
										$Importe,					
										date("d/m/Y H:i:s"),
										date("d/m/Y H:i:s"),
										$DatTallerPedidoDetalle->AmdId,
										$DatTallerPedidoDetalle->AmoId,
										NULL,
										"T",
										$DatTallerPedidoDetalle->UmeAbreviacion,									
										$DatTallerPedidoDetalle->AmdReingreso,	
																		
										$DatTallerPedidoDetalle->AmdId,
										NULL,
										NULL,

										$DatTallerPedidoDetalle->ProCodigoOriginal,
										$ValorVenta,
										$Impuesto,//antes rea AmdDescuento
										$Descuento,
										(($InsFactura->FacObsequio=="1")?1:2),
										2,
										
										2,
										0,
										
										$DatTallerPedidoDetalle->AmdCompraOrigen
										);
						
									}elseif($DatTallerPedidoDetalle->RtiId == "RTI-10010" or $reingreso !== false){
										
										$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
										NULL,
										$DatTallerPedidoDetalle->ProNombre." [S]",
										NULL,
										$PrecioVenta,
										$Cantidad,
										$Importe,	
										date("d/m/Y H:i:s"),
										date("d/m/Y H:i:s"),
										$DatTallerPedidoDetalle->AmdId,
										$DatTallerPedidoDetalle->AmoId,
										NULL,
										"T",
										$DatTallerPedidoDetalle->UmeAbreviacion,									
										$DatTallerPedidoDetalle->AmdReingreso,	
																		
										$DatTallerPedidoDetalle->AmdId,
										NULL,
										NULL,
										
										$DatTallerPedidoDetalle->ProCodigoOriginal,
										$ValorVenta,
										$Impuesto,
										$Descuento,
										(($InsFactura->FacObsequio=="1")?1:2),
										2,
										
										2,
										0,
										
										$DatTallerPedidoDetalle->AmdCompraOrigen
										);	

									}else{										
										
										$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
										NULL,
										$DatTallerPedidoDetalle->ProNombre." ".$DatTallerPedidoDetalle->ProCodigoOriginal." ".($DatTallerPedidoDetalle->AmdReingreso=="1"?'[R]':'')." ".($DatTallerPedidoDetalle->ProTienePromocion=="1"?'[*]':''),
										NULL,
										$PrecioVenta,
										$Cantidad,
										$Importe,	
										date("d/m/Y H:i:s"),
										date("d/m/Y H:i:s"),
										$DatTallerPedidoDetalle->AmdId,
										$DatTallerPedidoDetalle->AmoId,
										NULL,
										"R",
										$DatTallerPedidoDetalle->UmeAbreviacion,									
										$DatTallerPedidoDetalle->AmdReingreso,	
																		
										$DatTallerPedidoDetalle->AmdId,
										NULL,
										NULL,
										
										$DatTallerPedidoDetalle->ProCodigoOriginal,
										$ValorVenta,
										$Impuesto,
										$Descuento,
										(($InsFactura->FacObsequio=="1")?1:2),
										2,
										
										2,
										0,
										
										$DatTallerPedidoDetalle->AmdCompraOrigen
										);	
						
									}
								
								}
					
							}
						}								
							
				//	}
			
			
					if(!empty($InsTallerPedido->AmoDescuento) and $InsTallerPedido->AmoDescuento <> "0.00"){
						
					}
				
					if(!empty($InsTallerPedido->AmoId)){
				
						$_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						$InsTallerPedido->AmoId,
						NULL,
						NULL,
						1,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s"),
						$InsTallerPedido->FinId,
						$InsTallerPedido->FccId,
						$InsTallerPedido->AmoFecha,
						$InsTallerPedido->AmoSubTipo
						);
						
					}
				
			}				
		}
		
			
		//TAREAS
		if(!empty($InsFichaAccion->FichaAccionTarea)){
			foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){



/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro3
Parametro4 = FdePrecio
Parametro5 = FdeCantidad
Parametro6 = FdeImporte
Parametro7 = FdeTiempoCreacion
Parametro8 = FdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FdeTipo
Parametro13 = FdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = FdeCodigo
Parametro19 = FdeValorVenta
Parametro20 = FdeImpuesto
Parametro21 = FdeDescuento
Parametro22 = FdeGratuito
Parametro23 = FdeExonerado

Parametro24 = FdeIncluyeSelectivo
Parametro25 = FdeImpuestoSelectivo
*/	
				if(!empty($DatFichaAccionTarea->FatCosto) and $DatFichaAccionTarea->FatCosto <> "0.00"){
					
					$Cantidad = 1;
					
					if($InsFactura->MonId<>$EmpresaMonedaId ){
						$DatFichaAccionTarea->FatCosto = round($DatFichaAccionTarea->FatCosto  / $InsFactura->FacTipoCambio,2);
					}

					if($IncluyeImpuesto == 2){
						$DatFichaAccionTarea->FatCosto = $DatFichaAccionTarea->FatCosto + ($DatFichaAccionTarea->FatCosto * ($InsFactura->FacPorcentajeImpuestoVenta/100));
					}

					$PrecioVenta = $DatFichaAccionTarea->FatCosto;
					$Importe = round($PrecioVenta * $Cantidad,2);
					
					$DatFichaAccionTarea->FatValorVenta = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
					$DatFichaAccionTarea->FatImpuesto = $Importe - $DatFichaAccionTarea->FatValorVenta;

					$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatFichaAccionTarea->FatDescripcion,
					NULL,
					$PrecioVenta,
					$Cantidad ,
					$Importe,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					0,
					0,
					NULL,
					"S",
					"UND",								
					NULL,
												
					NULL,
					$DatFichaAccionTarea->FatId,
					NULL,
						
					"",
					$DatFichaAccionTarea->FatValorVenta,
					$DatFichaAccionTarea->FatImpuesto,
					0,
					(($InsFactura->FacObsequio=="1")?1:2),
					2,
					
					2,
					0,
					
					""
					);	

					//$InsFactura->FacObsequio
				}
				
			}
		}
					
		//MANO DE OBRA
	//	if(!empty($InsFichaAccion->FccManoObra) and $InsFichaAccion->FccManoObra <> "0.00" ){
//			 
//
///*
//SesionObjeto-FacturaDetalleListado
//Parametro1 = FdeId
//Parametro2 = FdeDescripcion
//Parametro3
//Parametro4 = FdePrecio
//Parametro5 = FdeCantidad
//Parametro6 = FdeImporte
//Parametro7 = FdeTiempoCreacion
//Parametro8 = FdeTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 =
//Parametro12 = FdeTipo
//Parametro13 = FdeUnidadMedida
//Parametro14 = VcdReingreso
//
//Parametro15 = AmdId
//Parametro16 = FatId
//Parametro17 = OvvId
//
//Parametro18 = FdeCodigo
//Parametro19 = FdeValorVenta
//Parametro20 = FdeImpuesto
//Parametro21 = FdeDescuento
//Parametro22 = FdeGratuito
//Parametro23 = FdeExonerado
//
//Parametro24 = FdeIncluyeSelectivo
//Parametro25 = FdeImpuestoSelectivo
//*/	
//		  
//			  $manoobra = '';
//			  $Cantidad = 1;
//			  
//			  if(!empty($InsFichaAccion->FccManoObraDetalle)){
//				  $manoobra = $InsFichaAccion->FccManoObraDetalle;	
//			  }else{
//				  $manoobra = 'MANO DE OBRA';
//			  }
//			  
//			  if($InsFactura->MonId<>$EmpresaMonedaId ){
//				  $InsFichaAccion->FccManoObra = round($InsFichaAccion->FccManoObra  / $InsFactura->FacTipoCambio,2);
//			  }
//			  
//			  if($InsTallerPedido->AmoIncluyeImpuesto == 2){		
//				  $InsFichaAccion->FccManoObra = round($InsFichaAccion->FccManoObra  / $InsFactura->FacTipoCambio,2);
//			  }
//			  
//			  $PrecioVenta = $InsFichaAccion->FccManoObra;
//			  $Importe = round($PrecioVenta * $Cantidad,2);
//			  
//			  $InsFichaAccion->FccValorVentaManoObra = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
//			  $InsFichaAccion->FccImpuestoManoObra = $Importe - $InsFichaAccion->FccValorVentaManoObra;
//		
//			  $_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//			  NULL,
//			  $manoobra,
//			  NULL,
//			  ($PrecioVenta),
//			  $Cantidad,
//			  ($Importe),
//			  date("d/m/Y H:i:s"),
//			  date("d/m/Y H:i:s"),
//			  NULL,
//			  NULL,
//			  NULL,
//			  "S",
//			  NULL,						
//			  NULL,
//			  
//			  NULL,
//			  NULL,
//			  NULL,				
//			  
//			   "",
//			  $InsFichaAccion->FccValorVentaManoObra,
//			  $InsFichaAccion->FccImpuestoManoObra,
//			  0,
//			  (($InsFactura->FacObsequio=="1")?1:2),
//			  2,
//			  
//			  2,
//			  0	,
//			  
//			  ""		  
//			  );
//			  
//		}
		
		
		//MANO OBRA
		
		if(!empty($InsFichaAccion->FccManoObra) and $InsFichaAccion->FccManoObra <> "0.00" ){
			
			$manoobra = '';
			$Cantidad = 1;
			$PrecioVenta = $InsFichaAccion->FccManoObra;
			$Importe = round($PrecioVenta * $Cantidad,2);
			
			$ValorVenta = 0;
			$Impuesto = 0;
								
			  if(!empty($InsFichaAccion->FccManoObraDetalle)){
				  $manoobra = $InsFichaAccion->FccManoObraDetalle;	
			  }else{
				  $manoobra = 'MANO DE OBRA';
			  }
			  
			  if($InsFactura->MonId<>$EmpresaMonedaId ){
				  $PrecioVenta = round($PrecioVenta  / $InsFactura->FacTipoCambio,2);
				  $Importe = round($Importe  / $InsFactura->FacTipoCambio,2);
			  }
  
			  if($InsTallerPedido->AmoIncluyeImpuesto == 2){
					$PrecioVenta = $PrecioVenta * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
					$Importe = $Importe * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
				}
			  
			  
			  $Impuesto = ($Importe / (($InsFactura->FacPorcentajeImpuestoVenta/100)+1));
			$Impuesto = $Importe - $Impuesto;
				
				$ValorVenta = $Importe/((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);

				$Descuento = 0;
			
				if($InsTallerPedido->AmoDescuento>0){
					$Descuento = ($InsFactura->FacPorcentajeDescuento/100) * $Importe;
				}
				
				// $ValorVenta = $ValorVenta - $Descuento;
				
			  $_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			  NULL,
			  $manoobra,
			  NULL,
			  ($PrecioVenta),
			  $Cantidad,
			  ($Importe),
			  date("d/m/Y H:i:s"),
			  date("d/m/Y H:i:s"),
			  NULL,
			  NULL,
			  NULL,
			  "S",
			  NULL,						
			  NULL,
			  
			  NULL,
			  NULL,
			  NULL,				
			  
			   "",
			  	$ValorVenta,
									$Impuesto,
									$Descuento,
			  (($InsFactura->FacObsequio=="1")?1:2),
			  2,
			  
			  2,
			  0		,
			  
			  ""	  
			  );
			
		
		}
		
	}else{
		
		$ArrSeleccionados = explode("#",$POST_Seleccionados);
		
		if(!empty($ArrSeleccionados)){
			foreach($ArrSeleccionados as $DatSeleccionado){
			
				if(!empty($DatSeleccionado)){

					$InsFichaAccion->FccId = $DatSeleccionado;
					$InsFichaAccion->MtdObtenerFichaAccion();
					
					$InsFichaIngreso = new ClsFichaIngreso();
					$InsFichaIngreso->FinId = $InsFichaAccion->FinId;
					$InsFichaIngreso->MtdObtenerFichaIngreso();
				
					//OBTENIENDO FICHAS
					$InsTallerPedido = new ClsTallerPedido();
					$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoTiempoCreacion','DESC','',NULL,NULL,NULL,$InsFichaAccion->FccId,NULL,0,0,NULL,NULL,false,NULL);
					$ArrTallerPedidos = $ResTallerPedido['Datos'];
					
					
					//OBTENIENDO TOTAL DESCUENTO
					$MonedaId = "";
					$TipoCambio = NULL;
					$IncluyeImpuesto = NULL;
					$Observacion = NULL;
					$TallerPedidoId = "";
					$TienePromocion = false;
					
					$TotalDescuento = 0;
					$TotalBruto = 0;
					
					if(!empty($ArrTallerPedidos)){	
						foreach($ArrTallerPedidos as $DatTallerPedido){
			
							//$InsTallerPedido = new ClsTallerPedido();
							//$InsTallerPedido->AmoId = $DatTallerPedido->AmoId; 
							//$InsTallerPedido->MtdObtenerTallerPedido();	
							
							$MonedaId = $DatTallerPedido->MonId;
							$TipoCambio = $DatTallerPedido->AmoTipoCambio;
							$IncluyeImpuesto = $DatTallerPedido->AmoIncluyeImpuesto;
							$Observacion .= $DatTallerPedido->AmoObservacion;
							$TallerPedidoId = $DatTallerPedido->AmoId;
							
							if($DatTallerPedido->AmoIncluyeImpuesto == 2){
								$DatTallerPedido->AmoDescuento = ($DatTallerPedido->AmoDescuento * (($EmpresaImpuestoVenta/100)+1));
							}
							
							$TotalDescuento += $DatTallerPedido->AmoDescuento;
							$TotalBruto += $DatTallerPedido->AmoTotal;				
									
							if($DatTallerPedidoDetalle->ProTienePromocion=="1"){
								$TienePromocion = true;
							}
											
						}
					}
		
				$TotalBruto += $InsFichaAccion->FccManoObra;	
		
		
		$PorcentajeDescuento = (((100*$TotalDescuento)/$TotalBruto));
		
		
		//ESTRUCTURA FACTURA
		$InsFactura->MonId = $MonedaId;
		$InsFactura->FacTipoCambio = $TipoCambio;
		
		$InsFactura->AmoId = $TallerPedidoId;
		$InsFactura->FccId = $InsFichaAccion->FccId;
		$InsFactura->FinId = $InsFichaIngreso->FinId;
		
		$InsFactura->CliId = $InsFichaIngreso->CliId;		
		$InsFactura->CliNombre = $InsFichaIngreso->CliNombre;
		$InsFactura->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
		$InsFactura->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
		
		$InsFactura->TdoId = $InsFichaIngreso->TdoId;
		$InsFactura->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
		$InsFactura->FacDireccion = $InsFichaIngreso->CliDireccion." - ".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliDepartamento;
		$InsFactura->FacTelefono = $InsFichaIngreso->FinTelefono;		
		$InsFactura->FacObsequio = $InsFichaAccion->FimObsequio;
		
		$InsFactura->FacIncluyeImpuesto = $IncluyeImpuesto;
		$InsFactura->FacEstado = 5;
		$InsFactura->FacObservacion = $Observacion.chr(13).date("d/m/Y H:i:s")." - Factura autogenerada de Mov. Alm.:".$InsFactura->AmoId." / O.T.:".$InsFactura->FinId;
			
		if($InsFactura->FacObsequio == 1){
			$InsFactura->FacLeyenda .= chr(13)."ENTREGA A TITULO GRATUITO. VALOR REFERENCIAL";			
		}
		
		if($TienePromocion){
			$InsFactura->FacObservacionImpresa .= chr(13)."(*) Productos en oferta con precio especial disponibles hasta agotar stock";
		}
			
		$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
		$InsFactura->FacPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
		
		$InsFactura->FacPorcentajeDescuento = $PorcentajeDescuento;
		
		$InsFactura->FacVendedor = $InsFichaIngreso->UsuUsuario;	
		$InsFactura->FacNumeroPedido = $InsFichaIngreso->FinId;	
		
				
		
					//ITEMS		
					if(!empty($ArrTallerPedidos)){	
						foreach($ArrTallerPedidos as $DatTallerPedido){
			
							$InsTallerPedido->AmoId = $DatTallerPedido->AmoId; 
							$InsTallerPedido->MtdObtenerTallerPedido();	
							
							$MonedaId = $InsTallerPedido->MonId;
							$TipoCambio = $InsTallerPedido->AmoTipoCambio;
							$IncluyeImpuesto = $InsTallerPedido->AmoIncluyeImpuesto;
							$Observacion .= $InsTallerPedido->AmoObservacion;
							$TallerPedidoId = $InsTallerPedido->AmoId;
			
								//if($InsFichaAccion->MinSigla == "MA"){
							
									//	$TotalValorVenta = 0;
//										$TotalPrecioVenta = 0;
//										$TotalImporte = 0;
//										$TotalImpuesto = 0;
//										$TotalDescuento = 0;
//				
//										$Repuestos = "";
//												
//										if(!empty($InsTallerPedido->TallerPedidoDetalle)){
//											foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
//												
//												$GuardarDetalle = false;
//												
//												if($DatTallerPedidoDetalle->AmdCantidadPendienteFacturar>0){
//													$GuardarDetalle = true;
//												}
//									
//												if($DatTallerPedidoDetalle->AmdEstado == 1){
//													$GuardarDetalle = false;
//												}
//																					
//												if($GuardarDetalle){
//													
//													$reingreso = strpos($DatTallerPedidoDetalle->ProCodigoOriginal, "-R");
//													$Cantidad = $DatTallerPedidoDetalle->AmdCantidadPendienteFacturar;
//													
//													$PrecioVenta = $DatTallerPedidoDetalle->AmdPrecioVenta;
//													$Importe = $DatTallerPedidoDetalle->AmdImporte;
//													$ValorVenta = 0;
//													$Impuesto = 0;
//												
//													if($InsFactura->MonId<>$EmpresaMonedaId ){
//														$PrecioVenta = ($PrecioVenta / $InsFactura->FacTipoCambio);
//														$Importe = ($Importe / $InsFactura->FacTipoCambio);
//													}
//					
//													if($InsTallerPedido->AmoIncluyeImpuesto == 2){
//														$PrecioVenta = $PrecioVenta * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
//														$Importe = $Importe * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
//													}
//													
//													$Impuesto = ($Importe / (($InsFactura->FacPorcentajeImpuestoVenta/100)+1));
//													$Impuesto = $Importe - $Impuesto;
//													
//													$ValorVenta = $Importe/((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
//				
//													$Descuento = 0;
//												
//													if($InsTallerPedido->AmoDescuento>0){
//														$Descuento = ($InsFactura->FacPorcentajeDescuento/100) * $ValorVenta;
//													}
//				
//													$ValorVenta = $ValorVenta - $Descuento;
//														
//													$TotalValorVenta += $ValorVenta;
//													$TotalPrecioVenta += $PrecioVenta;
//													$TotalImporte += $Importe;
//													$TotalImpuesto += $Impuesto;
//													$TotalDescuento += $Descuento;
//													
//													if($DatTallerPedidoDetalle->RtiId == "RTI-10003"){
//					
//														$Repuestos .= " | ".number_format($DatTallerPedidoDetalle->AmdCantidad,2)." ".$DatTallerPedidoDetalle->UmeNombre." ".$DatTallerPedidoDetalle->ProNombre." [S]";			
//													
//													}elseif($DatTallerPedidoDetalle->RtiId == "RTI-10010" or $reingreso !== false){
//														
//														$Repuestos .= " | ".number_format($DatTallerPedidoDetalle->AmdCantidad,2)." ".$DatTallerPedidoDetalle->UmeNombre." ".$DatTallerPedidoDetalle->ProNombre." [S]";			
//													
//													}else{
//														
//														$Repuestos .= " | ".number_format($DatTallerPedidoDetalle->AmdCantidad,2)." ".$DatTallerPedidoDetalle->UmeNombre." ".$DatTallerPedidoDetalle->ProNombre." ".($DatTallerPedidoDetalle->AmdReingreso=="1"?'[R]':'')." ".($DatTallerPedidoDetalle->ProTienePromocion=="1"?'[*]':'');
//														
//													}
//													
//												
//												}
//						
//						
//											}		
//										}
//										
//									
//			
//			/*
//			SesionObjeto-FacturaDetalleListado
//			Parametro1 = FdeId
//			Parametro2 = FdeDescripcion
//			Parametro3
//			Parametro4 = FdePrecio
//			Parametro5 = FdeCantidad
//			Parametro6 = FdeImporte
//			Parametro7 = FdeTiempoCreacion
//			Parametro8 = FdeTiempoModificacion
//			Parametro9 = AmdId
//			Parametro10 = AmoId
//			Parametro11 =
//			Parametro12 = FdeTipo
//			Parametro13 = FdeUnidadMedida
//			Parametro14 = VcdReingreso
//			
//			Parametro15 = AmdId
//			Parametro16 = FatId
//			Parametro17 = OvvId
//			
//			Parametro18 = FdeCodigo
//			Parametro19 = FdeValorVenta
//			Parametro20 = FdeImpuesto
//			Parametro21 = FdeDescuento
//			Parametro22 = FdeGratuito
//			Parametro23 = FdeExonerado
//			
//			Parametro24 = FdeIncluyeSelectivo
//			Parametro25 = FdeImpuestoSelectivo
//			*/							
//										$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//										NULL,
//										"KIT DE MANTENIMIENTO ".$InsFichaAccion->VmaNombre." ".$InsFichaAccion->VmoNombre." ".$InsFichaAccion->FinMantenimientoKilometraje." KM".$Repuestos,
//										NULL,
//										$TotalImporte,
//										1,
//										$TotalImporte,				
//										
//										date("d/m/Y H:i:s"),
//										date("d/m/Y H:i:s"),
//										NULL,//EX AMDID
//										$DatTallerPedidoDetalle->AmoId,
//										NULL,
//										"T",
//										NULL,//UmeNombre
//										NULL,//AmdReingreso
//										NULL,//AmdId
//										NULL,
//										NULL,
//										"",//ProCodigoOriginal
//										$TotalValorVenta,
//										$TotalImpuesto,
//										$TotalDescuento,
//										(($InsFactura->FacObsequio=="1")?1:2),
//										2,
//										
//										2,
//										0,
//										
//										""
//										);	
//											
							//	}else{
			
									if(!empty($InsTallerPedido->TallerPedidoDetalle)){
										foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
											
											$GuardarDetalle = false;
											
											if($DatTallerPedidoDetalle->AmdCantidadPendienteFacturar>0){	
												$GuardarDetalle = true;
											}
											
											if($DatTallerPedidoDetalle->ProTienePromocion=="1"){
												$TienePromocion = true;
											}
												if($DatTallerPedidoDetalle->AmdEstado == 1){	
												$GuardarDetalle = false;
											}
											
											
											if($GuardarDetalle){
																				
												$reingreso = strpos($DatTallerPedidoDetalle->ProCodigoOriginal, "-R");
												
												$Cantidad = $DatTallerPedidoDetalle->AmdCantidadPendienteFacturar;
												$PrecioVenta = $DatTallerPedidoDetalle->AmdPrecioVenta;
												$Importe = $DatTallerPedidoDetalle->AmdImporte;
												$ValorVenta = 0;
												$Impuesto = 0;
												
												if($InsFactura->MonId<>$EmpresaMonedaId ){
													$PrecioVenta = ($PrecioVenta / $InsFactura->FacTipoCambio);
													$Importe = ($Importe / $InsFactura->FacTipoCambio);
												}
				
												if($InsTallerPedido->AmoIncluyeImpuesto == 2){
													$PrecioVenta = $PrecioVenta * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
													$Importe = $Importe * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
												}
												
												$Impuesto = ($Importe / (($InsFactura->FacPorcentajeImpuestoVenta/100)+1));
												$Impuesto = $Importe - $Impuesto;
												
												$ValorVenta = $Importe/((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
			
												$Descuento = 0;
											
												if($InsTallerPedido->AmoDescuento>0){
													$Descuento = ($InsFactura->FacPorcentajeDescuento/100) * $Importe;
												}
			
												// $ValorVenta = $ValorVenta - $Descuento;
											
												
												
			/*
			SesionObjeto-FacturaDetalleListado
			Parametro1 = FdeId
			Parametro2 = FdeDescripcion
			Parametro3
			Parametro4 = FdePrecio
			Parametro5 = FdeCantidad
			Parametro6 = FdeImporte
			Parametro7 = FdeTiempoCreacion
			Parametro8 = FdeTiempoModificacion
			Parametro9 = AmdId
			Parametro10 = AmoId
			Parametro11 =
			Parametro12 = FdeTipo
			Parametro13 = FdeUnidadMedida
			Parametro14 = VcdReingreso
			
			Parametro15 = AmdId
			Parametro16 = FatId
			Parametro17 = OvvId
			
			Parametro18 = FdeCodigo
			Parametro19 = FdeValorVenta
			Parametro20 = FdeImpuesto
			Parametro21 = FdeDescuento
			Parametro22 = FdeGratuito
			Parametro23 = FdeExonerado
			
			Parametro24 = FdeIncluyeSelectivo
			Parametro25 = FdeImpuestoSelectivo
			*/		
													
												if($DatTallerPedidoDetalle->RtiId == "RTI-10003"){
										
													$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
													NULL,
													$DatTallerPedidoDetalle->ProNombre." [S]",
													NULL,
													
													$PrecioVenta,
													$Cantidad,
													$Importe,					
													date("d/m/Y H:i:s"),
													date("d/m/Y H:i:s"),
													$DatTallerPedidoDetalle->AmdId,
													$DatTallerPedidoDetalle->AmoId,
													NULL,
													"T",
													$DatTallerPedidoDetalle->UmeAbreviacion,									
													$DatTallerPedidoDetalle->AmdReingreso,	
																					
													$DatTallerPedidoDetalle->AmdId,
													NULL,
													NULL,
			
													$DatTallerPedidoDetalle->ProCodigoOriginal,
			
													$ValorVenta,
													$Impuesto,//antes rea AmdDescuento
													$Descuento,
													(($InsFactura->FacObsequio=="1")?1:2),
													2,
													
													2,
													0,
													
													$DatTallerPedidoDetalle->AmdCompraOrigen
													);
									
												}elseif($DatTallerPedidoDetalle->RtiId == "RTI-10010" or $reingreso !== false){
													
													$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
													NULL,
													$DatTallerPedidoDetalle->ProNombre." [S]",
													NULL,
													$PrecioVenta,
													$Cantidad,
													$Importe,	
													date("d/m/Y H:i:s"),
													date("d/m/Y H:i:s"),
													$DatTallerPedidoDetalle->AmdId,
													$DatTallerPedidoDetalle->AmoId,
													NULL,
													"T",
													$DatTallerPedidoDetalle->UmeAbreviacion,									
													$DatTallerPedidoDetalle->AmdReingreso,	
																					
													$DatTallerPedidoDetalle->AmdId,
													NULL,
													NULL,
													
													$DatTallerPedidoDetalle->ProCodigoOriginal,
													$ValorVenta,
													$Impuesto,
													$Descuento,
													(($InsFactura->FacObsequio=="1")?1:2),
													2,
													
													2,
													0,
													
													$DatTallerPedidoDetalle->AmdCompraOrigen
													);	
			
												}else{										
													
													$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
													NULL,
													$DatTallerPedidoDetalle->ProNombre." ".$DatTallerPedidoDetalle->ProCodigoOriginal." ".($DatTallerPedidoDetalle->AmdReingreso=="1"?'[R]':'')." ".($DatTallerPedidoDetalle->ProTienePromocion=="1"?'[*]':''),
													NULL,
													$PrecioVenta,
													$Cantidad,
													$Importe,	
													date("d/m/Y H:i:s"),
													date("d/m/Y H:i:s"),
													$DatTallerPedidoDetalle->AmdId,
													$DatTallerPedidoDetalle->AmoId,
													NULL,
													"R",
													$DatTallerPedidoDetalle->UmeAbreviacion,									
													$DatTallerPedidoDetalle->AmdReingreso,	
																					
													$DatTallerPedidoDetalle->AmdId,
													NULL,
													NULL,
													
													$DatTallerPedidoDetalle->ProCodigoOriginal,
													$ValorVenta,
													$Impuesto,
													$Descuento,
													(($InsFactura->FacObsequio=="1")?1:2),
													2,
													
													2,
													0,
													
													$DatTallerPedidoDetalle->AmdCompraOrigen
													);	
									
												}
											
											}
								
										}
									}
																	
										
								//}
							
							
						
								if(!empty($InsTallerPedido->AmoDescuento) and $InsTallerPedido->AmoDescuento <> "0.00"){
										
								}
							
								if(!empty($InsTallerPedido->AmoId)){
							
									$_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
									NULL,
									$InsTallerPedido->AmoId,
									NULL,
									NULL,
									1,
									date("d/m/Y H:i:s"),
									date("d/m/Y H:i:s"),
									$InsTallerPedido->FinId,
									$InsTallerPedido->FccId,
									$InsTallerPedido->AmoFecha,
									$InsTallerPedido->AmoSubTipo
									);
									
								}
							
						}				
					}
							
					
					
				//TAREAS
					if(!empty($InsFichaAccion->FichaAccionTarea)){
						foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){
			
			/*
			SesionObjeto-FacturaDetalleListado
			Parametro1 = FdeId
			Parametro2 = FdeDescripcion
			Parametro3
			Parametro4 = FdePrecio
			Parametro5 = FdeCantidad
			Parametro6 = FdeImporte
			Parametro7 = FdeTiempoCreacion
			Parametro8 = FdeTiempoModificacion
			Parametro9 = AmdId
			Parametro10 = AmoId
			Parametro11 =
			Parametro12 = FdeTipo
			Parametro13 = FdeUnidadMedida
			Parametro14 = VcdReingreso
			
			Parametro15 = AmdId
			Parametro16 = FatId
			Parametro17 = OvvId
			
			Parametro18 = FdeCodigo
			Parametro19 = FdeValorVenta
			Parametro20 = FdeImpuesto
			Parametro21 = FdeDescuento
			Parametro22 = FdeGratuito
			Parametro23 = FdeExonerado
			
			Parametro24 = FdeIncluyeSelectivo
			Parametro25 = FdeImpuestoSelectivo
			*/								
			
							if(!empty($DatFichaAccionTarea->FatCosto) and $DatFichaAccionTarea->FatCosto <> "0.00"){
								
								$Cantidad = 1;
								
								if($InsFactura->MonId<>$EmpresaMonedaId ){
									$DatFichaAccionTarea->FatCosto = round($DatFichaAccionTarea->FatCosto  / $InsFactura->FacTipoCambio,2);
								}
			
								if($IncluyeImpuesto == 2){
									$DatFichaAccionTarea->FatCosto = $DatFichaAccionTarea->FatCosto + ($DatFichaAccionTarea->FatCosto * ($InsFactura->FacPorcentajeImpuestoVenta/100));
								}
			
								$PrecioVenta = $DatFichaAccionTarea->FatCosto;
								$Importe = round($PrecioVenta * $Cantidad,2);
								
								$DatFichaAccionTarea->FatValorVenta = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
								$DatFichaAccionTarea->FatImpuesto = $Importe - $DatFichaAccionTarea->FatValorVenta;
								
								$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
								NULL,
								$DatFichaAccionTarea->FatDescripcion,
								NULL,
								$PrecioVenta,
								$Cantidad ,
								$Importe,
								date("d/m/Y H:i:s"),
								date("d/m/Y H:i:s"),
								0,
								0,
								NULL,
								"S",
								"UND",								
								NULL,
															
								NULL,
								$DatFichaAccionTarea->FatId,
								NULL,
									
								"",
								$DatFichaAccionTarea->FatValorVenta,
								$DatFichaAccionTarea->FatImpuesto,
								0,
								(($InsFactura->FacObsequio=="1")?1:2),
								2,
								
								2,
								0,
								
								""
								);	
								
							}
							
						}
					}
								
					//MANO DE OBRA
				//	if(!empty($InsFichaAccion->FccManoObra) and $InsFichaAccion->FccManoObra <> "0.00" ){
//						 
//			
//			/*
//			SesionObjeto-FacturaDetalleListado
//			Parametro1 = FdeId
//			Parametro2 = FdeDescripcion
//			Parametro3
//			Parametro4 = FdePrecio
//			Parametro5 = FdeCantidad
//			Parametro6 = FdeImporte
//			Parametro7 = FdeTiempoCreacion
//			Parametro8 = FdeTiempoModificacion
//			Parametro9 = AmdId
//			Parametro10 = AmoId
//			Parametro11 =
//			Parametro12 = FdeTipo
//			Parametro13 = FdeUnidadMedida
//			Parametro14 = VcdReingreso
//			
//			Parametro15 = AmdId
//			Parametro16 = FatId
//			Parametro17 = OvvId
//			
//			Parametro18 = FdeCodigo
//			Parametro19 = FdeValorVenta
//			Parametro20 = FdeImpuesto
//			Parametro21 = FdeDescuento
//			Parametro22 = FdeGratuito
//			Parametro23 = FdeExonerado
//			
//			Parametro24 = FdeIncluyeSelectivo
//			Parametro25 = FdeImpuestoSelectivo
//			*/	
//						  $manoobra = '';
//						  $Cantidad = 1;
//						  
//						  if(!empty($InsFichaAccion->FccManoObraDetalle)){
//							  $manoobra = $InsFichaAccion->FccManoObraDetalle;	
//						  }else{
//							  $manoobra = 'MANO DE OBRA';
//						  }
//						  
//						  if($InsFactura->MonId<>$EmpresaMonedaId ){
//							  $InsFichaAccion->FccManoObra = round($InsFichaAccion->FccManoObra  / $InsFactura->FacTipoCambio,2);
//						  }
//						  
//						  if($InsTallerPedido->AmoIncluyeImpuesto == 2){		
//							  $InsFichaAccion->FccManoObra = round($InsFichaAccion->FccManoObra  / $InsFactura->FacTipoCambio,2);
//						  }
//						  
//						  $PrecioVenta = $InsFichaAccion->FccManoObra;
//						  $Importe = round($PrecioVenta * $Cantidad,2);
//						  
//						  $InsFichaAccion->FccValorVentaManoObra = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
//						  $InsFichaAccion->FccImpuestoManoObra = $Importe - $InsFichaAccion->FccValorVentaManoObra;
//					
//						  $_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//						  NULL,
//						  $manoobra,
//						  NULL,
//						  ($PrecioVenta),
//						  $Cantidad,
//						  ($Importe),
//						  date("d/m/Y H:i:s"),
//						  date("d/m/Y H:i:s"),
//						  NULL,
//						  NULL,
//						  NULL,
//						  "S",
//						  NULL,						
//						  NULL,
//						  
//						  NULL,
//						  NULL,
//						  NULL,				
//						  
//						   "",
//						  $InsFichaAccion->FccValorVentaManoObra,
//						  $InsFichaAccion->FccImpuestoManoObra,
//						  0,
//						  (($InsFactura->FacObsequio=="1")?1:2),
//						  2,
//						  
//						  2,
//						  0,
//						  
//						  ""
//						  );
//						  
//					}
										
		//MANO OBRA
		
		if(!empty($InsFichaAccion->FccManoObra) and $InsFichaAccion->FccManoObra <> "0.00" ){
			
			$manoobra = '';
			$Cantidad = 1;
			$PrecioVenta = $InsFichaAccion->FccManoObra;
			$Importe = round($PrecioVenta * $Cantidad,2);
			
			$ValorVenta = 0;
			$Impuesto = 0;
								
			  if(!empty($InsFichaAccion->FccManoObraDetalle)){
				  $manoobra = $InsFichaAccion->FccManoObraDetalle;	
			  }else{
				  $manoobra = 'MANO DE OBRA';
			  }
			  
			  if($InsFactura->MonId<>$EmpresaMonedaId ){
				  $PrecioVenta = round($PrecioVenta  / $InsFactura->FacTipoCambio,2);
				  $Importe = round($Importe  / $InsFactura->FacTipoCambio,2);
			  }
  
			  if($InsTallerPedido->AmoIncluyeImpuesto == 2){
					$PrecioVenta = $PrecioVenta * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
					$Importe = $Importe * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
				}
			  
			  
			  $Impuesto = ($Importe / (($InsFactura->FacPorcentajeImpuestoVenta/100)+1));
			$Impuesto = $Importe - $Impuesto;
				
				$ValorVenta = $Importe/((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);

				$Descuento = 0;
			
				if($InsTallerPedido->AmoDescuento>0){
					$Descuento = ($InsFactura->FacPorcentajeDescuento/100) * $Importe;
				}
				
				// $ValorVenta = $ValorVenta - $Descuento;
				
			  $_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			  NULL,
			  $manoobra,
			  NULL,
			  ($PrecioVenta),
			  $Cantidad,
			  ($Importe),
			  date("d/m/Y H:i:s"),
			  date("d/m/Y H:i:s"),
			  NULL,
			  NULL,
			  NULL,
			  "S",
			  NULL,						
			  NULL,
			  
			  NULL,
			  NULL,
			  NULL,				
			  
			   "",
			  	$ValorVenta,
									$Impuesto,
									$Descuento,
			  (($InsFactura->FacObsequio=="1")?1:2),
			  2,
			  
			  2,
			  0		,
			  
			  ""	  
			  );
			
		
		}
					
					
					
				
						
					
				}
				
			}
		}
		
	}
	
	




}




function FncCargarVentaConcretadaDatos(){

	global $GET_VcoId;
	global $POST_Seleccionados;
	
	global $Identificador;
	global $InsVentaConcretada;
	global $InsFactura;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;
	global $EmpresaImpuestoSelectivo;
	
	if(!empty($GET_VcoId)){
		
		$InsVentaConcretada = new ClsVentaConcretada();
		$InsVentaConcretada->VcoId = $GET_VcoId;	
		$InsVentaConcretada->MtdObtenerVentaConcretada();	
		
		//CALCULANDO PORCENTAJE DESCUENTO
		if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
			$VcoDescuento = ($InsVentaConcretada->VcoDescuento / $InsVentaConcretada->VcoTipoCambio);
			$VcoTotal = ($InsVentaConcretada->VcoTotal / $InsVentaConcretada->VcoTipoCambio);
			$VcoSubTotal = ($InsVentaConcretada->VcoSubTotal / $InsVentaConcretada->VcoTipoCambio);
		}else{
			$VcoDescuento = ($InsVentaConcretada->VcoDescuento);
			$VcoTotal = ($InsVentaConcretada->VcoTotal);
			$VcoSubTotal = ($InsVentaConcretada->VcoSubTotal);			
		}

		//AUX
		if($InsVentaConcretada->VcoIncluyeImpuesto == 1){	
			$VcoDescuento = ($VcoDescuento / (($EmpresaImpuestoVenta/100)+1));	
		}
		
		$CalcTotalDescuento = $VcoDescuento * ( ($EmpresaImpuestoVenta/100)+1);
		$CalcTotalBruto = ($VcoSubTotal + $VcoDescuento) * ( ($EmpresaImpuestoVenta/100)+1);				
		
		$PorcentajeDescuento = (((100*$CalcTotalDescuento)/$CalcTotalBruto));
		
		
		
		
		$InsFactura->AmoId = $InsVentaConcretada->VcoId;
		$InsFactura->CprId = $InsVentaConcretada->CprId;
		$InsFactura->VdiId = $InsVentaConcretada->VdiId;	

		$InsFactura->CliId = $InsVentaConcretada->CliId;		
		$InsFactura->CliNombre = $InsVentaConcretada->CliNombre;
		$InsFactura->CliApellidoPaterno = $InsVentaConcretada->CliApellidoPaterno;
		$InsFactura->CliApellidoMaterno = $InsVentaConcretada->CliApellidoMaterno;
		
		$InsFactura->TdoId = $InsVentaConcretada->TdoId;
		$InsFactura->CliNumeroDocumento = $InsVentaConcretada->CliNumeroDocumento;
		$InsFactura->FacDireccion = $InsVentaConcretada->CliDireccion." - ".$InsVentaConcretada->CliDistrito." - ".$InsVentaConcretada->CliProvincia." - ".$InsVentaConcretada->CliDepartamento;
		
		$InsFactura->FacTelefono = $InsVentaConcretada->VcoTelefono;	
		$InsFactura->FacEstado = 5;
		$InsFactura->FacObservacion = $InsVentaConcretada->VcoObservacion.chr(13).date("d/m/Y H:i:s")." - Factura autogenerada de Mov. Alm.: ".$InsFactura->AmoId." / Cot.: ".$InsFactura->CprId;
	
		if(!empty($InsVentaConcretada->VdiOrdenCompraNumero)){
			$InsFactura->FacObservacionImpresa .= chr(13)."O.C.: ".$InsVentaConcretada->VdiOrdenCompraNumero;		
		}
		
		if(!empty($InsVentaConcretada->CprId)){
			$InsFactura->FacObservacionImpresa .= chr(13)."Cot.: ".$InsVentaConcretada->CprId;		
		}
		
		$InsFactura->MonId = $InsVentaConcretada->MonId;		
		$InsFactura->FacTipoCambio = $InsVentaConcretada->VcoTipoCambio;		
		
		$InsFactura->FacIncluyeImpuesto = 1;
		$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
		$InsFactura->FacPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
		
		$InsFactura->FacPorcentajeDescuento = $PorcentajeDescuento;
		
		$InsFactura->FacVendedor = $InsVentaConcretada->UsuUsuario;	
		$InsFactura->FacNumeroPedido = $InsVentaConcretada->VdiId;	
		
		
		$InsFactura->FacAbono = 0;
		
		$FacturaTotal = 0;
			
			if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
				foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){
					
					//$Cantidad = $DatVentaConcretadaDetalle->VcdCantidad;
					//.deb($DatVentaConcretadaDetalle->VcdCantidadFacturar);
					if($DatVentaConcretadaDetalle->VcdCantidadFacturar>0){
						
						$reingreso = strpos($DatVentaConcretadaDetalle->ProCodigoOriginal, "-R");
									
						$Cantidad = $DatVentaConcretadaDetalle->VcdCantidadFacturar;
						$PrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta;
						$Importe = $DatVentaConcretadaDetalle->VcdImporte;
						$ValorVenta = 0;
						$Impuesto = 0;
						
						if($InsFactura->MonId<>$EmpresaMonedaId ){
							$PrecioVenta = ($PrecioVenta / $InsFactura->FacTipoCambio);
							$Importe = ($Importe / $InsFactura->FacTipoCambio);
						}
						
						if($InsVentaConcretada->VcoIncluyeImpuesto == 2){
							$PrecioVenta = $PrecioVenta * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
							$Importe = $Importe * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
						}
						  
						$Impuesto = ($Importe / (($InsFactura->FacPorcentajeImpuestoVenta/100)+1));
						$Impuesto = $Importe - $Impuesto;
						
						$ValorVenta = $Importe/((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
						
						$Descuento = 0;
						
						if($InsVentaConcretada->VcoDescuento>0){
						  $Descuento = ($InsFactura->FacPorcentajeDescuento/100) * $ValorVenta;
						}
						
						// $ValorVenta = $ValorVenta - $Descuento;
											
						/*
						SesionObjeto-FacturaDetalleListado
						Parametro1 = FdeId
						Parametro2 = FdeDescripcion
						Parametro3
						Parametro4 = FdePrecio
						Parametro5 = FdeCantidad
						Parametro6 = FdeImporte
						Parametro7 = FdeTiempoCreacion
						Parametro8 = FdeTiempoModificacion
						Parametro9 = AmdId
						Parametro10 = AmoId
						Parametro11 =
						Parametro12 = FdeTipo
						Parametro13 = FdeUnidadMedida
						Parametro14 = VcdReingreso
						
						Parametro15 = AmdId
						Parametro16 = FatId
						Parametro17 = OvvId
						
						Parametro18 = FdeCodigo
						Parametro19 = FdeValorVenta
						Parametro20 = FdeImpuesto
						Parametro21 = FdeDescuento
						Parametro22 = FdeGratuito
						Parametro23 = FdeExonerado
						
						Parametro24 = FdeIncluyeSelectivo
						Parametro25 = FdeImpuestoSelectivo
						Parametro26 = AmdCompraOrigen
						*/		

						if($DatVentaConcretadaDetalle->RtiId == "RTI-10003"){
							
							$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatVentaConcretadaDetalle->ProNombre." [S]",
							NULL,
							$PrecioVenta,
							$Cantidad,
							$Importe,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							NULL,//EX VcdId
							$DatVentaConcretadaDetalle->VcoId,
							NULL,
							"T",
							$DatVentaConcretadaDetalle->UmeAbreviacion,
							$DatVentaConcretadaDetalle->VcdReingreso,

							$DatVentaConcretadaDetalle->VcdId,
							NULL,
							NULL,

							$DatVentaConcretadaDetalle->ProCodigoOriginal,
							$ValorVenta,
							$Impuesto,//antes rea AmdDescuento
							$Descuento,
							2,
							2,
							
							2,
							0,
							
							$DatVentaConcretadaDetalle->VcdCompraOrigen							
							);
								
						}elseif($DatVentaConcretadaDetalle->RtiId == "RTI-10010" or $reingreso !== false){
							
							$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatVentaConcretadaDetalle->ProNombre." [S]",
							NULL,
							$PrecioVenta,
							$Cantidad,
							$Importe,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							NULL,//EX VcdId
							$DatVentaConcretadaDetalle->VcoId,
							NULL,
							"T",
							$DatVentaConcretadaDetalle->UmeAbreviacion,
							$DatVentaConcretadaDetalle->VcdReingreso,
							
							$DatVentaConcretadaDetalle->VcdId,
							NULL,
							NULL,
							
							$DatVentaConcretadaDetalle->ProCodigoOriginal,
							$ValorVenta,
							$Impuesto,//antes rea AmdDescuento
							$Descuento,
							2,
							2,
							
							2,
							0,
							
							$DatVentaConcretadaDetalle->VcdCompraOrigen
							);
							
						}else{
							
							$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatVentaConcretadaDetalle->ProNombre." ".$DatVentaConcretadaDetalle->ProCodigoOriginal." ".($DatVentaConcretadaDetalle->VcdReingreso=="1"?'[R]':'')." ".($DatVentaConcretadaDetalle->ProTienePromocion=="1"?'[*]':''),
							NULL,
							$PrecioVenta,
							$Cantidad,
							$Importe,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							NULL,//EX VcdId
							$DatVentaConcretadaDetalle->VcoId,
							NULL,
							"R",
							$DatVentaConcretadaDetalle->UmeAbreviacion,
							$DatVentaConcretadaDetalle->VcdReingreso,
							
							$DatVentaConcretadaDetalle->VcdId,
							NULL,
							NULL,
							
							$DatVentaConcretadaDetalle->ProCodigoOriginal,
							$ValorVenta,
							$Impuesto,//antes rea AmdDescuento
							$Descuento,
							2,
							2,
							
							2,
							0,
							
							$DatVentaConcretadaDetalle->VcdCompraOrigen
							);
							
						}

						$FacturaTotal += $Importe;

					}

				}		
			}
			
			if(!empty($InsVentaConcretada->VcoDescuento)){
						
			}			
					
			if(!empty($InsVentaConcretada->VcoManoObra) and $InsVentaConcretada->VcoManoObra <> 0.00){
				
				
		
/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro3
Parametro4 = FdePrecio
Parametro5 = FdeCantidad
Parametro6 = FdeImporte
Parametro7 = FdeTiempoCreacion
Parametro8 = FdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FdeTipo
Parametro13 = FdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = FdeCodigo
Parametro19 = FdeValorVenta
Parametro20 = FdeImpuesto
Parametro21 = FdeDescuentom
Parametro22 = FdeGratuito
Parametro23 = FdeExonerado		
*/
				$Cantidad = 1;
				
				if($InsFactura->MonId<>$EmpresaMonedaId ){
					$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra  / $InsFactura->FacTipoCambio,2);
				}

				if($InsVentaConcretada->VcoIncluyeImpuesto == 2){				
					$InsVentaConcretada->VcoManoObra = $InsVentaConcretada->VcoManoObra + ($InsOrdenVentaVehiculo->VcoManoObra * ($InsFactura->FacPorcentajeImpuestoVenta/100));
				}

				$PrecioVenta = $InsVentaConcretada->VcoManoObra;
				$Importe = round($PrecioVenta * $Cantidad,2);
				
				$InsVentaConcretada->VcoValorVentaManoObra = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
				$InsVentaConcretada->VcoImpuestoManoObra = $Importe - $InsVentaConcretada->VcoValorVentaManoObra;
				
				$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				"MANO DE OBRA",
				NULL,
				$PrecioVenta,
				$Cantidad,
				$Importe,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s"),
				NULL,
				NULL,
				NULL,
				"S",
				NULL,
				NULL,
				
				NULL,
				NULL,
				NULL,
				
				"",
				$InsVentaConcretada->VcoValorVentaManoObra,
				$InsVentaConcretada->VcoImpuestoManoObra,
				0,
				2,
				2,
				
				2,
				0,
				
				""	
				);
				
				$FacturaTotal += $InsVentaConcretada->VcoManoObra;
						
			}
	
			if(!empty($InsVentaConcretada->VcoId)){
				
				$_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				$InsVentaConcretada->VcoId,
				NULL,
				NULL,
				1,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s"),
				NULL,
				NULL,
				$InsVentaConcretada->VcoFecha,
				$InsVentaConcretada->VcoSubTipo
				);
			
			}
			
			
			$InsPago = new ClsPago();
//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL)
			$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,$InsVentaConcretada->VdiId,NULL,NULL,NULL);
			$ArrPagos = $ResPago['Datos'];
				
			$TotalAbonado = 0;
							
			if(!empty($ArrPagos)){
				foreach($ArrPagos as $DatPago){
						
					if($DatPago->MonId == $InsFactura->MonId){//DOLARES
						
						if($InsFactura->MonId == $EmpresaMonedaId){
							$TotalAbonado += $DatPago->PagMonto;
						}else{
							$TotalAbonado += ($DatPago->PagMonto/$DatPago->PagTipoCambio);
						}
						
					}
						
				}
			}
			
			//deb($FacturaTotal." - ".$TotalAbonado);
			$InsFactura->FacAbono += $FacturaTotal - $TotalAbonado;
			
	}else{
		
		$ArrSeleccionados = explode("#",$POST_Seleccionados);
		
		if(!empty($ArrSeleccionados)){
			foreach($ArrSeleccionados as $DatSeleccionado){
				
				if(!empty($DatSeleccionado)){

//SesionObjeto-FacturaAlmacenMovimiento
//Parametro1 = FamId
//Parametro2 = AmoId
//Parametro3 = 
//Parametro4 = 
//Parametro5 = FamEstado
//Parametro6 = FamTiempoCreacion
//Parametro7 = FamTiempoModificacion
					$InsVentaConcretada = new ClsVentaConcretada();
					$InsVentaConcretada->VcoId = $DatSeleccionado;	
					$InsVentaConcretada->MtdObtenerVentaConcretada();	
					
					//CALCULANDO PORCENTAJE DESCUENTO
					if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
						$VcoDescuento = ($InsVentaConcretada->VcoDescuento / $InsVentaConcretada->VcoTipoCambio);
						$VcoTotal = ($InsVentaConcretada->VcoTotal / $InsVentaConcretada->VcoTipoCambio);
						$VcoSubTotal = ($InsVentaConcretada->VcoSubTotal / $InsVentaConcretada->VcoTipoCambio);
					}else{
						$VcoDescuento = ($InsVentaConcretada->VcoDescuento);
						$VcoTotal = ($InsVentaConcretada->VcoTotal);
						$VcoSubTotal = ($InsVentaConcretada->VcoSubTotal);			
					}
			
					//AUX
					if($InsVentaConcretada->VcoIncluyeImpuesto == 1){	
						$VcoDescuento = ($VcoDescuento / (($EmpresaImpuestoVenta/100)+1));	
					}
					
					$CalcTotalDescuento = $VcoDescuento * ( ($EmpresaImpuestoVenta/100)+1);
					$CalcTotalBruto = ($VcoSubTotal + $VcoDescuento) * ( ($EmpresaImpuestoVenta/100)+1);				
					
					$PorcentajeDescuento = (((100*$CalcTotalDescuento)/$CalcTotalBruto));
					
						
//					$TotalDescuento = $InsVentaConcretada->VcoDescuento;
//					//$TotalBruto = $InsVentaConcretada->VcoTotal;
//					//$TotalBruto = $InsVentaConcretada->VcoTotal;
//					$TotalBruto = $InsVentaConcretada->VcoTotal + $InsVentaConcretada->VcoDescuento;
//					
//					if($InsVentaConcretada->VcoIncluyeImpuesto == 2){				
//						$TotalDescuento = $InsVentaConcretada->VcoDescuento + ($InsVentaConcretada->VcoDescuento * ($EmpresaImpuestoVenta/100));				
//					}
//					
//					if($InsVentaConcretada->VcoIncluyeImpuesto == 2){				
//						$TotalBruto = $InsVentaConcretada->VcoTotal + ($InsVentaConcretada->VcoTotal * ($EmpresaImpuestoVenta/100));				
//					}
//					
//					$PorcentajeDescuento = (((100*$TotalDescuento)/$TotalBruto));
					
					
					$InsFactura->AmoId = $InsVentaConcretada->VcoId;
					$InsFactura->CprId = $InsVentaConcretada->CprId;
					$InsFactura->VdiId = $InsVentaConcretada->VdiId;

					$InsFactura->CliId = $InsVentaConcretada->CliId;		
					$InsFactura->CliNombre = $InsVentaConcretada->CliNombre;
					$InsFactura->CliApellidoPaterno = $InsVentaConcretada->CliApellidoPaterno;
					$InsFactura->CliApellidoMaterno = $InsVentaConcretada->CliApellidoMaterno;
					
					$InsFactura->TdoId = $InsVentaConcretada->TdoId;
					$InsFactura->CliNumeroDocumento = $InsVentaConcretada->CliNumeroDocumento;
					$InsFactura->FacDireccion = $InsVentaConcretada->CliDireccion." - ".$InsVentaConcretada->CliDistrito." - ".$InsVentaConcretada->CliProvincia." - ".$InsVentaConcretada->CliDepartamento;
					
					$InsFactura->FacTelefono = $InsVentaConcretada->VcoTelefono;	
					//$InsFactura->FacIncluyeImpuesto = $InsVentaConcretada->VcoIncluyeImpuesto;	
					$InsFactura->FacEstado = 5;
				//	$InsFactura->FacObservacion = $InsVentaConcretada->VcoObservacion;
					$InsFactura->FacObservacion = $InsVentaConcretada->VcoObservacion.chr(13).date("d/m/Y H:i:s")." - Factura autogenerada de Mov. Alm.: ".$InsFactura->AmoId." / Cot.: ".$InsFactura->CprId;
					
					//deb($InsFactura->FacIncluyeImpuesto);
					if(!empty($InsVentaConcretada->VdiOrdenCompraNumero)){
						$InsFactura->FacObservacionImpresa .= chr(13)."O.C.: ".$InsVentaConcretada->VdiOrdenCompraNumero;		
					}
				
					if(!empty($InsVentaConcretada->CprId)){
						$InsFactura->FacObservacionImpresa .= chr(13)."Cot.: ".$InsVentaConcretada->CprId;		
					}
				
					//$InsFactura->MonId = $EmpresaMonedaId;		
					$InsFactura->MonId = $InsVentaConcretada->MonId;		
					$InsFactura->FacTipoCambio = $InsVentaConcretada->VcoTipoCambio;		
				
					$InsFactura->FacIncluyeImpuesto = 1;
					$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
					$InsFactura->FacPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
					$InsFactura->FacPorcentajeDescuento = $PorcentajeDescuento;
					
					$InsFactura->FacVendedor = $InsVentaConcretada->UsuUsuario;	
					$InsFactura->FacNumeroPedido = $InsVentaConcretada->VdiId;	
		
		
					$InsFactura->FacAbono = 0;
					//$InsFactura->FacTotalDescuento = $InsVentaConcretada->VcoDescuento;
					
					//if($InsFactura->MonId<>$EmpresaMonedaId ){
//						$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento  / $InsFactura->FacTipoCambio,6);
//					}
//		
					//$ValorVentaTotal = 0;			
//					
//					if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
//						foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){
//							
//							if($DatVentaConcretadaDetalle->VcdCantidadFacturar>0){
//								
//								$Cantidad = $DatVentaConcretadaDetalle->VcdCantidadFacturar;
//								
//								if($InsFactura->MonId<>$EmpresaMonedaId ){
//									$PrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta  / $InsFactura->FacTipoCambio,6);
//								}
//		
//								if($InsVentaConcretada->VcoIncluyeImpuesto == 2){							
//									$PrecioVenta = $PrecioVenta + ($PrecioVenta * ($InsFactura->FacPorcentajeImpuestoVenta/100));							
//								}
//		
//								$Importe = round($PrecioVenta * $Cantidad,2);
//							
//								$ValorVenta = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
//								
//								$ValorVentaTotal += $ValorVenta;
//		
//							}
//		
//						}		
//					}
//					
					//$ValorVentaTotal = 0;			
//			
//					if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
//						foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){
//						
//							if($DatVentaConcretadaDetalle->VcdCantidadFacturar>0){
//								
//								$Cantidad = $DatVentaConcretadaDetalle->VcdCantidadFacturar;
//								
//								if($InsFactura->MonId<>$EmpresaMonedaId ){
//									$PrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta  / $InsFactura->FacTipoCambio,6);
//								}
//					
//								if($InsVentaConcretada->VcoIncluyeImpuesto == 2){							
//									$PrecioVenta = $PrecioVenta + ($PrecioVenta * ($InsFactura->FacPorcentajeImpuestoVenta/100));							
//								}
//					
//								$Importe = round($PrecioVenta * $Cantidad,2);
//							
//								$ValorVenta = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
//								
//								$ValorVentaTotal += $ValorVenta;
//					
//							}
//					
//						}		
//					}
//						
//						
//					if($InsFactura->MonId<>$EmpresaMonedaId ){
//						$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento  / $InsFactura->FacTipoCambio,6);
//					}
//					
//					$PorcentajeDescuento = round(((100*$InsVentaConcretada->VcoDescuento)/$ValorVentaTotal),2);
//		
					$FacturaTotal = 0;
			
//			deb($InsVentaConcretada->VentaConcretadaDetalle);
			
			//deb($InsFactura->MonId);
				//deb($EmpresaMonedaId);
				
					if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
						foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){
							
							//$Cantidad = $DatVentaConcretadaDetalle->VcdCantidad;
							//.deb($DatVentaConcretadaDetalle->VcdCantidadFacturar);
							
							if($DatVentaConcretadaDetalle->VcdCantidadFacturar>0){
								
								//$Cantidad = $DatVentaConcretadaDetalle->VcdCantidadFacturar;
//								$reingreso = strpos($DatVentaConcretadaDetalle->ProCodigoOriginal, "-R");
//							
//								if($InsFactura->MonId<>$EmpresaMonedaId ){
//									$DatVentaConcretadaDetalle->VcdPrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta  / $InsFactura->FacTipoCambio,6);
//								}
//								
//								if($InsVentaConcretada->VcoIncluyeImpuesto == 2){							
//									$DatVentaConcretadaDetalle->VcdPrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta + ($DatVentaConcretadaDetalle->VcdPrecioVenta * ($InsFactura->FacPorcentajeImpuestoVenta/100));							
//								}
//								
//								if($InsVentaConcretada->VcoIncluyeImpuesto == 1){							
//									$InsVentaConcretada->VcoDescuento = $InsVentaConcretada->VcoDescuento /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
//								}
//		
//								$PrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta;
//								$Importe = round($PrecioVenta * $Cantidad,2);
//						
//								$DatVentaConcretadaDetalle->VcdValorVenta = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
//								$DatVentaConcretadaDetalle->VcdImpuesto = $Importe  - $DatVentaConcretadaDetalle->VcdValorVenta;	
//							
//								$Descuento = 0;						
//		
//								if($InsVentaConcretada->VcoDescuento>0){
//									
//									$PorcentajeDistribucion = 0;
//									
//									$PorcentajeDistribucion = ((100 * $DatVentaConcretadaDetalle->VcdValorVenta)/$ValorVentaTotal);
//									$PorcentajeDistribucion  = ($PorcentajeDistribucion / 100);
//									$Descuento = $PorcentajeDistribucion * $InsVentaConcretada->VcoDescuento;
//									//$DatVentaConcretadaDetalle->VcdValorVenta = $DatVentaConcretadaDetalle->VcdValorVenta - $Descuento;
//									//$DatVentaConcretadaDetalle->VcdImpuesto = ($DatVentaConcretadaDetalle->VcdValorVenta * ($InsFactura->FacPorcentajeImpuestoVenta/100));							
//									//$Importe = $DatVentaConcretadaDetalle->VcdValorVenta + $DatVentaConcretadaDetalle->VcdImpuesto;
//									
//									if($InsFactura->MonId<>$EmpresaMonedaId ){
//										$Descuento = round($Descuento/ $InsFactura->FacTipoCambio,6);
//									}
//									
//								}
								
								$reingreso = strpos($DatVentaConcretadaDetalle->ProCodigoOriginal, "-R");
											
								$Cantidad = $DatVentaConcretadaDetalle->VcdCantidadPendienteFacturar;
								$PrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta;
								$Importe = $DatVentaConcretadaDetalle->VcdImporte;
								$ValorVenta = 0;
								$Impuesto = 0;
								
								if($InsFactura->MonId<>$EmpresaMonedaId ){
									$PrecioVenta = ($PrecioVenta / $InsFactura->FacTipoCambio);
									$Importe = ($Importe / $InsFactura->FacTipoCambio);
								}
								
								if($InsVentaConcretada->VcoIncluyeImpuesto == 2){
									$PrecioVenta = $PrecioVenta * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
									$Importe = $Importe * (($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
								}
								  
								$Impuesto = ($Importe / (($InsFactura->FacPorcentajeImpuestoVenta/100)+1));
								$Impuesto = $Importe - $Impuesto;
								
								$ValorVenta = $Importe/((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
								
								$Descuento = 0;
								
								if($InsVentaConcretada->VcoDescuento>0){
								  $Descuento = ($InsFactura->FacPorcentajeDescuento/100) * $ValorVenta;
								}
								
								// $ValorVenta = $ValorVenta - $Descuento;
								
								
/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro3
Parametro4 = FdePrecio
Parametro5 = FdeCantidad
Parametro6 = FdeImporte
Parametro7 = FdeTiempoCreacion
Parametro8 = FdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FdeTipo
Parametro13 = FdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = FdeCodigo
Parametro19 = FdeValorVenta
Parametro20 = FdeImpuesto
Parametro21 = FdeDescuento
Parametro22 = FdeGratuito
Parametro23 = FdeExonerado

Parametro24 = FdeIncluyeSelectivo
Parametro25 = FdeImpuestoSelectivo
*/		
								if($DatVentaConcretadaDetalle->RtiId == "RTI-10003"){
									
									$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
									NULL,
									$DatVentaConcretadaDetalle->ProNombre." [S]",
									NULL,
									$PrecioVenta,
									$Cantidad,
									$Importe,
									date("d/m/Y H:i:s"),
									date("d/m/Y H:i:s"),
									NULL,//EX VcdId
									$DatVentaConcretadaDetalle->VcoId,
									NULL,
									"T",
									$DatVentaConcretadaDetalle->UmeAbreviacion,
									$DatVentaConcretadaDetalle->VcdReingreso,
		
									$DatVentaConcretadaDetalle->VcdId,
									NULL,
									NULL,
		
									$DatVentaConcretadaDetalle->ProCodigoOriginal,
									$ValorVenta,
									$Impuesto,
									$Descuento,
									2,
									2,
									
									2,
									0,
									
									$DatVentaConcretadaDetalle->VcdCompraOrigen	
									);
										
								}elseif($DatVentaConcretadaDetalle->RtiId == "RTI-10010" or $reingreso !== false){
									
									$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
									NULL,
									$DatVentaConcretadaDetalle->ProNombre." [S]",
									NULL,
									$PrecioVenta,
									$Cantidad,
									$Importe,
									date("d/m/Y H:i:s"),
									date("d/m/Y H:i:s"),
									NULL,//EX VcdId
									$DatVentaConcretadaDetalle->VcoId,
									NULL,
									"T",
									$DatVentaConcretadaDetalle->UmeAbreviacion,
									$DatVentaConcretadaDetalle->VcdReingreso,
									
									$DatVentaConcretadaDetalle->VcdId,
									NULL,
									NULL,
									
									$DatVentaConcretadaDetalle->ProCodigoOriginal,
									$ValorVenta,
									$Impuesto,
									$Descuento,
									2,
									2,
									
									2,
									0,
									
									$DatVentaConcretadaDetalle->VcdCompraOrigen			
									);
									
								}else{
									
									$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
									NULL,
									$DatVentaConcretadaDetalle->ProNombre." ".$DatVentaConcretadaDetalle->ProCodigoOriginal." ".($DatVentaConcretadaDetalle->VcdReingreso=="1"?'[R]':'')." ".($DatVentaConcretadaDetalle->ProTienePromocion=="1"?'[*]':''),
									NULL,
									$PrecioVenta,
									$Cantidad,
									$Importe,
									date("d/m/Y H:i:s"),
									date("d/m/Y H:i:s"),
									NULL,//EX VcdId
									$DatVentaConcretadaDetalle->VcoId,
									NULL,
									"R",
									$DatVentaConcretadaDetalle->UmeAbreviacion,
									$DatVentaConcretadaDetalle->VcdReingreso,
									
									$DatVentaConcretadaDetalle->VcdId,
									NULL,
									NULL,
									
									$DatVentaConcretadaDetalle->ProCodigoOriginal,
									$ValorVenta,
									$Impuesto,
									$Descuento,
									2,
									2,
									
									2,
									0,
									
									$DatVentaConcretadaDetalle->VcdCompraOrigen	
									);
									
								}
		
								$FacturaTotal += $Importe;
		
							}
		
						}		
					}
			
//				if(!empty($InsVentaConcretada->VcoDescuento)){
//
//				if($InsFactura->MonId<>$EmpresaMonedaId ){
//					$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento  / $InsFactura->FacTipoCambio,2);
//				}
//		
//				if($InsFactura->FacIncluyeImpuesto == 2){				
//					$InsVentaConcretada->VcoDescuento = $InsVentaConcretada->VcoDescuento + ($InsOrdenVentaVehiculo->VcoDescuento * ($InsFactura->FacPorcentajeImpuestoVenta/100));
//				}
//				
///*
//SesionObjeto-FacturaDetalleListado
//Parametro1 = FdeId
//Parametro2 = FdeDescripcion
//Parametro3
//Parametro4 = FdePrecio
//Parametro5 = FdeCantidad
//Parametro6 = FdeImporte
//Parametro7 = FdeTiempoCreacion
//Parametro8 = FdeTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 =
//Parametro12 = FdeTipo
//Parametro13 = FdeUnidadMedida
//Parametro14 = VcdReingreso
//
//Parametro15 = AmdId
//Parametro16 = FatId
//Parametro17 = OvvId
//*/
//
//				$PrecioVenta = $InsVentaConcretada->VcoDescuento;
//				$Importe = $PrecioVenta * 1;
//													
//				$InsVentaConcretada->VcoValorVenta = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
//				$InsVentaConcretada->VcoImpuesto = $Importe - $InsVentaConcretada->VcoValorVenta;		
//						
//				$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//				NULL,
//				"DESCUENTO",
//				NULL,
//				$PrecioVenta*-1,
//				1,
//				$Importe*-1,
//				date("d/m/Y H:i:s"),
//				date("d/m/Y H:i:s"),
//				NULL,
//				NULL,
//				NULL,
//				"S",
//				NULL,
//				NULL,
//				
//				NULL,
//				NULL,
//				NULL,
//				
//				"",
//				$InsVentaConcretada->VcoValorVenta*-1,
//				$InsVentaConcretada->VcoImpuesto*-1,
//				0,
//				2,
//				2 		
//				);
//				
//				$FacturaTotal += $InsVentaConcretada->VcoDescuento*-1;
//						
//			}
			
					
					if(!empty($InsVentaConcretada->VcoManoObra) and $InsVentaConcretada->VcoManoObra <> 0.00){
						
						$Cantidad = 1;
						
						if($InsFactura->MonId<>$EmpresaMonedaId ){
							$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra  / $InsFactura->FacTipoCambio,2);
						}
		
						if($InsVentaConcretada->VcoIncluyeImpuesto == 2){				
							$InsVentaConcretada->VcoManoObra = $InsVentaConcretada->VcoManoObra + ($InsOrdenVentaVehiculo->VcoManoObra * ($InsFactura->FacPorcentajeImpuestoVenta/100));
						}
		
						/*
						SesionObjeto-FacturaDetalleListado
						Parametro1 = FdeId
						Parametro2 = FdeDescripcion
						Parametro3
						Parametro4 = FdePrecio
						Parametro5 = FdeCantidad
						Parametro6 = FdeImporte
						Parametro7 = FdeTiempoCreacion
						Parametro8 = FdeTiempoModificacion
						Parametro9 = AmdId
						Parametro10 = AmoId
						Parametro11 =
						Parametro12 = FdeTipo
						Parametro13 = FdeUnidadMedida
						Parametro14 = VcdReingreso
						
						Parametro15 = AmdId
						Parametro16 = FatId
						Parametro17 = OvvId
						
						Parametro18 = FdeCodigo
						Parametro19 = FdeValorVenta
						Parametro20 = FdeImpuesto
						Parametro21 = FdeDescuentom
						Parametro22 = FdeGratuito
						Parametro23 = FdeExonerado		
						*/
		
						$PrecioVenta = $InsVentaConcretada->VcoManoObra;
						$Importe = round($PrecioVenta * $Cantidad,2);
						
						$InsVentaConcretada->VcoValorVentaManoObra = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
						$InsVentaConcretada->VcoImpuestoManoObra = $Importe - $InsVentaConcretada->VcoValorVentaManoObra;
						
						$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						"MANO DE OBRA",
						NULL,
						$PrecioVenta,
						$Cantidad,
						$Importe,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s"),
						NULL,
						NULL,
						NULL,
						"S",
						NULL,
						NULL,
						
						NULL,
						NULL,
						NULL,
						
						"",
						$InsVentaConcretada->VcoValorVentaManoObra,
						$InsVentaConcretada->VcoImpuestoManoObra,
						0,
						2,
						2,
							
						2,
						0,
						
						""
						);
		
						$FacturaTotal += $InsVentaConcretada->VcoManoObra;
		
					}
			
					if(!empty($InsVentaConcretada->VcoId)){
						
						$_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						$InsVentaConcretada->VcoId,
						NULL,
						NULL,
						1,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s"),
						NULL,
						NULL,
						$InsVentaConcretada->VcoFecha,
						$InsVentaConcretada->VcoSubTipo
						);
					
					}
			
					
					$InsPago = new ClsPago();
		//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL)
					$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,$InsVentaConcretada->VdiId,NULL,NULL,NULL);
					$ArrPagos = $ResPago['Datos'];
						
					$TotalAbonado = 0;
									
					if(!empty($ArrPagos)){
						foreach($ArrPagos as $DatPago){
								
							if($DatPago->MonId == $InsFactura->MonId){//DOLARES
								
								if($InsFactura->MonId == $EmpresaMonedaId){
									$TotalAbonado += $DatPago->PagMonto;
								}else{
									$TotalAbonado += ($DatPago->PagMonto/$DatPago->PagTipoCambio);
								}
								
							}
								
						}
					}
					
					//deb($FacturaTotal." - ".$TotalAbonado);
					$InsFactura->FacAbono += $FacturaTotal - $TotalAbonado;
					
					
				}
				
			}
		}
		
		
	}
	
	
	
		
}

//
//function FncCargarOrdenVentaVehiculoDatos(){
//	
//	
//	global $GET_OvvId;
//	global $Identificador;
//	global $InsOrdenVentaVehiculo;
//	global $InsOrdenVentaVehiculo;
//	global $EmpresaMonedaId;
//	global $EmpresaImpuestoVenta;
//	global $EmpresaImpuestoSelectivo;
//	
//	global $InsFactura;
//	
//	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
//	
//	$InsOrdenVentaVehiculo->OvvId = $GET_OvvId;	
//	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();	
//
//	$InsFactura->OvvId = $InsOrdenVentaVehiculo->OvvId;
//	$InsFactura->CveId = $InsOrdenVentaVehiculo->CveId;
//	
//	$InsFactura->CliId = $InsOrdenVentaVehiculo->CliId;		
//	$InsFactura->CliNombre = $InsOrdenVentaVehiculo->CliNombre;
//	$InsFactura->CliApellidoPaterno = $InsOrdenVentaVehiculo->CliApellidoPaterno;
//	$InsFactura->CliApellidoMaterno = $InsOrdenVentaVehiculo->CliApellidoMaterno;
//	
//	$InsFactura->TdoId = $InsOrdenVentaVehiculo->TdoId;
//	$InsFactura->CliNumeroDocumento = $InsOrdenVentaVehiculo->CliNumeroDocumento;
//	$InsFactura->FacDireccion = $InsOrdenVentaVehiculo->CliDireccion." - ".$InsOrdenVentaVehiculo->CliDistrito." - ".$InsOrdenVentaVehiculo->CliProvincia." - ".$InsOrdenVentaVehiculo->CliDepartamento;
//	
//	$InsFactura->FacTelefono = $InsOrdenVentaVehiculo->CliTelefono;		
//	$InsFactura->FacIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;	
//	$InsFactura->FacEstado = 5;
//	
//	$InsOrdenVentaVehiculo->OvvObservacion = strip_tags($InsOrdenVentaVehiculo->OvvObservacion);
//	$InsFactura->FacObservacion = $InsOrdenVentaVehiculo->OvvObservacion.chr(13).date("d/m/Y H:i:s")." - Factura autogenerada de Ord. Ven. Veh.: ".$InsFactura->OvvId." / Prof. Veh: ".$InsFactura->CveId;
//	
//	$InsFactura->MonId = $InsOrdenVentaVehiculo->MonId;		
//	$InsFactura->FacTipoCambio = $InsOrdenVentaVehiculo->VcoTipoCambio;		
//
//	//$InsFactura->FacIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;		
//	$InsFactura->FacIncluyeImpuesto = 1;		
//	$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
//	$InsFactura->FacPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
//	
//	$InsFactura->FacVendedor = $InsOrdenVentaVehiculo->UsuUsuario;	
//	$InsFactura->FacNumeroPedido = $InsOrdenVentaVehiculo->OvvId;	
//	
//	
//	if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId ){
//
//		$InsOrdenVentaVehiculo->OvvTotal = ($InsOrdenVentaVehiculo->OvvTotal  / $InsOrdenVentaVehiculo->OvvTipoCambio);
//		$InsOrdenVentaVehiculo->OvvSubTotal = ($InsOrdenVentaVehiculo->OvvSubTotal  / $InsOrdenVentaVehiculo->OvvTipoCambio);
//		$InsOrdenVentaVehiculo->OvvImpuesto = ($InsOrdenVentaVehiculo->OvvImpuesto  / $InsOrdenVentaVehiculo->OvvTipoCambio);
//
//	}
//
//
///*
//SesionObjeto-FacturaDetalleListado
//Parametro1 = FdeId
//Parametro2 = FdeDescripcion
//Parametro3
//Parametro4 = FdePrecio
//Parametro5 = FdeCantidad
//Parametro6 = FdeImporte
//Parametro7 = FdeTiempoCreacion
//Parametro8 = FdeTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 =
//Parametro12 = FdeTipo
//Parametro13 = FdeUnidadMedida
//Parametro14 = VcdReingreso
//
//Parametro15 = AmdId
//Parametro16 = FatId
//Parametro17 = OvvId
//
//Parametro18 = FdeCodigo
//Parametro19 = FdeValorVenta
//Parametro20 = FdeImpuesto
//Parametro21 = FdeDescuento
//Parametro22 = FdeGratuito
//Parametro23 = FdeExonerado
//
//Parametro24 = FdeIncluyeSelectivo
//Parametro25 = FdeImpuestoSelectivo
//Parametro26 = AmdCompraOrigen
//*/		
//		
//		
////		if($InsFactura->FacIncluyeImpuesto == 2){
////			$InsVentaConcretada->VcoManoObra = $InsVentaConcretada->VcoManoObra + ($InsOrdenVentaVehiculo->VcoManoObra * ($InsFactura->FacPorcentajeImpuestoVenta/100));
////		}
//				
//	$Cantidad = 1;
//	
//	if($InsOrdenVentaVehiculo->OvvIncluyeImpuesto == 2){				
//		$InsOrdenVentaVehiculo->OvvTotal = $InsOrdenVentaVehiculo->OvvTotal + ($InsOrdenVentaVehiculo->OvvTotal * ($InsFactura->FacPorcentajeImpuestoVenta/100));
//	}
//				
//	$PrecioVenta = $InsOrdenVentaVehiculo->OvvTotal;
//	$Importe = round($PrecioVenta * $Cantidad,2);
//	
//	$InsOrdenVentaVehiculo->OvvValorVenta = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
//	$InsOrdenVentaVehiculo->OvvImpuesto = $Importe  - $DatVentaConcretadaDetalle->OvvValorVenta;
//						
////	if($InsFactura->FacIncluyeImpuesto == 1){
////		$InsOrdenVentaVehiculo->OvvValorVenta = $InsOrdenVentaVehiculo->OvvTotal /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
////		$InsOrdenVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvTotal - $InsOrdenVentaVehiculo->OvvValorVenta;
////	}else{
////		$InsOrdenVentaVehiculo->OvvValorVenta = $InsOrdenVentaVehiculo->OvvTotal;
////		$InsOrdenVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvValorVenta * ($InsFactura->FacPorcentajeImpuestoVenta/100);
////	}
//
////	$ValorVenta = $InsOrdenVentaVehiculo->OvvTotal;
////	$Importe = $ValorVenta;
//	
//	
//	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){
//
//		$aux = 0;
//		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){			
//			if($DatOrdenVentaVehiculoObsequio->ObsUso == 2){
//				$aux++;
//			}
//		}
//		
//		if(!empty($aux)){
//			
//			$Obsequios = "| ACCESORIOS: ";
//			$o = 1;
//			foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){
//				
//				if($DatOrdenVentaVehiculoObsequio->ObsUso == 2){
//				
//					$Obsequios .= ($o==count($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)?" y ":"").$DatOrdenVentaVehiculoObsequio->ObsNombre.($o==count($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)?"":", ");
//					
//				}
//					
//				$o++;
//			}
//		
//		}
//		
//	}
//	
//	
//	
///*
//SesionObjeto-FacturaDetalleListado
//Parametro1 = FdeId
//Parametro2 = FdeDescripcion
//Parametro3
//Parametro4 = FdePrecio
//Parametro5 = FdeCantidad
//Parametro6 = FdeImporte
//Parametro7 = FdeTiempoCreacion
//Parametro8 = FdeTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 =
//Parametro12 = FdeTipo
//Parametro13 = FdeUnidadMedida
//Parametro14 = VcdReingreso
//
//Parametro15 = AmdId
//Parametro16 = FatId
//Parametro17 = OvvId
//
//Parametro18 = FdeCodigo
//Parametro19 = FdeValorVenta
//Parametro20 = FdeImpuesto
//Parametro21 = FdeDescuento
//Parametro22 = FdeGratuito
//Parametro23 = FdeExonerado
//
//Parametro24 = FdeIncluyeSelectivo
//Parametro25 = FdeImpuestoSelectivo
//Parametro26 = AmdCompraOrigen
//*/		
//
//	$InsFactura->FacObservacionImpresa = "".$Obsequios;
//
//	$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//	NULL,
//	$InsOrdenVentaVehiculo->VmaNombre." ".$InsOrdenVentaVehiculo->VmoNombre." ".$InsOrdenVentaVehiculo->VveNombre,
//	NULL,
//	$PrecioVenta,
//	$Cantidad,
//	$Importe,
//	date("d/m/Y H:i:s"),
//	date("d/m/Y H:i:s"),
//	NULL,
//	NULL,
//	NULL,
//	"V",
//	"Unidad",
//	NULL,
//	
//	NULL,
//	NULL,
//	$InsOrdenVentaVehiculo->OvvId,
//	"",
//	$InsOrdenVentaVehiculo->OvvValorVenta,
//	$InsOrdenVentaVehiculo->OvvImpuesto,
//	0,
//	2,
//	2,
//	
//	2,
//	0,
//	""
//	);
//	
//	if(!empty(	$InsOrdenVentaVehiculo->OvvId)){
//		
//		$_SESSION['InsFacturaDatoAdicional1'.$Identificador] = $InsOrdenVentaVehiculo->VmaNombre;
//		$_SESSION['InsFacturaDatoAdicional2'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica7)?$InsOrdenVentaVehiculo->EinCaracteristica7:$InsOrdenVentaVehiculo->VveCaracteristica7);
//
//		$_SESSION['InsFacturaDatoAdicional3'.$Identificador] = (empty($InsOrdenVentaVehiculo->EinNombre)?$InsOrdenVentaVehiculo->VmoNombre:$InsOrdenVentaVehiculo->EinNombre);
//		$_SESSION['InsFacturaDatoAdicional4'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica8)?$InsOrdenVentaVehiculo->EinCaracteristica8:$InsOrdenVentaVehiculo->VveCaracteristica8);
//
//		$_SESSION['InsFacturaDatoAdicional5'.$Identificador] = $InsOrdenVentaVehiculo->EinAnoFabricacion;
//		$_SESSION['InsFacturaDatoAdicional6'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica9)?$InsOrdenVentaVehiculo->EinCaracteristica9:$InsOrdenVentaVehiculo->VveCaracteristica9);
//
//		$_SESSION['InsFacturaDatoAdicional7'.$Identificador] = $InsOrdenVentaVehiculo->EinNumeroMotor;
//		$_SESSION['InsFacturaDatoAdicional8'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica10)?$InsOrdenVentaVehiculo->EinCaracteristica10:$InsOrdenVentaVehiculo->VveCaracteristica10);
//
//		$_SESSION['InsFacturaDatoAdicional9'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica1)?$InsOrdenVentaVehiculo->EinCaracteristica1:$InsOrdenVentaVehiculo->VveCaracteristica1);
//		$_SESSION['InsFacturaDatoAdicional10'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica11)?$InsOrdenVentaVehiculo->EinCaracteristica11:$InsOrdenVentaVehiculo->VveCaracteristica11);
//
//		$_SESSION['InsFacturaDatoAdicional11'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica2)?$InsOrdenVentaVehiculo->EinCaracteristica2:$InsOrdenVentaVehiculo->VveCaracteristica2);
//		$_SESSION['InsFacturaDatoAdicional12'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica12)?$InsOrdenVentaVehiculo->EinCaracteristica12:$InsOrdenVentaVehiculo->VveCaracteristica12);
//
//		$_SESSION['InsFacturaDatoAdicional13'.$Identificador] = $InsOrdenVentaVehiculo->EinVIN;
//		$_SESSION['InsFacturaDatoAdicional14'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica13)?$InsOrdenVentaVehiculo->EinCaracteristica13:$InsOrdenVentaVehiculo->VveCaracteristica13);
//
//		$_SESSION['InsFacturaDatoAdicional15'.$Identificador] = $InsOrdenVentaVehiculo->EinColor;
//		$_SESSION['InsFacturaDatoAdicional16'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica14)?$InsOrdenVentaVehiculo->EinCaracteristica14:$InsOrdenVentaVehiculo->VveCaracteristica14);
//
//	
//		$_SESSION['InsFacturaDatoAdicional17'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica3)?$InsOrdenVentaVehiculo->EinCaracteristica3:$InsOrdenVentaVehiculo->VveCaracteristica3);
//		$_SESSION['InsFacturaDatoAdicional18'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica15)?$InsOrdenVentaVehiculo->EinCaracteristica15:$InsOrdenVentaVehiculo->VveCaracteristica15);
//		
//		$_SESSION['InsFacturaDatoAdicional19'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica4)?$InsOrdenVentaVehiculo->EinCaracteristica4:$InsOrdenVentaVehiculo->VveCaracteristica4);
//		$_SESSION['InsFacturaDatoAdicional20'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica16)?$InsOrdenVentaVehiculo->EinCaracteristica16:$InsOrdenVentaVehiculo->VveCaracteristica16);
//		
//		$_SESSION['InsFacturaDatoAdicional21'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica5)?$InsOrdenVentaVehiculo->EinCaracteristica5:$InsOrdenVentaVehiculo->VveCaracteristica5);
//		$_SESSION['InsFacturaDatoAdicional22'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica17)?$InsOrdenVentaVehiculo->EinCaracteristica17:$InsOrdenVentaVehiculo->VveCaracteristica17);
//		
//		$_SESSION['InsFacturaDatoAdicional23'.$Identificador] = $InsOrdenVentaVehiculo->EinDUA;
//		
//		$_SESSION['InsFacturaDatoAdicional24'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica18)?$InsOrdenVentaVehiculo->EinCaracteristica18:$InsOrdenVentaVehiculo->VveCaracteristica18);
//		
//		$_SESSION['InsFacturaDatoAdicional25'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica19)?$InsOrdenVentaVehiculo->EinCaracteristica19:$InsOrdenVentaVehiculo->VveCaracteristica19);
//		
//		$_SESSION['InsFacturaDatoAdicional26'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica20)?$InsOrdenVentaVehiculo->EinCaracteristica20:$InsOrdenVentaVehiculo->VveCaracteristica20);
//				
//	}
//	
//	
//	
////	deb($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio);
////	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){
////		
////		$Obsequios = "ACCESORIOS: ";
////		$o = 1;
////		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){
////			
////			if($DatOrdenVentaVehiculoObsequio->ObsUso == 2){
////			
////				$Obsequios .= ($o==count($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)?" y ":"").$DatOrdenVentaVehiculoObsequio->ObsNombre.($o==count($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)?"":", ");
////				
////			}
////				
////			$o++;
////		}
////		
////		if(trim($Obsequios) <>  "ACCESORIOS:"){
////		
/////*
////SesionObjeto-FacturaDetalleListado
////Parametro1 = FdeId
////Parametro2 = FdeDescripcion
////Parametro3
////Parametro4 = FdePrecio
////Parametro5 = FdeCantidad
////Parametro6 = FdeImporte
////Parametro7 = FdeTiempoCreacion
////Parametro8 = FdeTiempoModificacion
////Parametro9 = AmdId
////Parametro10 = AmoId
////Parametro11 =
////Parametro12 = FdeTipo
////Parametro13 = FdeUnidadMedida
////Parametro14 = VcdReingreso
////
////Parametro15 = AmdId
////Parametro16 = FatId
////Parametro17 = OvvId
////
////Parametro18 = FdeCodigo
////Parametro19 = FdeValorVenta
////Parametro20 = FdeImpuesto
////Parametro21 = FdeDescuento
////Parametro22 = FdeGratuito
////Parametro23 = FdeExonerado	
////*/
////			$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
////			NULL,
////			$Obsequios,
////			NULL,
////			0,
////			0,
////			0,
////			date("d/m/Y H:i:s"),
////			date("d/m/Y H:i:s"),
////			NULL,
////			NULL,
////			NULL,
////			"T",
////			"",
////			NULL,
////			
////			NULL,
////			NULL,
////				$InsOrdenVentaVehiculo->OvvId,
////				"",
////				0,
////				0,
////				0,
////				2,
////				2	
////			);	
////		}
////		
////	}
//	
//	
//	//if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){
////		
////		$Obsequios = "OBSEQUIOS: ";
////		$o = 1;
////		
////		$Obsequios .= "".$InsOrdenVentaVehiculo->OvvObsequiOtro;
////		
////		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){
////			
////			if($DatOrdenVentaVehiculoObsequio->ObsUso == 1){
////			
////				$Obsequios .= ($o==count($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)?" y ":"").$DatOrdenVentaVehiculoObsequio->ObsNombre.($o==count($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)?"":", ");
////				
////			}
////				
////			$o++;
////		}
////		
////		if(trim($Obsequios) <>  "OBSEQUIOS:"){
////		
/////*
////SesionObjeto-FacturaDetalleListado
////Parametro1 = FdeId
////Parametro2 = FdeDescripcion
////Parametro3
////Parametro4 = FdePrecio
////Parametro5 = FdeCantidad
////Parametro6 = FdeImporte
////Parametro7 = FdeTiempoCreacion
////Parametro8 = FdeTiempoModificacion
////Parametro9 = AmdId
////Parametro10 = AmoId
////Parametro11 =
////Parametro12 = FdeTipo
////Parametro13 = FdeUnidadMedida
////Parametro14 = VcdReingreso
////
////Parametro15 = AmdId
////Parametro16 = FatId
////Parametro17 = OvvId
////*/
////			$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
////			NULL,
////			$Obsequios,
////			NULL,
////			0,
////			0,
////			0,
////			date("d/m/Y H:i:s"),
////			date("d/m/Y H:i:s"),
////			NULL,
////			NULL,
////			NULL,
////			"T",
////			"",
////			NULL,
////			
////			NULL,
////			NULL,
////			$InsOrdenVentaVehiculo->OvvId
////			);	
////		}
//		
////	}
//	
//	
//	
//}
//




function FncCargarVehiculoMovimientoSalidaDatos(){
	
	
	global $GET_VmvId;
	
	global $Identificador;
	global $InsOrdenVentaVehiculo;
	global $InsVehiculoMovimientoSalida;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;
	global $EmpresaImpuestoSelectivo;
	global $CorreosNotificacionBienvenida;
	
	global $InsFactura;
	
	$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();
	$InsVehiculoMovimientoSalida->VmvId = $GET_VmvId;	
	$InsVehiculoMovimientoSalida->MtdObtenerVehiculoMovimientoSalida();
	

	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
	$InsOrdenVentaVehiculo->OvvId = $InsVehiculoMovimientoSalida->OvvId;	
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();	


	
	
	
	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
	$InsOrdenVentaVehiculo->OvvId = $InsVehiculoMovimientoSalida->OvvId;
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
	
				
						
	if(!empty($InsOrdenVentaVehiculo->PerId)){
		
		$InsPersonal = new ClsPersonal();
		$InsPersonal->PerId = $InsOrdenVentaVehiculo->PerId;
		$InsPersonal->MtdObtenerPersonal();
	
	}
	
	$EmailPersonal = "";
	$EmailPersonal = $CorreosNotificacionBienvenida.",";
	
	if(!empty($InsPersonal->PerEmail)){
		
		$EmailPersonal .= trim($InsPersonal->PerEmail).",";
		
	}	
	
	if(!empty($InsOrdenVentaVehiculo->CliEmail)){
		
		$EmailPersonal .= trim($InsOrdenVentaVehiculo->CliEmail).",";
		
	}

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";		
echo "EmailPersonal: ";
echo $EmailPersonal;
echo "<br>";




//	deb($InsVehiculoMovimientoSalida->OvvId);
	$InsFactura->OvvId = $InsOrdenVentaVehiculo->OvvId;
	$InsFactura->CveId = $InsOrdenVentaVehiculo->CveId;
	
	$InsFactura->CliId = $InsOrdenVentaVehiculo->CliId;		
	$InsFactura->CliNombre = $InsOrdenVentaVehiculo->CliNombre;
	$InsFactura->CliApellidoPaterno = $InsOrdenVentaVehiculo->CliApellidoPaterno;
	$InsFactura->CliApellidoMaterno = $InsOrdenVentaVehiculo->CliApellidoMaterno;
	$InsFactura->CliEmail = $InsOrdenVentaVehiculo->CliEmail;
	
	$InsFactura->TdoId = $InsOrdenVentaVehiculo->TdoId;
	$InsFactura->CliNumeroDocumento = $InsOrdenVentaVehiculo->CliNumeroDocumento;
	$InsFactura->FacDireccion = $InsOrdenVentaVehiculo->CliDireccion." - ".$InsOrdenVentaVehiculo->CliDistrito." - ".$InsOrdenVentaVehiculo->CliProvincia." - ".$InsOrdenVentaVehiculo->CliDepartamento;
	
	$InsFactura->FacTelefono = $InsOrdenVentaVehiculo->CliTelefono;		
	$InsFactura->FacIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;	
	$InsFactura->FacEstado = 5;
	$InsFactura->FacObservado = 2;
	
	$InsOrdenVentaVehiculo->OvvObservacion = strip_tags($InsOrdenVentaVehiculo->OvvObservacion);
	$InsFactura->FacObservacion = $InsOrdenVentaVehiculo->OvvObservacion.chr(13).date("d/m/Y H:i:s")." - Factura autogenerada de Ord. Ven. Veh.: ".$InsFactura->OvvId." / Prof. Veh: ".$InsFactura->CveId;
	
	$InsFactura->MonId = $InsOrdenVentaVehiculo->MonId;		
	$InsFactura->FacTipoCambio = $InsOrdenVentaVehiculo->VcoTipoCambio;		

	//$InsFactura->FacIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;		
	$InsFactura->FacIncluyeImpuesto = 1;		
	$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsFactura->FacPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
	
	$InsFactura->FacVendedor = $InsOrdenVentaVehiculo->UsuUsuario;	
	$InsFactura->FacNumeroPedido = $InsOrdenVentaVehiculo->OvvId;	
	
	if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId ){

		$InsOrdenVentaVehiculo->OvvTotal = ($InsOrdenVentaVehiculo->OvvTotal  / $InsOrdenVentaVehiculo->OvvTipoCambio);
		$InsOrdenVentaVehiculo->OvvSubTotal = ($InsOrdenVentaVehiculo->OvvSubTotal  / $InsOrdenVentaVehiculo->OvvTipoCambio);
		$InsOrdenVentaVehiculo->OvvImpuesto = ($InsOrdenVentaVehiculo->OvvImpuesto  / $InsOrdenVentaVehiculo->OvvTipoCambio);

	}


/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro3
Parametro4 = FdePrecio
Parametro5 = FdeCantidad
Parametro6 = FdeImporte
Parametro7 = FdeTiempoCreacion
Parametro8 = FdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FdeTipo
Parametro13 = FdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = FdeCodigo
Parametro19 = FdeValorVenta
Parametro20 = FdeImpuesto
Parametro21 = FdeDescuento
Parametro22 = FdeGratuito
Parametro23 = FdeExonerado

Parametro24 = FdeIncluyeSelectivo
Parametro25 = FdeImpuestoSelectivo
*/		
		
		
//		if($InsFactura->FacIncluyeImpuesto == 2){
//			$InsVentaConcretada->VcoManoObra = $InsVentaConcretada->VcoManoObra + ($InsOrdenVentaVehiculo->VcoManoObra * ($InsFactura->FacPorcentajeImpuestoVenta/100));
//		}
				
	$Cantidad = 1;
	
	if($InsOrdenVentaVehiculo->OvvIncluyeImpuesto == 2){				
		$InsOrdenVentaVehiculo->OvvTotal = $InsOrdenVentaVehiculo->OvvTotal + ($InsOrdenVentaVehiculo->OvvTotal * ($InsFactura->FacPorcentajeImpuestoVenta/100));
	}
				
	$PrecioVenta = $InsOrdenVentaVehiculo->OvvTotal;
	$Importe = round($PrecioVenta * $Cantidad,2);
	
	$InsOrdenVentaVehiculo->OvvValorVenta = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
	$InsOrdenVentaVehiculo->OvvImpuesto = $Importe  - $InsOrdenVentaVehiculo->OvvValorVenta;
						
//	if($InsFactura->FacIncluyeImpuesto == 1){
//		$InsOrdenVentaVehiculo->OvvValorVenta = $InsOrdenVentaVehiculo->OvvTotal /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
//		$InsOrdenVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvTotal - $InsOrdenVentaVehiculo->OvvValorVenta;
//	}else{
//		$InsOrdenVentaVehiculo->OvvValorVenta = $InsOrdenVentaVehiculo->OvvTotal;
//		$InsOrdenVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvValorVenta * ($InsFactura->FacPorcentajeImpuestoVenta/100);
//	}

//	$ValorVenta = $InsOrdenVentaVehiculo->OvvTotal;
//	$Importe = $ValorVenta;
	
	
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){

		$aux = 0;
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){			
			if($DatOrdenVentaVehiculoObsequio->ObsUso == 2){
				$aux++;
			}
		}
		
		if(!empty($aux)){
			
			$Obsequios = "| ACCESORIOS: ";
			$o = 1;
			foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){
				
				if($DatOrdenVentaVehiculoObsequio->ObsUso == 2){
				
					$Obsequios .= ($o==count($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)?" y ":"").$DatOrdenVentaVehiculoObsequio->ObsNombre.($o==count($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)?"":", ");
					
				}
					
				$o++;
			}
		
		}
		
	}
	
	
	
/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro3
Parametro4 = FdePrecio
Parametro5 = FdeCantidad
Parametro6 = FdeImporte
Parametro7 = FdeTiempoCreacion
Parametro8 = FdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FdeTipo
Parametro13 = FdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = FdeCodigo
Parametro19 = FdeValorVenta
Parametro20 = FdeImpuesto
Parametro21 = FdeDescuento
Parametro22 = FdeGratuito
Parametro23 = FdeExonerado

Parametro24 = FdeIncluyeSelectivo
Parametro25 = FdeImpuestoSelectivo
Parametro26 = VmdId
*/		

	$VehiculoMovimientoSalidaDetalleId = "";
	$VehiculoCodigoIdentificador = "";
	
	if(!empty($InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle)){
		foreach($InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle as $DatVehiculoMovimientoSalidaDetalle){
			$VehiculoMovimientoSalidaDetalleId = $DatVehiculoMovimientoSalidaDetalle->VmdId;
			$VehiculoCodigoIdentificador = $DatVehiculoMovimientoSalidaDetalle->VehCodigoIdentificador;
		}
	}

	$InsFactura->FacObservacionImpresa = "".$Obsequios;

	$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
	NULL,
	$InsOrdenVentaVehiculo->VmaNombre." ".$InsOrdenVentaVehiculo->VmoNombre." ".$InsOrdenVentaVehiculo->VveNombre." ",
	NULL,
	$PrecioVenta,
	$Cantidad,
	$Importe,
	date("d/m/Y H:i:s"),
	date("d/m/Y H:i:s"),
	NULL,
	NULL,
	NULL,
	"V",
	"UND",
	NULL,
	
	NULL,
	NULL,
	$InsOrdenVentaVehiculo->OvvId,
	$VehiculoCodigoIdentificador,
	$InsOrdenVentaVehiculo->OvvValorVenta,
	$InsOrdenVentaVehiculo->OvvImpuesto,
	0,
	2,
	2,
	
	2,
	0,
	
	$VehiculoMovimientoSalidaDetalleId
	);
	
	if(!empty(	$InsOrdenVentaVehiculo->OvvId)){
		
		$_SESSION['InsFacturaDatoAdicional1'.$Identificador] = $InsOrdenVentaVehiculo->VmaNombre;
		$_SESSION['InsFacturaDatoAdicional2'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica7)?$InsOrdenVentaVehiculo->EinCaracteristica7:$InsOrdenVentaVehiculo->VveCaracteristica7);

		$_SESSION['InsFacturaDatoAdicional3'.$Identificador] = (empty($InsOrdenVentaVehiculo->EinNombre)?$InsOrdenVentaVehiculo->VmoNombre:$InsOrdenVentaVehiculo->EinNombre);
		$_SESSION['InsFacturaDatoAdicional4'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica8)?$InsOrdenVentaVehiculo->EinCaracteristica8:$InsOrdenVentaVehiculo->VveCaracteristica8);

		$_SESSION['InsFacturaDatoAdicional5'.$Identificador] = $InsOrdenVentaVehiculo->EinAnoFabricacion;
		//$_SESSION['InsFacturaDatoAdicional5'.$Identificador] = $InsOrdenVentaVehiculo->EinAnoModelo;
		$_SESSION['InsFacturaDatoAdicional27'.$Identificador] = $InsOrdenVentaVehiculo->EinAnoModelo;
		
		
		$_SESSION['InsFacturaDatoAdicional6'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica9)?$InsOrdenVentaVehiculo->EinCaracteristica9:$InsOrdenVentaVehiculo->VveCaracteristica9);

		$_SESSION['InsFacturaDatoAdicional7'.$Identificador] = $InsOrdenVentaVehiculo->EinNumeroMotor;
		$_SESSION['InsFacturaDatoAdicional8'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica10)?$InsOrdenVentaVehiculo->EinCaracteristica10:$InsOrdenVentaVehiculo->VveCaracteristica10);

		$_SESSION['InsFacturaDatoAdicional9'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica1)?$InsOrdenVentaVehiculo->EinCaracteristica1:$InsOrdenVentaVehiculo->VveCaracteristica1);
		$_SESSION['InsFacturaDatoAdicional10'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica11)?$InsOrdenVentaVehiculo->EinCaracteristica11:$InsOrdenVentaVehiculo->VveCaracteristica11);

		$_SESSION['InsFacturaDatoAdicional11'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica2)?$InsOrdenVentaVehiculo->EinCaracteristica2:$InsOrdenVentaVehiculo->VveCaracteristica2);
		$_SESSION['InsFacturaDatoAdicional12'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica12)?$InsOrdenVentaVehiculo->EinCaracteristica12:$InsOrdenVentaVehiculo->VveCaracteristica12);

		$_SESSION['InsFacturaDatoAdicional13'.$Identificador] = $InsOrdenVentaVehiculo->EinVIN;
		$_SESSION['InsFacturaDatoAdicional14'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica13)?$InsOrdenVentaVehiculo->EinCaracteristica13:$InsOrdenVentaVehiculo->VveCaracteristica13);

		$_SESSION['InsFacturaDatoAdicional15'.$Identificador] = $InsOrdenVentaVehiculo->EinColor;
		$_SESSION['InsFacturaDatoAdicional16'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica14)?$InsOrdenVentaVehiculo->EinCaracteristica14:$InsOrdenVentaVehiculo->VveCaracteristica14);

	
		$_SESSION['InsFacturaDatoAdicional17'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica3)?$InsOrdenVentaVehiculo->EinCaracteristica3:$InsOrdenVentaVehiculo->VveCaracteristica3);
		$_SESSION['InsFacturaDatoAdicional18'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica15)?$InsOrdenVentaVehiculo->EinCaracteristica15:$InsOrdenVentaVehiculo->VveCaracteristica15);
		
		$_SESSION['InsFacturaDatoAdicional19'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica4)?$InsOrdenVentaVehiculo->EinCaracteristica4:$InsOrdenVentaVehiculo->VveCaracteristica4);
		$_SESSION['InsFacturaDatoAdicional20'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica16)?$InsOrdenVentaVehiculo->EinCaracteristica16:$InsOrdenVentaVehiculo->VveCaracteristica16);
		
		$_SESSION['InsFacturaDatoAdicional21'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica5)?$InsOrdenVentaVehiculo->EinCaracteristica5:$InsOrdenVentaVehiculo->VveCaracteristica5);
		$_SESSION['InsFacturaDatoAdicional22'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica17)?$InsOrdenVentaVehiculo->EinCaracteristica17:$InsOrdenVentaVehiculo->VveCaracteristica17);
		
		$_SESSION['InsFacturaDatoAdicional23'.$Identificador] = $InsOrdenVentaVehiculo->EinDUA;
		
		$_SESSION['InsFacturaDatoAdicional24'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica18)?$InsOrdenVentaVehiculo->EinCaracteristica18:$InsOrdenVentaVehiculo->VveCaracteristica18);
		
		$_SESSION['InsFacturaDatoAdicional25'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica19)?$InsOrdenVentaVehiculo->EinCaracteristica19:$InsOrdenVentaVehiculo->VveCaracteristica19);
		
		$_SESSION['InsFacturaDatoAdicional26'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica20)?$InsOrdenVentaVehiculo->EinCaracteristica20:$InsOrdenVentaVehiculo->VveCaracteristica20);
		
		$_SESSION['InsFacturaDatoAdicional27'.$Identificador] = ($InsOrdenVentaVehiculo->EinAnoModelo);
	
		$_SESSION['InsFacturaDatoAdicional28'.$Identificador] = "";
				
	}
	
	if(!empty($InsVehiculoMovimientoSalida->VmvId)){
						
//SesionObjeto-FacturaAlmacenMovimiento
//Parametro1 = BamId
//Parametro2 = AmoId
//Parametro3 = 
//Parametro4 = 
//Parametro5 = BamEstado
//Parametro6 = BamTiempoCreacion
//Parametro7 = BamTiempoModificacion
//Parametro8 = FinId
//Parametro9 = FccId
//Parametro10 = AmoFecha
//Parametro11 = AmoSubTipo
//Parametro12 = VmvId
//Parametro13 = VmvFecha
//Parametro14 = VmvSubTipo

						$_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
						NULL,
						NULL,
						NULL,
						NULL,
						1,
						date("d/m/Y H:i:s"),
						date("d/m/Y H:i:s"),
						NULL,
						NULL,
						NULL,
						NULL,
						$InsVehiculoMovimientoSalida->VmvId,
						$InsVehiculoMovimientoSalida->VmvFecha,
						$InsVehiculoMovimientoSalida->VmvSubTipo
						);
					
					}
	

}




function FncCargarPago(){
	

	global $GET_PagId;
	
	global $Identificador;
	global $InsOrdenVentaVehiculo;
	global $InsPago;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;
	global $EmpresaImpuestoSelectivo;
	
	global $InsFactura;
	
	$InsPago->PagId = $GET_PagId;
	$InsPago->MtdObtenerPago();		
	
	if($InsPago->MonId<>$EmpresaMonedaId ){
		$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
	}
	
	
	$InsFactura->PagId = $InsPago->PagId;
	
	$InsFactura->CliId = $InsPago->CliId;		
	$InsFactura->CliNombre = $InsPago->CliNombre;
	$InsFactura->CliApellidoPaterno = $InsPago->CliApellidoPaterno;
	$InsFactura->CliApellidoMaterno = $InsPago->CliApellidoMaterno;
	
	$InsFactura->TdoId = $InsPago->TdoId;
	$InsFactura->CliNumeroDocumento = $InsPago->CliNumeroDocumento;
	$InsFactura->FacDireccion = $InsPago->CliDireccion." - ".$InsPago->CliDistrito." - ".$InsPago->CliProvincia." - ".$InsPago->CliDepartamento;
	
	$InsFactura->FacTelefono = $InsPago->CliTelefono;		
	$InsFactura->FacIncluyeImpuesto = 1;	
	$InsFactura->FacEstado = 5;
	$InsFactura->FacObservado = 2;
	
	$InsOrdenVentaVehiculo->OvvObservacion = strip_tags($InsPago->PagObservacion);
	$InsFactura->FacObservacion = $InsPago->PagObservacion.chr(13).date("d/m/Y H:i:s")." - Factura autogenerada de Pago: ".$InsFactura->PagId;
	$InsFactura->FacObservacionImpresa = "En caso desista de la compra, se retendrá el 50% del valor total por gastos operativos generados";
	
	$InsFactura->MonId = $InsPago->MonId;		
	$InsFactura->FacTipoCambio = $InsPago->PagTipoCambio;		

	//$InsFactura->FacIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;		
	$InsFactura->FacIncluyeImpuesto = 1;		
	$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsFactura->FacPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
	

	$NumeroPedido = "";
	
	if(!empty($InsPago->PagoComprobante)){
		
		foreach($InsPago->PagoComprobante as $DatPagoComprobante){
			
			$OrdenVentaVehiculoId = $DatPagoComprobante->OvvId;
			$VentaDirectaId = $DatPagoComprobante->VdiId;
			
		}
		
	}
	
	$NumeroPedido = $OrdenVentaVehiculoId."".$VentaDirectaId;
	
	$InsFactura->FacVendedor = "";	
	$InsFactura->FacNumeroPedido = $NumeroPedido ;	
	

/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro3
Parametro4 = FdePrecio
Parametro5 = FdeCantidad
Parametro6 = FdeImporte
Parametro7 = FdeTiempoCreacion
Parametro8 = FdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FdeTipo
Parametro13 = FdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = FdeCodigo
Parametro19 = FdeValorVenta
Parametro20 = FdeImpuesto
Parametro21 = FdeDescuento
Parametro22 = FdeGratuito
Parametro23 = FdeExonerado

Parametro24 = FdeIncluyeSelectivo
Parametro25 = FdeImpuestoSelectivo
*/		
		
			
	$Cantidad = 1;
		
	$PrecioVenta = $InsPago->PagMonto;
	$Importe = round($PrecioVenta * $Cantidad,2);
	
	$ValorVenta = $Importe /((($InsFactura->FacPorcentajeImpuestoVenta)/100)+1);
	$Impuesto = $Importe  - $ValorVenta;
						

/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro3
Parametro4 = FdePrecio
Parametro5 = FdeCantidad
Parametro6 = FdeImporte
Parametro7 = FdeTiempoCreacion
Parametro8 = FdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FdeTipo
Parametro13 = FdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = FdeCodigo
Parametro19 = FdeValorVenta
Parametro20 = FdeImpuesto
Parametro21 = FdeDescuento
Parametro22 = FdeGratuito
Parametro23 = FdeExonerado

Parametro24 = FdeIncluyeSelectivo
Parametro25 = FdeImpuestoSelectivo
Parametro26 = VmdId
*/		

	
	$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
	NULL,
	"Adelanto de pedido de orden ".$NumeroPedido." / PagId: ".$InsPago->PagId,
	NULL,
	$PrecioVenta,
	$Cantidad,
	$Importe,
	date("d/m/Y H:i:s"),
	date("d/m/Y H:i:s"),
	NULL,
	NULL,
	NULL,
	"S",
	"ZZ",
	NULL,
	
	NULL,
	NULL,
	NULL,
	NULL,
	$ValorVenta,
	$Impuesto,
	0,
	2,
	2,
	
	2,
	0,
	
	NULL
	);
	
	
	
	

	
		
}

?>  