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
$GET_Nombre = $_GET['Nombre'];
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
$InsBoleta->MtdObtenerBoleta(false);

//deb($InsBoleta);

$NOMBRE = 'R-'.$EmpresaCodigo.'-03-'.$InsBoleta->BtaNumero.'-'.$InsBoleta->BolId;
//$ARCHIVO = $NOMBRE.'.xml';
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ENVIAR CORREO</title>

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

	$('#CapBoletaAccion').html('Conectando con GMAIL para enviar correo electronico...');	
	
	$.ajax({
		type: 'GET',
		dataType: 'json',
		url: 'acc/AccBoletaEnviarCorreo.php',
		data: 'Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>',
		success: function(respuesta){
			
			switch(respuesta['CodigoRespuesta']){

				case "1":
				
					$('#CapBoletaAccion').html('Correo electronico enviado correctamente. '+respuesta['MensajeRespuesta']);	
					setTimeout("window.close();",2500);
					
				break;
				
				case "2":
				
					$('#CapBoletaAccion').html('No se encontro direccion de correo electronico a enviar. '+respuesta['MensajeRespuesta']);						
				
				break;
				
				case "3":
				
					$('#CapBoletaAccion').html('No se encontro archivo PDF para enviar. '+respuesta['MensajeRespuesta']);						
				
				break;
				
				case "4":
				
					$('#CapBoletaAccion').html('No se encontro archivo XML a enviar. '+respuesta['MensajeRespuesta']);						
				
				break;
				
				case "5":
				
					$('#CapBoletaAccion').html('No se encontro archivo CDR a enviar. '+respuesta['MensajeRespuesta']);						
				
				break;
				
				default:
				
					$('#CapBoletaAccion').html('Ha ocurrido un error enviando el correo electronico, proceso cancelado.');
					
				break;
				
			}
			
									
		},
		error: function(respuesta){
			
			$('#CapBoletaAccion').html('Ha ocurrido un error interno.');
									
		}
	});

});
</script>

<div id="CapBoletaAccion"></div>
<div id="CapBoletaRespuesta"></div>
</body>
</html>

