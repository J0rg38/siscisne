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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');


$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();


$q = strtolower($_GET["q"]);
if (!$q) return;


$ResAlmacenMovimientoSalida = $InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalidas("AmoId","contiene",$q,"AmoId","ASC",NULL,NULL,NULL,NULL);

	$ArrAlmacenMovimientoSalidas = $ResAlmacenMovimientoSalida['Datos'];
	$AlmacenMovimientoSalidasTotal = $ResAlmacenMovimientoSalida['Total'];

	if(empty($ArrAlmacenMovimientoSalidas)){

	}else{
		foreach($ArrAlmacenMovimientoSalidas as $DatAlmacenMovimientoSalida){			

			echo $DatAlmacenMovimientoSalida->AmoId."|";
			echo $DatAlmacenMovimientoSalida->AmoFecha."|";
			echo "\n";
		}
	}

?>