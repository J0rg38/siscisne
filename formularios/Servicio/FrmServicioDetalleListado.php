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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsServicioDetalle'.$Identificador])){
	$_SESSION['InsServicioDetalle'.$Identificador] = new ClsSesionObjeto();	
}



//SesionObjeto-ServicioDetalle
//Parametro1 = SdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = SdeCantidad
//Parametro5 = SdeImporte
//Parametro6 = SdeEstado
//Parametro7 = SdeTiempoCreacion
//Parametro8 = SdeTiempoModificacion
//Parametro10 = ProNombre
//Parametro11 = ProCodigoOriginal
//Parametro12 = ProCodigoAlternativo
//Parametro13 = RtiId
//Parametro14 = UmeNombre


$RepSesionObjetos = $_SESSION['InsServicioDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="27">#</th>
  <th width="81">Id</th>
  <th width="102">Cod Original</th>
  <th width="499"> Nombre</th>
  <th width="112">U.M.</th>
  <th width="112">Cantidad</th>
  <th width="93"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;

foreach($ArrSesionObjetos as $DatSesionObjeto){
?>

<tr>
<td align="center"><?php echo $c;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro11;?></td>
<td align="right">
  <?php echo $DatSesionObjeto->Parametro10;?></td>
<td align="right"><?php echo $DatSesionObjeto->Parametro14;?></td>
<td align="right"><?php echo number_format($DatSesionObjeto->Parametro4,2);?></td>
<td width="93" align="center">
  <?php
  
if($_POST['Editar']==1){
?>
  
  <a class="EstSesionObjetosItem" href="javascript:FncServicioDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  
  
  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncServicioDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
    <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  
  
  <?php
}
?>
</td>
</tr>
<?php
	

$c++;
}



?>





</tbody>
</table>
<br />
<?php
}
?>
