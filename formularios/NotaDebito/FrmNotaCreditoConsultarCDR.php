<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
//require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoAlmacenMovimiento.php');
//require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoLetra.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');


$InsNotaCredito = new ClsNotaCredito();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsNotaCredito->NcrId = $GET_id;
$InsNotaCredito->NctId = $GET_ta;
$InsNotaCredito->MtdObtenerNotaCredito();


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROCESAR ARCHIVO XML</title>

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

	$('#CapNotaCreditoAccion').html('Conectando con SUNAT para procesar archivo xml...');	
	
	$.ajax({
		type: 'GET',
		dataType: 'json',
		url: 'acc/AccNotaCreditoConsultarCDR.php',
		data: 'Id=<?php echo $InsNotaCredito->NcrId;?>&Ta=<?php echo $InsNotaCredito->NctId;?>',
		success: function(respuesta){
			
			switch(respuesta['CodigoRespuesta']){

				case "D101":
				
					$('#CapNotaCreditoAccion').html('Archivo xml procesado correctamente. '+respuesta['MensajeRespuesta']);				
					
					window.opener.FncFiltrar();
									
					setTimeout("window.close();",2500);
					
				break;
				
				case "D102":
				
					$('#CapNotaCreditoAccion').html(respuesta['MensajeRespuesta']);
					
				break;

				case "D103":
				
					$('#CapNotaCreditoAccion').html(respuesta['MensajeRespuesta']);
					
				break;
				
				case "D104":
				
					$('#CapNotaCreditoAccion').html(respuesta['MensajeRespuesta']);
					
				break;
				
				case "D105":
				
					$('#CapNotaCreditoAccion').html(respuesta['MensajeRespuesta']);
					
				break;
				
				case "D106":
				
					$('#CapNotaCreditoAccion').html(respuesta['MensajeRespuesta']);
					
				break;
				
				case "":
				
					$('#CapNotaCreditoAccion').html(respuesta['MensajeRespuesta']);
				
				break;
				
				default:
				
					$('#CapNotaCreditoAccion').html('Ha ocurrido un error procesando el archivo xml, proceso cancelado. \n\n Codigo: '+respuesta['CodigoRespuesta']+' / Mensaje: '+respuesta['MensajeRespuesta']);
					
				break;
				
			}
			
									
		}
	});

});
</script>
<div id="CapNotaCreditoAccion"></div>

</body>
</html>
