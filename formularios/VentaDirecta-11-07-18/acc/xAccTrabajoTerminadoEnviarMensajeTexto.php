<?php
session_start();
	
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

////ARCHIVOS PRINCIPALES
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../../';
$InsProyecto->Ruta = '../../../';

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

$GET_FinId = $_GET['FinId'];

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaIngreso->FinId = $GET_FinId;
$InsFichaIngreso->MtdObtenerFichaIngreso(false);

$Mensaje = "";
$Celular = "";
$Referencia = "";

$Mensaje = "CYC TACNA, le informamos que su vehiculo ".$InsFichaIngreso->EinPlaca." se encuentra listo para recoger.";

if(empty($InsFichaIngreso->FinCelular)){
	$Celular = $InsFichaIngreso->CliCelular;
}else{
	$Celular = $InsFichaIngreso->FinCelular;	
}

$Referencia = $InsFichaIngreso->EinVIN;

if(empty($Celular)){
	die("No se encontro numero de celular registrado.");	
}

/*
* WS - MENSAJE TEXTO
*/

$wsdl = 'http://192.168.10.6:8080/sissms/webservice/WsMensajeTexto.php?wsdl';

$l_oClient = new nusoap_client($wsdl,'wsdl');
$l_oProxy = $l_oClient->getProxy();
	
$err = $l_oClient->getError();

if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

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

</head>
<body>

<img src="../../../imagenes/sms.png" alt="[SMS]" title="SMS" width="45" height="45" border="0" /><br />
<img src="../../../imagenes/cargando.gif" alt="[Cargando...]" title="Cargando..." width="80"  border="0" /><br /><br />

<?php
echo "Enviando mensaje de texto...";
echo "<br>";

$MensajeTexto['MteId'] = NULL;
$MensajeTexto['MteFecha'] = date("d/m/Y");
$MensajeTexto['MteReferencia'] = $Referencia;
$MensajeTexto['MteDestino'] = $Celular;
$MensajeTexto['MteContenido'] =  $Mensaje;
$MensajeTexto['MteEstado'] = 1;

$l_stResult = $l_oProxy->MtdRegistrarMensajeTexto(json_encode($MensajeTexto));

if($_SESSION['MysqlDeb']){
	deb($l_stResult);
}
	
switch($l_stResult){
	
	case "1":
?>
		<script type="text/javascript">
        $().ready(function() {
            window.setTimeout("window.close();",1500);
        });
        </script>
<?php
		echo "Se transfirio correctamente el mensaje de texto";	
		echo "<br>";
	break;
	
	case "2":
?>
		<script type="text/javascript">
        $().ready(function() {
            window.setTimeout("window.close();",5000);
        });
        </script>
<?php

		echo "No se pudo transferir los mensajes de texto, intente nuevamente";
		echo "<br>";
	break;

	default:
?>
		<script type="text/javascript">
        $().ready(function() {
            window.setTimeout("window.close();",5000);
        });
        </script>
<?php
		echo "Ha ocurrido un error interno. ".$l_stResult;
		echo "<br>";
	break;	
		
}
?>

</body>
</html>