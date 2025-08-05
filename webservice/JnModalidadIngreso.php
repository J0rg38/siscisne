<?php
session_start();
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

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


require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');

$InsModalidadIngreso = new ClsModalidadIngreso();

$POST_Accion = $_POST['Accion'];



switch($POST_Accion){

	case "ObtenerDatos":
		MtdObtenerModalidadIngresos();
	break;

}	
	
function MtdObtenerModalidadIngresos(){
	
	global $POST_Accion;
	
	global $InsModalidadIngreso;
	global $Resultado;

	$Resultado = '';
	$JsResultado = array();

	$InsModalidadIngreso = new ClsModalidadIngreso();
	
	$JsResultado['Respuesta'] = '';	
	$JsResultado['Datos'] =  array();	

	//MtdObtenerModalidadIngresos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'MinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
	$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinNombre","ASC",NULL,NULL);
	$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

	if(!empty($ArrModalidadIngresos)){
	
		$JsResultado['Respuesta'] = 'M001';	
		
		foreach($ArrModalidadIngresos as $DatModalidadIngreso){
			
			$ModalidadIngreso['ModalidadIngresoId'] = (empty($DatModalidadIngreso->PedId)?'':$DatModalidadIngreso->PedId);
			$ModalidadIngreso['ModalidadIngresoNombre'] = strtoupper((empty($DatModalidadIngreso->MinNombre)?'':$DatModalidadIngreso->MinNombre));
			$JsResultado['Datos'][] = $ModalidadIngreso;

		}
		
	}else{
		$JsResultado['Respuesta'] = 'M002';	
	}
	
	$Resultado = json_encode($JsResultado);
}

echo ($Resultado);

?>
