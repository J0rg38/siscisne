<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnEnviarCorreo_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsPedidoCompraLlegada->UsuId = $_SESSION['SesionId'];		
	
	$InsPedidoCompraLlegada->PleId = $_POST['CmpId'];
	$InsPedidoCompraLlegada->OcoId = $_POST['CmpOrdenCompra'];
	$InsPedidoCompraLlegada->PleFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsPedidoCompraLlegada->PleObservacion = addslashes($_POST['CmpObservacion']);

	$InsPedidoCompraLlegada->PleComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsPedidoCompraLlegada->PleComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsPedidoCompraLlegada->PleComprobanteNumero = $InsPedidoCompraLlegada->PleComprobanteNumeroSerie."-".$InsPedidoCompraLlegada->PleComprobanteNumeroNumero;
	
	$InsPedidoCompraLlegada->PleComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);	
	
	$InsPedidoCompraLlegada->PleGuiaRemisionNumeroSerie = $_POST['CmpGuiaRemisionNumeroSerie'];	
	$InsPedidoCompraLlegada->PleGuiaRemisionNumeroNumero = $_POST['CmpGuiaRemisionNumeroNumero'];	
	$InsPedidoCompraLlegada->PleGuiaRemisionNumero = $InsPedidoCompraLlegada->PleGuiaRemisionNumeroSerie."-".$InsPedidoCompraLlegada->PleGuiaRemisionNumeroNumero;	
	
	$InsPedidoCompraLlegada->PleGuiaRemisionFecha = FncCambiaFechaAMysql($_POST['CmpGuiaRemisionFecha'],true);	

	$InsPedidoCompraLlegada->PleFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);

	$InsPedidoCompraLlegada->PleObservacion = addslashes($_POST['CmpObservacion']);
	$InsPedidoCompraLlegada->PleEstado = $_POST['CmpEstado'];
	
	$InsPedidoCompraLlegada->PleTiempoModificacion = date("Y-m-d H:i:s");
	$InsPedidoCompraLlegada->PleEliminado = 1;

	$InsPedidoCompraLlegada->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsPedidoCompraLlegada->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsPedidoCompraLlegada->PrvNombreCompleto = $_POST['CmpProveedorNombre'];
	$InsPedidoCompraLlegada->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsPedidoCompraLlegada->PleFoto = $_SESSION['SesPleFoto'.$Identificador];
		
	$InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle = array();

	$InsPedidoCompraLlegada->PleDestinatarios = $_POST['CmpDestinatario'];
	
	if($Guardar){
		
//		if($InsPedidoCompraLlegada->MtdEditarPedidoCompraLlegada()){		
		//($oDestinatario,$oPedidoCompraLlegadaId,$oFechaInicio=NULL,$oFechaFin=NULL){
		if($InsPedidoCompraLlegada->MtdEnviarDespachoPedidoCompraLlegada($InsPedidoCompraLlegada->PleDestinatarios,$InsPedidoCompraLlegada->PleId,NULL,NULL, $_SESSION['SesionNombre'])){		
		
			$InsPedidoCompraLlegada->MtdActualizarEstadoPedidoCompraLlegada($InsPedidoCompraLlegada->PleId,"31");
			FncCargarDatos();
			$Resultado.='#SAS_PLE_102';
			$Edito = true;
		} else{

			$InsPedidoCompraLlegada->PleFecha = FncCambiaFechaANormal($InsPedidoCompraLlegada->PleFecha);
			$InsPedidoCompraLlegada->PleGuiaRemisionFecha = FncCambiaFechaANormal($InsPedidoCompraLlegada->PleGuiaRemisionFecha,true);
			$InsPedidoCompraLlegada->PleComprobanteFecha = FncCambiaFechaANormal($InsPedidoCompraLlegada->PleComprobanteFecha,true);
			$Resultado.='#ERR_PLE_102';
		}

	}else{

		$InsPedidoCompraLlegada->PleFecha = FncCambiaFechaANormal($InsPedidoCompraLlegada->PleFecha);
		$InsPedidoCompraLlegada->PleGuiaRemisionFecha = FncCambiaFechaANormal($InsPedidoCompraLlegada->PleGuiaRemisionFecha,true);
		$InsPedidoCompraLlegada->PleComprobanteFecha = FncCambiaFechaANormal($InsPedidoCompraLlegada->PleComprobanteFecha,true);

	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsPedidoCompraLlegada;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador]);

	$_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsPedidoCompraLlegada->PleId = $GET_id;
	$InsPedidoCompraLlegada->MtdObtenerPedidoCompraLlegada();		
	
	$InsPedidoCompraLlegada->PleDestinatarios = "jblanco@cyc.com.pe,aliendo@cyc.com.pe,iquezada@cyc.com.pe,scanepam@cyc.com.pe,anace@cyc.com.pe,pcondori@cyc.com.pe,dvercelone@cyc.com.pe,jmaquera@cyc.com.pe";
	
	if(!empty($InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle)){
		foreach($InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle as $DatInsPedidoCompraLlegadaDetalle){
		
//SesionObjeto-PedidoCompraLlegadaDetalle
//Parametro1 = 
//Parametro2 = PcdId
//Parametro3 = PldCantidad
//Parametro4 = PldEstado
//Parametro5 = PldTiempoCreacion
//Parametro6 = PldTiempoModificacion
//Parametro7 = ProId
//Parametro8 = UmeId
//Parametro9 = PcdCantidad
//Parametro10 = ProNombre
//Parametro11 = ProCodigoOriginal
//Parametro12 = ProCodigoAlternativo
//Parametro13 = UmeIdOrigen
//Parametro14 = UmeNombre
//Parametro15 = VdiId

//Parametro16 = VdiOrdenCompraNumero
//Parametro17 = CliNumeroDocumento
//Parametro18 = CliNombre
//Parametro19 = CliApellidoPaterno
//Parametro20 = CliApellidoMaterno
//Parametro21 = RtiId
//Parametro22 = OcoId


			$_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatInsPedidoCompraLlegadaDetalle->PldId,
			$DatInsPedidoCompraLlegadaDetalle->PcdId,
			$DatInsPedidoCompraLlegadaDetalle->PldCantidad,
			$DatInsPedidoCompraLlegadaDetalle->PldEstado,			
			$DatInsPedidoCompraLlegadaDetalle->PldTiempoCreacion,
			$DatInsPedidoCompraLlegadaDetalle->PldTiempoModificacion,			
			$DatInsPedidoCompraLlegadaDetalle->ProId,
			$DatInsPedidoCompraLlegadaDetalle->UmeId,
			$DatInsPedidoCompraLlegadaDetalle->PcdCantidad,			
			$DatInsPedidoCompraLlegadaDetalle->ProNombre,
			$DatInsPedidoCompraLlegadaDetalle->ProCodigoOriginal,
			$DatInsPedidoCompraLlegadaDetalle->ProCodigoAlternativo,					
			$DatInsPedidoCompraLlegadaDetalle->UmeIdOrigen,
			$DatInsPedidoCompraLlegadaDetalle->UmeNombre,		
			
			$DatInsPedidoCompraLlegadaDetalle->VdiId,		
			$DatInsPedidoCompraLlegadaDetalle->VdiOrdenCompraNumero,		
					
			$DatInsPedidoCompraLlegadaDetalle->CliNumeroDocumento,
			$DatInsPedidoCompraLlegadaDetalle->CliNombre,
			$DatInsPedidoCompraLlegadaDetalle->CliApellidoPaterno,
			$DatInsPedidoCompraLlegadaDetalle->CliApellidoMaterno,
			$DatInsPedidoCompraLlegadaDetalle->RtiId,
			$DatInsPedidoCompraLlegadaDetalle->OcoId
				
			);

		}
	}
		
		
}
?>