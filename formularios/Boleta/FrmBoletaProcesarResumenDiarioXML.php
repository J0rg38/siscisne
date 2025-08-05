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

$GET_Seleccionados = $_GET['Seleccionados'];
$GET_Nombre = $_GET['Nombre'];
$GET_Id = $_GET['Id'];


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Boletas</title>

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

	$('#CapBoletaAccion').html('Conectando con SUNAT para procesar archivo xml...');	
	
	$.ajax({
		type: 'GET',
		dataType: 'json',
		url: 'acc/AccBoletaProcesarResumenDiarioXML.php',
		data: 'Nombre=<?php echo $GET_Nombre;?>&Id=<?php echo $GET_Id;?>',
		success: function(respuesta){
			
			switch(respuesta['CodigoRespuesta']){
				
				case "R101":				
					$('#CapBoletaAccion').html('Archivo xml de resumen diario procesado correctamente. '+respuesta['MensajeRespuesta']);				
					window.setTimeout("window.close();",3000);					
				break;
				
				case "R102":
					$('#CapBoletaAccion').html(respuesta['MensajeRespuesta']);
				break;
				
				case "R103":
					$('#CapBoletaAccion').html(respuesta['MensajeRespuesta']);
				break;
				
				case "R104":
					$('#CapBoletaAccion').html(respuesta['MensajeRespuesta']);
				break;
				
				case "":
					$('#CapBoletaAccion').html(respuesta['MensajeRespuesta']);
				break;
				
				default:
					$('#CapBoletaAccion').html('Ha ocurrido un error procesando el archivo xml, proceso cancelado. RESPUESTA: '+respuesta['MensajeRespuesta']);					
				break;
				
			}
			
									
		}
	});

});
</script>



<div id="CapBoletaAccion"></div>

</body>
</html>
