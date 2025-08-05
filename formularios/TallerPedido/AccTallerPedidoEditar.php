<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$ResultadoDetalle = '';
	$ItemSinStock = false;

	$InsFichaIngreso->UsuId = $_SESSION['SesionId'];
	$InsFichaIngreso->FinId = ($_POST['CmpFichaIngresoId']);
	$InsFichaIngreso->CliId =($_POST['CmpClienteId']);
	$InsFichaIngreso->FinFecha = ($_POST['CmpFecha']);
	$InsFichaIngreso->CliNombre = ($_POST['CmpFichaIngresoCliente']);
	$InsFichaIngreso->EinVIN = ($_POST['CmpFichaIngresoVIN']);
	$InsFichaIngreso->EinPlaca = ($_POST['CmpFichaIngresoPlaca']);

	$InsFichaIngreso->VmaNomvre =($_POST['CmpFichaIngresoMarca']);
	$InsFichaIngreso->VmoNombre =($_POST['CmpFichaIngresoModelo']);
	$InsFichaIngreso->VveNombre =($_POST['CmpFichaIngresoVersion']);
	
	$InsFichaIngreso->VmaId =($_POST['CmpVehiculoIngresoMarcaId']);
	$InsFichaIngreso->VmoId =($_POST['CmpVehiculoIngresoModeloId']);
	$InsFichaIngreso->VveId =($_POST['CmpVehiculoIngresoVersionId']);

	$InsFichaIngreso->PmaId =($_POST['CmpPlanMantenimientoId']);
	$InsFichaIngreso->FinMantenimientoKilometraje =($_POST['CmpFichaIngresoMantenimientoKilometraje']);
	$InsFichaIngreso->FinAlmacenObservacion = addslashes($_POST['CmpAlmacenObservacion']);	
	$InsFichaIngreso->FinNota = addslashes($_POST['CmpNota']);	

	$InsFichaIngreso->LtiId =($_POST['CmpClienteTipo']);

	$InsFichaIngreso->MtdObtenerFichaIngresoEstado();

	//SesionObjeto-TallerPedidoGasto
	//Parametro1 = FigId
	//Parametro2 = GasId
	//Parametro3 = GasComprobanteNumero
	//Parametro4 = GasComprobanteFecha
	//Parametro5 = GasTotal
	//Parametro6 = FigEstado
	//Parametro7 = GasTiempoCreacion
	//Parametro8 = GasTiempoModificacion
	//Parametro9 = PrvNombre
	//Parametro10 = PrvApellidoPaterno
	//Parametro11 = PrvApellidoMaterno
	//Parametro12 = MonNombre
	//Parametro13 = MonSimbolo
	//Parametro14 = GasTipoCambio
	//Parametro15 = MonId
	//Parametro16 = GasFoto
	
	$RepSesionObjetos = $_SESSION['InsTallerPedidoGasto'.$Identificador]->MtdObtenerSesionObjetos(false);
	$ArrSesionObjetos = $RepSesionObjetos['Datos'];

//	deb($ArrSesionObjetos)	;
	if(!empty($ArrSesionObjetos)){
		foreach($ArrSesionObjetos as $DatSesionObjeto){
	
			$InsFichaIngresoGasto1 = new ClsFichaIngresoGasto();
			$InsFichaIngresoGasto1->FigId = $DatSesionObjeto->Parametro1;
			$InsFichaIngresoGasto1->GasId = $DatSesionObjeto->Parametro2;
			$InsFichaIngresoGasto1->FigEstado = $DatSesionObjeto->Parametro6;
			$InsFichaIngresoGasto1->FigTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsFichaIngresoGasto1->FigTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsFichaIngresoGasto1->FigEliminado = $DatSesionObjeto->Eliminado;
			$InsFichaIngresoGasto1->InsMysql = NULL;
			
			$InsFichaIngreso->FichaIngresoGasto[] = $InsFichaIngresoGasto1;	
	
				
		}
	}
	
	    	//SesionObjeto-TallerPedidoAlmacenMovimientoEntrada
	//Parametro1 = FilId
	//Parametro2 = AmoId
	//Parametro3 = AmoComprobanteNumero
	//Parametro4 = AmoComprobanteFecha
	//Parametro5 = AmoTotal
	//Parametro6 = FilEstado
	//Parametro7 = AmoTiempoCreacion
	//Parametro8 = AmoTiempoModificacion
	//Parametro9 = PrvNombre
	//Parametro10 = PrvApellidoPaterno
	//Parametro11 = PrvApellidoMaterno
	//Parametro12 = MonNombre
	//Parametro13 = MonSimbolo
	//Parametro14 = AmoTipoCambio
	//Parametro15 = MonId
	//Parametro16 = AmoFoto
	
	$RepSesionObjetos = $_SESSION['InsTallerPedidoAlmacenMovimientoEntrada'.$Identificador]->MtdObtenerSesionObjetos(false);
	$ArrSesionObjetos = $RepSesionObjetos['Datos'];

//	deb($ArrSesionObjetos)	;
	if(!empty($ArrSesionObjetos)){
		foreach($ArrSesionObjetos as $DatSesionObjeto){
	
			$InsFichaIngresoAlmacenMovimientoEntrada1 = new ClsFichaIngresoAlmacenMovimientoEntrada();
			$InsFichaIngresoAlmacenMovimientoEntrada1->FilId = $DatSesionObjeto->Parametro1;
			$InsFichaIngresoAlmacenMovimientoEntrada1->AmoId = $DatSesionObjeto->Parametro2;
			$InsFichaIngresoAlmacenMovimientoEntrada1->FilEstado = $DatSesionObjeto->Parametro6;
			$InsFichaIngresoAlmacenMovimientoEntrada1->FilTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsFichaIngresoAlmacenMovimientoEntrada1->FilTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsFichaIngresoAlmacenMovimientoEntrada1->FilEliminado = $DatSesionObjeto->Eliminado;
			$InsFichaIngresoAlmacenMovimientoEntrada1->InsMysql = NULL;
			
			$InsFichaIngreso->FichaIngresoAlmacenMovimientoEntrada[] = $InsFichaIngresoAlmacenMovimientoEntrada1;	
	
				
		}
	}

////deb($_POST);	

	$validar = 0;
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
			
			$Guardar = true;
			
			$MonedaId = $_POST['CmpMonedaId_'.$DatFichaIngresoModalidad->MinSigla];
			$TipoCambio = $_POST['CmpTipoCambio_'.$DatFichaIngresoModalidad->MinSigla];
			
			$InsFichaAccion = new ClsFichaAccion();
			$InsFichaAccion->FccId = $_POST['CmpFichaAccionId_'.$DatFichaIngresoModalidad->MinSigla];
			$InsFichaAccion->FimId = $DatFichaIngresoModalidad->FimId;
			$InsFichaAccion->FccManoObra = eregi_replace(",","",(empty($_POST['CmpFichaAccionManoObra_'.$DatFichaIngresoModalidad->MinSigla])?0:$_POST['CmpFichaAccionManoObra_'.$DatFichaIngresoModalidad->MinSigla]));
			$InsFichaAccion->FccManoObraDetalle = addslashes($_POST['CmpFichaAccionManoObraDetalle_'.$DatFichaIngresoModalidad->MinSigla]);
			$InsFichaAccion->PerId = ($_POST['CmpPersonal_'.$DatFichaIngresoModalidad->MinSigla]);
			
				if($MonedaId<>$EmpresaMonedaId ){
				$InsFichaAccion->FccManoObra = $InsFichaAccion->FccManoObra * $TipoCambio;
			}
			
			if($InsFichaAccion->MtdEditarTrabajoTerminado()){
				
			}else{
				
			}
				
				
				
				
			$InsTallerPedido = new ClsTallerPedido();
			$InsTallerPedido->AmoId = $_POST['CmpId_'.$DatFichaIngresoModalidad->MinSigla];
			$InsTallerPedido->UsuId = $_SESSION['SesionId'];
			$InsTallerPedido->SucId = $_SESSION['SesionSucursal'];
			
			$InsTallerPedido->AlmId = $_POST['CmpAlmacen_'.$DatFichaIngresoModalidad->MinSigla];

			if( ($DatFichaIngresoModalidad->MinSigla == "GA" 
			and $InsFichaIngreso->FinTipo == 2 ) 
			or $DatFichaIngresoModalidad->MinSigla == "IF" 
			or $DatFichaIngresoModalidad->MinSigla == "AD" 
			or $DatFichaIngresoModalidad->MinSigla == "PP" 
			//or $DatFichaIngresoModalidad->MinSigla == "OB" 
			){

				$InsCliente = new ClsCliente();
				$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"CYC");
				$ArrClientes = $ResCliente['Datos'];
				
				if(!empty($ArrClientes)){
					foreach($ArrClientes as $DatCliente){
					
						$InsTallerPedido->CliId = $DatCliente->CliId;
						
					}
				}

			}else{
				$InsTallerPedido->CliId = $InsFichaIngreso->CliId;	
			}
				
			$InsTallerPedido->AmoFecha = FncCambiaFechaAMysql($_POST['CmpFecha_'.$DatFichaIngresoModalidad->MinSigla]);
			$InsTallerPedido->FccId = ($_POST['CmpFichaAccionId_'.$DatFichaIngresoModalidad->MinSigla]);
			
			$InsTallerPedido->AmoPorcentajeMantenimiento = (empty($_POST['CmpPorcentajeMantenimiento_'.$DatFichaIngresoModalidad->MinSigla])?0:$_POST['CmpPorcentajeMantenimiento_'.$DatFichaIngresoModalidad->MinSigla]);
			
			$InsTallerPedido->AmoIncluyeImpuesto = 1;
			$InsTallerPedido->AmoPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;		
			$InsTallerPedido->AmoEstado = 3;
			$InsTallerPedido->AmoDescuento = (empty($_POST['CmpDescuento_'.$DatFichaIngresoModalidad->MinSigla])?0:$_POST['CmpDescuento_'.$DatFichaIngresoModalidad->MinSigla]);	
			$InsTallerPedido->AmoObservacion = addslashes($_POST['CmpObservacion_'.$DatFichaIngresoModalidad->MinSigla]);
			$InsTallerPedido->AmoTiempoModificacion = date("Y-m-d H:i:s");
			
			$InsTallerPedido->MonId = $_POST['CmpMonedaId_'.$DatFichaIngresoModalidad->MinSigla];
			$InsTallerPedido->AmoTipoCambio = $_POST['CmpTipoCambio_'.$DatFichaIngresoModalidad->MinSigla];
			
			$InsTallerPedido->MinSigla = ($_POST['CmpModalidadIngresoSigla_'.$DatFichaIngresoModalidad->MinSigla]);
			$InsTallerPedido->MinNombre = ($_POST['CmpModalidadIngresoNombre_'.$DatFichaIngresoModalidad->MinSigla]);
			$InsTallerPedido->MinSigla = ($_POST['CmpModalidadIngresoSigla_'.$DatFichaIngresoModalidad->MinSigla]);
			$InsTallerPedido->MinId = ($_POST['CmpModalidadIngresoId_'.$DatFichaIngresoModalidad->MinSigla]);
		
			$InsTallerPedido->TopId = $_POST['CmpTipoOperacionId_'.$DatFichaIngresoModalidad->MinSigla];
			
			$InsTallerPedido->AmoTotal = 0;
			
			if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
				$InsTallerPedido->AmoDescuento = $InsTallerPedido->AmoDescuento * $InsTallerPedido->AmoTipoCambio;
			}
			
			$InsTallerPedido->TallerPedidoDetalle = array();

		
			$RepSesionObjetos = $_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
			$ArrSesionObjetos = $RepSesionObjetos['Datos'];
			
		//	deb($ArrSesionObjetos);
			
				$item = 1;
				if(!empty($ArrSesionObjetos)){
					foreach($ArrSesionObjetos as $DatSesionObjeto){

						if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
							$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsTallerPedido->AmoTipoCambio;
						}else{
							$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4;
						}
						
						if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
							$DatSesionObjeto->Parametro17 = $DatSesionObjeto->Parametro17 * $InsTallerPedido->AmoTipoCambio;
						}else{
							$DatSesionObjeto->Parametro17 = $DatSesionObjeto->Parametro17;
						}		

						$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();

						$InsTallerPedidoDetalle1->AmdCosto = $DatSesionObjeto->Parametro17;
						$InsTallerPedidoDetalle1->AmdCostoExtraTotal = 0;
						$InsTallerPedidoDetalle1->FapId = $DatSesionObjeto->Parametro26;//AGREGADO 16-04-14
						$InsTallerPedidoDetalle1->VddId = $DatSesionObjeto->Parametro30;
						
						$ListaPrecioCosto = 0;
						$InsTallerPedidoDetalle1->AmdUtilidad = 0;
						$InsTallerPedidoDetalle1->AmdValorTotal = 0;
						$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;
						
						$InsTallerPedidoDetalle1->FccId = $InsTallerPedido->FccId;
								
						$InsTallerPedidoDetalle1->AmdId = $DatSesionObjeto->Parametro1;
						$InsTallerPedidoDetalle1->ProId = $DatSesionObjeto->Parametro2;
						
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
						$InsProducto->MtdObtenerProducto(false);
			
						$InsTallerPedidoDetalle1->UmeId = $DatSesionObjeto->Parametro10;
						$InsTallerPedidoDetalle1->AmdCantidad = $DatSesionObjeto->Parametro5;	
						$InsTallerPedidoDetalle1->AmdCantidadReal = $DatSesionObjeto->Parametro12;
						$InsTallerPedidoDetalle1->AmdCantidadRealAnterior = $DatSesionObjeto->Parametro27;
													
						$InsTallerPedidoDetalle1->AmdPrecioVenta = $DatSesionObjeto->Parametro4;

						$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
						$InsProducto->MtdObtenerProducto(false);
  
						$InsUnidadMedida->UmeId = $InsTallerPedidoDetalle1->UmeId;
						$InsUnidadMedida->MtdObtenerUnidadMedida();

						$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad;
						
						//$InsTallerPedidoDetalle1->AmdReingreso = ($DatSesionObjeto->Parametro29);
						$InsTallerPedidoDetalle1->AmdReingreso = 2;
						//$InsTallerPedidoDetalle1->AmdCompraOrigen = $_POST['CmpTallerPedidoDetalleCompraOrigen_'.$InsTallerPedido->MinSigla.$DatSesionObjeto->Parametro7];
						$InsTallerPedidoDetalle1->AmdCompraOrigen = "X";
						//$InsTallerPedidoDetalle1->AmdEstado = ($DatSesionObjeto->Parametro28);
						$InsTallerPedidoDetalle1->AmdEstado = ($_POST['CmpTallerPedidoDetalleEstado_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item]);
						
						//$InsTallerPedidoDetalle1->AmdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
						//$InsTallerPedidoDetalle1->AmdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
						
						$InsTallerPedidoDetalle1->AmdTiempoCreacion = date("Y-m-d H:i:s");
						$InsTallerPedidoDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");

						if( (empty($InsTallerPedidoDetalle1->ProId) and !empty($InsTallerPedidoDetalle1->AmdId)) or $DatSesionObjeto->Eliminado==2){
							$InsTallerPedidoDetalle1->AmdEliminado = 2;							
						}else{
							$InsTallerPedidoDetalle1->AmdEliminado = 1;
						}
						
						//$InsTallerPedidoDetalle1->AlmId = $DatSesionObjeto->Parametro31;
						$InsTallerPedidoDetalle1->AlmId = ($_POST['CmpAlmacen_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item]);
						
						
						
						$InsTallerPedidoDetalle1->AmdFecha = FncCambiaFechaAMysql($DatSesionObjeto->Parametro32);
						
						$InsTallerPedidoDetalle1->InsMysql = NULL;

						$InsTallerPedidoDetalle1->ProNombre = $InsProducto->ProNombre;
						$InsTallerPedidoDetalle1->ProCodigoOriginal = $InsProducto->ProCodigoOriginal;
						$InsTallerPedidoDetalle1->ProCodigoAlternativo = $InsProducto->ProCodigoAlternativo;
						
						$InsTallerPedidoDetalle1->RtiId = $InsProducto->RtiId;
						$InsTallerPedidoDetalle1->UmeNombre = $InsUnidadMedida->UmeNombre;
						$InsTallerPedidoDetalle1->UmeIdOrigen = $InsProducto->UmeId;
						
						$InsTallerPedidoDetalle1->AmdVerificarStock = $DatSesionObjeto->Parametro16;
						$InsTallerPedidoDetalle1->AmdValidarStock = $InsProducto->ProValidarStock;
						$InsTallerPedidoDetalle1->Origen = $DatSesionObjeto->Parametro18;
						
						$InsTallerPedidoDetalle1->AmdFacturado = $DatSesionObjeto->Parametro33;
						$InsTallerPedidoDetalle1->AmoCierre = $DatSesionObjeto->Parametro34;
						
						//$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;	
						
						if($InsTallerPedidoDetalle1->AmdEliminado == 1){

							if($InsTallerPedidoDetalle1->AmdEstado==3){
	
								$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;								
								
							}

						}
						
						$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;	
						
						
				//SesionObjeto-TallerPedidoDetalle/InsTallerPedidoDetalle
				//	Parametro1 = AmdId
				//	Parametro2 = ProId
				//	Parametro3 = ProNombre
				//	Parametro4 = AmdPrecioVenta
				//	Parametro5 = AmdCantidad
				//	Parametro6 = AmdImporte
				//	Parametro7 = AmdTiempoCreacion
				//	Parametro8 = AmdTiempoModificacion
				//	Parametro9 = UmeNombre
				//	Parametro10 = UmeId
				//	Parametro11 = RtiId
				//	Parametro12 = AmdCantidadReal
				//	Parametro13 = ProCodigoOriginal,
				//	Parametro14 = ProCodigoAlternativo
				//	Parametro15 = UmeIdOrigen
				//	Parametro16 = VerificarStock
				//	Parametro17 = AmdCosto
				//	Parametro18 = Origen
				//	Parametro19 = Verificar
				//	Parametro20 = FaaId
				
				//	Parametro21 = PmtId
				//	Parametro22 = FaaAccion
				//	Parametro23 = FaaNivel
				//	Parametro24 = FaaVerificar1
				//	Parametro25 = 
				//	Parametro26 = FapId	
				//	Parametro27 = AmdCantidadRealAnterior
				//	Parametro28 = AmdEstado
				//	Parametro29 = AmdReingreso
				//	Parametro30 = VddId
				
				//	Parametro31 = AlmId
				//	Parametro32 = AmdFecha
				//	Parametro33 = AmdFacturado
				//	Parametro34 = AmoCierre
				
				
						 /* $_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
						  $InsTallerPedidoDetalle1->AmdId,
						  $InsTallerPedidoDetalle1->ProId,
						  $InsTallerPedidoDetalle1->ProNombre,
						  $InsTallerPedidoDetalle1->AmdPrecioVenta,
						  $InsTallerPedidoDetalle1->AmdCantidad,
						  $InsTallerPedidoDetalle1->AmdImporte,
						  FncCambiaFechaANormal($InsTallerPedidoDetalle1->AmdTiempoCreacion),
						  FncCambiaFechaANormal($InsTallerPedidoDetalle1->AmdTiempoModificacion),
						  $InsTallerPedidoDetalle1->UmeNombre,
						  $InsTallerPedidoDetalle1->UmeId,
						  $InsTallerPedidoDetalle1->RtiId,
						  $InsTallerPedidoDetalle1->AmdCantidadReal,
						  $InsTallerPedidoDetalle1->ProCodigoOriginal,
						  $InsTallerPedidoDetalle1->ProCodigoAlternativo,
						  $InsTallerPedidoDetalle1->UmeIdOrigen,
						  $InsTallerPedidoDetalle1->AmdVerificarStock,
						  $InsTallerPedidoDetalle1->AmdCosto,
						  $InsTallerPedidoDetalle1->Origen,
						  NULL,//$InsTallerPedidoDetalle1->Verificar,
						  $InsTallerPedidoDetalle1->FaaId,

						  NULL,
						  NULL,
						  NULL,
						  NULL,
						  NULL,
						  $InsTallerPedidoDetalle1->FapId,
						  $DatSesionObjeto->Parametro27,
						  $InsTallerPedidoDetalle1->AmdEstado,
						  $InsTallerPedidoDetalle1->AmdReingreso,
						  $InsTallerPedidoDetalle1->VddId,
						  
						  $InsTallerPedidoDetalle1->AlmId,
						  FncCambiaFechaANormal($InsTallerPedidoDetalle1->AmdFecha),
						  
							$InsTallerPedidoDetalle1->AmdFacturado,
							$InsTallerPedidoDetalle1->AmoCierre
						  );*/
									
						$item++;
					}
				}

				$RepSesionObjetos = $_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
				$ArrSesionObjetos = $RepSesionObjetos['Datos'];
//deb($ArrSesionObjetos);

				$item = 1;
				if(!empty($ArrSesionObjetos)){
					foreach($ArrSesionObjetos as $DatSesionObjeto){
						
					//deb($DatSesionObjeto->Parametro1);
//VERIFIACR SI SE VAA BORRAR
						$InsFichaAccionMantenimiento1 = new ClsFichaAccionMantenimiento();
						$InsFichaAccionMantenimiento1->FaaId = $_POST['CmpFichaAccionMantenimientoId_'.$DatSesionObjeto->Parametro21];
						$InsFichaAccionMantenimiento1->PmtId = $DatSesionObjeto->Parametro21;						
						$InsFichaAccionMantenimiento1->FaaAccion = $_POST['CmpFichaAccionMantenimientoAccion_'.$DatSesionObjeto->Parametro21];
						$InsFichaAccionMantenimiento1->FaaVerificar2 = (empty($_POST['CmpFichaAccionMantenimientoVerificar2_'.$DatSesionObjeto->Parametro21])?2:1);				
						$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");
						$InsFichaAccionMantenimiento1->FapId = $_POST['CmpFichaAccionProductoId_'.$DatSesionObjeto->Parametro21];
						$InsFichaAccionMantenimiento1->InsMysql = NULL;

						$InsTallerPedido->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;
						
						if(!empty($DatSesionObjeto->Parametro1)){							
							//echo "aa";
							if(!empty($_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoId'])){
							//echo "bb";
							
								$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();
								$InsTallerPedidoDetalle1->AmdId = $DatSesionObjeto->Parametro1;
								$InsTallerPedidoDetalle1->ProId = $_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoId'];
							
								//OBTENIENDO PRODUCTO
								$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
								$InsProducto->MtdObtenerProducto(false);
							
								$InsTallerPedidoDetalle1->FaaId = $DatSesionObjeto->Parametro20;
								$InsTallerPedidoDetalle1->FapId = $InsFichaAccionMantenimiento1->FapId;
																
								$InsTallerPedidoDetalle1->UmeId = $_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoUnidadMedidaConvertir'];
								
								$ListaPrecioCosto = 0;
								$InsTallerPedidoDetalle1->AmdUtilidad = 0;
								$InsTallerPedidoDetalle1->AmdValorTotal = 0;
								$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;
							
								//OBTENIENDO LISTA DE PRECIOS RETIRADO 31-03-16
								//if(!empty($InsTallerPedidoDetalle1->ProId) and !empty($InsFichaIngreso->LtiId) and !empty($InsTallerPedidoDetalle1->UmeId)){
//							
//									$InsListaPrecio = new ClsListaPrecio();
//									$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$InsTallerPedidoDetalle1->ProId,$InsFichaIngreso->LtiId,$InsTallerPedidoDetalle1->UmeId);
//									$ArrListaPrecios = $ResListaPrecio['Datos'];
//									
//									foreach($ArrListaPrecios as $DatListaPrecio){
//										
//										$ListaPrecioCosto = (empty($DatListaPrecio->LprCosto)?0:$DatListaPrecio->LprCosto);
//										$InsTallerPedidoDetalle1->AmdUtilidad = (empty($DatListaPrecio->LprUtilidad)?0:$DatListaPrecio->LprUtilidad);
//										$InsTallerPedidoDetalle1->AmdValorTotal = (empty($DatListaPrecio->LprValorVenta)?0:$DatListaPrecio->LprValorVenta);
//										$InsTallerPedidoDetalle1->AmdPrecioVenta = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);//AGREGADO-28-02-14
//										
//									}
//									
//								}
								
								$InsTallerPedidoDetalle1->AmdCosto = $DatSesionObjeto->Parametro17;
								$InsTallerPedidoDetalle1->AmdCostoExtraTotal = 0;
								$InsTallerPedidoDetalle1->AmdCantidad = eregi_replace(",","",$_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoCantidad']);
								//$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad ;
								
								//OBTENIENDO UNIDAD DE MEDIDA 
								$InsUnidadMedida->UmeId = $InsTallerPedidoDetalle1->UmeId;
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
									$InsTallerPedidoDetalle1->AmdCantidadReal = round($InsTallerPedidoDetalle1->AmdCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
								}else{
									$InsTallerPedidoDetalle1->AmdCantidadReal = '';
								}
								
								$InsTallerPedidoDetalle1->AmdCantidadRealAnterior = $DatSesionObjeto->Parametro27;
							
								//$InsTallerPedidoDetalle1->AmdReingreso = $_POST['Cmp'.$DatSesionObjeto->Parametro21.'TallerPedidoDetalleReingreso'];
								$InsTallerPedidoDetalle1->AmdReingreso = 2;								
								//$InsTallerPedidoDetalle1->AmdCompraOrigen = $_POST['CmpTallerPedidoDetalleCompraOrigen_'.$DatSesionObjeto->Parametro21];
								$InsTallerPedidoDetalle1->AmdCompraOrigen = "X";
								$InsTallerPedidoDetalle1->AmdEstado = (empty($_POST['Cmp'.$DatSesionObjeto->Parametro21.'TallerPedidoDetalleEstado'])?1:($_POST['Cmp'.$DatSesionObjeto->Parametro21.'TallerPedidoDetalleEstado']));
								
								//Cmp>ProductoImporte
                                $InsTallerPedidoDetalle1->AmdImporte = eregi_replace(",","",$_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoImporte']);								
								$InsTallerPedidoDetalle1->AmdPrecioVenta =  $InsTallerPedidoDetalle1->AmdImporte / $InsTallerPedidoDetalle1->AmdCantidad;
								
								//deb($InsTallerPedidoDetalle1->AmdImporte);
								//deb($InsTallerPedido->AmoTipoCambio);
								//deb($InsTallerPedido->MonId);
								//deb($EmpresaMonedaId);
								if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
									$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdImporte * $InsTallerPedido->AmoTipoCambio;
								}else{
									$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdImporte;
								}
								
								if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
									$InsTallerPedidoDetalle1->AmdPrecioVenta = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedido->AmoTipoCambio;
								}else{
									$InsTallerPedidoDetalle1->AmdPrecioVenta = $InsTallerPedidoDetalle1->AmdPrecioVenta;
								}	
					//deb($InsTallerPedidoDetalle1->AmdImporte);
								//$InsTallerPedidoDetalle1->AmdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
								//$InsTallerPedidoDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");
								$InsTallerPedidoDetalle1->AmdTiempoCreacion = date("Y-m-d H:i:s");
								$InsTallerPedidoDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");
										
								$InsTallerPedidoDetalle1->AmdEliminado = 1;		
							  
							  	$InsTallerPedidoDetalle1->AlmId = ($_POST['CmpAlmacenId_'.$DatSesionObjeto->Parametro21]);
								$InsTallerPedidoDetalle1->AmdFecha = FncCambiaFechaAMysql($_POST['CmpTallerPedidoDetalleFecha_'.$DatSesionObjeto->Parametro21]);
								
								//DATOS DE PRODUCTO
								$InsTallerPedidoDetalle1->ProNombre = $InsProducto->ProNombre;
								$InsTallerPedidoDetalle1->ProCodigoOriginal = $InsProducto->ProCodigoOriginal;
								$InsTallerPedidoDetalle1->ProCodigoAlternativo = $InsProducto->ProCodigoAlternativo;
									
								$InsTallerPedidoDetalle1->RtiId= $InsProducto->RtiId;
								$InsTallerPedidoDetalle1->UmeNombre= $InsUnidadMedida->UmeNombre;
								$InsTallerPedidoDetalle1->UmeIdOrigen= $InsProducto->UmeId;
								//DATOS EXTRA DE DETALLE					
								$InsTallerPedidoDetalle1->AmdVerificarStock = $DatSesionObjeto->Parametro16;
								$InsTallerPedidoDetalle1->AmdValidarStock = $InsProducto->ProValidarStock;
								$InsTallerPedidoDetalle1->Origen= $DatSesionObjeto->Parametro18;
								
								//$InsTallerPedidoDetalle1->AlmId = $InsTallerPedido->AlmId;
								//$InsTallerPedidoDetalle1->AmdFecha = date("Y-m-d");
								$InsTallerPedidoDetalle1->AmdFacturado = $DatSesionObjeto->Parametro33;
								$InsTallerPedidoDetalle1->AmoCierre = $DatSesionObjeto->Parametro34;
								//$InsTallerPedidoDetalle1->AlmId = $DatSesionObjeto->Parametro31;
								//$InsTallerPedidoDetalle1->AmdFecha = $DatSesionObjeto->Parametro32;
								
								$InsTallerPedidoDetalle1->InsMysql = NULL;
							
								//$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;	
								//$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;
								
									
						if($InsTallerPedidoDetalle1->AmdEliminado == 1){

							if($InsTallerPedidoDetalle1->AmdEstado==3){
	
								$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;								
								
							}

						}
							
								$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;	


//deb($InsTallerPedidoDetalle1);

//	SesionObjeto-TallerPedidoMantenimiento/InsTallerPedidoMantenimiento
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecioVenta
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro17 = AmdCosto
//	Parametro18 = Origen
//	Parametro19 = Verificar
//	Parametro20 = FaaId

//	Parametro21 = PmtId
//	Parametro22 = FaaAccion
//	Parametro23 = FaaNivel
//	Parametro24 = FaaVerificar1
//	Parametro25 = FaaVerificar2
//	Parametro26 = FapId

//	Parametro27 = 
//	Parametro28 = AmdEstado
//	Parametro29 = AmdReingreso
//	Parametro30 = 

//	Parametro31 = AlmId
//	Parametro32 = AmdFecha
//	Parametro33 = AmdFacturado
//	Parametro34 = AmoCierre

//									if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
//										$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdImporte / $InsTallerPedido->AmoTipoCambio;
//									}
//									
//									if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
//										$InsTallerPedidoDetalle1->AmdPrecioVenta = $InsTallerPedidoDetalle1->AmdPrecioVenta / $InsTallerPedido->AmoTipoCambio;
//									}
//									

									$_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
									$InsTallerPedidoDetalle1->AmdId,//CORREGIDO 20-03-14
									$InsTallerPedidoDetalle1->ProId,
									$InsTallerPedidoDetalle1->ProNombre,
									$InsTallerPedidoDetalle1->AmdPrecioVenta,
									$InsTallerPedidoDetalle1->AmdCantidad,
									$InsTallerPedidoDetalle1->AmdImporte,
									FncCambiaFechaANormal($InsTallerPedidoDetalle1->AmdTiempoCreacion),
									FncCambiaFechaANormal($InsTallerPedidoDetalle1->AmdTiempoModificacion),
									$InsTallerPedidoDetalle1->UmeNombre,
									$InsTallerPedidoDetalle1->UmeId,
									$InsTallerPedidoDetalle1->RtiId,
									$InsTallerPedidoDetalle1->AmdCantidadReal,
									$InsTallerPedidoDetalle1->ProCodigoOriginal,
									$InsTallerPedidoDetalle1->ProCodigoAlternativo,
									$InsTallerPedidoDetalle1->UmeIdOrigen,
									$InsTallerPedidoDetalle1->AmdVerificarStock,
									$InsTallerPedidoDetalle1->AmdCosto,
									$InsTallerPedidoDetalle1->Origen,
									NULL,//$InsTallerPedidoDetalle1->Verificar,
									$InsTallerPedidoDetalle1->FaaId,
									
									$InsFichaAccionMantenimiento1->PmtId,
									//$InsFichaAccionMantenimiento1->FaaAccion,
									$DatSesionObjeto->Parametro22,
									NULL,
									NULL,
									$InsFichaAccionMantenimiento1->FaaVerificar2,
									$InsFichaAccionMantenimiento1->FapId,
									$DatSesionObjeto->Parametro27,
									$InsTallerPedidoDetalle1->AmdEstado,
									$InsTallerPedidoDetalle1->AmdReingreso,
									NULL,
									$InsTallerPedidoDetalle1->AlmId,
									FncCambiaFechaANormal($InsTallerPedidoDetalle1->AmdFecha),
									
									$InsTallerPedidoDetalle1->AmdFacturado,
									$InsTallerPedidoDetalle1->AmoCierre,
									$InsTallerPedidoDetalle1->AmdCompraOrigen
									);
									
							}else{

								if(!empty($DatSesionObjeto->Parametro1)){//AGREGADO 07/04/15

									$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();
									$InsTallerPedidoDetalle1->AmdId = $DatSesionObjeto->Parametro1;
									$InsTallerPedidoDetalle1->AmdEliminado = 2;
									$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;	

								}
								
								unset($InsTallerPedidoDetalle1);
										
								$_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								$InsFichaAccionMantenimiento1->FaaId,
							
								$InsFichaAccionMantenimiento1->PmtId,
								//$InsFichaAccionMantenimiento1->FaaAccion,
								$DatSesionObjeto->Parametro22,
								NULL,
								NULL,
								$InsFichaAccionMantenimiento1->FaaVerificar2,
								$InsFichaAccionMantenimiento1->FapId,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								NULL
								);
								
								if(!empty($InsFichaAccionMantenimiento1->FapId)){
							
									$InsFichaAccionProducto1->FapId = $InsFichaAccionMantenimiento1->FapId;
									$InsFichaAccionProducto1->FapEliminado = 2;
									
									$InsTallerPedido->FichaAccionProducto[] = $InsFichaAccionProducto1;
							
								}								
								//// echo "DDD";
							
							}

						}else{
							
							if(!empty($_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoId'])){
									
								$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();
								$InsTallerPedidoDetalle1->AmdId = $DatSesionObjeto->Parametro1;
								$InsTallerPedidoDetalle1->ProId = $_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoId'];
								
								//OBTENIENDO DATOS DEL PRODUCTO
								$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
								$InsProducto->MtdObtenerProducto(false);
									
								$InsTallerPedidoDetalle1->FaaId = $DatSesionObjeto->Parametro20;
								$InsTallerPedidoDetalle1->FapId = $InsFichaAccionMantenimiento1->FapId;
								$InsTallerPedidoDetalle1->UmeId = $_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoUnidadMedidaConvertir'];
								
								$ListaPrecioCosto = 0;
								$InsTallerPedidoDetalle1->AmdUtilidad = 0;
								$InsTallerPedidoDetalle1->AmdValorTotal = 0;
								$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;

								//EN CASO DE CAMPAÑAS - RETIRADO
								$InsTallerPedidoDetalle1->AmdCosto = $InsProducto->ProCosto;
								$InsTallerPedidoDetalle1->AmdCostoExtraTotal = 0;							
								$InsTallerPedidoDetalle1->AmdCantidad = eregi_replace(",","",$_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoCantidad']);
								//$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad ;
						
								//OBTENIENDO UNIDAD DE MEDIDA
								$InsUnidadMedida->UmeId = $InsTallerPedidoDetalle1->UmeId;
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
	//							
								if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
									$InsTallerPedidoDetalle1->AmdCantidadReal = round($InsTallerPedidoDetalle1->AmdCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
								}else{
									$InsTallerPedidoDetalle1->AmdCantidadReal = '';
								}

								//$InsTallerPedidoDetalle1->AmdReingreso = $_POST['Cmp'.$DatSesionObjeto->Parametro21.'TallerPedidoDetalleReingreso'];
								$InsTallerPedidoDetalle1->AmdReingreso = 2;
								//$InsTallerPedidoDetalle1->AmdCompraOrigen = $_POST['CmpTallerPedidoDetalleCompraOrigen_'.$DatSesionObjeto->Parametro21];
								$InsTallerPedidoDetalle1->AmdCompraOrigen = "X";
								$InsTallerPedidoDetalle1->AmdEstado = (empty($_POST['Cmp'.$DatSesionObjeto->Parametro21.'TallerPedidoDetalleEstado'])?1:3);
								
								$InsTallerPedidoDetalle1->AmdImporte = eregi_replace(",","",$_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoImporte']);								
								$InsTallerPedidoDetalle1->AmdPrecioVenta =  $InsTallerPedidoDetalle1->AmdImporte / $InsTallerPedidoDetalle1->AmdCantidad;
								
								if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
									$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdImporte * $InsTallerPedido->AmoTipoCambio;
								}else{
									$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdImporte;
								}
								
								if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
									$InsTallerPedidoDetalle1->AmdPrecioVenta = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedido->AmoTipoCambio;
								}else{
									$InsTallerPedidoDetalle1->AmdPrecioVenta = $InsTallerPedidoDetalle1->AmdPrecioVenta;
								}	
								
								
								//$InsTallerPedidoDetalle1->AmdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
								//$InsTallerPedidoDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");
								$InsTallerPedidoDetalle1->AmdTiempoCreacion = date("Y-m-d H:i:s");
								$InsTallerPedidoDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");

								$InsTallerPedidoDetalle1->AmdEliminado = 1;		
										
								$InsTallerPedidoDetalle1->AlmId = ($_POST['CmpAlmacenId_'.$DatSesionObjeto->Parametro21]);
								$InsTallerPedidoDetalle1->AmdFecha = FncCambiaFechaAMysql($_POST['CmpTallerPedidoDetalleFecha_'.$DatSesionObjeto->Parametro21]);
								
								
								//DATOS DEL PRODUCTO
								$InsTallerPedidoDetalle1->ProNombre = $InsProducto->ProNombre;
								$InsTallerPedidoDetalle1->ProCodigoOriginal = $InsProducto->ProCodigoOriginal;
								$InsTallerPedidoDetalle1->ProCodigoAlternativo = $InsProducto->ProCodigoAlternativo;
								
								$InsTallerPedidoDetalle1->RtiId= $InsProducto->RtiId;
								$InsTallerPedidoDetalle1->UmeNombre= $InsUnidadMedida->UmeNombre;
								$InsTallerPedidoDetalle1->UmeIdOrigen= $InsProducto->UmeId;
		
								//DATOS EXTRA DEL PRODUCTO
								$InsTallerPedidoDetalle1->AmdVerificarStock = $DatSesionObjeto->Parametro16;
								$InsTallerPedidoDetalle1->AmdValidarStock = $InsProducto->ProValidarStock;
								$InsTallerPedidoDetalle1->Origen = $DatSesionObjeto->Parametro18;
								
								///$InsTallerPedidoDetalle1->AlmId = $DatSesionObjeto->Parametro31;
								//$InsTallerPedidoDetalle1->AmdFecha = $DatSesionObjeto->Parametro32;
								
								$InsTallerPedidoDetalle1->AmdFacturado = $DatSesionObjeto->Parametro33;
								$InsTallerPedidoDetalle1->AmoCierre = $DatSesionObjeto->Parametro34;
						
								$InsTallerPedidoDetalle1->InsMysql = NULL;
								
								//$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;
								
									
						if($InsTallerPedidoDetalle1->AmdEliminado == 1){

							if($InsTallerPedidoDetalle1->AmdEstado==3){
	
								$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;								
								
							}

						}
										
								$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;	


//	SesionObjeto-TallerPedidoMantenimiento/InsTallerPedidoMantenimiento
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecioVenta
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro17 = AmdCosto
//	Parametro18 = Origen
//	Parametro19 = Verificar
//	Parametro20 = FaaId

//	Parametro21 = PmtId
//	Parametro22 = FaaAccion
//	Parametro23 = FaaNivel
//	Parametro24 = FaaVerificar1
//	Parametro25 = FaaVerificar2
//	Parametro26 = FapId

//	Parametro27 = 
//	Parametro28 = AmdEstado
//	Parametro29 = AmdReingreso
//	Parametro30 = 

//	Parametro31 = AlmId
//	Parametro32 = AmdFecha
//	Parametro33 = AmdFacturado
//	Parametro34 = AmoCierre		

							//	if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
//										$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdImporte / $InsTallerPedido->AmoTipoCambio;
//									}
//									
//									if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
//										$InsTallerPedidoDetalle1->AmdPrecioVenta = $InsTallerPedidoDetalle1->AmdPrecioVenta / $InsTallerPedido->AmoTipoCambio;
//									}
//									
									
								$_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
								$InsTallerPedidoDetalle1->AmdId,//AGREGADO 20-03-14
								$InsTallerPedidoDetalle1->ProId,
								$InsTallerPedidoDetalle1->ProNombre,
								$InsTallerPedidoDetalle1->AmdPrecioVenta,
								$InsTallerPedidoDetalle1->AmdCantidad,
								$InsTallerPedidoDetalle1->AmdImporte,
								FncCambiaFechaANormal($InsTallerPedidoDetalle1->AmdTiempoCreacion),
								FncCambiaFechaANormal($InsTallerPedidoDetalle1->AmdTiempoModificacion),
								$InsTallerPedidoDetalle1->UmeNombre,
								$InsTallerPedidoDetalle1->UmeId,
								$InsTallerPedidoDetalle1->RtiId,
								$InsTallerPedidoDetalle1->AmdCantidadReal,
								$InsTallerPedidoDetalle1->ProCodigoOriginal,
								$InsTallerPedidoDetalle1->ProCodigoAlternativo,
								$InsTallerPedidoDetalle1->UmeIdOrigen,
								$InsTallerPedidoDetalle1->AmdVerificarStock,
								$InsTallerPedidoDetalle1->AmdCosto,
								$InsTallerPedidoDetalle1->Origen,
								NULL,//$InsTallerPedidoDetalle1->Verificar,
								$InsTallerPedidoDetalle1->FaaId,
								
								$InsFichaAccionMantenimiento1->PmtId,
								//$InsFichaAccionMantenimiento1->FaaAccion,
								$DatSesionObjeto->Parametro22,
								NULL,
								NULL,
								$InsFichaAccionMantenimiento1->FaaVerificar2,
								$InsFichaAccionMantenimiento1->FapId,
								$DatSesionObjeto->Parametro27,
								$InsTallerPedidoDetalle1->AmdEstado,
								$InsTallerPedidoDetalle1->AmdReingreso,
								NULL,
								$InsTallerPedidoDetalle1->AlmId,
								FncCambiaFechaANormal($InsTallerPedidoDetalle1->AmdFecha),
								 $InsTallerPedidoDetalle1->AmdFacturado,
						  		$InsTallerPedidoDetalle1->AmoCierre,
								$InsTallerPedidoDetalle1->AmdCompraOrigen
								);
										
								$i++;

							}else{
									//// echo "III";	
								$_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									$InsFichaAccionMantenimiento1->FaaId,
	
									$InsFichaAccionMantenimiento1->PmtId,
									//$InsFichaAccionMantenimiento1->FaaAccion,
									$DatSesionObjeto->Parametro22,
									NULL,
									NULL,
									$InsFichaAccionMantenimiento1->FaaVerificar2,
									$InsFichaAccionMantenimiento1->FapId
									);
								
							}
								
							
						}

					}
				}else{
					
					
					
				}

				if($Guardar){
					
					if(!empty($InsTallerPedido->AmoId)){
						
						
						
						if($InsTallerPedido->MtdEditarTallerPedido()){
							
							
							$validar++;
							FncCargarTallerPedidoDatos();
							//$Resultado.='#SAS_TPE_102';
						}else{
							$InsTallerPedido->AmoFecha = FncCambiaFechaANormal($InsTallerPedido->AmoFecha);
							//$Resultado.='#ERR_TPE_102';
						}
					
					}else{
						
						if(!empty($InsTallerPedido->TallerPedidoDetalle)){
							
					if($DatFichaIngresoModalidad->MinSigla=="MA"){
								
						//echo "<h1>SE ENCONTRARON ".count($InsTallerPedido->TallerPedidoDetalle)." ITEMS EN LA FICHA DE MANTENIMIENTO</h1>";
					}
					
						
						
							if($InsTallerPedido->MtdRegistrarTallerPedido()){
								$validar++;
								FncCargarTallerPedidoDatos();
								//$Resultado.='#SAS_TPE_102';
							}else{
								$InsTallerPedido->AmoFecha = FncCambiaFechaANormal($InsTallerPedido->AmoFecha);
								$InsTallerPedido->AmoId = "";								
								//$Resultado.='#ERR_TPE_102';
							}
						}else{
							$InsTallerPedido->AmoFecha = FncCambiaFechaANormal($InsTallerPedido->AmoFecha);
							$validar++;					
						}
						

						
					}
					
				}else{
					$InsTallerPedido->AmoFecha = FncCambiaFechaANormal($InsTallerPedido->AmoFecha);
				}

				$ArrTallerPedidos[] = $InsTallerPedido;				

			

			
		}
	}

	$InsFichaIngreso->MtdEditarFichaIngresoDato("FinAlmacenObservacion",$InsFichaIngreso->FinAlmacenObservacion,$InsFichaIngreso->FinId);
	$InsFichaIngreso->MtdEditarFichaIngresoGasto();
$InsFichaIngreso->MtdEditarFichaIngresoAlmacenMovimientoEntrada();
	
	//deb(count($InsFichaIngreso->FichaIngresoModalidad));
	
	//deb($validar);
	
	if($validar == count($InsFichaIngreso->FichaIngresoModalidad)){
		
		$Resultado = '#SAS_TPE_102';
		
		if($InsFichaIngreso->FinEstado == 5){
			//ACTUALIZANDO A ALMACEN [Preparando Pedido]
			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,6,false); //OJO
		}
		
		$Edito = true;
	}else{
		$Resultado .='#ERR_TPE_102'.$ResultadoDetalle;
	}
	
	//FncCargarDatos();
	
}else{
	
	
		//CORRIGIENDO 
		if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
			foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){

				$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;
				
				$FichaAccionId = "";
				
				if(empty($InsFichaAccion)){
					
					$InsFichaAccion1 = new ClsFichaAccion();
					$InsFichaAccion1->FimId = $DatFichaIngresoModalidad->FimId;
					$InsFichaAccion1->FccFecha = date("Y-m-d");
					$InsFichaAccion1->FccObservacion = date("d/m/Y H:i:s")." - [Agregado]Sub OT autogenerada de O.T.: ".$InsFichaIngreso->FinId;
					$InsFichaAccion1->FccManoObra = 0;	
					$InsFichaAccion1->FccDescuento = 0;	
					$InsFichaAccion1->FccEstado = 1;	
					$InsFichaAccion1->FccTiempoCreacion = date("Y-m-d H:i:s");
					$InsFichaAccion1->FccTiempoModificacion = date("Y-m-d H:i:s");
					
					if($InsFichaAccion1->MtdRegistrarFichaAccion()){
						
						$FichaAccionId = $InsFichaAccion1->FccId;
						
						$InsFichaAccion2 = new ClsFichaAccion();
						$InsFichaAccion2->FccId = $FichaAccionId;
						$InsFichaAccion2->FimId = $DatFichaIngresoModalidad->FimId;

						if($DatFichaIngresoModalidad->MinId == "MIN-10001"){
							
							if(!empty($DatFichaIngresoModalidad->FichaIngresoMantenimiento)){
								foreach($DatFichaIngresoModalidad->FichaIngresoMantenimiento as $DatFichaIngresoMantenimiento){
		
									if(!empty($DatFichaIngresoMantenimiento->MinSigla)){ //AUX
		
										$InsFichaAccionMantenimiento1 = new ClsFichaAccionMantenimiento();
		
										$InsFichaAccionMantenimiento1->PmtId = $DatFichaIngresoMantenimiento->PmtId;
										//$InsFichaAccionMantenimiento1->FaaAccion = $DatFichaIngresoMantenimiento->FiaAccion;
										if($InsFichaAccionMantenimiento1->FaaAccion<>"C" or $InsFichaAccionMantenimiento1->FaaAccion<>"R"){
											$InsFichaAccionMantenimiento1->FaaAccion = "X";			
										}
		
										$InsFichaAccionMantenimiento1->FaaNivel = (($DatFichaIngresoMantenimiento->FidAccion == "X"))?'2':'1';
										$InsFichaAccionMantenimiento1->FaaVerificar1 = 1;//ACTUALIZADO 03-10-17
										$InsFichaAccionMantenimiento1->FaaVerificar2 = 1;//ACTUALIZADO 03-10-17
										$InsFichaAccionMantenimiento1->FaaEstado = 2;
										$InsFichaAccionMantenimiento1->FaaTiempoCreacion = date("Y-m-d H:i:s");
										$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");
										$InsFichaAccionMantenimiento1->FiaId = $DatFichaIngresoMantenimiento->FiaId;
		
										if($InsFichaAccionMantenimiento1->FaaAccion == "C" or $InsFichaAccionMantenimiento1->FaaAccion == "U" or $InsFichaAccionMantenimiento1->FaaAccion == "R"){
												
											$ProductoId = "";
											$ProductoNombre = "";
											$ProductoUnidadMedida = "";
											$ProductoUnidadMedidaNombre = "";
											$ProductoUnidadMedidaOrigen = "";
											$ProductoTipo = "";
											$ProductoCantidad = 0;
											
											if(empty($InsFichaIngreso->PmaId)){
													
													
												$InsPlanMantenimiento = new ClsPlanMantenimiento();
												$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId);
												$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
												
												$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
												unset($ArrPlanMantenimientos);
												$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
												
											}else{
												
												$InsPlanMantenimiento = new ClsPlanMantenimiento();												
												$InsPlanMantenimiento->PmaId = $InsFichaIngreso->PmaId;												
												$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
												
											}
											
											
											
											
											
											if(!empty($InsPlanMantenimiento->PmaId)){
												
												$InsTareaProducto = new ClsTareaProducto();
			//MtdObtenerTareaProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oTarea=NULL)
												
												//deb($InsPlanMantenimiento->PmaId." --- ".$InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$InsFichaIngreso->FinMantenimientoKilometraje]['eq']." --- ".$DatFichaIngresoMantenimiento->PmtId);
												//deb($InsFichaIngreso->FinMantenimientoKilometraje);
												
												$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$InsFichaIngreso->FinMantenimientoKilometraje]['eq'],$DatFichaIngresoMantenimiento->PmtId);
												$ArrTareaProductos = $ResTareaProducto['Datos'];
												
												if(!empty($ArrTareaProductos)){
													foreach($ArrTareaProductos as $DatTareaProducto){
													
														
														$InsProducto = new ClsProducto();
														$InsProducto->ProId = $DatTareaProducto->ProId;
														$InsProducto->MtdObtenerProducto(false);
														
														$ProductoId = $InsProducto->ProId;
														$ProductoCodigoOriginal = $InsProducto->ProCodigoOriginal;
														
														$ProductoNombre = $InsProducto->ProNombre;
														$ProductoUnidadMedida = $DatTareaProducto->UmeId;
														$ProductoUnidadMedidaNombre = $DatTareaProducto->UmeNombre;
														$ProductoUnidadMedidaOrigen = $InsProducto->UmeId;
														$ProductoTipo = $InsProducto->RtiId;
														$ProductoCantidad = $DatTareaProducto->TprCantidad;				
					
													}	
												}
												
											}
											
											if(!empty($ProductoId)){
												
												$InsFichaAccionMantenimiento1->ProId = $ProductoId;
												$InsFichaAccionMantenimiento1->UmeId = $ProductoUnidadMedida;
												$InsFichaAccionMantenimiento1->FaaCantidad = $ProductoCantidad;
											}	
											
										}
										
										$InsFichaAccionMantenimiento1->InsMysql = NULL;
			
										$InsFichaAccion2->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;
										
									}
				
								}
								
								if(!empty($InsFichaAccion2->FichaAccionMantenimiento)){
									$InsFichaAccion2->MtdCorregirFichaAccionMantenimiento();
								}
								
								
							}
							
						}
						
					}

				}
					
			}
		
		}
			
			
	$InsFichaIngreso->FinId = $GET_Id;
	$InsFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngreso();
	
	
	

	$validar = 0;
	
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){

				$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;

				$InsTallerPedido = new ClsTallerPedido();	

				$InsTallerPedido->UsuId = $_SESSION['SesionId'];	
				$InsTallerPedido->SucId = $_SESSION['SesionSucursal'];	
				$InsTallerPedido->FccId = $InsFichaAccion->FccId;
				$InsTallerPedido->TopId = "TOP-10000";

				$InsTallerPedido->CliId = $InsFichaIngreso->CliId;
				$InsTallerPedido->LtiId = $InsFichaIngreso->LtiId;

				$InsTallerPedido->AlmId = "ALM-10000";
				$InsTallerPedido->AmoFecha = date("Y-m-d");
				$InsTallerPedido->AmoObservacion = date("d/m/Y H:i:s")." - Mov. Alm. Autogenerado de O.T.: ".$InsFichaIngreso->FinId;
			
				$InsTallerPedido->AmoDescuento = 0;
				$InsTallerPedido->AmoSubTipo = 2;
				
				
				
				if($DatFichaIngresoModalidad->MinSigla == "GA" 
				or $DatFichaIngresoModalidad->MinSigla == "CA" 
				or $DatFichaIngresoModalidad->MinSigla == "PO"  
				){	
					$InsTallerPedido->MonId = "MON-10001";
					
						$InsTipoCambio = new ClsTipoCambio();
						$InsTipoCambio->MonId = $InsTallerPedido->MonId;
						$InsTipoCambio->TcaFecha = date("Y-m-d");
						
						$InsTipoCambio->MtdObtenerTipoCambioActual();
						
						if(empty($InsTipoCambio->TcaId)){
							$InsTipoCambio->MtdObtenerTipoCambioUltimo();
						}
							
						$InsTallerPedido->AmoTipoCambio = $InsTipoCambio->TcaMontoComercial;
						
				}else{
					$InsTallerPedido->MonId = $EmpresaMonedaId;
					$InsTallerPedido->AmoTipoCambio = NULL;

				}
				
				
				if($DatFichaIngresoModalidad->MinSigla == "MA" ){
					$InsTallerPedido->AmoPorcentajeMantenimiento = 000;
				}else{
					$InsTallerPedido->AmoPorcentajeMantenimiento = 0;
				}
				
				$InsTallerPedido->AmoIncluyeImpuesto = 1;
				$InsTallerPedido->AmoPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
				$InsTallerPedido->AmoEstado = 1;
				$InsTallerPedido->AmoTiempoCreacion = date("Y-m-d H:i:s");
				$InsTallerPedido->AmoTiempoModificacion = date("Y-m-d H:i:s");

				$InsTallerPedido->MinId = $InsFichaAccion->MinId;
				$InsTallerPedido->MinSigla = $InsFichaAccion->MinSigla;
				$InsTallerPedido->MinNombre = $InsFichaAccion->MinNombre;
	
				$InsTallerPedido->TallerPedidoDetalle = array();
	
				$InsTallerPedido->AmoTotal = 0;


	
				//SesionObjeto-TallerPedidoDetalle/InsTallerPedidoDetalle
				//	Parametro1 = AmdId
				//	Parametro2 = ProId
				//	Parametro3 = ProNombre
				//	Parametro4 = AmdPrecioVenta
				//	Parametro5 = AmdCantidad
				//	Parametro6 = AmdImporte
				//	Parametro7 = AmdTiempoCreacion
				//	Parametro8 = AmdTiempoModificacion
				//	Parametro9 = UmeNombre
				//	Parametro10 = UmeId
				//	Parametro11 = RtiId
				//	Parametro12 = AmdCantidadReal
				//	Parametro13 = ProCodigoOriginal,
				//	Parametro14 = ProCodigoAlternativo
				//	Parametro15 = UmeIdOrigen
				//	Parametro16 = VerificarStock
				//	Parametro17 = AmdCosto
				//	Parametro18 = Origen
				//	Parametro19 = Verificar
				//	Parametro20 = FaaId
				
				//	Parametro21 = PmtId
				//	Parametro22 = FaaAccion
				//	Parametro23 = FaaNivel
				//	Parametro24 = FaaVerificar1
				//	Parametro25 = 
				//	Parametro26 = FapId	
				//	Parametro27 = AmdCantidadRealAnterior
				//	Parametro28 = AmdEstado
				//	Parametro29 = AmdReingreso
				//	Parametro30 = VddId
				
				//	Parametro31 = AlmId
				//	Parametro32 = AmdFecha
				//	Parametro33 = AmdFacturado
				//	Parametro34 = AmoCierre

					if(!empty($InsFichaAccion->FichaAccionProducto)){
						foreach($InsFichaAccion->FichaAccionProducto as $DatFichaAccionProducto){					

							if(!empty($DatFichaAccionProducto->ProId) 
							and ($DatFichaAccionProducto->FapAccion=="C" 
							or $DatFichaAccionProducto->FapAccion=="U" 
							or  $DatFichaAccionProducto->FapAccion=="") ){
								
								if(empty($DatFichaAccionProducto->UmeId)){
									
//MtdObtenerProductoTipoUnidadMedidas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PtuId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTipo=NULL,$oProductoTipo=NULL,$oUso=NULL)
									$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
									$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeId","ASC","1",2,$DatFichaAccionProducto->RtiId);
									$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];

									foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUnidadMedida){
										
										$UnidadMedidaEquivalente = 0;
									
										if($DatFichaAccionProducto->UmeIdOrigen == $DatProductoTipoUnidadMedida->UmeId){
											$UnidadMedidaEquivalente = 1;
										}else{
											$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$DatProductoTipoUnidadMedida->UmeId,$DatFichaAccionProducto->UmeIdOrigen);
											
											$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
											
											foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
												$UnidadMedidaEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
											}
										}
										
									}
								   
									if(!empty($UnidadMedidaEquivalente)){
									
										$DatFichaAccionProducto->UmeId = $DatProductoTipoUnidadMedida->UmeId;
										
									}
			

								}
								
								
								$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();
								
								$InsTallerPedidoDetalle1->ProId = $DatFichaAccionProducto->ProId;
								$InsTallerPedidoDetalle1->UmeId = $DatFichaAccionProducto->UmeId;
								
								$InsTallerPedidoDetalle1->FapId = $DatFichaAccionProducto->FapId;//AGREGADO 16-04-14
								
									
									$ListaPrecioCosto = 0;
									$InsTallerPedidoDetalle1->AmdUtilidad = 0;
									$InsTallerPedidoDetalle1->AmdValorTotal = 0;
									$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;

									

								//OBTENIENDO LISTA DE PRECIOS
								if(!empty($InsTallerPedidoDetalle1->ProId) and !empty($InsFichaIngreso->LtiId) and !empty($InsTallerPedidoDetalle1->UmeId)){

									$InsListaPrecio = new ClsListaPrecio();
									$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$InsTallerPedidoDetalle1->ProId,$InsFichaIngreso->LtiId,$InsTallerPedidoDetalle1->UmeId);
									$ArrListaPrecios = $ResListaPrecio['Datos'];
	
									foreach($ArrListaPrecios as $DatListaPrecio){

										if($InsTallerPedido->MonId == $EmpresaMonedaId){
											
											$DatListaPrecio->LprCosto = (empty($DatListaPrecio->LprCosto)?0:$DatListaPrecio->LprCosto);
											$DatListaPrecio->LprUtilidad = (empty($DatListaPrecio->LprUtilidad)?0:$DatListaPrecio->LprUtilidad);
											$DatListaPrecio->LprValorVenta = (empty($DatListaPrecio->LprValorVenta)?0:$DatListaPrecio->LprValorVenta);
											$DatListaPrecio->LprPrecio = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);
											
										}else{
											
											$DatListaPrecio->LprCosto = ((empty($DatListaPrecio->LprCosto)?0:$DatListaPrecio->LprCosto)/$InsTallerPedido->AmoTipoCambio);
											$DatListaPrecio->LprUtilidad = ((empty($DatListaPrecio->LprUtilidad)?0:$DatListaPrecio->LprUtilidad)/$InsTallerPedido->AmoTipoCambio);
											$DatListaPrecio->LprValorVenta = ((empty($DatListaPrecio->LprValorVenta)?0:$DatListaPrecio->LprValorVenta)/$InsTallerPedido->AmoTipoCambio);
											$DatListaPrecio->LprPrecio = ((empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio)/$InsTallerPedido->AmoTipoCambio);
											
										}
										
										$ListaPrecioCosto = (empty($DatListaPrecio->LprCosto)?0:$DatListaPrecio->LprCosto);
			
										$InsTallerPedidoDetalle1->AmdUtilidad = (empty($DatListaPrecio->LprUtilidad)?0:$DatListaPrecio->LprUtilidad);
										$InsTallerPedidoDetalle1->AmdValorTotal = (empty($DatListaPrecio->LprValorVenta)?0:$DatListaPrecio->LprValorVenta);
										$InsTallerPedidoDetalle1->AmdPrecioVenta = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);//AGREGADO-28-02-14					

									}
								}
																
								//EN CASO DE CAMPAÑAS
								//if($DatFichaIngresoModalidad->MinSigla == "GA" or $DatFichaIngresoModalidad->MinSigla == "CA" or $DatFichaIngresoModalidad->MinSigla == "PO"  or $DatFichaIngresoModalidad->MinSigla == "IF" or $DatFichaIngresoModalidad->MinSigla == "AD" or $DatFichaIngresoModalidad->MinSigla == "PP"){			
								if($DatFichaIngresoModalidad->MinSigla == "GA" 
								or $DatFichaIngresoModalidad->MinSigla == "CA" 
								or $DatFichaIngresoModalidad->MinSigla == "PO"  
								or $DatFichaIngresoModalidad->MinSigla == "IF" 
								or $DatFichaIngresoModalidad->MinSigla == "AD" 
								or $DatFichaIngresoModalidad->MinSigla == "PP" 
							
								){		
								
									$InsTallerPedidoDetalle1->AmdUtilidad = 0;
									$InsTallerPedidoDetalle1->AmdValorTotal = $ListaPrecioCosto;
									$InsTallerPedidoDetalle1->AmdPrecioVenta = $InsTallerPedidoDetalle1->AmdValorTotal + (($InsTallerPedido->AmoPorcentajeImpuestoVenta/100) * $InsTallerPedidoDetalle1->AmdValorTotal);
									
								}
								
								
								$InsTallerPedidoDetalle1->AmdPrecioVenta = FncRedondearCYC($InsTallerPedidoDetalle1->AmdPrecioVenta);
								
												

								$InsTallerPedidoDetalle1->AmdCosto = $DatFichaAccionProducto->ProCosto;								
								$InsTallerPedidoDetalle1->AmdCostoExtraTotal = 0;
								
								$InsTallerPedidoDetalle1->AmdCantidad = $DatFichaAccionProducto->FapCantidad;

								$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad;
									
									$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
									$InsProducto->MtdObtenerProducto(false);
		
									$InsUnidadMedida->UmeId = $InsTallerPedidoDetalle1->UmeId;
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
									  $InsTallerPedidoDetalle1->AmdCantidadReal = round($InsTallerPedidoDetalle1->AmdCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
									}else{
									  $InsTallerPedidoDetalle1->AmdCantidadReal = '';
									}
								
								$InsTallerPedidoDetalle1->AmdReingreso = 2;
								$InsTallerPedidoDetalle1->AmdCompraOrigen = "G";
								$InsTallerPedidoDetalle1->AmdEstado = 3;
								$InsTallerPedidoDetalle1->AmdTiempoCreacion = date("Y-m-d H:i:s");
								$InsTallerPedidoDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");
								$InsTallerPedidoDetalle1->AmdEliminado = 1;
	
								$InsTallerPedidoDetalle1->AlmId = $InsTallerPedido->AlmId;
								$InsTallerPedidoDetalle1->AmdFecha = date("Y-m-d");
								
	
									$InsTallerPedidoDetalle1->ProNombre = $DatFichaAccionProducto->ProNombre;
									$InsTallerPedidoDetalle1->ProCodigoOriginal = $InsProducto->ProCodigoOriginal;
									$InsTallerPedidoDetalle1->ProCodigoAlternativo = $InsProducto->ProCodigoAlternativo;
									
									$InsTallerPedidoDetalle1->RtiId = $DatFichaAccionProducto->RtiId;
									$InsTallerPedidoDetalle1->UmeNombre = $DatFichaAccionProducto->UmeNombre;
									$InsTallerPedidoDetalle1->UmeIdOrigen= $DatFichaAccionProducto->UmeIdOrigen;

								$InsTallerPedidoDetalle1->InsMysql = NULL;

								$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;

								$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;

							}

						}
					}
					
					if(!empty($InsFichaAccion->FichaAccionMantenimiento)){
						foreach($InsFichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){					
	
							if(!empty($DatFichaAccionMantenimiento->ProId) and !empty($DatFichaAccionMantenimiento->UmeId) and ($DatFichaAccionMantenimiento->FaaAccion=="C" or $DatFichaAccionMantenimiento->FaaAccion=="U" or  $DatFichaAccionMantenimiento->FaaAccion=="R") ){
								
								$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();
								
								//////deb($DatFichaAccionMantenimiento->UmeId);
								$InsTallerPedidoDetalle1->AmdUtilidad = 0;
								$InsTallerPedidoDetalle1->AmdValorTotal = 0;
								$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;
								
								$InsTallerPedidoDetalle1->ProId = $DatFichaAccionMantenimiento->ProId;
								//$InsTallerPedidoDetalle1->ProCodigoOriginal = $DatFichaAccionMantenimiento->ProCodigoOriginal;
								//$InsTallerPedidoDetalle1->ProCodigoAltenativo = $DatFichaAccionMantenimiento->ProCodigoAltenativo;
								
								$InsTallerPedidoDetalle1->FaaId = $DatFichaAccionMantenimiento->FaaId;								
								$InsTallerPedidoDetalle1->UmeId = $DatFichaAccionMantenimiento->UmeId;

								$ListaPrecioCosto = 0;
								$InsTallerPedidoDetalle1->AmdUtilidad = 0;
								$InsTallerPedidoDetalle1->AmdValorTotal = 0;
								$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;


								//OBTENIENDO LISTA DE PRECIOS
								if(!empty($InsTallerPedidoDetalle1->ProId) and !empty($InsFichaIngreso->LtiId) and !empty($InsTallerPedidoDetalle1->UmeId)){

									$InsListaPrecio = new ClsListaPrecio();
									$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$InsTallerPedidoDetalle1->ProId,$InsFichaIngreso->LtiId,$InsTallerPedidoDetalle1->UmeId);
									$ArrListaPrecios = $ResListaPrecio['Datos'];
	
									foreach($ArrListaPrecios as $DatListaPrecio){

										if($InsTallerPedido->MonId == $EmpresaMonedaId){
											
											$DatListaPrecio->LprCosto = (empty($DatListaPrecio->LprCosto)?0:$DatListaPrecio->LprCosto);
											$DatListaPrecio->LprUtilidad = (empty($DatListaPrecio->LprUtilidad)?0:$DatListaPrecio->LprUtilidad);
											$DatListaPrecio->LprValorVenta = (empty($DatListaPrecio->LprValorVenta)?0:$DatListaPrecio->LprValorVenta);
											$DatListaPrecio->LprPrecio = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);
											
										}else{
											
											$DatListaPrecio->LprCosto = ((empty($DatListaPrecio->LprCosto)?0:$DatListaPrecio->LprCosto)/$InsTallerPedido->AmoTipoCambio);
											$DatListaPrecio->LprUtilidad = ((empty($DatListaPrecio->LprUtilidad)?0:$DatListaPrecio->LprUtilidad)/$InsTallerPedido->AmoTipoCambio);
											$DatListaPrecio->LprValorVenta = ((empty($DatListaPrecio->LprValorVenta)?0:$DatListaPrecio->LprValorVenta)/$InsTallerPedido->AmoTipoCambio);
											$DatListaPrecio->LprPrecio = ((empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio)/$InsTallerPedido->AmoTipoCambio);
											
										}
										
										$ListaPrecioCosto = (empty($DatListaPrecio->LprCosto)?0:$DatListaPrecio->LprCosto);
			
										$InsTallerPedidoDetalle1->AmdUtilidad = (empty($DatListaPrecio->LprUtilidad)?0:$DatListaPrecio->LprUtilidad);
										$InsTallerPedidoDetalle1->AmdValorTotal = (empty($DatListaPrecio->LprValorVenta)?0:$DatListaPrecio->LprValorVenta);
										$InsTallerPedidoDetalle1->AmdPrecioVenta = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);//AGREGADO-28-02-14					
										
										
										
									}

								}
								
								$InsTallerPedidoDetalle1->AmdPrecioVenta = $InsTallerPedidoDetalle1->AmdPrecioVenta + ($InsTallerPedidoDetalle1->AmdPrecioVenta*($InsTallerPedido->AmoPorcentajeMantenimiento/100));
								
								//REDONDEO
								$InsTallerPedidoDetalle1->AmdPrecioVenta = FncRedondearCYC($InsTallerPedidoDetalle1->AmdPrecioVenta);
								
								
								$InsTallerPedidoDetalle1->AmdCosto = $DatFichaAccionMantenimiento->ProCosto;
								$InsTallerPedidoDetalle1->AmdCostoExtraTotal = 0;
																
								$InsTallerPedidoDetalle1->AmdCantidad = $DatFichaAccionMantenimiento->FapCantidad;

								$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad;
																						
									$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
									$InsProducto->MtdObtenerProducto(false);
									
									$InsUnidadMedida->UmeId = $InsTallerPedidoDetalle1->UmeId;
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
										$InsTallerPedidoDetalle1->AmdCantidadReal = round($InsTallerPedidoDetalle1->AmdCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
									}else{
										$InsTallerPedidoDetalle1->AmdCantidadReal = '';
									}
								
								$InsTallerPedidoDetalle1->AmdReingreso = 2;
								$InsTallerPedidoDetalle1->AmdCompraOrigen = "G";
								$InsTallerPedidoDetalle1->AmdEstado = 3;
								$InsTallerPedidoDetalle1->AmdTiempoCreacion = date("Y-m-d H:i:s");
								$InsTallerPedidoDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");
								$InsTallerPedidoDetalle1->AmdEliminado = 1;
		
								$InsTallerPedidoDetalle1->AlmId = $InsTallerPedido->AlmId;
								$InsTallerPedidoDetalle1->AmdFecha = date("Y-m-d");
								
								
									$InsTallerPedidoDetalle1->ProNombre = $DatFichaAccionMantenimiento->ProNombre;
									$InsTallerPedidoDetalle1->ProCodigoOriginal = $InsProducto->ProCodigoOriginal;
									$InsTallerPedidoDetalle1->ProCodigoAlternativo = $InsProducto->ProCodigoAlternativo;
									
									$InsTallerPedidoDetalle1->RtiId= $DatFichaAccionMantenimiento->RtiId;
									$InsTallerPedidoDetalle1->UmeNombre= $DatFichaAccionMantenimiento->UmeNombre;
									$InsTallerPedidoDetalle1->UmeIdOrigen= $DatFichaAccionMantenimiento->UmeIdOrigen;
									
									$InsTallerPedidoDetalle1->PmtId = $DatFichaAccionMantenimiento->PmtId;
									$InsTallerPedidoDetalle1->FaaAccion = $DatFichaAccionMantenimiento->FaaAccion;
									$InsTallerPedidoDetalle1->FaaNivel = $DatFichaAccionMantenimiento->FaaNivel;
									$InsTallerPedidoDetalle1->FaaVerificar1 = $DatFichaAccionMantenimiento->FaaVerificar1;
															
								$InsTallerPedidoDetalle1->InsMysql = NULL;

								$StockReal = 0;
								$VerificarStock = 2;
								
								$InsAlmacenProducto = new ClsAlmacenProducto();
								$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle1->ProId,$InsTallerPedido->AlmId,date("Y"),$InsTallerPedido->SucId);
								
								if($StockReal < $InsTallerPedidoDetalle1->AmdCantidadReal){		
									$VerificarStock = 1;
								}
	
								
								if($VerificarStock == 2){
									
									$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;
										
									$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;
								}



							}

						}
					}
					
					$TallerPedidoId = $InsTallerPedido->MtdVerificarExisteTallerPedido("FccId",$InsTallerPedido->FccId);
					//s//deb($TallerPedidoId);
					if(empty($TallerPedidoId)){

						if($InsTallerPedido->MtdRegistrarTallerPedido()){
							$validar++;
							FncCargarTallerPedidoDatos();
						}else{
							break;	
						}
						
					}else{
						$InsTallerPedido->AmoId = $TallerPedidoId;
						$InsTallerPedido->MtdObtenerTallerPedido();
						
						if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
				
							$InsTallerPedido->AmoDescuento = round($InsTallerPedido->AmoDescuento / $InsTallerPedido->AmoTipoCambio,2);
								
						}
							
							
						//deb("aaa");deb("aaa");deb("aaa");deb("aaa");
//						deb($InsTallerPedido->MonId);
//						deb($EmpresaMonedaId);
//						deb("aaa");
						if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
						
								$InsFichaAccion->FccManoObra = round($InsFichaAccion->FccManoObra / $InsTallerPedido->AmoTipoCambio,2);
						
							}
							
							
						$validar++;
					}
					
					
	
					
//		SesionObjeto-TallerPedidoFoto
//		Parametro1 = FafId
//		Parametro2 =
//		Parametro3 = FafArchivo
//		Parametro4 = FafEstado
//		Parametro5 = FafTiempoCreacion
//		Parametro6 = FafTiempoModificacion

//				if(!empty($InsFichaAccion->FichaAccionFoto)){
//					foreach($InsFichaAccion->FichaAccionFoto as $DatFichaAccionFoto){
//						
//						//$_SESSION['InsTallerPedidoFoto'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
////						$DatFichaAccionFoto->FafId,
////						NULL,
////						$DatFichaAccionFoto->FafArchivo,
////						$DatFichaAccionFoto->FafEstado,
////						($DatFichaAccionFoto->FafTiempoCreacion),
////						($DatFichaAccionFoto->FafTiempoModificacion)
////						);
//	
//					}
//				}		
					

				//$ArrTallerPedidos[] = $InsTallerPedido;	
						
		}
	}
			
			

	FncCargarDatos();

}




function FncCargarDatos(){

	global $InsFichaIngreso;
	global $Identificador;
	global $GET_Id;
	global $ArrTallerPedidos;
	global $ArrModalidadIngresos;
	global $EmpresaMonedaId;
	
	
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
			
			unset($_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsTallerPedidoFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsTallerPedidoFicha'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);

			$_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsTallerPedidoFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsTallerPedidoFicha'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			
		}		
	}

	$_SESSION['SesFinFotoVIN'.$Identificador] = $InsFichaIngreso->FinFotoVIN;
	$_SESSION['SesFinFotoFrontal'.$Identificador] = $InsFichaIngreso->FinFotoFrontal;
	$_SESSION['SesFinFotoCupon'.$Identificador] = $InsFichaIngreso->FinFotoCupon;
	$_SESSION['SesFinFotoMantenimiento'.$Identificador] = $InsFichaIngreso->FinFotoMantenimiento;
	
	unset($_SESSION['InsTallerPedidoHerramienta'.$Identificador]);
	unset($_SESSION['InsTallerPedidoGasto'.$Identificador]);
	unset($_SESSION['InsTallerPedidoAlmacenMovimientoEntrada'.$Identificador]);
			
	$_SESSION['InsTallerPedidoHerramienta'.$Identificador] = new ClsSesionObjeto();	
	$_SESSION['InsTallerPedidoGasto'.$Identificador] = new ClsSesionObjeto();	
	$_SESSION['InsTallerPedidoAlmacenMovimientoEntrada'.$Identificador] = new ClsSesionObjeto();	

//SesionObjeto-TallerPedidoGasto
//Parametro1 = FigId
//Parametro2 = GasId
//Parametro3 = GasComprobanteNumero
//Parametro4 = GasComprobanteFecha
//Parametro5 = GasTotal
//Parametro6 = FigEstado
//Parametro7 = GasTiempoCreacion
//Parametro8 = GasTiempoModificacion
//Parametro9 = PrvNombre
//Parametro10 = PrvApellidoPaterno
//Parametro11 = PrvApellidoMaterno
//Parametro12 = MonNombre
//Parametro13 = MonSimbolo
//Parametro14 = GasTipoCambio
//Parametro15 = MonId
//Parametro16 = GasFoto

	if(!empty($InsFichaIngreso->FichaIngresoGasto)){
		foreach($InsFichaIngreso->FichaIngresoGasto as $DatFichaIngresoGasto){					
		
			$_SESSION['InsTallerPedidoGasto'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatFichaIngresoGasto->FigId,
			$DatFichaIngresoGasto->GasId,
			$DatFichaIngresoGasto->GasComprobanteNumero,
			$DatFichaIngresoGasto->GasComprobanteFecha,
			$DatFichaIngresoGasto->GasTotal,
			$DatFichaIngresoGasto->FigEstado,
			($DatFichaIngresoGasto->FigTiempoCreacion),
			($DatFichaIngresoGasto->FigTiempoModificacion),
			$DatFichaIngresoGasto->PrvNombre,
			$DatFichaIngresoGasto->PrvApellidoPaterno,
			$DatFichaIngresoGasto->PrvApellidoMaterno,
			$DatFichaIngresoGasto->MonNombre,
			$DatFichaIngresoGasto->MonSimbolo,
			$DatFichaIngresoGasto->GasTipoCambio,
			$DatFichaIngresoGasto->MonId,
			$DatFichaIngresoGasto->GasFoto,
			$DatFichaIngresoGasto->GasConcepto);
			
		}
	}
	
	
//SesionObjeto-TallerPedidoAlmacenMovimientoEntrada
//Parametro1 = FilId
//Parametro2 = AmoId
//Parametro3 = AmoComprobanteNumero
//Parametro4 = AmoComprobanteFecha
//Parametro5 = AmoTotal
//Parametro6 = FilEstado
//Parametro7 = AmoTiempoCreacion
//Parametro8 = AmoTiempoModificacion
//Parametro9 = PrvNombre
//Parametro10 = PrvApellidoPaterno
//Parametro11 = PrvApellidoMaterno
//Parametro12 = MonNombre
//Parametro13 = MonSimbolo
//Parametro14 = AmoTipoCambio
//Parametro15 = MonId
//Parametro16 = AmoFoto

	if(!empty($InsFichaIngreso->FichaIngresoAlmacenMovimientoEntrada)){
		foreach($InsFichaIngreso->FichaIngresoAlmacenMovimientoEntrada as $DatFichaIngresoAlmacenMovimientoEntrada){					
		
			$_SESSION['InsTallerPedidoAlmacenMovimientoEntrada'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatFichaIngresoAlmacenMovimientoEntrada->FilId,
			$DatFichaIngresoAlmacenMovimientoEntrada->AmoId,
			$DatFichaIngresoAlmacenMovimientoEntrada->AmoComprobanteNumero,
			$DatFichaIngresoAlmacenMovimientoEntrada->AmoComprobanteFecha,
			$DatFichaIngresoAlmacenMovimientoEntrada->AmoTotal,
			$DatFichaIngresoAlmacenMovimientoEntrada->FilEstado,
			($DatFichaIngresoAlmacenMovimientoEntrada->FilTiempoCreacion),
			($DatFichaIngresoAlmacenMovimientoEntrada->FilTiempoModificacion),
			$DatFichaIngresoAlmacenMovimientoEntrada->PrvNombre,
			$DatFichaIngresoAlmacenMovimientoEntrada->PrvApellidoPaterno,
			$DatFichaIngresoAlmacenMovimientoEntrada->PrvApellidoMaterno,
			$DatFichaIngresoAlmacenMovimientoEntrada->MonNombre,
			$DatFichaIngresoAlmacenMovimientoEntrada->MonSimbolo,
			$DatFichaIngresoAlmacenMovimientoEntrada->AmoTipoCambio,
			$DatFichaIngresoAlmacenMovimientoEntrada->MonId,
			$DatFichaIngresoAlmacenMovimientoEntrada->AmoFoto,
			$DatFichaIngresoAlmacenMovimientoEntrada->AmoConcepto);
			
		}
	}
	
	
//SesionObjeto-TallerPedidoHerramienta
//Parametro1 = FihId
//Parametro2 = ProId
//Parametro3 = ProNombre
//Parametro4 = 
//Parametro5 = 
//Parametro6 = UmeId
//Parametro7 = FihTiempoCreacion
//Parametro8 = FihTiempoModificacion
//Parametro9 = FihCantidad
//Parametro10 = FihCantidadReal	
//Parametro11 = RtiId
//Parametro12 = UmeNombre
//Parametro13 = UmeIdOrigen
//Parametro14 = FihEstado

	if(!empty($InsFichaIngreso->FichaIngresoHerramienta)){
		foreach($InsFichaIngreso->FichaIngresoHerramienta as $DatFichaIngresoHerramienta){					
		
			$_SESSION['InsTallerPedidoHerramienta'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatFichaIngresoHerramienta->FihId,
			$DatFichaIngresoHerramienta->ProId,
			$DatFichaIngresoHerramienta->ProNombre,
			NULL,
			NULL,
			$DatFichaIngresoHerramienta->UmeId,
			($DatFichaIngresoHerramienta->FihTiempoCreacion),
			($DatFichaIngresoHerramienta->FihTiempoModificacion),
			$DatFichaIngresoHerramienta->FihCantidad,
			$DatFichaIngresoHerramienta->FihCantidadReal,
			$DatFichaIngresoHerramienta->RtiId,
			$DatFichaIngresoHerramienta->UmeNombre,
			$DatFichaIngresoHerramienta->UmeIdOrigen,
			$DatFichaIngresoHerramienta->FihEstado);
			
		}
	}
	
	

	
	
	
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){

			$InsTallerPedido = $DatFichaIngresoModalidad->FichaAccion->TallerPedido;
			if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
				
				$InsTallerPedido->AmoDescuento = round($InsTallerPedido->AmoDescuento / $InsTallerPedido->AmoTipoCambio,2);
								
			}
			
			$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;
			
//				deb($InsTallerPedido->AmoFecha);
	//			deb($DatFichaIngresoModalidad->FichaAccion->TallerPedidoFicha);
			
				foreach($DatFichaIngresoModalidad->FichaAccion->TallerPedidoFicha as $DatTallerPedidoFicha){					
				
//	SesionObjeto-TallerPedidoFicha
//	Parametro1 = AmoId
//	Parametro2 = AmoFecha
//	Parametro3 = AlmNombre
//	Parametro4 = AmoItems
//	Parametro5 = CliNombre
//	Parametro6 = AmoTiempoCreacion
//	Parametro7 = AmoTiempoModificacion
//	Parametro8 = CliApellidoPaterno
//	Parametro9 = CliApellidoMaterno
//	Parametro10 = AmoTotal
//	Parametro11 = MonNombre
//	Parametro12 = MonSimbolo

//	Parametro13 = GrtNumero
//	Parametro14 = GreId
//	Parametro15 = GrtId

//					deb($InsTallerPedido->AmoFecha." - ". date("d/m/Y"));
					//if(($DatTallerPedidoFicha->AmoFecha != date("d/m/Y"))){
						if(($DatTallerPedidoFicha->AmoId != $InsTallerPedido->AmoId)){
						
						$_SESSION['InsTallerPedidoFicha'.$DatFichaIngresoModalidad->FichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatTallerPedidoFicha->AmoId,
						$DatTallerPedidoFicha->AmoFecha,
						$DatTallerPedidoFicha->AlmNombre,
						$DatTallerPedidoFicha->AmoTotalItems,
						$DatTallerPedidoFicha->CliNombre,
						$DatTallerPedidoFicha->AmoTiempoCreacion,
						($DatTallerPedidoFicha->AmoTiempoModificacion),
						($DatTallerPedidoFicha->CliApellidoPaterno),
						$DatTallerPedidoFicha->CliApellidoMaterno,
						$DatTallerPedidoFicha->AmoTotal,
						$DatTallerPedidoFicha->MonNombre,
						$DatTallerPedidoFicha->MonSimbolo,
						
						$DatTallerPedidoFicha->GrtNumero,
						$DatTallerPedidoFicha->GreId,
						$DatTallerPedidoFicha->GreId);
					
					}
					
				}
				
			
				if($DatFichaIngresoModalidad->FichaAccion->MinId == "MIN-10001"){
				
				
						if(!empty($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento)){
							foreach($DatFichaIngresoModalidad->FichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
					
								//////////deb($DatFichaAccionMantenimiento->FaaId);
					
								$MantenimientoExiste = false;
					
								if(!empty($InsTallerPedido->TallerPedidoDetalle)){
									foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){	
					
										if($DatFichaAccionMantenimiento->FaaId == $DatTallerPedidoDetalle->FaaId){
					
										
											//if(($DatTallerPedidoDetalle->AmdTiempoModificacion) == "00/00/0000 00:00:00"){
											//	$DatTallerPedidoDetalle->AmdTiempoModificacion = date("d/m/Y H:i:s");
											//}
											
											
											
											if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
								
												$DatTallerPedidoDetalle->AmdCosto = round($DatTallerPedidoDetalle->AmdCosto / $InsTallerPedido->AmoTipoCambio,2);
												$DatTallerPedidoDetalle->AmdPrecioVenta = round($DatTallerPedidoDetalle->AmdPrecioVenta / $InsTallerPedido->AmoTipoCambio,2);
												$DatTallerPedidoDetalle->AmdImporte = round($DatTallerPedidoDetalle->AmdImporte / $InsTallerPedido->AmoTipoCambio,2);
								
											}
											
										//	SesionObjeto-TallerPedidoMantenimiento/InsTallerPedidoMantenimiento
										//	Parametro1 = AmdId
										//	Parametro2 = ProId
										//	Parametro3 = ProNombre
										//	Parametro4 = AmdPrecioVenta
										//	Parametro5 = AmdCantidad
										//	Parametro6 = AmdImporte
										//	Parametro7 = AmdTiempoCreacion
										//	Parametro8 = AmdTiempoModificacion
										//	Parametro9 = UmeNombre
										//	Parametro10 = UmeId
										//	Parametro11 = RtiId
										//	Parametro12 = AmdCantidadReal
										//	Parametro13 = ProCodigoOriginal,
										//	Parametro14 = ProCodigoAlternativo
										//	Parametro15 = UmeIdOrigen
										//	Parametro16 = VerificarStock
										//	Parametro17 = AmdCosto
										//	Parametro18 = Origen
										//	Parametro19 = Verificar
										//	Parametro20 = FaaId
										
										//	Parametro21 = PmtId
										//	Parametro22 = FaaAccion
										//	Parametro23 = FaaNivel
										//	Parametro24 = FaaVerificar1
										//	Parametro25 = FaaVerificar2
										//	Parametro26 = FapId
										
										//	Parametro27 = 
										//	Parametro28 = AmdEstado
										//	Parametro29 = AmdReingreso
										//	Parametro30 = 
										
										//	Parametro31 = AlmId
										//	Parametro32 = AmdFecha
										//	Parametro33 = AmdFacturado
										//	Parametro34 = AmoCierre

											$_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->FichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
											$DatTallerPedidoDetalle->AmdId,
											$DatTallerPedidoDetalle->ProId,
											$DatTallerPedidoDetalle->ProNombre,
											$DatTallerPedidoDetalle->AmdPrecioVenta,
											$DatTallerPedidoDetalle->AmdCantidad,
											$DatTallerPedidoDetalle->AmdImporte,
											($DatTallerPedidoDetalle->AmdTiempoCreacion),
											($DatTallerPedidoDetalle->AmdTiempoModificacion),
											$DatTallerPedidoDetalle->UmeNombre,
											$DatTallerPedidoDetalle->UmeId,
											$DatTallerPedidoDetalle->RtiId,
											$DatTallerPedidoDetalle->AmdCantidadReal,
											$DatTallerPedidoDetalle->ProCodigoOriginal,
											$DatTallerPedidoDetalle->ProCodigoAlternativo,
											$DatTallerPedidoDetalle->UmeIdOrigen,
											NULL,
											$DatTallerPedidoDetalle->AmdCosto,
											2,
											1,
											$DatTallerPedidoDetalle->FaaId,
											
											$DatTallerPedidoDetalle->PmtId,
											$DatTallerPedidoDetalle->FaaAccion,
											NULL,
											NULL,
											$DatTallerPedidoDetalle->FaaVerificar2,
											$DatTallerPedidoDetalle->FapId,
											$DatTallerPedidoDetalle->AmdCantidadReal,
											$DatTallerPedidoDetalle->AmdEstado,
											$DatTallerPedidoDetalle->AmdReingreso,
											NULL,
											
											$DatTallerPedidoDetalle->AlmId,
											$DatTallerPedidoDetalle->AmdFecha,
											
											$DatTallerPedidoDetalle->AmdFacturado,
											$DatTallerPedidoDetalle->AmoCierre,
											$DatTallerPedidoDetalle->AmdCompraOrigen
											
											);

											$MantenimientoExiste = true;
					
											break;
										}
					
									}					
								}
								
								if(!$MantenimientoExiste){
									
									//////////deb($DatFichaAccionMantenimiento->FaaId);
									$_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->FichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,							
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									NULL,
									1,
									1,
									$DatFichaAccionMantenimiento->FaaId,
									
									$DatFichaAccionMantenimiento->PmtId,
									$DatFichaAccionMantenimiento->FaaAccion,
									NULL,
									NULL,
									$DatFichaAccionMantenimiento->FaaVerificar2,
									//$DatFichaAccionMantenimiento->FapId
									
									NULL//chekear bien
									);
								}
							
								
							}
						}
					
			
								
			}
				
	
					if(!empty($InsTallerPedido->TallerPedidoDetalle)){
						foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){	
					//////deb($DatTallerPedidoDetalle->FaaId);
							if(empty($DatTallerPedidoDetalle->FaaId)){
								
								
								//deb($InsTallerPedido->MonId);
								//deb($EmpresaMonedaId);
//deb($InsTallerPedido->AmoTipoCambio);

//deb("A: ".$DatTallerPedidoDetalle->AmdPrecioVenta);

								if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
					
									$DatTallerPedidoDetalle->AmdCosto = round($DatTallerPedidoDetalle->AmdCosto / $InsTallerPedido->AmoTipoCambio,2);
									$DatTallerPedidoDetalle->AmdPrecioVenta = round($DatTallerPedidoDetalle->AmdPrecioVenta / $InsTallerPedido->AmoTipoCambio,2);
									$DatTallerPedidoDetalle->AmdImporte = round($DatTallerPedidoDetalle->AmdImporte / $InsTallerPedido->AmoTipoCambio,2);
					
								}
				
				//deb("B: ".$DatTallerPedidoDetalle->AmdPrecioVenta);
				
							//SesionObjeto-TallerPedidoDetalle/InsTallerPedidoDetalle
				//	Parametro1 = AmdId
				//	Parametro2 = ProId
				//	Parametro3 = ProNombre
				//	Parametro4 = AmdPrecioVenta
				//	Parametro5 = AmdCantidad
				//	Parametro6 = AmdImporte
				//	Parametro7 = AmdTiempoCreacion
				//	Parametro8 = AmdTiempoModificacion
				//	Parametro9 = UmeNombre
				//	Parametro10 = UmeId
				//	Parametro11 = RtiId
				//	Parametro12 = AmdCantidadReal
				//	Parametro13 = ProCodigoOriginal,
				//	Parametro14 = ProCodigoAlternativo
				//	Parametro15 = UmeIdOrigen
				//	Parametro16 = VerificarStock
				//	Parametro17 = AmdCosto
				//	Parametro18 = Origen
				//	Parametro19 = Verificar
				//	Parametro20 = FaaId
				
				//	Parametro21 = PmtId
				//	Parametro22 = FaaAccion
				//	Parametro23 = FaaNivel
				//	Parametro24 = FaaVerificar1
				//	Parametro25 = 
				//	Parametro26 = FapId	
				//	Parametro27 = AmdCantidadRealAnterior
				//	Parametro28 = AmdEstado
				//	Parametro29 = AmdReingreso
				//	Parametro30 = VddId
				
				//	Parametro31 = AlmId
				//	Parametro32 = AmdFecha
				//	Parametro33 = AmdFacturado
				//	Parametro34 = AmoCierre

				
								$_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->FichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
								$DatTallerPedidoDetalle->AmdId,
								$DatTallerPedidoDetalle->ProId,
								$DatTallerPedidoDetalle->ProNombre,
								$DatTallerPedidoDetalle->AmdPrecioVenta,
								$DatTallerPedidoDetalle->AmdCantidad,
								$DatTallerPedidoDetalle->AmdImporte,
								($DatTallerPedidoDetalle->AmdTiempoCreacion),
								($DatTallerPedidoDetalle->AmdTiempoModificacion),
								$DatTallerPedidoDetalle->UmeNombre,
								$DatTallerPedidoDetalle->UmeId,
								$DatTallerPedidoDetalle->RtiId,
								$DatTallerPedidoDetalle->AmdCantidadReal,
								$DatTallerPedidoDetalle->ProCodigoOriginal,
								$DatTallerPedidoDetalle->ProCodigoAlternativo,
								$DatTallerPedidoDetalle->UmeIdOrigen,
								NULL,
								$DatTallerPedidoDetalle->AmdCosto,
								2,
								1,
								NULL,
									
								NULL,
								NULL,
								NULL,
								NULL,
								NULL,
								
								$DatTallerPedidoDetalle->FapId,
								$DatTallerPedidoDetalle->AmdCantidadReal,
								$DatTallerPedidoDetalle->AmdEstado,
								$DatTallerPedidoDetalle->AmdReingreso,
								$DatTallerPedidoDetalle->VddId,
								
								$DatTallerPedidoDetalle->AlmId,
								$DatTallerPedidoDetalle->AmdFecha,
								
								$DatTallerPedidoDetalle->AmdFacturado,
								$DatTallerPedidoDetalle->AmoCierre,
								$DatTallerPedidoDetalle->AmdCompraOrigen
								);
									
							}
									
						}
					}


				

				
//////deb($_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->FichaAccion->MinSigla.$Identificador]);

//		SesionObjeto-TallerPedidoFoto
//		Parametro1 = FafId
//		Parametro2 =
//		Parametro3 = FafArchivo
//		Parametro4 = FafEstado
//		Parametro5 = FafTiempoCreacion
//		Parametro6 = FafTiempoModificacion

				if(!empty($InsFichaAccion->FichaAccionFoto)){
					foreach($InsFichaAccion->FichaAccionFoto as $DatFichaAccionFoto){
						
						$_SESSION['InsTallerPedidoFoto'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
						$DatFichaAccionFoto->FafId,
						NULL,
						$DatFichaAccionFoto->FafArchivo,
						$DatFichaAccionFoto->FafEstado,
						($DatFichaAccionFoto->FafTiempoCreacion),
						($DatFichaAccionFoto->FafTiempoModificacion)
						);
	
					}
				}	
		
		
			$ArrTallerPedidos[] = $InsTallerPedido;			

		}
	}
	
	
	
	
		
		
		
	
}






function FncCargarTallerPedidoDatos(){

	global $Identificador;
	global $InsTallerPedido;
	//global $InsFichaAccion;
	global $EmpresaMonedaId;
	
	$InsTallerPedido->MtdObtenerTallerPedido();

	unset($_SESSION['InsTallerPedidoDetalle'.$InsTallerPedido->MinSigla.$Identificador]);
	unset($_SESSION['InsTallerPedidoMantenimiento'.$InsTallerPedido->MinSigla.$Identificador]);
	unset($_SESSION['InsTallerPedidoFoto'.$InsTallerPedido->MinSigla.$Identificador]);

	$_SESSION['InsTallerPedidoDetalle'.$InsTallerPedido->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsTallerPedidoMantenimiento'.$InsTallerPedido->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsTallerPedidoFoto'.$InsTallerPedido->MinSigla.$Identificador] = new ClsSesionObjeto();

	//////////deb($InsTallerPedido);
	$InsFichaAccion = new ClsFichaAccion();
	
	$InsFichaAccion->FccId = $InsTallerPedido->FccId;
	$InsFichaAccion->MtdObtenerFichaAccion();
	
	//deb($InsTallerPedido->MonId);
	//deb($EmpresaMonedaId);
	
	if($InsTallerPedido->MonId<>$EmpresaMonedaId ){

		$InsFichaAccion->FccManoObra = round($InsFichaAccion->FccManoObra / $InsTallerPedido->AmoTipoCambio,2);

	}

//////////deb($InsFichaAccion->MinId);

	if($InsFichaAccion->MinId == "MIN-10001"){

	//// echo "AAAA";
		
		if(!empty($InsFichaAccion->FichaAccionMantenimiento)){
			foreach($InsFichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
		
				$MantenimientoExiste = false;
		
				if(!empty($InsTallerPedido->TallerPedidoDetalle)){
					foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){	
		
						if($DatFichaAccionMantenimiento->FaaId == $DatTallerPedidoDetalle->FaaId){
						
						//	if(($DatTallerPedidoDetalle->AmdTiempoModificacion) == "00/00/0000 00:00:00"){
//								$DatTallerPedidoDetalle->AmdTiempoModificacion = date("d/m/Y H:i:s");
//							}
							
							if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
				
								$DatTallerPedidoDetalle->AmdCosto = round($DatTallerPedidoDetalle->AmdCosto / $InsTallerPedido->AmoTipoCambio,2);
								$DatTallerPedidoDetalle->AmdPrecioVenta = round($DatTallerPedidoDetalle->AmdPrecioVenta / $InsTallerPedido->AmoTipoCambio,2);
								$DatTallerPedidoDetalle->AmdImporte = round($DatTallerPedidoDetalle->AmdImporte / $InsTallerPedido->AmoTipoCambio,2);
				
							}
							


//	SesionObjeto-TallerPedidoMantenimiento/InsTallerPedidoMantenimiento
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecioVenta
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro17 = AmdCosto
//	Parametro18 = Origen
//	Parametro19 = Verificar
//	Parametro20 = FaaId

//	Parametro21 = PmtId
//	Parametro22 = FaaAccion
//	Parametro23 = FaaNivel
//	Parametro24 = FaaVerificar1
//	Parametro25 = FaaVerificar2
//	Parametro26 = FapId

//	Parametro27 = 
//	Parametro28 = AmdEstado
//	Parametro29 = AmdReingreso
//	Parametro30 = 

//	Parametro31 = AlmId
//	Parametro32 = AmdFecha
//	Parametro33 = AmdFacturado
//	Parametro34 = AmoCierre
//	Parametro35 = AmdCompraOrigen
			
							$_SESSION['InsTallerPedidoMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
							$DatTallerPedidoDetalle->AmdId,
							$DatTallerPedidoDetalle->ProId,
							$DatTallerPedidoDetalle->ProNombre,
							$DatTallerPedidoDetalle->AmdPrecioVenta,
							$DatTallerPedidoDetalle->AmdCantidad,
							$DatTallerPedidoDetalle->AmdImporte,
							($DatTallerPedidoDetalle->AmdTiempoCreacion),
							($DatTallerPedidoDetalle->AmdTiempoModificacion),
							$DatTallerPedidoDetalle->UmeNombre,
							$DatTallerPedidoDetalle->UmeId,
							$DatTallerPedidoDetalle->RtiId,
							$DatTallerPedidoDetalle->AmdCantidadReal,
							$DatTallerPedidoDetalle->ProCodigoOriginal,
							$DatTallerPedidoDetalle->ProCodigoAlternativo,
							$DatTallerPedidoDetalle->UmeIdOrigen,
							NULL,
							$DatTallerPedidoDetalle->AmdCosto,
							2,
							1,
							$DatTallerPedidoDetalle->FaaId,
							
							$DatTallerPedidoDetalle->PmtId,
							$DatTallerPedidoDetalle->FaaAccion,
							NULL,
							NULL,
							$DatTallerPedidoDetalle->FaaVerificar2,
							$DatTallerPedidoDetalle->FapId,
							$DatTallerPedidoDetalle->AmdCantidadReal,
							$DatTallerPedidoDetalle->AmdEstado,
							$DatTallerPedidoDetalle->AmdReingreso,
							NULL,
							
							$DatTallerPedidoDetalle->AlmId,
							$DatTallerPedidoDetalle->AmdFecha,
							
							$DatTallerPedidoDetalle->AmdFacturado,
							$DatTallerPedidoDetalle->AmoCierre,
							$DatTallerPedidoDetalle->AmdCompraOrigen
							);
						
							$MantenimientoExiste = true;
		
							break;
						}
		
					}					
				}
				
				if(!$MantenimientoExiste){

					$_SESSION['InsTallerPedidoMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					NULL,
					NULL,
					NULL,
					NULL,							
					NULL,
					NULL,
					NULL,
					NULL,
					NULL,
					NULL,
					NULL,
					NULL,
					NULL,
					NULL,
					NULL,
					NULL,
					1,
					1,
					$DatFichaAccionMantenimiento->FaaId,
					
					$DatFichaAccionMantenimiento->PmtId,
					$DatFichaAccionMantenimiento->FaaAccion,
					NULL,
					NULL,
					$DatFichaAccionMantenimiento->FaaVerificar2,
					NULL
					);

				}
			
				
			}
		}
			
							
	}

//// echo "BBBB";

	if(!empty($InsTallerPedido->TallerPedidoDetalle)){
		foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){					
	
			if(empty($DatTallerPedidoDetalle->FaaId)){
	
			//SesionObjeto-TallerPedidoDetalle/InsTallerPedidoDetalle
			//	Parametro1 = AmdId
			//	Parametro2 = ProId
			//	Parametro3 = ProNombre
			//	Parametro4 = AmdPrecioVenta
			//	Parametro5 = AmdCantidad
			//	Parametro6 = AmdImporte
			//	Parametro7 = AmdTiempoCreacion
			//	Parametro8 = AmdTiempoModificacion
			//	Parametro9 = UmeNombre
			//	Parametro10 = UmeId
			//	Parametro11 = RtiId
			//	Parametro12 = AmdCantidadReal
			//	Parametro13 = ProCodigoOriginal,
			//	Parametro14 = ProCodigoAlternativo
			//	Parametro15 = UmeIdOrigen
			//	Parametro16 = VerificarStock
			//	Parametro17 = AmdCosto
			//	Parametro18 = Origen
			//	Parametro19 = Verificar
			//	Parametro20 = FaaId
			
			//	Parametro21 = PmtId
			//	Parametro22 = FaaAccion
			//	Parametro23 = FaaNivel
			//	Parametro24 = FaaVerificar1
			//	Parametro25 = 
			//	Parametro26 = FapId	
			//	Parametro27 = AmdCantidadRealAnterior
			//	Parametro28 = AmdEstado
			//	Parametro29 = AmdReingreso
			//	Parametro30 = VddId
			
			//	Parametro31 = AlmId
			//	Parametro32 = AmdFecha
			//	Parametro33 = AmdFacturado
			//	Parametro34 = AmoCierre
			//	Parametro35 = AmdCompraOrigen
			
			
				//if(($DatTallerPedidoDetalle->AmdTiempoModificacion) == "00/00/0000 00:00:00"){
	//						$DatTallerPedidoDetalle->AmdTiempoModificacion = date("d/m/Y H:i:s");
	//					}
				
				
				if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
	
					$DatTallerPedidoDetalle->AmdCosto = round($DatTallerPedidoDetalle->AmdCosto / $InsTallerPedido->AmoTipoCambio,2);
					$DatTallerPedidoDetalle->AmdPrecioVenta = round($DatTallerPedidoDetalle->AmdPrecioVenta / $InsTallerPedido->AmoTipoCambio,2);
					$DatTallerPedidoDetalle->AmdImporte = round($DatTallerPedidoDetalle->AmdImporte / $InsTallerPedido->AmoTipoCambio,2);
	
				}
	
						
				$_SESSION['InsTallerPedidoDetalle'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
				$DatTallerPedidoDetalle->AmdId,
				$DatTallerPedidoDetalle->ProId,
				$DatTallerPedidoDetalle->ProNombre,
				$DatTallerPedidoDetalle->AmdPrecioVenta,
				$DatTallerPedidoDetalle->AmdCantidad,
				$DatTallerPedidoDetalle->AmdImporte,
				($DatTallerPedidoDetalle->AmdTiempoCreacion),
				($DatTallerPedidoDetalle->AmdTiempoModificacion),
				$DatTallerPedidoDetalle->UmeNombre,
				$DatTallerPedidoDetalle->UmeId,
				$DatTallerPedidoDetalle->RtiId,
				$DatTallerPedidoDetalle->AmdCantidadReal,
				$DatTallerPedidoDetalle->ProCodigoOriginal,
				$DatTallerPedidoDetalle->ProCodigoAlternativo,
				$DatTallerPedidoDetalle->UmeIdOrigen,
				NULL,
				$DatTallerPedidoDetalle->AmdCosto,
				2,
				1,
				NULL,
	
				NULL,
				NULL,
				NULL,
				NULL,
				NULL,
				$DatTallerPedidoDetalle->FapId,
				$DatTallerPedidoDetalle->AmdCantidadReal,
				$DatTallerPedidoDetalle->AmdEstado,
				$DatTallerPedidoDetalle->AmdReingreso,
				$DatTallerPedidoDetalle->VddId,
				
				$DatTallerPedidoDetalle->AlmId,
				$DatTallerPedidoDetalle->AmdFecha,
				$DatTallerPedidoDetalle->AmdFacturado,
				$DatTallerPedidoDetalle->AmoCierre,
				$DatTallerPedidoDetalle->AmdCompraOrigen
				);
				
			//	////////deb($DatTallerPedidoDetalle->FapId);
	
			}
	
		}
	}
		
	

//		SesionObjeto-TallerPedidoFoto
//		Parametro1 = FafId
//		Parametro2 =
//		Parametro3 = FafArchivo
//		Parametro4 = FafEstado
//		Parametro5 = FafTiempoCreacion
//		Parametro6 = FafTiempoModificacion

	if(!empty($InsFichaAccion->FichaAccionFoto)){
		foreach($InsFichaAccion->FichaAccionFoto as $DatFichaAccionFoto){
			
			$_SESSION['InsTallerPedidoFoto'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatFichaAccionFoto->FafId,
			NULL,
			$DatFichaAccionFoto->FafArchivo,
			$DatFichaAccionFoto->FafEstado,
			($DatFichaAccionFoto->FafTiempoCreacion),
			($DatFichaAccionFoto->FafTiempoModificacion)
			);
	
		}
	}	
	
		
	
}



?>