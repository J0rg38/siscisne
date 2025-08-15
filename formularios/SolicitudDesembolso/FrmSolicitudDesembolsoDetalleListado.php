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
$POST_Descuento = (empty($_POST['Descuento'])?0:preg_replace("/,/", "", $_POST['Descuento']));
$POST_AlmacenId = $_POST['AlmacenId'];

session_start();
if (!isset($_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador])){
	$_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsAlmacenProducto = new ClsAlmacenProducto();
$InsAlmacen = new ClsAlmacen();

//	SesionObjeto-SolicitudDesembolsoDetalle
//	Parametro1 = SddId
//	Parametro2 = SdsId
//	Parametro3 = SreId
//	Parametro4 = SddDescripcion
//	Parametro5 = SddCantidad
//	Parametro6 = SddImporte
//	Parametro7 = SddTiempoCreacion
//	Parametro8 = SddTiempoModificacion
//	Parametro9 = SddEstado
//	Parametro10 = SreNombre

$RepSesionObjetos = $_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="7%">Id</th>
  <th width="62%"> Nombre
</th>
  <th width="9%">Cantidad</th>
  <th width="9%">Importe</th>
<th width="11%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$TotalBruto = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>

<tr>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $c;?></td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
  
  
  <?php echo $DatSesionObjeto->Parametro3;?>
  
</td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
  <?php echo $DatSesionObjeto->Parametro10;?>
  
  <!--(<?php echo $DatSesionObjeto->Parametro16;?>)--></td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo number_format($DatSesionObjeto->Parametro5,2);?></td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo number_format($DatSesionObjeto->Parametro6,2);?></td>
<td align="center" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
  
  <?php
if($_POST['Editar']==1){
?>
  
  
  <a class="EstSesionObjetosItem" href="javascript:FncSolicitudDesembolsoDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  
  <?php
}
?>
  
  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncSolicitudDesembolsoDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
    <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?>
  
  
</td>
</tr>
<?php
	$TotalBruto += $DatSesionObjeto->Parametro6;

$c++;
}


//$Total = $TotalBruto - $POST_Descuento;


//if($POST_IncluyeImpuesto == 2){
//	
//	$SubTotal = $TotalBruto - $POST_Descuento;
//	$Impuesto = $SubTotal * ($POST_PorcentajeImpuestoVenta/100);	
//	$Total = $SubTotal + $Impuesto;
//	
//}else{
	
	//$Total = $TotalBruto - $POST_Descuento;
//	$SubTotal = $Total / (($POST_PorcentajeImpuestoVenta/100)+1);
//	$Impuesto = $Total - $SubTotal;	

//}

$Total = $TotalBruto;


?>
</tbody>
</table>
<br />

<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">

<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="left" >&nbsp;</td>
  <td width="68%" align="right" class="Total">Total:</td>
  <td width="8%" align="right"><span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda; ?></span> <?php echo number_format($Total,2);?></td>
  
</tr>
</tbody>
</table>
<?php
}
?>
