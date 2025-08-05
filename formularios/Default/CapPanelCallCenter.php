<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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





$POST_finicio = isset($_POST['FechaInicio'])?$_POST['FechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['FechaFin'])?$_POST['FechaFin']:date("d/m/Y");

$POST_ClienteNombre = $_POST['ClienteNombre'];
$POST_ClienteId = $_POST['ClienteId'];

$POST_FichaIngresoId = $_POST['FichaIngresoId'];
$POST_SucursalId = $_POST['SucursalId'];

$POST_VehiculoMarca = $_POST['VehiculoMarca'];
$POST_Modalidad = $_POST['Modalidad'];
$POST_IncluirCSI = $_POST['IncluirCSI'];
$POST_DiasTranscurridos = $_POST['DiasTranscurridos'];

$POST_Filtro = $_POST['Filtro'];

		
$POST_ord = isset($_POST['Orden'])?$_POST['Orden']:"FinFecha";
$POST_sen = isset($_POST['Sentido'])?$_POST['Sentido']:"DESC";

require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');

require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqLogistica().'ClsEncuesta.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenVentaVehiculo.php');




$InsReporteFichaIngreso = new ClsReporteFichaIngreso();



//$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoSeguimientoLlamadas(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_ClienteId,$POST_FichaIngresoId,2,$POST_SucursalId,"MIN-10003,MIN-10019,MIN-10020,MIN-10021",false);		

//MtdObtenerReporteFichaIngresoSeguimientoLlamadas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oFichaIngreso=NULL,$oDiasTranscurridos=0,$oSucursal=NULL,$oModalidadIngreso=NULL,$oConLlamada=false,$oVehiculoMarca=NULL,$oIncluirCSI=NULL,$oDiasTranscurridosTipo="Mayor") {
$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoSeguimientoLlamadas("EinPlaca,EinVIN,FinId,CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_Filtro,$POST_ord,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_ClienteId,$POST_FichaIngresoId,$POST_DiasTranscurridos,$POST_SucursalId,$POST_Modalidad,false,$POST_VehiculoMarca,$POST_IncluirCSI,"Igual");		
$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];





?>

POST VENTA<br />
 
El dia de hoy hay (<?php echo count($ArrReporteFichaIngresos);?>) pendientes por llamar
<br /><br />


<?php
$InsReporteOrdenVentaVehiculo = new ClsReporteOrdenVentaVehiculo();
//MtdObtenerReporteOrdenVentaVehiculoClientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oIncluirCSI=NULL,$oDiasTranscurridosTipo="Mayor",$oDiasTranscurridos=0)
$ResReporteOrdenVentaVehiculo = $InsReporteOrdenVentaVehiculo->MtdObtenerReporteOrdenVentaVehiculoClientes("OvvId,CliNombre,CliApellidoPaterno,CliApellidoMaterno","contiene",$POST_Filtro ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_VehiculoMarca,$POST_SucursalId,$POST_IncluirCSI,"Igual",$POST_DiasTranscurridos);
$ArrReporteOrdenVentaVehiculos = $ResReporteOrdenVentaVehiculo['Datos'];


?>

VENTA<br />

El dia de hoy hay (<?php echo count($ArrReporteFichaIngresos);?>) pendientes por llamar
<br /><br />


