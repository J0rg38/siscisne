<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

//deb($_POST);

	$Resultado = '';

$InsGuiaRemision->GreId = $_POST['CmpId'];
	$InsGuiaRemision->GrtId = $_POST['CmpTalonario'];
	$InsGuiaRemision->UsuId = $_SESSION['SesionId'];
		
	$InsGuiaRemision->CliId = $_POST['CmpClienteId'];
	$InsGuiaRemision->PrvId = $_POST['CmpProveedorId'];
	
	$InsGuiaRemision->TalId = $_POST['CmpTrasladoAlmacenId'];
	//$InsGuiaRemision->OvvId = $_POST['CmpOrdenVentaVehiculo'];
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
	
	$InsGuiaRemision->GrePesoTotal = preg_replace("/,/", "", (empty($_POST['CmpPesoTotal'])?0:$_POST['CmpPesoTotal']));
	$InsGuiaRemision->GreTotalPaquetes = preg_replace("/,/", "", (empty($_POST['CmpTotalPaquetes'])?0:$_POST['CmpTotalPaquetes']));
	
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
	/*
	01 venta
	14 venta sujeta a confirmacion del comprador
	02 compra
	04 traslado entre establecimientos de la misma empresa
	18 traslado emisor itinerante cp
	08 importacion
	09 exportacion
	19 traslado a zona primaria
	13 otros
	*/
	//switch($InsGuiaRemision->GreMotivoTraslado){
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
	Parametro1 = Id
	Parametro2 = Codigo
	Parametro3 = Descripcion
	Parametro4 = Cantidad
	Parametro5 = UnidadMedida
	Parametro6 = PesoTotal
	Parametro7 = TiempoCreacion
	Parametro8 = TiempoModificacion
	*/
	
	$ResGuiaRemisionDetalle = $_SESSION['InsGuiaRemisionDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
	
		if(is_array($ResGuiaRemisionDetalle['Datos'])){
		
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
	
		$ResGuiaRemisionAlmacenMovimiento = $_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]->MtdObtenerSesionObjetos(false);
		
			if(is_array($ResGuiaRemisionAlmacenMovimiento['Datos'])){
			
				foreach($ResGuiaRemisionAlmacenMovimiento['Datos'] as $DatSesionObjeto){
						
					$InsGuiaRemisionAlmacenMovimiento1 = new ClsGuiaRemisionAlmacenMovimiento();
					$InsGuiaRemisionAlmacenMovimiento1->GamId = $DatSesionObjeto->Parametro1;	
					$InsGuiaRemisionAlmacenMovimiento1->GreId = $DatSesionObjeto->Parametro2;
					$InsGuiaRemisionAlmacenMovimiento1->GrtId = $DatSesionObjeto->Parametro3;
					
					$InsGuiaRemisionAlmacenMovimiento1->AmoId = $DatSesionObjeto->Parametro4;
					$InsGuiaRemisionAlmacenMovimiento1->VmvId = $DatSesionObjeto->Parametro8;
					
					$InsGuiaRemisionAlmacenMovimiento1->GamEliminado = $DatSesionObjeto->Eliminado;				
					$InsGuiaRemisionAlmacenMovimiento1->InsMysql = NULL;
					
					$InsGuiaRemision->GuiaRemisionAlmacenMovimiento[] = $InsGuiaRemisionAlmacenMovimiento1;	
							
				}	
					
			}	
				
			if($InsGuiaRemision->MtdEditarGuiaRemision()){		
				$Edito = true;
				$Resultado.='#SAS_GRE_102';
				
				FncCargarDatos();
				
			} else{
				$Resultado.='#ERR_GRE_102';
				$InsGuiaRemision->GreFechaInicioTraslado = FncCambiaFechaANormal($InsGuiaRemision->GreFechaInicioTraslado);
				
			}
	

}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
		
	global $GET_id;
	global $GET_ta;
	global $Identificador;
	global $InsGuiaRemision;
	
	unset($_SESSION['InsGuiaRemisionDetalle'.$Identificador]);
	unset($_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador]);
	
	$_SESSION['InsGuiaRemisionDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsGuiaRemisionAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();
	
	$InsGuiaRemision->GreId = $GET_id;
	$InsGuiaRemision->GrtId = $GET_ta;
	$InsGuiaRemision->MtdObtenerGuiaRemision();		
	
	if(!empty($InsGuiaRemision->GuiaRemisionDetalle)){
		foreach($InsGuiaRemision->GuiaRemisionDetalle as $DatGuiaRemisionDetalle){

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
			$DatGuiaRemisionDetalle->GrdId,
			$DatGuiaRemisionDetalle->GrdCodigo,
			$DatGuiaRemisionDetalle->GrdDescripcion,
			$DatGuiaRemisionDetalle->GrdCantidad,
			$DatGuiaRemisionDetalle->GrdUnidadMedida,
			$DatGuiaRemisionDetalle->GrdPesoTotal,
			($DatGuiaRemisionDetalle->GrdTiempoCreacion),
			($DatGuiaRemisionDetalle->GrdTiempoModificacion),
			($DatGuiaRemisionDetalle->GrdPesoNeto)
			);
		
		}
	}
	
	if(!empty($InsGuiaRemision->GuiaRemisionAlmacenMovimiento)){
		foreach($InsGuiaRemision->GuiaRemisionAlmacenMovimiento as $DatGuiaRemisionAlmacenMovimiento){

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
			$DatGuiaRemisionAlmacenMovimiento->GamId,
			$DatGuiaRemisionAlmacenMovimiento->GreId,
			$DatGuiaRemisionAlmacenMovimiento->GrtId,
			$DatGuiaRemisionAlmacenMovimiento->AmoId,
			3,
			$DatGuiaRemisionAlmacenMovimiento->GamTiempoCreacion,
			$DatGuiaRemisionAlmacenMovimiento->GamTiempoModificacion,
			$DatGuiaRemisionAlmacenMovimiento->VmvId,
			$DatGuiaRemisionAlmacenMovimiento->VmvFecha,
			$DatGuiaRemisionAlmacenMovimiento->AmoFecha,
			$DatGuiaRemisionAlmacenMovimiento->AmoSubTipo,
			$DatGuiaRemisionAlmacenMovimiento->VmvSubTipo
			);
		
		}
	}
	
	
}
?>