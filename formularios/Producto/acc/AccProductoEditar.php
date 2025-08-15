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
	$InsProducto->ProCodigoOriginalAnterior = $_POST['CmpCodigoOriginalAnterior'];
	
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

	
	$InsProducto->ProPrecio =$_POST['CmpPrecio'];
	$InsProducto->ProCosto = $_POST['CmpCosto'];
	$InsProducto->ProCostoIngreso = $_POST['CmpCostoIngreso'];
	$InsProducto->UmeId = $_POST['CmpUnidadMedidaBase'];
	$InsProducto->UmeIdIngreso = $_POST['CmpUnidadMedidaIngreso'];
	$InsProducto->ProCodigoBarra = $_POST['CmpCodigoBarra'];
//	$InsProducto->ProStock = $_POST['CmpStock'];
	$InsProducto->ProStockMinimo = $_POST['CmpStockMinimo'];
	
	$InsProducto->ProValidarUso = (empty($_POST['CmpValidarUso'])?1:$_POST['CmpValidarUso']);
	
	$InsProducto->RtiId = $_POST['CmpTipo'];	
	//$InsProducto->ProFoto = $_SESSION['SesProFotoSolo'.$Identificador];
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

	$InsProducto->ProTiempoModificacion = date("Y-m-d H:i:s");
	$InsProducto->PcaNombre = $_POST['CmpCategoriaNombre'];
	
	$InsProducto->ProductoVehiculoVersion = array();
	$InsProducto->ProductoAno = array();
	$InsProducto->ProductoCodigoReemplazo = array();
	
	foreach($ArrVehiculoVersiones as $DatVehiculoVersion){

		$InsProductoVehiculoVersion1 = new ClsProductoVehiculoVersion();
		$InsProductoVehiculoVersion1->PvvId = $_POST['CmpProductoVehiculoVersion_'.$DatVehiculoVersion->VveId];
		$InsProductoVehiculoVersion1->VveId = $_POST['CmpVehiculoVersion_'.$DatVehiculoVersion->VveId];
		$InsProductoVehiculoVersion1->PvvTiempoCreacion = date("Y-m-d H:i:s");
		$InsProductoVehiculoVersion1->PvvTiempoModificacion = date("Y-m-d H:i:s");
		
		if(!empty($InsProductoVehiculoVersion1->PvvId)){
			if(empty($InsProductoVehiculoVersion1->VveId)){
				$InsProductoVehiculoVersion1->PvvEliminado = 2;
			}else{
				$InsProductoVehiculoVersion1->PvvEliminado = 1;
			}
		}else{
			if(empty($InsProductoVehiculoVersion1->VveId)){
				$InsProductoVehiculoVersion1->PvvEliminado = 2;
			}else{
				$InsProductoVehiculoVersion1->PvvEliminado = 1;
			}

		}

		$InsProductoVehiculoVersion1->InsMysql = NULL;

		$InsProducto->ProductoVehiculoVersion[] = $InsProductoVehiculoVersion1;	
				
	}
	
	
	
	
	


	for($i=date("Y")-25;$i<=(date("Y"));$i++){

		$InsProductoAno1 = new ClsProductoAno();
		$InsProductoAno1->PanId = $_POST['CmpProductoAno_'.$i];
		$InsProductoAno1->PanAno = $_POST['CmpAno_'.$i];
		$InsProductoAno1->PanTiempoCreacion = date("Y-m-d H:i:s");
		$InsProductoAno1->PaTiempoModificacion = date("Y-m-d H:i:s");
		
		if(!empty($InsProductoAno1->PanId)){
			if(empty($InsProductoAno1->PanAno)){
				$InsProductoAno1->PanEliminado = 2;
			}else{
				$InsProductoAno1->PanEliminado = 1;
			}
		}else{
			if(empty($InsProductoAno1->PanAno)){
				$InsProductoAno1->PanEliminado = 2;
			}else{
				$InsProductoAno1->PanEliminado = 1;
			}

		}

		$InsProductoAno1->InsMysql = NULL;

		$InsProducto->ProductoAno[] = $InsProductoAno1;	
				
	}
	
	if(($InsProducto->ProCodigoOriginal) <> $InsProducto->ProCodigoOriginalAnterior){
		$ProId = $InsProducto->MtdVerificarExisteProductoCodigoOriginal(trim($InsProducto->ProCodigoOriginal),$InsProducto->ProId);
		if(!empty($ProId)){
			$Guardar = false;
			$Resultado.='#ERR_PRO_600';
		}		
	}
	
	$ResProductoCodigoReemplazo = $_SESSION['InsProductoCodigoReemplazo'.$Identificador]->MtdObtenerSesionObjetos(false);

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
	
	$RepSesionObjetos = $_SESSION['InsProductoFoto'.$Identificador]->MtdObtenerSesionObjetos(false);
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
			
	if($Guardar){	
		if($InsProducto->MtdEditarProducto()){		
			
			if(!empty($InsProducto->ProCodigoOriginalAnterior)){
				
				//deb($InsProducto->ProCodigoOriginal." - ".$InsProducto->ProCodigoOriginalAnterior);
				if($InsProducto->ProCodigoOriginal<>$InsProducto->ProCodigoOriginalAnterior){
					
					if($InsProducto->MtdEditarProductoCodigoOriginal($InsProducto->ProId,$InsProducto->ProCodigoOriginal)){
				
					}
					
				}
			}
	
			
		
			if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
			}
						
			$Resultado.='#SAS_PRO_102';	
			FncCargarDatos();	
			$Edito = true;	
		}else{			
			$Resultado.='#ERR_PRO_102';		
		}			
	}
	
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsProducto;
	global $Identificador;
	
	unset($_SESSION['SesProFotoSolo'.$Identificador]);
	unset($_SESSION['SesProEspecificacion'.$Identificador]);
	unset($_SESSION['InsProductoCodigoReemplazo'.$Identificador]);
	unset($_SESSION['InsProductoFoto'.$Identificador]);
	
	$InsProducto->ProId = $GET_id;
	$InsProducto->MtdObtenerProducto();		
	
	$InsProducto->ProCodigoOriginalAnterior = $InsProducto->ProCodigoOriginal;
			
	$_SESSION['SesProFotoSolo'.$Identificador] =	$InsProducto->ProFoto;
	$_SESSION['SesProEspecificacion'.$Identificador] =	$InsProducto->ProEspecificacion;
	$_SESSION['InsProductoCodigoReemplazo'.$Identificador] = new ClsSesionObjeto();
	$_SESSION['InsProductoFoto'.$Identificador] = new ClsSesionObjeto();
	
	//SesionObjeto-InsProductoCodigoReemplazo
	//Parametro1 = PcrId
	//Parametro2 = PcrNumero
	//Parametro3 = PcrEstado
	//Parametro4 = PcrTiempoCreacion
	//Parametro5 = PcrTiempoModificacion
		
	if(!empty($InsProducto->ProductoCodigoReemplazo)){
		foreach($InsProducto->ProductoCodigoReemplazo as $DatProductoCodigoReemplazo){					
		
			$_SESSION['InsProductoCodigoReemplazo'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatProductoCodigoReemplazo->PcrId,
			$DatProductoCodigoReemplazo->PcrNumero,
			NULL,
			($DatProductoCodigoReemplazo->PcrTiempoCreacion),
			($DatProductoCodigoReemplazo->PcrTiempoModificacion)
			);
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
		
//		deb($InsProducto->ProductoFoto);
	if(!empty($InsProducto->ProductoFoto)){
		foreach($InsProducto->ProductoFoto as $DatProductoFoto){
			
			$_SESSION['InsProductoFoto'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatProductoFoto->PfoId,
			NULL,
			$DatProductoFoto->PfoArchivo,			
			$DatProductoFoto->PfoEstado,
			($DatProductoFoto->PfoTiempoCreacion),
			($DatProductoFoto->PfoTiempoModificacion),
			$DatProductoFoto->PfoTipo
			);
	
		}
	}	

}

?>