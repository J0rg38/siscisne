<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsProducto->ProId = $_POST['CmpId'];
	$InsProducto->SucId = $_POST['CmpSucursalId'];	
	
	$InsProducto->ProCodigoAlternativo = $_POST['CmpCodigoAlternativo'];
	$InsProducto->ProCodigoOriginal = $_POST['CmpCodigoOriginal'];
	$InsProducto->ProNombre = $_POST['CmpNombre'];

	//$InsProducto->ProPrecioMercado = eregi_replace(",","",$_POST['CmpPrecioMercado']);
	$InsProducto->ProPrecioMercado = 0;
	
	$InsProducto->UmeId = $_POST['CmpUnidadMedidaBase'];
	$InsProducto->UmeIdIngreso = $_POST['CmpUnidadMedidaIngreso'];

	$InsProducto->RtiId = $_POST['CmpTipo'];	
	$InsProducto->ProCosto = eregi_replace(",","",$_POST['CmpCosto']);
	$InsProducto->ProCostoIngreso = eregi_replace(",","",$_POST['CmpCostoIngreso']);
	
	$InsProducto->ProEstado = $_POST['CmpEstado'];	
	$InsProducto->ProPorcentajeImpuestoVenta = eregi_replace(",","",$_POST['CmpPorcentajeImpuestoVenta']);

	$InsProducto->ProTiempoModificacion = date("Y-m-d H:i:s");

	$InsProducto->ListaPrecio = array();
//	$InsProducto->ProductoCosto = array();

	$i = 1;
	
	//deb($_POST);
	if(!empty($ArrClienteTipos)){
		foreach($ArrClienteTipos as $DatClienteTipo){
			//echo $DatClienteTipo->LtiId."/".$DatClienteTipo->LtiNombre;
			//echo "<br>";
			foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
				
			//echo $DatProductoTipoUnidadMedidaSalida->UmeId."/".$DatProductoTipoUnidadMedidaSalida->UmeNombre;
			//echo "<br>";
			
				//echo $i;
				//echo "<br>";
				$UnidadMedidaEquivalente = 0;
				
				if($InsProducto->UmeId == $DatProductoTipoUnidadMedidaSalida->UmeId){
			
					$UnidadMedidaEquivalente = 1;
				
				}else{
				
					$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$DatProductoTipoUnidadMedidaSalida->UmeId,$InsProducto->UmeId);
					$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
				
					foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
						$UnidadMedidaEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
					}
				
				}
		
		//deb($_POST['CmpSucursalId']);
				if(!empty($UnidadMedidaEquivalente)){
					
				//	deb('CmpListaPrecioId_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId);
					//deb($_POST['CmpListaPrecioId_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId]);
					
					$InsListaPrecio = new ClsListaPrecio();
					$InsListaPrecio->LprId = $_POST['CmpListaPrecioId_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId];			
					$InsListaPrecio->SucId = $_POST['CmpSucursalId'];	
					//deb($InsListaPrecio->SucId);					
					$InsListaPrecio->LtiId = $DatClienteTipo->LtiId;
					$InsListaPrecio->UmeId = $DatProductoTipoUnidadMedidaSalida->UmeId;
					
					$InsListaPrecio->LprCosto = eregi_replace(",","",$_POST['CmpListaPrecioCosto_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId]);

					$InsListaPrecio->LprUtilidad = eregi_replace(",","",$_POST['CmpListaPrecioUtilidad_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId]);
					$InsListaPrecio->LprOtroCosto = (eregi_replace(",","",$_POST['CmpListaPrecioOtroCosto_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])*1);				
					$InsListaPrecio->LprManoObra = (eregi_replace(",","",$_POST['CmpListaPrecioManoObra_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])*1);				

					$InsListaPrecio->LprAdicional = eregi_replace(",","",((empty($_POST['CmpListaPrecioAdicional_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])?0:$_POST['CmpListaPrecioAdicional_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])));
					$InsListaPrecio->LprDescuento = eregi_replace(",","",((empty($_POST['CmpListaPrecioDescuento_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])?0:$_POST['CmpListaPrecioDescuento_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])));

					$InsListaPrecio->LprPorcentajeUtilidad = eregi_replace(",","",((empty($_POST['CmpListaPrecioPorcentajeUtilidad_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])?0:$_POST['CmpListaPrecioPorcentajeUtilidad_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])));
					$InsListaPrecio->LprPorcentajeOtroCosto = (eregi_replace(",","",$_POST['CmpListaPrecioPorcentajeOtroCosto_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])*1);
					$InsListaPrecio->LprPorcentajeManoObra = (eregi_replace(",","",$_POST['CmpListaPrecioPorcentajeManoObra_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])*1);

					$InsListaPrecio->LprPorcentajeDescuento = eregi_replace(",","",((empty($_POST['CmpListaPrecioPorcentajeDescuento_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])?0:$_POST['CmpListaPrecioPorcentajeDescuento_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])));
					$InsListaPrecio->LprPorcentajeAdicional = eregi_replace(",","",((empty($_POST['CmpListaPrecioPorcentajeAdicional_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])?0:$_POST['CmpListaPrecioPorcentajeAdicional_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId])));
					
					$InsListaPrecio->LprValorVenta = eregi_replace(",","",$_POST['CmpListaPrecioValorVenta_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId]);
					$InsListaPrecio->LprImpuesto = eregi_replace(",","",$_POST['CmpListaPrecioImpuesto_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId]);
					$InsListaPrecio->LprPrecio = eregi_replace(",","",$_POST['CmpListaPrecioPrecio_'.$DatClienteTipo->LtiId.'_'.$DatProductoTipoUnidadMedidaSalida->UmeId]);
	
					$InsListaPrecio->LprTiempoCreacion = date("Y-m-d H:i:s");
					$InsListaPrecio->LprTiempoModificacion = date("Y-m-d H:i:s");
					$InsListaPrecio->LprEliminado = 1;
					//deb($InsListaPrecio->LprCosto);	
					
					//deb($InsListaPrecio);	
					
	//				$InsListaPrecio->LprCosto = (empty($InsListaPrecio->LprCosto)?0:$InsListaPrecio->LprCosto);
//					
//					$InsListaPrecio->LprUtilidad = (empty($InsListaPrecio->LprCosto)?0:$InsListaPrecio->LprUtilidad);
//					$InsListaPrecio->LprOtroCosto = (empty($InsListaPrecio->LprCosto)?0:$InsListaPrecio->LprOtroCosto);
//					$InsListaPrecio->LprManoObra = (empty($InsListaPrecio->LprCosto)?0:$InsListaPrecio->LprManoObra);
//					
//					$InsListaPrecio->LprAdicional = (empty($InsListaPrecio->LprCosto)?0:$InsListaPrecio->LprAdicional);
//					$InsListaPrecio->LprDescuento = (empty($InsListaPrecio->LprCosto)?0:$InsListaPrecio->LprDescuento);
//
//					
//					$InsListaPrecio->LprPorcentajeUtilidad = (empty($InsListaPrecio->LprPorcentajeUtilidad)?0:$InsListaPrecio->LprPorcentajeUtilidad);
//					$InsListaPrecio->LprPorcentajeOtroCosto = (empty($InsListaPrecio->LprPorcentajeOtroCosto)?0:$InsListaPrecio->LprPorcentajeOtroCosto);
//					$InsListaPrecio->LprPorcentajeManoObra = (empty($InsListaPrecio->LprPorcentajeManoObra)?0:$InsListaPrecio->LprPorcentajeManoObra);
//					
//					$InsListaPrecio->LprPorcentajeDescuento = (empty($InsListaPrecio->LprPorcentajeDescuento)?0:$InsListaPrecio->LprPorcentajeDescuento);
//					$InsListaPrecio->LprPorcentajeAdicional = (empty($InsListaPrecio->LprPorcentajeAdicional)?0:$InsListaPrecio->LprPorcentajeAdicional);
//
//					$InsListaPrecio->LprValorVenta = (empty($InsListaPrecio->LprValorVenta)?0:$InsListaPrecio->LprValorVenta);
//					$InsListaPrecio->LprImpuesto = (empty($InsListaPrecio->LprImpuesto)?0:$InsListaPrecio->LprImpuesto);
//					$InsListaPrecio->LprPrecio = (empty($InsListaPrecio->LprPrecio)?0:$InsListaPrecio->LprPrecio);
					
					$InsProducto->ListaPrecio[] = $InsListaPrecio;
					
					}
			
				$i++;
			}
	
		}
	}
	
	
	//echo "TOTAL: ".$i;
	//echo "TOTAL2: ".count($InsProducto->ListaPrecio);
	
//	deb($_POST);
//	if(!empty($ArrProductoTipoUnidadMedidaSalidas)){
//		foreach($ArrProductoTipoUnidadMedidaSalidas as $DatProductoTipoUnidadMedidaSalida){
//	
//				$InsProductoCosto = new ClsProductoCosto();
//				$InsProductoCosto->RcoId = $_POST['CmpProductoCostoId_'.$DatProductoTipoUnidadMedidaSalida->UmeId];			
//				$InsProductoCosto->UmeId = $DatProductoTipoUnidadMedidaSalida->UmeId;
//				$InsProductoCosto->UmeIdIngreso = $InsProducto->UmeIdIngreso;
//				$InsProductoCosto->RcoCosto = eregi_replace(",","",$_POST['CmpProductoCostoCosto_'.$DatProductoTipoUnidadMedidaSalida->UmeId]);
//				$InsProductoCosto->RcoTiempoCreacion = date("Y-m-d H:i:s");
//				$InsProductoCosto->RcoTiempoModificacion = date("Y-m-d H:i:s");
//				$InsProductoCosto->RcoEliminado = 1;
//				
//				$InsProducto->ProductoCosto[] = $InsProductoCosto;
//						
//		}
//	}

	if($InsProducto->MtdActualizarListaPrecioMercado()){					
	
			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
                self.parent.tb_remove('<?php echo $GET_mod;?>');
                </script>
<?php
			}
		
		$Edito = true;
		
		$Resultado.='#SAS_LPR_102';	
		FncCargarDatos();		
	}else{			
		$Resultado.='#ERR_LPR_102';		
	}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsProducto;
	global $Identificador;
	global $ArrListaPrecios;
	
	
	$InsProducto->ProId = $GET_id;
	$InsProducto = $InsProducto->MtdObtenerProducto();		
	
			
}

?>