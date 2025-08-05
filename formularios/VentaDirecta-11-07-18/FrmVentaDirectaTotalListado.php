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
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];
$POST_ManoObra = eregi_replace(",","",$_POST['ManoObra']);
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];
$POST_PorcentajeDescuento = eregi_replace(",","",$_POST['DescuentoPorcentaje']);


session_start();
if (!isset($_SESSION['InsVentaDirectaDetalle'.$Identificador])){
	$_SESSION['InsVentaDirectaDetalle'.$Identificador] = new ClsSesionObjeto();	
}
if (!isset($_SESSION['InsVentaDirectaPlanchado'.$Identificador])){
	$_SESSION['InsVentaDirectaPlanchado'.$Identificador] = new ClsSesionObjeto();	
}
if (!isset($_SESSION['InsVentaDirectaPintado'.$Identificador])){
	$_SESSION['InsVentaDirectaPintado'.$Identificador] = new ClsSesionObjeto();	
}
if (!isset($_SESSION['InsVentaDirectaCentrado'.$Identificador])){
	$_SESSION['InsVentaDirectaCentrado'.$Identificador] = new ClsSesionObjeto();	
}
if (!isset($_SESSION['InsVentaDirectaTarea'.$Identificador])){
	$_SESSION['InsVentaDirectaTarea'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsVentaDirectaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');



require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

$RepSesionObjetos = $_SESSION['InsVentaDirectaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrVentaDirectaDetalles = $RepSesionObjetos['Datos'];

$RepSesionObjetos = $_SESSION['InsVentaDirectaPlanchado'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrVentaDirectaPlanchados = $RepSesionObjetos['Datos'];

$RepSesionObjetos = $_SESSION['InsVentaDirectaPintado'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrVentaDirectaPintados = $RepSesionObjetos['Datos'];

$RepSesionObjetos = $_SESSION['InsVentaDirectaCentrado'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrVentaDirectaCentrados = $RepSesionObjetos['Datos'];

$RepSesionObjetos = $_SESSION['InsVentaDirectaTarea'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrVentaDirectaTareas = $RepSesionObjetos['Datos'];


$TotalRepuesto = 0;

    foreach($ArrVentaDirectaDetalles as $DatSesionObjeto){
		$TotalRepuesto = $TotalRepuesto + $DatSesionObjeto->Parametro6;
	}
	
$TotalPlanchado = 0;

    foreach($ArrVentaDirectaPlanchados as $DatSesionObjeto){
		$TotalPlanchado = $TotalPlanchado + $DatSesionObjeto->Parametro5;
	}
	
$TotalPintado = 0;

    foreach($ArrVentaDirectaPintados as $DatSesionObjeto){
		$TotalPintado = $TotalPintado + $DatSesionObjeto->Parametro5;
	}
	
$TotalCentrado = 0;

    foreach($ArrVentaDirectaCentrados as $DatSesionObjeto){
		$TotalCentrado = $TotalCentrado + $DatSesionObjeto->Parametro5;
	}
	
$TotalTarea = 0;

    foreach($ArrVentaDirectaTareas as $DatSesionObjeto){
		$TotalTarea = $TotalTarea + $DatSesionObjeto->Parametro5;
	}
	
//$TotalBruto = $POST_ManoObra + $TotalRepuesto + $TotalCentrado + $TotalPintado + $TotalPlanchado + $TotalTarea;
	//deb($POST_IncluyeImpuesto);
    if($POST_IncluyeImpuesto==1){
        
        $Total = $POST_ManoObra + $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea;
        $SubTotal = $Total / (($POST_PorcentajeImpuestoVenta/100)+1);
        $Impuesto = $Total - $SubTotal;	
        
    }else{
        
        $SubTotal = $POST_ManoObra + $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea;
        $Impuesto = $SubTotal * (($POST_PorcentajeImpuestoVenta/100));
        $Total = $SubTotal + $Impuesto;	
        
    }
	
	
	
?>


<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="5%" align="right" class="Total">&nbsp;</td>
  <td width="46%" align="right" class="Total">&nbsp;</td>
  <td align="right" class="Total"><!--Total Repuestos:-->
    <?php
/*if(!empty($POST_ManoObra) and $POST_ManoObra <> "0.00"){
?> 
    Mano de Obra:
  <?php	
}*/
?></td>
  <td align="right"><!--<span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> 
  
  <?php echo number_format($TotalRepuesto,2);?>-->
    
    <?php
/*if(!empty($POST_ManoObra) and $POST_ManoObra <> "0.00"){
?>
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> 
    <?php echo number_format($POST_ManoObra,2);?> 
    
  <?php	
}*/
?></td>
</tr>
<tr>
  <td colspan="2" align="right" class="Total"><?php
/*if($POST_IncluyeImpuesto == 1){
?>
    Los precios	incluyen impuesto
    <?php	
}else{
?>
    Los precios	no incluyen impuesto
    <?php	
}*/
?></td>
  <td width="39%" align="right" class="Total">SubTotal:</td>
  <td width="10%" align="right">
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($SubTotal,2);?> 
    </td>
</tr>
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" class="Total">&nbsp;</td>
  <td align="right" class="Total">I.G.V. (<?php echo $EmpresaImpuestoVenta;?>%):</td>
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

