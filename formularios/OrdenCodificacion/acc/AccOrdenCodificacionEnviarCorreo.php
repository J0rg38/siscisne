<?php
//Si se hizo click en guardar	
	

if(isset($_POST['BtnEnviarCorreo_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

	$InsOrdenCodificacion->UsuId = $_SESSION['SesionId'];	
	
	$InsOrdenCodificacion->OciId = $_POST['CmpId'];
	$InsOrdenCodificacion->PrvId = $_POST['CmpProveedorId'];
	$InsOrdenCodificacion->OciFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsOrdenCodificacion->OciFechaRespuesta = FncCambiaFechaAMysql($_POST['CmpFechaRespuesta'],true);
	$InsOrdenCodificacion->OciHora = ($_POST['CmpHora']);

	$InsOrdenCodificacion->OciSolicitante = $_POST['CmpSolicitante'];
	$InsOrdenCodificacion->OciSolicitanteCargo = $_POST['CmpSolicitanteCargo'];
	$InsOrdenCodificacion->OciDealerSucursal = $_POST['CmpDealerSucursal'];
	$InsOrdenCodificacion->OciDescripcionPN= $_POST['CmpDescripcionPN'];
	$InsOrdenCodificacion->OciVIN = $_POST['CmpVIN'];
	$InsOrdenCodificacion->OciVehiculoModelo = $_POST['CmpVehiculoModelo'];
	$InsOrdenCodificacion->OciVehiculoAnoFabricacion = $_POST['CmpVehiculoAnoFabricacion'];
	$InsOrdenCodificacion->OciVehiculoMotorCilindrada = $_POST['CmpVehiculoMotorCilindrada'];

	$InsOrdenCodificacion->OciObservacion = addslashes($_POST['CmpObservacion']);
	$InsOrdenCodificacion->OciObservacionImpresa = addslashes($_POST['CmpObservacionImpresa']);
	$InsOrdenCodificacion->OciObservacionCorreo = addslashes($_POST['CmpObservacionCorreo']);
	
	$InsOrdenCodificacion->OciOrigen =  $_POST['CmpOrigen'];
	$InsOrdenCodificacion->OciEstado = $_POST['CmpEstado'];
	$InsOrdenCodificacion->OciTiempoModificacion = date("Y-m-d H:i:s");

	$InsOrdenCodificacion->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsOrdenCodificacion->PrvNombreCompleto = $InsOrdenCodificacion->PrvNombre;
	$InsOrdenCodificacion->TdoId = $_POST['CmpProveedorTipoDocumento'];	
	$InsOrdenCodificacion->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];

	
	$InsOrdenCodificacion->OciDestinatarios = $_POST['CmpDestinatario'];
	
	
	$Destinatario = preg_replace("/ /", "", $_POST['CmpDestinatario']);
	
	if(!empty($Destinatario)){
		
		if($InsOrdenCodificacion->MtdGenerarExcelOrdenCodificacion($InsOrdenCodificacion->OciId,"")){
			
			$InsOrdenCodificacion->MtdEnviarCorreoPedidoOrdenCodificacion($InsOrdenCodificacion->OciId,$Destinatario,"",$_SESSION['SesionNombre']);  
			
		}else{
			$Guardar = false;	
		}
			
	}else{
		$Guardar = false;	
	}
		

		
	if($Guardar){
		
		$InsOrdenCodificacion->MtdEditarOrdenCodificacionDato("OciObservacionImpresa",$InsOrdenCodificacion->OciObservacionImpresa,$InsOrdenCodificacion->OciId);
		$InsOrdenCodificacion->MtdEditarOrdenCodificacionDato("OciObservacionCorreo",$InsOrdenCodificacion->OciObservacionCorreo,$InsOrdenCodificacion->OciId);
	
		if($InsOrdenCodificacion->OciEstado == 1){
	
			if($InsOrdenCodificacion->MtdActualizarEstadoOrdenCodificacion($InsOrdenCodificacion->OciId,3)){
			}
	
		}else if($InsOrdenCodificacion->OciEstado == 3){
			
			if($InsOrdenCodificacion->MtdActualizarEstadoOrdenCodificacion($InsOrdenCodificacion->OciId,31)){
			}
				
		}
		
		if(!empty($GET_dia)){
?>
		<script type="text/javascript">
            self.parent.tb_remove('<?php echo $GET_mod;?>');
            self.parent.$('#CmpOrdenCodificacionId').val("<?php echo $InsOrdenCodificacion->OciId;?>");
            self.parent.FncOrdenCodificacionBuscar("Id");
        </script>
    <?php
        }
    
		$Resultado.='#SAS_OCI_109';	
		$Edito = true;
        $InsOrdenCodificacion->OciFecha = FncCambiaFechaANormal($InsOrdenCodificacion->OciFecha);	
        
		
	}else{
		$Edito = false;
		$Resultado.='#ERR_OCI_109';	
		 $InsOrdenCodificacion->OciFecha = FncCambiaFechaANormal($InsOrdenCodificacion->OciFecha);	
		 
	}
	
		
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){

	global $GET_id;
	global $Identificador;
	global $InsOrdenCodificacion;
	global $EmpresaMonedaId;
	global $InsProductoDisponibilidad;
	global $InsProductoReemplazo;
	global $CorreosGMOrdenCodificacion;
	
	unset($_SESSION['SesOciFoto'.$Identificador]);
	
	$InsOrdenCodificacion->OciId = $GET_id;
	$InsOrdenCodificacion->MtdObtenerOrdenCodificacion();		
	
	$_SESSION['SesOciFoto'.$Identificador] = $InsOrdenCodificacion->OciFoto;
	

	$InsOrdenCodificacion->OciDestinatarios = $CorreosGMOrdenCodificacion;
	
	if(!empty($InsOrdenCodificacion->PerEmail)){
	
		$ArrCorreos = explode(",",$InsOrdenCodificacion->OciDestinatarios);
	
		if(!in_array($InsOrdenCodificacion->PerEmail,$ArrCorreos)){
			$InsOrdenCodificacion->OciDestinatarios .= ",".$InsOrdenCodificacion->PerEmail;
		}
	
	}
	
}
?>