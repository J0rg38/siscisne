<?php
//session_start();
header('Content-Type: application/json');

require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');


require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

$GET_EntregaVentaVehiculoId = $_POST['EntregaVentaVehiculoId'];
$GET_Duracion = $_POST['Duracion'];
$GET_FechaProgramada = $_POST['Fecha'];
$GET_HoraProgramada = $_POST['Hora'];
$GET_Observacion = addslashes($_POST['Observacion']);
$GET_Notificar = $_POST['Notificar'];

//deb($GET_Nombre );

require_once($InsPoo->MtdPaqLogistica().'ClsEntregaVentaVehiculo.php');


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

$CodigoRespuesta = 0;
$MensajeRespuesta = "";

$InsEntregaVentaVehiculo = new ClsEntregaVentaVehiculo();
$InsEntregaVentaVehiculo->EvvId = $GET_EntregaVentaVehiculoId;
$InsEntregaVentaVehiculo->MtdObtenerEntregaVentaVehiculo();

$OrdenVentaVehiculoId = $InsEntregaVentaVehiculo->OvvId;
$PersonalId = $InsEntregaVentaVehiculo->PerId;
$VehiculoIngresoId = $InsEntregaVentaVehiculo->EinId;

$EntregaVentaVehiculoVIN = $InsEntregaVentaVehiculo->EvvVIN;
$EntregaVentaVehiculoNumeroMotor = $InsEntregaVentaVehiculo->EvvNumeroMotor;
$EntregaVentaVehiculoModelo = $InsEntregaVentaVehiculo->EvvAnoModelo;
$EntregaVentaVehiculoFabricacion = $InsEntregaVentaVehiculo->EvvAnoFabricacion;
$EntregaVentaVehiculoColor = $InsEntregaVentaVehiculo->EvvColor;
	
	$Guardar = true;
	$InsEntregaVentaVehiculo = new ClsEntregaVentaVehiculo();
	
	$InsEntregaVentaVehiculo->UsuId = $_SESSION['SesionId'];	
	
	$InsEntregaVentaVehiculo->EvvId = NULL;	
	$InsEntregaVentaVehiculo->PerId = $PersonalId;		
	$InsEntregaVentaVehiculo->EvvFechaProgramada = FncCambiaFechaAMysql($GET_FechaProgramada);
	$InsEntregaVentaVehiculo->EvvHoraProgramada = ($GET_HoraProgramada);
	$InsEntregaVentaVehiculo->EvvFecha = date("Y-m-d");
	$InsEntregaVentaVehiculo->EvvDuracion = $GET_Duracion;		
		
	list($InsEntregaVentaVehiculo->EvvAno,$InsEntregaVentaVehiculo->EvvMes,$aux) = explode("-",$InsEntregaVentaVehiculo->EvvFecha);
	
	$InsEntregaVentaVehiculo->EinId = $VehiculoIngresoId;
	$InsEntregaVentaVehiculo->OvvId = $OrdenVentaVehiculoId;
	
	$InsEntregaVentaVehiculo->EvvVIN = $EntregaVentaVehiculoVIN ;
	$InsEntregaVentaVehiculo->EvvNumeroMotor = $EntregaVentaVehiculoNumeroMotor;
	$InsEntregaVentaVehiculo->EvvAnoModelo = $EntregaVentaVehiculoModelo ;
	$InsEntregaVentaVehiculo->EvvAnoFabricacion = $EntregaVentaVehiculoFabricacion;
	$InsEntregaVentaVehiculo->EvvColor = $EntregaVentaVehiculoColor;
	
	$InsEntregaVentaVehiculo->EvvObservacion = $GET_EntregaVentaVehiculoId." - Entrega de vehiculo reprogramada ".date("d/m/Y H:i:s");
	$InsEntregaVentaVehiculo->EvvObservacionSalida = $GET_Observacion;
	
	$InsEntregaVentaVehiculo->EvvAprobacion = 3;	
	
	$InsEntregaVentaVehiculo->EvvEstado = 1;	
	$InsEntregaVentaVehiculo->EvvTiempoCreacion = date("Y-m-d H:i:s");
	$InsEntregaVentaVehiculo->EvvTiempoModificacion = date("Y-m-d H:i:s");
	
	$InsEntregaVentaVehiculo->EvvNotificar = 2;
	
	$InsEntregaVentaVehiculo->EntregaVentaVehiculoObsequio = array();
	$InsEntregaVentaVehiculo->EntregaVentaVehiculoCondicionVenta = array();

	if(empty($InsEntregaVentaVehiculo->EinId)){
			$Guardar = false;
			$Resultado.='#ERR_EVV_112';
	}
	
	if($Guardar){
		
		if($InsEntregaVentaVehiculo->MtdRegistrarEntregaVentaVehiculo()){
			
			if($GET_Notificar=="1"){
				
				$InsPersonal = new ClsPersonal();
				$InsPersonal->PerId = $InsEntregaVentaVehiculo->PerIdVendedor;
				$InsPersonal->MtdObtenerPersonal();
				
				$PersonalEmail = "";
				
				if(!empty($InsPersonal->PerEmail)){

					$PersonalEmail  = trim($InsPersonal->PerEmail);

				}
				
				$InsEntregaVentaVehiculo->MtdNotificarEntregaVentaVehiculoReprogramacion($InsEntregaVentaVehiculo->EvvId,$PersonalEmail .",".$CorreosNotificacionOrdenVentaVehiculoReprogramacionEntregaVehiculo);
				
			}
			
			$CodigoRespuesta = 1;
		}else{
			$CodigoRespuesta = 2;
		}
		
	}else{
		$CodigoRespuesta = 3;
	}
	

		
$Resultado["CodigoRespuesta"] = ($CodigoRespuesta);
$Resultado["MensajeRespuesta"] = ($MensajeRespuesta);

echo json_encode($Resultado);

//if(json_last_error()
?>