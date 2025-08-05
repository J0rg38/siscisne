<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

/*
*Configuraciones
*/
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
/*
*Clases de Conexion
*/
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
/*
*Funciones
*/
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');
?>


<?php
$POST_Inicial = $_POST['Inicial'];

require_once($InsProyecto->MtdRutClases().'ClsVehiculo.php');

$InsVehiculo = new ClsVehiculo();

list($Letra,$Numero) = explode("-",$POST_Inicial);

$InsVehiculo->MtdGenerarVehiculoUnidad($Letra);
echo $InsVehiculo->VehUnidad;
?>	