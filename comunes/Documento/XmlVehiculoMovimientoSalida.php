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


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalida.php');


$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();


$q = strtolower($_GET["q"]);
if (!$q) return;


$ResVehiculoMovimientoSalida = $InsVehiculoMovimientoSalida->MtdObtenerVehiculoMovimientoSalidas("VmvId","contiene",$q,"VmvId","ASC",NULL,NULL,NULL,NULL);

	$ArrVehiculoMovimientoSalidas = $ResVehiculoMovimientoSalida['Datos'];
	$VehiculoMovimientoSalidasTotal = $ResVehiculoMovimientoSalida['Total'];

	if(empty($ArrVehiculoMovimientoSalidas)){

	}else{
		foreach($ArrVehiculoMovimientoSalidas as $DatVehiculoMovimientoSalida){			

			echo $DatVehiculoMovimientoSalida->VmvId."|";
			echo $DatVehiculoMovimientoSalida->VmvFecha."|";
			echo "\n";
		}
	}

?>