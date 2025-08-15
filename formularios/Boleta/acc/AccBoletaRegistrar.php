<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or ($_POST['Guardar'] ?? '')=="1"){	
	
	$Resultado = '';
	$Guardar = true;
	
	$InsBoleta->BolId = $_POST['CmpId'];
	$InsBoleta->SucId = $_SESSION['SesionSucursal'];
	$InsBoleta->UsuId = $_SESSION['SesionId'];

	
	$InsBoleta->BtaId = $_POST['CmpTalonario'];
	$InsBoleta->CliId = $_POST['CmpClienteId'];

	$InsBoleta->UsuId = $_SESSION['SesionId'];
	$InsBoleta->NpaId = $_POST['CmpCondicionPago'];	
	$InsBoleta->BolCantidadDia = isset($_POST['CmpCantidadDia'])?$_POST['CmpCantidadDia']:0;

	$InsBoleta->MonId = $_POST['CmpMonedaId'];
	$InsBoleta->BolTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsBoleta->BolAbono = preg_replace("/,/", "", (empty($_POST['CmpAbono'])?0:$_POST['CmpAbono']));
	$InsBoleta->BolObsequio = $_POST['CmpObsequio'];
	
	$InsBoleta->BolIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsBoleta->BolAbono = preg_replace("/,/", "", $_POST['CmpAbono']);
		
	$InsBoleta->BolEstado = $_POST['CmpEstado'];
	$InsBoleta->BolFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	//$InsBoleta->BolFechaVencimiento = FncCambiaFechaAMysql($_POST['CmpFechaVencimiento'],true);
	
	 $FechaVencimiento = NULL;
	 
	if($InsBoleta->BolCantidadDia>0){
		// $FechaVencimiento = date("d/m/Y",strtotime($_POST['CmpFechaEmision']." + ".$InsBoleta->BolCantidadDia." days"));
		$FechaVencimiento = strtotime('+'.$InsBoleta->BolCantidadDia.' day', strtotime($InsBoleta->BolFechaEmision));;
		$FechaVencimiento = date('d/m/Y', $FechaVencimiento);
	}
	
	$InsBoleta->BolFechaVencimiento = FncCambiaFechaAMysql($FechaVencimiento,true);
	 
	 
	 
	$InsBoleta->BolPorcentajeImpuestoVenta = ($_POST['CmpPorcentajeImpuestoVenta']);
	$InsBoleta->BolPorcentajeImpuestoSelectivo = ($_POST['CmpPorcentajeImpuestoSelectivo']);
	$InsBoleta->BolObservacion = $_POST['CmpObservacion']."###".$_POST['CmpObservacionImpresa'];
	$InsBoleta->BolObservacionCaja = addslashes($_POST['CmpObservacionCaja']);
	$InsBoleta->BolLeyenda = addslashes($_POST['CmpLeyenda']);
	
	$InsBoleta->BolUsuario =  $_SESSION['SesionUsuario'];
	$InsBoleta->BolObservado = $_POST['CmpObservado'];
	$InsBoleta->BolCierre = 1;
	$InsBoleta->BolTiempoCreacion = date("Y-m-d H:i:s");
	$InsBoleta->BolTiempoModificacion = date("Y-m-d H:i:s");
	$InsBoleta->BolEliminado = 1;
	
	$InsBoleta->CliNombre = $_POST['CmpClienteNombre'];
	$InsBoleta->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsBoleta->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsBoleta->CliTelefono = $_POST['CmpClienteTelefono'];
	$InsBoleta->CliEmail = $_POST['CmpClienteEmail'];
	$InsBoleta->CliCelular = $_POST['CmpClienteCelular'];
	$InsBoleta->CliFax = $_POST['CmpClienteFax'];

	$InsBoleta->BolDireccion = $_POST['CmpClienteDireccion'];	

	$InsBoleta->BolRegimenComprobanteNumero = $_POST['CmpRegimenComprobanteNumero'];
	$InsBoleta->BolRegimenComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpRegimenComprobanteFecha'],true);	
	$InsBoleta->RegId = $_POST['CmpRegimenId'];	
	$InsBoleta->RegAplicacion = $_POST['CmpRegimenAplicacion'];	
	$InsBoleta->BolRegimenPorcentaje = $_POST['CmpRegimenPorcentaje'];
	$InsBoleta->BolRegimenMonto = preg_replace("/,/", "", $_POST['CmpRegimenMonto']);
	
	if($InsBoleta->MonId<>$EmpresaMonedaId and !empty($InsBoleta->BolTipoCambio)){
		$InsBoleta->BolRegimenMonto = $InsBoleta->BolRegimenMonto * $InsBoleta->BolTipoCambio;
	}	

	$InsBoleta->FinId = $_POST['CmpFichaIngresoId'];
	$InsBoleta->AmoId = $_POST['CmpAlmacenMovimientoSalidaIdAux'];
	$InsBoleta->FccId = $_POST['CmpFichaAccionId'];
	$InsBoleta->VdiId = $_POST['CmpVentaDirectaId'];
	$InsBoleta->CprId = $_POST['CmpCotizacionProductoId'];

	$InsBoleta->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	$InsBoleta->CveId = $_POST['CmpCotizacionVehiculoId'];
	
	$InsBoleta->PagId = $_POST['CmpPagoId'];
	
	$InsBoleta->BolProcesar = $_POST['CmpProcesar'];
	$InsBoleta->BolEnviarSUNAT = $_POST['CmpEnviarSUNAT'];
	
	$InsBoleta->BolUsuario = $_POST['CmpUsuario'];
	$InsBoleta->BolVendedor = $_POST['CmpVendedor'];
	$InsBoleta->BolNumeroPedido = $_POST['CmpNumeroPedido'];
	
	$InsBoleta->BoletaDetalle = array();	

	if($InsBoleta->MonId<>$EmpresaMonedaId){
		if(empty($InsBoleta->BolTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_BOL_600';
		}
	}
	
	if(empty($InsBoleta->CliId)){
		$Guardar = false;
		$Resultado.='#ERR_BOL_123';
	}	
	
	if(!empty($InsBoleta->OvvId)){
		if(empty($InsBoleta->CliEmail)){
			$Guardar = false;
			$Resultado.='#ERR_BOL_124';
		}
	}	
	
	
	
	$InsBoleta->BolDatoAdicional1 = $_SESSION['InsBoletaDatoAdicional1'.$Identificador];
	$InsBoleta->BolDatoAdicional2 = $_SESSION['InsBoletaDatoAdicional2'.$Identificador];
	$InsBoleta->BolDatoAdicional3 = $_SESSION['InsBoletaDatoAdicional3'.$Identificador];
	$InsBoleta->BolDatoAdicional4 = $_SESSION['InsBoletaDatoAdicional4'.$Identificador];
	$InsBoleta->BolDatoAdicional5 = $_SESSION['InsBoletaDatoAdicional5'.$Identificador];
	$InsBoleta->BolDatoAdicional6 = $_SESSION['InsBoletaDatoAdicional6'.$Identificador];
	$InsBoleta->BolDatoAdicional7 = $_SESSION['InsBoletaDatoAdicional7'.$Identificador];
	$InsBoleta->BolDatoAdicional8 = $_SESSION['InsBoletaDatoAdicional8'.$Identificador];
	$InsBoleta->BolDatoAdicional9 = $_SESSION['InsBoletaDatoAdicional9'.$Identificador];
	$InsBoleta->BolDatoAdicional10 = $_SESSION['InsBoletaDatoAdicional10'.$Identificador];
	$InsBoleta->BolDatoAdicional11 = $_SESSION['InsBoletaDatoAdicional11'.$Identificador];
	$InsBoleta->BolDatoAdicional12 = $_SESSION['InsBoletaDatoAdicional12'.$Identificador];
	$InsBoleta->BolDatoAdicional13 = $_SESSION['InsBoletaDatoAdicional13'.$Identificador];
	$InsBoleta->BolDatoAdicional14 = $_SESSION['InsBoletaDatoAdicional14'.$Identificador];
	$InsBoleta->BolDatoAdicional15 = $_SESSION['InsBoletaDatoAdicional15'.$Identificador];
	$InsBoleta->BolDatoAdicional16 = $_SESSION['InsBoletaDatoAdicional16'.$Identificador];
	$InsBoleta->BolDatoAdicional17 = $_SESSION['InsBoletaDatoAdicional17'.$Identificador];
	$InsBoleta->BolDatoAdicional18 = $_SESSION['InsBoletaDatoAdicional18'.$Identificador];
	$InsBoleta->BolDatoAdicional19 = $_SESSION['InsBoletaDatoAdicional19'.$Identificador];
	$InsBoleta->BolDatoAdicional20 = $_SESSION['InsBoletaDatoAdicional20'.$Identificador];
	$InsBoleta->BolDatoAdicional21 = $_SESSION['InsBoletaDatoAdicional21'.$Identificador];
	$InsBoleta->BolDatoAdicional22 = $_SESSION['InsBoletaDatoAdicional22'.$Identificador];
	$InsBoleta->BolDatoAdicional23 = $_SESSION['InsBoletaDatoAdicional23'.$Identificador];
	$InsBoleta->BolDatoAdicional24 = $_SESSION['InsBoletaDatoAdicional24'.$Identificador];
	$InsBoleta->BolDatoAdicional25 = $_SESSION['InsBoletaDatoAdicional25'.$Identificador];
	$InsBoleta->BolDatoAdicional26 = $_SESSION['InsBoletaDatoAdicional26'.$Identificador];
	$InsBoleta->BolDatoAdicional27 = $_SESSION['InsBoletaDatoAdicional27'.$Identificador];
	$InsBoleta->BolDatoAdicional28 = $_SESSION['InsBoletaDatoAdicional28'.$Identificador];

	//PROPIETARIOS
	//$InsBoleta->BolDatoAdicional24 = $_SESSION['InsBoletaDatoAdicional24'.$Identificador];
	
	//OTROS DATOS
	//$InsBoleta->BolDatoAdicional25 = $_SESSION['InsBoletaDatoAdicional25'.$Identificador];
		
	/*
	SesionObjeto-BoletaDetalleListado
	Parametro1 = BdeId
	Parametro2 = BdeDescripcion
	Parametro3
	Parametro4 = BdePrecio
	Parametro5 = BdeCantidad
	Parametro6 = BdeImporte
	Parametro7 = BdeTiempoCreacion
	Parametro8 = BdeTiempoModificacion
	Parametro9 = AmdId
	Parametro10 = AmoId
	Parametro11 =
	Parametro12 = BdeTipo
	Parametro13 = BdeUnidadMedida
	Parametro14 = VcdReingreso
	Parametro15 = AmdId
	Parametro16 = FatId
	Parametro17 = OvvId
	
	Parametro18 = BdeCodigo
	Parametro19 = BdParametro20 = BdeImpuesto
	Parametro21 = BdeDescuentom
	Parametro22 = BdeGratuito
	Parametro23 = BdeExonerado					
	*/

	$InsBoleta->BolTotalBruto = 0;
	$InsBoleta->BolTotalGravado = 0;
	$InsBoleta->BolTotalExonerado = 0;
	$InsBoleta->BolTotalDescuento = 0;
	$InsBoleta->BolTotalGratuito = 0;
	$InsBoleta->BolTotalDescuentoNoExonerado = 0;
	$InsBoleta->BolTotalValorBruto = 0;
	$InsBoleta->BolTotalPagar= 0;
	$InsBoleta->BolTotalImpuestoSelectivo= 0;
	
	$InsBoleta->BolSubTotal = 0;
	$InsBoleta->BolImpuesto = 0;
	$InsBoleta->BolTotal = 0;


	$ResBoletaDetalle = $_SESSION['InsBoletaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResBoletaDetalle['Datos'])){
		foreach($ResBoletaDetalle['Datos'] as $DatSesionObjeto){
					
			if($InsBoleta->MonId<>$EmpresaMonedaId){
			
				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsBoleta->BolTipoCambio;
				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsBoleta->BolTipoCambio;

				$DatSesionObjeto->Parametro19 = $DatSesionObjeto->Parametro19 * $InsBoleta->BolTipoCambio;
				$DatSesionObjeto->Parametro20 = $DatSesionObjeto->Parametro20 * $InsBoleta->BolTipoCambio;
				$DatSesionObjeto->Parametro21 = $DatSesionObjeto->Parametro21 * $InsBoleta->BolTipoCambio;
				$DatSesionObjeto->Parametro25 = $DatSesionObjeto->Parametro25 * $InsBoleta->BolTipoCambio;

			}
			
			$InsBoletaDetalle1 = new ClsBoletaDetalle();
			$InsBoletaDetalle1->BdeId = $DatSesionObjeto->Parametro1;

			$InsBoletaDetalle1->AmdId = $DatSesionObjeto->Parametro15;	
			$InsBoletaDetalle1->VmdId = $DatSesionObjeto->Parametro26;	
			$InsBoletaDetalle1->FatId = $DatSesionObjeto->Parametro16;				
			$InsBoletaDetalle1->BdeTipo = $DatSesionObjeto->Parametro12;
	
			if($InsBoletaDetalle1->BdeTipo<>"T"){
				$InsBoletaDetalle1->BdeDescripcion = addslashes($DatSesionObjeto->Parametro2);	
			}else{
				$InsBoletaDetalle1->BdeDescripcion = addslashes((($DatSesionObjeto->Parametro2)));
			}

			$InsBoletaDetalle1->BdePrecio = $DatSesionObjeto->Parametro4;
			$InsBoletaDetalle1->BdeCantidad = $DatSesionObjeto->Parametro5;
			$InsBoletaDetalle1->BdeImporte = $DatSesionObjeto->Parametro6;
			
			$InsBoletaDetalle1->BdeValorVenta = $DatSesionObjeto->Parametro19;
			$InsBoletaDetalle1->BdeImpuesto = $DatSesionObjeto->Parametro20;
			$InsBoletaDetalle1->BdeDescuento = $DatSesionObjeto->Parametro21;
			$InsBoletaDetalle1->BdeImpuestoSelectivo = $DatSesionObjeto->Parametro25;
			
			//$InsBoletaDetalle1->BdeGratuito = $InsBoleta->BolObsequio ;
			$InsBoletaDetalle1->BdeGratuito = $DatSesionObjeto->Parametro22;
			$InsBoletaDetalle1->BdeExonerado = $DatSesionObjeto->Parametro23;			
			$InsBoletaDetalle1->BdeIncluyeSelectivo = $DatSesionObjeto->Parametro24;

			$InsBoletaDetalle1->BdeCodigo = $DatSesionObjeto->Parametro18;
			$InsBoletaDetalle1->BdeUnidadMedida = $DatSesionObjeto->Parametro13;

			$InsBoletaDetalle1->BdeTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsBoletaDetalle1->BdeTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsBoletaDetalle1->BdeEliminado = $DatSesionObjeto->Eliminado;
			$InsBoletaDetalle1->InsMysql = NULL;
					
			if($InsBoletaDetalle1->BdeEliminado==1){	
			
				$InsBoleta->BolTotalBruto += $InsBoletaDetalle1->BdeImporte;	
									
				//EXONERADO
				if($InsBoletaDetalle1->BdeExonerado == 1){						
					$InsBoleta->BolTotalExonerado += $InsBoletaDetalle1->BdeValorVenta;
				}
				
				//GRAVADO
				if($InsBoletaDetalle1->BdeExonerado == 2 and $InsBoletaDetalle1->BdeGratuito == 2){			
					$InsBoleta->BolTotalGravado += $InsBoletaDetalle1->BdeValorVenta;
				}
				
				//VALOR BRUTO
				if($InsBoletaDetalle1->BdeGratuito == 2){		
					$InsBoleta->BolTotalValorBruto += $InsBoletaDetalle1->BdeValorVenta;
				}
				
				//GRATUITO
				if($InsBoletaDetalle1->BdeGratuito == 1){			
					$InsBoleta->BolTotalGratuito += $InsBoletaDetalle1->BdeValorVenta;			
				}
				
				//INCLUYE SELECTIVO
				if($InsBoletaDetalle1->BdeIncluyeSelectivo == 1){			
					$InsBoleta->BolTotalImpuestoSelectivo += ($InsBoletaDetalle1->BdeImpuestoSelectivo);
				}		
				
				//TOTAL PAGAR								
				if($InsBoletaDetalle1->BdeGratuito == 2){	
					if($InsBoletaDetalle1->BdeExonerado == 2){
						//$InsBoleta->BolTotalPagar += ( ($InsBoletaDetalle1->BdeValorVenta - $InsBoletaDetalle1->BdeDescuento ) * ( ($InsBoleta->BolPorcentajeImpuestoVenta/100)+1) ) * ( (100 - $InsBoleta->BolPorcentajeDescuento)/100 ) ;
						$InsBoleta->BolTotalPagar += ( ($InsBoletaDetalle1->BdeValorVenta) * ( ($InsBoleta->BolPorcentajeImpuestoVenta/100)+1) ) * ( (100 - $InsBoleta->BolPorcentajeDescuento)/100 ) ;
					}else{
						//$InsBoleta->BolTotalPagar += ($InsBoletaDetalle1->BdeValorVenta - $InsBoletaDetalle1->BdeDescuento) * ( (100 - $InsBoleta->BolPorcentajeDescuento)/100 );	
						$InsBoleta->BolTotalPagar += ($InsBoletaDetalle1->BdeValorVenta) * ( (100 - $InsBoleta->BolPorcentajeDescuento)/100 );	
					}
				}
				
				$InsBoleta->BolTotalDescuento += $InsBoletaDetalle1->BdeDescuento;
				
				$InsBoleta->BoletaDetalle[] = $InsBoletaDetalle1;	
				
				
			}
						
		}	
		
	}/*else{
		$Guardar = false;
		$Resultado.='#ERR_BOL_603';
	}*/




						
//SesionObjeto-BoletaAlmacenMovimiento
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


	$ResBoletaAlmacenMovimiento = $_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdObtenerSesionObjetos(true);//OJO

	if(!empty($ResBoletaAlmacenMovimiento['Datos'])){	
		foreach($ResBoletaAlmacenMovimiento['Datos'] as $DatSesionObjeto){
						
			$InsBoletaAlmacenMovimiento1 = new ClsBoletaAlmacenMovimiento();
			$InsBoletaAlmacenMovimiento1->BamId = $DatSesionObjeto->Parametro1;	
				
			$InsBoletaAlmacenMovimiento1->AmoId = $DatSesionObjeto->Parametro2;		
			$InsBoletaAlmacenMovimiento1->VmvId = $DatSesionObjeto->Parametro12;		

			$InsBoletaAlmacenMovimiento1->BamEstado = $DatSesionObjeto->Parametro5;
			$InsBoletaAlmacenMovimiento1->BamTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro6);
			$InsBoletaAlmacenMovimiento1->BamTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			
			$InsBoletaAlmacenMovimiento1->BamEliminado = $DatSesionObjeto->Eliminado;				
			//$InsBoletaAlmacenMovimiento1->InsMysql = NULL;
			
			$InsBoleta->BoletaAlmacenMovimiento[] = $InsBoletaAlmacenMovimiento1;	
			
			
		}
	}
	
	//if($InsBoleta->BolPorcentajeDescuento>0){
//		
//		$InsBoleta->BolTotalExonerado = $InsBoleta->BolTotalExonerado - ($InsBoleta->BolTotalExonerado * ($InsBoleta->BolPorcentajeDescuento/100));
//		$InsBoleta->BolTotalGravado =  $InsBoleta->BolTotalGravado - ($InsBoleta->BolTotalGravado * ($InsBoleta->BolPorcentajeDescuento/100));
//		$InsBoleta->BolTotalDescuento = $InsBoleta->BolTotalDescuento + ($InsBoleta->BolTotalValorBruto * ($InsBoleta->BolPorcentajeDescuento/100));
//
//	}
//	
//	$InsBoleta->BolSubTotal = ($InsBoleta->BolTotalGravado);
//	$InsBoleta->BolImpuesto = ($InsBoleta->BolSubTotal * ($InsBoleta->BolPorcentajeImpuestoVenta/100));
//	$InsBoleta->BolTotal = ($InsBoleta->BolSubTotal + $InsBoleta->BolImpuesto + $InsBoleta->BolTotalExonerado);

	$InsBoleta->BolSubTotal = ($InsBoleta->BolTotalGravado);
	$InsBoleta->BolImpuesto = (($InsBoleta->BolSubTotal + $InsBoleta->BolTotalImpuestoSelectivo ) * ($InsBoleta->BolPorcentajeImpuestoVenta/100));
	$InsBoleta->BolTotal = ($InsBoleta->BolSubTotal+ $InsBoleta->BolTotalImpuestoSelectivo +  $InsBoleta->BolTotalExonerado + $InsBoleta->BolImpuesto);


		
	if(!empty($InsBoleta->RegId)){
		if($InsBoleta->RegAplicacion==1){
			$InsBoleta->BolTotalReal = $InsBoleta->BolTotal - $InsBoleta->BolRegimenMonto;
	
		}elseif($InsBoleta->RegAplicacion == 2){
			$InsBoleta->BolTotalReal = $InsBoleta->BolTotal + $InsBoleta->BolRegimenMonto;					
		}
	}else{
		$InsBoleta->BolTotalReal = $InsBoleta->BolTotal;
	}	
	
//	if(!empty($InsBoleta->AmoId)){
//		
//		$ArrBoleta = $InsBoleta->MtdVerificarExisteAlmacenMovimientoSalidaId($InsBoleta->AmoId);		
//		
//		if(!empty($ArrBoleta)){
//			$Guardar = false;
//			$Resultado .= "#ERR_BOL_604";	
//		}
//			
//	}
	
	if($Guardar){
		if($InsBoleta->MtdRegistrarBoleta()){
	
			switch($GET_ori){
				
				case "FichaAccion":
				
				
					$ResBoletaAlmacenMovimiento = $_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdObtenerSesionObjetos(true);//OJO
				
					if(!empty($ResBoletaAlmacenMovimiento['Datos'])){	
						foreach($ResBoletaAlmacenMovimiento['Datos'] as $DatSesionObjeto){
										
							if(!empty($DatSesionObjeto->Parametro8)){
								
								$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($DatSesionObjeto->Parametro8,9);
								$InsFichaAccion->MtdActualizarEstadoFichaAccion($DatSesionObjeto->Parametro9,3);
							}
						
						}
					}
					
	
					
					//$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsBoleta->FinId,9);
					
					//$InsFichaAccion->MtdActualizarEstadoFichaAccion($InsBoleta->FccId,3);
				
				break;
				
				//ALMACEN
				/*case "AlmacenMovimientoSalida":
		
					$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsBoleta->FinId,9);
					
		
				break;	*/
				
				case "VentaConcretada":
					
					if($InsBoleta->BolEstado <> 6){
						$InsCotizacionProducto = new ClsCotizacionProducto();
						$InsCotizacionProducto->MtdActualizarEstadoCotizacionProducto($InsBoleta->CprId,5);
					}
				break;	
				
				
				case "OrdenVentaVehiculo":	

					

					if($InsBoleta->BolEstado <> 6){
						
						$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
						$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($InsBoleta->OvvId,5);
						$InsOrdenVentaVehiculo->OvvId = $InsBoleta->OvvId;
						$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
						
									
							 
					}
					
					
//					$InsOrdenVentaVehiculo->OvvId = $InsBoleta->OvvId;
//					$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);
//					
//					if(!empty($InsOrdenVentaVehiculo->EinId)){
//						
//						$InsVehiculoIngreso = new ClsVehiculoIngreso();
//						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","VENDIDO",$InsOrdenVentaVehiculo->EinId);
//						
//					}
					
					
				break;
				
				case "VehiculoMovimientoSalida":
					
					
					
					if($InsBoleta->BolEstado <> 6){
						
						$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
						$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($InsBoleta->OvvId,5);
						$InsOrdenVentaVehiculo->OvvId = $InsBoleta->OvvId;
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
							$InsOrdenVentaVehiculo->MtdEnviarBienvenidaOrdenVentaVehiculo($InsBoleta->OvvId,$EmailPersonal,$SistemaCorreoRemitente,$SistemaCorreoImagenBienvenida,false);
							
					}
					
					
					
					
					//if($InsBoleta->BolEstado <> 6){
//						$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();
//						$InsVehiculoMovimientoSalida->MtdActualizarEstadoVehiculoMovimientoSalida($InsBoleta->VmvId,3);
//					}
					
				break;	
				
				
				case "Pago":
					
					if($InsBoleta->BolEstado <> 6){
						
						$InsPago = new ClsPago();
						$InsPago->MtdActualizarEstadoPago($InsBoleta->PagId,3);
						
					}
					
				break;	
				
			}
			
			
			if(!empty($InsBoleta->BolAbono) and $InsBoleta->BolAbono <> "0.00" and $InsBoleta->NpaId == "NPA-10000"){
					//
//					$Guardar = true;
//					
//					$InsPago = new ClsPago();
//				
//					$InsPago->PagId = NULL;
//					$InsPago->PagFecha = date("Y-m-d");
//					$InsPago->CliId = $InsBoleta->CliId;
//					$InsPago->AreId = "ARE-10000";
//					$InsPago->BolId = $InsBoleta->BolId;
//					$InsPago->BtaId = $InsBoleta->BtaId;
//					
//					$InsPago->NpaId = "NPA-10000";
//					$InsPago->FpaId = "FPA-10000";
//					
//					$InsPago->MonId = $InsBoleta->MonId;
//					$InsPago->PagTipoCambio = $InsBoleta->BolTipoCambio;
//					$InsPago->PagMonto = preg_replace("/,/", "", (empty($InsBoleta->BolAbono)?0:$InsBoleta->BolAbono));
//
//					$InsPago->PagObservacion = date("d/m/Y H:i:s")." - Abono Generada de Boleta: ".$InsBoleta->BtaNumero."-".$InsBoleta->BolId;
//					$InsPago->PagObservacion .= $InsVentaDirecta->VdiObservacion;;
//
//					$InsPago->PagConcepto = "Abono de Boleta ".$InsBoleta->BtaNumero."-".$InsBoleta->BolId;
//
//					$InsPago->PagUtilizado = 1;	
//					$InsPago->PagTipo = "BOL";		
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
//							$Resultado.='#ERR_BOL_901';
//						}
//					}
//				
//					if($InsPago->MonId<>$EmpresaMonedaId ){
//						$InsPago->PagMonto = round($InsPago->PagMonto * $InsPago->PagTipoCambio,6);
//					}
//					
//					$InsPagoComprobante1 = new ClsPagoComprobante();
//					$InsPagoComprobante1->PacId = NULL;
//					$InsPagoComprobante1->BolId = $InsBoleta->BolId;
//					$InsPagoComprobante1->BtaId = $InsBoleta->BtaId;
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
//							$Resultado.='#ERR_BOL_900';
//						}
//						
//					}


				}
				

		
		//	if($InsBoleta->BolNotificar=="1"){
//				$InsBoleta->MtdNotificarBoletaRegistro($InsBoleta->BolId,$InsBoleta->BtaId,$CorreosNotificacionBoletaRegistro);
//			}
			
			
		$InsBoletaTalonario = new ClsBoletaTalonario();
		$InsBoletaTalonario->BtaId = $InsBoleta->BtaId;
		$InsBoletaTalonario->MtdObtenerBoletaTalonario();
		
	  	if(substr($InsBoletaTalonario->BtaNumero,0,1)=="B"){
			
			if($InsBoleta->BolProcesar=="1"){
		?>
			  <script type="text/javascript">
                    $().ready(function() {
                    /*
                    Configuracion carga de datos y animacion
                    */			
                        //FncPopUp('formularios/Boleta/FrmBoletaGenerarXML.php?Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>&Procesar=1&EnviarSUNAT=<?php echo $_POST['CmpProcesar']?>&P=1',0,0,1,0,0,1,0,350,150);
                        //FncPopUp('formularios/Boleta/FrmBoletaGenerarXML.php?Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>&Procesar=1&EnviarSUNAT=1&P=1',0,0,1,0,0,1,0,350,150);
    					FncBoletaGenerarXMLv2('<?php echo $InsBoleta->BolId;?>','<?php echo $InsBoleta->BtaId;?>','',1,1);		
                    });
                </script>
        <?php			
			}
		
		}
		
		
				
			$Registro = true;				
			$Resultado.='#SAS_BOL_101';
		} else{
			$Resultado.='#ERR_BOL_101';
		}
	}
	
	
	$InsBoleta->BolFechaEmision = FncCambiaFechaANormal($InsBoleta->BolFechaEmision);
	$InsBoleta->BolFechaVencimiento = FncCambiaFechaANormal($InsBoleta->BolFechaVencimiento,true);
	$InsBoleta->BolRegimenComprobanteFecha = FncCambiaFechaANormal($InsBoleta->BolRegimenComprobanteFecha,true);
	list($InsBoleta->BolObservacion,$InsBoleta->BolObservacionImpresa) = explode("###",$InsBoleta->BolObservacion);
	
	if($InsBoleta->MonId<>$EmpresaMonedaId and !empty($InsBoleta->BolTipoCambio)){
		$InsBoleta->BolRegimenMonto = round($InsBoleta->BolRegimenMonto / $InsBoleta->BolTipoCambio,2);
	}
	
}else{

	unset($_SESSION['InsBoletaDetalle'.$Identificador]);
	unset($_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]);

	$_SESSION['InsBoletaDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();

	$InsBoleta->BolFechaEmision = date("d/m/Y");	
	//$InsBoleta->BolFechaVencimiento = date("d/m/Y");	
	$InsBoleta->BolCantidadDia = 0;
	
	$InsBoleta->NpaId = "NPA-10000";	
	$InsBoleta->TdoId = "TDO-10000";
	$InsBoleta->MonId = $EmpresaMonedaId;
	$InsBoleta->BolCancelado = 2;
	$InsBoleta->BolObsequio = 2;
	$InsBoleta->BolObservado = 2;
	
	$InsBoleta->BolSpot = 2;
	$InsBoleta->BolPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsBoleta->BolPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
	$InsBoleta->BolIncluyeImpuesto = 1;
	$InsBoleta->BolAbono = 0;
	
	$InsBoleta->BolNotificar = 0;
	$InsBoleta->BolProcesar = 1;
	$InsBoleta->BolEnviarSUNAT = 0;
	$InsBoleta->SucId = $_SESSION['SesionSucursal'];
	$InsBoleta->BolUsuario =  $_SESSION['SesionUsuario'];
	
	
	switch($GET_ori){
		
		case "FichaAccion":

			if(!empty($GET_FccId) or !empty($POST_Seleccionados) ){
				FncCargarFichaAccionDatos();	
			}
			
		break;
		//ALMACEN
		//case "AlmacenMovimientoSalida":
//		
//			if(!empty($GET_AmoId)){
//				FncCargarAlmacenMovimientoSalidaDatos();
//			}
//
//		break;	
		
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
	global $Identificador;
	global $InsFichaAccion;
	global $InsTallerPedido;
	global $InsBoleta;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;
	global $EmpresaImpuestoSelectivo;
	global $POST_Seleccionados;

	$InsFichaAccion = new ClsFichaAccion();

	if(!empty($GET_FccId)){
		
		$InsFichaAccion = new ClsFichaAccion();
		$InsFichaAccion->FccId = $GET_FccId;
		$InsFichaAccion->MtdObtenerFichaAccion();
		
		$InsFichaIngreso = new ClsFichaIngreso();
		$InsFichaIngreso->FinId = $InsFichaAccion->FinId;
		$InsFichaIngreso->MtdObtenerFichaIngreso();
		
		//OBTENIENDO FICHAS
		$InsTallerPedido = new ClsTallerPedido();
		$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoTiempoCreacion','DESC',NULL,NULL,NULL,NULL,$InsFichaAccion->FccId,NULL,0,0,NULL,NULL,false,NULL);
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
		
		
	//	deb("");
//		deb("");
//		deb("");
//		
//		deb($TotalDescuento);
//		deb($TotalBruto);
		
		$PorcentajeDescuento = (((100*$TotalDescuento)/$TotalBruto));
		
		$InsBoleta->MonId = $MonedaId ;
		$InsBoleta->BolTipoCambio = $TipoCambio;
		
		$InsBoleta->AmoId = $TallerPedidoId;
		$InsBoleta->FinId = $InsFichaIngreso->FinId;
		$InsBoleta->FccId = $InsFichaAccion->FccId;		
					
		$InsBoleta->CliId = $InsFichaIngreso->CliId;		
		$InsBoleta->CliNombre = $InsFichaIngreso->CliNombre;
		$InsBoleta->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
		$InsBoleta->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
		
		$InsBoleta->TdoId = $InsFichaIngreso->TdoId;
		$InsBoleta->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
		$InsBoleta->BolDireccion = $InsFichaIngreso->CliDireccion." - ".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliDepartamento;		
		$InsBoleta->BolTelefono = $InsFichaIngreso->FinTelefono;		
		$InsBoleta->BolObsequio = $InsFichaAccion->FimObsequio;
		
		$InsBoleta->BolIncluyeImpuesto =  $IncluyeImpuesto;
		$InsBoleta->BolEstado = 5;
		$InsBoleta->BolObservacion =  $Observacion.chr(13).date("d/m/Y H:i:s")." - Boleta autogenerada de Mov. Alm.: ".$InsBoleta->AmoId." / O.T.: ".$InsBoleta->FinId;
		
		if($InsBoleta->BolObsequio == 1){
			$InsBoleta->BolLeyenda = chr(13)."ENTREGA A TITULO GRATUITO. VALOR REFERENCIAL";	
		}
		
		if($TienePromocion){
			 $InsBoleta->BolObservacionImpresa .= chr(13)."(*) Productos en oferta con precio especial disponibles hasta agotar stock";
		}
	
		$InsBoleta->BolPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
		$InsBoleta->BolPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
		
		$InsBoleta->BolPorcentajeDescuento = $PorcentajeDescuento;
		
		$InsBoleta->BolVendedor = $InsFichaIngreso->UsuUsuario;	
		$InsBoleta->BolNumeroPedido = $InsFichaIngreso->FinId;	
					
		//deb($InsTallerPedido->AmoIncluyeImpuesto);
		//deb($InsBoleta->BolPorcentajeImpuestoVenta);
		//deb($InsBoleta->BolPorcentajeDescuento);
		
		//ITMS
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
//						$TotalPrecioVenta = 0;
//						$TotalImporte = 0;
//						$TotalImpuesto = 0;
//						$TotalDescuento = 0;
//
//						$Repuestos = "";
//								
//						if(!empty($InsTallerPedido->TallerPedidoDetalle)){
//							foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
//								
//								$GuardarDetalle = false;
//								
//								if($DatTallerPedidoDetalle->AmdCantidadPendienteFacturar>0){
//									$GuardarDetalle = true;
//								}
//					
//								if($DatTallerPedidoDetalle->AmdEstado == 1){
//									$GuardarDetalle = false;
//								}
//																	
//								if($GuardarDetalle){
//									
//									$reingreso = strpos($DatTallerPedidoDetalle->ProCodigoOriginal, "-R");
//									$Cantidad = $DatTallerPedidoDetalle->AmdCantidadPendienteFacturar;
//									
//									$PrecioVenta = $DatTallerPedidoDetalle->AmdPrecioVenta;
//									$Importe = $DatTallerPedidoDetalle->AmdImporte;
//									$ValorVenta = 0;
//									$Impuesto = 0;
//								
//								
//									if($InsBoleta->MonId<>$EmpresaMonedaId ){
//										$PrecioVenta = ($PrecioVenta / $InsBoleta->BolTipoCambio);
//										$Importe = ($Importe / $InsBoleta->BolTipoCambio);
//									}
//	
//									if($InsTallerPedido->AmoIncluyeImpuesto == 2){
//										$PrecioVenta = $PrecioVenta * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
//										$Importe = $Importe * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
//									}
//									
//									$Impuesto = ($Importe / (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1));
//									$Impuesto = $Importe - $Impuesto;
//									
//									$ValorVenta = $Importe/((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
//
//									$Descuento = 0;
//								
//									if($InsTallerPedido->AmoDescuento>0){
//										$Descuento = ($InsBoleta->BolPorcentajeDescuento/100) * $ValorVenta;
//									}
//
//									$ValorVenta = $ValorVenta - $Descuento;
//										
//									$TotalValorVenta += $ValorVenta;
//									$TotalPrecioVenta += $PrecioVenta;
//									$TotalImporte += $Importe;
//									$TotalImpuesto += $Impuesto;
//									$TotalDescuento += $Descuento;
//									
//									if($DatTallerPedidoDetalle->RtiId == "RTI-10003"){
//	
//										$Repuestos .= " | ".number_format($DatTallerPedidoDetalle->AmdCantidad,2)." ".$DatTallerPedidoDetalle->UmeNombre." ".$DatTallerPedidoDetalle->ProNombre." [S]";			
//									
//									}elseif($DatTallerPedidoDetalle->RtiId == "RTI-10010" or $reingreso !== false){
//										
//										$Repuestos .= " | ".number_format($DatTallerPedidoDetalle->AmdCantidad,2)." ".$DatTallerPedidoDetalle->UmeNombre." ".$DatTallerPedidoDetalle->ProNombre." [S]";			
//									
//									}else{
//										
//										$Repuestos .= " | ".number_format($DatTallerPedidoDetalle->AmdCantidad,2)." ".$DatTallerPedidoDetalle->UmeNombre." ".$DatTallerPedidoDetalle->ProNombre." ".($DatTallerPedidoDetalle->AmdReingreso=="1"?'[R]':'')." ".($DatTallerPedidoDetalle->ProTienePromocion=="1"?'[*]':'');
//										
//									}
//									
//								
//								}
//		
//		
//							}		
//						}
//						
//					
//
///*
//SesionObjeto-BoletaDetalleListado
//Parametro1 = BdeId
//Parametro2 = BdeDescripcion
//Parametro3
//Parametro4 = BdePrecio
//Parametro5 = BdeCantidad
//Parametro6 = BdeImporte
//Parametro7 = BdeTiempoCreacion
//Parametro8 = BdeTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 =
//Parametro12 = BdeTipo
//Parametro13 = BdeUnidadMedida
//Parametro14 = VcdReingreso
//
//Parametro15 = AmdId
//Parametro16 = FatId
//Parametro17 = OvvId
//
//Parametro18 = BdeCodigo
//Parametro19 = BdeValorVenta
//Parametro20 = BdeImpuesto
//Parametro21 = BdeDescuento
//Parametro22 = BdeGratuito
//Parametro23 = BdeExonerado
//
//Parametro24 = BdeIncluyeSelectivo
//Parametro25 = BdeImpuestoSelectivo
//*/							
//						$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//						NULL,
//						"KIT DE MANTENIMIENTO ".$InsFichaAccion->VmaNombre." ".$InsFichaAccion->VmoNombre." ".$InsFichaAccion->FinMantenimientoKilometraje." KM".$Repuestos,
//						NULL,
//						$TotalImporte,
//						1,
//						$TotalImporte,				
//						
//						date("d/m/Y H:i:s"),
//						date("d/m/Y H:i:s"),
//						NULL,//EX AMDID
//						$DatTallerPedidoDetalle->AmoId,
//						NULL,
//						"T",
//						NULL,//UmeNombre
//						NULL,//AmdReingreso
//						NULL,//AmdId
//						NULL,
//						NULL,
//						"",//ProCodigoOriginal
//						$TotalValorVenta,
//						$TotalImpuesto,
//						$TotalDescuento,
//						(($InsBoleta->BolObsequio=="1")?1:2),
//						2,
//						
//						2,
//						0,
//						
//						""
//						);	
							
				//}else{
					
//					deb($InsBoleta->BolPorcentajeDescuento);



	
					if(!empty($InsTallerPedido->TallerPedidoDetalle)){
						foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
							
							$GuardarDetalle = false;
							
							//if($DatTallerPedidoDetalle->AmdCantidadPendienteFacturar>0){
							if($DatTallerPedidoDetalle->AmdCantidadPendienteFacturar>0 and $DatTallerPedidoDetalle->AmdEstado==3){		
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
								
								if($InsBoleta->MonId<>$EmpresaMonedaId ){
									$PrecioVenta = ($PrecioVenta / $InsBoleta->BolTipoCambio);
									$Importe = ($Importe / $InsBoleta->BolTipoCambio);
								}

								if($InsTallerPedido->AmoIncluyeImpuesto == 2){
									$PrecioVenta = $PrecioVenta * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
									$Importe = $Importe * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
								}
								
								$Impuesto = ($Importe / (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1));
								$Impuesto = $Importe - $Impuesto;
								
								$ValorVenta = $Importe/((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);

								$Descuento = 0;
							
								if($InsTallerPedido->AmoDescuento>0){
									$Descuento = ($InsBoleta->BolPorcentajeDescuento/100) * $ValorVenta;
								}
								
								//deb($Descuento);

								$ValorVenta = $ValorVenta - $Descuento;
							
									/*
									SesionObjeto-BoletaDetalleListado
									Parametro1 = BdeId
									Parametro2 = BdeDescripcion
									Parametro3
									Parametro4 = BdePrecio
									Parametro5 = BdeCantidad
									Parametro6 = BdeImporte
									Parametro7 = BdeTiempoCreacion
									Parametro8 = BdeTiempoModificacion
									Parametro9 = AmdId
									Parametro10 = AmoId
									Parametro11 =
									Parametro12 = BdeTipo
									Parametro13 = BdeUnidadMedida
									Parametro14 = VcdReingreso
									
									Parametro15 = AmdId
									Parametro16 = FatId
									Parametro17 = OvvId
									
									Parametro18 = BdeCodigo
									Parametro19 = BdeValorVenta
									Parametro20 = BdeImpuesto
									Parametro21 = BdeDescuento
									Parametro22 = BdeGratuito
									Parametro23 = BdeExonerado	
									*/
									
								if($DatTallerPedidoDetalle->RtiId == "RTI-10003"){
						
									$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
									(($InsBoleta->BolObsequio=="1")?1:2),
									2,
									
									2,
									0,
									
									$DatTallerPedidoDetalle->AmdCompraOrigen
									);
					
								}elseif($DatTallerPedidoDetalle->RtiId == "RTI-10010" or $reingreso !== false){
									
									$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
									(($InsBoleta->BolObsequio=="1")?1:2),
									2,
									
									2,
									0,
									
									$DatTallerPedidoDetalle->AmdCompraOrigen
									);	

								}else{										
									
									$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
									(($InsBoleta->BolObsequio=="1")?1:2),
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
		
				//if(!empty($InsTallerPedido->AmoDescuento) and $InsTallerPedido->AmoDescuento <> "0.00"){
//					
//				}
			
				if(!empty($InsTallerPedido->AmoId)){
			
					$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
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
				SesionObjeto-BoletaDetalleListado
				Parametro1 = BdeId
				Parametro2 = BdeDescripcion
				Parametro3
				Parametro4 = BdePrecio
				Parametro5 = BdeCantidad
				Parametro6 = BdeImporte
				Parametro7 = BdeTiempoCreacion
				Parametro8 = BdeTiempoModificacion
				Parametro9 = AmdId
				Parametro10 = AmoId
				Parametro11 =
				Parametro12 = BdeTipo
				Parametro13 = BdeUnidadMedida
				Parametro14 = VcdReingreso
				Parametro15 = AmdId
				Parametro16 = FatId
				Parametro17 = OvvId
				
				Parametro18 = BdeCodigo
				Parametro19 = BdeValorVenta
				Parametro20 = BdeImpuesto
				Parametro21 = BdeDescuentom
				Parametro22 = BdeGratuito
				Parametro23 = BdeExonerado					
				*/	
		
				if(!empty($DatFichaAccionTarea->FatCosto) and $DatFichaAccionTarea->FatCosto <> "0.00"){
					
					$Cantidad = 1;
					
					if($InsBoleta->MonId<>$EmpresaMonedaId ){
						$DatFichaAccionTarea->FatCosto = round($DatFichaAccionTarea->FatCosto  / $InsBoleta->BolTipoCambio,2);
					}

					if($IncluyeImpuesto == 2){
						$DatFichaAccionTarea->FatCosto = $DatFichaAccionTarea->FatCosto + ($DatFichaAccionTarea->FatCosto * ($InsBoleta->BolPorcentajeImpuestoVenta/100));
					}

					$PrecioVenta = $DatFichaAccionTarea->FatCosto;
					$Importe = round($PrecioVenta * $Cantidad,2);
					
					$DatFichaAccionTarea->FatValorVenta = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
					$DatFichaAccionTarea->FatImpuesto = $Importe - $DatFichaAccionTarea->FatValorVenta;

					$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
					(($InsBoleta->BolObsequio=="1")?1:2),
					2,
					
					2,
					0,
					
					
					""
					);	

				}
				
			}
		}
				
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
			  
			  if($InsBoleta->MonId<>$EmpresaMonedaId ){
				  $PrecioVenta = round($PrecioVenta  / $InsBoleta->BolTipoCambio,2);
				  $Importe = round($Importe  / $InsBoleta->BolTipoCambio,2);
			  }
			  
			 // if($InsTallerPedido->AmoIncluyeImpuesto == 2){		
//				  $InsFichaAccion->FccManoObra = round($InsFichaAccion->FccManoObra  / $InsBoleta->BolTipoCambio,2);
//			  }
//			  
			  if($InsTallerPedido->AmoIncluyeImpuesto == 2){
					$PrecioVenta = $PrecioVenta * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
					$Importe = $Importe * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
				}
			  
			  
			  $Impuesto = ($Importe / (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1));
			$Impuesto = $Importe - $Impuesto;
				
				$ValorVenta = $Importe/((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);

				$Descuento = 0;
			
				if($InsTallerPedido->AmoDescuento>0){
					$Descuento = ($InsBoleta->BolPorcentajeDescuento/100) * $ValorVenta;
				}
				
				//deb($Descuento);

				$ValorVenta = $ValorVenta - $Descuento;
				
				
			  //
//			  $ValorVenta = $Importe/((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
//			  
//			  $InsFichaAccion->FccValorVentaManoObra = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
//			  $InsFichaAccion->FccImpuestoManoObra = $Importe - $InsFichaAccion->FccValorVentaManoObra;
//			
//			
//			$Descuento = 0;
//		
//			if($InsTallerPedido->AmoDescuento>0){
//				$Descuento = ($InsBoleta->BolPorcentajeDescuento/100) * $ValorVenta;
//			}
//			
//			//deb($Descuento);
//
//			$ValorVenta = $ValorVenta - $Descuento;
								
								
								
								
		
			  $_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
			  (($InsBoleta->BolObsequio=="1")?1:2),
			  2,
			  
			  2,
			  0		,
			  
			  ""	  
			  );
			
		
		}
		
		
		//TALLER PEDIDOS FICHA ACCION - IFIN
		
		///deb($MonedaId);
		
		

	}else{

		$ArrSeleccionados = explode("#",$POST_Seleccionados);
		
		if(!empty($ArrSeleccionados)){
			foreach($ArrSeleccionados as $DatSeleccionado){
				
				if(!empty($DatSeleccionado)){
					
					$InsFichaAccion = new ClsFichaAccion();
					$InsFichaAccion->FccId = $DatSeleccionado;
					$InsFichaAccion->MtdObtenerFichaAccion();
					
					
					$InsFichaIngreso = new ClsFichaIngreso();
					$InsFichaIngreso->FinId = $InsFichaAccion->FinId;
					$InsFichaIngreso->MtdObtenerFichaIngreso();
					
					//OBTENIENDO FICHAS
					$InsTallerPedido = new ClsTallerPedido();
					$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoTiempoCreacion','DESC',NULL,NULL,NULL,NULL,$InsFichaAccion->FccId,NULL,0,0,NULL,NULL,false,NULL);
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
					
					$PorcentajeDescuento = (((100*$TotalDescuento)/$TotalBruto));
					
					$InsBoleta->MonId = $MonedaId ;
					$InsBoleta->BolTipoCambio = $TipoCambio;
					
					$InsBoleta->AmoId = $TallerPedidoId;
					$InsBoleta->FinId = $InsFichaIngreso->FinId;
					$InsBoleta->FccId = $InsFichaAccion->FccId;		
								
					$InsBoleta->CliId = $InsFichaIngreso->CliId;		
					$InsBoleta->CliNombre = $InsFichaIngreso->CliNombre;
					$InsBoleta->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
					$InsBoleta->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
					
					$InsBoleta->TdoId = $InsFichaIngreso->TdoId;
					$InsBoleta->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
					$InsBoleta->BolDireccion = $InsFichaIngreso->CliDireccion." - ".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliDepartamento;		
					$InsBoleta->BolTelefono = $InsFichaIngreso->FinTelefono;		
					$InsBoleta->BolObsequio = $InsFichaAccion->FimObsequio;
					
					$InsBoleta->BolIncluyeImpuesto =  $IncluyeImpuesto;
					$InsBoleta->BolEstado = 5;
					$InsBoleta->BolObservacion =  $Observacion.chr(13).date("d/m/Y H:i:s")." - Boleta autogenerada de Mov. Alm.: ".$InsBoleta->AmoId." / O.T.: ".$InsBoleta->FinId;
					
					if($InsBoleta->BolObsequio == 1){
						$InsBoleta->BolLeyenda = chr(13)."ENTREGA A TITULO GRATUITO. VALOR REFERENCIAL";	
					}
					
					if($TienePromocion){
						 $InsBoleta->BolObservacionImpresa .= chr(13)."(*) Productos en oferta con precio especial disponibles hasta agotar stock";
					}
				
					$InsBoleta->BolPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
					$InsBoleta->BolPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
					
					$InsBoleta->BolPorcentajeDescuento = $PorcentajeDescuento;
					
					$InsBoleta->BolVendedor = $InsFichaIngreso->UsuUsuario;	
					$InsBoleta->BolNumeroPedido = $InsFichaIngreso->FinId;	
					
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
							//
//										$TotalValorVenta = 0;
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
//												
//													if($InsBoleta->MonId<>$EmpresaMonedaId ){
//														$PrecioVenta = ($PrecioVenta / $InsBoleta->BolTipoCambio);
//														$Importe = ($Importe / $InsBoleta->BolTipoCambio);
//													}
//					
//													if($InsTallerPedido->AmoIncluyeImpuesto == 2){
//														$PrecioVenta = $PrecioVenta * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
//														$Importe = $Importe * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
//													}
//													
//													$Impuesto = ($Importe / (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1));
//													$Impuesto = $Importe - $Impuesto;
//													
//													$ValorVenta = $Importe/((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
//				
//													$Descuento = 0;
//												
//													if($InsTallerPedido->AmoDescuento>0){
//														$Descuento = ($InsBoleta->BolPorcentajeDescuento/100) * $ValorVenta;
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
//			SesionObjeto-BoletaDetalleListado
//			Parametro1 = BdeId
//			Parametro2 = BdeDescripcion
//			Parametro3
//			Parametro4 = BdePrecio
//			Parametro5 = BdeCantidad
//			Parametro6 = BdeImporte
//			Parametro7 = BdeTiempoCreacion
//			Parametro8 = BdeTiempoModificacion
//			Parametro9 = AmdId
//			Parametro10 = AmoId
//			Parametro11 =
//			Parametro12 = BdeTipo
//			Parametro13 = BdeUnidadMedida
//			Parametro14 = VcdReingreso
//			
//			Parametro15 = AmdId
//			Parametro16 = FatId
//			Parametro17 = OvvId
//			
//			Parametro18 = BdeCodigo
//			Parametro19 = BdeValorVenta
//			Parametro20 = BdeImpuesto
//			Parametro21 = BdeDescuento
//			Parametro22 = BdeGratuito
//			Parametro23 = BdeExonerado
//			
//			Parametro24 = BdeIncluyeSelectivo
//			Parametro25 = BdeImpuestoSelectivo
//			*/							
//										$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
//										(($InsBoleta->BolObsequio=="1")?1:2),
//										2,
//										
//										2,
//										0,
//										
//										""
//										);	
											
								//}else{
			
									if(!empty($InsTallerPedido->TallerPedidoDetalle)){
										foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
											
											$GuardarDetalle = false;
											
											if($DatTallerPedidoDetalle->AmdCantidadPendienteFacturar>0 and $DatTallerPedidoDetalle->AmdEstado==3){	
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
												
												if($InsBoleta->MonId<>$EmpresaMonedaId ){
													$PrecioVenta = ($PrecioVenta / $InsBoleta->BolTipoCambio);
													$Importe = ($Importe / $InsBoleta->BolTipoCambio);
												}
				
												if($InsTallerPedido->AmoIncluyeImpuesto == 2){
													$PrecioVenta = $PrecioVenta * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
													$Importe = $Importe * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
												}
												
												$Impuesto = ($Importe / (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1));
												$Impuesto = $Importe - $Impuesto;
												
												$ValorVenta = $Importe/((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
			
												$Descuento = 0;
											
												if($InsTallerPedido->AmoDescuento>0){
													$Descuento = ($InsBoleta->BolPorcentajeDescuento/100) * $ValorVenta;
												}
			
												$ValorVenta = $ValorVenta - $Descuento;
											
												
												/*
													SesionObjeto-BoletaDetalleListado
													Parametro1 = BdeId
													Parametro2 = BdeDescripcion
													Parametro3
													Parametro4 = BdePrecio
													Parametro5 = BdeCantidad
													Parametro6 = BdeImporte
													Parametro7 = BdeTiempoCreacion
													Parametro8 = BdeTiempoModificacion
													Parametro9 = AmdId
													Parametro10 = AmoId
													Parametro11 =
													Parametro12 = BdeTipo
													Parametro13 = BdeUnidadMedida
													Parametro14 = VcdReingreso
													
													Parametro15 = AmdId
													Parametro16 = FatId
													Parametro17 = OvvId
													
													Parametro18 = BdeCodigo
													Parametro19 = BdeValorVenta
													Parametro20 = BdeImpuesto
													Parametro21 = BdeDescuento
													Parametro22 = BdeGratuito
													Parametro23 = BdeExonerado	
													*/
													
												if($DatTallerPedidoDetalle->RtiId == "RTI-10003"){
										
													$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
													(($InsBoleta->BolObsequio=="1")?1:2),
													2,
													
													2,
													0,
													
													$DatTallerPedidoDetalle->AmdCompraOrigen
													);
									
												}elseif($DatTallerPedidoDetalle->RtiId == "RTI-10010" or $reingreso !== false){
													
													$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
													(($InsBoleta->BolObsequio=="1")?1:2),
													2,
													
													2,
													0,
													
													$DatTallerPedidoDetalle->AmdCompraOrigen
													);	
			
												}else{										
													
													$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
													(($InsBoleta->BolObsequio=="1")?1:2),
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
							
									$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
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
							SesionObjeto-BoletaDetalleListado
							Parametro1 = BdeId
							Parametro2 = BdeDescripcion
							Parametro3
							Parametro4 = BdePrecio
							Parametro5 = BdeCantidad
							Parametro6 = BdeImporte
							Parametro7 = BdeTiempoCreacion
							Parametro8 = BdeTiempoModificacion
							Parametro9 = AmdId
							Parametro10 = AmoId
							Parametro11 =
							Parametro12 = BdeTipo
							Parametro13 = BdeUnidadMedida
							Parametro14 = VcdReingreso
							Parametro15 = AmdId
							Parametro16 = FatId
							Parametro17 = OvvId
							
							Parametro18 = BdeCodigo
							Parametro19 = BdeValorVenta
							Parametro20 = BdeImpuesto
							Parametro21 = BdeDescuentom
							Parametro22 = BdeGratuito
							Parametro23 = BdeExonerado					
							*/	
					
							if(!empty($DatFichaAccionTarea->FatCosto) and $DatFichaAccionTarea->FatCosto <> "0.00"){
								
								$Cantidad = 1;
								
								if($InsBoleta->MonId<>$EmpresaMonedaId ){
									$DatFichaAccionTarea->FatCosto = round($DatFichaAccionTarea->FatCosto  / $InsBoleta->BolTipoCambio,2);
								}
			
								if($IncluyeImpuesto == 2){
									$DatFichaAccionTarea->FatCosto = $DatFichaAccionTarea->FatCosto + ($DatFichaAccionTarea->FatCosto * ($InsBoleta->BolPorcentajeImpuestoVenta/100));
								}
			
								$PrecioVenta = $DatFichaAccionTarea->FatCosto;
								$Importe = round($PrecioVenta * $Cantidad,2);
								
								$DatFichaAccionTarea->FatValorVenta = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
								$DatFichaAccionTarea->FatImpuesto = $Importe - $DatFichaAccionTarea->FatValorVenta;
			
								$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
								(($InsBoleta->BolObsequio=="1")?1:2),
								2,
								
								2,
								0,
								
								""
								);	
			
							}
							
						}
					}
							
					//MANO OBRA	
					if(!empty($InsFichaAccion->FccManoObra) and $InsFichaAccion->FccManoObra <> "0.00" ){
						
						$manoobra = '';
						  $Cantidad = 1;
						  
						  if(!empty($InsFichaAccion->FccManoObraDetalle)){
							  $manoobra = $InsFichaAccion->FccManoObraDetalle;	
						  }else{
							  $manoobra = 'MANO DE OBRA';
						  }
						  
						  if($InsBoleta->MonId<>$EmpresaMonedaId ){
							  $InsFichaAccion->FccManoObra = round($InsFichaAccion->FccManoObra  / $InsBoleta->BolTipoCambio,2);
						  }
						  
						  if($InsTallerPedido->AmoIncluyeImpuesto == 2){		
							  $InsFichaAccion->FccManoObra = round($InsFichaAccion->FccManoObra  / $InsBoleta->BolTipoCambio,2);
						  }
						  
						  $PrecioVenta = $InsFichaAccion->FccManoObra;
						  $Importe = round($PrecioVenta * $Cantidad,2);
						  
						  $InsFichaAccion->FccValorVentaManoObra = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
						  $InsFichaAccion->FccImpuestoManoObra = $Importe - $InsFichaAccion->FccValorVentaManoObra;
					
						  $_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
						  $InsFichaAccion->FccValorVentaManoObra,
						  $InsFichaAccion->FccImpuestoManoObra,
						  0,
						  (($InsBoleta->BolObsequio=="1")?1:2),
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
	global $InsBoleta;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;
	global $EmpresaImpuestoSelectivo;
	
//	deb($EmpresaImpuestoSelectivo);
	
	if(!empty($GET_VcoId)){
		
		$InsVentaConcretada = new ClsVentaConcretada();
		$InsVentaConcretada->VcoId = $GET_VcoId;	
		$InsVentaConcretada->MtdObtenerVentaConcretada();	
		
		
//		$TotalDescuento = $InsVentaConcretada->VcoDescuento;
//		$TotalBruto = $InsVentaConcretada->VcoTotal + $InsVentaConcretada->VcoDescuento;
//		
//	//	deb($TotalBruto);
//		if($InsVentaConcretada->VcoIncluyeImpuesto == 2){				
//			$TotalDescuento = $InsVentaConcretada->VcoDescuento + ($InsVentaConcretada->VcoDescuento * ($EmpresaImpuestoVenta/100));				
//		}
//		
//		if($InsVentaConcretada->VcoIncluyeImpuesto == 2){				
//			$TotalBruto = $InsVentaConcretada->VcoTotal + ($InsVentaConcretada->VcoTotal * ($EmpresaImpuestoVenta/100));				
//		}
//		
//		$PorcentajeDescuento = (((100*$TotalDescuento)/$TotalBruto));

		
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
				
		
		$InsBoleta->AmoId = $InsVentaConcretada->VcoId;
		$InsBoleta->CprId = $InsVentaConcretada->CprId;
		$InsBoleta->VdiId = $InsVentaConcretada->VdiId;	
				
		$InsBoleta->CliId = $InsVentaConcretada->CliId;		
		$InsBoleta->CliNombre = $InsVentaConcretada->CliNombre;
		$InsBoleta->CliApellidoPaterno = $InsVentaConcretada->CliApellidoPaterno;
		$InsBoleta->CliApellidoMaterno = $InsVentaConcretada->CliApellidoMaterno;
		
		$InsBoleta->TdoId = $InsVentaConcretada->TdoId;
		$InsBoleta->CliNumeroDocumento = $InsVentaConcretada->CliNumeroDocumento;
		$InsBoleta->BolDireccion = $InsVentaConcretada->CliDireccion." - ".$InsVentaConcretada->CliDistrito." - ".$InsVentaConcretada->CliProvincia." - ".$InsVentaConcretada->CliDepartamento;
		
		$InsBoleta->BolTelefono = $InsVentaConcretada->VcoTelefono;	
		$InsBoleta->BolEstado = 5;
		$InsBoleta->BolObservacion = $InsVentaConcretada->VcoObservacion.chr(13).date("d/m/Y H:i:s")." - Boleta autogenerada de Mov. Alm.: ".$InsBoleta->AmoId." / Cot.: ".$InsBoleta->CprId;
	
		if(!empty($InsVentaConcretada->VdiOrdenCompraNumero)){
			$InsBoleta->BolObservacionImpresa .= chr(13)."O.C.: ".$InsVentaConcretada->VdiOrdenCompraNumero;		
		}
		
		if(!empty($InsVentaConcretada->CprId)){
			$InsBoleta->BolObservacionImpresa .= chr(13)."Cot.: ".$InsVentaConcretada->CprId;		
		}
		
		$InsBoleta->MonId = $InsVentaConcretada->MonId;		
		$InsBoleta->BolTipoCambio = $InsVentaConcretada->VcoTipoCambio;		
		
		$InsBoleta->BolIncluyeImpuesto = 1;
		$InsBoleta->BolPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
		$InsBoleta->BolPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
		
		$InsBoleta->BolPorcentajeDescuento = $PorcentajeDescuento;
		
		$InsBoleta->BolVendedor = $InsVentaConcretada->UsuUsuario;	
		$InsBoleta->BolNumeroPedido = $InsVentaConcretada->VdiId;	
		
		$InsBoleta->BolAbono = 0;
		
		$BoletaTotal = 0;
			
			if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
				foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){
					
					//$Cantidad = $DatVentaConcretadaDetalle->VcdCantidad;
					//.deb($DatVentaConcretadaDetalle->VcdCantidadFacturar);
					//if($DatVentaConcretadaDetalle->VcdCantidadFacturar>0){
					if($DatVentaConcretadaDetalle->VcdCantidadFacturar>0 and $DatVentaConcretadaDetalle->VcdEstado == 3){						
						$reingreso = strpos($DatVentaConcretadaDetalle->ProCodigoOriginal, "-R");
									
						$Cantidad = $DatVentaConcretadaDetalle->VcdCantidadFacturar;
						$PrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta;
						$Importe = $DatVentaConcretadaDetalle->VcdImporte;
						$ValorVenta = 0;
						$Impuesto = 0;
						
						if($InsBoleta->MonId<>$EmpresaMonedaId ){
							$PrecioVenta = ($PrecioVenta / $InsBoleta->BolTipoCambio);
							$Importe = ($Importe / $InsBoleta->BolTipoCambio);
						}
						
						if($InsVentaConcretada->VcoIncluyeImpuesto == 2){
							$PrecioVenta = $PrecioVenta * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
							$Importe = $Importe * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
						}
						  
						$Impuesto = ($Importe / (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1));
						$Impuesto = $Importe - $Impuesto;
						
						$ValorVenta = $Importe/((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
						
						$Descuento = 0;
						
						if($InsVentaConcretada->VcoDescuento>0){
						  $Descuento = ($InsBoleta->BolPorcentajeDescuento/100) * $ValorVenta;
						}
						
						$ValorVenta = $ValorVenta - $Descuento;
											
						/*
						SesionObjeto-BoletaDetalleListado
						Parametro1 = BdeId
						Parametro2 = BdeDescripcion
						Parametro3
						Parametro4 = BdePrecio
						Parametro5 = BdeCantidad
						Parametro6 = BdeImporte
						Parametro7 = BdeTiempoCreacion
						Parametro8 = BdeTiempoModificacion
						Parametro9 = AmdId
						Parametro10 = AmoId
						Parametro11 =
						Parametro12 = BdeTipo
						Parametro13 = BdeUnidadMedida
						Parametro14 = VcdReingreso
						
						Parametro15 = AmdId
						Parametro16 = FatId
						Parametro17 = OvvId
						
						Parametro18 = BdeCodigo
						Parametro19 = BdeValorVenta
						Parametro20 = BdeImpuesto
						Parametro21 = BdeDescuento
						Parametro22 = BdeGratuito
						Parametro23 = BdeExonerado
						
						Parametro24 = BdeIncluyeSelectivo
						Parametro25 = BdeImpuestoSelectivo
						*/		

						if($DatVentaConcretadaDetalle->RtiId == "RTI-10003"){
							
							$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
							
							$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
							
							$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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

						$BoletaTotal += $Importe;

					}

				}		
			}
			
			if(!empty($InsVentaConcretada->VcoDescuento)){
						
			}			
					
			if(!empty($InsVentaConcretada->VcoManoObra) and $InsVentaConcretada->VcoManoObra <> 0.00){
				
				
		
/*
SesionObjeto-BoletaDetalleListado
Parametro1 = BdeId
Parametro2 = BdeDescripcion
Parametro3
Parametro4 = BdePrecio
Parametro5 = BdeCantidad
Parametro6 = BdeImporte
Parametro7 = BdeTiempoCreacion
Parametro8 = BdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = BdeTipo
Parametro13 = BdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = BdeCodigo
Parametro19 = BdeValorVenta
Parametro20 = BdeImpuesto
Parametro21 = BdeDescuentom
Parametro22 = BdeGratuito
Parametro23 = BdeExonerado		
*/
				$Cantidad = 1;
				
				if($InsBoleta->MonId<>$EmpresaMonedaId ){
					$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra  / $InsBoleta->BolTipoCambio,2);
				}

				if($InsVentaConcretada->VcoIncluyeImpuesto == 2){				
					$InsVentaConcretada->VcoManoObra = $InsVentaConcretada->VcoManoObra + ($InsOrdenVentaVehiculo->VcoManoObra * ($InsBoleta->BolPorcentajeImpuestoVenta/100));
				}

				$PrecioVenta = $InsVentaConcretada->VcoManoObra;
				$Importe = round($PrecioVenta * $Cantidad,2);
				
				$InsVentaConcretada->VcoValorVentaManoObra = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
				$InsVentaConcretada->VcoImpuestoManoObra = $Importe - $InsVentaConcretada->VcoValorVentaManoObra;
				
				$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
				
				$BoletaTotal += $InsVentaConcretada->VcoManoObra;
						
			}
	
			if(!empty($InsVentaConcretada->VcoId)){
				
				$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
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
//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL)
			$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,$InsVentaConcretada->VdiId,NULL,NULL,NULL);
			$ArrPagos = $ResPago['Datos'];
				
			$TotalAbonado = 0;
							
			if(!empty($ArrPagos)){
				foreach($ArrPagos as $DatPago){
						
					if($DatPago->MonId == $InsBoleta->MonId){//DOLARES
						
						if($InsBoleta->MonId == $EmpresaMonedaId){
							$TotalAbonado += $DatPago->PagMonto;
						}else{
							$TotalAbonado += ($DatPago->PagMonto/$DatPago->PagTipoCambio);
						}
						
					}
						
				}
			}
			
			//deb($BoletaTotal." - ".$TotalAbonado);
			$InsBoleta->BolAbono += $BoletaTotal - $TotalAbonado;
			
	}else{
		
		$ArrSeleccionados = explode("#",$POST_Seleccionados);
		
		if(!empty($ArrSeleccionados)){
			foreach($ArrSeleccionados as $DatSeleccionado){
				
				if(!empty($DatSeleccionado)){


//SesionObjeto-BoletaAlmacenMovimiento
//Parametro1 = FamId
//Parametro2 = AmoId
//Parametro3 = 
//Parametro4 = 
//Parametro5 = FamEstado
//Parametro6 = FamTiempoCreacion
//Parametro7 = FamTiempoModificacion
	
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
//					$TotalBruto = $InsVentaConcretada->VcoTotal + $InsVentaConcretada->VcoDescuento;
//					
//					if($InsVentaConcretada->VcoIncluyeImpuesto == 2){				
//
//						$TotalDescuento = $InsVentaConcretada->VcoDescuento + ($InsVentaConcretada->VcoDescuento * ($EmpresaImpuestoVenta/100));				
//					}
//					
//					if($InsVentaConcretada->VcoIncluyeImpuesto == 2){				
//						$TotalBruto = $InsVentaConcretada->VcoTotal + ($InsVentaConcretada->VcoTotal * ($EmpresaImpuestoVenta/100));				
//					}
//					
//					$PorcentajeDescuento = (((100*$TotalDescuento)/$TotalBruto));
					
					
					$InsBoleta->AmoId = $InsVentaConcretada->VcoId;
					$InsBoleta->CprId = $InsVentaConcretada->CprId;
					$InsBoleta->VdiId = $InsVentaConcretada->VdiId;	
					
					$InsBoleta->CliId = $InsVentaConcretada->CliId;		
					$InsBoleta->CliNombre = $InsVentaConcretada->CliNombre;
					$InsBoleta->CliApellidoPaterno = $InsVentaConcretada->CliApellidoPaterno;
					$InsBoleta->CliApellidoMaterno = $InsVentaConcretada->CliApellidoMaterno;
					
					$InsBoleta->TdoId = $InsVentaConcretada->TdoId;
					$InsBoleta->CliNumeroDocumento = $InsVentaConcretada->CliNumeroDocumento;
					$InsBoleta->BolDireccion = $InsVentaConcretada->CliDireccion." - ".$InsVentaConcretada->CliDistrito." - ".$InsVentaConcretada->CliProvincia." - ".$InsVentaConcretada->CliDepartamento;
					
					$InsBoleta->BolTelefono = $InsVentaConcretada->VcoTelefono;	
					//$InsBoleta->BolIncluyeImpuesto = $InsVentaConcretada->VcoIncluyeImpuesto;	
					$InsBoleta->BolEstado = 5;
				//	$InsBoleta->BolObservacion = $InsVentaConcretada->VcoObservacion;
					$InsBoleta->BolObservacion = $InsVentaConcretada->VcoObservacion.chr(13).date("d/m/Y H:i:s")." - Boleta autogenerada de Mov. Alm.: ".$InsBoleta->AmoId." / Cot.: ".$InsBoleta->CprId;
					
					//deb($InsBoleta->BolIncluyeImpuesto);
					if(!empty($InsVentaConcretada->VdiOrdenCompraNumero)){
						$InsBoleta->BolObservacionImpresa .= chr(13)."O.C.: ".$InsVentaConcretada->VdiOrdenCompraNumero;		
					}
				
					if(!empty($InsVentaConcretada->CprId)){
						$InsBoleta->BolObservacionImpresa .= chr(13)."Cot.: ".$InsVentaConcretada->CprId;		
					}
				
					//$InsBoleta->MonId = $EmpresaMonedaId;		
					$InsBoleta->MonId = $InsVentaConcretada->MonId;		
					$InsBoleta->BolTipoCambio = $InsVentaConcretada->VcoTipoCambio;		
				
					$InsBoleta->BolIncluyeImpuesto = 1;
					$InsBoleta->BolPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
					$InsBoleta->BolPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
					$InsBoleta->BolPorcentajeDescuento = $PorcentajeDescuento;
					
					$InsBoleta->BolVendedor = $InsVentaConcretada->UsuUsuario;	
					$InsBoleta->BolNumeroPedido = $InsVentaConcretada->VdiId;	
	
					$InsBoleta->BolAbono = 0;
					//$InsBoleta->BolTotalDescuento = $InsVentaConcretada->VcoDescuento;
					
					//if($InsBoleta->MonId<>$EmpresaMonedaId ){
//						$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento  / $InsBoleta->BolTipoCambio,6);
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
//								if($InsBoleta->MonId<>$EmpresaMonedaId ){
//									$PrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta  / $InsBoleta->BolTipoCambio,6);
//								}
//		
//								if($InsVentaConcretada->VcoIncluyeImpuesto == 2){							
//									$PrecioVenta = $PrecioVenta + ($PrecioVenta * ($InsBoleta->BolPorcentajeImpuestoVenta/100));							
//								}
//		
//								$Importe = round($PrecioVenta * $Cantidad,2);
//							
//								$ValorVenta = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
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
//								if($InsBoleta->MonId<>$EmpresaMonedaId ){
//									$PrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta  / $InsBoleta->BolTipoCambio,6);
//								}
//					
//								if($InsVentaConcretada->VcoIncluyeImpuesto == 2){							
//									$PrecioVenta = $PrecioVenta + ($PrecioVenta * ($InsBoleta->BolPorcentajeImpuestoVenta/100));							
//								}
//					
//								$Importe = round($PrecioVenta * $Cantidad,2);
//							
//								$ValorVenta = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
//								
//								$ValorVentaTotal += $ValorVenta;
//					
//							}
//					
//						}		
//					}
//						
//						
//					if($InsBoleta->MonId<>$EmpresaMonedaId ){
//						$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento  / $InsBoleta->BolTipoCambio,6);
//					}
//					
//					$PorcentajeDescuento = round(((100*$InsVentaConcretada->VcoDescuento)/$ValorVentaTotal),2);
//		
					$BoletaTotal = 0;
			
//			deb($InsVentaConcretada->VentaConcretadaDetalle);
			
			//deb($InsBoleta->MonId);
				//deb($EmpresaMonedaId);
				
					if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
						foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){
							
							//$Cantidad = $DatVentaConcretadaDetalle->VcdCantidad;
							//.deb($DatVentaConcretadaDetalle->VcdCantidadFacturar);
							
							if($DatVentaConcretadaDetalle->VcdCantidadFacturar>0 and $DatVentaConcretadaDetalle->VcdEstado == 3){
								
								//$Cantidad = $DatVentaConcretadaDetalle->VcdCantidadFacturar;
//								$reingreso = strpos($DatVentaConcretadaDetalle->ProCodigoOriginal, "-R");
//							
//								if($InsBoleta->MonId<>$EmpresaMonedaId ){
//									$DatVentaConcretadaDetalle->VcdPrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta  / $InsBoleta->BolTipoCambio,6);
//								}
//								
//								if($InsVentaConcretada->VcoIncluyeImpuesto == 2){							
//									$DatVentaConcretadaDetalle->VcdPrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta + ($DatVentaConcretadaDetalle->VcdPrecioVenta * ($InsBoleta->BolPorcentajeImpuestoVenta/100));							
//								}
//								
//								if($InsVentaConcretada->VcoIncluyeImpuesto == 1){							
//									$InsVentaConcretada->VcoDescuento = $InsVentaConcretada->VcoDescuento /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
//								}
//		
//								$PrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta;
//								$Importe = round($PrecioVenta * $Cantidad,2);
//						
//								$DatVentaConcretadaDetalle->VcdValorVenta = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
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
//									//$DatVentaConcretadaDetalle->VcdImpuesto = ($DatVentaConcretadaDetalle->VcdValorVenta * ($InsBoleta->BolPorcentajeImpuestoVenta/100));							
//									//$Importe = $DatVentaConcretadaDetalle->VcdValorVenta + $DatVentaConcretadaDetalle->VcdImpuesto;
//									
//									if($InsBoleta->MonId<>$EmpresaMonedaId ){
//										$Descuento = round($Descuento/ $InsBoleta->BolTipoCambio,6);
//									}
//									
//								}
								
								$reingreso = strpos($DatVentaConcretadaDetalle->ProCodigoOriginal, "-R");
											
								$Cantidad = $DatVentaConcretadaDetalle->VcdCantidadPendienteFacturar;
								$PrecioVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta;
								$Importe = $DatVentaConcretadaDetalle->VcdImporte;
								$ValorVenta = 0;
								$Impuesto = 0;
								
								if($InsBoleta->MonId<>$EmpresaMonedaId ){
									$PrecioVenta = ($PrecioVenta / $InsBoleta->BolTipoCambio);
									$Importe = ($Importe / $InsBoleta->BolTipoCambio);
								}
								
								if($InsVentaConcretada->VcoIncluyeImpuesto == 2){
									$PrecioVenta = $PrecioVenta * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
									$Importe = $Importe * (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1);
								}
								  
								$Impuesto = ($Importe / (($InsBoleta->BolPorcentajeImpuestoVenta/100)+1));
								$Impuesto = $Importe - $Impuesto;
								
								$ValorVenta = $Importe/((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
								
								$Descuento = 0;
								
								if($InsVentaConcretada->VcoDescuento>0){
								  $Descuento = ($InsBoleta->BolPorcentajeDescuento/100) * $ValorVenta;
								}
								
								$ValorVenta = $ValorVenta - $Descuento;
								
								
/*
SesionObjeto-BoletaDetalleListado
Parametro1 = BdeId
Parametro2 = BdeDescripcion
Parametro3
Parametro4 = BdePrecio
Parametro5 = BdeCantidad
Parametro6 = BdeImporte
Parametro7 = BdeTiempoCreacion
Parametro8 = BdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = BdeTipo
Parametro13 = BdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = BdeCodigo
Parametro19 = BdeValorVenta
Parametro20 = BdeImpuesto
Parametro21 = BdeDescuento
Parametro22 = BdeGratuito
Parametro23 = BdeExonerado

Parametro24 = BdeIncluyeSelectivo
Parametro25 = BdeImpuestoSelectivo
*/		
								if($DatVentaConcretadaDetalle->RtiId == "RTI-10003"){
									
									$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
									0		,
									
									$DatVentaConcretadaDetalle->VcdCompraOrigen
									);
										
								}elseif($DatVentaConcretadaDetalle->RtiId == "RTI-10010" or $reingreso !== false){
									
									$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
									
									$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
		
								$BoletaTotal += $Importe;
		
							}
		
						}		
					}
			
//				if(!empty($InsVentaConcretada->VcoDescuento)){
//
//				if($InsBoleta->MonId<>$EmpresaMonedaId ){
//					$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento  / $InsBoleta->BolTipoCambio,2);
//				}
//		
//				if($InsBoleta->BolIncluyeImpuesto == 2){				
//					$InsVentaConcretada->VcoDescuento = $InsVentaConcretada->VcoDescuento + ($InsOrdenVentaVehiculo->VcoDescuento * ($InsBoleta->BolPorcentajeImpuestoVenta/100));
//				}
//				
///*
//SesionObjeto-BoletaDetalleListado
//Parametro1 = BdeId
//Parametro2 = BdeDescripcion
//Parametro3
//Parametro4 = BdePrecio
//Parametro5 = BdeCantidad
//Parametro6 = BdeImporte
//Parametro7 = BdeTiempoCreacion
//Parametro8 = BdeTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 =
//Parametro12 = BdeTipo
//Parametro13 = BdeUnidadMedida
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
//				$InsVentaConcretada->VcoValorVenta = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
//				$InsVentaConcretada->VcoImpuesto = $Importe - $InsVentaConcretada->VcoValorVenta;		
//						
//				$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
//				$BoletaTotal += $InsVentaConcretada->VcoDescuento*-1;
//						
//			}
			
					
					if(!empty($InsVentaConcretada->VcoManoObra) and $InsVentaConcretada->VcoManoObra <> 0.00){
						
						$Cantidad = 1;
						
						if($InsBoleta->MonId<>$EmpresaMonedaId ){
							$InsVentaConcretada->VcoManoObra = round($InsVentaConcretada->VcoManoObra  / $InsBoleta->BolTipoCambio,2);
						}
		
						if($InsVentaConcretada->VcoIncluyeImpuesto == 2){				
							$InsVentaConcretada->VcoManoObra = $InsVentaConcretada->VcoManoObra + ($InsOrdenVentaVehiculo->VcoManoObra * ($InsBoleta->BolPorcentajeImpuestoVenta/100));
						}
		
						/*
						SesionObjeto-BoletaDetalleListado
						Parametro1 = BdeId
						Parametro2 = BdeDescripcion
						Parametro3
						Parametro4 = BdePrecio
						Parametro5 = BdeCantidad
						Parametro6 = BdeImporte
						Parametro7 = BdeTiempoCreacion
						Parametro8 = BdeTiempoModificacion
						Parametro9 = AmdId
						Parametro10 = AmoId
						Parametro11 =
						Parametro12 = BdeTipo
						Parametro13 = BdeUnidadMedida
						Parametro14 = VcdReingreso
						
						Parametro15 = AmdId
						Parametro16 = FatId
						Parametro17 = OvvId
						
						Parametro18 = BdeCodigo
						Parametro19 = BdeValorVenta
						Parametro20 = BdeImpuesto
						Parametro21 = BdeDescuentom
						Parametro22 = BdeGratuito
						Parametro23 = BdeExonerado		
						*/
		
						$PrecioVenta = $InsVentaConcretada->VcoManoObra;
						$Importe = round($PrecioVenta * $Cantidad,2);
						
						$InsVentaConcretada->VcoValorVentaManoObra = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
						$InsVentaConcretada->VcoImpuestoManoObra = $Importe - $InsVentaConcretada->VcoValorVentaManoObra;
						
						$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
		
						$BoletaTotal += $InsVentaConcretada->VcoManoObra;
		
					}
			
					if(!empty($InsVentaConcretada->VcoId)){
						
						//SesionObjeto-BoletaAlmacenMovimiento
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

						$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
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
		//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL)
					$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,$InsVentaConcretada->VdiId,NULL,NULL,NULL);
					$ArrPagos = $ResPago['Datos'];
						
					$TotalAbonado = 0;
									
					if(!empty($ArrPagos)){
						foreach($ArrPagos as $DatPago){
								
							if($DatPago->MonId == $InsBoleta->MonId){//DOLARES
								
								if($InsBoleta->MonId == $EmpresaMonedaId){
									$TotalAbonado += $DatPago->PagMonto;
								}else{
									$TotalAbonado += ($DatPago->PagMonto/$DatPago->PagTipoCambio);
								}
								
							}
								
						}
					}
					
					//deb($BoletaTotal." - ".$TotalAbonado);
					$InsBoleta->BolAbono += $BoletaTotal - $TotalAbonado;
					
					
				}
				
			}
		}
		
		
	}
	
	
	
		
}


//
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
//	global $InsBoleta;
//	
//	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
//	
//	$InsOrdenVentaVehiculo->OvvId = $GET_OvvId;	
//	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();	
//
//	$InsBoleta->OvvId = $InsOrdenVentaVehiculo->OvvId;
//	$InsBoleta->CveId = $InsOrdenVentaVehiculo->CveId;
//	
//	$InsBoleta->CliId = $InsOrdenVentaVehiculo->CliId;		
//	$InsBoleta->CliNombre = $InsOrdenVentaVehiculo->CliNombre;
//	$InsBoleta->CliApellidoPaterno = $InsOrdenVentaVehiculo->CliApellidoPaterno;
//	$InsBoleta->CliApellidoMaterno = $InsOrdenVentaVehiculo->CliApellidoMaterno;
//	
//	$InsBoleta->TdoId = $InsOrdenVentaVehiculo->TdoId;
//	$InsBoleta->CliNumeroDocumento = $InsOrdenVentaVehiculo->CliNumeroDocumento;
//	$InsBoleta->BolDireccion = $InsOrdenVentaVehiculo->CliDireccion." - ".$InsOrdenVentaVehiculo->CliDistrito." - ".$InsOrdenVentaVehiculo->CliProvincia." - ".$InsOrdenVentaVehiculo->CliDepartamento;
//	
//	$InsBoleta->BolTelefono = $InsOrdenVentaVehiculo->CliTelefono;		
//	$InsBoleta->BolIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;	
//	$InsBoleta->BolEstado = 5;
//	
//	$InsOrdenVentaVehiculo->OvvObservacion = strip_tags($InsOrdenVentaVehiculo->OvvObservacion);
//	$InsBoleta->BolObservacion = $InsOrdenVentaVehiculo->OvvObservacion.chr(13).date("d/m/Y H:i:s")." - Boleta autogenerada de Ord. Ven. Veh.: ".$InsBoleta->OvvId." / Prof. Veh: ".$InsBoleta->CveId;
//	
//	$InsBoleta->MonId = $InsOrdenVentaVehiculo->MonId;		
//	$InsBoleta->BolTipoCambio = $InsOrdenVentaVehiculo->VcoTipoCambio;		
//
//	//$InsBoleta->BolIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;		
//	$InsBoleta->BolIncluyeImpuesto = 1;		
//	$InsBoleta->BolPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
//	$InsBoleta->BolPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
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
//SesionObjeto-BoletaDetalleListado
//Parametro1 = BdeId
//Parametro2 = BdeDescripcion
//Parametro3
//Parametro4 = BdePrecio
//Parametro5 = BdeCantidad
//Parametro6 = BdeImporte
//Parametro7 = BdeTiempoCreacion
//Parametro8 = BdeTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 =
//Parametro12 = BdeTipo
//Parametro13 = BdeUnidadMedida
//Parametro14 = VcdReingreso
//
//Parametro15 = AmdId
//Parametro16 = FatId
//Parametro17 = OvvId
//
//Parametro18 = BdeCodigo
//Parametro19 = BdeValorVenta
//Parametro20 = BdeImpuesto
//Parametro21 = BdeDescuento
//Parametro22 = BdeGratuito
//Parametro23 = BdeExonerado
//
//Parametro24 = BdeIncluyeSelectivo
//Parametro25 = BdeImpuestoSelectivo
//*/		
//		
//		
////		if($InsBoleta->BolIncluyeImpuesto == 2){
////			$InsVentaConcretada->VcoManoObra = $InsVentaConcretada->VcoManoObra + ($InsOrdenVentaVehiculo->VcoManoObra * ($InsBoleta->BolPorcentajeImpuestoVenta/100));
////		}
//				
//	$Cantidad = 1;
//	
//	if($InsOrdenVentaVehiculo->OvvIncluyeImpuesto == 2){				
//		$InsOrdenVentaVehiculo->OvvTotal = $InsOrdenVentaVehiculo->OvvTotal + ($InsOrdenVentaVehiculo->OvvTotal * ($InsBoleta->BolPorcentajeImpuestoVenta/100));
//	}
//				
//	$PrecioVenta = $InsOrdenVentaVehiculo->OvvTotal;
//	$Importe = round($PrecioVenta * $Cantidad,2);
//	
//	$InsOrdenVentaVehiculo->OvvValorVenta = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
//	$InsOrdenVentaVehiculo->OvvImpuesto = $Importe  - $DatVentaConcretadaDetalle->OvvValorVenta;
//						
////	if($InsBoleta->BolIncluyeImpuesto == 1){
////		$InsOrdenVentaVehiculo->OvvValorVenta = $InsOrdenVentaVehiculo->OvvTotal /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
////		$InsOrdenVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvTotal - $InsOrdenVentaVehiculo->OvvValorVenta;
////	}else{
////		$InsOrdenVentaVehiculo->OvvValorVenta = $InsOrdenVentaVehiculo->OvvTotal;
////		$InsOrdenVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvValorVenta * ($InsBoleta->BolPorcentajeImpuestoVenta/100);
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
//SesionObjeto-BoletaDetalleListado
//Parametro1 = BdeId
//Parametro2 = BdeDescripcion
//Parametro3
//Parametro4 = BdePrecio
//Parametro5 = BdeCantidad
//Parametro6 = BdeImporte
//Parametro7 = BdeTiempoCreacion
//Parametro8 = BdeTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 =
//Parametro12 = BdeTipo
//Parametro13 = BdeUnidadMedida
//Parametro14 = VcdReingreso
//
//Parametro15 = AmdId
//Parametro16 = FatId
//Parametro17 = OvvId
//
//Parametro18 = BdeCodigo
//Parametro19 = BdeValorVenta
//Parametro20 = BdeImpuesto
//Parametro21 = BdeDescuento
//Parametro22 = BdeGratuito
//Parametro23 = BdeExonerado
//
//Parametro24 = BdeIncluyeSelectivo
//Parametro25 = BdeImpuestoSelectivo
//*/		
//	$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//	NULL,
//	$InsOrdenVentaVehiculo->VmaNombre." ".$InsOrdenVentaVehiculo->VmoNombre." ".$InsOrdenVentaVehiculo->VveNombre." ".$Obsequios,
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
//	
//	""
//	);
//	
//	if(!empty(	$InsOrdenVentaVehiculo->OvvId)){
//		
//		$_SESSION['InsBoletaDatoAdicional1'.$Identificador] = $InsOrdenVentaVehiculo->VmaNombre;
//		$_SESSION['InsBoletaDatoAdicional2'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica7)?$InsOrdenVentaVehiculo->EinCaracteristica7:$InsOrdenVentaVehiculo->VveCaracteristica7);
//
//		$_SESSION['InsBoletaDatoAdicional3'.$Identificador] = (empty($InsOrdenVentaVehiculo->EinNombre)?$InsOrdenVentaVehiculo->VmoNombre:$InsOrdenVentaVehiculo->EinNombre);
//		$_SESSION['InsBoletaDatoAdicional4'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica8)?$InsOrdenVentaVehiculo->EinCaracteristica8:$InsOrdenVentaVehiculo->VveCaracteristica8);
//
//		$_SESSION['InsBoletaDatoAdicional5'.$Identificador] = $InsOrdenVentaVehiculo->EinAnoFabricacion;
//		$_SESSION['InsBoletaDatoAdicional6'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica9)?$InsOrdenVentaVehiculo->EinCaracteristica9:$InsOrdenVentaVehiculo->VveCaracteristica9);
//
//		$_SESSION['InsBoletaDatoAdicional7'.$Identificador] = $InsOrdenVentaVehiculo->EinNumeroMotor;
//		$_SESSION['InsBoletaDatoAdicional8'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica10)?$InsOrdenVentaVehiculo->EinCaracteristica10:$InsOrdenVentaVehiculo->VveCaracteristica10);
//
//		$_SESSION['InsBoletaDatoAdicional9'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica1)?$InsOrdenVentaVehiculo->EinCaracteristica1:$InsOrdenVentaVehiculo->VveCaracteristica1);
//		$_SESSION['InsBoletaDatoAdicional10'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica11)?$InsOrdenVentaVehiculo->EinCaracteristica11:$InsOrdenVentaVehiculo->VveCaracteristica11);
//
//		$_SESSION['InsBoletaDatoAdicional11'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica2)?$InsOrdenVentaVehiculo->EinCaracteristica2:$InsOrdenVentaVehiculo->VveCaracteristica2);
//		$_SESSION['InsBoletaDatoAdicional12'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica12)?$InsOrdenVentaVehiculo->EinCaracteristica12:$InsOrdenVentaVehiculo->VveCaracteristica12);
//
//		$_SESSION['InsBoletaDatoAdicional13'.$Identificador] = $InsOrdenVentaVehiculo->EinVIN;
//		$_SESSION['InsBoletaDatoAdicional14'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica13)?$InsOrdenVentaVehiculo->EinCaracteristica13:$InsOrdenVentaVehiculo->VveCaracteristica13);
//
//		$_SESSION['InsBoletaDatoAdicional15'.$Identificador] = $InsOrdenVentaVehiculo->EinColor;
//		$_SESSION['InsBoletaDatoAdicional16'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica14)?$InsOrdenVentaVehiculo->EinCaracteristica14:$InsOrdenVentaVehiculo->VveCaracteristica14);
//
//	
//		$_SESSION['InsBoletaDatoAdicional17'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica3)?$InsOrdenVentaVehiculo->EinCaracteristica3:$InsOrdenVentaVehiculo->VveCaracteristica3);
//		$_SESSION['InsBoletaDatoAdicional18'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica15)?$InsOrdenVentaVehiculo->EinCaracteristica15:$InsOrdenVentaVehiculo->VveCaracteristica15);
//		
//		$_SESSION['InsBoletaDatoAdicional19'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica4)?$InsOrdenVentaVehiculo->EinCaracteristica4:$InsOrdenVentaVehiculo->VveCaracteristica4);
//		$_SESSION['InsBoletaDatoAdicional20'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica16)?$InsOrdenVentaVehiculo->EinCaracteristica16:$InsOrdenVentaVehiculo->VveCaracteristica16);
//		
//		$_SESSION['InsBoletaDatoAdicional21'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica5)?$InsOrdenVentaVehiculo->EinCaracteristica5:$InsOrdenVentaVehiculo->VveCaracteristica5);
//		$_SESSION['InsBoletaDatoAdicional22'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica17)?$InsOrdenVentaVehiculo->EinCaracteristica17:$InsOrdenVentaVehiculo->VveCaracteristica17);
//		
//		$_SESSION['InsBoletaDatoAdicional23'.$Identificador] = $InsOrdenVentaVehiculo->EinDUA;
//				
//	}
//	
//	
//					
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
////SesionObjeto-BoletaDetalleListado
////Parametro1 = BdeId
////Parametro2 = BdeDescripcion
////Parametro3
////Parametro4 = BdePrecio
////Parametro5 = BdeCantidad
////Parametro6 = BdeImporte
////Parametro7 = BdeTiempoCreacion
////Parametro8 = BdeTiempoModificacion
////Parametro9 = AmdId
////Parametro10 = AmoId
////Parametro11 =
////Parametro12 = BdeTipo
////Parametro13 = BdeUnidadMedida
////Parametro14 = VcdReingreso
////
////Parametro15 = AmdId
////Parametro16 = FatId
////Parametro17 = OvvId
////
////Parametro18 = BdeCodigo
////Parametro19 = BdeValorVenta
////Parametro20 = BdeImpuesto
////Parametro21 = BdeDescuento
////Parametro22 = BdeGratuito
////Parametro23 = BdeExonerado	
////*/
////			$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
////SesionObjeto-BoletaDetalleListado
////Parametro1 = BdeId
////Parametro2 = BdeDescripcion
////Parametro3
////Parametro4 = BdePrecio
////Parametro5 = BdeCantidad
////Parametro6 = BdeImporte
////Parametro7 = BdeTiempoCreacion
////Parametro8 = BdeTiempoModificacion
////Parametro9 = AmdId
////Parametro10 = AmoId
////Parametro11 =
////Parametro12 = BdeTipo
////Parametro13 = BdeUnidadMedida
////Parametro14 = VcdReingreso
////
////Parametro15 = AmdId
////Parametro16 = FatId
////Parametro17 = OvvId
////*/
////			$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
	
	global $InsBoleta;
	
	$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();
	$InsVehiculoMovimientoSalida->VmvId = $GET_VmvId;	
	$InsVehiculoMovimientoSalida->MtdObtenerVehiculoMovimientoSalida();
	

	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
	$InsOrdenVentaVehiculo->OvvId = $InsVehiculoMovimientoSalida->OvvId;	
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();	
	
	
	
	
	
	
	//$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
//	$InsOrdenVentaVehiculo->OvvId = $InsVehiculoMovimientoSalida->OvvId;
//	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
//	
//				
//						
//	if(!empty($InsOrdenVentaVehiculo->PerId)){
//		
//		$InsPersonal = new ClsPersonal();
//		$InsPersonal->PerId = $InsOrdenVentaVehiculo->PerId;
//		$InsPersonal->MtdObtenerPersonal();
//	
//	}
//	
//	$EmailPersonal = "";
//	$EmailPersonal = $CorreosNotificacionBienvenida.",";
//	
//	if(!empty($InsPersonal->PerEmail)){
//		
//		$EmailPersonal .= trim($InsPersonal->PerEmail).",";
//		
//	}	
//	
//	if(!empty($InsOrdenVentaVehiculo->CliEmail)){
//		
//		$EmailPersonal .= trim($InsOrdenVentaVehiculo->CliEmail).",";
//		
//	}
//
//echo "<br>";
//echo "<br>";
//echo "<br>";
//echo "<br>";
//echo "<br>";		
//echo "EmailPersonal: ";
//echo $EmailPersonal;
//echo "<br>";







//	deb($InsVehiculoMovimientoSalida->OvvId);
	$InsBoleta->OvvId = $InsOrdenVentaVehiculo->OvvId;
	$InsBoleta->CveId = $InsOrdenVentaVehiculo->CveId;
	
	$InsBoleta->CliId = $InsOrdenVentaVehiculo->CliId;		
	$InsBoleta->CliNombre = $InsOrdenVentaVehiculo->CliNombre;
	$InsBoleta->CliApellidoPaterno = $InsOrdenVentaVehiculo->CliApellidoPaterno;
	$InsBoleta->CliApellidoMaterno = $InsOrdenVentaVehiculo->CliApellidoMaterno;
	$InsBoleta->CliEmail = $InsOrdenVentaVehiculo->CliEmail;
	
	$InsBoleta->TdoId = $InsOrdenVentaVehiculo->TdoId;
	$InsBoleta->CliNumeroDocumento = $InsOrdenVentaVehiculo->CliNumeroDocumento;
	$InsBoleta->BolDireccion = $InsOrdenVentaVehiculo->CliDireccion." - ".$InsOrdenVentaVehiculo->CliDistrito." - ".$InsOrdenVentaVehiculo->CliProvincia." - ".$InsOrdenVentaVehiculo->CliDepartamento;
	
	$InsBoleta->BolTelefono = $InsOrdenVentaVehiculo->CliTelefono;		
	$InsBoleta->BolIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;	
	$InsBoleta->BolEstado = 5; 
	$InsBoleta->BolObservado = 2;
	
	$InsOrdenVentaVehiculo->OvvObservacion = strip_tags($InsOrdenVentaVehiculo->OvvObservacion);
	$InsBoleta->BolObservacion = $InsOrdenVentaVehiculo->OvvObservacion.chr(13).date("d/m/Y H:i:s")." - Boleta autogenerada de Ord. Ven. Veh.: ".$InsBoleta->OvvId." / Prof. Veh: ".$InsBoleta->CveId;
	
	$InsBoleta->MonId = $InsOrdenVentaVehiculo->MonId;		
	$InsBoleta->BolTipoCambio = $InsOrdenVentaVehiculo->VcoTipoCambio;		

	//$InsBoleta->BolIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;		
	$InsBoleta->BolIncluyeImpuesto = 1;		
	$InsBoleta->BolPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsBoleta->BolPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
	
	$InsBoleta->BolVendedor = $InsOrdenVentaVehiculo->UsuUsuario;	
	$InsBoleta->BolNumeroPedido = $InsOrdenVentaVehiculo->OvvId;	
	
	if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId ){

		$InsOrdenVentaVehiculo->OvvTotal = ($InsOrdenVentaVehiculo->OvvTotal  / $InsOrdenVentaVehiculo->OvvTipoCambio);
		$InsOrdenVentaVehiculo->OvvSubTotal = ($InsOrdenVentaVehiculo->OvvSubTotal  / $InsOrdenVentaVehiculo->OvvTipoCambio);
		$InsOrdenVentaVehiculo->OvvImpuesto = ($InsOrdenVentaVehiculo->OvvImpuesto  / $InsOrdenVentaVehiculo->OvvTipoCambio);

	}


/*
SesionObjeto-BoletaDetalleListado
Parametro1 = BdeId
Parametro2 = BdeDescripcion
Parametro3
Parametro4 = BdePrecio
Parametro5 = BdeCantidad
Parametro6 = BdeImporte
Parametro7 = BdeTiempoCreacion
Parametro8 = BdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = BdeTipo
Parametro13 = BdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = BdeCodigo
Parametro19 = BdeValorVenta
Parametro20 = BdeImpuesto
Parametro21 = BdeDescuento
Parametro22 = BdeGratuito
Parametro23 = BdeExonerado

Parametro24 = BdeIncluyeSelectivo
Parametro25 = BdeImpuestoSelectivo
*/		
		
		
//		if($InsBoleta->BolIncluyeImpuesto == 2){
//			$InsVentaConcretada->VcoManoObra = $InsVentaConcretada->VcoManoObra + ($InsOrdenVentaVehiculo->VcoManoObra * ($InsBoleta->BolPorcentajeImpuestoVenta/100));
//		}
				
	$Cantidad = 1;
	
	if($InsOrdenVentaVehiculo->OvvIncluyeImpuesto == 2){				
		$InsOrdenVentaVehiculo->OvvTotal = $InsOrdenVentaVehiculo->OvvTotal + ($InsOrdenVentaVehiculo->OvvTotal * ($InsBoleta->BolPorcentajeImpuestoVenta/100));
	}
				
	$PrecioVenta = $InsOrdenVentaVehiculo->OvvTotal;
	$Importe = round($PrecioVenta * $Cantidad,2);
	
	$InsOrdenVentaVehiculo->OvvValorVenta = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
	$InsOrdenVentaVehiculo->OvvImpuesto = $Importe  - $InsOrdenVentaVehiculo->OvvValorVenta;
						
//	if($InsBoleta->BolIncluyeImpuesto == 1){
//		$InsOrdenVentaVehiculo->OvvValorVenta = $InsOrdenVentaVehiculo->OvvTotal /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
//		$InsOrdenVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvTotal - $InsOrdenVentaVehiculo->OvvValorVenta;
//	}else{
//		$InsOrdenVentaVehiculo->OvvValorVenta = $InsOrdenVentaVehiculo->OvvTotal;
//		$InsOrdenVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvValorVenta * ($InsBoleta->BolPorcentajeImpuestoVenta/100);
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
SesionObjeto-BoletaDetalleListado
Parametro1 = BdeId
Parametro2 = BdeDescripcion
Parametro3
Parametro4 = BdePrecio
Parametro5 = BdeCantidad
Parametro6 = BdeImporte
Parametro7 = BdeTiempoCreacion
Parametro8 = BdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = BdeTipo
Parametro13 = BdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = BdeCodigo
Parametro19 = BdeValorVenta
Parametro20 = BdeImpuesto
Parametro21 = BdeDescuento
Parametro22 = BdeGratuito
Parametro23 = BdeExonerado

Parametro24 = BdeIncluyeSelectivo
Parametro25 = BdeImpuestoSelectivo
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

	$InsBoleta->BolObservacionImpresa = "".$Obsequios;

	$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
		
		$_SESSION['InsBoletaDatoAdicional1'.$Identificador] = $InsOrdenVentaVehiculo->VmaNombre;
		$_SESSION['InsBoletaDatoAdicional2'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica7)?$InsOrdenVentaVehiculo->EinCaracteristica7:$InsOrdenVentaVehiculo->VveCaracteristica7);

		$_SESSION['InsBoletaDatoAdicional3'.$Identificador] = (empty($InsOrdenVentaVehiculo->EinNombre)?$InsOrdenVentaVehiculo->VmoNombre:$InsOrdenVentaVehiculo->EinNombre);
		$_SESSION['InsBoletaDatoAdicional4'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica8)?$InsOrdenVentaVehiculo->EinCaracteristica8:$InsOrdenVentaVehiculo->VveCaracteristica8);

		$_SESSION['InsBoletaDatoAdicional5'.$Identificador] = $InsOrdenVentaVehiculo->EinAnoFabricacion;
		//$_SESSION['InsBoletaDatoAdicional5'.$Identificador] = $InsOrdenVentaVehiculo->EinAnoModelo;
		$_SESSION['InsBoletaDatoAdicional27'.$Identificador] = $InsOrdenVentaVehiculo->EinAnoModelo;
		
		
		$_SESSION['InsBoletaDatoAdicional6'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica9)?$InsOrdenVentaVehiculo->EinCaracteristica9:$InsOrdenVentaVehiculo->VveCaracteristica9);

		$_SESSION['InsBoletaDatoAdicional7'.$Identificador] = $InsOrdenVentaVehiculo->EinNumeroMotor;
		$_SESSION['InsBoletaDatoAdicional8'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica10)?$InsOrdenVentaVehiculo->EinCaracteristica10:$InsOrdenVentaVehiculo->VveCaracteristica10);

		$_SESSION['InsBoletaDatoAdicional9'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica1)?$InsOrdenVentaVehiculo->EinCaracteristica1:$InsOrdenVentaVehiculo->VveCaracteristica1);
		$_SESSION['InsBoletaDatoAdicional10'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica11)?$InsOrdenVentaVehiculo->EinCaracteristica11:$InsOrdenVentaVehiculo->VveCaracteristica11);

		$_SESSION['InsBoletaDatoAdicional11'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica2)?$InsOrdenVentaVehiculo->EinCaracteristica2:$InsOrdenVentaVehiculo->VveCaracteristica2);
		$_SESSION['InsBoletaDatoAdicional12'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica12)?$InsOrdenVentaVehiculo->EinCaracteristica12:$InsOrdenVentaVehiculo->VveCaracteristica12);

		$_SESSION['InsBoletaDatoAdicional13'.$Identificador] = $InsOrdenVentaVehiculo->EinVIN;
		$_SESSION['InsBoletaDatoAdicional14'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica13)?$InsOrdenVentaVehiculo->EinCaracteristica13:$InsOrdenVentaVehiculo->VveCaracteristica13);

		$_SESSION['InsBoletaDatoAdicional15'.$Identificador] = $InsOrdenVentaVehiculo->EinColor;
		$_SESSION['InsBoletaDatoAdicional16'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica14)?$InsOrdenVentaVehiculo->EinCaracteristica14:$InsOrdenVentaVehiculo->VveCaracteristica14);

	
		$_SESSION['InsBoletaDatoAdicional17'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica3)?$InsOrdenVentaVehiculo->EinCaracteristica3:$InsOrdenVentaVehiculo->VveCaracteristica3);
		$_SESSION['InsBoletaDatoAdicional18'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica15)?$InsOrdenVentaVehiculo->EinCaracteristica15:$InsOrdenVentaVehiculo->VveCaracteristica15);
		
		$_SESSION['InsBoletaDatoAdicional19'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica4)?$InsOrdenVentaVehiculo->EinCaracteristica4:$InsOrdenVentaVehiculo->VveCaracteristica4);
		$_SESSION['InsBoletaDatoAdicional20'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica16)?$InsOrdenVentaVehiculo->EinCaracteristica16:$InsOrdenVentaVehiculo->VveCaracteristica16);
		
		$_SESSION['InsBoletaDatoAdicional21'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica5)?$InsOrdenVentaVehiculo->EinCaracteristica5:$InsOrdenVentaVehiculo->VveCaracteristica5);
		$_SESSION['InsBoletaDatoAdicional22'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica17)?$InsOrdenVentaVehiculo->EinCaracteristica17:$InsOrdenVentaVehiculo->VveCaracteristica17);
		
		$_SESSION['InsBoletaDatoAdicional23'.$Identificador] = $InsOrdenVentaVehiculo->EinDUA;
		
		$_SESSION['InsBoletaDatoAdicional24'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica18)?$InsOrdenVentaVehiculo->EinCaracteristica18:$InsOrdenVentaVehiculo->VveCaracteristica18);
		
		$_SESSION['InsBoletaDatoAdicional25'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica19)?$InsOrdenVentaVehiculo->EinCaracteristica19:$InsOrdenVentaVehiculo->VveCaracteristica19);
		
		$_SESSION['InsBoletaDatoAdicional26'.$Identificador] = (!empty($InsOrdenVentaVehiculo->EinCaracteristica20)?$InsOrdenVentaVehiculo->EinCaracteristica20:$InsOrdenVentaVehiculo->VveCaracteristica20);
				
	}
	
	if(!empty($InsVehiculoMovimientoSalida->VmvId)){
						
//SesionObjeto-BoletaAlmacenMovimiento
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


						$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
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
	
	global $InsBoleta;
	
	$InsPago->PagId = $GET_PagId;
	$InsPago->MtdObtenerPago();		
	
	if($InsPago->MonId<>$EmpresaMonedaId ){
		$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
	}
	
	
	$InsBoleta->PagId = $InsPago->PagId;
	
	$InsBoleta->CliId = $InsPago->CliId;		
	$InsBoleta->CliNombre = $InsPago->CliNombre;
	$InsBoleta->CliApellidoPaterno = $InsPago->CliApellidoPaterno;
	$InsBoleta->CliApellidoMaterno = $InsPago->CliApellidoMaterno;
	
	$InsBoleta->TdoId = $InsPago->TdoId;
	$InsBoleta->CliNumeroDocumento = $InsPago->CliNumeroDocumento;
	$InsBoleta->BolDireccion = $InsPago->CliDireccion." - ".$InsPago->CliDistrito." - ".$InsPago->CliProvincia." - ".$InsPago->CliDepartamento;
	
	$InsBoleta->BolTelefono = $InsPago->CliTelefono;		
	$InsBoleta->BolIncluyeImpuesto = 1;	
	$InsBoleta->BolEstado = 5;
	$InsBoleta->BolObservado = 2;
	
	$InsOrdenVentaVehiculo->OvvObservacion = strip_tags($InsPago->PagObservacion);
	$InsBoleta->BolObservacion = $InsPago->PagObservacion.chr(13).date("d/m/Y H:i:s")." - Boleta autogenerada de Pago: ".$InsBoleta->PagId;
	$InsBoleta->BolObservacionImpresa = "En caso desista de la compra, se retendrá el 50% del valor total por gastos operativos generados";
	
	$InsBoleta->MonId = $InsPago->MonId;		
	$InsBoleta->BolTipoCambio = $InsPago->PagTipoCambio;		

	//$InsBoleta->BolIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;		
	$InsBoleta->BolIncluyeImpuesto = 1;		
	$InsBoleta->BolPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsBoleta->BolPorcentajeImpuestoSelectivo = $EmpresaImpuestoSelectivo;
	

	$NumeroPedido = "";
	
	if(!empty($InsPago->PagoComprobante)){
		
		foreach($InsPago->PagoComprobante as $DatPagoComprobante){
			
			$OrdenVentaVehiculoId = $DatPagoComprobante->OvvId;
			$VentaDirectaId = $DatPagoComprobante->VdiId;
			
		}
		
	}
	
	$NumeroPedido = $OrdenVentaVehiculoId."".$VentaDirectaId;
	
	$InsBoleta->BolVendedor = "";	
	$InsBoleta->BolNumeroPedido = $NumeroPedido ;	
	

/*
SesionObjeto-BoletaDetalleListado
Parametro1 = BdeId
Parametro2 = BdeDescripcion
Parametro3
Parametro4 = BdePrecio
Parametro5 = BdeCantidad
Parametro6 = BdeImporte
Parametro7 = BdeTiempoCreacion
Parametro8 = BdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = BdeTipo
Parametro13 = BdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = BdeCodigo
Parametro19 = BdeValorVenta
Parametro20 = BdeImpuesto
Parametro21 = BdeDescuento
Parametro22 = BdeGratuito
Parametro23 = BdeExonerado

Parametro24 = BdeIncluyeSelectivo
Parametro25 = BdeImpuestoSelectivo
*/		
		
			
	$Cantidad = 1;
		
	$PrecioVenta = $InsPago->PagMonto;
	$Importe = round($PrecioVenta * $Cantidad,2);
	
	$ValorVenta = $Importe /((($InsBoleta->BolPorcentajeImpuestoVenta)/100)+1);
	$Impuesto = $Importe  - $ValorVenta;
						

/*
SesionObjeto-BoletaDetalleListado
Parametro1 = BdeId
Parametro2 = BdeDescripcion
Parametro3
Parametro4 = BdePrecio
Parametro5 = BdeCantidad
Parametro6 = BdeImporte
Parametro7 = BdeTiempoCreacion
Parametro8 = BdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = BdeTipo
Parametro13 = BdeUnidadMedida
Parametro14 = VcdReingreso

Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = BdeCodigo
Parametro19 = BdeValorVenta
Parametro20 = BdeImpuesto
Parametro21 = BdeDescuento
Parametro22 = BdeGratuito
Parametro23 = BdeExonerado

Parametro24 = BdeIncluyeSelectivo
Parametro25 = BdeImpuestoSelectivo
Parametro26 = VmdId
*/		

	
	$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
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
