<?php
//Si se hizo click en guardar		
//deb($_POST[);	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	
	$Resultado = '';
	
	$InsVehiculoIngreso->UsuId = $_SESSION['SesionId'];	
	
	$InsVehiculoIngreso->EinId = $_POST['CmpId'];
	$InsVehiculoIngreso->CliId = $_POST['CmpClienteId2'];
	$InsVehiculoIngreso->OncId = $_POST['CmpConcesionario'];

	$InsVehiculoIngreso->EinVIN = $_POST['CmpVIN'];

	$InsVehiculoIngreso->VmaId = $_POST['CmpVehiculoMarca'];
	$InsVehiculoIngreso->VmoId = $_POST['CmpVehiculoModelo'];
	$InsVehiculoIngreso->VveId = $_POST['CmpVehiculoVersion'];
	$InsVehiculoIngreso->VehId = $_POST['CmpVehiculoColor'];
	
	$InsVehiculoIngreso->EinAnoFabricacion = (empty($_POST['CmpAnoFabricacion'])?0:$_POST['CmpAnoFabricacion']);
	$InsVehiculoIngreso->EinAnoModelo = (empty($_POST['CmpAnoModelo'])?0:$_POST['CmpAnoModelo']);
	$InsVehiculoIngreso->EinNumeroMotor = $_POST['CmpNumeroMotor'];
	
	$InsVehiculoIngreso->EinTransmision = $_POST['CmpTransmision'];
	
	$InsVehiculoIngreso->EinColor = $_POST['CmpColor'];
	$InsVehiculoIngreso->EinDUA = $_POST['CmpDUA'];
	$InsVehiculoIngreso->EinGuiaTransporte = $_POST['CmpGuiaTransporte'];
	$InsVehiculoIngreso->EinCodigoBarra = $_POST['CmpCodigoBarra'];
	$InsVehiculoIngreso->EinGuiaRemision = $_POST['CmpGuiaRemision'];
	$InsVehiculoIngreso->EinPlaca = $_POST['CmpPlaca'];

	$InsVehiculoIngreso->EinPoliza = $_POST['CmpPoliza'];	
	$InsVehiculoIngreso->EinZofra = $_POST['CmpZofra'];	
	$InsVehiculoIngreso->EinNacionalizado = $_POST['CmpNacionalizado'];	
	
	
	$InsVehiculoIngreso->VprCodigo = $_POST['CmpProformaCodigo'];	
	$InsVehiculoIngreso->VprAno = $_POST['CmpProformaAno'];
	$InsVehiculoIngreso->VprMes = $_POST['CmpProformaMes'];
	
	$InsVehiculoIngreso->VpdCosto = preg_replace("/,/", "", (empty($_POST['CmpProformaDetalleCosto'])?0:$_POST['CmpProformaDetalleCosto']));
	$InsVehiculoIngreso->VehiculoProformaMonId = $_POST['CmpProformaMonedaId'];
	$InsVehiculoIngreso->VprTipoCambio = $_POST['CmpProformaTipoCambio'];
	
	
	if($InsVehiculoIngreso->VehiculoProformaMonId<>$EmpresaMonedaId ){
		
		$InsVehiculoIngreso->VpdCosto = round($InsVehiculoIngreso->VpdCosto * $InsVehiculoIngreso->VprTipoCambio,3);
	}
	
	
	$InsVehiculoIngreso->EinComprobanteCompraNumero = $_POST['CmpComprobanteCompraNumero'];	
	
	$InsVehiculoIngreso->EinComprobanteCompraNumeroNumero = $_POST['CmpComprobanteCompraNumeroNumero'];
	$InsVehiculoIngreso->EinComprobanteCompraNumeroSerie = $_POST['CmpComprobanteCompraNumeroSerie'];
	$InsVehiculoIngreso->EinComprobanteCompraNumero = $InsVehiculoIngreso->EinComprobanteCompraNumeroSerie."-".$InsVehiculoIngreso->EinComprobanteCompraNumeroNumero;
	
	
	$InsVehiculoIngreso->PerId = $_POST['CmpResponsable'];	
	
	$InsVehiculoIngreso->EinArchivoDAM = $_SESSION['SesEinArchivoDAM'.$Identificador];
	$InsVehiculoIngreso->EinArchivoDAM2 = $_SESSION['SesEinArchivoDAM2'.$Identificador];
	$InsVehiculoIngreso->EinArchivoDAM3 = $_SESSION['SesEinArchivoDAM3'.$Identificador];
	
	$InsVehiculoIngreso->EinFechaSalidaDAM = FncCambiaFechaAMysql($_POST['CmpFechaSalidaDAM'],true);
	$InsVehiculoIngreso->EinFechaRetornoDAM = FncCambiaFechaAMysql($_POST['CmpFechaRetornoDAM'],true);

	$InsVehiculoIngreso->EinEstadoVehicular = $_POST['CmpEstadoVehicular'];	
	$InsVehiculoIngreso->EinSolicitud = $_POST['CmpSolicitud'];	
	$InsVehiculoIngreso->EinEstadoVehicularFechaSalida = FncCambiaFechaAMysql($_POST['CmpEstadoVehicularFechaSalida'],true);
	$InsVehiculoIngreso->EinEstadoVehicularFechaLlegada = FncCambiaFechaAMysql($_POST['CmpEstadoVehicularFechaLlegada'],true);
	
	$InsVehiculoIngreso->EinNumeroViaje = $_POST['CmpNumeroViaje'];	
	$InsVehiculoIngreso->EinUbicacion = $_POST['CmpUbicacion'];	
	
	$InsVehiculoIngreso->EinManualPropietario = $_POST['CmpManualPropietario'];	
	$InsVehiculoIngreso->EinManualGarantia = $_POST['CmpManualGarantia'];	
	
	
	$InsVehiculoIngreso->EinTipo = $_POST['CmpOrigen'];
	

//	$InsVehiculoIngreso->EinCaracteristicaMarca = addslashes($_POST['CmpVehiculoVersionCaracteristicaMarca']);
//	$InsVehiculoIngreso->EinCaracteristicaModelo = addslashes($_POST['CmpVehiculoVersionCaracteristicaModelo']);
//	$InsVehiculoIngreso->EinCaracteristicaAnoFabricacion = addslashes($_POST['CmpVehiculoVersionCaracteristicaAnoFabricacion']);
//	$InsVehiculoIngreso->EinCaracteristicaVIN = addslashes($_POST['CmpVehiculoVersionCaracteristicaVIN']);
//	$InsVehiculoIngreso->EinCaracteristicaColor = addslashes($_POST['CmpVehiculoVersionCaracteristicaColor']);
	
	$InsVehiculoIngreso->EinNombre = $_POST['CmpVehiculoIngresoNombre'];	
	
	if(!empty($InsVehiculoIngreso->VmoId) and empty($InsVehiculoIngreso->EinNombre)){
		
		$InsVehiculoModelo = new ClsVehiculoModelo();
		$InsVehiculoModelo->VmoId = $InsVehiculoIngreso->VmoId;
		$InsVehiculoModelo->MtdObtenerVehiculoModelo();

		if($InsVehiculoModelo->VmoNombre == "SAIL SEDAN" or
			$InsVehiculoModelo->VmoNombre == "SAIL HATCHBACK" or
			$InsVehiculoModelo->VmoNombre == "SPARK GT" or
			$InsVehiculoModelo->VmoNombre == "N300 MOVE" or
			$InsVehiculoModelo->VmoNombre == "N300 CARGO" or
			$InsVehiculoModelo->VmoNombre == "N300 WORK" or
			
			$InsVehiculoModelo->VmoNombre == "CRUZE SEDAN" or
			$InsVehiculoModelo->VmoNombre == "CRUZE HATCHBACK" or
			
			$InsVehiculoModelo->VmoNombre == "SONIC SEDAN" or
			$InsVehiculoModelo->VmoNombre == "SONIC HATCHBACK" or
		
			$InsVehiculoModelo->VmoNombre == "AVEO SEDAN" or
			$InsVehiculoModelo->VmoNombre == "AVEO HATCHBACK"
		){
			
			$InsVehiculoModelo->VmoNombre = preg_replace("/SEDAN/", "", $InsVehiculoModelo->VmoNombre);
			$InsVehiculoModelo->VmoNombre = preg_replace("/HATCHBACK/", "", $InsVehiculoModelo->VmoNombre);
			$InsVehiculoModelo->VmoNombre = preg_replace("/GT/", "", $InsVehiculoModelo->VmoNombre);
			$InsVehiculoModelo->VmoNombre = preg_replace("/MAX/", "", $InsVehiculoModelo->VmoNombre);
			$InsVehiculoModelo->VmoNombre = preg_replace("/MOVE/", "", $InsVehiculoModelo->VmoNombre);
			$InsVehiculoModelo->VmoNombre = preg_replace("/CARGO/", "", $InsVehiculoModelo->VmoNombre);
			$InsVehiculoModelo->VmoNombre = preg_replace("/WORK/", "", $InsVehiculoModelo->VmoNombre);	
			$InsVehiculoIngreso->EinNombre = $InsVehiculoModelo->VmoNombre;
				
		}

	}
	
	$InsVehiculoIngreso->VveCaracteristica1 = addslashes($_POST['CmpVehiculoVersionCaracteristica1']);
	$InsVehiculoIngreso->VveCaracteristica2 = addslashes($_POST['CmpVehiculoVersionCaracteristica2']);
	$InsVehiculoIngreso->VveCaracteristica3 = addslashes($_POST['CmpVehiculoVersionCaracteristica3']);
	$InsVehiculoIngreso->VveCaracteristica4 = addslashes($_POST['CmpVehiculoVersionCaracteristica4']);
	$InsVehiculoIngreso->VveCaracteristica5 = addslashes($_POST['CmpVehiculoVersionCaracteristica5']);
	$InsVehiculoIngreso->VveCaracteristica6 = addslashes($_POST['CmpVehiculoVersionCaracteristica6']);
	$InsVehiculoIngreso->VveCaracteristica7 = addslashes($_POST['CmpVehiculoVersionCaracteristica7']);
	$InsVehiculoIngreso->VveCaracteristica8 = addslashes($_POST['CmpVehiculoVersionCaracteristica8']);
	$InsVehiculoIngreso->VveCaracteristica9 = addslashes($_POST['CmpVehiculoVersionCaracteristica9']);
	$InsVehiculoIngreso->VveCaracteristica10 = addslashes($_POST['CmpVehiculoVersionCaracteristica10']);
	
	$InsVehiculoIngreso->VveCaracteristica11 = addslashes($_POST['CmpVehiculoVersionCaracteristica11']);
	$InsVehiculoIngreso->VveCaracteristica12 = addslashes($_POST['CmpVehiculoVersionCaracteristica12']);
	$InsVehiculoIngreso->VveCaracteristica13 = addslashes($_POST['CmpVehiculoVersionCaracteristica13']);
	$InsVehiculoIngreso->VveCaracteristica14 = addslashes($_POST['CmpVehiculoVersionCaracteristica14']);
	$InsVehiculoIngreso->VveCaracteristica15 = addslashes($_POST['CmpVehiculoVersionCaracteristica15']);
	$InsVehiculoIngreso->VveCaracteristica16 = addslashes($_POST['CmpVehiculoVersionCaracteristica16']);
	$InsVehiculoIngreso->VveCaracteristica17 = addslashes($_POST['CmpVehiculoVersionCaracteristica17']);	
	
	
		$InsVehiculoIngreso->EinCaracteristica1 = addslashes($_POST['CmpVehiculoVersionCaracteristica1']);
		$InsVehiculoIngreso->EinCaracteristica2 = addslashes($_POST['CmpVehiculoVersionCaracteristica2']);
		$InsVehiculoIngreso->EinCaracteristica3 = addslashes($_POST['CmpVehiculoVersionCaracteristica3']);
		$InsVehiculoIngreso->EinCaracteristica4 = addslashes($_POST['CmpVehiculoVersionCaracteristica4']);
		$InsVehiculoIngreso->EinCaracteristica5 = addslashes($_POST['CmpVehiculoVersionCaracteristica5']);
		$InsVehiculoIngreso->EinCaracteristica6 = addslashes($_POST['CmpVehiculoVersionCaracteristica6']);
		$InsVehiculoIngreso->EinCaracteristica7 = addslashes($_POST['CmpVehiculoVersionCaracteristica7']);
		$InsVehiculoIngreso->EinCaracteristica8 = addslashes($_POST['CmpVehiculoVersionCaracteristica8']);
		$InsVehiculoIngreso->EinCaracteristica9 = addslashes($_POST['CmpVehiculoVersionCaracteristica9']);
		$InsVehiculoIngreso->EinCaracteristica10 = addslashes($_POST['CmpVehiculoVersionCaracteristica10']);
		
		$InsVehiculoIngreso->EinCaracteristica11 = addslashes($_POST['CmpVehiculoVersionCaracteristica11']);
		$InsVehiculoIngreso->EinCaracteristica12 = addslashes($_POST['CmpVehiculoVersionCaracteristica12']);
		$InsVehiculoIngreso->EinCaracteristica13 = addslashes($_POST['CmpVehiculoVersionCaracteristica13']);
		$InsVehiculoIngreso->EinCaracteristica14 = addslashes($_POST['CmpVehiculoVersionCaracteristica14']);
		$InsVehiculoIngreso->EinCaracteristica15 = addslashes($_POST['CmpVehiculoVersionCaracteristica15']);
		$InsVehiculoIngreso->EinCaracteristica16 = addslashes($_POST['CmpVehiculoVersionCaracteristica16']);
		$InsVehiculoIngreso->EinCaracteristica17 = addslashes($_POST['CmpVehiculoVersionCaracteristica17']);	
		
	
	$InsVehiculoIngreso->MonId = $_POST['CmpMonedaId'];	
	$InsVehiculoIngreso->EinTipoCambio = $_POST['CmpTipoCambio'];	
	$InsVehiculoIngreso->EinDescuentoGerencia = preg_replace("/,/", "", (empty($_POST['CmpDescuentoGerencia'])?0:$_POST['CmpDescuentoGerencia']));

	if($InsVehiculoIngreso->MonId<>$EmpresaMonedaId ){
		$InsVehiculoIngreso->EinDescuentoGerencia = round($InsVehiculoIngreso->EinDescuentoGerencia * $InsVehiculoIngreso->EinTipoCambio,3);
	}

	$InsVehiculoIngreso->EinRecepcionFecha = FncCambiaFechaAMysql($_POST['CmpRecepcionFecha'],true);
	$InsVehiculoIngreso->EinRecepcionZonaComprometida = $_POST['CmpRecepcionZonaComprometida'];	
	$InsVehiculoIngreso->EinRecepcionRepuestoDetalle = $_POST['CmpRecepcionRepuestoDetalle'];	
	$InsVehiculoIngreso->EinRecepcionSolucion = $_POST['CmpRecepcionSolucion'];	
	$InsVehiculoIngreso->EinRecepcionObservacion = $_POST['CmpRecepcionObservacion'];
	$InsVehiculoIngreso->EinClaveAlarma = $_POST['CmpClaveAlarma'];	
	
	$InsVehiculoIngreso->EinEstado = $_POST['CmpEstado'];	
	$InsVehiculoIngreso->EinTiempoCreacion = date("Y-m-d H:i:s");
	$InsVehiculoIngreso->EinTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculoIngreso->EinEliminado = 1;
	
	$InsVehiculoIngreso->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsVehiculoIngreso->CliNombre = $_POST['CmpClienteNombre'];
	$InsVehiculoIngreso->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	
	$InsVehiculoIngreso->VehiculoIngresoCliente = array();
	
	if(!empty($_POST['CmpVehiculoVersionCaracteristicaPredeterminar'])){
		$InsVehiculoIngreso->Predeterminar = true;	
	}else{
		$InsVehiculoIngreso->Predeterminar = false;
	}
	

//SesionObjeto-VehiculoIngresoCliente
//Parametro1 = VicId
//Parametro2 = 
//Parametro3 = CliNombre
//Parametro4 = CliNumeroDocumento
//Parametro5 = TdoId
//Parametro6 = CliId
//Parametro7 = VicTiempoCreacion
//Parametro8 = VicTiempoModificacion
//Parametro9 = TdoNombre

//Parametro10 = VicEstado
//Parametro11 = VicFecha



	$ResVehiculoIngresoCliente = $_SESSION['InsVehiculoIngresoCliente'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];

	if(!empty($ArrVehiculoIngresoClientes)){
		$item = 1;
		foreach($ArrVehiculoIngresoClientes as $DatSesionObjeto){
				
			$InsVehiculoIngresoCliente1 = new ClsVehiculoIngresoCliente();

			$InsVehiculoIngresoCliente1->CliId = $DatSesionObjeto->Parametro6;
			$InsVehiculoIngresoCliente1->VicFecha = FncCambiaFechaAMysql($DatSesionObjeto->Parametro11,true);

			$InsVehiculoIngresoCliente1->VicEstado = $DatSesionObjeto->Parametro10;							
			$InsVehiculoIngresoCliente1->VicTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsVehiculoIngresoCliente1->VicTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsVehiculoIngresoCliente1->VicEliminado = $DatSesionObjeto->Eliminado;
			$InsVehiculoIngresoCliente1->InsMysql = NULL;

			if($InsVehiculoIngresoCliente1->VicEliminado==1){					
				$InsVehiculoIngreso->VehiculoIngresoCliente[] = $InsVehiculoIngresoCliente1;	
			}

			$item++;	
		}

	}
	
	
	
			//		SesionObjeto-VehiculoIngresoFoto
			//		Parametro1 = VifId
			//		Parametro2 =
			//		Parametro3 = VifArchivo
			//		Parametro4 = VifEstado
			//		Parametro5 = VifTiempoCreacion
			//		Parametro6 = VifTiempoModificacion


			$RepSesionObjetos = $_SESSION['InsVehiculoIngresoFoto'.$Identificador]->MtdObtenerSesionObjetos(true);
			$ArrSesionObjetos = $RepSesionObjetos['Datos'];

				if(!empty($ArrSesionObjetos)){
					foreach($ArrSesionObjetos as $DatSesionObjeto){

						$InsVehiculoIngresoFoto1 = new ClsVehiculoIngresoFoto();
						$InsVehiculoIngresoFoto1->VifId = $DatSesionObjeto->Parametro1;
						$InsVehiculoIngresoFoto1->VifArchivo = $DatSesionObjeto->Parametro3;
						$InsVehiculoIngresoFoto1->VifEstado = $DatSesionObjeto->Parametro4;
						$InsVehiculoIngresoFoto1->VifTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro5);
						$InsVehiculoIngresoFoto1->VifTiempoModificacion = date("Y-m-d H:i:s");
						$InsVehiculoIngresoFoto1->VifEliminado = $DatSesionObjeto->Eliminado;
						$InsVehiculoIngresoFoto1->InsMysql = NULL;
						
						$InsVehiculoIngreso->VehiculoIngresoFoto[] = $InsVehiculoIngresoFoto1;	
						
					}
				}
				
//		$InsVehiculoIngreso->EinCaracteristica10 = addslashes($_POST['CmpCaracteristica10']);
//		$InsVehiculoIngreso->EinCaracteristica12 = addslashes($_POST['CmpCaracteristica12']);
//		$InsVehiculoIngreso->EinCaracteristica13 = addslashes($_POST['CmpCaracteristica13']);		
	
//	deb($Guardar);
	if($Guardar){


	
//echo "aaa";
		
	//	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinCaracteristica10",$InsVehiculoIngreso->EinCaracteristica10,$InsVehiculoIngreso->EinId);
//		$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinCaracteristica12",$InsVehiculoIngreso->EinCaracteristica12,$InsVehiculoIngreso->EinId);
//		$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinCaracteristica13",$InsVehiculoIngreso->EinCaracteristica13,$InsVehiculoIngreso->EinId);
//		
		//deb($Resultado);
		
		
		if($InsVehiculoIngreso->MtdRegistrarVehiculoIngreso()){


	
//echo "bbb";
			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
                    self.parent.tb_remove('<?php echo $GET_mod;?>');
                    self.parent.$('#CmpVehiculoIngresoId').val("<?php echo $InsVehiculoIngreso->EinId;?>");
					self.parent.FncVehiculoIngresoFormularioFuncion();
					
                    //self.parent.FncVehiculoIngresoBuscar("Id");
                </script>
<?php
			}
			$Registro = true;
			FncNuevo();
			
			$Resultado.='#SAS_EIN_101';
		} else{
				
//echo "ccc";
			if($InsVehiculoIngreso->VehiculoProformaMonId<>$EmpresaMonedaId ){
				$InsVehiculoIngreso->VpdCosto = round($InsVehiculoIngreso->VpdCosto / $InsVehiculoIngreso->VprTipoCambio,3);
			}
			
			if($InsVehiculoIngreso->MonId<>$EmpresaMonedaId ){
				$InsVehiculoIngreso->EinDescuentoGerencia = round($InsVehiculoIngreso->EinDescuentoGerencia / $InsVehiculoIngreso->EinTipoCambio,3);
			}		
			
			$InsVehiculoIngreso->EinFechaSalidaDAM = FncCambiaFechaANormal($InsVehiculoIngreso->EinFechaSalidaDAM,true);
			$InsVehiculoIngreso->EinFechaRetornoDAM = FncCambiaFechaAMysql($InsVehiculoIngreso->EinFechaRetornoDAM,true);

			$Resultado.='#ERR_EIN_101';
		}


	}

}else{

	FncNuevo();

}

function FncNuevo(){
	
	global $Identificador;
	global $InsVehiculoIngreso;
	
	global $GET_VehiculoIngresoVIN;
	
	global $GET_VehiculoMarcaId;
	global $GET_VehiculoModeloId;
	global $GET_VehiculoVersionId;
	
	global $GET_VehiculoIngresoColor;
	global $GET_VehiculoIngresoAnoFabricacion;
	global $GET_VehiculoIngresoAnoModelo;
	
	global $GET_VehiculoIngresoNumeroMotor;


	unset($_SESSION['InsVehiculoIngresoFoto'.$Identificador]);
	unset($_SESSION['InsVehiculoIngresoCliente'.$Identificador]);
	
	$_SESSION['InsVehiculoIngresoFoto'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsVehiculoIngresoCliente'.$Identificador] = new ClsSesionObjeto();

	$InsVehiculoIngreso = new ClsVehiculoIngreso();

	$InsVehiculoIngreso->EinVIN = $GET_VehiculoIngresoVIN;
	$InsVehiculoIngreso->OncId = "ONC-10000";
	$InsVehiculoIngreso->VmaId = (empty($GET_VehiculoMarcaId)?"VMA-10017":$GET_VehiculoMarcaId);
	
	$InsVehiculoIngreso->VmoId = $GET_VehiculoModeloId;
	$InsVehiculoIngreso->VveId = $GET_VehiculoVersionId ;
	
	$InsVehiculoIngreso->EinColor = $GET_VehiculoIngresoColor ;
	$InsVehiculoIngreso->EinAnoFabricacion = $GET_VehiculoIngresoAnoFabricacion ;
	$InsVehiculoIngreso->EinAnoModelo = $GET_VehiculoIngresoAnoModelo ;
	
	$InsVehiculoIngreso->EinNumeroMotor = $GET_VehiculoIngresoNumeroMotor ;
	
	$InsVehiculoIngreso->EinZofra = 2;
	$InsVehiculoIngreso->EinNacionalizado = 2;
	
	
	//$InsCliente = new ClsCliente();
//
//	$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"CYC");
//	$ArrClientes = $ResCliente['Datos'];
//
//	if(!empty($ArrClientes)){
//		foreach($ArrClientes as $DatCliente){
//
//			$_SESSION['InsVehiculoIngresoCliente'.$Identificador]->MtdAgregarSesionObjeto(1,
//			NULL,
//			NULL,
//			$DatCliente->CliNombre." ".$DatCliente->CliApellidoPaterno." ".$DatCliente->CliApellidoMaterno,
//			$DatCliente->CliNumeroDocumento,
//			$DatCliente->TdoId,
//			$DatCliente->CliId,
//			date("d/m/Y H:i:s"),
//			date("d/m/Y H:i:s"),
//			$DatCliente->TdoNombre,
//			1,
//			date("d/m/Y")
//			);
//
//		}
//	}
	
	
}
?>