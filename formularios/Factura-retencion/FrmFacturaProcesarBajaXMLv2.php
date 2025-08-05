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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];
$GET_Procesar = $_GET['Procesar'];
$GET_EnviarSUNAT = $_GET['EnviarSUNAT'];

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsFactura->FacId = $GET_id;
$InsFactura->FtaId = $GET_ta;
$InsFactura->MtdObtenerFactura();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PROCESAR ARCHIVO XML DE BAJA</title>

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

	$('#CapFacturaAccion').html('Conectando con SUNAT para procesar archivo xml...');	
	
	$.ajax({
		type: 'GET',
		dataType: 'json',
		url: 'acc/AccFacturaProcesarBajaXMLv2.php',
		data: 'Id=<?php echo $InsFactura->FacId;?>&Ta=<?php echo $InsFactura->FtaId;?>',
		success: function(respuesta){
			
			switch(respuesta['CodigoRespuesta']){
				
				case "B101":
				
					$('#CapFacturaAccion').html('Archivo xml de baja procesado correctamente. '+respuesta['MensajeRespuesta']);				
					
					//setTimeout("window.close();",2500);
					window.setTimeout("parent.tb_remove();",2500);
					
					
				break;
				
				case "B102":
					$('#CapFacturaAccion').html(respuesta['MensajeRespuesta']);
					//setTimeout("window.close();",2500);
				break;
				
				case "B103":
					$('#CapFacturaAccion').html(respuesta['MensajeRespuesta']);
					//setTimeout("window.close();",2500);
				break;
				
				case "B104":
					$('#CapFacturaAccion').html(respuesta['MensajeRespuesta']);
					//setTimeout("window.close();",2500);
				break;
				
				case "":
					$('#CapFacturaAccion').html(respuesta['MensajeRespuesta']);
					//setTimeout("window.close();",2500);
				break;
				
				default:
				
					$('#CapFacturaAccion').html('Ha ocurrido un error procesando el archivo xml de baja, proceso cancelado.');
					//setTimeout("window.close();",2500);
					
				break;
				
			}
			
									
		}
	});

});
</script>



<div id="CapFacturaAccion"></div>

</body>
</html>
