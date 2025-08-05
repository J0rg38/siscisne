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

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$InsCliente = new ClsCliente();

$q = strtolower($_GET["q"]);
$GET_campo = (empty($_GET['Campo'])?"CliNombre":$_GET['Campo']);

if (!$q) return;

	//MtdObtenerClientes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CliId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL)
	$ResCliente = $InsCliente->MtdObtenerClientes($GET_campo,"contiene",$q,$GET_campo,"ASC",1,NULL,1,NULL);
	
	$ArrClientes = $ResCliente['Datos'];
	$ClientesTotal = $ResCliente['Total'];
		
	if(empty($ArrClientes)){
		
	}else{
		foreach($ArrClientes as $DatCliente){			
			echo $DatCliente->CliNombreCompleto."|".$DatCliente->CliId."|".$DatCliente->CliNumeroDocumento."|.\n";	
		}
	}

?>