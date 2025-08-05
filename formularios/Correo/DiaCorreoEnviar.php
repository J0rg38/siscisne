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
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

?>

<?php require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>C &amp; C S.A.C. - Envio de correo</title>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script>


<?php

//$client = new nusoap_client('http://cyc.com.pe/servicio/WsCorreo.php?wsdl','wsdl');
$client = new nusoap_client('http://trovastudios.com/servicio/WsCorreo.php?wsdl','wsdl');
$err = $client->getError();

if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
?>

</head>

<body>

Enviando correos...

<?php
$GET_Destinatario = $_GET['Destinatario'];
$GET_RemitenteCorreo = $_GET['RemitenteCorreo'];
$GET_RemitenteNombre = $_GET['RemitenteNombre'];
$GET_Asunto = $_GET['Asunto'];
$GET_Contenido = $_GET['Contenido'];

?>
<?php

if(!empty($GET_Destinatario) and !empty($GET_RemitenteCorreo) and !empty($GET_RemitenteNombre) and !empty($GET_Asunto) and !empty($GET_Contenido)){
	
	$param = array(
	'oDestinatario' => $GET_Destinatario,
	'oRemitenteCorreo' => $GET_RemitenteCorreo,
	'oRemitenteNombre' => $GET_RemitenteNombre,
	'oAsunto' => $GET_Asunto,
	'oContenido' => $GET_Contenido);

	$CorreoEnvio = $client->call('MtdEnviarCorreoCYC', $param);
	//var_dump($CorreoEnvio);
?>
	
    <?php
		if($CorreoEnvio == "Si"){
	?>	

<script type="text/javascript">
$().ready(function() {
	setTimeout("window.close();",1500);
});
</script>

    	Se envio correctamente.
	<?php	
		}else{
?>

<script type="text/javascript">
$().ready(function() {
	setTimeout("window.close();",3000);
});
</script>

    	No se pudo enviar los  correos.       
<?php
		}
?>

<?php
}
?>

</body>
</html>