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
$POST_PorcentajeImpuestoVenta = $_POST['PorcentajeImpuestoVenta'];
$POST_OrdenCompraId = $_POST['OrdenCompraId'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];

$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];
$POST_VerEstado = $_POST['VerEstado'];
$POST_AlmacenId = $_POST['AlmacenId'];

session_start();
if (!isset($_SESSION['InsTrasladoAlmacenDetalle'.$Identificador])){
	$_SESSION['InsTrasladoAlmacenDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');


$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsAlmacenProducto = new ClsAlmacenProducto();

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsAlmacenProducto = new ClsAlmacenProducto();

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

/*
SesionObjeto-TrasladoAlmacenDetalle
Parametro1 = TadId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = TadPrecio
Parametro5 = TadCantidad
Parametro6 = TadImporte
Parametro7 = TadTiempoCreacion
Parametro8 = TadTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = TadCodigo
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = VerificarStock
Parametro17 = 
Parametro18 = VddId
Parametro19 = TadAno
Parametro20 = TadModelo

Parametro21 - TadDisponibilidad
Parametro22 - TadReemplazo
Parametro23 = AmdCantidad

Parametro24 = TadBOFecha
Parametro25 = TadBOEstado
*/


$RepSesionObjetos = $_SESSION['InsTrasladoAlmacenDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];


//deb($ArrSesionObjetos);
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
  <th width="2%">Id</th>
  <th width="9%">Codigo Original</th>
  <th width="8%">Codigo Alternativo</th>
  <th width="44%"> Nombre</th>
  <th width="4%">U.M.</th>
  <th width="9%"> Cantidad</th>
  <th>Estado</th>
  <th width="6%" align="center">Stock</th>
  <th> Acc.</th>

  </tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$Total = 0;
//$TotalBruto = 0;
//$CantidadTotal = 0;
$TotalItems = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>

<tr>
<td align="right" bgcolor="<?php echo $fondo;?>">
<span title="<?php echo $DatSesionObjeto->Parametro1;?>">
<?php echo $c;?>
</span>
</td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatSesionObjeto->Parametro13;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatSesionObjeto->Parametro14;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>">
  <?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatSesionObjeto->Parametro9;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>">
	
	<?php echo number_format($DatSesionObjeto->Parametro5,3);?>

</td>
<td width="7%" align="center">
<?php
switch($DatSesionObjeto->Parametro16){
	case "1":
?>
No transferido
<?php
	break;
	
	case "3":
?>
Transferido
<?php
	break;
	

	
	default:
?>
-
<?php	
	break;
}
?>


</td>
<td align="center" valign="middle">

<?php
$StockReal = 0;


//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($DatSesionObjeto->Parametro2,$POST_AlmacenId,date("Y"),$_SESSION['SesionSucursal']);

$InsUnidadMedida->UmeId = $DatSesionObjeto->Parametro10;
$InsUnidadMedida->MtdObtenerUnidadMedida();

$VerificarStock = 2;

if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
	$InsUnidadMedidaConversion->UmcEquivalente = 1;
}else{
	$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
	$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
	
	foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
		$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
	}
}

$CantidadReal = round($DatSesionObjeto->Parametro5 * $InsUnidadMedidaConversion->UmcEquivalente,6);

if($StockReal < $CantidadReal){		
	$VerificarStock = 1;
}

?>
  <a href="javascript:FncAlmacenStockConsultarCargar('<?php echo trim($DatSesionObjeto->Parametro2);?>');">
    <?php
if($VerificarStock == 1){
?>
    <span style="color:#F00; font-weight:bold;">SIN STOCK </span>
    <?php	
}else{
?>
    EN STOCK
    <?php	
}
?>
    (<?php echo number_format($StockReal,2);?>)
    
 <!--    <?php if(!empty($DatSesionObjeto->Parametro17)){?>+ <b><?php echo number_format($DatSesionObjeto->Parametro17,2);?></b><?php }?>) -->
    
    
     </a>
  <?php
/*
$InsProducto->ProId = $DatSesionObjeto->Parametro2;
$InsProducto->MtdObtenerProducto(false);

$InsUnidadMedida->UmeId = $DatSesionObjeto->Parametro10;
$InsUnidadMedida->MtdObtenerUnidadMedida();

$VerificarStock = 2;

if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
	$InsUnidadMedidaConversion->UmcEquivalente = 1;
}else{
	$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
	$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
	
	foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
		$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
	}
}

$CantidadReal = round($DatSesionObjeto->Parametro5 * $InsUnidadMedidaConversion->UmcEquivalente,6);

if($InsProducto->ProStockReal < $CantidadReal){		
	$VerificarStock = 1;
}

?>

<?php
//if($DatSesionObjeto->Parametro16 == 1){
if($VerificarStock == 1){
?>

	<span style="color:#F00; font-weight:bold;">SIN STOCK  </span>
  
<?php	
}else{
?>

  <a href="javascript:FncAlmacenStockConsultarCargar('<?php echo trim($DatSesionObjeto->Parametro2);?>');">  EN STOCK </a>
  
<?php	
}
?>
(<?php echo number_format($InsProducto->ProStockReal,2);?>)


<?php
*/
?></td>
<td width="9%" align="center"><?php
	if($POST_Editar==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncTrasladoAlmacenDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  <?php
if($POST_Eliminar==1){
?>
  <a href="javascript:FncTrasladoAlmacenDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?></td>
<?php
if($POST_VerEstado==1){
?>
<?php
}
?>
</tr>
<?php
	$TotalItems++;
	$TotalBruto = $TotalBruto + $DatSesionObjeto->Parametro6;

$c++;
}



$Total = $TotalBruto;


?>
</tbody>
</table>
<br />


<?php
}
?>

