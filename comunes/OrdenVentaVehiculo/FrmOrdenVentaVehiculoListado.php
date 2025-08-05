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

//CONTROL DE LISTA DE ACCESO
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');

$InsACL = new ClsACL();

$PrivilegioAccesoTotal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenVentaVehiculo","AccesoTotal"))?true:false;

$POST_Filtro = $_POST['Filtro'];
$POST_Sucursal = $_POST['Sucursal'];

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();

//if($PrivilegioAccesoTotal){
	
//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oOrdenVentaVehiculo=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL,$oAprobacion1=NULL,$oAprobacion2=NULL,$oAprobacion3=NULL,$oTieneActaFechaEntrega=0)
	$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos("ovv.OvvId,ein.EinVIN,ein.EinPlaca,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNombreCompleto,cli.CliTelefono,cli.CliCelular,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre","contiene",$POST_Filtro,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio,true),FncCambiaFechaAMysql($POST_ffin,true),5,$POST_Moneda,NULL,NULL,0,NULL,NULL,NULL,$POST_Sucursal,NULL,NULL,NULL,$POST_ActaEntrega);
	$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];
	$OrdenVentaVehiculosTotal = $ResOrdenVentaVehiculo['Total'];
	$OrdenVentaVehiculosTotalSeleccionado = $ResOrdenVentaVehiculo['TotalSeleccionado'];

//}else{
//
//	$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos("ovv.OvvId,ein.EinVIN,ein.EinPlaca,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNombreCompleto,cli.CliTelefono,cli.CliCelular,vma.VmaNombre,vmo.VmoNombre,vve.VveNombre","contiene",$POST_Filtro,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio,true),FncCambiaFechaAMysql($POST_ffin,true),5,$POST_Moneda,NULL,NULL,0,NULL,NULL,NULL,$POST_Sucursal,NULL,NULL,NULL,$POST_ActaEntrega);
//	$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];
//	$OrdenVentaVehiculosTotal = $ResOrdenVentaVehiculo['Total'];
//	$OrdenVentaVehiculosTotalSeleccionado = $ResOrdenVentaVehiculo['TotalSeleccionado'];
//
//}
?>





<?php
if(empty($ArrOrdenVentaVehiculos)){
?>
No se encontraron elementos
<?php
}else{
?>
Se encontraron <?php echo $OrdenVentaVehiculosTotal;?> elemento(s)
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstTablaListado">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" align="center">#</th>
  <th width="7%" align="center">Sucursal</th>
  <th width="7%" align="center">Orden de Venta</th>
  <th width="6%" align="center">Num. Doc.</th>
  <th width="38%" align="center">
    Nombre</th>
  <th width="8%" align="center">Telef.</th>
  <th width="8%" align="center">Cel.</th>
  <th width="7%" align="center">VIN</th>
  <th width="6%" align="center">Placa</th>
  <th width="5%" align="center">Vehiculo</th>
  <th width="6%" align="center"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
foreach($ArrOrdenVentaVehiculos as $DatOrdenVentaVehiculo){
?>
<tr>
<td align="center"><?php echo $c;?></td>
<td align="right"><?php echo $DatOrdenVentaVehiculo->SucNombre;?></td>
<td align="right"><?php echo $DatOrdenVentaVehiculo->OvvId;?></td>
<td align="right"><?php echo $DatOrdenVentaVehiculo->CliNumeroDocumento;?></td>
<td align="right">
  
    <?php echo $DatOrdenVentaVehiculo->CliNombre;?> <?php echo $DatOrdenVentaVehiculo->CliApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculo->CliApellidoMaterno;?>
    
</td>
<td align="center"><?php echo $DatOrdenVentaVehiculo->CliTelefono;?></td>
<td align="center"><?php echo $DatOrdenVentaVehiculo->CliCelular;?></td>
<td align="center"><?php echo $DatOrdenVentaVehiculo->EinVIN;?></td>
<td align="center"><?php echo $DatOrdenVentaVehiculo->EinPlaca;?></td>
<td align="center"><?php echo $DatOrdenVentaVehiculo->VmaNombre;?><?php echo $DatOrdenVentaVehiculo->VmoNombre;?><?php echo $DatOrdenVentaVehiculo->VveNombre;?></td>
<td align="center">
  
  
  
  <a  href="javascript:FncOrdenVentaVehiculoListadoEscoger('<?php echo $DatOrdenVentaVehiculo->OvvId;?>');">
    <img border="0"  align="absmiddle" src="imagenes/escoger.gif" alt="[Escoger]" title="Escoger" width="15" height="15"  />
    </a>
  
  
</td>
</tr>
<?php
$c++;
}
?>
</tbody>
</table>

<?php
}
?>

