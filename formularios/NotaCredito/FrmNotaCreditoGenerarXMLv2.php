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
$GET_Procesar = $_GET['Procesar'];
$GET_EnviarSUNAT = $_GET['EnviarSUNAT'];

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

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
<title>GENERAR XML</title>

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

	$('#CapNotaCreditoAccion').html('Generando archivo xml...');	
	
	$.ajax({
		type: 'GET',
		dataType: 'json',
		url: 'acc/AccNotaCreditoGenerarXMLv2.php',
		data: 'Id=<?php echo $InsNotaCredito->NcrId;?>&Ta=<?php echo $InsNotaCredito->NctId;?>',
		success: function(respuesta){
			
			switch(respuesta['CodigoRespuesta']){
				case "1":
					
					<?php
					if($GET_Procesar=="1"){
					?>	
					
						$('#CapNotaCreditoAccion').html('Archivo xml generado correctamente, se conectara con SUNAT...');
						window.setTimeout("FncNotaCreditoProcesarXML('"+respuesta['Nombre']+"');",2500);
					
						<?php						
					}else if($GET_Procesar=="3"){
					?>
						
						$('#CapNotaCreditoAccion').html('Archivo xml generado correctamente, se firmara ...');
						window.setTimeout("FncNotaCreditoFirmarXML('"+respuesta['Nombre']+"');",2500);
						
							
					<?php	
					}else{
					?>
						
						$('#CapNotaCreditoAccion').html('Archivo xml generado correctamente...');
						//window.setTimeout("window.close();",2500);
						window.setTimeout("parent.tb_remove();",2500);
						
					<?php	
					}
					?>

				break;
				
				default:
					$('#CapNotaCreditoAccion').html('Ha ocurrido un error generando el archivo xml, proceso cancelado...');
					//window.setTimeout("window.close();",4000);
					
				break;
			}
			
									
		}
	});

});

function FncNotaCreditoProcesarXML(oNombre){
	
	//FncPopUp('FrmNotaCreditoProcesarXMLv2.php?Nombre='+oNombre+'&Id=<?php echo $InsNotaCredito->NcrId;?>&Ta=<?php echo $InsNotaCredito->NctId;?>&Procesar=<?php echo $GET_Procesar?>&EnviarSUNAT=<?php echo $GET_EnviarSUNAT;?>&P=1',0,0,1,0,0,1,0,350,150);
	window.location.href = 'FrmNotaCreditoProcesarXMLv2.php?Nombre='+oNombre+'&Id=<?php echo $InsNotaCredito->NcrId;?>&Ta=<?php echo $InsNotaCredito->NctId;?>&Procesar=<?php echo $GET_Procesar?>&EnviarSUNAT=<?php echo $GET_EnviarSUNAT;?>&P=1';


}


function FncNotaCreditoFirmarXML(oNombre){
	
	window.location.href = 'FrmNotaCreditoFirmarXMLv2.php?Nombre='+oNombre+'&Id=<?php echo $InsNotaCredito->NcrId;?>&Ta=<?php echo $InsNotaCredito->NctId;?>&Procesar=<?php echo $GET_Procesar?>&EnviarSUNAT=<?php echo $GET_EnviarSUNAT;?>&P=1';

}

</script>

<div id="CapNotaCreditoAccion"></div>

</body>
</html>
