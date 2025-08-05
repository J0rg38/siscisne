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


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');

$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoModelo = new ClsVehiculoModelo();


$POST_VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];

$POST_VehiculoMarcaId = $_POST['VehiculoMarcaId'];
$POST_VehiculoModeloId = $_POST['VehiculoModeloId'];
$POST_VehiculoVersionId = $_POST['VehiculoVersionId'];


$POST_VehiculoIngresoAnoFabricacion = $_POST['VehiculoIngresoAnoFabricacion'];
$POST_VehiculoIngresoAnoModelo = $_POST['VehiculoIngresoAnoModelo'];
$POST_VehiculoIngresoNumeroMotor = $_POST['VehiculoIngresoNumeroMotor'];

$POST_VehiculoIngresoColor = $_POST['VehiculoIngresoColor'];



$VehiculoIngresoId = $InsVehiculoIngreso->MtdVerificarExisteVehiculoIngreso("EinVIN",$POST_VehiculoIngresoVIN);

if(!empty($VehiculoIngresoId)){
	
	$InsVehiculoIngreso->EinId = $VehiculoIngresoId;
	$InsVehiculoIngreso->MtdObtenerVehiculoIngreso(false);

	
	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VmaId",$POST_VehiculoMarcaId,$VehiculoIngresoId);
	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VmoId",$POST_VehiculoModeloId,$VehiculoIngresoId);
	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VveId",$POST_VehiculoVersionId,$VehiculoIngresoId);

	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoFabricacion",$POST_VehiculoIngresoAnoFabricacion,$VehiculoIngresoId);
	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoModelo",$POST_VehiculoIngresoAnoModelo,$VehiculoIngresoId);
	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinNumeroMotor",$POST_VehiculoIngresoNumeroMotor,$VehiculoIngresoId);

	$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinColor",$POST_VehiculoIngresoColor,$VehiculoIngresoId);

	echo $InsVehiculoIngreso->EinId;

}else{
	
	//$InsVehiculoModelo = new ClsVehiculoModelo();
//	$InsVehiculoModelo->VmoId = $POST_VehiculoModeloId;
//	$InsVehiculoModelo->MtdObtenerVehiculoModelo();
//	
	
	if(!empty($POST_VehiculoModeloId)){
		
		$InsVehiculoModelo = new ClsVehiculoModelo();
		$InsVehiculoModelo->VmoId = $POST_VehiculoModeloId;
		$InsVehiculoModelo->MtdObtenerVehiculoModelo();

		if($InsVehiculoModelo->VmoNombre == "SAIL SEDAN" or
			$InsVehiculoModelo->VmoNombre == "SAIL HATCHBACK" or
			$InsVehiculoModelo->VmoNombre == "SPARK GT" or
			$InsVehiculoModelo->VmoNombre == "N300 MOVE" or
			$InsVehiculoModelo->VmoNombre == "N300 CARGO" or
			$InsVehiculoModelo->VmoNombre == "N300 WORK" or
			
			$InsVehiculoModelo->VmoNombre == "CRUZE SEDAN" or
			$InsVehiculoModelo->VmoNombre == "CRUZE HATCHBACK" or
			
			$InsVehiculoModelo->VmoNombre == "SONIC SEDAN" or
			$InsVehiculoModelo->VmoNombre == "SONIC HATCHBACK" or
		
			$InsVehiculoModelo->VmoNombre == "AVEO SEDAN" or
			$InsVehiculoModelo->VmoNombre == "AVEO HATCHBACK"
			
			){
				
				$InsVehiculoModelo->VmoNombre = eregi_replace("SEDAN","",$InsVehiculoModelo->VmoNombre);
				$InsVehiculoModelo->VmoNombre = eregi_replace("HATCHBACK","",$InsVehiculoModelo->VmoNombre);
				$InsVehiculoModelo->VmoNombre = eregi_replace("GT","",$InsVehiculoModelo->VmoNombre);
				$InsVehiculoModelo->VmoNombre = eregi_replace("MAX","",$InsVehiculoModelo->VmoNombre);
				$InsVehiculoModelo->VmoNombre = eregi_replace("MOVE","",$InsVehiculoModelo->VmoNombre);
				$InsVehiculoModelo->VmoNombre = eregi_replace("CARGO","",$InsVehiculoModelo->VmoNombre);
				$InsVehiculoModelo->VmoNombre = eregi_replace("WORK","",$InsVehiculoModelo->VmoNombre);
				
				$InsVehiculoIngreso->EinNombre = $InsVehiculoModelo->VmoNombre;
			
			}
			
	}
		
		$InsVehiculoIngreso->EinId = "";
		$InsVehiculoIngreso->CliId = NULL;
		$InsVehiculoIngreso->OncId = "ONC-10000";
	
		$InsVehiculoIngreso->EinVIN = $POST_VehiculoIngresoVIN;
		//$InsVehiculoIngreso->EinNombre = $InsVehiculoModelo->VmoNombre;
		$InsVehiculoIngreso->VmaId = $POST_VehiculoMarcaId;
		$InsVehiculoIngreso->VmoId = $POST_VehiculoModeloId;
		$InsVehiculoIngreso->VveId = $POST_VehiculoVersionId;
		
		$InsVehiculoIngreso->EinAnoFabricacion = $POST_VehiculoIngresoAnoFabricacion;
		$InsVehiculoIngreso->EinAnoModelo = $POST_VehiculoIngresoAnoModelo;
		$InsVehiculoIngreso->EinNumeroMotor = $POST_VehiculoIngresoNumeroMotor;
		
		$InsVehiculoIngreso->EinColor = $POST_VehiculoIngresoColor;
	
		$InsVehiculoIngreso->EinTiempoCreacion = date("Y-m-d H:i:s");
		$InsVehiculoIngreso->EinTiempoModificacion = date("Y-m-d H:i:s");
		$InsVehiculoIngreso->EinEliminado = 1;
	
		if($InsVehiculoIngreso->MtdRegistrarVehiculoIngresoDeVehiculoProforma()){
			echo $InsVehiculoIngreso->EinId;
		}else{
			echo "2";
		}

}


	





?>