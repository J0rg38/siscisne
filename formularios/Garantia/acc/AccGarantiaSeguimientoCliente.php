<?php

//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;	
	
	$InsGarantia->UsuId = $_SESSION['SesionId'];
	
	$InsGarantia->GarId = $_POST['CmpId'];
	$InsGarantia->FccId = $_POST['CmpFichaAccionId'];

	$InsGarantia->GarFechaEmision = FncCambiaFechaAMysql($_POST['CmpFecha']);	
	$InsGarantia->GarFechaVenta = FncCambiaFechaAMysql($_POST['CmpFechaVenta'],true);	
	
	list($InsGarantia->GarAno,$InsGarantia->GarMes,$aux) = explode("-",$InsGarantia->GarFechaEmision);
	
	$InsGarantia->GarCausa = addslashes($_POST['CmpCausa']);
	$InsGarantia->GarSolucion = addslashes($_POST['CmpSolucion']);
	
	$InsGarantia->CliId = $_POST['CmpClienteId'];
	$InsGarantia->CliNombre = $_POST['CmpClienteNombre'];
	$InsGarantia->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsGarantia->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsGarantia->GarDireccion = $_POST['CmpClienteDireccion'];
	$InsGarantia->GarCiudad = $_POST['CmpClienteCiudad'];
	
	$InsGarantia->GarTelefono = $_POST['CmpClienteTelefono'];
	$InsGarantia->GarCelular = $_POST['CmpClienteCelular'];
	
	$InsGarantia->MonId = $_POST['CmpMonedaId'];
	$InsGarantia->GarTipoCambio = $_POST['CmTipoCambio'];
	$InsGarantia->GarPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	
	$InsGarantia->FinId = $_POST['CmpFichaIngresoId'];
	$InsGarantia->FinVehiculoKilometraje = $_POST['CmpFichaIngresoVehiculoKilometraje'];
	$InsGarantia->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	
	$InsGarantia->VmaId = $_POST['CmpVehiculoIngresoMarcaId'];
	$InsGarantia->VmoId = $_POST['CmpVehiculoIngresoModeloId'];	
	
	$InsGarantia->VmaNombre = $_POST['CmpVehiculoIngresoMarca'];
	$InsGarantia->VmoNombre = $_POST['CmpVehiculoIngresoModelo'];
	$InsGarantia->GarModelo = $_POST['CmpVehiculoIngresoModelo'];
	$InsGarantia->EinPlaca = $_POST['CmpVehiculoIngresoPlaca'];

	$InsGarantia->EinId = $_POST['CmpVehiculoIngresoId'];	

	$InsGarantia->GarObservacion = addslashes($_POST['CmpObservacion']);
	$InsGarantia->GarObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsGarantia->GarTarifaAutorizada = preg_replace("/,/", "", $_POST['CmpTarifaAutorizada']);
	
	$InsGarantia->GarEstado = $_POST['CmpEstado'];
	$InsGarantia->GarTiempoCreacion = date("Y-m-d H:i:s");
	$InsGarantia->GarTiempoModificacion = date("Y-m-d H:i:s");

	$InsGarantia->GarSubTotalRepuestoStock = 0;
	$InsGarantia->GarFactorPorcentaje1 = 0;
	$InsGarantia->GarSubTotalRepuestoOtro = 0;
	$InsGarantia->GarFactorPorcentaje2 = 0;

	$InsGarantia->GarTotalRepuesto = 0;
	$InsGarantia->GarTotalManoObra = 0;

	$InsGarantia->GarSubTotal = 0;
	$InsGarantia->GarImpuesto = 0;
	$InsGarantia->GarTotal = 0;

	$InsGarantia->GarTransaccionFecha = FncCambiaFechaAMysql($_POST['CmpTransaccionFecha'],true);
	$InsGarantia->GarTransaccionNumero = $_POST['CmpTransaccionNumero'];	
	$InsGarantia->GarObservacionFinal = addslashes($_POST['CmpObservacionFinal']);	
	
	$InsGarantia->GarNumeroComprobante = $_POST['CmpNumeroComprobante'];	

	
	$ResGarantiaLlamada = $_SESSION['InsGarantiaLlamada'.$Identificador]->MtdObtenerSesionObjetos(false);

	if(!empty($ResGarantiaLlamada['Datos'])){
		foreach($ResGarantiaLlamada['Datos'] as $DatSesionObjeto){

			//SesionObjeto-InsGarantiaLlamada
			//Parametro1 = GllId
			//Parametro2 = 
			//Parametro3 = GllFecha
			//Parametro4 = 
			//Parametro5 = GllObservacion
			//Parametro6 = GllEstado
			//Parametro7 = GllTiempoCreacion
			//Parametro8 = GllTiempoModificacion
	
			$InsGarantiaLlamada1 = new ClsGarantiaLlamada();
			$InsGarantiaLlamada1->GllId = $DatSesionObjeto->Parametro1;
			$InsGarantiaLlamada1->GllFecha = FncCambiaFechaAMysql($DatSesionObjeto->Parametro3);
			$InsGarantiaLlamada1->GllObservacion = $DatSesionObjeto->Parametro5;
			$InsGarantiaLlamada1->GllEstado = $DatSesionObjeto->Parametro6;
			$InsGarantiaLlamada1->GllTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsGarantiaLlamada1->GllTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsGarantiaLlamada1->GllEliminado = $DatSesionObjeto->Eliminado;				
			$InsGarantiaLlamada1->InsMysql = NULL;
			
			$InsGarantia->GarantiaLlamada[] = $InsGarantiaLlamada1;		
			
			if($InsGarantiaLlamada1->GllEliminado==1){					
				
			}

		}

	}
	
	

	$InsGarantia->GarTotalRepuesto = $InsGarantia->GarSubTotalRepuestoStock;
	$InsGarantia->GarSubTotal = $InsGarantia->GarTotalRepuesto + $InsGarantia->GarTotalManoObra;
	$InsGarantia->GarImpuesto = $InsGarantia->GarSubTotal * ($InsGarantia->GarPorcentajeImpuestoVenta/100);
	$InsGarantia->GarTotal = $InsGarantia->GarSubTotal + $InsGarantia->GarImpuesto;

	if($Guardar){

		if($InsGarantia->MtdSeguimientoClienteGarantia()){
			
			
				if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
				}
				
				
			$Edito = true;
			$Resultado.='#SAS_GAR_106';
		}else{
			$Resultado.='#ERR_GAR_106';
		}

	}	
	
	$InsGarantia->GarFechaEmision = FncCambiaFechaANormal($InsGarantia->GarFechaEmision);		
	$InsGarantia->GarFechaVenta = FncCambiaFechaANormal($InsGarantia->GarFechaVenta,true);	
	$InsGarantia->GarTransaccionFecha = FncCambiaFechaANormal($InsGarantia->GarTransaccionFecha,true);	
		
}else{

	FncCargarDatos();
}


function FncCargarDatos(){

	global $InsGarantia;
	global $Identificador;
	
	global $GET_Id;

	unset($_SESSION['InsGarantiaLlamada'.$Identificador]);
			
	$_SESSION['InsGarantiaLlamada'.$Identificador] = new ClsSesionObjeto();	

	$InsGarantia->GarId = $GET_Id;
	$InsGarantia->MtdObtenerGarantia();
	
	//SesionObjeto-InsGarantiaLlamada
	//Parametro1 = GllId
	//Parametro2 = 
	//Parametro3 = GllFecha
	//Parametro4 = 
	//Parametro5 = GllObseracion
	//Parametro6 = GllEstado
	//Parametro7 = GllTiempoCreacion
	//Parametro8 = GllTiempoModificacion
		
	if(!empty($InsGarantia->GarantiaLlamada)){
		foreach($InsGarantia->GarantiaLlamada as $DatGarantiaLlamada){					
	
			$_SESSION['InsGarantiaLlamada'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatGarantiaLlamada->GllId,
			NULL,
			FncCambiaFechaANormal($DatGarantiaLlamada->GllFecha),	
			NULL,
			$DatGarantiaLlamada->GllObservacion,
			$DatGarantiaLlamada->GllEstado,
			($DatGarantiaLlamada->GllTiempoCreacion),
			($DatGarantiaLlamada->GllTiempoModificacion)
			);

		}
	}
	
	
	

}

?>

