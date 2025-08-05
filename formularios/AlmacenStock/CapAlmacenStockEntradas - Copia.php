<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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


$POST_ProductoId = $_POST['ProductoId'];
$POST_Ano = (empty($_POST['Ano'])?date("Y"):$_POST['Ano']);
$POST_AlmacenId = $_POST['AlmacenId'];
$POST_Sucursal = $_POST['Sucursal'];

if(empty($POST_ProductoId)){
	die("No ha escogido un producto");
}

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsKardex.php');

$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

$InsAlmacenStock = new ClsAlmacenStock();
$InsKardex = new ClsKardex();

//$InsAlmacenStock->ProId = $POST_ProductoId;
//$InsAlmacenStock->MtdObtenerAlmacenStock();


/*
ENTRADAS
1 - ALMACEN MOVIMIENTO ENTRADA / compras
2 - otros ingresos
6 - TRASLADO ALMACEN
7 - CONVERSION
SALIDAS
1 - ALMACEN MOVIMIENTO SALIDA
2 - TALLER PEDIDO
3 - VENTA CONCRETADA
6 - TRASLADO ALMACEN
7 - CONVERSION
8 - TRANSFERENCIA ENTRADA


*/

if(!empty($POST_AlmacenId)){
		
}else{
	$stipo = "1,2";
}

//MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenId=NULL,$oAlmacenMovimientoSubTipo=NULL,$oSucursal=NULL) {
$ResAlmacenMovimientoEntradaDetalle = $InsKardex->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmoFecha','ASC',1,NULL,NULL,3,$POST_ProductoId,$POST_Ano."-01-01",$POST_Ano."-12-31",NULL,0,NULL,NULL,NULL,$POST_AlmacenId,$stipo,$POST_Sucursal);
$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];
?>

        
        
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
<thead class="EstTablaListadoHead">
  <tr>
    <th width="3%" rowspan="2">#</th>
    <th width="8%" rowspan="2">FICHA</th>
    <th width="10%" rowspan="2">FEC. FICHA</th>
    <th width="19%" rowspan="2">OPERACION</th>
    <th width="2%" rowspan="2">&nbsp;</th>
    <th width="11%" rowspan="2">PROVEEDOR</th>
    <th colspan="2">COMPROB.</th>
    <th width="11%" rowspan="2">ORD. COMP.</th>
    <th colspan="2">SALIDA</th>
    <th colspan="2">BASE</th>
    </tr>
  <tr>
    <th width="6%">NUM. </th>
    <th width="8%">FEC. </th>
    <th width="5%">U.M.</th>
    <th width="6%">CANT.</th>
    <th width="5%">U.M.</th>
    <th width="6%">CANT.</th>
    </tr>                
  </thead>
<tbody class="EstTablaListadoBody">
<?php
  $i=1;
  $TotalIngresos = 0;
  $TotalIngresosReal = 0;
foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){
?>
 

<tr>
    <td align="left" valign="top"><?php echo $i;?></td>
    <td align="left" valign="top">
      
      
      
      <?php 
    switch($DatAlmacenMovimientoEntradaDetalle->AmoSubTipo){
        case "2":
  ?>
      <a target="_blank" href="principal.php?Mod=AlmacenMovimientoEntradaSimple&Form=Ver&Id=<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId?>">
        <?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId?>
        </a> 	
      <?php  
        break;
        
		 case "6":
  ?>
      <a target="_blank" href="principal.php?Mod=TrasladoAlmacen&Form=Ver&Id=<?php echo $DatAlmacenMovimientoEntradaDetalle->TalId?>">
        <?php echo $DatAlmacenMovimientoEntradaDetalle->TalId?>
        </a> 	
      <?php  
        break;
		
		 case "7":
  ?>
      <a target="_blank" href="principal.php?Mod=ProduccionProducto&Form=Ver&Id=<?php echo $DatAlmacenMovimientoEntradaDetalle->PprId?>">
        <?php echo $DatAlmacenMovimientoEntradaDetalle->PprId?>
        </a> 	
      <?php  
        break;
		
        default:
  ?>
      <a target="_blank" href="principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId?>">
        <?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId?>
        </a>
      
  <?php	  
        break;
    }
?>
      
    </td>
    <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->AmoFecha?></td>
    <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->TopNombre?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->PrvNombreCompleto;?>
      <?php echo $DatAlmacenMovimientoEntradaDetalle->PrvApellidoPaterno;?>
      <?php echo $DatAlmacenMovimientoEntradaDetalle->PrvApellidoMaterno;?>
    </td>
    <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteNumero?></td>
    <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteFecha?></td>
    <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->OcoId?></td>
    <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->UmeNombre?></td>
    <td align="left" valign="top"><?php echo number_format($DatAlmacenMovimientoEntradaDetalle->AmdCantidad,2);?></td>
    <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->UmeNombreOrigen?></td>
    <td align="left" valign="top"><?php echo $DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal?></td>
    </tr>
      
  
  <?php
  $TotalIngresosReal += $DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal;
  $TotalIngresos += $DatAlmacenMovimientoEntradaDetalle->AmdCantidad;
  $i++;  
}
?>
<tr>
    <td colspan="9" align="right">TOTAL INGRESOS:</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo number_format($TotalIngresosReal,6);?></td>
  </tr>
  </tbody>
</table>