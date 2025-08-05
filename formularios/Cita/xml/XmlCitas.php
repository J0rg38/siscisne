<?php
session_start();
header("Content-type: text/xml");

////PRINCIPALES
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../../';
$InsProyecto->Ruta = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');

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

$GET_PersonalId = $_GET['PersonalId'];
$GET_FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$GET_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);

require_once($InsPoo->MtdPaqActividad().'ClsCita.php');

$InsCita = new ClsCita();

//$ResCita = $InsCita->MtdObtenerCitas(NULL,NULL,NULL,"CitFecha","ASC",NULL,3,NULL,$GET_Personal,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),"CitFecha");
$ResCita = $InsCita->MtdObtenerCitas(NULL,NULL,NULL,"CitFecha","ASC",NULL,3,NULL,$GET_Personal,FncCambiaFechaAMysql($GET_FechaInicio),FncCambiaFechaAMysql($GET_FechaFin),"CitFecha");
$ArrCitas = $ResCita['Datos'];

$citas = '';

$citas .= '<data>';
$i = 1;
if(!empty($ArrCitas)){
	foreach($ArrCitas as $DatCita){
			
					
		$citas .= '<event id="'.$i.'">';
		$citas .= '<start_date>';
		$citas .= '<![CDATA['.FncCambiaFechaAMysql($DatCita->CitFechaProgramada).' '.$DatCita->CitHoraProgramada.']]>';
		$citas .= '</start_date>';
		
		$citas .= '<end_date>';
		$citas .= '<![CDATA['.FncCambiaFechaAMysql($DatCita->CitFechaProgramadaFin).' '.$DatCita->CitHoraProgramadaFin.']]>';
		$citas .= '</end_date>';
		
		$citas .= '<text>';
		$citas .= '<![CDATA['.$DatCita->CliNombre.' '.$DatCita->CliApellidoPaterno.' '.$DatCita->CliApellidoMaterno.']]>';
		$citas .= '</text>';
		
		$citas .= '<details>';
		$citas .= '<![CDATA['.$DatCita->CliNombre.' '.$DatCita->CliApellidoPaterno.' '.$DatCita->CliApellidoMaterno.']]>';
		$citas .= '</details>';
		
		$citas .= '</event>';
		
		$i++;
	}
}

$citas .= '</data>';

echo $citas;
?>