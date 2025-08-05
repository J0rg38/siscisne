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
$ModalidadIngreso = $_POST['ModalidadIngreso'];
$POST_MonedaId = $_POST['MonedaId'];

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

session_start();
if (!isset($_SESSION['InsReclamoDetalle'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsReclamoDetalle'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();
	
//SesionObjeto-InsReclamoDetalle
//Parametro1 = RdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = ProCodigoOriginal
//Parametro5 = ProNombre
//Parametro6 = AmoComprobanteNumero
//Parametro7 = RdeEstado
//Parametro8 = 
//Parametro9 = AmoComprobanteFecha
//Parametro10 = OcoTipo	
//Parametro11 = AmdCantidad	
//Parametro12 = RdeCantidad	
//Parametro13 = RdePrecioUnitario
//Parametro14 = RdeMonto
//Parametro15 = RdeObservacion
//Parametro16 = RdeTiempoCreacion
//Parametro17 = RdeTiempoModificacion
$RepSesionObjetos = $_SESSION['InsReclamoDetalle'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

?>

<?php
if(empty($ArrSesionObjetos)){
?>|
No se encontraron elementos
<?php
}else{
?>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" align="center">#</th>
  <th width="7%" align="center">Fact. Num.</th>
  <th width="5%" align="center">Fecha Fact.</th>
  <th width="6%" align="center">Num. Parte</th>
  <th width="27%" align="center">Nombre</th>
  <th width="4%" align="center">Tipo Pedido</th>
  <th width="4%" align="center">Cant. Fact.</th>
  <th width="5%" align="center">Cant. Recibida</th>
  <th width="4%" align="center">Precio Uni.</th>
  <th width="7%" align="center">Monto Reclamada</th>
  <th width="24%" align="center">Observacion</th>
  <th width="5%" align="center">Acc.</th>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$TotalReclamoDetalle = 0;
$c = 1;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>


<tr>
<td align="right"><?php echo $c;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro6;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro9;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro4;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro5;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro10;?></td>
<td align="right"><?php echo number_format($DatSesionObjeto->Parametro11,2);?></td>
<td align="right"><?php echo number_format($DatSesionObjeto->Parametro12,2);?></td>
<td align="right">
  <?php echo number_format($DatSesionObjeto->Parametro13,2);?>
</td>
<td align="right">
  <?php echo number_format($DatSesionObjeto->Parametro14,2);?>
</td>
<td align="right"><?php echo $DatSesionObjeto->Parametro15;?>

<?php //echo $DatSesionObjeto->Parametro16;?>
<?php //echo $DatSesionObjeto->Parametro17;?>
</td>
<td align="center">
  
  <?php
if($_POST['Editar']==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncReclamoDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/editar.gif" alt="[Editar]" title="Editar" width="15" height="15"  /></a>
  <?php
}
?>
  
  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncReclamoDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" > <img align="absmiddle" src="imagenes/eliminar.gif" alt="[Eliminar]" title="Eliminar" width="15" height="15" border="0" /></a>
  <?php
}
?>
  
</td>
</tr>
<?php
		$TotalReclamoDetalle += $DatSesionObjeto->Parametro14;
		$c++;
		
	
}



?>
</tbody>
</table>
<br />

<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="19%" align="right" class="Total">&nbsp;</td>
  <td width="56%" align="right" class="Total">&nbsp;</td>
  <td width="11%" align="right" class="Total">Total:</td>
  <td width="14%" align="right">
    
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($TotalReclamoDetalle,2);?>

  </td>

  </tr>
  
  
 
</tbody>
</table>
<?php
}
?>




