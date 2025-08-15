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
$POST_ManoObra = preg_replace("/,/", "", $_POST['ManoObra']);
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];
$POST_PorcentajeDescuento = preg_replace("/,/", "", $_POST['PorcentajeDescuento']);


session_start();
if (!isset($_SESSION['InsCotizacionProductoDetalle'.$Identificador])){
	$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = new ClsSesionObjeto();	
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
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');


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

?>


<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
    <th width="2%">#</th>
    <th width="2%">Id</th>
    <th width="5%">Cod. Original</th>
    <th width="8%">Cod. Alternativo</th>
    <th width="22%"> Nombre
    </th>
    <th width="6%">Cantidad</th>
    <th width="4%">U.M.</th>
    <th width="4%">Precio</th>
    <th width="5%">Importe</th>
    <th width="5%">Desc.</th>
    <th width="5%">Importe Final</th>
    <th width="8%">Disponible (Lista GM)
    



<?php
	$FechaDisponibilidad = "";
	
	$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades(NULL,NULL,NULL ,"PdiId","ASC","1",1);
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
    <th width="8%">Reemplazo (Lista GM)
      
      
      
      
      <?php

$FechaReemplazo = "";

?>
      
      <?php
	// MtdObtenerProductoReemplazos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {
		
	$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos(NULL,NULL,NULL ,"PreId","ASC","1",1);
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
    <th width="4%">Stk.</th>
    <th width="5%">Pedido</th>
    <th width="4%">Verif.</th>
    <th width="5%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">

<?php
if(!empty($ArrCotizacionProductoDetalles)){
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
//						Parametro16 = 
//						Parametro17 = 
//						Parametro18 = CrdValorVenta
//						Parametro19 = UmeIdOrigen
//						Parametro20 = CrdCosto
//						Parametro21 = CrdEstado
//						Parametro22 = CrdTipoPedido
//						Parametro23 = CrdDescuento
//						Parametro24 = CrdPrecioBruto
    
    $c = 1;
    $TotalBruto = 0;
	$TotalDescuento = 0;
	
    foreach($ArrCotizacionProductoDetalles as $DatCotizacionProductoDetalle){
    ?>
    
    
<?php

///deb($DatCotizacionProductoDetalle->Parametro6);
	$DetallePrecioBruto = 0;
	$DetalleDescuento = 0;
	$DetallePrecio = 0;
	$DetalleImporte = 0;
	
	//if($POST_IncluyeImpuesto == 1){
	//}else{
		
	if(!empty($POST_PorcentajeDescuento)){
		
		$DetallePrecioBruto = ($DatCotizacionProductoDetalle->Parametro24);
		$DetallePrecio = $DetallePrecioBruto;
		$DetalleImporte = ($DetallePrecio * $DatCotizacionProductoDetalle->Parametro5);
			
		$DetallePrecioDescuento =  $DetallePrecio - ($DetallePrecio * ($POST_PorcentajeDescuento/100));
		
		$DetalleDescuento = ($DetalleImporte * ($POST_PorcentajeDescuento/100));
		$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
	
	}else{
	
		$DetallePrecioBruto = ($DatCotizacionProductoDetalle->Parametro24);
		$DetallePrecio = $DetallePrecioBruto;
		$DetalleImporte = ($DetallePrecio * $DatCotizacionProductoDetalle->Parametro5);
		
		$DetallePrecioDescuento =  $DetallePrecio;
		
		$DetalleDescuento = 0;
		$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
	
	}
		
//}


?>
<?php

?>
        
        
        <tr>
        <td align="right">
        <span title="<?php echo $DatCotizacionProductoDetalle->Parametro1;?>">
        <?php echo $c;?>
        </span>
        </td>
        <td align="right"><?php echo $DatCotizacionProductoDetalle->Parametro2;?></td>
        <td align="right">
        
        <?php echo $DatCotizacionProductoDetalle->Parametro13;?>
        
        <a target="_blank" href="principal.php?Mod=Producto&Form=Consulta&ProCodigoOriginal=<?php echo $DatCotizacionProductoDetalle->Parametro13;?>"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Producto]" width="20" height="20" border="0" align="absmiddle" title="Producto " /> </a>
        <a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatCotizacionProductoDetalle->Parametro2;?>"   title=""> <img src="imagenes/almacen_stock.jpg" alt="[Stock]" width="20" height="20" border="0" align="absmiddle" title="Stock" /> </a>
        
        
        </td>
        <td align="right"><?php echo $DatCotizacionProductoDetalle->Parametro14;?></td>
        <td align="left"><?php echo $DatCotizacionProductoDetalle->Parametro3;?></td>
        <td align="right"><?php echo number_format($DatCotizacionProductoDetalle->Parametro5,2);?></td>
        <td align="right"><?php echo $DatCotizacionProductoDetalle->Parametro9;?></td>
        <td align="right"><?php echo number_format($DetallePrecio,2);?></td>
        <td align="right"><?php echo number_format($DetalleImporte,2);?></td>
        <td align="right" bgcolor="#99FF66"><?php echo number_format(($DetalleDescuento),2);?></td>
        <td align="right"><?php echo number_format(($DetalleImporteFinal ),2);?></td>
        
        
        
        <td align="center" bgcolor="#FFFF99">
        
        
        <?php
        
        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatCotizacionProductoDetalle->Parametro13 ,"PdiId","ASC","1",1);
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
         $ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10","esigual",$DatCotizacionProductoDetalle->Parametro13 ,"PreId","ASC",NULL,1);
        $ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
        
        if(!empty($ArrProductoReemplazos)){
              $Reemplazo= "SI";
        }
             
        ?>
        
        <?php echo $Reemplazo;?>
        
        </td>
        <td align="center">
        
        <?php

$InsProducto->ProId = $DatCotizacionProductoDetalle->Parametro2;
$InsProducto->MtdObtenerProducto(false);

$InsUnidadMedida->UmeId = $DatCotizacionProductoDetalle->Parametro10;
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

$CantidadReal = round($DatCotizacionProductoDetalle->Parametro5 * $InsUnidadMedidaConversion->UmcEquivalente,6);

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
?> <a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatCotizacionProductoDetalle->Parametro2;?>">
	EN STOCK     </a>
<?php	
}
?>

(<?php echo number_format($InsProducto->ProStockReal,2);?>)





        
        
        <?php
        
      /*  $InsProducto->ProId = $DatCotizacionProductoDetalle->Parametro2;
        $InsProducto->MtdObtenerProducto(false);
        
        $InsUnidadMedida->UmeId = $DatCotizacionProductoDetalle->Parametro10;
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
        
        $CantidadReal = round($DatCotizacionProductoDetalle->Parametro5 * $InsUnidadMedidaConversion->UmcEquivalente,6);
        
        //deb($InsUnidadMedidaConversion->UmcEquivalente);
        
        //deb($InsProducto->ProStockReal." - ".$CantidadReal);
        
        if($InsProducto->ProStockReal < $CantidadReal){		
            $VerificarStock = 1;
        }
            
        ?>
       
        <?php
        if($VerificarStock == 1){
        ?>
        SIN STOCK
        <?php	
        }else{
        ?>
        EN STOCK
        <?php	
        }*/
        ?>
      
        
        
        </td>
        <td align="right">
	
		
		<?php echo $DatCotizacionProductoDetalle->Parametro22;?>
        
        
        </td>
        <td align="center"><?php
        switch($DatCotizacionProductoDetalle->Parametro21){
            case 1:
        ?>
          Si
          <?php
            break;
            
            case 2:
        ?>
          No
  <?php
            break;
            
            default:
        ?>
          -
  <?php
            break;
        }
        ?></td>
        <td align="center">
          <?php
        if($POST_Editar==1){
        ?>
          <a class="EstSesionObjetosItem" href="javascript:FncCotizacionProductoDetalleEscoger('<?php echo $DatCotizacionProductoDetalle->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/editar.gif" alt="[Editar]" title="Editar" width="15" height="15"  /></a>
          <?php
        }
        ?>
          
          <?php
        if($POST_Eliminar==1){
        ?>
          <a href="javascript:FncCotizacionProductoDetalleEliminar('<?php echo $DatCotizacionProductoDetalle->Item;?>');" >
          <img align="absmiddle" src="imagenes/eliminar.gif" alt="[Eliminar]" title="Eliminar" width="15" height="15" border="0" /></a>
          <?php
        }
        ?>
          
          
        </td>
        </tr>

	<?php
//        $TotalBruto = $TotalBruto + $DatCotizacionProductoDetalle->Parametro6;
		$TotalBruto = $TotalBruto + $DetalleImporteFinal;
		$TotalDescuento = $TotalDescuento + $DetalleDescuento;
		
		
    $c++;
    }
    ?>

<?php
}
?>

<?php
//if(!empty($SubManoObra)){
if(!empty($POST_ManoObra) and $POST_ManoObra <> "0.00"){
	/*
?>


    <tr>
      <td align="right">-</td>
      <td align="right">-</td>
      <td align="right">-</td>
      <td align="right">-</td>
      <td align="right">MANO DE OBRA</td>
      <td align="right">-</td>
        <td align="right">
    
        <?php	// $SubManoObra = ($POST_ManoObra);?>
        <?php	// echo number_format($SubManoObra,2);?>
        <?php	echo number_format($POST_ManoObra,2);?>
    
        </td>
      <td align="right">1.00</td>
      <td align="right"><?php //echo number_format($SubManoObra,2)?>
      <?php	echo number_format($POST_ManoObra,2)?></td>
      <td align="right" bgcolor="#99FF66">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="center" bgcolor="#FFFF99">-</td>
      <td align="center" bgcolor="#FFCC33">-</td>
      <td align="center">-</td>
      <td align="center">&nbsp;</td>
      <td align="center">-</td>
      <td align="center">-</td>
    </tr>

<?php*/	
	$TotalBruto = $TotalBruto + $POST_ManoObra;
}
?>

<?php

$TotalRepuesto = $TotalBruto;
//$TotalDescuento = $TotalDescuento;

/*if(!empty($POST_PorcentajeDescuento)){
	//$TotalDescuento = $TotalBruto * ($POST_PorcentajeDescuento/100);
	$TotalBruto = $TotalBruto - $TotalDescuento;
	
}*/


if($POST_IncluyeImpuesto == 2){
	
	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($POST_PorcentajeImpuestoVenta/100);	
	$Total = $SubTotal + $Impuesto;
	
}else{
	
	$Total = $TotalBruto;
	$SubTotal = $Total / (($POST_PorcentajeImpuestoVenta/100)+1);
	$Impuesto = $Total - $SubTotal;	

}

	//if($POST_IncluyeImpuesto == 1){
//
//		$Total = $TotalBruto;
//		$SubTotal = $Total / (($EmpresaImpuestoVenta/100)+1);
//		$Impuesto = $Total - $SubTotal;	
//		$POST_ManoObra = $POST_ManoObra / (($EmpresaImpuestoVenta/100)+1);
//		
//		if(!empty($POST_PorcentajeDescuento)  and $POST_PorcentajeDescuento <> "" and $POST_PorcentajeDescuento<>"0.00"){
//			
//			$TotalDescuento = ( $SubTotal * ($POST_PorcentajeDescuento / 100) );
//			$SubTotal = $SubTotal - ( $SubTotal * ($POST_PorcentajeDescuento / 100) )  ;
//			$SubTotal = $SubTotal + $POST_ManoObra;
//			$Impuesto = $SubTotal * 0.18;
//			$Total = $SubTotal + $Impuesto;
//			
//		}
//		
//	}else{
//		
//		
//		$SubTotal = $TotalBruto;
//		$Impuesto =  $SubTotal*(($EmpresaImpuestoVenta/100));	
//		$Total = $SubTotal + $Impuesto;
//		
//		if(!empty($POST_PorcentajeDescuento)){
//			
//			$TotalDescuento = ( $SubTotal * ($POST_PorcentajeDescuento / 100) );
//			$SubTotal = $SubTotal - $TotalDescuento;
//			$SubTotal = $SubTotal + $POST_ManoObra;
//			$Impuesto = $SubTotal * 0.18;
//			$Total = $SubTotal + $Impuesto;
//
//		}
//
//		
//	}

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
      <td align="right" bgcolor="#99FF66"><?php
if(!empty($TotalDescuento )){
?>
        <?php echo number_format($TotalDescuento,2);?>
      <?php	
}
?></td>
      <td align="right">&nbsp;</td>
      <td align="center" bgcolor="#FFFF99">&nbsp;</td>
      <td align="center" bgcolor="#FFCC33">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
</tbody>
</table>

<br />
<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="right" class="Total">&nbsp;</td>
  <td align="right" class="Total"><!--Total Repuestos:-->
    <?php
if(!empty($POST_ManoObra) and $POST_ManoObra <> "0.00"){
?> 
Mano de Obra:
<?php	
}
?></td>
  <td align="right"><!--<span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> 
  
  <?php echo number_format($TotalRepuesto,2);?>-->
  
    <?php
if(!empty($POST_ManoObra) and $POST_ManoObra <> "0.00"){
?>
  <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> 
  <?php echo number_format($POST_ManoObra,2);?> 

<?php	
}
?></td>
</tr>
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="left" >&nbsp;</td>
  <td align="right" class="Total"><?php
if(!empty($TotalDescuento )){
?>
    Descuento (<?php echo number_format($POST_PorcentajeDescuento,2);?> %):
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
  <td colspan="2" align="right" class="Total"><?php
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

