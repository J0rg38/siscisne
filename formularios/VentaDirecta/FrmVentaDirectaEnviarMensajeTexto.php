<?php
session_start();
	
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

////ARCHIVOS PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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
/*
*Control de Lista de Acceso
*/
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
//INSTANCIAS
$InsSesion = new ClsSesion();
$InsMensaje = new ClsMensaje();

$InsACL = new ClsACL();

require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');

$GET_VdiId = $_GET['VdiId'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');

$InsVentaDirecta = new ClsVentaDirecta();
$InsVentaDirecta->VdiId = $GET_VdiId;
$InsVentaDirecta->MtdObtenerVentaDirecta(false);

$Mensaje = "";
$Celular = "";
$Referencia = "";
//$Mensaje = "CYC TACNA, le informamos que su pedido de repuestos esta listo para recoger de 08:00am a 01:00pm y 03:00 pm a 06:00pm.";
$Mensaje = "CYC TACNA, le informamos que su pedido de repuestos se encuentra disponible en nuestro almacen. Para mas informacion puede llamar al 950310803 o 953769146.";

if(empty($InsVentaDirecta->VdiCelular)){
	$Celular = $InsVentaDirecta->CliCelular;
}else{
	$Celular = $InsVentaDirecta->FinCelular;	
}

$Celular  .= ",950312623,953769146,950310803";
//$Celular  = "950312623";
$Referencia = "VDI: ".$InsVentaDirecta->VdiId;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TRANSFIRIENDO MENSAJE DE TEXTO</title>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>

<!--
Nombre: DHTMLX MESSAGES
Descripcion:
-->
<script src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxSuite_v50_std/codebase/dhtmlx.js"></script>
<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxSuite_v50_std/codebase/dhtmlx.css">


</head>
<body>

<img src="../../imagenes/sms.png" alt="[SMS]" title="SMS" width="45" height="45" border="0" /><br />
<img src="../../imagenes/cargando.gif" alt="[Cargando...]" title="Cargando..." width="80"  border="0" /><br /><br />

<script type="text/javascript">

$().ready(function() {

	$('#CapVentaDirectaAccion').html('Esperando confirmacion...');	
	
	dhtmlx.confirm("¿Realmente desea enviar el mensaje: <?php echo $Mensaje;?>?", function(result){
		if(result==true){
		
		$('#CapVentaDirectaAccion').html('Enviando mensaje de texto...');	
		
			$.ajax({
				type: 'GET',
				dataType: 'json',
				url: 'acc/AccVentaDirectaEnviarMensajeTexto.php',
				data: 'Mensaje=<?php echo $Mensaje;?>&Referencia=<?php echo $Referencia;?>&Celular=<?php echo $Celular;?>',
				success: function(resultado){
					
					switch(resultado['Respuesta']){
						case "1":
							
							$('#CapVentaDirectaAccion').html(resultado['Mensaje']);
							window.setTimeout("window.close();",1500);
		
						break;
						
						case "2":
							
							$('#CapVentaDirectaAccion').html(resultado['Mensaje']);
							window.setTimeout("window.close();",4500);
		
						break;
						
						case "3":
							
							$('#CapVentaDirectaAccion').html(resultado['Mensaje']);
							window.setTimeout("window.close();",4500);
		
						break;
						
						case "4":
							
							$('#CapVentaDirectaAccion').html(resultado['Mensaje']);
							window.setTimeout("window.close();",4500);
		
						break;
						
						default:
						
							$('#CapVentaDirectaAccion').html('Ha ocurrido un error interno: '+resultado['Mensaje']);
							//setTimeout("window.close();",2500);
							
						break;
					}
					
											
				}
			});
			
		  
		}else{
			$('#CapVentaDirectaAccion').html('Envio de mensaje de texto cancelado...');	
			window.setTimeout("window.close();",1500);
		}
		
});

															
	

});




</script>

<div id="CapVentaDirectaAccion"></div>

</body>
</html>