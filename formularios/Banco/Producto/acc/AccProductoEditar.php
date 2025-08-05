<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsProducto->ProId = $_POST['CmpId'];
	$InsProducto->PcaId = $_POST['CmpCategoriaId'];
	$InsProducto->PcaNombre = $_POST['CmpCategoriaNombre'];
	
	$InsProducto->ProCodigoAlternativo = $_POST['CmpCodigoAlternativo'];
	$InsProducto->ProCodigoOriginal = $_POST['CmpCodigoOriginal'];
	$InsProducto->ProNombre = $_POST['CmpNombre'];
	$InsProducto->ProUbicacion = $_POST['CmpUbicacion'];
	$InsProducto->ProReferencia = $_POST['CmpReferencia'];
	$InsProducto->ProEspecificacion = $_SESSION['SesProEspecificacion'.$Identificador];
	
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
	$InsProducto->ProFoto = $_SESSION['SesProFoto'.$Identificador];
	
	$InsProducto->ProStockVerificado = $_POST['CmpStockVerificado'];	
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
	
	if(!empty($InsProducto->ProCodigoOriginal)){
		$ProId = $InsProducto->MtdVerificarExisteProductoCodigoOriginal($InsProducto->ProCodigoOriginal,$InsProducto->ProId);
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

	if($Guardar){	
		if($InsProducto->MtdEditarProducto()){		
		
		
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
	
	unset($_SESSION['SesProFoto'.$Identificador]);
	unset($_SESSION['SesProEspecificacion'.$Identificador]);
	unset($_SESSION['InsProductoCodigoReemplazo'.$Identificador]);
	
	$InsProducto->ProId = $GET_id;
	$InsProducto = $InsProducto->MtdObtenerProducto();		
			
	$_SESSION['SesProFoto'.$Identificador] =	$InsProducto->ProFoto;
	$_SESSION['SesProEspecificacion'.$Identificador] =	$InsProducto->ProEspecificacion;
	$_SESSION['InsProductoCodigoReemplazo'.$Identificador] = new ClsSesionObjeto();
	
	
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

}

?>