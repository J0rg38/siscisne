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
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsFichaIngresoManoObra'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaIngresoManoObra'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

/*
SesionObjeto-FichaIngresoManoObra
Parametro1 = FmoId
Parametro2 =
Parametro3 = FmoNombre
Parametro4 = FmoImporte
Parametro5 =
Parametro6 = FmoEstado
Parametro7 = FmoTiempoCreacion
Parametro8 = FmoTiempoModificacion
*/

$RepSesionObjetos = $_SESSION['InsFichaIngresoManoObra'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

?>


<?php


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
  <th width="73%" align="center"> Descripcion
</th>
  <th width="14%" align="center">Importe</th>
<th width="14%" align="center"> Acc.  </th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$TotalItems = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
	if($DatSesionObjeto->Parametro6 <> "L" and $DatSesionObjeto->Parametro6<>"N" and $DatSesionObjeto->Parametro6<>"E"  and $DatSesionObjeto->Parametro6<>"Z"){
?>
<tr>
<td width="2%" align="right"><?php echo $c;?></td>
<td align="right" valign="top">
  <?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro4,2);?></td>
<td align="center" valign="top">
  
  <?php
if($_POST['Editar']==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncFichaIngresoManoObraEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>




  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncFichaIngresoManoObraEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
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
}
?>
</tbody>
</table>


<?php
}
?>
