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

$GET_FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$GET_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);
$GET_Sucursal = (($_GET['Sucursal']));

require_once($InsPoo->MtdPaqLogistica().'ClsEntregaVentaVehiculo.php');

$InsEntregaVentaVehiculo = new ClsEntregaVentaVehiculo();

//MtdObtenerEntregaVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'EvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL,$oSucursal=NULL,$oFecha="EvvFechaProgramada")
$ResEntregaVentaVehiculo = $InsEntregaVentaVehiculo->MtdObtenerEntregaVentaVehiculos(NULL,NULL,NULL,"EvvFechaProgramada","ASC",NULL,NULL,NULL,NULL,NULL,$GET_Sucursal,"EvvFechaProgramada");
$ArrEntregaVentaVehiculos = $ResEntregaVentaVehiculo['Datos'];


$citas = '';

$citas .= '<data>';
$i = 1;
if(!empty($ArrEntregaVentaVehiculos)){
	foreach($ArrEntregaVentaVehiculos as $DatEntregaVentaVehiculo){
			
					
		$citas .= '<event id="'.$i.'" subid="'.$DatEntregaVentaVehiculo->EvvId.'"  >';
		$citas .= '<start_date>';
		$citas .= '<![CDATA['.FncCambiaFechaAMysql($DatEntregaVentaVehiculo->EvvFechaHoraInicio).']]>';
		$citas .= '</start_date>';
		
		$citas .= '<end_date>';
		$citas .= '<![CDATA['.FncCambiaFechaAMysql($DatEntregaVentaVehiculo->EvvFechaHoraFin).']]>';
		$citas .= '</end_date>';
		
		
			$citas .= '<text>';
			$citas .= '<![CDATA['.$DatEntregaVentaVehiculo->VmoNombre.' / '.$DatEntregaVentaVehiculo->EinVIN.']]>';
			$citas .= '</text>';
			
			$citas .= '<details>';
			$citas .= '<![CDATA[<b>Inicio:</b> '.($DatEntregaVentaVehiculo->EvvFechaHoraInicio).' <br> <b>Fin:</b> '.$DatEntregaVentaVehiculo->EvvFechaHoraFin.' <br><br> <b>Vehiculo</b> '.$DatEntregaVentaVehiculo->VmaNombre.' '.$DatEntregaVentaVehiculo->VmoNombre.' '.$DatEntregaVentaVehiculo->VveNombre.' <br><b>VIN:</b> '.$DatEntregaVentaVehiculo->EinVIN.' <br><b>Asesor de Ventas:</b> '.$DatEntregaVentaVehiculo->PerNombreVendedor.' '.$DatEntregaVentaVehiculo->PerApellidoPaternoVendedor.' '.$DatEntregaVentaVehiculo->PerApellidoMaternoVendedor.'<br><b>Observaciones:</b> <i>'.$DatEntregaVentaVehiculo->EvvObservacion.'</i> <br><br><a href="javascript:FncEntregaVehiculoAnulado(\''.$DatEntregaVentaVehiculo->EvvId.'\');">[Anulado]</a> - <a href="javascript:FncEntregaVehiculoRealizado(\''.$DatEntregaVentaVehiculo->EvvId.'\');">[Realizado]</a> - <a href="javascript:FncEntregaVehiculoPendiente(\''.$DatEntregaVentaVehiculo->EvvId.'\');">[Pendiente]</a>]]>';
			$citas .= '</details>';

			$citas .= '<readonly>';
			$citas .= 'true';
			$citas .= '</readonly>';

		if(($DatEntregaVentaVehiculo->EvvEstado==1)){
			$citas .= '<color>';
			$citas .= 'red';
			$citas .= '</color>';
		}else if(($DatEntregaVentaVehiculo->EvvEstado==3)){
			$citas .= '<color>';
			$citas .= 'green';
			$citas .= '</color>';
			
		}else if(($DatEntregaVentaVehiculo->EvvEstado==6)){
			$citas .= '<color>';
			$citas .= 'orange';
			$citas .= '</color>';			
		}else{
			$citas .= '<color>';
			$citas .= 'gray';
			$citas .= '</color>';			
		}
		
		$citas .= '</event>';
		
		$i++;
	}
}
$citas .= '</data>';

echo $citas;
?>