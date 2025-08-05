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
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];

session_start();
if (!isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();	
}

if (!isset($_SESSION['InsOrdenCompraDetalle'.$Identificador])){
	$_SESSION['InsOrdenCompraDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();


/*
SesionObjeto-OrdenCompraPedido
Parametro1 = PcoId
Parametro2 = PcoFecha
*/
	
$ResOrdenCompraPedido = $_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrOrdenCompraPedidos = $ResOrdenCompraPedido['Datos'];
$OrdenCompraPedidoTotal = $RepSesionObjetos['Total'];
$OrdenCompraPedidoTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

//	SesionObjeto-OrdenCompraDetalle
//	Parametro1 = OcdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = OcdPrecio
//	Parametro5 = OcdCantidad
//	Parametro6 = OcdImporte
//	Parametro7 = OcdTiempoCreacion
//	Parametro8 = OcdTiempoModificacion
//	Parametro9 = UnidadMedidaNombreConvertir
//	Parametro10 = UnidadMedidaConvertir
//	Parametro11 = Tipo
//	Parametro12 = 
//	Parametro13 = OcdCodigoOtro
//	Parametro14 = ProCodigoOriginal
//	Parametro15 = ProCodigoAlternativo
//	Parametro16 = PcdId


$RepOrdenCompraDetalle = $_SESSION['InsOrdenCompraDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrOrdenCompraDetalles = $RepOrdenCompraDetalle['Datos'];
//deb($ArrOrdenCompraDetalles);
?>

<?php
if(empty($ArrOrdenCompraPedidos)){
?>
No se encontraron elementos
<?php
}else{
?>
<!--Se encontraron <?php echo $OrdenCompraPedidoTotalSeleccionado;?> elemento(s)-->

<?php
$Total = 0;
foreach($ArrOrdenCompraPedidos as $DatSesionObjeto){
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
  <th width="2%">#</th>
  <th width="8%">Id</th>
  <th width="6%">Cod. GM</th>
  <th width="9%">Cod. Orig.</th>
  <th width="7%">Cod. Alt.</th>
  <th width="21%"> Nombre </th>
  <th width="13%">U.M.</th>
  <th width="6%">Año</th>
  <th width="8%">Modelo</th>
  <th width="6%"> Precio </th>
  <th width="6%"> Cantidad</th>
  <th width="8%">Importe</th>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">


<?php
$c = 1;
//	SesionObjeto-OrdenCompraDetalle
//	Parametro1 = OcdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = OcdPrecio
//	Parametro5 = OcdCantidad
//	Parametro6 = OcdImporte
//	Parametro7 = OcdTiempoCreacion
//	Parametro8 = OcdTiempoModificacion
//	Parametro9 = UnidadMedidaNombreConvertir
//	Parametro10 = UnidadMedidaConvertir
//	Parametro11 = Tipo
//	Parametro12 = 
//	Parametro13 = OcdCodigoOtro
//	Parametro14 = ProCodigoOriginal
//	Parametro15 = ProCodigoAlternativo
//	Parametro16 = PcdId

//deb($ArrOrdenCompraDetalles);
if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
	foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
		
		
					if($InsPedidoCompra->MonId<>$EmpresaMonedaId){
				$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio / $InsPedidoCompra->PcoTipoCambio;
			}else{
				$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio;
			}

			if($InsPedidoCompra->MonId<>$EmpresaMonedaId ){
				$DatPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdImporte / $InsPedidoCompra->PcoTipoCambio;
			}else{
				$DatPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdImporte;
			}
?>


	<tr>
		<td align="right"><?php echo $c;?></td>
		<td align="right"><?php echo $DatPedidoCompraDetalle->ProId;?></td>
		<td align="right">
			<?php echo $DatPedidoCompraDetalle->PcdCodigo;?>
	       </td>
		<td align="right"><?php echo $DatPedidoCompraDetalle->ProCodigoOriginal;?></td>
		<td align="right"><?php echo $DatPedidoCompraDetalle->ProCodigoAlternativo;?></td>
		<td align="right"><?php echo $DatPedidoCompraDetalle->ProNombre;?></td>
		<td align="right"><?php echo $DatPedidoCompraDetalle->UmeNombre;?></td>
		<td align="right"><?php echo $DatPedidoCompraDetalle->PcdAno;?></td>
		<td align="right"><?php echo $DatPedidoCompraDetalle->PcdModelo;?></td>
		<td align="right">
			<?php echo number_format($DatPedidoCompraDetalle->PcdPrecio,2);?>
		</td>
		<td align="right"><?php echo number_format($DatPedidoCompraDetalle->PcdCantidad,2);?></td>
		<td align="right"><?php echo number_format($DatPedidoCompraDetalle->PcdImporte,2);?></td>
	</tr>

<?php
	$Total = $Total + $DatPedidoCompraDetalle->PcdImporte;
$c++;
	}
}
?>
</tbody>
</table>

<?php
	

}

?>





<br />
<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="right" class="Total">&nbsp;</td>
  <td width="61%" align="right" class="Total">Total:</td>
  <td width="15%" align="right">
    
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?>

  </td>

  </tr>
  
  
 
</tbody>
</table>



<?php
}
?>