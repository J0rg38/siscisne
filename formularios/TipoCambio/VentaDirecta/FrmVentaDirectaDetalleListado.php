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
//$POST_Descuento = $_POST['TotalDescuento'];
$POST_Eliminar = $_POST['Eliminar'];
$POST_Editar = $_POST['Editar'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];
$POST_VerEstado = $_POST['VerEstado'];
$POST_Confirmar = $_POST['Confirmar'];
$POST_PorcentajeDescuento = eregi_replace(",","",$_POST['PorcentajeDescuento']);
$POST_ManoObra = eregi_replace(",","",$_POST['ManoObra']);
$POST_AlmacenId = $_POST['AlmacenId'];

session_start();
if (!isset($_SESSION['InsVentaDirectaDetalle'.$Identificador])){
	$_SESSION['InsVentaDirectaDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');		

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();



$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();



$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();


//						SesionObjeto-VentaDirectaDetalle
//						Parametro1 = VddId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = VddPrecioVenta
//						Parametro5 = VddCantidad
//						Parametro6 = VddImporte
//						Parametro7 = VddTiempoCreacion
//						Parametro8 = VddTiempoModificacion
//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = VddCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo
//						Parametro15 = UmeIdOrigen
//						Parametro16 = VerificarStock
//						Parametro17 = VddCosto
//						Parametro18 = ProStock
//						Parametro19 = ProStockReal
//						Parametro20 = VddCantidadPedir
//						Parametro21 = VddCantidadPedirFecha
//						Parametro22 = CrdId
//						Parametro23 = VddNuevo
//						Parametro24 = VddCantidadPorLlegar
//						Parametro25 = AmdCantidad
//						Parametro26 = VddEstado
//						Parametro27 = VdiId

//						Parametro28 = VddRemplazo
//						Parametro29 = ProIdPedido
//						Parametro30 = ProCodigoOriginalPedido

//						Parametro31 = PcdBOFecha
//						Parametro32 = PcdBOEstado
//						Parametro33 = VddFechaPorLlegar

$RepSesionObjetos = $_SESSION['InsVentaDirectaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

$TotalDescuento = 0;
$SubTotal = 0;
$Impuesto = 0;
$Total = 0;

//deb($ArrSesionObjetos);

$ArrAnulados = array();
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
  <th width="4%">Estado</th>
  <th width="3%">Cod. Orig.</th>


<?php
if($POST_VerEstado <> 1){
?>
  <th width="3%">Cod. Alt.</th>
  
<?php
}
?>

  <th width="26%"> Nombre
</th>
<th width="3%">U.M.</th>
<th width="4%">
  
  Precio</th>


<th width="5%">
  Cantidad</th>
<th width="5%">Importe</th>
<th>Desc.</th>
<th>Importe Final</th>
<?php
if($POST_VerEstado <> 1){
?>
<th width="7%">Disponible (Lista GM)

    
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
<th width="7%">

Reemplazo (Lista GM)

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
<?php
}
?>
<?php
if($POST_VerEstado <> 1){
?>
<th width="7%">Pedido



</th>
<?php
}
?>
<?php
if($POST_VerEstado == 1){
?>
<th width="5%">Cant. Despacho</th>
<th width="4%">Despacho Fecha</th>
<th width="4%">Ord. Comp.</th>
<th width="4%">Ord. Comp. Fecha</th>
<th width="4%">Status GM</th>
<th width="4%">Fec. LLegada GM</th>
<th width="4%">Comprob. Num.</th>
<th width="4%">Fecha Comprob. Num.</th>
<th width="4%">Estado</th>
<th width="4%">Ficha Salida</th>
<th width="4%">Ficha Salida Fecha</th>
<th width="5%">O.T.</th>
<th width="5%">Factura </th>
<th width="5%">Factura Fecha</th>
<?php
}
?>
<th width="7%">Stock</th>
<th width="7%"> Acc.</th>
<?php
if($POST_VerEstado <> 1){
?>
<?php
}
?>

</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$TotalBruto = 0;

foreach($ArrSesionObjetos as $DatSesionObjeto){
	
	$DetallePrecioBruto = 0;
	$DetalleDescuento = 0;
	$DetallePrecio = 0;
	$DetalleImporte = 0;
	
	if(!empty($POST_PorcentajeDescuento)){
		
		$DetallePrecioBruto = ($DatSesionObjeto->Parametro36);
		$DetallePrecio = $DetallePrecioBruto;
		$DetalleImporte = ($DetallePrecio * $DatSesionObjeto->Parametro5);
			
		$DetallePrecioDescuento =  $DetallePrecio - ($DetallePrecio * ($POST_PorcentajeDescuento/100));
		
		$DetalleDescuento = ($DetalleImporte * ($POST_PorcentajeDescuento/100));
		$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
	
	}else{
	
		$DetallePrecioBruto = ($DatSesionObjeto->Parametro36);
		$DetallePrecio = $DetallePrecioBruto;
		$DetalleImporte = ($DetallePrecio * $DatSesionObjeto->Parametro5);
		
		$DetallePrecioDescuento =  $DetallePrecio;
		
		$DetalleDescuento = 0;
		$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
	
	}
	
	
	
	
	if($DatSesionObjeto->Parametro26 == 1 or $DatSesionObjeto->Parametro26 == 7){	
?>


<?php
if($POST_VerEstado == 1){
?>

	<?php
	
	if($DatSesionObjeto->Parametro26 == 1){
	
		if(empty($DatSesionObjeto->Parametro24) and empty($DatSesionObjeto->Parametro25)){
			$fondo = "#F30";//ROJO - NO LLEGO
		
		}else if( ($DatSesionObjeto->Parametro25 >= $DatSesionObjeto->Parametro5)  ){
			$fondo = "#6F3"; // VERDE
			
			}else if( ($DatSesionObjeto->Parametro24 >= $DatSesionObjeto->Parametro5)  ){
			$fondo = "#09C"; // AZUL
		
		}else if($DatSesionObjeto->Parametro24 < $DatSesionObjeto->Parametro5){
			$fondo = "#FC0";//NARAJA - LLEGADA PARCIAL		
		}else{
			$fondo = "";	
		}
		
	}else{
		$fondo = "";	
	}
	?>
    
<?php

}else{
	
	$fondo = "";	
}
?>
<tr>
<td align="right"  bgcolor="<?php echo $fondo;?>"><span title="<?php echo $DatSesionObjeto->Parametro1;?>"><?php echo $c;?></span>

</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">
  
  <?php echo $DatSesionObjeto->Parametro2;?>
</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">


<?php
switch($DatSesionObjeto->Parametro26){
	case 1:
?>
CONSIDERAR
<?php
	break;
	
	case 2:
?>
  ANULADO
  <?php
	break;


	case 3:
?>
  INTERNO
  <?php
	break;
	
	
	case 4:
?>
  DEVOLUCION
  <?php
	break;

	case 5:
?>
  DAÑADO
  <?php
	break;
	
	case 7:
?>
  FACTURADO
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
<td align="right"  bgcolor="<?php echo $fondo;?>">
  
  
 <a href="javascript:FncProductoConsultarCargar('<?php echo trim($DatSesionObjeto->Parametro2);?>');"><?php echo $DatSesionObjeto->Parametro13;?></a>



<?php
if($DatSesionObjeto->Parametro28 == "Si"){
?><br>
(<?php echo $DatSesionObjeto->Parametro30;?>)
<?php	
}
?>

<!--<a target="_blank" href="principal.php?Mod=Producto&Form=Consulta&ProCodigoOriginal=<?php echo $DatSesionObjeto->Parametro13;?>"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Producto]" width="20" height="20" border="0" align="absmiddle" title="Producto " /> </a>
<a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatSesionObjeto->Parametro2;?>"   title=""> <img src="imagenes/almacen_stock.jpg" alt="[Stock]" width="20" height="20" border="0" align="absmiddle" title="Stock" /> </a>
-->
  
  
</td>

<?php
if($POST_VerEstado <> 1){
?>
<td align="right"  bgcolor="<?php echo $fondo;?>">

	
        <?php echo $DatSesionObjeto->Parametro14;?>
  

</td>
<?php
}
?>
<td align="center"  bgcolor="<?php echo $fondo;?>">


        <?php echo $DatSesionObjeto->Parametro3;?>
  

</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">


		<?php echo $DatSesionObjeto->Parametro9;?>
   

</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">
  

	<?php echo number_format(($DetallePrecio),2);?>

  

</td>

<td align="right"  bgcolor="<?php echo $fondo;?>">

	
		<?php echo number_format($DatSesionObjeto->Parametro5,2);?>
   
  <br />
<span class="EstFormularioSubEtiqueta">
(<?php echo number_format($DatSesionObjeto->Parametro12,3);?>)
</span>
  
   <!--(<?php echo number_format($DatSesionObjeto->Parametro12,3);?>)-->
</td>
<td align="right"  bgcolor="<?php echo $fondo;?>"><?php echo number_format($DetalleImporte,2);?></td>
<td align="right"  bgcolor="#99FF66"><?php echo number_format(($DetalleDescuento),2);?></td>
<td align="right"  bgcolor="<?php echo $fondo;?>"><?php echo number_format(($DetalleImporteFinal ),2);?></td>

<?php
if($POST_VerEstado <> 1){
?>
<td align="center" bgcolor="#FFFF99">

<?php
$Disponibilidad = "";

if(!empty($DatSesionObjeto->Parametro13)){

	$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",trim($DatSesionObjeto->Parametro13) ,"PdiId","ASC","1",1);
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
}
?>


<?php echo $Disponibilidad;?> (<?php echo number_format($Cantidad,2);?>)

</td>
<td align="center" bgcolor="#FFCC33">

<?php

$Reemplazo = "";

if(!empty($DatSesionObjeto->Parametro13)){
?>

	<?php
    $Reemplazo = "NO";
     $ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10","esigual",trim($DatSesionObjeto->Parametro13) ,"PreId","ASC",NULL,1);
    $ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
    
    if(!empty($ArrProductoReemplazos)){
          $Reemplazo= "SI";
    }
         
    ?>

<?php
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

<?php
}
?>

<?php
if($POST_VerEstado <> 1){
?>
<td align="center">
<?php echo $DatSesionObjeto->Parametro35;?>
</td>

<?php
}
?>


<?php
if($POST_VerEstado == 1){
?>

	<?php
	/*if(empty($DatSesionObjeto->Parametro24)){
		$fondo = "#FF0000";
	}else if($DatSesionObjeto->Parametro24 >= $DatSesionObjeto->Parametro5){
		$fondo = "#00CC33";
	}else if($DatSesionObjeto->Parametro24 < $DatSesionObjeto->Parametro5){
		$fondo = "#FF6600";		
	}else{
		$fondo = "#FFFFFF";	
	}*/
	?>
    
	<td align="center" >
    
    <?php
	//if($DatSesionObjeto->Parametro24>$DatSesionObjeto->Parametro5){
	?>
    
    <?php
	echo number_format($DatSesionObjeto->Parametro24,2);
	?>
    
    <?php	
	//}
	?>
    </td>
	<td align="center"> 
    <?php
	echo ($DatSesionObjeto->Parametro33);
	?></td>
	<td align="center">

<?php
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
///MtdObtenerPedidoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL)
$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1,3);
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];
//MtdObtenerVentaConcretadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL)
?>
	  <?php
if(!empty($ArrPedidoCompraDetalles)){
	foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
?>
	  <a href="javascript:FncOrdenCompraVistaPreliminar('<?php echo $DatPedidoCompraDetalle->OcoId;?>')"><?php echo $DatPedidoCompraDetalle->OcoId;?></a>
	  <?php	
	}	
}
?></td>
	<td align="center">
    
    
    <?php
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1,3);
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];
?>
	  <?php
if(!empty($ArrPedidoCompraDetalles)){
	foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
?>
	  <?php echo $DatPedidoCompraDetalle->OcoFecha;?>
	  <?php	
	}	
}
?>

</td>
	<td align="center" bgcolor="#BBEEFF"><?php echo $DatSesionObjeto->Parametro32;?></td>
	<td align="center" bgcolor="#BBEEFF"><?php echo $DatSesionObjeto->Parametro31;?></td>
	<td align="center">
    
<?php
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
											//$InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL);
$ResAlmacenMovimientoEntradaDetalle  = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmdId','Desc',1,"1",NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,$DatSesionObjeto->Parametro1);
$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];


?>

<?php
if(!empty($ArrAlmacenMovimientoEntradaDetalles)){
	foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
?>

<a href="javascript:FncAlmacenMovimientoEntradaVistaPreliminar('<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId;?>')">
<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteNumero;?>
</a>
	  <?php
	}
}
?>
      
    </td>
	<td align="center">
<?php
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
//$InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL);
$ResAlmacenMovimientoEntradaDetalle  = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmdId','Desc',1,"1",NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,$DatSesionObjeto->Parametro1);
$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];
?>

<?php
if(!empty($ArrAlmacenMovimientoEntradaDetalles)){
	foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
?>
	<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteFecha;?>
<?php
	}
}
?>

</td>
<td align="center">
    
    
			<?php
			switch($DatSesionObjeto->Parametro34){
				case 1:
			?>
            	No Llego
            <?php	
				break;
				
				case 2:
			?>
            Da&ntilde;ado
            <?php	
				break;
				
				case 3:
			?>
            Conforme
            <?php	
				break;
			}
			?>
            
   
                
</td>
<td align="center">

	<?php
    $VentaConcretadaId = "";
    $VentaConcretadaFecha = "";
    $VentaConcretadaRevisar = false;
    ?>
    
    <?php
    $InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
//MtdObtenerVentaConcretadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL,$oVentaConcretadaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL)
    $ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmdId','Desc',NULL,NULL,"3",NULL,$DatSesionObjeto->Parametro1,NULL);//revisar estados
    $ArrVentaConcretadaDetalles = $ResVentaConcretadaDetalle['Datos'];
	
//	deb($ArrVentaConcretadaDetalles );
    ?>
    
    <?php
    if(!empty($ArrVentaConcretadaDetalles)){
        foreach($ArrVentaConcretadaDetalles as $DatVentaConcretadaDetalle){
    ?>
    
        <?php
        $VentaConcretadaId = $DatVentaConcretadaDetalle->VcoId;
        $VentaConcretadaFecha = $DatVentaConcretadaDetalle->VcoFecha;
        ?>
    
        <a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $VentaConcretadaId;?>')">
        <?php echo $VentaConcretadaId;?> 
        </a>
    
    <?php
        }
    }
    ?>
        
     
     
        


    <?php
	/*if($VentaConcretadaRevisar){
	?>
	    <span title="Revisar">[R]</span>    
    <?php	
	}*/
	?>

<?php
//MtdObtenerTallerPedidoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVentaDirectaDetalle=NULL)

$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();
$ResTallerPedidoDetalle = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetalles(NULL,NULL,NULL,'AmdId','Desc',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1);
$ArrTallerPedidoDetalles = $ResTallerPedidoDetalle['Datos'];

?>

 
     <?php
    if(!empty($ArrTallerPedidoDetalles)){
        foreach($ArrTallerPedidoDetalles as $DatTallerPedidoDetalle){
    ?>
    
        <?php
        $TallerPedidoId = $DatTallerPedidoDetalle->AmoId;
        $TallerPedidoFecha = $DatTallerPedidoDetalle->AmoFecha;
        ?>
    
        <a href="javascript:FncTallerPedidoVistaPreliminar('<?php echo $TallerPedidoId;?>')">
        <?php echo $TallerPedidoId;?> 
        </a>
    
    <?php
        }
    }
    ?>
 

	  </td>
	<td align="center">
	
<?php
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
$ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmdId','Desc',NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1,3);
$ArrVentaConcretadaDetalles = $ResVentaConcretadaDetalle['Datos'];
?>

<?php
if(!empty($ArrVentaConcretadaDetalles)){
	foreach($ArrVentaConcretadaDetalles as $DatVentaConcretadaDetalle){
?>

	<?php
	$VentaConcretadaId = $DatVentaConcretadaDetalle->VcoId;
	$VentaConcretadaFecha = $DatVentaConcretadaDetalle->VcoFecha;
	?>
	
	<?php echo $VentaConcretadaFecha;?> 
    
<?php
	}
}
?>

<?php //echo $VentaConcretadaFecha;?> 



<?php
//MtdObtenerTallerPedidoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVentaDirectaDetalle=NULL)

$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();
$ResTallerPedidoDetalle = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetalles(NULL,NULL,NULL,'AmdId','Desc',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1);
$ArrTallerPedidoDetalles = $ResTallerPedidoDetalle['Datos'];

?>

 
     <?php
    if(!empty($ArrTallerPedidoDetalles)){
        foreach($ArrTallerPedidoDetalles as $DatTallerPedidoDetalle){
    ?>
    
        <?php
        $TallerPedidoId = $DatTallerPedidoDetalle->AmoId;
        $TallerPedidoFecha = $DatTallerPedidoDetalle->AmoFecha;
        ?>
    
      
        <?php echo $TallerPedidoFecha;?> 
      
    
    <?php
        }
    }
    ?>
    
    
</td>
	<td align="center">
    

     
     
        

<?php
//MtdObtenerTallerPedidoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVentaDirectaDetalle=NULL)

$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();
$ResTallerPedidoDetalle = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetalles(NULL,NULL,NULL,'AmdId','Desc',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1);
$ArrTallerPedidoDetalles = $ResTallerPedidoDetalle['Datos'];

?>

 
     <?php
    if(!empty($ArrTallerPedidoDetalles)){
        foreach($ArrTallerPedidoDetalles as $DatTallerPedidoDetalle){
    ?>
    
        <?php
        $TallerPedidoId = $DatTallerPedidoDetalle->AmoId;
        $TallerPedidoFecha = $DatTallerPedidoDetalle->AmoFecha;
		$FichaIngresoId = $DatTallerPedidoDetalle->FinId;
        ?>
    
        <a href="javascript:FncFichaIngresoVistaPreliminar('<?php echo $FichaIngresoId;?>')">
        <?php echo $FichaIngresoId;?> 
        </a>
    
    <?php
        }
    }
    ?>
    
    </td>
	<td align="center">


<?php
$FacturaId = "";
$FacturaTalonarioId = "";
$FacturaFecha = "";
$FacturaTalonarioNumero = "";
$FacturaRevisar = false;
?>

    
<?php
$InsFacturaDetalle = new ClsFacturaDetalle();
$ResFacturaDetalle = $InsFacturaDetalle->MtdObtenerFacturaDetalles(NULL,NULL,'FdeId','Desc',NULL,NULL,NULL,NULL,5,$DatSesionObjeto->Parametro1);
$ArrFacturaDetalles = $ResFacturaDetalle['Datos'];
?>

<?php
if(!empty($ArrFacturaDetalles)){
	foreach($ArrFacturaDetalles as $DatFacturaDetalle){
?>
		<?php
		$FacturaId = $DatFacturaDetalle->FacId;
		$FacturaTalonarioId = $DatFacturaDetalle->FtaId;
		$FacturaFecha = $DatFacturaDetalle->FacFechaEmision;
		$FacturaTalonarioNumero = $DatFacturaDetalle->FtaNumero;
		?>
        
                        
<a href="javascript:FncFacturaVistaPreliminar('<?php echo $FacturaId;?>','<?php echo $FacturaTalonarioId;?>')">
<?php echo $FacturaTalonarioNumero;?> - <?php echo $FacturaId;?> 
</a>


        
<?php
	}
}
?>




<?php
$BoletaId = "";
$BoletaTalonarioId = "";
$BoletaFecha = "";
$BoletaTalonarioNumero = "";
$BoletaRevisar = false;
?>


<?php
$InsBoletaDetalle = new ClsBoletaDetalle();
$ResBoletaDetalle = $InsBoletaDetalle->MtdObtenerBoletaDetalles(NULL,NULL,'BdeId','Desc',NULL,NULL,NULL,NULL,5,$DatSesionObjeto->Parametro1);
$ArrBoletaDetalles = $ResBoletaDetalle['Datos'];
?>

<?php
if(!empty($ArrBoletaDetalles)){
	foreach($ArrBoletaDetalles as $DatBoletaDetalle){
?>
		<?php
		$BoletaId = $DatBoletaDetalle->BolId;
		$BoletaTalonarioId = $DatBoletaDetalle->BtaId;
		$BoletaFecha = $DatBoletaDetalle->BolFechaEmision;
		$BoletaTalonarioNumero = $DatBoletaDetalle->BtaNumero;
		?>
        
        
        <a href="javascript:FncBoletaVistaPreliminar('<?php echo $BoletaId;?>','<?php echo $BoletaTalonarioId;?>')">
			<?php echo $BoletaTalonarioNumero;?> - <?php echo $BoletaId;?>
            
          
		</a>

<?php
	}
}
?>

		
</td>
	<td align="center">




<?php
$FacturaId = "";
$FacturaTalonarioId = "";
$FacturaFecha = "";
$FacturaTalonarioNumero = "";
$FacturaRevisar = false;
?>

    
<?php
$InsFacturaDetalle = new ClsFacturaDetalle();
$ResFacturaDetalle = $InsFacturaDetalle->MtdObtenerFacturaDetalles(NULL,NULL,'FdeId','Desc',NULL,NULL,NULL,NULL,5,$DatSesionObjeto->Parametro1);
$ArrFacturaDetalles = $ResFacturaDetalle['Datos'];
?>

<?php
if(!empty($ArrFacturaDetalles)){
	foreach($ArrFacturaDetalles as $DatFacturaDetalle){
?>
		<?php
		$FacturaId = $DatFacturaDetalle->FacId;
		$FacturaTalonarioId = $DatFacturaDetalle->FtaId;
		$FacturaFecha = $DatFacturaDetalle->FacFechaEmision;
		$FacturaTalonarioNumero = $DatFacturaDetalle->FtaNumero;
		?>
        
                        
			<?php echo $FacturaFecha;?>

        
<?php
	}
}
?>




<?php
$BoletaId = "";
$BoletaTalonarioId = "";
$BoletaFecha = "";
$BoletaTalonarioNumero = "";
$BoletaRevisar = false;
?>


<?php
$InsBoletaDetalle = new ClsBoletaDetalle();
$ResBoletaDetalle = $InsBoletaDetalle->MtdObtenerBoletaDetalles(NULL,NULL,'BdeId','Desc',NULL,NULL,NULL,NULL,5,$DatSesionObjeto->Parametro1);
$ArrBoletaDetalles = $ResBoletaDetalle['Datos'];
?>

<?php
if(!empty($ArrBoletaDetalles)){
	foreach($ArrBoletaDetalles as $DatBoletaDetalle){
?>
		<?php
		$BoletaId = $DatBoletaDetalle->BolId;
		$BoletaTalonarioId = $DatBoletaDetalle->BtaId;
		$BoletaFecha = $DatBoletaDetalle->BolFechaEmision;
		$BoletaTalonarioNumero = $DatBoletaDetalle->BtaNumero;
		?>
        
        
    <?php echo $BoletaFecha;?>

<?php
	}
}
?>


</td>
	<?php
}
?>

<td align="center">

<?php


$StockReal = 0;

$InsAlmacenProducto = new ClsAlmacenProducto();
//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($DatSesionObjeto->Parametro2,$POST_AlmacenId,date("Y"));
//deb($DatSesionObjeto->Parametro2);
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
  
  
</td>
<td align="center"><?php

if($POST_Editar==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncVentaDirectaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  <?php
//if($_POST['Eliminar']==1 and empty($DatSesionObjeto->Parametro22)){
if($POST_Eliminar==1){
?>
  <a href="javascript:FncVentaDirectaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?></td>
<?php
if($POST_VerEstado <> 1){
?>
<?php
}
?>
</tr>
<?php
	
//		$TotalBruto += $DatSesionObjeto->Parametro6;			
		$TotalBruto = $TotalBruto + $DetalleImporteFinal;	
		$TotalDescuento = $TotalDescuento + $DetalleDescuento;
		
	}else{
		$ArrAnulados[] = $DatSesionObjeto;
	}
	

$c++;
}

if(!empty($POST_ManoObra) and $POST_ManoObra <> "0.00"){

	$TotalBruto = $TotalBruto + $POST_ManoObra;
}

$TotalRepuesto = $TotalBruto;

//if(!empty($POST_PorcentajeDescuento)){
//	$TotalDescuento = $TotalBruto * ($POST_PorcentajeDescuento/100);
//	$TotalBruto = $TotalBruto - $TotalDescuento;
//}

if($POST_IncluyeImpuesto == 2){
	
	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($POST_PorcentajeImpuestoVenta/100);	
	$Total = $SubTotal + $Impuesto;
	
}else{
	
	$Total = $TotalBruto;
	$SubTotal = $Total / (($POST_PorcentajeImpuestoVenta/100)+1);
	$Impuesto = $Total - $SubTotal;	

}

//	if($POST_IncluyeImpuesto == 1){
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
//	}


?>
</tbody>
</table>
<br />
<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" >&nbsp;</td>
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
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($POST_ManoObra,2);?>
    <?php	
}
?></td>
  </tr>
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" >&nbsp;</td>
  <td align="right" class="Total">
  
  <?php
if(!empty($TotalDescuento )){
?>
Descuento (<?php echo number_format($POST_PorcentajeDescuento,2);?> %):
<?php	
}
?></td>
  <td align="right"><span class="EstMonedaSimbolo">
  
  <?php
if(!empty($TotalDescuento )){
?>
  <?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($TotalDescuento,2);?>
  <?php	
}
?>
  
  </td>
  </tr>
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="left" >&nbsp;</td>
  <td width="61%" align="right" class="Total">SubTotal:</td>
  <td width="15%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($SubTotal,2);?></td>
</tr>
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" >&nbsp;</td>
  <td align="right" class="Total">Impuesto (<?php echo $POST_PorcentajeImpuestoVenta;?>%):</td>
  <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Impuesto,2);?></td>
</tr>
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" >&nbsp;</td>
  <td align="right" class="Total">Total:</td>
  <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
</tr>

</tbody>
</table>

<?php
}
?>

<?php
if(!empty($ArrAnulados)){
?>
<br />

OTROS ITEMS ANULADOS<br /><br />

<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%">#</th>
  <th width="2%">Id</th>
  <th width="4%">Estado</th>
  <th width="3%">Cod. Orig.</th>
  <th width="3%">Cod. Alt.</th>
  <th width="26%"> Nombre
</th>
<th width="3%">U.M.</th>
<th width="4%">
  
  Precio</th>


<th width="5%">
  Cantidad</th>
<th width="5%">
  Importe</th>

<?php
if($POST_VerEstado <> 1){
?>
<?php
}
?>
<?php
if($POST_VerEstado <> 1){
?>
<?php
}
?>
<?php
if($POST_VerEstado == 1){
?>
<th width="5%">Cant. Despacho</th>
<th width="4%">Despacho Fecha</th>
<th width="4%">Ord. Comp.</th>
<th width="4%">Ord. Comp. Fecha</th>
<th width="4%">Status GM</th>
<th width="4%">Fec. LLegada GM</th>
<th width="4%">Comprob. Num.</th>
<th width="4%">Fecha Comprob. Num.</th>
<th>Ficha Salida</th>
<th>Ficha Salida Fecha</th>
<th width="5%">Factura </th>
<th width="5%">Factura Fecha</th>
<?php
}
?>
<th width="4%">Stock</th>
<th width="7%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;


foreach($ArrAnulados as $DatSesionObjeto){
	
	//if($DatSesionObjeto->Parametro26 <> 1){	
?>


<?php
if($POST_VerEstado == 1){
?>

	<?php
	
	if($DatSesionObjeto->Parametro26 == 1){
	
		if(empty($DatSesionObjeto->Parametro24) and empty($DatSesionObjeto->Parametro25)){
			$fondo = "#F30";//ROJO - NO LLEGO
		}else if( ($DatSesionObjeto->Parametro24 >= $DatSesionObjeto->Parametro5) or ($DatSesionObjeto->Parametro25 >= $DatSesionObjeto->Parametro5)  ){
			$fondo = "#6F3"; // VERDE
		}else if($DatSesionObjeto->Parametro24 < $DatSesionObjeto->Parametro5){
			$fondo = "#FC0";//NARAJA - LLEGADA PARCIAL		
		}else{
			$fondo = "";	
		}
		
	}else{
		$fondo = "";	
	}
	?>
    
<?php

}else{
	
	$fondo = "";	
}
?>
<tr>
<td align="right"  bgcolor="<?php echo $fondo;?>"><span title="<?php echo $DatSesionObjeto->Parametro1;?>"><?php echo $c;?></span>

</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">
  
  <?php echo $DatSesionObjeto->Parametro2;?>
</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">


<?php
switch($DatSesionObjeto->Parametro26){
	case 1:
?>
CONSIDERAR
<?php
	break;
	
	case 2:
?>
  ANULADO
  <?php
	break;


	case 3:
?>
  INTERNO
  <?php
	break;
	
	
	case 4:
?>
  DEVOLUCION
  <?php
	break;
	
	case 5:
?>
  DAÑADO
  <?php
	break;
	
	case 7:
?>
  FACTURADO
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
<td align="right"  bgcolor="<?php echo $fondo;?>">
  
  
  
  <?php echo $DatSesionObjeto->Parametro13;?>
<?php
if($DatSesionObjeto->Parametro28 == "Si"){
?><br>
(<?php echo $DatSesionObjeto->Parametro30;?>)
<?php	
}
?>
<a target="_blank" href="principal.php?Mod=Producto&Form=Consulta&ProCodigoOriginal=<?php echo $DatSesionObjeto->Parametro13;?>"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Producto]" width="20" height="20" border="0" align="absmiddle" title="Producto " /> </a>
<a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatSesionObjeto->Parametro2;?>"   title=""> <img src="imagenes/almacen_stock.jpg" alt="[Stock]" width="20" height="20" border="0" align="absmiddle" title="Stock" /> </a>

 
  
  
</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">

	
        <?php echo $DatSesionObjeto->Parametro14;?>
  

</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">


        <?php echo $DatSesionObjeto->Parametro3;?>
  

</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">


		<?php echo $DatSesionObjeto->Parametro9;?>
   

</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">
  

	<?php echo number_format(($DatSesionObjeto->Parametro4),2);?>

  
</td>

<td align="right"  bgcolor="<?php echo $fondo;?>">

	
		<?php echo number_format($DatSesionObjeto->Parametro5,2);?>
     <br />
<span class="EstFormularioSubEtiqueta">
  (<?php echo number_format($DatSesionObjeto->Parametro12,3);?>)
  </span>
  
   <!--(<?php echo number_format($DatSesionObjeto->Parametro12,3);?>)-->
</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">
  <?php echo number_format($DatSesionObjeto->Parametro6,2);?>
  
  <?php
  $DatSesionObjeto->Parametro6 = round($DatSesionObjeto->Parametro6,2);
  ?>
  
</td>

<?php
if($POST_VerEstado <> 1){
?>
<?php
}
?>

<?php
if($POST_VerEstado <> 1){
?>
<?php
}
?>


<?php
if($POST_VerEstado == 1){
?>

	<?php
	/*if(empty($DatSesionObjeto->Parametro24)){
		$fondo = "#FF0000";
	}else if($DatSesionObjeto->Parametro24 >= $DatSesionObjeto->Parametro5){
		$fondo = "#00CC33";
	}else if($DatSesionObjeto->Parametro24 < $DatSesionObjeto->Parametro5){
		$fondo = "#FF6600";		
	}else{
		$fondo = "#FFFFFF";	
	}*/
	?>
    
	<td align="center" >
    
    <?php
	//if($DatSesionObjeto->Parametro24>$DatSesionObjeto->Parametro5){
	?>
    
    <?php
	echo number_format($DatSesionObjeto->Parametro24,2);
	?>
    
    <?php	
	//}
	?>
    </td>
	<td align="center"><?php
	echo ($DatSesionObjeto->Parametro33);
	?></td>
	<td align="center">
	  
  <?php
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
///MtdObtenerPedidoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL)
$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1,3);
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];
//MtdObtenerVentaConcretadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL)
?>
	  <?php
if(!empty($ArrPedidoCompraDetalles)){
	foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
?>
	  <a href="javascript:FncOrdenCompraVistaPreliminar('<?php echo $DatPedidoCompraDetalle->OcoId;?>')"><?php echo $DatPedidoCompraDetalle->OcoId;?></a>
	  <?php	
	}	
}
?></td>
	<td align="center">
    
    
    <?php
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1,3);
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];
?>
	  <?php
if(!empty($ArrPedidoCompraDetalles)){
	foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
?>
	  <?php echo $DatPedidoCompraDetalle->OcoFecha;?>
	  <?php	
	}	
}
?>

</td>
	<td align="center" bgcolor="#BBEEFF"><?php echo $DatSesionObjeto->Parametro32;?></td>
	<td align="center" bgcolor="#BBEEFF"><?php echo $DatSesionObjeto->Parametro31;?></td>
	<td align="center">
    
<?php
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
											//$InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL);
$ResAlmacenMovimientoEntradaDetalle  = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmdId','Desc',1,"1",NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,$DatSesionObjeto->Parametro1);
$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];


?>

<?php
if(!empty($ArrAlmacenMovimientoEntradaDetalles)){
	foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
?>

<a href="javascript:FncAlmacenMovimientoEntradaVistaPreliminar('<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId;?>')">
<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteNumero;?>
</a>
	  <?php
	}
}
?>
      
    </td>
	<td align="center">
  <?php
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
											//$InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL);
$ResAlmacenMovimientoEntradaDetalle  = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmdId','Desc',1,"1",NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,$DatSesionObjeto->Parametro1);
$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];

?>
	  
  <?php
if(!empty($ArrAlmacenMovimientoEntradaDetalles)){
	foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
?>
	  <?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteFecha;?>
  <?php
	}
}
?>
	  
	  </td>
	<td align="center">
	
<?php
$VentaConcretadaId = "";
$VentaConcretadaFecha = "";
$VentaConcretadaRevisar = false;
?>

<?php
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
$ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmdId','Desc',NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1,3);
$ArrVentaConcretadaDetalles = $ResVentaConcretadaDetalle['Datos'];

?>
	  <?php
if(!empty($ArrVentaConcretadaDetalles)){
	foreach($ArrVentaConcretadaDetalles as $DatVentaConcretadaDetalle){
?>
	  <?php
	$VentaConcretadaId = $DatVentaConcretadaDetalle->AmoId;
	$VentaConcretadaFecha = $DatVentaConcretadaDetalle->AmoFecha;
	?>
	  <a href="javascript:FncVentaConcretadaVistaPreliminar('<?php echo $VentaConcretadaId;?>')"> <?php echo $VentaConcretadaId;?> </a>
	  <?php
	}
}
?>
	  <?php
	/*if($VentaConcretadaRevisar){
	?>
	    <span title="Revisar">[R]</span>    
    <?php	
	}*/
	?></td>
	<td align="center">
	
	
	<?php
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();
$ResVentaConcretadaDetalle = $InsVentaConcretadaDetalle->MtdObtenerVentaConcretadaDetalles(NULL,NULL,'AmdId','Desc',NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1,3);
$ArrVentaConcretadaDetalles = $ResVentaConcretadaDetalle['Datos'];

?>
      <?php
if(!empty($ArrVentaConcretadaDetalles)){
	foreach($ArrVentaConcretadaDetalles as $DatVentaConcretadaDetalle){
?>
      <?php
	$VentaConcretadaId = $DatVentaConcretadaDetalle->AmoId;
	$VentaConcretadaFecha = $DatVentaConcretadaDetalle->AmoFecha;
	?>
      <?php echo $VentaConcretadaFecha;?>
      <?php
	}
}
?>

<?php
$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle();
// MtdObtenerTallerPedidoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVentaDirectaDetalle=NULL)
$ResTallerPedidoDetalle = $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetalles(NULL,NULL,NULL,'AmdId','Desc',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,$DatSesionObjeto->Parametro1);
$ArrTallerPedidoDetalles = $ResTallerPedidoDetalle['Datos'];
?>

      <?php
if(!empty($ArrTallerPedidoDetalles)){
	foreach($ArrTallerPedidoDetalles as $DatTallerPedidoDetalle){
?>
      <?php
	$TallerPedidoId = $DatTallerPedidoDetalle->AmoId;
	$TallerPedidoFecha = $DatTallerPedidoDetalle->AmoFecha;
	?>
      <?php echo $TallerPedidoFecha;?>
      <?php
	}
}
?>

      <?php //echo $VentaConcretadaFecha;?>
      
      
      
      </td>
	<td align="center">


<?php
$FacturaId = "";
$FacturaTalonarioId = "";
$FacturaFecha = "";
$FacturaTalonarioNumero = "";
$FacturaRevisar = false;
?>

    
<?php
$InsFacturaDetalle = new ClsFacturaDetalle();
$ResFacturaDetalle = $InsFacturaDetalle->MtdObtenerFacturaDetalles(NULL,NULL,'FdeId','Desc',NULL,NULL,NULL,NULL,5,$DatSesionObjeto->Parametro1);
$ArrFacturaDetalles = $ResFacturaDetalle['Datos'];
?>

<?php
if(!empty($ArrFacturaDetalles)){
	foreach($ArrFacturaDetalles as $DatFacturaDetalle){
?>
		<?php
		$FacturaId = $DatFacturaDetalle->FacId;
		$FacturaTalonarioId = $DatFacturaDetalle->FtaId;
		$FacturaFecha = $DatFacturaDetalle->FacFechaEmision;
		$FacturaTalonarioNumero = $DatFacturaDetalle->FtaNumero;
		?>
        
                        
<a href="javascript:FncFacturaVistaPreliminar('<?php echo $FacturaId;?>','<?php echo $FacturaTalonarioId;?>')">
<?php echo $FacturaTalonarioNumero;?> - <?php echo $FacturaId;?> 
</a>

<?php
/*if($FacturaRevisar){
?>
	<span title="Revisar">[R]</span>
<?php
}*/
?>

        
<?php
	}
}/*else{//PARA REGISTROS ANTIGUOS
?>

    <?php
    $InsVentaConcretada = new ClsVentaConcretada();
    $ResVentaConcretada = $InsVentaConcretada->MtdObtenerVentaConcretadas(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"3",0,0,0,$DatSesionObjeto->Parametro27,NULL);
    $ArrVentaConcretadas = $ResVentaConcretada['Datos'];
    ?>

    <?php
	
	if(!empty($ArrVentaConcretadas)){
    	foreach($ArrVentaConcretadas as $DatVentaConcretada){
    ?>
    		 
			<?php
			$InsFactura = new ClsFactura();
			$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,'FacId','Desc',NULL,NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaConcretada->VcoId,NULL,NULL,NULL,NULL);
			$ArrFacturas = $ResFactura['Datos'];
			
			
			?>
			
            <?php
			if(!empty($ArrFacturas)){
				foreach($ArrFacturas as $DatFactura){
			?>
            
                <?php
				$FacturaId = $DatFactura->FacId;				
				$FacturaTalonarioId = $DatFactura->FtaId;
				$FacturaFecha = $DatFactura->FacFechaEmision;
				$FacturaTalonarioNumero = $DatFactura->FtaNumero;
				
				$FacturaRevisar = true;
				?>

                
                <a href="javascript:FncFacturaVistaPreliminar('<?php echo $FacturaId;?>','<?php echo $FacturaTalonarioId;?>')">
                <?php echo $FacturaTalonarioNumero;?> - <?php echo $FacturaId;?> 
                </a>
                
                    <?php
                    if($FacturaRevisar){
                    ?>
                    <span title="Revisar">[R]</span>
                    <?php
                    }
                    ?>
    <br />
    
            <?php	
				}
			}
			?>        
        
        
    <?php
	    }
	}
    ?>


<?php	
}*/
?>




<?php
$BoletaId = "";
$BoletaTalonarioId = "";
$BoletaFecha = "";
$BoletaTalonarioNumero = "";
$BoletaRevisar = false;
?>


<?php
$InsBoletaDetalle = new ClsBoletaDetalle();
$ResBoletaDetalle = $InsBoletaDetalle->MtdObtenerBoletaDetalles(NULL,NULL,'BdeId','Desc',NULL,NULL,NULL,NULL,5,$DatSesionObjeto->Parametro1);
$ArrBoletaDetalles = $ResBoletaDetalle['Datos'];
?>

<?php
if(!empty($ArrBoletaDetalles)){
	foreach($ArrBoletaDetalles as $DatBoletaDetalle){
?>
		<?php
		$BoletaId = $DatBoletaDetalle->BolId;
		$BoletaTalonarioId = $DatBoletaDetalle->BtaId;
		$BoletaFecha = $DatBoletaDetalle->BolFechaEmision;
		$BoletaTalonarioNumero = $DatBoletaDetalle->BtaNumero;
		?>
        
        
        <a href="javascript:FncBoletaVistaPreliminar('<?php echo $BoletaId;?>','<?php echo $BoletaTalonarioId;?>')">
			<?php echo $BoletaTalonarioNumero;?> - <?php echo $BoletaId;?>
            
          
		</a>

  <?php /*
			if($BoletaRevisar){
			?>
				<span title="Revisar">[R]</span>
            <?php	
			}*/
			?>

<?php
	}
}/*else{
?>

	<?php
    $InsVentaConcretada = new ClsVentaConcretada();
    $ResVentaConcretada = $InsVentaConcretada->MtdObtenerVentaConcretadas(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"3",0,0,0,$DatSesionObjeto->Parametro27,NULL);
    $ArrVentaConcretadas = $ResVentaConcretada['Datos'];
    ?>
    
    <?php
	if(!empty($ArrVentaConcretadas)){
    	foreach($ArrVentaConcretadas as $DatVentaConcretada){
    ?>
    		
			<?php
			$InsBoleta = new ClsBoleta();
//MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL) {
			$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,'BolId','Desc',NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,$DatVentaConcretada->VcoId,NULL);
			$ArrBoletas = $ResBoleta['Datos'];
			?>
			
            <?php
			if(!empty($ArrBoletas)){
				foreach($ArrBoletas as $DatBoleta){
			?>

					<?php
                    $BoletaId = $DatBoleta->BolId;
                    $BoletaTalonarioId = $DatBoleta->BtaId;
                    $BoletaFecha = $DatBoleta->BolFechaEmision;
                    $BoletaTalonarioNumero = $DatBoleta->BtaNumero;
					
					$BoletaRevisar = true;
                    ?>
                    
                    <a href="javascript:FncBoletaVistaPreliminar('<?php echo $BoletaId;?>','<?php echo $BoletaTalonarioId;?>')">
			<?php echo $BoletaTalonarioNumero;?> - <?php echo $BoletaId;?>
            
          
		</a>

  <?php
			if($BoletaRevisar){
			?>
				<span title="Revisar">[R]</span>
            <?php	
			}
			?>
            
            

            <?php	
				}
			}
			?>        
        
        
    <?php
	    }
	}
    ?>

<?php	
}*/
?>

		
</td>
	<td align="center">
	
	<?php echo $FacturaFecha;?>
    
    <?php echo $BoletaFecha;?>
    





</td>
	<?php
}
?>

<td align="center">


<?php

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
	EN STOCK   
<?php	
}
?>
(<?php echo number_format($InsProducto->ProStockReal,2);?>)


<a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatSesionObjeto->Parametro2;?>">
<?php
/*if($DatSesionObjeto->Parametro16 == 1){
?>
<!--<a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatSesionObjeto->Parametro2;?>">
<img src="imagenes/advertencia.png" title="No hay stock suficiente [<?php echo number_format($DatSesionObjeto->Parametro18,3);?>]" alt="No hay stock suficiente" width="15" height="15" border="0" /> Sin Stock
</a>-->



<span style="color:#F00; font-weight:bold;">SIN STOCK</span>
<!--<a href="javascript:FncProductoNotificarSinStock('<?php echo $DatSesionObjeto->Parametro2;?>','<?php echo $DatSesionObjeto->Parametro12;?>');">Notificar</a>-->



   
<?php	
}else{
?>
EN STOCK
<?php	
}*/
?>
</a>
<!--
<a href="javascript:FncProductoNotificarSinStock('<?php echo $DatSesionObjeto->Parametro2;?>');">Revisar</a>
-->

</td>
<td align="center"><?php

if($POST_Editar==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncVentaDirectaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  <?php
//if($_POST['Eliminar']==1 and empty($DatSesionObjeto->Parametro22)){
if($POST_Eliminar==1){
?>
  <a href="javascript:FncVentaDirectaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?></td>
</tr>
<?php	
	//}
	
$c++;
}

?>
</tbody>
</table>

<br /><br />
<?php
}
?>
<?php
if($POST_VerEstado == 1){
?>
<table border="0" cellpadding="2" cellspacing="2" class="EstPanelTablaListado">
<tbody class="EstPanelTablaListadoBody">
<tr>

<td>
<span class="EstPanelTablaListadoTitulo">LEYENDA: </span>
</td>
<td><div style="background-color:#09C; width:30px;">&nbsp;</div></td>
<td>Con Despacho</td>
<td><div style="background-color:#F30; width:30px;">&nbsp;</div></td>


<td width="120">
<span class="EstPanelTablaListadoEtiqueta">No Llego</span>/No Concretado</td>
<td><div style="background-color:#FC0; width:30px;">&nbsp;</div></td>
<td width="120">
<span class="EstPanelTablaListadoEtiqueta">Llegada Parcial</span>
</td>
<td><div style="background-color:#6F3; width:30px;">&nbsp;</div></td>
<td width="120"><span class="EstPanelTablaListadoEtiqueta">Llegada Completa</span></td>
<td width="120">[R] Revisar</td>
</tr>
</tbody>
</table>

<?php
}
?>