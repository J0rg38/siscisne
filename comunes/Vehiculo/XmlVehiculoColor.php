<?php
session_start();
//header("Content-type: text/plain");
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

$GET_VehiculoMarca = $_GET['VehiculoMarca'];
$GET_VehiculoModelo = $_GET['VehiculoModelo'];
$GET_VehiculoVersion = $_GET['VehiculoVersion'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoStock.php');

$InsVehiculoStock = new ClsVehiculoStock();

//MtdObtenerVehiculoColores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VesId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL,$oColor=NULL,$oSucursal=NULL)
//$ResVehiculoStock = $InsVehiculoStock->MtdObtenerVehiculoColores("EinColor","contiene",($q),"EinColor","ASC","",$GET_MarcaId,$GET_ModeloId,$GET_VersionId,NULL,NULL);
$ResVehiculoStock = $InsVehiculoStock->MtdObtenerVehiculoColores(NULL,NULL,NULL,"EinColor","ASC","",$GET_VehiculoMarca,$GET_VehiculoModelo,$GET_VehiculoVersion,NULL,NULL);
$ArrVehiculoColores = $ResVehiculoStock['Datos'];


	if(empty($ArrVehiculoColores)){
		
	}else{

		foreach($ArrVehiculoColores as $DatVehiculoColor){			
			
			echo $DatVehiculoColor->EinColor."\n"	;	
		
		}
		
	}
	

?>