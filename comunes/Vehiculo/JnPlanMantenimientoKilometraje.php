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


require_once($InsProyecto->MtdRutLibrerias().'JSON.php');

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoKilometraje.php');

$InsPlanMantenimiento = new ClsPlanMantenimiento();


$GET_VehiculoMarcaId = $_GET['VehiculoMarcaId'];

$ArrPlanMantenimientoKilometrajes = array();

switch($GET_VehiculoMarcaId){

	//case "VMA-10017"://CHEVROLET
	default://CHEVROLET
		foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){

			$InsPlanMantenimientoKilometraje = new ClsPlanMantenimientoKilometraje();
			$InsPlanMantenimientoKilometraje->PmkKilometraje = $DatKilometro['km'];
			$InsPlanMantenimientoKilometraje->PmkEtiqueta = $DatKilometroEtiqueta;
			$InsPlanMantenimientoKilometraje->PmkEquivalente = $DatKilometro['eq'];

			$ArrPlanMantenimientoKilometrajes[] = $InsPlanMantenimientoKilometraje;
		}

	break;

	case "VMA-10018"://ISUZU

		foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){

			$InsPlanMantenimientoKilometraje = new ClsPlanMantenimientoKilometraje();
			$InsPlanMantenimientoKilometraje->PmkKilometraje = $DatKilometro['km'];
			$InsPlanMantenimientoKilometraje->PmkEtiqueta = $DatKilometroEtiqueta;
			$InsPlanMantenimientoKilometraje->PmkEquivalente = $DatKilometro['eq'];

			$ArrPlanMantenimientoKilometrajes[] = $InsPlanMantenimientoKilometraje;

		}

	break;
	
	case "":
		//die("No se encontro la MARCA DEL VEHICULO");
		
		foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){

			$InsPlanMantenimientoKilometraje = new ClsPlanMantenimientoKilometraje();
			$InsPlanMantenimientoKilometraje->PmkKilometraje = $DatKilometro['km'];
			$InsPlanMantenimientoKilometraje->PmkEtiqueta = $DatKilometroEtiqueta;
			$InsPlanMantenimientoKilometraje->PmkEquivalente = $DatKilometro['eq'];

			$ArrPlanMantenimientoKilometrajes[] = $InsPlanMantenimientoKilometraje;
		}



	break;

}

echo json_encode($ArrPlanMantenimientoKilometrajes);
/*$json = new JSON;
$var = $json->serialize( $ArrPlanMantenimientoKilometrajes );
$json->unserialize( $var );

echo $var;	*/
?>