<?php
//Si se hizo click en guardar			
if(isset($_POST['BtnGuardar_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';
	
	$InsCliente->UsuId = $_SESSION['SesionId'];	
	
	$InsCliente->CliId = $_POST['CmpId'];
	$InsCliente->CliNombreCompleto = $_POST['CmpClienteNombreCompleto'];

	$InsCliente->CliDestinatarios = trim($_POST['CmpDestinatarios']);
	$InsCliente->CliContenido = addslashes($_POST['CmpContenido']);

	if($Guardar){

		if($InsCliente->MtdEditarCliente()){

			if(!empty($GET_dia)){
?>
				<script type="text/javascript">
                //self.parent.tb_remove('<?php echo $GET_mod;?>');
                </script>
<?php
			}
			
			$Edito = true;
			FncCargarDatos();	
			$Resultado.='#SAS_CLI_102';	
				
		}else{			
		
			$Resultado.='#ERR_CLI_102';	
				
		}			

		
	}else{
		$Resultado.='#SAS_CLI_102';
	}
			
			
}else{
	
	FncCargarDatos();
	
}

function FncCargarDatos(){
	
	global $GET_id;
	global $InsCliente;
	global $Identificador;
	global $EmpresaMonedaId;

	$InsCliente->CliId = $GET_id;
	$InsCliente->MtdObtenerCliente();		
	
	$InsCliente->CliNombreCompleto = $InsCliente->CliNombre." ".$InsCliente->CliApellidoMaterno." ".$InsCliente->CliApellidoPaterno;
	
	$Destinatarios = "";
	
	if(!empty($InsCliente->CliCelular)){
		$InsCliente->CliCelular = trim($InsCliente->CliCelular);
		$InsCliente->CliCelular = str_replace("-","",$InsCliente->CliCelular);
		$InsCliente->CliCelular = str_replace("#","",$InsCliente->CliCelular);
		$Destinatarios .= "".$InsCliente->CliCelular;
	}
	
	if(!empty($InsCliente->CliContactoCelular1)){
		$InsCliente->CliContactoCelular1 = trim($InsCliente->CliContactoCelular1);
		$InsCliente->CliContactoCelular1 = str_replace("-","",$InsCliente->CliContactoCelular1);
		$InsCliente->CliContactoCelular1 = str_replace("#","",$InsCliente->CliContactoCelular1);
		$Destinatarios .= "".$InsCliente->CliContactoCelular1;
	}
	
	if(!empty($InsCliente->CliContactoCelular2)){
		$InsCliente->CliContactoCelular2 = trim($InsCliente->CliContactoCelular2);
		$InsCliente->CliContactoCelular2 = str_replace("-","",$InsCliente->CliContactoCelular2);
		$InsCliente->CliContactoCelular2 = str_replace("#","",$InsCliente->CliContactoCelular2);
		$Destinatarios .= "".$InsCliente->CliContactoCelular2;
	}
	
	if(!empty($InsCliente->CliContactoCelular3)){
		$InsCliente->CliContactoCelular3 = trim($InsCliente->CliContactoCelular3);
		$InsCliente->CliContactoCelular3 = str_replace("-","",$InsCliente->CliContactoCelular3);
		$InsCliente->CliContactoCelular3 = str_replace("#","",$InsCliente->CliContactoCelular3);
		$Destinatarios .= "".$InsCliente->CliContactoCelular3;
	}
	
	$InsCliente->CliDestinatarios = $Destinatarios;	

}
?>