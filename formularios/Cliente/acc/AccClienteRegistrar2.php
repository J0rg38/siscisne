<?php
//Si se hizo click en guardar	
		
//if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	
if(isset($_POST['BtnEnviar']) ){	

	$Resultado = '';
	$Registrar = true;
	

	if($_SESSION['tmptxt'] <> $_POST['CmpCaptcha']){
		$Registrar = false;
		$Resultado.='#ERR_CLI_302';
	}
		
	$InsCliente->CliNumeroDocumento = ($_POST['CmpNumeroDocumento']);

	if(!empty($InsCliente->CliNumeroDocumento)){
		$InsCliente->CliId = "";
		$InsCliente->MtdVerificarExisteClienteNumeroDocumento();
		if(!empty($InsCliente->CliId)){
			$Resultado.='#ERR_CLI_203';	
			$Registrar = false;
		}
	}
	
	
	if($Registrar){
		$InsCliente->CliTelefono = ($_POST['CmpTelefono']);
		if(!empty($InsCliente->CliCelular)){
			$InsCliente->CliId = "";
			$InsCliente->MtdVerificarExisteClienteCelular();
			if(!empty($InsCliente->CliId)){
				$Resultado.='#ERR_CLI_202';	
				$Registrar = false;
			}
		}
	}
	
	if($Registrar){
		$InsCliente->CliCelular = ($_POST['CmpCelular']);
		if(!empty($InsCliente->CliTelefono)){
			$InsCliente->CliId = "";
			$InsCliente->MtdVerificarExisteClienteTelefono();
			if(!empty($InsCliente->CliId)){
				$Resultado.='#ERR_CLI_201';	
				$Registrar = false;
			}
		}
	}
	
	
	$InsCliente->CliId = $_POST['CmpId'];	
	$InsCliente->CcaId = "CCA-5";	
	$InsCliente->CliNumeroDocumento = $_POST['CmpNumeroDocumento'];
	$InsCliente->CliNombre = $_POST['CmpNombre'];
	$InsCliente->CliDireccion = ($_POST['CmpDireccion']);
	$InsCliente->CliTelefono = addslashes($_POST['CmpTelefono']);
	$InsCliente->CliCelular = addslashes($_POST['CmpCelular']);
	$InsCliente->CliEmail = ($_POST['CmpEmail']);
	$InsCliente->CliZona = "";
	$InsCliente->CliConfirmado = 2;
	$InsCliente->CliEstado = 1;
	$InsCliente->CliTiempoRenovacion = date("Y-m-d H:i:s");
	$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
	$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
	$InsCliente->CliEliminado = 1;

	if($Registrar){
		if($InsCliente->MtdRegistrarCliente()){
			unset($InsCliente);
			$Resultado.='#SAS_CLI_1001';	
			
?>
		<script type="text/javascript">
		function FncRedirigir(){
		  window.location = "principal.php?Mod=Pedido&Form=Registrar";	
		}
        $(function(){
           
		   setTimeout("FncRedirigir();",1000);
		   
		 
        });
        </script>
<?php
		}else{
			$Resultado.='#ERR_CLI_1001';	
		}
	}

}else{

}	
?>