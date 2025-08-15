<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or ($_POST['Guardar'] ?? '')=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsOrdenVentaVehiculo->UsuId = $_SESSION['SesionId'];	
	
	$InsOrdenVentaVehiculo->OvvId = $_POST['CmpId'];
	$InsOrdenVentaVehiculo->SucId = $_SESSION['SesionSucursal'];
	
	$InsOrdenVentaVehiculo->PerId = $_POST['CmpPersonal'];
	$InsOrdenVentaVehiculo->PerIdFirmante = $_POST['CmpPersonalFirmante'];	
	$InsOrdenVentaVehiculo->CliId = $_POST['CmpClienteId'];
	$InsOrdenVentaVehiculo->TdoId = $_POST['CmpTipoDocumentoId'];
	$InsOrdenVentaVehiculo->NpaId = $_POST['CmpCondicionPago'];

	$InsOrdenVentaVehiculo->MonId = $_POST['CmpMonedaId'];
	$InsOrdenVentaVehiculo->OvvTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsOrdenVentaVehiculo->MpaId = $_POST['CmpModalidadPago'];
	
	$InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	$InsOrdenVentaVehiculo->OvvFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsOrdenVentaVehiculo->OvvFechaEntrega = FncCambiaFechaAMysql($_POST['CmpFechaEntrega'],true);
	
	list($InsOrdenVentaVehiculo->OvvAno,$InsOrdenVentaVehiculo->OvvMes,$aux) = explode("-",$InsOrdenVentaVehiculo->OvvFecha);
	
	$InsOrdenVentaVehiculo->OvvObservacion = addslashes($_POST['CmpObservacion']);

	$InsOrdenVentaVehiculo->OvvTelefono = $_POST['CmpClienteTelefono'];
	$InsOrdenVentaVehiculo->OvvCelular = $_POST['CmpClienteCelular'];
	$InsOrdenVentaVehiculo->OvvDireccion = $_POST['CmpClienteDireccion'];
	$InsOrdenVentaVehiculo->OvvEmail = $_POST['CmpClienteEmail'];

	$InsOrdenVentaVehiculo->OvvIncluyeImpuesto = 1;

	$InsOrdenVentaVehiculo->OvvCondicionVenta = $_POST['CmpCondicionVenta'];
	$InsOrdenVentaVehiculo->OvvCondicionVentaOtro = $_POST['CmpCondicionVentaOtro'];
	$InsOrdenVentaVehiculo->OvvObsequio = $_POST['CmpObsequio'];
	$InsOrdenVentaVehiculo->OvvObsequioOtro = $_POST['CmpObsequioOtro'];
	
	$InsOrdenVentaVehiculo->OvvComprobanteVenta = $_POST['CmpComprobanteVenta'];	
	
	$InsOrdenVentaVehiculo->OvvReferencia = $_POST['CmpReferencia'];
	$InsOrdenVentaVehiculo->OvvGLPModeloTanque = $_POST['CmpGLPModeloTanque'];
	$InsOrdenVentaVehiculo->OvvTipoPlaca = $_POST['CmpTipoPlaca'];	
	
	$InsOrdenVentaVehiculo->OvvNota = addslashes($_POST['CmpNota']);	
	$InsOrdenVentaVehiculo->OvvPlaca = $_POST['CmpPlaca'];	
	
		
	$InsOrdenVentaVehiculo->OvvPlaca = $_POST['CmpPlaca'];
	$InsOrdenVentaVehiculo->OvvTarjeta = $_POST['CmpTarjeta'];
	
	
	$InsOrdenVentaVehiculo->OvvEstado = $_POST['CmpEstado'];	
	$InsOrdenVentaVehiculo->OvvTiempoCreacion = date("Y-m-d H:i:s");
	$InsOrdenVentaVehiculo->OvvTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsOrdenVentaVehiculo->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsOrdenVentaVehiculo->CliNombre = $_POST['CmpClienteNombre'];
	$InsOrdenVentaVehiculo->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	
	$InsOrdenVentaVehiculo->VmaId = $_POST['CmpVehiculoMarca'];
	$InsOrdenVentaVehiculo->VmoId = $_POST['CmpVehiculoModelo'];
	$InsOrdenVentaVehiculo->VveId = $_POST['CmpVehiculoVersion'];	

	//$InsOrdenVentaVehiculo->VmaId = $_POST['CmpVehiculoMarcaId'];
//	$InsOrdenVentaVehiculo->VmoId = $_POST['CmpVehiculoModeloId'];
//	$InsOrdenVentaVehiculo->VveId = $_POST['CmpVehiculoVersionId'];	

	$InsOrdenVentaVehiculo->OvvInmediata = $_POST['CmpInmediata'];
	$InsOrdenVentaVehiculo->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsOrdenVentaVehiculo->OvvAnoModelo = $_POST['CmpVehiculoAnoModelo'];
	$InsOrdenVentaVehiculo->OvvAnoFabricacion = $_POST['CmpVehiculoAnoFabricacion'];
	$InsOrdenVentaVehiculo->OvvColor = $_POST['CmpVehiculoColor'];
	$InsOrdenVentaVehiculo->OvvGLP = $_POST['CmpGLP'];
	$InsOrdenVentaVehiculo->CveId = $_POST['CmpCotizacionVehiculoId'];

	$InsOrdenVentaVehiculo->OvvActaEntregaFecha = FncCambiaFechaAMysql($_POST['CmpActaEntregaFecha'],true);
	$InsOrdenVentaVehiculo->OvvActaEntregaHora = ($_POST['CmpActaEntregaHora']);
	$InsOrdenVentaVehiculo->OvvActaEntregaDescripcion = addslashes($_POST['CmpActaEntregaDescripcion']);
	
	$InsOrdenVentaVehiculo->OvvTotalBruto = 0;
	
	$InsOrdenVentaVehiculo->OvvPrecio = preg_replace("/,/", "", $_POST['CmpPrecio']);
	$InsOrdenVentaVehiculo->OvvDescuento = preg_replace("/,/", "", $_POST['CmpDescuento']);
	$InsOrdenVentaVehiculo->OvvDescuento = (empty($InsOrdenVentaVehiculo->OvvDescuento)?0:$InsOrdenVentaVehiculo->OvvDescuento);
	
	$InsOrdenVentaVehiculo->OvvBonoGM = preg_replace("/,/", "", $_POST['CmpBonoGM']);
	$InsOrdenVentaVehiculo->OvvBonoDealer = preg_replace("/,/", "", $_POST['CmpBonoDealer']);
	$InsOrdenVentaVehiculo->OvvDescuentoGerencia = preg_replace("/,/", "", $_POST['CmpDescuentoGerencia']);
	$InsOrdenVentaVehiculo->OvvDescuentoGerencia = (empty($InsOrdenVentaVehiculo->OvvDescuentoGerencia)?0:$InsOrdenVentaVehiculo->OvvDescuentoGerencia);
	
//	$InsOrdenVentaVehiculo->OvvTotal = preg_replace("/,/", "", $_POST['CmpTotal']);
//	
//	$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvTotal * ($InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta/100),3);
//	$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvTotal - $InsOrdenVentaVehiculo->OvvImpuesto,3);
//	
	
		$InsOrdenVentaVehiculo->OvvTotal = preg_replace("/,/", "", $_POST['CmpTotal']);
	$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal,6);
	

	$InsOrdenVentaVehiculo->OvvSubTotal = round( ($InsOrdenVentaVehiculo->OvvTotal /( ($InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta/100)+1 ) ) ,6);
	$InsOrdenVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvTotal - $InsOrdenVentaVehiculo->OvvSubTotal;

	
	
	
	

	$InsOrdenVentaVehiculo->CveTotal = preg_replace("/,/", "", $_POST['CmpCotizacionVehiculoTotal']);
	
	$InsOrdenVentaVehiculo->EinVIN = $_POST['CmpVehiculoIngresoVIN'];
	
	$InsOrdenVentaVehiculo->OvvNotificar = (empty($_POST['CmpNotificar'])?2:$_POST['CmpNotificar']);
	$InsOrdenVentaVehiculo->OvvEntregaNotificar = (empty($_POST['CmpEntregaNotificar'])?2:$_POST['CmpEntregaNotificar']);
	
	if( $InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId ){
		
		$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento * $InsOrdenVentaVehiculo->OvvTipoCambio,3);



		$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		

		$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->CprTotal = round($InsOrdenVentaVehiculo->CprTotal * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
	}	

	$InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio = array();
	$InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta = array();

	if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){
		if(empty($InsOrdenVentaVehiculo->OvvTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_OVV_127';
		}
	}

	//if(empty($InsOrdenVentaVehiculo->EinId)){
//			$Guardar = false;
//			$Resultado.='#ERR_OVV_126';
//	}
	


	foreach($ArrCondicionVentas as $DatCondicionVenta){

		$InsOrdenVentaVehiculoCondicionVenta1 = new ClsOrdenVentaVehiculoCondicionVenta();

		$InsOrdenVentaVehiculoCondicionVenta1->OvnCondicionVenta = $_POST['CmpCondicionVenta_'.$DatCondicionVenta->CovId];

		$InsOrdenVentaVehiculoCondicionVenta1->CovId = $DatCondicionVenta->CovId;
		$InsOrdenVentaVehiculoCondicionVenta1->OvnEstado = 1;
		$InsOrdenVentaVehiculoCondicionVenta1->OvnTiempoCreacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoCondicionVenta1->OvnTiempoModificacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoCondicionVenta1->OvnEliminado = 1;

		$InsOrdenVentaVehiculoCondicionVenta1->InsMysql = NULL;
	
		if(!empty($InsOrdenVentaVehiculoCondicionVenta1->OvnCondicionVenta)){
			$InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta[] = $InsOrdenVentaVehiculoCondicionVenta1;	
		}

	}
	
	
	foreach($ArrObsequios as $DatObsequio){

		$InsOrdenVentaVehiculoObsequio1 = new ClsOrdenVentaVehiculoObsequio();

		$InsOrdenVentaVehiculoObsequio1->OvoObsequio = $_POST['CmpObsequio_'.$DatObsequio->ObsId];
		$InsOrdenVentaVehiculoObsequio1->ObsId = $DatObsequio->ObsId;
		
		
		$InsOrdenVentaVehiculoObsequio1->OvoAprobado = 2;
		$InsOrdenVentaVehiculoObsequio1->OvoEstado = 1;
		$InsOrdenVentaVehiculoObsequio1->OvoTiempoCreacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoObsequio1->OvoTiempoModificacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoObsequio1->OvoEliminado = 1;

		$InsOrdenVentaVehiculoObsequio1->InsMysql = NULL;
	
		if(!empty($InsOrdenVentaVehiculoObsequio1->OvoObsequio)){
			$InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio[] = $InsOrdenVentaVehiculoObsequio1;	
		}

	}
	

	foreach($ArrAccesorios as $DatAccesorio){

		$InsOrdenVentaVehiculoObsequio1 = new ClsOrdenVentaVehiculoObsequio();

		$InsOrdenVentaVehiculoObsequio1->OvoObsequio = $_POST['CmpObsequio_'.$DatAccesorio->ObsId];
		$InsOrdenVentaVehiculoObsequio1->ObsId = $DatAccesorio->ObsId;
		
		
		$InsOrdenVentaVehiculoObsequio1->OvoAprobado = 2;
		$InsOrdenVentaVehiculoObsequio1->OvoEstado = 1;
		$InsOrdenVentaVehiculoObsequio1->OvoTiempoCreacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoObsequio1->OvoTiempoModificacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoObsequio1->OvoEliminado = 1;

		$InsOrdenVentaVehiculoObsequio1->InsMysql = NULL;
	
		if(!empty($InsOrdenVentaVehiculoObsequio1->OvoObsequio)){
			$InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio[] = $InsOrdenVentaVehiculoObsequio1;	
		}

	}
	
		
	foreach($InsPlanMantenimiento->PmaChevroletKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
		
		//deb( $_POST['CmpMantenimientoChevrolet_'.$DatKilometro['eq']]);
		
		
		
		$InsOrdenVentaVehiculoMantenimiento1 = new ClsOrdenVentaVehiculoMantenimiento();

		$InsOrdenVentaVehiculoMantenimiento1->OvmKilometraje = $_POST['CmpMantenimientoChevrolet_'.$DatKilometro['eq']];
		$InsOrdenVentaVehiculoMantenimiento1->OvmEstado = 1;
		$InsOrdenVentaVehiculoMantenimiento1->OvmTiempoCreacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoMantenimiento1->OvmTiempoModificacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoMantenimiento1->OvmEliminado = 1;

		$InsOrdenVentaVehiculoMantenimiento1->InsMysql = NULL;
		
		//deb($InsOrdenVentaVehiculoMantenimiento1->OvmKilometraje);
		if(!empty($InsOrdenVentaVehiculoMantenimiento1->OvmKilometraje)){
		//deb($InsOrdenVentaVehiculoObsequio1->OvmKilometraje);
			$InsOrdenVentaVehiculo->OrdenVentaVehiculoMantenimiento[] = $InsOrdenVentaVehiculoMantenimiento1;	
		}

	}
	
	foreach($InsPlanMantenimiento->PmaIsuzuKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){

		$InsOrdenVentaVehiculoMantenimiento1 = new ClsOrdenVentaVehiculoMantenimiento();

		$InsOrdenVentaVehiculoMantenimiento1->OvmKilometraje = $_POST['CmpMantenimientoIsuzu_'.$DatKilometro['eq']];
		$InsOrdenVentaVehiculoMantenimiento1->OvmEstado = 1;
		$InsOrdenVentaVehiculoMantenimiento1->OvmTiempoCreacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoMantenimiento1->OvmTiempoModificacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoMantenimiento1->OvmEliminado = 1;

		$InsOrdenVentaVehiculoMantenimiento1->InsMysql = NULL;
	
		if(!empty($InsOrdenVentaVehiculoMantenimiento1->OvmKilometraje)){
			$InsOrdenVentaVehiculo->OrdenVentaVehiculoMantenimiento[] = $InsOrdenVentaVehiculoMantenimiento1;	
		}

	}
	
//SesionObjeto-OrdenVentaVehiculoPropietario
//Parametro1 = CviId
//Parametro2 = 
//Parametro3 = CliNombre
//Parametro4 = CliNumeroDocumento
//Parametro5 = TdoId
//Parametro6 = CliId
//Parametro7 = CviTiempoCreacion
//Parametro8 = CviTiempoModificacion
//Parametro9 = TdoNombre

//Parametro10 = CliTelefono
//Parametro11 = CliCelular
//Parametro12 = CliEmail

//Parametro13 = CliNombre
//Parametro14 = CliApellidoPaterno
//Parametro15 = CliApellidoMaterno

	$ResOrdenVentaVehiculoPropietario = $_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrOrdenVentaVehiculoPropietarios = $ResOrdenVentaVehiculoPropietario['Datos'];


//deb($ArrOrdenVentaVehiculoPropietarios);

	$Propietario = "";
	
	if(!empty($ArrOrdenVentaVehiculoPropietarios)){
		$item = 1;
		foreach($ArrOrdenVentaVehiculoPropietarios as $DatSesionObjeto){
				
			$InsOrdenVentaVehiculoPropietario1 = new ClsOrdenVentaVehiculoPropietario();

			$InsOrdenVentaVehiculoPropietario1->CliId = $DatSesionObjeto->Parametro6;
			//$InsOrdenVentaVehiculoPropietario1->OvpFirmaDJ = $DatSesionObjeto->Parametro16;		
			$InsOrdenVentaVehiculoPropietario1->OvpFirmaDJ = (empty($_POST['CmpOrdenVentaVehiculoPropietario_'.$DatSesionObjeto->Item])?2:$_POST['CmpOrdenVentaVehiculoPropietario_'.$DatSesionObjeto->Item]);
			//$InsOrdenVentaVehiculoPropietario1->OvpFirmaDJ = 1;		
			$InsOrdenVentaVehiculoPropietario1->OvpEstado = 1;						
			$InsOrdenVentaVehiculoPropietario1->OvpTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsOrdenVentaVehiculoPropietario1->OvpTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsOrdenVentaVehiculoPropietario1->OvpEliminado = $DatSesionObjeto->Eliminado;
			$InsOrdenVentaVehiculoPropietario1->InsMysql = NULL;

			if($InsOrdenVentaVehiculoPropietario1->OvpEliminado==1){		
						
				$InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario[] = $InsOrdenVentaVehiculoPropietario1;	
				
				if($item==1){
						$InsOrdenVentaVehiculo->CliId = $InsOrdenVentaVehiculoPropietario1->CliId;				
					$Propietario = $InsOrdenVentaVehiculoPropietario1->CliId;
					$item++;	
				}
			
				
			}

			
		}

	}else{
		
		$Guardar = false;
		$Resultado.='#ERR_OVV_125';
		
	}
	
	
	if($Guardar){
		
		if($InsOrdenVentaVehiculo->MtdRegistrarOrdenVentaVehiculo()){

			if(!empty($InsOrdenVentaVehiculo->EinId)){
				
				if($InsOrdenVentaVehiculo->OvvEstado == 3){
					
					$InsVehiculoIngreso = new ClsVehiculoIngreso();
					$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","RESERVADO",$InsOrdenVentaVehiculo->EinId);
					
					if(!empty($Propietario)){
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("CliId",$Propietario,$InsOrdenVentaVehiculo->EinId);	
					}
					
				}
				
			}

			if($InsOrdenVentaVehiculo->OvvNotificar == 1){
				
				$InsPersonal = new ClsPersonal();
				$InsPersonal->PerId = $InsOrdenVentaVehiculo->PerId;
				$InsPersonal->MtdObtenerPersonal();
				
				
				$EmailPersonal = "";
				
				if(!empty($InsPersonal->PerEmail)){
					
					$EmailPersonal .= trim($InsPersonal->PerEmail).",";
					
				}	
				
				if(!empty($InsPersonal->PerEmailVendedor)){
					
					$EmailPersonal .= trim($InsPersonal->PerEmailVendedor).",";
					
				}	
				
				
					
					$InsOrdenVentaVehiculo->MtdNotificarOrdenVentaVehiculoRegistro($InsOrdenVentaVehiculo->OvvId,$InsPersonal->PerEmail.",".$CorreosNotificacionOrdenVentaVehiculo);
					
					$InsOrdenVentaVehiculo->MtdNotificarOrdenVentaVehiculoAprobacionAsignacionVIN($InsOrdenVentaVehiculo->OvvId,$EmailPersonal.",".$CorreosNotificacionOrdenVentaVehiculoAprobacionVIN);
					
				
				
				
			}
			
			/*if($InsOrdenVentaVehiculo->OvvEntregaNotificar == 1){
				
				//deb($InsOrdenVentaVehiculo->OvvActaEntregaFecha);
				
				if(!empty($InsOrdenVentaVehiculo->OvvActaEntregaFecha)){
				
					$InsPersonal = new ClsPersonal();
					$InsPersonal->PerId = $InsOrdenVentaVehiculo->PerId;
					$InsPersonal->MtdObtenerPersonal();
					
					$InsPersonal->PerEmail = trim($InsPersonal->PerEmail);					
					$InsOrdenVentaVehiculo->MtdNotificarOrdenVentaVehiculoEntrega($InsOrdenVentaVehiculo->OvvId,$InsPersonal->PerEmail.",".$CorreosNotificacionOrdenVentaVehiculoEntregaVehiculo);
					
				}
				
				
			}
			**/

			$Registro = true;

			unset($InsOrdenVentaVehiculo);
			$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
			FncNuevo();
			$Resultado.='#SAS_OVV_101';

		} else{
			
			if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){
				
				$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);		
				
				$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
				$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
				$InsOrdenVentaVehiculo->CveTotal = round($InsOrdenVentaVehiculo->CveTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
			}	
					
			$InsOrdenVentaVehiculo->OvvFecha = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvFecha);
			$InsOrdenVentaVehiculo->OvvFechaEntrega = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvFechaEntrega,true);
			$InsOrdenVentaVehiculo->OvvActaEntregaFecha = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvActaEntregaFecha,true);

			$Resultado.='#ERR_OVV_101';
		}
	
	}else{

	
		if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){

			$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			

			$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			

			$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			$InsOrdenVentaVehiculo->CveTotal = round($InsOrdenVentaVehiculo->CveTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);

		}	

		$InsOrdenVentaVehiculo->OvvFecha = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvFecha);
		$InsOrdenVentaVehiculo->OvvFechaEntrega = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvFechaEntrega,true);
		$InsOrdenVentaVehiculo->OvvActaEntregaFecha = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvActaEntregaFecha,true);

	}


}else{

	FncNuevo();

	switch($GET_Origen){

	
		case "CotizacionVehiculo":
			
			$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
			$InsCotizacionVehiculo->CveId = $GET_CveId;
			$InsCotizacionVehiculo->MtdObtenerCotizacionVehiculo();
			
			$InsOrdenVentaVehiculo->PerId = $InsCotizacionVehiculo->PerId;
			$InsOrdenVentaVehiculo->CliId = $InsCotizacionVehiculo->CliId;
			$InsOrdenVentaVehiculo->NpaId = $InsCotizacionVehiculo->NpaId;
		
			$InsOrdenVentaVehiculo->MonId = $InsCotizacionVehiculo->MonId;
			$InsOrdenVentaVehiculo->OvvTipoCambio = $InsCotizacionVehiculo->CveTipoCambio;
			
			$InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta = $InsCotizacionVehiculo->CvePorcentajeImpuestoVenta;
			$InsOrdenVentaVehiculo->OvvFecha = date("d/m/Y");
			
			$InsOrdenVentaVehiculo->OvvAno = date("Y");
			$InsOrdenVentaVehiculo->OvvMes = date("m");
			
			$InsOrdenVentaVehiculo->OvvObservacion = $InsCotizacionVehiculo->CveObservacion;
		
			$InsOrdenVentaVehiculo->OvvTelefono = $InsCotizacionVehiculo->CveTelefono;
			$InsOrdenVentaVehiculo->OvvCelular = $InsCotizacionVehiculo->CveCelular;
			$InsOrdenVentaVehiculo->OvvDireccion = $InsCotizacionVehiculo->CveDireccion;
			$InsOrdenVentaVehiculo->OvvEmail = $InsCotizacionVehiculo->CveEmail;
			
			$InsOrdenVentaVehiculo->OvvGLP = $InsCotizacionVehiculo->CveGLP;
		
			$InsOrdenVentaVehiculo->OvvIncluyeImpuesto = 2;

			$InsOrdenVentaVehiculo->OvvCondicionVentaOtro = $InsCotizacionVehiculo->CveCondicionVentaOtro;
			$InsOrdenVentaVehiculo->OvvObsequioOtro = $InsCotizacionVehiculo->CveObsequioOtro;
		
			$InsOrdenVentaVehiculo->OvvEstado = 1;	
			$InsOrdenVentaVehiculo->OvvTiempoCreacion = date("Y-m-d H:i:s");
			$InsOrdenVentaVehiculo->OvvTiempoModificacion = date("Y-m-d H:i:s");
			
			$InsOrdenVentaVehiculo->TdoId = $InsCotizacionVehiculo->TdoId;
			$InsOrdenVentaVehiculo->CliNombre = $InsCotizacionVehiculo->CliNombre;
			$InsOrdenVentaVehiculo->CliApellidoPaterno = $InsCotizacionVehiculo->CliApellidoPaterno;
			$InsOrdenVentaVehiculo->CliApellidoMaterno = $InsCotizacionVehiculo->CliApellidoMaterno;
			
			$InsOrdenVentaVehiculo->CliNumeroDocumento = $InsCotizacionVehiculo->CliNumeroDocumento;
			
			$InsOrdenVentaVehiculo->TdoNombre = $InsCotizacionVehiculo->TdoNombre;
			
			$InsOrdenVentaVehiculo->CliTelefono = $InsCotizacionVehiculo->CliTelefono;
			$InsOrdenVentaVehiculo->CliCelular = $InsCotizacionVehiculo->CliCelular;
			$InsOrdenVentaVehiculo->CliEmail = $InsCotizacionVehiculo->CliEmail;
			
			$InsOrdenVentaVehiculo->VmaId = $InsCotizacionVehiculo->VmaId;
			$InsOrdenVentaVehiculo->VmoId = $InsCotizacionVehiculo->VmoId;
			$InsOrdenVentaVehiculo->VveId = $InsCotizacionVehiculo->VveId;

			$InsOrdenVentaVehiculo->EinId = $InsCotizacionVehiculo->EinId;
			$InsOrdenVentaVehiculo->OvvAnoModelo = $InsCotizacionVehiculo->CveAnoModelo;
			$InsOrdenVentaVehiculo->OvvColor = $InsCotizacionVehiculo->CveColor;

			$InsOrdenVentaVehiculo->OvvPrecio = $InsCotizacionVehiculo->CvePrecio;
			$InsOrdenVentaVehiculo->OvvDescuento = $InsCotizacionVehiculo->CveDescuento;

			$InsOrdenVentaVehiculo->OvvBonoGM = 0;
			$InsOrdenVentaVehiculo->OvvBonoDealer = 0;
			$InsOrdenVentaVehiculo->OvvDescuentoGerencia = 0;

			$InsOrdenVentaVehiculo->OvvSubTotal = $InsCotizacionVehiculo->CveSubTotal;
			$InsOrdenVentaVehiculo->OvvImpuesto = $InsCotizacionVehiculo->CveImpuesto;
			$InsOrdenVentaVehiculo->OvvTotal = $InsCotizacionVehiculo->CveTotal;

			$InsOrdenVentaVehiculo->CveTotal = $InsCotizacionVehiculo->CveTotal;
			
			if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId ){
				
				$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
				$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
				$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
				
				$InsOrdenVentaVehiculo->CveTotal = round($InsOrdenVentaVehiculo->CveTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);

			}	

			//deb($InsCotizacionVehiculo->CliNombre);
			$InsOrdenVentaVehiculo->CliNombre = $InsCotizacionVehiculo->CliNombre;
			$InsOrdenVentaVehiculo->CliApellidoPaterno = $InsCotizacionVehiculo->CliApellidoPaterno;
			$InsOrdenVentaVehiculo->CliApellidoMaterno = $InsCotizacionVehiculo->CliApellidoMaterno;
			
			$InsOrdenVentaVehiculo->CveId = $InsCotizacionVehiculo->CveId;
				
			if(!empty($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta)){
				foreach($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta as $DatCotizacionVehiculoCondicionVenta){
	
					$InsCotizacionVehiculoCondicionVenta1 = new ClsOrdenVentaVehiculoCondicionVenta();
					$InsCotizacionVehiculoCondicionVenta1->CovNombre = $DatCotizacionVehiculoCondicionVenta->CovNombre;
					$InsCotizacionVehiculoCondicionVenta1->CovId = $DatCotizacionVehiculoCondicionVenta->CovId;
					$InsCotizacionVehiculoCondicionVenta1->OvnEstado = 1;
					$InsCotizacionVehiculoCondicionVenta1->OvnTiempoCreacion = date("Y-m-d H:i:s");
					$InsCotizacionVehiculoCondicionVenta1->OvnTiempoModificacion = date("Y-m-d H:i:s");
					
					$InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta[] = $InsCotizacionVehiculoCondicionVenta1;
					
				}
			}
			
//			deb($InsCotizacionVehiculo->CotizacionVehiculoObsequio);
			if(!empty($InsCotizacionVehiculo->CotizacionVehiculoObsequio)){
				foreach($InsCotizacionVehiculo->CotizacionVehiculoObsequio as $DatCotizacionVehiculoObsequio){
	
					$InsOrdenVentaVehiculoObsequio1 = new ClsOrdenVentaVehiculoCondicionVenta();
					$InsOrdenVentaVehiculoObsequio1->ObsNombre = $DatCotizacionVehiculoObsequio->ObsNombre;
					$InsOrdenVentaVehiculoObsequio1->ObsId = $DatCotizacionVehiculoObsequio->ObsId;
					$InsOrdenVentaVehiculoObsequio1->OvoAux = 1;
					$InsOrdenVentaVehiculoObsequio1->OvoEstado = 1;
					$InsOrdenVentaVehiculoObsequio1->OvoTiempoCreacion = date("Y-m-d H:i:s");
					$InsOrdenVentaVehiculoObsequio1->OvoTiempoModificacion = date("Y-m-d H:i:s");
					
					$InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio[] = $InsOrdenVentaVehiculoObsequio1;
				
				}
			}
			
			

//SesionObjeto-OrdenVentaVehiculoPropietario
//Parametro1 = CviId
//Parametro2 = 
//Parametro3 = CliNombre
//Parametro4 = CliNumeroDocumento
//Parametro5 = TdoId
//Parametro6 = CliId
//Parametro7 = CviTiempoCreacion
//Parametro8 = CviTiempoModificacion
//Parametro9 = TdoNombre

//Parametro10 = CliTelefono
//Parametro11 = CliCelular
//Parametro12 = CliEmail

//Parametro13 = CliNombre
//Parametro14 = CliApellidoPaterno
//Parametro15 = CliApellidoMaterno

//Parametro16 = OvpFirmaDJ

			$_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador]->MtdAgregarSesionObjeto(1,
			NULL,
			NULL,
			$InsOrdenVentaVehiculo->CliNombre." ".$InsOrdenVentaVehiculo->CliApellidoPaterno." ".$InsOrdenVentaVehiculo->CliApellidoMaterno,
			$InsOrdenVentaVehiculo->CliNumeroDocumento,
			$InsOrdenVentaVehiculo->TdoId,
			$InsOrdenVentaVehiculo->CliId,
			(date("d/m/Y H:i:s")),
			(date("d/m/Y H:i:s")),
			$InsOrdenVentaVehiculo->TdoNombre,
			
			$InsOrdenVentaVehiculo->CliTelefono,
			$InsOrdenVentaVehiculo->CliCelular,
			$InsOrdenVentaVehiculo->CliEmail,
			
			$InsOrdenVentaVehiculo->CliNombre,
			$InsOrdenVentaVehiculo->CliApellidoPaterno,
			$InsOrdenVentaVehiculo->CliApellidoMaterno,
			"1"
			);
			
		break;
		
			
	}
	
}

function FncNuevo(){

	global $InsOrdenVentaVehiculo;
	global $Identificador;
	
	unset($_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador]);
		
	$_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();	
	
	$InsOrdenVentaVehiculo->SucId = $_SESSION['SesionSucursal'];;
	
	
	$InsOrdenVentaVehiculo->OvvEstado = 1;
	$InsOrdenVentaVehiculo->MonId = "MON-10001";

	$InsOrdenVentaVehiculo->OvvNotificar = 2;
	$InsOrdenVentaVehiculo->OvvEntregarNotificar = 1;
	$InsOrdenVentaVehiculo->PerId = $_SESSION['SesionPersonal'];
	$InsOrdenVentaVehiculo->OvvGLP = "No";
	$InsOrdenVentaVehiculo->OvvInmediata = 2;

//$InsOrdenVentaVehiculo->OvvActaEntregaDescripcion = "<html><body><ul>
//  <li>01 Llave de Ruedas.</li>
//  <li>02 Llaves de Encendido</li>
//  <li>01 Gata Mecánica</li>
//  <li>01 Gancho de Remolque</li>
//  <li>01 Antena</li>
//  <li>01 Neumático de Repuesto</li>
//  <li>01 Manual de Mantenimiento</li>
//  <li>01 Manual del Propietario</li>
//  <li>01 Encendedor</li>
//  <li>01 Cenicero</li>
//  <li>01 Juego de Pisos</li>
//</ul></body></html>";
//}

/*$InsOrdenVentaVehiculo->OvvActaEntregaDescripcion = "
<ul>
<li>01 Llave de Ruedas</li>
<li>02 Llaves de Encendido</li>
<li>01 Gata Mecánica</li>
<li>01 Gancho de Remolque</li>
<li>01 Antena</li>
<li>01 Neumático de Repuesto</li>
<li>01 Manual de Mantenimiento</li>
<li>01 Manual del Propietario</li>
<li>01 Encendedor</li>
<li>01 Cenicero</li>

</ul>";*/
}

/* <li>01 Juego de Pisos</li> */
?>