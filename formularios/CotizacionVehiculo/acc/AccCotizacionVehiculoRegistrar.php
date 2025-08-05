<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
	
	$Guardar = true;
	$Resultado = '';
	
	$InsCotizacionVehiculo->UsuId = $_SESSION['SesionId'];	

	$InsCotizacionVehiculo->CveId = $_POST['CmpId'];
	$InsCotizacionVehiculo->SucId = $_SESSION['SesionSucursal'];
	
	
	
//	$InsCotizacionVehiculo->CveAno = $_POST['CmpAno'];
//	$InsCotizacionVehiculo->CveMes = $_POST['CmpMes'];
	$InsCotizacionVehiculo->PerId = $_POST['CmpPersonal'];
	$InsCotizacionVehiculo->PerIdReferente = $_POST['CmpPersonalReferente'];
	$InsCotizacionVehiculo->CliId = $_POST['CmpClienteId'];
	$InsCotizacionVehiculo->NpaId = $_POST['CmpCondicionPago'];
	$InsCotizacionVehiculo->TrfId = $_POST['CmpTipoReferido'];


	$InsCotizacionVehiculo->MonId = $_POST['CmpMonedaId'];
	$InsCotizacionVehiculo->CveTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsCotizacionVehiculo->CvePorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];	
	$InsCotizacionVehiculo->CveFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsCotizacionVehiculo->CveHora = ($_POST['CmpHora']);
	$InsCotizacionVehiculo->CveFechaVigencia = FncCambiaFechaAMysql($_POST['CmpFechaVigencia'],true);
	
	list($InsCotizacionVehiculo->CveAno,$InsCotizacionVehiculo->CveMes,$aux) = explode("-",$InsCotizacionVehiculo->CveFecha);
	
	$InsCotizacionVehiculo->CveObservacion = addslashes($_POST['CmpObservacion']);
	$InsCotizacionVehiculo->CveObservacionReporte = addslashes($_POST['CmpObservacionReporte']);
	$InsCotizacionVehiculo->CveAdicional = addslashes($_POST['CmpAdicional']);
	$InsCotizacionVehiculo->CveNota = addslashes($_POST['CmpNota']);

	$InsCotizacionVehiculo->CveTelefono = $_POST['CmpClienteTelefono'];
	$InsCotizacionVehiculo->CveCelular = $_POST['CmpClienteCelular'];
	$InsCotizacionVehiculo->CveDireccion = $_POST['CmpClienteDireccion'];
	$InsCotizacionVehiculo->CveEmail = $_POST['CmpClienteEmail'];

	$InsCotizacionVehiculo->CveIncluyeImpuesto = 2;

	$InsCotizacionVehiculo->CveCondicionVenta = $_POST['CmpCondicionVenta'];
	$InsCotizacionVehiculo->CveCondicionVentaOtro = $_POST['CmpCondicionVentaOtro'];
	$InsCotizacionVehiculo->CveObsequio = $_POST['CmpObsequio'];
	$InsCotizacionVehiculo->CveObsequioOtro = $_POST['CmpObsequioOtro'];

	$InsCotizacionVehiculo->CveNivelInteres = $_POST['CmpNivelInteres'];
	$InsCotizacionVehiculo->CveCotizoOtroLugar = $_POST['CmpCotizoOtroLugar'];
	
	$InsCotizacionVehiculo->CveGLP = $_POST['CmpGLP'];	
	$InsCotizacionVehiculo->CveEstado = $_POST['CmpEstado'];	
	$InsCotizacionVehiculo->CveTiempoCreacion = date("Y-m-d H:i:s");
	$InsCotizacionVehiculo->CveTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsCotizacionVehiculo->TdoId = $_POST['CmpClienteTipoDocumento'];
	
	
	$InsCotizacionVehiculo->CliNombre = $_POST['CmpClienteNombre'];
	$InsCotizacionVehiculo->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsCotizacionVehiculo->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];	
	$InsCotizacionVehiculo->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsCotizacionVehiculo->CliNombreCompleto = $_POST['CmpClienteNombreCompleto'];
	
	$InsCotizacionVehiculo->VmaId = $_POST['CmpVehiculoMarca'];
	$InsCotizacionVehiculo->VmoId = $_POST['CmpVehiculoModelo'];
	$InsCotizacionVehiculo->VveId = $_POST['CmpVehiculoVersion'];	

	$InsCotizacionVehiculo->VmaId2 = $_POST['CmpVehiculoMarca2'];
	$InsCotizacionVehiculo->VmoId2 = $_POST['CmpVehiculoModelo2'];
	$InsCotizacionVehiculo->VveId2 = $_POST['CmpVehiculoVersion2'];	
	
	$InsCotizacionVehiculo->VmaId3 = $_POST['CmpVehiculoMarca3'];
	$InsCotizacionVehiculo->VmoId3 = $_POST['CmpVehiculoModelo3'];
	$InsCotizacionVehiculo->VveId3 = $_POST['CmpVehiculoVersion3'];	


/*
* MODELO 1
*/
	$InsCotizacionVehiculo->EinId = $_POST['CmpVehiculoIngresoId'];
	$InsCotizacionVehiculo->CveAnoModelo = $_POST['CmpAnoModelo'];
	$InsCotizacionVehiculo->CveAnoFabricacion = $_POST['CmpAnoFabricacion'];
	$InsCotizacionVehiculo->CveColor = $_POST['CmpColor'];
	
	$InsCotizacionVehiculo->CveTotalBruto = 0;
	
	$InsCotizacionVehiculo->CveCantidad =  eregi_replace(",","",(empty($_POST['CmpCantidad'])?0:$_POST['CmpCantidad']));
	
	$InsCotizacionVehiculo->CvePrecio = eregi_replace(",","",$_POST['CmpPrecio']);
	$InsCotizacionVehiculo->CveDescuento = eregi_replace(",","",$_POST['CmpDescuento']);
	
	$InsCotizacionVehiculo->CveTotal = eregi_replace(",","",$_POST['CmpTotal']);
	$InsCotizacionVehiculo->CveImpuesto = round($InsCotizacionVehiculo->CveTotal * ($InsCotizacionVehiculo->CvePorcentajeImpuestoVenta/100),3);
	$InsCotizacionVehiculo->CveSubTotal = round($InsCotizacionVehiculo->CveTotal - $InsCotizacionVehiculo->CveImpuesto,3);
	
	if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId and !empty($InsCotizacionVehiculo->CveTipoCambio)){

		$InsCotizacionVehiculo->CvePrecio = round($InsCotizacionVehiculo->CvePrecio * $InsCotizacionVehiculo->CveTipoCambio,3);
		$InsCotizacionVehiculo->CveDescuento = round($InsCotizacionVehiculo->CveDescuento * $InsCotizacionVehiculo->CveTipoCambio,3);

		$InsCotizacionVehiculo->CveTotal = round($InsCotizacionVehiculo->CveTotal * $InsCotizacionVehiculo->CveTipoCambio,3);
		$InsCotizacionVehiculo->CveImpuesto = round($InsCotizacionVehiculo->CveImpuesto * $InsCotizacionVehiculo->CveTipoCambio,3);
		$InsCotizacionVehiculo->CveSubTotal = round($InsCotizacionVehiculo->CveSubTotal * $InsCotizacionVehiculo->CveTipoCambio,3);

	}	


/*
*MODELO 2
*/


	$InsCotizacionVehiculo->EinId2 = $_POST['CmpVehiculoIngresoId2'];
	$InsCotizacionVehiculo->CveAnoModelo2 = $_POST['CmpAnoModelo2'];
	$InsCotizacionVehiculo->CveAnoFabricacion2 = $_POST['CmpAnoFabricacion2'];
	$InsCotizacionVehiculo->CveColor2 = $_POST['CmpColor2'];

	$InsCotizacionVehiculo->CveTotalBruto2 = 0;
	
	$InsCotizacionVehiculo->CveCantidad2 =  eregi_replace(",","",(empty($_POST['CmpCantidad2'])?0:$_POST['CmpCantidad2']));
	
	$InsCotizacionVehiculo->CvePrecio2 = eregi_replace(",","",$_POST['CmpPrecio2']);
	$InsCotizacionVehiculo->CveDescuento2 = eregi_replace(",","",$_POST['CmpDescuento2']);
	
	$InsCotizacionVehiculo->CveTotal2 = eregi_replace(",","",$_POST['CmpTotal2']);
	$InsCotizacionVehiculo->CveImpuesto2 = round($InsCotizacionVehiculo->CveTotal2 * ($InsCotizacionVehiculo->CvePorcentajeImpuestoVenta/100),3);
	$InsCotizacionVehiculo->CveSubTotal2 = round($InsCotizacionVehiculo->CveTotal2 - $InsCotizacionVehiculo->CveImpuesto2,3);
	
	if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId and !empty($InsCotizacionVehiculo->CveTipoCambio)){

		$InsCotizacionVehiculo->CvePrecio2 = round($InsCotizacionVehiculo->CvePrecio2 * $InsCotizacionVehiculo->CveTipoCambio,3);
		$InsCotizacionVehiculo->CveDescuento2 = round($InsCotizacionVehiculo->CveDescuento2 * $InsCotizacionVehiculo->CveTipoCambio,3);

		$InsCotizacionVehiculo->CveTotal2 = round($InsCotizacionVehiculo->CveTotal2 * $InsCotizacionVehiculo->CveTipoCambio,3);
		$InsCotizacionVehiculo->CveImpuesto2 = round($InsCotizacionVehiculo->CveImpuesto2 * $InsCotizacionVehiculo->CveTipoCambio,3);
		$InsCotizacionVehiculo->CveSubTotal2 = round($InsCotizacionVehiculo->CveSubTotal2 * $InsCotizacionVehiculo->CveTipoCambio,3);

	}	
	

/*
*MODELO 2
*/


	$InsCotizacionVehiculo->EinId2 = $_POST['CmpVehiculoIngresoId2'];
	$InsCotizacionVehiculo->CveAnoModelo2 = $_POST['CmpAnoModelo2'];
	$InsCotizacionVehiculo->CveAnoFabricacion2 = $_POST['CmpAnoFabricacion2'];
	$InsCotizacionVehiculo->CveColor2 = $_POST['CmpColor2'];

	$InsCotizacionVehiculo->CveTotalBruto2 = 0;
	
	$InsCotizacionVehiculo->CveCantidad2 =  eregi_replace(",","",(empty($_POST['CmpCantidad2'])?0:$_POST['CmpCantidad2']));
	
	$InsCotizacionVehiculo->CvePrecio2 = eregi_replace(",","",$_POST['CmpPrecio2']);
	$InsCotizacionVehiculo->CveDescuento2 = eregi_replace(",","",$_POST['CmpDescuento2']);
	
	$InsCotizacionVehiculo->CveTotal2 = eregi_replace(",","",$_POST['CmpTotal2']);
	$InsCotizacionVehiculo->CveImpuesto2 = round($InsCotizacionVehiculo->CveTotal2 * ($InsCotizacionVehiculo->CvePorcentajeImpuestoVenta/100),3);
	$InsCotizacionVehiculo->CveSubTotal2 = round($InsCotizacionVehiculo->CveTotal2 - $InsCotizacionVehiculo->CveImpuesto2,3);
	
	if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId and !empty($InsCotizacionVehiculo->CveTipoCambio)){

		$InsCotizacionVehiculo->CvePrecio2 = round($InsCotizacionVehiculo->CvePrecio2 * $InsCotizacionVehiculo->CveTipoCambio,3);
		$InsCotizacionVehiculo->CveDescuento2 = round($InsCotizacionVehiculo->CveDescuento2 * $InsCotizacionVehiculo->CveTipoCambio,3);

		$InsCotizacionVehiculo->CveTotal2 = round($InsCotizacionVehiculo->CveTotal2 * $InsCotizacionVehiculo->CveTipoCambio,3);
		$InsCotizacionVehiculo->CveImpuesto2 = round($InsCotizacionVehiculo->CveImpuesto2 * $InsCotizacionVehiculo->CveTipoCambio,3);
		$InsCotizacionVehiculo->CveSubTotal2 = round($InsCotizacionVehiculo->CveSubTotal2 * $InsCotizacionVehiculo->CveTipoCambio,3);

	}	
	




/*
*MODELO 3
*/


	$InsCotizacionVehiculo->EinId3 = $_POST['CmpVehiculoIngresoId3'];
	$InsCotizacionVehiculo->CveAnoModelo3 = $_POST['CmpAnoModelo3'];
	$InsCotizacionVehiculo->CveAnoFabricacion3 = $_POST['CmpAnoFabricacion3'];
	$InsCotizacionVehiculo->CveColor3 = $_POST['CmpColor3'];

	$InsCotizacionVehiculo->CveTotalBruto3 = 0;
	
	$InsCotizacionVehiculo->CveCantidad3 =  eregi_replace(",","",(empty($_POST['CmpCantidad3'])?0:$_POST['CmpCantidad3']));
	
	$InsCotizacionVehiculo->CvePrecio3 = eregi_replace(",","",$_POST['CmpPrecio3']);
	$InsCotizacionVehiculo->CveDescuento3 = eregi_replace(",","",$_POST['CmpDescuento3']);
	
	$InsCotizacionVehiculo->CveTotal3 = eregi_replace(",","",$_POST['CmpTotal3']);
	$InsCotizacionVehiculo->CveImpuesto3 = round($InsCotizacionVehiculo->CveTotal3 * ($InsCotizacionVehiculo->CvePorcentajeImpuestoVenta/100),3);
	$InsCotizacionVehiculo->CveSubTotal3 = round($InsCotizacionVehiculo->CveTotal3 - $InsCotizacionVehiculo->CveImpuesto3,3);
	
	if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId and !empty($InsCotizacionVehiculo->CveTipoCambio)){

		$InsCotizacionVehiculo->CvePrecio3 = round($InsCotizacionVehiculo->CvePrecio3 * $InsCotizacionVehiculo->CveTipoCambio,3);
		$InsCotizacionVehiculo->CveDescuento3 = round($InsCotizacionVehiculo->CveDescuento3 * $InsCotizacionVehiculo->CveTipoCambio,3);

		$InsCotizacionVehiculo->CveTotal3 = round($InsCotizacionVehiculo->CveTotal3 * $InsCotizacionVehiculo->CveTipoCambio,3);
		$InsCotizacionVehiculo->CveImpuesto3 = round($InsCotizacionVehiculo->CveImpuesto3 * $InsCotizacionVehiculo->CveTipoCambio,3);
		$InsCotizacionVehiculo->CveSubTotal3 = round($InsCotizacionVehiculo->CveSubTotal3 * $InsCotizacionVehiculo->CveTipoCambio,3);

	}	
		
	
	$InsCotizacionVehiculo->CveStatus = $_POST['CmpStatus'];
	$InsCotizacionVehiculo->CveFoto = $_SESSION['SesCveFoto'.$Identificador];
	$InsCotizacionVehiculo->CotizacionVehiculoObsequio = array();
	$InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta = array();

	if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId){
		if(empty($InsCotizacionVehiculo->CveTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_CVE_600';
		}
	}


	if(empty($InsCotizacionVehiculo->CliId)){
		$Guardar = false;
		$Resultado.='#ERR_CVE_123';
	}	
	
	
	foreach($ArrCondicionVentas as $DatCondicionVenta){

		$InsCotizacionVehiculoCondicionVenta1 = new ClsCotizacionVehiculoCondicionVenta();

		$InsCotizacionVehiculoCondicionVenta1->CcvCondicionVenta = $_POST['CmpCondicionVenta_'.$DatCondicionVenta->CovId];

		$InsCotizacionVehiculoCondicionVenta1->CovId = $DatCondicionVenta->CovId;
		$InsCotizacionVehiculoCondicionVenta1->CcvEstado = 1;
		$InsCotizacionVehiculoCondicionVenta1->CcvTiempoCreacion = date("Y-m-d H:i:s");
		$InsCotizacionVehiculoCondicionVenta1->CcvTiempoModificacion = date("Y-m-d H:i:s");
		$InsCotizacionVehiculoCondicionVenta1->CcvEliminado = 1;

		$InsCotizacionVehiculoCondicionVenta1->InsMysql = NULL;
	
		if(!empty($InsCotizacionVehiculoCondicionVenta1->CcvCondicionVenta)){
			$InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta[] = $InsCotizacionVehiculoCondicionVenta1;	
		}

	}


foreach($ArrAccesorios as $DatAccesorio){

		$InsCotizacionVehiculoObsequio1 = new ClsCotizacionVehiculoObsequio();

		$InsCotizacionVehiculoObsequio1->CvoObsequio = $_POST['CmpObsequio_'.$DatAccesorio->ObsId];
		$InsCotizacionVehiculoObsequio1->ObsId = $DatAccesorio->ObsId;
		
		
		$InsCotizacionVehiculoObsequio1->CvoAprobado = 2;
		$InsCotizacionVehiculoObsequio1->CvoEstado = 1;
		$InsCotizacionVehiculoObsequio1->CvoTiempoCreacion = date("Y-m-d H:i:s");
		$InsCotizacionVehiculoObsequio1->CvoTiempoModificacion = date("Y-m-d H:i:s");
		$InsCotizacionVehiculoObsequio1->CvoEliminado = 1;

		$InsCotizacionVehiculoObsequio1->InsMysql = NULL;
	
		if(!empty($InsCotizacionVehiculoObsequio1->CvoObsequio)){
			$InsCotizacionVehiculo->CotizacionVehiculoObsequio[] = $InsCotizacionVehiculoObsequio1;	
		}

	}
	
	

//		SesionObjeto-CotizacionVehiculoFoto
	//		Parametro1 = CvfId
	//		Parametro2 =
	//		Parametro3 = CvfArchivo
	//		Parametro4 = CvfEstado
	//		Parametro5 = CvfTiempoCreacion
	//		Parametro6 = CvfTiempoModificacion
	//		Parametro7 = CvfTipo
		
		$RepSesionObjetos = $_SESSION['InsCotizacionVehiculoFoto'.$Identificador]->MtdObtenerSesionObjetos(true);
		$ArrSesionObjetos = $RepSesionObjetos['Datos'];
		
		if(!empty($ArrSesionObjetos)){
			foreach($ArrSesionObjetos as $DatSesionObjeto){
		
				$InsCotizacionVehiculoFoto1 = new ClsCotizacionVehiculoFoto();
				$InsCotizacionVehiculoFoto1->CvfId = $DatSesionObjeto->Parametro1;
				$InsCotizacionVehiculoFoto1->CvfArchivo = $DatSesionObjeto->Parametro3;
				$InsCotizacionVehiculoFoto1->CvfTipo = $DatSesionObjeto->Parametro7;
				$InsCotizacionVehiculoFoto1->CvfEstado = $DatSesionObjeto->Parametro4;
				$InsCotizacionVehiculoFoto1->CvfTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro5);
				$InsCotizacionVehiculoFoto1->CvfTiempoModificacion = date("Y-m-d H:i:s");
				$InsCotizacionVehiculoFoto1->CvfEliminado = $DatSesionObjeto->Eliminado;
				$InsCotizacionVehiculoFoto1->InsMysql = NULL;
		
				$InsCotizacionVehiculo->CotizacionVehiculoFoto[] = $InsCotizacionVehiculoFoto1;	
		
			}
		}	
	
	if($Guardar){

		if($InsCotizacionVehiculo->MtdRegistrarCotizacionVehiculo()){

			$Registro = true;
			FncNuevo();
			$Resultado.='#SAS_CVE_101';

		} else{

			if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId and !empty($InsCotizacionVehiculo->CveTipoCambio)){
				$InsCotizacionVehiculo->CveTotal = round($InsCotizacionVehiculo->CveTotal / $InsCotizacionVehiculo->CveTipoCambio,3);
				$InsCotizacionVehiculo->CveImpuesto = round($InsCotizacionVehiculo->CveImpuesto / $InsCotizacionVehiculo->CveTipoCambio,3);
				$InsCotizacionVehiculo->CveSubTotal = round($InsCotizacionVehiculo->CveSubTotal / $InsCotizacionVehiculo->CveTipoCambio,3);
			}	

			$InsCotizacionVehiculo->CveFecha = FncCambiaFechaANormal($InsCotizacionVehiculo->CveFecha);
			$InsCotizacionVehiculo->CveFechaVigencia = FncCambiaFechaANormal($InsCotizacionVehiculo->CveFechaVigencia,true);

			$Resultado.='#ERR_CVE_101';
		}

	}else{

		if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId and !empty($InsCotizacionVehiculo->CveTipoCambio)){
			$InsCotizacionVehiculo->CveTotal = round($InsCotizacionVehiculo->CveTotal / $InsCotizacionVehiculo->CveTipoCambio,3);
			$InsCotizacionVehiculo->CveImpuesto = round($InsCotizacionVehiculo->CveImpuesto / $InsCotizacionVehiculo->CveTipoCambio,3);
			$InsCotizacionVehiculo->CveSubTotal = round($InsCotizacionVehiculo->CveSubTotal / $InsCotizacionVehiculo->CveTipoCambio,3);
		}	
	
		$InsCotizacionVehiculo->CveFecha = FncCambiaFechaANormal($InsCotizacionVehiculo->CveFecha);
		$InsCotizacionVehiculo->CveFechaVigencia = FncCambiaFechaANormal($InsCotizacionVehiculo->CveFechaVigencia,true);
		
	}

}else{

	 FncNuevo();
	///	unset($_SESSION['InsCotizacionVehiculoDetalle'.$Identificador]);
}

function FncNuevo(){

	global $InsCotizacionVehiculo;
	global $InsCotizacionVehiculoCondicionVenta1;
	global $ArrCondicionVentas;
	
	unset($_SESSION['SesCveFoto'.$Identificador]);
	unset($_SESSION['InsCotizacionVehiculoFoto'.$Identificador]);

	$_SESSION['InsCotizacionVehiculoFoto'.$Identificador] = new ClsSesionObjeto();
	
	
	$InsCotizacionVehiculo->SucId = $_SESSION['SesionSucursal'];
	$InsCotizacionVehiculo->CveAno = date("Y");
	$InsCotizacionVehiculo->CveMes = date("m");
	$InsCotizacionVehiculo->CveEstado = 3;
	$InsCotizacionVehiculo->MonId = "MON-10001";

	$InsCotizacionVehiculo->PerId = $_SESSION['SesionPersonal'];
	
	$InsCotizacionVehiculo->CveFecha = date("d/m/Y");
	$InsCotizacionVehiculo->CveHora = date("H:i");
	//$InsCotizacionVehiculo->CveFechaVigencia = "19/10/2014";
	$InsCotizacionVehiculo->CveCantidad = 1;
	$InsCotizacionVehiculo->CveGLP = "No";
	$InsCotizacionVehiculo->CveStatus = 1;


	
	$fecha = date_create(date("Y-m-d"));
	date_add($fecha, date_interval_create_from_date_string('7 days'));
	//echo date_format($fecha, 'Y-m-d');
	
	$InsCotizacionVehiculo->CveFechaVigencia = date_format($fecha, 'd/m/Y');


	foreach($ArrCondicionVentas as $DatCondicionVenta){

		$InsCotizacionVehiculoCondicionVenta1 = new ClsCotizacionVehiculoCondicionVenta();
		$InsCotizacionVehiculoCondicionVenta1->CovId = $DatCondicionVenta->CovId;
		$InsCotizacionVehiculoCondicionVenta1->CcvEstado = 1;
		$InsCotizacionVehiculoCondicionVenta1->CcvTiempoCreacion = date("d/m/Y H:i:s");
		$InsCotizacionVehiculoCondicionVenta1->CcvTiempoModificacion = date("d/m/Y H:i:s");
		$InsCotizacionVehiculoCondicionVenta1->InsMysql = NULL;

		$InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta[] = $InsCotizacionVehiculoCondicionVenta1;	

	}

}
?>