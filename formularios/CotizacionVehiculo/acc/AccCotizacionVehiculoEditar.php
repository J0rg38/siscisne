<?php
//Si se hizo click en guardar	
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

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
	$InsCotizacionVehiculo->CveObservacion = addslashes(($_POST['CmpObservacion']));
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
	$InsCotizacionVehiculo->CveGLP = $_POST['CmpGLP'];	
	$InsCotizacionVehiculo->CveEstado = $_POST['CmpEstado'];
	$InsCotizacionVehiculo->CveCotizoOtroLugar = $_POST['CmpCotizoOtroLugar'];	
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
		$InsCotizacionVehiculoCondicionVenta1->CcvId = $_POST['CmpCotizacionVehiculoCondicionVentaId_'.$DatCondicionVenta->CovId];
		$InsCotizacionVehiculoCondicionVenta1->CcvCondicionVenta = $_POST['CmpCondicionVenta_'.$DatCondicionVenta->CovId];
		$InsCotizacionVehiculoCondicionVenta1->CovId = $DatCondicionVenta->CovId;
		$InsCotizacionVehiculoCondicionVenta1->CcvEstado = 1;
		$InsCotizacionVehiculoCondicionVenta1->CcvTiempoCreacion = date("Y-m-d H:i:s");
		$InsCotizacionVehiculoCondicionVenta1->CcvTiempoModificacion = date("Y-m-d H:i:s");
		
		if(!empty($InsCotizacionVehiculoCondicionVenta1->CcvId)){
			if(empty($InsCotizacionVehiculoCondicionVenta1->CcvCondicionVenta)){
				$InsCotizacionVehiculoCondicionVenta1->CcvEliminado = 2;
			}else{
				$InsCotizacionVehiculoCondicionVenta1->CcvEliminado = 1;
			}
		}else{
			if(empty($InsCotizacionVehiculoCondicionVenta1->CcvCondicionVenta)){
				$InsCotizacionVehiculoCondicionVenta1->CcvEliminado = 2;
			}else{
				$InsCotizacionVehiculoCondicionVenta1->CcvEliminado = 1;
			}
		}

		$InsCotizacionVehiculoCondicionVenta1->InsMysql = NULL;
		$InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta[] = $InsCotizacionVehiculoCondicionVenta1;	

	}
	
	foreach($ArrAccesorios as $DatAccesorio){

		$InsCotizacionVehiculoObsequio1 = new ClsCotizacionVehiculoObsequio();
		$InsCotizacionVehiculoObsequio1->CvoId = $_POST['CmpCotizacionVehiculoObsequioId_'.$DatAccesorio->ObsId];
		$InsCotizacionVehiculoObsequio1->CvoObsequio = $_POST['CmpObsequio_'.$DatAccesorio->ObsId];
		$InsCotizacionVehiculoObsequio1->ObsId = $DatAccesorio->ObsId;
		$InsCotizacionVehiculoObsequio1->CvoAprobado = 2;
		$InsCotizacionVehiculoObsequio1->CvoEstado = 1;
		$InsCotizacionVehiculoObsequio1->CvoTiempoCreacion = date("Y-m-d H:i:s");
		$InsCotizacionVehiculoObsequio1->CvoTiempoModificacion = date("Y-m-d H:i:s");
		
		if(!empty($InsCotizacionVehiculoObsequio1->CvoId)){
			if(empty($InsCotizacionVehiculoObsequio1->CvoObsequio)){
				$InsCotizacionVehiculoObsequio1->CvoEliminado = 2;
			}else{
				$InsCotizacionVehiculoObsequio1->CvoEliminado = 1;
			}
		}else{
			if(empty($InsCotizacionVehiculoObsequio1->CvoObsequio)){
				$InsCotizacionVehiculoObsequio1->CvoEliminado = 2;
			}else{
				$InsCotizacionVehiculoObsequio1->CvoEliminado = 1;
			}
		}
	
		$InsCotizacionVehiculoObsequio1->InsMysql = NULL;
		$InsCotizacionVehiculo->CotizacionVehiculoObsequio[] = $InsCotizacionVehiculoObsequio1;	

	}

//	deb($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta);
//	for($i=1;$i<6;$i++){
//
//		$InsCotizacionVehiculoObsequio1 = new ClsCotizacionVehiculoObsequio();
//		//$InsCotizacionVehiculoObsequio1->CvoId = NULL;
//		$InsCotizacionVehiculoObsequio1->CvoId = $_POST['CmpCotizacionVehiculoObsequioId_'.$i];
//		echo $InsCotizacionVehiculoObsequio1->CvoObsequio = $_POST['CmpObsequio_'.$i];
//
//		if(!empty($InsCotizacionVehiculoObsequio1->CvoId)){
//			if(empty($InsCotizacionVehiculoObsequio1->CvoObsequio)){
//				$InsCotizacionVehiculoObsequio1->CvoEliminado = 2;
//			}else{
//				$InsCotizacionVehiculoObsequio1->CvoEliminado = 1;
//			}
//		}else{
//			if(empty($InsCotizacionVehiculoObsequio1->CvoObsequio)){
//				$InsCotizacionVehiculoObsequio1->CvoEliminado = 2;
//			}else{
//				$InsCotizacionVehiculoObsequio1->CvoEliminado = 1;
//			}
//		}
//
//		$InsCotizacionVehiculoObsequio1->InsMysql = NULL;
//		$InsCotizacionVehiculo->CotizacionVehiculoObsequio[] = $InsCotizacionVehiculoObsequio1;	
//
//	}


	
	//		SesionObjeto-CotizacionVehiculoFoto
	//		Parametro1 = CvfId
	//		Parametro2 =
	//		Parametro3 = CvfArchivo
	//		Parametro4 = CvfEstado
	//		Parametro5 = CvfTiempoCreacion
	//		Parametro6 = CvfTiempoModificacion
	//		Parametro7 = CvfTipo
	
	$RepSesionObjetos = $_SESSION['InsCotizacionVehiculoFoto'.$Identificador]->MtdObtenerSesionObjetos(false);
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
		if($InsCotizacionVehiculo->MtdEditarCotizacionVehiculo()){
			$Edito = true;		
			FncCargarDatos();
			$Resultado.='#SAS_CVE_102';
		} else{
	
			$InsCotizacionVehiculo->CveFecha = FncCambiaFechaANormal($InsCotizacionVehiculo->CveFecha);
			$InsCotizacionVehiculo->CveFechaVigencia = FncCambiaFechaANormal($InsCotizacionVehiculo->CveFechaVigencia,true);
				
			if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId and !empty($InsCotizacionVehiculo->CveTipoCambio)){
				$InsCotizacionVehiculo->CveTotal = round($InsCotizacionVehiculo->CveTotal / $InsCotizacionVehiculo->CveTipoCambio,3);
				$InsCotizacionVehiculo->CveImpuesto = round($InsCotizacionVehiculo->CveImpuesto / $InsCotizacionVehiculo->CveTipoCambio,3);
				$InsCotizacionVehiculo->CveSubTotal = round($InsCotizacionVehiculo->CveSubTotal / $InsCotizacionVehiculo->CveTipoCambio,3);
			}	

			$Resultado.='#ERR_CVE_102';		
		}			
	}else{

		$InsCotizacionVehiculo->CveFecha = FncCambiaFechaANormal($InsCotizacionVehiculo->CveFecha);
		$InsCotizacionVehiculo->CveFechaVigencia = FncCambiaFechaANormal($InsCotizacionVehiculo->CveFechaVigencia,true);
			
		if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId and !empty($InsCotizacionVehiculo->CveTipoCambio)){
			$InsCotizacionVehiculo->CveTotal = round($InsCotizacionVehiculo->CveTotal / $InsCotizacionVehiculo->CveTipoCambio,3);
			$InsCotizacionVehiculo->CveImpuesto = round($InsCotizacionVehiculo->CveImpuesto / $InsCotizacionVehiculo->CveTipoCambio,3);
			$InsCotizacionVehiculo->CveSubTotal = round($InsCotizacionVehiculo->CveSubTotal / $InsCotizacionVehiculo->CveTipoCambio,3);
		}	
		
	}

	

}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsCotizacionVehiculo;
	global $EmpresaMonedaId;
	
	unset($_SESSION['SesCveFoto'.$Identificador]);
	unset($_SESSION['InsCotizacionVehiculoFoto'.$Identificador]);
	
				
	$_SESSION['SesCveFoto'.$Identificador] =	$InsCotizacionVehiculo->ProFoto;
	$_SESSION['InsCotizacionVehiculoFoto'.$Identificador] = new ClsSesionObjeto();
//	unset($_SESSION['InsCotizacionVehiculoDetalle'.$Identificador]);

//	$_SESSION['InsCotizacionVehiculoDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsCotizacionVehiculo->CveId = $GET_id;
	$InsCotizacionVehiculo->MtdObtenerCotizacionVehiculo();		

//	deb($InsCotizacionVehiculo->CotizacionVehiculoObsequio);
	$_SESSION['SesCveFoto'.$Identificador] =	$InsCotizacionVehiculo->CveFoto;
	//deb($InsCotizacionVehiculo->MonId." - ".$EmpresaMonedaId." ".$InsCotizacionVehiculo->CveTipoCambio);

	//if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId and !empty($InsCotizacionVehiculo->CveTipoCambio)){
  if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId ){
	  
  //	deb("afdsds");
	  $InsCotizacionVehiculo->CvePrecio = round($InsCotizacionVehiculo->CvePrecio / $InsCotizacionVehiculo->CveTipoCambio,3);
	  $InsCotizacionVehiculo->CveDescuento = round($InsCotizacionVehiculo->CveDescuento / $InsCotizacionVehiculo->CveTipoCambio,3);
	  
	  $InsCotizacionVehiculo->CveTotal = round($InsCotizacionVehiculo->CveTotal / $InsCotizacionVehiculo->CveTipoCambio,3);
	  $InsCotizacionVehiculo->CveImpuesto = round($InsCotizacionVehiculo->CveImpuesto / $InsCotizacionVehiculo->CveTipoCambio,3);
	  $InsCotizacionVehiculo->CveSubTotal = round($InsCotizacionVehiculo->CveSubTotal / $InsCotizacionVehiculo->CveTipoCambio,3);
  }	
  
  
  
  		//		SesionObjeto-CotizacionVehiculoFoto
	//		Parametro1 = CvfId
	//		Parametro2 =
	//		Parametro3 = CvfArchivo
	//		Parametro4 = CvfEstado
	//		Parametro5 = CvfTiempoCreacion
	//		Parametro6 = CvfTiempoModificacion
	//		Parametro7 = CvfTipo
		
//		deb($InsCotizacionVehiculo->CotizacionVehiculoFoto);
	if(!empty($InsCotizacionVehiculo->CotizacionVehiculoFoto)){
		foreach($InsCotizacionVehiculo->CotizacionVehiculoFoto as $DatCotizacionVehiculoFoto){
			
			$_SESSION['InsCotizacionVehiculoFoto'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatCotizacionVehiculoFoto->CvfId,
			NULL,
			$DatCotizacionVehiculoFoto->CvfArchivo,			
			$DatCotizacionVehiculoFoto->CvfEstado,
			($DatCotizacionVehiculoFoto->CvfTiempoCreacion),
			($DatCotizacionVehiculoFoto->CvfTiempoModificacion),
			$DatCotizacionVehiculoFoto->CvfTipo
			);
	
		}
	}	

	//deb($InsCotizacionVehiculo->CvePrecio);
	
//	if(is_array($InsCotizacionVehiculo->CotizacionVehiculoDetalle)){
//		foreach($InsCotizacionVehiculo->CotizacionVehiculoDetalle as $DatCotizacionVehiculoDetalle){
//
//			if($InsCotizacionVehiculo->MonId<>$EmpresaMonedaId and (!empty($InsCotizacionVehiculo->CveTipoCambio) )){
//				$DatCotizacionVehiculoDetalle->CvdImporte = round($DatCotizacionVehiculoDetalle->CvdImporte / $InsCotizacionVehiculo->CveTipoCambio,2);
//				$DatCotizacionVehiculoDetalle->CvdPrecio = round($DatCotizacionVehiculoDetalle->CvdPrecio  / $InsCotizacionVehiculo->CCveTipoCambio,2);
//			}
//			
///*
//SesionObjeto-CotizacionVehiculoDetalle
//Parametro1 = CvdId
//Parametro2 = ProId
//Parametro3 = ProNombre
//Parametro4 = CvdPrecio
//Parametro5 = CvdCantidad
//Parametro6 = CvdImporte
//Parametro7 = CvdTiempoCreacion
//Parametro8 = CvdTiempoModificacion
//Parametro9 = UmeNombre
//Parametro10 = UmeId
//Parametro11 = RtiId
//Parametro12 = CvdCantidadReal
//Parametro13 = ProCodigoOriginal
//Parametro14 = ProCodigoAlternativo
//*/
//
//		
//			$_SESSION['InsCotizacionVehiculoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//			$DatCotizacionVehiculoDetalle->CvdId,
//			$DatCotizacionVehiculoDetalle->ProId,
//			$DatCotizacionVehiculoDetalle->ProNombre,
//			$DatCotizacionVehiculoDetalle->CvdPrecio,
//			$DatCotizacionVehiculoDetalle->CvdCantidad,
//			$DatCotizacionVehiculoDetalle->CvdImporte,
//			($DatCotizacionVehiculoDetalle->CvdTiempoCreacion),
//			($DatCotizacionVehiculoDetalle->CvdTiempoModificacion),
//			$DatCotizacionVehiculoDetalle->UmeNombre,
//			$DatCotizacionVehiculoDetalle->UmeId,
//			$DatCotizacionVehiculoDetalle->RtiId,
//			$DatCotizacionVehiculoDetalle->CvdCantidadReal,
//			$DatCotizacionVehiculoDetalle->ProCodigoOriginal,
//			$DatCotizacionVehiculoDetalle->ProCodigoAlternativo);
//		
//		}
//	}
	
	

	
}
?>