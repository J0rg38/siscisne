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

$GET_Personal = $_GET['Personal'];
$GET_PersonalMecanico = $_GET['PersonalMecanico'];
$GET_Sucursal = $_GET['Sucursal'];

$GET_FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$GET_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);

require_once($InsPoo->MtdPaqActividad().'ClsCita.php');

$InsCita = new ClsCita();

//MtdObtenerCitas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oPersonalMecanico=NULL,$oHora=NULL,$oSucursal=NULL)
$ResCita = $InsCita->MtdObtenerCitas(NULL,NULL,NULL,"CitFecha","ASC",NULL,NULL,NULL,$GET_Personal,NULL,NULL,"CitFecha",false,NULL,$GET_PersonalMecanico,NULL,$GET_Sucursal);
$ArrCitas = $ResCita['Datos'];

$citas = '';

$citas .= '<data>';
$i = 1;
if(!empty($ArrCitas)){
	foreach($ArrCitas as $DatCita){
			
		$citas .= '<event id="'.$i.'" subid="'.$DatCita->CitId.'">';
		$citas .= '<start_date>';
		$citas .= '<![CDATA['.FncCambiaFechaAMysql($DatCita->CitFechaHoraInicio).']]>';
		$citas .= '</start_date>';
		
		$citas .= '<end_date>';
		$citas .= '<![CDATA['.FncCambiaFechaAMysql($DatCita->CitFechaHoraFin).']]>';
		$citas .= '</end_date>';
		
		if(!empty($DatCita->CitKilometrajeMantenimiento)){
			
			$citas .= '<text>';
			$citas .= '<![CDATA['.$DatCita->CliNombre.' '.$DatCita->CliApellidoPaterno.' '.$DatCita->CliApellidoMaterno.' / '.$DatCita->CitDescripcion.' / '.$DatCita->EinPlaca.' / Mant: '.$DatCita->CitKilometrajeMantenimiento.' km]]>';
			$citas .= '</text>';
			
			$citas .= '<details>';
			$citas .= '<![CDATA['.$DatCita->CliNombre.' '.$DatCita->CliApellidoPaterno.' '.$DatCita->CliApellidoMaterno.' / '.$DatCita->CitDescripcion.' / '.$DatCita->EinPlaca.' / Mant: '.$DatCita->CitKilometrajeMantenimiento.' km]]>';
			$citas .= '</details>';
		
		}else{
			
			$citas .= '<text>';
			$citas .= '<![CDATA['.$DatCita->CliNombre.' '.$DatCita->CliApellidoPaterno.' '.$DatCita->CliApellidoMaterno.' / '.$DatCita->CitDescripcion.' / '.$DatCita->EinPlaca.']]>';
			$citas .= '</text>';
			
			$citas .= '<details>';
			$citas .= '<![CDATA['.$DatCita->CliNombre.' '.$DatCita->CliApellidoPaterno.' '.$DatCita->CliApellidoMaterno.' / '.$DatCita->CitDescripcion.' / '.$DatCita->EinPlaca.']]>';
			$citas .= '</details>';

			
		}
		
		
		
		if(!empty($DatCita->CitKilometrajeMantenimiento)){
			$citas .= '<color>';
			$citas .= 'blue';
			$citas .= '</color>';
		}else{
			$citas .= '<color>';
			$citas .= 'red';
			$citas .= '</color>';
			
		}
		$citas .= '</event>';
		
		$i++;
	}
}
$citas .= '</data>';

echo $citas;
?>