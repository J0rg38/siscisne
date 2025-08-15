<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsFactura->FacId = $_POST['CmpId'];
	$InsFactura->FtaId = $_POST['CmpTalonario'];
	$InsFactura->CliId = $_POST['CmpClienteId'];
	
	$InsFactura->UsuId = $_SESSION['SesionId'];
	$InsFactura->UsuUsuario = $_SESSION['SesionUsuario'];
	$InsFactura->SucId = $_SESSION['SesionSucursal'];
	
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
		
	$InsFactura->FacCancelado = $_POST['CmpCancelado'];
	$InsFactura->FacObsequio = $_POST['CmpObsequio'];
	$InsFactura->FacSpot = $_POST['CmpSpot'];
	
	$InsFactura->FacIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsFactura->FacConcepto = addslashes($_POST['CmpConcepto']);
	

	$InsFactura->FacAbono = preg_replace("/,/", "", (empty($_POST['CmpAbono'])?0:$_POST['CmpAbono']));
	
	
	//$InsFactura->FacTipo = $_POST['CmpTipo'];
	$InsFactura->FacTipo = 1;
	$InsFactura->FacEstado = $_POST['CmpEstado'];

	$InsFactura->FacPorcentajeImpuestoVenta = ($_POST['CmpPorcentajeImpuestoVenta']);
	$InsFactura->FacPorcentajeImpuestoSelectivo = ($_POST['CmpPorcentajeImpuestoSelectivo']);
			
	$InsFactura->FacFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	//$InsFactura->FacFechaVencimiento = FncCambiaFechaAMysql($_POST['CmpFechaVencimiento'],true);	

	$FechaVencimiento = NULL;
	
//deb("");deb("");deb("");deb("");deb("");
//deb($InsFactura->FacCantidadDia);
		
		
	if($InsFactura->FacCantidadDia>0){
		// $FechaVencimiento = date("d/m/Y",strtotime($_POST['CmpFechaEmision']." + ".$InsFactura->FacCantidadDia." days"));
		$FechaVencimiento = strtotime('+'.$InsFactura->FacCantidadDia.' day', strtotime($InsFactura->FacFechaEmision));;
		$FechaVencimiento = date('d/m/Y', $FechaVencimiento);
	}
	




	//deb($FechaVencimiento);
	
	$InsFactura->FacFechaVencimiento = FncCambiaFechaAMysql($FechaVencimiento,true);
	
	
	$InsFactura->FacObservacion = addslashes($_POST['CmpObservacion'])."###".addslashes($_POST['CmpObservacionImpresa']);
	$InsFactura->FacObservacionCaja = addslashes($_POST['CmpObservacionCaja']);
	$InsFactura->FacLeyenda = addslashes($_POST['CmpLeyenda']);
		
	$InsFactura->FacCierre = $_POST['CmpCierre'];
	$InsFactura->FacObservado = $_POST['CmpObservado'];
	
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
	
	if($InsFactura->MonId<>$EmpresaMonedaId){
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
	
//	if(!empty($InsFactura->OvvId)){
//		if($InsFactura->CliEmail){
//			$Guardar = false;
//			$Resultado.='#ERR_FAC_124';
//		}
//	}	
//	
	
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

Parametro18 = FdeCodigo
Parametro19 = FdeValorVenta
Parametro20 = FdeImpuesto
Parametro21 = FdeDescuento
Parametro22 = FdeGratuito
Parametro23 = FdeExonerado

Parametro24 = FdeIncluyeSelectivo
Parametro25 = FdeImpuestoSelectivo
*/	

	$InsFactura->FacTotalBruto = 0;
	$InsFactura->FacTotalGravado = 0;
	$InsFactura->FacTotalExonerado = 0;
//	$InsFactura->FacTotalDescuento = 0;
	$InsFactura->FacTotalGratuito = 0;
	$InsFactura->FacTotalDescuentoNoExonerado = 0;
	$InsFactura->FacTotalValorBruto = 0;
	$InsFactura->FacTotalPagar= 0;
	$InsFactura->FacTotalImpuestoSelectivo= 0;
 
	$InsFactura->FacSubTotal = 0;
	$InsFactura->FacImpuesto = 0;
	$InsFactura->FacTotal = 0;

	$ResFacturaDetalle = $_SESSION['InsFacturaDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
	
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



			if($InsFacturaDetalle1->FdeTipo<>"T"){
				$InsFacturaDetalle1->FdeDescripcion = (utf8_encode($DatSesionObjeto->Parametro2));	
			}else{
				$InsFacturaDetalle1->FdeDescripcion = (utf8_encode(($DatSesionObjeto->Parametro2)));
			}
			
			$InsFacturaDetalle1->FdePrecio  = $DatSesionObjeto->Parametro4;
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
			
			$InsFactura->FacturaDetalle[] = $InsFacturaDetalle1;	
			
			if($InsFacturaDetalle1->FdeEliminado==1){		
				
				
				$InsFactura->FacTotalBruto += $InsFacturaDetalle1->FdeImporte;	
									
				//EXONERADO
				if($InsFacturaDetalle1->FdeExonerado == 1){						
					//$InsFactura->FacTotalExonerado += $InsFacturaDetalle1->FdeValorVenta - $InsFacturaDetalle1->FdeDescuento;
					$InsFactura->FacTotalExonerado += $InsFacturaDetalle1->FdeValorVenta;
				}
				
				//GRAVADO
				if($InsFacturaDetalle1->FdeExonerado == 2 and $InsFacturaDetalle1->FdeGratuito == 2){			
					//$InsFactura->FacTotalGravado += $InsFacturaDetalle1->FdeValorVenta - $InsFacturaDetalle1->FdeDescuento;
					$InsFactura->FacTotalGravado += $InsFacturaDetalle1->FdeValorVenta;
				}
				
				//VALOR BRUTO
				if($InsFacturaDetalle1->FdeGratuito == 2){		
					//$InsFactura->FacTotalValorBruto += $InsFacturaDetalle1->FdeValorVenta - $InsFacturaDetalle1->FdeDescuento;
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

	$ResFacturaAlmacenMovimiento = $_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]->MtdObtenerSesionObjetos(false);//OJO

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
	
	//if($InsFactura->FacTipo == "2"){
//		$InsFactura->FacTotalBruto = preg_replace("/,/", "", $_POST['CmpTotal']);
//	}
	
//	if($InsFactura->FacPorcentajeDescuento>0){
//		$InsFactura->FacTotalExonerado = $InsFactura->FacTotalExonerado - ($InsFactura->FacTotalExonerado * ($InsFactura->FacPorcentajeDescuento/100));
//		$InsFactura->FacTotalGravado =  $InsFactura->FacTotalGravado - ($InsFactura->FacTotalGravado * ($InsFactura->FacPorcentajeDescuento/100));
//		$InsFactura->FacTotalDescuento = $InsFactura->FacTotalDescuento + ($InsFactura->FacTotalValorBruto * ($InsFactura->FacPorcentajeDescuento/100));
//	}

	$InsFactura->FacSubTotal = ($InsFactura->FacTotalGravado);
	$InsFactura->FacImpuesto = (($InsFactura->FacSubTotal + $InsFactura->FacTotalImpuestoSelectivo ) * ($InsFactura->FacPorcentajeImpuestoVenta/100));
	$InsFactura->FacTotal = ($InsFactura->FacSubTotal + $InsFactura->FacTotalImpuestoSelectivo +  $InsFactura->FacTotalExonerado + $InsFactura->FacImpuesto);

	if(!empty($InsFactura->RegId)){
		if($InsFactura->RegAplicacion==1){
			$InsFactura->FacTotalReal = $InsFactura->FacTotal - $InsFactura->FacRegimenMonto;
	
		}elseif($InsFactura->RegAplicacion == 2){
			$InsFactura->FacTotalReal = $InsFactura->FacTotal + $InsFactura->FacRegimenMonto;					
		}
	}else{
		$InsFactura->FacTotalReal = $InsFactura->FacTotal;
	}	
	
	
	if($Guardar){
		if($InsFactura->MtdEditarFactura()){
			
			if($InsFactura->FacNotificar=="1"){
				$InsFactura->MtdNotificarFacturaRegistro($InsFactura->FacId,$InsFactura->FtaId,$CorreosNotificacionFacturaRegistro);
			}
			
?>
			<script type="text/javascript">
				$().ready(function() {
				/*
				Configuracion carga de datos y animacion
				*/			
					//FncPopUp('formularios/Factura/FrmFacturaGenerarXML.php?Id=<?php echo $InsFactura->FacId;?>&Ta=<?php echo $InsFactura->FtaId;?>&P=1',0,0,1,0,0,1,0,350,150);

				});
			</script>
<?php	
			$Edito = true;		
			$Resultado.='#SAS_FAC_102';
			FncCargarDatos();
		} else{
			$Resultado.='#ERR_FAC_102';
			$InsFactura->FacFechaEmision = FncCambiaFechaANormal($InsFactura->FacFechaEmision);
			$InsFactura->FacOrdenFecha = FncCambiaFechaANormal($InsFactura->FacOrdenFecha,true);
			$InsFactura->FacFechaVencimiento = FncCambiaFechaANormal($InsFactura->FacFechaVencimiento,true);
			
			list($InsFactura->FacObservacion,$InsFactura->FacObservacionImpresa) = explode("###",$InsFactura->FacObservacion);
			
			if($InsFactura->MonId<>$EmpresaMonedaId){
				
				$InsFactura->FacRegimenMonto = round($InsFactura->FacRegimenMonto / $InsFactura->FacTipoCambio,2);
				$InsFactura->FacTotalDescuento = round($InsFactura->FacTotalDescuento / $InsFactura->FacTipoCambio,2);

				$InsFactura->FacAbono = round($InsFactura->FacAbono / $InsFactura->FacTipoCambio,2);

			}
			
		
			
	
		}
	}else{
		$InsFactura->FacFechaEmision = FncCambiaFechaANormal($InsFactura->FacFechaEmision);
		$InsFactura->FacOrdenFecha = FncCambiaFechaANormal($InsFactura->FacOrdenFecha,true);
		$InsFactura->FacFechaVencimiento = FncCambiaFechaANormal($InsFactura->FacFechaVencimiento,true);
		
		list($InsFactura->FacObservacion,$InsFactura->FacObservacionImpresa) = explode("###",$InsFactura->FacObservacion);

		if($InsFactura->MonId<>$EmpresaMonedaId){
			
			$InsFactura->FacRegimenMonto = round($InsFactura->FacRegimenMonto / $InsFactura->FacTipoCambio,2);
			$InsFactura->FacTotalDescuento = round($InsFactura->FacTotalDescuento / $InsFactura->FacTipoCambio,2);
			
			$InsFactura->FacAbono = round($InsFactura->FacAbono / $InsFactura->FacTipoCambio,2);
			
		}
		
			
	}

}else{
	
	FncCargarDatos();
	
}


function FncCargarDatos(){

	global $GET_id;
	global $GET_ta;
	global $Identificador;	
	global $InsFactura;
	global $EmpresaMonedaId;
	global $CorreosNotificacionBienvenida;

	unset($_SESSION['InsFacturaDetalle'.$Identificador]);	
	unset($_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]);

	$_SESSION['InsFacturaDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFacturaAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();

	$InsFactura->FacId = $GET_id;
	$InsFactura->FtaId = $GET_ta;
	$InsFactura->MtdObtenerFactura();		
	
	//$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
//	$InsOrdenVentaVehiculo->OvvId = $InsFactura->OvvId;
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


	$_SESSION['InsFacturaDatoAdicional1'.$Identificador] = $InsFactura->FacDatoAdicional1;
	$_SESSION['InsFacturaDatoAdicional2'.$Identificador] = $InsFactura->FacDatoAdicional2;
	$_SESSION['InsFacturaDatoAdicional3'.$Identificador] = $InsFactura->FacDatoAdicional3;
	$_SESSION['InsFacturaDatoAdicional4'.$Identificador] = $InsFactura->FacDatoAdicional4;
	$_SESSION['InsFacturaDatoAdicional5'.$Identificador] = $InsFactura->FacDatoAdicional5;
	$_SESSION['InsFacturaDatoAdicional6'.$Identificador] = $InsFactura->FacDatoAdicional6;
	$_SESSION['InsFacturaDatoAdicional7'.$Identificador] = $InsFactura->FacDatoAdicional7;
	
	$_SESSION['InsFacturaDatoAdicional8'.$Identificador] = $InsFactura->FacDatoAdicional8;
	$_SESSION['InsFacturaDatoAdicional9'.$Identificador] = $InsFactura->FacDatoAdicional9;
	$_SESSION['InsFacturaDatoAdicional10'.$Identificador] = $InsFactura->FacDatoAdicional10;
	
	$_SESSION['InsFacturaDatoAdicional11'.$Identificador] = $InsFactura->FacDatoAdicional11;
	$_SESSION['InsFacturaDatoAdicional12'.$Identificador] = $InsFactura->FacDatoAdicional12;
	$_SESSION['InsFacturaDatoAdicional13'.$Identificador] = $InsFactura->FacDatoAdicional13;
	$_SESSION['InsFacturaDatoAdicional14'.$Identificador] = $InsFactura->FacDatoAdicional14;
	$_SESSION['InsFacturaDatoAdicional15'.$Identificador] = $InsFactura->FacDatoAdicional15;
	$_SESSION['InsFacturaDatoAdicional16'.$Identificador] = $InsFactura->FacDatoAdicional16;
	$_SESSION['InsFacturaDatoAdicional17'.$Identificador] = $InsFactura->FacDatoAdicional17;
	$_SESSION['InsFacturaDatoAdicional18'.$Identificador] = $InsFactura->FacDatoAdicional18;
	$_SESSION['InsFacturaDatoAdicional19'.$Identificador] = $InsFactura->FacDatoAdicional19;
	$_SESSION['InsFacturaDatoAdicional20'.$Identificador] = $InsFactura->FacDatoAdicional20;
	
	$_SESSION['InsFacturaDatoAdicional21'.$Identificador] = $InsFactura->FacDatoAdicional21;
	$_SESSION['InsFacturaDatoAdicional22'.$Identificador] = $InsFactura->FacDatoAdicional22;
	$_SESSION['InsFacturaDatoAdicional23'.$Identificador] = $InsFactura->FacDatoAdicional23;
	$_SESSION['InsFacturaDatoAdicional24'.$Identificador] = $InsFactura->FacDatoAdicional24;
	$_SESSION['InsFacturaDatoAdicional25'.$Identificador] = $InsFactura->FacDatoAdicional25;
	$_SESSION['InsFacturaDatoAdicional26'.$Identificador] = $InsFactura->FacDatoAdicional26;
	$_SESSION['InsFacturaDatoAdicional27'.$Identificador] = $InsFactura->FacDatoAdicional27;
	$_SESSION['InsFacturaDatoAdicional28'.$Identificador] = $InsFactura->FacDatoAdicional28;

	if($InsFactura->FacTipo == "1"){
//		$InsFactura->FacTotal = 
	}
	
//	if($InsFactura->MonId<>$EmpresaMonedaId){
	if($InsFactura->MonId<>$EmpresaMonedaId){
		
		$InsFactura->FacRegimenMonto = round($InsFactura->FacRegimenMonto/$InsFactura->FacTipoCambio,2);
		$InsFactura->FacTotalDescuento = round($InsFactura->FacTotalDescuento/$InsFactura->FacTipoCambio,2);
		
		$InsFactura->FacAbono = round($InsFactura->FacAbono/$InsFactura->FacTipoCambio,2);
		
	}
	
	if(!empty($InsFactura->FacturaDetalle)){
		foreach($InsFactura->FacturaDetalle as $DatFacturaDetalle){
			

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


			if($InsFactura->MonId<>$EmpresaMonedaId ){

				$DatFacturaDetalle->FdeImporte = ($DatFacturaDetalle->FdeImporte / $InsFactura->FacTipoCambio);
				$DatFacturaDetalle->FdePrecio = ($DatFacturaDetalle->FdePrecio  / $InsFactura->FacTipoCambio);
				
				$DatFacturaDetalle->FdeValorVenta = ($DatFacturaDetalle->FdeValorVenta  / $InsFactura->FacTipoCambio);
				$DatFacturaDetalle->FdeImpuesto = ($DatFacturaDetalle->FdeImpuesto  / $InsFactura->FacTipoCambio);
				$DatFacturaDetalle->FdeDescuento = ($DatFacturaDetalle->FdeDescuento  / $InsFactura->FacTipoCambio);

			}

			$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatFacturaDetalle->FdeId,
			utf8_decode($DatFacturaDetalle->FdeDescripcion),
			NULL,
			($DatFacturaDetalle->FdePrecio),
			($DatFacturaDetalle->FdeCantidad),
			($DatFacturaDetalle->FdeImporte),
			($DatFacturaDetalle->FdeTiempoCreacion),
			($DatFacturaDetalle->FdeTiempoModificacion),
			NULL,//EX AMDID
			$DatFacturaDetalle->AmoId,
			NULL,
			$DatFacturaDetalle->FdeTipo,
			$DatFacturaDetalle->FdeUnidadMedida,
			$DatFacturaDetalle->FdeReingreso,
			
			$DatFacturaDetalle->AmdId,
			$DatFacturaDetalle->FatId,
			$DatFacturaDetalle->OvvId,
			
			$DatFacturaDetalle->FdeCodigo,
			$DatFacturaDetalle->FdeValorVenta,
			$DatFacturaDetalle->FdeImpuesto,
			$DatFacturaDetalle->FdeDescuento,
			$DatFacturaDetalle->FdeGratuito,
			$DatFacturaDetalle->FdeExonerado,
			
			$DatFacturaDetalle->FdeIncluyeSelectivo,
			$DatFacturaDetalle->FdeImpuestoSelectivo,
			$DatFacturaDetalle->AmdCompraOrigen);
			

		}
	}
	

	if(!empty($InsFactura->FacturaAlmacenMovimiento)){
		foreach($InsFactura->FacturaAlmacenMovimiento as $DatFacturaAlmacenMovimiento){

			$_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatFacturaAlmacenMovimiento->FamId,
			$DatFacturaAlmacenMovimiento->AmoId,
			NULL,
			NULL,
			1,
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s"),
			$DatFacturaAlmacenMovimiento->FinId,
			$DatFacturaAlmacenMovimiento->FccId,
			
			$DatFacturaAlmacenMovimiento->AmoFecha,
			$DatFacturaAlmacenMovimiento->AmoSubTipo,
			$DatFacturaAlmacenMovimiento->VmvId,
			$DatFacturaAlmacenMovimiento->VmvFecha,
			$DatFacturaAlmacenMovimiento->VmvSubTipo
			);

		}
	}

	
}

?>