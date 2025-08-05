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

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');

$InsOrdenCompra = new ClsOrdenCompra();

$q = strtolower($_GET["q"]);
if (!$q) return;

$ResOrdenCompra = $InsOrdenCompra->MtdObtenerOrdenCompras("OcoId","contiene",$q,"OcoId","ASC",NULL,NULL,NULL,NULL,NULL);

	$ArrOrdenCompras = $ResOrdenCompra['Datos'];
	$OrdenComprasTotal = $ResOrdenCompra['Total'];
		
	if(empty($ArrOrdenCompras)){
		
	}else{
		foreach($ArrOrdenCompras as $DatOrdenCompra){			
			echo $DatOrdenCompra->OcoId."|".
			$DatOrdenCompra->OcoFecha."|".
			$DatOrdenCompra->PrvNombre."|".
			"\n";	
		}
	}

?>