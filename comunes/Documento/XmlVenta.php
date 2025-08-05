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


require_once($InsPoo->MtdPaqActividad().'ClsVenta.php');

$InsVenta = new ClsVenta();

$q = strtolower($_GET["q"]);
if (!$q) return;

$ResVenta = $InsVenta->MtdObtenerVentas("VenId","contiene",$q,"VenId","ASC",1,NULL,$_SESSION['SisSucId'],NULL,NULL,NULL,NULL);

	$ArrVentas = $ResVenta['Datos'];
	$VentasTotal = $ResVenta['Total'];

	if(empty($ArrVentas)){

	}else{
		foreach($ArrVentas as $DatVenta){			

			//echo $DatVenta->VtaNumero." - ".$DatVenta->VenId.", ".$DatVenta->CliNombre.", ".$DatVenta->VenFechaEmision."|";
			echo $DatVenta->VenId."|";
			echo $DatVenta->VtaId."|";
			echo $DatVenta->VtaNumero."|";
			echo $DatVenta->CliNombre."|";
			echo $DatVenta->VenFechaEmision."|";
			echo "-|";
			echo "-|";
			echo $DatVenta->SucId."|";
			echo "\n";
		}
	}

?>