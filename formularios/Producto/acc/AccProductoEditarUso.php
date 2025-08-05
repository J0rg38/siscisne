<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsProducto->UsuId = $_SESSION['SesionId'];
	
	$InsProducto->ProId = $_POST['CmpId'];
	$InsProducto->ProCodigoAlternativo = $_POST['CmpCodigoAlternativo'];
	$InsProducto->ProCodigoOriginal = $_POST['CmpCodigoOriginal'];
	$InsProducto->ProNombre = $_POST['CmpNombre'];
	
	$InsProducto->ProValidarUso = (empty($_POST['CmpValidarUso'])?1:$_POST['CmpValidarUso']);
	$InsProducto->ProTiempoModificacion = date("Y-m-d H:i:s");

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
	
	

	if($Guardar){	
		if($InsProducto->MtdEditarProductoUso()){		
		
		
			if(!empty($GET_dia)){
?>
<script type="text/javascript">
self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
			}
		
			$Resultado.='#SAS_PRO_108';	
			FncCargarDatos();	
			$Edito = true;	
		}else{			
			$Resultado.='#ERR_PRO_108';		
		}			
	}
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsProducto;
	global $Identificador;
	
	$InsProducto->ProId = $GET_id;
	$InsProducto->MtdObtenerProducto();	

}

?>