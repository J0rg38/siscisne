<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsPagoVehiculoIngreso->UsuId = $_SESSION['SesionId'];	

	$InsPagoVehiculoIngreso->PviId = $_POST['CmpId'];
	$InsPagoVehiculoIngreso->PrvId = $_POST['CmpProveedorId'];
	$InsPagoVehiculoIngreso->CtiId = $_POST['CmpComprobanteTipo'];	
	$InsPagoVehiculoIngreso->TopId = $_POST['CmpTipoOperacion'];	
	$InsPagoVehiculoIngreso->OcoId = $_POST['CmpOrdenCompra'];	
	$InsPagoVehiculoIngreso->AlmId = $_POST['CmpAlmacen'];	
	
	
	$InsPagoVehiculoIngreso->BanId = $_POST['CmpBanco'];
	$InsPagoVehiculoIngreso->PviNumeroBloque = $_POST['CmpNumeroBloque'];
	
	$InsPagoVehiculoIngreso->SucId = $_POST['CmpSucursal'];	
	
//	$InsPagoVehiculoIngreso->PviPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	$InsPagoVehiculoIngreso->PviPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
	$InsPagoVehiculoIngreso->PviFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsPagoVehiculoIngreso->PviObservacion = addslashes($_POST['CmpObservacion']);
	$InsPagoVehiculoIngreso->PviDocumentoOrigen = $_POST['CmpDocumentoOrigen'];
	
	$InsPagoVehiculoIngreso->PviComprobanteNumeroSerie = $_POST['CmpComprobanteNumeroSerie'];
	$InsPagoVehiculoIngreso->PviComprobanteNumeroNumero = $_POST['CmpComprobanteNumeroNumero'];
	$InsPagoVehiculoIngreso->PviComprobanteNumero = $InsPagoVehiculoIngreso->PviComprobanteNumeroSerie."-".$InsPagoVehiculoIngreso->PviComprobanteNumeroNumero;
	
	$InsPagoVehiculoIngreso->PviComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpComprobanteFecha'],true);	

	$InsPagoVehiculoIngreso->PviGuiaRemisionNumeroSerie = $_POST['CmpGuiaRemisionNumeroSerie'];	
	$InsPagoVehiculoIngreso->PviGuiaRemisionNumeroNumero = $_POST['CmpGuiaRemisionNumeroNumero'];	
	$InsPagoVehiculoIngreso->PviGuiaRemisionNumero = $InsPagoVehiculoIngreso->PviGuiaRemisionNumeroSerie."-".$InsPagoVehiculoIngreso->PviGuiaRemisionNumeroNumero;	
	
	$InsPagoVehiculoIngreso->PviGuiaRemisionFecha = FncCambiaFechaAMysql($_POST['CmpGuiaRemisionFecha'],true);	
	$InsPagoVehiculoIngreso->PviGuiaRemisionFoto = $_SESSION['SesPviGuiaRemisionFoto'.$Identificador];

	$InsPagoVehiculoIngreso->MonId = $_POST['CmpMonedaId'];
	$InsPagoVehiculoIngreso->PviTipoCambio = $_POST['CmpTipoCambio'];
	$InsPagoVehiculoIngreso->PviTipoCambioComercial = $_POST['CmpTipoCambioComercial'];
	
	$InsPagoVehiculoIngreso->PviIncluyeImpuesto = 2;

	$InsPagoVehiculoIngreso->PviMargenUtilidad = 0.00;
	$InsPagoVehiculoIngreso->PviTipo = 1;
	$InsPagoVehiculoIngreso->PviSubTipo = 2;

	$InsPagoVehiculoIngreso->NpaId = $_POST['CmpCondicionPago'];
	$InsPagoVehiculoIngreso->PviCantidadDia = isset($_POST['CmpCantidadDia'])?$_POST['CmpCantidadDia']:0;
	
	$InsPagoVehiculoIngreso->PviEstado = $_POST['CmpEstado'];
	
	$InsPagoVehiculoIngreso->PviTiempoCreacion = date("Y-m-d H:i:s");
	$InsPagoVehiculoIngreso->PviTiempoModificacion = date("Y-m-d H:i:s");
	$InsPagoVehiculoIngreso->PviEliminado = 1;
	
	$InsPagoVehiculoIngreso->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsPagoVehiculoIngreso->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsPagoVehiculoIngreso->PrvApellidoPaterno = $_POST['CmpProveedorApellidoPaterno'];
	$InsPagoVehiculoIngreso->PrvApellidoMaterno = $_POST['CmpProveedorApellidoMaterno'];
	
	$InsPagoVehiculoIngreso->PrvNombreCompleto = $_POST['CmpProveedorNombreCompleto'];
	$InsPagoVehiculoIngreso->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsPagoVehiculoIngreso->PviTotal = eregi_replace(",","",(empty($_POST['CmpTotal'])?0:$_POST['CmpTotal']));
	
	$InsPagoVehiculoIngreso->PviFoto = $_SESSION['SesPviFoto'.$Identificador];

	settype($InsPagoVehiculoIngreso->PviTipoCambio,"float");
		
	$InsPagoVehiculoIngreso->PagoVehiculoIngresoDetalle = array();
	
	if($InsPagoVehiculoIngreso->MonId<>$EmpresaMonedaId){
		if(empty($InsPagoVehiculoIngreso->PviTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_PVI_600';
		}
	}
	
	if(empty($InsPagoVehiculoIngreso->SucId)){
		$Guardar = false;
		$Resultado.='#ERR_PVI_602';
	}
	
	
	$InsPagoVehiculoIngreso->PviTotalBruto = 0;
	$InsPagoVehiculoIngreso->PviSubTotal = 0;
	$InsPagoVehiculoIngreso->PviImpuesto = 0;
	//$InsPagoVehiculoIngreso->PviTotal = 0;
	$InsPagoVehiculoIngreso->PviValorTotal = 0;
	
	
//
//SesionObjeto-PagoVehiculoIngresoDetalle
//Parametro1 = PvdId
//Parametro2 = EinId
//Parametro3 = EinVIN

//Parametro4 = PvdCosto
//Parametro5 = PvdCantidad
//Parametro6 = PvdImporte
//Parametro7 = PvdTiempoCreacion
//Parametro8 = PvdTiempoModificacion

//Parametro9 = EinNumeroMotor
//Parametro10 = EinAnoFabricacion
//Parametro11 = EinAnoModelo
//Parametro12 = VehId

//Parametro13 = PvdUtilidad
//Parametro14 = PvdUtilidadPorcentaje
//Parametro15 = PvdCostoAnterior
//Parametro16 = PvdObservacion
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = PvdEstado
//Parametro26 = UmeId

	$ResPagoVehiculoIngreso = $_SESSION['InsPagoVehiculoIngresoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	
	if(!empty($ResPagoVehiculoIngreso['Datos'])){
		foreach($ResPagoVehiculoIngreso['Datos'] as $DatSesionObjeto){
			
			if($InsPagoVehiculoIngreso->MonId<>$EmpresaMonedaId){
				
				$DatSesionObjeto->Parametro4 = $DatSesionObjeto->Parametro4 * $InsPagoVehiculoIngreso->PviTipoCambio;
				$DatSesionObjeto->Parametro6 = $DatSesionObjeto->Parametro6 * $InsPagoVehiculoIngreso->PviTipoCambio;
				$DatSesionObjeto->Parametro13 = $DatSesionObjeto->Parametro13 * $InsPagoVehiculoIngreso->PviTipoCambio;
				$DatSesionObjeto->Parametro15 = $DatSesionObjeto->Parametro15 * $InsPagoVehiculoIngreso->PviTipoCambio;
				$DatSesionObjeto->Parametro29 = $DatSesionObjeto->Parametro29 * $InsPagoVehiculoIngreso->PviTipoCambio;
				
			}
		
			$InsPagoVehiculoIngresoDetalle1 = new ClsPagoVehiculoIngresoDetalle();
			$InsPagoVehiculoIngresoDetalle1->PvdId = $DatSesionObjeto->Parametro1;
			
			$InsPagoVehiculoIngresoDetalle1->EinId = $DatSesionObjeto->Parametro2;
			$InsPagoVehiculoIngresoDetalle1->VehId = $DatSesionObjeto->Parametro12;
			
			$InsPagoVehiculoIngresoDetalle1->PvdCosto = $DatSesionObjeto->Parametro4;
			$InsPagoVehiculoIngresoDetalle1->PvdCantidad = $DatSesionObjeto->Parametro5;
			$InsPagoVehiculoIngresoDetalle1->PvdImporte = $DatSesionObjeto->Parametro6;
			$InsPagoVehiculoIngresoDetalle1->PvdObservacion = $DatSesionObjeto->Parametro16;

			$InsPagoVehiculoIngresoDetalle1->PvdEstado = $InsPagoVehiculoIngreso->PviEstado;		
			$InsPagoVehiculoIngresoDetalle1->PvdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsPagoVehiculoIngresoDetalle1->PvdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsPagoVehiculoIngresoDetalle1->PvdEliminado = $DatSesionObjeto->Eliminado;				
			$InsPagoVehiculoIngresoDetalle1->InsMysql = NULL;

						
			if($InsPagoVehiculoIngresoDetalle1->PvdEliminado==1){	
							
				$InsPagoVehiculoIngreso->PagoVehiculoIngresoDetalle[] = $InsPagoVehiculoIngresoDetalle1;		
				///$InsPagoVehiculoIngreso->PviTotalBruto += $InsPagoVehiculoIngreso1->PvdImporte;
				
			}
		}		
		
	}else{
		//$Guardar = false;
		//$Resultado.='#ERR_PVI_111';
	}

	
	if( $InsPagoVehiculoIngreso->MonId<>$EmpresaMonedaId ){
		$InsPagoVehiculoIngreso->PviTotal = $InsPagoVehiculoIngreso->PviTotal * $InsPagoVehiculoIngreso->PviTipoCambio;
	}else{
		$InsPagoVehiculoIngreso->PviTotal = $InsPagoVehiculoIngreso->PviTotal;
	}

 

	if($Guardar){

		if($InsPagoVehiculoIngreso->MtdRegistrarPagoVehiculoIngreso()){
//
//			if($_POST['CmpNotificar']=="1"){
//				
//				$InsPagoVehiculoIngreso->MtdNotificarPagoVehiculoIngresoRegistro($InsPagoVehiculoIngreso->PviId,$CorreosNotificacionPagoVehiculoIngresoRegistro,false);
//				
//			}
//			
			FncNuevo();
		
			$Resultado.='#SAS_PVI_101';
			$Registro = true;
		}else{
			
			
			if($InsPagoVehiculoIngreso->MonId<>$EmpresaMonedaId ){
				$InsPagoVehiculoIngreso->PviTotal = round($InsPagoVehiculoIngreso->PviTotal / $InsPagoVehiculoIngreso->PviTipoCambio,3);
			}
			
			$InsPagoVehiculoIngreso->PviFecha = FncCambiaFechaANormal($InsPagoVehiculoIngreso->PviFecha);
			$InsPagoVehiculoIngreso->PviComprobanteFecha = FncCambiaFechaANormal($InsPagoVehiculoIngreso->PviComprobanteFecha,true);
			$InsPagoVehiculoIngreso->PviGuiaRemisionFecha = FncCambiaFechaANormal($InsPagoVehiculoIngreso->PviGuiaRemisionFecha,true);


			$Resultado.='#ERR_PVI_101';	
		}
			
	}else{
		
			
			if($InsPagoVehiculoIngreso->MonId<>$EmpresaMonedaId ){
				$InsPagoVehiculoIngreso->PviTotal = round($InsPagoVehiculoIngreso->PviTotal / $InsPagoVehiculoIngreso->PviTipoCambio,3);
			}
			
			$InsPagoVehiculoIngreso->PviFecha = FncCambiaFechaANormal($InsPagoVehiculoIngreso->PviFecha);
			$InsPagoVehiculoIngreso->PviComprobanteFecha = FncCambiaFechaANormal($InsPagoVehiculoIngreso->PviComprobanteFecha,true);
			$InsPagoVehiculoIngreso->PviGuiaRemisionFecha = FncCambiaFechaANormal($InsPagoVehiculoIngreso->PviGuiaRemisionFecha,true);
			
		
	}
	


}else{

	FncNuevo();
	
}



function FncNuevo(){

	global $Identificador;
	global $InsPagoVehiculoIngreso;
		
	unset($_SESSION['InsPagoVehiculoIngresoDetalle'.$Identificador]);
	unset($_SESSION['SesPviFoto'.$Identificador]);
	
	$_SESSION['InsPagoVehiculoIngresoDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsPagoVehiculoIngreso = new ClsPagoVehiculoIngreso();
	
	$InsPagoVehiculoIngreso->PviEstado = 3;

	$InsPagoVehiculoIngreso->TopId = "TOP-10010";
	$InsPagoVehiculoIngreso->CtiId = "CTI-10006";
	$InsPagoVehiculoIngreso->TdoId = "TDO-10003";
	$InsPagoVehiculoIngreso->NpaId = "NPA-10000";
	$InsPagoVehiculoIngreso->PviCantidadDia = 0;
	$InsPagoVehiculoIngreso->SucId = $_SESSION['SesionSucursal'];
	$InsPagoVehiculoIngreso->AlmId = "";
	
	
	$ProveedorId = '';
	$ProveedorNombreCompleto =  '';
	
	$ProveedorNombre = '';
	$ProveedorApellidoPaterno = '';
	$ProveedorApellidoMaterno = '';
	
	$ProveedorNumeroDocumento = '';
	$TipoDocumentoId = '';
			
	$InsProveedor = new ClsProveedor();	
	
	//MtdObtenerProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PrvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL) 
	$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,"PrvNombre","ASC",1,"1","PROVEEDOR");
	$ArrProveedores = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){
		
			$ProveedorId = $DatProveedor->PrvId;
			$ProveedorNombreCompleto = $DatProveedor->PrvNombreCompleto;
			
			$ProveedorNombre = $DatProveedor->PrvNombre;
			$ProveedorApellidoPaterno = $DatProveedor->PrvApellidoPaterno;
			$ProveedorApellidoMaterno = $DatProveedor->PrvApellidoMaterno;
			
			$ProveedorNumeroDocumento = $DatProveedor->PrvNumeroDocumento;
			$TipoDocumentoId = $DatProveedor->TdoId;

		}
	}
	$InsPagoVehiculoIngreso->PrvId = $ProveedorId;
	$InsPagoVehiculoIngreso->PrvNumeroDocumento = $ProveedorNumeroDocumento;
	$InsPagoVehiculoIngreso->PrvNombre = $ProveedorNombre;
	$InsPagoVehiculoIngreso->PrvApellidoPaterno = $ProveedorApellidoPaterno;
	$InsPagoVehiculoIngreso->PrvApellidoMaterno = $ProveedorApellidoMaterno;
	$InsPagoVehiculoIngreso->TdoId = $TipoDocumentoId;
	$InsPagoVehiculoIngreso->PrvNombreCompleto = $ProveedorNombreCompleto;
	
	

}
?>