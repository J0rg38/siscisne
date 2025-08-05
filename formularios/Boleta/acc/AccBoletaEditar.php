<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	//$Identificador = $_POST['Identificador'];
	
	$Resultado = '';
	$Guardar = true;
	
	
	$InsBoleta->BolId = $_POST['CmpId'];
	
	$InsBoleta->UsuId = $_SESSION['SesionId'];
	$InsBoleta->SucId = $_SESSION['SesionSucursal'];
	
	$InsBoleta->BtaId = $_POST['CmpTalonario'];	
	$InsBoleta->CliId = $_POST['CmpClienteId'];	

	$InsBoleta->NpaId = $_POST['CmpCondicionPago'];	
	$InsBoleta->BolCantidadDia = isset($_POST['CmpCantidadDia'])?$_POST['CmpCantidadDia']:0;

	$InsBoleta->MonId = $_POST['CmpMonedaId'];
	$InsBoleta->BolTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsBoleta->BolAbono = eregi_replace(",","",(empty($_POST['CmpAbono'])?0:$_POST['CmpAbono']));
	
	$InsBoleta->BolObsequio = $_POST['CmpObsequio'];
	$InsBoleta->BolEstado = $_POST['CmpEstado'];			
	$InsBoleta->BolFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	//$InsBoleta->BolFechaVencimiento = FncCambiaFechaAMysql($_POST['CmpFechaVencimiento'],true);
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
	
	$InsBoleta->BolObservado = $_POST['CmpObservado'];
	$InsBoleta->BolCierre = $_POST['CmpCierre'];
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
	$InsBoleta->BolRegimenMonto = eregi_replace(",","",$_POST['CmpRegimenMonto']);
	
	if($InsBoleta->MonId<>$EmpresaMonedaId and !empty($InsBoleta->BolTipoCambio)){
		$InsBoleta->BolRegimenMonto = $InsBoleta->BolRegimenMonto * $InsBoleta->BolTipoCambio;
	}
		
	$InsBoleta->FinId = $_POST['CmpFichaIngresoId'];
	$InsBoleta->AmoId = $_POST['CmpAlmacenMovimientoSalidaIdAux'];
	$InsBoleta->FccId = $_POST['CmpFichaAccionId'];
	$InsBoleta->CprId = $_POST['CmpCotizacionProductoId'];

	$InsBoleta->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	$InsBoleta->CveId = $_POST['CmpCotizacionVehiculoId'];
	
		$InsBoleta->PagId = $_POST['CmpPagoId'];
		
		
		$InsBoleta->BolProcesar = $_POST['CmpProcesar'];
	$InsBoleta->BolEnviarSUNAT = $_POST['CmpEnviarSUNAT'];
	
	$InsBoleta->BolUsuario = $_POST['CmpUsuario'];
	$InsBoleta->BolVendedor = $_POST['CmpVendedor'];
	$InsBoleta->BolNumeroPedido = $_POST['CmpNumeroPedido'];
	
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
	
	//if(!empty($InsBoleta->OvvId)){
//		if($InsBoleta->CliEmail){
//			$Guardar = false;
//			$Resultado.='#ERR_BOL_124';
//		}
//	}	
	
	
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


	$ResBoletaDetalle = $_SESSION['InsBoletaDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

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
			//$InsBoletaDetalle1->AmdId = $DatSesionObjeto->Parametro9;
			$InsBoletaDetalle1->AmdId = $DatSesionObjeto->Parametro15;
			$InsBoletaDetalle1->VmdId = $DatSesionObjeto->Parametro15;
			
			$InsBoletaDetalle1->FatId = $DatSesionObjeto->Parametro16;
			$InsBoletaDetalle1->BdeTipo = $DatSesionObjeto->Parametro12;
			
			/*if($InsBoletaDetalle1->BdeTipo<>"T"){
				$InsBoletaDetalle1->BdeDescripcion = utf8_encode(htmlentities($DatSesionObjeto->Parametro2));	
			}else{
				$InsBoletaDetalle1->BdeDescripcion = addslashes(utf8_encode(($DatSesionObjeto->Parametro2)));
			}*/
			if($InsBoletaDetalle1->BdeTipo<>"T"){
				$InsBoletaDetalle1->BdeDescripcion = addslashes(($DatSesionObjeto->Parametro2));	
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

			$InsBoleta->BoletaDetalle[] = $InsBoletaDetalle1;	

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
				if($InsBoletaDetalle1->FdeIncluyeSelectivo == 1){			
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
				
			}

		}	
	}else{
		$Guardar = false;
		$Resultado.='#ERR_BOL_603';		
	}
	
		
//	if($InsBoleta->BolPorcentajeDescuento>0){
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
	
	
	
	
//SesionObjeto-BoletaAlmacenMovimiento
//Parametro1 = BamId
//Parametro2 = AmoId
//Parametro3 = 
//Parametro4 = 
//Parametro5 = BamEstado
//Parametro6 = BamTiempoCreacion
//Parametro7 = BamTiempoModificacion


	$ResBoletaAlmacenMovimiento = $_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdObtenerSesionObjetos(false);//OJO

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
	
	
	if($Guardar){
		if($InsBoleta->MtdEditarBoleta()){		
		
		
			if($InsBoleta->BolNotificar=="1"){
				$InsBoleta->MtdNotificarBoletaRegistro($InsBoleta->BolId,$InsBoleta->BtaId,$CorreosNotificacionBoletaRegistro);
			}
		?>
        
        <script type="text/javascript">
				$().ready(function() {
				/*
				Configuracion carga de datos y animacion
				*/			
					//FncPopUp('formularios/Boleta/FrmBoletaGenerarXML.php?Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>&P=1',0,0,1,0,0,1,0,350,150);

				});
			</script>
            
        <?php
			
			$Resultado.='#SAS_BOL_102';
			$Edito = true;
	
			FncCargarDatos();
	
		} else{
			
			$Resultado.='#ERR_BOL_102';
	
			$InsBoleta->BolFechaEmision = FncCambiaFechaANormal($InsBoleta->BolFechaEmision);
			$InsBoleta->BolFechaVencimiento = FncCambiaFechaANormal($InsBoleta->BolFechaVencimiento,true);
			$InsBoleta->BolRegimenComprobanteFecha = FncCambiaFechaANormal($InsBoleta->BolRegimenComprobanteFecha,true);
			list($InsBoleta->BolObservacion,$InsBoleta->BolObservacionImpresa) = explode("###",$InsBoleta->BolObservacion);

			if($InsBoleta->MonId<>$EmpresaMonedaId and !empty($InsBoleta->BolTipoCambio)){
				$InsBoleta->BolRegimenMonto = round($InsBoleta->BolRegimenMonto / $InsBoleta->BolTipoCambio,2);
			}
	
		}		
	}else{
			$InsBoleta->BolFechaEmision = FncCambiaFechaANormal($InsBoleta->BolFechaEmision);
			$InsBoleta->BolFechaVencimiento = FncCambiaFechaANormal($InsBoleta->BolFechaVencimiento,true);
			$InsBoleta->BolRegimenComprobanteFecha = FncCambiaFechaANormal($InsBoleta->BolRegimenComprobanteFecha,true);
			list($InsBoleta->BolObservacion,$InsBoleta->BolObservacionImpresa) = explode("###",$InsBoleta->BolObservacion);		

			if($InsBoleta->MonId<>$EmpresaMonedaId and !empty($InsBoleta->BolTipoCambio)){
				$InsBoleta->BolRegimenMonto = round($InsBoleta->BolRegimenMonto / $InsBoleta->BolTipoCambio,2);
			}
	}
	
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){

	global $GET_id;
	global $GET_ta;
	global $Identificador;	
	global $InsBoleta;	
	global $CorreosNotificacionBienvenida;
	
	unset($_SESSION['InsBoletaDetalle'.$Identificador]);
	unset($_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]);

	$InsBoleta = new ClsBoleta();
	
	$_SESSION['InsBoletaDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();

	$InsBoleta->BolId = $GET_id;
	$InsBoleta->BtaId = $GET_ta;
	$InsBoleta = $InsBoleta->MtdObtenerBoleta();		


/*
*
*/


	//$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
//	$InsOrdenVentaVehiculo->OvvId = $InsBoleta->OvvId;
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

//echo "<br>";
//echo "<br>";
//echo "<br>";
//echo "<br>";
//echo "<br>";		
//echo "EmailPersonal: ";
//echo $EmailPersonal;
//echo "<br>";

	//MtdEnviarBienvenidaOrdenVentaVehiculo($oOrdenVentaVehiculo,$oDestinatario,$oRemitente,$oAdjuntoBanner)
	//$InsOrdenVentaVehiculo->MtdEnviarBienvenidaOrdenVentaVehiculo($InsBoleta->OvvId,$EmailPersonal,$SistemaCorreoRemitente,$SistemaCorreoImagenBienvenida,false);
	

/*
*
*/

	$_SESSION['InsBoletaDatoAdicional1'.$Identificador] = $InsBoleta->BolDatoAdicional1;
	$_SESSION['InsBoletaDatoAdicional2'.$Identificador] = $InsBoleta->BolDatoAdicional2;
	$_SESSION['InsBoletaDatoAdicional3'.$Identificador] = $InsBoleta->BolDatoAdicional3;
	$_SESSION['InsBoletaDatoAdicional4'.$Identificador] = $InsBoleta->BolDatoAdicional4;
	$_SESSION['InsBoletaDatoAdicional5'.$Identificador] = $InsBoleta->BolDatoAdicional5;
	$_SESSION['InsBoletaDatoAdicional6'.$Identificador] = $InsBoleta->BolDatoAdicional6;
	$_SESSION['InsBoletaDatoAdicional7'.$Identificador] = $InsBoleta->BolDatoAdicional7;
	$_SESSION['InsBoletaDatoAdicional8'.$Identificador] = $InsBoleta->BolDatoAdicional8;
	$_SESSION['InsBoletaDatoAdicional9'.$Identificador] = $InsBoleta->BolDatoAdicional9;
	$_SESSION['InsBoletaDatoAdicional10'.$Identificador] = $InsBoleta->BolDatoAdicional10;
	
	$_SESSION['InsBoletaDatoAdicional11'.$Identificador] = $InsBoleta->BolDatoAdicional11;
	$_SESSION['InsBoletaDatoAdicional12'.$Identificador] = $InsBoleta->BolDatoAdicional12;
	$_SESSION['InsBoletaDatoAdicional13'.$Identificador] = $InsBoleta->BolDatoAdicional13;
	$_SESSION['InsBoletaDatoAdicional14'.$Identificador] = $InsBoleta->BolDatoAdicional14;
	$_SESSION['InsBoletaDatoAdicional15'.$Identificador] = $InsBoleta->BolDatoAdicional15;
	$_SESSION['InsBoletaDatoAdicional16'.$Identificador] = $InsBoleta->BolDatoAdicional16;
	$_SESSION['InsBoletaDatoAdicional17'.$Identificador] = $InsBoleta->BolDatoAdicional17;
	$_SESSION['InsBoletaDatoAdicional18'.$Identificador] = $InsBoleta->BolDatoAdicional18;
	$_SESSION['InsBoletaDatoAdicional19'.$Identificador] = $InsBoleta->BolDatoAdicional19;
	$_SESSION['InsBoletaDatoAdicional20'.$Identificador] = $InsBoleta->BolDatoAdicional20;
	
	$_SESSION['InsBoletaDatoAdicional21'.$Identificador] = $InsBoleta->BolDatoAdicional21;
	$_SESSION['InsBoletaDatoAdicional22'.$Identificador] = $InsBoleta->BolDatoAdicional22;
	$_SESSION['InsBoletaDatoAdicional23'.$Identificador] = $InsBoleta->BolDatoAdicional23;
	$_SESSION['InsBoletaDatoAdicional24'.$Identificador] = $InsBoleta->BolDatoAdicional24;
	$_SESSION['InsBoletaDatoAdicional25'.$Identificador] = $InsBoleta->BolDatoAdicional25;
	$_SESSION['InsBoletaDatoAdicional26'.$Identificador] = $InsBoleta->BolDatoAdicional26;
	$_SESSION['InsBoletaDatoAdicional27'.$Identificador] = $InsBoleta->BolDatoAdicional27;
	
	if($InsBoleta->MonId<>$EmpresaMonedaId and !empty($InsBoleta->BolTipoCambio)){
		$InsBoleta->BolRegimenMonto = round($InsBoleta->BolRegimenMonto/$InsBoleta->BolTipoCambio,2);
		$InsBoleta->BolTotalDescuento = round($InsBoleta->BolTotalDescuento/$InsBoleta->BolTipoCambio,2);
		
		$InsBoleta->BolAbono = round($InsBoleta->BolAbono/$InsBoleta->BolTipoCambio,2);
	}
		
	if(is_array($InsBoleta->BoletaDetalle)){
		foreach($InsBoleta->BoletaDetalle as $DatBoletaDetalle){
			

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



			if($InsBoleta->MonId<>$EmpresaMonedaId and (!empty($InsBoleta->BolTipoCambio) )){
				
				$DatBoletaDetalle->BdeImporte = ($DatBoletaDetalle->BdeImporte / $InsBoleta->BolTipoCambio);
				$DatBoletaDetalle->BdePrecio = ($DatBoletaDetalle->BdePrecio  / $InsBoleta->BolTipoCambio);
				
				$DatBoletaDetalle->BdeValorVenta = ($DatBoletaDetalle->BdeValorVenta  / $InsBoleta->BolTipoCambio);
				$DatBoletaDetalle->BdeImpuesto = ($DatBoletaDetalle->BdeImpuesto  / $InsBoleta->BolTipoCambio);
				$DatBoletaDetalle->BdeDescuento = ($DatBoletaDetalle->BdeDescuento  / $InsBoleta->BolTipoCambio);
				
			}
			
			$_SESSION['InsBoletaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatBoletaDetalle->BdeId,
			$DatBoletaDetalle->BdeDescripcion,
			NULL,
			($DatBoletaDetalle->BdePrecio),
			($DatBoletaDetalle->BdeCantidad),
			($DatBoletaDetalle->BdeImporte),
			($DatBoletaDetalle->BdeTiempoCreacion),			
			($DatBoletaDetalle->BdeTiempoModificacion),
			NULL,
			$DatBoletaDetalle->AmoId,
			NULL,
			$DatBoletaDetalle->BdeTipo,
			$DatBoletaDetalle->BdeUnidadMedida,
			$DatBoletaDetalle->BdeReingreso,
			
			$DatBoletaDetalle->AmdId,
			$DatBoletaDetalle->FatId,
			$DatBoletaDetalle->OvvId,
			
			$DatBoletaDetalle->BdeCodigo,
			$DatBoletaDetalle->BdeValorVenta,
			$DatBoletaDetalle->BdeImpuesto,
			$DatBoletaDetalle->BdeDescuento,
			$DatBoletaDetalle->BdeGratuito,
			$DatBoletaDetalle->BdeExonerado,
			
			$DatBoletaDetalle->BdeIncluyeSelectivo,
			$DatBoletaDetalle->BdeImpuestoSelectivo
			);
		
		}
	}
	
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

	if(!empty($InsBoleta->BoletaAlmacenMovimiento)){
		foreach($InsBoleta->BoletaAlmacenMovimiento as $DatBoletaAlmacenMovimiento){

			$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatBoletaAlmacenMovimiento->BamId,
			$DatBoletaAlmacenMovimiento->AmoId,
			NULL,
			NULL,
			1,
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s"),
			$DatBoletaAlmacenMovimiento->FinId,
			$DatBoletaAlmacenMovimiento->FccId,
			$DatBoletaAlmacenMovimiento->AmoFecha,
			$DatBoletaAlmacenMovimiento->AmoSubTipo,
			$DatBoletaAlmacenMovimiento->VmvId,
			$DatBoletaAlmacenMovimiento->VmvFecha,
			$DatBoletaAlmacenMovimiento->VmvSubTipo
			);

		}
	}

	

}
?>