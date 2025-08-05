 <?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){		
	
	$Resultado = '';
	$Guardar = true;
	
	$InsOrdenCotizacion->UsuId = $_SESSION['SesionId'];	
	$InsOrdenCotizacion->SucId = $_SESSION['SesionSucursal'];	
	
	$InsOrdenCotizacion->OotId = $_POST['CmpId'];
	$InsOrdenCotizacion->PrvId = $_POST['CmpProveedorId'];
	$InsOrdenCotizacion->PerId = $_POST['CmpPersonal'];	
	
	$InsOrdenCotizacion->OotFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsOrdenCotizacion->OotFechaRespuesta = FncCambiaFechaAMysql($_POST['CmpFechaRespuesta'],true);
	$InsOrdenCotizacion->OotHora = ($_POST['CmpHora']);
	list($InsOrdenCotizacion->OotAno,$Mes,$Dia) = explode("-",$InsOrdenCotizacion->OotFecha);

	$InsOrdenCotizacion->MonId = $_POST['CmpMonedaId'];
	$InsOrdenCotizacion->OotTipoCambio = $_POST['CmpTipoCambio'];

	$InsOrdenCotizacion->OotObservacion = addslashes($_POST['CmpObservacion']);
	$InsOrdenCotizacion->OotOrigen =  $_POST['CmpOrigen'];
	$InsOrdenCotizacion->OotEstado = $_POST['CmpEstado'];
	$InsOrdenCotizacion->OotTiempoCreacion = date("Y-m-d H:i:s");
	$InsOrdenCotizacion->OotTiempoModificacion = date("Y-m-d H:i:s");

	$InsOrdenCotizacion->OotPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsOrdenCotizacion->OotMargenUtilidad = 0;
	$InsOrdenCotizacion->OotIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];		

	$InsOrdenCotizacion->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsOrdenCotizacion->PrvNombreCompleto = $InsOrdenCotizacion->PrvNombre;
	$InsOrdenCotizacion->TdoId = $_POST['CmpProveedorTipoDocumento'];	
	$InsOrdenCotizacion->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsOrdenCotizacion->OotSubTotal = 0;
	$InsOrdenCotizacion->OotImpuesto = 0;
	$InsOrdenCotizacion->OotTotal = 0;


	$InsOrdenCotizacion->OrdenCotizacionDetalle = array();

	if($InsOrdenCotizacion->MonId<>$EmpresaMonedaId){
		if(empty($InsOrdenCotizacion->OotTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_OOT_600';
		}
	}
	

	/*
SesionObjeto-OrdenCotizacionDetalle
Parametro1 = OodId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = 
Parametro5 = 
Parametro6 = 
Parametro7 = OodTiempoCreacion
Parametro8 = OodTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = 
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = 
Parametro17 = 
Parametro18 = 
Parametro19 = OodAno
Parametro20 = OodModelo

Parametro21 - 
Parametro22 - 
Parametro23 = 

Parametro24 = 
Parametro25 = 

Parametro26 = PcdEstado
*/

	$ResOrdenCotizacionDetalle = $_SESSION['InsOrdenCotizacionDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResOrdenCotizacionDetalle['Datos'])){
		$item = 1;
		foreach($ResOrdenCotizacionDetalle['Datos'] as $DatSesionObjeto){
				
			$InsOrdenCotizacionDetalle1 = new ClsOrdenCotizacionDetalle();
			$InsOrdenCotizacionDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsOrdenCotizacionDetalle1->UmeId = $DatSesionObjeto->Parametro10;
							
			$InsOrdenCotizacionDetalle1->OodAno =  $DatSesionObjeto->Parametro19;
			$InsOrdenCotizacionDetalle1->OodModelo =  $DatSesionObjeto->Parametro20;
			//$InsOrdenCotizacionDetalle1->OodPrecio =  $DatSesionObjeto->Parametro4;
			
			if($InsOrdenCotizacion->MonId<>$EmpresaMonedaId){
				$InsOrdenCotizacionDetalle1->OodPrecio = $DatSesionObjeto->Parametro4 * $InsOrdenCotizacion->OotTipoCambio;
			}else{
				$InsOrdenCotizacionDetalle1->OodPrecio = $DatSesionObjeto->Parametro4;
			}
			
			$InsOrdenCotizacionDetalle1->OodEstado = $InsOrdenCotizacion->OotEstado;//$DatSesionObjeto->Parametro26;
			$InsOrdenCotizacionDetalle1->OodTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsOrdenCotizacionDetalle1->OodTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsOrdenCotizacionDetalle1->OodEliminado = $DatSesionObjeto->Eliminado;				
			$InsOrdenCotizacionDetalle1->InsMysql = NULL;

			$InsOrdenCotizacion->OrdenCotizacionDetalle[] = $InsOrdenCotizacionDetalle1;		
			
			if($InsOrdenCotizacionDetalle1->OodEliminado==1){					
			
			}
			
			$item++;	
		}

	}else{
		$Guardar = false;
		$Resultado.='#ERR_OOT_111';
	}
	
	
	//$InsOrdenCotizacion->OotImpuesto = $InsOrdenCotizacion->OotSubTotal * ($InsOrdenCotizacion->OotPorcentajeImpuestoVenta/100);	
	//$InsOrdenCotizacion->OotTotal = $InsOrdenCotizacion->OotSubTotal + $InsOrdenCotizacion->OotImpuesto;

	if($Guardar){

		if($InsOrdenCotizacion->MtdRegistrarOrdenCotizacion()){
			
			//if($POST_OrdenCompraEnviar == 1){
//				
//				if(!empty($InsOrdenCotizacion->OcoId)){
//					
//					$InsOrdenCompra = new ClsOrdenCompra();
//					$InsOrdenCompra->OcoId = $InsOrdenCotizacion->OcoId;
//					$InsOrdenCompra->MtdObtenerOrdenCompra();
//					
//					if($InsOrdenCompra->MtdActualizarEstadoOrdenCompra($InsOrdenCotizacion->OcoId,3)){
//						
//					}
//
//					
//				}
//				
//			}
			
			
//			unset($_SESSION['InsOrdenCotizacionDetalle'.$Identificador]);
//			$_SESSION['InsOrdenCotizacionDetalle'.$Identificador] = new ClsSesionObjeto();
//			unset($InsOrdenCotizacion);
//			$InsOrdenCotizacion->OotFecha = date("d/m/Y");
//			$InsOrdenCotizacion->OotEstado = 3;
//			$InsOrdenCotizacion->OotOrigen = "OOT";

			unset($InsOrdenCotizacion);
			FncNuevo();

			$Registro = true;
			$Resultado.='#SAS_OOT_101';

		}else{
			$InsOrdenCotizacion->OotFecha = FncCambiaFechaANormal($InsOrdenCotizacion->OotFecha);
			$InsOrdenCotizacion->OotFechaRespuesta = FncCambiaFechaANormal($InsOrdenCotizacion->OotFechaRespuesta,true);
			$Resultado.='#ERR_OOT_101';
		}		

	}else{

		$InsOrdenCotizacion->OotFecha = FncCambiaFechaANormal($InsOrdenCotizacion->OotFecha);	
			$InsOrdenCotizacion->OotFechaRespuesta = FncCambiaFechaANormal($InsOrdenCotizacion->OotFechaRespuesta,true);

	}

	

}else{
	
	FncNuevo();
	
}


function FncNuevo(){
	
	global $Identificador;
	global $InsOrdenCotizacion;
	global $InsTipoCambio;
	global $EmpresaImpuestoVenta;
		
	//unset($InsOrdenCotizacion);
	unset($_SESSION['InsOrdenCotizacionDetalle'.$Identificador]);
		
	$_SESSION['InsOrdenCotizacionDetalle'.$Identificador] = new ClsSesionObjeto();
		
	$InsOrdenCotizacion->PerId = $_SESSION['SesionId'];
	$InsOrdenCotizacion->OotEstado = 3;
	$InsOrdenCotizacion->OotIncluyeImpuesto = 3;
	$InsOrdenCotizacion->OotOrigen = "OOT";
	$InsOrdenCotizacion->MonId = "MON-10001";
	$InsOrdenCotizacion->OotFecha = date("d/m/Y");
	$InsOrdenCotizacion->OotHora = date("H:i:s");
	$InsOrdenCotizacion->OotPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	//$InsOrdenCotizacion->PrvId = "CLI-1000";
//	$InsOrdenCotizacion->PrvNombre = "C&C S.A.C.";
//	$InsOrdenCotizacion->PrvNumeroDocumento = "20410705878";
//	$InsOrdenCotizacion->TdoId = "TDO-10003";
	$InsProveedor = new ClsProveedor();
	//MtdObtenerProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PrvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL) {
	$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,"PrvNombre","ASC","1","1","CYC");
	$ArrProveedores = $ResProveedor['Datos'];
	
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){
		
			$InsOrdenCotizacion->PrvId = $DatProveedor->PrvId;
			$InsOrdenCotizacion->PrvNombreCompleto = $DatProveedor->PrvNombreCompleto;
			$InsOrdenCotizacion->PrvNombre = $DatProveedor->PrvNombre;
			$InsOrdenCotizacion->PrvApellidoPaterno = $DatProveedor->PrvApellidoPaterno;
			$InsOrdenCotizacion->PrvApellidoMaterno = $DatProveedor->PrvApellidoMaterno;
			$InsOrdenCotizacion->PrvNumeroDocumento = $DatProveedor->PrvNumeroDocumento;
			$InsOrdenCotizacion->TdoId = $DatProveedor->TdoId;
//			$InsOrdenCotizacion->PrvId = "CLI-1000";
//			$InsOrdenCotizacion->PrvNombre = "C&C S.A.C.";
//			$InsOrdenCotizacion->PrvNumeroDocumento = "20410705878";
//			$InsOrdenCotizacion->TdoId = "TDO-10003";
	
		}
	}
	
	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = "MON-10001";
	$InsTipoCambio->TcaFecha = date("Y-m-d");
	
	$InsTipoCambio->MtdObtenerTipoCambioActual();
	
	if(empty($InsTipoCambio->TcaId)){
		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}
		
	$InsOrdenCotizacion->OotTipoCambio = $InsTipoCambio->TcaMontoCompra;
	
}
?>