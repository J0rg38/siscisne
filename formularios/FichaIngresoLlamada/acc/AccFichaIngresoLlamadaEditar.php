<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';
	
	$InsFichaIngresoLlamada->UsuId = $_SESSION['SesionId'];	
	
	$InsFichaIngresoLlamada->FllId = $_POST['CmpId'];
	$InsFichaIngresoLlamada->FllFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsFichaIngresoLlamada->FllObservacion = addslashes($_POST['CmpObservacion']);
	
	$InsFichaIngresoLlamada->FinId = ($_POST['CmpFichaIngresoId']);
	$InsFichaIngresoLlamada->FinFecha = FncCambiaFechaAMysql($_POST['CmpFichaIngresoFecha']);
	$InsFichaIngresoLlamada->CliNombre = addslashes($_POST['CmpClienteNombre']);
	$InsFichaIngresoLlamada->CliApellidoPaterno = addslashes($_POST['CmpClienteApellidoPaterno']);
	$InsFichaIngresoLlamada->CliApellidoMaterno = addslashes($_POST['CmpClienteApellidoMaterno']);
	
		//$InsFichaIngresoLlamada->FllEstado = $_POST['CmpEstado'];
	$InsFichaIngresoLlamada->FllEstado = 1;
	$InsFichaIngresoLlamada->FllTiempoCreacion = date("Y-m-d H:i:s");
	$InsFichaIngresoLlamada->FllTiempoModificacion = date("Y-m-d H:i:s");
	$InsFichaIngresoLlamada->FllEliminado = 1;
	

	if($Guardar){

		if($InsFichaIngresoLlamada->MtdEditarFichaIngresoLlamada()){

			if(!empty($GET_dia)){
?>
<script type="text/javascript">


		<?php
		if(!empty($GET_Tipo)){
		?>
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.FncFichaIngresoLlamadaCargar("<?php echo $GET_Tipo;?>","<?php echo $InsFichaIngresoLlamada->FllId;?>");

		<?php			
		}else{
		?>
			self.parent.tb_remove('<?php echo $GET_mod;?>');
			self.parent.$('#CmpFllenteId').val("<?php echo $InsFichaIngresoLlamada->FllId;?>");
			self.parent.FncFichaIngresoLlamadaBuscar("Id");
		<?php	
		}
		?>
		
		
//self.parent.tb_remove('<?php echo $GET_mod;?>');
</script>
<?php
			}
			$Edito = true;
			FncCargarDatos();	
			$Resultado.='#SAS_FLL_102';		
		}else{			
		
		
			$InsFichaIngresoLlamada->FllFecha = FncCambiaFechaANormal($InsFichaIngresoLlamada->FllFecha,true);
			$InsFichaIngresoLlamada->FinFecha = FncCambiaFechaANormal($InsFichaIngresoLlamada->FinFecha,true);
			
			$Resultado.='#ERR_FLL_102';		
			
		}			

		
	}else{

		$InsFichaIngresoLlamada->FllFecha = FncCambiaFechaANormal($InsFichaIngresoLlamada->FllFecha,true);
		$InsFichaIngresoLlamada->FinFecha = FncCambiaFechaANormal($InsFichaIngresoLlamada->FinFecha,true);
		
		$Resultado.='#SAS_FLL_102';
		
	}
			
			
}else{
	FncCargarDatos();
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsFichaIngresoLlamada;
	global $Identificador;
	global $EmpresaMonedaId;

	
	$InsFichaIngresoLlamada->FllId = $GET_id;
	$InsFichaIngresoLlamada->MtdObtenerFichaIngresoLlamada();			

	 
	
}
?>