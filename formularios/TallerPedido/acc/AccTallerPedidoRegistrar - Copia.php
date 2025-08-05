 <?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$ResultadoDetalle = '';
	$ItemSinStock = false;

	$InsFichaIngreso->UsuId = $_SESSION['SesionId'];
	$InsFichaIngreso->FinId =($_POST['CmpFichaIngresoId']);
	$InsFichaIngreso->CliId =($_POST['CmpClienteId']);
	$InsFichaIngreso->FinFecha =($_POST['CmpFecha']);
	$InsFichaIngreso->CliNombre =($_POST['CmpFichaIngresoCliente']);	
	$InsFichaIngreso->EinVIN =($_POST['CmpFichaIngresoVIN']);
	$InsFichaIngreso->EinPlaca =($_POST['CmpFichaIngresoPlaca']);
	
	$InsFichaIngreso->VmaNomvre =($_POST['CmpFichaIngresoMarca']);
	$InsFichaIngreso->VmoNombre =($_POST['CmpFichaIngresoModelo']);
	$InsFichaIngreso->VveNombre =($_POST['CmpFichaIngresoVersion']);
	
	$InsFichaIngreso->VmaId =($_POST['CmpVehiculoIngresoMarcaId']);
	$InsFichaIngreso->VmoId =($_POST['CmpVehiculoIngresoModeloId']);
	$InsFichaIngreso->VveId =($_POST['CmpVehiculoIngresoVersionId']);
	
	$InsFichaIngreso->PmaId =($_POST['CmpPlanMantenimientoId']);	
	$InsFichaIngreso->FinMantenimientoKilometraje =($_POST['CmpFichaIngresoMantenimientoKilometraje']);
	$InsFichaIngreso->FinAlmacenObservacion = addslashes($_POST['CmpAlmacenObservacion']);	
	
	$InsFichaIngreso->LtiId =($_POST['CmpClienteTipo']);
	
	
	//SesionObjeto-TallerPedidoGasto
	//Parametro1 = FigId
	//Parametro2 = GasId
	//Parametro3 = GasComprobanteNumero
	//Parametro4 = GasComprobanteFecha
	//Parametro5 = GasTotal
	//Parametro6 = FigEstado
	//Parametro7 = FigTiempoCreacion
	//Parametro8 = FigTiempoModificacion
	//Parametro9 = PrvNombre
	//Parametro10 = PrvApellidoPaterno
	//Parametro11 = PrvApellidoMaterno
	//Parametro12 = MonNombre
	//Parametro13 = MonSimbolo
	//Parametro14 = GasTipoCambio
	
	$RepSesionObjetos = $_SESSION['InsTallerPedidoGasto'.$Identificador]->MtdObtenerSesionObjetos(false);
	$ArrSesionObjetos = $RepSesionObjetos['Datos'];
	//				
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
	
	$validar = 0;
	
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
			
			$Guardar = true;

$InsFichaAccion = new ClsFichaAccion();
			$InsFichaAccion->FccId = $_POST['CmpFichaAccionId_'.$DatFichaIngresoModalidad->MinSigla];
			$InsFichaAccion->FimId = $DatFichaIngresoModalidad->FimId;
			$InsFichaAccion->FccManoObra = eregi_replace(",","",(empty($_POST['CmpFichaAccionManoObra_'.$DatFichaIngresoModalidad->MinSigla])?0:$_POST['CmpFichaAccionManoObra_'.$DatFichaIngresoModalidad->MinSigla]));
			$InsFichaAccion->FccManoObraDetalle = addslashes($_POST['CmpFichaAccionManoObraDetalle_'.$DatFichaIngresoModalidad->MinSigla]);
			$InsFichaAccion->PerId = ($_POST['CmpPersonal_'.$DatFichaIngresoModalidad->MinSigla]);
			
			if($InsFichaAccion->MtdEditarTrabajoTerminado()){
				
			}else{
				
			}
			
						
			$InsTallerPedido = new ClsTallerPedido();
			$InsTallerPedido->UsuId = $_SESSION['SesionId'];
			$InsTallerPedido->AmoId = $_POST['CmpId_'.$DatFichaIngresoModalidad->MinSigla];
			
			//$InsTallerPedido->CliId = $InsFichaIngreso->CliId;
			$InsTallerPedido->CliId = ($_POST['CmpClienteId_'.$DatFichaIngresoModalidad->MinSigla]);
			
			//$InsTallerPedido->AlmId = "ALM-10000";
			$InsTallerPedido->AlmId = $_POST['CmpAlmacen_'.$DatFichaIngresoModalidad->MinSigla];
			
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
						
			$InsTallerPedido->AmoTotal = 0;
			if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
				$InsTallerPedido->AmoDescuento = $InsTallerPedido->AmoDescuento * $InsTallerPedido->AmoTipoCambio;
			}
			
			$InsTallerPedido->TallerPedidoDetalle = array();

			if(!empty($InsTallerPedido->AmoId)){

				$RepSesionObjetos = $_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
				$ArrSesionObjetos = $RepSesionObjetos['Datos'];

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
		
						$InsTallerPedidoDetalle1->FaaId = $DatSesionObjeto->Parametro20;
						$InsTallerPedidoDetalle1->FapId = $DatSesionObjeto->Parametro26;
						$InsTallerPedidoDetalle1->VddId = $DatSesionObjeto->Parametro30;
		
						$InsTallerPedidoDetalle1->AmdCosto = $DatSesionObjeto->Parametro17;
						$InsTallerPedidoDetalle1->AmdCostoExtraTotal = 0;
		
						$ListaPrecioCosto = 0;
						$InsTallerPedidoDetalle1->AmdUtilidad = 0;
						$InsTallerPedidoDetalle1->AmdValorTotal = 0;
						$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;
						
						$InsTallerPedidoDetalle1->AmdId = $DatSesionObjeto->Parametro1;
						$InsTallerPedidoDetalle1->ProId = $DatSesionObjeto->Parametro2;
										
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
						$InsProducto->MtdObtenerProducto(false);
							
						$InsTallerPedidoDetalle1->UmeId = $DatSesionObjeto->Parametro10;
						$InsTallerPedidoDetalle1->AmdCantidad = $DatSesionObjeto->Parametro5;	
						$InsTallerPedidoDetalle1->AmdCantidadReal = $DatSesionObjeto->Parametro12;
						$InsTallerPedidoDetalle1->AmdCantidadRealAnterior= $DatSesionObjeto->Parametro27;
						
						$InsTallerPedidoDetalle1->AmdPrecioVenta = $DatSesionObjeto->Parametro4;
						$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad;
						
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						$InsUnidadMedida = new ClsUnidadMedida();
						$InsUnidadMedida->UmeId = $InsTallerPedidoDetalle1->UmeId;
						$InsUnidadMedida->MtdObtenerUnidadMedida();
		
						//$InsTallerPedidoDetalle1->AmdReingreso = $DatSesionObjeto->Parametro29;
						$InsTallerPedidoDetalle1->AmdReingreso = 2;
						//$InsTallerPedidoDetalle1->AmdCompraOrigen = $_POST['CmpTallerPedidoDetalleCompraOrigen_'.$InsTallerPedido->MinSigla.$DatSesionObjeto->Parametro7];
						$InsTallerPedidoDetalle1->AmdCompraOrigen = "X";

						//$InsTallerPedidoDetalle1->AmdEstado = $DatSesionObjeto->Parametro28;
						$InsTallerPedidoDetalle1->AmdEstado = ($_POST['CmpTallerPedidoDetalleEstado_'.$DatFichaIngresoModalidad->MinSigla.$DatSesionObjeto->Item]);

					//	$InsTallerPedidoDetalle1->AmdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
//						$InsTallerPedidoDetalle1->AmdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
						$InsTallerPedidoDetalle1->AmdTiempoCreacion = date("Y-m-d H:i:s");
						$InsTallerPedidoDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");

						if((empty($InsTallerPedidoDetalle1->ProId) and !empty($InsTallerPedidoDetalle1->AmdId) or ($DatSesionObjeto->Eliminado==2))){
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
		
						$InsTallerPedidoDetalle1->VerificarStock = $DatSesionObjeto->Parametro16;
						$InsTallerPedidoDetalle1->AmdValidarStock = $InsProducto->ProValidarStock;
						$InsTallerPedidoDetalle1->Origen= $DatSesionObjeto->Parametro18;
						
						$InsTallerPedidoDetalle1->AmdFacturado = $DatSesionObjeto->Parametro33;
						$InsTallerPedidoDetalle1->AmdCierre = $DatSesionObjeto->Parametro34;
						
						if($InsTallerPedidoDetalle1->AmdEliminado == 1){
							$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;
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
				//	Parametro34 = AmdCierre
				
				
						/*$_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
						NULL,
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
						$InsTallerPedidoDetalle1->VerificarStock,
						$InsTallerPedidoDetalle1->AmdCosto,
						$InsTallerPedidoDetalle1->Origen,
						$InsTallerPedidoDetalle1->Verificar,
						$InsTallerPedidoDetalle1->FaaId,
						
						NULL,
						NULL,
						NULL,
						NULL,
						NULL,
						$InsTallerPedidoDetalle1->FapId,
						$InsTallerPedidoDetalle1->AmdCantidadReal,
						$InsTallerPedidoDetalle1->AmdEstado,
						$InsTallerPedidoDetalle1->AmdReingreso,
						$InsTallerPedidoDetalle1->VddId,
						
						$InsTallerPedidoDetalle1->AlmId,
						  FncCambiaFechaANormal($InsTallerPedidoDetalle1->AmdFecha),
						  
						  $InsTallerPedidoDetalle1->AmdFacturado,
						  $InsTallerPedidoDetalle1->AmdCierre
						);
		*/
						$item++;				
					}
				}


	$RepSesionObjetos = $_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdObtenerSesionObjetos(false);
	$ArrSesionObjetos = $RepSesionObjetos['Datos'];

	if(!empty($ArrSesionObjetos)){
		foreach($ArrSesionObjetos as $DatSesionObjeto){

			//VERIFICAR SI SE VA ARETIRAR
			$InsFichaAccionMantenimiento1 = new ClsFichaAccionMantenimiento();
			$InsFichaAccionMantenimiento1->FaaId = $_POST['CmpFichaAccionMantenimientoId_'.$DatSesionObjeto->Parametro21];
			$InsFichaAccionMantenimiento1->PmtId = $DatSesionObjeto->Parametro21;						
			
			$InsFichaAccionMantenimiento1->FaaAccion = $_POST['CmpFichaAccionMantenimientoAccion_'.$DatSesionObjeto->Parametro21];
			$InsFichaAccionMantenimiento1->FaaVerificar2 = (empty($_POST['CmpFichaAccionMantenimientoVerificar2_'.$DatSesionObjeto->Parametro21])?2:1);				
			$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");
			$InsFichaAccionMantenimiento1->FapId = $_POST['CmpFichaAccionProductoId_'.$DatSesionObjeto->Parametro21];
			$InsFichaAccionMantenimiento1->InsMysql = NULL;
			
			$InsTallerPedido->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;
			
			//OBTENIENDO PRODUCTO
						
			//deb($DatSesionObjeto->Parametro21." / ".$_POST['CmpFichaAccionMantenimientoAccion_'.$DatSesionObjeto->Parametro21]." / ".$DatSesionObjeto->Parametro1." / ".$_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoId']);
			//if(!empty($InsTallerPedidoDetalle1->AmdId)){
			if(!empty($DatSesionObjeto->Parametro1)){							
				
				$InsProducto = new ClsProducto();
				$InsProducto->ProId = $_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoId'];;
				$InsProducto->MtdObtenerProducto(false);
	
					if(!empty($_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoId'])){
					   
						//echo "CCC";
						$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();
						$InsTallerPedidoDetalle1->AmdId = $DatSesionObjeto->Parametro1;
						$InsTallerPedidoDetalle1->ProId = $_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoId'];
				
						//OBTENIENDO PRODUCTO
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
						$InsProducto->MtdObtenerProducto(false);
								
							$InsTallerPedidoDetalle1->FaaId = $DatSesionObjeto->Parametro20;
							$InsTallerPedidoDetalle1->FapId = $InsFichaAccionMantenimiento1->FapId;
							
							$InsTallerPedidoDetalle1->UmeId = $_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoUnidadMedidaConvertir'];
							
							$ListaPrecioCosto  = 0;
							$InsTallerPedidoDetalle1->AmdUtilidad = 0;
							$InsTallerPedidoDetalle1->AmdValorTotal = 0;
							$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;
			
							//OBTENIENDO LISTA DE PRECIOS
							//if(!empty($InsTallerPedidoDetalle1->ProId) and !empty($InsFichaIngreso->LtiId) and !empty($InsTallerPedidoDetalle1->UmeId)){
//						
//								$InsListaPrecio = new ClsListaPrecio();
//								$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$InsTallerPedidoDetalle1->ProId,$InsFichaIngreso->LtiId,$InsTallerPedidoDetalle1->UmeId);
//								$ArrListaPrecios = $ResListaPrecio['Datos'];
//								
//								foreach($ArrListaPrecios as $DatListaPrecio){
//									
//									$ListaPrecioCosto = (empty($DatListaPrecio->LprCosto)?0:$DatListaPrecio->LprCosto);
//									$InsTallerPedidoDetalle1->AmdUtilidad = (empty($DatListaPrecio->LprUtilidad)?0:$DatListaPrecio->LprUtilidad);
//									$InsTallerPedidoDetalle1->AmdValorTotal = (empty($DatListaPrecio->LprValorVenta)?0:$DatListaPrecio->LprValorVenta);
//									$InsTallerPedidoDetalle1->AmdPrecioVenta = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);//AGREGADO-28-02-14
//									
//								}
//								
//							}
			
							$InsTallerPedidoDetalle1->AmdCosto = $DatSesionObjeto->Parametro17;
							$InsTallerPedidoDetalle1->AmdCostoExtraTotal = 0;
							$InsTallerPedidoDetalle1->AmdCantidad = eregi_replace(",","",$_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoCantidad']);
							//$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad ;							
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

							//OBTENIENDO UNIDAD DE MEDIDA
							$InsUnidadMedida = new ClsUnidadMedida();
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
							
							$InsTallerPedidoDetalle1->AmdCantidadRealAnterior= $DatSesionObjeto->Parametro27;
							//$InsTallerPedidoDetalle1->AmdReingreso = $_POST['Cmp'.$DatSesionObjeto->Parametro21.'TallerPedidoDetalleReingreso'];
							$InsTallerPedidoDetalle1->AmdReingreso = 2;
							//$InsTallerPedidoDetalle1->AmdCompraOrigen = $_POST['CmpTallerPedidoDetalleCompraOrigen_'.$DatSesionObjeto->Parametro21];
							$InsTallerPedidoDetalle1->AmdCompraOrigen = "X";
							$InsTallerPedidoDetalle1->AmdEstado = (empty($_POST['Cmp'.$DatSesionObjeto->Parametro21.'TallerPedidoDetalleEstado'])?1:($_POST['Cmp'.$DatSesionObjeto->Parametro21.'TallerPedidoDetalleEstado']));
						
				
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
							$InsTallerPedidoDetalle1->VerificarStock = $DatSesionObjeto->Parametro16;
							$InsTallerPedidoDetalle1->AmdValidarStock = $InsProducto->ProValidarStock;
							$InsTallerPedidoDetalle1->Origen= $DatSesionObjeto->Parametro18;
							
							$InsTallerPedidoDetalle1->AmdFacturado = $DatSesionObjeto->Parametro33;
							$InsTallerPedidoDetalle1->AmdCierre = $DatSesionObjeto->Parametro34;
							
							$InsTallerPedidoDetalle1->InsMysql = NULL;
			
						   // $InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;	
							$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;
			
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
							//	Parametro34 = AmdCierre		
					
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
							$InsTallerPedidoDetalle1->VerificarStock,
							$InsTallerPedidoDetalle1->AmdCosto,
							$InsTallerPedidoDetalle1->Origen,
							NULL,
							$InsTallerPedidoDetalle1->FaaId,
			
							$InsFichaAccionMantenimiento1->PmtId,
							$DatSesionObjeto->Parametro22,
							NULL,
							NULL,
							$InsFichaAccionMantenimiento1->FaaVerificar2,
							$InsFichaAccionMantenimiento1->FapId,
							$InsTallerPedidoDetalle1->AmdCantidadReal,
							$InsTallerPedidoDetalle1->AmdEstado,
							$InsTallerPedidoDetalle1->AmdReingreso,
							NULL,
							$InsTallerPedidoDetalle1->AlmId,
							FncCambiaFechaANormal($InsTallerPedidoDetalle1->AmdFecha),
							
							$InsTallerPedidoDetalle1->AmdFacturado,
							$InsTallerPedidoDetalle1->AmdCierre,
							$InsTallerPedidoDetalle1->AmdCompraOrigen
							);
							
					}else{
			
						$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();
						$InsTallerPedidoDetalle1->AmdId = $DatSesionObjeto->Parametro1;
						$InsTallerPedidoDetalle1->AmdEliminado = 2;
						
						$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;	

						unset($InsTallerPedidoDetalle1);
							
						$_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
						$DatSesionObjeto->Parametro1,
						"",
						"",
						0,
						0,
						0,
						$DatSesionObjeto->Parametro7,
						$DatSesionObjeto->Parametro8,
						$DatSesionObjeto->Parametro9,
						$DatSesionObjeto->Parametro10,
						$DatSesionObjeto->Parametro11,
						0,
						"",
						$DatSesionObjeto->Parametro14,
						$DatSesionObjeto->Parametro15,
						$DatSesionObjeto->Parametro16,
						$DatSesionObjeto->Parametro17,
						$DatSesionObjeto->Parametro18,
						$DatSesionObjeto->Parametro19,
						
						$DatSesionObjeto->Parametro20,
						$DatSesionObjeto->Parametro21,

						$DatSesionObjeto->Parametro22,
						$DatSesionObjeto->Parametro23,
						$DatSesionObjeto->Parametro24,
						
						$DatSesionObjeto->Parametro25,
						$DatSesionObjeto->Parametro26
						);
						
							
					//	$_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]->MtdEditarSesionObjeto($DatSesionObjeto->Item,1,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						NULL,
//						$InsFichaAccionMantenimiento1->FaaId,
//			
//						$InsFichaAccionMantenimiento1->PmtId,
//						//$InsFichaAccionMantenimiento1->FaaAccion,
//						$DatSesionObjeto->Parametro22,
//						NULL,
//						NULL,
//						$InsFichaAccionMantenimiento1->FaaVerificar2,
//						$InsFichaAccionMantenimiento1->FapId
//						);
						
						if(!empty($InsFichaAccionMantenimiento1->FapId)){
			
							$InsFichaAccionProducto1->FapId = $InsFichaAccionMantenimiento1->FapId;
							$InsFichaAccionProducto1->FapEliminado = 2;
							$InsTallerPedido->FichaAccionProducto[] = $InsFichaAccionProducto1;
			
						}								
						//echo "DDD";
			
					}
			
			
			}else{
						  ///echo "GGG";
						  //if(!empty($InsTallerPedidoDetalle1->ProId)){
				if(!empty($_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoId'])){
							  
					//deb($_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoId']);
					//echo "HHH";
					$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();
					$InsTallerPedidoDetalle1->AmdId = $DatSesionObjeto->Parametro1;
					$InsTallerPedidoDetalle1->ProId = $_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoId'];
					
					//OBTENIENDO DATOS DEL PRODUCTO
					$InsProducto = new ClsProducto();
					$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
					$InsProducto->MtdObtenerProducto(false);
				
					$InsTallerPedidoDetalle1->FaaId = $DatSesionObjeto->Parametro20;
					$InsTallerPedidoDetalle1->FapId = $InsFichaAccionMantenimiento1->FapId;
					$InsTallerPedidoDetalle1->UmeId = $_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoUnidadMedidaConvertir'];
					
					$ListaPrecioCosto = 0;
					$InsTallerPedidoDetalle1->AmdUtilidad = 0;
					$InsTallerPedidoDetalle1->AmdValorTotal = 0;
					$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;
	
					//if(!empty($InsTallerPedidoDetalle1->ProId) and !empty($InsFichaIngreso->LtiId) and !empty($InsTallerPedidoDetalle1->UmeId)){
//				
//						$InsListaPrecio = new ClsListaPrecio();
//						$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$InsTallerPedidoDetalle1->ProId,$InsFichaIngreso->LtiId,$InsTallerPedidoDetalle1->UmeId);
//						$ArrListaPrecios = $ResListaPrecio['Datos'];
//						
//						foreach($ArrListaPrecios as $DatListaPrecio){
//							
//							$ListaPrecioCosto = (empty($DatListaPrecio->LprCosto)?0:$DatListaPrecio->LprCosto);
//							$InsTallerPedidoDetalle1->AmdUtilidad = (empty($DatListaPrecio->LprUtilidad)?0:$DatListaPrecio->LprUtilidad);
//							$InsTallerPedidoDetalle1->AmdValorTotal = (empty($DatListaPrecio->LprValorVenta)?0:$DatListaPrecio->LprValorVenta);
//							$InsTallerPedidoDetalle1->AmdPrecioVenta = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);//AGREGADO-28-02-14
//							
//						}
//						
//					}
	
				
					$InsTallerPedidoDetalle1->AmdCosto = $InsProducto->ProCosto;
					$InsTallerPedidoDetalle1->AmdCostoExtraTotal = 0;
					$InsTallerPedidoDetalle1->AmdCantidad = eregi_replace(",","",$_POST['Cmp'.$DatSesionObjeto->Parametro21.'ProductoCantidad']);
					
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

//					$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad ;
			
					//OBTENIENDO UNIDAD DE MEDIDA
					$InsUnidadMedida = new ClsUnidadMedida();
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
					
					//$InsTallerPedidoDetalle1->AmdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
					//$InsTallerPedidoDetalle1->AmdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
					$InsTallerPedidoDetalle1->AmdTiempoCreacion = date("Y-m-d H:i:s");
					$InsTallerPedidoDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");
					$InsTallerPedidoDetalle1->AmdEliminado = 1;		
							
					$InsTallerPedidoDetalle1->AlmId = ($_POST['CmpAlmacenId_'.$DatSesionObjeto->Parametro21]);
					$InsTallerPedidoDetalle1->AmdFecha = FncCambiaFechaAMysql($_POST['CmpTallerPedidoDetalleFecha_'.$DatSesionObjeto->Parametro21]);
							
					//DATOS DEL PRODUCTO
					$InsTallerPedidoDetalle1->ProNombre = $InsProducto->ProNombre;
					$InsTallerPedidoDetalle1->ProCodigoOriginal = $InsProducto->ProCodigoOriginal;
					$InsTallerPedidoDetalle1->ProCodigoAlternativo = $InsProducto->ProCodigoAlternativo;
					
					$InsTallerPedidoDetalle1->RtiId = $InsProducto->RtiId;
					$InsTallerPedidoDetalle1->UmeNombre = $InsUnidadMedida->UmeNombre;
					$InsTallerPedidoDetalle1->UmeIdOrigen = $InsProducto->UmeId;
	
					//DATOS EXTRA DEL PRODUCTO
					$InsTallerPedidoDetalle1->VerificarStock = $DatSesionObjeto->Parametro16;
					$InsTallerPedidoDetalle1->AmdValidarStock = $InsProducto->ProValidarStock;
					$InsTallerPedidoDetalle1->Origen = $DatSesionObjeto->Parametro18;
					
					$InsTallerPedidoDetalle1->AmdFacturado = $DatSesionObjeto->Parametro33;
					$InsTallerPedidoDetalle1->AmdCierre = $DatSesionObjeto->Parametro34;
							
								
					$InsTallerPedidoDetalle1->InsMysql = NULL;
					
					$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;
					
					$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;	
									
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
					$InsTallerPedidoDetalle1->VerificarStock,
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
					$InsTallerPedidoDetalle1->AmdCantidadReal,
					$InsTallerPedidoDetalle1->AmdEstado,
					$InsTallerPedidoDetalle1->AmdReingreso,
					NULL,
					$InsTallerPedidoDetalle1->AlmId,
					FncCambiaFechaANormal($InsTallerPedidoDetalle1->AmdFecha),
					$InsTallerPedidoDetalle1->AmdFacturado,
					$InsTallerPedidoDetalle1->AmdCierre,
					$InsTallerPedidoDetalle1->AmdCompraOrigen
					);
	  
								  
				}else{
							  //echo "III";	
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
	}
				if($Guardar){
					
					if($DatFichaIngresoModalidad->MinSigla=="MA"){
						echo "<h1>SE ENCONTRARON ".count($InsTallerPedido->TallerPedidoDetalle)." ITEMS EN LA FICHA DE MANTENIMIENTO</h1>";
					}
					
					if($InsTallerPedido->MtdEditarTallerPedido()){
						
						FncCargarTallerPedidoDatos($InsTallerPedido->AmoId);
						//$Resultado.='#SAS_TPE_101';
						$validar++;
					}else{
						$InsTallerPedido->AmoFecha = FncCambiaFechaANormal($InsTallerPedido->AmoFecha);
						//$Resultado.='#ERR_TPE_101';
					}
										
				}else{
					$InsTallerPedido->AmoFecha = FncCambiaFechaANormal($InsTallerPedido->AmoFecha);
				}


				$ArrTallerPedidos[] = $InsTallerPedido;				

			}

		}
	}


	//////deb(count($InsFichaIngreso->FichaIngresoModalidad)." - ".$validar);
	
	
	$InsFichaIngreso->MtdEditarFichaIngresoDato("FinAlmacenObservacion",$InsFichaIngreso->FinAlmacenObservacion,$InsFichaIngreso->FinId);
		
	$InsFichaIngreso->MtdEditarFichaIngresoGasto();
	
	if(count($InsFichaIngreso->FichaIngresoModalidad) == $validar){		

		if($InsFichaIngreso->FinEstado == 5){
			//ACTUALIZANDO A ALMACEN [Preparando Pedido]
			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,6,false); //OJO
			
			if($POST_FichaIngresoEnviar == "1"){

				//ACTUALIZANDO A ALMACEN [Pedido Enviado]
				$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,7);

				//ACTUALIZANDO A TALLER [Pedido Recibido]
				$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,71);
				
				//ACTUALIZANDO A TALLER [Trabajo Terminado]
				$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,73);
			}
					
		}
		
		
		$Resultado .= '#SAS_TPE_101';
		
		$Registro =true;

	}else{
		$Resultado .='#ERR_TPE_102';	
	}

}else{
	
	if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
			
			unset($_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			unset($_SESSION['InsTallerPedidoFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
			
			$_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			$_SESSION['InsTallerPedidoFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
			
		}
	}

	$_SESSION['SesFinFotoVIN'.$Identificador] = $InsFichaIngreso->FinFotoVIN;
	$_SESSION['SesFinFotoFrontal'.$Identificador] = $InsFichaIngreso->FinFotoFrontal;
	$_SESSION['SesFinFotoCupon'.$Identificador] = $InsFichaIngreso->FinFotoCupon;
	$_SESSION['SesFinFotoMantenimiento'.$Identificador] = $InsFichaIngreso->FinFotoMantenimiento;
	
	unset($_SESSION['InsTallerPedidoHerramienta'.$Identificador]);
			
	$_SESSION['InsTallerPedidoHerramienta'.$Identificador] = new ClsSesionObjeto();
	
	if($InsFichaIngreso->FinEstado == 4){


		$validar = 0;
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
											
											$InsPlanMantenimiento = new ClsPlanMantenimiento();
											$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId);
											$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
											
											$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
											unset($ArrPlanMantenimientos);
											$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
											
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

				}else{
					$FichaAccionId = $InsFichaAccion->FccId;
				}
					
			}
			
		
	}
	
	
	$InsFichaIngreso->FinId = $GET_FinId;
	$InsFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngreso();	
			
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

		$validar = 0;
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
											
											$InsPlanMantenimiento = new ClsPlanMantenimiento();
											$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$InsFichaIngreso->VmoId);
											$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
											
											$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
											unset($ArrPlanMantenimientos);
											$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
											
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

				}else{
					$FichaAccionId = $InsFichaAccion->FccId;
				}
			
				$InsTallerPedido = new ClsTallerPedido();	
				$InsTallerPedido->SucId = $_SESSION['SesionSucursal'];
				$InsTallerPedido->UsuId = $_SESSION['SesionId'];	
				$InsTallerPedido->FccId = $FichaAccionId;
				$InsTallerPedido->TopId = "TOP-10000";
				
				$InsAlmacen = new ClsAlmacen();
				$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$InsTallerPedido->SucId);
				$ArrAlmacenes = $RepAlmacen['Datos'];
				
				$AlmacenId = "";
				
				if(!empty($ArrAlmacenes)){
					foreach($ArrAlmacenes as $DatAlmacen){
						$AlmacenId = $DatAlmacen->AlmId;						
					}
				}
				
				$InsTallerPedido->AlmId = $AlmacenId;

			//	if($DatFichaIngresoModalidad->MinSigla == "MA" and $InsFichaIngreso->VmaId == "VMA-10017" ){
//					$InsTallerPedido->AlmId = "ALM-10001";
//				}else{
//					$InsTallerPedido->AlmId = "ALM-10000";
//				}
					
				
				//if( ($DatFichaIngresoModalidad->MinSigla == "GA" or $InsFichaIngreso->FinTipo ) or $DatFichaIngresoModalidad->MinSigla == "IF" or $DatFichaIngresoModalidad->MinSigla == "AD" or $DatFichaIngresoModalidad->MinSigla == "PP"){
				
				//////deb($DatFichaIngresoModalidad->MinSigla." - ".$InsFichaIngreso->FinTipo);
				
				//CORREGIDO EL DIA 12-11-14
				
				//				if( ($DatFichaIngresoModalidad->MinSigla == "GA" and $InsFichaIngreso->FinTipo == 2 ) or $DatFichaIngresoModalidad->MinSigla == "IF" or $DatFichaIngresoModalidad->MinSigla == "AD" or $DatFichaIngresoModalidad->MinSigla == "PP"){
				//	
				//	
				//					$InsCliente = new ClsCliente();
				//					$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"CYC");
				//					$ArrClientes = $ResCliente['Datos'];
				//					
				//					if(!empty($ArrClientes)){
				//						foreach($ArrClientes as $DatCliente){
				//						
				//							$InsTallerPedido->CliId = $DatCliente->CliId;
				//							
				//						}
				//					}
				//					
				//				}else{
				//					$InsTallerPedido->CliId = $InsFichaIngreso->CliId;	
				//				}
				//								
				$InsTallerPedido->CliId = $InsFichaIngreso->CliId;
				$InsTallerPedido->LtiId = $InsFichaIngreso->LtiId;
				
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
					$InsTallerPedido->AmoPorcentajeMantenimiento = 000;;
				}else{
					$InsTallerPedido->AmoPorcentajeMantenimiento = 0;
				}
				$InsTallerPedido->AmoIncluyeImpuesto = 1;
				$InsTallerPedido->AmoPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
				$InsTallerPedido->AmoEstado = 3;//ANTES ERA 3
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
//	Parametro34 = AmdCierre


					if(!empty($InsFichaAccion->FichaAccionProducto) and empty($InsFichaAccion->FichaAccionMantenimiento)){//REVISAR 02-05-17
						foreach($InsFichaAccion->FichaAccionProducto as $DatFichaAccionProducto){					

							if(!empty($DatFichaAccionProducto->ProId) 
							
								and (
								$DatFichaAccionProducto->FapAccion=="C" 
								or $DatFichaAccionProducto->FapAccion=="U" 
								or $DatFichaAccionProducto->FapAccion==""
								//or $DatFichaAccionMantenimiento->FaaAccion=="R"
								) 
							
							){
								
								if(empty($DatFichaAccionProducto->UmeId)){

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
										
										//$InsTallerPedidoDetalle1->AmdPrecioVenta = round($InsTallerPedidoDetalle1->AmdPrecioVenta, 0, PHP_ROUND_HALF_UP);
										
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
								//or $DatFichaIngresoModalidad->MinSigla == "OB"
								){	
									$InsTallerPedidoDetalle1->AmdUtilidad = 0;
									$InsTallerPedidoDetalle1->AmdValorTotal = $ListaPrecioCosto;
									$InsTallerPedidoDetalle1->AmdPrecioVenta = $InsTallerPedidoDetalle1->AmdValorTotal + (($InsTallerPedido->AmoPorcentajeImpuestoVenta/100) * $InsTallerPedidoDetalle1->AmdValorTotal);
									
								}
								
								
								//REDONDEO
								$InsTallerPedidoDetalle1->AmdPrecioVenta = FncRedondearCYC($InsTallerPedidoDetalle1->AmdPrecioVenta);
								
								$InsTallerPedidoDetalle1->AmdCosto = $DatFichaAccionProducto->ProCosto;								
								$InsTallerPedidoDetalle1->AmdCostoExtraTotal = 0;
								
								$InsTallerPedidoDetalle1->AmdCantidad = $DatFichaAccionProducto->FapCantidad;

								$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad;
									
									$InsProducto = new ClsProducto();
									$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
									$InsProducto->MtdObtenerProducto(false);
									
									$InsUnidadMedida = new ClsUnidadMedida();
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
								$InsTallerPedidoDetalle1->AmdValidarStock = $InsProducto->ProValidarStock;
								$InsTallerPedidoDetalle1->AmdEstado = 3;//ANTES ERA 3
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
							
							
							
							$StockReal = 0;
							$VerificarStock = 2;
							
							//$InsAlmacenProducto = new ClsAlmacenProducto();
							//$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle1->ProId,$InsTallerPedido->AlmId,date("Y"));
							
							//if($StockReal < $InsTallerPedidoDetalle1->AmdCantidadReal){		
							//	$VerificarStock = 1;
							//}

						
							
							//if($VerificarStock == 2){
								$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;
								$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;
							//}
							
							
								//$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;

								//$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;

							}

						}
					}
					
				//	deb($InsFichaAccion->FichaAccionMantenimiento);
					
					if(!empty($InsFichaAccion->FichaAccionMantenimiento)){
						foreach($InsFichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){					
	
							if(
							!empty($DatFichaAccionMantenimiento->ProId) 
							and !empty($DatFichaAccionMantenimiento->UmeId) 
							and ($DatFichaAccionMantenimiento->FaaAccion=="C" 
							or $DatFichaAccionMantenimiento->FaaAccion=="U" 
							or $DatFichaAccionMantenimiento->FaaAccion=="R"
							) ){
								
								
								$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();
								
								//////deb($DatFichaAccionMantenimiento->UmeId);
								$InsTallerPedidoDetalle1->AmdUtilidad = 0;
								$InsTallerPedidoDetalle1->AmdValorTotal = 0;
								$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;
								
								$InsTallerPedidoDetalle1->ProId = $DatFichaAccionMantenimiento->ProId;
								//$InsTallerPedidoDetalle1->ProCodigoOriginal = $DatFichaAccionMantenimiento->ProCodigoOriginal;
								//$InsTallerPedidoDetalle1->ProCodigoAltenativo = $DatFichaAccionMantenimiento->ProCodigoAltenativo;
								
								$InsTallerPedidoDetalle1->FaaId = $DatFichaAccionMantenimiento->FaaId;	
								$InsTallerPedidoDetalle1->FapId = $DatFichaAccionMantenimiento->FapId;	
															
								$InsTallerPedidoDetalle1->UmeId = $DatFichaAccionMantenimiento->UmeId;

								$ListaPrecioCosto = 0;
								$InsTallerPedidoDetalle1->AmdUtilidad = 0;
								$InsTallerPedidoDetalle1->AmdValorTotal = 0;
								$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;

								if(!empty($InsTallerPedidoDetalle1->ProId) and !empty($InsFichaIngreso->LtiId) and !empty($InsTallerPedidoDetalle1->UmeId)){
									$InsListaPrecio = new ClsListaPrecio();
									$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$InsTallerPedidoDetalle1->ProId,$InsFichaIngreso->LtiId,$InsTallerPedidoDetalle1->UmeId);
									$ArrListaPrecios = $ResListaPrecio['Datos'];

									foreach($ArrListaPrecios as $DatListaPrecio){
										
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
																
								//$InsTallerPedidoDetalle1->AmdCantidad = $DatFichaAccionMantenimiento->FapCantidad;
								$InsTallerPedidoDetalle1->AmdCantidad = (empty($DatFichaAccionMantenimiento->FaaCantidad)?0:$DatFichaAccionMantenimiento->FaaCantidad);

								$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad;
									
									$InsProducto = new ClsProducto();						
									$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
									$InsProducto->MtdObtenerProducto(false);
									
									$InsUnidadMedida = new ClsUnidadMedida();
									$InsUnidadMedida->UmeId = $InsTallerPedidoDetalle1->UmeId;
									$InsUnidadMedida->MtdObtenerUnidadMedida();
									
									//sdeb($InsTallerPedidoDetalle1->UmeId);
									
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
										$InsTallerPedidoDetalle1->AmdCantidadReal = 0;
									}
								
								$InsTallerPedidoDetalle1->AmdReingreso = 2;
								$InsTallerPedidoDetalle1->AmdCompraOrigen = "G";
								$InsTallerPedidoDetalle1->AmdValidarStock = $InsProducto->ProValidarStock;
								$InsTallerPedidoDetalle1->AmdEstado = 3;//ANTES ERA 3
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
									
							//	deb($InsTallerPedidoDetalle1->ProCodigoOriginal);
							
							$AlmacenId = "";
							
							switch($InsTallerPedido->VmaId){
								
								default:
								
									$InsTareaProducto = new ClsTareaProducto();
									$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsFichaIngreso->PmaId,$InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$InsFichaIngreso->FinMantenimientoKilometraje]['eq'],$DatFichaAccionMantenimiento->PmtId);
									$ArrTareaProductos = $ResTareaProducto['Datos'];
									
									if(!empty($ArrTareaProductos)){
										foreach($ArrTareaProductos as $DatTareaProducto){
											$AlmacenId = $DatTareaProducto->AlmId;
										}
									}
									
								break;
								
								case "VMA-10018":
								
									$InsTareaProducto = new ClsTareaProducto();
									$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsFichaIngreso->PmaId,$InsPlanMantenimiento->PmaIsuzuKilometrajesNuevo[$InsFichaIngreso->FinMantenimientoKilometraje]['eq'],$DatFichaAccionMantenimiento->PmtId);
									$ArrTareaProductos = $ResTareaProducto['Datos'];
									
									if(!empty($ArrTareaProductos)){
										foreach($ArrTareaProductos as $DatTareaProducto){
											$AlmacenId = $DatTareaProducto->AlmId;
										}
									}
									
								break;
								
							}
							
							if(!empty($AlmacenId)){
								$InsTallerPedidoDetalle1->AlmId = $AlmacenId;
							}
							
								
								//deb($ArrTareaProductos);
								
								$InsTallerPedidoDetalle1->InsMysql = NULL;
						
						
							//$StockReal = 0;
//							$VerificarStock = 2;
//							
//							$InsAlmacenProducto = new ClsAlmacenProducto();
//							$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle1->ProId,$InsTallerPedido->AlmId,date("Y"));
//							
//							if($StockReal < $InsTallerPedidoDetalle1->AmdCantidadReal){		
//								$VerificarStock = 1;
//							}

//							if($VerificarStock == 2){
								$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;
								$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;
							//}


							}

						}
					}
					
					$TallerPedidoId = $InsTallerPedido->MtdVerificarExisteTallerPedido("FccId",$InsTallerPedido->FccId);
					//s//deb($TallerPedidoId);
					if(empty($TallerPedidoId)){

						if($InsTallerPedido->MtdRegistrarTallerPedido()){
							$validar++;
							FncCargarTallerPedidoDatos($InsTallerPedido->AmoId);
						}else{
							break;	
						}
						
//						deb("bb");
					}else{
						
					//	deb("aa");
						$InsTallerPedido->AmoId = $TallerPedidoId;
						$InsTallerPedido->MtdObtenerTallerPedido();
						
						$validar++;
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
					

				$ArrTallerPedidos[] = $InsTallerPedido;			
			}
			
			
			if(count($InsFichaIngreso->FichaIngresoModalidad) == $validar){
				//ACTUALIZANDO A ALMACEN [Revisado Pedido]
				$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,5,false); //OJOO

			}else{
				foreach($ArrTallerPedidos as $DatTallerPedido){
					$InsTallerPedido->AmoId = $DatTallerPedido->AmoId;
					$InsTallerPedido->MtdEliminarTallerPedido($DatTallerPedido->AmoId);
				}
			}


		}
		
	}
	

}


function FncCargarTallerPedidoDatos($oTallerPedidoId){

	global $Identificador;
	global $InsTallerPedido;
	//global $InsFichaAccion;
	global $EmpresaMonedaId;
	//SIP/20
	
	$InsTallerPedido->AmoId = $oTallerPedidoId;
	$InsTallerPedido->MtdObtenerTallerPedido();

	unset($_SESSION['InsTallerPedidoDetalle'.$InsTallerPedido->MinSigla.$Identificador]);
	unset($_SESSION['InsTallerPedidoMantenimiento'.$InsTallerPedido->MinSigla.$Identificador]);
	unset($_SESSION['InsTallerPedidoFoto'.$InsTallerPedido->MinSigla.$Identificador]);


	$_SESSION['InsTallerPedidoDetalle'.$InsTallerPedido->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsTallerPedidoMantenimiento'.$InsTallerPedido->MinSigla.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsTallerPedidoFoto'.$InsTallerPedido->MinSigla.$Identificador] = new ClsSesionObjeto();

	//////deb($InsTallerPedido);
	$InsFichaAccion = new ClsFichaAccion();
	
	$InsFichaAccion->FccId = $InsTallerPedido->FccId;
	$InsFichaAccion->MtdObtenerFichaAccion();

		//////deb($InsFichaAccion->MinId);
	if($InsFichaAccion->MinId == "MIN-10001"){

		if(!empty($InsFichaAccion->FichaAccionMantenimiento)){
			foreach($InsFichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
		
				$MantenimientoExiste = false;
		
				if(!empty($InsTallerPedido->TallerPedidoDetalle)){
					foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){	
		
						if($DatFichaAccionMantenimiento->FaaId == $DatTallerPedidoDetalle->FaaId){
							//echo "sii";	
							
							//if(($DatTallerPedidoDetalle->AmdTiempoModificacion) == "00/00/0000 00:00:00"){
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
//	Parametro34 = AmdCierre
							
							$_SESSION['InsTallerPedidoMantenimiento'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
							$DatTallerPedidoDetalle->AmdId,
							$DatTallerPedidoDetalle->ProId,
							$DatTallerPedidoDetalle->ProNombre,
							$DatTallerPedidoDetalle->AmdPrecioVenta,
							$DatTallerPedidoDetalle->AmdCantidad,
							$DatTallerPedidoDetalle->AmdImporte,
							FncCambiaFechaANormal($DatTallerPedidoDetalle->AmdTiempoCreacion),
							FncCambiaFechaANormal($DatTallerPedidoDetalle->AmdTiempoModificacion),
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
							$DatTallerPedidoDetalle->AmdCierre,
							$DatTallerPedidoDetalle->AmdCompraOrigen
							);
		
							$MantenimientoExiste = true;
							break;
							
						}
		
					}					
				}
				
				//deb($MantenimientoExiste );
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
	
	
	
		  if(!empty($InsTallerPedido->TallerPedidoDetalle)){
			  foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){	
				  
//					if(!empty($DatTallerPedidoDetalle->FapId) and empty($DatTallerPedidoDetalle->FaaId)){
					if(empty($DatTallerPedidoDetalle->FaaId)){
						
		
						if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
	
							$DatTallerPedidoDetalle->AmdCosto = round($DatTallerPedidoDetalle->AmdCosto / $InsTallerPedido->AmoTipoCambio,2);
							$DatTallerPedidoDetalle->AmdPrecioVenta = round($DatTallerPedidoDetalle->AmdPrecioVenta / $InsTallerPedido->AmoTipoCambio,2);
							$DatTallerPedidoDetalle->AmdImporte = round($DatTallerPedidoDetalle->AmdImporte / $InsTallerPedido->AmoTipoCambio,2);
			
						}
				
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
						//	Parametro34 = AmdCierre
						//	Parametro35 = AmdCompraOrigen
						
							$_SESSION['InsTallerPedidoDetalle'.$InsFichaAccion->MinSigla.$Identificador]->MtdAgregarSesionObjeto(1,
							$DatTallerPedidoDetalle->AmdId,
							$DatTallerPedidoDetalle->ProId,
							$DatTallerPedidoDetalle->ProNombre,
							$DatTallerPedidoDetalle->AmdPrecioVenta,
							$DatTallerPedidoDetalle->AmdCantidad,
							$DatTallerPedidoDetalle->AmdImporte,
							FncCambiaFechaANormal($DatTallerPedidoDetalle->AmdTiempoCreacion),
							FncCambiaFechaANormal($DatTallerPedidoDetalle->AmdTiempoModificacion),
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
							$DatTallerPedidoDetalle->AmdCierre,
							$DatTallerPedidoDetalle->AmdCompraOrigen
							
							);
				
					
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

