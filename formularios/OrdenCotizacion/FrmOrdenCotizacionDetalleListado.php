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
$POST_PorcentajeImpuestoVenta = $_POST['PorcentajeImpuestoVenta'];
$POST_OrdenCompraId = $_POST['OrdenCompraId'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];

$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];
$POST_VerEstado = $_POST['VerEstado'];

session_start();
if (!isset($_SESSION['InsOrdenCotizacionDetalle'.$Identificador])){
	$_SESSION['InsOrdenCotizacionDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();


$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

/*
SesionObjeto-OrdenCotizacionDetalle
Parametro1 = PcdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = PcdPrecio
Parametro5 = PcdCantidad
Parametro6 = PcdImporte
Parametro7 = PcdTiempoCreacion
Parametro8 = PcdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = PcdCodigo
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = VerificarStock
Parametro17 = 
Parametro18 = VddId
Parametro19 = PcdAno
Parametro20 = PcdModelo

Parametro21 - PcdDisponibilidad
Parametro22 - PcdReemplazo
Parametro23 = AmdCantidad

Parametro24 = PcdBOFecha
Parametro25 = PcdBOEstado
*/


$RepSesionObjetos = $_SESSION['InsOrdenCotizacionDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="14%">Cod. Orig.</th>
  <th width="27%"> Nombre</th>
  <th width="5%">U.M.</th>
  <th width="6%">Año</th>
  <th width="7%">Modelo</th>
  <th width="8%">Precio Cotizado</th>
  <?php
if($POST_VerEstado==1){
?>
  <?php
}
?>
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
<td align="right" bgcolor="<?php echo $fondo;?>">
  
  
  <?php echo $DatSesionObjeto->Parametro13;?>
  
  
  <a target="_blank" href="principal.php?Mod=Producto&Form=Consulta&ProCodigoOriginal=<?php echo $DatSesionObjeto->Parametro13;?>"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Producto]" width="20" height="20" border="0" align="absmiddle" title="Producto " /> </a>
  <a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatSesionObjeto->Parametro2;?>"   title=""> <img src="imagenes/almacen_stock.jpg" alt="[Stock]" width="20" height="20" border="0" align="absmiddle" title="Stock" /> </a>
  
  
  
</td>
<td align="right" bgcolor="<?php echo $fondo;?>">
  <?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatSesionObjeto->Parametro9;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatSesionObjeto->Parametro19;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatSesionObjeto->Parametro20;?></td>
<td align="right" ><?php echo number_format($DatSesionObjeto->Parametro4,2);?></td>
<?php
if($POST_VerEstado==1){
?>
<?php
}
?>
<td width="6%" align="center">  
  
  <?php
	if($POST_Editar==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncOrdenCotizacionDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  
  <?php
if($POST_Eliminar==1){
?>
  <a href="javascript:FncOrdenCotizacionDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
    <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?></td>
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
