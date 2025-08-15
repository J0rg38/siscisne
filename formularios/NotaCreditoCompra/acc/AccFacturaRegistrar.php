<?php
//Si se hizo click en guardar	

	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsFactura->FacId = $_POST['CmpId'];
	$InsFactura->FtaId = $_POST['CmpTalonario'];
	$InsFactura->CliId = $_POST['CmpClienteId'];

	$InsFactura->UsuId = $_SESSION['SesionId'];
	$InsFactura->SucId = $_SESSION['SisSucId'];

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
	$InsFactura->FacEstado = $_POST['CmpEstado'];
	$InsFactura->FacPorcentajeImpuestoVenta = ($_POST['CmpPorcentajeImpuestoVenta']);
			
	$InsFactura->FacFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	$InsFactura->FacObservacion = addslashes($_POST['CmpObservacion'])."###".addslashes($_POST['CmpObservacionImpresa']);
	
	$InsFactura->FacCierre = 1;
	$InsFactura->FacTiempoCreacion = date("Y-m-d H:i:s");
	$InsFactura->FacTiempoModificacion = date("Y-m-d H:i:s");
	$InsFactura->FacEliminado = 1;
	
	$InsFactura->CliNombre = $_POST['CmpClienteNombre'];
	$InsFactura->CliNombreCompleto = $_POST['CmpClienteNombre'];
	$InsFactura->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsFactura->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	
	$InsFactura->TdoId = $_POST['CmpClienteTipoDocumentoId'];	
	$InsFactura->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsFactura->CliTelefono = $_POST['CmpClienteTelefono'];

	$InsFactura->CliEmail = $_POST['CmpClienteEmail'];
	$InsFactura->CliCelular = $_POST['CmpClienteCelular'];
	$InsFactura->CliFax = $_POST['CmpClienteFax'];

	$InsFactura->FacDireccion = $_POST['CmpClienteDireccion'];

	$InsFactura->FacRegimenComprobanteNumero = $_POST['CmpRegimenComprobanteNumero'];
	$InsFactura->FacRegimenComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpRegimenComprobanteFecha'],true);	
	$InsFactura->RegId = $_POST['CmpRegimenId'];	
	$InsFactura->RegAplicacion = $_POST['CmpRegimenAplicacion'];	
	$InsFactura->FacRegimenPorcentaje = $_POST['CmpRegimenPorcentaje'];
	$InsFactura->FacRegimenMonto = preg_replace("/,/", "", $_POST['CmpRegimenMonto']);
	
	if($InsFactura->MonId<>$EmpresaMonedaId and !empty($InsFactura->FacTipoCambio)){
		$InsFactura->FacRegimenMonto = $InsFactura->FacRegimenMonto * $InsFactura->FacTipoCambio;
	}	
		
	$InsFactura->FinId = $_POST['CmpFichaIngresoId'];
	$InsFactura->AmoId = $_POST['CmpAlmacenMovimientoSalidaId'];
	
	
	$InsFactura->VdiId = $_POST['CmpVentaDirectaId'];
	
	$InsFactura->FccId = $_POST['CmpFichaAccionId'];
	$InsFactura->CprId = $_POST['CmpCotizacionProductoId'];
	
	$InsFactura->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	$InsFactura->CveId = $_POST['CmpCotizacionVehiculoId'];
		
	$InsFactura->FacturaDetalle = array();
	
	if($InsFactura->MonId<>$EmpresaMonedaId){
		if(empty($InsFactura->FacTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_FAC_600';
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
*/
	
	$InsFactura->FacTotalBruto = 0;
	$InsFactura->FacSubTotal = 0;
	$InsFactura->FacImpuesto = 0;
	$InsFactura->FacTotal = 0;

	$ResFacturaDetalle = $_SESSION['InsFacturaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);//OJO

	if(!empty($ResFacturaDetalle['Datos'])){	
		foreach($ResFacturaDetalle['Datos'] as $DatSesionObjeto){
						
		$InsFacturaDetalle1 = new ClsFacturaDetalle();
			$InsFacturaDetalle1->FdeId = $DatSesionObjeto->Parametro1;	
				
			$InsFacturaDetalle1->OdeId = $DatSesionObjeto->Parametro9;
			
			$InsFacturaDetalle1->FdeTipo = $DatSesionObjeto->Parametro12;
			
			$InsFacturaDetalle1->AmdId = $DatSesionObjeto->Parametro9;
			
			$InsFacturaDetalle1->FdeDescripcion = utf8_encode(htmlentities($DatSesionObjeto->Parametro2));
			
			$InsFacturaDetalle1->FdePrecio = $DatSesionObjeto->Parametro4;

			if($InsFactura->MonId<>$EmpresaMonedaId and !empty($InsFactura->FacTipoCambio)){
				$InsFacturaDetalle1->FdePrecio = $DatSesionObjeto->Parametro4 * $InsFactura->FacTipoCambio;
			}else{
				$InsFacturaDetalle1->FdePrecio = $DatSesionObjeto->Parametro4;
			}
			
			$InsFacturaDetalle1->FdeCantidad = $DatSesionObjeto->Parametro5;

			if($InsFactura->MonId<>$EmpresaMonedaId and !empty($InsFactura->FacTipoCambio)){
				$InsFacturaDetalle1->FdeImporte = $DatSesionObjeto->Parametro6 * $InsFactura->FacTipoCambio;
			}else{
				$InsFacturaDetalle1->FdeImporte = $DatSesionObjeto->Parametro6;
			}

			$InsFacturaDetalle1->FdeUnidadMedida = $DatSesionObjeto->Parametro13;
			$InsFacturaDetalle1->FdeTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsFacturaDetalle1->FdeTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			
			$InsFacturaDetalle1->FdeEliminado = $DatSesionObjeto->Eliminado;				
			$InsFacturaDetalle1->InsMysql = NULL;
			
			$InsFactura->FacturaDetalle[] = $InsFacturaDetalle1;	
			
			if($InsFacturaDetalle1->FdeEliminado==1){		
				$InsFactura->FacTotalBruto += $InsFacturaDetalle1->FdeImporte;
			}
		}	

	}else if($InsFactura->FacEstado <> 6){
		$Guardar = false;
		$Resultado .= "#ERR_FAC_603";		
	}
	
	if($InsFactura->FacIncluyeImpuesto==2){
		$InsFactura->FacSubTotal = round($InsFactura->FacTotalBruto,6);
		$InsFactura->FacImpuesto = round(($InsFactura->FacSubTotal * ($InsFactura->FacPorcentajeImpuestoVenta/100)),6);
		$InsFactura->FacTotal = round($InsFactura->FacSubTotal + $InsFactura->FacImpuesto,6);
	}else{
		$InsFactura->FacTotal = round($InsFactura->FacTotalBruto,6);	
		$InsFactura->FacSubTotal = round($InsFactura->FacTotal / (($InsFactura->FacPorcentajeImpuestoVenta/100)+1),6);
		$InsFactura->FacImpuesto = round(($InsFactura->FacTotal - $InsFactura->FacSubTotal),6);
	}

	
	if(!empty($InsFactura->RegId)){
		if($InsFactura->RegAplicacion==1){
			$InsFactura->FacTotalReal = $InsFactura->FacTotal - $InsFactura->FacRegimenMonto;
		}elseif($InsFactura->RegAplicacion == 2){
			$InsFactura->FacTotalReal = $InsFactura->FacTotal + $InsFactura->FacRegimenMonto;					
		}
	}else{
		$InsFactura->FacTotalReal = $InsFactura->FacTotal;
	}	
	
	
	if(!empty($InsFactura->AmoId)){
		
		$ArrFactura = $InsFactura->MtdVerificarExisteAlmacenMovimientoSalidaId($InsFactura->AmoId);		
		
		if(!empty($ArrFactura)){
			$Guardar = false;
			$Resultado .= "#ERR_FAC_604";	
		}
			
	}
	
	if($Guardar){
		
		if($InsFactura->MtdRegistrarFactura()){	

			switch($GET_ori){

				case "FichaAccion":		
					
					$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFactura->FinId,9);
					
					$InsFichaAccion->MtdActualizarEstadoFichaAccion($InsFactura->FccId,3);
						
				break;


	
				case "AlmacenMovimientoSalida":		

					if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFactura->FinId,9)){
						//$Resultado .= "#SAS_FCC_106";
					}else{
						//$Resultado .= "#ERR_FCC_106";
					}

				break;
				
				case "VentaConcretada":	

					$InsCotizacionProducto->MtdActualizarEstadoCotizacionProducto($InsFactura->OvvId,6);
					
				break;
				
				
							
				case "OrdenVentaVehiculo":	
					
					$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
					
					if($InsFactura->FacEstado <> 6){
						$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($InsFactura->OvvId,5);
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
			}
	
			$Registro = true;		
			$Resultado.='#SAS_FAC_101';
		} else{
			$Resultado.='#ERR_FAC_101';
		}		
		


	}
	
	$InsFactura->FacFechaEmision = FncCambiaFechaANormal($InsFactura->FacFechaEmision);
	$InsFactura->FacOrdenFecha = FncCambiaFechaANormal($InsFactura->FacOrdenFecha,true);
	list($InsFactura->FacObservacion,$InsFactura->FacObservacionImpresa) = explode("###",$InsFactura->FacObservacion);
	
	if($InsFactura->MonId<>$EmpresaMonedaId and !empty($InsFactura->FacTipoCambio)){
		$InsFactura->FacRegimenMonto = round($InsFactura->FacRegimenMonto / $InsFactura->FacTipoCambio,2);
	}
	
}else{

	unset($_SESSION['InsFacturaDetalle'.$Identificador]);	
	
	$_SESSION['InsFacturaDetalle'.$Identificador] = new ClsSesionObjeto();

	$InsFactura->FacFechaEmision = date("d/m/Y");	
	$InsFactura->TdoId = "TDO-10000";
	$InsFactura->MonId = $EmpresaMonedaId;
	$InsFactura->NpaId = "NPA-10000";
	$InsFactura->FacCancelado = 2;
	
	$InsFactura->FacObsequio = 2;
	$InsFactura->FacSpot = 2;
	//deb($InsFactura->FacSpot);
	$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsFactura->FacIncluyeImpuesto = 1;

	switch($GET_ori){

		case "FichaAccion":

			if(!empty($GET_FccId)){
				FncCargarFichaAccionDatos();		
			}

		break;

		case "AlmacenMovimientoSalida":		

			if(!empty($GET_AmoId)){
				FncCargarAlmacenMovimientoSalidaDatos();				
			}

		break;

		case "VentaConcretada":		

			if(!empty($GET_VcoId)){
				FncCargarVentaConcretadaDatos();
			}

		break;
		
		case "OrdenVentaVehiculo":

			if(!empty($GET_OvvId)){
				FncCargarOrdenVentaVehiculoDatos();
			}

		break;

	}

}


function FncCargarFichaAccionDatos(){
	
	global $GET_FccId;
	global $GET_AmoId;
	global $Identificador;
	global $InsFichaAccion;
	global $InsAlmacenMovimientoSalida;
	global $InsFactura;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;

	$InsFichaAccion = new ClsFichaAccion();
	$InsFichaAccion->FccId = $GET_FccId;
	$InsFichaAccion->MtdObtenerFichaAccion();
		
	$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();
	
	
	$ResAlmacenMovimientoSalida = $InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalidas(NULL,NULL,NULL,'AmoTiempoCreacion','DESC','1',NULL,NULL,NULL,$InsFichaAccion->FccId,NULL,0,0,NULL,NULL,false,NULL);
	$ArrAlmacenMovimientoSalidas = $ResAlmacenMovimientoSalida['Datos'];
	
	if(!empty($ArrAlmacenMovimientoSalidas)){

		foreach($ArrAlmacenMovimientoSalidas as $DatAlmacenMovimientoSalida){
	
			$InsAlmacenMovimientoSalida->AmoId = $DatAlmacenMovimientoSalida->AmoId; 
			$InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalida();	
	
		}
			
	}
	
	$InsFichaIngreso = new ClsFichaIngreso();
	$InsFichaIngreso->FinId = $InsFichaAccion->FinId;
	$InsFichaIngreso->MtdObtenerFichaIngreso();

	$InsFactura->AmoId = $InsAlmacenMovimientoSalida->AmoId;
	$InsFactura->FccId = $InsFichaAccion->FccId;
	$InsFactura->FinId = $InsFichaIngreso->FinId;
	
	$InsFactura->CliId = $InsFichaIngreso->CliId;		
	$InsFactura->CliNombre = $InsFichaIngreso->CliNombre;
	$InsFactura->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
	$InsFactura->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
	
	$InsFactura->TdoId = $InsFichaIngreso->TdoId;
	$InsFactura->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
	$InsFactura->FacDireccion = $InsFichaIngreso->FinDireccion." - ".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliDepartamento;
	$InsFactura->FacTelefono = $InsFichaIngreso->FinTelefono;		
	
	$InsFactura->FacIncluyeImpuesto = $InsAlmacenMovimientoSalida->AmoIncluyeImpuesto;
	$InsFactura->FacEstado = 5;

	$InsFactura->FacObservacion = $InsAlmacenMovimientoSalida->AmoObservacion.chr(13).date("d/m/Y H:i:s")." - Factura autogenerada de Mov. Alm.:".$InsFactura->AmoId." / O.T.:".$InsFactura->FinId;
		
		//deb($InsAlmacenMovimientoSalida->FimObsequio);
	if($InsAlmacenMovimientoSalida->FimObsequio == 1){
		$InsFactura->FacObservacionImpresa = chr(13)."ESTE SERVICIO ES GRATUITO";
	}
	
	
	$InsFactura->MonId = $EmpresaMonedaId;		
	$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;

	if(!empty($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle)){
		foreach($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle as $DatAlmacenMovimientoSalidaDetalle){

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

			$ValorVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta;
			$Importe = $ValorVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;

			if($DatAlmacenMovimientoSalidaDetalle->RtiId == "RTI-10003"){

//				$ValorVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
//				$Importe = $ValorVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
				
				$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				$DatAlmacenMovimientoSalidaDetalle->ProNombre." ".$DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal,
				NULL,
				
				$ValorVenta,
				$DatAlmacenMovimientoSalidaDetalle->AmdCantidad,
				$Importe,					
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s"),
				$DatAlmacenMovimientoSalidaDetalle->AmdId,
			$DatAlmacenMovimientoSalidaDetalle->AmoId,
				NULL,
				"M",
				$DatAlmacenMovimientoSalidaDetalle->UmeAbreviacion
				);

			}else{
				
//				$ValorVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
//				$Importe = $ValorVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
//				
				$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				$DatAlmacenMovimientoSalidaDetalle->ProNombre." ".$DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal,
				NULL,
				$ValorVenta,
				$DatAlmacenMovimientoSalidaDetalle->AmdCantidad,
				$Importe,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s"),
				$DatAlmacenMovimientoSalidaDetalle->AmdId,
				$DatAlmacenMovimientoSalidaDetalle->AmoId,
				NULL,
				"R",
				$DatAlmacenMovimientoSalidaDetalle->UmeAbreviacion
				);	

			}

		}
	}else{
		

		if(!empty($InsFichaAccion->FichaAccionTarea)){
			foreach($InsFichaAccion->FichaAccionTarea as $DatFichaAccionTarea){

				$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				$DatFichaAccionTarea->FatDescripcion,
				NULL,
				0,
				1,
				0,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s"),
				0,
				0,
				NULL,
				"S",
				"UND"
				);	

			}
		}
		
	}

	if(!empty($InsFichaAccion->FccManoObra)){

		$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
		NULL,
		"MANO DE OBRA",
		NULL,
		//($InsFichaAccion->FccManoObra/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1)),
		($InsFichaAccion->FccManoObra),
		1,
//		($InsFichaAccion->FccManoObra/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1)),
		($InsFichaAccion->FccManoObra),
		date("d/m/Y H:i:s"),
		date("d/m/Y H:i:s"),
		NULL,
		NULL,
		NULL,
		"S",
		NULL
		);

	}
	
//	deb($InsAlmacenMovimientoSalida->AmoDescuento);
	if(!empty($InsAlmacenMovimientoSalida->AmoDescuento)){

		$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
		NULL,
		"DESCUENTO",
		NULL,
		//($InsAlmacenMovimientoSalida->AmoDescuento/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1)*-1),
		($InsAlmacenMovimientoSalida->AmoDescuento*-1),
		1,
//		($InsAlmacenMovimientoSalida->AmoDescuento/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1)*-1),
		($InsAlmacenMovimientoSalida->AmoDescuento*-1),
		date("d/m/Y H:i:s"),
		date("d/m/Y H:i:s"),
		NULL,
		NULL,
		NULL,
		"R",
		NULL
		);

	}


}





function FncCargarAlmacenMovimientoSalidaDatos(){
	
	global $GET_AmoId;
	global $Identificador;
	global $InsAlmacenMovimientoSalida;
	global $InsFactura;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;

	$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();

	$InsAlmacenMovimientoSalida->AmoId = $GET_AmoId;
	$InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalida();	
	
	$InsFichaIngreso = new ClsFichaIngreso();
	$InsFichaIngreso->FinId = $InsAlmacenMovimientoSalida->FinId;
	$InsFichaIngreso->MtdObtenerFichaIngreso();

	$InsFactura->AmoId = $InsAlmacenMovimientoSalida->AmoId;
	$InsFactura->FinId = $InsFichaIngreso->FinId;
	
	$InsFactura->CliId = $InsFichaIngreso->CliId;		
	$InsFactura->CliNombre = $InsFichaIngreso->CliNombre;
	$InsFactura->CliApellidoPaterno = $InsFichaIngreso->CliApellidoPaterno;
	$InsFactura->CliApellidoMaterno = $InsFichaIngreso->CliApellidoMaterno;
	
	$InsFactura->TdoId = $InsFichaIngreso->TdoId;
	$InsFactura->CliNumeroDocumento = $InsFichaIngreso->CliNumeroDocumento;
	//$InsFactura->FacDireccion = $InsFichaIngreso->FinDireccion;
	$InsFactura->FacDireccion = $InsFichaIngreso->FinDireccion." - ".$InsFichaIngreso->CliDistrito." - ".$InsFichaIngreso->CliProvincia." - ".$InsFichaIngreso->CliDepartamento;
	
	$InsFactura->FacTelefono = $InsFichaIngreso->FinTelefono;	
	$InsFactura->FacIncluyeImpuesto = $InsAlmacenMovimientoSalida->AmoIncluyeImpuesto;	
	$InsFactura->FacEstado = 5;

	$InsFactura->FacObservacion = $InsAlmacenMovimientoSalida->AmoObservacion.chr(13).date("d/m/Y H:i:s")." - Factura autogenerada de Mov. Alm.:".$InsFactura->AmoId." / O.T.:".$InsFactura->FinId;
	
	if($InsAlmacenMovimientoSalida->FimObsequio == 1){
		$InsFactura->FacObservacionImpresa = chr(13)."ESTE SERVICIO ES GRATUITO";
	}
		
	$InsFactura->MonId = $EmpresaMonedaId;		
	$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;

	//$ArrSuministros = array();
	
	if(!empty($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle)){
		foreach($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle as $DatAlmacenMovimientoSalidaDetalle){

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

			$ValorVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta;
			$Importe = $ValorVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
				
				
			if($DatAlmacenMovimientoSalidaDetalle->RtiId == "RTI-10003"){
//
//				$ValorVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
//				$Importe = $ValorVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
				
				
					$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
					NULL,
					$DatAlmacenMovimientoSalidaDetalle->ProNombre." ".$DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal,
					NULL,
					
					$ValorVenta,
					$DatAlmacenMovimientoSalidaDetalle->AmdCantidad,
					$Importe,					
					date("d/m/Y H:i:s"),
					date("d/m/Y H:i:s"),
					$DatAlmacenMovimientoSalidaDetalle->AmdId,
				$DatAlmacenMovimientoSalidaDetalle->AmoId,
					NULL,
					"M",
					$DatAlmacenMovimientoSalidaDetalle->UmeAbreviacion
					);

			}else{
				
				//$ValorVenta = $DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
//				$Importe = $ValorVenta * $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
				
				$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
				NULL,
				$DatAlmacenMovimientoSalidaDetalle->ProNombre." ".$DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal,
				NULL,
				$ValorVenta,
				$DatAlmacenMovimientoSalidaDetalle->AmdCantidad,
				$Importe,
				date("d/m/Y H:i:s"),
				date("d/m/Y H:i:s"),
				$DatAlmacenMovimientoSalidaDetalle->AmdId,
				$DatAlmacenMovimientoSalidaDetalle->AmoId,
				NULL,
				"R",
				$DatAlmacenMovimientoSalidaDetalle->UmeAbreviacion
				);	

				//$ArrSuministros[] = $DatAlmacenMovimientoSalidaDetalle;

			}

		}
	}else{
		//$Resultado.='#ERR_FAC_603';
	}

//	if(!empty($ArrSuministros)){
//
////		$Importe = 0;
////
////		foreach($ArrSuministros as $DatSuministro){
////			$Importe += $DatSuministro->AmdImporte;
////		}
////
////		$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
////		NULL,
////		"MATERIALES",
////		NULL,
////		
////		($Importe/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1)),
////		//$Importe,
////		1,
////		($Importe/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1)),
////		date("d/m/Y H:i:s"),
////		date("d/m/Y H:i:s"),
////		NULL,
////		NULL,
////		NULL,
////		"M",
////		NULL
////		);
//
//
//	}
	
	
	if(!empty($InsAlmacenMovimientoSalida->FccManoObra)){

		$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
		NULL,
		"MANO DE OBRA",
		NULL,
//		($InsAlmacenMovimientoSalida->FccManoObra/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1)),
		($InsAlmacenMovimientoSalida->FccManoObra),
		1,
		//($InsAlmacenMovimientoSalida->FccManoObra/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1)),
		($InsAlmacenMovimientoSalida->FccManoObra),
		date("d/m/Y H:i:s"),
		date("d/m/Y H:i:s"),
		NULL,
		NULL,
		NULL,
		"S",
		NULL
		);

	}
	
	
	

}



function FncCargarVentaConcretadaDatos(){

	global $GET_VcoId;
	global $Identificador;
	global $InsVentaConcretada;
	global $InsFactura;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;
	

	$InsVentaConcretada = new ClsVentaConcretada();
	
	$InsVentaConcretada->VcoId = $GET_VcoId;	
	$InsVentaConcretada->MtdObtenerVentaConcretada();	

	$InsFactura->AmoId = $InsVentaConcretada->VcoId;
	$InsFactura->CprId = $InsVentaConcretada->CprId;
	
	$InsFactura->CliId = $InsVentaConcretada->CliId;		
	$InsFactura->CliNombre = $InsVentaConcretada->CliNombre;
	$InsFactura->CliApellidoPaterno = $InsVentaConcretada->CliApellidoPaterno;
	$InsFactura->CliApellidoMaterno = $InsVentaConcretada->CliApellidoMaterno;
	
	$InsFactura->TdoId = $InsVentaConcretada->TdoId;
	$InsFactura->CliNumeroDocumento = $InsVentaConcretada->CliNumeroDocumento;
	$InsFactura->FacDireccion = $InsVentaConcretada->VcoDireccion." - ".$InsVentaConcretada->CliDistrito." - ".$InsVentaConcretada->CliProvincia." - ".$InsVentaConcretada->CliDepartamento;
	
	
	$InsFactura->FacTelefono = $InsVentaConcretada->VcoTelefono;	
	$InsFactura->FacIncluyeImpuesto = $InsVentaConcretada->VcoIncluyeImpuesto;	
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

	///$InsFactura->FacIncluyeImpuesto = 2;
	$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	
	if(!empty($InsVentaConcretada->VentaConcretadaDetalle)){
		foreach($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle){

			if($InsFactura->MonId<>$EmpresaMonedaId ){
				$DatVentaConcretadaDetalle->VcdPrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta  / $InsFactura->FacTipoCambio,2);
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
*/
			
			//$ValorVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1);
//			$Importe = $ValorVenta * $DatVentaConcretadaDetalle->VcdCantidad;

			$ValorVenta = $DatVentaConcretadaDetalle->VcdPrecioVenta;
			$Importe = $ValorVenta * $DatVentaConcretadaDetalle->VcdCantidad;

			$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			$DatVentaConcretadaDetalle->ProNombre." ".$DatVentaConcretadaDetalle->ProCodigoOriginal,
			NULL,
			$ValorVenta,
			$DatVentaConcretadaDetalle->VcdCantidad,
			$Importe,
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s"),
			$DatVentaConcretadaDetalle->VcdId,
			$DatVentaConcretadaDetalle->VcoId,
			NULL,
			"R",
			$DatVentaConcretadaDetalle->UmeAbreviacion
			);
			
			
		}		
	}
	
	if(!empty($InsVentaConcretada->VcoDescuento)){

//		$InsVentaConcretada->VcoDescuento = $InsVentaConcretada->VcoDescuento/(($InsFactura->FacPorcentajeImpuestoVenta/100)+1);

		if($InsFactura->MonId<>$EmpresaMonedaId ){
			$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento  / $InsFactura->FacTipoCambio,2);
		}

		$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
		NULL,
		"DESCUENTO",
		NULL,
		$InsVentaConcretada->VcoDescuento*-1,
		1,
		$InsVentaConcretada->VcoDescuento*-1,
		date("d/m/Y H:i:s"),
		date("d/m/Y H:i:s"),
		NULL,
		NULL,
		NULL,
		"S",
		NULL
		);
				
	}
	
}


function FncCargarOrdenVentaVehiculoDatos(){
	
	
	global $GET_OvvId;
	global $Identificador;
	global $InsOrdenVentaVehiculo;
	global $InsOrdenVentaVehiculo;
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;
	global $InsFactura;
	
	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
	
	$InsOrdenVentaVehiculo->OvvId = $GET_OvvId;	
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();	

	$InsFactura->OvvId = $InsOrdenVentaVehiculo->OvvId;
	$InsFactura->CveId = $InsOrdenVentaVehiculo->CveId;
	
	$InsFactura->CliId = $InsOrdenVentaVehiculo->CliId;		
	$InsFactura->CliNombre = $InsOrdenVentaVehiculo->CliNombre;
	$InsFactura->CliApellidoPaterno = $InsOrdenVentaVehiculo->CliApellidoPaterno;
	$InsFactura->CliApellidoMaterno = $InsOrdenVentaVehiculo->CliApellidoMaterno;
	
	$InsFactura->TdoId = $InsOrdenVentaVehiculo->TdoId;
	$InsFactura->CliNumeroDocumento = $InsOrdenVentaVehiculo->CliNumeroDocumento;
	$InsFactura->FacDireccion = $InsOrdenVentaVehiculo->CliDireccion." - ".$InsOrdenVentaVehiculo->CliDistrito." - ".$InsOrdenVentaVehiculo->CliProvincia." - ".$InsOrdenVentaVehiculo->CliDepartamento;
	
	$InsFactura->FacTelefono = $InsOrdenVentaVehiculo->CliTelefono;		
	$InsFactura->FacIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;	
	$InsFactura->FacEstado = 5;

	$InsFactura->FacObservacion = $InsOrdenVentaVehiculo->OvvObservacion.chr(13).date("d/m/Y H:i:s")." - Factura autogenerada de Ord. Ven. Veh.: ".$InsFactura->OvvId." / Prof. Veh: ".$InsFactura->CveId;
	
	
	$InsFactura->MonId = $InsOrdenVentaVehiculo->MonId;		
	$InsFactura->FacTipoCambio = $InsOrdenVentaVehiculo->VcoTipoCambio;		

	$InsFactura->FacIncluyeImpuesto = $InsOrdenVentaVehiculo->OvvIncluyeImpuesto;		
	$InsFactura->FacPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;

	
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

Parametro14 = OvvId
*/		
//	if($InsFactura->FacIncluyeImpuesto == 2){
//		$ValorVenta = $InsOrdenVentaVehiculo->OvvSubTotal;
//	}else{
//		$ValorVenta = $InsOrdenVentaVehiculo->OvvSubTotal;
//	}
	$ValorVenta = $InsOrdenVentaVehiculo->OvvTotal;
	$Importe = $ValorVenta;
	
	$_SESSION['InsFacturaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
	NULL,
	$InsOrdenVentaVehiculo->VmaNombre." ".$InsOrdenVentaVehiculo->VmoNombre." ".$InsOrdenVentaVehiculo->VveNombre,
	NULL,
	$ValorVenta,
	1,
	$Importe,
	date("d/m/Y H:i:s"),
	date("d/m/Y H:i:s"),
	NULL,
	NULL,
	NULL,
	"V",
	"Unidad",
	
	$InsOrdenVentaVehiculo->OvvId
	);
	
}

?>