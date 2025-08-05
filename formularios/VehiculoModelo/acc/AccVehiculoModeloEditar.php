<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	
	$InsVehiculoModelo->VmoId = $_POST['CmpId'];
	$InsVehiculoModelo->VmaId = $_POST['CmpMarca'];
	$InsVehiculoModelo->VtiId = $_POST['CmpTipo'];
	$InsVehiculoModelo->VmoVigenciaVenta = $_POST['CmpVigenciaVenta'];	
	$InsVehiculoModelo->VmoEstado = 1;
	$InsVehiculoModelo->VmoNombre = $_POST['CmpNombre'];
	$InsVehiculoModelo->VmoNombreComercial = $_POST['CmpNombreComercial'];
	$InsVehiculoModelo->VmoTiempoModificacion = date("Y-m-d H:i:s");
	$InsVehiculoModelo->VmoFotoCaracteristica = $_SESSION['SesVmoFotoCaracteristica'.$Identificador];
	
	
		if($InsVehiculoModelo->MtdEditarVehiculoModelo()){	
		
			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
                self.parent.tb_remove('<?php echo $GET_mod;?>');
                self.parent.$('#CmpVehiculoModeloId').val("<?php echo $InsVehiculoModelo->VmoId;?>");
                self.parent.FncVehiculoModelosCargar();
                </script>
<?php
			}	

			$Edito = true;	
			$Resultado.='#SAS_VMO_102';
			FncCargarDatos();			
		}else{			
			$Resultado.='#ERR_VMO_102';		
		}			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsVehiculoModelo;
global $Identificador;
	
	unset($_SESSION['SesVmoFotoCaracteristica'.$Identificador]);
	
	
	$InsVehiculoModelo->VmoId = $GET_id;
	
	
	$InsVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelo();	
	$_SESSION['SesVmoFotoCaracteristica'.$Identificador] = $InsVehiculoModelo->VmoFotoCaracteristica;
	

}

?>