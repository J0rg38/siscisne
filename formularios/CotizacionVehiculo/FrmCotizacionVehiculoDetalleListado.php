<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

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

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsCotizacionVehiculoDetalle'.$Identificador])){
	$_SESSION['InsCotizacionVehiculoDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $_POST['MonedaId'];
$InsMoneda->MtdObtenerMoneda();

/*
SesionObjeto-CotizacionVehiculoDetalle
Parametro1 = CvdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = CvdCosto
Parametro5 = CvdCantidad
Parametro6 = CvdImporte
Parametro7 = CvdTiempoCreacion
Parametro8 = CvdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = CvdCantidadReal
Parametro13 = ProCodigoOriginal
Parametro14 = ProCodigoAlternativo
*/
	

$RepSesionObjetos = $_SESSION['InsCotizacionVehiculoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
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
    <th width="2%">#</th>
    <th width="5%">Id</th>
    <th width="9%">Cod. Original</th>
    <th width="9%">Cod. Alternativo</th>
    <th width="46%"> Nombre
    </th>
    <th width="7%">U.M.</th>
    <th width="6%">Precio</th>
    <th width="6%">Cantidad</th>
    <th width="5%">Importe</th>
    <th width="5%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$TotalBruto = 0;
$CantidadTotal = 0;
$TotalItems = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>

<?php
if($InsMoneda->MonId==$EmpresaMonedaId){
?>
	<?php  $DatSesionObjeto->Parametro6 = ($DatSesionObjeto->Parametro6 * $_POST['TipoCambio']);?>
	<?php  $DatSesionObjeto->Parametro4 = ($DatSesionObjeto->Parametro4 * $_POST['TipoCambio']);?>
<?php	
}
?>

<tr>
<td align="right"><?php echo $c;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro13;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro14;?></td>
<td align="right">
<?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro9;?></td>
<td align="right"><?php echo number_format(($DatSesionObjeto->Parametro4),2);?></td>
<td align="right"><?php echo number_format($DatSesionObjeto->Parametro5,3);?> (<?php echo number_format($DatSesionObjeto->Parametro12,3);?>)</td>
<td align="right"><?php echo number_format($DatSesionObjeto->Parametro6,2);?></td>
<td align="center">
<?php
if($_POST['Editar']==1){
?>
<a class="EstSesionObjetosItem" href="javascript:FncCotizacionVehiculoDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
<?php
}
?>

<?php
if($_POST['Eliminar']==1){
?>
<a href="javascript:FncCotizacionVehiculoDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
<img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
<?php
}
?>


</td>
</tr>
<?php
	$TotalItems++;
	$TotalBruto = $TotalBruto + $DatSesionObjeto->Parametro6;
	$CantidadTotal = $CantidadTotal + $DatSesionObjeto->Parametro5;
$c++;
}

if($_POST['IncluyeImpuesto']==1){
	$ImpuestoVenta = ($EmpresaImpuestoVenta/100);
	$ImpuestoVenta = $ImpuestoVenta + 1;
	$SubTotal = (($TotalBruto /$ImpuestoVenta));
	$Impuesto = $TotalBruto - $SubTotal;
	$Total = $TotalBruto;
}else{
	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal*($EmpresaImpuestoVenta/100);	
	$Total = $SubTotal + $Impuesto;
}
?>
</tbody>
</table>
<br />
<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="left" >&nbsp;</td>
  <td width="63%" align="right" class="Total">SubTotal:</td>
  <td width="13%" align="right">
	<span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($SubTotal,2);?> 
  </td>
  </tr>
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" class="Total">&nbsp;</td>
  <td align="right" class="Total">Impuesto (<?php echo $EmpresaImpuestoVenta;?>%):</td>
  <td align="right">
  	<span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Impuesto,2);?>
</td>
 
  <tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="right" class="Total">&nbsp;</td>
  <td align="right" class="Total">Total:</td>
  <td align="right">
    
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?>

  </td>

  </tr>
  
  
 
</tbody>
</table>

<?php
}
?>