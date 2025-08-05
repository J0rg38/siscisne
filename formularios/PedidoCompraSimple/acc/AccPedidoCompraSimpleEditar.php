<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;

	$InsPedidoCompra->UsuId = $_SESSION['SesionId'];	
	
	$InsPedidoCompra->PcoId = $_POST['CmpId'];
	$InsPedidoCompra->CliId = $_POST['CmpClienteId'];
	$InsPedidoCompra->PerId = $_POST['CmpPersonal'];
	$InsPedidoCompra->PcoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsPedidoCompra->OcoId = $_POST['CmpOrdenCompraId'];
	
	$InsPedidoCompra->MonId = $_POST['CmpMonedaId'];
	$InsPedidoCompra->PcoTipoCambio = $_POST['CmpTipoCambio'];

	$InsPedidoCompra->PcoObservacion = addslashes($_POST['CmpObservacion']);
	$InsPedidoCompra->PcoObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsPedidoCompra->PcoObservacionCorreo = addslashes($_POST['CmpObservacionCorreo']);
	
		$InsPedidoCompra->PcoOrigen =  "OTR";
	$InsPedidoCompra->PcoEstado = $_POST['CmpEstado'];
	$InsPedidoCompra->PcoTiempoModificacion = date("Y-m-d H:i:s");

	$InsPedidoCompra->PcoIncluyeImpuesto = $_POST['CmpIncluyeImpuesto'];
	$InsPedidoCompra->PcoPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsPedidoCompra->PcoMargenUtilidad = 0;

	$InsPedidoCompra->PcoAprobado = $_POST['CmpAprobado'];

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
	
	if(empty($InsPedidoCompra->CliId)){
		$Guardar = false;
		$Resultado.='#ERR_PCO_123';
	}
	
	
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

	$ResPedidoCompraDetalle = $_SESSION['InsPedidoCompraDetalle'.$Identificador]->MtdObtenerSesionObjetos(false);
	if(!empty($ResPedidoCompraDetalle['Datos'])){
		$item = 1;
		foreach($ResPedidoCompraDetalle['Datos'] as $DatSesionObjeto){
				
			$InsPedidoCompraDetalle1 = new ClsPedidoCompraDetalle();
			$InsPedidoCompraDetalle1->PcdId = $DatSesionObjeto->Parametro1;
			$InsPedidoCompraDetalle1->ProId = $DatSesionObjeto->Parametro2;
			$InsPedidoCompraDetalle1->UmeId = $DatSesionObjeto->Parametro10;
			$InsPedidoCompraDetalle1->VddId = $DatSesionObjeto->Parametro18;
			
			$InsPedidoCompraDetalle1->PcdCantidad = $DatSesionObjeto->Parametro5;				
		
			$InsPedidoCompraDetalle1->PcdAno =  $DatSesionObjeto->Parametro19;
			$InsPedidoCompraDetalle1->PcdModelo =  $DatSesionObjeto->Parametro20;
			$InsPedidoCompraDetalle1->PcdCodigo =  $DatSesionObjeto->Parametro12;

			if($InsPedidoCompra->MonId<>$EmpresaMonedaId){
				$InsPedidoCompraDetalle1->PcdPrecio = $DatSesionObjeto->Parametro4 * $InsPedidoCompra->PcoTipoCambio;
			}else{
				$InsPedidoCompraDetalle1->PcdPrecio = $DatSesionObjeto->Parametro4;
			}

			if($InsPedidoCompra->MonId<>$EmpresaMonedaId ){
				$InsPedidoCompraDetalle1->PcdImporte = $DatSesionObjeto->Parametro6 * $InsPedidoCompra->PcoTipoCambio;
			}else{
				$InsPedidoCompraDetalle1->PcdImporte = $DatSesionObjeto->Parametro6;
			} 
			//$InsPedidoCompraDetalle1->PcdEstado = $InsPedidoCompra->PcoEstado;
			$InsPedidoCompraDetalle1->PcdObservacion = $DatSesionObjeto->Parametro34;
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



	if($Guardar){
		
		
			$InsOrdenCompra = new ClsOrdenCompra();
			$InsOrdenCompra->OcoId = $InsPedidoCompra->OcoId;
			$InsOrdenCompra->OcoTipo = "ALM";
			//$InsOrdenCompra->OcoTipo = "CYC";
			
			$InsOrdenCompra->OcoAno = "";
			$InsOrdenCompra->OcoMes = "";
			$InsOrdenCompra->OcoCodigoDealer = "";
			$InsOrdenCompra->OcoVIN = "";
			$InsOrdenCompra->OcoOrdenTrabajo = "";
			$InsOrdenCompra->PrvId =  $InsPedidoCompra->PrvId;
		
			$InsOrdenCompra->MonId =  $InsPedidoCompra->MonId;
			$InsOrdenCompra->OcoTipoCambio = $InsPedidoCompra->PcoTipoCambio;
				
			$InsOrdenCompra->OcoFecha = $InsPedidoCompra->PcoFecha;
			$InsOrdenCompra->OcoFechaLlegadaEstimada = NULL;

			$InsOrdenCompra->OcoHora = "";
			$InsOrdenCompra->OcoObservacion = "";
			
			$InsOrdenCompra->OcoRespuestaProveedor = "";
			$InsOrdenCompra->OcoProcesadoProveedor  = 2;
				
			$InsOrdenCompra->OcoEstado = 3;
			$InsOrdenCompra->OcoTiempoModificacion = date("Y-m-d H:i:s");
			$InsOrdenCompra->OcoEliminado = 1;
		
			if($InsOrdenCompra->MonId<>$EmpresaMonedaId){
				if(empty($InsOrdenCompra->OcoTipoCambio)){
					$Guardar = false;
					$Resultado.='#ERR_OCO_600';
				}
			}
		
	$InsOrdenCompra->OcoIncluyeImpuesto = $InsPedidoCompra->PcoIncluyeImpuesto;
		$InsOrdenCompra->OcoPorcentajeImpuestoVenta = $InsPedidoCompra->PcoPorcentajeImpuestoVenta;
		
		$InsOrdenCompra->OcoSubTotal = $InsPedidoCompra->PcoSubTotal;
		$InsOrdenCompra->OcoImpuesto = $InsPedidoCompra->PcoImpuesto;
		$InsOrdenCompra->OcoTotal = $InsPedidoCompra->PcoTotal;
			
			if($Guardar){
			
				if(!$InsOrdenCompra->MtdEditarOrdenCompra()){	
					$Guardar = false;
				}
			}
		
	}
	
	
	
	
	if($Guardar){
		if($InsPedidoCompra->MtdEditarPedidoCompra()){	


			if(!empty($GET_dia)){
?>
				<script type="text/javascript">

				self.parent.tb_remove('<?php echo $GET_mod;?>');
				self.parent.$('#CmpPedidoCompraId').val("<?php echo $InsPedidoCompra->PcoId;?>");
				self.parent.FncPedidoCompraBuscar("Id");

				</script>
<?php
			}
			
			if(!empty($InsPedidoCompra->OcoId)){

				$InsOrdenCompra = new ClsOrdenCompra();
				$InsOrdenCompra->FncRecalcularTotalOrdenCompra($InsPedidoCompra->OcoId);
					
			}
				
					
			$Edito = true;
			FncCargarDatos();
			$Resultado.='#SAS_PCO_102';
		} else{
			$InsPedidoCompra->PcoFecha = FncCambiaFechaANormal($InsPedidoCompra->PcoFecha);
			$Resultado.='#ERR_PCO_102';
		}	
	}else{
		$InsPedidoCompra->PcoFecha = FncCambiaFechaANormal($InsPedidoCompra->PcoFecha);
	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	
	global $GET_id;
	global $Identificador;
	global $InsPedidoCompra;
	global $EmpresaMonedaId;
	global $InsProductoDisponibilidad;
	global $InsProductoReemplazo;
	
	
	unset($_SESSION['InsPedidoCompraDetalle'.$Identificador]);

	$_SESSION['InsPedidoCompraDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsPedidoCompra->PcoId = $GET_id;
	$InsPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompra();		


	if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
		foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){



$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatPedidoCompraDetalle->ProCodigoOriginal ,"PdiTiempoCreacion","DESC","1",1);
$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];

				$Disponibilidad = "";
				
				if(!empty($ArrProductoDisponibilidades)){
					foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
						
						$Disponibilidad =  ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';
					
					}
				}
	
				$Reemplazo = "NO";
                 $ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10","esigual",$DatPedidoCompraDetalle->ProCodigoOriginal ,"PreId","ASC",NULL,1);
$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];

   
   
				if(!empty($ArrProductoReemplazos)){
				      $Reemplazo= "SI";
                
                }
				
			if($InsPedidoCompra->MonId<>$EmpresaMonedaId){
				$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio / $InsPedidoCompra->PcoTipoCambio;
			}else{
				$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio;
			}

			if($InsPedidoCompra->MonId<>$EmpresaMonedaId ){
				$DatPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdImporte / $InsPedidoCompra->PcoTipoCambio;
			}else{
				$DatPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdImporte;
			}
			
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


Parametro27 = PleFecha
Parametro28 = PldCantidad

Parametro34 = PcdObservacion
*/					

		
			$_SESSION['InsPedidoCompraDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatPedidoCompraDetalle->PcdId,
			$DatPedidoCompraDetalle->ProId,
			$DatPedidoCompraDetalle->ProNombre,
			$DatPedidoCompraDetalle->PcdPrecio,
			$DatPedidoCompraDetalle->PcdCantidad,
			$DatPedidoCompraDetalle->PcdImporte,
			($DatPedidoCompraDetalle->PcdTiempoCreacion),
			($DatPedidoCompraDetalle->PcdTiempoModificacion),
			$DatPedidoCompraDetalle->UmeNombre,
			$DatPedidoCompraDetalle->UmeId,
			$DatPedidoCompraDetalle->RtiId,
			$DatPedidoCompraDetalle->PcdCodigo,
			$DatPedidoCompraDetalle->ProCodigoOriginal,
			$DatPedidoCompraDetalle->ProCodigoAlternativo,
			$DatPedidoCompraDetalle->UmeIdOrigen,
			NULL,
			NULL,
			$DatPedidoCompraDetalle->VddId,
			$DatPedidoCompraDetalle->PcdAno,
			$DatPedidoCompraDetalle->PcdModelo,
			$Disponibilidad,
			$Reemplazo,
			$DatPedidoCompraDetalle->AmdCantidad,
			
			$DatPedidoCompraDetalle->PcdBOFecha,
			$DatPedidoCompraDetalle->PcdBOEstado,
			
			$DatPedidoCompraDetalle->PcdEstado,
			$DatPedidoCompraDetalle->PleFecha,
			$DatPedidoCompraDetalle->PldCantidad,
			
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			$DatPedidoCompraDetalle->PcdObservacion
			);
		
		}
	}
	
	

	
}



//
//
//
//function FncCargarTallerPedidoDatos(){
//	
//	global $GET_TpeId;
//	global $Identificador;
//	global $InsTallerPedido;
//	global $InsFichaIngreso;
//	
//	unset($_SESSION['InsTallerPedidoDetalle'.$Identificador]);
//
//	$_SESSION['InsTallerPedidoDetalle'.$Identificador] = new ClsSesionObjeto();
//	
//	
//	$InsTallerPedido = new ClsTallerPedido();		
//	$InsTallerPedido->TpeId = $GET_TpeId;
//	$InsTallerPedido->MtdObtenerTallerPedido();
//	
//	if(!empty($InsTallerPedido->TallerPedidoDetalle)){
//		foreach($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle){
//	
//			$_SESSION['InsTallerPedidoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
//			$DatTallerPedidoDetalle->TpdId,
//			$DatTallerPedidoDetalle->ProId,
//			$DatTallerPedidoDetalle->ProNombre,
//			NULL,
//			$DatTallerPedidoDetalle->TpdCantidad,
//			NULL,
//			($DatTallerPedidoDetalle->TpdTiempoCreacion),
//			($DatTallerPedidoDetalle->TpdTiempoModificacion),
//			$DatTallerPedidoDetalle->UmeNombre,
//			$DatTallerPedidoDetalle->UmeId,
//			$DatTallerPedidoDetalle->RtiId,
//			$DatTallerPedidoDetalle->TpdCantidadReal,
//			$DatTallerPedidoDetalle->ProCodigoOriginal,
//			$DatTallerPedidoDetalle->ProCodigoAlternativo,
//			$DatTallerPedidoDetalle->UmeIdOrigen
//			);
//		
//		}
//	}
//	
//			
//	$InsFichaIngreso = new ClsFichaIngreso();
//	$InsFichaIngreso->FinId = $InsTallerPedido->FinId;
//	$InsFichaIngreso->MtdObtenerFichaIngreso();
//}
?>