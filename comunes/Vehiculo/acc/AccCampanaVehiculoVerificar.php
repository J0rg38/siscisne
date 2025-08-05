<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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


require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

$POST_VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];
$POST_Fecha = $_POST['Fecha'];
$POST_VehiculoModelo = $_POST['VehiculoModelo'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');

require_once($InsPoo->MtdPaqActividad().'ClsCampana.php');
require_once($InsPoo->MtdPaqActividad().'ClsCampanaVehiculo.php');

$InsFichaIngreso = new ClsFichaIngreso();
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsCampana = new ClsCampana();
$InsCampanaVehiculo = new ClsCampanaVehiculo();

$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos("EinVIN","esigual",$POST_VehiculoIngresoVIN,"EinVIN","ASC","1",NULL,NULL,NULL);
$ArrVehiculosIngresos = $ResVehiculoIngreso['Datos'];

$InsVehiculoIngreso->EinId = $ArrVehiculosIngresos[0]->EinId;
unset($ArrVehiculosIngresos);

$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);
$InsVehiculoIngreso->InsMysql=NULL;





$TieneCampana = false;
$RealizoCampana = false;
$CampanaId = "";

//$ResCampanaVehiculo = $InsCampanaVehiculo->MtdObtenerCampanaVehiculos("AveVIN","esigual",$InsVehiculoIngreso->EinVIN,'CamFechaInicio','ASC',"1",NULL,NULL,FncCambiaFechaAMysql($POST_Fecha),NULL);
$ResCampanaVehiculo = $InsCampanaVehiculo->MtdObtenerCampanaVehiculos("AveVIN","esigual",$InsVehiculoIngreso->EinVIN,'CamFechaInicio','DESC',NULL,NULL,NULL,NULL,NULL);
$ArrCampanaVehiculos = $ResCampanaVehiculo['Datos'];

$ArrCampanaRealizadas = array();

$TieneCampana = true;
//
//if(!empty($ArrCampanaVehiculos)){
//	foreach($ArrCampanaVehiculos as $DatCampanaVehiculo){
//		
//		//MtdObtenerFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL) 
//		$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,'FinId','ASC','1',NULL,NULL,NULL,NULL,NULL,$InsVehiculoIngreso->EinVIN,NULL,NULL,0,$DatCampanaVehiculo->CamId);
//		$ArrFichaIngresos = $ResFichaIngreso['Datos'];
//
//	//	$CampanaId = "";
////		foreach($ArrFichaIngresos as $DatFichaIngreso){
////			$CampanaId = $DatFichaIngreso->CamId;
////		}
//
//		if(!empty($ArrFichaIngresos)){
//		//if($DatCampanaVehiculo->CamId == $CampanaId){
//			$RealizoCampana = true;
//			
//			
//			break;
//		}else{
//			$CampanaId = $DatCampanaVehiculo->CamId;
//		}
//		
//	}
//}else{
//	CamVIN

		
//MtdObtenerCampanas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oVehiculoModelo=NULL,$oConVIN=NULL) {
//	$ResCampana = $InsCampana->MtdObtenerCampanas(NULL,NULL,NULL,'CamId','Desc',"1",NULL,NULL,NULL,$InsVehiculoIngreso->VmoId,2);
//	$ArrCampanas = $ResCampana['Datos'];
	
	if(!empty($ArrCampanaVehiculos)){
		foreach($ArrCampanaVehiculos as $DatCampanaVehiculo){
			
			//MtdObtenerFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL) 
			$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,'FinId','ASC','1',NULL,NULL,NULL,NULL,NULL,$InsVehiculoIngreso->EinVIN,NULL,NULL,0,$DatCampanaVehiculo->CamId);
			$ArrFichaIngresos = $ResFichaIngreso['Datos'];
			
			$CampanaIdRealizada = "";
			if(!empty($ArrFichaIngresos)){
				foreach($ArrFichaIngresos as $DatFichaIngreso){
					$CampanaIdRealizada = $DatFichaIngreso->CamId;
				}
			}
			
			if(!empty($CampanaIdRealizada)){
				$ArrCampanaRealizadas[] = $CampanaIdRealizada; 
			}
			
	
		}
	}
	
	
	
//	deb($ArrCampanaRealizadas);
	if(!empty($ArrCampanaVehiculos)){
		foreach($ArrCampanaVehiculos as $DatCampanaVehiculo){
			if(!in_array($DatCampanaVehiculo->CamId,$ArrCampanaRealizadas)){
				$CampanaId = $DatCampanaVehiculo->CamId;
				break;
			}
		}
	}
//}


if(!empty($CampanaId)){
	
	$InsCampana->CamId = $CampanaId;
	$InsCampana->MtdObtenerCampana();
		
	if(!empty($InsCampana->CampanaVehiculo)){
		foreach($InsCampana->CampanaVehiculo as $DatCampanaVehiculo){
			
			if($DatCampanaVehiculo->AveVIN == $InsVehiculoIngreso->EinVIN){
				
				if($DatCampanaVehiculo->AveEstado == 2){
					$RealizoCampana = true;
				}
				
			}
			
		}
	}else{
		
	}
		
}
//deb($TieneCampana );

//deb($RealizoCampana );

if($TieneCampana and !$RealizoCampana){
	if(!empty($CampanaId)){

		$InsCampana->CamId = $CampanaId;
		$InsCampana->MtdObtenerCampana(false);

	}
}


$InsCampana->InsMysql = NULL;

$json = new Services_JSON();
$var = $json->encode($InsCampana);

echo $var;

?>