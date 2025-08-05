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
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];
$POST_ManoObra = eregi_replace(",","",$_POST['ManoObra']);
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];
$POST_DescuentoPorcentaje = eregi_replace(",","",$_POST['DescuentoPorcentaje']);


session_start();
if (!isset($_SESSION['InsCotizacionProductoDetalle'.$Identificador])){
	$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = new ClsSesionObjeto();	
}

if (!isset($_SESSION['InsCotizacionProductoPlanchado'.$Identificador])){
	$_SESSION['InsCotizacionProductoPlanchado'.$Identificador] = new ClsSesionObjeto();	
}
if (!isset($_SESSION['InsCotizacionProductoPintado'.$Identificador])){
	$_SESSION['InsCotizacionProductoPintado'.$Identificador] = new ClsSesionObjeto();	
}
if (!isset($_SESSION['InsCotizacionProductoCentrado'.$Identificador])){
	$_SESSION['InsCotizacionProductoCentrado'.$Identificador] = new ClsSesionObjeto();	
}
if (!isset($_SESSION['InsCotizacionProductoTarea'.$Identificador])){
	$_SESSION['InsCotizacionProductoTarea'.$Identificador] = new ClsSesionObjeto();	
}



require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');

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

$RepSesionObjetos = $_SESSION['InsCotizacionProductoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCotizacionProductoDetalles = $RepSesionObjetos['Datos'];




$RepSesionObjetos = $_SESSION['InsCotizacionProductoPlanchado'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCotizacionProductoPlanchados = $RepSesionObjetos['Datos'];

$RepSesionObjetos = $_SESSION['InsCotizacionProductoPintado'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCotizacionProductoPintados = $RepSesionObjetos['Datos'];

$RepSesionObjetos = $_SESSION['InsCotizacionProductoCentrado'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCotizacionProductoCentrados = $RepSesionObjetos['Datos'];

$RepSesionObjetos = $_SESSION['InsCotizacionProductoTarea'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrCotizacionProductoTareas = $RepSesionObjetos['Datos'];



?>


<table class="EstTablaListado" width="100%" cellpadding="1" cellspacing="1" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" rowspan="2">#</th>
  <th width="2%" rowspan="2">Id</th>
  <th width="5%" rowspan="2">Estado</th>
  <th width="5%" rowspan="2">Cod. Original</th>
  <th width="6%" rowspan="2">Cod. Alternativo</th>
  <th width="14%" rowspan="2"> Nombre    </th>
  <th width="3%" rowspan="2">U.M.</th>
  <th width="5%" rowspan="2">Cantidad</th>
  <th width="4%" rowspan="2">Precio</th>
  <th width="4%" rowspan="2">Importe</th>
  <th colspan="2">Descuento</th>
  <th width="5%" rowspan="2">Importe Final </th>
  <th colspan="2">(Lista GM)</th>
  <th width="8%" rowspan="2">Stk.</th>
  <th width="4%" rowspan="2">Pedido</th>
  <th width="9%" rowspan="2">Nota</th>
  <th width="9%" rowspan="2"> Acc.</th>
</tr>
<tr>
    <th width="4%">Valor</th>
    <th width="6%">(%)</th>
    <th width="6%">Disponible 
      
      
      
      
  <?php
	$FechaDisponibilidad = "";
	
	$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades(NULL,NULL,NULL ,"PdiTiempoCreacion","DESC","1",1);
	$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
	
	if(!empty($ArrProductoDisponibilidades)){
		foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
			
			$FechaDisponibilidad = $DatProductoDisponibilidad->PdiTiempoCreacion;
		
		}
	}
?>
  <?php
echo $FechaDisponibilidad;
?>
      
      
      
      
    </th>
    <th width="8%">Reemplazo 
      <?php

$FechaReemplazo = "";

?>
      
      <?php
	// MtdObtenerProductoReemplazos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {
		
	$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos(NULL,NULL,NULL ,"PreTiempoCreacion","DESC","1",1);
    $ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
    
    if(!empty($ArrProductoReemplazos)){
		foreach($ArrProductoReemplazos as $DatProductoReemplazo){
			
			$FechaReemplazo = $DatProductoReemplazo->PreTiempoCreacion;
		
		}
    }
    ?>
      
      
      <?php

echo $FechaReemplazo;

?>
      
      
</th>
    </tr>
</thead>
<tbody class="EstTablaListadoBody">

<?php
if(!empty($ArrCotizacionProductoDetalles)){
?>
	<?php
    
		
    $c = 1;
    $TotalBruto = 0;
	$TotalDescuento = 0;
	
    foreach($ArrCotizacionProductoDetalles as $DatSesionObjeto){
    ?>
    
    
<?php

	
//						SesionObjeto-CotizacionProductoDetalle
//						Parametro1 = CpdId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = CrdPrecio
//						Parametro5 = CrdCantidad
//						Parametro6 = CrdImporte
//						Parametro7 = CrdTiempoCreacion
//						Parametro8 = CrdTiempoModificacion

//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = AmdCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo

//						Parametro15 = AmdPrecioVenta
//						Parametro16 = CrdDescripcion
//						Parametro17 = CrdCodigo
//						Parametro18 = CrdValorVenta

//						Parametro19 = UmeIdOrigen
//						Parametro20 = CrdCosto
//						Parametro21 = CrdEstado
//						Parametro22 = CrdTipoPedido
//						Parametro23 = CrdDescuento
//						Parametro24 = CrdPrecioBruto

//						Parametro25 = CrdPorcentajeUtilidad
//						Parametro26 = CrdPorcentajeOtroCosto
//						Parametro27 = CrdPorcentajeManoObra
//						Parametro28 = CrdPorcentajePedido

//						Parametro29 = CrdPorcentajeAdicional
//						Parametro30 = CrdPorcentajeDescuento
//						Parametro31 = CrdAdicional
//						Parametro32 = CrdDescuentoUnitario
//						Parametro33 = CrdImporteBruto


?>
<?php

?>
        
        
        <tr>
        <td align="right">
        <span title="<?php echo $DatSesionObjeto->Parametro1;?>">
        <?php echo $c;?>
        </span>
        </td>
        <td align="right"><?php echo $DatSesionObjeto->Parametro2;?>
        <input style="visibility:hidden;" checked="checked" etiqueta="detalle" type="checkbox" name="CmpCotizacionProductoDetalle_<?php echo $DatSesionObjeto->Item;?>" id="CmpCotizacionProductoDetalle_<?php echo $DatSesionObjeto->Item;?>" value="<?php echo $DatSesionObjeto->Item;?>"/>
        
        
        </td>
        <td align="right">
        
        
        
        <select <?php echo (($_POST['Editar']==2)?'disabled="disabled"':'')?> class="EstFormularioCombo" name="CmpCotizacionProductoDetalleEstado_<?php echo $DatSesionObjeto->Item;?>" id="CmpCotizacionProductoDetalleEstado_<?php echo $DatSesionObjeto->Item;?>">
          <option value="">-</option>
          <option <?php echo (($DatSesionObjeto->Parametro21=="6")?'selected="selected"':'');?> value="6">Anulado</option>
          <option <?php echo (($DatSesionObjeto->Parametro21=="3")?'selected="selected"':'');?> value="3" >Considerar</option>
        </select></td>
        <td align="right">
        
        <?php //echo $DatSesionObjeto->Parametro13;?>
         <a href="javascript:FncProductoConsultarCargar('<?php echo trim($DatSesionObjeto->Parametro2);?>');"><?php echo $DatSesionObjeto->Parametro13;?></a>

      
        
        </td>
        <td align="right"><?php echo $DatSesionObjeto->Parametro14;?></td>
        <td align="left"><?php echo $DatSesionObjeto->Parametro3;?> </td>
        <td align="right"><?php echo $DatSesionObjeto->Parametro9;?></td>
        <td align="right"><?php echo number_format($DatSesionObjeto->Parametro5,2);?></td>
        <td align="right"><?php echo number_format($DatSesionObjeto->Parametro24,2);?></td>
        <td align="right"><?php echo number_format($DatSesionObjeto->Parametro33,2);?></td>
        <td align="right" bgcolor="#99FF66"><?php echo number_format($DatSesionObjeto->Parametro23,2);?></td>
        <td align="right" bgcolor="#99FF66">
		
		<?php echo number_format(($DatSesionObjeto->Parametro30),2);?> 
		<?php //echo number_format(($DetalleDescuento),2);?>
        
        </td>
        <td align="right"><?php echo number_format(($DatSesionObjeto->Parametro6 ),2);?></td>
        
        
        
        <td align="center" bgcolor="#FFFF99">
        
        
        <?php
        
        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatSesionObjeto->Parametro13 ,"PdiTiempoCreacion","DESC","1",1);
        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
        
        //$Disponibilidad = "";
        $Disponibilidad = "NO";
        $Cantidad = 0;
        if(!empty($ArrProductoDisponibilidades)){
            foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
                
                $Disponibilidad =  ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';
                $Cantidad =  ($DatProductoDisponibilidad->PdiCantidad);
            
            }
        }
        
        ?>
        
        <?php echo $Disponibilidad;?>		
        (<?php echo number_format($Cantidad,2);?>)
        </td>
        <td align="center" bgcolor="#FFCC33">
        
        
        <?php
        $Reemplazo = "NO";
         $ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",$DatSesionObjeto->Parametro13 ,"PreId","ASC",NULL,1);
        $ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
        
        if(!empty($ArrProductoReemplazos)){
              $Reemplazo= "SI";
        }
             
        ?>
        
<?php
if($Reemplazo == "SI"){
?>
	
	<a href="javascript:FncProductoReemplazoCargar('<?php echo trim($DatSesionObjeto->Parametro13);?>');"><?php echo $Reemplazo;?></a>
    
<?php	
}else{
?>
<?php echo $Reemplazo;?>
<?php	
}
?>
        
        </td>
        <td align="center">


<?php


$StockReal = 0;

$InsAlmacenProducto = new ClsAlmacenProducto();
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
//if($DatSesionObjeto->Parametro16 == 1){
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
  
  
  
  <!--<a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatSesionObjeto->Parametro2;?>">
	EN STOCK     </a>-->
<?php	
}
?>

(<?php echo number_format($InsProducto->ProStockReal,2);?>)



<?php
*/
?>

        
        
        
      
        
        
        </td>
        <td align="right">
	
		
		<?php echo $DatSesionObjeto->Parametro22;?>
        
        
        </td>
        <td align="center">
        
        <input name="CmpCotizacionProductoDetalleObservacion_<?php echo $DatSesionObjeto->Item;?>" type="text" class="EstFormularioCaja" id="CmpCotizacionProductoDetalleObservacion_<?php echo $DatSesionObjeto->Item;?>" value="<?php echo $DatSesionObjeto->Parametro35?>" size="25" maxlength="255" />
        
        </td>
        <td align="center">
          <?php
        if($POST_Editar==1){
        ?>
          <a class="EstSesionObjetosItem" href="javascript:FncCotizacionProductoDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
          <?php
        }
        ?>
          
          <?php
        if($POST_Eliminar==1){
        ?>
          <a href="javascript:FncCotizacionProductoDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
          <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
          <?php
        }
        ?>
          
          
        </td>
        </tr>

	<?php
//        $TotalBruto = $TotalBruto + $DatSesionObjeto->Parametro6;
		$TotalBruto = $TotalBruto + $DatSesionObjeto->Parametro6;
		$TotalDescuento = $TotalDescuento + $DatSesionObjeto->Parametro23;
		
		
    $c++;
    }
    ?>

<?php
}
?>



<?php

$TotalRepuesto = $TotalBruto;

?>

    <?php
if(!empty($POST_ManoObra) and $POST_ManoObra <> "0.00"){
?>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="right">-</td>
      <td align="right">&nbsp;</td>
      <td align="right">-</td>
      <td align="right">-</td>
      <td align="left">MANO DE OBRA</td>
      <td align="right">-</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">-</td>
      <td align="right" bgcolor="#99FF66">&nbsp;</td>
      <td align="right" bgcolor="#99FF66">-</td>
      <td align="right">
        <?php echo number_format($POST_ManoObra,2);?>
     </td>
      <td align="center" bgcolor="#FFFF99">-</td>
      <td align="center" bgcolor="#FFCC33">-</td>
      <td align="center">-</td>
      <td align="center">-</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
<?php
}
?>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right"><?php
if(!empty($TotalDescuento )){
?>
        <?php echo number_format($TotalDescuento,2);?>
      <?php	
}
?></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
</tbody>
</table>

<?php
if(!empty($ArrCotizacionProductoPlanchados) or !empty($ArrCotizacionProductoPintados) or !empty($ArrCotizacionProductoCentrados) or !empty($ArrCotizacionProductoTareas)){
	
	$Total = $POST_ManoObra + $TotalRepuesto;
?>



<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="24%" colspan="2" align="left" class="Total"><?php
if($POST_IncluyeImpuesto == 1){
?>
    Los precios	incluyen impuesto
    <?php	
}else{
?>
    Los precios	no incluyen impuesto
    <?php	
}
?></td>
  <td width="65%" align="right" class="Total">Total Repuestos y Mano de Obra:</td>
  <td width="11%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
</tr>
</tbody>
</table>


<?php	
}else{
	
	
if($POST_IncluyeImpuesto == "1"){
	
	$Total = $POST_ManoObra + $TotalRepuesto;
	$SubTotal = $Total / (($POST_PorcentajeImpuestoVenta/100)+1);
	$Impuesto = $Total - $SubTotal;	
	
}else{
	
	$SubTotal = $POST_ManoObra + $TotalRepuesto;
	$Impuesto = $SubTotal * (($POST_PorcentajeImpuestoVenta/100));
	$Total = $SubTotal + $Impuesto;	
	
}
	
	
	
?>


<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="left" >&nbsp;</td>
  <td align="right" class="Total"><?php
if(!empty($TotalDescuento )){
?>
    Descuento (<?php echo number_format($POST_DescuentoPorcentaje,2);?> %):
    <?php	
}
?></td>
  <td align="right"><?php
if(!empty($TotalDescuento )){
?>
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($TotalDescuento,2);?>
    <?php	
}
?></td>
</tr>
<tr>
  <td colspan="2" align="left" class="Total"><?php
if($POST_IncluyeImpuesto == 1){
?>
    Los precios	incluyen impuesto
    <?php	
}else{
?>
    Los precios	no incluyen impuesto
    <?php	
}
?></td>
  <td width="66%" align="right" class="Total">SubTotal:</td>
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

<?php
}
?>