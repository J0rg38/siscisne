<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
//require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
//require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
//require_once($InsPoo->MtdPaqLogistica().'ClsClienteCategoria.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
$InsCliente = new ClsCliente();

//Obteniendo datos de factura
$InsCliente->CliId = $GET_id;
$InsCliente->MtdObtenerCliente();


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ENVIAR CORREO ELECTRONICO</title>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>


</head>
<body>


<img src="../../imagenes/sunat.gif" alt="[SUNAT]" title="SUNAT" width="45" height="45" border="0" />
<img src="../../imagenes/cargando_sunat.gif" alt="[Cargando...]" title="Cargando..." width="80"  border="0" />

<script type="text/javascript">
$().ready(function() {

	$('#CapClienteAccion').html('Conectando con GMAIL para enviar correo electronico...');	
	
	$.ajax({
		type: 'GET',
		dataType: 'json',
		url: 'acc/AccClienteEnviarCorreo.php',
		data: 'Id=<?php echo $InsCliente->CliId;?>',
		success: function(respuesta){
			
			switch(respuesta['CodigoRespuesta']){

				case "1":
				
					$('#CapClienteAccion').html('Correo electronico enviado correctamente. '+respuesta['MensajeRespuesta']);								
					
					setTimeout("window.close();",2500);
					
				break;
				
				case "2":
				
					$('#CapClienteAccion').html('No se encontro direccion de correo electronico a enviar. '+respuesta['MensajeRespuesta']);								
					
				break;
				
				case "3":
				
					$('#CapClienteAccion').html('No se encontro clave electronica a enviar. '+respuesta['MensajeRespuesta']);								
					
				break;
				
				default:
				
					$('#CapClienteAccion').html('Ha ocurrido un error enviando el correo electronico, proceso cancelado.');
					
				break;
				
			}
			
									
		}
	});

});
</script>
<div id="CapClienteAccion"></div>

</body>
</html>
