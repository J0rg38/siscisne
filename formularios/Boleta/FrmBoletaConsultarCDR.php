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

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
//require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaLetra.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');



$InsBoleta = new ClsBoleta();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsBoleta->BolId = $GET_id;
$InsBoleta->BtaId = $GET_ta;
$InsBoleta->MtdObtenerBoleta();


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

	$('#CapBoletaAccion').html('Conectando con SUNAT para procesar archivo xml...');	
	
	$.ajax({
		type: 'GET',
		dataType: 'json',
		url: 'acc/AccBoletaConsultarCDR.php',
		data: 'Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>',
		success: function(respuesta){
			
			switch(respuesta['CodigoRespuesta']){

				case "D101":
				
					$('#CapBoletaAccion').html('Archivo xml procesado correctamente. '+respuesta['MensajeRespuesta']);				
					
					parent.tb_remove();
									
					setTimeout("window.close();",2500);
					
				break;
				
				case "D102":
				
					$('#CapBoletaAccion').html(respuesta['MensajeRespuesta']);
					
				break;

				case "D103":
				
					$('#CapBoletaAccion').html(respuesta['MensajeRespuesta']);
					
				break;
				
				case "D104":
				
					$('#CapBoletaAccion').html(respuesta['MensajeRespuesta']);
					
				break;
				
				case "D105":
				
					$('#CapBoletaAccion').html(respuesta['MensajeRespuesta']);
					
				break;
				
				case "D106":
				
					$('#CapBoletaAccion').html(respuesta['MensajeRespuesta']);
					
				break;
				
				case "":
				
					$('#CapBoletaAccion').html(respuesta['MensajeRespuesta']);
				
				break;
				
				default:
				
					$('#CapBoletaAccion').html('Ha ocurrido un error procesando el archivo xml, proceso cancelado. \n\n Codigo: '+respuesta['CodigoRespuesta']+' / Mensaje: '+respuesta['MensajeRespuesta']);
					
				break;
				
			}
			
									
		}
	});

});
</script>
<div id="CapBoletaAccion"></div>

</body>
</html>
