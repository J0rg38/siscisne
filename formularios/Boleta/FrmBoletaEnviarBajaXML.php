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

$GET_Nombre = $_GET['Nombre'];
$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_Procesar = $_GET['Procesar'];
$GET_EnviarSUNAT = $_GET['EnviarSUNAT'];

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsBoleta = new ClsBoleta();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de boleta
$InsBoleta->BolId = $GET_id;
$InsBoleta->BtaId = $GET_ta;
$InsBoleta->MtdObtenerBoleta();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ENVIAR BAJA XML</title>

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

	$('#CapBoletaAccion').html('Enviando archivo xml...');	
	
	$.ajax({
		type: 'GET',
		dataType: 'json',
		url: 'acc/AccBoletaEnviarBajaXML.php',
		data: 'Nombre=<?php echo $GET_Nombre;?>',
		success: function(respuesta){
			
			switch(respuesta['CodigoRespuesta']){

				case 1:

					$('#CapBoletaAccion').html('Archivo xml enviado correctamente, se procedera a firmar el archivo...');
					window.setTimeout("FncBoletaFirmarBajaXML('"+respuesta['Nombre']+"');",2500);
			
				break;

				case 2:
					
					$('#CapBoletaAccion').html('Ha ocurrido un error enviando el archivo xml, intente nuevamente...');					
					//window.setTimeout("window.close();",4000);
					
				break;
				
				default:
					$('#CapBoletaAccion').html('Ha ocurrido un error enviando el archivo xml, proceso cancelado...');
					//window.setTimeout("window.close();",4000);
					
				break;
			}
			
									
		}
	});

});



function FncBoletaFirmarBajaXML(oNombre){
	//console.log("firmandooooo");
	FncPopUp('FrmBoletaFirmarBajaXML.php?Nombre='+oNombre+'&Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>&Procesar=<?php echo $GET_Procesar;?>&EnviarSUNAT=<?php echo $GET_EnviarSUNAT;?>&P=1',0,0,1,0,0,1,0,350,150);					
}
</script>

<div id="CapBoletaAccion"></div>

</body>
</html>
