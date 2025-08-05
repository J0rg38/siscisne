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

session_start();
if (!isset($_SESSION['InsGuiaRemisionVenta'.$Identificador])){
	$_SESSION['InsGuiaRemisionVenta'.$Identificador] = new ClsSesionObjeto();	
}


/*
SesionObjeto-GuiaRemisionVentaListado
Parametro1 = NevId
Parametro2 = VtaIdVenId
Parametro3 = VenId
Parametro4 = VtaId
Parametro5 = VtaNumero

*/

$RepSesionObjetos = $_SESSION['InsGuiaRemisionVenta'.$Identificador]->MtdObtenerSesionObjetos(true);
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
Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="3%">#</th>
  <th width="89%"> Nota de Servicio</th>

<th width="8%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$SubTotal = 0;
$CantidadTotal = 0;
$TotalItems = 0;

foreach($ArrSesionObjetos as $DatSesionObjeto){
?>
<tr>
<td align="center"><?php echo $c;?></td>
<td align="center">
  <?php echo $DatSesionObjeto->Parametro5;?> - <?php echo $DatSesionObjeto->Parametro3;?>
  </td>

<td align="center">
<?php
if($_POST['Eliminar']==1){
?>
<a href="javascript:FncGuiaRemisionVentaEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
<img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
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
  <td width="32%" align="right" class="Total">Total Items:</td>
  <td align="left" ><?php echo $TotalItems;?></td>
  </tr>
</tbody>
</table>

<?php
}
?>