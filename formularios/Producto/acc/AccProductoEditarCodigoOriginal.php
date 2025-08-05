<?php
//Si se hizo click en guardar		
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;
	
	$InsProducto->UsuId = $_SESSION['SesionId'];
		
	$InsProducto->ProId = $_POST['CmpId'];
	$InsProducto->ProCodigoOriginal = $_POST['CmpCodigoOriginal'];
	$InsProducto->ProCodigoOriginalAnterior = $_POST['CmpCodigoOriginalAnterior'];
	
	if($Guardar){	
		if($InsProducto->MtdEditarProductoCodigoOriginal($InsProducto->ProId,$InsProducto->ProCodigoOriginal)){		
			
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

	$InsProducto->ProId = $GET_id;
	$InsProducto->MtdObtenerProducto();	
	$InsProducto->ProCodigoOriginalAnterior = $InsProducto->ProCodigoOriginal;
	
}

?>