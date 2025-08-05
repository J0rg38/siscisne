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
	
//	$InsProducto->ProPrecio = 0;
//	$InsProducto->ProCosto = 0;
	$InsProducto->UmeId = $_POST['CmpUnidadMedidaBase'];
	$InsProducto->UmeIdIngreso = $_POST['CmpUnidadMedidaIngreso'];	

	$InsProducto->ProCodigoBarra = $_POST['CmpCodigoBarra'];
//	$InsProducto->ProStock = $_POST['CmpStock'];
	$InsProducto->ProStockMinimo = $_POST['CmpStockMinimo'];

	$InsProducto->ProValidarUso = (empty($_POST['CmpValidarUso'])?1:$_POST['CmpValidarUso']);

	$InsProducto->RtiId = $_POST['CmpTipo'];	
	$InsProducto->ProFoto = $_SESSION['SesProFoto'.$Identificador];
	$InsProducto->ProValidarStock = 1;	
	$InsProducto->ProStockVerificado = $_POST['CmpStockVerificado'];
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
		$ProId = $InsProducto->MtdVerificarExisteProductoCodigoOriginal($InsProducto->ProCodigoOriginal);
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
	
	
	
	if($Guardar){
		if($InsProducto->MtdRegistrarProducto()){
			
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
		
	$_SESSION['InsProductoCodigoReemplazo'.$Identificador] = new ClsSesionObjeto();
		
			$InsProducto = new ClsProducto();
			
			
	$InsProducto->ProCodigoOriginal = empty($GET_ProductoCodigo)?$GET_ProductoCodigoOriginal:$GET_ProductoCodigo;
	$InsProducto->ProCodigoAlternativo = $GET_ProductoCodigoAlternativo;
	$InsProducto->ProNombre = $GET_ProductoNombre;
	$InsProducto->ProDescripcion = $GET_ProductoNombre;
	$InsProducto->UmeId = empty($GET_ProductoUnidadMedida)?"UME-10007":$GET_ProductoUnidadMedida;



	$InsProducto->RtiId = "RTI-10000";
	//$InsProducto->UmeId = "UME-10007";
	$InsProducto->UmeIdIngreso = "UME-10007";
	
	
}

?>