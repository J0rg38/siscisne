<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';
	
	$InsOrdenCompra->UsuId = $_SESSION['SesionId'];	
		
	$InsOrdenCompra->OcoId = $_POST['CmpId'];
	$InsOrdenCompra->OcoTipo = $_POST['CmpTipo'];
	$InsOrdenCompra->OcoCodigoDealer = $_POST['CmpCodigoDealer'];
	
	$InsOrdenCompra->OcoVIN = $_POST['CmpVIN'];
	$InsOrdenCompra->OcoOrdenTrabajo = $_POST['CmpOrdenTrabajo'];
	
	$InsOrdenCompra->PrvId = $_POST['CmpProveedorId'];

	$InsOrdenCompra->VmaId = $_POST['CmpVehiculoMarca'];
	$InsOrdenCompra->MonId = $_POST['CmpMonedaId'];
	$InsOrdenCompra->OcoTipoCambio = $_POST['CmpTipoCambio'];

	$InsOrdenCompra->OcoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsOrdenCompra->OcoFechaLlegadaEstimada = FncCambiaFechaAMysql($_POST['CmpFechaEstimadaLlegada'],true);
	
	if(empty($InsOrdenCompra->OcoFechaLlegadaEstimada)){
		
		switch($InsOrdenCompra->OcoTipo){
			
			case "YRUSH":
			
				$FechaEstimadaLlegada = strtotime ( '+2 days' , strtotime ( $InsOrdenCompra->OcoFecha) ) ;
				$FechaEstimadaLlegada = date ('Y-m-d' , $FechaEstimadaLlegada );
				$InsOrdenCompra->OcoFechaLlegadaEstimada = $FechaEstimadaLlegada;
				
			break;
			
			case "ZVOR":
			
				$FechaEstimadaLlegada = strtotime ( '+60 days' , strtotime ( $InsOrdenCompra->OcoFecha) ) ;
				$FechaEstimadaLlegada = date ('Y-m-d' , $FechaEstimadaLlegada );
				$InsOrdenCompra->OcoFechaLlegadaEstimada = $FechaEstimadaLlegada;
			
			break;
			
			case "STK":

				$FechaEstimadaLlegada = strtotime ( '+4 days' , strtotime ( $InsOrdenCompra->OcoFecha) ) ;
				$FechaEstimadaLlegada = date ('Y-m-d' , $FechaEstimadaLlegada );
				$InsOrdenCompra->OcoFechaLlegadaEstimada = $FechaEstimadaLlegada;

			break;
			
			default:
			
			break;
                            
		}
		
		
		
	}
	
	
				
				
				
	list($InsOrdenCompra->OcoAno,$InsOrdenCompra->OcoMes,$Dia) = explode("-",$InsOrdenCompra->OcoFecha);

	$InsOrdenCompra->OcoMes = $_POST['CmpMes'];
	
	$InsOrdenCompra->OcoHora = ($_POST['CmpHora']);
	$InsOrdenCompra->OcoObservacion = addslashes($_POST['CmpObservacion']);
	$InsOrdenCompra->OcoRespuestaProveedor = addslashes($_POST['CmpRespuestaProveedor']);
	$InsOrdenCompra->OcoProcesadoProveedor = $_POST['CmpProcesadoProveedor'];
	
	$InsOrdenCompra->OcoPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsOrdenCompra->OcoIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	
	$InsOrdenCompra->OcoEstado = ($_POST['CmpEstado']);
	$InsOrdenCompra->OcoTiempoCreacion = date("Y-m-d H:i:s");
	$InsOrdenCompra->OcoTiempoModificacion = date("Y-m-d H:i:s");
	$InsOrdenCompra->OcoEliminado = 1;
	
	$InsOrdenCompra->TdoId = $_POST['CmpProveedorTipoDocumento'];
	$InsOrdenCompra->PrvNombre = $_POST['CmpProveedorNombre'];
	
	$InsOrdenCompra->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsOrdenCompra->OrdenCompraDetalle = array();
	$InsOrdenCompra->OrdenCompraPedido = array();

	if($InsOrdenCompra->MonId<>$EmpresaMonedaId){
		if(empty($InsOrdenCompra->OcoTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_OCO_600';
		}
	}

	$InsOrdenCompra->OcoSubTotal = 0;
	$InsOrdenCompra->OcoImpuesto = 0;
	$InsOrdenCompra->OcoTotal = 0;
	
	$InsOrdenCompra->OcoTotalBruto = 0;

	$RepOrdenCompraPedido = $_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdObtenerSesionObjetos(true);
	$ArrOrdenCompraPedidos = $RepOrdenCompraPedido['Datos'];

	//deb($ArrOrdenCompraPedidos);
	if(!empty($ArrOrdenCompraPedidos)){
		foreach($ArrOrdenCompraPedidos as $DatOrdenCompraPedido){
			

				
			$InsPedidoCompra1 = new ClsPedidoCompra();
			$InsPedidoCompra1->PcoId = $DatOrdenCompraPedido->Parametro1;
			$InsPedidoCompra1->MtdObtenerPedidoCompra();
			
			$InsPedidoCompra1->PcoSubTotal = 0;
			$InsPedidoCompra1->PcoImpuesto = 0;
			$InsPedidoCompra1->PcoTotal = 0;
			$InsPedidoCompra1->PcoTotalBruto = 0;
			
			if(!empty($InsPedidoCompra1->PedidoCompraDetalle)){
				foreach($InsPedidoCompra1->PedidoCompraDetalle as $DatPedidoCompraDetalle){

					$InsPedidoCompra1->PcoTotalBruto += $DatPedidoCompraDetalle->PcdImporte;

				}
			}
			//$InsPedidoCompra1 = new ClsPedidoCompra();
			//$InsPedidoCompra1->PcoId = $DatOrdenCompraPedido->Parametro1;
			
			
			if($InsPedidoCompra1->PcoIncluyeImpuesto==2){
				$InsPedidoCompra1->PcoSubTotal = round($InsPedidoCompra1->PcoTotalBruto,6);
				$InsPedidoCompra1->PcoImpuesto = round(($InsPedidoCompra1->PcoSubTotal * ($InsPedidoCompra1->PcoPorcentajeImpuestoVenta/100)),6);
				$InsPedidoCompra1->PcoTotal = round($InsPedidoCompra1->PcoSubTotal + $InsPedidoCompra1->PcoImpuesto,6);
			}else{
				$InsPedidoCompra1->PcoTotal = round($InsPedidoCompra1->PcoTotalBruto,6);	
				$InsPedidoCompra1->PcoSubTotal = round($InsPedidoCompra1->PcoTotal / (($InsPedidoCompra1->PcoPorcentajeImpuestoVenta/100)+1),6);
				$InsPedidoCompra1->PcoImpuesto = round(($InsPedidoCompra1->PcoTotal - $InsPedidoCompra1->PcoSubTotal),6);
			}
			
			$InsOrdenCompra->OcoSubTotal += $InsPedidoCompra1->PcoSubTotal;
			$InsOrdenCompra->OcoImpuesto += $InsPedidoCompra1->PcoImpuesto;
			$InsOrdenCompra->OcoTotal += $InsPedidoCompra1->PcoTotal;
			
			$InsOrdenCompra->MonId = $InsPedidoCompra1->MonId;
			$InsOrdenCompra->OcoTipoCambio = $InsPedidoCompra1->PcoTipoCambio;
			
			
			$InsOrdenCompra->OrdenCompraPedido[] = $InsPedidoCompra1;
			
		}
	}

//
//	if($InsOrdenCompra->OcoIncluyeImpuesto==2){
//		$InsOrdenCompra->OcoSubTotal = round($InsOrdenCompra->OcoTotalBruto,6);
//		$InsOrdenCompra->OcoImpuesto = round(($InsOrdenCompra->OcoSubTotal * ($InsOrdenCompra->OcoPorcentajeImpuestoVenta/100)),6);
//		$InsOrdenCompra->OcoTotal = round($InsOrdenCompra->OcoSubTotal + $InsOrdenCompra->OcoImpuesto,6);
//	}else{
//		$InsOrdenCompra->OcoTotal = round($InsOrdenCompra->OcoTotalBruto,6);	
//		$InsOrdenCompra->OcoSubTotal = round($InsOrdenCompra->OcoTotal / (($InsOrdenCompra->ocoPorcentajeImpuestoVenta/100)+1),6);
//		$InsOrdenCompra->OcoImpuesto = round(($InsOrdenCompra->OcoTotal - $InsOrdenCompra->OcoSubTotal),6);
//	}
//	
//	
//	
//	if(empty($InsOrdenCompra->OcoTotal)){
//		$Guardar = false;
//		$Resultado.='#ERR_OCO_604';
//	}
	
	
	if($Guardar){	
		if($InsOrdenCompra->MtdRegistrarOrdenCompra()){
			
			$Registro =  true;
			$Resultado.='#SAS_OCO_101';
			
			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
					self.parent.tb_remove('<?php echo $GET_mod;?>');
					self.parent.$('#CmpOrdenCompraId').val("<?php echo $InsOrdenCompra->OcoId;?>");
					self.parent.FncOrdenCompraBuscar("Id");
                </script>
<?php
			}
			
//			unset($InsOrdenCompra);
//			unset($_SESSION['InsOrdenCompraDetalle'.$Identificador]);
//			unset($_SESSION['InsOrdenCompraPedido'.$Identificador]);
//			
//			$InsOrdenCompra->OcoFecha = date("d/m/Y");
//			$InsOrdenCompra->OcoMes = date("m");
//			$InsOrdenCompra->OcoAno = date("Y");
//			$InsOrdenCompra->OcoHora = date("H:i");
//			$InsOrdenCompra->OcoEstado = 1;
//			
//			$InsOrdenCompra->MonId = "MON-10001";
//			$InsOrdenCompra->OcoTipoCambio = $_SESSION['SesionTipoCambioCompra'];
//			$InsOrdenCompra->OcoCodigoDealer = "8001200006";
//			$InsOrdenCompra->OcoTipo = "STK";
//			
			
			unset($InsOrdenCompra);
			FncNuevo();
			
		} else{

			$InsOrdenCompra->OcoFecha = FncCambiaFechaANormal($InsOrdenCompra->OcoFecha);
			$InsOrdenCompra->OcoFechaLlegadaEstimada = FncCambiaFechaANormal($InsOrdenCompra->OcoFechaLlegadaEstimada,true);
			$Resultado.='#ERR_OCO_101';		

		}

	}else{

		$InsOrdenCompra->OcoFecha = FncCambiaFechaANormal($InsOrdenCompra->OcoFecha);
		$InsOrdenCompra->OcoFechaLlegadaEstimada = FncCambiaFechaANormal($InsOrdenCompra->OcoFechaLlegadaEstimada,true);
			
	}

	
		
}else{
	
	FncNuevo();

	switch($GET_ori){

		case "PedidoCompra":
			
			$ArrPedidoCompras = array();
			$ArrPedidoCompras = explode("#",$_POST['cmp_seleccionados']);
			$ArrPedidoCompras = array_filter($ArrPedidoCompras);

			//deb($ArrPedidoCompras);
			if(!empty($ArrPedidoCompras)){
				foreach($ArrPedidoCompras as $DatPedidoCompra){

					$InsPedidoCompra = new ClsPedidoCompra();
					$InsPedidoCompra->PcoId = $DatPedidoCompra;	
					$InsPedidoCompra->MtdObtenerPedidoCompra(false);	
					
					//deb($InsPedidoCompra->PcoId);
					$_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdAgregarSesionObjeto(1,
					$InsPedidoCompra->PcoId,
					$InsPedidoCompra->PcoFecha);

				}
			}
			
		break;

	}
}

function FncNuevo(){

	global $InsOrdenCompra;
	global $Identificador;
	global $InsTipoCambio;
	global $EmpresaImpuestoVenta;
	
	//unset($InsOrdenCompra);
	unset($_SESSION['InsOrdenCompraDetalle'.$Identificador]);
	unset($_SESSION['InsOrdenCompraPedido'.$Identificador]);

	$_SESSION['InsOrdenCompraDetalle'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();

	//$InsOrdenCompra = new ClsOrdenCompra();
	
	$InsOrdenCompra->OcoFecha = date("d/m/Y");
	$InsOrdenCompra->OcoMes = date("m");
	$InsOrdenCompra->OcoAno = date("Y");
	$InsOrdenCompra->OcoHora = date("H:i");
	$InsOrdenCompra->OcoEstado = 1;
	

	$InsOrdenCompra->MonId = "MON-10001";
	$InsOrdenCompra->OcoCodigoDealer = "8001200006";
	$InsOrdenCompra->OcoTipo = "STK";

	$InsProveedor = new ClsProveedor();
	$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,'PrvNombre','ASC','1',NULL,"CYC");
	$ArrProveedores = $ResProveedor['Datos'];
	
	$InsOrdenCompra->OcoIncluyeImpuesto = 2;;
	$InsOrdenCompra->OcoPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;
	
	//deb($ArrProveedores);
	if(!empty($ArrProveedores)){
		foreach($ArrProveedores as $DatProveedor){

			$InsOrdenCompra->PrvId = $DatProveedor->PrvId;
			$InsOrdenCompra->PrvNombreCompleto = $DatProveedor->PrvNombreCompleto;
			$InsOrdenCompra->PrvNumeroDocumento = $DatProveedor->PrvNumeroDocumento;
			$InsOrdenCompra->TdoId = $DatProveedor->TdoId;

		}
	}

	//deb($InsOrdenCompra);
	$InsTipoCambio = new ClsTipoCambio();
	$InsTipoCambio->MonId = $InsOrdenCompra->MonId;
	$InsTipoCambio->TcaFecha = date("Y-m-d");
	
	$InsTipoCambio->MtdObtenerTipoCambioActual();
	
	if(empty($InsTipoCambio->TcaId)){
		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	}
		
	$InsOrdenCompra->OcoTipoCambio = $InsTipoCambio->TcaMontoComercial;

}
?>