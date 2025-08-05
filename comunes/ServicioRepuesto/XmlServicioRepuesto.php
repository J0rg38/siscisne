<?php
session_start();
//header("Content-type: text/plain");
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

require_once($InsPoo->MtdPaqLogistica().'ClsServicioRepuesto.php');

$InsServicioRepuesto = new ClsServicioRepuesto();

$GET_Cbu = FncLimpiarVariable($_GET['Cbu']);
$GET_TipoGasto = FncLimpiarVariable($_GET['TipoGasto']);

$q = strtolower($_GET["q"]);
$t = empty($_GET['t'])?1:$_GET['t'];
if (!$q) return;

//MtdObtenerServicioRepuestos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipoGasto=NULL) {

$ResServicioRepuesto = $InsServicioRepuesto->MtdObtenerServicioRepuestos($GET_Cbu,"contiene",($q),$GET_Cbu,"ASC","15",1,$GET_TipoGasto);
$ArrServicioRepuestos = $ResServicioRepuesto['Datos'];
//deb($ArrServicioRepuestos);

	if(empty($ArrServicioRepuestos)){
		
	}else{
		
		//if($t==1){
//			echo "<b><center>NOMBRE</center></b>|".
//			"<b><center>ID</center></b>\n";	
//		}

		foreach($ArrServicioRepuestos as $DatServicioRepuesto){			
			echo $DatServicioRepuesto->SreNombre."|".$DatServicioRepuesto->SreId."|.\n";	
		}
		
		
	}
	

?>