<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	
	
	$InsAlmacenStock->AlmId = $_POST['CmpAlmacenId'];	
	$InsAlmacenStock->SucId = $_POST['CmpSucursal'];
	
	
	$InsAlmacenStock->ProId = $_POST['CmpProductoId'];
	
	$InsAlmacenStock->ProNombre = $_POST['CmpProductoNombre'];
	$InsAlmacenStock->ProReferencia = $_POST['CmpProductoReferencia'];
	$InsAlmacenStock->UmeNombre = $_POST['CmpProductoUnidadMedida'];
	
	$InsAlmacenStock->ProPromedioMensual = $_POST['CmpProductoPromedioMensual'];
	$InsAlmacenStock->ProDiasInmovilizado = $_POST['CmpProductoPromedioMensual'];
	$InsAlmacenStock->ProFechaUltimaSalida = $_POST['CmpFechaUltimaSalida'];
	
	$InsAlmacenStock->AstUbicacion = $_POST['CmpProductoUbicacion'];
	
	$InsAlmacenStock->AstStockMinimo = eregi_replace(",","",(empty($_POST['CmpStockMinimo'])?0:$_POST['CmpStockMinimo']));
	$InsAlmacenStock->AstStockMaximo = eregi_replace(",","",(empty($_POST['CmpStockMaximo'])?0:$_POST['CmpStockMaximo']));
	
	$InsAlmacenStock->AstObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsAlmacenStock->AstTiempoModificacion = date("Y-m-d H:i:s");
		
	if($InsAlmacenStock->MtdEditarAlmacenStockStockMinimo()){				

		if(!empty($GET_dia)){
?>
			
<?php
		}

		$Edito = true;	
		FncCargarDatos();			
		$Resultado.='#SAS_AST_102';
		
	}else{			
		$Resultado.='#ERR_AST_102';		
	}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $GET_Almacen;		
	global $GET_Sucursal;
	global $GET_Ano;

//deb($GET_id);
//deb($GET_Almacen);
//deb($GET_Sucursal);
//deb($GET_Ano);

	global $InsAlmacenStock;
	global $Identificador;
	

	
	$InsAlmacenStock->ProId = $GET_id;
	$InsAlmacenStock->MtdObtenerAlmacenStock();
	$InsAlmacenStock->SucId = $GET_Sucursal;
	$InsAlmacenStock->AlmId = $GET_Almacen;

	//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false,$oSucursal=NULL,$oAno) 
	$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks(NULL,NULL,NULL,"AstStock","DESC",NULL,"1",NULL,$GET_Ano."-01-01",date("Y-m-d"),NULL,NULL,NULL,$GET_id,NULL,$GET_Almacen,false,$GET_Sucursal,$GET_Ano);
	$ArrAlmacenStocks = $ResAlmacenStock['Datos'];
	
	
	$StockReal = 0;
	
	
	$StockMinimo = 0;
	$StockMaximo = 0;
	$StockObservacion = "";
	
	if(!empty($ArrAlmacenStocks)){
		foreach($ArrAlmacenStocks as $DatAlmacenStock){
			
			$StockMinimo = $DatAlmacenStock->AstStockMinimo;
			$StockMaximo = $DatAlmacenStock->AstStockMaximo;
			$StockObservacion = $DatAlmacenStock->AstObservacion;
		}
	}


	$InsAlmacenStock->AstStockMinimo = $StockMinimo;
	$InsAlmacenStock->AstStockMaximo = $StockMaximo;
	$InsAlmacenStock->AstObservacion = $StockObservacion;

}

?>