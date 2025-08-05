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

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsObsequio.php');

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsPersonal = new ClsPersonal();
$InsCondicionVenta = new ClsCondicionVenta();
$InsCondicionPago = new ClsCondicionPago();
$InsObsequio = new ClsObsequio();
//Obteniendo datos de factura
$InsCotizacionVehiculo->CveId = $GET_id;
$InsCotizacionVehiculo->MtdObtenerCotizacionVehiculo();		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ENVIO DE CORREO ELECTRNICO</title>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>

</head>
<body>

<img src="../../imagenes/logos/logo_cargando.png" alt="[Logo]" title="Logo" height="45" border="0" /><br /><br />
<img src="../../imagenes/cargando_sunat.gif" alt="[Cargando...]" title="Cargando..." width="80"  border="0" />
<br /><br />
<script type="text/javascript">
$().ready(function() {

	$('#CapCotizacionVehiculoAccion').html('Preparando para enviar correo electronico...');	
		
	$('#BtnEnviar').on('click', function() {
		
		FncCotizacionVehiculoEnviarCorreo();

	});
	

});

function FncCotizacionVehiculoEnviarCorreo(){
	
	var Email = $('#CmpEmail').val();
	var Actualizar = "2";
	
	if(Email==""){
		
		alert("Debes ingresar un correo electronico para enviar");
	
	}else if(FncValidarEmail(Email)==false){
		
		alert("Debes ingresar un correo electronico valido");
		
	}else{
		
		if ($('#CmpActualizar').is(':checked')) {
			Actualizar = "1";
		}
		
		$('#CapCotizacionVehiculoAccion').html("Enviando...");
		
		$.ajax({
			type: 'GET',
			dataType: 'json',
			url: 'acc/AccCotizacionVehiculoEnviarCorreo.php',
			data: 'Id=<?php echo $InsCotizacionVehiculo->CveId;?>&Email='+Email+'&Actualizar='+Actualizar,
			success: function(respuesta){
				
				switch(respuesta['Respuesta']){
					case "1":
					
						$('#CapCotizacionVehiculoAccion').html('Correo electronico enviado correctamente');
						setTimeout("window.close();",1500);
					break;
					
					case "2":
					
						$('#CapCotizacionVehiculoAccion').html('No se pudo enviar el correo electronico, intente nuevamente');
						
					break;
					
					
						case "3":
					
						$('#CapCotizacionVehiculoAccion').html(respuesta['Mensaje']);
						
					break;
					
						case "4":
					
						$('#CapCotizacionVehiculoAccion').html(respuesta['Mensaje']);
						
					break;
					
					default:
						$('#CapCotizacionVehiculoAccion').html('Ha ocurrido un error enviando el correo electronico, proceso cancelado...');
						//window.setTimeout("window.close();",4000);
						
					break;
				}
				
										
			}
		});
	}
	
}

</script>

Correo Electronico:
<input name="CmpEmail" type="text" class="EstFormularioCaja" id="CmpEmail" value="<?php echo $InsCotizacionVehiculo->CliEmail;?>" size="35" maxlength="255" />

<input type="button" name="BtnEnviar" id="BtnEnviar" value="Enviar Correo" /><br />
<input type="checkbox" name="CmpActualizar" id="CmpActualizar" value="1" /> Actualizar ficha de cliente
<div id="CapCotizacionVehiculoAccion"></div>

</body>
</html>
