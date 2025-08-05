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

session_start();
if (!isset($_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador])){
	$_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();


$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

/*
SesionObjeto-ProduccionProductoDetalle
Parametro1 = PpdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = PpdPrecio
Parametro5 = PpdCantidad
Parametro6 = PpdImporte
Parametro7 = PpdTiempoCreacion
Parametro8 = PpdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = PpdCodigo
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = VerificarStock
Parametro17 = 
Parametro18 = VddId
Parametro19 = PpdAno
Parametro20 = PpdModelo

Parametro21 - PpdDisponibilidad
Parametro22 - PpdReemplazo
Parametro23 = AmdCantidad

Parametro24 = PpdBOFecha
Parametro25 = PpdBOEstado
*/


$RepSesionObjetos = $_SESSION['InsProduccionProductoDetalleEntrada'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="6%">Codigo Original</th>
  <th width="7%">Codigo Alternativo</th>
  <th width="37%"> Nombre</th>
  <th width="6%">U.M.</th>
  <th width="5%">Costo</th>
  <th width="7%"> Cantidad</th>
  <th>Importe</th>
  <th>Estado</th>
  <th>Stock</th>
  <th> Acc.</th>
  <?php
if($POST_VerEstado==1){
?>
  <?php
}
?>
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

<?php
if($POST_VerEstado == 1){
?>

	<?php
	if(empty($DatSesionObjeto->Parametro23)){
		$fondo = "#F30";
	}else if($DatSesionObjeto->Parametro23 >= $DatSesionObjeto->Parametro5){
		$fondo = "#6F3";
	}else if($DatSesionObjeto->Parametro23 < $DatSesionObjeto->Parametro5){
		$fondo = "#FC0";		
	}else{
		$fondo = "";	
	}
	?>
    
<?php
}else{
	$fondo = "";	
}
?>


<?php	
	
//	if($InsMoneda->MonId<>$EmpresaMonedaId){
//	
//		$DatSesionObjeto->Parametro6 = round($DatSesionObjeto->Parametro6 / $POST_TipoCambio,2);
//		$DatSesionObjeto->Parametro4 = round($DatSesionObjeto->Parametro4  / $POST_TipoCambio,2);
//		
//	}
//	
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
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo ($DatSesionObjeto->Parametro9);?></td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo number_format($DatSesionObjeto->Parametro4,2);?></td>
<td align="right" bgcolor="<?php echo $fondo;?>">
  
  <?php echo number_format($DatSesionObjeto->Parametro5,2);?>
  
</td>
<td width="6%" align="right"><?php echo number_format($DatSesionObjeto->Parametro18,2);?></td>
<td width="7%" align="center">
  <?php
switch($DatSesionObjeto->Parametro16){
	case "1":
?>
  No convertido
  <?php
	break;
	
	case "3":
?>
  Convertido
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
<td width="4%" align="center">No Aplica</td>
<td width="11%" align="center"><?php
	if($POST_Editar==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncProduccionProductoDetalleEntradaEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  <?php
if($POST_Eliminar==1){
?>
  <a href="javascript:FncProduccionProductoDetalleEntradaEliminar('<?php echo $DatSesionObjeto->Item;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
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

