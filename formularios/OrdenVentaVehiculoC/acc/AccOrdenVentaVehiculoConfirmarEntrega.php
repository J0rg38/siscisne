<?php

//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Resultado = '';
	$Guardar = true;	
	
	$InsOrdenVentaVehiculo->OvvId = $_POST['CmpId'];
	$InsOrdenVentaVehiculo->TdoId = $_POST['CmpClienteTipoDocumento'];
	$InsOrdenVentaVehiculo->CliNumeroDocumento = $_POST['CmpClienteNumeroDocumento'];
	$InsOrdenVentaVehiculo->CliNombre = $_POST['CmpClienteNombre'];
	$InsOrdenVentaVehiculo->CliApellidoPaterno = $_POST['CmpClienteApellidoPaterno'];
	$InsOrdenVentaVehiculo->CliApellidoMaterno = $_POST['CmpClienteApellidoMaterno'];
	$InsOrdenVentaVehiculo->CliNombreCompleto = $_POST['CmpClienteNombreCompleto'];
	
	$InsOrdenVentaVehiculo->PerIdActaEntrega = $_POST['CmpPersonal'];
	$InsOrdenVentaVehiculo->OvvActaEntregaFecha = FncCambiaFechaAMysql($_POST['CmpFechaEntrega']);
	$InsOrdenVentaVehiculo->OvvActaEntregaHora = $_POST['CmpHoraEntrega'];
	$InsOrdenVentaVehiculo->OvvActaEntregaDescripcion = addslashes($_POST['CmpObservacion']);
	$InsOrdenVentaVehiculo->OvvFotoActaEntrega = $_SESSION['SesOvvFotoActaEntrega'.$Identificador];
	
	$InsOrdenVentaVehiculo->OvvNotificar = $_POST['CmpNotificar'];
	$InsOrdenVentaVehiculo->OvvDestinatarios = $_POST['CmpDestinatarios'];
	
	if($Guardar){

		if($InsOrdenVentaVehiculo->MtdConfirmarEntregaOrdenVentaVehiculo()){
			
			//deb($InsOrdenVentaVehiculo->OvvNotificar);
			
			if($InsOrdenVentaVehiculo->OvvNotificar==1){
				//MtdEnviarCorreoConfirmarEntregaOrdenVentaVehiculo
				if($InsOrdenVentaVehiculo->MtdEnviarCorreoConfirmarEntregaOrdenVentaVehiculo($InsOrdenVentaVehiculo->OvvId,$InsOrdenVentaVehiculo->OvvDestinatarios)){
					
				}
				
			}
			
			
			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
                self.parent.tb_remove('<?php echo $GET_mod;?>');
                </script>
<?php
			}
				
				
			$Edito = true;
			$Resultado.='#SAS_OVV_124';
		}else{
			$Resultado.='#ERR_OVV_124';
		}

	}	
	
	$InsOrdenVentaVehiculo->OvvActaEntregaFecha = FncCambiaFechaANormal($InsOrdenVentaVehiculo->OvvActaEntregaFecha);		
	
		
}else{

	FncCargarDatos();
}


function FncCargarDatos(){

	global $InsOrdenVentaVehiculo;
	global $Identificador;
	global $CorreosNotificacionOrdenVentaVehiculoConfirmarEntrega;

	$CorreosNotificacionOrdenVentaVehiculoConfirmarEntrega = "j.blanco@cisne.com.pe";
	
	global $GET_Id;

	unset($_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador]);
	unset($_SESSION['SesOvvFotoActaEntrega'.$Identificador]);
	
	$_SESSION['InsOrdenVentaVehiculoLlamada'.$Identificador] = new ClsSesionObjeto();	

	$InsOrdenVentaVehiculo->OvvId = $GET_Id;
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();
	
	$_SESSION['SesOvvFotoActaEntrega'.$Identificador] = $InsOrdenVentaVehiculo->OvvFotoActaEntrega;
	
	$InsOrdenVentaVehiculo->OvvDestinatarios = $CorreosNotificacionOrdenVentaVehiculoConfirmarEntrega;
	
	if(empty($InsOrdenVentaVehiculo->OvvActaEntregaFecha) or $InsOrdenVentaVehiculo->OvvActaEntregaFecha == "0000-00-00" or $InsOrdenVentaVehiculo->OvvActaEntregaFecha == "00/00/0000"){
		
		$InsOrdenVentaVehiculo->OvvActaEntregaFecha = date("d/m/Y");
		$InsOrdenVentaVehiculo->OvvActaEntregaHora = date("H:i");
		$InsOrdenVentaVehiculo->OvvNotificar==1;
		
	}else{
		
		$InsOrdenVentaVehiculo->OvvNotificar==2;	
		
	}
	
	
	
}

?>

