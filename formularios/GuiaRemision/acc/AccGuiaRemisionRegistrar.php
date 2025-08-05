<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

//deb($_POST);
	$Resultado = '';

	$InsGuiaRemision->GreId = $_POST['CmpId'];
	$InsGuiaRemision->GrtId = $_POST['CmpTalonario'];
	$InsGuiaRemision->UsuId = $_SESSION['SesionId'];
	$InsGuiaRemision->SucId = $_SESSION['SesionSucursal'];
	
	$InsGuiaRemision->CliId = $_POST['CmpClienteId'];
	$InsGuiaRemision->PrvId = $_POST['CmpProveedorId'];

	$InsGuiaRemision->TptId = $_POST['CmpTrasladoAlmacenId'];
	$InsGuiaRemision->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	
	$InsGuiaRemision->TptId = $_POST['CmpTrasladoProductoId'];
	$InsGuiaRemision->TveId = $_POST['CmpTrasladoVehiculoId'];

	$InsGuiaRemision->GreDestinatarioNombre = $_POST['CmpDestinatarioNombre'];
	$InsGuiaRemision->GreDestinatarioNumeroDocumento1 = $_POST['CmpDestinatarioNumeroDocumento1'];
	$InsGuiaRemision->GreDestinatarioNumeroDocumento2 = $_POST['CmpDestinatarioNumeroDocumento2'];

	$InsGuiaRemision->GreFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	$InsGuiaRemision->GreFechaInicioTraslado = FncCambiaFechaAMysql($_POST['CmpFechaInicioTraslado']);
	
	$InsGuiaRemision->GrePuntoPartida = $_POST['CmpPuntoPartida'];
	$InsGuiaRemision->GrePuntoPartidaDepartamento = $_POST['CmpPuntoPartidaDepartamento'];
	$InsGuiaRemision->GrePuntoPartidaProvincia = $_POST['CmpPuntoPartidaProvincia'];
	$InsGuiaRemision->GrePuntoPartidaDistrito = $_POST['CmpPuntoPartidaDistrito'];
	$InsGuiaRemision->GrePuntoPartidaCodigoUbigeo = $_POST['CmpPuntoPartidaCodigoUbigeo'];
	
	$InsGuiaRemision->GrePuntoLlegada = $_POST['CmpPuntoLlegada'];
	$InsGuiaRemision->GrePuntoLlegadaDepartamento = $_POST['CmpPuntoLlegadaDepartamento'];
	$InsGuiaRemision->GrePuntoLlegadaProvincia = $_POST['CmpPuntoLlegadaProvincia'];
	$InsGuiaRemision->GrePuntoLlegadaDistrito = $_POST['CmpPuntoLlegadaDistrito'];
	$InsGuiaRemision->GrePuntoLlegadaCodigoUbigeo = $_POST['CmpPuntoLlegadaCodigoUbigeo'];

	$InsGuiaRemision->GreNumeroRegistro = $_POST['CmpNumeroRegistro'];
	$InsGuiaRemision->GreNumeroConstanciaInscripcion = $_POST['CmpNumeroConstanciaInscripcion'];
	$InsGuiaRemision->GreChofer = $_POST['CmpChofer'];
	$InsGuiaRemision->GreChoferNumeroDocumento = $_POST['CmpChoferNumeroDocumento'];	
	
	$InsGuiaRemision->GreNumeroLicenciaConducir = $_POST['CmpNumeroLicenciaConducir'];
	$InsGuiaRemision->GreMarca = $_POST['CmpMarca'];
	$InsGuiaRemision->GrePlaca = $_POST['CmpPlaca'];
	$InsGuiaRemision->GreMotivoTraslado = $_POST['CmpMotivoTraslado'];
	$InsGuiaRemision->GreMotivoTrasladoOtro = $_POST['CmpMotivoTrasladoOtro'];
	$InsGuiaRemision->GreMotivoTrasladoCodigo = $_POST['CmpMotivoTrasladoCodigo'];
	
	
	
	$InsGuiaRemision->GreComprobantePagoNumero = $_POST['CmpComprobantePagoNumero'];
	$InsGuiaRemision->GreObservacion = $_POST['CmpObservacion'];
	$InsGuiaRemision->GreObservacionImpresa = $_POST['CmpObservacionImpresa'];

	$InsGuiaRemision->GrePesoTotal = eregi_replace(",","",(empty($_POST['CmpPesoTotal'])?0:$_POST['CmpPesoTotal']));
	$InsGuiaRemision->GreTotalPaquetes = eregi_replace(",","",(empty($_POST['CmpTotalPaquetes'])?0:$_POST['CmpTotalPaquetes']));
	
	$InsGuiaRemision->GreEstado = $_POST['CmpEstado'];
	$InsGuiaRemision->GreCierre = 1;
	$InsGuiaRemision->GreTiempoCreacion = date("Y-m-d H:i:s");	
	$InsGuiaRemision->GreTiempoModificacion = date("Y-m-d H:i:s");
	$InsGuiaRemision->GreEliminado = 1;
	
	$InsGuiaRemision->CliNombre = $_POST['CmpClienteNombre'];
	$InsGuiaRemision->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	
	$InsGuiaRemision->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsGuiaRemision->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	
	$InsGuiaRemision->GuiaRemisionDetalle = array();	
	$InsGuiaRemision->GuiaRemisionAlmacenMovimiento = array();	

	///*
//	01 venta
//	14 venta sujeta a confirmacion del comprador
//	02 compra
//	04 traslado entre establecimientos de la misma empresa
//	18 traslado emisor itinerante cp
//	08 importacion
//	09 exportacion
//	19 traslado a zona primaria
//	13 otros
//	*/
//	switch($InsGuiaRemision->GreMotivoTraslado){
//		
//		case 1://Venta
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "01";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "VENTA";
//		break;
//		
//		case 2://Venta sujeto a confirmar
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "14";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "VENTA SUJETA A CONFIRMACION DEL COMPRADOR";
//		break;
//		
//		case 3://Compra
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "02";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "COMPRA";
//		break;
//		
//		case 4://Consignacion
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "13";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "OTROS";
//		break;
//		
//		case 5://Devolucion
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "13";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "OTROS";
//		break;
//		
//		case 6://Entre establecimientos
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "04";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "TRASLADO ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA";
//		break;
//		
//		case 7://Para Transformación
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "13";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "OTROS";
//		break;
//		
//		case 8://Recojo de Bienes transformados
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "13";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "OTROS";
//		break;
//		
//		case 9://Emisor Itinerante
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "18";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "TRASLADO EMISOR ITINERANTE CP";
//		break;
//		
//		case 10://Emisor Itinerante
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "19";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "TRASLADO A ZONA PRIMARIA";
//		break;
//		
//		case 11://Importación
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "08";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "IMPORTACION";
//		break;
//		
//		case 12://Exportación
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "09";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "EXPORTACION";
//		break;
//		
//		case 13:// Venta con Entrega a Terceros
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "13";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "OTROS";
//		break;
//		
//		case 14://Otros
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "13";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "OTROS";
//		break;
//		
//		default:
//			$InsGuiaRemision->GreMotivoTrasladoCodigo = "13";
//			$InsGuiaRemision->GreMotivoTrasladoDescripcion = "OTROS";
//		break;
//		
//	}
		
	if(empty($InsGuiaRemision->CliId)){
		$Guardar = false;
		$Resultado.='#ERR_GRE_123';
	}	
	
	
/*
SesionObjeto-GuiaRemisionDetalleListado
Parametro1 = GrdId
Parametro2 = GrdCodigo
Parametro3 = GrdDescripcion
Parametro4 = GrdCantidad
Parametro5 = GrdUnidadMedida
Parametro6 = GrdPesoTotal
Parametro7 = GrdTiempoCreacion
Parametro8 = GrdTiempoModificacion
Parametro9 = GrdPesoNeto
*/

$ResGuiaRemisionDetalle = $_SESSION['InsGuiaRemisionDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResGuiaRemisionDetalle['Datos'])){
		foreach($ResGuiaRemisionDetalle['Datos'] as $DatSesionObjeto){
				
			$InsGuiaRemisionDetalle1 = new ClsGuiaRemisionDetalle();
			$InsGuiaRemisionDetalle1->GrdId = $DatSesionObjeto->Parametro1;	
			
			$InsGuiaRemisionDetalle1->GrdCodigo = $DatSesionObjeto->Parametro2;
			$InsGuiaRemisionDetalle1->GrdDescripcion = $DatSesionObjeto->Parametro3;
			$InsGuiaRemisionDetalle1->GrdCantidad = $DatSesionObjeto->Parametro4;
			$InsGuiaRemisionDetalle1->GrdUnidadMedida = $DatSesionObjeto->Parametro5;
			$InsGuiaRemisionDetalle1->GrdPesoNeto = $DatSesionObjeto->Parametro9;
			$InsGuiaRemisionDetalle1->GrdPesoTotal = $DatSesionObjeto->Parametro6;

			$InsGuiaRemisionDetalle1->GrdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsGuiaRemisionDetalle1->GrdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsGuiaRemisionDetalle1->GrdEliminado = $DatSesionObjeto->Eliminado;				
			$InsGuiaRemisionDetalle1->InsMysql = NULL;
			
			$InsGuiaRemision->GuiaRemisionDetalle[] = $InsGuiaRemisionDetalle1;	
					
		}
	}
	
	

//SesionObjeto-GuiaRemisionAlmacenMovimiento
	//Parametro1 = GamId
	//Parametro2 = 
	//Parametro3 = 
	//Parametro4 = AmoId
	//Parametro5 = GamEstado
	//Parametro6 = GamTiempoCreacion
	//Parametro7 = GamTiempoModificacion
	//Parametro8 = VmvId
	//Parametro9 = 
	//Parametro10 = 
	//Parametro11 = AmoSubTipo
	//Parametro12 = VmvSubTipo

$ResGuiaRemisionAlmacenMovimiento = $_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResGuiaRemisionAlmacenMovimiento['Datos'])){
		foreach($ResGuiaRemisionAlmacenMovimiento['Datos'] as $DatSesionObjeto){
				
			$InsGuiaRemisionAlmacenMovimiento1 = new ClsGuiaRemisionAlmacenMovimiento();
			$InsGuiaRemisionAlmacenMovimiento1->GamId = $DatSesionObjeto->Parametro1;
			$InsGuiaRemisionAlmacenMovimiento1->GreId = NULL;
			$InsGuiaRemisionAlmacenMovimiento1->GrtId = NULL;
			
			$InsGuiaRemisionAlmacenMovimiento1->AmoId = $DatSesionObjeto->Parametro4;
			$InsGuiaRemisionAlmacenMovimiento1->VmvId = $DatSesionObjeto->Parametro8;
			
			$InsGuiaRemisionAlmacenMovimiento1->GamEliminado = $DatSesionObjeto->Eliminado;				
			$InsGuiaRemisionAlmacenMovimiento1->InsMysql = NULL;
			
			$InsGuiaRemision->GuiaRemisionAlmacenMovimiento[] = $InsGuiaRemisionAlmacenMovimiento1;	
					
		}
	}
	
	if($InsGuiaRemision->MtdRegistrarGuiaRemision()){	
		$Registro = true;		
		$Resultado.='#SAS_GRE_101';
	} else{
		$Resultado.='#ERR_GRE_101';
	}
	
	$InsGuiaRemision->GreFechaEmision = FncCambiaFechaANormal($InsGuiaRemision->GreFechaEmision);
	$InsGuiaRemision->GreFechaInicioTraslado = FncCambiaFechaANormal($InsGuiaRemision->GreFechaInicioTraslado);
	
	
	

}else{

	unset($_SESSION['InsGuiaRemisionDetalle'.$Identificador]);

	$_SESSION['InsGuiaRemisionDetalle'.$Identificador] = new ClsSesionObjeto();

	$InsGuiaRemision->GreFechaEmision = date("d/m/Y");	
	$InsGuiaRemision->GreFechaInicioTraslado = date("d/m/Y");	
	$InsGuiaRemision->GrePuntoPartida = $EmpresaDireccion;
	$InsGuiaRemision->GrePuntoPartidaDepartamento = $EmpresaDepartamento;
	$InsGuiaRemision->GrePuntoPartidaProvincia = $EmpresaProvincia;
	$InsGuiaRemision->GrePuntoPartidaDistrito = $EmpresaDistrito;
	$InsGuiaRemision->GrePuntoPartidaCodigoUbigeo = $EmpresaCodigoUbigeo;
	$InsGuiaRemision->SucId = $_SESSION['SesionSucursal'];
	
	$InsGuiaRemision->GreMotivoTraslado = 1;
	$InsGuiaRemision->GreEstado = 5;


	switch($GET_ori){
		
		case "VehiculoMovimientoSalida":
		
			$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();
			$InsVehiculoMovimientoSalida->VmvId = $GET_VmvId;
			$InsVehiculoMovimientoSalida->MtdObtenerVehiculoMovimientoSalida();
			
			
			$ClienteId = '';
			$ClienteNombreCompleto =  '';
			
			$ClienteNombre = '';
			$ClienteApellidoPaterno = '';
			$ClienteApellidoMaterno = '';
			
			$ClienteNumeroDocumento = '';
			$TipoDocumentoId = '';
					
			$InsCliente = new ClsCliente();	
			$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"PRINCIPAL");
			$ArrClientes = $ResCliente['Datos'];
			
			if(!empty($ArrClientes)){
				foreach($ArrClientes as $DatCliente){
				
					$ClienteId = $DatCliente->CliId;
					$ClienteNombreCompleto = $DatCliente->CliNombreCompleto;
					
					$ClienteNombre = $DatCliente->CliNombre;
					$ClienteApellidoPaterno = $DatCliente->CliApellidoPaterno;
					$ClienteApellidoMaterno = $DatCliente->CliApellidoMaterno;
					
					$ClienteNumeroDocumento = $DatCliente->CliNumeroDocumento;
					$TipoDocumentoId = $DatCliente->TdoId;
		
				}
			}
			
			$InsGuiaRemision->CliId = $ClienteId;
			$InsGuiaRemision->CliNumeroDocumento = $ClienteNumeroDocumento;
			$InsGuiaRemision->CliNombre = $ClienteNombre;
			$InsGuiaRemision->CliApellidoPaterno = $ClienteApellidoPaterno;
			$InsGuiaRemision->CliApellidoMaterno = $ClienteApellidoMaterno;
			$InsGuiaRemision->TdoId = $TipoDocumentoId;
			$InsGuiaRemision->CliNombreCompleto = $ClienteNombreCompleto;
			
			//
//			$InsGuiaRemision->CliId = NULL;
//			$InsGuiaRemision->CliNombre = NULL;
//			$InsGuiaRemision->CliApellidoPaterno = NULL;
//			$InsGuiaRemision->CliApellidoMaterno = NULL;
			
			$InsGuiaRemision->GreDestinatarioNombre = $InsVehiculoMovimientoSalida->PrvNombre." ".$InsVehiculoMovimientoSalida->PrvApellidoPaterno." ".$InsVehiculoMovimientoSalida->PrvApellidoMaterno;
			
			$InsGuiaRemision->GreDestinatarioNumeroDocumento1 = $InsVehiculoMovimientoSalida->PrvNumeroDocumento;			

			$InsGuiaRemision->GrePuntoLlegada = primera_mayuscula($InsVehiculoMovimientoSalida->SucDireccionDestino)." ".primera_mayuscula($InsVehiculoMovimientoSalida->SucDepartamentoDestino)." ".primera_mayuscula($InsVehiculoMovimientoSalida->SucProvinciaDestino)." ".primera_mayuscula($InsVehiculoMovimientoSalida->SucDistritoDestino);
			$InsGuiaRemision->GrePuntoLlegadaCodigoUbigeo = $InsVehiculoMovimientoSalida->SucCodigoUbigeoDestino;
			
			$InsGuiaRemision->GrePuntoLlegadaDepartamento = primera_mayuscula($InsVehiculoMovimientoSalida->SucDepartamentoDestino);
			$InsGuiaRemision->GrePuntoLlegadaProvincia = primera_mayuscula($InsVehiculoMovimientoSalida->SucProvinciaDestino);
			$InsGuiaRemision->GrePuntoLlegadaDistrito = primera_mayuscula($InsVehiculoMovimientoSalida->SucDistritoDestino);		
		
			
						
			$InsGuiaRemision->GrePuntoPartida = primera_mayuscula($InsVehiculoMovimientoSalida->SucDireccion)." ".primera_mayuscula($InsVehiculoMovimientoSalida->SucDepartamento)." ".primera_mayuscula($InsVehiculoMovimientoSalida->SucProvincia)." ".primera_mayuscula($InsVehiculoMovimientoSalida->SucDistrito);
			$InsGuiaRemision->GrePuntoPartidaCodigoUbigeo = $InsVehiculoMovimientoSalida->SucCodigoUbigeo;
			
			$InsGuiaRemision->GrePuntoPartidaDepartamento = primera_mayuscula($InsVehiculoMovimientoSalida->SucDepartamento);
			$InsGuiaRemision->GrePuntoPartidaProvincia = primera_mayuscula($InsVehiculoMovimientoSalida->SucProvincia);
			$InsGuiaRemision->GrePuntoPartidaDistrito = primera_mayuscula($InsVehiculoMovimientoSalida->SucDistrito);
				
			$InsGuiaRemision->GreObservacion = $InsVehiculoMovimientoSalida->VmvObservacion.chr(13).date("d/m/Y H:i:s")." - Guia de Remision Generada de Mov. Veh.:".$InsVehiculoMovimientoSalida->VmvId;
			
			$InsGuiaRemision->GreObservacionImpresa = NULL;
			
			$InsGuiaRemision->GreMotivoTraslado = 1;
			$InsGuiaRemision->GreEstado = 5;
			
			if(!empty($InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle)){
				foreach($InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle as $DatVehiculoMovimientoSalidaDetalle){



					$_SESSION['InsGuiaRemisionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatVehiculoMovimientoSalidaDetalle->EinVIN,
					$DatVehiculoMovimientoSalidaDetalle->VmaNombre." ".$DatVehiculoMovimientoSalidaDetalle->VmoNombre." ".$DatVehiculoMovimientoSalidaDetalle->VveNombre." ".$DatVehiculoMovimientoSalidaDetalle->EinColor,
					$DatVehiculoMovimientoSalidaDetalle->VmdCantidad,
					$DatVehiculoMovimientoSalidaDetalle->UmeNombre,
					0.00,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					0.00);

				}		
			}
			

	//SesionObjeto-GuiaRemisionAlmacenMovimiento
	//Parametro1 = GamId
	//Parametro2 = 
	//Parametro3 = 
	//Parametro4 = AmoId
	//Parametro5 = GamEstado
	//Parametro6 = GamTiempoCreacion
	//Parametro7 = GamTiempoModificacion
	//Parametro8 = VmvId
	//Parametro9 = VmvFecha
	//Parametro10 = AmoFecha
	//Parametro11 = AmoSubTipo
	//Parametro12 = VmvSubTipo
	
			$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			NULL,
			NULL,
			NULL,
			3,
			date("d/m/Y h:i:s"),
			date("d/m/Y h:i:s"),
			$InsVehiculoMovimientoSalida->VmvId,
			$InsVehiculoMovimientoSalida->VmvFecha,
			NULL,
			NULL,
			$InsVehiculoMovimientoSalida->VmvSubTipo);
		
		break;
		
		
		
		case "FichaAccion":
		
			$InsFichaAccion = new ClsFichaAccion();
			$InsFichaAccion->FccId = $GET_FccId;
			$InsFichaAccion->MtdObtenerFichaAccion();
				
			$InsTptlerPedido = new ClsTptlerPedido();
			
			$ResTptlerPedido = $InsTptlerPedido->MtdObtenerTptlerPedidos(NULL,NULL,NULL,'AmoTiempoCreacion','DESC','',NULL,NULL,NULL,$InsFichaAccion->FccId,NULL,0,0,NULL,NULL,false,NULL);
			$ArrTptlerPedidos = $ResTptlerPedido['Datos'];
			

			$TptlerPedidoId = "";
			
			if(!empty($ArrTptlerPedidos)){		
				foreach($ArrTptlerPedidos as $DatTptlerPedido){
					
					if($DatTptlerPedido->AmoId == $GET_AmoId){
						$TptlerPedidoId = $DatTptlerPedido->AmoId;
					}
					
			
				}					
			}
			
			$InsTptlerPedido->AmoId = $TptlerPedidoId; 
			$InsTptlerPedido->MtdObtenerTptlerPedido();	
			
			//deb($InsFichaAccion->FinId);
			
			$InsFichaIngreso = new ClsFichaIngreso();
			$InsFichaIngreso->FinId = $InsFichaAccion->FinId;
			$InsFichaIngreso->MtdObtenerFichaIngreso();



			$InsGuiaRemision->CliId = $InsFichaIngreso->CliId;
			$InsGuiaRemision->CliNombre = $InsFichaIngreso->CliNombre;
			$InsGuiaRemision->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
			$InsGuiaRemision->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
			
			$InsGuiaRemision->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;			
//			$InsGuiaRemision->GrePuntoLlegada = $InsFichaIngreso->CliDireccion;
			$InsGuiaRemision->GrePuntoLlegada = $InsFichaIngreso->CliDireccion." ".$InsFichaIngreso->CliDistrito." ".$InsFichaIngreso->CliProvincia." ".$InsVentaConcretada->CliDepartamento;
						
			$InsGuiaRemision->GrePuntoPartida = $EmpresaDireccion;
			$InsGuiaRemision->GreObservacion = $InsFichaIngreso->FinObservacion.chr(13).date("d/m/Y H:i:s")." - Guia de Remision Generada de Ord. Trab.:".$InsFichaIngreso->FinId;
			
			$InsGuiaRemision->GreObservacionImpresa = $InsFichaIngreso->VmaNombre." ".$InsFichaIngreso->VmoNombre;
			
			if(!empty($InsFichaIngreso->EinPlaca)){
				$InsGuiaRemision->GreObservacionImpresa .= " / Placa: ".$InsFichaIngreso->EinPlaca;
			}
			
			if(!empty($InsFichaIngreso->EinVIN)){
				$InsGuiaRemision->GreObservacionImpresa .= " / VIN: ".$InsFichaIngreso->EinVIN;
			}
			
			$InsGuiaRemision->GreMotivoTraslado = 1;
			$InsGuiaRemision->GreEstado = 5;
									
			if(!empty($InsTptlerPedido->TptlerPedidoDetalle)){
				foreach($InsTptlerPedido->TptlerPedidoDetalle as $DatTptlerPedidoDetalle){

/*
SesionObjeto-GuiaRemisionDetalleListado
Parametro1 = GrdId
Parametro2 = GrdCodigo
Parametro3 = GrdDescripcion
Parametro4 = GrdCantidad
Parametro5 = GrdUnidadMedida
Parametro6 = GrdPesoTotal
Parametro7 = GrdTiempoCreacion
Parametro8 = GrdTiempoModificacion
Parametro9 = GrdPesoNeto
*/

					$_SESSION['InsGuiaRemisionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatTptlerPedidoDetalle->ProCodigoOriginal,
					$DatTptlerPedidoDetalle->ProNombre,
					$DatTptlerPedidoDetalle->AmdCantidad,
					$DatTptlerPedidoDetalle->UmeNombre,
					0.00,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					0.00);

				}		
			}
					
					
	//SesionObjeto-GuiaRemisionAlmacenMovimiento
	//Parametro1 = GamId
	//Parametro2 = AmoId
	//Parametro3 = 
	//Parametro4 = 
	//Parametro5 = GamEstado
	//Parametro6 = GamTiempoCreacion
	//Parametro7 = GamTiempoModificacion
	//Parametro8 = VmvId
	//Parametro9 = 
	//Parametro10 = 
	//Parametro11 = AmoSubTipo
	//Parametro12 = VmvSubTipo
					$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					NULL,
					NULL,
					$InsTptlerPedido->AmoId);
					
					
		break;
		
		//VentaConcretada
		case "VentaConcretada":
		
		
	//	$InsFactura = new ClsFactura();

			if(!empty($GET_VcoId)){

					$InsVentaConcretada = new ClsVentaConcretada();
					$InsVentaConcretada->VcoId = $GET_VcoId;	
					$InsVentaConcretada->MtdObtenerVentaConcretada();
					
					$InsGuiaRemision->CliId = $InsVentaConcretada->CliId;
					$InsGuiaRemision->CliNombre = $InsVentaConcretada->CliNombre." ".$InsVentaConcretada->CliApellidoPaterno." ".$InsVentaConcretada->CliApellidoMaterno;
					$InsGuiaRemision->CliNumeroDocumento = $InsVentaConcretada->CliNumeroDocumento;			
					$InsGuiaRemision->GrePuntoLlegada = $InsVentaConcretada->CliDireccion." ".$InsVentaConcretada->CliDistrito." ".$InsVentaConcretada->CliProvincia." ".$InsVentaConcretada->CliDepartamento;
					$InsGuiaRemision->GrePuntoPartida = $EmpresaDireccion;
					$InsGuiaRemision->GreObservacion = $InsVentaConcretada->VcoObservacion.chr(13).date("d/m/Y H:i:s")." - Guia de Remision Generada de Ord. Ven.:".$InsVentaDirecta->VdiId." / Ven. Con.: ".$InsVentaConcretada->VcoId;
					
					
					$InsGuiaRemision->GreObservacionImpresa = "Ord. Ven.:".$InsVentaConcretada->VdiId." / Ven. Con.: ".$InsVentaConcretada->VcoId." / Ref.".$InsVentaConcretada->VdiOrdenCompraNumero;
								
					$InsGuiaRemision->GreMotivoTraslado = 1;
					$InsGuiaRemision->GreEstado = 5;
											
					if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
						foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){
		
		/*
		SesionObjeto-GuiaRemisionDetalleListado
		Parametro1 = GrdId
		Parametro2 = GrdCodigo
		Parametro3 = GrdDescripcion
		Parametro4 = GrdCantidad
		Parametro5 = GrdUnidadMedida
		Parametro6 = GrdPesoTotal
		Parametro7 = GrdTiempoCreacion
		Parametro8 = GrdTiempoModificacion
		Parametro9 = GrdPesoNeto
		*/
		
							$_SESSION['InsGuiaRemisionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatVentaConcretadaDetalle->ProCodigoOriginal,
							$DatVentaConcretadaDetalle->ProNombre,
							$DatVentaConcretadaDetalle->VcdCantidad,
							$DatVentaConcretadaDetalle->UmeNombre,
							0.00,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							0.00);
		
						}		
					}
							
	//SesionObjeto-GuiaRemisionAlmacenMovimiento
	//Parametro1 = GamId
	//Parametro2 = AmoId
	//Parametro3 = 
	//Parametro4 = 
	//Parametro5 = GamEstado
	//Parametro6 = GamTiempoCreacion
	//Parametro7 = GamTiempoModificacion
	//Parametro8 = VmvId
	//Parametro9 = 
	//Parametro10 = 
	//Parametro11 = AmoSubTipo
	//Parametro12 = VmvSubTipo
							$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							NULL,
							NULL,
							$InsVentaConcretada->VcoId);
							
							
				
		
		
			}else{
			
				  $ArrVentaConcretadas = array();
				  $ArrVentaConcretadas = explode("#",$_POST['cmp_seleccionados']);
				  $ArrVentaConcretadas = array_filter($ArrVentaConcretadas);
				  
				  foreach($ArrVentaConcretadas as $DatVentaConcretada){
					  
					  
					  $InsVentaConcretada = new ClsVentaConcretada();
					$InsVentaConcretada->VcoId = $DatVentaConcretada;	
					$InsVentaConcretada->MtdObtenerVentaConcretada();
					
					$InsGuiaRemision->CliId = $InsVentaConcretada->CliId;
					$InsGuiaRemision->CliNombre = $InsVentaConcretada->CliNombre." ".$InsVentaConcretada->CliApellidoPaterno." ".$InsVentaConcretada->CliApellidoMaterno;
					$InsGuiaRemision->CliNumeroDocumento = $InsVentaConcretada->CliNumeroDocumento;			
					$InsGuiaRemision->GrePuntoLlegada = $InsVentaConcretada->CliDireccion." ".$InsVentaConcretada->CliDistrito." ".$InsVentaConcretada->CliProvincia." ".$InsVentaConcretada->CliDepartamento;
					$InsGuiaRemision->GrePuntoPartida = $EmpresaDireccion;
					$InsGuiaRemision->GreObservacion = $InsVentaConcretada->VcoObservacion.chr(13).date("d/m/Y H:i:s")." - Guia de Remision Generada de Ord. Ven.:".$InsVentaDirecta->VdiId." / Ven. Con.: ".$InsVentaConcretada->VcoId;
					
					
					$InsGuiaRemision->GreObservacionImpresa = "Ord. Ven.:".$InsVentaConcretada->VdiId." / Ven. Con.: ".$InsVentaConcretada->VcoId." / Ref.".$InsVentaConcretada->VdiOrdenCompraNumero;
								
					$InsGuiaRemision->GreMotivoTraslado = 1;
					$InsGuiaRemision->GreEstado = 5;
											
					if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
						foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){
		
		/*
		SesionObjeto-GuiaRemisionDetalleListado
		Parametro1 = GrdId
		Parametro2 = GrdCodigo
		Parametro3 = GrdDescripcion
		Parametro4 = GrdCantidad
		Parametro5 = GrdUnidadMedida
		Parametro6 = GrdPesoTotal
		Parametro7 = GrdTiempoCreacion
		Parametro8 = GrdTiempoModificacion
		Parametro9 = GrdPesoNeto
		*/
		
							$_SESSION['InsGuiaRemisionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							$DatVentaConcretadaDetalle->ProCodigoOriginal,
							$DatVentaConcretadaDetalle->ProNombre,
							$DatVentaConcretadaDetalle->VcdCantidad,
							$DatVentaConcretadaDetalle->UmeNombre,
							0.00,
							date("d/m/Y H:i:s"),
							date("d/m/Y H:i:s"),
							0.00);
		
						}		
					}
							
//SesionObjeto-GuiaRemisionAlmacenMovimiento
	//Parametro1 = GamId
	//Parametro2 = AmoId
	//Parametro3 = 
	//Parametro4 = 
	//Parametro5 = GamEstado
	//Parametro6 = GamTiempoCreacion
	//Parametro7 = GamTiempoModificacion
	//Parametro8 = VmvId
	//Parametro9 = 
	//Parametro10 = 
	//Parametro11 = AmoSubTipo
	//Parametro12 = VmvSubTipo
							$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
							NULL,
							NULL,
							NULL,
							$InsVentaConcretada->VcoId);
			  
			  
				  }

			}
	


		break;
		
		case "OrdenVentaVehiculo":
		
		
			$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();

			if(!empty($GET_ori)){
						
				$InsOrdenVentaVehiculo->OvvId = $GET_OvvId;	
				$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();	
				
				//deb($InsOrdenVentaVehiculo->OvvId);
				$InsGuiaRemision->OvvId = $InsOrdenVentaVehiculo->OvvId;
				$InsGuiaRemision->CliId = $InsOrdenVentaVehiculo->CliId;
				$InsGuiaRemision->CliNombre = $InsOrdenVentaVehiculo->CliNombre;
				$InsGuiaRemision->CliApellidoPaterno = $InsOrdenVentaVehiculo->CliApellidoPaterno;
				$InsGuiaRemision->CliApellidoMaterno = $InsOrdenVentaVehiculo->CliApellidoMaterno;
				$InsGuiaRemision->CliNumeroDocumento = $InsOrdenVentaVehiculo->CliNumeroDocumento;	

				$InsGuiaRemision->GrePuntoLlegada = $InsOrdenVentaVehiculo->CliDireccion." ".$InsOrdenVentaVehiculo->CliDistrito." ".$InsOrdenVentaVehiculo->CliProvincia." ".$InsOrdenVentaVehiculo->CliDepartamento;
			
			
				$InsGuiaRemision->GrePuntoPartida = $EmpresaDireccion;
				$InsGuiaRemision->GreObservacion = $InsOrdenVentaVehiculo->OvvObservacion.chr(13).date("d/m/Y H:i:s")." - Guia de Remision Generada de Ord. Ven. Veh.:".$InsOrdenVentaVehiculo->OvvId;
			
			
				$InsGuiaRemision->GreMotivoTraslado = 1;
				$InsGuiaRemision->GreEstado = 5;
			
					/*
					SesionObjeto-GuiaRemisionDetalleListado
					Parametro1 = Id
					Parametro2 = Codigo
					Parametro3 = Descripcion
					Parametro4 = Cantidad
					Parametro5 = UnidadMedida
					Parametro6 = PesoTotal
					Parametro7 = TiempoCreacion
					Parametro8 = TiempoModificacion
					Parametro9 = VdeId
					*/
					$_SESSION['InsGuiaRemisionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					NULL,
					$InsOrdenVentaVehiculo->VmaNombre." ".$InsOrdenVentaVehiculo->VmoNombre." ".$InsOrdenVentaVehiculo->VveNombre,
					1,
					"UNIDAD",
					0.00,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					NULL,
					NULL);

			}
			
			
			
		break;
		
		
		case "Factura":
		
			$InsFactura = new ClsFactura();

			if(!empty($GET_ori) and !empty($POST_ta)){
						
				$InsFactura->FacId = $GET_ori;	
				$InsFactura->FtaId = $POST_ta;	
				
				$InsFactura->MtdObtenerFactura();	
				
				$InsGuiaRemision->GreObservacion = $InsFactura->FacObservacion;
				
				$InsGuiaRemision->DesId = $InsFactura->CliId;		
				$InsGuiaRemision->DesNombre = $InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno;
				$InsGuiaRemision->TdoId = "TDO-10000";
				$InsGuiaRemision->DesNumeroDocumento = $InsFactura->CliNumeroDocumento;
				$InsGuiaRemision->DesDireccion = $InsFactura->CliDireccion;
				$InsGuiaRemision->DesTelefono = $InsFactura->CliTelefono;
				
				$InsGuiaRemision->DesEmail = $InsFactura->CliEmail;
				$InsGuiaRemision->DesCelular = $InsFactura->CliCelular;
				$InsGuiaRemision->DesFax = $InsFactura->CliFax;
				
				$InsGuiaRemision->DesTipo = 1;
				
				$InsGuiaRemision->GrePuntoLlegada = $InsFactura->CliDireccion;
				
				$InsGuiaRemision->GreEstado = 5;
				
				if(is_array($InsFactura->FacturaDetalle)){
				
					foreach($InsFactura->FacturaDetalle as $DatFacturaDetalle){
				
					/*
					SesionObjeto-GuiaRemisionDetalleListado
					Parametro1 = Id
					Parametro2 = Codigo
					Parametro3 = Descripcion
					Parametro4 = Cantidad
					Parametro5 = UnidadMedida
					Parametro6 = PesoTotal
					Parametro7 = TiempoCreacion
					Parametro8 = TiempoModificacion
					Parametro9 = VdeId
					*/
				
					$_SESSION['InsGuiaRemisionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					NULL,
					$DatFacturaDetalle->FdeDescripcion,
					$DatFacturaDetalle->FdeCantidad,
					NULL,
					0.00,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					NULL,
					NULL);
									
					}		
				}


				


			}else{
			

				  $ArrFacturas = array();
				  $Factura = array();
				  
				  $ArrFacturas = explode("#",$_POST['cmp_seleccionados']);
			  
				  $ArrFacturas = array_filter($ArrFacturas);
				  
				  foreach($ArrFacturas as $DatFactura){
			  
					  $Factura = explode("%",$DatFactura);
					  
					  $InsFactura->FacId = $Factura[0];	
					  $InsFactura->FtaId = $Factura[1];	
					  
					  $InsFactura->MtdObtenerFactura();	
					  
					  $InsGuiaRemision->GreObservacion .= " ".$InsFactura->FacObservacion;
					  
					  $InsGuiaRemision->DesId = $InsFactura->CliId;		
					  //$InsGuiaRemision->DesNombre = $InsFactura->CliNombre;
					
					$InsGuiaRemision->DesNombre = $InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno;
					$InsGuiaRemision->TdoId = "TDO-10000";
					$InsGuiaRemision->DesNumeroDocumento = $InsFactura->CliNumeroDocumento;
					$InsGuiaRemision->DesDireccion = $InsFactura->CliDireccion;
					$InsGuiaRemision->DesTelefono = $InsFactura->CliTelefono;
					  
					$InsGuiaRemision->DesEmail = $InsFactura->CliEmail;
					$InsGuiaRemision->DesCelular = $InsFactura->CliCelular;
					$InsGuiaRemision->DesFax = $InsFactura->CliFax;
					  
					$InsGuiaRemision->DesTipo = 1;

					$InsGuiaRemision->GreEstado = 5;
									  
					  if(is_array($InsFactura->FacturaDetalle)){
						  foreach($InsFactura->FacturaDetalle as $DatFacturaDetalle){

							  /*
							  SesionObjeto-GuiaRemisionDetalleListado
							  Parametro1 = Id
							  Parametro2 = Codigo
							  Parametro3 = Descripcion
							  Parametro4 = Cantidad
							  Parametro5 = UnidadMedida
							  Parametro6 = PesoTotal
							  Parametro7 = TiempoCreacion
							  Parametro8 = TiempoModificacion
							  Parametro9 = VdeId
							  */

							  $_SESSION['InsGuiaRemisionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
							  NULL,
							  NULL,
							  $DatFacturaDetalle->FdeDescripcion,
							  $DatFacturaDetalle->FdeCantidad,
							  NULL,
							  0.00,
							  date("d/m/Y H:i:s"),
							  date("d/m/Y H:i:s"),
							  NULL,
							  NULL);
										  
						  }		

					  }
					  
					  
					 
				  }
			}
			
		break;
		
		
		//
//		case "TrasladoAlmacen":
//
//			$InsTrasladoAlmacen = new ClsTrasladoAlmacen();
//			$InsTrasladoAlmacen->TptId = $GET_TptId;	
//			$InsTrasladoAlmacen->MtdObtenerTrasladoAlmacen();
//
//			$InsCliente = new ClsCliente();
//			
//			
//			//MtdObtenerClientes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CliId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL)
//			$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"CYC");
//			$ArrClientes = $ResCliente['Datos'];
//			
//			if(!empty($ArrClientes)){
//				foreach($ArrClientes as $DatCliente){
//				
//					$InsGuiaRemision->CliId = $DatCliente->CliId;
//					$InsGuiaRemision->CliNombreCompleto = $DatCliente->CliNombreCompleto;
//					
//					$InsGuiaRemision->CliNombre = $DatCliente->CliNombre;
//					$InsGuiaRemision->CliApellidoPaterno = $DatCliente->CliApellidoPaterno;
//					$InsGuiaRemision->CliApellidoMaterno = $DatCliente->CliApellidoMaterno;
//					
//					$InsGuiaRemision->CliNumeroDocumento = $DatCliente->CliNumeroDocumento;
//					$InsGuiaRemision->TdoId = $DatCliente->TdoId;
//		
//				}
//			}
//			
//			$InsGuiaRemision->TptId = $InsTrasladoAlmacen->TptId;
//			
//			$InsGuiaRemision->GrePuntoLlegada = $InsTrasladoAlmacen->AlmDireccionDestino." ".$InsTrasladoAlmacen->AlmDistritoDestino." ".$InsTrasladoAlmacen->AlmProvinciaDestino." ".$InsTrasladoAlmacen->AlmDepartamentoDestino;
//			$InsGuiaRemision->GrePuntoPartida = $InsTrasladoAlmacen->AlmDireccion." ".$InsTrasladoAlmacen->AlmDistrito." ".$InsTrasladoAlmacen->AlmProvincia." ".$InsTrasladoAlmacen->AlmDepartamento;
//			$InsGuiaRemision->GreObservacion = $InsAlmacenMovimientoSalida->AmoObservacion.chr(13).date("d/m/Y H:i:s")." - Guia de Remision Generada de Traslado.:".$InsTrasladoAlmacen->TptId;
//			
//			$InsGuiaRemision->GreObservacionImpresa = "";
//			
//			$InsGuiaRemision->GreMotivoTraslado = 9;
//			$InsGuiaRemision->GreEstado = 5;
//									
//			if(!empty($InsTrasladoAlmacen->TrasladoAlmacenDetalle)){
//				foreach($InsTrasladoAlmacen->TrasladoAlmacenDetalle as $DatTrasladoAlmacenDetalle){
//
///*
//SesionObjeto-GuiaRemisionDetalleListado
//Parametro1 = GrdId
//Parametro2 = GrdCodigo
//Parametro3 = GrdDescripcion
//Parametro4 = GrdCantidad
//Parametro5 = GrdUnidadMedida
//Parametro6 = GrdPesoTotal
//Parametro7 = GrdTiempoCreacion
//Parametro8 = GrdTiempoModificacion
//Parametro9 = GrdPesoNeto
//*/
//
//					$_SESSION['InsGuiaRemisionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//					NULL,
//					$DatTrasladoAlmacenDetalle->ProCodigoOriginal,
//					$DatTrasladoAlmacenDetalle->ProNombre,
//					$DatTrasladoAlmacenDetalle->TadCantidad,
//					$DatTrasladoAlmacenDetalle->UmeNombre,
//					0.00,
//					date("d/m/Y H:i:s"),
//					date("d/m/Y H:i:s"),
//					0.00);
//
//				}		
//			}
//					
///*
//SesionObjeto-GuiaRemisionAlmacenMovimiento
//Parametro1 = GamId
//Parametro2 = GreId
//Parametro3 = GrtId
//Parametro4 = AmoId
//Parametro5 = TptId
//*/
//			$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
//			NULL,
//			NULL,
//			NULL,
//			$InsTrasladoProducto->TptId,
//			NULL);
//
//		break;
		
		
		
		
		case "TrasladoProducto":

			$InsTrasladoProducto = new ClsTrasladoProducto();
			$InsTrasladoProducto->TptId = $GET_TptId;	


			$InsTrasladoProducto->MtdObtenerTrasladoProducto();		


			$InsGuiaRemision->TptId = $InsTrasladoProducto->TptId;

			$InsGuiaRemision->CliId = $InsTrasladoProducto->CliId;
			$InsGuiaRemision->CliNombreCompleto = $InsTrasladoProducto->CliNombreCompleto;
					
			$InsGuiaRemision->CliNombre = $InsTrasladoProducto->CliNombre;
			$InsGuiaRemision->CliApellidoPaterno = $InsTrasladoProducto->CliApellidoPaterno;
			$InsGuiaRemision->CliApellidoMaterno = $InsTrasladoProducto->CliApellidoMaterno;
					
			$InsGuiaRemision->CliNumeroDocumento = $InsTrasladoProducto->CliNumeroDocumento;
			$InsGuiaRemision->TdoId = $InsTrasladoProducto->TdoId;
		
			$InsGuiaRemision->GrePuntoLlegada = $InsTrasladoProducto->SucDireccionDestino." ".$InsTrasladoProducto->SucDistritoDestino." ".$InsTrasladoProducto->SucProvinciaDestino." ".$InsTrasladoProducto->SucDepartamentoDestino;
			$InsGuiaRemision->GrePuntoPartida = $InsTrasladoProducto->SucDireccion." ".$InsTrasladoProducto->SucDistrito." ".$InsTrasladoProducto->SucProvincia." ".$InsTrasladoProducto->SucDepartamento;
			
			
			$InsGuiaRemision->GrePuntoLlegadaDepartamento = primera_mayuscula($InsTrasladoProducto->SucDepartamentoDestino);
			$InsGuiaRemision->GrePuntoLlegadaProvincia = primera_mayuscula($InsTrasladoProducto->SucProvinciaDestino);
			$InsGuiaRemision->GrePuntoLlegadaDistrito = primera_mayuscula($InsTrasladoProducto->SucDistritoDestino);		
		
			
			$InsGuiaRemision->GrePuntoPartidaDepartamento = primera_mayuscula($InsTrasladoProducto->SucDepartamento);
			$InsGuiaRemision->GrePuntoPartidaProvincia = primera_mayuscula($InsTrasladoProducto->SucProvincia);
			$InsGuiaRemision->GrePuntoPartidaDistrito = primera_mayuscula($InsTrasladoProducto->SucProvincia);
			
			
			
			$InsGuiaRemision->GreObservacion = $InsTrasladoProducto->TptObservacion.chr(13).date("d/m/Y H:i:s")." - Guia de Remision Generada de Traslado de Productos.:".$InsTrasladoAlmacen->TptId;
			
			$InsGuiaRemision->GreObservacionImpresa = "";
			
			$InsGuiaRemision->GreMotivoTraslado = 9;
			$InsGuiaRemision->GreEstado = 5;
			
			$InsGuiaRemision->GreMotivoTrasladoCodigo = 4;
			
			$InsGuiaRemision->GrePuntoPartidaCodigoUbigeo = $InsTrasladoProducto->SucCodigoUbigeo;
			$InsGuiaRemision->GrePuntoLlegadaCodigoUbigeo = $InsTrasladoProducto->SucCodigoUbigeoDestino;
			
		
			

//deb("");
//deb("");
//deb("");
//deb("");
//deb($GET_TptId);
//deb($InsTrasladoProducto);									

			if(!empty($InsTrasladoProducto->TrasladoProductoDetalle)){
				foreach($InsTrasladoProducto->TrasladoProductoDetalle as $DatTrasladoProductoDetalle){

/*
//SesionObjeto-GuiaRemisionDetalleListado
//Parametro1 = GrdId
//Parametro2 = GrdCodigo
//Parametro3 = GrdDescripcion
//Parametro4 = GrdCantidad
//Parametro5 = GrdUnidadMedida
//Parametro6 = GrdPesoTotal
//Parametro7 = GrdTiempoCreacion
//Parametro8 = GrdTiempoModificacion
//Parametro9 = GrdPesoNeto
*/

					$_SESSION['InsGuiaRemisionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatTrasladoProductoDetalle->ProCodigoOriginal,
					$DatTrasladoProductoDetalle->ProNombre,
					$DatTrasladoProductoDetalle->TsdCantidad,
					$DatTrasladoProductoDetalle->UmeNombre,
					0.00,
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					0.00);

				}		
			}
					
	//SesionObjeto-GuiaRemisionAlmacenMovimiento
	//Parametro1 = GamId
	//Parametro2 = AmoId
	//Parametro3 = 
	//Parametro4 = 
	//Parametro5 = GamEstado
	//Parametro6 = GamTiempoCreacion
	//Parametro7 = GamTiempoModificacion
	//Parametro8 = VmvId
	//Parametro9 = 
	//Parametro10 = 
	//Parametro11 = AmoSubTipo
	//Parametro12 = VmvSubTipo
			
		//	
//			$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
//			NULL,
//			NULL,
//			NULL,
//			$InsTrasladoProducto->TptId,
//			NULL);
			
			//deb($_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]);
			
		break;
		
		
		
		
	}


	
}



?>