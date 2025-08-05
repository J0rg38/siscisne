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


require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');

$InsBoleta = new ClsBoleta();

$q = strtolower($_GET["q"]);
if (!$q) return;

$ResBoleta = $InsBoleta->MtdObtenerBoletas("BolId","contiene",$q,"BolId","ASC",1,NULL,$_SESSION['SisSucId'],NULL,NULL,NULL,NULL);

	$ArrBoletas = $ResBoleta['Datos'];
	$BoletasTotal = $ResBoleta['Total'];

	if(empty($ArrBoletas)){

	}else{
		foreach($ArrBoletas as $DatBoleta){			
			//echo $DatBoleta->BtaNumero." - ".$DatBoleta->BolId.", ".$DatBoleta->CliNombre.", ".$DatBoleta->BolFechaEmision."|";
			echo $DatBoleta->BolId."|";
			echo $DatBoleta->BtaId."|";
			echo $DatBoleta->BtaNumero."|";
			echo $DatBoleta->CliNombre."|";
			echo $DatBoleta->BolFechaEmision."|";
			echo "-|";
			echo "-|";
			echo $DatBoleta->SucId."|";
			echo "-|";
			echo "-|";
			echo $DatBoleta->SucNombre."|";
			echo "\n";

		}
	}

?>