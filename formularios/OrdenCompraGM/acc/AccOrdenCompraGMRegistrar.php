<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';
	
	$InsOrdenCompra->UsuId = $_SESSION['SesionId'];	
		
	$InsOrdenCompra->OcoId = $_POST['CmpId'];
	$InsOrdenCompra->OcoTipo = $_POST['CmpTipo'];

	$InsOrdenCompra->OcoCodigoDealer = $_POST['CmpCodigoDealer'];
	
	$InsOrdenCompra->PrvId = $_POST['CmpProveedorId'];

	$InsOrdenCompra->MonId = $_POST['CmpMonedaId'];
	$InsOrdenCompra->OcoTipoCambio = $_POST['CmpTipoCambio'];
	
	$InsOrdenCompra->OcoFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	list($InsOrdenCompra->OcoAno,$InsOrdenCompra->OcoMes,$Dia) = explode("-",$InsOrdenCompra->OcoFecha);
	
	$InsOrdenCompra->OcoHora = ($_POST['CmpHora']);
	$InsOrdenCompra->OcoObservacion = addslashes($_POST['CmpObservacion']);

	$InsOrdenCompra->OcoEstado = 1;	
	$InsOrdenCompra->OcoTiempoCreacion = date("Y-m-d H:i:s");
	$InsOrdenCompra->OcoTiempoModificacion = date("Y-m-d H:i:s");
	$InsOrdenCompra->OcoEliminado = 1;
	
	$InsOrdenCompra->TdoId = $_POST['CmpTipoDocumento'];
	$InsOrdenCompra->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsOrdenCompra->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];
	
	$InsOrdenCompra->OrdenCompraDetalle = array();

	if($InsOrdenCompra->MonId<>$EmpresaMonedaId){
		if(empty($InsOrdenCompra->OcoTipoCambio)){
			$Guardar = false;
			$Resultado.='#ERR_OCO_600';
		}
	}
	
	$InsOrdenCompra->OcoTotal = 0;

/*
SesionObjeto-OrdenCompraDetalle
Parametro1 = OcdId
Parametro2 = ProId
Parametro3 = Nombre
Parametro4 = Costo
Parametro5 = Cantidad
Parametro6 = Importe
Parametro7 = TiempoCreacion
Parametro8 = TiempoModificacion
Parametro9 = UnidadMedida
*/
//	$InsOrdenCompra->OcoTotal = 0;
//	
//	if(!empty($ArrPedidoCompras)){
//		foreach($ArrPedidoCompras as $DatPedidoCompra){
//	
//			$InsPedidoCompra = new ClsPedidoCompra();
//			$InsPedidoCompra->PcoId = $_POST['CmpPedidoCompra_'.$DatPedidoCompra->PcoId];
//			$InsPedidoCompra->PcoTiempoModificacion = date("Y-m-d H:i:s");
//			
//			if(!empty($InsPedidoCompra->PcoId)){
//				$InsOrdenCompra->PedidoCompra[] = $InsPedidoCompra;			
//			}
//	
//		}
//	}
	
	if($Guardar){	
		if($InsOrdenCompra->MtdRegistrarOrdenCompra()){
			
			if(!empty($GET_dia)){
?>
<script type="text/javascript">
	self.parent.tb_remove('<?php echo $GET_mod;?>');
	self.parent.$('#CmpOrdenCompraId').val("<?php echo $InsOrdenCompra->OcoId;?>");
	self.parent.FncOrdenCompraBuscar("Id");
</script>
<?php
			}

			$Registro =  true;
			$Resultado.='#SAS_OCO_101';
		} else{
			$Resultado.='#ERR_OCO_101';		
		}
	}

	$InsOrdenCompra->OcoFecha = FncCambiaFechaANormal($InsOrdenCompra->OcoFecha);
		
}else{

	unset($_SESSION['InsOrdenCompraDetalle'.$Identificador]);

	$InsOrdenCompra->OcoMes = date("m");
	$InsOrdenCompra->OcoAno = date("Y");
	$InsOrdenCompra->OcoHora = date("H:i");
	$InsOrdenCompra->OcoEstado = 1;
	
	$InsOrdenCompra->MonId = "MON-10001";
	$InsOrdenCompra->OcoTipoCambio = $_SESSION['SesionTipoCambioCompra'];
	$InsOrdenCompra->OcoCodigoDealer = "8001200006";
}
?>