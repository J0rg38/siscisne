<?php
//Si se hizo click en guardar	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

	$InsOrdenVentaVehiculo->OvvId = $_POST['CmpId'];
	
	$InsOrdenVentaVehiculo->PerId = $_POST['CmpPersonal'];
	$InsOrdenVentaVehiculo->CliId = $_POST['CmpClienteId'];
	$InsOrdenVentaVehiculo->TdoId = $_POST['CmpTipoDocumentoId'];

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
	
	$InsOrdenVentaVehiculo->OvvNota = addslashes($_POST['CmpNota']);	
	$InsOrdenVentaVehiculo->OvvPlaca = $_POST['CmpPlaca'];	
	$InsOrdenVentaVehiculo->OvvEstado = $_POST['CmpEstado'];
	$InsOrdenVentaVehiculo->OvvTiempoModificacion = date("Y-m-d H:i:s");

	$InsOrdenVentaVehiculo->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsOrdenVentaVehiculo->CliNombre = $_POST['CmpClienteNombre'];
	$InsOrdenVentaVehiculo->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
		

	$InsOrdenVentaVehiculo->VmaId = $_POST['CmpVehiculoMarca'];
	$InsOrdenVentaVehiculo->VmoId = $_POST['CmpVehiculoModelo'];
	$InsOrdenVentaVehiculo->VveId = $_POST['CmpVehiculoVersion'];	

	$InsOrdenVentaVehiculo->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsOrdenVentaVehiculo->OvvAnoModelo = $_POST['CmpAnoModelo'];
	$InsOrdenVentaVehiculo->OvvAnoFabricacion = $_POST['CmpAnoFabricacion'];
	$InsOrdenVentaVehiculo->OvvColor = $_POST['CmpColor'];

	$InsOrdenVentaVehiculo->CveId = $_POST['CmpCotizacionVehiculoId'];


	$InsOrdenVentaVehiculo->OvvActaEntregaFecha = FncCambiaFechaAMysql($_POST['CmpActaEntregaFecha'],true);
	$InsOrdenVentaVehiculo->OvvActaEntregaDescripcion = addslashes($_POST['CmpActaEntregaDescripcion']);
	
	
	$InsOrdenVentaVehiculo->OvvTotalBruto = 0;

	$InsOrdenVentaVehiculo->OvvPrecio = eregi_replace(",","",$_POST['CmpPrecio']);
	$InsOrdenVentaVehiculo->OvvDescuento = eregi_replace(",","",$_POST['CmpDescuento']);
	$InsOrdenVentaVehiculo->OvvDescuento = (empty($InsOrdenVentaVehiculo->OvvDescuento)?0:$InsOrdenVentaVehiculo->OvvDescuento);
	
	$InsOrdenVentaVehiculo->OvvBonoGM = eregi_replace(",","",$_POST['CmpBonoGM']);
	$InsOrdenVentaVehiculo->OvvBonoDealer = eregi_replace(",","",$_POST['CmpBonoDealer']);
	$InsOrdenVentaVehiculo->OvvDescuentoGerencia = eregi_replace(",","",$_POST['CmpDescuentoGerencia']);
	$InsOrdenVentaVehiculo->OvvDescuentoGerencia = (empty($InsOrdenVentaVehiculo->OvvDescuentoGerencia)?0:$InsOrdenVentaVehiculo->OvvDescuentoGerencia);
	
	$InsOrdenVentaVehiculo->OvvTotal = eregi_replace(",","",$_POST['CmpTotal']);
	$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal,6);
	

	$InsOrdenVentaVehiculo->OvvSubTotal = round( ($InsOrdenVentaVehiculo->OvvTotal /( ($InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta/100)+1 ) ) ,6);
	$InsOrdenVentaVehiculo->OvvImpuesto = $InsOrdenVentaVehiculo->OvvTotal - $InsOrdenVentaVehiculo->OvvSubTotal;



	$InsOrdenVentaVehiculo->CveTotal = eregi_replace(",","",$_POST['CmpCotizacionVehiculoTotal']);

	$InsOrdenVentaVehiculo->EinVIN = $_POST['CmpVehiculoIngresoVIN'];

	$InsOrdenVentaVehiculo->OvvNotificar = (empty($_POST['CmpNotificar'])?2:$_POST['CmpNotificar']);




	if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId and !empty($InsOrdenVentaVehiculo->OvvTipoCambio)){

		$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
	
		$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia * $InsOrdenVentaVehiculo->OvvTipoCambio,3);

		$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal * $InsOrdenVentaVehiculo->OvvTipoCambio,6);
		$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto * $InsOrdenVentaVehiculo->OvvTipoCambio,6);
		$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal * $InsOrdenVentaVehiculo->OvvTipoCambio,6);
		
		$InsOrdenVentaVehiculo->CveTotal = round($InsOrdenVentaVehiculo->CveTotal * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
	}	
	
	
	
	$InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio = array();
	$InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta = array();

	if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){
		if(empty($InsOrdenVentaVehiculo->OvvTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_OVV_113';
		}
	}

	if(empty($InsOrdenVentaVehiculo->EinId)){
			$Guardar = false;
			$Resultado.='#ERR_OVV_112';
	}
	
	foreach($ArrCondicionVentas as $DatCondicionVenta){

		$InsOrdenVentaVehiculoCondicionVenta1 = new ClsOrdenVentaVehiculoCondicionVenta();
		$InsOrdenVentaVehiculoCondicionVenta1->OvnId = $_POST['CmpOrdenVentaVehiculoCondicionVentaId_'.$DatCondicionVenta->CovId];
		$InsOrdenVentaVehiculoCondicionVenta1->OvnCondicionVenta = $_POST['CmpCondicionVenta_'.$DatCondicionVenta->CovId];
		$InsOrdenVentaVehiculoCondicionVenta1->CovId = $DatCondicionVenta->CovId;
		$InsOrdenVentaVehiculoCondicionVenta1->OvnEstado = 1;
		$InsOrdenVentaVehiculoCondicionVenta1->OvnTiempoCreacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoCondicionVenta1->OvnTiempoModificacion = date("Y-m-d H:i:s");
		
		
		if(!empty($InsOrdenVentaVehiculoCondicionVenta1->OvnId)){
			if(empty($InsOrdenVentaVehiculoCondicionVenta1->OvnCondicionVenta)){
				$InsOrdenVentaVehiculoCondicionVenta1->OvnEliminado = 2;
			}else{
				$InsOrdenVentaVehiculoCondicionVenta1->OvnEliminado = 1;
			}
		}else{
			if(empty($InsOrdenVentaVehiculoCondicionVenta1->OvnCondicionVenta)){
				$InsOrdenVentaVehiculoCondicionVenta1->OvnEliminado = 2;
			}else{
				$InsOrdenVentaVehiculoCondicionVenta1->OvnpEliminado = 1;
			}
		}
	
		$InsOrdenVentaVehiculoCondicionVenta1->InsMysql = NULL;
		$InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta[] = $InsOrdenVentaVehiculoCondicionVenta1;	

	}
	
	
	
	
	foreach($ArrObsequios as $DatObsequio){

		$InsOrdenVentaVehiculoObsequio1 = new ClsOrdenVentaVehiculoObsequio();
		$InsOrdenVentaVehiculoObsequio1->OvoId = $_POST['CmpOrdenVentaVehiculoObsequioId_'.$DatObsequio->ObsId];
		$InsOrdenVentaVehiculoObsequio1->OvoObsequio = $_POST['CmpObsequio_'.$DatObsequio->ObsId];
		$InsOrdenVentaVehiculoObsequio1->ObsId = $DatObsequio->ObsId;
		$InsOrdenVentaVehiculoObsequio1->OvoAprobado = 2;
		$InsOrdenVentaVehiculoObsequio1->OvoEstado = 1;
		$InsOrdenVentaVehiculoObsequio1->OvoTiempoCreacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoObsequio1->OvoTiempoModificacion = date("Y-m-d H:i:s");
		

		
		if(!empty($InsOrdenVentaVehiculoObsequio1->OvoId)){
			if(empty($InsOrdenVentaVehiculoObsequio1->OvoObsequio)){
				$InsOrdenVentaVehiculoObsequio1->OvoEliminado = 2;
			}else{
				$InsOrdenVentaVehiculoObsequio1->OvoEliminado = 1;
			}
		}else{
			if(empty($InsOrdenVentaVehiculoObsequio1->OvoObsequio)){
				$InsOrdenVentaVehiculoObsequio1->OvoEliminado = 2;
			}else{
				$InsOrdenVentaVehiculoObsequio1->OvoEliminado = 1;
			}
		}
		//deb($InsOrdenVentaVehiculoObsequio1->OvoId);
		//deb($InsOrdenVentaVehiculoObsequio1->OvoObsequio);
		//deb($InsOrdenVentaVehiculoObsequio1->OvoEliminado);
		//echo "<hr>";
		$InsOrdenVentaVehiculoObsequio1->InsMysql = NULL;
		$InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio[] = $InsOrdenVentaVehiculoObsequio1;	

	}


	foreach($ArrAccesorios as $DatAccesorio){

		$InsOrdenVentaVehiculoObsequio1 = new ClsOrdenVentaVehiculoObsequio();
		$InsOrdenVentaVehiculoObsequio1->OvoId = $_POST['CmpOrdenVentaVehiculoObsequioId_'.$DatAccesorio->ObsId];
		$InsOrdenVentaVehiculoObsequio1->OvoObsequio = $_POST['CmpObsequio_'.$DatAccesorio->ObsId];
		$InsOrdenVentaVehiculoObsequio1->ObsId = $DatObsequio->ObsId;
		$InsOrdenVentaVehiculoObsequio1->OvoAprobado = 2;
		$InsOrdenVentaVehiculoObsequio1->OvoEstado = 1;
		$InsOrdenVentaVehiculoObsequio1->OvoTiempoCreacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoObsequio1->OvoTiempoModificacion = date("Y-m-d H:i:s");
		
		if(!empty($InsOrdenVentaVehiculoObsequio1->OvoId)){
			if(empty($InsOrdenVentaVehiculoObsequio1->OvoObsequio)){
				$InsOrdenVentaVehiculoObsequio1->OvoEliminado = 2;
			}else{
				$InsOrdenVentaVehiculoObsequio1->OvoEliminado = 1;
			}
		}else{
			if(empty($InsOrdenVentaVehiculoObsequio1->OvoObsequio)){
				$InsOrdenVentaVehiculoObsequio1->OvoEliminado = 2;
			}else{
				$InsOrdenVentaVehiculoObsequio1->OvoEliminado = 1;
			}
		}
		//deb($InsOrdenVentaVehiculoObsequio1->OvoId);
		//deb($InsOrdenVentaVehiculoObsequio1->OvoObsequio);
		//deb($InsOrdenVentaVehiculoObsequio1->OvoEliminado);
		//echo "<hr>";
		$InsOrdenVentaVehiculoObsequio1->InsMysql = NULL;
		$InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio[] = $InsOrdenVentaVehiculoObsequio1;	

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

	$ResOrdenVentaVehiculoPropietario = $_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador]->MtdObtenerSesionObjetos(false);
	$ArrOrdenVentaVehiculoPropietarios = $ResOrdenVentaVehiculoPropietario['Datos'];

	if(!empty($ArrOrdenVentaVehiculoPropietarios)){
		$item = 1;
		foreach($ArrOrdenVentaVehiculoPropietarios as $DatSesionObjeto){
				
			$InsOrdenVentaVehiculoPropietario1 = new ClsOrdenVentaVehiculoPropietario();

			$InsOrdenVentaVehiculoPropietario1->OvpId = $DatSesionObjeto->Parametro1;
			$InsOrdenVentaVehiculoPropietario1->CliId = $DatSesionObjeto->Parametro6;
			//$InsOrdenVentaVehiculoPropietario1->OvpFirmaDJ = $DatSesionObjeto->Parametro16;	
			$InsOrdenVentaVehiculoPropietario1->OvpFirmaDJ = 1;	
			$InsOrdenVentaVehiculoPropietario1->OvpEstado = 1;						
			$InsOrdenVentaVehiculoPropietario1->OvpTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsOrdenVentaVehiculoPropietario1->OvpTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsOrdenVentaVehiculoPropietario1->OvpEliminado = $DatSesionObjeto->Eliminado;
			$InsOrdenVentaVehiculoPropietario1->InsMysql = NULL;

			$InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario[] = $InsOrdenVentaVehiculoPropietario1;	
			
			$InsOrdenVentaVehiculo->CliId = $InsOrdenVentaVehiculoPropietario1->CliId;
			
			
			$item++;	
		}

	}else{
		
		$Guardar = false;
		$Resultado.='#ERR_OVV_111';
	}
	




	foreach($InsPlanMantenimiento->PmaChevroletKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){

		$InsOrdenVentaVehiculoMantenimiento1 = new ClsOrdenVentaVehiculoMantenimiento();
		$InsOrdenVentaVehiculoMantenimiento1->OvmId = $_POST['CmpOrdenVentaVehiculoMantenimientoId_'.$DatKilometro['eq']];
		$InsOrdenVentaVehiculoMantenimiento1->OvmKilometraje = $_POST['CmpMantenimientoChevrolet_'.$DatKilometro['eq']];
		$InsOrdenVentaVehiculoMantenimiento1->OvmEstado = 1;
		$InsOrdenVentaVehiculoMantenimiento1->OvmTiempoCreacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoMantenimiento1->OvmTiempoModificacion = date("Y-m-d H:i:s");
		
		if(!empty($InsOrdenVentaVehiculoMantenimiento1->OvmId)){
			if(empty($InsOrdenVentaVehiculoMantenimiento1->OvmKilometraje)){
				$InsOrdenVentaVehiculoMantenimiento1->OvmEliminado = 2;
			}else{
				$InsOrdenVentaVehiculoMantenimiento1->OvmEliminado = 1;
			}
		}else{
			if(empty($InsOrdenVentaVehiculoMantenimiento1->OvmKilometraje)){
				$InsOrdenVentaVehiculoMantenimiento1->OvmEliminado = 2;
			}else{
				$InsOrdenVentaVehiculoMantenimiento1->OvmEliminado = 1;
			}
		}
	
		$InsOrdenVentaVehiculoMantenimiento1->InsMysql = NULL;
		$InsOrdenVentaVehiculo->OrdenVentaVehiculoMantenimiento[] = $InsOrdenVentaVehiculoMantenimiento1;	

	}
	
	
	
	//deb($InsOrdenVentaVehiculo->OrdenVentaVehiculoMantenimiento);
	
	foreach($InsPlanMantenimiento->PmaIsuzuKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){

		$InsOrdenVentaVehiculoMantenimiento1 = new ClsOrdenVentaVehiculoMantenimiento();
		$InsOrdenVentaVehiculoMantenimiento1->OvmId = $_POST['CmpOrdenVentaVehiculoMantenimientoId_'.$DatKilometro['eq']];
		$InsOrdenVentaVehiculoMantenimiento1->OvmKilometraje = $_POST['CmpMantenimientoIsuzu_'.$DatKilometro['eq']];
		$InsOrdenVentaVehiculoMantenimiento1->OvmEstado = 1;
		$InsOrdenVentaVehiculoMantenimiento1->OvmTiempoCreacion = date("Y-m-d H:i:s");
		$InsOrdenVentaVehiculoMantenimiento1->OvmTiempoModificacion = date("Y-m-d H:i:s");
		
		if(!empty($InsOrdenVentaVehiculoMantenimiento1->OvmId)){
			if(empty($InsOrdenVentaVehiculoMantenimiento1->OvmKilometraje)){
				$InsOrdenVentaVehiculoMantenimiento1->OvmEliminado = 2;
			}else{
				$InsOrdenVentaVehiculoMantenimiento1->OvmEliminado = 1;
			}
		}else{
			if(empty($InsOrdenVentaVehiculoMantenimiento1->OvmKilometraje)){
				$InsOrdenVentaVehiculoMantenimiento1->OvmEliminado = 2;
			}else{
				$InsOrdenVentaVehiculoMantenimiento1->OvmEliminado = 1;
			}
		}
	
		$InsOrdenVentaVehiculoMantenimiento1->InsMysql = NULL;
		$InsOrdenVentaVehiculo->OrdenVentaVehiculoMantenimiento[] = $InsOrdenVentaVehiculoMantenimiento1;	

	}
	
	if($Guardar){
		if($InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculo()){
			
			if($InsOrdenVentaVehiculo->OvvNotificar == 1){
				
				$InsPersonal = new ClsPersonal();
				$InsPersonal->PerId = $InsOrdenVentaVehiculo->PerId;
				$InsPersonal->MtdObtenerPersonal();
				
				if(!empty($InsPersonal->PerEmail)){
					
					$InsPersonal->PerEmail = trim($InsPersonal->PerEmail);
					
					$InsOrdenVentaVehiculo->MtdNotificarOrdenVentaVehiculoRegistro($InsOrdenVentaVehiculo->OvvId,$InsPersonal->PerEmail.",jblanco@cyc.com.pe,aliendo@cyc.com.pe,jmaquera@cyc.com.pe,dvercelone@cyc.com.pe,avillanueva@cyc.com.pe");
				}
				
				
			}
			
			$Edito = true;		
			FncCargarDatos();
			$Resultado.='#SAS_OVV_102';

		} else{
	
			$InsOrdenVentaVehiculo->OvvFecha = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvFecha);
			$InsOrdenVentaVehiculo->OvvFechaEntrega = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvFechaEntrega,true);
			$InsOrdenVentaVehiculo->OvvActaEntregaFecha = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvActaEntregaFecha,true);
			
			if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){
				
				$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
				$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
					
				
		
				$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
				$InsOrdenVentaVehiculo->CveTotal = round($InsOrdenVentaVehiculo->CveTotal * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			}	

			$Resultado.='#ERR_OVV_102';		
		}			
	}else{

		$InsOrdenVentaVehiculo->OvvFecha = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvFecha);
		$InsOrdenVentaVehiculo->OvvFechaEntrega = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvFechaEntrega,true);
		$InsOrdenVentaVehiculo->OvvActaEntregaFecha = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvActaEntregaFecha,true);
			
		if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){
			
			$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			
			
			
			$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
				
				
				
		
					
			$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			
			$InsOrdenVentaVehiculo->CveTotal = round($InsOrdenVentaVehiculo->CveTotal * $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		}	
		
	}

	

}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsOrdenVentaVehiculo;
	global $EmpresaMonedaId;


	unset($_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador]);
	
	$_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();


	$InsOrdenVentaVehiculo->OvvId = $GET_id;
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();		

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
	
	
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){

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
			$DatOrdenVentaVehiculoPropietario->OvpId,
			NULL,
			$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno,
			$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento,
			$DatOrdenVentaVehiculoPropietario->TdoId,
			$DatOrdenVentaVehiculoPropietario->CliId,
			($DatOrdenVentaVehiculoPropietario->OvpTiempoCreacion),
			($DatOrdenVentaVehiculoPropietario->OvpTiempoModificacion),
			$DatOrdenVentaVehiculoPropietario->TdoNombre,
			
			$DatOrdenVentaVehiculoPropietario->CliTelefono,
			$DatOrdenVentaVehiculoPropietario->CliCelular,
			$DatOrdenVentaVehiculoPropietario->CliEmail,
			
			$DatOrdenVentaVehiculoPropietario->CliNombre,
			$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno,
			$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno,
			$DatOrdenVentaVehiculoPropietario->OvpFirmaDJ
			);
		
		}
	}
		
	

	
}
?>