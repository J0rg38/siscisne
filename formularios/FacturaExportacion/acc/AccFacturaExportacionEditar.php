<?php
//Si se hizo click en guardar	

if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	//$Identificador = $_POST['Identificador'];
	
	$Resultado = '';
	$Guardar = true;

	$InsFacturaExportacion->FexId = $_POST['CmpId'];
	
	$InsFacturaExportacion->UsuId = $_SESSION['SesionId'];
	$InsFacturaExportacion->SucId = $_SESSION['SisSucId'];
	
	$InsFacturaExportacion->FetId = $_POST['CmpTalonario'];	
	$InsFacturaExportacion->CliId = $_POST['CmpClienteId'];	

	$InsFacturaExportacion->NpaId = $_POST['CmpCondicionPago'];	
	$InsFacturaExportacion->FexCantidadDia = isset($_POST['CmpCantidadDia'])?$_POST['CmpCantidadDia']:0;

	$InsFacturaExportacion->MonId = $_POST['CmpMonedaId'];
	$InsFacturaExportacion->FexTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsFacturaExportacion->FexObsequio = $_POST['CmpObsequio'];
	$InsFacturaExportacion->FexEstado = $_POST['CmpEstado'];			
	$InsFacturaExportacion->FexFechaEmision = FncCambiaFechaAMysql($_POST['CmpFechaEmision']);
	$InsFacturaExportacion->FexPorcentajeImpuestoVenta = ($_POST['CmpPorcentajeImpuestoVenta']);
	$InsFacturaExportacion->FexObservacion = $_POST['CmpObservacion']."###".$_POST['CmpObservacionImpresa'];
	$InsFacturaExportacion->FexCierre = $_POST['CmpCierre'];
	$InsFacturaExportacion->FexTiempoModificacion = date("Y-m-d H:i:s");
	$InsFacturaExportacion->FexEliminado = 1;
	
	$InsFacturaExportacion->CliNombre = $_POST['CmpClienteNombre'];
	$InsFacturaExportacion->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsFacturaExportacion->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsFacturaExportacion->CliTelefono = $_POST['CmpClienteTelefono'];
	$InsFacturaExportacion->CliEmail = $_POST['CmpClienteEmail'];
	$InsFacturaExportacion->CliCelular = $_POST['CmpClienteCelular'];
	$InsFacturaExportacion->CliFax = $_POST['CmpClienteFax'];	

	$InsFacturaExportacion->FexDireccion = $_POST['CmpClienteDireccion'];	

	$InsFacturaExportacion->FexRegimenComprobanteNumero = $_POST['CmpRegimenComprobanteNumero'];
	$InsFacturaExportacion->FexRegimenComprobanteFecha = FncCambiaFechaAMysql($_POST['CmpRegimenComprobanteFecha'],true);	
	$InsFacturaExportacion->RegId = $_POST['CmpRegimenId'];	
	$InsFacturaExportacion->RegAplicacion = $_POST['CmpRegimenAplicacion'];	
	$InsFacturaExportacion->FexRegimenPorcentaje = $_POST['CmpRegimenPorcentaje'];
	$InsFacturaExportacion->FexRegimenMonto = eregi_replace(",","",$_POST['CmpRegimenMonto']);
	
	if($InsFacturaExportacion->MonId<>$EmpresaMonedaId and !empty($InsFacturaExportacion->FexTipoCambio)){
		$InsFacturaExportacion->FexRegimenMonto = $InsFacturaExportacion->FexRegimenMonto * $InsFacturaExportacion->FexTipoCambio;
	}
		
	$InsFacturaExportacion->FinId = $_POST['CmpFichaIngresoId'];
	$InsFacturaExportacion->AmoId = $_POST['CmpAlmacenMovimientoSalidaId'];
	$InsFacturaExportacion->FccId = $_POST['CmpFichaAccionId'];
	$InsFacturaExportacion->CprId = $_POST['CmpCotizacionProductoId'];

	$InsFacturaExportacion->OvvId = $_POST['CmpOrdenVentaVehiculoId'];
	$InsFacturaExportacion->CveId = $_POST['CmpCotizacionVehiculoId'];
		
	$InsFacturaExportacion->FacturaExportacionDetalle = array();	
	
	if($InsFacturaExportacion->MonId<>$EmpresaMonedaId){
		if(empty($InsFacturaExportacion->FexTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_FEX_600';
		}
	}
	
	
/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FedId
Parametro2 = FedDescripcion
Parametro3
Parametro4 = FedPrecio
Parametro5 = FedCantidad
Parametro6 = FedImporte
Parametro7 = FedTiempoCreacion
Parametro8 = FedTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FedTipo
Parametro13 = FedUnidadMedida
*/
	$InsFacturaExportacion->FexTotalBruto = 0;
	$InsFacturaExportacion->FexSubTotal = 0;
	$InsFacturaExportacion->FexImpuesto = 0;
	$InsFacturaExportacion->FexTotal = 0;

	$ResFacturaExportacionDetalle = $_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResFacturaExportacionDetalle['Datos'])){
		foreach($ResFacturaExportacionDetalle['Datos'] as $DatSesionObjeto){
		
			$InsFacturaExportacionDetalle1 = new ClsFacturaExportacionDetalle();
			$InsFacturaExportacionDetalle1->FedId = $DatSesionObjeto->Parametro1;			
			$InsFacturaExportacionDetalle1->AmdId = $DatSesionObjeto->Parametro9;
			$InsFacturaExportacionDetalle1->FedDescripcion = utf8_encode(htmlentities($DatSesionObjeto->Parametro2));
			
			
			$InsFacturaExportacionDetalle1->FedTipo = $DatSesionObjeto->Parametro12;

			if($InsFacturaExportacion->MonId<>$EmpresaMonedaId and !empty($InsFacturaExportacion->FexTipoCambio)){
				$InsFacturaExportacionDetalle1->FedPrecio = $DatSesionObjeto->Parametro4 * $InsFacturaExportacion->FexTipoCambio;
			}else{
				$InsFacturaExportacionDetalle1->FedPrecio = $DatSesionObjeto->Parametro4;
			}

			$InsFacturaExportacionDetalle1->FedCantidad = $DatSesionObjeto->Parametro5;

			if($InsFacturaExportacion->MonId<>$EmpresaMonedaId and !empty($InsFacturaExportacion->FexTipoCambio)){
				$InsFacturaExportacionDetalle1->FedImporte = $DatSesionObjeto->Parametro6 * $InsFacturaExportacion->FexTipoCambio;
			}else{
				$InsFacturaExportacionDetalle1->FedImporte = $DatSesionObjeto->Parametro6;
			}

			$InsFacturaExportacionDetalle1->FedUnidadMedida = ($DatSesionObjeto->Parametro13);
			$InsFacturaExportacionDetalle1->FedTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsFacturaExportacionDetalle1->FedTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsFacturaExportacionDetalle1->FedEliminado = $DatSesionObjeto->Eliminado;				
			$InsFacturaExportacionDetalle1->InsMysql = NULL;

			$InsFacturaExportacion->FacturaExportacionDetalle[] = $InsFacturaExportacionDetalle1;	

			if($InsFacturaExportacionDetalle1->FedEliminado==1){		
				$InsFacturaExportacion->FexTotalBruto += $InsFacturaExportacionDetalle1->FedImporte;
			}

		}	
	}else{
		$Guardar = false;
		$Resultado.='#ERR_FEX_603';		
	}
	
	$InsFacturaExportacion->FexTotal = round($InsFacturaExportacion->FexTotalBruto,6);
	$InsFacturaExportacion->FexSubTotal = round(($InsFacturaExportacion->FexTotal/(($InsFacturaExportacion->FexPorcentajeImpuestoVenta/100)+1)),6);
	$InsFacturaExportacion->FexImpuesto = round($InsFacturaExportacion->FexTotal - $InsFacturaExportacion->FexSubTotal,6);

		if(!empty($InsFacturaExportacion->RegId)){
		if($InsFacturaExportacion->RegAplicacion==1){
			$InsFacturaExportacion->FexTotalReal = $InsFacturaExportacion->FexTotal - $InsFacturaExportacion->FexRegimenMonto;
	
		}elseif($InsFacturaExportacion->RegAplicacion == 2){
			$InsFacturaExportacion->FexTotalReal = $InsFacturaExportacion->FexTotal + $InsFacturaExportacion->FexRegimenMonto;					
		}
	}else{
		$InsFacturaExportacion->FexTotalReal = $InsFacturaExportacion->FexTotal;
	}	
	
	if($Guardar){
		if($InsFacturaExportacion->MtdEditarFacturaExportacion()){		
			$Resultado.='#SAS_FEX_102';
			$Edito = true;
	
			FncCargarDatos();
	
		} else{
			$Resultado.='#ERR_FEX_102';
	
			$InsFacturaExportacion->FexFechaEmision = FncCambiaFechaANormal($InsFacturaExportacion->FexFechaEmision);
			$InsFacturaExportacion->FexRegimenComprobanteFecha = FncCambiaFechaANormal($InsFacturaExportacion->FexRegimenComprobanteFecha,true);
			list($InsFacturaExportacion->FexObservacion,$InsFacturaExportacion->FexObservacionImpresa) = explode("###",$InsFacturaExportacion->FexObservacion);

			if($InsFacturaExportacion->MonId<>$EmpresaMonedaId and !empty($InsFacturaExportacion->FexTipoCambio)){
				$InsFacturaExportacion->FexRegimenMonto = round($InsFacturaExportacion->FexRegimenMonto / $InsFacturaExportacion->FexTipoCambio,2);
			}
	
		}		
	}else{
			$InsFacturaExportacion->FexFechaEmision = FncCambiaFechaANormal($InsFacturaExportacion->FexFechaEmision);
			$InsFacturaExportacion->FexRegimenComprobanteFecha = FncCambiaFechaANormal($InsFacturaExportacion->FexRegimenComprobanteFecha,true);
			list($InsFacturaExportacion->FexObservacion,$InsFacturaExportacion->FexObservacionImpresa) = explode("###",$InsFacturaExportacion->FexObservacion);		

			if($InsFacturaExportacion->MonId<>$EmpresaMonedaId and !empty($InsFacturaExportacion->FexTipoCambio)){
				$InsFacturaExportacion->FexRegimenMonto = round($InsFacturaExportacion->FexRegimenMonto / $InsFacturaExportacion->FexTipoCambio,2);
			}
	}
	
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){

	global $GET_id;
	global $GET_ta;
	global $Identificador;	
	global $InsFacturaExportacion;	

	unset($_SESSION['InsFacturaExportacionDetalle'.$Identificador]);
	unset($_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]);

	$InsFacturaExportacion = new ClsFacturaExportacion();
	
	$_SESSION['InsFacturaExportacionDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador] = new ClsSesionObjeto();

	$InsFacturaExportacion->FexId = $GET_id;
	$InsFacturaExportacion->FetId = $GET_ta;
	$InsFacturaExportacion = $InsFacturaExportacion->MtdObtenerFacturaExportacion();		

	if($InsFacturaExportacion->MonId<>$EmpresaMonedaId and !empty($InsFacturaExportacion->FexTipoCambio)){
		$InsFacturaExportacion->FexRegimenMonto = round($InsFacturaExportacion->FexRegimenMonto/$InsFacturaExportacion->FexTipoCambio,2);
	}
		
	if(is_array($InsFacturaExportacion->FacturaExportacionDetalle)){
		foreach($InsFacturaExportacion->FacturaExportacionDetalle as $DatFacturaExportacionDetalle){
			
/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FedId
Parametro2 = FedDescripcion
Parametro3
Parametro4 = FedPrecio
Parametro5 = FedCantidad
Parametro6 = FedImporte
Parametro7 = FedTiempoCreacion
Parametro8 = FedTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FedTipo
Parametro13 = FedUnidadMedida
*/

			if($InsFacturaExportacion->MonId<>$EmpresaMonedaId and (!empty($InsFacturaExportacion->FexTipoCambio) )){
				$DatFacturaExportacionDetalle->FedImporte = ($DatFacturaExportacionDetalle->FedImporte / $InsFacturaExportacion->FexTipoCambio);
				$DatFacturaExportacionDetalle->FedPrecio = ($DatFacturaExportacionDetalle->FedPrecio  / $InsFacturaExportacion->FexTipoCambio);
			}
			
			$_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatFacturaExportacionDetalle->FedId,
			$DatFacturaExportacionDetalle->FedDescripcion,
			NULL,
			($DatFacturaExportacionDetalle->FedPrecio),
			($DatFacturaExportacionDetalle->FedCantidad),
			($DatFacturaExportacionDetalle->FedImporte),
			($DatFacturaExportacionDetalle->FedTiempoCreacion),			
			($DatFacturaExportacionDetalle->FedTiempoModificacion),
			$DatFacturaExportacionDetalle->AmdId,
			$DatFacturaExportacionDetalle->AmoId,
			NULL,
			$DatFacturaExportacionDetalle->FedTipo,
			$DatFacturaExportacionDetalle->FedUnidadMedida,
			$DatFacturaExportacionDetalle->VcdReingreso
			);
		
		}
	}
	
	
	
	if(!empty($InsFacturaExportacion->FacturaExportacionAlmacenMovimiento)){
		foreach($InsFacturaExportacion->FacturaExportacionAlmacenMovimiento as $DatFacturaExportacionAlmacenMovimiento){

			$_SESSION['InsFacturaExportacionAlmacenMovimiento'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatFacturaExportacionAlmacenMovimiento->FeaId,
			$DatFacturaExportacionAlmacenMovimiento->AmoId,
			NULL,
			NULL,
			1,
			date("d/m/Y H:i:s"),
			date("d/m/Y H:i:s")
			);

		}
	}

	

}
?>