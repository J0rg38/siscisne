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
$POST_MonedaId = $_POST['MonedaId'];
	
session_start();
if (!isset($_SESSION['InsVentaDirectaCentrado'.$Identificador])){
	$_SESSION['InsVentaDirectaCentrado'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

/*
SesionObjeto-VentaDirectaCentrado
Parametro1 = CppId
Parametro2 = 
Parametro3 = CppDescripcion
Parametro4 = 
Parametro5 = CrdImporte
Parametro6 = CrdTiempoCreacion
Parametro7 = CrdTiempoModificacion
*/

$RepSesionObjetos = $_SESSION['InsVentaDirectaCentrado'.$Identificador]->MtdObtenerSesionObjetos(true);
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
    <th width="2%">#</th>
    <th width="65%"> Descripcion
    </th>
    <th width="24%">Importe</th>
    <th width="9%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">

<?php echo $POST_ManoObra;?>

<?php
$c = 1;
$TotalBruto = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>

<?php
if($InsMoneda->MonId==$EmpresaMonedaId){
?>
	<?php  $DatSesionObjeto->Parametro5 = ($DatSesionObjeto->Parametro5 * $_POST['TipoCambio']);?>
<?php	
}
?>

<tr>
<td align="right"><?php echo $c;?></td>
<td align="right">
  <?php echo $DatSesionObjeto->Parametro3;?> 
</td>
<td align="right">
<?php echo number_format($DatSesionObjeto->Parametro5,2);?>
</td>
<td align="center">

<?php
if($_POST['Editar']==1){
?>
<a class="EstSesionObjetosItem" href="javascript:FncVentaDirectaCentradoEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
<?php
}
?>

<?php
if($_POST['Eliminar']==1){
?>
<a href="javascript:FncVentaDirectaCentradoEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
<img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
<?php
}
?>


</td>
</tr>



<?php
	
	$TotalBruto = $TotalBruto + $DatSesionObjeto->Parametro5;
	
$c++;
}



?>
</tbody>
</table>

	
<?php
	$Total = $TotalBruto;
	
?>
<br />
<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="right" class="Total">&nbsp;</td>
  <td width="66%" align="right" class="Total">Total:</td>
  <td width="10%" align="right">
    
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?>

  </td>

  </tr>
  
  
 
</tbody>
</table>

<?php
}
?>