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
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];

session_start();
if (!isset($_SESSION['InsOrdenCompraEntradaPedido'.$Identificador])){
	$_SESSION['InsOrdenCompraEntradaPedido'.$Identificador] = new ClsSesionObjeto();	
}

if (!isset($_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador])){
	$_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');



/*
SesionObjeto-OrdenCompraEntradaPedido
Parametro1 = PcoId
Parametro2 = PcoFecha
*/
	
$ResOrdenCompraEntradaPedido = $_SESSION['InsOrdenCompraEntradaPedido'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrOrdenCompraEntradaPedidos = $ResOrdenCompraEntradaPedido['Datos'];
$OrdenCompraEntradaPedidoTotal = $ResOrdenCompraEntradaPedido['Total'];
$OrdenCompraEntradaPedidoTotalSeleccionado = $ResOrdenCompraEntradaPedido['TotalSeleccionado'];

			//	SesionObjeto-OrdenCompraEntradaDetalle
			//	Parametro1 = OedId
			//	Parametro2 = ProId
			//	Parametro3 = ProNombre
			//	Parametro4 = OedPrecio
			//	Parametro5 = OedCantidad
			//	Parametro6 = OedImporte
			//	Parametro7 = OedTiempoCreacion
			//	Parametro8 = OedTiempoModificacion
			//	Parametro9 = UmeNombre/UnidadMedidaNombreConvertir
			//	Parametro10 = UmeId/UnidadMedidaConvertir
			//	Parametro11 = OedCantidadReal
			//	Parametro12 = 
			//	Parametro13 = OedCodigoOtro
			//	Parametro14 = ProCodigoOriginal
			//	Parametro15 = ProCodigoAlternativo
			//	Parametro16 = PcdId
			//	Parametro17 = OcdId
			//	Parametro18 = OcdSaldo
$RepOrdenCompraEntradaDetalle = $_SESSION['InsOrdenCompraEntradaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrOrdenCompraEntradaDetalles = $RepOrdenCompraEntradaDetalle['Datos'];
//deb($ArrOrdenCompraEntradaDetalles);
?>

<?php
if(empty($ArrOrdenCompraEntradaPedidos)){
?>
No se encontraron elementos
<?php
}else{
?>
<!--Se encontraron <?php echo $OrdenCompraEntradaPedidoTotalSeleccionado;?> elemento(s)-->

<?php

foreach($ArrOrdenCompraEntradaPedidos as $DatSesionObjeto){
?>
    
    <?php
    $InsPedidoCompra = new ClsPedidoCompra();
    $InsPedidoCompra->PcoId = $DatSesionObjeto->Parametro1;
    $InsPedidoCompra->MtdObtenerPedidoCompra();
    ?>
    <br />
    
    <table width="100%" cellpadding="2" cellspacing="0" border="0">
    <tbody>
        <tr>
            <td width="5%" align="left" >Pedido:</td>
          <td width="9%" align="left" ><?php echo $InsPedidoCompra->PcoId;?></td>
          <td width="12%" align="left" >Fecha:</td>
          <td width="68%" align="left" ><?php echo $InsPedidoCompra->PcoFecha;?></td>
            <td width="6%" align="left">&nbsp;</td>
        </tr>
    </tbody>
    </table>
    
    <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
    <thead class="EstTablaListadoHead">
    <tr>
      <th width="1%">#</th>
      <th width="9%">Id</th>
      <th width="7%">Cod. Proveedor</th>
      <th width="10%">Cod. Orig.</th>
      <th width="7%">Cod. Alt.</th>
      <th width="43%"> Nombre </th>
      <th width="9%">U.M.</th>
      <th width="4%"> Precio </th>
      <th width="5%">Cantidad</th>
      <th width="5%">Entrada</th>
      <th width="0%">&nbsp;</th>
      </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    
    <?php
    $c = 1;
			//	SesionObjeto-OrdenCompraEntradaDetalle
			//	Parametro1 = OedId
			//	Parametro2 = ProId
			//	Parametro3 = ProNombre
			//	Parametro4 = OedPrecio
			//	Parametro5 = OedCantidad
			//	Parametro6 = OedImporte
			//	Parametro7 = OedTiempoCreacion
			//	Parametro8 = OedTiempoModificacion
			//	Parametro9 = UmeNombre/UnidadMedidaNombreConvertir
			//	Parametro10 = UmeId/UnidadMedidaConvertir
			//	Parametro11 = OedCantidadReal
			//	Parametro12 = 
			//	Parametro13 = OedCodigoOtro
			//	Parametro14 = ProCodigoOriginal
			//	Parametro15 = ProCodigoAlternativo
			//	Parametro16 = PcdId
			//	Parametro17 = OcdId
			//	Parametro18 = OcdSaldo
    
    if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
        foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
    
            $OrdenCompraEntradaDetalleCodigoOtro = "";
			$OrdenCompraEntradaDetallePrecio = 0;
			$OrdenCompraEntradaDetalleCantidad = 0;
			$OrdenCompraEntradaDetalleSaldo= 0;
			
            if(!empty($ArrOrdenCompraEntradaDetalles)){
                foreach($ArrOrdenCompraEntradaDetalles as $DatOrdenCompraEntradaDetalle){
                    if($DatOrdenCompraEntradaDetalle->Parametro16 == $DatPedidoCompraDetalle->PcdId){
						
						$OrdenCompraEntradaDetalleCodigoOtro = $DatOrdenCompraEntradaDetalle->Parametro13;
						$OrdenCompraEntradaDetallePrecio = $DatOrdenCompraEntradaDetalle->Parametro4;
						$OrdenCompraEntradaDetalleCantidad = $DatOrdenCompraEntradaDetalle->Parametro5;
						$OrdenCompraEntradaDetalleSaldo = $DatOrdenCompraEntradaDetalle->Parametro18;
						
                        break;
                    }
                }
            }
            
            
    ?>
    
    
        <tr>
            <td align="right"><?php echo $c;?></td>
            <td align="right"><?php echo $DatPedidoCompraDetalle->ProId;?></td>
            <td align="right"><?php echo $OrdenCompraEntradaDetalleCodigoOtro;?></td>
            <td align="right"><?php echo $DatPedidoCompraDetalle->ProCodigoOriginal;?></td>
            <td align="right"><?php echo $DatPedidoCompraDetalle->ProCodigoAlternativo;?></td>
            <td align="right"><?php echo $DatPedidoCompraDetalle->ProNombre;?></td>
            <td align="right"><?php echo $DatPedidoCompraDetalle->UmeNombre;?></td>
            <td align="right"><?php echo number_format($OrdenCompraEntradaDetallePrecio,2);?></td>
            <td align="right"><?php echo number_format($DatPedidoCompraDetalle->PcdCantidad,2);?></td>
            <td align="right">
			<input class="EstFormularioCaja" name="CmpProductoEntrada_<?php echo $DatPedidoCompraDetalle->PcdId;?>" type="text" id="CmpProductoEntrada_<?php echo $DatPedidoCompraDetalle->PcdId;?>" size="10" maxlength="10" value="<?php echo number_format($OrdenCompraEntradaDetalleCantidad,2);?>" <?php echo ($POST_Editar==2  or $OrdenCompraEntradaDetalleSaldo==0)?'readonly="readonly"':'';?>  />
            </td>
            <td align="right">&nbsp;</td>
        </tr>
    
    <?php
    $c++;
        }
    }
    ?>
    </tbody>
    </table>

<?php
	

}

?>




<!--
<br />
<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="right" class="Total">&nbsp;</td>
  <td width="68%" align="right" class="Total">Total:</td>
  <td width="8%" align="right">
    
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?>

  </td>

  </tr>
  
  
 
</tbody>
</table>-->



<?php
}
?>