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


require_once($InsPoo->MtdPaqActividad().'ClsCompra.php');

$InsCompra = new ClsCompra();

$q = strtolower($_GET["q"]);
if (!$q) return;

$ResCompra = $InsCompra->MtdObtenerCompras("ComId,ComComprobanteNumero,PrvNombre","contiene",$q,"ComId","ASC",1,NULL,$_SESSION['SisSucId'],NULL,NULL,NULL);
$ArrCompras = $ResCompra['Datos'];
$ComprasTotal = $ResCompra['Total'];
		
	if(empty($ArrCompras)){
		
	}else{
		foreach($ArrCompras as $DatCompra){			

			echo $DatCompra->ComId."|";
			echo $DatCompra->SucId."|";
			echo $DatCompra->ComComprobanteNumero."|";
			echo $DatCompra->PrvNombre."|";
			echo $DatCompra->ComFechaEmision."|";
			echo $DatCompra->CtiNombre."|";
			echo $DatCompra->PrvNumeroDocumento."|";
			echo $DatCompra->SucId."|";
			echo $DatCompra->PrvNumeroDocumento."|";
			echo $DatCompra->PrvDireccion."|";
			echo $DatCompra->SucNombre."|";
			echo "\n";	
			
		}
	}

?>