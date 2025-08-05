<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsTrasladoVehiculo->UsuId = $_SESSION['SesionId'];	

	$InsTrasladoVehiculo->TveId = $_POST['CmpId'];
	$InsTrasladoVehiculo->PerId = $_POST['CmpPersonal'];	
	$InsTrasladoVehiculo->SucId = $_POST['CmpSucursal'];	
	$InsTrasladoVehiculo->SucIdDestino = $_POST['CmpSucursalDestino'];	
	
	$InsTrasladoVehiculo->CliId = $_POST['CmpClienteId'];
	$InsTrasladoVehiculo->PrvId = $_POST['CmpProveedorId'];
	$InsTrasladoVehiculo->MonId = $_POST['CmpMonedaId'];
	$InsTrasladoVehiculo->CtiId = $_POST['CmpComprobanteTipo'];
	$InsTrasladoVehiculo->TopId = $_POST['CmpTipoOperacion'];
	$InsTrasladoVehiculo->TveIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsTrasladoVehiculo->TvePorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	
	$InsTrasladoVehiculo->TveReferenciaSerie = $_POST['CmpReferenciaSerie'];
	$InsTrasladoVehiculo->TveReferenciaNumero = $_POST['CmpReferenciaNumero'];
	$InsTrasladoVehiculo->TveReferencia = $InsTrasladoVehiculo->TveReferenciaSerie."-".$InsTrasladoVehiculo->TveReferenciaNumero;

	$InsTrasladoVehiculo->TveFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsTrasladoVehiculo->TveFechaLlegada = FncCambiaFechaAMysql($_POST['CmpFechaLlegada']);
	
	$InsTrasladoVehiculo->TveObservacionInterna = addslashes($_POST['CmpObservacionInterna']);
	$InsTrasladoVehiculo->TveObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	
	$InsTrasladoVehiculo->TveRevisado = 2;
	$InsTrasladoVehiculo->TveEstado = $_POST['CmpEstado'];
	
	$InsTrasladoVehiculo->TveTiempoCreacion = date("Y-m-d H:i:s");
	$InsTrasladoVehiculo->TveTiempoModificacion = date("Y-m-d H:i:s");
	$InsTrasladoVehiculo->TveEliminado = 1;
	
	$InsTrasladoVehiculo->TveFoto = $_SESSION['SesTveFoto'.$Identificador];

	$InsTrasladoVehiculo->TrasladoVehiculoDetalle = array();
	

	if(empty($InsTrasladoVehiculo->SucIdDestino)){
		$Guardar = false;
		$Resultado.='#ERR_TVE_602';
	}
	

	
//SesionObjeto-TrasladoVehiculoDetalle
//Parametro1 = TvdId
//Parametro2 = EinId
//Parametro3 = EinVIN

//Parametro4 = 
//Parametro5 = TvdCantidad
//Parametro6 = 
//Parametro7 = TvdTiempoCreacion
//Parametro8 = TvdTiempoModificacion

//Parametro9 = EinNumeroMotor
//Parametro10 = EinAnoFabricacion
//Parametro11 = EinAnoModelo
//Parametro12 = VehId

//Parametro13 = 
//Parametro14 = 
//Parametro15 = TvdObservacion
//Parametro16 = UmeId
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = TvdEstado

	$ResTrasladoVehiculoDetalle = $_SESSION['InsTrasladoVehiculoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
	
	if(!empty($ResTrasladoVehiculoDetalle['Datos'])){
		foreach($ResTrasladoVehiculoDetalle['Datos'] as $DatSesionObjeto){
			
			$InsTrasladoVehiculoDetalle1 = new ClsTrasladoVehiculoDetalle();
			$InsTrasladoVehiculoDetalle1->TvdId = $DatSesionObjeto->Parametro1;

			$InsTrasladoVehiculoDetalle1->EinId = $DatSesionObjeto->Parametro2;
			$InsTrasladoVehiculoDetalle1->VehId = $DatSesionObjeto->Parametro12;
			$InsTrasladoVehiculoDetalle1->UmeId = $DatSesionObjeto->Parametro16;

			$InsTrasladoVehiculoDetalle1->TvdCantidad = $DatSesionObjeto->Parametro5;
			$InsTrasladoVehiculoDetalle1->TvdCosto = 0;
			$InsTrasladoVehiculoDetalle1->TvdImporte = 0;
			
			$InsTrasladoVehiculoDetalle1->TvdObservacion = $DatSesionObjeto->Parametro15;
		
			$InsTrasladoVehiculoDetalle1->TvdEstado = $DatSesionObjeto->Parametro25;
			$InsTrasladoVehiculoDetalle1->TvdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsTrasladoVehiculoDetalle1->TvdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);
			$InsTrasladoVehiculoDetalle1->TvdEliminado = $DatSesionObjeto->Eliminado;				
			$InsTrasladoVehiculoDetalle1->InsMysql = NULL;

			if($InsTrasladoVehiculoDetalle1->TvdEliminado==1){	
							
				$InsTrasladoVehiculo->TrasladoVehiculoDetalle[] = $InsTrasladoVehiculoDetalle1;		
			
			}
		}		
		
	}else{
		//$Guardar = false;
		//$Resultado.='#ERR_TVE_111';
	}

	

	if($Guardar){

		if($InsTrasladoVehiculo->MtdRegistrarTrasladoVehiculo()){

		/*	if($_POST['CmpNotificar']=="1"){
				
				$InsTrasladoVehiculo->MtdNotificarTrasladoVehiculoRegistro($InsTrasladoVehiculo->TveId,$CorreosNotificacionTrasladoVehiculoRegistro,false);
				
				
			}*/
			
			FncNuevo();
		
			$Resultado.='#SAS_TVE_101';
			$Registro = true;
		}else{
			
			$InsTrasladoVehiculo->TveFecha = FncCambiaFechaANormal($InsTrasladoVehiculo->TveFecha);
			$InsTrasladoVehiculo->TveFechaLlegada = FncCambiaFechaANormal($InsTrasladoVehiculo->TveFechaLlegada);
		
			$Resultado.='#ERR_TVE_101';	
		}
			
	}else{
		
			$InsTrasladoVehiculo->TveFecha = FncCambiaFechaANormal($InsTrasladoVehiculo->TveFecha);
			$InsTrasladoVehiculo->TveFechaLlegada = FncCambiaFechaANormal($InsTrasladoVehiculo->TveFechaLlegada);
			
	}
	


}else{

	FncNuevo();
	
	switch($GET_Ori){
		
		case "OrdenCompra":
			

		break;
	}
}



function FncNuevo(){

	global $Identificador;
	global $InsTrasladoVehiculo;
	
	global $EmpresaMonedaId;
	global $EmpresaImpuestoVenta;
		
	unset($_SESSION['InsTrasladoVehiculoDetalle'.$Identificador]);
	
	unset($_SESSION['SesTveFoto'.$Identificador]);
	
	$_SESSION['InsTrasladoVehiculoDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsTrasladoVehiculo = new ClsTrasladoVehiculo();
	$InsTrasladoVehiculo->TveEstado = 3;
	$InsTrasladoVehiculo->SucId = $_SESSION['SesionSucursal'];
	$InsTrasladoVehiculo->PerId = $_SESSION['SesionPersonal'];
	
	$InsTrasladoVehiculo->CtiId = "CTI-10006";
	$InsTrasladoVehiculo->TopId = "TOP-10010";
	$InsTrasladoVehiculo->MonId = $EmpresaMonedaId;
	$InsTrasladoVehiculo->TveIncluyeImpuesto = 2;
	$InsTrasladoVehiculo->TvePorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	
	
	
	$InsProveedor = new ClsProveedor();	
	
	//MtdObtenerProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PrvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL) 
	$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,"PrvNombre","ASC",1,"1","PRINCIPAL");
	$ArrProveedores = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){
		
			$ProveedorId = $DatProveedor->PrvId;
			
		}
	}
	$InsTrasladoVehiculo->PrvId = $ProveedorId;
	
	
	$InsCliente = new ClsCliente();
	
	$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"PRINCIPAL");
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
		
			$ClienteId = $DatCliente->CliId;
		

		}
	}
	
	$InsTrasladoVehiculo->CliId = $ClienteId;
	

}
?>