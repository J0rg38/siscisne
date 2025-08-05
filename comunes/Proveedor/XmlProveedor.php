<?php
session_start();
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


$GET_Fila = $_GET['Fila'];

require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

$InsProveedor = new ClsProveedor();

$q = strtolower($_GET["q"]);
$GET_campo = (empty($_GET['Campo'])?"PrvNombre":$_GET['Campo']);
if (!$q) return;
//MtdObtenerProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PrvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL)

$ResProveedor = $InsProveedor->MtdObtenerProveedores($GET_campo,"contiene",$q,$GET_campo,"ASC",NULL,1,NULL);
$ArrProveedores = $ResProveedor['Datos'];
$ProveedoresTotal = $ResProveedor['Total'];	
	
if(empty($ArrProveedores)){
	
}else{
	foreach($ArrProveedores as $DatProveedor){			
		echo $DatProveedor->PrvId."|".$DatProveedor->PrvNombreCompleto."|".$DatProveedor->PrvNumeroDocumento."|".$DatProveedor->TdoId."|".$DatProveedor->PrvDireccion."|".$DatProveedor->PrvNombre."|".$DatProveedor->PrvApellidoPaterno."|".$DatProveedor->PrvApellidoMaterno."|".$GET_Fila."\n";	
	}
}
	

?>