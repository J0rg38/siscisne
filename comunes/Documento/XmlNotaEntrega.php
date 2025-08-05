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


require_once($InsPoo->MtdPaqContabilidad().'ClsNotaEntrega.php');

$InsNotaEntrega = new ClsNotaEntrega();

$q = strtolower($_GET["q"]);
if (!$q) return;

$ResNotaEntrega = $InsNotaEntrega->MtdObtenerNotaEntregas("NenId","contiene",$q,"NenId","ASC",1,NULL,$_SESSION['SisSucId'],NULL,NULL,NULL,NULL);

	$ArrNotaEntregas = $ResNotaEntrega['Datos'];
	$NotaEntregasTotal = $ResNotaEntrega['Total'];

	if(empty($ArrNotaEntregas)){

	}else{
		foreach($ArrNotaEntregas as $DatNotaEntrega){			
			//echo $DatNotaEntrega->NetNumero." - ".$DatNotaEntrega->NenId.", ".$DatNotaEntrega->CliNombre.",".$DatNotaEntrega->NenFechaEmision."|";
			echo $DatNotaEntrega->NenId."|";
			echo $DatNotaEntrega->NetId."|";
			echo $DatNotaEntrega->NetNumero."|";
			echo $DatNotaEntrega->CliNombre."|";
			echo $DatNotaEntrega->NenFechaEmision."|";
			echo "-|";
			echo "-|";
			echo $DatNotaEntrega->SucId."|";
			echo "\n";
			

		}
	}

?>