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
$ModalidadIngreso = $_POST['ModalidadIngreso'];
$POST_MonedaId = $_POST['MonedaId'];

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

session_start();
if (!isset($_SESSION['InsGarantiaDetalle'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsGarantiaDetalle'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();
	

//SesionObjeto-InsGarantiaDetalle
//Parametro1 = GdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = GdeCodigo
//Parametro5 = GdeDescripcion
//Parametro6 = GdeCosto
//Parametro7 = GdeCantidad
//Parametro8 = GdeCostoTotal	
//Parametro9 = GdeEstado	
//Parametro10 = GdeTiempoCreacion		
//Parametro11 = GdeTiempoModificacion	
//Parametro12 = GdeMargen
//Parametro13 = GdeCostoMargen
//Parametro14 = AmdId

//Parametro15 = ProCodigoOriginal
//Parametro16 = ProNombre
//Parametro17 = UmeNombre

	
$RepSesionObjetos = $_SESSION['InsGarantiaDetalle'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

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
  <th width="2%" align="center">#</th>
  <th width="18%" align="center">Numero de Rep.</th>
  <th width="45%" align="center"> Descripcion
</th>
  <th width="11%" align="center">Cant.</th>
  <th width="13%" align="center">Costo</th>
  <th width="11%" align="center">Acc.</th>
  </tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$TotalGarantiaDetalle = 0;
$c = 1;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>


<tr>
<td align="right"><?php echo $c;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro15;?></td>
<td align="right">
	<?php echo $DatSesionObjeto->Parametro16;?></td>
<td align="right">
	<?php echo number_format($DatSesionObjeto->Parametro7,2);?>
</td>
<td align="right">
  <?php echo number_format($DatSesionObjeto->Parametro8,2);?>
</td>
<td align="center">
  
  <?php
if($_POST['Editar']==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncGarantiaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  
  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncGarantiaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?>
  
</td>
</tr>
<?php
//		$TotalGarantiaDetalle += $DatSesionObjeto->Parametro13;
		$TotalGarantiaDetalle += $DatSesionObjeto->Parametro8;
		$c++;
		
	
}



?>
</tbody>
</table>
<br />

<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="1%" align="right" class="Total">&nbsp;</td>
  <td width="2%" align="right" class="Total">&nbsp;</td>
  <td width="86%" align="right" class="Total">Total:</td>
  <td width="11%" align="right">
    
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($TotalGarantiaDetalle,2);?>

  </td>

  </tr>
  
  
 
</tbody>
</table>
<?php
}
?>




