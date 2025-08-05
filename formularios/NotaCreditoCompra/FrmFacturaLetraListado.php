<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsFacturaLetra'.$Identificador])){
	$_SESSION['InsFacturaLetra'.$Identificador] = new ClsSesionObjeto();	
}

/*
SesionObjeto-FacturaLetra
Parametro1 = FleId
Parametro2 = FleNumero
Parametro3 = FleFechaEmision
Parametro4 = FleFechaVencimiento
Parametro5 = FleMonto
Parametro6 = FleEstado
Parametro7 = FleTiempoCreacion
Parametro8 = FleTiempoModificacion
*/



$RepSesionObjetos = $_SESSION['InsFacturaLetra'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="16%">Fecha Emision</th>
<th width="17%">Fecha Vencimiento</th>
<th width="18%">Numero</th>
<th width="16%">Monto</th>
<th width="12%">Estado</th>
<?php
if($_POST['MostrarTiempoModificacion']==1){
?>
<th width="12%">U.A.</th>
<?php
}
?>
<th width="7%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$TotalBruto = 0;
$CantidadTotal = 0;
$TotalItems = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>
<tr>
<td align="center"><?php echo $c;?></td>
<td align="right">
  <?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro4;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro5;?></td>
<td align="right">

<?php
	switch($DatSesionObjeto->Parametro6){
		case 1:
	?>
    Pendiente
    <?php	
		break;
		
		case 3:
	?>
	Cancelado
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
<?php
if($_POST['MostrarTiempoModificacion']==1){
?>
<td align="right"><?php echo $DatSesionObjeto->Parametro8;?></td>
<?php
}
?>

<td align="center">


<?php
if($_POST['Editar']==1){
?>
<a class="EstSesionObjetosItem" href='javascript:FncFacturaLetraEscoger("<?php echo $DatSesionObjeto->Item;?>");'><img border="0"  align="absmiddle" src="imagenes/editar.gif" alt="[Editar]" title="Editar" width="15" height="15"  /></a>

<?php
}
?>

<?php
if($_POST['Eliminar']==1){
?>

<a href="javascript:FncFacturaLetraEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
<img align="absmiddle" src="imagenes/eliminar.gif" alt="[Eliminar]" title="Eliminar" width="15" height="15" border="0" /></a>

<?php
}
?>

</td>
</tr>
<?php
	$TotalItems++;

$c++;
}


?>
</tbody>
</table>
<br />
<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="19%" align="right" class="Total">Total Items:</td>
  <td width="6%" align="left" ><?php echo $TotalItems;?></td>
  <td width="61%" align="right" class="Total">&nbsp;</td>
  <td width="14%" align="right">&nbsp;</td>
</tr>
</tbody>
</table>

<?php
}
?>