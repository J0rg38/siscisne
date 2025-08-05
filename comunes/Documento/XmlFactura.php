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


require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');

$InsFactura = new ClsFactura();

$GET_ncredito = $_GET['NotaCredito'];
$q = strtolower($_GET["q"]);
if (!$q) return;

$ResFactura = $InsFactura->MtdObtenerFacturas("FacId","contiene",$q,"FacId","ASC",1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$GET_ncredito);

$ArrFacturas = $ResFactura['Datos'];
$FacturasTotal = $ResFactura['Total'];

	if(empty($ArrFacturas)){

	}else{
		foreach($ArrFacturas as $DatFactura){			
			//echo $DatFactura->FtaNumero." - ".$DatFactura->FacId.", ".$DatFactura->CliNombre.", ".$DatFactura->FacFechaEmision."|";
			echo $DatFactura->FacId."|";
			echo $DatFactura->FtaId."|";
			echo $DatFactura->FtaNumero."|";
			echo $DatFactura->CliNombre."|";
			echo $DatFactura->FacFechaEmision."|";
			echo "-|";
			echo "-|";
			echo $DatFactura->SucId."|";
			echo $DatFactura->CliNumeroDocumento."|";
			echo $DatFactura->FacDireccion."|";
			echo $DatFactura->SucNombre."|";
			echo "\n";

		}
	}

?>