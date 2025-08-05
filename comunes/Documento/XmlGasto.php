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

$POST_Campo = (empty($_GET['Campo'])?"GasId,GasComprobanteNumero":$_GET['Campo']);

require_once($InsPoo->MtdPaqContabilidad().'ClsGasto.php');

$InsGasto = new ClsGasto();

$q = strtolower($_GET["q"]);
if (!$q) return;

//MtdObtenerGastos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'GasId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFecha="GasFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL)

$ResGasto = $InsGasto->MtdObtenerGastos($POST_Campo,"contiene",$q,"GasId","ASC","1",NULL,NULL,3,NULL,"GasFecha",0,NULL,NULL);
$ArrGastos = $ResGasto['Datos'];
$GastosTotal = $ResGasto['Total'];

		
	if(empty($ArrGastos)){
		
	}else{
		foreach($ArrGastos as $DatGasto){
			echo $DatGasto->GasId."|";
			echo $DatGasto->GasComprobanteFecha."|";
			echo $DatGasto->GasComprobanteNumero."|";
			echo $DatGasto->PrvNombre."|";
			echo $DatGasto->PrvApellidoPaterno."|";
			echo $DatGasto->PrvApellidoMaterno."|";
			echo $DatGasto->PrvNumeroDocumento."|";
			echo $DatCompra->GasFechaEmision."|";
			echo "\n";
		}
	}

?>