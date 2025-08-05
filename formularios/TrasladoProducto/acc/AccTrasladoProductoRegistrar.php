
<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){		
	
	$Resultado = '';
	$Guardar = true;
	
	$InsTrasladoProducto->UsuId = $_SESSION['SesionId'];	
	
	$InsTrasladoProducto->TptId = $_POST['CmpId'];
	//$InsTrasladoProducto->SucId = $_SESSION['SesionSucursal'];
	$InsTrasladoProducto->SucId = $_POST['CmpSucursal'];
	$InsTrasladoProducto->SucIdDestino = $_POST['CmpSucursalDestino'];
	
	$InsTrasladoProducto->CliId =  $_POST['CmpClienteId'];	
	$InsTrasladoProducto->PrvId =  $_POST['CmpProveedorId'];	
	
	$InsTrasladoProducto->AlmId = $_POST['CmpAlmacen'];
	$InsTrasladoProducto->AlmIdDestino = $_POST['CmpAlmacenDestino'];
	
	$InsTrasladoProducto->PerId = $_POST['CmpPersonal'];
	$InsTrasladoProducto->CliId = $_POST['CmpClienteId'];
	$InsTrasladoProducto->PrvId = $_POST['CmpProveedorId'];
	$InsTrasladoProducto->MonId = $_POST['CmpMonedaId'];
	$InsTrasladoProducto->CtiId = $_POST['CmpComprobanteTipo'];
	$InsTrasladoProducto->TopId = $_POST['CmpTipoOperacion'];
	$InsTrasladoProducto->TptIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsTrasladoProducto->TptPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	
	$InsTrasladoProducto->TptReferenciaSerie = $_POST['CmpReferenciaSerie'];
	$InsTrasladoProducto->TptReferenciaNumero = $_POST['CmpReferenciaNumero'];
	
	$InsTrasladoProducto->TptReferencia = $InsTrasladoProducto->TptReferenciaSerie."-".$InsTrasladoProducto->TptReferenciaNumero;	
	$InsTrasladoProducto->TptResponsable = $_POST['CmpResponsable'];
	
	$InsTrasladoProducto->TptFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsTrasladoProducto->TptFechaLlegada = FncCambiaFechaAMysql($_POST['CmpFechaLlegada']);
	
	$InsTrasladoProducto->TptObservacion = addslashes($_POST['CmpObservacion']);	
	$InsTrasladoProducto->TptObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);	
	
	$InsTrasladoProducto->TptPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsTrasladoProducto->TptIncluyeImpuesto = $_POST['CmpPorcentajeImpuestoVenta'];

	$InsTrasladoProducto->TptEstado = $_POST['CmpEstado'];
	$InsTrasladoProducto->TptTiempoCreacion = date("Y-m-d H:i:s");
	$InsTrasladoProducto->TptTiempoModificacion = date("Y-m-d H:i:s");	

	$InsTrasladoProducto->TptFoto = $_SESSION['SesTptFoto'.$Identificador];
	
	$InsTrasladoProducto->TptSubTotal = 0;
	$InsTrasladoProducto->TptImpuesto = 0;
	$InsTrasladoProducto->TptTotal = 0;
	
	$InsTrasladoProducto->TrasladoProductoDetalle = array();

	if(empty($InsTrasladoProducto->SucId)){
		$Guardar = false;
		$Resultado.='#ERR_TPT_112';
	}
	
	if(empty($InsTrasladoProducto->SucIdDestino)){
		$Guardar = false;
		$Resultado.='#ERR_TPT_112';
	}

	
	/*
	SesionObjeto-TrasladoProductoDetalle
	Parametro1 = TpdId
	Parametro2 = ProId
	Parametro3 = ProNombre
	Parametro4 = TpdPrecio
	Parametro5 = TpdCantidad
	Parametro6 = TpdImporte
	Parametro7 = TpdTiempoCreacion
	Parametro8 = TpdTiempoModificacion
	Parametro9 = UmeNombre
	Parametro10 = UmeId
	Parametro11 = RtiId
	Parametro12 = TpdCantidadReal
	Parametro13 = ProCodigoOriginal,
	Parametro14 = ProCodigoAlternativo
	Parametro15 = UmeIdOrigen
	Parametro16 = VerificarStock
	Parametro17 = TpdCosto
	*/
	
	
	$ResTrasladoProductoDetalle = $_SESSION['InsTrasladoProductoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResTrasladoProductoDetalle['Datos'])){
		$item = 1;
		foreach($ResTrasladoProductoDetalle['Datos'] as $DatSesionObjeto){
				
			$InsTrasladoProductoDetalle1 = new ClsTrasladoProductoDetalle();
			$InsTrasladoProductoDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsTrasladoProductoDetalle1->UmeId = $DatSesionObjeto->Parametro10;

			$InsTrasladoProductoDetalle1->TpdCosto = $DatSesionObjeto->Parametro17;
			$InsTrasladoProductoDetalle1->TpdCantidad = $DatSesionObjeto->Parametro5;
			$InsTrasladoProductoDetalle1->TpdCantidadReal = $DatSesionObjeto->Parametro12;
			$InsTrasladoProductoDetalle1->TpdImporte = $DatSesionObjeto->Parametro6;
			
			$InsTrasladoProductoDetalle1->TpdEstado = $DatSesionObjeto->Parametro19;
			$InsTrasladoProductoDetalle1->TpdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsTrasladoProductoDetalle1->TpdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsTrasladoProductoDetalle1->TpdEliminado = $DatSesionObjeto->Eliminado;				
			$InsTrasladoProductoDetalle1->InsMysql = NULL;

			if($InsTrasladoProductoDetalle1->TpdEliminado==1){	
				
				$InsTrasladoProducto->TrasladoProductoDetalle[] = $InsTrasladoProductoDetalle1;				
					
			}

			$item++;	
		}

	}else{
		$Guardar = false;
		$Resultado.='#ERR_TPT_111';
	}
	
	if($Guardar){
		if($InsTrasladoProducto->MtdRegistrarTrasladoProducto()){
			
			FncNuevo();
			$Registro = true;
			$Resultado.='#SAS_TPT_101';
			
		} else{
			
			$InsTrasladoProducto->TptFecha = FncCambiaFechaANormal($InsTrasladoProducto->TptFecha);
			$InsTrasladoProducto->TptFechaLlegada = FncCambiaFechaANormal($InsTrasladoProducto->TptFechaLlegada);
			$Resultado.='#ERR_TPT_101';
		}		
	}else{
		
		$InsTrasladoProducto->TptFecha = FncCambiaFechaANormal($InsTrasladoProducto->TptFecha);
		$InsTrasladoProducto->TptFechaLlegada = FncCambiaFechaANormal($InsTrasladoProducto->TptFechaLlegada);
			
	}

	
}else{

	FncNuevo();

}

function FncNuevo(){

	global $InsTrasladoProducto;
	global $Identificador;
	global $EmpresaImpuestoVenta;
	global $EmpresaMonedaId;
	
	unset($_SESSION['InsTrasladoProductoDetalle'.$Identificador]);
		
	$_SESSION['InsTrasladoProductoDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsTrasladoProducto = new ClsTrasladoProducto();
	
	$InsTrasladoProducto->TptEstado = 3;
	$InsTrasladoProducto->AlmId = NULL;
	
	$InsTrasladoProducto->SucId = $_SESSION['SesionSucursal'];
	$InsTrasladoProducto->TptResponsable = $_SESSION['SesionNombre'];
	$InsTrasladoProducto->PerId = $_SESSION['SesionPersonal'];
	
	$InsTrasladoProducto->CtiId = "CTI-10006";
	$InsTrasladoProducto->TopId = "TOP-10010";
	$InsTrasladoProducto->MonId = $EmpresaMonedaId;
	$InsTrasladoProducto->TptIncluyeImpuesto = 1;
	$InsTrasladoProducto->TptPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	
	
	$InsProveedor = new ClsProveedor();	
	
	//MtdObtenerProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PrvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL) 
	$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,"PrvNombre","ASC",1,"1","PRINCIPAL");
	$ArrProveedores = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){
		
			$ProveedorId = $DatProveedor->PrvId;
			
		}
	}
	$InsTrasladoProducto->PrvId = $ProveedorId;
	
	
	$InsCliente = new ClsCliente();
	
	$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"PRINCIPAL");
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
		
			$ClienteId = $DatCliente->CliId;
		

		}
	}
	
	$InsTrasladoProducto->CliId = $ClienteId;
	
}

?>