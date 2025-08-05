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

$GET_P = (empty($_GET['P'])?10:$_GET['P']);

require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');

$InsFacturaDetalle = new ClsFacturaDetalle();

$q = strtolower($_GET["q"]);
if (!$q) return;

//MtdObtenerBoletaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'BdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oBoleta=NULL,$oTalonario=NULL,$oAlmacenMovimientoDetalleId=NULL,$oBoletaEstado=NULL,$oFacturaDetalleDirectaDetalleId=NULL)
$ResFacturaDetalle = $InsFacturaDetalle->MtdObtenerBoletaDetalles("FdeDescripcion",$q,"FdeTiempoCreacion","DESC",$GET_P,NULL,NULL,NULL,NULL,NULL);
$ArrFacturaDetalles = $ResFacturaDetalle['Datos'];
$FacturaDetallesTotal = $ResFacturaDetalle['Total'];

	if(empty($ArrFacturaDetalles)){

	}else{
		foreach($ArrFacturaDetalles as $DatFacturaDetalle){			

			//echo $DatFacturaDetalle->VtaNumero." - ".$DatFacturaDetalle->VenId.", ".$DatFacturaDetalle->CliNombre.", ".$DatFacturaDetalle->VenFechaEmision."|";
			echo $DatFacturaDetalle->FdeId."|";
			echo $DatFacturaDetalle->FdeDescripcion."|";
			echo $DatFacturaDetalle->FdeCodigo."|";
			echo $DatFacturaDetalle->FdeUnidadMedida."|";
			echo $DatFacturaDetalle->SucId."|";
			echo "\n";
		}
	}

?>