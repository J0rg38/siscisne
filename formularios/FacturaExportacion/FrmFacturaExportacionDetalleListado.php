<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

$Identificador = $_POST['Identificador'];
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];

$POST_OvvId = $_POST['OrdenVentaVehiculoId'];
$POST_MonedaSimbolo = $_POST['MonedaSimbolo'];
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];

session_start();
if (!isset($_SESSION['InsFacturaExportacionDetalle'.$Identificador])){
	$_SESSION['InsFacturaExportacionDetalle'.$Identificador] = new ClsSesionObjeto();	
}


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FedId
Parametro2 = FedDescripcion
Parametro3
Parametro4 = FedPrecio
Parametro5 = FedCantidad
Parametro6 = FedImporte
Parametro7 = FedTiempoCreacion
Parametro8 = FedTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FedTipo
Parametro13 = FedUnidadMedida
*/

$RepSesionObjetos = $_SESSION['InsFacturaExportacionDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];
?>

<?php
if(!empty($POST_OvvId)){

	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
	$InsOrdenVentaVehiculo->OvvId = $POST_OvvId;
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();

}
?>

<?php
if(empty($ArrSesionObjetos)){
?>
No se encontraron elementos
<?php
}else{

?>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%">#</th>
  <th width="3%">Tipo</th>
  <th width="57%"> Descripci&oacute;n</th>
  <th width="4%">U.M.</th>
  <th width="7%">p/unitario</th>
  <th width="11%">Cantidad</th>
  <th width="8%">Importe</th>

<th width="8%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$Total = 0;
$CantidadTotal = 0;
$TotalItems = 0;

foreach($ArrSesionObjetos as $DatSesionObjeto){
?>

<tr>
<td align="right" valign="top">
<span title="<?php echo $DatSesionObjeto->Parametro1;?>">
<?php echo $c;?>
</span>
</td>
<td align="right" valign="top"><?php echo $DatSesionObjeto->Parametro12;?></td>
<td align="right" valign="top">
  
  <?php echo utf8_encode($DatSesionObjeto->Parametro2);?>
  
  </td>
<td align="right" valign="top"><?php echo $DatSesionObjeto->Parametro13;?></td>
<td align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro4,2);?></td>
<td align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro5,2);?></td>
<td align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro6,2);?></td>

<td align="center" valign="top">


<?php
if($POST_Editar==1){
?>

<a class="EstSesionObjetosItem" href="javascript:FncFacturaExportacionDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');">
<img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>

<?php	
}
?>

<?php
if($POST_Eliminar==1){
?>
<a href="javascript:FncFacturaExportacionDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
<img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
<?php	
}
?>

</td>
</tr>

<?php
	$TotalItems++;
	$Total += $DatSesionObjeto->Parametro6;	
	$CantidadTotal = $CantidadTotal + $DatSesionObjeto->Parametro5;
$c++;
}
?>

</tbody>
</table>

<br />

<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<tbody class="EstTablaListadoBody">
<tr>
<td colspan="6" align="right">
<span class="Total">TOTAL:</span></td>
<td width="17%" align="right"><span class="EstMonedaSimbolo"><?php echo $POST_MonedaSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
<td width="5%" align="center">&nbsp;</td>
</tr>
</tbody>
</table>

<?php
}
?>
