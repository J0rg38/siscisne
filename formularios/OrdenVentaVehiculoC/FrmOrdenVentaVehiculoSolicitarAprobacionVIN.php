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


$GET_Id = $_GET['Id'];


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');


$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $GET_Id;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();

$InsPersonal = new ClsPersonal();
$InsPersonal->PerId = $InsOrdenVentaVehiculo->PerId;
$InsPersonal->MtdObtenerPersonal();

if($InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($InsOrdenVentaVehiculo->OvvId,3)){
	
}else{
	
}
			
			
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SOLICITANDO APROBACION</title>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>

</head>
<body>

<img src="../../imagenes/logos/logo_cargando.png" alt="[Logo]" height="35" title="Logo" border="0" />
<img src="../../imagenes/cargando_sunat.gif" alt="[Cargando...]" title="Cargando..." width="80"  border="0" />

<script type="text/javascript">
$().ready(function() {

	$('#CapOrdenVentaVehiculoAccion').html('Conectando con GMAIL para enviar correo...');	
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'acc/AccOrdenVentaVehiculoSolicitarAprobacionVIN.php',
		data: 'Id=<?php echo $InsOrdenVentaVehiculo->OvvId;?>',
		success: function(respuesta){
			//alert(respuesta['CodigoRespuesta']);
			
			switch(respuesta['CodigoRespuesta']){
				
				case 1:
				
					$('#CapOrdenVentaVehiculoAccion').html('Se solicito la aprobacion correctamente. '+respuesta['MensajeRespuesta']);					
					window.opener.FncFiltrar();			
					setTimeout("window.close();",2500);
					
				break;
				
				case 2:
				
					$('#CapOrdenVentaVehiculoAccion').html('Ha ocurrido un problema solicitando la aprobacion');
					
				break;

			
				
				default:
				
					$('#CapOrdenVentaVehiculoAccion').html('Ha ocurrido un error solicitando la aprobacion. Intente nuevamente.');
					
				break;
				
			}
			
									
		},
		error: function(respuesta){
			$('#CapOrdenVentaVehiculoAccion').html('Ha ocurrido un error solicitando la aprobacion. Intente nuevamente.');
					
		}
	});

});
</script>
<div id="CapOrdenVentaVehiculoAccion"></div>


</body>
</html>
