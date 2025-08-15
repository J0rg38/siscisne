<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsProducto->UsuId = $_SESSION['SesionId'];
	
	$InsProducto->ProId = $_POST['CmpId'];
	$InsProducto->PcaId = $_POST['CmpProductoCategoria'];
	$InsProducto->PcaNombre = $_POST['CmpCategoriaNombre'];
	$InsProducto->ProMarcaReferencia = $_POST['CmpMarcaReferencia'];
	
	$InsProducto->ProCodigoAlternativo = $_POST['CmpCodigoAlternativo'];
	$InsProducto->ProCodigoOriginal = $_POST['CmpCodigoOriginal'];
	$InsProducto->ProNombre = $_POST['CmpNombre'];
	$InsProducto->ProUbicacion = $_POST['CmpUbicacion'];
	
	$InsProducto->ProMarca = $_POST['CmpMarca'];
	
	$InsProducto->ProPeso = (empty($_POST['CmpPeso'])?0:$_POST['CmpPeso']);
	$InsProducto->ProLargo = (empty($_POST['CmpLargo'])?0:$_POST['CmpLargo']);
	$InsProducto->ProAncho = (empty($_POST['CmpAncho'])?0:$_POST['CmpAncho']);
	$InsProducto->ProAlto = (empty($_POST['CmpAlto'])?0:$_POST['CmpAlto']);

	$InsProducto->ProVolumen = ($InsProducto->ProLargo * $InsProducto->ProAncho * $InsProducto->ProAlto)/1000000;
	
	$InsProducto->ProReferencia = addslashes($_POST['CmpReferencia']);
	$InsProducto->ProEspecificacion = $_SESSION['SesProEspecificacion'.$Identificador];
	$InsProducto->ProNota = addslashes($_POST['CmpNota']);
	
//	$InsProducto->ProPrecio = 0;
//	$InsProducto->ProCosto = 0;
	$InsProducto->UmeId = $_POST['CmpUnidadMedidaBase'];
	$InsProducto->UmeIdIngreso = $_POST['CmpUnidadMedidaIngreso'];	

	$InsProducto->ProCodigoBarra = $_POST['CmpCodigoBarra'];
//	$InsProducto->ProStock = $_POST['CmpStock'];
	$InsProducto->ProStockMinimo = $_POST['CmpStockMinimo'];

	$InsProducto->ProValidarUso = (empty($_POST['CmpValidarUso'])?1:$_POST['CmpValidarUso']);

	$InsProducto->RtiId = $_POST['CmpTipo'];	
//	$InsProducto->ProFoto = $_SESSION['SesProFoto'.$Identificador];
	$InsProducto->ProFoto = $_SESSION['SesProFotoSolo'.$Identificador];
		
	$InsProducto->ProStockVerificado = 2;
	$InsProducto->ProValidarStock = $_POST['CmpValidarStock'];	
	
	$InsProducto->LtiId =$_POST['CmpClienteTipo'];
	
	$InsProducto->ProCritico = (empty($_POST['CmpCritico'])?2:$_POST['CmpCritico']);
	$InsProducto->ProDescontinuado = (empty($_POST['CmpDescontinuado'])?2:$_POST['CmpDescontinuado']);
	
	$InsProducto->ProCalcularPrecio = (empty($_POST['CmpCalcularPrecio'])?2:$_POST['CmpCalcularPrecio']);
	$InsProducto->ProTienePromocion = (empty($_POST['CmpTienePromocion'])?2:$_POST['CmpTienePromocion']);
	$InsProducto->ProPorcentajeAdicional = preg_replace("/,/", "", (empty($_POST['CmpPorcentajeAdicional'])?0:$_POST['CmpPorcentajeAdicional']));
	$InsProducto->ProPorcentajeDescuento = preg_replace("/,/", "", (empty($_POST['CmpPorcentajeDescuento'])?0:$_POST['CmpPorcentajeDescuento']));

	$InsProducto->ProEstado = $_POST['CmpEstado'];	
	$InsProducto->ProTiempoCreacion = date("Y-m-d H:i:s");
	$InsProducto->ProTiempoModificacion = date("Y-m-d H:i:s");
	$InsProducto->ProEliminado = 1;

	$InsProducto->PcaNombre = $_POST['CmpCategoriaNombre'];

	$InsProducto->ProductoVehiculoVersion = array();
	$InsProducto->ProductoAno = array();
	$InsProducto->ProductoCodigoReemplazo = array();

	foreach($ArrVehiculoVersiones as $DatVehiculoVersion){

		$InsProductoVehiculoVersion1 = new ClsProductoVehiculoVersion();
		$InsProductoVehiculoVersion1->VveId = $_POST['CmpVehiculoVersion_'.$DatVehiculoVersion->VveId];
		$InsProductoVehiculoVersion1->PvvTiempoCreacion = date("Y-m-d H:i:s");
		$InsProductoVehiculoVersion1->PvvTiempoModificacion = date("Y-m-d H:i:s");
		$InsProductoVehiculoVersion1->InsMysql = NULL;
		
		if(!empty($InsProductoVehiculoVersion1->VveId)){
			$InsProducto->ProductoVehiculoVersion[] = $InsProductoVehiculoVersion1;	
		}	
				
	}
	
	
	for($i=date("Y")-25;$i<=(date("Y"));$i++){

		$InsProductoAno1 = new ClsProductoAno();
		$InsProductoAno1->PanAno = $_POST['CmpAno_'.$i];
		$InsProductoAno1->PanTiempoCreacion = date("Y-m-d H:i:s");
		$InsProductoAno1->PanTiempoModificacion = date("Y-m-d H:i:s");
		$InsProductoAno1->InsMysql = NULL;
		
		if(!empty($InsProductoAno1->PanAno)){
			$InsProducto->ProductoAno[] = $InsProductoAno1;	
		}	
				
	}	
	
//	deb($InsProducto->ProductoAno);
	
	if(!empty($InsProducto->ProCodigoOriginal)){
		$ProId = $InsProducto->MtdVerificarExisteProductoCodigoOriginal(trim($InsProducto->ProCodigoOriginal));
		if(!empty($ProId)){
			$Guardar = false;
			$Resultado.='#ERR_PRO_600';
		}		
	}
		
		
		

	
	$ResProductoCodigoReemplazo = $_SESSION['InsProductoCodigoReemplazo'.$Identificador]->MtdObtenerSesionObjetos(true);

	if(!empty($ResProductoCodigoReemplazo['Datos'])){
		foreach($ResProductoCodigoReemplazo['Datos'] as $DatSesionObjeto){

	
	//SesionObjeto-InsProductoCodigoReemplazo
	//Parametro1 = PcrId
	//Parametro2 = PcrNumero
	//Parametro3 = PcrEstado
	//Parametro4 = PcrTiempoCreacion
	//Parametro5 = PcrTiempoModificacion
	
			$InsProductoCodigoReemplazo1 = new ClsProductoCodigoReemplazo();
			$InsProductoCodigoReemplazo1->PcrId = $DatSesionObjeto->Parametro1;
			$InsProductoCodigoReemplazo1->PcrNumero = $DatSesionObjeto->Parametro2;
			
			$InsProductoCodigoReemplazo1->PcrEstado = $DatSesionObjeto->Parametro3;
			$InsProductoCodigoReemplazo1->PcrTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro4);
			$InsProductoCodigoReemplazo1->PcrTiempoModificacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro5);
			$InsProductoCodigoReemplazo1->PcrEliminado = $DatSesionObjeto->Eliminado;				
			$InsProductoCodigoReemplazo1->InsMysql = NULL;
			
			$InsProducto->ProductoCodigoReemplazo[] = $InsProductoCodigoReemplazo1;		
			
			if($InsProductoCodigoReemplazo1->PcrEliminado==1){					

			}

		}

	}
	
	
	//		SesionObjeto-ProductoFoto
	//		Parametro1 = PfoId
	//		Parametro2 =
	//		Parametro3 = PfoArchivo
	//		Parametro4 = PfoEstado
	//		Parametro5 = PfoTiempoCreacion
	//		Parametro6 = PfoTiempoModificacion
	//		Parametro7 = PfoTipo
		
		$RepSesionObjetos = $_SESSION['InsProductoFoto'.$Identificador]->MtdObtenerSesionObjetos(true);
		$ArrSesionObjetos = $RepSesionObjetos['Datos'];
		
		if(!empty($ArrSesionObjetos)){
			foreach($ArrSesionObjetos as $DatSesionObjeto){
		
				$InsProductoFoto1 = new ClsProductoFoto();
				$InsProductoFoto1->PfoId = $DatSesionObjeto->Parametro1;
				$InsProductoFoto1->PfoArchivo = $DatSesionObjeto->Parametro3;
				$InsProductoFoto1->PfoTipo = $DatSesionObjeto->Parametro7;
				$InsProductoFoto1->PfoEstado = $DatSesionObjeto->Parametro4;
				$InsProductoFoto1->PfoTiempoCreacion = FncCambiaFechaAMysql($DatSesionObjeto->Parametro5);
				$InsProductoFoto1->PfoTiempoModificacion = date("Y-m-d H:i:s");
				$InsProductoFoto1->PfoEliminado = $DatSesionObjeto->Eliminado;
				$InsProductoFoto1->InsMysql = NULL;
		
				$InsProducto->ProductoFoto[] = $InsProductoFoto1;	
		
			}
		}	
	
		/*
		LISTA DISPONIBILIDAD
		*/
		
		$Disponible = 0;
		$Cantidad = 0;
		
		if(!empty($InsProducto->ProCodigoOriginal)){
		
			$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
			$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",trim($InsProducto->ProCodigoOriginal) ,"PdiTiempoCreacion","DESC","1",1);
			$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
			
			//$Disponibilidad = "";
			if(!empty($ArrProductoDisponibilidades)){
				foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
		
					$Disponible =  ($DatProductoDisponibilidad->PdiDisponible);
					$Cantidad =  ($DatProductoDisponibilidad->PdiCantidad);
		
				}
			}
			
			
		}
	
		$InsProducto->ProTieneDisponibilidadGM = $Disponible;
		$InsProducto->ProDisponibilidadCantidadGM = $Cantidad;
	
		/*
		LISTA REEMPLAZO
		*/		
		
		$Reemplazo = "NO";
		
		if(!empty($InsProducto->ProCodigoOriginal)){
		
			$InsProductoReemplazo = new ClsProductoReemplazo();
			 $ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",trim($InsProducto->ProCodigoOriginal) ,"PreId","ASC",NULL,1);
			$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
			
			if(!empty($ArrProductoReemplazos)){
				$Reemplazo= "SI";
			}
		
		}	
	
		$InsProducto->ProTieneReemplazoGM = $Reemplazo;
	
		/*
		LISTA PRECIO
		*/
	
		$Precio = 0;
		$PrecioReal = 0;
		$MonIdListaPrecio = NULL;
		$CalcularPrecio = 1;
		
		if(!empty($InsProducto->ProCodigoOriginal)){	
		
			$InsProductoListaPrecio = new ClsProductoListaPrecio();	
			$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$InsProducto->ProCodigoOriginal,'PlpTiempoCreacion','DESC',"1",1);
			$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
							
			if(!empty($ArrProductoListaPrecios)){
				foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
				
					$Precio = $DatProductoListaPrecio->PlpPrecio;
					$PrecioReal = $DatProductoListaPrecio->PlpPrecioReal;
					$MonIdListaPrecio = $DatProductoListaPrecio->MonId;
					//$CalcularPrecio = 1;
					
				}
			}
	
		}
		
		$InsProducto->ProListaPrecioCosto = $Precio;
		$InsProducto->ProListaPrecioCostoReal = $PrecioReal;
		$InsProducto->MonIdListaPrecio = $MonIdListaPrecio;
		$InsProducto->ProCalcularPrecio = $CalcularPrecio;
		
		/*
		LISTA PROMOCION
		*/
		
		$PrecioPromocion = 0;
		$PrecioRealPromocion = 0;
		$MonIdListaPromocion = NULL;
		$CalcularPrecio = 1;
		
		if(!empty($InsProducto->ProCodigoOriginal)){	
		
		
			$InsProductoListaPromocion = new ClsProductoListaPromocion();
			$ResProductoListaPromocion = $InsProductoListaPromocion->MtdObtenerProductoListaPromociones("PloCodigo","esigual",$InsProducto->ProCodigoOriginal,'PloId','ASC',"1",1);
			$ArrProductoListaPromociones = $ResProductoListaPromocion['Datos'];
							
			if(!empty($ArrProductoListaPromociones)){
				foreach($ArrProductoListaPromociones as $DatProductoListaPromocion){
				
					$PrecioPromocion = $DatProductoListaPromocion->PloPrecio;
					$PrecioRealPromocion = $DatProductoListaPromocion->PloPrecioReal;
					$MonIdListaPromocion = $DatProductoListaPromocion->MonId;
					//$CalcularPrecio = 2;
						
				}
			}
		}
		
		$InsProducto->ProListaPromocionCosto = $PrecioPromocion;
		$InsProducto->ProListaPromocionCostoReal = $PrecioRealPromocion;
		$InsProducto->MonIdListaPromocion = $MonIdListaPromocion;
		$InsProducto->ProCalcularPrecio = $CalcularPrecio;
		
	
	if($Guardar){
		if($InsProducto->MtdRegistrarProducto()){
			
			
			$InsProducto->ProCosto = $Precio;
			$InsProducto->MtdActualizarProductoCosto();
			
			$InsProducto->MtdEditarProductoDato("ProListaPrecioCosto",$InsProducto->ProListaPrecioCosto,$InsProducto->ProId);							
			$InsProducto->MtdEditarProductoDato("ProListaPrecioCostoReal",$InsProducto->ProListaPrecioCostoReal,$InsProducto->ProId);							
			$InsProducto->MtdEditarProductoDato("MonIdListaPrecio",$InsProducto->MonIdListaPrecio,$InsProducto->ProId);
			$InsProducto->MtdEditarProductoDato("ProCalcularPrecio",$InsProducto->ProCalcularPrecio,$InsProducto->ProId);
			
			$InsProducto->MtdEditarProductoDato("ProListaPromocionCosto",$InsProducto->ProListaPromocionCosto,$InsProducto->ProId);							
			$InsProducto->MtdEditarProductoDato("ProListaPromocionCostoReal",$InsProducto->ProListaPromocionCostoReal,$InsProducto->ProId);							
			$InsProducto->MtdEditarProductoDato("MonIdListaPromocion",$InsProducto->MonIdListaPromocion,$InsProducto->ProId);
			$InsProducto->MtdEditarProductoDato("ProCalcularPrecio",$InsProducto->ProCalcularPrecio,$InsProducto->ProId);
			
			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
                    self.parent.tb_remove('<?php echo $GET_mod;?>');
                    self.parent.$('#CmpProductoId').val("<?php echo $InsProducto->ProId;?>");
                    self.parent.FncProductoBuscar("Id");
                </script>
<?php
			}
			
			//unset($_SESSION['SesProFoto'.$Identificador]);
			//unset($_SESSION['SesProEspecificacion'.$Identificador]);
			//unset($InsProducto);	
			FncNuevo();	
			//$InsProducto= new ClsProducto();
			$Resultado.='#SAS_PRO_101';
			$Registro = false;

		} else{
			$InsProducto->PcaId = $_POST['CmpCategoria'];
			$Resultado.='#ERR_PRO_101';
		}
	}

}else{
	FncNuevo();
}


function FncNuevo(){
	
	global $Identificador;
	global $InsProducto;
	
	global $GET_ProductoCodigo;
	global $GET_ProductoCodigoOriginal;
	global $GET_ProductoCodigoAlternativo;
	global $GET_ProductoNombre;
	global $GET_ProductoUnidadMedida;
	
	unset($_SESSION['SesProFoto'.$Identificador]);
	unset($_SESSION['SesProEspecificacion'.$Identificador]);
	unset($_SESSION['InsProductoCodigoReemplazo'.$Identificador]);
	unset($_SESSION['InsProductoFoto'.$Identificador]);
		
	$_SESSION['InsProductoCodigoReemplazo'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsProductoFoto'.$Identificador] = new ClsSesionObjeto();
	
			$InsProducto = new ClsProducto();
			
			
	$InsProducto->ProCodigoOriginal = empty($GET_ProductoCodigo)?$GET_ProductoCodigoOriginal:$GET_ProductoCodigo;
	$InsProducto->ProCodigoAlternativo = $GET_ProductoCodigoAlternativo;
	$InsProducto->ProNombre = $GET_ProductoNombre;
	$InsProducto->ProDescripcion = $GET_ProductoNombre;
	$InsProducto->UmeId = empty($GET_ProductoUnidadMedida)?"UME-10007":$GET_ProductoUnidadMedida;



	$InsProducto->RtiId = "RTI-10000";
	$InsProducto->PcaId = "PCA-10000";
	//$InsProducto->UmeId = "UME-10007";
	$InsProducto->UmeIdIngreso = "UME-10007";
	$InsProducto->ProCalcularPrecio = 1;
	$InsProducto->ProCritico = 2;
	$InsProducto->ProDescontinuado = 2;
}

?>