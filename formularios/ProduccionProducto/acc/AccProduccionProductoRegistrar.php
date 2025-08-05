 <?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){		
	
	$Resultado = '';
	$Guardar = true;
	
	$InsProduccionProducto->UsuId = $_SESSION['SesionId'];	
	$InsProduccionProducto->SucId = $_SESSION['SesionSucursal'];
	
	$InsProduccionProducto->PerId = $_POST['CmpPersonal'];
	$InsProduccionProducto->AlmId = $_POST['CmpAlmacen'];

	$InsProduccionProducto->TopId = "TOP-10021";
	$InsProduccionProducto->CtiId = "CTI-10006";
	
	$InsProduccionProducto->CliId = "CLI-1000";
	$InsProduccionProducto->PrvId = "PRV-1000";
		
	$InsProduccionProducto->PprFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	
	list($InsProduccionProducto->PprAno,$Mes,$Dia) = explode("-",$InsProduccionProducto->PprFecha);	
	$InsProduccionProducto->PprObservacion = addslashes($_POST['CmpObservacion']);

	$InsProduccionProducto->MonId = $_POST['CmpMonedaId'];
	$InsProduccionProducto->PprTipoCambio = $_POST['CmpTipoCambio'];

	$InsProduccionProducto->PprPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsProduccionProducto->PprIncluyeImpuesto = 1;
	
	$InsProduccionProducto->PprEstado = $_POST['CmpEstado'];
	$InsProduccionProducto->PprTiempoCreacion = date("Y-m-d H:i:s");
	$InsProduccionProducto->PprTiempoModificacion = date("Y-m-d H:i:s");

	$InsProduccionProducto->PprTotal = 0;


	if(empty($InsProduccionProducto->AlmId )){
		$Guardar = false;
		$Resultado.='#ERR_PPR_112';		
	}


/*
SesionObjeto-ProduccionProductoDetalle
Parametro1 = PpdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = PpdCosto
Parametro5 = PpdCantidad
Parametro6 = PpdCantidadReal
Parametro7 = PpdTiempoCreacion
Parametro8 = PpdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = 
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = PpdEstado
Parametro17 = PpdCantidadRealAnterior
Parametro18 = PpdImporte
*/

	$ResProduccionProductoDetalleEntrada = $_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResProduccionProductoDetalleEntrada['Datos'])){
		$item = 1;
		foreach($ResProduccionProductoDetalleEntrada['Datos'] as $DatSesionObjeto){
				
			$InsProduccionProductoDetalle1 = new ClsProduccionProductoDetalle();
			$InsProduccionProductoDetalle1->PpdId = $DatSesionObjeto->Parametro1;
			$InsProduccionProductoDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsProduccionProductoDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			
			$InsProduccionProductoDetalle1->PpdCantidad = $DatSesionObjeto->Parametro5;
			$InsProduccionProductoDetalle1->PpdCantidadReal = $DatSesionObjeto->Parametro6;

			$InsProduccionProductoDetalle1->PpdCosto = $DatSesionObjeto->Parametro4;
			$InsProduccionProductoDetalle1->PpdPrecio= 0;
			$InsProduccionProductoDetalle1->PpdImporte = $DatSesionObjeto->Parametro18;
			
//			deb();
			$InsProduccionProductoDetalle1->PpdEstado = $InsProduccionProducto->PprEstado;
			$InsProduccionProductoDetalle1->PpdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsProduccionProductoDetalle1->PpdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsProduccionProductoDetalle1->PpdEliminado = $DatSesionObjeto->Eliminado;				
			$InsProduccionProductoDetalle1->InsMysql = NULL;

			if($InsProduccionProductoDetalle1->PpdEliminado==1){					
				$InsProduccionProducto->ProduccionProductoDetalleEntrada[] = $InsProduccionProductoDetalle1;		
			}
			
			$item++;	
		}

	}else{
		$Guardar = false;
		$Resultado.='#ERR_PPR_111';
	}
	
	
	
			/*
			SesionObjeto-ProduccionProductoDetalle
			Parametro1 = PpdId
			Parametro2 = ProId
			Parametro3 = ProNombre
			Parametro4 = PpdCosto
			Parametro5 = PpdCantidad
			Parametro6 = PpdCantidadReal
			Parametro7 = PpdTiempoCreacion
			Parametro8 = PpdTiempoModificacion
			Parametro9 = UmeNombre
			Parametro10 = UmeId
			Parametro11 = RtiId
			Parametro12 = PpdTipo
			Parametro13 = ProCodigoOriginal,
			Parametro14 = ProCodigoAlternativo
			Parametro15 = UmeIdOrigen
			Parametro16 = PpdEstado,
			Parametro17 = PpdCantidadRealAnterior
			Parametro18 = PpdImporte
			*/	
			
	$ResProduccionProductoDetalleSalida = $_SESSION['InsProduccionProductoDetalleSalida'.$Identificador]->MtdObtenerSesionObjetos(true);

//deb($ResProduccionProductoDetalleSalida['Datos']);
	if(!empty($ResProduccionProductoDetalleSalida['Datos'])){
		$item = 1;
		foreach($ResProduccionProductoDetalleSalida['Datos'] as $DatSesionObjeto){
				
			$InsProduccionProductoDetalle1 = new ClsProduccionProductoDetalle();
			$InsProduccionProductoDetalle1->PpdId = $DatSesionObjeto->Parametro1;
			$InsProduccionProductoDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsProduccionProductoDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			$InsProduccionProductoDetalle1->PpdCantidad = $DatSesionObjeto->Parametro5;
			$InsProduccionProductoDetalle1->PpdCantidadReal = $DatSesionObjeto->Parametro6;
			
			$InsProduccionProductoDetalle1->PpdCosto = $DatSesionObjeto->Parametro4;
			$InsProduccionProductoDetalle1->PpdPrecio = $DatSesionObjeto->Parametro4;
			$InsProduccionProductoDetalle1->PpdImporte = $DatSesionObjeto->Parametro18;
			
///			deb($InsProduccionProductoDetalle1->PpdImporte);
			$InsProduccionProductoDetalle1->PpdEstado = $InsProduccionProducto->PprEstado;
			$InsProduccionProductoDetalle1->PpdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsProduccionProductoDetalle1->PpdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsProduccionProductoDetalle1->PpdEliminado = $DatSesionObjeto->Eliminado;				
			$InsProduccionProductoDetalle1->InsMysql = NULL;

			if($InsProduccionProductoDetalle1->PpdEliminado==1){					
				$InsProduccionProducto->ProduccionProductoDetalleSalida[] = $InsProduccionProductoDetalle1;		
			}
			
			$item++;	
		}

	}else{
		$Guardar = false;
		$Resultado.='#ERR_PPR_111';
	}
	
	

	if($Guardar){

		if($InsProduccionProducto->MtdRegistrarProduccionProducto()){
			
			unset($InsProduccionProducto);
			FncNuevo();

			$Registro = true;
			$Resultado.='#SAS_PPR_101';

		}else{

			$InsProduccionProducto->PprFecha = FncCambiaFechaANormal($InsProduccionProducto->PprFecha);
			
			$Resultado.='#ERR_PPR_101';

		}		

	}else{

		$InsProduccionProducto->PprFecha = FncCambiaFechaANormal($InsProduccionProducto->PprFecha);	
		
	}

	

}else{
	
	FncNuevo();
	
}

function FncNuevo(){

	global $Identificador;
	global $InsProduccionProducto;
	global $InsTipoCambio;
	global $EmpresaImpuestoVenta;
	global $EmpresaMonedaId;

	unset($_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador]);
	unset($_SESSION['InsProduccionProductoDetalleSalida'.$Identificador]);

	$_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsProduccionProductoDetalleSalida'.$Identificador] = new ClsSesionObjeto();

	$InsProduccionProducto->PprFecha = date("d/m/Y");
	
	
	$InsProduccionProducto->PprEstado = 3;
	$InsProduccionProducto->AlmId = "ALM-10000";
	
	$InsProduccionProducto->TopId = "TOP-10010";
	$InsProduccionProducto->CtiId = "CTI-10006";
	
	$InsProduccionProducto->MonId = $EmpresaMonedaId;
	$InsProduccionProducto->PprPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsProduccionProducto->SucId = $_SESSION['SesionSucursal'];
}
?>