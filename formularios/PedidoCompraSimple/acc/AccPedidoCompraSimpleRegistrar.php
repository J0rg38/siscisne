 <?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){		
	
	$Resultado = '';
	$Guardar = true;
	
	$InsPedidoCompra->UsuId = $_SESSION['SesionId'];	
	
	$InsPedidoCompra->PcoId = $_POST['CmpId'];
	$InsPedidoCompra->CliId = $_POST['CmpClienteId'];
	$InsPedidoCompra->PerId = $_POST['CmpPersonal'];
	$InsPedidoCompra->SucId = $_SESSION['SesionSucursal'];
	
	$InsPedidoCompra->PcoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	list($InsPedidoCompra->PcoAno,$Mes,$Dia) = explode("-",$InsPedidoCompra->PcoFecha);

	$InsPedidoCompra->MonId = $_POST['CmpMonedaId'];
	$InsPedidoCompra->PcoTipoCambio = $_POST['CmpTipoCambio'];

	$InsPedidoCompra->PcoObservacion = addslashes($_POST['CmpObservacion']);
	$InsPedidoCompra->PcoObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsPedidoCompra->PcoObservacionCorreo = addslashes($_POST['CmpObservacionCorreo']);
	
	$InsPedidoCompra->PcoOrigen =  "OTR";
	$InsPedidoCompra->PcoAprobado =  2;
	$InsPedidoCompra->PcoEstado = $_POST['CmpEstado'];
	$InsPedidoCompra->PcoTiempoCreacion = date("Y-m-d H:i:s");
	$InsPedidoCompra->PcoTiempoModificacion = date("Y-m-d H:i:s");

	$InsPedidoCompra->PcoIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsPedidoCompra->PcoPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsPedidoCompra->PcoMargenUtilidad = 0;
//	$InsPedidoCompra->PcoIncluyeImpuesto = 0;		
	$InsPedidoCompra->PcoAprobado = 2;		

	$InsPedidoCompra->PrvNombreCompleto = $_POST['CmpProveedorNombreCompleto'];
	$InsPedidoCompra->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsPedidoCompra->PrvApellidoPaterno = $_POST['CmpProveedorApellidoPaterno'];
	$InsPedidoCompra->PrvApellidoMaterno = $_POST['CmpProveedorApellidoMaterno'];
	
	$InsPedidoCompra->TdoIdProveedor = $_POST['CmpProveedorTipoDocumento'];	
	$InsPedidoCompra->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsPedidoCompra->PrvId = $_POST['CmpProveedorId'];
		
	$InsPedidoCompra->PcoSubTotal = 0;
	$InsPedidoCompra->PcoImpuesto = 0;
	$InsPedidoCompra->PcoTotal = 0;

	$InsPedidoCompra->PedidoCompraDetalle = array();

	if($InsPedidoCompra->MonId<>$EmpresaMonedaId){
		if(empty($InsPedidoCompra->PcoTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_PCO_600';
		}
	}
	

//	if(empty($InsPedidoCompra->CliId)){
//		$Guardar = false;
//		$Resultado.='#ERR_PCO_123';
//	}	
	
/*
SesionObjeto-PedidoCompraDetalle
Parametro1 = PcdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = PcdPrecio
Parametro5 = PcdCantidad
Parametro6 = PcdImporte
Parametro7 = PcdTiempoCreacion
Parametro8 = PcdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = PcdCodigo
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = VerificarStock
Parametro17 = 
Parametro18 = VddId
Parametro19 = PcdAno
Parametro20 = PcdModelo

Parametro21 - PcdDisponibilidad
Parametro22 - PcdReemplazo
Parametro23 = AmdCantidad

Parametro24 = PcdBOFecha
Parametro25 = PcdBOEstado

Parametro26 = PcdEstado

Parametro34 = PcdObservacion
*/

	$ResPedidoCompraDetalle = $_SESSION['InsPedidoCompraDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResPedidoCompraDetalle['Datos'])){
		$item = 1;
		foreach($ResPedidoCompraDetalle['Datos'] as $DatSesionObjeto){
				
			$InsPedidoCompraDetalle1 = new ClsPedidoCompraDetalle();
			$InsPedidoCompraDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsPedidoCompraDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			$InsPedidoCompraDetalle1->VddId = $DatSesionObjeto->Parametro18;
		
			$InsPedidoCompraDetalle1->PcdCantidad = $DatSesionObjeto->Parametro5;				
			
			$InsPedidoCompraDetalle1->PcdAno =  $DatSesionObjeto->Parametro19;
			$InsPedidoCompraDetalle1->PcdModelo =  $DatSesionObjeto->Parametro20;
			$InsPedidoCompraDetalle1->PcdCodigo =  $DatSesionObjeto->Parametro12;

			if($InsPedidoCompra->MonId<>$EmpresaMonedaId ){
				$InsPedidoCompraDetalle1->PcdPrecio = $DatSesionObjeto->Parametro4 * $InsPedidoCompra->PcoTipoCambio;
			}else{
				$InsPedidoCompraDetalle1->PcdPrecio = $DatSesionObjeto->Parametro4;
			}


			if($InsPedidoCompra->MonId<>$EmpresaMonedaId ){
				$InsPedidoCompraDetalle1->PcdImporte = $DatSesionObjeto->Parametro6 * $InsPedidoCompra->PcoTipoCambio;
			}else{
				$InsPedidoCompraDetalle1->PcdImporte = $DatSesionObjeto->Parametro6;
			}

			$InsPedidoCompraDetalle1->PcdObservacion = $DatSesionObjeto->Parametro34;
			//$InsPedidoCompraDetalle1->PcdEstado = $InsPedidoCompra->PcoEstado;
			$InsPedidoCompraDetalle1->PcdEstado = $DatSesionObjeto->Parametro26;
			$InsPedidoCompraDetalle1->PcdTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro7);
			$InsPedidoCompraDetalle1->PcdTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro8);

			$InsPedidoCompraDetalle1->PcdEliminado = $DatSesionObjeto->Eliminado;				
			$InsPedidoCompraDetalle1->InsMysql = NULL;

			$InsPedidoCompra->PedidoCompraDetalle[] = $InsPedidoCompraDetalle1;		
			
			if($InsPedidoCompraDetalle1->PcdEliminado==1){					
				$InsPedidoCompra->PcoTotalBruto += $InsPedidoCompraDetalle1->PcdImporte;	
			}
			
			$item++;	
		}

	}else{
		$Guardar = false;
		$Resultado.='#ERR_PCO_111';
	}
	
	
	if($InsPedidoCompra->PcoIncluyeImpuesto==2){
		$InsPedidoCompra->PcoSubTotal = round($InsPedidoCompra->PcoTotalBruto,6);
		$InsPedidoCompra->PcoImpuesto = round(($InsPedidoCompra->PcoSubTotal * ($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100)),6);
		$InsPedidoCompra->PcoTotal = round($InsPedidoCompra->PcoSubTotal + $InsPedidoCompra->PcoImpuesto,6);
	}else{
		$InsPedidoCompra->PcoTotal = round($InsPedidoCompra->PcoTotalBruto,6);	
		$InsPedidoCompra->PcoSubTotal = round($InsPedidoCompra->PcoTotal / (($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100)+1),6);
		$InsPedidoCompra->PcoImpuesto = round(($InsPedidoCompra->PcoTotal - $InsPedidoCompra->PcoSubTotal),6);
	}
	
	//$InsPedidoCompra->PcoImpuesto = $InsPedidoCompra->PcoSubTotal * ($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100);	
	//$InsPedidoCompra->PcoTotal = $InsPedidoCompra->PcoSubTotal + $InsPedidoCompra->PcoImpuesto;
	
	if($Guardar){
	
		$InsOrdenCompra = new ClsOrdenCompra();
		$InsOrdenCompra->UsuId = $InsPedidoCompra->UsuId;
			
		$InsOrdenCompra->OcoId = NULL;
		$InsOrdenCompra->OcoTipo = "ALM";
		$InsOrdenCompra->OcoCodigoDealer = "";
		
		$InsOrdenCompra->OcoVIN = "";
		$InsOrdenCompra->OcoOrdenTrabajo = "";
		
		$InsOrdenCompra->PrvId = $InsPedidoCompra->PrvId;
	
		$InsOrdenCompra->MonId = $InsPedidoCompra->MonId;
		$InsOrdenCompra->OcoTipoCambio = $InsPedidoCompra->PcoTipoCambio;
	
		$InsOrdenCompra->OcoFecha = $InsPedidoCompra->PcoFecha;
		$InsOrdenCompra->OcoFechaLlegadaEstimada = NULL;
		
		list($InsOrdenCompra->OcoAno,$InsOrdenCompra->OcoMes,$Dia) = explode("-",$InsOrdenCompra->OcoFecha);
	
		$InsOrdenCompra->OcoMes = date("m");
		
		$InsOrdenCompra->OcoHora = date("H:i:s");
		$InsOrdenCompra->OcoObservacion = "Orden de compra autogenerada de pedido de compra (otros proveedores) - ".date("d/m/Y H:i:s");
		$InsOrdenCompra->OcoRespuestaProveedor = "";
		$InsOrdenCompra->OcoProcesadoProveedor = 1;
		
		$InsOrdenCompra->OcoEstado = 3;
		$InsOrdenCompra->OcoTiempoCreacion = date("Y-m-d H:i:s");
		$InsOrdenCompra->OcoTiempoModificacion = date("Y-m-d H:i:s");
		$InsOrdenCompra->OcoEliminado = 1;
		
		$InsOrdenCompra->OcoIncluyeImpuesto = $InsPedidoCompra->PcoIncluyeImpuesto;
		$InsOrdenCompra->OcoPorcentajeImpuestoVenta = $InsPedidoCompra->PcoPorcentajeImpuestoVenta;
		
		$InsOrdenCompra->OcoSubTotal = $InsPedidoCompra->PcoSubTotal;
		$InsOrdenCompra->OcoImpuesto = $InsPedidoCompra->PcoImpuesto;
		$InsOrdenCompra->OcoTotal = $InsPedidoCompra->PcoTotal;
	
		if($Guardar){	
			if(!$InsOrdenCompra->MtdRegistrarOrdenCompra()){
				$Guardar = false;
			}else{
				$InsPedidoCompra->OcoId = $InsOrdenCompra->OcoId;
			}
		}
		
	}
	
	if($Guardar){

		if($InsPedidoCompra->MtdRegistrarPedidoCompra()){
			
			unset($InsPedidoCompra);
			FncNuevo();

			$Registro = true;
			$Resultado.='#SAS_PCO_101';

		}else{
			$InsPedidoCompra->PcoFecha = FncCambiaFechaANormal($InsPedidoCompra->PcoFecha);
			$Resultado.='#ERR_PCO_101';
		}		

	}else{

		$InsPedidoCompra->PcoFecha = FncCambiaFechaANormal($InsPedidoCompra->PcoFecha);	

	}

	

}else{
	
	FncNuevo();
	
	
	switch($GET_Origen){

		case "VentaDirecta":

			$InsVentaDirecta = new ClsVentaDirecta();
			$InsVentaDirecta->VdiId = $GET_VdiId;
			$InsVentaDirecta->MtdObtenerVentaDirecta();

			$InsPedidoCompra->VdiId = $InsVentaDirecta->VdiId;
			$InsPedidoCompra->VdiOrdenCompraNumero = $InsVentaDirecta->VdiOrdenCompraNumero;
			
			$InsPedidoCompra->PerId = $InsVentaDirecta->PerId;
			
			$InsPedidoCompra->CliId = $InsVentaDirecta->CliId;
			$InsPedidoCompra->CliNombre = $InsVentaDirecta->CliNombre;
			$InsPedidoCompra->CliApellidoPaterno = $InsVentaDirecta->CliApellidoPaterno;
			$InsPedidoCompra->CliApellidoMaterno = $InsVentaDirecta->CliApellidoMaterno;
			$InsPedidoCompra->CliNombreCompleto = $InsVentaDirecta->CliNombreCompleto;
			$InsPedidoCompra->CliNumeroDocumento = $InsVentaDirecta->CliNumeroDocumento;
			$InsPedidoCompra->TdoId = $InsVentaDirecta->TdoId;
			$InsPedidoCompra->LtiId = $InsVentaDirecta->LtiId;
			$InsPedidoCompra->PcoMargenUtilidad = $InsVentaDirecta->VdiMargenUtilidad;
			$InsPedidoCompra->PcoOrigen = "VDI";
			$InsPedidoCompra->PcoObservacion = $InsVentaDirecta->VdiObservacion.chr(13).date("d/m/Y H:i:s")." - Ped. Compra Generada de Ord. Ven.:".$InsVentaDirecta->VdiId;
			$InsPedidoCompra->PcoObservacionImpresa = "CLIENTE: ".$InsPedidoCompra->CliNombre." ".$InsPedidoCompra->CliApellidoPaterno;
			
			//deb($InsVentaDirecta->VentaDirectaDetalle);
			if(!empty($InsVentaDirecta->VentaDirectaDetalle)){
				foreach($InsVentaDirecta->VentaDirectaDetalle as $DatVentaDirectaDetalle){
					
					if($DatVentaDirectaDetalle->VddEstado == 1){
	
						$GuardarDetalle = true;
						
						$InsProductoListaPrecio = new ClsProductoListaPrecio();
		
						$ProductoListaPrecio = 0;
						
						if(!empty($DatVentaDirectaDetalle->ProCodigoOriginal)){
	
							$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$DatVentaDirectaDetalle->ProCodigoOriginal,'PlpTiempoCreacion','DESC',"1",NULL);
							$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
							
							if(!empty($ArrProductoListaPrecios)){
								foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
									
									if($InsPedidoCompra->MonId <> $EmpresaMonedaId){
											//deb($DatProductoListaPrecio->MonId." - ".$InsPedidoCompra->MonId);
										if($DatProductoListaPrecio->MonId == $InsPedidoCompra->MonId){
											$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecioReal;
										}else{
											$ProductoListaPrecio = ($DatProductoListaPrecio->PlpPrecio/$DatProductoListaPrecio->PlpTipoCambio);
										}
										
									}else{
										$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecio;
									}
									//$ProductoListaPrecio = $DatProductoListaPrecio->PlpPrecio;
								}
							}
	
						}
						
						
						$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatVentaDirectaDetalle->ProCodigoOriginal ,"PdiTiempoCreacion","DESC","1",1);
		$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
		
						//$Disponibilidad = "";
						$Disponibilidad = "NO";
						
						if(!empty($ArrProductoDisponibilidades)){
							foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
								
								$Disponibilidad =  ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';
							
							}
						}
		
						$Reemplazo = "NO";
						$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10","esigual",$DatVentaDirectaDetalle->ProCodigoOriginal ,"PreTiempoCreacion","DESC",NULL,1);
						$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
		
		   
							if(!empty($ArrProductoReemplazos)){
								  $Reemplazo= "SI";
							}
						
							//deb($ProductoListaPrecio);
							//$DatVentaDirectaDetalle->VddPrecioVenta = $ProductoListaPrecio * $InsPedidoCompra->PcoTipoCambio;
		
							$DatVentaDirectaDetalle->VddPrecioVenta = $ProductoListaPrecio;
							$DatVentaDirectaDetalle->VddImporte = $DatVentaDirectaDetalle->VddPrecioVenta * $DatVentaDirectaDetalle->VddCantidadPendiente;
	
							//deb($DatVentaDirectaDetalle->ProId." - ".$DatVentaDirectaDetalle->VddCantidadPendiente." - ".$DatVentaDirectaDetalle->PcdCantidad);
					
							if($DatVentaDirectaDetalle->VddCantidadPendiente<=0){
								$GuardarDetalle = false;
							}
		
		//deb($GuardarDetalle);
		
		if($GuardarDetalle){
								
			/*
			SesionObjeto-PedidoCompraDetalle
			Parametro1 = PcdId
			Parametro2 = ProId
			Parametro3 = ProNombre
			Parametro4 = PcdPrecio
			Parametro5 = PcdCantidad
			Parametro6 = PcdImporte
			Parametro7 = PcdTiempoCreacion
			Parametro8 = PcdTiempoModificacion
			Parametro9 = UmeNombre
			Parametro10 = UmeId
			Parametro11 = RtiId
			Parametro12 = PcdCodigo
			Parametro13 = ProCodigoOriginal,
			Parametro14 = ProCodigoAlternativo
			Parametro15 = UmeIdOrigen
			Parametro16 = VerificarStock
			Parametro17 = 
			Parametro18 = VddId
			Parametro19 = PcdAno
			Parametro20 = PcdModelo
			*/
			
			$DatVentaDirectaDetalle->VddImporte = $DatVentaDirectaDetalle->VddCantidadPendiente * $DatVentaDirectaDetalle->VddPrecioVenta;
				
/*
SesionObjeto-PedidoCompraDetalle
Parametro1 = PcdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = PcdPrecio
Parametro5 = PcdCantidad
Parametro6 = PcdImporte
Parametro7 = PcdTiempoCreacion
Parametro8 = PcdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = PcdCodigo
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = VerificarStock
Parametro17 = 
Parametro18 = VddId
Parametro19 = PcdAno
Parametro20 = PcdModelo

Parametro21 - PcdDisponibilidad
Parametro22 - PcdReemplazo
Parametro23 = AmdCantidad

Parametro24 = PcdBOFecha
Parametro25 = PcdBOEstado

Parametro26 = PcdEstado
*/


									$_SESSION['InsPedidoCompraDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
									NULL,
									$DatVentaDirectaDetalle->ProId,
									$DatVentaDirectaDetalle->ProNombre,
									$DatVentaDirectaDetalle->VddPrecioVenta,
									$DatVentaDirectaDetalle->VddCantidadPendiente,
		//							$DatVentaDirectaDetalle->VddCantidad,
									$DatVentaDirectaDetalle->VddImporte,
									(date("d/m/Y H:i:s")),
									(date("d/m/Y H:i:s")),
									$DatVentaDirectaDetalle->UmeNombre,
									$DatVentaDirectaDetalle->UmeId,
									$DatVentaDirectaDetalle->RtiId,
									$DatVentaDirectaDetalle->ProCodigoOriginal,
									$DatVentaDirectaDetalle->ProCodigoOriginal,
									$DatVentaDirectaDetalle->ProCodigoAlternativo,
									$DatVentaDirectaDetalle->UmeIdOrigen,
									NULL,
									NULL,
									$DatVentaDirectaDetalle->VddId,
									$InsVentaDirecta->VdiAnoModelo,
									$InsVentaDirecta->VdiModelo,
									$Disponibilidad,
									$Reemplazo,
									0,
									NULL,
									NULL,
									3
									);
		
//deb($_SESSION['InsPedidoCompraDetalle'.$Identificador]);
							}
		
		

					}
					
				}
				
				
				
			}else{
				$Resultado.='#ERR_PCO_701';
			}
		
		break;
		
		case "FichaAccion":
			
			$InsFichaAccion = new ClsFichaAccion();
			$InsFichaAccion->FccId = $GET_FccId;
			$InsFichaAccion->MtdObtenerFichaAccion(false);

			$InsPedidoCompra->FccId = $InsFichaAccion->FccId;
			$InsPedidoCompra->FinId = $InsFichaAccion->FinId;
			$InsPedidoCompra->MinNombre = $InsFichaAccion->MinNombre;
			$InsPedidoCompra->PcoOrigen = "FIN";
			
			
			$InsPedidoCompra->CliId = $InsFichaAccion->CliId;
			$InsPedidoCompra->CliNombreCompleto = $InsFichaAccion->CliNombreCompleto;
			
			$InsPedidoCompra->CliNombre = $InsFichaAccion->CliNombre;
			$InsPedidoCompra->CliApellidoPaterno = $InsFichaAccion->CliApellidoPaterno;
			$InsPedidoCompra->CliApellidoMaterno = $InsFichaAccion->CliApellidoMaterno;
			
			$InsPedidoCompra->CliNumeroDocumento = $InsFichaAccion->CliNumeroDocumento;
			$InsPedidoCompra->TdoId = $InsFichaAccion->TdoId;
			
			
		break;
		
	}
		
	
}


function FncNuevo(){
	
	
	global $Identificador;
	global $InsPedidoCompra;
	global $InsTipoCambio;
	global $EmpresaImpuestoVenta;
	global $EmpresaMonedaId;
	
	//unset($InsPedidoCompra);
	unset($_SESSION['InsPedidoCompraDetalle'.$Identificador]);
		
	$_SESSION['InsPedidoCompraDetalle'.$Identificador] = new ClsSesionObjeto();
	
	
	$InsPedidoCompra->PcoEstado = 3;
	$InsPedidoCompra->MonId = $EmpresaMonedaId;
	$InsPedidoCompra->PcoFecha = date("d/m/Y");
	$InsPedidoCompra->PcoPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	$InsPedidoCompra->PcoOrigen = "OTR";
	//$InsPedidoCompra->CliId = "CLI-1000";
//	$InsPedidoCompra->CliNombre = "C&C S.A.C.";
//	$InsPedidoCompra->CliNumeroDocumento = "20410705878";
//	$InsPedidoCompra->TdoIdProveedor = "TDO-10003";

	$InsCliente = new ClsCliente();
	
	//MtdObtenerClientes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CliId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL)
	$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"CYC");
	$ArrClientes = $ResCliente['Datos'];
	
	if(!empty($ArrClientes)){
		foreach($ArrClientes as $DatCliente){
		
			$InsPedidoCompra->CliId = $DatCliente->CliId;
			$InsPedidoCompra->CliNombreCompleto = $DatCliente->CliNombreCompleto;
			
			$InsPedidoCompra->CliNombre = $DatCliente->CliNombre;
			$InsPedidoCompra->CliApellidoPaterno = $DatCliente->CliApellidoPaterno;
			$InsPedidoCompra->CliApellidoMaterno = $DatCliente->CliApellidoMaterno;
			
			$InsPedidoCompra->CliNumeroDocumento = $DatCliente->CliNumeroDocumento;
			$InsPedidoCompra->TdoIdProveedor = $DatCliente->TdoIdProveedor;
				
		//	$InsPedidoCompra->CliId = "CLI-1000";
//			$InsPedidoCompra->CliNombre = "C&C S.A.C.";
//			$InsPedidoCompra->CliNumeroDocumento = "20410705878";
//			$InsPedidoCompra->TdoIdProveedor = "TDO-10003";
	
		}
	}
	
	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = "MON-10001";
	$InsTipoCambio->TcaFecha = date("Y-m-d");
	
	$InsTipoCambio->MtdObtenerTipoCambioActual();
	
	if(empty($InsTipoCambio->TcaId)){
		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}
		
	$InsPedidoCompra->PcoTipoCambio = $InsTipoCambio->TcaMontoCompra;
	
}
?>