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
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];
$POST_ImpuestoVenta = $_POST['ImpuestoVenta'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];
$POST_MonedaSimbolo = $_POST['MonedaSimbolo'];

$POST_PorcentajeImpuestoVenta = $_POST['PorcentajeImpuestoVenta'];
$POST_PorcentajeImpuestoSelectivo = $_POST['PorcentajeImpuestoSelectivo'];

$POST_TotalDescuentoGlobal = $_POST['TotalDescuentoGlobal'];

	

session_start();
if (!isset($_SESSION['InsComprobanteRetencionDetalle'.$Identificador])){
	$_SESSION['InsComprobanteRetencionDetalle'.$Identificador] = new ClsSesionObjeto();	
}



//deb($POST_PorcentajeDescuento);

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();


/*
SesionObjeto-ComprobanteRetencionDetalleListado
Parametro1 = CedId
Parametro2 = CedTipoDocumento
Parametro3 = 
Parametro4 = CedRetenido
Parametro5 = CedPagado
Parametro6 = CedTotal
Parametro7 = CedTiempoCreacion
Parametro8 = CedTiempoModificacion
Parametro9 = CedSerie
Parametro10 = CedNumero
Parametro11 = CedPorcentajeRetencion
Parametro12 = CedFechaEmision
Parametro13 = CedEstado
*/

$RepSesionObjetos = $_SESSION['InsComprobanteRetencionDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];
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
  <th width="19">#</th>
  <th width="34">Tipo</th>
  <th width="91">Serie</th>
  <th width="109">Numero</th>
  <th width="265"> Fecha Emision</th>
  <th width="116">Monto a Pagar</th>
  <th width="101">Porcen. Reten.</th>
  <th width="82">Retenido</th>
  <th width="75">Pagado</th>
  <th width="68"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$Total = 0;
$CantidadTotal = 0;
$TotalItems = 0;
$TotalRetenido = 0;

foreach($ArrSesionObjetos as $DatSesionObjeto){

?>

<tr>
<td align="center" valign="top">
<span title="<?php echo $DatSesionObjeto->Parametro1;?>">
<?php echo $c;?></span></td>
<td align="right" valign="top"><?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right" valign="top"><?php echo ($DatSesionObjeto->Parametro9);?></td>
<td align="right" valign="top"><?php echo ($DatSesionObjeto->Parametro10);?></td>
<td align="right" valign="top"><?php echo utf8_encode($DatSesionObjeto->Parametro12);?>
  
</td>
<td align="right" valign="top"> <?php echo number_format(($DatSesionObjeto->Parametro6),2);?></td>
<td width="101" align="right" valign="top">
  
 
  <?php echo number_format(($DatSesionObjeto->Parametro11),2);?>

  </td>
<td width="82" align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro4,2);?></td>
<td width="75" align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro5,2);?></td>
<td width="68" align="center" valign="top">
  <?php
if($POST_Editar==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncComprobanteRetencionDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  
  
  <?php
if($POST_Eliminar==1){
?>
  
  <a href="javascript:FncComprobanteRetencionDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
  <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  
  <?php
}
?>
  <?php //echo ($DatSesionObjeto->Parametro24);?> 
</td>
</tr>
<?php
	$TotalItems++;

	$TotalRetenido += $DatSesionObjeto->Parametro5;

$c++;
}

?>

</tbody>
</table>



<br />


<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<tbody class="EstTablaListadoBody">
<tr>
  <td colspan="6" align="right"><span class="Total">IMPORTE TOTAL RETENIDO:</span></td>
  <td width="153" align="right">
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span><?php echo number_format($TotalRetenido,2);?>
    </td>
  <td width="30" align="right">&nbsp;</td>
</tr>
</tbody>
</table>
<?php
}
?>
